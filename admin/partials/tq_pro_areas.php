<?php settings_fields( 'areas' ); ?>
<?php do_settings_sections( 'areas' ); ?>
<form class="admin-form tq-admin-form box-form round" id="edit_area_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new area by entering the details below:</legend>
		
		<div class="row row-areas">
			<div class="inline-field">
				<label for="name">Zone Name</label>
				<input class="input-long" type="text" name="name" />
			</div>
			<div class="inline-field">
				<label for="group">Select Surcharge</label>
				<select name="surcharge_id" class="inline">
					<?php $this->admin->plugin->render_surcharge_options(); ?>
				</select>
			</div>
			<div id="area-selector"></div>
			<input type="hidden" name="definition"/>
		</div>
	</fieldset>

	<div class="buttons">
		<div class="inline-field">
			<?php submit_button('Save area', 'primary', 'save_area', true, array('class'=>'submit')); ?>
		</div>
		<div class="inline-field">
			<?php submit_button('Clear Form', 'primary', 'clear_area', true, array('class'=>'submit')); ?>
		</div>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro4_save_record"/>
	<input type="hidden" name="update" value="areas"/>	
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="areas_table" class="settings-table">
		<thead>
			<tr><th>Zone</th><th>Surcharge Name</th><th>Surcharge Amount</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Area?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This area will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>