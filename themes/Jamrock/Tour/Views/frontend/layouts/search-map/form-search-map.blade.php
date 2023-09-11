<div class="px-30px pt-30px">
    <div class="row ">
        <div class="col-md-10">
            <form action="{{url( app_get_locale(false,false,'/').config('tour.tour_route_prefix') )}}" class="form bravo_form d-flex justify-content-start" method="get" onsubmit="return false;">

                @php $tour_map_search_fields = setting_item_array('tour_map_search_fields');
                    $tour_map_search_fields = array_values(\Illuminate\Support\Arr::sort($tour_map_search_fields, function ($value) {
                        return $value['position'] ?? 0;
                    }));

                @endphp
                @if(!empty($tour_map_search_fields))
                    @foreach($tour_map_search_fields as $field)
                        @switch($field['field'])
                            @case ('location')
                                @include('Tour::frontend.layouts.search-map.fields.location')
                            @break
                            @case ('service_name')
                                @include('Tour::frontend.layouts.search-map.fields.service_name')
                            @break
                        @endswitch
                    @endforeach
                @endif
            </form>
        </div>
        <div class="col-md-2">
            <div class="box-count px-1">
                @if($rows->total() > 1)
                    {{ __(":count Tours Found",['count'=>$rows->total()]) }}
                @else
                    {{ __(":count Tour Found",['count'=>$rows->total()]) }}
                @endif
            </div>
        </div>
    </div>
</div>

