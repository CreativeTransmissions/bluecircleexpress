/*	Google Maps Quote Calculatior Order Form
*	jQuery Plugin from Creative Transmissions 
*	http://www.creativetransmissions.com/google-maps-quote-calculator-plugin
*	Author: Andrew van Duivenbode
* 	Liscence: MIT Liscence - See liscence.txt
*/


;(function ( $, window, document, undefined ) {
		// Create the defaults 
		var map;
		var pluginName = "TransitQuotePremium",
		
		defaults = {
			ajaxUrl: '',
			customer: false,
			debug: false,
			quoteResult: 'quote',
			timepickerSelector: 'collection_time',
			datepickerSelector: 'collection_date'
		};

		// The actual plugin constructor
		function Plugin ( element, options ) {
			this.element = element;
			this.settings = $.extend( {}, defaults, options );
			this._defaults = defaults;
			this._name = pluginName;
			this.init();
		}

		Plugin.prototype = {
			/* initialization code */
			init: function () {	
				this.initRequestForms();				
				if(!this.initData()){
					return false;
				};
				if(!this.initUI()){
					return false
				};

				if(!this.initEvents()){
					return false
				};


			},
			initRequestForms: function(){
				var that = this;

				//init popup 
				$('.popup-with-form').magnificPopup({
		          type: 'inline',
    	          items: [					     
				      {
				        src: '#address-popup', // CSS selector of an element on page that should be used as a popup
				        type: 'inline'
				      }
				    ],
				    callbacks: {
					    open: function() {
					    	var map_id = window[$('#map').attr('id')];
					    	google.maps.event.trigger(map_id, 'resize');						    	
					    },
					    close: function() {
					      // Will fire when popup is closed
					      //Copy addresses to main form feilds for validation
					      $('input[name="moving_from"]').val($('#address_0').val());
					      $('input[name="moving_to"]').val($('#address_1').val());
					    }
					}
		        });
		        

				var that = this;
				$('input[name=service_type_id]').on('change', function() {
					if($('input[name=service_type_id]:checked').val()==1){
						$('#business-size').attr('required', true).show();
						$('#business-size').removeAttr('disabled');

						$('#domestic-house-size').attr('required', false).hide().removeAttr('data-parsley-id').removeClass('parsley-error');
						$('#domestic-house-size').attr('disabled', true);
					} else{
						$('#business-size').attr('required', false).hide().removeAttr('data-parsley-id').removeClass('parsley-error');
						$('#business-size').attr('disabled', true);
						
						$('#domestic-house-size').attr('required', true).show();
						$('#domestic-house-size').removeAttr('disabled');
					}
				});


				$('#address-popup input[name="addresses-ok"]').on('click', function(){
					$.magnificPopup.close();
				});

			}, 


			initData: function(){
				this.log('initData');
				if(!this.initDataRates()){
					return false;
				};
				this.initDataMapSettings();
				return true;
			},

			initDataRates: function(){
				this.log('initDataRates');
				var limits = [];
				var rates = [];
				var costPerUnit = []; //cost for additional miles

				if(!this.settings.data.rates){
					this.log('Warning: no Rates supplied');
					return false;
				
				}
				$.each(this.settings.data.rates, function(idx,r){
					//key based on service type id
					var ratesKey = 's_'+String(r.service_type_id);				
					
					//only add limits once
					limits.push(parseFloat(r.distance));

					if(!rates[ratesKey]){
						rates[ratesKey] = [];
					};
					//store the rates per distance unit, hour or set amount
					rates[ratesKey].push(r);
				});

				this.rates = rates;
				this.limits = limits;
				
				this.log('initDataRates');
				this.log(this.limits);
				this.log(this.rates);
				return true;
			},

			initDataMapSettings: function(){
				//Initialize map settings

				this.geolocate = (this.settings.data.geolocate=='true')?true:false;

				this.mapSettings = {
						// Google Map Options
						mapTypeId : google.maps.MapTypeId.ROADMAP, 
						scrollwheel : false,
						startLat: 38.8763,
						startLng: 12.1852,
						zoom: 2
				};

				if((this.settings.data.startLat!='')&&(this.settings.data.startLng!='')){
					this.mapSettings.startLat = this.settings.data.startLat;
					this.mapSettings.startLng = this.settings.data.startLng;
					this.mapSettings.zoom = 10;
				} else {
					//geolocate current user position if no start lat or lng is returned
					this.geolocate = true;
				};					

			},

			initUI: function () {					
				this.initCalculator();
				this.initDatePicker();
				this.initTimePicker();
				$('.notice-field').hide();
				return true;				
			},

			initCalculator: function(){

				//Initialize Google Maps Quote Calculator jquery plugin
				this.calculator = $('#map').mapQuoteCalculator({

					ajaxUrl: TransitQuotePremiumSettings.ajaxurl,
					debug: this.settings.debug,

					// fare calculation options
					limits: this.limits, // Travel distance boundaries for which rates to use

					// the costs per mile or kilometer depending on which is selected
					rates: this.rates,

					//Prices per mile when over the highest distance limit
					costPerUnit: this.excessDistance,
					
					showRoute: true,

					units: this.settings.data.distance_unit, // imperial or metric
					geolocate: this.geolocate,
					// Google Map Options
					map :this.mapSettings,
					minNotice: this.settings.data.min_notice,
					minNoticeCharge: this.settings.data.min_notice_charge,

					/*	
						The form elements tell the plugin which html inputs are used for 
						entering the addresses and diplaying the reuslts 

						You can also use them to put the information into form fields so you can save them to your server
					*/

					// Required Form Elements 
					pickUpInput: 'address_0', // The id of the text input for the pick up address
					dropOffInput: 'address_1',  // The id of the text input for the drop off address

					 /* The id of the text input or html element for displaying the quote.
					 	You can also set a comma separated list of ids if you would like to populate more than one element
					 	for example display in a large results box and a hidden form element */

					quoteResult: this.settings.data.quoteResult, // for more than one: 'quote,hiddenquote'
					distance: 'distance', //The id of the text input or html element for displaying the distance					
					hours: 'hours',  //The id of the text input or html element for displaying estimated travel time

					surcharge: 'surcharge',

					// Optional Form Elements - Latitude and Longitude coordinates for addresses
					pickUpLat: 'address_0_lat', 
					pickUpLng: 'address_0_lng',

					dropOfLat: 'address_1_lat',
					dropOfLng: 'address_1_lng',

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
							html +='<input type="hidden" id="address_'+idx+'_lat" name="lat_'+idx+'" value=""/>';
							html +='<input type="hidden" id="address_'+idx+'_lng" name="lng_'+idx+'" value=""/>';

						return html;
					}

				});
			},

			initDatePicker: function(){
				var that = this;
				$('#'+this.settings.datepickerSelector).datepicker({
					dateFormat: 'dd / mm / yy',
					altField:'#delivery_date',
					altFormat:'dd-mm-yy',
					minDate: 0,
					onSelect: function(){
						$('#'+that.settings.datepickerSelector).change();
						that.calculator.updateQuote();
					}
				});

			},

			initTimePicker: function(){
				var that = this;
				$('#'+this.settings.timepickerSelector).timepicker({
					useLocalTimezone: true,
					onSelect: function(){
					 	that.calculator.updateQuote();
					}
				});	
			},

			processCustomerAddresses: function(){
				//convert json string to array of customer addresses indexed as per database
				var addresses = $.parseJSON(this.settings.customerAddresses);
				var indexed = [];
				$.each(addresses, function(idx,address){
					var addressId = parseInt(address.id);
					indexed[addressId] = address;
				});
				return indexed;
			},

			initEvents: function(){
				var that = this;

				$('input,select').keypress(function(event) { return event.keyCode != 13; });

				$('a.no-address').on('click', function(e){
					e.preventDefault();
					e.stopPropagation();
					var clsParts = this.className.split('-');
					var locNo = clsParts.pop();
					that.calculator.pickLocation(locNo);
				})

				if(this.settings.data.customerAddresses){
					$('#select_address_0').on('change', function(){
						var addressId = $(this).val();
						that.updateAddress('Pick Up', addressId);
					});

					$('#select_address_1').on('change', function(){
						var addressId = $(this).val();
						that.updateAddress('Drop Off', addressId);
					});
				};

				$(this.element).on('submit', function (e) {
					e.preventDefault;
				});

				$(this.element).on('click','input:submit', function(e){
					e.preventDefault();
					var btn = e.target;
					if($(that.element).parsley().validate()){
						that.submitForm(btn)
					};
					
				});

				$(this.element).on('click','button:submit', function(e){
					e.preventDefault();
					var btn = e.target;
					that.submitForm(btn)					
				});

				$.listen('parsley:field:error', function(parsleyField) {
					if (parsleyField.$element.is(":hidden")) {
				        parsleyField._ui.$errorsWrapper.css('display', 'none');
				       	parsleyField.validationResult = true;
				        return true;
			    	}
				/*	if (parsleyField.$element.attr('name') === 'field1') {
					$("input[name=field2]").focus();
					}*/
				});
			
			},

			submitForm: function(btn){
				var that = this;
				var submitType = $(btn).val();

				$('.spinner-div').css({
				    height: $('.spinner-div').parent().height(), 
				    width: $('.spinner-div').parent().width()
				});

				//check for total cost element
				var totalEl = $('input[name="total"]');
				if(totalEl.length>0){
					//total cost element is on page so validate it
					var totalCost = $('input[name="total"]').val();
					if(!totalCost){
						invalid = true;		
					};
				};

			
				$('.progress, .success, failure').hide();
				this.updateProgressMessage('Sending your request to our staff, please wait a moment...');
				$('.buttons').hide();
				$('.spinner-div').css({
					    height: $('#quote-form').height(), 
					    width: $('#quote-form').width()
				});	
				$('.spinner-div').show();

				//serialize form
				var data = $(this.element).serialize();
					//add button value to determine if request is for a quote or payment
					data += '&submitType='+submitType;

				$.post(this.settings.ajaxUrl, data, function(response) {
					if(response.success==='true'){
						$('.failure, .progress, .spinner-div').hide();
						if(response.data.success_message){
							$('.success').html(response.data.success_message);
						};
						$('.success').show();
						//$('#quote-form')[0].reset();
					} else {
						console.log(response)
						console.log(response.success)
						$('.failure, .progress, .spinner-div').hide();
						$('.failure .msg').html(response);
						$('.failure, .buttons').show();
					};
					
				}, 'json');
			},

			log: function(data){
				if(this.settings.debug){
					console.log(data);
				}
			},

			updateAddress: function(addressType, addressId){
				//get address details
				var address = this.customerAddresses[addressId];
				if(!address){
					this.log('No details for address: ' + address);
					return false;
				};

				//Add address text to search box
				switch(addressType){
					case 'Pick Up':
						$('#address_0').val(address.address);
					break;
					case 'Drop Off':
						$('#address_1').val(address.address);
						var deliveryName = (address.delivery_contact_name)?address.delivery_contact_name:'';
						$('#delivery_name').val(deliveryName);
					break;
				}
				//populate the calculator
				this.calculator.setAddress(addressType, address);

				//update form with location data
				this.calculator.updateForm(addressType);

				//check if route is now available
				this.calculator.checkForRoute();	
			},

			updateProgressMessage: function(msg){
				$('.progress p').html(msg);
				$('.progress').show();
			}

		};

		$.fn[ pluginName ] = function ( options ) {
				return this.each(function() {
						if ( !$.data( this, "plugin_" + pluginName ) ) {
								$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
						}
				});
		};

})( jQuery, window, document );