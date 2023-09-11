<div class="bravo-more-book-mobile">
    <div class="container">
        <div class="left">
                <a class="btn btn-secondary" onclick="history.back()">{{__("back")}}</a>
        </div>
        <div class="left">
            <div class="g-price px-2 mx-1">
                <div class="prefix">
                    <span class="fr_text">{{__("from")}}</span>
                </div>
                <div class="price">
                    <span class="onsale">{{ $row->display_sale_price }}</span>
                    <span class="text-price">{{ $row->display_price }}</span>
                </div>
            </div>

            @if(setting_item('car_enable_review'))
            <?php
            $reviewData = $row->getScoreReview();
            $score_total = $reviewData['score_total'];
            ?>
            <div class="service-review tour-review-{{$score_total}}">
                <div class="list-star">
                    <ul class="booking-item-rating-stars">
                        <li><i class="fa fa-star-o"></i></li>
                        <li><i class="fa fa-star-o"></i></li>
                        <li><i class="fa fa-star-o"></i></li>
                        <li><i class="fa fa-star-o"></i></li>
                        <li><i class="fa fa-star-o"></i></li>
                    </ul>
                    <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                        <ul class="booking-item-rating-stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <span class="review">
                        @if($reviewData['total_review'] > 1)
                        {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                    @else
                        {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                    @endif
                    </span>
            </div>
            @endif
        </div>
        <div class="left">
            @if($row->getBookingEnquiryType() === "book")
                <a class="btn btn-primary bravo-button-book-mobile" id="myCheck" >{{__("Book")}}</a>
            @else
                <a class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">{{__("Contact")}}</a>
            @endif
        </div>
    </div>
</div>

<script defer>
   if(screen.width < 768) {

       setTimeout(function () {
           var url_string = window.location.href; // www.test.com?filename=test
           var url = new URL(url_string);
           var paramValue = url.searchParams.get("booking_form");
           if (paramValue === 'true') {
               element = document.getElementById("myCheck");
               element.click();
           }
       }, 1000)
   }
</script>
