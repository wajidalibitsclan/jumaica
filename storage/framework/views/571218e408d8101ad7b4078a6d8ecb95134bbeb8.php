<div class="px-30px pt-30px">
    <div class="row ">
        <div class="col-md-10">
            <form action="<?php echo e(url( app_get_locale(false,false,'/').config('tour.tour_route_prefix') )); ?>" class="form bravo_form d-flex justify-content-start" method="get" onsubmit="return false;">

                <?php $tour_map_search_fields = setting_item_array('tour_map_search_fields');
                    $tour_map_search_fields = array_values(\Illuminate\Support\Arr::sort($tour_map_search_fields, function ($value) {
                        return $value['position'] ?? 0;
                    }));

                ?>
                <?php if(!empty($tour_map_search_fields)): ?>
                    <?php $__currentLoopData = $tour_map_search_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php switch($field['field']):
                            case ('location'): ?>
                                <?php echo $__env->make('Tour::frontend.layouts.search-map.fields.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php break; ?>
                            <?php case ('service_name'): ?>
                                <?php echo $__env->make('Tour::frontend.layouts.search-map.fields.service_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php break; ?>
                        <?php endswitch; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-2">
            <div class="box-count px-1">
                <?php if($rows->total() > 1): ?>
                    <?php echo e(__(":count Tours Found",['count'=>$rows->total()])); ?>

                <?php else: ?>
                    <?php echo e(__(":count Tour Found",['count'=>$rows->total()])); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Tour/Views/frontend/layouts/search-map/form-search-map.blade.php ENDPATH**/ ?>