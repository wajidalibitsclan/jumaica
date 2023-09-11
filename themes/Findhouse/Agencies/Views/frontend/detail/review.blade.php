<?php
$review = app(\Themes\Findhouse\Review\Models\Review::class);
$reviewData = $review::getTotalViewAndRateAvg($row['id'], $review_service_type);
?>

<div class="product_single_content">
    <div class="mbp_pagination_comments">
        <ul class="total_reivew_view">
            <li class="list-inline-item sub_titles">
                @if($reviewData['total_review'] > 1)
                    {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                @else
                    {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                @endif
            </li>
            <li class="list-inline-item">
                <ul class="star_list">
                    <ul>
                        @for( $i = 0 ; $i < 5 ; $i++ )
                            @if($i < (int)$reviewData['score_total'])
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                            @else
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star-o"></i></a></li>
                            @endif
                        @endfor
                    </ul>
                </ul>
            </li>
            <li class="list-inline-item avrg_review">{{ __("(:rate_agv out of 5)",["rate_agv"=>$reviewData['score_total'] ]) }}</li>
            <li class="list-inline-item write_review">{{ __("Write a Review") }}</li>
        </ul>
        @if($review_list)
            @foreach($review_list as $item)
                @php $userInfo = $item->author; @endphp
                <div class="mbp_first media">
                    @if($avatar_url = $userInfo->getAvatarUrl())
                        <img class="mr-3" src="{{$avatar_url}}" alt="{{$userInfo->getDisplayName()}}">
                    @else
                        <span class="avatar-text">{{ucfirst($userInfo->getDisplayName()[0])}}</span>
                    @endif
                    <div class="media-body">
                        <h4 class="sub_title mt-0">{{$userInfo->getDisplayName()}}
                            <div class="sspd_review dif">
                                @if($item->rate_number)
                                    <ul class="ml10">
                                        @for( $i = 0 ; $i < 5 ; $i++ )
                                            @if($i < $item->rate_number)
                                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            @else
                                                <li class="list-inline-item"><a href="#"><i class="fa fa-star-o"></i></a></li>
                                            @endif
                                        @endfor
                                    </ul>
                                @endif
                            </div>
                        </h4>
                        <a class="sspd_postdate fz14" href="#">{{display_datetime($item->created_at)}}</a>
                        <p class="mt10">{{$item->content}}</p>
                    </div>
                </div>
                <div class="custom_hr"></div>
            @endforeach
        @endif
        <div class="mbp_comment_form style2">
            <h4>{{__("Write a review")}}</h4>
            @include('admin.message')
            <form class="comments_form review-form" id="review-form" action="{{ route('review.store') }}" method="post">
                @csrf

                <div class="form-group review-items sspd_review">
                    <div class="item">
                        <input class="review_rate" type="hidden" name="review_rate">
                        <div class="rates">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <label class="review_rating_para">{{ __('Your Rating & Review') }}</label>
                    </div>
                </div>
                <div class="form-group">
                    <input  type="text" class="form-control" id="review_title" name="review_title"
                           aria-describedby="textHelp" required placeholder="Review Title">
                </div>
                <div class="form-group">
                    <textarea minlength="10" class="form-control" required name="review_content" rows="12" placeholder="Your Review"></textarea>
                </div>
                <input type="hidden" name="review_service_id" value="{{ $row['id'] }}">
                <input type="hidden" name="review_service_type" value="{{ $review_service_type }}">
                <button type="submit" class="btn btn-thm">{{__('Submit Review')}} <span class="flaticon-right-arrow-1"></span>
                </button>
            </form>
        </div>
    </div>
</div>
