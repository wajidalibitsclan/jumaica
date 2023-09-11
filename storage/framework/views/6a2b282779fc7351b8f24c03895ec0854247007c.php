<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('dist/frontend/module/car/css/car.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css")); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/fotorama/fotorama.css")); ?>"/>
    <link rel="stylesheet" href="/themes/jamrock/libs/timepicker/VueTimepicker.css"/>

        <style>
            .bravo_footer{
                display: none!important;
            }
        </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bravo_detail_car">
        <?php echo $__env->make('Layout::parts.bc', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container">
            <?php echo $__env->make('Car::frontend.layouts.details.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="bravo_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <?php $review_score = $row->review_data ?>
                        <?php echo $__env->make('Car::frontend.layouts.details.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('Car::frontend.layouts.details.review', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <?php echo $__env->make('Tour::frontend.layouts.details.vendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('Car::frontend.layouts.details.form-book', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="row end_tour_sticky">
                    <div class="col-md-12">
                        <?php echo $__env->make('Car::frontend.layouts.details.related', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $__env->make('Car::frontend.layouts.details.form-book-mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <?php echo App\Helpers\MapEngine::scripts(); ?>

    <script>
        jQuery(function ($) {
            <?php if($row->map_lat && $row->map_lng): ?>
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [<?php echo e($row->map_lat); ?>, <?php echo e($row->map_lng); ?>],
                zoom:<?php echo e($row->map_zoom ?? "8"); ?>,
                ready: function (engineMap) {
                    engineMap.addMarker([<?php echo e($row->map_lat); ?>, <?php echo e($row->map_lng); ?>], {
                        icon_options: {
                            iconUrl:"<?php echo e(get_file_url(setting_item("car_icon_marker_map"),'full') ?? url('images/icons/png/pin.png')); ?>"
                        }
                    });
                }
            });
            <?php endif; ?>
        })
    </script>
    <script>
        var bravo_booking_data = <?php echo json_encode($booking_data); ?>;
        var bravo_booking_i18n = {
			no_date_select:'<?php echo e(__('Please select Start and End date')); ?>',
            no_from_address_select:'<?php echo e(__('Please select pickup location')); ?>',
            no_to_address_select:'<?php echo e(__('Please select return location')); ?>',
			no_gg_distance_select:'<?php echo e(__('Can not calculate distance, please select address again')); ?>',
			no_pickup_date_select:'<?php echo e(__('Please select Pickup date and Pickup time')); ?>',
			no_return_date_select:'<?php echo e(__('Please select Return date and Return time')); ?>',
            no_passenger_select:'<?php echo e(__('Please select at least one person')); ?>',
            no_guest_select:'<?php echo e(__('Please select at least one number')); ?>',
            load_dates_url:'<?php echo e(route('car.vendor.availability.loadDates')); ?>',
            name_required:'<?php echo e(__("Name is Required")); ?>',
            email_required:'<?php echo e(__("Email is Required")); ?>',
        };
    </script>


    <script type="text/javascript" src="<?php echo e(asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js")); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset("libs/fotorama/fotorama.js")); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset("libs/sticky/jquery.sticky.js")); ?>"></script>
    <script type="text/javascript" src="/themes/jamrock/libs/timepicker/VueTimepicker.umd.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('themes/jamrock/js/car/single-car.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Car/Views/frontend/detail.blade.php ENDPATH**/ ?>