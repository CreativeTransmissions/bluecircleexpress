<form class="admin-form box-form round" id="edit_customer_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Update Customer details:</legend>
		<div class="inline-field">
			<label for="name">First Name</label>
			<input class="input-long" type="text" name="first_name" id="first_name"/>
		</div>
		<div class="inline-field">
			<label for="group">Last Name</label>
			<input class="input-long" type="text" name="last_name" id="last_name"/>
		</div>
		<div class="inline-field">
			<label for="group">Email</label>
			<input class="input-long" type="text" name="email" id="email"/>
		</div>
		<div class="inline-field">
			<label for="group">Phone</label>
			<input class="input-long" type="text" name="phone" id="phone"/>
		</div>
	</fieldset>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="ct_save_record"/>
	<input type="hidden" name="update" value="ct_customers"/>
	<div class="inline-field">
		<?php submit_button('Save Customer Details', 'primary', 'save_customer', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'ct_customers' ); ?>
	<?php do_settings_sections( 'ct_customers' ); ?>
	<table id="ct_customers_table" class="settings-table">
		<thead>
			<tr><th>Last Name</th><th>First Name</th><th>Email</th><th>Phone</th><th class="actions"><div class="spinner"></div></th></tr>
		</thead>
		<tbody>
		<tr><td colspan="4" class="empty-table"><div class="spinner"></div><?php echo $this->empty_message; ?></td></tr>
		</tbody>
	</table>
</form>
