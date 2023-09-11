<?php
$extra = $booking->extras;
if(empty($extra)) return;
?>
<?php $__currentLoopData = $extra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td class="label" style="font-weight:normal">
            <?php echo e($item->extra->title ?? ''); ?>:
            <?php echo e(format_money($item->price)); ?> x <?php echo e($item->number); ?>

        </td>
        <td class="val">
            <?php echo e(format_money($item->price * $item->number)); ?>

        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/frontend/booking/extra-detail-email.blade.php ENDPATH**/ ?>