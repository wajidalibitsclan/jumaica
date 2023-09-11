<?php

namespace Themes\Jamrock\Tour\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Tour extends \Modules\Tour\Models\Tour
{
    protected $casts = [
        'faqs'      => 'array',
        'include'   => 'array',
        'exclude'   => 'array',
        'itinerary' => 'array',
        'service_fee' => 'array',
        'surrounding' => 'array',
        'start_date'=> 'date',
        'end_date'=> 'date',
        'last_booking_date'   => 'date',
        'pax_ranger'=>'array',
    ];

    public function beforeCheckout(Request $request, $booking)
    {
    }

    public function pricing()
    {
        return $this->hasMany(TourPricing::class,'tour_id');
    }

    public function savePricing($request){
        $distance = $request->input('distance',[]);
        $rangers = $request->input('rangers',[]);
        if(!empty($distance)){
            $argv = [];
            $this->pricing()->delete();
            foreach ($distance as $item=>$value){
                $argv[]= new TourPricing([
                    'gg_from'=>$value['from']??0,
                    'gg_to'=>$value['to']??0,
                    'tour_id'=>$this->id,
                    'prices'=>$rangers[$item]??[],
                ]);
            }
            $this->pricing()->saveMany($argv);
        }
    }

    public function getBookingData()
    {
        $booking_data = [
            'id'                       => $this->id,
            'service_type'                       => $this->type,
            'person_types'             => [],
            'max'                      => 0,
            'open_hours'               => [],
            'extra_price'              => [],
            'minDate'                  => date('m/d/Y'),
            'duration'                 => $this->duration,
            'buyer_fees'               => [],
            'start_date'               => request()->input('start') ?? "",
            'start_date_html'          => request()->input('start') ? display_date(request()->input('start')) : __('Please select date!'),
            'end_date'                 => request()->input('end') ?? "",
            'end_date_html'            => request()->input('end') ? display_date(request()->input('end')) : "",
            'deposit'                  => $this->isDepositEnable(),
            'deposit_type'             => $this->getDepositType(),
            'deposit_amount'           => $this->getDepositAmount(),
            'deposit_fomular'          => $this->getDepositFomular(),
            'is_form_enquiry_and_book' => $this->isFormEnquiryAndBook(),
            'enquiry_type'             => $this->getBookingEnquiryType(),
            'is_fixed_date'            => false,
            'pricing'=>$this->pricing,
            'min_people'=>$this->min_people,
            'max_people'=>$this->max_people
        ];
        $meta = $this->meta ?? false;
        $lang = app()->getLocale();
        if ($meta) {
            if ($meta->enable_person_types) {
                $booking_data['person_types'] = $meta->person_types;
                if (!empty($booking_data['person_types'])) {
                    foreach ($booking_data['person_types'] as $k => &$type) {
                        if (!empty($lang)) {
                            $type['name'] = !empty($type['name_' . $lang])?$type['name_' . $lang]:$type['name'];
                            $type['desc'] = !empty($type['desc_' . $lang])?$type['desc_' . $lang]:$type['desc'];
                        }
                        $type['min'] = (int)$type['min'];
                        $type['max'] = (int)$type['max'];
                        $type['number'] = $type['min'];
                        $type['display_price'] = format_money($type['price']);
                    }
                    $booking_data['person_types'] = array_values((array)$booking_data['person_types']);
                } else {
                    $booking_data['person_types'] = [];
                }
            }
            if ($meta->enable_extra_price) {
                $booking_data['extra_price'] = $meta->extra_price;
                if (!empty($booking_data['extra_price'])) {
                    foreach ($booking_data['extra_price'] as $k => &$type) {
                        if (!empty($lang) and !empty($type['name_' . $lang])) {
                            $type['name'] = $type['name_' . $lang];
                        }
                        $type['number'] = 0;
                        $type['enable'] = 0;
                        $type['price_html'] = format_money($type['price']);
                        $type['price_type'] = '';
                        switch ($type['type']) {
                            case "per_day":
                                $type['price_type'] .= '/' . __('day');
                            break;
                            case "per_hour":
                                $type['price_type'] .= '/' . __('hour');
                            break;
                        }
                        if (!empty($type['per_person'])) {
                            $type['price_type'] .= 'PP';
                        }
                    }
                }
                $booking_data['extra_price'] = array_values((array)$booking_data['extra_price']);
            }
            if ($meta->enable_open_hours) {
                $booking_data['open_hours'] = $meta->open_hours;
            }
        }
        $list_fees = setting_item_array('tour_booking_buyer_fees');
        if (!empty($list_fees)) {
            foreach ($list_fees as $item) {
                $item['type_name'] = $item['name_' . app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_' . app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }
        if(!empty($this->enable_service_fee) and !empty($service_fee = $this->service_fee)){
            foreach ($service_fee as $item) {
                $item['type_name'] = $item['name_' . app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_' . app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }

        if($this->isFixedDate()){
            $booking_data['is_fixed_date'] = true;
            $booking_data['start_date'] = $this->start_date->format('Y-m-d');
            $booking_data['start_date_html'] =display_date($this->start_date);
            $booking_data['end_date_html'] =display_date($this->end_date);
            $booking_data['end_date'] = $this->end_date;
            $booking_data['last_booking_date'] = $this->last_booking_date;
            $booking_data['last_booking_date_html'] = display_date($this->last_booking_date);
            $booking_data['open_hours'] =[];
        }

        return $booking_data;
    }
    public function addToCart(Request $request)
    {
        $res = $this->addToCartValidate($request);
        if ($res !== true)
            return $res;

        $start_date =  new \DateTime($request->input('pickup_date').' '.$request->input('pickup_time'));

        // Add Booking
        // get Price Availability Calendar
        $total = 0;
        $total_guests = 0;
        $discount = 0;
        $base_price = 0;
        // for Availability Calendar
        $extra_price = [];
        $extra_price_input = $request->input('extra_price');
        $person_types = [];
        $discount_by_people = [];
        $total_guests = $request->input('passenger');
        $meta = $this->meta;

        $gg_distance  = $request->input('gg_distance');
        $distanceKm = $gg_distance['value']/1000;

        if(!empty($pricing = $this->pricing)){
            foreach ($pricing as$value){
                if($value['gg_from']<= $distanceKm and $distanceKm <=$value['gg_to']){
                    foreach ($value['prices'] as $child){
                        if($child['pax_from']<=$total_guests and $total_guests <= $child['pax_to']){
                            $base_price = !empty($child['discount'])?$child['discount']:$child['price'];
                        }
                    }
                }
            }
        }
        if(empty($base_price)){
            return $this->sendError(__("Error total null"));
        }
        $total = $base_price;

        if ($meta) {
            if ($meta->enable_extra_price and !empty($meta->extra_price)) {
                if (!empty($meta->extra_price)) {
                    foreach ($meta->extra_price as $k => $type) {
                        if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
                            $type_total = 0;
                            switch ($type['type']) {
                                case "one_time":
                                    $type_total = $type['price'];
                                    break;
                                case "per_hour":
                                    $type_total = $type['price'] * $this->duration;
                                    break;
                                case "per_day":
                                    $type_total = $type['price'] * ceil($this->duration / 24);
                                    break;
                            }
                            if (!empty($type['per_person'])) {
                                $type_total *= $total_guests;
                            }

                            $type['total'] = $type_total;
                            $total += $type_total;
                            $extra_price[] = $type;
                        }
                    }
                }
            }

        }

        if (empty($start_date)) {
            return $this->sendError(__("Start date is not a valid date"));
        }

        //Buyer Fees for Admin
        $total_before_fees = $total;
        $total_buyer_fee = 0;
        if (!empty($list_buyer_fees = setting_item('tour_booking_buyer_fees'))) {
            $list_fees = json_decode($list_buyer_fees, true);
            $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , $total_guests);
            $total += $total_buyer_fee;
        }

        //Service Fees for Vendor
        $total_service_fee = 0;
        if(!empty($this->enable_service_fee) and !empty($list_service_fee = $this->service_fee)){
            $total_service_fee = $this->calculateServiceFees($list_service_fee , $total_before_fees , $total_guests);
            $total += $total_service_fee;
        }

        $booking = new $this->bookingClass();
        $booking->status = 'draft';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = $this->create_user;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->total_guests = $total_guests;
        $booking->start_date = $start_date->format('Y-m-d H:i:s');
        $start_date->modify('+ ' . max(1, $this->duration) . ' hours');
        $booking->end_date = $start_date->format('Y-m-d H:i:s');

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;



        $booking->calculateCommission();
        if ($this->isDepositEnable()) {
            $booking_deposit_fomular = $this->getDepositFomular();
            $tmp_price_total = $booking->total;
            if ($booking_deposit_fomular == "deposit_and_fee") {
                $tmp_price_total = $booking->total_before_fees;
            }
            switch ($this->getDepositType()) {
                case "percent":
                    $booking->deposit = $tmp_price_total * $this->getDepositAmount() / 100;
                break;
                default:
                    $booking->deposit = $this->getDepositAmount();
                break;
            }
            if ($booking_deposit_fomular == "deposit_and_fee") {
                $booking->deposit = $booking->deposit + $total_buyer_fee + $total_service_fee;
            }
        }
        $check = $booking->save();
        if ($check) {
            $from_address=$request->input('from_address',[]);
            $to_address=$request->input('to_address',[]);
            $this->bookingClass::clearDraftBookings();
            $booking->addMeta('duration', $this->duration);
            $booking->addMeta('base_price', $base_price);
            $booking->addMeta('guests', max($total_guests, $request->input('guests')));
            $booking->addMeta('extra_price', $extra_price);
            $booking->addMeta('person_types', $person_types);
            $booking->addMeta('discount_by_people', $discount_by_people);
            $booking->addMeta('tmp_total', $booking->total);

            $booking->addMeta('booking_tour_information',[
                'gg_distance'=>$request->input('gg_distance'),
                'gg_duration'=>$request->input('gg_duration'),
                'from_address'=>$from_address['address']??'',
                'to_address'=>$to_address['address']??'',
                'from_address_json'=>$from_address,
                'to_address_json'=>$to_address,
                'pickup_date'=>$start_date,
                'passenger'=>$total_guests,
            ]);
            if ($this->isDepositEnable()) {
                $booking->addMeta('deposit_info', [
                    'type'    => $this->getDepositType(),
                    'amount'  => $this->getDepositAmount(),
                    'fomular' => $this->getDepositFomular(),
                ]);
            }
            return $this->sendSuccess([
                'url' => route('booking.extra',['code'=>$booking->code]),
                'booking_code' => $booking->code,
            ]);
        }
        return $this->sendError(__("Can not check availability"));
    }
    public function addToCartValidate(Request $request)
    {
        $meta = $this->meta;
        $rules = [
            'passenger' => 'required|min:1|max:'.$this->max_people,
            'pickup_date' => 'required|date_format:Y-m-d',
            'pickup_time' => 'required|date_format:H:i',
            'gg_distance'=>'required',
            'from_address'=>'required',
            'to_address'=>'required',
        ];
        $message =[
            'pickup_date.required'=>__("Pickup date and Pickup time are required"),
            'pickup_time.required'=>__("Pickup date and Pickup time are required"),
            'gg_distance.required'=>__("Distance is required"),
            'from_address.required'=>__("Pickup location is required"),
            'to_address.required'=>__("Return location is required"),
        ];
        $start_date = date('Y-m-d H:i:s',strtotime($request->input('pickup_date').' '.$request->input('pickup_time')));

        // Validation
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules,$message);
            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }
        }
        if (strtotime($start_date) < strtotime(date('Y-m-d 00:00:00'))) {
            return $this->sendError(__("Your selected dates are not valid"));
        }

        if($this->isFixedDate()){
            if(Carbon::parse($request->start_date.' 00:00:00') <> $this->start_date){
                return $this->sendError(__("This tour is not available at selected dates"));
            }
        }else{
            // Validate Date and Booking
//            if(!$this->isAvailableInRanges($start_date)){
//                return $this->sendError(__("This tour is not available at selected dates"));
//            }

            if ($meta) {
                // Open Hours
                if ($meta->enable_open_hours) {
                    $open_hours = $meta->open_hours;
                    $nDate = date('N', strtotime($start_date));
                    if (!isset($open_hours[$nDate]) or empty($open_hours[$nDate]['enable'])) {
                        return $this->sendError(__("This tour is not open on your selected day"));
                    }
                }
            }

            if(!empty($this->min_day_before_booking)){
                $minday_before = strtotime("today +".$this->min_day_before_booking." days");
                if(  strtotime($start_date) < $minday_before){
                    return $this->sendError(__("You must book the service for :number days in advance",["number"=>$this->min_day_before_booking]));
                }
            }
        }

        return true;
    }





    public function saveCloneByID($clone_id)
    {
        $new = parent::saveCloneByID($clone_id); // TODO: Change the autogenerated stub

        if($new){
            foreach ($this->pricing as $itemOld){
                $item = $itemOld->replicate();
                $item->tour_id = $new->id;
                $item->save();
            }
        }
    }

}
