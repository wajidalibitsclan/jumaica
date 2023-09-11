<div class="bravo_single_book_wrap">
    <div class="bravo_single_book border-0">
        <div id="bravo_tour_car_book_app" v-cloak>
            <div class="text-center px-2 py-3" style="background: #E9F0F6">
                <i class="<?php echo e($row->getServiceIconFeatured()); ?>"></i>
                <?php echo e($row->title); ?>

            </div>

            <div id="bravo_results_map" class="results_map_inner d-none"></div>
            <div id="pickAddress" class="px-2">
                <div class="form-group d-flex align-items-center mb-0" id="toAddress">
                    <input type="hidden" value="<?php echo e($row->address); ?>" name="to_address" id="inputToAddress" class="form-control" >
                </div>
            </div>
            <div class="nav-enquiry my-3" v-if="is_form_enquiry_and_book">
                <div class="enquiry-item active">
                    <span><?php echo e(__("Book")); ?></span>
                </div>
                <div class="enquiry-item" data-toggle="modal" data-target="#enquiry_form_modal">
                    <span><?php echo e(__("Enquiry")); ?></span>
                </div>
            </div>
            <div class="form-book" :class="{'d-none':enquiry_type!='book'}">

                <div id="formBookContent" class="border border-primary rounded">

                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating border-right border-primary flex-grow-1">
                            <input type="text" value="<?php echo e(request('pickup_map_place')); ?>" placeholder="<?php echo e(__('Enter your pickup location..')); ?>" name="from_address" id="inputFromAddress" class="form-control" >
                            <label for="return"  ><?php echo e(__('Pickup Location')); ?></label>
                        </div>
                    </div>
                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating border-right border-primary">
                            <input ref="start_date" type="text" readonly placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>" class="form-control datecss bg-white" >
                            <label for="return"  ><?php echo e(__('Pickup Date')); ?></label>
                        </div>
                        <div class="form-floating">
                            <vue-timepicker class=" datecss" format="HH:mm" close-on-complete v-model="pickup_time"></vue-timepicker>
                            <label class="always-top" for="return" ><?php echo e(__('Pickup Time')); ?></label>
                        </div>
                    </div>

                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating border-right border-primary">
                            <input type="number" pattern="[0-9]*" v-model="passenger" placeholder="0" min="0"  class="form-control " >
                            <label for="return"  ><?php echo e(__('Persons')); ?></label>
                        </div>
                        <div class="form-floating">
                            <input type="text" :value="distance_duration_html" placeholder="0" min="0" class="form-control " >
                            <label for="return" ><?php echo e(__('Travel Time')); ?></label>
                        </div>
                    </div>


                    <div class="form-book-row p-3" v-if="extra_price.length">
                        <h6 class="form-section-title"><?php echo e(__('Extras:')); ?></h6>
                        <div class="d-flex align-items-center justify-content-between pt-2" v-for="(type,index) in extra_price">
                            <div class=" flex-grow-1">
                                <label :for="'extra'+index"> {{type.name}} {{type.price_html}} <span  v-if="type.price_type">({{type.price_type}})</span></label>

                            </div>
                            <div class="flex-shrink-0">
                                <input type="checkbox" true-value="1" false-value="0" v-model="type.enable" :id="'extra'+index">
                            </div>
                        </div>
                    </div>

                    <div class="form-book-row p-3" v-if="buyer_fees.length">
                        <div class="d-flex align-items-center justify-content-between pt-2" v-for="(type,index) in buyer_fees">
                            <div class="font-weight-bold flex-grow-1">
                                <label>{{type.type_name}}
                                    <i class="icofont-info-circle" v-if="type.desc" data-toggle="tooltip" data-placement="top" :title="type.type_desc"></i>
                                </label>
                                <div class="render" v-if="type.price_type">({{type.price_type}})</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="unit" v-if='type.unit == "percent"'>
                                    {{ type.price }}%
                                </div>
                                <div class="unit" v-else>
                                    {{ formatMoney(type.price) }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <ul class="form-section-total list-unstyled pb-0" v-if="total_price > 0">
                    <li class="text-center">
                        <label class="w-100 font-weight-bold " style="font-size:18px ;color:#0070C1"><span class="font-weight-normal"><?php echo e(__("Total")); ?></span> {{total_price_html}}</label>
                    </li>
                    <li v-if="is_deposit_ready">
                        <label for=""><?php echo e(__("Pay now")); ?></label>
                        <span class="price">{{pay_now_price_html}}</span>
                    </li>
                </ul>
                <div v-html="html"></div>
                <div class="submit-group" v-show="message.content">
                    <div class="alert-text mt10"  v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
                </div>
                <div class="submit-group d-flex justify-content-between btn-actions">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary mr-3 mr-3 d-none d-md-block" style="font-size: 14px;color:#242E42; padding: 10px 20px !important;" @click="doCancel($event)" >
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <a class="btn btn-secondary mr-3 d-block d-md-none" style="font-size: 14px;color:#242E42; padding: 10px 20px !important;" @click="doCancel($event)" >
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <a class="btn btn-large" style="font-size: 14px;padding: 10px 20px !important;" @click="doSubmit($event)" :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
                        <span v-if="step == 1"><?php echo e(__("Continue")); ?></span>
                        <span v-if="step == 2"><?php echo e(__("Continue")); ?></span>
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                    </a>
                </div>
            </div>
            <div class="form-send-enquiry" v-show="enquiry_type=='enquiry'">
                <button class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">
                    <?php echo e(__("Contact Now")); ?>

                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make("Booking::frontend.global.enquiry-form",['service_type'=>'car'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        var currentDirection = {
            from:{
                lat:<?php echo e(request('pickup_map_lat',0)); ?>,
                lng:<?php echo e(request('pickup_map_lng',0)); ?>,
                place_id:'<?php echo e(request('pickup_place_id')); ?>',
            },
            to:{
                lat:<?php echo e($row->map_lat??0); ?>,
                lng:<?php echo e($row->map_lng??0); ?>,
                place_id:'<?php echo e(request('dropoff_place_id')); ?>',
            },
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Tour/Views/frontend/layouts/details/form-book.blade.php ENDPATH**/ ?>