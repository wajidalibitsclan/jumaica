<div class="g-header">
    <div class="left">
        <h1><?php echo clean($translation->title); ?></h1>
        <?php if($translation->address): ?>
            <p class="address"><i class="fa fa-map-marker"></i>
                <?php echo e($translation->address); ?>

            </p>
        <?php endif; ?>
    </div>
    <div class="right">
        <?php if(setting_item('tour_enable_review') and $review_score): ?>
            <div class="review-score">
                <div class="head">
                    <div class="left">
                        <span class="head-rating"><?php echo e($review_score['score_text']); ?></span>
                        <span class="text-rating"><?php echo e(__("from :number reviews",['number'=>$review_score['total_review']])); ?></span>
                    </div>
                    <div class="score">
                        <?php echo e($review_score['score_total']); ?><span>/5</span>
                    </div>
                </div>
                <div class="foot">
                    <?php echo e(__(":number% of guests recommend",['number'=>$row->recommend_percent])); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if(!empty($row->duration) or !empty($row->category_tour->name) or !empty($row->max_people) or !empty($row->location->name)): ?>
    <div class="g-tour-feature">
    <div class="row">

        <?php if(!empty($row->category_tour->name)): ?>
            <?php $cat =  $row->category_tour->translateOrOrigin(app()->getLocale()) ?>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-beach"></i>
                    </div>
                    <div class="info">
                        <h4 class="name"><?php echo e(__("Tour Type")); ?></h4>
                        <p class="value">
                            <?php echo e($cat->name ?? ''); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        


            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-car-alt-4"></i>
                    </div>
                    <div class="info">
                        <h4 class="name"><?php echo e(__("Transport Type")); ?></h4>
                        <p class="value">
                            Private Transport
                        </p>
                    </div>
                </div>
            </div>

        <?php if(!empty($row->location->name)): ?>
                <?php $location =  $row->location->translateOrOrigin(app()->getLocale()) ?>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-island-alt"></i>
                    </div>
                    <div class="info">
                        <h4 class="name"><?php echo e(__("Location")); ?></h4>
                        <p class="value">
                            <?php echo e($location->name ?? ''); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

            <div class="col-6 col-lg-3 col-X-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-wall-clock"></i>
                    </div>
                    <div class="info">
                        <h4 class="name"><?php echo e(__("Duration")); ?></h4>
                        <p class="value">
                            <?php echo e($row->duration_text); ?>

                        </p>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php endif; ?>
<?php if($row->getGallery()): ?>
    <div class="g-gallery">
        <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            <?php $__currentLoopData = $row->getGallery(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($item['large']); ?>" data-thumb="<?php echo e($item['thumb']); ?>" data-alt="<?php echo e(__("Gallery")); ?>"></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="social">
            <div class="social-share">
                <span class="social-icon">
                    <i class="icofont-share"></i>
                </span>
                <ul class="share-wrapper">
                    <li>
                        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>" target="_blank" rel="noopener" original-title="<?php echo e(__("Facebook")); ?>">
                            <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="https://twitter.com/share?url=<?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>" target="_blank" rel="noopener" original-title="<?php echo e(__("Twitter")); ?>">
                            <i class="fa fa-twitter fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="copy_cilpboard" href="javascript:;" onclick="myFunction()">
                            <input type="hidden" value="<?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>" id="myInput">
                            <i class="icofont-ui-copy fa-lg"></i>
                        </a>
                    </li>

                    <script>

                        function myFunction() {
                            var $temp = $("<input>");
                            $("body").append($temp);
                            $temp.val('<?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>').select();
                            document.execCommand("copy");
                            $temp.remove();

                        }
                    </script>
                    <li>
                        <a class="twitter" href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site <?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>."
                           title="Share by Email">
                            <i class="fa fa-envelope fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="whatsapp://send?text=<?php echo e($row->getDetailUrl()); ?>&amp;title=<?php echo e($translation->title); ?>" data-action="share/whatsapp/share" original-title="<?php echo e(__("WhatsApp")); ?>">
                            <i class="icofont-chat fa-lg"></i>
                        </a>

                    </li>
                </ul>
            </div>
            <div class="service-wishlist <?php echo e($row->isWishList()); ?>" data-id="<?php echo e($row->id); ?>" data-type="<?php echo e($row->type); ?>">
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if($translation->content): ?>
    <div class="g-overview">
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
<?php endif; ?>
<?php echo $__env->make('Tour::frontend.layouts.details.tour-include-exclude', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Tour::frontend.layouts.details.tour-itinerary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Tour::frontend.layouts.details.tour-attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Tour::frontend.layouts.details.tour-faqs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if ($__env->exists("Hotel::frontend.layouts.details.hotel-surrounding")) echo $__env->make("Hotel::frontend.layouts.details.hotel-surrounding", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if($row->map_lat && $row->map_lng): ?>
<div class="g-location">
    <div class="location-title">
        <h3><?php echo e(__("Tour Location")); ?></h3>
        <?php if($translation->address): ?>
            <div class="address">
                <i class="icofont-location-arrow"></i>
                <?php echo e($translation->address); ?>

            </div>
        <?php endif; ?>
    </div>

    <div class="location-map">
        <div id="map_content"></div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/BC/Tour/Views/frontend/layouts/details/tour-detail.blade.php ENDPATH**/ ?>