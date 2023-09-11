<div class="bravo-list-item <?php if(!$rows->count()): ?> not-found <?php endif; ?>">
    <?php if($rows->count()): ?>
        <div class="list-item">
            <div class="row">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6  mb-30px">
                        <?php echo $__env->make('Tour::frontend.layouts.search.loop-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="bravo-pagination">
            <?php echo e($rows->appends(array_merge(request()->query(),['_ajax'=>1]))->links()); ?>

        </div>
    <?php else: ?>
        <div class="not-found-box">
            <h3 class="n-title"><?php echo e(__("We couldn't find any tours.")); ?></h3>
            <p class="p-desc"><?php echo e(__("Try changing your filter criteria")); ?></p>
            
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Tour/Views/frontend/layouts/search-map/list-item.blade.php ENDPATH**/ ?>