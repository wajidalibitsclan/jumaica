<svg class="field-icon fa " width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M21 21L16.514 16.506M19 10.5C19 12.7543 18.1045 14.9163 16.5104 16.5104C14.9163 18.1045 12.7543 19 10.5 19C8.24566 19 6.08365 18.1045 4.48959 16.5104C2.89553 14.9163 2 12.7543 2 10.5C2 8.24566 2.89553 6.08365 4.48959 4.48959C6.08365 2.89553 8.24566 2 10.5 2C12.7543 2 14.9163 2.89553 16.5104 4.48959C18.1045 6.08365 19 8.24566 19 10.5V10.5Z" stroke="#00B050" stroke-width="2.33333" stroke-linecap="round"/>
</svg>


<div class="form-group">
    <div class="form-content">
        <label class="position-relative">

            <?php echo e($field['title'] ?? ""); ?></label>
        <div class="input-search">
            <input type="text" name="service_name" class="form-control" placeholder="<?php echo e(__("Search by tour name")); ?>" value="<?php echo e(request()->input("service_name")); ?>">
        </div>
    </div>
</div>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Tour/Views/frontend/layouts/search/fields/service_name.blade.php ENDPATH**/ ?>