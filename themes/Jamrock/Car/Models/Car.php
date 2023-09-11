<?php


namespace Themes\Jamrock\Car\Models;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\SEO;

class Car extends \Modules\Car\Models\Car
{

    public function beforeCheckout(Request $request, $booking)
    {
        return;
    }

    public function prices(){
        return $this->hasMany(Pricing::class,'car_id');
    }

    public function savePricing($prices){
            $argv = [];
            $this->prices()->delete();
            foreach ($prices as $item=>$value){
                $argv[]= new Pricing([
                    'from'=>$value['from'] ??0,
                    'to'=>$value['to'] ?? 0,
                    'oneway_price'=>$value['oneway_price'] ?? 0,
                    'oneway_discount'=>$value['oneway_discount'] ?? 0,
                    'roundtrip_price'=>$value['roundtrip_price'] ?? 0,
                    'roundtrip_discount'=>$value['roundtrip_discount'] ?? 0,
                ]);
            }
            $this->prices()->saveMany($argv);
    }
    public function getBookingData()
    {

        if (!empty($start = request()->input('start'))) {
            $start_html = display_date($start);
            $end_html = request()->input('end') ? display_date(request()->input('end')) : "";
            $date_html = $start_html . '<i class="fa fa-long-arrow-right" style="font-size: inherit"></i>' . $end_html;
        }
        $booking_data = [
            'id'              => $this->id,
            'extra_price'     => [],
            'minDate'         => date('m/d/Y'),
            'max_number'      => $this->number ?? 1,
            'buyer_fees'      => [],
            'start_date'      => request()->input('start') ?? "",
            'start_date_html' => $date_html ?? __('Please select date!'),
            'end_date'        => request()->input('end') ?? "",
            'deposit'=>$this->isDepositEnable(),
            'deposit_type'=>$this->getDepositType(),
            'deposit_amount'=>$this->getDepositAmount(),
            'deposit_fomular'=>$this->getDepositFomular(),
            'is_form_enquiry_and_book'=> $this->isFormEnquiryAndBook(),
            'enquiry_type'=> $this->getBookingEnquiryType(),
            'pricing'=>$this->prices,
            'max_passenger'      => $this->passenger ?? 1,
            'max_baggage'=>$this->baggage??1,

        ];
        $lang = app()->getLocale();
        if ($this->enable_extra_price) {
            $booking_data['extra_price'] = $this->extra_price;
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

        $list_fees = setting_item_array('car_booking_buyer_fees');
        if(!empty($list_fees)){
            foreach ($list_fees as $item){
                $item['type_name'] = $item['name_'.app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_'.app()->getLocale()] ?? $item['desc'] ?? '';
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
        return $booking_data;
    }

    public function addToCart(Request $request)
    {
        $res = $this->addToCartValidate($request);
        if($res !== true) return $res;
        // Add Booking
        $start_date =  new \DateTime($request->input('pickup_date').' '.$request->input('pickup_time'));
        $extra_price_input = $request->input('extra_price');
        $extra_price = [];
        $number = $request->input('passenger',1);

        $trip_type_selected =$request->input('trip_type_selected',0);
        $is_oneway_trip = $trip_type_selected == 1;

        $end_date =  !$is_oneway_trip ? new \DateTime($request->input('return_date').' '.$request->input('return_time')) : null;

        $gg_distance  = $request->input('gg_distance');
        $distanceKm = $gg_distance['value']/1000;
        $total = 0 ;
        foreach ($this->prices as $item=>$value){
            if($value->from <= $distanceKm and $distanceKm<= $value->to){
                if(!$is_oneway_trip){
//                    round trip
                    $total = $value->roundtrip_discount?:$value->roundtrip_price;
                }else{
                    $total = $value->oneway_discount?:$value->oneway_price;
                }
            }
        }

        if (empty($total)) {
            return $this->sendError(__("Can not calculate total price"));
        }



        if ($this->enable_extra_price and !empty($this->extra_price)) {
            if (!empty($this->extra_price)) {
                foreach ($this->extra_price as $k => $type) {
                    if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
                        $type_total = $type['price'];


                        if (!empty($type['per_person'])) {
                            $type_total *= $number;
                        }

                        $type['total'] = $type_total;
                        $total += $type_total;
                        $extra_price[] = $type;
                    }
                }
            }
        }

        //Buyer Fees for Admin
        $total_before_fees = $total;
        $total_buyer_fee = 0;
        if (!empty($list_buyer_fees = setting_item('car_booking_buyer_fees'))) {
            $list_fees = json_decode($list_buyer_fees, true);
            $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , 1);
            $total += $total_buyer_fee;
        }

        //Service Fees for Vendor
        $total_service_fee = 0;
        if(!empty($this->enable_service_fee) and !empty($list_service_fee = $this->service_fee)){
            $total_service_fee = $this->calculateServiceFees($list_service_fee , $total_before_fees , 1);
            $total += $total_service_fee;
        }
        if (empty($start_date) or (empty($is_oneway_trip) and empty($end_date))) {
            return $this->sendError(__("Your selected dates are not valid"));
        }


        $booking = new $this->bookingClass();
        $booking->status = 'draft';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = $this->create_user;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->total_guests = $number;
        $booking->start_date = $start_date->format('Y-m-d H:i:s');
        $booking->end_date = $end_date ? $end_date->format('Y-m-d H:i:s') : null;

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $booking->calculateCommission();
        $booking->number = $number;

        if($this->isDepositEnable())
        {
            $booking_deposit_fomular = $this->getDepositFomular();
            $tmp_price_total = $booking->total;
            if($booking_deposit_fomular == "deposit_and_fee"){
                $tmp_price_total = $booking->total_before_fees;
            }

            switch ($this->getDepositType()){
                case "percent":
                    $booking->deposit = $tmp_price_total * $this->getDepositAmount() / 100;
                break;
                default:
                    $booking->deposit = $this->getDepositAmount();
                break;
            }
            if($booking_deposit_fomular == "deposit_and_fee"){
                $booking->deposit = $booking->deposit + $total_buyer_fee + $total_service_fee;
            }
        }

        $check = $booking->save();
        if ($check) {
            $from_address=$request->input('from_address',[]);
            $to_address=$request->input('to_address',[]);
            $this->bookingClass::clearDraftBookings();
            $booking->addMeta('duration', $this->duration);
            $booking->addMeta('base_price', $this->price);
            $booking->addMeta('sale_price', $this->sale_price);
            $booking->addMeta('extra_price', $extra_price);
            $booking->addMeta('pickup_date',$start_date);
            $booking->addMeta('return_date',$end_date);
            $booking->addMeta('tmp_total', $booking->total);
            $booking->addMeta('booking_car_information',[
                'pickup_flight'=>$request->input('pickup_flight'),
                'return_flight'=>$request->input('return_flight'),
                'gg_distance'=>$request->input('gg_distance'),
                'gg_duration'=>$request->input('gg_duration'),
                'from_address'=>$from_address['address']??'',
                'to_address'=>$to_address['address']??'',
                'from_address_json'=>$from_address,
                'to_address_json'=>$to_address,
                'baggage'=>$request->input('baggage'),
                'is_oneway_trip'=>$is_oneway_trip,
                'pickup_date'=>$start_date,
                'return_date'=>$end_date,
                'passenger'=>$number,
            ]);


            if($this->isDepositEnable())
            {
                $booking->addMeta('deposit_info',[
                    'type'=>$this->getDepositType(),
                    'amount'=>$this->getDepositAmount(),
                    'fomular'=>$this->getDepositFomular(),
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
        $is_oneway_trip = $request->input('trip_type_selected',0);
        $rules = [
            'passenger' => 'required|max:'.$this->passenger,
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
            'from_address.required'=>__("From address is required"),
            'to_address.required'=>__("To address is required"),
        ];

        // Validation
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules,$message);

            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }
        }
        $start_date = date('Y-m-d H:i:s',strtotime($request->input('pickup_date').' '.$request->input('pickup_time')));
        if(empty($is_oneway_trip)){

            $end_date = date('Y-m-d H:i:s',strtotime($request->input('return_date').' '.$request->input('return_time')));

            if(strtotime($start_date) < strtotime(date('Y-m-d 00:00:00')) or strtotime($start_date) > strtotime($end_date))
            {
                return $this->sendError(__("Return date must greater than pickup date"));
            }

        }else{
            if(strtotime($start_date) < strtotime(date('Y-m-d 00:00:00')))
            {
                return $this->sendError(__("You can not select past date"));
            }
        }


        return true;
    }


    public function saveCloneByID($clone_id)
    {
        $old = parent::find($clone_id);
        if(empty($old)) return false;
        $selected_terms = $old->terms->pluck('term_id');
        $old->title = $old->title." - Copy";
        $new = $old->replicate();
        $new->save();
        //Terms
        foreach ($selected_terms as $term_id) {
            $this->carTermClass::firstOrCreate([
                'term_id' => $term_id,
                'target_id' => $new->id
            ]);
        }
        //Language
        $langs = $this->carTranslationClass::where("origin_id",$old->id)->get();
        if(!empty($langs)){
            foreach ($langs as $lang){
                $langNew = $lang->replicate();
                $langNew->origin_id = $new->id;
                $langNew->save();
                $langSeo = SEO::where('object_id', $lang->id)->where('object_model', $lang->getSeoType()."_".$lang->locale)->first();
                if(!empty($langSeo)){
                    $langSeoNew = $langSeo->replicate();
                    $langSeoNew->object_id = $langNew->id;
                    $langSeoNew->save();
                }
            }
        }
        //SEO
        $metaSeo = SEO::where('object_id', $old->id)->where('object_model', $this->seo_type)->first();
        if(!empty($metaSeo)){
            $metaSeoNew = $metaSeo->replicate();
            $metaSeoNew->object_id = $new->id;
            $metaSeoNew->save();
        }

        foreach ($this->prices as $priceOld){
            $price = $priceOld->replicate();
            $price->car_id = $new->id;
            $price->save();
        }
    }

}
