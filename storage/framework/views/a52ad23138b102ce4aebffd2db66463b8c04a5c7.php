<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('dist/frontend/module/car/css/car.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css")); ?>"/>
    <style type="text/css">
        .bravo_topbar, .bravo_footer {
            display: none
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bravo_search_tour bravo_search_car">
        <h1 class="d-none">
            <?php echo e(setting_item_with_lang("car_page_search_title")); ?>

        </h1>
        <div class="bravo_form_search_map">
            <?php echo $__env->make('Car::frontend.layouts.search-map.form-search-map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="pt-0 pt-md-3 bravo_search_map <?php echo e(setting_item_with_lang("car_layout_map_option",false,"map_left")); ?>">
            <div class="results_map p-0 p-md-2">
                <div class="map-loading d-none">
                    <div class="st-loader"></div>
                </div>
                <div id="bravo_results_map" class="results_map_inner"></div>
            </div>

            <div class="d-block d-md-none pt-3">
                <div class="box-count px-1 d-flex justify-content-start align-items-center">
                    <div>
                        <span class="map-duration"></span>
                        <?php if($rows->total() > 1): ?>
                            <?php echo e(__(":count Cars Found",['count'=>$rows->total()])); ?>

                        <?php else: ?>
                            <?php echo e(__(":count Car Found",['count'=>$rows->total()])); ?>

                        <?php endif; ?>
                    </div>
                    <a href="javascript:;" class="show_hide_map ml-auto pl-1">Hide Map</a>
                </div>
            </div>

            <div class="results_item">
                <?php echo $__env->make('Car::frontend.layouts.search-map.advance-filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="listing_items">
                    <?php echo $__env->make('Car::frontend.layouts.search-map.list-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <?php echo App\Helpers\MapEngine::scripts(); ?>

    <script>
        var bravo_map_data = {
            markers:<?php echo json_encode($markers); ?>,
            map_lat_default:<?php echo e(setting_item('car_map_lat_default','0')); ?>,
            map_lng_default:<?php echo e(setting_item('car_map_lng_default','0')); ?>,
            map_zoom_default:<?php echo e(setting_item('car_map_zoom_default','6')); ?>,
        };


        $('.show_hide_map').click(function() {
            if ($('.results_map').css('display') == 'block') {
                $('.results_map').toggle("slide");
                $('.d-block.d-md-none.pt-3').attr('style', 'padding-top: 6px !important');
                $(this).html('SHOW MAP')
            }else{

                $('.results_map').toggle("slide");
                $('.d-block.d-md-none.pt-3').attr('style', 'padding-top: 15px !important');
                $(this).html('HIDE MAP')
            }

        });


        $('.pickup_clear').on('click', function (){
            $('#pick_up').val('').focus();
        })
        $('.dropoff_clear').on('click', function (){
            $('#drop_off').val('').focus();
        })


        var distance = $('input[name="gmap_distance"]').val();


    </script>
    <script type="text/javascript" src="<?php echo e(asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js")); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('module/car/js/car-map.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app',['container_class'=>'container-fluid','header_right_menu'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/BC/Car/Views/frontend/search-map.blade.php ENDPATH**/ ?>