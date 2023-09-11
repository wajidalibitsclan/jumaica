<?php if(floatval($booking->deposit) and in_array($booking->status,['draft','unpaid'])): ?>
    <?php
    $oldDeposit = $booking->getMeta('old_deposit');
    $deposit = $booking->deposit;
    if (empty(floatval($deposit))){
        $deposit  = !empty($oldDeposit)?floatval($oldDeposit):0;
    }
    ;?>
    <hr>
    <div class="form-section">
        <h4 class="form-section-title"><?php echo e(__("How do you want to pay?")); ?></h4>
        <div class="deposit_types gateways-table accordion ">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-0"><label ><input type="radio" checked name="how_to_pay" value="deposit">
                                <?php echo e(__("Pay deposit")); ?>

                            </label></h4>
                        <span class="price"><strong><?php echo e(format_money($deposit)); ?></strong></span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-0"><label ><input type="radio"  name="how_to_pay" value="full">
                                <?php echo e(__("Pay in full")); ?>

                            </label></h4>
                        <span class="price"><strong><?php echo e(format_money($booking->total)); ?></strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/BC/Booking/Views/frontend/booking/checkout-deposit.blade.php ENDPATH**/ ?>