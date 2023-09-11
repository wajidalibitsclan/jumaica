<div class="bravo-list-vendor">
    <div class="container">
        <?php if($title): ?>
            <div class="title">
                <?php echo e($title); ?>

                <?php if(!empty($desc)): ?>
                    <div class="sub-title">
                        <?php echo e($desc); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="list-item">
            <div class="row">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-<?php echo e($col ?? 3); ?> col-md-6 mb-4">
                        <div class="item">
                            <div class="image">
                                <?php if($avatar_url = $row->getAvatarUrl()): ?>
                                    <img src="<?php echo e($avatar_url); ?>" alt="<?php echo e($row->getDisplayName()); ?>" class="w-100">
                                <?php endif; ?>
                            </div>
                            <h4 class="name"><?php echo e($row->getDisplayName()); ?>

                                <?php if($row->is_verified): ?>
                                    <img data-toggle="tooltip" data-placement="top" src="<?php echo e(asset('icon/ico-vefified-1.svg')); ?>" title="<?php echo e(__("Verified")); ?>" alt="ico-vefified-1">
                                <?php else: ?>
                                    <img data-toggle="tooltip" data-placement="top" src="<?php echo e(asset('icon/ico-not-vefified-1.svg')); ?>" title="<?php echo e(__("Not verified")); ?>" alt="ico-vefified-1">
                                <?php endif; ?>
                            </h4>
                            <span class="designation"><?php echo e(__("Member Since :time",["time"=> date("M Y",strtotime($row->created_at))])); ?></span>
                            <?php if(setting_item('vendor_show_email') or setting_item('vendor_show_phone')): ?>
                                <?php if(setting_item('vendor_show_email')): ?>
                                    <div class="text">
                                        <?php echo e($row->email); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(setting_item('vendor_show_phone')): ?>
                                    <div class="text">
                                        <?php echo e($row->phone); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($city = $row->city): ?>
                                <div class="location">
                                    <i class="fa fa-location-arrow"></i> <?php echo e($city); ?>, <?php echo e($row->country); ?>

                                </div>
                            <?php endif; ?>
                            <a href="<?php echo e(route('user.profile',['id'=>$row->user_name ?? $row->id])); ?>" class="btn btn-primary">
                                <span class="btn-title"><?php echo e(__("View Profile")); ?></span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Base/Vendor/Views/frontend/blocks/list-vendor/index.blade.php ENDPATH**/ ?>