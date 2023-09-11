(function ($) {
    new Vue({
        el:'#bravo_tour_car_book_app',
        data:{
            id:'',
            extra_price:[],
            buyer_fees:[],
            pricing:[],
            message:{
                content:'',
                type:false
            },
            html:'',
            onSubmit:false,
            start_date:'',
            end_date:'',
            start_date_html:'',

            step:1,
            start_date_obj:'',
            allEvents:[],
            number:0,
            max_number:1,
            total_price_before_fee:0,
            total_price_fee:0,

            is_form_enquiry_and_book:false,
            enquiry_type:'book',
            enquiry_is_submit:false,
            enquiry_name:"",
            enquiry_email:"",
            enquiry_phone:"",
            enquiry_note:"",

            from_address:'',
            to_address:'',
            gg_distance: '',
            gg_duration:'',
            pickup_date:'',
            pickup_time:'',
            passenger:'',
            min_people:1,
            max_people:1,
            mapEngine:'',
            service_type:""
        },
        watch:{
            extra_price:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            passenger:function () {
                var me = this;
                if(parseInt(me.passenger) > parseInt(me.max_people)){
                    me.passenger = parseInt(me.max_people);
                }
                if(parseInt(me.passenger) < me.min_people){
                    me.passenger = me.min_people
                }
            },
            baggage:function () {
                var me = this;
                if(parseInt(me.baggage) > parseInt(me.max_baggage)){
                    me.baggage = parseInt(me.max_baggage);
                }
                if(parseInt(me.baggage) < 1){
                    me.baggage = 1
                }
            }
        },
        computed:{
            distance_duration_html:function (){
                var html = '';
                if (typeof this.gg_distance.value !='undefined' && typeof this.gg_duration.value !='undefined'){
                    html =  this.gg_distance.text+' | '+ this.gg_duration.text
                }
                return html
            },


            per_passenger(){
                let t = 0;
                var me = this;
                if (typeof this.gg_distance.value !='undefined' && typeof this.gg_duration.value !='undefined') {
                    var isBook = false;
                    if (me.gg_distance) {
                        var distance = me.gg_distance.value / 1000;
                        for (var ix in me.pricing) {
                            var item = me.pricing[ix];
                            if (item.gg_from <= distance && distance <= item.gg_to) {
                                for (var ic in item.prices) {
                                    var price = item.prices[ic];
                                    if (parseInt(price.pax_from) <= me.passenger && me.passenger <= parseInt(price.pax_to)) {
                                        if (parseFloat(price.discount)) {
                                            t = parseFloat(price.discount);
                                        } else {
                                            t = parseFloat(price.price)
                                        }
                                        isBook = true;
                                    }
                                }
                            }
                        }
                    }
                }
                return t;
            },
            total_price:function(){
                var me = this;
                if (typeof this.gg_distance.value !='undefined' && typeof this.gg_duration.value !='undefined'){
                    var total_price = 0;
                    var isBook = false;
                    if (me.gg_distance) {
                        total_price = this.per_passenger;
                    }

                    for (var ix in me.extra_price) {
                        var item = me.extra_price[ix];
                        if(!item.price) continue;
                        if (item.enable == 1) {

                            let type_total = 0;
                            switch (item.type) {
                                case "one_time":
                                    type_total += parseFloat(item.price);
                                    break;
                            }
                            if (typeof item.per_person !== "undefined") {
                                type_total = type_total * this.passenger;
                            }
                            total_price += type_total;
                        }
                    }
                    this.total_price_before_fee = total_price;

                    var total_fee = 0;
                    for (var ix in me.buyer_fees) {
                        var item = me.buyer_fees[ix];
                        if(!item.price) continue;

                        //for Fixed
                        var fee_price = parseFloat(item.price);

                        //for Percent
                        if (typeof item.unit !== "undefined" && item.unit === "percent" ) {
                            fee_price = ( total_price / 100 ) * fee_price;
                        }

                        if (typeof item.per_person !== "undefined") {
                            fee_price = fee_price * guests;
                        }
                        total_fee += fee_price;
                    }
                    total_price += total_fee;
                    this.total_price_fee = total_fee;
                    if (me.passenger === 0) {
                        return 0;
                    } else {
                        return total_price;
                    }
                }
                return 0;
            },
            total_price_html:function(){
                if(!this.total_price) return '';
                return window.bravo_format_money(this.total_price);
            },
            pay_now_price:function(){
                if(this.is_deposit_ready){
                    var total_price_depossit = 0;

                    var tmp_total_price = this.total_price;
                    var deposit_fomular = this.deposit_fomular;
                    if(deposit_fomular === "deposit_and_fee"){
                        tmp_total_price = this.total_price_before_fee;
                    }

                    switch (this.deposit_type) {
                        case "percent":
                            total_price_depossit =  tmp_total_price * this.deposit_amount / 100;
                            break;
                        default:
                            total_price_depossit =  this.deposit_amount;
                    }
                    if(deposit_fomular === "deposit_and_fee"){
                        total_price_depossit = total_price_depossit + this.total_price_fee;
                    }

                    return  total_price_depossit
                }
                return this.total_price;
            },
            pay_now_price_html:function(){
                return window.bravo_format_money(this.pay_now_price);
            },
            daysOfWeekDisabled(){
                var res = [];

                for(var k in this.open_hours)
                {
                    if(typeof this.open_hours[k].enable == 'undefined' || this.open_hours[k].enable !=1 ){

                        if(k == 7){
                            res.push(0);
                        }else{
                            res.push(k);
                        }
                    }
                }

                return res;
            },
            is_deposit_ready:function () {
                if(this.deposit && this.deposit_amount) return true;
                return false;
            },

        },
        created:function(){
            for(var k in bravo_booking_data){
                this[k] = bravo_booking_data[k];
            }
        },
        mounted(){
            var me = this;
            this.$nextTick(function () {
                var mapEngine = new BravoMapEngine('bravo_results_map',{
                    fitBounds:bookingCore.map_options.map_fit_bounds,
                    center:[0,0],
                    zoom:6,
                    disableScripts:true,
                    markerClustering:bookingCore.map_options.map_clustering,
                    autoCallRoute:true,
                    currentDirection:typeof currentDirection != "undefined" ? currentDirection : {},
                    ready: function (engineMap) {
                        console.log($('#inputFromAddress').val());
                        console.log($('#inputToAddress').val());
                        engineMap.registerDirection('inputFromAddress','inputToAddress',function (response,from_place,to_place) {

                            var leg = response.routes[ 0 ].legs[ 0 ];
                            var start_address_json = {
                                lat: leg.start_location.lat(),
                                lng: leg.start_location.lng(),
                                address:$('#inputFromAddress').val(),
                                pladeId:from_place
                            }
                            var end_address_json = {
                                lat: leg.end_location.lat(),
                                lng: leg.end_location.lng(),
                                address:$('#inputToAddress').val(),
                                pladeId:to_place
                            }
                            var legDistance = leg.distance;
                            var legDuration = leg.duration;

                            me.gg_distance = Object.assign({},legDistance);
                            me.gg_duration = Object.assign({},legDuration);
                            me.from_address = Object.assign({},start_address_json);
                            me.to_address = Object.assign({},end_address_json);

                        },function (place,mode){

                        },false);
                    }
                });
                me.$set(me, 'mapEngine',mapEngine)

                var options = {
                    singleDatePicker: true,
                    showCalendar: false,
                    sameDate: true,
                    autoApply           : true,
                    disabledPast        : true,
                    dateFormat          : bookingCore.date_format,
                    enableLoading       : true,
                    showEventTooltip    : true,
                    classNotAvailable   : ['disabled', 'off'],
                    disableHightLight: true,
                    minDate:this.minDate,
                    opens: bookingCore.rtl ? 'right':'left',
                    locale:{
                        direction: bookingCore.rtl ? 'rtl':'ltr',
                        firstDay:daterangepickerLocale.first_day_of_week
                    },
                };

                if (typeof  daterangepickerLocale == 'object') {
                    options.locale = _.merge(daterangepickerLocale,options.locale);
                }

                    if ($(window).width() > 960) {
                        $(this.$refs.start_date).daterangepicker(options).on('apply.daterangepicker',
                            function (ev, picker) {
                                me.pickup_date = picker.startDate.format('YYYY-MM-DD');
                            })
                    }
            })
        },
        methods:{
            handleTotalPrice:function() {
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            validate(){
                if(this.gg_distance=='')
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_from_address_select;
                    return false;
                }
                if(!this.pickup_date || !this.pickup_time)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_pickup_date_select;
                    return false;
                }
                let pickupDatetime = moment(this.pickup_date+' '+this.pickup_time);
                if (pickupDatetime < moment()){
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_pickup_date_select;
                    return false;
                }


                if(!this.passenger )
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_passenger_select;
                    return false;
                }

                return true;
            },
            doSubmit:function (e) {
                e.preventDefault();
                if(this.onSubmit) return false;

                if(!this.validate()) return false;

                this.onSubmit = true;
                var me = this;

                this.message.content = '';

                if(this.step == 1){
                    this.html = '';
                }

                $.ajax({
                    url:bookingCore.url+'/booking/addToCart',
                    data:{
                        service_id:this.id,
                        service_type:this.service_type,
                        extra_price:this.extra_price,
                        passenger:this.passenger,
                        from_address:this.from_address,
                        to_address:this.to_address,
                        gg_distance:this.gg_distance,
                        gg_duration:this.gg_duration,
                        pickup_date:this.pickup_date,
                        pickup_time:this.pickup_time,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){

                        if(!res.status){
                            me.onSubmit = false;
                        }
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.step){
                            me.step = res.step;
                        }
                        if(res.html){
                            me.html = res.html
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        me.onSubmit = false;

                        bravo_handle_error_response(e);

                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }

                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;

                        }
                    }
                })
            },
            doEnquirySubmit:function(e){
                e.preventDefault();
                if(this.onSubmit) return false;
                if(!this.validateenquiry()) return false;
                this.onSubmit = true;
                var me = this;
                this.message.content = '';

                $.ajax({
                    url:bookingCore.url+'/booking/addEnquiry',
                    data:{
                        service_id:this.id,
                        service_type:'car',
                        name:this.enquiry_name,
                        email:this.enquiry_email,
                        phone:this.enquiry_phone,
                        note:this.enquiry_note,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                        if(res.status){
                            me.enquiry_is_submit = true;
                            me.enquiry_name = "";
                            me.enquiry_email = "";
                            me.enquiry_phone = "";
                            me.enquiry_note = "";
                        }
                        me.onSubmit = false;
                    },
                    error:function (e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }
                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                    }
                })
            },
            validateenquiry(){
                if(!this.enquiry_name)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.name_required;
                    return false;
                }
                if(!this.enquiry_email)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.email_required;
                    return false;
                }
                return true;
            },

            calculatorDistanceDuration(){
                if(!this.validateSearchPlace()) return false;
                this.mapEngine.route();
            },

            doCancel(){
                $('.bravo_single_book_wrap').modal('hide');
            }
        },
        components:{
            "VueTimepicker": VueTimepicker.default
        }

    });
})(jQuery);
