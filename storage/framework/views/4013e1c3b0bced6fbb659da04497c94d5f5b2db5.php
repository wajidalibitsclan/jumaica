<?php $lang_local = app()->getLocale();
    $bookingInformation = $booking->getJsonMeta('booking_car_information');
    $is_oneway_trip = $bookingInformation['is_oneway_trip']??false;
?>
<div class="booking-review">



    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info d-flex flex-row-reverse">
                <div>
                    <?php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    ?>
                    <h3 class="service-name">
                        <a href="<?php echo e($service->getDetailUrl()); ?>" style="font-size: 13px !important;">
                            <?php echo clean($service_translation->title); ?>


                            |
                            <?php if(!$is_oneway_trip): ?>
                                Round Trip
                                <?php else: ?>
                                OneWay
                            <?php endif; ?>
|
                            <?php
                                $price_item = $booking->total_before_extra_price;
                            ?>
                            <?php if(!empty($price_item)): ?>
                                <?php echo e(format_money( $price_item)); ?>

                            <?php endif; ?>
                                            <?php if($meta = $booking->number): ?>
                                                <div class="d-flex flex-column float-left label p-1 text-muted">
                                                    <?php echo e(__('Persons')); ?> & Bags :
                                                        <?php echo e($meta); ?>

                                                        |
                                                        <?php echo e($bookingInformation['baggage']); ?>

                                            <?php endif; ?>
                        </a>
                    </h3>
                    <?php if($service_translation->address): ?>
                        <p class="address"><i class="fa fa-map-marker"></i>
                            <?php echo e($service_translation->address); ?>

                        </p>
                    <?php endif; ?>
                </div>
                <div>
                    <img src="<?php echo e($service->image_url); ?>" class="img-responsive" alt="<?php echo clean($service_translation->title); ?>">
                </div>
            </div>
        </div>
        <div class="">

                    <div class="border border-secondary d-flex flex-column label p-1 text-muted w-100"><?php echo e(__('where From:')); ?> <span class="text-dark"><?php echo e($bookingInformation['from_address']); ?></span></div>

                    <div class="border border-secondary d-flex flex-column label p-1 text-muted w-100"><?php echo e(__('where To:')); ?> <span class="text-dark"><?php echo e($bookingInformation['to_address']); ?></span></div>


                <?php if($booking->start_date): ?>
                    <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                        <div class="label text-muted"><?php echo e(__('Pickup date:')); ?></div>
                        <div class="val text-dark">
                            <?php echo e(display_datetime($booking->start_date)); ?>

                        </div>
                    </div>
                    <?php if(!$is_oneway_trip): ?>
                        <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                            <div class="label text-muted"><?php echo e(__('Return date:')); ?></div>
                            <div class="val text-dark">
                                <?php echo e(display_datetime($booking->end_date)); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>












                <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                    <div class="label text-muted"><?php echo e(__('Pickup Flight #:')); ?></div>
                    <div class="val text-dark">
                        <?php echo e($bookingInformation['pickup_flight']); ?>

                    </div>
                </div>
                <?php if(!$is_oneway_trip): ?>
                    <div class="border border-secondary d-flex flex-column float-left label p-1 text-muted w-50">
                        <div class="label text-muted"><?php echo e(__('Return Flight #:')); ?></div>
                        <div class="val text-dark">
                            <?php echo e($bookingInformation['return_flight']); ?>

                        </div>
                    </div>
                <?php endif; ?>

        </div>
        <div class="border border-secondary d-flex flex-column label p-1 review-section text-muted total-review w-100">











                <?php $extra_price = $booking->getJsonMeta('extra_price') ?>
                <?php if(!empty($extra_price) or !empty($booking->extras)): ?>
                   <div>
                        <div class="label-title"><span><?php echo e(__("Extras:")); ?></span></div>
                    </div>
                    <div class="no-flex">
                        <ul class="pl-0">
                            <?php $__currentLoopData = $extra_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="label">
                                        <?php echo e($type['name_'.$lang_local] ?? $type['name']); ?>: <?php echo e(format_money($type['price'])); ?> x <?php echo e(!empty($type['per_person']) ? $booking->number : 1); ?>

                                    </div>
                                    <div class="val">
                                        <?php echo e(format_money($type['total'] ?? 0)); ?>

                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if ($__env->exists('Booking::frontend/booking/extra-detail')) echo $__env->make('Booking::frontend/booking/extra-detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <hr>

































                <div class="coupon-box d-none">
                <?php if ($__env->exists('Coupon::frontend/booking/checkout-coupon')) echo $__env->make('Coupon::frontend/booking/checkout-coupon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
               
                <?php echo $__env->make('Booking::frontend/booking/checkout-deposit-amount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
     <div class="border border-secondary label p-1 text-muted w-100">
         <button class="btn btn-secondary m-1" onclick="$('.coupon-box').toggleClass('d-none')">Add Coupon</button>
     </div>
    </div>

    <h4 class="booking-review-title d-flex justify-content-start align-items-center" style="font-size:18px;">
        <div class="d-flex">
            <?php echo e(__("BOOKING INFO")); ?> |
            <a class="d-block d-sm-none ml-auto text-15 show_hide_section1 show_hide_map" href="#">SHOW DETAILS</a>
        </div>
    </h4>
</div>



<?php $__env->startPush('js'); ?>
<script>
    $(document).ready(function(){
    $('.show_hide_section1').click(function() {
        if ($('.booking-review-content').css('display') == 'block') {
            $('.booking-review-content').toggle("slide");
            $(this).html('SHOW DETAILS')
        }else{

            $('.booking-review-content').toggle("slide");
            $(this).html('HIDE DETAILS')
        }

    });
    })
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Car/Views/frontend/booking/detail.blade.php ENDPATH**/ ?>