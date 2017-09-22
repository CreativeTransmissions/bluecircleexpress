;(function ( $, window, document, undefined ) {

		// Create the defaults once
		var pluginName = "transitQuotePremiumAdmin",
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
						case 'tq_pro_map_options':
							this.initMapTabEvents();
						break;	
						case 'tq_pro_customers':
							this.initCustomersTabUI();						
							this.initCustomersTabEvents();
							this.initEditTableEvents('customers');
						break;	
						case 'tq_pro_rates':				
							this.initRatesTabEvents();
							this.initEditTableEvents('rates');
						break;
						case 'tq_pro_services':
							this.initServiceTabUI();
							this.initServiceTabEvents();					
							this.initEditTableEvents('services');
						break;							
						case 'tq_pro_vehicles':
							this.initVehicleTabUI();
							this.initVehicleTabEvents();
							this.initEditTableEvents('vehicles');
						break;
						case 'tq_pro_paypal_transactions':
							this.initPayPayTransactionsTabUI();
							this.initPayPayTransactionsTabEvents();
						break;
						default:
							this.initJobsTabUI();
							this.initJobsTabEvents();
							this.initEditTableEvents('jobs');						
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
					$('.datepicker').datepicker('option', 'altFormat','yy-mm-dd' );
					$('.datepicker').datepicker('option', 'dateFormat','dd/mm/yy' );
					$('#from_date').datepicker('option', 'altField','#from_date_alt');
					$('#from_date').datepicker('setDate', d);
					$('#to_date').datepicker('option', 'altField','#to_date_alt');
					$('#to_date').datepicker('setDate', new Date());

				},

				initJobsTabEvents: function(){
					var that = this;

					this.editTable = $('#jobs_table')[0];

					//expand details row on click 
					$('#jobs_table').on('click', 'tr td', function(e){
						var tagName = e.target.tagName.toLowerCase();
						switch(tagName){
							case 'select':
							case 'option':
							break;
							default:
								var dataId = $(this).parent('tr').attr('data-id');
								if(dataId){
									that.clickRow('jobs_table',dataId);
								};
							break;
						};
					});

					$('#jobs_table').on('click', 'th', function(e){
						that.clickHeaderRow(this);
					});

					//refresh table on change date range
					$('#to_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'jobs'
						});
					});


					$('#from_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'jobs'
						});
					});

					$('.admin-form table').on('change', 'select.select-status_type_id',function(e) {
						e.preventDefault();
						e.stopPropagation();
						that.selectStatus(this);
						$.data(this, 'current', $(this).val());
					});

					//Filter the list when a checkbox is changed
					$('#filter_status_types_form').on('click', 'input[type=checkbox]', function(){
						that.saveFilters('filter_status_types_form');
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

				initCustomersTabEvents: function(){
					var that = this;
					//set form to read/populate
					this.editForm = $('#edit_customer_form')[0];
					this.editTable = $('#customers_table')[0];

					this.editRecordMessage = 'Editing Customer Details';
					this.newRecordMessage = 'Enter New Customer Details'

					//Clear / New Plaza
					$('#clear_customer').on('click', function(e){
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

				initJobsTabUI: function(){
					var that = this;
					this.initDatePicker();
					this.loadTable({
						from_date: $('#from_date_alt').val(),
						to_date: $('#to_date_alt').val(),
						table: 'jobs'
					});
							
				},

				initCustomersTabUI: function(){
					var that = this;

					this.loadTable({
						table: 'customers'
					});
							
				},

				initMapTabEvents: function(){
					console.log('initQuoteTabEvents');
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

					// set form status message
					this.editRecordMessage = 'Editing Rate';
					this.newRecordMessage = 'Enter New Rate'

					// store filter input references
					this.serviceFilter = $('#table-form select[name="service_id"]');
					this.vehicleFilter = $('#table-form select[name="vehicle_id"]');

					// store form select element references
					this.serviceSelectEl = $('select[name="service_id"]', this.editForm);
					this.vehicleSelectEl = $('select[name="vehicle_id"]', this.editForm);

					//default selected service type
					this.selectedServiceId = this.serviceSelectEl.find("option:first-child").val(); 
					this.selectedVehicleId = this.vehicleSelectEl.find("option:first-child").val(); 

					that.selectedServiceFilterId = this.selectedServiceId;
					that.selectedVehicleFilterId = this.selectedVehicleId

					// when service is selected, store it as a property
					$('select[name="service_id"]', this.editForm).on('change', function(){
						that.selectedServiceId = $(this).val();
						console.log('selectedServiceId: ' + that.selectedServiceId);
						that.setRatesTableFilters();
					});
				
					$('select[name="vehicle_id"]', this.editForm).on('change', function(){
						that.selectedVehicleId = $(this).val();
						console.log('selectedVehicleId: ' + that.selectedVehicleId);
						that.setRatesTableFilters();
					});

					$(this.serviceFilter).on('change', function(){
						that.selectedServiceFilterId = $(this).val();
						console.log('selectedServiceFilterId: ' + that.selectedServiceFilterId);
						
						that.loadTable({
							service_id: that.selectedServiceFilterId,
							vehicle_id: that.selectedVehicleFilterId,
							table: 'rates'
						});
					});

					$(this.vehicleFilter).on('change', function(){
						that.selectedVehicleFilterId = $(this).val();
						console.log('selectedServiceFilterId: ' + that.selectedVehicleFilterId);
						that.loadTable({
							service_id: that.selectedServiceFilterId,
							vehicle_id: that.selectedVehicleFilterId,
							table: 'rates'
						});
					});

					that.loadTable({
							service_id: that.selectedServiceFilterId,
							vehicle_id: that.selectedVehicleFilterId,
							table: 'rates'
						});

					//Clear / New Rate
					$('#clear_rate').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save rates
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});
					
				},

				initServiceTabUI: function(){

					var that = this;

					this.loadTable({
						table: 'services'
					});
							
				},

				initServiceTabEvents: function(){
					var that = this;

					//set form to read/populate
					this.editForm = $('#edit_service_form')[0];
					this.editTable = $('#service_table')[0];

					// set form status message
					this.editRecordMessage = 'Editing Service';
					this.newRecordMessage = 'Enter New Service'

					//Clear / New Service
					$('#clear_service').on('click', function(e){
						e.preventDefault();
						that.clearForm(this);
						that.updateLegend(that.editForm, that.newRecordMessage);
					});

					//Save Service
					$(this.editForm).on('submit',function(e) {
					    e.preventDefault();
					    that.spinner(true);
					    that.saveRecord(this);
					});					
				},

				
				initVehicleTabUI: function(){

					var that = this;

					this.loadTable({
						table: 'vehicles'
					});
							
				},
				
				initPayPayTransactionsTabUI: function(){
					var that = this;
					this.initDatePicker();
					this.loadTable({
						from_date: $('#from_date_alt').val(),
						to_date: $('#to_date_alt').val(),
						table: 'transactions_paypal'
					});
							
				},

				initPayPayTransactionsTabEvents: function(){
					var that = this;

					//expand details row on click 
					$('#transactions_paypal_table').on('click', 'tr', function(e){
						var dataId = $(this).attr('data-id');
						that.clickRow('transactions_paypal_table',dataId);
					});

					$('#transactions_paypal_table').on('click', 'th', function(e){
						that.clickHeaderRow(this);
					});

					//refresh table on change date range
					$('#to_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'transactions_paypal'
						});
					});


					$('#from_date').datepicker('option', 'onSelect', function(){

						that.loadTable({
							from_date: $('#from_date_alt').val(),
							to_date: $('#to_date_alt').val(),
							table: 'transactions_paypal'
						});
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

				clickHeaderRow: function(el){
					var orderby	= $(el).attr('data-sortby');
					var order 	= $(el).attr('data-order');

					$('input[name=orderby]').attr('value',orderby)
					$('input[name=order]').attr('value',order)

					$(el).siblings('th').children('.sorting').removeClass('asc').css("visibility","hidden");
					if(order =='ASC'){
						$(el).attr('data-order', "DESC");
						$(el).children('.sorting').addClass('desc').removeClass('asc').css("visibility","visible");
					}else{
						$(el).attr('data-order', "ASC");	
						$(el).children('.sorting').addClass('asc').removeClass('desc').css("visibility","visible");					
					};
					this.saveFilters('filter_status_types_form');
				},

				clickRow: function(table, dataId){
					if(!this.expandRow(table, dataId)){
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


				expandRow: function(table, dataId){
					//expand the hidden row in a table
					var that = this;

					//get the row for the data id
					var tableRow = this.getRow(table, dataId);
					if(!tableRow){
						return false;
					};

					//get the next row down - the expandable one
					var nextRow = $(tableRow).next();
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
						this.getTableDetails(table, dataId,  function(tableDetailsHtml){
							if(tableDetailsHtml){
								$(nextRow).html('<td colspan="100">'+tableDetailsHtml+'</td>');
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

				getTableDetails: function(tableName, rowId, callback){
					var that = this;
					if(!rowId){
						return false;
					};
					var data = {
					 	action: 'load_details',
					 	table_name: tableName,
					 	row_id: rowId
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
							 	action: 'tq_pro_load_table',
							 }, options );
					$.post(this.settings.ajaxUrl, data, function(response) {
						if(response.success){
							$('#'+tableName+' tbody').append(response.html);
						} else {
							that.updateProgress('error - see console');
							console.log(response);
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
					data += '&from_date='+$('#from_date_alt').val();
					data += '&to_date='+$('#to_date_alt').val();
					data += '&orderby='+$('input[name=orderby]').val();
					data += '&order='+$('input[name=order]').val();
					console.log(data)
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
					var rowId = $(row).attr('data-id');
					this.updateJobStatus({	job_id: rowId,
											status_type_id: value});
					return true;

				},

				setRatesTableFilters: function(){
					// after saving rates, synch table filters so we can see the changes
					console.log('this.selectedServiceId: '+ this.selectedServiceId);
					console.log('this.selectedVehicleId: '+ this.selectedVehicleId);
					this.serviceFilter.val(this.selectedServiceId);
					this.vehicleFilter.val(this.selectedVehicleId);
					this.selectedServiceFilterId = this.selectedServiceId;
					this.selectedVehicleFilterId = this.selectedVehicleId;
					this.loadTable({
						service_id: this.selectedServiceFilterId,
						vehicle_id: this.selectedVehicleFilterId,
						table: 'rates'
					});
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
							that.clearForm(that.editTable);
							that.updateLegend(that.editTable, that.newRecordMessage);
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
					 	from_date: $('#from_date_alt').val(),
						to_date: $('#to_date_alt').val(),
					 }, data);


					$.post(ajaxurl, data, function(response) {
						if(response.success=='true'){
							//refresh table
							$('tbody', that.editTable).empty();
							$('tbody', that.editTable).append(response.html);	
							//that.initStatusTypes();
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
							//that.initStatusTypes();
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