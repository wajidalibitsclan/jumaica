@extends('layouts.app')
@section('content')
    <section class="our-agent-single bgc-f7 pb30-991">
        @include('Property::frontend.layouts.details.detail_v2.gallery_property')
    </section>

    <!-- Agent Single Grid View -->
    <section class="our-agent-single bgc-f7 pb30-991">
        <div class="container">
            @include('Agencies::frontend.detail.search_mobile')
            <div class="row">
                <div class="col-md-12 col-lg-8">
                        <div class="single_property_title mt30-767 mb30-767">
                            <h2>{{ $translation->title ?? '' }}</h2>
                            <p>{{ $translation->address }}</p>
                        </div>
                </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="single_property_social_share">
                            <div class="price float-left fn-400">
                                <h2>{{ $row['display_price'] ? $row['display_price'] : '' }}</h2>
                                @if($row->is_sold)
                                    <div><span class="badge badge-danger is_sold_out">{{__("Sold Out")}}</span></div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-8 mt50">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="listing_single_description style2">
                                <div class="lsd_list">
                                    <ul class="mb0">
                                        @if(!empty($row['Category'])) <li class="list-inline-item"><a href="#"><i class="{{ $row['Category']->icon }}"></i> {{  $row['Category']->name}}</a></li> @endif
                                        <li class="list-inline-item"><a href="#">{{ __("Beds") }}: {{ !empty($row['bed']) ? $row['bed'] : ''}}</a></li>
                                        <li class="list-inline-item"><a href="#">{{ __("Baths") }}: {{ !empty($row['bathroom']) ? $row['bathroom'] : '' }}</a></li>
                                        <li class="list-inline-item"><a href="#">{{ __("Sq Ft") }}: {{ !empty($row['square']) ? $row['square'] : ''}}</a></li>
                                    </ul>
                                </div>
                                @if(!empty($row['content']))
                                    <h4 class="mb30">{{ __("Description") }}</h4>
                                    <div class="gpara second_para white_goverlay mt10 mb10">{!! clean(Str::words($translation->content,50)) !!}</div>

                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <p class="mt10 mb10">{!! clean($translation->content) !!}</p>
                                        </div>
                                    </div>
                                    <p class="overlay_close">
                                        <a class="text-thm fz14" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            {{__('Show More')}} <span class="flaticon-download-1 fz12"></span>
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="additional_details">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="mb15">{{ __("Property Details") }}</h4>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <dl class="inline">
                                            <dt><p>{{ __("Property ID") }} :</p></dt>
                                            <dd><p>{{ $row->id ? $row->id : 0 }}</p></dd>
                                            <dt><p>{{ __("Price") }} :</p></dt>
                                            <dd><p>{{ $row->display_price ? $row->display_price : 0 }}</p></dd>
                                            <dt><p>{{ __("Property Size") }} :</p></dt>
                                            <dd><p>{!! !empty($row['square']) ? size_unit_format($row['square']) : 0 !!}</p></dd>
                                            <dt><p>{{ __("Year Built") }} :</p></dt>
                                            <dd><p>{{ $row->year_built ? $row->year_built : __('None') }}</p></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <dl class="inline">
                                            <dt><p>{{ __("Bedrooms") }} :</p></dt>
                                            <dd><p>{{ $row->bed ? $row->bed : 0 }}</p></dd>
                                            <dt><p>{{ __("Bathrooms") }} :</p></dt>
                                            <dd><p>{{ $row->bathroom ? $row->bathroom : 0 }}</p></dd>
                                            <dt><p>{{ __("Garage") }} :</p></dt>
                                            <dd><p>{{ $row->garages ? $row->garages : 0 }}</p></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <dl class="inline">
                                            <dt><p>{{ __("Property Type") }} :</p></dt>
                                            <dd><p>{{ $row->category ? $row->category->name : '' }}</p></dd>
                                            <dt><p>{{ __("Property Status") }} :</p></dt>
                                            <dd><p><span>{{$row->property_type == 1 ? __('For Buy') : __('For Rent')}}</span></p></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="additional_details">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="mb15">{{__('Additional details')}}</h4>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <dl class="inline">
                                            <dt><p>{{ __("Deposit") }} :</p></dt>
                                            <dd><p>{{  $row->deposit ? $row->deposit : 0 }}</p></dd>
                                            <dt><p>{{ __("Pool Size") }} :</p></dt>
                                            <dd><p>{!!  $row->pool_size ? size_unit_format($row->pool_size) : 0  !!}</p></dd>
                                            <dt><p>{{ __("Additional Rooms") }} :</p></dt>
                                            <dd><p>{{ $row->additional_zoom ? $row->additional_zoom : 0 }}</p></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">

                                        <dl class="inline">
                                            <dt><p>{{ __("Last remodel year") }} :</p></dt>
                                            <dd><p>{{ $row->remodal_year ? $row->remodal_year : __('None') }}</p></dd>
                                            <dt><p>{{ __("Amenities") }} :</p></dt>
                                            <dd><p>{{ $row->amenities ? $row->amenities : 0 }}</p></dd>
                                            <dt><p>{{ __("Equipment") }} :</p></dt>
                                            <dd><p>{{ $row->equipment ? $row->equipment : 0 }}</p></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('Property::frontend.layouts.details.property_feature')
                        @if(!empty($row->location->name))
                            @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
                        @endif
                        <div class="col-lg-12">
                            <div class="application_statics mt30">
                                <h4 class="mb30">{{ __("Location") }} <small class="application_statics_location float-right">{{ !empty($location->name) ? $location->name : '' }}</small></h4>
                                <div class="property_video p0">
                                    <div class="thumb">
                                        <div class="h400" id="map-canvas"></div>
                                        <div class="overlay_icon">
                                            <a href="#"><img class="map_img_icon" src="{{asset('findhouse/images/header-logo.png')}}" alt="header-logo.png"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('Property::frontend.layouts.details.property_video')
                        <div class="col-lg-12">
                            @include('Agencies::frontend.detail.review', ['review_service_id' => $row['id'], 'review_service_type' => 'property'])
                        </div>
                        @include('Property::frontend.layouts.details.property-related')
                    </div>
                </div>
                <div class="col-lg-4 col-xl-4 mt50">
                    <div class="sidebar_listing_list">
                        <div class="sidebar_advanced_search_widget">
                            <div class="sl_creator">
                                <h4 class="mb25">{{ __("Listed By") }}</h4>
                                <div class="media">
                                    <a href="{{route('agent.detail',['id'=>$row->user->id])}}" class="c-inherit">
                                    @if($avatar_url = $row->user->getAvatarUrl())
                                        <img class="mr-3" src="{{$avatar_url}}" alt="{{$row->user->getDisplayName()}}">
                                    @else
                                        <span class="mr-3">{{ucfirst($row->user->getDisplayName()[0])}}</span>
                                    @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb0"><a href="{{route('agent.detail',['id'=>$row->user->id])}}" class="c-inherit">{{ $row->user->getDisplayName() }}</a></h5>
                                        <p class="mb0">{{ !empty($row->user->phone) ? $row->user->phone : '' }}</p>
                                        <p class="mb0">{{ !empty($row->user->email) ? $row->user->email : '' }}</p>
                                        <a class="text-thm" href="{{route('agent.detail',['id'=>$row->user->id])}}">{{ __("View My Listing") }}</a>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('agent.contact') }}" method="POST" class="agent_contact_form">
                                @csrf
                                <ul class="sasw_list mb0">
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="text" class="form-control"  placeholder="{{ __('Your Name') }}" name="name">
                                        </div>
                                    </li>
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="number" class="form-control"  placeholder="{{ __('Phone') }}" name="phone">
                                        </div>
                                    </li>
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" placeholder="{{ __('Email') }}" name="email">
                                        </div>
                                    </li>
                                    <li class="search_area">
                                        <div class="form-group">
                                            <textarea id="form_message" name="message" class="form-control required" rows="5" placeholder="{{ __('Your Message') }}"></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <input type="hidden" name="vendor_id" value="{{ $row->user->id }}">
                                        <input type="hidden" name="object_id" value="{{ $row->id }}">
                                        <input type="hidden" name="object_model" value="property">
                                    </li>
                                    <li>
                                        <div class="search_option_button">
                                            <button type="submit" class="btn btn-block btn-thm">{{ __('Contact') }}</button>
                                        </div>
                                    </li>
                                </ul>
                                <div class="form-mess"></div>
                            </form>
                        </div>
                    </div>
                    @include('Property::frontend.layouts.search.form-search')
                    @include('Property::frontend.sidebar.FeatureProperty')
                    @include('Property::frontend.sidebar.categoryProperty')
                    @include('Property::frontend.sidebar.recentViewdProperty')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <link href="{{ asset('libs/fotorama/fotorama.css') }}" rel="stylesheet">
    <script src="{{ asset('libs/fotorama/fotorama.js') }}"></script>
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            new BravoMapEngine('map-canvas', {
                fitBounds: true,
                center: [{{$row->map_lat ?? "51.505"}}, {{$row->map_lng ?? "-0.09"}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    @if($row->map_lat && $row->map_lng)
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                    @endif
                    engineMap.on('click', function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.on('zoom_changed', function (zoom) {
                        $("input[name=map_zoom]").attr("value", zoom);
                    });
                    engineMap.searchBox($('.bravo_searchbox'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                }
            });
        })
    </script>
@endpush
