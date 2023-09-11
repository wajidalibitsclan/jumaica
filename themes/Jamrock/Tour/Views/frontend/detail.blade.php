@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
    <link rel="stylesheet" href="/themes/jamrock/libs/timepicker/VueTimepicker.css"/>
    <style>
        .bravo_footer{
            display: none!important;
        }
    </style>
@endpush
@section('content')
    <div class="bravo_detail_tour">
        @include('Tour::frontend.layouts.details.tour-banner')
        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        @php $review_score = $row->review_data @endphp
                        @include('Tour::frontend.layouts.details.tour-detail')
                        @include('Tour::frontend.layouts.details.tour-review')
                    </div>
                    <div class="col-md-12 col-lg-4">
                        @include('Tour::frontend.layouts.details.vendor')
                        @include('Tour::frontend.layouts.details.form-book')
                        @include('Tour::frontend.layouts.details.open-hours')
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        @include('Tour::frontend.layouts.details.tour-related')
                    </div>
                </div>
            </div>
        </div>
        <div class="bravo-more-book-mobile">
            <div class="container">
                <div class="left">
                    <div class="g-price">
                        <div class="prefix">
                            <span class="fr_text">{{__("from")}}</span>
                        </div>
                        <div class="price">
                            <span class="onsale">{{ $row->display_sale_price }}</span>
                            <span class="text-price">{{ $row->display_price }} <small>PP</small></span>
                        </div>
                    </div>
                    @if(setting_item('tour_enable_review'))
                    <?php
                    $reviewData = $row->getScoreReview();
                    $score_total = $reviewData['score_total'];
                    ?>
                    <div class="service-review tour-review-{{$score_total}}">
                        <div class="list-star">
                            <ul class="booking-item-rating-stars">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                            </ul>
                            <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                <ul class="booking-item-rating-stars">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <span class="review">
                        @if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                    </span>
                    </div>
                    @endif
                </div>
                <div class="right">
                    @if($row->getBookingEnquiryType() === "book")
                        <a class="btn btn-primary bravo-button-book-mobile">{{__("Book Now")}}</a>
                    @else
                        <a class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">{{__("Contact Now")}}</a>
                   @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {
                            iconUrl:"{{get_file_url(setting_item("tour_icon_marker_map"),'full') ?? url('images/icons/png/pin.png') }}"
                        }
                    });
                }
            });
            @endif
        })
    </script>
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!};
        var bravo_booking_i18n = {
            no_date_select:'{{__('Please select Start and End date')}}',
            no_from_address_select:'{{__('Please select pickup location')}}',
            no_to_address_select:'{{__('Please select return location')}}',
            no_gg_distance_select:'{{__('Please click search button')}}',
            no_pickup_date_select:'{{__('Please select Pickup date and Pickup time')}}',
            no_return_date_select:'{{__('Please select Return date and Return time')}}',
            no_passenger_select:'{{__('Please select at least one person')}}',
            no_guest_select:'{{__('Please select at least one number')}}',
            load_dates_url:'{{route('car.vendor.availability.loadDates')}}',
            name_required:'{{ __("Name is Required") }}',
            email_required:'{{ __("Email is Required") }}',
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('themes/jamrock/js/tour/single-tour.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="/themes/jamrock/libs/timepicker/VueTimepicker.umd.min.js"></script>
    <script type="text/javascript" src="{{ asset('themes/jamrock/js/tour/form-book.js?_ver='.config('app.asset_version')) }}"></script>

@endpush
