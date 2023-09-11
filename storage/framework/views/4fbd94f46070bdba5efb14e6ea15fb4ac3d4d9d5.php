<li class="d-flex flex-column border-0 mb-0">
    <div class="section-coupon-form">
        <?php if(in_array($booking->status , ['draft'])): ?>
            <div class="input-group group-form mb-3">
                <input type="text" class="form-control" name="coupon_code" placeholder="<?php echo e(__("Coupon code")); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary bravo_apply_coupon" type="button">
                        <?php echo e(__("Apply")); ?>

                        <i class="fa fa-spin fa-spinner d-none"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php if(!empty($booking->coupons)): ?>
            <ul class="p-0 mb-3 list-coupons">
                <?php $__currentLoopData = $booking->coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="item">
                        <div class="label">
                            <?php echo e($item->coupon_data['code']); ?>

                            <i data-toggle="tooltip" data-placement="top" class="icofont-info-circle" data-original-title="<?php echo e($item->coupon_data['name']); ?>"></i>
                        </div>
                        <div class="val">
                            -<?php echo e(format_money( $item->coupon_amount )); ?>

                            <?php if(in_array($booking->status , ['draft'])): ?>
                                <a href="#" data-code="<?php echo e($item->coupon_code); ?>" class="text-danger text-decoration-none bravo_remove_coupon">
                                <?php echo e(__("[Remove]")); ?>

                                <i class="fa fa-spin fa-spinner d-none"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <div class="message alert-text mt-2"></div>
    </div>
</li><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Base/Coupon/Views/frontend/booking/checkout-coupon.blade.php ENDPATH**/ ?>