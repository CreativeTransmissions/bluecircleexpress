<?php settings_fields( 'vehicles' ); ?>
<?php do_settings_sections( 'vehicles' ); ?>
<form class="admin-form box-form round" id="edit_vehicle_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new vehicle by entering the details below:</legend>
		
		<div class="row row-vehicles">
			<div class="field">
				<label for="name">Vehicle</label>
				<input class="input-long" type="text" name="name" />
			</div>
			<div class="field">
				<label for="description">Description</label>
				<textarea name="description"></textarea>
			</div>
		</div>
	</fieldset>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="save_record"/>
	<input type="hidden" name="update" value="vehicles"/>
	<div class="inline-field">
		<?php submit_button('Save vehicle', 'primary', 'save_vehicle', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<?php submit_button('Clear Rate', 'primary', 'clear_vehicle', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="vehicles_table" class="settings-table">
		<thead>
			<tr><th>Vehicle</th><th>Description</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Vehicle?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This vehicle and the rates associated will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>