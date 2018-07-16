/*	Google Maps Quote Calculatior Order Form
*	jQuery Plugin from Creative Transmissions 
*	http://www.creativetransmissions.com/google-maps-quote-calculator-plugin
*	Author: Andrew van Duivenbode
* 	Liscence: MIT Liscence - See liscence.txt
*/


;(function ( $, window, document, undefined ) {
		// Create the defaults 
		var map;
		var pluginName = "TransitQuotePro",
		
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
				$('input[name=service_id]').on('change', function() {
					if($('input[name=service_id]:checked').val()==1){
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
				this.log('sandbox: '+this.settings.data.sandbox);
				if(!this.initDataRates()){
					return false;
				};
				this.initDataMapSettings();
				this.initDataJourneyRestrictions();
				this.payPalInitialized = false;
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

				} else {
					this.rates = this.settings.data.rates;
				}
				
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

			initDataJourneyRestrictions: function(){

				if(this.settings.data.max_distance==0){
					this.settings.data.max_distance = false;
				};

				if(this.settings.data.max_travel_time==0){
					this.settings.data.max_travel_time = false;
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
				var that = this;

				//Initialize Google Maps Quote Calculator jquery plugin
				this.calculator = $('#map').mapQuoteCalculator({

					ajaxUrl: TransitQuoteProSettings.ajaxurl,
					debug: this.settings.debug,

					// fare calculation options
					limits: this.limits, // Travel distance boundaries for which rates to use

					// the costs per mile or kilometer depending on which is selected
					rates: this.rates,

					//Prices per mile when over the highest distance limit
					costPerUnit: this.excessDistance,
					
					showRoute: true,

					askForUnitNo: this.settings.data.ask_for_unit_no,
					askForPostCode: this.settings.data.ask_for_postcode,
					units: this.settings.data.distance_unit, // imperial or metric
					geolocate: this.geolocate,
					// Google Map Options
					map :this.mapSettings,
					maxAddressPickers: this.settings.data.max_address_pickers,
					minNotice: this.settings.data.min_notice,
					minNoticeCharge: this.settings.data.min_notice_charge,
					minCost: this.settings.data.min_price,

					minDistance: this.settings.data.min_distance,
					minDistanceMsg: this.settings.data.min_distance_msg,

					pickStartAddress: this.settings.data.pick_start_address,
					startPlaceName: this.settings.data.startPlaceName,
					maxDistance: this.settings.data.max_distance,
					maxDistanceMsg: this.settings.data.max_distance_msg,

					minTravelTime: this.settings.data.min_travel_time,
					minTravelTimeMsg: this.settings.data.min_travel_time_msg,

					maxTravelTime: this.settings.data.max_travel_time,
					maxTravelTimeMsg: this.settings.data.max_travel_time_msg,

					insertDestLinkText: this.settings.data.insert_dest_link_text,
					removeDestLinkText: this.settings.data.remove_dest_link_text,

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
					afterQuote: function(){
						//console.log('got distance, getting quote');
						that.submitForm('get_quote');
					},

					callbackChangeVehicleId: function(vehicleId){
						// UI changes on vehicle selection
						$('.select-desc').hide();
						var descToShowSelector = '.v-desc-'+String(vehicleId);
						$(descToShowSelector).show();
					}

				});
			},


			dateConverter:function(UNIX_timestamp){
			  var a = new Date(UNIX_timestamp);
			  var year = a.getFullYear();
			  var month = a.getMonth()+1;
			  var day = a.getDate();
			  var date = day + '-' + month + '-' + year;
			  return date;
			},


			initDatePicker: function(){
				var that = this;
				var arrayOfNumbers = TransitQuoteProSettings.blocked_dates.map(function(t){
					return new Date(t[0]); 
				});
				var interval = TransitQuoteProSettings.time_interval;
				
				var $inputDate =$('#'+this.settings.datepickerSelector).pickadate({
					formatSubmit: 'dd-mm-yyyy',
					disable : arrayOfNumbers,
					format:'dd / mm / yyyy',
		            min: new Date(),
		            onSet: function(context) {
		            	var date = that.dateConverter(context.select);
		            	$('#delivery_date').val(date);
		            	that.calculator.updateQuote();

		            	var selectedDate = date;
		            	var today = that.dateConverter(new Date());

		            	var inputTime = $('#'+that.settings.timepickerSelector).pickatime();
		            	var timePickerObj = inputTime.pickatime('picker');

		            	if(selectedDate == today){ 
		            		// if dates are equal then time should be start from now not begining of the day
		            		var todayDate = new Date();
							todayDate.setTime(todayDate.getTime() + (1*60*60*1000)); //add one hour	            			
	            			timePickerObj.set('min', todayDate).clear(); //clear suppose if prev time selected

		            	} else {
		            		// casue prev dates are disabled
		            		timePickerObj.set('min', false);
		            	}
				  	},
				  
		        });
		        var datePickerObj = $inputDate.pickadate('picker');
			},

			initTimePicker: function(){
				var that = this;
				var interval = TransitQuoteProSettings.time_interval;
				var today = new Date();
				today.setTime(today.getTime() + (1*60*60*1000)); //add one hour
				var $input = $( '#'+this.settings.timepickerSelector ).pickatime({
					min: today,
					format:'HH:i',
					interval: parseInt(interval),
					onSet: function(context) {
				    	that.calculator.updateQuote();
				  	}
				});
				var timePickerObj = $input.pickatime('picker');
			},

			initPayPal: function(){
				var that = this;

				paypal.Button.render({

				    env: that.settings.data.sandbox, // sandbox | production

				    // Show the buyer a 'Pay Now' button in the checkout flow
				    commit: true,

				    // payment() is called when the button is clicked
				    payment: function() {
				    	$('.paypal-msg-failure').hide();
				    	$('.paypal-msg-success').hide();
				    	var jobId = $('input[name="job_id"]').val();
				        // Set up a url on your server to create the payment_id
				        var CREATE_URL = TransitQuoteProSettings.paypal.createPaymentUrl;

						// Set up the data you need to pass to your server
						var data = {
				            jobId: jobId
				        };
		
				        // Make a call to your server to set up the payment
				        return paypal.request.post(CREATE_URL, data)
				            .then(function(res) {
				                return res.payment_id;
				            });
				    },

				    // onAuthorize() is called when the buyer approves the payment
				    onAuthorize: function(data, actions) {
				        
				        // Set up a url on your server to execute the payment
				        var EXECUTE_URL = TransitQuoteProSettings.paypal.executePaymentURL;

				        // Set up the data you need to pass to your server
				        var jobId = $('input[name="job_id"]').val();
				        var data = {
				            paymentID: data.paymentID,
				            payerID: data.payerID,
				            jobId: jobId
				        };

				        // Make a call to your server to execute the payment
				        return paypal.request.post(EXECUTE_URL, data, {timeout: 30000})
				            .then(function (response) {
				            	that.processResponseExecution(response);	
				            });
				    }

				}, '#paypal-button-container');

			},
			
			processResponseExecution: function(response){
				$('#paypal-button-container').hide();
				if(response.status === 'approved'){
					$('.paypal-msg-success').show();
				} else {
					var message = 'Unknown PayPal Error.';
					if(response.error){
						var errorData = response.error;
						if(errorData.message){
							var message = errorData.message;
						};
					};
					message = 'Your payment could not be processed because PayPal returned the following error.<br/>'+message + '<br/>Please try again or contact us for assistance.';
					$('.paypal-msg-failure').html(message);
					$('.paypal-msg-failure').show();	
					$('.buttons').show();
					
				}
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
					e.stopPropagation();
					e.preventDefault();
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
	
					that.onClickSubmitButton(btn);
		
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
				return true;
			},

			onClickSubmitButton: function(btn){
				var submitType = $(btn).val();
				switch(submitType){
					case 'get_quote'
						this.updateFormAction('tq_pro4_get_quote');
						break;
					case 'pay_method_1':
					case 'pay_method_2':
					case 'pay_method_3':
						if($(this.element).parsley().validate()){
							this.updateFormAction('tq_pro4_save_job');
							this.submitForm(submitType);
						};
					}			
				}
			},

			submitForm: function(submitType){
				var that = this;

				$('.failure').hide();
				var progressMessage = this.getProgressMsgForSubmitType(submitType);
				this.updateProgressMessage(progressMessage);
				$('.buttons').hide();
				$('.paypal-msg-failure').hide();

				//serialize form
				var data = $(this.element).serialize();
					//add button value to determine if request is for a quote or payment
					data += '&submit_type='+submitType;

				$.post(this.settings.ajaxUrl, data, function(response) {
					if(response.success==='true'){
						that.submissionSuccess(response, submitType);
					} else {
						$('.failure, .progress, .spinner-div').hide();
						$('.failure .msg').html(response.msg);
						$('.failure, .buttons').show();
					};
					$('.spinner-div').hide();
				}, 'json');
			},

			getProgressMsgForSubmitType: function(submitType){
				switch(submitType){
					case 'get_quote':
						return 'Calculating Estimated Delivery Cost..';
					break;
					case 'book_delivery':
						return 'Sending your request to our staff..';
					break;
					case 'pay_method_1':
					case 'pay_method_2':
					case 'pay_method_3':
					case 'pay_method_4':
						return 'Processing Payment..';
					break;
				}
			},

			submissionSuccess: function(response, submitType){
				this.hideStatusMessages();
				switch(submitType){
					case 'get_quote':
						if(response.data.quote){
							this.populateQuoteFields(response.data.quote);
							this.showQuoteFields();
						};
						
					break;
					case 'book_delivery':
						if(response.data.job_id){
							this.populateFormWithJobId(response);
						};
						$('.on-delivery').show();
						$('.on-delivery-msg-succcess').html(response.success_message);
						$('.tq-form-fields-container').hide();
					break;
					case 'pay_method_1':
					case 'pay_method_2':
					case 'pay_method_3':
					case 'pay_method_4':
						if(response.data.job_id){
							this.populateFormWithJobId(response);
						};
						this.processPaymentResponse(response);
					break;
				};
			},

			populateQuoteFields: function(quote){
				$('.totalCost').html(quote.total);
				$('.basicCost').html(quote.distance_cost);
				$('.rateTax').html(quote.rate_tax);
				$('.taxCost').html(quote.tax_cost);
				$('input[name="distance_cost"]').val(quote.distance_cost);
				$('input[name="total"]').val(quote.total);
				$('input[name="rate_tax"]').val(quote.rate_tax);
				$('input[name="tax_cost"]').val(quote.tax_cost);
				$('#breakdown').val(JSON.stringify(quote.breakdown));
			},

			showQuoteFields: function(){
				$('.quote-fields').removeClass('hidden');
				$('.quote-fields').show();
				$('.success.buttons').show();
				$('.tq-form-fields-container').show();
				$('.tq-form-fields-container').removeClass('hidden');
			},

			processPaymentResponse: function(response){
				if(this.hasValidPaymentMethod(response)){
					var paymentMethod = this.getPaymentMethodFromResponse(response);
						paymentMethod = parseInt(paymentMethod);
					if(paymentMethod=== 1 ||  paymentMethod === 0){
						$('.on-delivery-msg-succcess').html(response.success_message);
					};
					this.showPaymentButton(paymentMethod, response.data);
				}
			},

			hasValidPaymentMethod: function(response){
				if(this.hasPaymentMethod(response)){
					if(this.paymentMethodIsValid(response.payment_method)){
						return true;
					};
				};

				return false;
			},

			hasPaymentMethod: function(response){
				if(typeof(response.payment_method)!=='undefined'){
					return true;					
				};
				return false;
			},

			paymentMethodIsValid: function(paymentMethod){
				if(isNaN(parseInt(paymentMethod))){
					return false;
				};
				return true;
			},

			getPaymentMethodFromResponse: function(response){
				var paymentMethod = parseInt(response.payment_method);
				return paymentMethod;
			},

			hideStatusMessages: function(){
				$('.failure, .progress, .spinner-div').hide();
			},

			showSuccessMessage: function(){
				$('.success').show();
			},

			populateFormWithJobId: function(response){
				$('input[name="job_id"]').val(response.data.job_id);
			},

			showPaymentButton: function(paymentMethod, data){
				switch(paymentMethod){
					case 1:

						$('.on-delivery').show();
					break;
					case 2:
						$('.paypal-msg-failure').hide();
						$('#paypal').show();
						$('#paypal-button-container').show();
						if(!this.payPalInitialized){
							this.payPalInitialized = true;
							this.initPayPal();

						};
						
					break;
					case 3:
						var first_name = $(".bt-flabels__wrapper input#first_name").val();
						var last_name = $(".bt-flabels__wrapper input#last_name").val();
						var phone = $(".bt-flabels__wrapper input.phone").val();
						var email = $(".bt-flabels__wrapper input#email").val();
						var description = $(".bt-flabels__wrapper textarea#description").val();
						var form = $('<form method="post" id="woocommerce_paynow" action="?add-to-cart=' + data.product_id + '&dynamic_price=true">' +
						  '<input type="hidden" name="job_id" value="' + data.job_id + '" />' + 
						  '<input type="hidden" name="billing_first_name" value="' + first_name + '" />' + 
						  '<input type="hidden" name="billing_last_name" value="' + last_name + '" />' + 
						  '<input type="hidden" name="billing_phone" value="' + phone + '" />' + 
						  '<input type="hidden" name="billing_email" value="' + email + '" />' + 
						  '<input type="hidden" name="order_comments" value="' + description + '" />' + 
						  '<input type="hidden" name="autofill" value="true" />' + 
						  '</form>' );
						$('#woocommerce').append(form);
						debugger;
						$('#woocommerce_paynow').submit();
					break;
				}
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

			updateFormAction: function(formAction){
				$('form.tq-form input[name="action"]').val(formAction);
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