<?php
    $translation = $row->translateOrOrigin(app()->getLocale());
?>
<div class=" item-loop p-3 <?php echo e($wrap_class ?? ''); ?> bg-white jr-item-tour h-full d-flex flex-column">

    <div class="d-flex flex-grow-1">



        <div class="flex-grow-1 text-center px-3 e-img">

            <div class="text-left">
                <a style="font-size: 18px" class=" font-400 text-blue hover:text-none" <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
                    <?php echo clean($translation->title); ?>

                </a>
            </div>

            <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
                <?php if($row->image_url): ?>
                    <?php if(!empty($disable_lazyload)): ?>
                        <img src="<?php echo e($row->image_url); ?>" class="img-responsive" alt="">
                    <?php else: ?>
                        <?php echo get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]); ?>

                    <?php endif; ?>
                <?php endif; ?>
            </a>
<!--            <span class="text-13 d-block mt-2">Or Similar</span>-->
        </div>
        <div class="flex-shrink-0  text-center">
            <div class="extra_box mb-2">
                <div>
                    <div class="text-10">Up To</div>
                    <div class="text-14 font-weight-bold">
                        <?php echo e($row->passenger); ?>

                        <img src="<?php echo e(asset('themes/jamrock/images/image4.png')); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="extra_box mb-2">
                <div>
                    <div class="text-10">Up To</div>
                    <div class="text-14 font-weight-bold" style="margin-top: 3px;">
                        <?php echo e($row->baggage); ?>

                        <img style="max-width: 27px !important;" src="<?php echo e(asset('themes/jamrock/images/image6.png')); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="extra_box mb-2 blue">
                <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
                    <div class="text-15">More</div>
                    <div class="text-14 font-weight-bold">
                        <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>" alt="">
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php
    $distance = request('gmap_distance');
    $distance = $distance/1000;
    ?>

    <div class="row">
        <div class="col-6">
            <div class="price_box">
                <p class="text-center">
                    <?php if(isset($row->prices)): ?>
                    <?php $__currentLoopData = $row->prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($price->from <= $distance && $distance <= $price->to): ?>
                                <?php if($price->oneway_discount): ?>
                                    <small>$<?php echo e($price->oneway_price); ?></small>
                                    $<?php echo e($price->oneway_discount); ?>

                                <?php else: ?>
                                    $<?php echo e($price->oneway_price); ?>

                                <?php endif; ?>

                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                </p>
                <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>&trip_type=oneway">Oneway Trip</a>
            </div>
        </div>
        <div class="col-6">
            <div class="price_box">
                <p class="text-center">
                    <?php if(isset($row->prices)): ?>
                        <?php $__currentLoopData = $row->prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($price->from <= $distance && $distance <= $price->to): ?>
                                <?php if($price->roundtrip_discount): ?>
                                    <small>$<?php echo e($price->roundtrip_price); ?></small>
                                    $<?php echo e($price->roundtrip_discount); ?>

                                <?php else: ?>
                                    $<?php echo e($price->roundtrip_price); ?>

                                <?php endif; ?>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </p>

                <a <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl()); ?>&trip_type=round">Round Trip</a>
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
                    <span class="onsale text-red text-decoration-line-through"><?php echo e($row->display_sale_price); ?></span>
                </div>
                <div class="mr-5px">
                    <div><?php echo e(__("from")); ?></div>
                    <div class="text-price text-blue-800 text-14 font-500"> : <?php echo e($row->price ? format_money($row->price) : $row->display_price); ?></div>
                </div>
                <div>
                    <a class="btn btn-primary" <?php if(!empty($blank)): ?> target="_blank" <?php endif; ?> href="<?php echo e($row->getDetailUrl($include_param ?? true)); ?>">
                        <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.6123 1.50977L6.78086 6.67832L1.6123 11.8469" stroke="white" stroke-width="2.00999" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>-->

</div>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Car/Views/frontend/layouts/search/loop-grid.blade.php ENDPATH**/ ?>