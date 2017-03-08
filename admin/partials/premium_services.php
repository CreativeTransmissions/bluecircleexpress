<?php settings_fields( 'services' ); ?>
<?php do_settings_sections( 'services' ); ?>
<form class="admin-form box-form round" id="edit_service_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new service by entering the details below:</legend>
		
		<div class="row row-services">
			<div class="field">
				<label for="name">Service</label>
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
	<input type="hidden" name="update" value="services"/>
	<div class="inline-field">
		<?php submit_button('Save service', 'primary', 'save_service', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<?php submit_button('Clear Rate', 'primary', 'clear_service', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="services_table" class="settings-table">
		<thead>
			<tr><th>Service</th><th>Description</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Service?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This service and the rates associated will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>