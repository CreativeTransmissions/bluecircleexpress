<?php settings_fields( 'rates' ); ?>
<?php do_settings_sections( 'rates' ); ?>
<form class="admin-form box-form round" id="edit_rate_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new rate by entering the details below:</legend>
		<div class="inline-field">
			<label for="group">Max Distance (<?php echo $this->distance_unit; ?>s)</label>
			<input class="input-long" type="text" name="distance" />
		</div>
		<div class="inline-field">
			<label for="group">Set Price</label>
			<input class="input-long" type="text" name="amount" />
		</div>
		<div class="inline-field">
			<label for="group">Price Per <?php echo $this->distance_unit; ?></label>
			<input class="input-long" type="text" name="unit" />
		</div>
		<div class="inline-field">
			<label for="group">Price Per Hour</label>
			<input class="input-long" type="text" name="hour" />
		</div>
	</fieldset>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="service_type_id" value="1"/>
	<input type="hidden" name="action" value="save_record"/>
	<input type="hidden" name="update" value="rates"/>
	<div class="inline-field">
		<?php submit_button('Save Rates', 'primary', 'save_rate', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<?php submit_button('Clear Rate', 'primary', 'clear_rate', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="rates_table" class="settings-table">
		<thead>
			<tr><th>Max Distance</th><th>Set Price</th><th>Price Per <?php echo $this->distance_unit; ?></th><th>Price Per Hour</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		<?php
			$rates_data = $this->plugin->get_rates_list();
			//$this->plugin->debug($rates_data);
			echo $this->dbui->table_rows(array(
						'data'=>$rates_data,
						'table'=>'rates',
						'fields'=>array('id', 'distance','amount','unit','hour'),
						'inputs'=>false,
						'actions'=>array('Edit','Delete')
			));
		?>	
		</tbody>
	</table>
</form>
