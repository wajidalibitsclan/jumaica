<div class="bravo_single_book_wrap">
    <div class="bravo_single_book border-0">
        <div id="bravo_car_book_app" v-cloak>
            <div id="bravo_results_map" class="results_map_inner d-none"></div>

            <div id="pickAddress" class="px-2 mt-2 mt-sm-0">
                <div class="form-group d-flex flex-column border-bottom mb-0" id="fromAddress">
                    <p style="margin: 0;
    padding: 0;color:#00B050;">Form?</p>
                    
                    
                    
                    <div>
                        <input type="text" placeholder="Enter Pickup location" value="<?php echo e(request('pickup_map_place')); ?>"
                               name="from_address" id="inputFromAddress" class="border-0">
                        <span class="map_clear pickup_clear" style="top: 10px !important;">
                            <img src="<?php echo e(asset('themes/jamrock/images/image11.png')); ?>" alt="">
                        </span>
                    </div>
                </div>
                <div class="form-group d-flex flex-column mb-0" id="toAddress">
                    <p
                        style="margin: 0;
    padding: 0;color: #0070C1 "
                    >To?</p>
                    
                    
                    
                    <div>
                        <input type="text" placeholder="Enter dropoff location" value="<?php echo e(request('dropoff_map_place')); ?>"
                               name="to_address" id="inputToAddress" class="border-0">
                        <span class="map_clear dropoff_clear" style="top: 60px !important;">
                            <img src="<?php echo e(asset('themes/jamrock/images/image11.png')); ?>" alt="">
                        </span>
                    </div>
                </div>
                
            </div>
            <div class="mt-1 text-center" v-html="distance_duration_html"></div>
            <div id="selectTripType" class=" d-flex justify-content-between mb-3">

                <div class="oneway-trip mr-3">
                    <div class="text-center" v-html="oneway_trip_price_html"></div>
                    <div class="btn w-100 btn-secondary one_way" @click="trip_type_selected=1"
                         :class="{'btn-primary-btn text-white':trip_type_selected}">
                        <?php echo e(__("Oneway Trip")); ?>

                    </div>
                </div>

                <div class="round-trip ">
                    <div class="text-center" v-html="round_trip_price_html"></div>
                    <div class="btn w-100 btn-secondary one_way" @click="trip_type_selected=0;initDatepicker()"
                         :class="{'btn-primary-btn text-white':!trip_type_selected}">
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

                <div id="formBookContent" class="border border-secondary rounded">

                    <div class="form-book-row d-flex justify-content-between">
                        <div class="form-floating border-right border-secondary d-none d-md-block">
                            <input ref="start_date" type="text" readonly placeholder="yyyy-mm-dd"
                                   min="<?php echo e(date('Y-m-d')); ?>" class="form-control datecss bg-white">
                            <label for="return"><?php echo e(__('Pickup Date')); ?></label>
                        </div>
                        <div class="form-floating border-right border-secondary d-block d-md-none">
                            <input v-model="pickup_date" type="date" placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>"
                                   style="height: auto; padding-top: 0; margin-top: 32px;"
                                   class="form-control bg-white">

                            <label for="return"><?php echo e(__('Pickup Date')); ?></label>
                        </div>


                        <div class="form-floating d-none d-md-block">
                            <vue-timepicker class=" datecss" format="HH:mm" close-on-complete
                                            v-model="pickup_time"></vue-timepicker>
                            <label class="always-top" for="return"><?php echo e(__('Pickup Time')); ?></label>

                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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
                            <input type="time" format="HH:mm" placeholder="0" min="0" v-model="pickup_time"
                                   style="height: auto; padding-top: 0; margin-top: 32px;"
                                   class="form-control display-time">
                             </span>
                            <label class="always-top" for="return"><?php echo e(__('Pickup Time')); ?></label>

                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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
                        <div class="form-floating border-right border-secondary d-none d-md-block">
                            <input ref="end_date" type="text" readonly placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>"
                                   class="form-control datecss  bg-white">
                            <label for="return"><?php echo e(__('Return Date')); ?></label>
                        </div>


                        <div class="form-floating border-right border-secondary d-block d-md-none">
                            <input v-model="return_date" type="date" placeholder="yyyy-mm-dd" min="<?php echo e(date('Y-m-d')); ?>"
                                   style="height: auto; padding-top: 0; margin-top: 32px;"
                                   class="form-control bg-white">
                            <label for="return"><?php echo e(__('Return Date')); ?></label>
                        </div>


                        <div class="form-floating d-none d-md-block">
                            <vue-timepicker class=" datecss" close-on-complete format="HH:mm"
                                            v-model="return_time"></vue-timepicker>
                            <label class="always-top" for="return"><?php echo e(__('Return Time')); ?></label>
                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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
                            <input type="time" format="HH:mm" placeholder="0" min="0" v-model="return_time"
                                   style="height: auto; padding-top: 0; margin-top: 32px;"
                                   class="form-control display-time">
                             </span>

                            <label class="always-top" for="return"><?php echo e(__('Return Time')); ?></label>


                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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
                        <div class="form-floating border-right border-secondary">
                            <span class="vue__time-picker">
                            <input type="number" pattern="[0-9]*" v-model="passenger" placeholder="0" min="1"
                                   class="form-control display-time">
                                 </span>
                            <label for="return" class="always-top"><?php echo e(__('Persons')); ?></label>
                        </div>
                        <div class="form-floating">
                              <span class="vue__time-picker">
                            <input type="number" pattern="[0-9]*" v-model="baggage" placeholder="0" min="0"
                                   class="form-control display-time">
                              </span>
                            <label for="return" class="always-top"><?php echo e(__('Luggage')); ?></label>
                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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

                    <div class="border-bottom border-secondary">
                        <div class="py-2 text-center form-floating">
                            <?php echo e(__('Enter your flight # and if its late, we will wait!')); ?>


                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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
                        <div class="form-floating  border-secondary "
                             :class="{'border-right':!trip_type_selected ,'flex-grow-1':trip_type_selected}">
                            <input id="pickup_flight" type="text" v-model="pickup_flight" placeholder="AA1234"
                                   class="form-control datecss">
                            <label for="pickup_flight"><?php echo e(__('Pickup Flight #')); ?></label>
                        </div>
                        <div class="form-floating border-secondary" v-if="!trip_type_selected">
                            <input id="return_flight" type="text" v-model="return_flight" placeholder="AA1234"
                                   class="form-control datecss">
                            <label for="return_flight"><?php echo e(__('Return Flight #')); ?></label>

                            <div class="dropdown more_info_tooltip ">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo e(asset('themes/jamrock/images/new-image20.png')); ?>"/>
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                     style="min-width: 300px">

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


                    <div class="form-book-row p-3" v-if="extra_price.length">
                        <h6 class="form-section-title"><?php echo e(__('Extras:')); ?></h6>
                        <div class="d-flex align-items-center justify-content-between pt-2"
                             v-for="(type,index) in extra_price">
                            <div class=" flex-grow-1">
                                <label :for="'extra'+index"> {{type.name}} {{type.price_html}} <span
                                        v-if="type.price_type">({{type.price_type}})</span></label>

                            </div>
                            <div class="flex-shrink-0">
                                <input type="checkbox" true-value="1" false-value="0" v-model="type.enable"
                                       :id="'extra'+index">
                            </div>
                        </div>
                    </div>

                    <div class="form-book-row p-3" v-if="buyer_fees.length">
                        <div class="d-flex align-items-center justify-content-between pt-2"
                             v-for="(type,index) in buyer_fees">
                            <div class=" flex-grow-1">
                                <label>{{type.type_name}}
                                    <i class="icofont-info-circle" v-if="type.desc" data-toggle="tooltip"
                                       data-placement="top" :title="type.type_desc"></i>
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






                    <li v-if="is_deposit_ready">
                        <label for=""><?php echo e(__("Pay now")); ?></label>
                        <span class="price">{{pay_now_price_html}}</span>
                    </li>
                </ul>
                <div v-html="html"></div>
                <div class="" v-show="message.content">
                    <div class="alert-text mt10" v-html="message.content"
                         :class="{'danger':!message.type,'success':message.type}"></div>
                </div>
                <div class="submit-group d-flex justify-content-between btn-actions">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary mr-3 d-none d-md-block"
                       style="font-size: 14px;color:#242E42;min-width: 45%; padding: 10px 20px !important;">
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <a class="btn btn-secondary  d-block d-md-none"
                       style="font-size: 14px;color:#242E42;min-width: 33%; padding: 10px 20px !important;"
                       @click="doCancel($event)">
                        <span><?php echo e(__("Back")); ?></span>
                    </a>
                    <label class="font-weight-bold " style="font-size: 18px;
    color: rgb(0, 112, 193);
    border: 2px solid #00B050;
    background: #fff;
    border-radius: 5px;
    padding: 2px 12px;">
                        <span class="font-weight-normal text-13 text-green"><?php echo e(__("TOTAL")); ?></span>
                        <span class="text-green text-15">{{total_price_html}}</span>
                    </label>
                    <a class="btn" style="font-size: 14px;min-width: 33%; padding: 10px 20px !important;"
                       @click="doSubmit($event)"
                       :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
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
            from: {
                lat: <?php echo e(request('pickup_map_lat',0)); ?>,
                lng: <?php echo e(request('pickup_map_lng',0)); ?>,
                place_id: '<?php echo e(request('pickup_place_id')); ?>',
            },
            to: {
                lat: <?php echo e(request('dropoff_map_lat',0)); ?>,
                lng: <?php echo e(request('dropoff_map_lng',0)); ?>,
                place_id: '<?php echo e(request('dropoff_place_id')); ?>',
            },
        }
        var bc_current_url = '<?php echo e(request()->url()); ?>'

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Car/Views/frontend/layouts/details/form-book.blade.php ENDPATH**/ ?>