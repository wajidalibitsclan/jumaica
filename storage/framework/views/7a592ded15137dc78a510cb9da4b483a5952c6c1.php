<div class="bravo_single_book_wrap">
    <div class="bravo_single_book border-0">
        <div id="bravo_car_book_app" v-cloak>
            <div id="bravo_results_map" class="results_map_inner d-none"></div>

            <div id="pickAddress" class="px-2 mt-2 mt-sm-0">
                <div class="form-group d-flex align-items-center border-bottom mb-0" id="fromAddress">
                    <svg class="field-icon fa" <?php if(empty($is_map)): ?> style="left:0" <?php endif; ?> width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.00001 0.25C5.1773 0.25215 3.42987 0.977169 2.14102 2.26602C0.852176 3.55486 0.127158 5.3023 0.125007 7.125C0.122824 8.61452 0.60937 10.0636 1.51001 11.25C1.51001 11.25 1.69751 11.4969 1.72813 11.5325L7.00001 17.75L12.2744 11.5294C12.3019 11.4963 12.49 11.25 12.49 11.25L12.4906 11.2481C13.3908 10.0623 13.8771 8.61383 13.875 7.125C13.8729 5.3023 13.1478 3.55486 11.859 2.26602C10.5701 0.977169 8.82271 0.25215 7.00001 0.25ZM7.00001 9.625C6.50555 9.625 6.0222 9.47838 5.61108 9.20367C5.19996 8.92897 4.87953 8.53852 4.69031 8.08171C4.50109 7.62489 4.45158 7.12223 4.54804 6.63727C4.64451 6.15232 4.88261 5.70686 5.23224 5.35723C5.58187 5.0076 6.02733 4.7695 6.51228 4.67304C6.99723 4.57657 7.4999 4.62608 7.95672 4.8153C8.41353 5.00452 8.80398 5.32495 9.07868 5.73607C9.35338 6.1472 9.50001 6.63055 9.50001 7.125C9.49918 7.78779 9.23552 8.42319 8.76686 8.89185C8.2982 9.36052 7.66279 9.62417 7.00001 9.625Z" fill="currentColor"/>
                    </svg>
                    <input type="text" placeholder="Enter Pickup location" value="<?php echo e(request('pickup_map_place')); ?>" name="from_address" id="inputFromAddress" class="form-control" >
                </div>
                <div class="form-group d-flex align-items-center mb-0" id="toAddress">
                    <svg class="field-icon fa" <?php if(empty($is_map)): ?> style="left:0" <?php endif; ?> width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.00001 0.25C5.1773 0.25215 3.42987 0.977169 2.14102 2.26602C0.852176 3.55486 0.127158 5.3023 0.125007 7.125C0.122824 8.61452 0.60937 10.0636 1.51001 11.25C1.51001 11.25 1.69751 11.4969 1.72813 11.5325L7.00001 17.75L12.2744 11.5294C12.3019 11.4963 12.49 11.25 12.49 11.25L12.4906 11.2481C13.3908 10.0623 13.8771 8.61383 13.875 7.125C13.8729 5.3023 13.1478 3.55486 11.859 2.26602C10.5701 0.977169 8.82271 0.25215 7.00001 0.25ZM7.00001 9.625C6.50555 9.625 6.0222 9.47838 5.61108 9.20367C5.19996 8.92897 4.87953 8.53852 4.69031 8.08171C4.50109 7.62489 4.45158 7.12223 4.54804 6.63727C4.64451 6.15232 4.88261 5.70686 5.23224 5.35723C5.58187 5.0076 6.02733 4.7695 6.51228 4.67304C6.99723 4.57657 7.4999 4.62608 7.95672 4.8153C8.41353 5.00452 8.80398 5.32495 9.07868 5.73607C9.35338 6.1472 9.50001 6.63055 9.50001 7.125C9.49918 7.78779 9.23552 8.42319 8.76686 8.89185C8.2982 9.36052 7.66279 9.62417 7.00001 9.625Z" fill="currentColor"/>
                    </svg>
                    <input type="text" placeholder="Enter dropoff location" value="<?php echo e(request('dropoff_map_place')); ?>" name="to_address" id="inputToAddress" class="form-control" >
                </div>
                <span class="rounded-pill px-2" @click="calculatorDistanceDuration" id="btnPickAddress"><i class="fa fa-search"></i></span>
            </div>
            <div class="mt-3 mb-3 text-center" v-html="distance_duration_html"></div>
            <div id="selectTripType" class=" d-flex justify-content-between mb-3">

                <div class="oneway-trip mr-3">
                    <div class="text-center" v-html="oneway_trip_price_html"></div>
                    <div class="btn w-100 btn-secondary one_way" @click="trip_type_selected=1" :class="{'btn-primary text-white':trip_type_selected}">
                        <?php echo e(__("Oneway Trip")); ?>

                    </div>
                </div>

                <div class="round-trip ">
                    <div class="text-center" v-html="round_trip_price_html"></div>
                    <div class="btn w-100 btn-secondary" @click="trip_type_selected=0;initDatepicker()" :class="{'btn-primary text-white':!trip_type_selected}">
                        <?php echo e(__("Round Trip")); ?>

                    </div>
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
                        <div class="form-floating border-right border-primary d-none d-md-block">
                            <input  ref="start_date" type="text" readonly placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>" class="form-control datecss bg-white" >
                            <label for="return"  ><?php echo e(__('Pickup Date')); ?></label>
                        </div>
                        <div class="form-floating border-right border-primary d-block d-md-none">
                            <input v-model="pickup_date" type="date" placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>" style="height: auto; padding-top: 0; margin-top: 36px;" class="form-control bg-white" >

                            <label for="return"  ><?php echo e(__('Pickup Date')); ?></label>
                        </div>


                        <div class="form-floating d-none d-md-block">
                            <vue-timepicker class=" datecss" format="HH:mm" close-on-complete v-model="pickup_time"></vue-timepicker>
                            <label class="always-top" for="return" ><?php echo e(__('Pickup Time')); ?></label>

                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton" style="min-width: 300px">

                                    <div class="card">
                                        <div class="card-header text-white bg-green">Pickup Time Guidance</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php echo e(setting_item('pickup_tooltip')); ?>

                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-floating d-block d-md-none">
                             <span class="vue__time-picker h-100">
                            <input type="time" format="HH:mm" placeholder="0" min="0" v-model="pickup_time" style="height: auto; padding-top: 0; margin-top: 36px;" class="form-control display-time" >
                             </span>
                            <label class="always-top" for="return" ><?php echo e(__('Pickup Time')); ?></label>

                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton" style="min-width: 300px">

                                    <div class="card">
                                        <div class="card-header text-white bg-green">Pickup Time Guidance</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php echo e(setting_item('pickup_tooltip')); ?>

                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="form-book-row d-flex justify-content-between" v-if="!trip_type_selected">
                        <div class="form-floating border-right border-primary d-none d-md-block">
                            <input ref="end_date" type="text" readonly  placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>" class="form-control datecss  bg-white" >
                            <label for="return"  ><?php echo e(__('Return Date')); ?></label>
                        </div>


                        <div class="form-floating border-right border-primary d-block d-md-none">
                            <input v-model="return_date" type="date" placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>" style="height: auto; padding-top: 0; margin-top: 36px;" class="form-control bg-white" >
                            <label for="return"  ><?php echo e(__('Return Date')); ?></label>
                        </div>



                        <div class="form-floating d-none d-md-block">
                            <vue-timepicker class=" datecss" close-on-complete format="HH:mm" v-model="return_time"></vue-timepicker>
                            <label class="always-top" for="return" ><?php echo e(__('Return Time')); ?></label>
                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton" style="min-width: 300px">

                                    <div class="card">
                                        <div class="card-header text-white bg-green">Return Time Guidance</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php echo e(setting_item('return_tooltip')); ?>

                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="form-floating d-block d-md-none">

                            <span class="vue__time-picker h-100">
                            <input type="time" format="HH:mm" placeholder="0" min="0" v-model="return_time" style="height: auto; padding-top: 0; margin-top: 36px;" class="form-control display-time" >
                             </span>

                            <label class="always-top" for="return" ><?php echo e(__('Return Time')); ?></label>


                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton" style="min-width: 300px">

                                    <div class="card">
                                        <div class="card-header text-white bg-green">Return Time Guidance</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php echo e(setting_item('return_tooltip')); ?>

                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating border-right border-primary">
                            <span class="vue__time-picker">
                            <input type="number" pattern="[0-9]*" v-model="passenger" placeholder="0" min="1"  class="form-control display-time" >
                                 </span>
                            <label for="return" class="always-top" ><?php echo e(__('Persons')); ?></label>
                        </div>
                        <div class="form-floating">
                              <span class="vue__time-picker">
                            <input type="number" pattern="[0-9]*" v-model="baggage" placeholder="0" min="0" class="form-control display-time" >
                              </span>
                            <label for="return" class="always-top"><?php echo e(__('Luggage')); ?></label>
                        </div>
                    </div>

                    <div class="border-bottom border-primary">
                        <div class="py-2 text-center">
                            <?php echo e(__('Enter your FLT # & if its late, we will wait')); ?>

                        </div>
                    </div>

                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating  border-primary " :class="{'border-right':!trip_type_selected ,'flex-grow-1':trip_type_selected}">
                            <input id="pickup_flight" type="text" v-model="pickup_flight" placeholder="AA1234"   class="form-control datecss" >
                            <label for="pickup_flight"  ><?php echo e(__('Pickup Flight #')); ?></label>
                        </div>
                        <div class="form-floating border-primary" v-if="!trip_type_selected">
                            <input id="return_flight" type="text" v-model="return_flight" placeholder="AA1234"   class="form-control datecss" >
                            <label for="return_flight"  ><?php echo e(__('Return Flight #')); ?></label>
                        </div>
                    </div>


                    <div class="form-book-row p-3" v-if="extra_price.length">
                        <h6 class="form-section-title"><?php echo e(__('Extras:')); ?></h6>
                        <div class="d-flex align-items-center justify-content-between pt-2" v-for="(type,index) in extra_price">
                            <div class=" flex-grow-1">
                                <label :for="'extra'+index"> {{type.name}} {{type.price_html}} <span v-if="type.price_type">({{type.price_type}})</span></label>

                            </div>
                            <div class="flex-shrink-0">
                                <input type="checkbox" true-value="1" false-value="0" v-model="type.enable" :id="'extra'+index">
                            </div>
                        </div>
                    </div>

                    <div class="form-book-row p-3" v-if="buyer_fees.length">
                        <div class="d-flex align-items-center justify-content-between pt-2" v-for="(type,index) in buyer_fees">
                            <div class=" flex-grow-1">
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
                        <label class="w-100 font-weight-bold " style="font-size:18px ;color:#0070C1">
                            <span class="font-weight-normal text-13"><?php echo e(__("Total")); ?></span>
                            <span class="text-green text-15">{{total_price_html}}</span>
                        </label>
                    </li>
                    <li v-if="is_deposit_ready">
                        <label for=""><?php echo e(__("Pay now")); ?></label>
                        <span class="price">{{pay_now_price_html}}</span>
                    </li>
                </ul>
                <div v-html="html"></div>
                <div class="" v-show="message.content">
                    <div class="alert-text mt10"  v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
                </div>
                <div class="submit-group d-flex justify-content-between btn-actions">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary mr-3 d-none d-md-block" style="font-size: 14px;color:#242E42;min-width: 45%; padding: 10px 20px !important;" >
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <a class="btn btn-secondary mr-3 d-block d-md-none" style="font-size: 14px;color:#242E42;min-width: 45%; padding: 10px 20px !important;" @click="doCancel($event)" >
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <a class="btn" style="font-size: 14px;min-width: 45%; padding: 10px 20px !important;" @click="doSubmit($event)" :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
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
                lat:<?php echo e(request('dropoff_map_lat',0)); ?>,
                lng:<?php echo e(request('dropoff_map_lng',0)); ?>,
                place_id:'<?php echo e(request('dropoff_place_id')); ?>',
            },
        }
        var bc_current_url = '<?php echo e(request()->url()); ?>'

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/testing.jamaicataxi.com/htdocs/themes/Jamrock/Tour/Views/frontend/layouts/details/form-book.blade.php ENDPATH**/ ?>