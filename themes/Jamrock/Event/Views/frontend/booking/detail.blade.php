@php $lang_local = app()->getLocale();$bookingInformation = $booking->getJsonMeta('booking_tour_information') @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    @php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    @endphp
                    <h3 class="service-name"><a href="{{$service->getDetailUrl()}}">{!! clean($service_translation->title) !!}</a></h3>
                    @if($service_translation->address)
                        <p class="address"><i class="fa fa-map-marker"></i>
                            {{$service_translation->address}}
                        </p>
                    @endif
                </div>
                <div>
                    @if($image_url = $service->getImageUrl())
                        <img src="{{$image_url}}" alt="{!! clean($service_translation->title) !!}">
                    @endif
                </div>
            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{__('Start date:')}}</div>
                        <div class="val">
                            {{display_datetime($booking->start_date)}}
                        </div>
                    </li>
                @endif
                <li>
                    <div class="label">{{__('From:')}} <strong>{{$bookingInformation['from_address']}}</strong></div>
                </li>

                <li>
                    <div class="label">{{__('To:')}} <strong>{{$bookingInformation['to_address']}}</strong></div>
                </li>
                    @if($meta = $booking->number)
                        <li>
                            <div class="label">{{__('Passenger:')}}</div>
                            <div class="val">
                                {{$meta}}
                            </div>
                        </li>
                    @endif
            </ul>
        </div>
        @do_action('booking.checkout.before_total_review')
        <div class="review-section total-review">
            <ul class="review-list">
                @php
                    $price_item = $booking->total_before_extra_price;
                @endphp
                @if(!empty($price_item))
                    <li>
                        <div class="label">{{__('Taxi price')}}
                        </div>
                        <div class="val">
                            {{format_money( $price_item)}}
                        </div>
                    </li>
                @endif
                @if($booking->getMeta("booking_type") == "time_slot")
                    <li>
                        <div class="label">{{ $booking->total_guests }} x {{ format_money( $booking->getJsonMeta('base_price')) }}</div>
                        <div class="val">
                            {{format_money( $booking->getJsonMeta('base_price') * $booking->total_guests )  }}
                        </div>
                    </li>
                @endif
                @if($booking->getMeta("booking_type") == "ticket")
                    @php $ticket_types = $booking->getJsonMeta('ticket_types') @endphp
                    @if(!empty($ticket_types))
                        @foreach($ticket_types as $type)
                            <li>
                                <div class="label">{{ $type['name_'.$lang_local] ?? $type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                                <div class="val">
                                    {{format_money($type['price'] * $type['number'])}}
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price) or !empty($booking->extras))
                    <li>
                        <div class="label-title"><strong>{{__("Extra Prices:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}: {{format_money($type['price'])}} x {{!empty($type['per_person']) ? $booking->number : 1}}</div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                            @includeIf('Booking::frontend/booking/extra-detail')
                        </ul>
                    </li>
                @endif
                @php
                    $list_all_fee = [];
                    if(!empty($booking->buyer_fees)){
                        $buyer_fees = json_decode($booking->buyer_fees , true);
                        $list_all_fee = $buyer_fees;
                    }
                    if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                        $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                    }
                @endphp
                @if(!empty($list_all_fee))
                    @foreach ($list_all_fee as $item)
                        @php
                            $fee_price = $item['price'];
                            if(!empty($item['unit']) and $item['unit'] == "percent"){
                                $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                            }
                        @endphp
                        <li>
                            <div class="label">
                                {{$item['name_'.$lang_local] ?? $item['name']}}
                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                @if(!empty($item['per_ticket']) and $item['per_ticket'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_ticket']) and $item['per_ticket'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
                    @includeIf('Coupon::frontend/booking/checkout-coupon')
                <li class="final-total d-block">
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
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>
