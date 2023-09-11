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
        <?php if($style_list === "normal"): ?>
            <div class="row">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <?php echo $__env->make('Tour::frontend.layouts.search.loop-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <?php if($style_list === "carousel"): ?>
            <div class="owl-carousel">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('Tour::frontend.layouts.search.loop-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
                <div class="show_all">
                    <a class="btn btn-primary" href="<?php echo e(route('tour.search')); ?>"> <?php echo e(__("All Tours")); ?></a>
                </div>
        <?php endif; ?>
        <?php if($style_list === "box_shadow"): ?>
            <div class="row row-eq-height">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-<?php echo e($col ?? 4); ?> col-md-6 col-item">
                        <?php echo $__env->make('Tour::frontend.blocks.list-tour.loop-box-shadow', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Tour/Views/frontend/blocks/list-tour/style-normal.blade.php ENDPATH**/ ?>