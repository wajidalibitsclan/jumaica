

<div class="row">
    <?php $__currentLoopData = $dropdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e($item->title); ?> <span class="text-danger"> *</span></label>
                <select name="option[]" class="form-control">
                    <option value="">Please Select</option>
                    <?php $__currentLoopData = \Themes\Jamrock\Booking\Models\Options::where('dropdown_id', $item->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option->id); ?>" <?php echo e((in_array($option->id, $translation->option)) ? 'selected' : ''); ?>><?php echo e($option->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
   


<div class="form-group">
    <label><?php echo e(__("Price")); ?> <span class="text-danger"> *</span></label>
    <input type="text" required value="<?php echo e(old('price',$translation->price)); ?>" placeholder="<?php echo e(__("price")); ?>" name="price" class="form-control">
</div>


<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function (){
            $('.dropdown_list').on('change', function (){
                var id = $(this).val();
                $.ajax({
                    url: '<?php echo e(route('combination.admin.options')); ?>',
                    data: {
                        id: id,
                        _token: "<?php echo e(csrf_token()); ?>",
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                        let buffer = '';
                        for (var i = 0; i < res.length; i++) {
                            buffer += '<option value='+res[i].id+'>'+res[i].title+' - '+res[i].value+'</option>';
                        }

                        $('.option_list').html(buffer);
                    }
                })
            })
        })

    </script>

<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/admin/combination/form.blade.php ENDPATH**/ ?>