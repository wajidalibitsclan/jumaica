<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar"><?php echo e(__('Template Management')); ?></h1>
            <div class="title-actions">
                <a href="<?php echo e(route('template.admin.importTemplate')); ?>" class="btn btn-info"><?php echo e(__('Import new Template')); ?></a>
                <a href="<?php echo e(route('template.admin.create')); ?>" class="btn btn-primary"><?php echo e(__('Add new Template')); ?></a>
            </div>
        </div>
        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                <?php if(!empty($rows)): ?>
                    <form method="post" action="<?php echo e(route('template.admin.bulkEdit')); ?>" class="filter-form filter-form-left d-flex justify-content-start">
                        <?php echo e(csrf_field()); ?>

                        <select name="action" class="form-control">
                            <option value=""><?php echo e(__(" Bulk Actions ")); ?></option>
                            <option value="clone"><?php echo e(__(" Clone ")); ?></option>
                            <option value="delete"><?php echo e(__(" Delete ")); ?></option>
                        </select>
                        <button data-confirm="<?php echo e(__("Do you want to delete?")); ?>" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button"><?php echo e(__('Apply')); ?></button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="col-left">
                <form method="get" action="<?php echo e(route('template.admin.index')); ?> " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    <input type="text" name="s" value="<?php echo e(Request()->s); ?>" placeholder="<?php echo e(__('Search by name')); ?>" class="form-control">
                    <button class="btn-info btn btn-icon btn_search" type="submit"><?php echo e(__('Search')); ?></button>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title"><?php echo e(__('All templates')); ?></div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Actions')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($rows) > 0): ?>
                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" class="check-item" name="ids[]" value="<?php echo e($row->id); ?>"></td>
                                        <td class="title">
                                            <a href="<?php echo e(route('template.admin.edit',['id'=>$row->id])); ?>"><?php echo e($row->title); ?></a>
                                        </td>
                                        <td><?php echo e($row->updated_at); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    <?php echo e(__('Actions')); ?>

                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?php echo e(route('template.admin.edit',[$row->id])); ?>"> <i class="fa fa-edit" aria-hidden="true"></i> <?php echo e(__('Edit')); ?></a>
                                                    <a class="dropdown-item" href="<?php echo e(route('template.admin.exportTemplate',[$row->id])); ?>"> <i class="fa fa-download" aria-hidden="true"></i> <?php echo e(__('Export')); ?></a>
                                                    <a class="dropdown-item" href="<?php echo e(\Illuminate\Support\Facades\URL::signedRoute('template.admin.clone',[$row->id])); ?>"> <i class="fa fa-copy" aria-hidden="true"></i> <?php echo e(__('Clone')); ?></a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3"><?php echo e(__("No data")); ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?php echo e($rows->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Template/Views/admin/index.blade.php ENDPATH**/ ?>