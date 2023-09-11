@foreach($userProperties as $userProperty)
    <div class="col-lg-12">
        {{-- {{ dd($row->propertyCategory->name) }} --}}
        <div class="feat_property list style2 hvr-bxshd bdrrn mb10 mt20">
            @if(get_file_url($userProperty->image_id,'thumb'))
                <div class="thumb">
                    <img class="img-whp" src="{{get_file_url($userProperty->image_id,'thumb')}}">
                    <div class="thmb_cntnt">
                        <ul class="icon mb0">
                            <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                            <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="details">
                <div class="tc_content">
                    <div class="dtls_headr">
                        <ul class="tag">
                            <li class="list-inline-item"><a href="#">{{ $userProperty->property_type == 1 ? 'For buy' : ($userProperty->property_type == 2 ? 'For rent' : '')  }}</a></li>
                            <li class="list-inline-item"><a href="#">{{ __('Featured') }}</a></li>
                        </ul>
                        <a class="fp_price" href="#">${{ $userProperty->price }}<small>{{ __('/mo') }}</small></a>
                    </div>
                    <p class="text-thm">{{ $userProperty->nameCategory }}</p>
                    <a href="{{$userProperty->getDetailUrl()}}"><h4>{{ $userProperty->title }}</h4></a>
                    <p><span class="flaticon-placeholder"></span>{{ $userProperty->address }}</p>
                    <ul class="prop_details mb0">
                        <li class="list-inline-item"><a href="#">{{ __('Beds:') }} {{ $userProperty->bed }}</a></li>
                        <li class="list-inline-item"><a href="#">{{ __('Baths:') }} {{ $userProperty->bathroom }}</a></li>
                        <li class="list-inline-item"><a href="#">{{ __('Sq:') }} {!! size_unit_format($userProperty->square) !!}</a></li>
                    </ul>
                </div>
                <div class="fp_footer">
                    <ul class="fp_meta float-left mb0">
                        <li class="list-inline-item"><a href="#"><img src="{{ $row->getAvatarUrl() }}"></a></li>
                        <li class="list-inline-item"><a href="#">{{ $row->first_name . ' ' . $row->last_name }}</a></li>
                    </ul>
                    <div class="fp_pdate float-right">{{ display_datetime($userProperty->created_at) }}</div>
                </div>
            </div>
        </div>
    </div>
@endforeach