<?php

namespace Themes\Jamrock\Tour\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Tour\Hook;
use Modules\Tour\Models\TourCategory;
use Themes\Jamrock\Tour\Models\Tour;
use Themes\Jamrock\Tour\Models\TourPricing;

class TourController extends \Modules\Tour\Admin\TourController
{

    public function __construct()
    {
        parent::__construct();
        $this->tourClass = Tour::class;
        $this->locationCategoryClass = TourCategory::class;
    }

    public function create(Request $request)
    {
        $this->checkPermission('tour_create');
        $row = new Tour();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'               => $row,
            'attributes'        => $this->attributesClass::where('service', 'tour')->get(),
            'tour_category'     => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
            'tour_location'     => $this->locationClass::where('status', 'publish')->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where("status", "publish")->get(),
            'translation'       => new $this->tourTranslationClass(),
            'rangers'=>[],
            'distance'=>[],
            'json_column_pax'=>[],
            'breadcrumbs'       => [
                [
                    'name' => __('Tours'),
                    'url'  => route('tour.admin.index')
                ],
                [
                    'name'  => __('Add Tour'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Tour::admin.detail', $data);
    }


    public function edit(Request $request, $id)
    {
        $this->checkPermission('tour_update');
        $row = $this->tourClass::find($id);
        if (empty($row)) {
            return redirect(route('tour.admin.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (!$this->hasPermission('tour_manage_others')) {
            if ($row->create_user != Auth::id()) {
                return redirect(route('tour.admin.index'));
            }
        }
        $data = [
            'row'               => $row,
            'translation'       => $translation,
            "selected_terms"    => $row->tour_term->pluck('term_id'),
            'attributes'        => $this->attributesClass::where('service', 'tour')->get(),
            'tour_category'     => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
            'tour_location'     => $this->locationClass::where('status', 'publish')->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where("status", "publish")->get(),
            'enable_multi_lang' => true,
            'json_column_pax'=>$row->pax_range,
            'breadcrumbs'       => [
                [
                    'name' => __('Tours'),
                    'url'  => route('tour.admin.index')
                ],
                [
                    'name'  => __('Edit Tour'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__('Edit Tour')
        ];

        $pricing = $row->pricing;
        $distance=$rangers=[];
        if(!empty($pricing)){
            foreach ($pricing as $item => $value) {
                $distance[]=[
                    'from'=>$value->gg_from,
                    'to'=>$value->gg_to,
                ];
                $rangers[]=$value->prices;
            }
        }
        $data['distance'] = $distance;
        $data['rangers'] = $rangers;

        return view('Tour::admin.detail', $data);
    }

    public function store(Request $request, $id)
    {
        if ($id > 0) {
            $this->checkPermission('tour_update');
            $row = $this->tourClass::find($id);
            if (empty($row)) {
                return redirect(route('tour.admin.index'));
            }
            if ($row->create_user != Auth::id() and !$this->hasPermission('tour_manage_others')) {
                return redirect(route('tour.admin.index'));
            }
        } else {
            $this->checkPermission('tour_create');
            $row = new $this->tourClass();
            $row->status = "publish";
        }
        if(!empty($request->input('enable_fixed_date'))){
            $rules = [
                'start_date'        =>'required|date',
                'end_date'         =>'required|date|after_or_equal:start_date',
                'last_booking_date' =>'required|date|before:start_date'
            ];
            $request->validate($rules);
        }

        $row->fill($request->input());
        if ($request->input('slug')) {
            $row->slug = $request->input('slug');
        }
        $row->ical_import_url = $request->ical_import_url;
        $row->create_user = $request->input('create_user');
        $row->default_state = $request->input('default_state', 1);
        $row->enable_service_fee = $request->input('enable_service_fee');
        $row->service_fee = $request->input('service_fee');
        $row->pax_ranger = $request->input('pax_ranger');
        $row->display_order = $request->input('display_order');
        $row->duration_text = $request->input('duration_text');
        $res = $row->saveOriginOrTranslation($request->input('lang'), true);

        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
                $row->saveMeta($request);
            }

            $row->savePricing($request);

            do_action(Hook::AFTER_SAVING,$row,$request);

            if ($id > 0) {
                event(new UpdatedServiceEvent($row));
                return back()->with('success', __('Tour updated'));
            } else {
                event(new CreatedServicesEvent($row));
                return redirect(route('tour.admin.edit', $row->id))->with('success', __('Tour created'));
            }
        }
    }



}
