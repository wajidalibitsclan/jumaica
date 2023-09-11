<?php $lang_local = app()->getLocale();    $bookingInformation = $booking->getJsonMeta('booking_tour_information');
?>
<div class="booking-review">
    <h4 class="booking-review-title d-flex justify-content-start align-items-center" style="font-size:18px;">
        <?php echo e(__("BOOKING DETAILS")); ?>

        <a class="d-block d-sm-none ml-auto text-15 show_hide_section2 show_hide_map" href="#">Show Details</a>
    </h4>

    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    <?php
                        $service_translation = $service->translateOrOrigin($lang_local);
                    ?>
                    <h3 class="service-name"><a href="<?php echo e($service->getDetailUrl()); ?>"><?php echo clean($service_translation->title); ?></a></h3>
                    <?php if($service_translation->address): ?>
                        <p class="address"><i class="fa fa-map-marker"></i>
                            <?php echo e($service_translation->address); ?>

                        </p>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if($image_url = $service->getImageUrl()): ?>
                        <img src="<?php echo e($image_url); ?>" alt="<?php echo clean($service_translation->title); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                    <li>
                        <div class="label text-muted"><?php echo e(__('Fr:')); ?> <span class="text-dark"><?php echo e($bookingInformation['from_address']); ?></span></div>
                    </li>

                    <li>
                        <div class="label text-muted"><?php echo e(__('To:')); ?> <span class="text-dark"><?php echo e($bookingInformation['to_address']); ?></span></div>
                    </li>

                <?php if($booking->start_date): ?>
                    <li>
                        <div class="label text-muted"><?php echo e(__('Pickup Date:')); ?></div>
                        <div class="val">
                            <?php echo e(display_datetime($booking->start_date)); ?>

                        </div>
                    </li>
                <?php endif; ?>

                    <?php if($meta = $booking->number): ?>
                        <li>
                            <div class="label"><?php echo e(__('Persons:')); ?></div>
                            <div class="val">
                                <?php echo e($meta); ?>

                            </div>
                        </li>
                    <?php endif; ?>

            </ul>
        </div>
        <?php do_action('booking.checkout.before_total_review'); ?>
        <div class="review-section total-review">
            <ul class="review-list">
                <?php
                    $price_item = $booking->total_before_extra_price;
                ?>
               <?php if(!empty($price_item)): ?>
                    <li>
                        <div class="label text-muted"><?php echo e(__('Service Charge')); ?>

                        </div>
                        <div class="val">
                            <?php echo e(format_money( $price_item)); ?>

                        </div>
                    </li>
                <?php endif; ?>
                <?php $extra_price = $booking->getJsonMeta('extra_price') ?>
                <?php if(!empty($extra_price) or !empty($booking->extras)): ?>
                    <li>
                        <div class="label-title"><span><?php echo e(__("Extras:")); ?></span></div>
                    </li>
                    <li class="no-flex">
                        <ul class="pl-0">
                            <?php $__currentLoopData = $extra_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="label"><?php echo e($type['name_'.$lang_local] ?? $type['name']); ?>: <?php echo e(format_money($type['price'])); ?> x <?php echo e(!empty($type['per_person']) ? $booking->total_guests : 1); ?></div>
                                    <div class="val">
                                        <?php echo e(format_money($type['total'] ?? 0)); ?>

                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if ($__env->exists('Booking::frontend/booking/extra-detail')) echo $__env->make('Booking::frontend/booking/extra-detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <hr>

                <li>
                    <div class="label">
                        <?php echo e(__('Total:')); ?>


                        <span class="badge badge-default bg-gray py-1 px-2 ml-3" onclick="$('.coupon-box').toggleClass('d-none')">Add Couon</span>
                    </div>
                    <div class="val">
                        <?php echo e(format_money($booking->total)); ?>

                    </div>
                </li>

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
                        <li>
                            <div class="label">
                                <?php echo e($item['name_'.$lang_local] ?? $item['name']); ?>

                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo e($item['desc_'.$lang_local] ?? $item['desc']); ?>"></i>
                                <?php if(!empty($item['per_person']) and $item['per_person'] == "on"): ?>
                                    : <?php echo e($booking->total_guests); ?> * <?php echo e(format_money( $fee_price )); ?>

                                <?php endif; ?>
                            </div>
                            <div class="val">
                                <?php if(!empty($item['per_person']) and $item['per_person'] == "on"): ?>
                                    <?php echo e(format_money( $fee_price * $booking->total_guests )); ?>

                                <?php else: ?>
                                    <?php echo e(format_money( $fee_price )); ?>

                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div class="coupon-box d-none">
                <?php if ($__env->exists('Coupon::frontend/booking/checkout-coupon')) echo $__env->make('Coupon::frontend/booking/checkout-coupon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
              
                <?php echo $__env->make('Booking::frontend/booking/checkout-deposit-amount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
        </div>
    </div>
</div>


<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function(){
            $('.show_hide_section2').click(function() {
                if ($('.booking-review-content').css('display') == 'block') {
                    $('.booking-review-content').toggle("slide");
                    $(this).html('Show Details')
                }else{

                    $('.booking-review-content').toggle("slide");
                    $(this).html('Hide Details')
                }

            });
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Tour/Views/frontend/booking/detail.blade.php ENDPATH**/ ?>