<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css")); ?>"/>
    <style type="text/css">
        .bravo_topbar, .bravo_footer {
            display: none
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="bravo_search_tour">
        <h1 class="d-none">
            <?php echo e(setting_item_with_lang("tour_page_search_title")); ?>

        </h1>
        <div class="bravo_form_search_map">
            <?php echo $__env->make('Tour::frontend.layouts.search-map.form-search-map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="bravo_search_map <?php echo e(setting_item_with_lang("tour_layout_map_option",false,"map_left")); ?>">
            <div class="results_map">
                <div class="map-loading d-none">
                    <div class="st-loader"></div>
                </div>
                <div id="bravo_results_map" class="results_map_inner"></div>
            </div>
            <div class="results_item">
                <?php echo $__env->make('Tour::frontend.layouts.search-map.advance-filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="listing_items">
                    <?php echo $__env->make('Tour::frontend.layouts.search-map.list-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            map_lat_default:<?php echo e(setting_item('tour_map_lat_default','0')); ?>,
            map_lng_default:<?php echo e(setting_item('tour_map_lng_default','0')); ?>,
            map_zoom_default:<?php echo e(setting_item('tour_map_zoom_default','6')); ?>,
        };
    </script>
    <script type="text/javascript" src="<?php echo e(asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js")); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('module/tour/js/tour-map.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app',['container_class'=>'container-fluid','header_right_menu'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/BC/Tour/Views/frontend/search-map.blade.php ENDPATH**/ ?>