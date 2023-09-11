<div class="form-checkout " id="form-checkout" >
    <input type="hidden" name="code" value="<?php echo e($booking->code); ?>">
    <div class="form-section custom_checkout_style">
        <div class="row">

<!--            <?php if(is_enable_guest_checkout() && is_enable_registration()): ?>
                <div class="col-12">
                    <div class="form-group">
                        <label for="confirmRegister">
                            <input type="checkbox" name="confirmRegister" id="confirmRegister" value="1">
                            <?php echo e(__('Create a new account?')); ?>

                        </label>
                    </div>
                </div>
            <?php endif; ?>-->
            <div class="col-6 pr-0">
                <div class="form-group border-right">
                    <label ><?php echo e(__("First Name")); ?> <span class="required">*</span></label>
                    <input type="text" class="form-control" value="<?php echo e($user->first_name ?? ''); ?>" name="first_name">
                </div>
            </div>
            <div class="col-6 pl-0">
                <div class="form-group">
                    <label ><?php echo e(__("Last Name")); ?> <span class="required">*</span></label>
                    <input type="text" class="form-control" value="<?php echo e($user->last_name ?? ''); ?>" name="last_name">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group border-right">
                    <label ><?php echo e(__("Email")); ?> <span class="required">*</span></label>
                    <input type="email" class="form-control" value="<?php echo e($user->email ?? ''); ?>" name="email">
                </div>
            </div>

            <div class="col-6 field-country pr-0">
                <div class="form-group border-right">
                    <label ><?php echo e(__("Country")); ?> <span class="required">*</span> </label>
                    <select name="country" class="form-control select_country">
                        <option value=""><?php echo e(__('-- Select --')); ?></option>
                        

                        <option value="DZ" data-code="213">Algeria (+213)</option>
                        <option value="AD" data-code="376">Andorra (+376)</option>
                        <option value="AO" data-code="244">Angola (+244)</option>
                        <option value="AI" data-code="1264">Anguilla (+1264)</option>
                        <option value="AG" data-code="1268">Antigua &amp; Barbuda (+1268)</option>
                        <option value="AR" data-code="54">Argentina (+54)</option>
                        <option value="AM" data-code="374">Armenia (+374)</option>
                        <option value="AW" data-code="297">Aruba (+297)</option>
                        <option value="AU" data-code="61">Australia (+61)</option>
                        <option value="AT" data-code="43">Austria (+43)</option>
                        <option value="AZ" data-code="994">Azerbaijan (+994)</option>
                        <option value="BS" data-code="1242">Bahamas (+1242)</option>
                        <option value="BH" data-code="973">Bahrain (+973)</option>
                        <option value="BD" data-code="880">Bangladesh (+880)</option>
                        <option value="BB" data-code="1246">Barbados (+1246)</option>
                        <option value="BY" data-code="375">Belarus (+375)</option>
                        <option value="BE" data-code="32">Belgium (+32)</option>
                        <option value="BZ" data-code="501">Belize (+501)</option>
                        <option value="BJ" data-code="229">Benin (+229)</option>
                        <option value="BM" data-code="1441">Bermuda (+1441)</option>
                        <option value="BT" data-code="975">Bhutan (+975)</option>
                        <option value="BO" data-code="591">Bolivia (+591)</option>
                        <option value="BA" data-code="387">Bosnia Herzegovina (+387)</option>
                        <option value="BW" data-code="267">Botswana (+267)</option>
                        <option value="BR" data-code="55">Brazil (+55)</option>
                        <option value="BN" data-code="673">Brunei (+673)</option>
                        <option value="BG" data-code="359">Bulgaria (+359)</option>
                        <option value="BF" data-code="226">Burkina Faso (+226)</option>
                        <option value="BI" data-code="257">Burundi (+257)</option>
                        <option value="KH" data-code="855">Cambodia (+855)</option>
                        <option value="CM" data-code="237">Cameroon (+237)</option>
                        <option value="CA" data-code="1">Canada (+1)</option>
                        <option value="CV" data-code="238">Cape Verde Islands (+238)</option>
                        <option value="KY" data-code="1345">Cayman Islands (+1345)</option>
                        <option value="CF" data-code="236">Central African Republic (+236)</option>
                        <option value="CL" data-code="56">Chile (+56)</option>
                        <option value="CN" data-code="86">China (+86)</option>
                        <option value="CO" data-code="57">Colombia (+57)</option>
                        <option value="KM" data-code="269">Comoros (+269)</option>
                        <option value="CG" data-code="242">Congo (+242)</option>
                        <option value="CK" data-code="682">Cook Islands (+682)</option>
                        <option value="CR" data-code="506">Costa Rica (+506)</option>
                        <option value="HR" data-code="385">Croatia (+385)</option>
                        <option value="CU" data-code="53">Cuba (+53)</option>
                        <option value="CY" data-code="90392">Cyprus North (+90392)</option>
                        <option value="CY" data-code="357">Cyprus South (+357)</option>
                        <option value="CZ" data-code="42">Czech Republic (+42)</option>
                        <option value="DK" data-code="45">Denmark (+45)</option>
                        <option value="DJ" data-code="253">Djibouti (+253)</option>
                        <option value="DM" data-code="1809">Dominica (+1809)</option>
                        <option value="DO" data-code="1809">Dominican Republic (+1809)</option>
                        <option value="EC" data-code="593">Ecuador (+593)</option>
                        <option value="EG" data-code="20">Egypt (+20)</option>
                        <option value="SV" data-code="503">El Salvador (+503)</option>
                        <option value="GQ" data-code="240">Equatorial Guinea (+240)</option>
                        <option value="ER" data-code="291">Eritrea (+291)</option>
                        <option value="EE" data-code="372">Estonia (+372)</option>
                        <option value="ET" data-code="251">Ethiopia (+251)</option>
                        <option value="FK" data-code="500">Falkland Islands (+500)</option>
                        <option value="FO" data-code="298">Faroe Islands (+298)</option>
                        <option value="FJ" data-code="679">Fiji (+679)</option>
                        <option value="FI" data-code="358">Finland (+358)</option>
                        <option value="FR" data-code="33">France (+33)</option>
                        <option value="GF" data-code="594">French Guiana (+594)</option>
                        <option value="PF" data-code="689">French Polynesia (+689)</option>
                        <option value="GA" data-code="241">Gabon (+241)</option>
                        <option value="GM" data-code="220">Gambia (+220)</option>
                        <option value="GE" data-code="7880">Georgia (+7880)</option>
                        <option value="DE" data-code="49">Germany (+49)</option>
                        <option value="GH" data-code="233">Ghana (+233)</option>
                        <option value="GI" data-code="350">Gibraltar (+350)</option>
                        <option value="GR" data-code="30">Greece (+30)</option>
                        <option value="GL" data-code="299">Greenland (+299)</option>
                        <option value="GD" data-code="1473">Grenada (+1473)</option>
                        <option value="GP" data-code="590">Guadeloupe (+590)</option>
                        <option value="GU" data-code="671">Guam (+671)</option>
                        <option value="GT" data-code="502">Guatemala (+502)</option>
                        <option value="GN" data-code="224">Guinea (+224)</option>
                        <option value="GW" data-code="245">Guinea - Bissau (+245)</option>
                        <option value="GY" data-code="592">Guyana (+592)</option>
                        <option value="HT" data-code="509">Haiti (+509)</option>
                        <option value="HN" data-code="504">Honduras (+504)</option>
                        <option value="HK" data-code="852">Hong Kong (+852)</option>
                        <option value="HU" data-code="36">Hungary (+36)</option>
                        <option value="IS" data-code="354">Iceland (+354)</option>
                        <option value="IN" data-code="91">India (+91)</option>
                        <option value="ID" data-code="62">Indonesia (+62)</option>
                        <option value="IR" data-code="98">Iran (+98)</option>
                        <option value="IQ" data-code="964">Iraq (+964)</option>
                        <option value="IE" data-code="353">Ireland (+353)</option>
                        <option value="IL" data-code="972">Israel (+972)</option>
                        <option value="IT" data-code="39">Italy (+39)</option>
                        <option value="JM" data-code="1876">Jamaica (+1876)</option>
                        <option value="JP" data-code="81">Japan (+81)</option>
                        <option value="JO" data-code="962">Jordan (+962)</option>
                        <option value="KZ" data-code="7">Kazakhstan (+7)</option>
                        <option value="KE" data-code="254">Kenya (+254)</option>
                        <option value="KI" data-code="686">Kiribati (+686)</option>
                        <option value="KP" data-code="850">Korea North (+850)</option>
                        <option value="KR" data-code="82">Korea South (+82)</option>
                        <option value="KW" data-code="965">Kuwait (+965)</option>
                        <option value="KG" data-code="996">Kyrgyzstan (+996)</option>
                        <option value="LA" data-code="856">Laos (+856)</option>
                        <option value="LV" data-code="371">Latvia (+371)</option>
                        <option value="LB" data-code="961">Lebanon (+961)</option>
                        <option value="LS" data-code="266">Lesotho (+266)</option>
                        <option value="LR" data-code="231">Liberia (+231)</option>
                        <option value="LY" data-code="218">Libya (+218)</option>
                        <option value="LI" data-code="417">Liechtenstein (+417)</option>
                        <option value="LT" data-code="370">Lithuania (+370)</option>
                        <option value="LU" data-code="352">Luxembourg (+352)</option>
                        <option value="MO" data-code="853">Macao (+853)</option>
                        <option value="MK" data-code="389">Macedonia (+389)</option>
                        <option value="MG" data-code="261">Madagascar (+261)</option>
                        <option value="MW" data-code="265">Malawi (+265)</option>
                        <option value="MY" data-code="60">Malaysia (+60)</option>
                        <option value="MV" data-code="960">Maldives (+960)</option>
                        <option value="ML" data-code="223">Mali (+223)</option>
                        <option value="MT" data-code="356">Malta (+356)</option>
                        <option value="MH" data-code="692">Marshall Islands (+692)</option>
                        <option value="MQ" data-code="596">Martinique (+596)</option>
                        <option value="MR" data-code="222">Mauritania (+222)</option>
                        <option value="YT" data-code="269">Mayotte (+269)</option>
                        <option value="MX" data-code="52">Mexico (+52)</option>
                        <option value="FM" data-code="691">Micronesia (+691)</option>
                        <option value="MD" data-code="373">Moldova (+373)</option>
                        <option value="MC" data-code="377">Monaco (+377)</option>
                        <option value="MN" data-code="976">Mongolia (+976)</option>
                        <option value="MS" data-code="1664">Montserrat (+1664)</option>
                        <option value="MA" data-code="212">Morocco (+212)</option>
                        <option value="MZ" data-code="258">Mozambique (+258)</option>
                        <option value="MN" data-code="95">Myanmar (+95)</option>
                        <option value="NA" data-code="264">Namibia (+264)</option>
                        <option value="NR" data-code="674">Nauru (+674)</option>
                        <option value="NP" data-code="977">Nepal (+977)</option>
                        <option value="NL" data-code="31">Netherlands (+31)</option>
                        <option value="NC" data-code="687">New Caledonia (+687)</option>
                        <option value="NZ" data-code="64">New Zealand (+64)</option>
                        <option value="NI" data-code="505">Nicaragua (+505)</option>
                        <option value="NE" data-code="227">Niger (+227)</option>
                        <option value="NG" data-code="234">Nigeria (+234)</option>
                        <option value="NU" data-code="683">Niue (+683)</option>
                        <option value="NF" data-code="672">Norfolk Islands (+672)</option>
                        <option value="NP" data-code="670">Northern Marianas (+670)</option>
                        <option value="NO" data-code="47">Norway (+47)</option>
                        <option value="OM" data-code="968">Oman (+968)</option>
                        <option value="PW" data-code="680">Palau (+680)</option>
                        <option value="PA" data-code="507">Panama (+507)</option>
                        <option value="PG" data-code="675">Papua New Guinea (+675)</option>
                        <option value="PY" data-code="595">Paraguay (+595)</option>
                        <option value="PE" data-code="51">Peru (+51)</option>
                        <option value="PH" data-code="63">Philippines (+63)</option>
                        <option value="PL" data-code="48">Poland (+48)</option>
                        <option value="PT" data-code="351">Portugal (+351)</option>
                        <option value="PR" data-code="1787">Puerto Rico (+1787)</option>
                        <option value="QA" data-code="974">Qatar (+974)</option>
                        <option value="RE" data-code="262">Reunion (+262)</option>
                        <option value="RO" data-code="40">Romania (+40)</option>
                        <option value="RU" data-code="7">Russia (+7)</option>
                        <option value="RW" data-code="250">Rwanda (+250)</option>
                        <option value="SM" data-code="378">San Marino (+378)</option>
                        <option value="ST" data-code="239">Sao Tome &amp; Principe (+239)</option>
                        <option value="SA" data-code="966">Saudi Arabia (+966)</option>
                        <option value="SN" data-code="221">Senegal (+221)</option>
                        <option value="CS" data-code="381">Serbia (+381)</option>
                        <option value="SC" data-code="248">Seychelles (+248)</option>
                        <option value="SL" data-code="232">Sierra Leone (+232)</option>
                        <option value="SG" data-code="65">Singapore (+65)</option>
                        <option value="SK" data-code="421">Slovak Republic (+421)</option>
                        <option value="SI" data-code="386">Slovenia (+386)</option>
                        <option value="SB" data-code="677">Solomon Islands (+677)</option>
                        <option value="SO" data-code="252">Somalia (+252)</option>
                        <option value="ZA" data-code="27">South Africa (+27)</option>
                        <option value="ES" data-code="34">Spain (+34)</option>
                        <option value="LK" data-code="94">Sri Lanka (+94)</option>
                        <option value="SH" data-code="290">St. Helena (+290)</option>
                        <option value="KN" data-code="1869">St. Kitts (+1869)</option>
                        <option value="SC" data-code="1758">St. Lucia (+1758)</option>
                        <option value="SD" data-code="249">Sudan (+249)</option>
                        <option value="SR" data-code="597">Suriname (+597)</option>
                        <option value="SZ" data-code="268">Swaziland (+268)</option>
                        <option value="SE" data-code="46">Sweden (+46)</option>
                        <option value="CH" data-code="41">Switzerland (+41)</option>
                        <option value="SI" data-code="963">Syria (+963)</option>
                        <option value="TW" data-code="886">Taiwan (+886)</option>
                        <option value="TJ" data-code="7">Tajikstan (+7)</option>
                        <option value="TH" data-code="66">Thailand (+66)</option>
                        <option value="TG" data-code="228">Togo (+228)</option>
                        <option value="TO" data-code="676">Tonga (+676)</option>
                        <option value="TT" data-code="1868">Trinidad &amp; Tobago (+1868)</option>
                        <option value="TN" data-code="216">Tunisia (+216)</option>
                        <option value="TR" data-code="90">Turkey (+90)</option>
                        <option value="TM" data-code="7">Turkmenistan (+7)</option>
                        <option value="TM" data-code="993">Turkmenistan (+993)</option>
                        <option value="TC" data-code="1649">Turks &amp; Caicos Islands (+1649)</option>
                        <option value="TV" data-code="688">Tuvalu (+688)</option>
                        <option value="UG" data-code="256">Uganda (+256)</option>
                       <option value="GB" data-code="44">UK (+44)</option>
                        <option value="UA" data-code="380">Ukraine (+380)</option>
                        <option value="AE" data-code="971">United Arab Emirates (+971)</option>
                        <option value="UY" data-code="598">Uruguay (+598)</option>
                        <option value="US" selected data-code="1">USA (+1)</option>
                        <option value="UZ" data-code="7">Uzbekistan (+7)</option>
                        <option value="VU" data-code="678">Vanuatu (+678)</option>
                        <option value="VA" data-code="379">Vatican City (+379)</option>
                        <option value="VE" data-code="58">Venezuela (+58)</option>
                        <option value="VN" data-code="84">Vietnam (+84)</option>
                        <option value="VG" data-code="84">Virgin Islands - British (+1284)</option>
                        <option value="VI" data-code="84">Virgin Islands - US (+1340)</option>
                        <option value="WF" data-code="681">Wallis &amp; Futuna (+681)</option>
                        <option value="YE" data-code="969">Yemen (North)(+969)</option>
                        <option value="YE" data-code="967">Yemen (South)(+967)</option>
                        <option value="ZM" data-code="260">Zambia (+260)</option>
                        <option value="ZW" data-code="263">Zimbabwe (+263)</option>
                    </select>
                </div>
            </div>

                <div class="col-6 pl-0">
                    <div class="form-group c_code">
                        <label ><?php echo e(__("Phone")); ?> <span class="required">*</span> <i class="fa fa-info-circle" style="color: #0a58ca" data-toggle="tooltip" data-placement="top" title="Please include your country code"></i></label>
                        <span class="country_code">+1</span>
                        <input type="text" class="form-control" value="<?php echo e($user->phone ?? ''); ?>" name="phone">
                    </div>
                </div>


                <?php if(is_enable_guest_checkout()): ?>
                    <div class="col-12" id="confirmRegisterContent">
                        <div class="row">
                            <div class="col-6 pr-0" >
                                <div class="form-group border-right">
                                    <label ><?php echo e(__("Password")); ?> <span class="required">*</span></label>
                                    <input type="password" class="form-control" name="password" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-6 pl-0">
                                <div class="form-group">
                                    <label for=""><?php echo e(__('Password confirmation')); ?> <span class="required">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <div class="col-md-12">
                <div class="form-group">
                <label ><?php echo e(__("Special Requirements")); ?> </label>
                <textarea name="customer_notes" cols="30" rows="6" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('Booking::frontend/booking/checkout-passengers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Booking::frontend/booking/checkout-deposit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make($service->checkout_form_payment_file ?? 'Booking::frontend/booking/checkout-payment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php
    $term_conditions = setting_item('booking_term_conditions');
    ?>

    <div class="form-group">
        <label class="term-conditions-checkbox">
            <input type="checkbox" name="term_conditions"> <?php echo e(__('I have read and accept the')); ?>  <a target="_blank" data-toggle="modal" href="#term_conditions"><?php echo e(__('terms and conditions')); ?></a>
        </label>
    </div>
    <?php if(setting_item("booking_enable_recaptcha")): ?>
        <div class="form-group">
            <?php echo e(recaptcha_field('booking')); ?>

        </div>
    <?php endif; ?>
    <div class="html_before_actions"></div>

    <p class="alert-text mt10" v-show=" message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></p>

<!--    <div class="form-actions">
        <button class="btn btn-danger" @click="doCheckout"><?php echo e(__('Submit')); ?>

            <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
        </button>
    </div>-->


    <div class="d-flex justify-content-between">
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary" style="min-width: 105px">Back</a>

        <button type="button" class="btn btn-primary" style=" background: #00B050"> <?php echo e(format_money($booking->total)); ?></button>
        <button type="submit" class="btn btn-primary" @click="doCheckout">
            Continue
            <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
        </button>
    </div>

</div>
<div class="modal" tabindex="-1" id="term_conditions">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $p = \Modules\Page\Models\Page::find($term_conditions); ?>
                <?php if($p): ?>
                    <?php echo clean($p->content); ?>

                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('js'); ?>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
       $(document).ready(function (){
           $('.select_country').on('change', function (){
               var val = $(this).val();
               var code = null;

               $('.select_country option').each(function (){
                   if($(this).attr('value') === val){
                       code = $(this).attr('data-code');
                   }
               })

               $('.c_code span.country_code').html('+'+code);
           })
       })


    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/MAMP/htdocs/jamaica_texi/themes/Jamrock/Booking/Views/frontend/booking/checkout-form.blade.php ENDPATH**/ ?>