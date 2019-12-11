<?php settings_fields( 'tq_pro_rates' ); ?>
<?php do_settings_sections( 'tq_pro_rates' ); ?>
<?php 
	$weekend_col_cls = 'hidden';
	if($this->config['plugin']->get_use_weekend_rates()){
		$weekend_col_cls = '';
	};

	$holiday_col_cls = 'hidden';
	if($this->config['plugin']->get_use_holiday_rates()){
		$holiday_col_cls = '';
	};

	$out_of_hours_col_cls = 'hidden';
	if($this->config['plugin']->get_use_out_of_hours_rates()){
		$out_of_hours_col_cls = '';
	};		

	$dispatch_col_cls = 'hidden';
	if($this->config['plugin']->get_use_dispatch_rates()){
		$dispatch_col_cls = '';
	};

	$return_collection_col_cls = 'hidden';
	if($this->config['plugin']->get_use_return_to_collection_rates()){
		$return_collection_col_cls = '';
	};

	$return_base_col_cls = 'hidden';	
	if($this->config['plugin']->get_use_return_to_base_rates()){
		$return_base_col_cls = '';
	};		
?>
<p>The prices on each row apply to the parts of the journey up to the boundary distance. For example if you enter a boundary distance of 20 and a set price of £10, the first 20 miles will be charged adt £10.</p>
<p>Prices entered against a distance boundary of 0 will apply to all remaining miles after the highest distance boundary. For example if you have a boundary of 20 miles and a boundary of 0 miles, the first 20 miles will be charged with the 20 mile boundary rate and the remaining miles will be charged with the 0 boundary rate.</p> 
<p>You can charge with a different set of rates depending on journey length or the vehicle or service selected by the customer. When entering a rate, use the drop down boxes to select the options that will cause the rate to be used. For example if you select Maximum Distance = 50, Vehicle = Large Van, Service = Express, the rates will only apply to journeys of up to 50 miles when the customer has selected Large Van as the vehicle and Express as the service.</p>
<form class="box-form round tq-admin-form" id="edit_rate_form" method="post" autocomplete="false">
	
	<div class="row">
		<fieldset>
			<legend>Add a new rate by entering the details below:</legend>
			<div class="inline-field">
				<label for="group">Select Max Distance</label>
				<select name="journey_length_id" class="inline">
					<?php $this->admin->plugin->render_journey_length_options(); ?>
				</select>
			</div>
			<div class="inline-field">
				<label for="group">Select Service</label>
				<select name="service_id" class="inline">
					<?php $this->admin->plugin->render_service_options(); ?>
				</select>
			</div>
			<div class="inline-field">
				<label for="group">Select Vehicle</label>
				<select name="vehicle_id" class="inline">
					<?php $this->admin->plugin->render_vehicle_options(); ?>
				</select>
			</div>
		</fieldset>			
	</div>
	<div class="row row-rates">	
		<fieldset>
			<legend>Upper boundary distance for these rates:</legend>				
			<div class="inline-field">
				<label for="distance">Boundary Distance (<?php echo $this->admin->distance_unit; ?>s)</label>
				<input class="input-long" type="text" name="distance" />
			</div>
		</fieldset>
	</div>
	<div class="row row-rates">
		<fieldset>
			<legend>Standard Rates</legend>			
			<div class="inline-field">
				<label for="amount">Set Price</label>
				<input class="input-long" type="text" name="amount" />
			</div>
			<div class="inline-field">
				<label for="unit">Price Per <?php echo $this->admin->distance_unit; ?></label>
				<input class="input-long" type="text" name="unit" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour</label>
				<input class="input-long" type="text" name="hour" />
			</div>
		</fieldset>				
	</div>
	<div class="row row-rates <?php echo $holiday_col_cls; ?>">				
		<fieldset>
			<legend>Holiday Rates</legend>
			<div class="inline-field">
				<label for="hour">Set Price</label>
				<input class="input-long" type="text" name="amount_holiday" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> holiday</label>
				<input class="input-long" type="text" name="unit_holiday" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour holiday</label>
				<input class="input-long" type="text" name="hour_holiday" />
			</div>
		</fieldset>
	</div>
	<div class="row row-rates <?php echo $weekend_col_cls; ?>">				
		<fieldset>
			<legend>Weekend Rates</legend>
			<div class="inline-field">
				<label for="hour">Set Price Weekend</label>
				<input class="input-long" type="text" name="amount_weekend" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> weekend</label>
				<input class="input-long" type="text" name="unit_weekend" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour weekend</label>
				<input class="input-long" type="text" name="hour_weekend" />
			</div>
		</fieldset>
	</div>
	<div class="row row-rates <?php echo $out_of_hours_col_cls; ?>">		
		<fieldset>
			<legend>Out Of Hours Rates</legend>
			<div class="inline-field">
				<label for="hour">Set Price out of hours</label>
				<input class="input-long" type="text" name="amount_out_of_hours" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> out of hours</label>
				<input class="input-long" type="text" name="unit_out_of_hours" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour out of hours</label>
				<input class="input-long" type="text" name="hour_out_of_hours" />
			</div>	
		</fieldset>
	</div>

	<div class="row row-rates <?php echo $dispatch_col_cls; ?>">		
		<fieldset>
			<legend>Dispatch Rates (for journey from base/depo to first pickup)</legend>
			<div class="inline-field">
				<label for="hour">Set Price Dispatch</label>
				<input class="input-long" type="text" name="amount_dispatch" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> Dispatch</label>
				<input class="input-long" type="text" name="unit_dispatch" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour Dispatch</label>
				<input class="input-long" type="text" name="hour_dispatch" />
			</div>	
		</fieldset>
	</div>	
		
	<div class="row row-rates <?php echo $return_base_col_cls; ?>">		
		<fieldset>
			<legend>Return To Base Rates (for journey from final destination back to base/depo)</legend>
			<div class="inline-field">
				<label for="hour">Set Price Return To Base</label>
				<input class="input-long" type="text" name="amount_return_to_base" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> Return To Base</label>
				<input class="input-long" type="text" name="unit_return_to_base" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour Return To Base</label>
				<input class="input-long" type="text" name="hour_return_to_base" />
			</div>	
		</fieldset>
	</div>		
		
	<div class="row row-rates <?php echo $return_collection_col_cls; ?>">		
		<fieldset>
			<legend>Return To Collection Rates (for journey from final destination back to first collection address)</legend>
			<div class="inline-field">
				<label for="hour">Set Price Return To Collection</label>
				<input class="input-long" type="text" name="amount_return_to_pickup" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per <?php echo $this->admin->distance_unit; ?> Return To Collection</label>
				<input class="input-long" type="text" name="unit_return_to_pickup" />
			</div>
			<div class="inline-field">
				<label for="hour">Price Per Hour Return To Collection</label>
				<input class="input-long" type="text" name="hour_return_to_pickup" />
			</div>	
		</fieldset>
	</div>

	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro4_save_record"/>
	<input type="hidden" name="update" value="rates"/>
	<div class="inline-field">
		<?php submit_button('Save Rates', 'primary', 'save_rate', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<?php submit_button('Clear Form', 'primary', 'clear_rate', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<fieldset class="service-filters">
		<legend>Filter the rates below by service or vehicle</legend>
		<div class="inline-field">
			<label for="group">Select Max Distance</label>
			<select name="journey_length_id" class="inline">
				<?php $this->admin->plugin->render_journey_length_options(); ?>
			</select>
		</div>
		<div class="inline-field">
			<label for="group">Select Service</label>
			<select name="service_id" class="inline">
				<?php $this->admin->plugin->render_service_options(); ?>
			</select>
		</div>
		<div class="inline-field">
			<label for="group">Select Vehicle</label>
			<select name="vehicle_id" class="inline">
				<?php $this->admin->plugin->render_vehicle_options(); ?>
			</select>
		</div>
 	</fieldset>
	<table id="rates_table" class="settings-table">
		<thead>
			<tr><th>Boundary Distance</th>

			<th>Set Price</th>
			<th>Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th>Price Per Hour</th>
			
			<th class="amount_holiday <?php echo $holiday_col_cls; ?>">Holiday Set Price</th>
			<th class="unit_holiday <?php echo $holiday_col_cls; ?>">Holiday Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_holiday <?php echo $holiday_col_cls; ?>">Holiday Price Per Hour</th>

			<th class="amount_weekend <?php echo $weekend_col_cls; ?>">Weekend Set Price</th>
			<th class="unit_weekend <?php echo $weekend_col_cls; ?>">Weekend Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_weekend <?php echo $weekend_col_cls; ?>">Weekend Price Per Hour</th>

			<th class="amount_out_of_hours <?php echo $out_of_hours_col_cls; ?>">Out of Hours Set Price</th>
			<th class="unit_out_of_hours <?php echo $out_of_hours_col_cls; ?>">Out of Hours Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_out_of_hours <?php echo $out_of_hours_col_cls; ?>">Out of Hours Price Per Hour</th>

			<th class="amount_dispatch <?php echo $dispatch_col_cls; ?>">Dispatch Set Price</th>
			<th class="unit_dispatch <?php echo $dispatch_col_cls; ?>">Dispatch Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_dispatch <?php echo $dispatch_col_cls; ?>">Dispatch Price Per Hour</th>

			<th class="amount_return_to_base <?php echo $return_base_col_cls; ?>">Return To Base Set Price</th>
			<th class="unit_return_to_base <?php echo $return_base_col_cls; ?>">Return To Base Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_return_to_base <?php echo $return_base_col_cls; ?>">Return To Base Price Per Hour</th>

			<th class="amount_return_to_pickup <?php echo $return_collection_col_cls; ?>">Return To Collect Set Price</th>
			<th class="unit_return_to_pickup <?php echo $return_collection_col_cls; ?>">Return To Collect Price Per <?php echo $this->admin->distance_unit; ?></th>
			<th class="hour_return_to_pickup <?php echo $return_collection_col_cls; ?>">Return To Collect Price Per Hour</th>

			<th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Rates?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>The rates will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>