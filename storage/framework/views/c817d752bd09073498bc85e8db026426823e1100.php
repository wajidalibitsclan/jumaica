<div class="form-group">
    <label><?php echo e(__("Title")); ?> <span class="text-danger"> *</span></label>
    <input type="text" required value="<?php echo e(old('title',$translation->title)); ?>" placeholder="<?php echo e(__("title")); ?>" name="title" class="form-control">
</div>

<div class="form-group">
    <label><?php echo e(__("Image")); ?> </label>
    <?php echo \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id); ?>

</div>
<div class="form-group">
    <label><?php echo e(__("Youtube Video URL")); ?></label>
    <input type="text" value="<?php echo e(old('video_url',$translation->video_url)); ?>" placeholder="" name="video_url" class="form-control">
</div>
<div class="form-group">
    <label><?php echo e(__("Price")); ?></label>
    <input type="number" min="0" step="any" value="<?php echo e(old('price',$row->price)); ?>" placeholder="" name="price" class="form-control">
</div>
<div class="form-group">
    <label><?php echo e(__("Display Order")); ?></label>
    <input type="number" min="1" value="<?php echo e(old('display_order',$row->display_order)); ?>" placeholder="" name="display_order" class="form-control">
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="form-group">
    <label><?php echo e(__("Dropdown")); ?> <span class="text-danger"> *</span></label>
    <select name="dropdown[]" class="form-control select2" multiple>
        <option value="">Please Select</option>
            <?php $__currentLoopData = \Themes\Jamrock\Booking\Models\Dropdown::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->id); ?>" <?php echo e((in_array($item->id, $translation->dropdown)) ? 'selected' : ''); ?>><?php echo e($item->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<?php echo $__env->make('Booking::admin.extra.include-exclude', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php $__env->startPush('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2();
        })
    </script>

<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/extra/form.blade.php ENDPATH**/ ?>