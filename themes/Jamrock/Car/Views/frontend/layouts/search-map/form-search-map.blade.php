<?php
$popular_locations = \Modules\Location\Models\PopularLocation::query()->get();

$is_map = 1;
?>
<div class="px-30px pt-30px">
    <div class="row ">
        <div class="col-md-10">
            <form action="{{url( app_get_locale(false,false,'/').config('car.car_route_prefix') )}}" class="form bravo_form d-flex justify-content-start" method="get">
                <input type="hidden" name="_layout" value="{{request('_layout')}}">
                <input type="hidden" name="gmap_distance" value="{{request('gmap_distance')}}">
                <input type="hidden" name="gmap_duration" value="{{request('gmap_duration')}}">
                @include('Car::frontend.layouts.search-map.fields.location',['prefix'=>"pickup_",'title_input' => __("Enter your pickup location"),'show_popup_location'=>1,'name'=>'pick_up'])
                @include('Car::frontend.layouts.search-map.fields.location',['prefix'=>"dropoff_",'title_input' => __("Enter your dropoff location"),'show_popup_location'=>1,'name'=>'drop_off'])
            </form>
        </div>
        <div class="col-md-2 d-none d-md-block">
            <div class="box-count px-1">
                <span class="map-duration"></span>
                @if($rows->total() > 1)
                    {{ __(":count Cars Found",['count'=>$rows->total()]) }}
                @else
                    {{ __(":count Car Found",['count'=>$rows->total()]) }}
                @endif
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        var bc_current_url = '{{url('/car')}}';
        var currentDirection = {
            from:{
                lat:{{request('pickup_map_lat',0)}},
                lng:{{request('pickup_map_lng',0)}},
                place_id:'{{request('pickup_place_id')}}',
            },
            to:{
                lat:{{request('dropoff_map_lat',0)}},
                lng:{{request('dropoff_map_lng',0)}},
                place_id:'{{request('dropoff_place_id')}}',
            },
        }
    </script>
@endpush
