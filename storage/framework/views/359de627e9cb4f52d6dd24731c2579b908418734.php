<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar"><?php echo e(__("Extra")); ?></h1>
        </div>
        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        <?php if(!empty($rows)): ?>
                            <form method="post" action="<?php echo e(route('extra.admin.bulkedit')); ?>" class="filter-form filter-form-left d-flex justify-content-start">
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
                        
                        <a href="<?php echo e(route('extra.admin.create')); ?>" class="btn btn-primary">Add new extra</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th><?php echo e(__("Title")); ?></th>
                                    <th><?php echo e(__("Price")); ?></th>
                                    <th><?php echo e(__("Display Order")); ?></th>
                                    <th class="date d-none d-md-block"><?php echo e(__("Date")); ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if( count($rows) > 0): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="<?php echo e($row->id); ?>" class="check-item">
                                        <td class="title">
                                            <a href="<?php echo e(route('extra.admin.edit', $row->id)); ?>"><?php echo e($row->title); ?></a>
                                        </td>
                                        <td><?php echo e($row->display_order); ?></td>
                                        <td class="d-none d-md-block"><?php echo e(display_date($row->updated_at)); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?php echo e(route('extra.admin.edit', ['id' => $row->id])); ?>">Edit</a>
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
                            <?php echo e($rows->appends(request()->query())->links()); ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/extra/index.blade.php ENDPATH**/ ?>