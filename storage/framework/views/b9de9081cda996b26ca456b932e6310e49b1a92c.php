<?php
    $translation = $row->translateOrOrigin(app()->getLocale());
?>
<div class="item">
    <?php if($row->is_featured == "1"): ?>
        <div class="featured">
            <?php echo e(__("Featured")); ?>

        </div>
    <?php endif; ?>
    <div class="header-thumb">
        <?php if($row->discount_percent): ?>
            <div class="sale_info"><?php echo e($row->discount_percent); ?></div>
        <?php endif; ?>
        <?php if($row->image_url): ?>
            <?php if(!empty($disable_lazyload)): ?>
                <img src="<?php echo e($row->image_url); ?>" class="img-responsive" alt="<?php echo e($location->name ?? ''); ?>">
            <?php else: ?>
                <?php echo get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]); ?>

            <?php endif; ?>
        <?php endif; ?>
        <a class="st-btn st-btn-primary tour-book-now" href="<?php echo e($row->getDetailUrl()); ?>"><?php echo e(__("Book now")); ?></a>
        <div class="service-wishlist <?php echo e($row->isWishList()); ?>" data-id="<?php echo e($row->id); ?>" data-type="<?php echo e($row->type); ?>">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="caption clear">
        <div class="title-address" style="width: 100%">
            <h3 class="title"><a href="<?php echo e($row->getDetailUrl()); ?>"> <?php echo clean($translation->title); ?> </a></h3>

            <div class="d-flex justify-content-start align-items-center">


            <p class="duration">
                <span>
                    <?php echo e(duration_format($row->duration)); ?>

                </span>
                <?php if(!empty($row->location->name)): ?>
                    -
                    <i>
                        <?php $location =  $row->location->translateOrOrigin(app()->getLocale()) ?>
                        <?php echo e($location->name ?? ''); ?>

                    </i>
                <?php endif; ?>
            </p>

            <div class="g-price ml-auto">
                <div class="price pt-0">
                    <span class="onsale" style="position: unset"><?php echo e($row->display_sale_price); ?></span>
                    <span class="text-price"><?php echo e($row->display_price); ?></span>
                </div>
            </div>
            </div>
        </div>

    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Tour/Views/frontend/blocks/list-tour/loop-box-shadow.blade.php ENDPATH**/ ?>