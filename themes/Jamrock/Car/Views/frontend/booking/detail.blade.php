@php $lang_local = app()->getLocale();
    $bookingInformation = $booking->getJsonMeta('booking_car_information');
    $is_oneway_trip = $bookingInformation['is_oneway_trip']??false;
@endphp
<div class="booking-review">



    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info d-flex flex-row-reverse">
                <div>
                    @php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    @endphp
                    <h3 class="service-name">
                        <a href="{{$service->getDetailUrl()}}" style="font-size: 13px !important;">
                            {!! clean($service_translation->title) !!}

                            |
                            @if(!$is_oneway_trip)
                                Round Trip
                                @else
                                OneWay
                            @endif
|
                            @php
                                $price_item = $booking->total_before_extra_price;
                            @endphp
                            @if(!empty($price_item))
                                {{format_money( $price_item)}}
                            @endif
                                            @if($meta = $booking->number)
                                                <div class="d-flex flex-column float-left label p-1 text-muted">
                                                    {{__('Persons')}} & Bags :
                                                        {{$meta}}
                                                        |
                                                        {{$bookingInformation['baggage']}}
                                            @endif
                        </a>
                    </h3>
                    @if($service_translation->address)
                        <p class="address"><i class="fa fa-map-marker"></i>
                            {{$service_translation->address}}
                        </p>
                    @endif
                </div>
                <div>
                    <img src="{{$service->image_url}}" class="img-responsive" alt="{!! clean($service_translation->title) !!}">
                </div>
            </div>
        </div>
        <div class="">

                    <div class="border border-secondary d-flex flex-column label p-1 text-muted w-100">{{__('where From:')}} <span class="text-dark">{{$bookingInformation['from_address']}}</span></div>

                    <div class="border border-secondary d-flex flex-column label p-1 text-muted w-100">{{__('where To:')}} <span class="text-dark">{{$bookingInformation['to_address']}}</span></div>


                @if($booking->start_date)
                    <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                        <div class="label text-muted">{{__('Pickup date:')}}</div>
                        <div class="val text-dark">
                            {{display_datetime($booking->start_date)}}
                        </div>
                    </div>
                    @if(!$is_oneway_trip)
                        <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                            <div class="label text-muted">{{__('Return date:')}}</div>
                            <div class="val text-dark">
                                {{display_datetime($booking->end_date)}}
                            </div>
                        </div>
                    @endif
                @endif


