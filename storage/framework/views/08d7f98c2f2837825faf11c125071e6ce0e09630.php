<?php ($location_search_style = setting_item('tour_location_search_style')); ?>
<svg class="field-icon fa" width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M9.00001 0.5C6.81276 0.50258 4.71584 1.3726 3.16923 2.91922C1.62261 4.46584 0.752589 6.56276 0.750009 8.75C0.747389 10.5374 1.33124 12.2763 2.41201 13.7C2.41201 13.7 2.63701 13.9963 2.67376 14.039L9.00001 21.5L15.3293 14.0353C15.3623 13.9955 15.588 13.7 15.588 13.7L15.5888 13.6978C16.669 12.2747 17.2526 10.5366 17.25 8.75C17.2474 6.56276 16.3774 4.46584 14.8308 2.91922C13.2842 1.3726 11.1873 0.50258 9.00001 0.5ZM9.00001 11.75C8.40666 11.75 7.82665 11.5741 7.3333 11.2444C6.83995 10.9148 6.45543 10.4462 6.22837 9.89805C6.00131 9.34987 5.9419 8.74667 6.05765 8.16473C6.17341 7.58279 6.45913 7.04824 6.87869 6.62868C7.29825 6.20912 7.83279 5.9234 8.41474 5.80764C8.99668 5.69189 9.59988 5.7513 10.1481 5.97836C10.6962 6.20542 11.1648 6.58994 11.4944 7.08329C11.8241 7.57664 12 8.15666 12 8.75C11.999 9.54535 11.6826 10.3078 11.1202 10.8702C10.5578 11.4326 9.79535 11.749 9.00001 11.75Z" fill="#0070C1"/>
</svg>
<div class="form-group">

	<div class="form-content">
		<label class="position-relative">

            <?php echo e($field['title'] ?? ""); ?></label>
		<?php if($location_search_style=='autocompletePlace'): ?>
            <div class="g-map-place" >
                <input type="text" id="<?php echo e($name ?? ''); ?>" name="<?php echo e($prefix ?? ""); ?>map_place" placeholder="<?php echo e(__("Enter your pickup location?")); ?>"  value="<?php echo e(request()->input('map_place')); ?>" class="form-control border-0 map_place">
                <div class="map d-none" id="map-<?php echo e(\Illuminate\Support\Str::random(10)); ?>"></div>
                <input type="hidden" class="map_lat" name="<?php echo e($prefix ?? ""); ?>map_lat" value="<?php echo e(request()->input(($prefix ?? "").'map_lat')); ?>">
                <input type="hidden" class="map_lgn" name="<?php echo e($prefix ?? ""); ?>map_lgn" value="<?php echo e(request()->input(($prefix ?? "").'map_lgn')); ?>">
            </div>
		<?php else: ?>
            <?php
            $location_name = "";
            $list_json = [];
            $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json, &$location_name) {
                foreach ($locations as $location) {
                    $translate = $location->translateOrOrigin(app()->getLocale());
                    if (Request::query('location_id') == $location->id) {
                        $location_name = $translate->name;
                    }
                    $list_json[] = [
                        'id'    => $location->id,
                        'title' => $prefix.' '.$translate->name,
                    ];
                    $traverse($location->children, $prefix.'-');
                }
            };
            $traverse($tour_location);
            ?>
			<div class="smart-search">
				<input type="text" class="smart-search-location parent_text form-control" <?php echo e(( empty(setting_item("tour_location_search_style")) or setting_item("tour_location_search_style") == "normal" ) ? "readonly" : ""); ?> placeholder="<?php echo e(__("Or filter by tour location")); ?>" value="<?php echo e($location_name); ?>" data-onLoad="<?php echo e(__("Loading...")); ?>"
				       data-default="<?php echo e(json_encode($list_json)); ?>">
				<input type="hidden" class="child_id" name="location_id" value="<?php echo e(Request::query('location_id')); ?>">
			</div>
		<?php endif; ?>
	</div>
</div>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Tour/Views/frontend/layouts/search/fields/location.blade.php ENDPATH**/ ?>