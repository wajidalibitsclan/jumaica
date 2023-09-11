<div class="g-header">
    <div class="left">
        <h1>{!! clean($translation->title) !!}</h1>
        @if($translation->address)
            <p class="address"><i class="fa fa-map-marker"></i>
                {{$translation->address}}
            </p>
        @endif
    </div>
    <div class="right">
        @if(setting_item('tour_enable_review') and $review_score)
            <div class="review-score">
                <div class="head">
                    <div class="left">
                        <span class="head-rating">{{$review_score['score_text']}}</span>
                        <span class="text-rating">{{__("from :number reviews",['number'=>$review_score['total_review']])}}</span>
                    </div>
                    <div class="score">
                        {{$review_score['score_total']}}<span>/5</span>
                    </div>
                </div>
                <div class="foot">
                    {{__(":number% of guests recommend",['number'=>$row->recommend_percent])}}
                </div>
            </div>
        @endif
    </div>
</div>
@if(!empty($row->duration) or !empty($row->category_tour->name) or !empty($row->max_people) or !empty($row->location->name))
    <div class="g-tour-feature">
    <div class="row">

        @if(!empty($row->category_tour->name))
            @php $cat =  $row->category_tour->translateOrOrigin(app()->getLocale()) @endphp
            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-beach"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Tour Type")}}</h4>
                        <p class="value">
                            {{$cat->name ?? ''}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        {{--@if($row->max_people)
            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-travelling"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Group Size")}}</h4>
                        <p class="value">
                            @if($row->max_people > 1)
                                {{ __(":number persons",array('number'=>$row->max_people)) }}
                            @else
                                {{ __(":number person",array('number'=>$row->max_people)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif--}}


            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-car-alt-4"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Transport Type")}}</h4>
                        <p class="value">
                            Private Transport
                        </p>
                    </div>
                </div>
            </div>

        @if(!empty($row->location->name))
                @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-island-alt"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Location")}}</h4>
                        <p class="value">
                            {{$location->name ?? ''}}
                        </p>
                    </div>
                </div>
            </div>
        @endif

            <div class="col-6 col-lg-3 col-X-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-wall-clock"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Duration")}}</h4>
                        <p class="value">
                            {{$row->duration_text}}
                        </p>
                    </div>
                </div>
            </div>
    </div>
</div>
@endif
@if($row->getGallery())
    <div class="g-gallery">
        <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            @foreach($row->getGallery() as $key=>$item)
                <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}" data-alt="{{ __("Gallery") }}"></a>
            @endforeach
        </div>
        <div class="social">
            <div class="social-share">
                <span class="social-icon">
                    <i class="icofont-share"></i>
                </span>
                <ul class="share-wrapper">
                    <li>
                        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                            <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                            <i class="fa fa-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="copy_cilpboard" href="javascript:;" onclick="myFunction()">
                            <input type="hidden" value="{{$row->getDetailUrl()}}&amp;title={{$translation->title}}" id="myInput">
                            <i class="icofont-ui-copy fa-lg"></i>
                        </a>
                    </li>

                    <script>

                        function myFunction() {
                            var $temp = $("<input>");
                            $("body").append($temp);
                            $temp.val('{{$row->getDetailUrl()}}&amp;title={{$translation->title}}').select();
                            document.execCommand("copy");
                            $temp.remove();

                        }
                    </script>
                    <li>
                        <a class="twitter" href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site {{$row->getDetailUrl()}}&amp;title={{$translation->title}}."
                           title="Share by Email">
                            <i class="fa fa-envelope fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="whatsapp://send?text={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" data-action="share/whatsapp/share" original-title="{{__("WhatsApp")}}">
                            <i class="icofont-chat fa-lg"></i>
                        </a>

                    </li>
                </ul>
            </div>
            <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
@endif
@if($translation->content)
    <div class="g-overview">
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif
@include('Tour::frontend.layouts.details.tour-include-exclude')
@include('Tour::frontend.layouts.details.tour-itinerary')
@include('Tour::frontend.layouts.details.tour-attributes')
@include('Tour::frontend.layouts.details.tour-faqs')
@includeIf("Hotel::frontend.layouts.details.hotel-surrounding")

@if($row->map_lat && $row->map_lng)
<div class="g-location">
    <div class="location-title">
        <h3>{{__("Tour Location")}}</h3>
        @if($translation->address)
            <div class="address">
                <i class="icofont-location-arrow"></i>
                {{$translation->address}}
            </div>
        @endif
    </div>

    <div class="location-map">
        <div id="map_content"></div>
    </div>
</div>
@endif
