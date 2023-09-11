<div class="form-group">
    <label><?php echo e(__("Title")); ?> <span class="text-danger"> *</span></label>
    <input type="text" required value="<?php echo e(old('title',$translation->title)); ?>" placeholder="<?php echo e(__("title")); ?>" name="title" class="form-control">
</div>

<div class="form-group">
    <label><?php echo e(__("Value")); ?> <span class="text-danger"> *</span></label>
    <input type="text" required value="<?php echo e(old('value',$translation->value)); ?>" placeholder="<?php echo e(__("value")); ?>" name="value" class="form-control">
</div>

<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/options/form.blade.php ENDPATH**/ ?>