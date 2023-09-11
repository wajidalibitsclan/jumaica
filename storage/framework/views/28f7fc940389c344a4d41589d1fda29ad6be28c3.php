<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('module/booking/css/checkout.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <style>
        .bravo_footer{
            display: none!important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bravo-booking-page padding-content" >
        <div class="container">
            <div id="bravo-checkout-page" >
                <div class="row">
                    <div class="col-md-8">
                        <h4 style="font-size: 18px" class="form-title border-0 mb-2 d-flex justify-content-center align-items-center">

                            <?php echo e(__('LEAD PERSON DETAIL')); ?>



                            <div class="form-group ml-auto mb-0">
                                <label for="confirmRegister" class="mb-0 show_hide_map" style="padding-top: 5px !important; padding-bottom: 5px !important;">
                                    <?php echo e(__('Create Account')); ?>

                                    <input type="checkbox" checked name="confirmRegister" id="confirmRegister" value="1">
                                </label>
                            </div>

                        </h4>
                         <div class="booking-form">
                             <?php echo $__env->make($service->checkout_form_file ?? 'Booking::frontend/booking/checkout-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                             <?php if(!empty($token = request()->input('token'))): ?>
                                 <input type="hidden" name="token" value="<?php echo e($token); ?>">
                             <?php endif; ?>
                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking-detail booking-form">
                            <?php echo $__env->make($service->checkout_booking_detail_file ?? '', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('module/booking/js/checkout.js')); ?>"></script>
    <script type="text/javascript">
        jQuery(function () {
            $.ajax({
                'url': bookingCore.url + '<?php echo e($is_api ? '/api' : ''); ?>/booking/<?php echo e($booking->code); ?>/check-status',
                'cache': false,
                'type': 'GET',
                success: function (data) {
                    if (data.redirect !== undefined && data.redirect) {
                        window.location.href = data.redirect
                    }
                }
            });
        })

        $('.deposit_amount').on('change', function(){
            checkPaynow();
        });

        $('input[type=radio][name=how_to_pay]').on('change', function(){
            checkPaynow();
        });

        function checkPaynow(){
            var credit_input = $('.deposit_amount').val();
            var how_to_pay = $("input[name=how_to_pay]:checked").val();
            var convert_to_money = credit_input * <?php echo e(setting_item('wallet_credit_exchange_rate',1)); ?>;

            if(how_to_pay == 'full'){
                var pay_now_need_pay = parseFloat(<?php echo e(floatval($booking->total)); ?>) - convert_to_money;
            }else{
                var pay_now_need_pay = parseFloat(<?php echo e(floatval($booking->deposit == null ? $booking->total : $booking->deposit)); ?>) - convert_to_money;
            }

            if(pay_now_need_pay < 0){
                pay_now_need_pay = 0;
            }
            $('.convert_pay_now').html(bravo_format_money(pay_now_need_pay));
            $('.convert_deposit_amount').html(bravo_format_money(convert_to_money));
        }


        jQuery(function () {
            $(".bravo_apply_coupon").click(function () {
                var parent = $(this).closest('.section-coupon-form');
                parent.find(".group-form .fa-spin").removeClass("d-none");
                parent.find(".message").html('');
                $.ajax({
                    'url': bookingCore.url + '/booking/<?php echo e($booking->code); ?>/apply-coupon',
                    'data': parent.find('input,textarea,select').serialize(),
                    'cache': false,
                    'method':"post",
                    success: function (res) {
                        parent.find(".group-form .fa-spin").addClass("d-none");
                        if (res.reload !== undefined) {
                            window.location.reload();
                        }
                        if(res.message && res.status === 1)
                        {
                            parent.find('.message').html('<div class="alert alert-success">' + res.message+ '</div>');
                        }
                        if(res.message && res.status === 0)
                        {
                            parent.find('.message').html('<div class="alert alert-danger">' + res.message+ '</div>');
                        }
                    }
                });
            });
            $(".bravo_remove_coupon").click(function (e) {
                e.preventDefault();
                var parent = $(this).closest('.section-coupon-form');
                var parentItem = $(this).closest('.item');
                parentItem.find(".fa-spin").removeClass("d-none");
                $.ajax({
                    'url': bookingCore.url + '/booking/<?php echo e($booking->code); ?>/remove-coupon',
                    'data': {
                        coupon_code:$(this).attr('data-code')
                    },
                    'cache': false,
                    'method':"post",
                    success: function (res) {
                        parentItem.find(".fa-spin").addClass("d-none");
                        if (res.reload !== undefined) {
                            window.location.reload();
                        }
                        if(res.message && res.status === 0)
                        {
                            parent.find('.message').html('<div class="alert alert-danger">' + res.message+ '</div>');
                        }
                    }
                });
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/BC/Booking/Views/frontend/checkout.blade.php ENDPATH**/ ?>