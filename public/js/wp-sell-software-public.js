/*	Google Maps Quote Calculatior Order Form
*	jQuery Plugin from Creative Transmissions 
*	http://www.creativetransmissions.com/google-maps-quote-calculator-plugin
*	Author: Andrew van Duivenbode
* 	Liscence: MIT Liscence - See liscence.txt
*/


;(function ( $, window, document, undefined ) {
		// Create the defaults 
		var pluginName = "wpSellSoftwareCustomer",
		
		defaults = {
			ajaxUrl: '',
			vendorId: '',
			debug: false,
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
					// if(!this.initUI()){
					// 	return false
					// };
					if(!this.initEvents()){
						return false
					};
				},

				// initUI: function () {					
				// 	$('.notice-field').hide();
				// 	return true;				
				// },

				initEvents: function(){
					var that = this;
				    $('.paddle_button').on('click', function(e){
						var paddle_product 	= $(this).attr('data-product');
						var email 			= $(this).attr('data-email');
						var passthrough 	= $(this).attr('data-passthrough');
						var localproduct 	= $(this).attr('data-localproduct');					
						if(passthrough == '' || email=='' || paddle_product =='' || localproduct==''){
							return false;
						}
						Paddle.Setup({
							vendor: parseInt(that.settings.data.vendorId),
							debug: true
						});
						Paddle.Checkout.open({
							product: paddle_product,
							email: email,
							passthrough: passthrough,
							allowQuantity: false,
							successCallback: function(data) {
								console.log('successfully purchased.');
								var data = {
								 	action: 'save_sale',
								 	customer_id: data.checkout.passthrough,
								 	product_id: localproduct, //local id								 	
								};
								$.ajax({
								  type: 'POST',
								  url: that.settings.data.ajaxUrl,
								  data: data,
								  async:false,
								  dataType: 'json',
								  success: function(response){		
								  	$('.progress, .success, failure').hide();						  	
								  	if(response.success==='true'){
										console.log(response);
										console.log('successfully save in DB');
										$('.success').html('<h2>Success!</h2><p>Thanks for purchasing the product. You will get an email with an attachment!</p>').show();										
									}								
								  }
								});								
							},
							closeCallback: function(data) {
								$('.progress, .success').hide();
								console.log(data);
								$('.failure').show();	
							}

						});
					});
					
					
					$('input,select').keypress(function(event) { return event.keyCode != 13; });
					$(this.element).on('submit', function (e) {
						e.preventDefault;
					});
					$(this.element).on('click','input:submit', function(e){
						e.preventDefault();
						if($(that.element).parsley().validate()){
							that.submitForm()
						};						
					});
					// remove validation from hidden fields
					$.listen('parsley:field:error', function(parsleyField) {
						if (parsleyField.$element.is(":hidden")) {
					        parsleyField._ui.$errorsWrapper.css('display', 'none');
					       	parsleyField.validationResult = true;
					        return true;
				    	}
					});
				
				},

				submitForm: function(invalid, idealForm, e){
				
					var that = this;				
					$('.progress, .success, .failure').hide();
					this.updateProgressMessage('Please wait a moment...');
					$('.tq-address-container').css('background','#dddddd');
					$('.buttons').hide();
					$('.spinner-div').show();
					$('.spinner-div').css({
					    height: $('#quote-form').height(), 
					    width: $('#quote-form').width()
					});	
					var data = $(this.element).serialize();
					$.post(this.settings.data.ajaxUrl, data, function(response) {	
						if(response.success==='true'){
							$('.paddle_button').attr('data-passthrough', response.data.customer.id).attr('data-email', response.data.customer.email);
							$('.failure, .progress, .spinner-div').hide();
							$('.success').show();
							$('#quote-form')[0].reset();
							$('#quote-form').hide();
						} else {
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