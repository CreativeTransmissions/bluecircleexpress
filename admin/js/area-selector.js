/*	Google Places Place Selector
*	jQuery Plugin from Custom Google Map Tools
*	http://www.transitquote.co.uk
*	Author: Andrew van Duivenbode
* 	Liscence: MIT Liscence - See liscence.txt
*/


;(function ( $, window, document, undefined ) {

		var map;

		// Create the defaults 
		var pluginName = "areaSelector",
				defaults = {
					debug: true,

					geolocate: true,

					map: {
						// Google Map Options
						mapTypeId : google.maps.MapTypeId.ROADMAP, 
						scrollwheel : false,
						startLat: 52.0406224,
						startLng: -0.7594171000000642,
						zoom : 10
					}
		};

		// The actual plugin constructor
		function Plugin ( element, options ) {
				this.element = element;
				this.settings = $.extend( {}, defaults, options );
				this._defaults = defaults;
				this._name = pluginName;
				this.geocoder = new google.maps.Geocoder();
				this.mapId = this.element.id;
				this.pickUpPos = '';
				this.dropOffPos = '';
				this.init();
		}

		Plugin.prototype = {

				/* initialization code */
				init: function () {
					this.initUI();
				//	this.initEvents();
				},

				initUI: function () {
					var that = this;
					if(this.settings.geolocate){
						this.geoLocateUser(function(position){

							//get loction coords
							var lat = position.coords.latitude;
							var lng = position.coords.longitude;

							//show map
							that.settings.map.startLat = lat;
							that.settings.map.startLng = lng;
							that.initMap();
							that.initMapElements();

							//show position
							var pos = new google.maps.LatLng(lat, lng);						
							that.userMarker = that.initMarker({pos:pos,
													visible: true});

						});		
					} else {
						//no geolocation
						this.initMap();
						this.initMapElements();
					}
					
				},

				initMapElements: function(){

			        var drawingManager = new google.maps.drawing.DrawingManager({
			          drawingControl: true,
			          drawingControlOptions: {
			            position: google.maps.ControlPosition.TOP_CENTER,
			            drawingModes: ['polygon']
			          }
			        });
			        drawingManager.setMap(this.map);

					google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
					 	var path = polygon.getPath();

        				var encodeString = google.maps.geometry.encoding.encodePath(path);
					 	$('input[name="definition"]').val(encodeString);
					});


				},

				loadPolygon: function(){
				// ** WIP example code

			    var triangleCoords = [ // load from databaes
			        new google.maps.LatLng(33.5362475, -111.9267386),
			        new google.maps.LatLng(33.5104882, -111.9627875),
			        new google.maps.LatLng(33.5004686, -111.9027061)

			    ];

			    // Construct the polygon
			    bermudaTriangle = new google.maps.Polygon({
			        paths: triangleCoords,
			        draggable: true,
			        editable: true,
			        strokeColor: '#FF0000',
			        strokeOpacity: 0.8,
			        strokeWeight: 2,
			        fillColor: '#FF0000',
			        fillOpacity: 0.35
			    });

			    bermudaTriangle.setMap(map);
				},

				renderCircle: function(){

					var cityCircle = new google.maps.Circle({
			            strokeColor: '#003300',
			            strokeOpacity: 0.8,
			            strokeWeight: 2,
			            fillColor: '#00cc00',
			            fillOpacity: 0.35,
			            map: this.map,
			            center: new google.maps.LatLng(this.settings.map.startLat, this.settings.map.startLng),
			            radius: this.settings.radius
			          });

				},




				initMarker: function(markerOptions){
					var options = this.getMapOptions();
					var markerOptions = (markerOptions)? markerOptions : {};
					var markerOptions = $.extend({
						map: this.map,
						anchorPoint: new google.maps.Point(0, -29),
						draggable : this.settings.draggableMarker,
						position: options.center,
						visible: false
					}, markerOptions);

					var marker = new google.maps.Marker(markerOptions);	
					marker.setIcon(/** @type {google.maps.Icon} */({
						url: 'http://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
						size: new google.maps.Size(71, 71),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(17, 34),
						scaledSize: new google.maps.Size(35, 35)
					}));

					return marker;					
				},

				initAddressPicker: function(inputId){

					var input = document.getElementById(inputId);
					var autocomplete = new google.maps.places.Autocomplete(input);

					autocomplete.bindTo('bounds', this.map);

					return autocomplete;

				},

			

				displayMessage: function(msg){
					$('#feedback').html(msg);
				},

			
				getAddressPosition: function(addressRec){

					//get gmaps position from db address rec
					if(!addressRec){
						this.log('no addressRec');
						return false;
					};

					if(!addressRec.lat){
						this.log('no addressRec lat');
						return false;
					};

					if(!addressRec.lng){
						this.log('no addressRec lng');
						return false;
					};
					var pos = new google.maps.LatLng(addressRec.lat, addressRec.lng);
					if(!pos){
						return false;
					};
					return pos;
				},

				getHiddenAddressParts: function(addressNo){
					var addressParts = [];

					//populate each component
					$.each(this.settings.addressCmpNames, function(idx, cmp_name){
						var elName = '#address_'+addressNo+'_'+cmp_name;
						var part = $(elName).val();
						if(part){
							addressParts.push(part);
						};
					});		
					if(addressParts.length==0){
						return false;
					};

					return addressParts;
				},

				getMapData: function(){
					if(!this.mapData){
						return false;
					};
					return this.mapData
				},

				geoLocateUser: function(callback){
					var that = this;
					if(navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
								if(callback){
									callback(position)
								}
							});
					};
				},
				updateForm: function(address, components){
					var that = this;
					//update form with location data
					switch(address){
						case 'Pick Up':
							var addressNo = '0';
							this.pickUpPos = this.pickUpMarker.getPosition();
							this.updateElContent(this.pickUpLat, this.pickUpPos.lat());
							this.updateElContent(this.pickUpLng, this.pickUpPos.lng());
						break;

					};

					//populate each component
					if(components){
						$.each(this.settings.addressCmpNames, function(idx, cmp_name){
							var elName = '#address_'+addressNo+'_'+cmp_name;
							var elValue = that.getAddressPart(components, cmp_name, 'long_name');
							that.updateElContent($(elName), elValue);
						});
					}
				},

				updateElContent: function(el, value){
					if(!el){
						return false;
					};
					if(typeof(el)=='object'){
						var domEl = $(el).get(0);
					} else {
						var id = '#'+el;	
						var domEl = $(id).get(0);
					};
					//populate html elements by id
					if(domEl){
						var tagName = domEl.tagName;
						//that.log('populate domEl: ' + tagName);
						switch(tagName){
							case 'SPAN':
							case 'DIV':
							case 'P':
								//that.log(domEl);
								//that.log(value);
								$(domEl).html(value);
							break;
							default:
								$(domEl).val(value);
						};
					}
					//single object so return true;
					if(typeof(el)=='object'){
						return true;
					};


					var inputId = 'input[name="'+el+'"]';
					var textId = 'textarea[name="'+el+'"]';

					//populate form input elements
					$(inputId).val(value);

					//populate form input elements by class
					var inputCls = 'input.'+el;					
					$(inputCls).val(value);

					//that.log('textId: ' + textId);
					//populate form textareas
					$(textId).text(value);

					return true;
				},

				updateBounds: function(){
					if(($(this.pickUpInput).val() !='' ) && ($(this.dropOffInput).val() != '') ) {
						var pickUpMarkerPos = this.pickUpMarker.getPosition();
						var dropOffMarkerPos = this.dropOffMarker.getPosition();
						
						var bounds = new google.maps.LatLngBounds();
							bounds.extend(pickUpMarkerPos);
							bounds.extend(dropOffMarkerPos);

						this.map.fitBounds(bounds);
					}
				},

				getAddressPart : function(result, field, field_type) {
					//return a specific field from the address

					var value ='';
					$.each(result, function(idx, cmp){
						$.each(cmp.types, function(idx2, type){
							if (type==field) {
								value = cmp[field_type];
							};							
						});
					});

					return value;
				},

				clickMap: function(e){
					//called after map is clicked
					this.marker.setPosition(e.latLng);
					this.marker.setVisible(true);
					this.updatePosition();
				},

				dragEnd : function() {
					//called after marker is dragged
					this.updatePosition();
				},

				setMapData: function(data){
					if(!data){
						this.mapData = '';
					} else {
						this.mapData = data;
					}
				},

				updatePosition: function(){
					var that = this;

					//Update  the form fields with new lat lng and fetch geocode results for form
					var position = this.marker.getPosition();

					//Update the lat and lng form inputs
					if (this.lat) {
						$(this.lat).val(position.lat());
					};
					if (this.lng) {
						$(this.lng).val(position.lng());
					};

					this.reverseGeocode(position, function(results){
						if(results[0]){
							that.updateForm(results[0].address_components);
						};
					});

					
				},

				clearAddresses: function(){
					this.dropOffPos = '';
					this.pickUpPos = '';
					$(this.settings.pickUpInput).val('');
					$(this.settings.dropOffInput).val('');
				},

				initMap: function(){
					if(!this.mapId){
						return false;
					};

					this.mapElement = $('#'+this.mapId);
					if(this.mapElement.length==0){
						return false;
					}

					var options = this.getMapOptions();
					this.gmap = $(this.mapElement[0]).gmap(options);

					//store jquery version
					this.map = $(this.gmap).gmap('get','map');

				},

				getMapOptions: function(){
					var options = $.extend({},this.settings.map);
					//create gmap point for start
					options.center = new google.maps.LatLng(options.startLat, options.startLng);

					//remove non-google options 
					delete options.startLat;
					delete options.startLng;

					return options;			 
				},

				getMap: function(){
					return this.map;
				},

				clickMarker: function(marker, markerSetName){

					var that = this;

					//set map to position of marker
					var latLng = marker.getPosition(); 
					this.map.setCenter(latLng);
							
				},

				log: function(data){
					if(this.settings.debug){
						console.log(data);
					}
				},

				reverseGeocode: function(latlng, callback){
					var that = this;

					this.geocoder.geocode({'latLng': latlng}, function(results, status) {
      					if (status == google.maps.GeocoderStatus.OK) {
        					if (results[1]) {
        						callback(results);
        					}
						}
					});
				}
		
		};

		$.fn[ pluginName ] = function ( options ) {
			var plugin;
			  this.each(function() {
			    plugin = $.data(this, 'plugin_' + pluginName);
			    if (!plugin) {
			      plugin = new Plugin(this, options);
			      $.data(this, 'plugin_' + pluginName, plugin);
			    }
			  });
			  return plugin;
		};
})( jQuery, window, document );
