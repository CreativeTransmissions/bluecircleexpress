<?php settings_fields( 'surcharges' ); ?>
<?php do_settings_sections( 'surcharges' ); ?>
<form class="admin-form tq-admin-form box-form round" id="edit_surcharge_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add a new surcharge by entering the details below:</legend>
		
		<div class="row row-surcharges">
			<div class="field">
				<label for="name">Surcharge</label>
				<input class="input-long" type="text" name="name" />
			</div>
			<div class="field">
				<label for="description">Amount (<?php echo $this->config['currency_symbol']; ?>)</label>
				<input class="input-short" type="text" name="amount"/>
			</div>			
		</div>
	</fieldset>

	<div class="buttons">
		<div class="inline-field">
			<?php submit_button('Save surcharge', 'primary', 'save_surcharge', true, array('class'=>'submit')); ?>
		</div>
		<div class="inline-field">
			<?php submit_button('Clear Form', 'primary', 'clear_surcharge', true, array('class'=>'submit')); ?>
		</div>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro4_save_record"/>
	<input type="hidden" name="update" value="surcharges"/>	
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="surcharges_table" class="settings-table">
		<thead>
			<tr><th>Surcharge Name</th><th>Amount</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Surcharge?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This surcharge swill be permanently deleted and cannot be recovered. Are you sure?</p>
</div>