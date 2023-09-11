<?php
$extra = $booking->extras;
if(empty($extra)) return;
?>
<?php $__currentLoopData = $extra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li>
        <div class="label">
            <?php echo e($item->extra->title ?? ''); ?>:
            <?php echo e(format_money($item->price)); ?> x <?php echo e($item->number); ?>

            <a href="javascript:;" data-id="<?php echo e($item->id); ?>" class="delete_extra"><i class="text-danger fa fa-times-circle"></i></a>
        </div>
        <div class="val">
            <?php echo e(format_money($item->price * $item->number)); ?>

        </div>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function(){
            $('.delete_extra').on('click', function(){
                var id = $(this).attr('data-id');
                var url = '<?php echo e(url('booking')); ?>';
                url = url+'/'+id+'/extra/remove';
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function (res) {
                        window.location.reload()
                    }
                })


            })

        })

    </script>

<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Booking/Views/frontend/booking/extra-detail.blade.php ENDPATH**/ ?>