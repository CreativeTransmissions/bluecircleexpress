<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'paypal_transactions' ); ?>
	<?php do_settings_sections( 'paypal_transactions' ); ?>
	<table id="transactions_paypal_table" class="settings-table">
		<thead>
			<tr><th>Job ID</th><th>Customer Name</th><th>Customer Email</th><th>Amount</th><th>Currency</th><th>Status</th></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>