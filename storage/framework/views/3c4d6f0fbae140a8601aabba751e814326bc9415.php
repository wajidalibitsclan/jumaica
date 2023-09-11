<div class="form-checkout " id="form-checkout" >
    <input type="hidden" name="code" value="<?php echo e($booking->code); ?>">
    <div class="form-section custom_checkout_style">
        <div class="row">
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
                        

                        <option value="DZ-213" data-code="213">Algeria (+213)</option>
                        <option value="AD-376" data-code="376">Andorra (+376)</option>
                        <option value="AO-244" data-code="244">Angola (+244)</option>
                        <option value="AI-1264" data-code="1264">Anguilla (+1264)</option>
                        <option value="AG-1268" data-code="1268">Antigua & Barbuda (+1268)</option>
                        <option value="AR-54" data-code="54">Argentina (+54)</option>
                        <option value="AM-374" data-code="374">Armenia (+374)</option>
                        <option value="AW-297" data-code="297">Aruba (+297)</option>
                        <option value="AU-61" data-code="61">Australia (+61)</option>
                        <option value="AT-43" data-code="43">Austria (+43)</option>
                        <option value="AZ-994" data-code="994">Azerbaijan (+994)</option>
                        <option value="BS-1242" data-code="1242">Bahamas (+1242)</option>
                        <option value="BH-973" data-code="973">Bahrain (+973)</option>
                        <option value="BD-880" data-code="880">Bangladesh (+880)</option>
                        <option value="BB-1246" data-code="1246">Barbados (+1246)</option>
                        <option value="BY-375" data-code="375">Belarus (+375)</option>
                        <option value="BE-32" data-code="32">Belgium (+32)</option>
                        <option value="BZ-501" data-code="501">Belize (+501)</option>
                        <option value="BJ-229" data-code="229">Benin (+229)</option>
                        <option value="BM-1441" data-code="1441">Bermuda (+1441)</option>
                        <option value="BT-975" data-code="975">Bhutan (+975)</option>
                        <option value="BO-591" data-code="591">Bolivia (+591)</option>
                        <option value="BA-387" data-code="387">Bosnia Herzegovina (+387)</option>
                        <option value="BW-267" data-code="267">Botswana (+267)</option>
                        <option value="BR-55" data-code="55">Brazil (+55)</option>
                        <option value="BN-673" data-code="673">Brunei (+673)</option>
                        <option value="BG-359" data-code="359">Bulgaria (+359)</option>
                        <option value="BF-226" data-code="226">Burkina Faso (+226)</option>
                        <option value="BI-257" data-code="257">Burundi (+257)</option>
                        <option value="KH-855" data-code="855">Cambodia (+855)</option>
                        <option value="CM-237" data-code="237">Cameroon (+237)</option>
                        <option value="CA-1" data-code="1">Canada (+1)</option>
                        <option value="CV-238" data-code="238">Cape Verde Islands (+238)</option>
                        <option value="KY-1345" data-code="1345">Cayman Islands (+1345)</option>
                        <option value="CF-236" data-code="236">Central African Republic (+236)</option>
                        <option value="CL-56" data-code="56">Chile (+56)</option>
                        <option value="CN-86" data-code="86">China (+86)</option>
                        <option value="CO-57" data-code="57">Colombia (+57)</option>
                        <option value="KM-269" data-code="269">Comoros (+269)</option>
                        <option value="CG-242" data-code="242">Congo (+242)</option>
                        <option value="CK-682" data-code="682">Cook Islands (+682)</option>
                        <option value="CR-506" data-code="506">Costa Rica (+506)</option>
                        <option value="HR-385" data-code="385">Croatia (+385)</option>
                        <option value="CU-53" data-code="53">Cuba (+53)</option>
                        <option value="CY-90392" data-code="90392">Cyprus North (+90392)</option>
                        <option value="CY-357" data-code="357">Cyprus South (+357)</option>
                        <option value="CZ-42" data-code="42">Czech Republic (+42)</option>
                        <option value="DK-45" data-code="45">Denmark (+45)</option>
                        <option value="DJ-253" data-code="253">Djibouti (+253)</option>
                        <option value="DM-1809" data-code="1809">Dominica (+1809)</option>
                        <option value="DO-1809" data-code="1809">Dominican Republic (+1809)</option>
                        <option value="EC-593" data-code="593">Ecuador (+593)</option>
                        <option value="EG-20" data-code="20">Egypt (+20)</option>
                        <option value="SV-503" data-code="503">El Salvador (+503)</option>
                        <option value="GQ-240" data-code="240">Equatorial Guinea (+240)</option>
                        <option value="ER-291" data-code="291">Eritrea (+291)</option>
                        <option value="EE-372" data-code="372">Estonia (+372)</option>
                        <option value="ET-251" data-code="251">Ethiopia (+251)</option>
                        <option value="FK-500" data-code="500">Falkland Islands (+500)</option>
                        <option value="FO-298" data-code="298">Faroe Islands (+298)</option>
                        <option value="FJ-679" data-code="679">Fiji (+679)</option>
                        <option value="FI-358" data-code="358">Finland (+358)</option>
                        <option value="FR-33" data-code="33">France (+33)</option>
                        <option value="GF-594" data-code="594">French Guiana (+594)</option>
                        <option value="PF-689" data-code="689">French Polynesia (+689)</option>
                        <option value="GA-241" data-code="241">Gabon (+241)</option>
                        <option value="GM-220" data-code="220">Gambia (+220)</option>
                        <option value="GE-7880" data-code="7880">Georgia (+7880)</option>
                        <option value="DE-49" data-code="49">Germany (+49)</option>
                        <option value="GH-233" data-code="233">Ghana (+233)</option>
                        <option value="GI-350" data-code="350">Gibraltar (+350)</option>
                        <option value="GR-30" data-code="30">Greece (+30)</option>
                        <option value="GL-299" data-code="299">Greenland (+299)</option>
                        <option value="GD-1473" data-code="1473">Grenada (+1473)</option>
                        <option value="GP-590" data-code="590">Guadeloupe (+590)</option>
                        <option value="GU-671" data-code="671">Guam (+671)</option>
                        <option value="GT-502" data-code="502">Guatemala (+502)</option>
                        <option value="GN-224" data-code="224">Guinea (+224)</option>
                        <option value="GW-245" data-code="245">Guinea - Bissau (+245)</option>
                        <option value="GY-592" data-code="592">Guyana (+592)</option>
                        <option value="HT-509" data-code="509">Haiti (+509)</option>
                        <option value="HN-504" data-code="504">Honduras (+504)</option>
                        <option value="HK-852" data-code="852">Hong Kong (+852)</option>
                        <option value="HU-36" data-code="36">Hungary (+36)</option>
                        <option value="IS-354" data-code="354">Iceland (+354)</option>
                        <option value="IN-91" data-code="91">India (+91)</option>
                        <option value="ID-62" data-code="62">Indonesia (+62)</option>
                        <option value="IR-98" data-code="98">Iran (+98)</option>
                        <option value="IQ-964" data-code="964">Iraq (+964)</option>
                        <option value="IE-353" data-code="353">Ireland (+353)</option>
                        <option value="IL-972" data-code="972">Israel (+972)</option>
                        <option value="IT-39" data-code="39">Italy (+39)</option>
                        <option value="JM-1876" data-code="1876">Jamaica (+1876)</option>
                        <option value="JP-81" data-code="81">Japan (+81)</option>
                        <option value="JO-962" data-code="962">Jordan (+962)</option>
                        <option value="KZ-7" data-code="7">Kazakhstan (+7)</option>
                        <option value="KE-254" data-code="254">Kenya (+254)</option>
                        <option value="KI-686" data-code="686">Kiribati (+686)</option>
                        <option value="KP-850" data-code="850">Korea North (+850)</option>
                        <option value="KR-82" data-code="82">Korea South (+82)</option>
                        <option value="KW-965" data-code="965">Kuwait (+965)</option>
                        <option value="KG-996" data-code="996">Kyrgyzstan (+996)</option>
                        <option value="LA-856" data-code="856">Laos (+856)</option>
                        <option value="LV-371" data-code="371">Latvia (+371)</option>
                        <option value="LB-961" data-code="961">Lebanon (+961)</option>
                        <option value="LS-266" data-code="266">Lesotho (+266)</option>
                        <option value="LR-231" data-code="231">Liberia (+231)</option>
                        <option value="LY-218" data-code="218">Libya (+218)</option>
                        <option value="LI-417" data-code="417">Liechtenstein (+417)</option>
                        <option value="LT-370" data-code="370">Lithuania (+370)</option>
                        <option value="LU-352" data-code="352">Luxembourg (+352)</option>
                        <option value="MO-853" data-code="853">Macao (+853)</option>
                        <option value="MK-389" data-code="389">Macedonia (+389)</option>
                        <option value="MG-261" data-code="261">Madagascar (+261)</option>
                        <option value="MW-265" data-code="265">Malawi (+265)</option>
                        <option value="MY-60" data-code="60">Malaysia (+60)</option>
                        <option value="MV-960" data-code="960">Maldives (+960)</option>
                        <option value="ML-223" data-code="223">Mali (+223)</option>
                        <option value="MT-356" data-code="356">Malta (+356)</option>
                        <option value="MH-692" data-code="692">Marshall Islands (+692)</option>
                        <option value="MQ-596" data-code="596">Martinique (+596)</option>
                        <option value="MR-222" data-code="222">Mauritania (+222)</option>
                        <option value="YT-269" data-code="269">Mayotte (+269)</option>
                        <option value="MX-52" data-code="52">Mexico (+52)</option>
                        <option value="FM-691" data-code="691">Micronesia (+691)</option>
                        <option value="MD-373" data-code="373">Moldova (+373)</option>
                        <option value="MC-377" data-code="377">Monaco (+377)</option>
                        <option value="MN-976" data-code="976">Mongolia (+976)</option>
                        <option value="MS-1664" data-code="1664">Montserrat (+1664)</option>
                        <option value="MA-212" data-code="212">Morocco (+212)</option>
                        <option value="MZ-258" data-code="258">Mozambique (+258)</option>
                        <option value="MN-95" data-code="95">Myanmar (+95)</option>
                        <option value="NA-264" data-code="264">Namibia (+264)</option>
                        <option value="NR-674" data-code="674">Nauru (+674)</option>
                        <option value="NP-977" data-code="977">Nepal (+977)</option>
                        <option value="NL-31" data-code="31">Netherlands (+31)</option>
                        <option value="NC-687" data-code="687">New Caledonia (+687)</option>
                        <option value="NZ-64" data-code="64">New Zealand (+64)</option>
                        <option value="NI-505" data-code="505">Nicaragua (+505)</option>
                        <option value="NE-227" data-code="227">Niger (+227)</option>
                        <option value="NG-234" data-code="234">Nigeria (+234)</option>
                        <option value="NU-683" data-code="683">Niue (+683)</option>
                        <option value="NF-672" data-code="672">Norfolk Islands (+672)</option>
                        <option value="NP-670" data-code="670">Northern Marianas (+670)</option>
                        <option value="NO-47" data-code="47">Norway (+47)</option>
                        <option value="OM-968" data-code="968">Oman (+968)</option>
                        <option value="PW-680" data-code="680">Palau (+680)</option>
                        <option value="PA-507" data-code="507">Panama (+507)</option>
                        <option value="PG-675" data-code="675">Papua New Guinea (+675)</option>
                        <option value="PY-595" data-code="595">Paraguay (+595)</option>
                        <option value="PE-51" data-code="51">Peru (+51)</option>
                        <option value="PH-63" data-code="63">Philippines (+63)</option>
                        <option value="PL-48" data-code="48">Poland (+48)</option>
                        <option value="PT-351" data-code="351">Portugal (+351)</option>
                        <option value="PR-1787" data-code="1787">Puerto Rico (+1787)</option>
                        <option value="QA-974" data-code="974">Qatar (+974)</option>
                        <option value="RE-262" data-code="262">Reunion (+262)</option>
                        <option value="RO-40" data-code="40">Romania (+40)</option>
                        <option value="RU-7" data-code="7">Russia (+7)</option>
                        <option value="RW-250" data-code="250">Rwanda (+250)</option>
                        <option value="SM-378" data-code="378">San Marino (+378)</option>
                        <option value="ST-239" data-code="239">Sao Tome & Principe (+239)</option>
                        <option value="SA-966" data-code="966">Saudi Arabia (+966)</option>
                        <option value="SN-221" data-code="221">Senegal (+221)</option>
                        <option value="CS-381" data-code="381">Serbia (+381)</option>
                        <option value="SC-248" data-code="248">Seychelles (+248)</option>
                        <option value="SL-232" data-code="232">Sierra Leone (+232)</option>
                        <option value="SG-65" data-code="65">Singapore (+65)</option>
                        <option value="SK-421" data-code="421">Slovak Republic (+421)</option>
                        <option value="SI-386" data-code="386">Slovenia (+386)</option>
                        <option value="SB-677" data-code="677">Solomon Islands (+677)</option>
                        <option value="SO-252" data-code="252">Somalia (+252)</option>
                        <option value="ZA-27" data-code="27">South Africa (+27)</option>
                        <option value="ES-34" data-code="34">Spain (+34)</option>
                        <option value="LK-94" data-code="94">Sri Lanka (+94)</option>
                        <option value="SH-290" data-code="290">St. Helena (+290)</option>
                        <option value="KN-1869" data-code="1869">St. Kitts (+1869)</option>
                        <option value="SC-1758" data-code="1758">St. Lucia (+1758)</option>
                        <option value="SD-249" data-code="249">Sudan (+249)</option>
                        <option value="SR-597" data-code="597">Suriname (+597)</option>
                        <option value="SZ-268" data-code="268">Swaziland (+268)</option>
                        <option value="SE-46" data-code="46">Sweden (+46)</option>
                        <option value="CH-41" data-code="41">Switzerland (+41)</option>
                        <option value="SI-963" data-code="963">Syria (+963)</option>
                        <option value="TW-886" data-code="886">Taiwan (+886)</option>
                        <option value="TJ-992" data-code="992">Tajikistan (+992)</option>
                        <option value="TH-66" data-code="66">Thailand (+66)</option>
                        <option value="TG-228" data-code="228">Togo (+228)</option>
                        <option value="TO-676" data-code="676">Tonga (+676)</option>
                        <option value="TT-1868" data-code="1868">Trinidad & Tobago (+1868)</option>
                        <option value="TN-216" data-code="216">Tunisia (+216)</option>
                        <option value="TR-90" data-code="90">Turkey (+90)</option>
                        <option value="TM-993" data-code="993">Turkmenistan (+993)</option>
                        <option value="TC-1649" data-code="1649">Turks & Caicos Islands (+1649)</option>
                        <option value="TV-688" data-code="688">Tuvalu (+688)</option>
                        <option value="UG-256" data-code="256">Uganda (+256)</option>
                        <option value="GB-44" data-code="44">UK (+44)</option>
                        <option value="UA-380" data-code="380">Ukraine (+380)</option>
                        <option value="AE-971" data-code="971">United Arab Emirates (+971)</option>
                        <option value="US-1" data-code="1">USA (+1)</option>
                        <option value="UY-598" data-code="598">Uruguay (+598)</option>
                        <option value="UZ-998" data-code="998">Uzbekistan (+998)</option>
                        <option value="VU-678" data-code="678">Vanuatu (+678)</option>
                        <option value="VA-379" data-code="379">Vatican City (+379)</option>
                        <option value="VE-58" data-code="58">Venezuela (+58)</option>
                        <option value="VN-84" data-code="84">Vietnam (+84)</option>
                        <option value="VG-1" data-code="1">Virgin Islands - British (+1)</option>
                        <option value="VI-1" data-code="1">Virgin Islands - US (+1)</option>
                        <option value="WF-681" data-code="681">Wallis & Futuna (+681)</option>
                        <option value="YE-969" data-code="969">Yemen (North)(+969)</option>
                        <option value="YE-967" data-code="967">Yemen (South)(+967)</option>
                        <option value="ZM-260" data-code="260">Zambia (+260)</option>
                        <option value="ZW-263" data-code="263">Zimbabwe (+263)</option>
                    </select>
                </div>
            </div>

                <div class="col-6 pl-0">
                    <div class="form-group c_code">
                        <label ><?php echo e(__("Phone")); ?> <span class="required">*</span> <i class="fa fa-info-circle" style="color: #0a58ca" data-toggle="tooltip" data-placement="top" title="Please include your country code"></i></label>
                        <span class="country_code">+1</span>
                        <input type="number" class="form-control" value="<?php echo e($user->phone ?? ''); ?>" name="phone">
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
        <label class="term-conditions-checkbox" style="font-size: 13px;">
           <?php echo e(__('I have read and accept the')); ?>  <a target="_blank" data-toggle="modal" href="#term_conditions"><?php echo e(__('terms and conditions')); ?> </a>  <input type="checkbox" name="term_conditions">
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

        <button type="button" class="btn btn-primary" style=" width: 102px; background: #00B050"> <?php echo e(format_money($booking->total)); ?></button>
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
<?php /**PATH E:\laragon\www\jamaica_taxi\themes/Jamrock/Booking/Views/frontend/booking/checkout-form.blade.php ENDPATH**/ ?>