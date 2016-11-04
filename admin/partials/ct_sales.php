<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'ct_customers_products' ); ?>
	<?php do_settings_sections( 'ct_customers_products' ); ?>
		<fieldset class="date-filters">
		<div class="inline-field">
			<label for="from_date">From</label>
			<input id="from_date" class="datepicker"/>
			<input id="from_date_alt" class="datepicker" type="hidden" />
		</div>
		<div class="inline-field">
			<label for="to_date">To</label>
			<input id="to_date" class="datepicker" />
			<input id="to_date_alt" class="datepicker" type="hidden" />
		</div>	
 	</fieldset>
	<table id="ct_customers_products_table" class="settings-table">
		<thead>
			<tr><th>Customer</th><th>Product name</th><th>Purchased Date</th><th class="actions"><div class="spinner"></div></th></tr>
		</thead>
		<tbody>
		<tr><td colspan="4" class="empty-table"><div class="spinner"></div><?php echo $this->empty_message; ?></td></tr>
		</tbody>
	</table>
</form>
