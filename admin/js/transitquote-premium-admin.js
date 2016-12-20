;(function ( $, window, document, undefined ) {

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
// Create the defaults once
		var pluginName = "wpSellSoftwareAdmin",
				defaults = {
				feedback_header_el: '.admin-form h2',
				feedback_msg_el: '.feedback'
		};

		// The actual plugin constructor
		function Plugin ( element, options ) {
				this.element = element;

				this.settings = $.extend( {}, defaults, options );
				this._defaults = defaults;
				this._name = pluginName;
				this.init();
		}

		// Avoid Plugin.prototype conflicts
		$.extend(Plugin.prototype, {
				init: function () {
					this.spinner(false);
					this.getTab();
					this.initTab();
					this.spinner(false);
				},

				initTab: function(){
					switch(this.tab){
						case 'ct_customers':
							this.initCustomersProductsTabUI('customer');						
							this.initCustomersProductsTabEvents('customer');
							this.initEditTableEvents('ct_customers');
						break;
						case 'ct_products':
							this.initCustomersProductsTabUI('product');						
							this.initCustomersProductsTabEvents('product');
							this.initEditTableEvents('ct_products');
						break;						
						case 'ct_sales':
							// this.initCustomersProductsTabUI('customers_product');	
							this.initSalesTabUI();
							this.initSalesTabEvents();
							// this.initEditTableEvents('jobs');
						break;
						default:
							this.initCustomersProductsTabUI('customer');						
							this.initCustomersProductsTabEvents('customer');
							this.initEditTableEvents('ct_customers');
						break;
					}
				},

				initDatePicker: function(){
					var that = this;
					/*
					if(this.settings.data.oldestJobDate){
						var oldestJobDate = new Date(this.settings.data.oldestJobDate);
					} else {
						var oldestJobDate =  new Date();
					};*/
					var d = new Date();
					d.setMonth( d.getMonth( ) - 1 );
					$('.datepicker').datepicker();
					$('.datepicker').datepicker('option','changeMonth', true);
					$('.datepicker').datepicker('option', 'altFormat','yy-mm-dd' );
					$('.datepicker').datepicker('option', 'dateFormat','dd/mm/yy' );					
					$('#from_date').datepicker('option', 'altField','#from_date_alt');
					$('#from_date').datepicker('setDate', d);
					$('#to_date').datepicker('option', 'altField','#to_date_alt');
					$('#to_date').datepicker('setDate', new Date());					
				},

				initSalesTabEvents: function(){
					var that = this;

					this.editTable = $('#ct_customers_products_table')[0];

					//expand details row on click 
					//we will not expand the sale for now
					// $('#ct_customers_products_table').on('click', 'tr', function(e){
					// 	var dataId = $(this).attr('data-id');
					// 	that.clickJobRow(dataId);
					// });

					//refresh table on change date range
					$('#to_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'ct_customers_products'
						});
					});


					$('#from_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'ct_customers_products'
						});
					});
				},

				initStatusTypes: function(){
					//Init selects to change job status types
					var selects = $('select.select-status_type_id');
					$('select.select-status_type_id').each(function(idx, el){
						$(el).data('current', $(el).val());
					});
				},

				initCourierTabEvents: function(){
					$('#courier-map').courierMap({
						ajaxUrl: ajaxurl
					});
				},

				initCustomersProductsTabEvents: function(entity){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_'+entity+'_form')[0];
					this.editTable = $('#ct_'+entity+'s_table')[0];

					this.editRecordMessage = 'Editing '+entity+' details';
					this.newRecordMessage = 'Enter new '+entity+' details'

					//Clear / New Plaza
					$('#clear_'+entity+'').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initSalesTabUI: function(){
					var that = this;
					this.initDatePicker();
					this.loadTable({
						from_date: $('#from_date_alt').val(),
						to_date: $('#to_date_alt').val(),
						table: 'ct_customers_products'
					});
							
				},

				initCustomersProductsTabUI: function(entity){
					var that = this;
					this.loadTable({
						table: 'ct_'+entity+'s'
					});
							
				},

				initQuoteTabEvents: function(){
					
					$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
					  if(e.keyCode == 13) {
					    e.preventDefault();
					    return false;
					  }
					});

					var settings = {
						geolocate: false,
						map: {
							// Google Map Options
							mapTypeId : google.maps.MapTypeId.ROADMAP, 
							scrollwheel : false,
							zoom: 2,
							startLat: 38.8763,
							startLng: 12.1852
						},

					};

					if((this.settings.data.startLat)&&(this.settings.data.startLng)){
						settings.map.startLat = this.settings.data.startLat;
						settings.map.startLng = this.settings.data.startLng;
						settings.map.zoom = 10;
					};
					
					if(this.settings.data.startPlaceName){
						settings.startPlaceName = this.settings.data.startPlaceName;
					};

					$('#place-selector').placeSelector(settings);
				},

				initRatesTabEvents: function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_rate_form')[0];
					this.editTable = $('#rates_table')[0];

					this.editRecordMessage = 'Editing Rate';
					this.newRecordMessage = 'Enter New Rate'

					//Clear / New Plaza
					$('#clear_rate').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initSurchargeTabEvents : function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_service_types_surcharges_form')[0];
					this.editTable = $('#service_types_surcharges_table')[0];

					this.editRecordMessage = 'Editing Surcharge';
					this.newRecordMessage = 'Enter New Surcharge'

					//Clear / New Plaza
					$('#clear_surcharge').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initStatusTypeTabEvents: function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_status_type_form')[0];
					this.editTable = $('#status_types_table')[0];

					this.editRecordMessage = 'Editing Status Type';
					this.newRecordMessage = 'Enter New Status Type'

					//Clear / New Plaza
					$('#clear_status_type').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initVehicleTabEvents: function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_vehicle_form')[0];
					this.editTable = $('#vehicles_table')[0];

					this.editRecordMessage = 'Editing Vehicle Details';
					this.newRecordMessage = 'Enter New Vehicle'

					//Clear / New Plaza
					$('#clear_vehicle').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initVehicleRatesTabEvents: function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_service_types_vehicle_types_form')[0];
					this.editTable = $('#service_types_vehicle_types_table')[0];

					this.editRecordMessage = 'Editing Vehicle Rate';
					this.newRecordMessage = 'Enter New Vehicle Rate'

					//Clear / New Plaza
					$('#clear_rate').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Plaza
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initEditTableEvents: function(table){
					var that = this;

					//Click Edit Button
					$('.admin-form table').on('click', 'button.edit-btn',function(e) {
						e.preventDefault();
						e.stopPropagation();
						that.editRecord(this);
					});

					//Click Delete Button
					$('.admin-form table').on('click', 'button.delete-btn',function(e) {
						e.preventDefault();
						e.stopPropagation();

						var btn = this;

						$( "#dialog-confirm" ).dialog({
							resizable: false,
							modal: true,
							buttons: {
								"Delete Request": function() {
									$( this ).dialog( "close" );
									
									//Get record id
									var dataId = $(btn).closest('td').attr('data-id');					 
									if(!dataId){
										return false;
									};

									that.hideRow(dataId);
									that.deleteRecord(btn, table);									
								},
								Cancel: function() {
									$( this ).dialog( "close" );
								}
							}
    					});

					});	
				},

				clearForm: function(el){
					//el can be the form or a button in it
					//get the form the button is within
					if($(el).prop('tagName')=='form'){
						var form = el;
					} else {
						var form = $(el).closest('form');					
					};

					//clear all fields
					$(form).find(':input').each(function() {
					    var type = this.type;
					    var tag = this.tagName.toLowerCase();
					    var name = this.name;

					    if(name != 'action' && name != 'update'){
						    if (type == 'text' || type == 'password' || tag == 'textarea'|| type == 'hidden')
						      this.value = '';
						    else if (type == 'checkbox' || type == 'radio')
						      this.checked = false;
						    else if (tag == 'select')
						      this.selectedIndex = 0;
						};
					});
				},

				clickJobRow: function(dataId){
					if(!this.expandRow(dataId)){
						return false;
					};
					return true;
				},

				clickMap: function(e){
					var that = this;
					this.mouseMode = this.calculator.getMouseMode();
					//console.log('clickMap:this.mouseMode: '+this.mouseMode);
					switch(that.mouseMode){
						case 'set_start':
							this.calculator.setJourneyStart(e.latLng);
						break;
						case 'set_dest':
							this.calculator.setJourneyDest(e.latLng);
						break;
						case 'add_marker':
							that.feedbackMessage({msg: 'Location selected. Drag the marker to refine  the location or choose the plaza name and save.'});

							this.marker = this.calculator.createMarker({center: e.latLng});
							this.marker.setDraggable(true);
							this.marker.setVisible(true);
							
							that.getMarkerPos(this.marker);

							google.maps.event.addListener(this.marker, 'dragend', function(e){
								that.getMarkerPos(that.marker);
							});
						break;
					};
					//set normal after each click
					this.calculator.setMouseMode('normal');
				},				

				createColors: function(total){
					//create color list for courier markers
					var i = 360 / (total - 1); // distribute the colors evenly on the hue range
					var r = []; // hold the generated colors
					for (var x=0; x<total; x++){
						r.push(hsvToRgb(i * x, 100, 100)); // you can also alternate the saturation and value for even more contrast between the colors
					}
					return r;
				},

				hideRow: function(dataId){
					//expand the hidden row in a table
					var that = this;

					//get the row for the data id
					var jobRow = this.getRow('jobs_table', dataId);
					if(!jobRow){
						return false;
					};

					//get the next row down - the expandable one
					var nextRow = $(jobRow).next();
					if(!nextRow){
						return false;
					};

					//do nothing if not an expandable row
					if(!$(nextRow).hasClass('expand')){
						return false;
					};

					if((nextRow).is(':visible')){
						//row is already displaying so hide it
						$(nextRow).hide();
						return true;
					}
				},


				expandRow: function(dataId){
					//expand the hidden row in a table
					var that = this;

					//get the row for the data id
					var saleRow = this.getRow('ct_customers_products_table', dataId);
					if(!saleRow){
						return false;
					};

					//get the next row down - the expandable one
					var nextRow = $(saleRow).next();
					if(!nextRow){
						return false;
					};

					//do nothing if not an expandable row
					if(!$(nextRow).hasClass('expand')){
						return false;
					};

					if((nextRow).is(':visible')){
						//row is already displaying so hide it
						$(nextRow).hide();
						return false;
					} else {
						//row is hidden so display a loading message and show the row
						$(nextRow).html('<td colspan="100" class="job-loading">Loading details...</td>');
						$(nextRow).show();	

						//then load the job details view and inject it into the table 
						this.getJobDetails(dataId,  function(jobDetailsHtml){
							if(jobDetailsHtml){
								$(nextRow).html('<td colspan="100">'+jobDetailsHtml+'</td>');
								$('#jobs_table').trigger('jobdetailscomplete');
							} else {
								$(nextRow).html('<td colspan="100">Could not load details.</td>');
							}
															
						});
						return true;
					}
				},

				getMarkerPos: function(marker){
					var pos = marker.getPosition();
					var lat = pos.lat();
					var lng = pos.lng();	
					$('#location_details #lat').val(lat);
					$('#location_details #lng').val(lng);
					return pos;
				},

				clearTable: function(table){
					if(!table){
						console.log('no table name supplied');
						return false;
					};
					var tableName = table+'_table';
					$('#'+tableName+' tbody').empty();
				},

				configureForms: function(form){
					switch(form){
						case 'add_location':
							$('#location_details').show();
							$('#route_details').hide();
							this.feedbackMessage({header: 'Add New Location',
													msg:'Click on the map to add a new location and assign it to an existing toll plaza.<br/>Create the new plaza first on the Plazas tab.'});
							this.calculator.setMouseMode('add_marker');
						break;
						case 'test_route':
							$('#location_details').hide();
							$('#route_details').show();
							this.feedbackMessage({header: 'Test Routes',
													msg:'Check that Plazas are detected for specific routes.<br/>Click on a plaza icon to adjust or duplicate the location if it is not detected.'});
							this.calculator.setMouseMode('normal');
						break;						
					}
				},

				deleteRecord: function(btn, tableName){
					var that = this;
					//Get record id
					var recId = $(btn).closest('td').attr('data-id');					 
					if(!recId){
						return false;
					};
					this.spinner(true);

					var data = {
						action: 'delete_record',
						update: tableName,
						id: recId
					};

					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){
							//remove the record
							$('tr[data-id="'+recId+'"]', that.editTable).remove();
						} else {
							$('<div/>').html('Unable to delete record.').dialog();
						};
						that.spinner(false);
					},'json');
				},

				editRecord: function(btn){
					//Get record id
					var recId = $(btn).closest('td').attr('data-id');

					//Set id field for save
					var formEl = $('input[name="id"]', this.editForm);
					if(formEl.length==0){
						console.log('no id field for form.');
						return false;
					};
					$(formEl).val(recId);
					
					//update editing status
				    var legend = $(this.editForm).find('legend');
		 			$(legend).html(this.editRecordMessage);

					this.populateForm(recId, this.editForm, btn);
				},

				feedbackMessage: function(feedback){
					if(feedback.header){
						$(this.settings.feedback_header_el).html(feedback.header);
					};
					if(feedback.msg){
						$(this.settings.feedback_msg_el).html(feedback.msg);
					};
					if(feedback.spinner){
						this.spinner(true);
					} else {
						this.spinner(false);						
					}

				},

				getJobDetails: function(jobId, callback){
					var that = this;

					if(!jobId){
						return false;
					};
					var data = {
					 	action: 'load_job_details',
					 	job_id: jobId
					};

					//load the html view from the server to include in the job hidden row
					$.post(this.settings.ajaxUrl, data, function(responseHtml) {
						if(responseHtml){
							if(callback){
								callback(responseHtml);
							};		
						} else {
							if(callback){
								callback(false);
							};
						};

					}, 'html');		
				},

				getParameterByName: function (name) {
				    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				        results = regex.exec(location.search);
				    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
				},

				getRow: function(tableId, rowId){
					//return a reference to the html tr element identified by the data-id attribute
					var row = $('#'+tableId+' tr[data-id="' + rowId + '"]');
					if(row.length==0){
						return false;
					};	
					return row;				
				},

				getTab: function(){
					this.tab = this.getParameterByName('tab');
				},

				loadRecord: function(options, cb){
					if(!options.table){
						return false;
					};

					if(!options.id){
						return false;
					};

					var data = $.extend({
							 	action: 'load_record',
							 }, options );

					$.post(this.settings.ajaxUrl, data, function(response) {
						if(response.success){
							if(cb){
								cb(response.data);
							};
						} else {
							that.updateProgress('error - see console');
							console.log(response);
						}
					}, 'json');
				},

				loadTable: function(options){
					
					var that = this;
					
					if(!options.table){
						return false;
					};

					var tableName = options.table+'_table';					
					this.spinner(true);

					$('#'+tableName+' tbody').empty();

					var data = $.extend({
							 	action: 'ct_load_table',
							 }, options );
					
					$.post(this.settings.ajaxUrl, data, function(response) {
						if(response.success){
							$('#'+tableName+' tbody').append(response.html);
						} else {
							that.updateProgress('error - see console');
						};
						that.spinner(false);
						if(options.callback){
							options.callback(response);
						}
					}, 'json');					
				},

				populateForm: function(recId, form, btn){
					var that = this;
					this.tableData = [];
					var rec = [];
		 			//Get record data from table
					var cells = $(btn).closest('tr').find('td');

					//loop through table cells to get data
					$(cells).each(function(idx, td){
						var fieldName = $(td).attr('data-id');
						var value = $(td).attr('data-value');

						var field = {
							name: fieldName,
							value: value
						};

						//populate form
						that.populateField(field,form);

						//store data for later reference
						rec[fieldName] = field;

					});
					//add record to table data array
					this.tableData[recId] = rec;

				},

				populateField: function(field, form){
					//populate a form field with a value
					var value = field.value;
					var name = field.name;

					var selector = '[name="'+field.name+'"]';
					var formEl = $(selector, form);

					//remove disabled element but leave readonly permanatly 
					if(name!='exit_plaza_id'){ // an exception
						$(formEl).removeAttr('disabled');		
					}

					$(formEl).val(value);

				},
				
				refreshSelectOptions: function(table, select, cb){
					//first param can refer to html el id and table if the same
					if(!select){
						var select = table;
					};
					var s = $('#'+select);
					if(s.length===0){
						return false;
					};
					$(s).prop('disabled', true);

					var data = {
						action: 'select_options',
						select: table
					};

					$.post(this.settings.ajaxUrl, data, function(response) {
						if(response.success){
							$(s).empty();
							$(s).append(response.html);
							$(s).removeAttr('disabled');
							if(cb){
								cb(response.html);
							}
						} else {
							that.updateProgress('error - see console');
							console.log(response);
						}
					}, 'json');
				},

				saveFilters: function(form){
					var that = this;
					this.spinner(true);
					var data = $('#'+form).serialize();
					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){						
							//refresh table
							$('tbody', that.editTable).empty();
							$('tbody', that.editTable).append(response.html);
						} else {
							var msg = response.msg;
							that.feedbackMessage({
								msg: msg
							})							
						};
						that.spinner(false);
					}, 'json');
				},

				selectCourier: function(select){
					var value = $(select).val();
					var row = $(select).closest('tr');
					var rowId = $(row).attr('data-id');
					this.updateCourier({job_id: rowId,
										courier_id: value});
				},

				selectStatus: function(select){
					var value = $(select).val();
					var row = $(select).closest('tr');
					var courierId = $(row).find('select[name="courier_id"]').val()
					if((value == '2')&&(parseInt(courierId)==0)){
						//cant change to assigned

						$(select).val($.data(select, 'current')); 
						return false;
					};
					var row = $(select).closest('tr');
					var rowId = $(row).attr('data-id');
					this.updateJobStatus({	job_id: rowId,
											status_type_id: value});
					return true;

				},

				saveRecord: function(form){
					var that = this;
					this.spinner(true);
					var data = $(form).serialize();
					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){
							//display message
							var msg = 'Saved Successfully.';

							//clear the form
							that.clearForm(that.editForm);
							that.updateLegend(that.editForm, that.newRecordMessage);
							if(response.id){
								//update row
								if(that.editTable){
									var row = $(that.editTable).find('tr[data-id="'+response.id+'"]');
									$(row).replaceWith(response.html);								
								}

							} else {
								if(response.html){
									//refresh table
									$('tbody', that.editTable).empty();
									$('tbody', that.editTable).append(response.html);		
								}						
							};
							that.spinner(false);
						} else {
							var msg = response.msg;
						};

						that.feedbackMessage({
							msg: msg
						})

					}, 'json');
				},

				spinner: function(status, ctr){
					if(ctr){
						ctr = '#'+ctr;
					} else {
						var ctr = '#wpbody-content';
					};
					if(status){
						$('.spinner', ctr).show();
					} else {
						$('.spinner', ctr).hide();
					}
				},

				updateJobStatus: function(data){
					var that = this;
					this.spinner(true);

					var data = $.extend({
					 	action: 'update_job_status',
					 }, data);


					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){
							//refresh table
							$('tbody', that.editTable).empty();
							$('tbody', that.editTable).append(response.html);	
							that.initStatusTypes();
						} else {
							that.feedbackMessage({header:'Unable to update job status.'});
						};
						that.spinner(false);
					},'json');					
				},

				updateCourier: function(data){
					var that = this;
					this.spinner(true);

					var data = $.extend({
					 	action: 'update_courier',
					 }, data);


					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){
							//refresh table
							$('tbody', that.editTable).empty();
							$('tbody', that.editTable).append(response.html);	
							that.initStatusTypes();
						} else {
							that.feedbackMessage({header:'Unable to update courier.'});
						};
						that.spinner(false);
					},'json');					
				},

				updateLegend: function(form, message){
					$(form).find('legend').html(message);
				}


		});

		// A really lightweight plugin wrapper around the constructor,
		// preventing against multiple instantiations
		$.fn[ pluginName ] = function ( options ) {
				this.each(function() {
						if ( !$.data( this, "plugin_" + pluginName ) ) {
								$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
						}
				});

				// chain jQuery functions
				return this;
		};
})( jQuery, window, document );