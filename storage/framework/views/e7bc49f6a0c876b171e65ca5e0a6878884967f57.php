<!--
<div class="b-panel">
    <div class="b-panel-title"><?php echo e(__('Customer information')); ?></div>
    <div class="b-table-wrap">
        <div class="b-table b-table-div">
            <div class="info-first-name b-tr">
                <div class="label"><?php echo e(__('First name')); ?></div>
                <div class="val"><?php echo e($booking->first_name); ?></div>
            </div>
            <div class="info-last-name b-tr" style="clear: both">
                <div class="label"><?php echo e(__('Last name')); ?></div>
                <div class="val"><?php echo e($booking->last_name); ?></div>
            </div>
            <div class="info-email b-tr">
                <div class="label"><?php echo e(__('Email')); ?></div>
                <div class="val"><?php echo e($booking->email); ?></div>
            </div>
            <div class="info-phone b-tr">
                <div class="label"><?php echo e(__('Phone')); ?></div>
                <div class="val"><?php echo e($booking->phone); ?></div>
            </div>
            <div class="info-country b-tr">
                <div class="label"><?php echo e(__('Country')); ?></div>
                <div class="val"><?php echo e(get_country_name($booking->country)); ?></div>
            </div>
            <div class="info-notes b-tr">
                <div class="label"><?php echo e(__('Special Requirements')); ?></div>
                <div class="val"><?php echo e($booking->customer_notes); ?></div>
            </div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="mt20">
            <tr>
                <td width="50%" align="center">
                    <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-primary manage-booking-btn"><?php echo e(__('Book')); ?></a>
                </td>
                <td width="50%" align="center">
                    <a href="<?php echo e(get_page_url(11)); ?>" target="_blank" class="btn btn-primary manage-booking-btn"><?php echo e(__('Contact Us')); ?></a>
                </td>
            </tr>
        </table>
    </div>

</div>
-->
<style>
    .h-row{
        display: block;
        border-bottom: #ddd solid 1px;
    }
    .w-50{
        width: 50%;
        float: left;
        clear: both;
    }
    .panel_box{
        border: #ddd solid 1px;
        border-radius: 4px;
    }
    .border-right{
        border-right: #ddd solid 1px;
    }
</style>
<div class="b-panel-title" style="margin-bottom: 10px;"><?php echo e(__('Guest information')); ?></div>
<div class="b-panel">
<table border="1" width="100%">
<tbody>
    <tr>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('First name')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e($booking->first_name); ?></p>
        </td>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('Last name')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e($booking->last_name); ?></p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('Email')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e($booking->email); ?></p>
        </td>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('Phone')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e($booking->phone); ?></p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('Country')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e(get_country_name($booking->country)); ?></p>
        </td>
        <td>
            <p style="font-size: 13px; color: #919191; margin: 0; padding: 2px 5px;"><?php echo e(__('Special Requirements')); ?></p>
            <p style="color: #000; font-size: 16px; margin: 0; padding: 2px 5px;"><?php echo e($booking->customer_notes); ?></p>
        </td>
    </tr>
</tbody>
</table>
</div>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Base/Booking/Views/emails/parts/panel-customer.blade.php ENDPATH**/ ?>