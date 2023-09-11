jQuery(function ($) {


	$(".bravo-filter-price").each(function () {
		var input_price = $(this).find(".filter-price");
		var min = input_price.data("min");
		var max = input_price.data("max");
		var from = input_price.data("from");
		var to = input_price.data("to");
		var symbol = input_price.data("symbol");
		input_price.ionRangeSlider({
			type: "double",
			grid: true,
			min: min,
			max: max,
			from: from,
			to: to,
			prefix: symbol
		});
	});

	var mapEngine = new BravoMapEngine('bravo_results_map',{
		fitBounds:bookingCore.map_options.map_fit_bounds,
		center:[bravo_map_data.map_lat_default, bravo_map_data.map_lng_default ],
		zoom:bravo_map_data.map_zoom_default,
		disableScripts:true,
		markerClustering:bookingCore.map_options.map_clustering,
        autoCallRoute:true,
        currentDirection:typeof currentDirection != "undefined" ? currentDirection : {},
		ready: function (engineMap) {
            engineMap.registerDirection('pick_up','drop_off',function (response,from_place,to_place) {

                var leg = response.routes[ 0 ].legs[ 0 ];

                $('#pickup_filter .map_lat').val(leg.start_location.lat());
                $('#pickup_filter .map_lng').val(leg.start_location.lng());
                $('#pickup_filter .map_place_id').val(from_place);

                $('#dropoff_filter .map_lat').val(leg.end_location.lat());
                $('#dropoff_filter .map_lng').val(leg.end_location.lng());
                $('#dropoff_filter .map_place_id').val(to_place);

                $('input[name=gmap_distance]').val(leg.distance.value);
                $('input[name=gmap_duration]').val(leg.duration.value);

                $('.map-duration').html(leg.distance.text+' | '+ leg.duration.text +' | ');

                window.history.pushState({}, '', bc_current_url+'?'+$('.bravo_form').serialize());

                reloadForm();

            },function (place,mode){

            });

            const pickup_popup_location = $('.pickup_popup_location');
            const dropdoff_popup_location = $('.dropoff_popup_location');

            $('#pick_up').click(function (){

                if(!$(this).val()){
                    pickup_popup_location.show();
                }else {
                    pickup_popup_location.hide();
                }
            }).keyup(function (e){
                if (e.keyCode === 13) { e.preventDefault()}
                if(!$(this).val()){
                    pickup_popup_location.show();
                }else {
                    pickup_popup_location.hide();
                }
            })
            $('#drop_off').click(function (){
                if(!$(this).val()){
                    dropdoff_popup_location.show();
                }else {
                    dropdoff_popup_location.hide();
                }
            }).keyup(function (e){
                if (e.keyCode === 13) { e.preventDefault()}
                if(!$(this).val()){
                    dropdoff_popup_location.show();
                }else {
                    dropdoff_popup_location.hide();
                }
            })

            window.addEventListener('click', function(e){
                if (!document.getElementById('pickup_filter').contains(e.target)){
                    pickup_popup_location.hide();
                }
                if (!document.getElementById('dropoff_filter').contains(e.target)){
                    dropdoff_popup_location.hide();
                }
            });

            pickup_popup_location.find('.popular-location-item').click(function (){

                engineMap.setDirectionPlace(true,
                    { lat: $(this).data('lat'), lng: $(this).data('lng') }
                )
                pickup_popup_location.hide();
                $('#pick_up').val($(this).find('span').html())
            })

            dropdoff_popup_location.find('.popular-location-item').click(function (){
                engineMap.setDirectionPlace(false,
                    { lat: $(this).data('lat'), lng: $(this).data('lng') }
                )
                dropdoff_popup_location.hide();
                $('#drop_off').val($(this).find('span').html())
            })
		}
	});

	$('.bravo_form_search_map .smart-search .child_id').change(function () {
		reloadForm();
	});
    $('.bravo_form_search_map .g-map-place input[name=map_place]').change(function () {
        setTimeout(function () {
            reloadForm()
        },500)
    });

	$('.bravo_form_search_map .input-filter').change(function () {
		reloadForm();
	});
	$('.bravo_form_search_map .btn-filter,.btn-apply-advances').click(function () {
		reloadForm();
	});
	$('.btn-apply-advances').click(function(){
		$('#advance_filters').addClass('d-none');
	})

	function reloadForm(){
		$('.map_loading').show();
		$.ajax({
			data:$('.bravo_form_search_map input,select,textarea,input:hidden,#advance_filters input,select,textarea').serialize()+'&_ajax=1',
			url:window.location.href.split('?')[0],
			dataType:'json',
			type:'get',
			success:function (json) {
				$('.map_loading').hide();
				if(json.status)
				{
					$('.bravo-list-item').replaceWith(json.html);

					$('.listing_items').animate({
                        scrollTop:0
                    },'fast');

					if(window.lazyLoadInstance){
						window.lazyLoadInstance.update();
					}

				}

			},
			error:function (e) {
				$('.map_loading').hide();
				if(e.responseText){
					$('.bravo-list-item').html('<p class="alert-text danger">'+e.responseText+'</p>')
				}
			}
		})
	}

	function reloadFormByUrl(url){
        $('.map_loading').show();
        $.ajax({
            url:url,
            dataType:'json',
            type:'get',
            success:function (json) {
                $('.map_loading').hide();
                if(json.status)
                {
                    mapEngine.clearMarkers();
                    mapEngine.addMarkers2(json.markers);

                    $('.bravo-list-item').replaceWith(json.html);

					setTimeout(function () {
						$('.listing_items').animate({
							scrollTop:0
						},'fast');
						if($(document).width() < 991){
							$('html,body').animate({
								scrollTop: $(".listing_items").offset().top - 50
							},'fast');
						}
					},500);

                    if(window.lazyLoadInstance){
                        window.lazyLoadInstance.update();
                    }
                }

            },
            error:function (e) {
                $('.map_loading').hide();
                if(e.responseText){
                    $('.bravo-list-item').html('<p class="alert-text danger">'+e.responseText+'</p>')
                }
            }
        })
	}

	$('.toggle-advance-filter').click(function () {
		var id = $(this).data('target');
		$(id).toggleClass('d-none');
	});

    $(document).on('click', '.filter-item .dropdown-menu', function (e) {

        if(!$(e.target).hasClass('btn-apply-advances')){
            e.stopPropagation();
		}
    })
		.on('click','.bravo-pagination a',function (e) {
			e.preventDefault();
            reloadFormByUrl($(this).attr('href'));
        })
	;

});
