/*	Google Places Place Selector
*	jQuery Plugin from Custom Google Map Tools
*	http://www.customgooglemaptools.com
*	Author: Andrew van Duivenbode
* 	Liscence: MIT Liscence - See liscence.txt
*/


;(function ( $, window, document, undefined ) {

		var map;

		// Create the defaults 
		var pluginName = "placeSelector",
				defaults = {
					debug: true,
					addressCmpNames: ['street_number','route','postal_town','administrative_area_level_2','administrative_area_level_1','country','postal_code','country'],
					addressTemplate: function(data){
						if(!data.idx){
							return false;
						};

						var idx = data.idx;

						var html = '<input type="hidden" id="address_'+idx+'_street_number" name="street_number_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_route" name="route_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_postal_town" name="postal_town_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_administrative_area_level_2" name="administrative_area_level_2_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_administrative_area_level_1" name="administrative_area_level_1_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_country" name="country_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_postal_code" name="postal_code_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_lat" name="tq_pro_map_options[start_lat]" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_lng" name="tq_pro_map_options[start_lng]" value=""/>';
						return html;
					},

					geolocate: true,

					map: {
						// Google Map Options
						mapTypeId : google.maps.MapTypeId.ROADMAP, 
						scrollwheel : false,
						startLat: 52.0406224,
						startLng: -0.7594171000000642,
						zoom : 10
					},

					draggableMarker: true, // Allow the user to drag the marker to a location as well as search

					// Required Form Elements 
					pickUpInput: 'place_selector_address', // The id of the text input for the pick up address

					// Optional Form Elements - Pick Up Address details in Google's data format
					pickUpAdminAreaLevel2: 'address_0_administrative_area_level_2',
					pickUpAdminAreaLevel1: 'address_0_administrative_area_level_1',
					pickUpCountry: 'address_0_country',
					pickUpPostalCode: 'address_0_postal_code',

				
					// Optional Form Elements - Latitude and Longitude coordinates for addresses
					pickUpLat: 'address_0_lat', 
					pickUpLng: 'address_0_lng'
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
					this.initFormElements();
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
					/* initialize the html input which are bound to google places */

					this.addessPickers = [];

					this.pickUpInput = $('#'+this.settings.pickUpInput);

					if(this.pickUpInput.length>0){
						this.pickUpAutoComplete = this.initAddressPicker(this.settings.pickUpInput);
						this.pickUpMarker = this.initMarker({visible:true});
						this.pickUpInfowindow = new google.maps.InfoWindow();

						this.initPlaces('Pick Up', this.pickUpAutoComplete, this.pickUpMarker);

						//set start place name
						var startPlaceName = (this.settings.startPlaceName)?this.settings.startPlaceName:'';
						this.pickUpInput.val(startPlaceName);

						//set start lat
						if(this.settings.map.startLat){
							$(this.pickUpLat).val(this.settings.map.startLat);
						};
						//set start lng
						if(this.settings.map.startLng){
							$(this.pickUpLng).val(this.settings.map.startLng);
						};
						
					} else {
						this.log('There is no address input with id: '+ this.settings.pickUpInput);
					}
				},

				addElements: function(){
					//Adds the hidden address elements to the page to capture the places results
					var that =this;
					$('.addresspicker').each(function(idx, el){
						$(el).after(that.settings.addressTemplate({idx:String(idx)}));
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

				initFormElements: function(){
					this.addElements();
					this.getFormRefs();
					this.setFormDefaults();
				},

				initEvents: function () {
					this.initPageEvents();
				},

				initPlaces: function(addressType, addressPicker, marker){
					var that = this;

					// Event handler for changed place selection in drop down box
					google.maps.event.addListener(addressPicker, 'place_changed', function() {
						//place spefic stuff
						var place = addressPicker.getPlace();
						if(!place){
							return;
						};
						if (!place.geometry) {
							return;
						};

						var address = that.getAddressFromComponents(place.address_components);

						// If the place has a geometry, then present it on a map.
						if (place.geometry.viewport) {
							that.map.fitBounds(place.geometry.viewport);
						} else {
							//zoom and center to location
							//that.map.setCenter(place.geometry.location);
							//that.map.setZoom(17);
						};

						//Add address text to search box
						switch(addressType){
							case 'Pick Up':
								$('#select_address_0').val('');
							break;
						};				
						that.setAddress(addressType,{address:address}, place.geometry.location);
						
						//update form with location data
						that.updateForm(addressType, place.address_components);

					  });				
				},

				getAddressFromComponents: function(address_components){
					if(!address_components){
						return '';
					};
					var address = [
						(address_components[0] && address_components[0].short_name || ''),
						(address_components[1] && address_components[1].short_name || ''),
						(address_components[2] && address_components[2].short_name || '')
						].join(' ');
					
					return address;			
				},

				setMarkerInfoWindow: function(addressType, address){
					if(!address){
						return false;
					};

					if(!addressType){
						return false;
					};

					//get marker
					var marker = (addressType == 'Pick Up') ? this.pickUpMarker : this.dropOffMarker;
					var infoWindow = (addressType == 'Pick Up') ? this.pickUpInfowindow : this.dropOffInfowindow;
						

					infoWindow.setContent('<div class="pop-up">' + address+'</div>');
					infoWindow.open(this.map, marker);
				},

				setAddress: function(addressType, address, position){
					if(!address){
						return false;
					};

					if(!addressType){
						return false;
					};

					if(!position){ //get from address lat / lng if not passed
						var position = this.getAddressPosition(address);
					}

					if(!position){
						this.log('no pos');
						return false;
					}

					//set the marker location and address details to a passed address object
					//get infoWindow
					var infoWindow = (addressType == 'Pick Up') ? this.pickUpInfowindow : this.dropOffInfowindow;

					//get marker
					var marker = (addressType == 'Pick Up') ? this.pickUpMarker : this.dropOffMarker;


					//hide infoWindow
					infoWindow.close();

					//hide marker
					marker.setVisible(false);

					//set marker location
					marker.setPosition(position);

					//show marker
					marker.setVisible(true);

					//this.updateBounds();

					if(address.address){
						//set infowindow for full address
						this.setMarkerInfoWindow(addressType, address.address);
					};

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

				

				getFormRefs: function(){
					//set up references to the form elements to populate if they exist

					//pick up info
					this.pickUpAdminAreaLevel2 = $('#'+this.settings.pickUpAdminAreaLevel2);					
					this.pickUpAdminAreaLevel1 = $('#'+this.settings.pickUpAdminAreaLevel1);
					this.pickUpCountry = $('#'+this.settings.pickUpCountry);						
					this.pickUpPostalCode = $('#'+this.settings.pickUpPostalCode);	

					this.pickUpLat = $('#'+this.settings.pickUpLat);	
					this.pickUpLng = $('#'+this.settings.pickUpLng);	

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

				initPageEvents: function(){
					var that = this;

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
				},

				setFormDefaults: function(){
					//set default form values 

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
