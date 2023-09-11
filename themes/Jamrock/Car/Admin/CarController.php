<?php

namespace Themes\Jamrock\Car\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Car\Hook;
use Modules\Car\Models\Car;
use Modules\Car\Models\CarTranslation;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\UpdatedServiceEvent;

class CarController extends \Modules\Car\Admin\CarController
{
    public function __construct(Car $car, CarTranslation $car_translation)
    {
        parent::__construct($car, $car_translation);
        $this->car  = \Themes\Jamrock\Car\Models\Car::class;

    }
    public function store(Request $request, $id)
    {

        if ($id > 0) {
            $this->checkPermission('car_update');
            $row = $this->car::find($id);
            if (empty($row)) {
                return redirect(route('car.admin.index'));
            }
            if ($row->create_user != Auth::id() and !$this->hasPermission('car_manage_others')) {
                return redirect(route('car.admin.index'));
            }
        } else {
            $this->checkPermission('car_create');
            $row = new $this->car();
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
            'number',
            'price',
            'sale_price',
            'passenger',
            'gear',
            'baggage',
            'door',
            'enable_extra_price',
            'extra_price',
            'is_featured',
            'default_state',
            'enable_service_fee',
            'service_fee',
            'min_day_before_booking',
            'min_day_stays',
            'ical_import_url',
            'display_order'
        ];
        if ($this->hasPermission('car_manage_others')) {
            $dataKeys[] = 'create_user';
        }
        $row->fillByAttr($dataKeys, $request->input());
        if ($request->input('slug')) {
            $row->slug = $request->input('slug');
        }
        $res = $row->saveOriginOrTranslation($request->input('lang'), true);
        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }
            if(!empty($prices =$request->input('prices'))){
                $row->savePricing($prices);
            }
            do_action(Hook::AFTER_SAVING,$row,$request);
            if ($id > 0) {
                event(new UpdatedServiceEvent($row));
                return back()->with('success', __('Car updated'));
            } else {
                event(new CreatedServicesEvent($row));
                return redirect(route('car.admin.edit', $row->id))->with('success', __('Car created'));
            }
        }
    }

}
