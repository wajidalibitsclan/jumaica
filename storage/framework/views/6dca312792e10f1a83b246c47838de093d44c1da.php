<?php
    $translation = $row->translateOrOrigin(app()->getLocale());
?>
<div class="item-tour jr-item-tour <?php echo e($wrap_class ?? ''); ?>">
    <div class="thumb-image">
        <?php if($row->discount_percent): ?>
            <div class="sale_info"><?php echo e($row->discount_percent); ?></div>
        <?php endif; ?>
        <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
            <?php if($row->image_url): ?>
                <?php if(!empty($disable_lazyload)): ?>
                    <img src="<?php echo e($row->image_url); ?>" class="img-responsive" alt="<?php echo e($location->name ?? ''); ?>">
                <?php else: ?>
                    <?php echo get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]); ?>

                <?php endif; ?>
            <?php endif; ?>
        </a>
        <div class="service-wishlist <?php echo e($row->isWishList()); ?>" data-id="<?php echo e($row->id); ?>" data-type="<?php echo e($row->type); ?>">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="item-tour-card">
        <div class="location_card d-flex justify-content-start align-items-center">
            <div class="location">
                <?php if(!empty($row->location->name)): ?>
                    <?php $location =  $row->location->translateOrOrigin(app()->getLocale()) ?>
                    <svg class="field-icon fa" width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.00001 0.25C5.1773 0.25215 3.42987 0.977169 2.14102 2.26602C0.852176 3.55486 0.127158 5.3023 0.125007 7.125C0.122824 8.61452 0.60937 10.0636 1.51001 11.25C1.51001 11.25 1.69751 11.4969 1.72813 11.5325L7.00001 17.75L12.2744 11.5294C12.3019 11.4963 12.49 11.25 12.49 11.25L12.4906 11.2481C13.3908 10.0623 13.8771 8.61383 13.875 7.125C13.8729 5.3023 13.1478 3.55486 11.859 2.26602C10.5701 0.977169 8.82271 0.25215 7.00001 0.25ZM7.00001 9.625C6.50555 9.625 6.0222 9.47838 5.61108 9.20367C5.19996 8.92897 4.87953 8.53852 4.69031 8.08171C4.50109 7.62489 4.45158 7.12223 4.54804 6.63727C4.64451 6.15232 4.88261 5.70686 5.23224 5.35723C5.58187 5.0076 6.02733 4.7695 6.51228 4.67304C6.99723 4.57657 7.4999 4.62608 7.95672 4.8153C8.41353 5.00452 8.80398 5.32495 9.07868 5.73607C9.35338 6.1472 9.50001 6.63055 9.50001 7.125C9.49918 7.78779 9.23552 8.42319 8.76686 8.89185C8.2982 9.36052 7.66279 9.62417 7.00001 9.625Z" fill="currentColor"></path>
                    </svg>
                    <?php echo e($location->name ?? ''); ?>

                <?php endif; ?>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        </div>
        <div class="item-title tour-card-title">
            <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
                <i class="fa fa-tag"></i>  <?php echo clean($translation->title); ?>

            </a>
        </div>
    </div>


    <?php if(setting_item('tour_enable_review')): ?>
    <?php
    $reviewData = $row->getScoreReview();
    $score_total = $reviewData['score_total'];
    ?>
    <div class="service-review tour-review-<?php echo e($score_total); ?>">
        <div class="list-star">
            <ul class="booking-item-rating-stars">
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
                <li><i class="fa fa-star-o"></i></li>
            </ul>
            <div class="booking-item-rating-stars-active" style="width: <?php echo e($score_total * 2 * 10 ?? 0); ?>%">
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
            <?php if($reviewData['total_review'] > 1): ?>
                <?php echo e(__(":number Reviews",["number"=>$reviewData['total_review'] ])); ?>

            <?php else: ?>
                <?php echo e(__(":number Review",["number"=>$reviewData['total_review'] ])); ?>

            <?php endif; ?>
        </span>
    </div>
    <?php endif; ?>

</div>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Tour/Views/frontend/layouts/search/loop-grid.blade.php ENDPATH**/ ?>