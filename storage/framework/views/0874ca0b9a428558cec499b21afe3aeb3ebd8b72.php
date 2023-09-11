<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar"><?php echo e(__("Extra Combination")); ?></h1>
        </div>

        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        <?php if(!empty($rows)): ?>
                            <form method="post" action="<?php echo e(route('combination.admin.bulkedit')); ?>" class="filter-form filter-form-left d-flex justify-content-start">
                                <?php echo e(csrf_field()); ?>

                                <select name="action" class="form-control">
                                    <option value=""><?php echo e(__(" Bulk Action ")); ?></option>
                                    
                                    <option value="delete"><?php echo e(__(" Delete ")); ?></option>
                                </select>
                                <button data-confirm="<?php echo e(__("Do you want to delete?")); ?>" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button"><?php echo e(__('Apply')); ?></button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="col-left">
                        
                        <a href="<?php echo e(route('combination.admin.create')); ?>" class="btn btn-primary">Add new combination</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th><?php echo e(__("Combination")); ?></th>
                                    <th><?php echo e(__("Price")); ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if( count($rows) > 0): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="<?php echo e($row->id); ?>" class="check-item">
                                            <td>
                                                <?php $__currentLoopData = $row->option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if(\Themes\Jamrock\Booking\Models\Options::find($option)): ?>

                                                        <?php echo e(\Themes\Jamrock\Booking\Models\Options::find($option)->title); ?>

                                                    <?php endif; ?>

                                                    <?php if(!($loop->last)): ?>
                                                        -
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>

                                            <td>$<?php echo e(ucwords($row->price)); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?php echo e(route('combination.admin.edit', ['id' => $row->id])); ?>">Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5"><?php echo e(__("No data")); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/combination/index.blade.php ENDPATH**/ ?>