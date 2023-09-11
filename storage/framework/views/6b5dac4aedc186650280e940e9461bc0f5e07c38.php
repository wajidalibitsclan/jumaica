<?php
$translation = $service->translateOrOrigin(app()->getLocale());
$lang_local = app()->getLocale();
$meta = $booking->getJsonMeta('booking_car_information');
?>
<div class="b-panel-title"><?php echo e(__('Taxi Booking information')); ?></div>
<div class="b-table-wrap">
    <table class="b-table" cellspacing="0" cellpadding="0">
        <tr>
            <td class="label"><?php echo e(__('Booking Number')); ?></td>
            <td class="val">#<?php echo e($booking->id); ?></td>
        </tr>
        <tr>
            <td class="label"><?php echo e(__('Booking Date | Status')); ?></td>
            <td class="val"> <?php echo e(display_datetime($booking->created_at)); ?> | <?php echo e($booking->statusName); ?></td>
        </tr>
        <?php if($booking->gatewayObj): ?>
            <tr>
                <td class="label"><?php echo e(__('Payment method')); ?></td>
                <td class="val"><?php echo e($booking->gatewayObj->getOption('name')); ?></td>
            </tr>
        <?php endif; ?>
        <?php if($booking->gatewayObj and $note = $booking->gatewayObj->getOption('payment_note')): ?>
            <tr>
                <td class="label"><?php echo e(__('Payment Note')); ?></td>
                <td class="val"><?php echo clean($note); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td class="label"><?php echo e(__('Taxi | Trip Type')); ?></td>
            <td class="val">
                <?php echo clean($translation->title); ?> | <?php echo e(!empty($meta['is_oneway_trip']) ? 'Oneway Trip' : 'Round Trip'); ?>

            </td>
        </tr>
        <tr>
            <td class="label"><?php echo e(__('Pickup Address')); ?></td>
            <td class="val">
                <?php echo e($meta['from_address'] ?? ''); ?>

            </td>
        </tr>
        

        <tr>
            <td class="label"><?php echo e(__('Dropoff Address')); ?></td>
            <td class="val">
                <?php echo e($meta['to_address'] ?? ''); ?>

            </td>
        </tr>
        <tr>
            <td class="label"><?php echo e(__('Pickup Date')); ?></td>
            <td class="val">
                <?php echo e(isset($meta['pickup_date']['date']) ? display_datetime($meta['pickup_date']['date']) : ''); ?>

            </td>
        </tr>
        <?php if(empty($meta['is_oneway_trip'])): ?>
            <tr>
                <td class="label"><?php echo e(__('Dropoff Date')); ?></td>
                <td class="val">
                    <?php echo e(isset($meta['return_date']['date']) ? display_datetime($meta['return_date']['date']) : ''); ?>

                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td class="label"><?php echo e(__('Guest | Baggage')); ?></td>
            <td class="val">
                <?php echo e($meta['passenger'] ?? 0); ?> | <?php echo e($meta['baggage'] ?? 0); ?>

            </td>
        </tr>
        <?php if(empty($meta['pickup_flight'])): ?>
            <tr>
                <td class="label"><?php echo e(__('Pickup Flight')); ?></td>
                <td class="val">
                    <?php echo e($meta['pickup_flight'] ?? ''); ?>

                </td>
            </tr>
        <?php endif; ?>
        <?php if(empty($meta['return_flight'])): ?>
            <tr>
                <td class="label"><?php echo e(__('Return Flight')); ?></td>
                <td class="val">
                    <?php echo e($meta['return_flight'] ?? ''); ?>

                </td>
            </tr>
        <?php endif; ?>
        <?php if(!empty($meta['gg_distance'])): ?>
            <tr>
                <td class="label"><?php echo e(__('Travel Info')); ?></td>
                <td class="val">
                    <?php echo e($meta['gg_distance']['text'] ?? ''); ?> | <?php echo e($meta['gg_duration']['text'] ?? ''); ?>

                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td class="label"><?php echo e(__('Taxi Price')); ?></td>
            <td class="val">
                <?php echo e(format_money($booking->total_before_extra_price)); ?>

            </td>
        </tr>
        <tr>
            <td class="label"><?php echo e(__('Extras')); ?></td>
            <td class="val">
            </td>
        </tr>
        <?php $extra_price = $booking->getJsonMeta('extra_price')?>

        <?php if(!empty($extra_price)): ?>
            <?php $__currentLoopData = $extra_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="label" style="font-weight:normal"><?php echo e($type['name_'.$lang_local] ?? $type['name']); ?>: <?php echo e(format_money($type['price'])); ?> x <?php echo e(!empty($type['per_person']) ? $booking->number : 1); ?></td>
                    <td class="val no-r-padding">
                        <?php echo e(format_money($type['total'] ?? 0)); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if ($__env->exists('Booking::frontend/booking/extra-detail-email')) echo $__env->make('Booking::frontend/booking/extra-detail-email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $list_all_fee = [];
            if(!empty($booking->buyer_fees)){
                $buyer_fees = json_decode($booking->buyer_fees , true);
                $list_all_fee = $buyer_fees;
            }
            if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
            }
        ?>
        <?php if(!empty($list_all_fee)): ?>
            <?php $__currentLoopData = $list_all_fee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $fee_price = $item['price'];
                    if(!empty($item['unit']) and $item['unit'] == "percent"){
                        $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                    }
                ?>
                <tr>
                    <td class="label">
                        <?php echo e($item['name_'.$lang_local] ?? $item['name']); ?>

                        <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo e($item['desc_'.$lang_local] ?? $item['desc']); ?>"></i>
                        <?php if(!empty($item['per_person']) and $item['per_person'] == "on"): ?>
                            : <?php echo e($booking->total_guests); ?> * <?php echo e(format_money( $fee_price )); ?>

                        <?php endif; ?>
                    </td>
                    <td class="val">
                        <?php if(!empty($item['per_person']) and $item['per_person'] == "on"): ?>
                            <?php echo e(format_money( $fee_price * $booking->total_guests )); ?>

                        <?php else: ?>
                            <?php echo e(format_money( $fee_price )); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if(!empty($booking->coupon_amount) and $booking->coupon_amount > 0): ?>
                        <tr>
                            <td class="label">
                                <?php echo e(__("Coupon")); ?>

                            </td>
                            <td class="val">
                                -<?php echo e(format_money($booking->coupon_amount)); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
        <tr>
            <td class="label fsz21"><?php echo e(__('Total')); ?></td>
            <td class="val fsz21"><strong style="color: #FA5636"><?php echo e(format_money($booking->total)); ?></strong></td>
        </tr>
        <tr>
            <td class="label fsz21"><?php echo e(__('Paid')); ?></td>
            <td class="val fsz21"><strong style="color: #FA5636"><?php echo e(format_money($booking->paid)); ?></strong></td>
        </tr>
        <?php if($booking->total > $booking->paid): ?>
        <tr>
            <td class="label fsz21"><?php echo e(__('Remain')); ?></td>
            <td class="val fsz21"><strong style="color: #FA5636"><?php echo e(format_money($booking->total - $booking->paid)); ?></strong></td>
        </tr>
        <?php endif; ?>
    </table>
</div>
<div class="text-center mt20">
    <a href="<?php echo e(route("user.booking_history")); ?>" target="_blank" class="btn btn-primary manage-booking-btn"><?php echo e(__('Manage Bookings')); ?></a>
</div>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/modules/Car/Views/emails/new_booking_detail.blade.php ENDPATH**/ ?>