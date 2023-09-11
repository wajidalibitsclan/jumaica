@php($location_search_style = 'autocompletePlace')

<div id="{{$prefix}}filter" class="filter-item position-relative">
    @if($prefix == 'pickup_')
        <p style="margin: 0;
    padding: 0;color:#00B050;">Form?</p>
    @else
        <p
            style="margin: 0;
    padding: 0;color: #0070C1 "
        >To?</p>
    @endif




    {{--    <svg class="field-icon fa" @if(empty($is_map)) style="left:0" @endif width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
    {{--        <path d="M7.00001 0.25C5.1773 0.25215 3.42987 0.977169 2.14102 2.26602C0.852176 3.55486 0.127158 5.3023 0.125007 7.125C0.122824 8.61452 0.60937 10.0636 1.51001 11.25C1.51001 11.25 1.69751 11.4969 1.72813 11.5325L7.00001 17.75L12.2744 11.5294C12.3019 11.4963 12.49 11.25 12.49 11.25L12.4906 11.2481C13.3908 10.0623 13.8771 8.61383 13.875 7.125C13.8729 5.3023 13.1478 3.55486 11.859 2.26602C10.5701 0.977169 8.82271 0.25215 7.00001 0.25ZM7.00001 9.625C6.50555 9.625 6.0222 9.47838 5.61108 9.20367C5.19996 8.92897 4.87953 8.53852 4.69031 8.08171C4.50109 7.62489 4.45158 7.12223 4.54804 6.63727C4.64451 6.15232 4.88261 5.70686 5.23224 5.35723C5.58187 5.0076 6.02733 4.7695 6.51228 4.67304C6.99723 4.57657 7.4999 4.62608 7.95672 4.8153C8.41353 5.00452 8.80398 5.32495 9.07868 5.73607C9.35338 6.1472 9.50001 6.63055 9.50001 7.125C9.49918 7.78779 9.23552 8.42319 8.76686 8.89185C8.2982 9.36052 7.66279 9.62417 7.00001 9.625Z" fill="currentColor"/>--}}
    {{--    </svg>--}}

    <div class="">
        <div class="">
            @if(empty($is_map))
                <label class="position-relative">

                    {{$title}}
                </label>
            @endif
            @if($location_search_style=='autocompletePlace')
                <div class="g-map-place2">

                    <input required id="{{$name ?? ''}}" type="text" style="height: 13px"
                           name="{{ $prefix ?? "" }}map_place"
                           placeholder="{{ $title_input ?? __("Where are you going?") }}"
                           value="{{request()->query(($prefix ?? '').'map_place')}}"
                           class=" border-0 w-100">
                    <div class="map d-none" id="map-{{\Illuminate\Support\Str::random(10)}}"></div>
                    <input type="hidden" class="map_lat" name="{{ $prefix ?? "" }}map_lat"
                           value="{{request()->query(($prefix ?? "").'map_lat')}}">
                    <input type="hidden" class="map_lng" name="{{ $prefix ?? "" }}map_lng"
                           value="{{request()->query(($prefix ?? "").'map_lng')}}">
                    <input type="hidden" class="map_place_id" name="{{ $prefix ?? "" }}place_id"
                           value="{{request()->query(($prefix ?? "").'place_id')}}">
                </div>

            @else
                <?php
                $location_name = "";
                $list_json = [];
                $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json, &$location_name) {
                    foreach ($locations as $location) {
                        $translate = $location->translateOrOrigin(app()->getLocale());
                        if (request()->query('location_id') == $location->id) {
                            $location_name = $translate->name;
                        }
                        $list_json[] = [
                            'id' => $location->id,
                            'title' => $prefix . ' ' . $translate->name,
                        ];
                        $traverse($location->children, $prefix . '-');
                    }
                };
                $traverse($list_location);
                ?>
                <div class="smart-search">
                    <input type="text" class="smart-search-location parent_text form-control"
                           {{ ( empty(setting_item("car_location_search_style")) or setting_item("car_location_search_style") == "normal" ) ? "readonly" : ""  }} placeholder="{{ $title_input ?? __("Where are you going?")}}"
                           value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                           data-default="{{ json_encode($list_json) }}">
                    <input type="hidden" class="child_id" name="{{ $prefix ?? "" }}location_id"
                           value="{{Request::query(($prefix ?? "").'location_id')}}">
                </div>
            @endif
        </div>
        <span class="map_clear {{$prefix}}clear">
            <img src="{{asset('themes/jamrock/images/image11.png')}}" alt="">
        </span>
    </div>

    <div class="{{$prefix ?? ''}}popup_location popup_location ddddddd" style="display: none">
        <!--        <div class="popup_title" style="font-size: 20px">
                    Popular Locations
                </div>-->
        <ul class="nav nav-tabs mt-0" id="myTab" role="tablist">
            <li class="nav-item mr-auto" role="presentation">
                <button class="nav-link active" id="{{$prefix ?? ''}}home-tab" data-toggle="tab"
                        data-target="#{{$prefix ?? ''}}airports">
                    <i class="fa fa-plane"></i> Airports
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="{{$prefix ?? ''}}profile-tab" data-toggle="tab"
                        data-target="#{{$prefix ?? ''}}hotels">
                    <i class="fa fa-hotel"></i> Hotels
                </button>
            </li>
            <li class="nav-item ml-auto" role="presentation">
                <button class="nav-link" id="{{$prefix ?? ''}}contact-tab" data-toggle="tab"
                        data-target="#{{$prefix ?? ''}}ports">
                    <i class="fa fa-ship"></i> Ports
                </button>
            </li>
        </ul>
        <br>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="{{$prefix ?? ''}}airports" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="popup_lists">
                    @foreach($popular_locations as $l)
                        @if($l['type'] == 'Airports')
                            <a href="#" class="popular-location-item" data-lat="{{$l->map_lat}}"
                               data-lng="{{$l->map_lng}}" data-place-id="{{$l->map_place_id}}">
                                <i class="fa fa-plane"></i> <span>{{$l->name}}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="{{$prefix ?? ''}}hotels" role="tabpanel" aria-labelledby="profile-tab">
                <div class="popup_lists">
                    @foreach($popular_locations as $l)
                        @if($l['type'] == 'Hotels')
                            <a href="#" class="popular-location-item" data-lat="{{$l->map_lat}}"
                               data-lng="{{$l->map_lng}}" data-place-id="{{$l->map_place_id}}">
                                <i class="fa fa-hotel"></i> <span>{{$l->name}}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="{{$prefix ?? ''}}ports" role="tabpanel" aria-labelledby="contact-tab">
                <div class="popup_lists">
                    @foreach($popular_locations as $l)
                        @if($l['type'] == 'Ports')
                            <a href="#" class="popular-location-item" data-lat="{{$l->map_lat}}"
                               data-lng="{{$l->map_lng}}" data-place-id="{{$l->map_place_id}}">
                                <i class="fa fa-ship"></i> <span>{{$l->name}}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>


        <br>

        <div class="text-right">
            <button class="btn btn-primary btn-sm py-1 px-4 text-10"
                    onclick="$(this).closest('.popup_location').hide()">Close
            </button>
        </div>

    <!--        <div class="popup_lists">
            @foreach($popular_locations as $l)
        <a href="#" class="popular-location-item" data-lat="{{$l->map_lat}}" data-lng="{{$l->map_lng}}" data-place-id="{{$l->map_place_id}}">{{$l->name}}</a>
            @endforeach
        </div>-->
    </div>
</div>
