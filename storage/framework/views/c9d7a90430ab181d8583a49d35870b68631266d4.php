<?php ($location_search_style = 'autocompletePlace'); ?>

<div id="<?php echo e($prefix); ?>filter" class="filter-item position-relative">
    <?php if($prefix == 'pickup_'): ?>
        <p style="margin: 0;
    padding: 0;color:#00B050;">Form?</p>
    <?php else: ?>
        <p
            style="margin: 0;
    padding: 0;color: #0070C1 "
        >To?</p>
    <?php endif; ?>




    
    
    

    <div class="">
        <div class="">
            <?php if(empty($is_map)): ?>
                <label class="position-relative">

                    <?php echo e($title); ?>

                </label>
            <?php endif; ?>
            <?php if($location_search_style=='autocompletePlace'): ?>
                <div class="g-map-place2">

                    <input required id="<?php echo e($name ?? ''); ?>" type="text" style="height: 13px"
                           name="<?php echo e($prefix ?? ""); ?>map_place"
                           placeholder="<?php echo e($title_input ?? __("Where are you going?")); ?>"
                           value="<?php echo e(request()->query(($prefix ?? '').'map_place')); ?>"
                           class=" border-0 w-100">
                    <div class="map d-none" id="map-<?php echo e(\Illuminate\Support\Str::random(10)); ?>"></div>
                    <input type="hidden" class="map_lat" name="<?php echo e($prefix ?? ""); ?>map_lat"
                           value="<?php echo e(request()->query(($prefix ?? "").'map_lat')); ?>">
                    <input type="hidden" class="map_lng" name="<?php echo e($prefix ?? ""); ?>map_lng"
                           value="<?php echo e(request()->query(($prefix ?? "").'map_lng')); ?>">
                    <input type="hidden" class="map_place_id" name="<?php echo e($prefix ?? ""); ?>place_id"
                           value="<?php echo e(request()->query(($prefix ?? "").'place_id')); ?>">
                </div>

            <?php else: ?>
                <?php
                $location_name = "";
                $list_json = [];
                $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json, &$location_name) {
                    foreach ($locations as $location) {
                        $translate = $location->translateOrOrigin(app()->getLocale());
                        if (request()->query('location_id') == $location->id) {
                            $location_name = $translate->name;
                        }
                        $list_json[] = [
                            'id' => $location->id,
                            'title' => $prefix . ' ' . $translate->name,
                        ];
                        $traverse($location->children, $prefix . '-');
                    }
                };
                $traverse($list_location);
                ?>
                <div class="smart-search">
                    <input type="text" class="smart-search-location parent_text form-control"
                           <?php echo e(( empty(setting_item("car_location_search_style")) or setting_item("car_location_search_style") == "normal" ) ? "readonly" : ""); ?> placeholder="<?php echo e($title_input ?? __("Where are you going?")); ?>"
                           value="<?php echo e($location_name); ?>" data-onLoad="<?php echo e(__("Loading...")); ?>"
                           data-default="<?php echo e(json_encode($list_json)); ?>">
                    <input type="hidden" class="child_id" name="<?php echo e($prefix ?? ""); ?>location_id"
                           value="<?php echo e(Request::query(($prefix ?? "").'location_id')); ?>">
                </div>
            <?php endif; ?>
        </div>
        <span class="map_clear <?php echo e($prefix); ?>clear">
            <img src="<?php echo e(asset('themes/jamrock/images/image11.png')); ?>" alt="">
        </span>
    </div>

    <div class="<?php echo e($prefix ?? ''); ?>popup_location popup_location ddddddd" style="display: none">
        <!--        <div class="popup_title" style="font-size: 20px">
                    Popular Locations
                </div>-->
        <ul class="nav nav-tabs mt-0" id="myTab" role="tablist">
            <li class="nav-item mr-auto" role="presentation">
                <button class="nav-link active" id="<?php echo e($prefix ?? ''); ?>home-tab" data-toggle="tab"
                        data-target="#<?php echo e($prefix ?? ''); ?>airports">
                    <i class="fa fa-plane"></i> Airports
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="<?php echo e($prefix ?? ''); ?>profile-tab" data-toggle="tab"
                        data-target="#<?php echo e($prefix ?? ''); ?>hotels">
                    <i class="fa fa-hotel"></i> Hotels
                </button>
            </li>
            <li class="nav-item ml-auto" role="presentation">
                <button class="nav-link" id="<?php echo e($prefix ?? ''); ?>contact-tab" data-toggle="tab"
                        data-target="#<?php echo e($prefix ?? ''); ?>ports">
                    <i class="fa fa-ship"></i> Ports
                </button>
            </li>
        </ul>
        <br>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="<?php echo e($prefix ?? ''); ?>airports" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="popup_lists">
                    <?php $__currentLoopData = $popular_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($l['type'] == 'Airports'): ?>
                            <a href="#" class="popular-location-item" data-lat="<?php echo e($l->map_lat); ?>"
                               data-lng="<?php echo e($l->map_lng); ?>" data-place-id="<?php echo e($l->map_place_id); ?>">
                                <i class="fa fa-plane"></i> <span><?php echo e($l->name); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="<?php echo e($prefix ?? ''); ?>hotels" role="tabpanel" aria-labelledby="profile-tab">
                <div class="popup_lists">
                    <?php $__currentLoopData = $popular_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($l['type'] == 'Hotels'): ?>
                            <a href="#" class="popular-location-item" data-lat="<?php echo e($l->map_lat); ?>"
                               data-lng="<?php echo e($l->map_lng); ?>" data-place-id="<?php echo e($l->map_place_id); ?>">
                                <i class="fa fa-hotel"></i> <span><?php echo e($l->name); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="<?php echo e($prefix ?? ''); ?>ports" role="tabpanel" aria-labelledby="contact-tab">
                <div class="popup_lists">
                    <?php $__currentLoopData = $popular_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($l['type'] == 'Ports'): ?>
                            <a href="#" class="popular-location-item" data-lat="<?php echo e($l->map_lat); ?>"
                               data-lng="<?php echo e($l->map_lng); ?>" data-place-id="<?php echo e($l->map_place_id); ?>">
                                <i class="fa fa-ship"></i> <span><?php echo e($l->name); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>


        <br>

        <div class="text-right">
            <button class="btn btn-primary btn-sm py-1 px-4 text-10"
                    onclick="$(this).closest('.popup_location').hide()">Close
            </button>
        </div>

    <!--        <div class="popup_lists">
            <?php $__currentLoopData = $popular_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="#" class="popular-location-item" data-lat="<?php echo e($l->map_lat); ?>" data-lng="<?php echo e($l->map_lng); ?>" data-place-id="<?php echo e($l->map_place_id); ?>"><?php echo e($l->name); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>-->
    </div>
</div>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Car/Views/frontend/layouts/search-map/fields/location.blade.php ENDPATH**/ ?>