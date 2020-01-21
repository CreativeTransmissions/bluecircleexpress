(function ( $ ) {

	$.fn.ThemeFunctions = function ThemeFunctions(options) {

		if(!options){
			options = {};
		};

		var defaults = {
		
		};

		this.settings = $.extend({}, defaults, options);
		this.public = this.settings.public;
		this.element = this.settings.public.element; // the form element
		this.init();

	};

	$.fn.ThemeFunctions.prototype = {

		log: function(data){
			this.public.log(data);
		},

		init: function(){
			console.log('initializing theme');
			this.initThemeEvents();
		},

		initThemeEvents: function(){

			this.initThemeFormComponents();
			this.addEventHandlerChangeVisitType();
			this.addEventHandlerChangeTimeType();
		},

		initThemeFormComponents: function(){

			var firstCollectionAddressTimePickerSelector = 'input[name="address_0_collection_time"]';
			var elExists = $(firstCollectionAddressTimePickerSelector);
			if(elExists.length>0){
				this.initNewTimePicker(firstCollectionAddressTimePickerSelector);									
			};

			var firstCollectionAddressDatePickerSelector = 'input[name="address_0_collection_date"]';
			var elExists = $(firstCollectionAddressTimePickerSelector);
			if(elExists.length>0){
				this.initNewDatePicker(firstCollectionAddressDatePickerSelector);	
			};

			var deliveryDateSelector = 'input[name="delivery_date"]';
			var elExists = $(deliveryDateSelector);
			if(elExists.length>0){
				this.initNewDatePicker(deliveryDateSelector);			
			};

			var deliveryTimePickerSelector = 'input[name="delivery_time"]';
			var elExists = $(deliveryTimePickerSelector);
			if(elExists.length>0){
				this.initNewTimePicker(deliveryTimePickerSelector);
			};
		},

		initNewDatePicker: function(selector){
				var that = this;
				var interval = TransitQuoteProSettings.time_interval;
				var dateRangeToDisable = this.public.getInitialDateRangeToDisable();
        		var nextAvailableBookingDate = this.public.getNextAvailableBookingDate();

				var $inputDate = $(selector).pickadate({						
					disable : dateRangeToDisable,
					formatSubmit: 'dd-mm-yyyy',
		            hiddenName: true,
		            min: nextAvailableBookingDate,
		            onSet: function(context) {
		            	that.public.onSetDatepickerDate(this,context);
				  	},
				  	onClose: function() {
					    $('.timepicker').blur();
					    $('.datepicker').blur();
					    $('.picker').blur();
					}
		        });				
				
		        var datePickerObj = $inputDate.pickadate('picker');

    			var date = new Date();
    				datePickerObj.set('select', date);
			},		

			addEventHandlerChangeVisitType: function(){
				var that = this;
				$(this.element).on('change','select.visit_type', function(e){

					$(this).removeAttr('selected');
					var val = $(this).val();
					that.callbackChangeVisitType(this,val);
				});
				console.log('addEventHandlerChangeVisitType: ok');
			},

			callbackChangeVisitType: function(el, val){
				var addressIdx = el.name.split('_')[1];
				var addressWrap = $(el).closest('.address-wrap');

				this.updateAddressLabelsForLocationType(addressWrap, val);
				
			},

			updateAddressLabelsForLocationType: function(ctr, locationType){
				var subTitleEl = $(ctr).prevAll('span.sub_title:first');
				var iconEl = $('i',subTitleEl);
				var subTitleTextEl = $('span.address-type-subtitle',subTitleEl);
				var optionTextEls = $('select option.address-type-subtitle',ctr);
				var timeSubTitleEl = $('span.address-type-subtitle',ctr);
				var searchEl = $('input.addresspicker',ctr);

				switch(locationType){
					case 'Collection':
						$(iconEl).switchClass('icon-icn-destination-address', 'icon-icn-collection-address');
					break;
					case 'Delivery':
						$(iconEl).switchClass('icon-icn-collection-address', 'icon-icn-destination-address');
					break;
					case 'Collection and Delivery':
						$(iconEl).switchClass('icon-icn-collection-address', 'icon-icn-destination-address');						
					break;					
				};
				$(subTitleTextEl).html(locationType);
				$(subTitleTextEl).html(locationType);
				$(timeSubTitleEl).html(locationType);
				$(searchEl).attr('placeholder', locationType + ' Address');
				$(optionTextEls[0]).html(locationType+' At');
				$(optionTextEls[1]).html(locationType+' By');				


			},

			addEventHandlerChangeTimeType: function(){
				var that = this;
				$(this.element).on('change','select.time_type', function(e){
					that.log('change: time_type');
					var val = $(this).val();
					that.callbackChangeTimeType(this,val);
				});

				console.log('addEventHandlerChangeTimeType: ok');

			},

			callbackChangeTimeType: function(el, val){
				var addressIdx = el.name.split('_')[1];
				var addressWrap = $(el).closest('.address-wrap');
				switch(val){
					case 'ASAP':
						this.hideDateTimeFieldsInContainer(addressWrap);
						this.resetDateTimeFieldsInContainer();
					break;
					default:
						this.showDateTimeFieldsInContainer(addressWrap);
					break;
				};

				if(this.public.validateGetQuote()){
					this.public.updateFormAction('tq_pro4_get_quote');
					this.public.submitForm('get_quote');
				};
			},

			hideDateTimeFieldsInContainer: function(ctr){
				$('.optional-date-time', ctr).hide();
				$('.optional-date-time', ctr).hide();
			},

			resetDateTimeFieldsInContainer: function(ctr){
				var row = $('.optional-date-time', ctr);
				var datepickerInput = $('.datepicker', row);
				var datePicker = $(datepickerInput[0]).pickadate('picker');
    			var date = new Date();
    			datePicker.set('select', date);		

				var timepickerInput = $('.timepicker', row);
				var timePicker = $(timepickerInput[0]).pickatime('picker');
    			var date = new Date();
    			timePicker.set('select', date);		

			},

			showDateTimeFieldsInContainer: function(ctr){
				$('.optional-date-time', ctr).show();
				$('.optional-date-time', ctr).show();
			},			

		
			initNewTimePicker: function(selector){
				var that = this;

				if(this.public.settings.data.use_out_of_hours_rates === 'true'){
					var timePickerConfig = this.getTimePickerConfigUsingOutOfHours();
				} else {
					var timePickerConfig = this.getTimePickerConfigNoBookingsOutOfHours();
				};
				
				var timpickerInput = $(selector).pickatime(timePickerConfig);

				var picker = timpickerInput.pickatime('picker');
				$(selector).on('click', function(){
					picker.open();
				});


    			var date = new Date();
    				picker.set('select', date);				
			},				

			getTimePickerConfigUsingOutOfHours: function(){
				var that = this;
				
				var config = {
						interval: parseInt(TransitQuoteProSettings.time_interval),
						editable:true,
						formatSubmit: 'HH:i',
						onSet: function(context) {
							that.onSetTimePicker(context);

					  	},
					  	onClose: function() {
						    $('.timepicker').blur();
						    $('.datepicker').blur();
						    $('.picker').blur();
						}
				};

				return config;
			},

			getTimePickerConfigNoBookingsOutOfHours: function(){
				var that = this;

				var booking_start_time_datetime = this.public.dateTimeConverter(TransitQuoteProSettings.booking_start_time+'000')['time'];
				var booking_end_time_datetime = this.public.dateTimeConverter(TransitQuoteProSettings.booking_end_time+'000')['time'];

				var config = {
						min: booking_start_time_datetime,
						max: booking_end_time_datetime,
						interval: parseInt(TransitQuoteProSettings.time_interval),
						editable:true,
						formatSubmit: 'HH:i',
						onSet: function(context) {
							that.public.onSetTimePicker(context);

					  	},
					  	onClose: function() {
						    $('.timepicker').blur();
						    $('.datepicker').blur();
						    $('.picker').blur();
						}
				};

				return config;

			},

			afterInsertAddress: function(templateData){
				var timepickerSelector = 'input[name="address_'+templateData.idx+'_collection_time"]';
				var elExists = $(timepickerSelector);
				if(elExists.length>0){						
					this.initNewTimePicker(timepickerSelector);
				};

				var datepickerSelector = 'input[name="address_'+templateData.idx+'_collection_date"]';
				var elExists = $(datepickerSelector);
				if(elExists.length>0){							
					this.initNewDatePicker(datepickerSelector);
				};			
			},

			getCalcConfig: function(){
				return {
					addressPickerTemplate: function(data){
						if(!data.idx){
							return false;
						};
						
						var idx = data.idx;

                        	var html = '<span class="sub_title tq-primary-color">';
                        		html += '	<i class="icon icon-icn-destination-address"></i>';
                        		html += '	<span class="address-type-subtitle">'+TransitQuoteProSettings.destination_address_label+'</span></span>';
                        		html += '	<a href="#" class="remove-address no-address-'+idx+'">'+TransitQuoteProSettings.remove_dest_link_text+'</a>';
	                    	    html += '<div class="address-wrap"><div class="tq-row">';
	                    		html += '	<div class="half left">';
	                         	html += '		<span class="sub_title">Purpose of visit</span>';
	                         	html += '		<div class="bt-flabels__wrapper select-wrap">';
	                            html += '			<select class="visit_type" name="address_'+idx+'_visit_type" id="address_'+idx+'_visit_type">';
	                            html += '				<option>Collection</option>';
	                            html += '				<option selected="selected">Delivery</option>';
	                            html += '				<option>Collection and Delivery</option>';
	                            html += '			</select>';
	                         	html += '		</div>';
	                     		html += '	</div>';
			                    html += '	<div class="half right">';
			                    html += '		<span class="sub_title"><span class="address-type-subtitle">Delivery</span> Time</span>';
			                    html += '		<div class="bt-flabels__wrapper select-wrap">';
			                    html += '   		<select class="time_type" name="address_'+idx+'_time_type" id="address_'+idx+'_time_type">';
			                    html += '       		<option>ASAP</option>';
			                    html += '       		<option class="address-type-subtitle">Delivery At</option>';
			                    html += '       		<option class="address-type-subtitle">Delivery By</option>';
			                    html += '   		</select>';
			                    html += '		</div>';
			                    html += '	</div>';              
			                    html += '</div>';						
								html += '<div class="tq-row optional-date-time" style="display: none;">';

								html += '<div class="coll_date_wrap bt-flabels__wrapper">';
			                    html += '	<input name="address_' + idx + '_collection_date" id="address_' + idx + '_collection_date" data-parsley-trigger="select change" required readonly="" class="left collection_date dateclass placeholderclass datepicker" type="text" placeholder="Collection Date">';
			                    html += '	<span class="bt-flabels__error-desc">Required / Invalid </span>';
			                    html += '</div>';
								html += '	<div class="coll_time_wrap bt-flabels__wrapper">';
			                    html += '        <input name="address_' + idx + '_collection_time" class="right collection_time dateclass placeholderclass timepicker" readonly="" type="text" data-parsley-trigger="select change" placeholder="Collection Time" id="address_' + idx + '_collection_time" required>';
			                    html += '        <span class="bt-flabels__error-desc">Required / Invalid </span>';
			                    html += '   </div>';
	                    		html += '	</div>';

							html += '	<div class="field bt-flabels__wrapper full-width full">';
                        	html += '		<span class="transit_noadress"><a href="#" class="no-address no-address-'+idx+'">'+TransitQuoteProSettings.cant_find_address_text+'</a></span>';
                        	html += '		<input class="text addresspicker" required type="text" name="address_'+idx+'_address" id="address_'+idx+'" value="" autocomplete="false" placeholder="'+TransitQuoteProSettings.destination_address_label+'"/>';
                        	html += '		<span class="bt-flabels__error-desc">Required '+TransitQuoteProSettings.destination_address_label+'</span>';
							html += '	</div>';
							if(TransitQuoteProSettings.ask_for_unit_no === 'true'){
	                    		html += '	<div class="inline-block bt-flabels__wrapper half left">';
	                        	html += '		<input class="inline-block half-field" type="text" id="address_'+idx+'_appartment_no" name="address_'+idx+'_appartment_no" placeholder="'+data.unitNoLabel+'" value=""/>';
								html += '	</div>';
							};
							if(TransitQuoteProSettings.ask_for_postcode === 'true'){
	                    		html += '	<div class="inline-block bt-flabels__wrapper half right last-address-field">';
	                        	html += '		<input class="inline-block postcode half-field half-field-right" type="text" id="address_'+idx+'_postal_code" name="address_'+idx+'_postal_code" placeholder="'+TransitQuoteProSettings.postal_code_label+'" value=""/>';
	                    		html += '	</div>';
	                    	};
							if(TransitQuoteProSettings.show_contact_name === 'true'){
	                    		html += '	<div class="inline-block bt-flabels__wrapper half left last-address-field">';
	                        	html += '		<input class="inline-block half-field" id="address_'+idx+'_contact_name" type="text" name="address_'+idx+'_contact_name" placeholder="'+TransitQuoteProSettings.contact_name_label+'" value=""/>';
	                    		html += '	</div>';
	                    	};
							if(TransitQuoteProSettings.show_contact_number === 'true'){
	                    		html += '	<div class="inline-block bt-flabels__wrapper half right last-address-field">';
	                        	html += '		<input class="inline-block postcode half-field half-field-right" type="text" id="address_'+idx+'_contact_phone" name="address_'+idx+'_contact_phone" placeholder="'+TransitQuoteProSettings.contact_phone_label+'" value=""/>';
	                    		html += '	</div>';
	                    	};

	                    	    
	                    		html += '</div>';

						return html;
					}

				}
			}

		
	};

}(jQuery));	