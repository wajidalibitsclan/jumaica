@php $lang_local = app()->getLocale();    $bookingInformation = $booking->getJsonMeta('booking_tour_information');
@endphp
<div class="booking-review">
    <h4 class="booking-review-title d-flex justify-content-start align-items-center" style="font-size:18px;">
        {{__("BOOKING DETAILS")}}
        <a class="d-block d-sm-none ml-auto text-15 show_hide_section2 show_hide_map" href="#">Show Details</a>
    </h4>

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
                    <li>
                        <div class="label text-muted">{{__('Fr:')}} <span class="text-dark">{{$bookingInformation['from_address']}}</span></div>
                    </li>

                    <li>
                        <div class="label text-muted">{{__('To:')}} <span class="text-dark">{{$bookingInformation['to_address']}}</span></div>
                    </li>

                @if($booking->start_date)
                    <li>
                        <div class="label text-muted">{{__('Pickup Date:')}}</div>
                        <div class="val">
                            {{display_datetime($booking->start_date)}}
                        </div>
                    </li>
                @endif

                    @if($meta = $booking->number)
                        <li>
                            <div class="label">{{__('Persons:')}}</div>
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
                        <div class="label text-muted">{{__('Service Charge')}}
                        </div>
                        <div class="val">
                            {{format_money( $price_item)}}
                        </div>
                    </li>
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price) or !empty($booking->extras))
                    <li>
                        <div class="label-title"><span>{{__("Extras:")}}</span></div>
                    </li>
                    <li class="no-flex">
                        <ul class="pl-0">
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}: {{format_money($type['price'])}} x {{!empty($type['per_person']) ? $booking->total_guests : 1}}</div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                            @includeIf('Booking::frontend/booking/extra-detail')
                        </ul>
                    </li>
                @endif

                <hr>

                <li>
                    <div class="label">
                        {{__('Total:')}}

                        <span class="badge badge-default bg-gray py-1 px-2 ml-3" onclick="$('.coupon-box').toggleClass('d-none')">Add Couon</span>
                    </div>
                    <div class="val">
                        {{format_money($booking->total)}}
                    </div>
                </li>

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
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
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
            </ul>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(function(){
            $('.show_hide_section2').click(function() {
                if ($('.booking-review-content').css('display') == 'block') {
                    $('.booking-review-content').toggle("slide");
                    $(this).html('Show Details')
                }else{

                    $('.booking-review-content').toggle("slide");
                    $(this).html('Hide Details')
                }

            });
        })
    </script>
@endpush
