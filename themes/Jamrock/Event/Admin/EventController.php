<?php

namespace Themes\Jamrock\Event\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Location\Models\LocationCategory;
use Themes\Jamrock\Event\Models\Event;

class EventController extends \Modules\Event\Admin\EventController
{
    public function __construct()
    {
        parent::__construct();
        $this->event = Event::class;
        $this->locationCategoryClass = LocationCategory::class;
    }

    public function create(Request $request)
    {
        $this->checkPermission('event_create');
        $row = new $this->event();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'               => $row,
            'attributes'        => $this->attributes::where('service', 'event')->get(),
            'event_location'    => $this->location::where('status', 'publish')->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where('status', 'publish')->get(),
            'translation'       => new $this->event_translation(),
            'rangers'=>[],
            'distance'=>[],
            'json_column_pax'=>[],
            'breadcrumbs'       => [
                [
                    'name' => __('Events'),
                    'url'  => route('event.admin.index')
                ],
                [
                    'name'  => __('Add Event'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Add new Event")
        ];
        return view('Event::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('event_update');
        $row = $this->event::find($id);
        if (empty($row)) {
            return redirect(route('event.admin.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (!$this->hasPermission('event_manage_others')) {
            if ($row->create_user != Auth::id()) {
                return redirect(route('event.admin.index'));
            }
        }
        $data = [
            'row'               => $row,
            'translation'       => $translation,
            "selected_terms"    => $row->terms->pluck('term_id'),
            'attributes'        => $this->attributes::where('service', 'event')->get(),
            'event_location'    => $this->location::where('status', 'publish')->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where('status', 'publish')->get(),
            'enable_multi_lang' => true,
            'breadcrumbs'       => [
                [
                    'name' => __('Events'),
                    'url'  => route('event.admin.index')
                ],
                [
                    'name'  => __('Edit Event'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Edit: :name", ['name' => $row->title])
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

        return view('Event::admin.detail', $data);
    }

    public function store(Request $request, $id)
    {

        if ($id > 0) {
            $this->checkPermission('event_update');
            $row = $this->event::find($id);
            if (empty($row)) {
                return redirect(route('event.admin.index'));
            }
            if ($row->create_user != Auth::id() and !$this->hasPermission('event_manage_others')) {
                return redirect(route('event.admin.index'));
            }
        } else {
            $this->checkPermission('event_create');
            $row = new $this->event();
            $row->status = "publish";
        }
        $dataKeys = [
            'title',
            'content',
            'price',
            'is_instant',
            'status',
            'video',
            'faqs',
            'image_id',
            'banner_image_id',
            'gallery',
            'location_id',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
            'duration',
            'start_time',
            'price',
            'sale_price',
            'ticket_types',
            'enable_extra_price',
            'extra_price',
            'is_featured',
            'default_state',
            'enable_service_fee',
            'service_fee',
            'surrounding',
            'end_time',
            'duration_unit',
            'display_order',
            'duration_text'
        ];
        if ($this->hasPermission('event_manage_others')) {
            $dataKeys[] = 'create_user';
        }
        $row->fillByAttr($dataKeys, $request->input());
        if ($request->input('slug')) {
            $row->slug = $request->input('slug');
        }
        $row->pax_ranger = $request->input('pax_ranger');

        $res = $row->saveOriginOrTranslation($request->input('lang'), true);
        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }
            $row->savePricing($request);

            if ($id > 0) {
                event(new UpdatedServiceEvent($row));
                return back()->with('success', __('Event updated'));
            } else {
                event(new CreatedServicesEvent($row));
                return redirect(route('event.admin.edit', $row->id))->with('success', __('Event created'));
            }
        }
    }


}
