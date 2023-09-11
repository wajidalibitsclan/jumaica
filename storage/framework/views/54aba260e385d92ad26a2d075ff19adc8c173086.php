<?php
$popular_locations = \Modules\Location\Models\PopularLocation::query()->get();

$is_map = 1;
?>
<div class="px-30px pt-30px">
    <div class="row ">
        <div class="col-md-10">
            <form action="<?php echo e(url( app_get_locale(false,false,'/').config('car.car_route_prefix') )); ?>" class="form bravo_form d-flex justify-content-start" method="get">
                <input type="hidden" name="_layout" value="<?php echo e(request('_layout')); ?>">
                <input type="hidden" name="gmap_distance" value="<?php echo e(request('gmap_distance')); ?>">
                <input type="hidden" name="gmap_duration" value="<?php echo e(request('gmap_duration')); ?>">
                <?php echo $__env->make('Car::frontend.layouts.search-map.fields.location',['prefix'=>"pickup_",'title_input' => __("Enter your pickup location"),'show_popup_location'=>1,'name'=>'pick_up'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('Car::frontend.layouts.search-map.fields.location',['prefix'=>"dropoff_",'title_input' => __("Enter your dropoff location"),'show_popup_location'=>1,'name'=>'drop_off'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </form>
        </div>
        <div class="col-md-2 d-none d-md-block">
            <div class="box-count px-1">
                <span class="map-duration"></span>
                <?php if($rows->total() > 1): ?>
                    <?php echo e(__(":count Cars Found",['count'=>$rows->total()])); ?>

                <?php else: ?>
                    <?php echo e(__(":count Car Found",['count'=>$rows->total()])); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('js'); ?>
    <script>
        var bc_current_url = '<?php echo e(url('/car')); ?>';
        var currentDirection = {
            from:{
                lat:<?php echo e(request('pickup_map_lat',0)); ?>,
                lng:<?php echo e(request('pickup_map_lng',0)); ?>,
                place_id:'<?php echo e(request('pickup_place_id')); ?>',
            },
            to:{
                lat:<?php echo e(request('dropoff_map_lat',0)); ?>,
                lng:<?php echo e(request('dropoff_map_lng',0)); ?>,
                place_id:'<?php echo e(request('dropoff_place_id')); ?>',
            },
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Car/Views/frontend/layouts/search-map/form-search-map.blade.php ENDPATH**/ ?>