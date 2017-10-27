<?php settings_fields( 'tq_pro_rates' ); ?>
<?php do_settings_sections( 'tq_pro_rates' ); ?>
<form class="box-form round tq-admin-form" id="edit_rate_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new rate by entering the details below:</legend>
		<div class="row">
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
		</div>
		<div class="row row-rates">
			<div class="inline-field">
				<label for="distance">Max Distance (<?php echo $this->admin->distance_unit; ?>s)</label>
				<input class="input-long" type="text" name="distance" />
			</div>
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
		</div>
	</fieldset>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro3_save_record"/>
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
			<tr><th>Max Distance</th><th>Set Price</th><th>Price Per <?php echo $this->admin->distance_unit; ?></th><th>Price Per Hour</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Rates?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>The rates will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>