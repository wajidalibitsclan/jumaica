<?php
$popular_locations = \Modules\Location\Models\PopularLocation::query()->get();
?>
<form action="{{ route("car.search") }}" class="form bravo_form" method="get">
    <div id="car_hidden_map" style="display: none"></div>
    <input type="hidden" name="gmap_distance" value="{{request('gmap_distance')}}">
    <input type="hidden" name="gmap_duration" value="{{request('gmap_duration')}}">
    <div class="g-field-search">

        <div class="row">

            <div class="col-md-6 border-right">
                @include('Car::frontend.layouts.search-map.fields.location',['prefix'=>"pickup_",'title' => __("Where from?"),'title_input' => __("Enter your pickup location"),'show_popup_location'=>1,'name'=>'pick_up'])
            </div>
            <div class="col-md-6 border-right">
                @include('Car::frontend.layouts.search-map.fields.location',['prefix'=>"dropoff_",'title' => __("Where To?"),'title_input' => __("Enter your dropoff location"),'name'=>'drop_off'])
            </div>
        </div>
    </div>
    <div class="g-button-submit">
        <button class="btn btn-primary btn-search" type="submit">{{__("Search")}}</button>
    </div>
</form>

@push('js')
    <?php echo \App\Helpers\MapEngine::scripts() ?>
    <script>

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
        var mapEngine = new BravoMapEngine('car_hidden_map',{
            center:[{{setting_item('car_map_lat_default','0')}}, {{setting_item('car_map_lng_default','0')}} ],
            zoom:{{setting_item('car_map_zoom_default','6')}},
            disableScripts:true,
            autoCallRoute:true,
            currentDirection:typeof currentDirection != "undefined" ? currentDirection : {},
            ready: function (engineMap) {
                const options = {
                    componentRestrictions: { country: BC_MAP_COUNTRY_CODE },
                };
                engineMap.registerDirection('pick_up','drop_off',function (response,from_place,to_place) {

                    var leg = response.routes[ 0 ].legs[ 0 ];

                    $('input[name=gmap_distance]').val(leg.distance.value);
                    $('input[name=gmap_duration]').val(leg.duration.value);


                },function (place,mode){
                    switch (mode) {
                        case 'DEST':
                            $('#dropoff_filter .map_lat').val(place.geometry.location.lat());
                            $('#dropoff_filter .map_lng').val(place.geometry.location.lng());
                            $('#dropoff_filter .map_place_id').val(place.place_id);
                            break;
                        default:
                            $('#pickup_filter .map_lat').val(place.geometry.location.lat());
                            $('#pickup_filter .map_lng').val(place.geometry.location.lng());
                            $('#pickup_filter .map_place_id').val(place.place_id);
                            break;
                    }
                });

                const pickup_popup_location = $('.pickup_popup_location');
                const dropdoff_popup_location = $('.dropoff_popup_location');

                $('#pick_up').click(function (){

                    if(!$(this).val()){
                        pickup_popup_location.show();
                    }else {
                        pickup_popup_location.hide();
                    }
                }).keyup(function (e){
                    if (e.keyCode === 13) { e.preventDefault()}
                    if(!$(this).val()){
                        pickup_popup_location.show();
                    }else {
                        pickup_popup_location.hide();
                    }
                })
                $('#drop_off').click(function (){
                    if(!$(this).val()){
                        dropdoff_popup_location.show();
                    }else {
                        dropdoff_popup_location.hide();
                    }
                }).keyup(function (e){
                    if (e.keyCode === 13) { e.preventDefault()}
                    if(!$(this).val()){
                        dropdoff_popup_location.show();
                    }else {
                        dropdoff_popup_location.hide();
                    }
                })

                window.addEventListener('click', function(e){
                    if (!document.getElementById('pickup_filter').contains(e.target)){
                        pickup_popup_location.hide();
                    }
                    if (!document.getElementById('dropoff_filter').contains(e.target)){
                        dropdoff_popup_location.hide();
                    }
                });

                pickup_popup_location.find('.popular-location-item').click(function (e){
                    e.preventDefault();
                    $('#pickup_filter .map_lat').val($(this).data('lat'));
                    $('#pickup_filter .map_lng').val($(this).data('lng'));
                    $('#pickup_filter .map_place_id').val('');
                    pickup_popup_location.hide();
                    $('#pick_up').val($(this).find('span').html())

                    engineMap.options.currentDirection.from = {
                        lat:$(this).data('lat'),
                        lng:$(this).data('lng'),
                    }
                })

                dropdoff_popup_location.find('.popular-location-item').click(function (e){
                    e.preventDefault();
                    $('#dropoff_filter .map_lat').val($(this).data('lat'));
                    $('#dropoff_filter .map_lng').val($(this).data('lng'));
                    $('#dropoff_filter .map_place_id').val('');
                    dropdoff_popup_location.hide();
                    $('#drop_off').val($(this).find('span').html())
                    engineMap.options.currentDirection.to = {
                        lat:$(this).data('lat'),
                        lng:$(this).data('lng'),
                    }
                })
            }
        });



    </script>
@endpush