{{--                @if($meta = $booking->number)--}}
{{--                    <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">--}}
{{--                        <div class="label text-muted">{{__('Persons:')}} | Bags</div>--}}
{{--                        <div class="val text-dark">--}}
{{--                            {{$meta}}--}}
{{--                            |--}}
{{--                            {{$bookingInformation['baggage']}}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
                <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                    <div class="label text-muted">{{__('Pickup Flight #:')}}</div>
                    <div class="val text-dark">
                        {{$bookingInformation['pickup_flight']}}
                    </div>
                </div>
                @if(!$is_oneway_trip)
                    <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                        <div class="label text-muted">{{__('Return Flight #:')}}</div>
                        <div class="val text-dark">
                            {{$bookingInformation['return_flight']}}
                        </div>
                    </div>
                @endif

        </div>
        <div class="border border-secondary d-flex flex-column label p-1 review-section text-muted total-review w-100">

{{--                @php--}}
{{--                    $price_item = $booking->total_before_extra_price;--}}
{{--                @endphp--}}
{{--                 @if(!empty($price_item))--}}
{{--                   <li>--}}
{{--                        <div class="label text-muted">{{__('Service Charge')}}--}}
{{--                        </div>--}}
{{--                        <div class="val">--}}
{{--                            {{format_money( $price_item)}}--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endif--}}
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price) or !empty($booking->extras))
                   <div>
                        <div class="label-title"><span>{{__("Extras:")}}</span></div>
                    </div>
                    <div class="no-flex">
                        <ul class="pl-0">
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">
                                        {{$type['name_'.$lang_local] ?? $type['name']}}: {{format_money($type['price'])}} x {{!empty($type['per_person']) ? $booking->number : 1}}
                                    </div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                            @includeIf('Booking::frontend/booking/extra-detail')
                        </ul>
                    </div>
                @endif
                <hr>

{{--                <li>--}}
{{--                    <div class="label">--}}
{{--                        {{__('Total:')}}--}}


{{--                    </div>--}}
{{--                    <div class="val">--}}
{{--                        {{format_money($booking->total)}}--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                @php--}}
{{--                    $list_all_fee = [];--}}
{{--                    if(!empty($booking->buyer_fees)){--}}
{{--                        $buyer_fees = json_decode($booking->buyer_fees , true);--}}
{{--                        $list_all_fee = $buyer_fees;--}}
{{--                    }--}}
{{--                    if(!empty($vendor_service_fee = $booking->vendor_service_fee)){--}}
{{--                        $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);--}}
{{--                    }--}}
{{--                @endphp--}}
{{--                @if(!empty($list_all_fee))--}}
{{--                    @foreach ($list_all_fee as $item)--}}
{{--                        @php--}}
{{--                            $fee_price = $item['price'];--}}
{{--                            if(!empty($item['unit']) and $item['unit'] == "percent"){--}}
{{--                                $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        <li>--}}
{{--                            <div class="label">--}}
{{--                                {{$item['name_'.$lang_local] ?? $item['name']}}--}}
{{--                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>--}}
{{--                                @if(!empty($item['per_person']) and $item['per_person'] == "on")--}}
{{--                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="val">--}}
{{--                                @if(!empty($item['per_person']) and $item['per_person'] == "on")--}}
{{--                                    {{ format_money( $fee_price * $booking->total_guests ) }}--}}
{{--                                @else--}}
{{--                                    {{ format_money( $fee_price ) }}--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
                <div class="coupon-box d-none">
                @includeIf('Coupon::frontend/booking/checkout-coupon')
                </div>
               {{-- <li class="final-total d-block">
                    <div class="d-flex justify-content-between">
                        <div class="label">{{__("Total:")}}</div>
                        <div class="val">{{format_money($booking->total)}}</div>
                    </div>
                @if($booking->status !='draft')
                    <div class="d-flex justify-content-between">
                        <div class="label">{{__("Paid:")}}</div>
                        <div class="val">{{format_money($booking->paid)}}</div>
                    </div>
                    @if($booking->paid < $booking->total )
                        <div class="d-flex justify-content-between">
                            <div class="label">{{__("Remain:")}}</div>
                            <div class="val">{{format_money($booking->total - $booking->paid)}}</div>
                        </div>
                        @endif
                    @endif
                </li>--}}
                @include ('Booking::frontend/booking/checkout-deposit-amount')

        </div>
     <div class="border border-secondary label p-1 text-muted w-100">
         <button class="btn btn-secondary m-1" onclick="$('.coupon-box').toggleClass('d-none')">Add Coupon</button>
     </div>
    </div>

    <h4 class="booking-review-title d-flex justify-content-start align-items-center" style="font-size:18px;">
        <div class="d-flex">
            {{__("BOOKING INFO")}} |
            <a class="d-block d-sm-none ml-auto text-15 show_hide_section1 show_hide_map" href="#">SHOW DETAILS</a>
        </div>
    </h4>
</div>



@push('js')
<script>
    $(document).ready(function(){
    $('.show_hide_section1').click(function() {
        if ($('.booking-review-content').css('display') == 'block') {
            $('.booking-review-content').toggle("slide");
            $(this).html('SHOW DETAILS')
        }else{

            $('.booking-review-content').toggle("slide");
            $(this).html('HIDE DETAILS')
        }

    });
    })
</script>
@endpush

