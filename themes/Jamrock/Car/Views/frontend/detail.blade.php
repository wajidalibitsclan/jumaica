@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/car/css/car.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
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
    <div class="bravo_detail_car">
        @include('Layout::parts.bc')
        <div class="container">
            @include('Car::frontend.layouts.details.banner')
        </div>

        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        @php $review_score = $row->review_data @endphp
                        @include('Car::frontend.layouts.details.detail')
                        @include('Car::frontend.layouts.details.review')
                    </div>
                    <div class="col-md-12 col-lg-4">
                        @include('Tour::frontend.layouts.details.vendor')
                        @include('Car::frontend.layouts.details.form-book')
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        @include('Car::frontend.layouts.details.related')
                    </div>
                </div>
            </div>
        </div>
        @include('Car::frontend.layouts.details.form-book-mobile')
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
                            iconUrl:"{{get_file_url(setting_item("car_icon_marker_map"),'full') ?? url('images/icons/png/pin.png') }}"
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
			no_gg_distance_select:'{{__('Can not calculate distance, please select address again')}}',
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
    <script type="text/javascript" src="/themes/jamrock/libs/timepicker/VueTimepicker.umd.min.js"></script>
    <script type="text/javascript" src="{{ asset('themes/jamrock/js/car/single-car.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
