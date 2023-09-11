@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class=" item-loop  {{$wrap_class ?? ''}} bg-white jr-item-tour h-full d-flex flex-column">

    <div class="d-flex flex-grow-1">



        <div class="flex-grow-1 text-center  e-img px-1">

            <div class="text-left px-3">
                <a style="font-size: 18px" class=" font-400 text-blue hover:text-none" @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
                    {!! clean($translation->title) !!}
                </a>
            </div>

            <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
                @if($row->image_url)
                    @if(!empty($disable_lazyload))
                        <img src="{{$row->image_url}}" class="img-responsive" alt="">
                    @else
                        {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                    @endif
                @endif
            </a>
<!--            <span class="text-13 d-block mt-2">Or Similar</span>-->
        </div>
        <div class="flex-shrink-0  text-center">
            <div class="extra_box mb-2">
                <div>
                    <div class="text-10">Up To</div>
                    <div class="text-14 font-weight-bold">
                        {{$row->passenger}}
                        <img src="{{asset('themes/jamrock/images/new-image4.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="extra_box mb-2">
                <div>
                    <div class="text-10">Up To</div>
                    <div class="text-14 font-weight-bold" style="margin-top: 3px;">
                        {{$row->baggage}}
                        <img style="max-width: 27px !important;" src="{{asset('themes/jamrock/images/new-image6.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="extra_box mb-2 blue">
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
                    <div class="text-12">More<br>info</div>
{{--                    <div class="text-14 font-weight-bold">--}}
{{--                        <img src="{{asset('themes/jamrock/images/image20.png')}}" alt="">--}}
{{--                    </div>--}}
                </a>
            </div>
        </div>
    </div>

    @php
    $distance = request('gmap_distance');
    $distance = $distance/1000;
    @endphp

    <div class="row px-4">
        <div class="col-6">
            <div class="price_box">
                <p class="text-center">
                    @if(isset($row->prices))
                    @foreach($row->prices as $price)
                        @if ($price->from <= $distance && $distance <= $price->to)
                                @if($price->oneway_discount)
                                    <small>${{$price->oneway_price}}</small>
                                    ${{$price->oneway_discount}}
                                @else
                                    ${{$price->oneway_price}}
                                @endif

                            @break
                        @endif
                    @endforeach
                        @endif
                </p>
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}&trip_type=oneway">
                    <p style="color:#000;">Oneway Trip</p>
                    <span style="color:#9CC0FA;">SELECT</span>
                </a>
            </div>
        </div>
        <div class="col-6">
            <div class="price_box">
                <p class="text-center">
                    @if(isset($row->prices))
                        @foreach($row->prices as $price)
                            @if ($price->from <= $distance && $distance <= $price->to)
                                @if($price->roundtrip_discount)
                                    <small>${{$price->roundtrip_price}}</small>
                                    ${{$price->roundtrip_discount}}
                                @else
                                    ${{$price->roundtrip_price}}
                                @endif
                                @break
                            @endif
                        @endforeach
                    @endif
                </p>

                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}&trip_type=round">
                    <div class="text-14 font-weight-bold">
                        <img style="float: right;width: 15px;" src="{{asset('themes/jamrock/images/image20.png')}}" alt="">
                    </div>
                    <p style="color:#000;">Round Trip</p>
                    <span style="color:#9CC0FA;">SELECT</span>
                </a>
            </div>
        </div>
    </div>
<!--    <div class="flex-shrink-0 more-info">
        <hr>
        <div class="d-flex justify-content-between align-items-end">
            <div class="text-12 flex-shrink-0">
                <div><i class="fa fa-check text-success"></i> Free cancellation</div>
                <div><i class="fa fa-check text-success"></i> Free waiting time</div>
            </div>
            <div class="flx-grow-1 d-flex justify-content-between align-items-end">
                <div class="mr-5px">
                    <span class="onsale text-red text-decoration-line-through">{{ $row->display_sale_price }}</span>
                </div>
                <div class="mr-5px">
                    <div>{{__("from")}}</div>
                    <div class="text-price text-blue-800 text-14 font-500"> : {{ $row->price ? format_money($row->price) : $row->display_price }}</div>
                </div>
                <div>
                    <a class="btn btn-primary" @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
                        <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.6123 1.50977L6.78086 6.67832L1.6123 11.8469" stroke="white" stroke-width="2.00999" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>-->

</div>
