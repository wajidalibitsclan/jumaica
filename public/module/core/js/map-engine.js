(function ($) {
    window.BravoMapEngine = function (id,configs) {
        switch (bookingCore.map_provider) {
            case "osm":
                return new OsmMapEngine(id,configs);
                break;
            case "gmap":
                return new GmapEngine(id,configs);
                break;
        }
    };

    function BaseMapEngine(id,options){
        var defaults = {};
    }

    BaseMapEngine.prototype.getOption = function (key) {

        if(typeof this.options[key] == 'undefined'){

            if(typeof this.defaults[key] != 'undefined'){
                return this.defaults[key];
            }
            return null;

        }
        return this.options[key];

    };


    function OsmMapEngine(id,options){
        this.defaults = {
            fitBounds:true
        };
        var el = {};
        this.map = null;
        this.id = id;
        this.options = options;
        this.markers = [];
        this.bounds = null;

        this.init();

        return this;
    }

    OsmMapEngine.prototype = new BaseMapEngine();

    OsmMapEngine.prototype.initScripts = function (func) {
        func();
        return;

        if(typeof window.bc_osm_script_inited != 'undefined') return;
        if(this.getOption('disableScripts')){
            func();
            return;
        }

        var head= document.getElementsByTagName('head')[0];
        var script= document.createElement('script');
        script.type= 'text/javascript';
        script.src= bookingCore.url_root+'/libs/leaflet1.4.0/leaflet.js';
        head.appendChild(script);

        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = bookingCore.url_root+'/libs/leaflet1.4.0/leaflet.css';
        head.appendChild(link);

        window.bc_osm_script_inited = true;


        script.onload = function(){
            func();
        }
    };

    OsmMapEngine.prototype.init = function () {

        var me = this;

        this.el  = $('#'+this.id);

        this.initScripts(function () {

            var center = me.getOption('center');
            var zoom = me.getOption('zoom');

            me.map = L.map(me.id).setView(center, zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(me.map);

            var rd = me.getOption('ready');
            if(typeof rd == "function"){
                rd(me);
            }

        });

    };

    OsmMapEngine.prototype.addMarker = function (latLng,options) {

        // if(typeof options.icon_options.iconUrl == 'undefined'){
        //     options.icon_options.iconUrl = bookingCore.url+'/images/favicon.png';
        // }
        // if(options.icon_options){
        //     options.icon = L.icon(options.icon_options);
        // }

        var m = L.marker(latLng,options).addTo(this.map);

        this.markers.push(m);

    };
    OsmMapEngine.prototype.addMarker2 = function (marker) {

        var options = {
            icon_options:{
                iconUrl:''
            }
        };
            options.icon_options.iconUrl = marker.marker
        if(options.icon_options){
            options.icon = L.icon(options.icon_options);
        }

        var m = L.marker([marker.lat,marker.lng],options).addTo(this.map);

        this.markers.push(m);

    };

    OsmMapEngine.prototype.addMarkers = function (markers) {

        for(var i = 0 ; i < markers.length; i++){

            this.addMarker(markers[i][0],markers[i][1]);

        }

        if(this.getOption('fitBounds'))
        {
            this.bounds = [];
            for (var key in this.markers) {
                var marker = this.markers[key];
                this.bounds.push([ marker._latlng.lat , marker._latlng.lng ])
            }
            try {
                this.map.fitBounds(this.bounds);
            }catch (e) {
                console.log(e);
            }
            this.map.invalidateSize();
        }

    };
    OsmMapEngine.prototype.addMarkers2 = function (markers) {
        for(var i = 0 ; i < markers.length; i++){
            this.addMarker2(markers[i]);
        }
        if(this.getOption('fitBounds'))
        {
            this.bounds = [];
            for (var key in this.markers) {
                var marker = this.markers[key];
                this.bounds.push([ marker._latlng.lat , marker._latlng.lng ])
            }
            try {
                this.map.fitBounds(this.bounds);
            }catch (e) {
                console.log(e);
            }
            this.map.invalidateSize();
        }
    };

    OsmMapEngine.prototype.clearMarkers = function (markers) {

        for(var i = 0; i < this.markers.length; i++){

            this.map.removeLayer(this.markers[i]);

        }

        this.markers = [];

    };

    OsmMapEngine.prototype.on = function (type,func) {

        switch (type) {
            case "click":
                return this.map.on(type,function(e){
                    func([
                        e.latlng.lat,
                        e.latlng.lng,
                    ])
                });
            case "zoom_changed":
                return this.map.on('zoomend',function(e){
                    func(e.target.getZoom())
                });
            break;
        }

    };

    OsmMapEngine.prototype.searchBox = function (classSearchBox ,func) {
        classSearchBox.hide();
    }

    function GmapEngine(id,options){

		this.defaults = {
            fitBounds:true
        };
        var el = {};
        this.map = null;
        this.id = id;
        this.options = options;
        this.markersPositions = [];
        this.markers = [];
        var bounds = null;
        this.infoboxs = [];

        this.init();

        return this;

    }

    GmapEngine.prototype = new BaseMapEngine();

    GmapEngine.prototype.initScripts = function (func) {

        func();
        return;
        if(typeof window.bc_gmap_script_inited != 'undefined') return;
        if(this.getOption('disableScripts')){
            func();
            return;
        }

        var head= document.getElementsByTagName('head')[0];
        var script= document.createElement('script');
        script.type= 'text/javascript';
        script.src= 'https://maps.googleapis.com/maps/api/js?key='+bookingCore.map_gmap_key+'&libraries=places';
        head.appendChild(script);

		var script2 = document.createElement('script');
		script2.type= 'text/javascript';
		script2.src= bookingCore.url+'/libs/infobox.js';
		head.appendChild(script2);

        window.bc_gmap_script_inited = true;

        script.onload = function(){
            func();
        }
    };

    GmapEngine.prototype.init = function () {

        var me = this;


        this.initScripts(function () {

            var center = me.getOption('center');
            var zoom = me.getOption('zoom');

            if(me.id){
                this.el  = $('#'+this.id);

                me.map = new google.maps.Map(document.getElementById(me.id), {
                    center: {lat:center[0],lng:center[1]},
                    zoom: zoom,
                    maxZoom:15,
                    mapTypeControl:false,
                    streetViewControl:false
                });
            }

            var rd = me.getOption('ready');
            if(typeof rd == "function"){
                rd(me);
                if(me.getOption('markerClustering'))
                {
                    new MarkerClusterer(me.map, me.markers, {
                        imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                    });
                }
            }
        });

    };

    GmapEngine.prototype.addMarker = function (latLng,options) {


        var m = new google.maps.Marker({
            position: {
                lat:latLng[0],
                lng:latLng[1]
            },
            map: this.map,
            icon: options.icon_options.iconUrl
        });

        this.markers.push(m);

    };

    GmapEngine.prototype.addMarker2 = function (marker) {

        var m = new google.maps.Marker({
            position: {
                lat:marker.lat,
                lng:marker.lng
            },
            map: this.map,
            icon: marker.marker
        });

        if(marker.infobox){
			var ibOptions = {
				content: '',
				disableAutoPan: true
				, maxWidth: 0
				, pixelOffset: new google.maps.Size(-135, -35)
				, zIndex: null
				, boxStyle: {
					padding: "0px 0px 0px 0px",
					width: "270px",
				},
				closeBoxURL: "",
				cancelBubble: true,
				infoBoxClearance: new google.maps.Size(1, 1),
				isHidden: false,
				pane: "floatPane",
				enableEventPropagation: true,
				alignBottom: true
			};

			var boxText = document.createElement("div");

			// if (window.matchMedia("(min-width: 768px)").matches) {
			// 	if (popupPos == 'right') {
			// 		boxText.classList.add("right-box");
			// 	}
			// }
			//
			// $(window).resize(function () {
			// 	if (window.matchMedia("(min-width: 768px)").matches) {
			// 		if (popupPos == 'right') {
			// 			boxText.classList.add("right-box");
			// 		}
			// 	} else {
			// 		boxText.classList.remove("right-box");
			// 	}
			// });

			boxText.style.cssText = "border-radius: 5px; background: #fff; padding: 0px;";
			boxText.innerHTML = marker.infobox;

			ibOptions.content = boxText;

            // Close Old
			for(var i = 0 ; i < this.infoboxs.length; i++){

				this.infoboxs[i].close();
			}

            var ib =  new InfoBox(ibOptions);
            this.infoboxs.push(ib);

			// google.maps.event.addListener(ib, 'domready', function () {
			// 	var closeInfoBox = document.getElementById("close-popup-on-map");
			// 	google.maps.event.addDomListener(closeInfoBox, 'click', function () {
			// 		ib.close();
			// 	});
			// });

			var me = this;
			m.addListener('click', function() {
			    //
                for(var i = 0 ; i < me.infoboxs.length ; i++){
                    me.infoboxs[i].close();
                }
			    ib.open(me.map,this);
			    me.map.panTo(ib.getPosition());

                if(window.lazyLoadInstance){
                    window.lazyLoadInstance.update();
                }
			});


        }

        this.markers.push(m);
        this.markersPositions.push(m.getPosition());

    };

    GmapEngine.prototype.addMarkers = function (markers) {

        for(var i = 0 ; i < markers.length; i++){

            this.addMarker(markers[i][0], markers[i][1]);
        }

        if(this.getOption('fitBounds'))
        {
            this.bounds = new google.maps.LatLngBounds();

            for(var i = 0; i < this.markers.length; i++){

                this.bounds.extend(this.markers[i]);

            }

            this.map.fitBounds(this.bounds);
        }

    };
    GmapEngine.prototype.addMarkers2 = function (markers) {

        for(var i = 0 ; i < markers.length; i++){

            this.addMarker2(markers[i]);

        }

        if(this.getOption('fitBounds'))
        {
            this.bounds = new google.maps.LatLngBounds();

            for(var i = 0; i < this.markersPositions.length; i++){

                this.bounds.extend(this.markersPositions[i]);

            }

            this.map.fitBounds(this.bounds);
        }

    };

    GmapEngine.prototype.clearMarkers = function (markers) {

        if(this.markers.length > 0){
            for(var i = 0; i < this.markers.length; i++){
                this.markers[i].setMap(null);
            }
        }

        this.markers = [];
        this.markersPositions = [];

        this.infoboxs = [];

    };

    GmapEngine.prototype.on = function (type,func) {
        switch (type) {
            case "click":
                return this.map.addListener(type,function(e){
                    let zoom = this.getZoom();
                    func([
                        e.latLng.lat(),
                        e.latLng.lng(),
                        zoom,
                    ])
                });
            break;
            case "zoom_changed":
                return this.map.addListener(type,function(e){
                    let zoom = this.getZoom();
                    func(
                        zoom
                    )
                });
            break;
        }
    };

    GmapEngine.prototype.registerDirection = function (fromInputId,toInputId,routeCompleteCallback,placeChangeCb) {

        this.directionsService = new google.maps.DirectionsService();
        this.directionsRenderer = new google.maps.DirectionsRenderer();
        this.directionsRenderer.setMap(this.map);

        const originInput = document.getElementById(
            fromInputId
        );
        const destinationInput = document.getElementById(
            toInputId
        );
        const originAutocomplete = new google.maps.places.Autocomplete(
            originInput,
            { fields: ["place_id",'geometry'] }
        );

        const destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput,
            { fields: ["place_id",'geometry'] }
        );
        if(typeof BC_MAP_COUNTRY_CODE != 'undefined'){
            originAutocomplete.setComponentRestrictions({
                country: BC_MAP_COUNTRY_CODE,
            });
            destinationAutocomplete.setComponentRestrictions({
                country: BC_MAP_COUNTRY_CODE,
            });
        }

        this.setupPlaceChangedListener(originAutocomplete, "ORIG",placeChangeCb);
        this.setupPlaceChangedListener(destinationAutocomplete, "DEST",placeChangeCb);

        this.routeCompleteCallback = routeCompleteCallback;

        var currentDirection = this.getOption('currentDirection');
        if(typeof currentDirection !='undefined'){
            let doRoute = false;
            if(currentDirection.from.lat){
                doRoute = true;
                this.originLocation = currentDirection.from;
            }
            if(currentDirection.from.place_id){
                doRoute = true;
                this.originPlaceId = currentDirection.from.place_id;
            }
            if(currentDirection.to.lat){
                doRoute = true;
                this.destinationLocation = currentDirection.to;
            }
            if(currentDirection.to.place_id){
                doRoute = true;
                this.destinationPlaceId = currentDirection.to.place_id;
            }

            if(doRoute){
                this.route();
            }
        }
    };

    GmapEngine.prototype.setupPlaceChangedListener = function (autocomplete,mode,cb) {
        autocomplete.bindTo("bounds", this.map);

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.place_id) {
                window.alert("Please select an option from the dropdown list.");
                return;
            }

            if (mode === "ORIG") {
                this.originPlaceId = place.place_id;
                this.originLocation = null;
            } else {
                this.destinationPlaceId = place.place_id;
                this.destinationLocation = null;
            }

            cb(place,mode)
            if (this.getOption('autoCallRoute')){
                this.route();
            }

        });
    };
    GmapEngine.prototype.setDirectionPlace = function (orig,location) {
        if (orig) {
            this.originLocation = location;
            this.originPlaceId = null;
        } else {
            this.destinationPlaceId = null;
            this.destinationLocation = location
        }

        this.route();
    };
    GmapEngine.prototype.route = function () {
        const me = this;

        const options = {
            origin: { placeId: this.originPlaceId },
            destination: { placeId: this.destinationPlaceId },
            travelMode: google.maps.TravelMode.DRIVING,
        };
        if(this.originLocation){
            options.origin = this.originLocation
        }
        if(this.destinationLocation){
            options.destination = this.destinationLocation
        }
        console.log(options);
        if(!options.origin.placeId && !options.origin.lat){
            return;
        }
        if(!options.destination.placeId && !options.destination.lat){
            return;
        }
        this.directionsService.route(
            options,
            (response, status) => {
                if (status === "OK") {
                    me.directionsRenderer.setDirections(response);
                    if(this.routeCompleteCallback){
                        var leg = response.routes[ 0 ].legs[ 0 ];

                        this.originLocation = leg.start_location;
                        this.destinationLocation = leg.end_location;

                        this.routeCompleteCallback(response,this.originPlaceId,this.destinationPlaceId)
                    }
                } else {
                    window.alert("Directions request failed due to " + status);
                }
            }
        );

    };

    GmapEngine.prototype.searchBox = function (classSearchBox ,func) {
        var me = this;
        var options = {};
        if(typeof BC_MAP_COUNTRY_CODE != 'undefined'){
            options.componentRestrictions = {
                country:BC_MAP_COUNTRY_CODE
            }
        }
        var searchBox = new google.maps.places.SearchBox(classSearchBox[0],options);
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0, place ; place = places[i]; i++) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                if(i===0){
                    func([
                        place.geometry.location.lat(),
                        place.geometry.location.lng(),
                        me.map.getZoom()]
                    );
                }
            }
            me.map.fitBounds(bounds);
        });
    }

})(jQuery);
