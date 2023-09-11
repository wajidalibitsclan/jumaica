(function ($) {
    new Vue({
        el:'#bravo_car_book_app',
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
            trip_type_selected:0,
            pickup_date:'',
            pickup_time:'',
            return_date:'',
            return_time:'',
            passenger:null,
            max_passenger:1,
            max_baggage:1,
            baggage:null,
            pickup_flight:'',
            return_flight:'',
            mapEngine:''
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
                if(parseInt(me.passenger) > parseInt(me.max_passenger)){
                    me.passenger = parseInt(me.max_passenger);
                }
                if(parseInt(me.passenger) < 1){
                    me.passenger = 1
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
            search_add_text:function (){
                if (this.from_address !='' || this.to_address !=''){
                    return 'Edit'
                }else{
                    return 'Search'
                }
            },
            distance_duration_html:function (){
                var html = '';
              if (typeof this.gg_distance.value !='undefined' && typeof this.gg_duration.value !='undefined'){
                  html =  this.gg_distance.text+' | '+ this.gg_duration.text
              }
              return html
            },


            round_trip_price_html:function(){
                if(!this.round_trip_total_price) return '';

                if (!this.oneway_trip_total_price[0]){
                    return '';
                }
                if (this.round_trip_total_price[1]){
                    return '<div class="price">\n' +
                        '                    <span class="value">\n' +
                        '                        <span class="onsale" style="font-size: 13px">'+window.bravo_format_money(this.round_trip_total_price[0])+'</span>\n' +
                        '                        <span class="text-green text-15">'+window.bravo_format_money(this.round_trip_total_price[1])+'</span>\n' +
                        '                    </span>\n' +
                        '                </div>';
                }else{
                    return '<div class="price">\n' +
                        '                    <span class="value">\n' +
                        '                        <span class="text-green text-15">'+window.bravo_format_money(this.round_trip_total_price[0])+'</span>\n' +
                        '                    </span>\n' +
                        '                </div>'
                }
            },

            oneway_trip_price_html:function(){


                if(!this.oneway_trip_total_price) return '';
                if (!this.oneway_trip_total_price[0]){
                    return '';
                }
                if (this.oneway_trip_total_price[1]){
                    return '<div class="price">\n' +
                        '                    <span class="value">\n' +
                        '                        <span class="onsale" style="font-size: 13px">'+window.bravo_format_money(this.oneway_trip_total_price[0])+'</span>\n' +
                        '                        <span class="text-green text-15">'+window.bravo_format_money(this.oneway_trip_total_price[1])+'</span>\n' +
                        '                    </span>\n' +
                        '                </div>';
                }else{
                    return '<div class="price">\n' +
                        '                    <span class="value">\n' +
                        '                        <span class="text-green text-15">'+window.bravo_format_money(this.oneway_trip_total_price[0])+'</span>\n' +
                        '                    </span>\n' +
                        '                </div>'
                }
            },
            round_trip_total_price:function () {
                var me = this;
                var price = [0,0];
                if (me.gg_distance) {
                    var distance = me.gg_distance.value/1000;
                    console.log(me.pricing);
                    for (var ix in me.pricing) {
                        var item = me.pricing[ix];
                        if (item.from <= distance && distance <= item.to){
                            price = [parseFloat(item.roundtrip_price),parseFloat(item.roundtrip_discount)]
                        }
                    }
                }
                return price;

            },
            oneway_trip_total_price:function () {
                var me = this;
                var price = [0,0];
                if (me.gg_distance) {
                    var distance = me.gg_distance.value/1000;
                    for (var ix in me.pricing) {
                        var item = me.pricing[ix];
                        if (item.from <= distance && distance <= item.to){
                            price =[parseFloat(item.oneway_price),parseFloat(item.oneway_discount)]
                        }
                    }
                }
                return price;
            },
            total_price:function(){
                var me = this;
                if (typeof this.gg_distance.value !='undefined' && typeof this.gg_duration.value !='undefined'){
                    var total_price = 0;
                    if (!this.trip_type_selected){
                        total_price+=this.round_trip_total_price[1]?parseFloat(this.round_trip_total_price[1]):parseFloat(this.round_trip_total_price[0])
                    }else{
                        total_price+=this.oneway_trip_total_price[1]?parseFloat(this.oneway_trip_total_price[1]):parseFloat(this.oneway_trip_total_price[0])
                    }
                    var total_fee = 0;
                    for (var ix in me.extra_price) {
                        var item = me.extra_price[ix];
                        if(!item.price) continue;
                        if (item.enable == 1) {
                            //for Fixed
                            var fee_price = parseFloat(item.price);

                            if (typeof item.per_person !== "undefined") {
                                fee_price = fee_price * me.passenger;
                            }

                            total_fee += fee_price;

                        }
                    }
                    total_price += total_fee;

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
                            fee_price = fee_price * me.passenger;
                        }
                        total_fee += fee_price;
                    }
                    total_price += total_fee;
                    this.total_price_fee = total_fee;
                    return total_price;
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

                            var paramValue = url.searchParams.get("trip_type");
                            var booking_form = false;
                            if(paramValue === 'round'){
                                var booking_form = true
                            }
                            if(paramValue === 'oneway'){
                                var booking_form = true
                            }

                            const params = new URLSearchParams({
                                ...{
                                    pickup_map_lat:start_address_json.lat,
                                    pickup_map_lng:start_address_json.lng,
                                    pickup_map_place_id:start_address_json.pladeId,
                                    pickup_map_place:$('#inputFromAddress').val(),
                                    booking_form:booking_form,
                                },
                                ...{
                                    dropoff_map_lat:end_address_json.lat,
                                    dropoff_map_lng:end_address_json.lng,
                                    dropoff_map_place_id:end_address_json.pladeId,
                                    dropoff_map_place:$('#inputToAddress').val(),
                                },
                            });

                            window.history.pushState({}, '', bc_current_url+'?'+params.toString());

                        },function (place,mode){

                        },false);
                    }
                });
                me.$set(me, 'mapEngine',mapEngine);


                })
            this.initDatepicker();


            var url_string = window.location.href; // www.test.com?filename=test
            var url = new URL(url_string);
            var paramValue = url.searchParams.get("trip_type");
            if(paramValue === 'round'){
                this.trip_type_selected = 0;
            }
            if(paramValue === 'oneway'){
                this.trip_type_selected = 1;
            }

        },
        methods:{
            initDatepicker(){
                var me = this;
                this.$nextTick( ()=>{
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
                            $(this.$refs.end_date).daterangepicker(options).on('apply.daterangepicker',
                                function (ev, picker) {
                                    me.return_date = picker.startDate.format('YYYY-MM-DD');
                                })
                        }
                })
            },
            handleTotalPrice:function() {
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            validateSearchPlace(){
                if(typeof $('#inputFromAddress').val() =='undefined' || $('#inputFromAddress').val() =='')
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_from_address_select;
                    return false;
                }
                if(typeof $('#inputToAddress').val() =='undefined' || $('#inputToAddress').val() =='')
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_to_address_select;
                    return false;
                }

                return true;
            },
            validate(){
                if(this.gg_distance=='')
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_gg_distance_select;
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

                if (!this.trip_type_selected ){
                    let returnDateTime = moment(this.return_date+' '+this.return_time);

                    if( !this.return_date || !this.return_date)
                    {
                        this.message.status = false;
                        this.message.content = bravo_booking_i18n.no_return_date_select;
                        return false;
                    }
                    if (returnDateTime < moment()){
                        this.message.status = false;
                        this.message.content = bravo_booking_i18n.no_return_date_select;
                        return false;
                    }
                    if (returnDateTime < pickupDatetime){
                        if (returnDateTime < moment()){
                            this.message.status = false;
                            this.message.content = bravo_booking_i18n.no_return_date_select;
                            return false;
                        }
                    }

                    if(!this.round_trip_total_price[0]){
                        this.message.status = false;
                        this.message.content = 'Price is empty';
                        return false;
                    }

                }else{
                    if(!this.oneway_trip_total_price[0]){
                        this.message.status = false;
                        this.message.content = 'Price is empty';
                        return false;
                    }
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
                        service_type:"car",
                        extra_price:this.extra_price,
                        passenger:this.passenger,
                        from_address:this.from_address,
                        to_address:this.to_address,
                        gg_distance:this.gg_distance,
                        gg_duration:this.gg_duration,
                        trip_type_selected:this.trip_type_selected,
                        pickup_date:this.pickup_date,
                        pickup_time:this.pickup_time,
                        return_date:this.return_date,
                        return_time:this.return_time,
                        baggage:this.baggage,
                        pickup_flight:this.pickup_flight,
                        return_flight:this.return_flight,
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

    $(window).on("load", function () {
        var urlHash = window.location.href.split("#")[1];
        if (urlHash &&  $('.' + urlHash).length ){
            var offset_other = 70
            if(urlHash === "review-list"){
                offset_other = 330;
            }
            $('html,body').animate({
                scrollTop: $('.' + urlHash).offset().top - offset_other
            }, 1000);
        }
    });

    $(".bravo-button-book-mobile").click(function () {
        $('.bravo_single_book_wrap').modal('show');
    });

    $(".bravo_detail_car .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });

})(jQuery);
