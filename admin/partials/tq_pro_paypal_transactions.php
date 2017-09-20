<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'paypal_transactions' ); ?>
	<?php do_settings_sections( 'paypal_transactions' ); ?>
	<input type="hidden" name="orderby" value=''/>
	<input type="hidden" name="order" value=''/>
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
	<table id="transactions_paypal_table" class="settings-table">
		<thead>
			<tr><th data-sortby='jobid' data-order='DESC'>Job ID<span class="sorting"></span></th>
				<th data-sortby='payment_date' data-order='DESC'>Payment Date<span class="sorting"></span></th>
				<th data-sortby='customer_name' data-order='ASC'>Customer Name<span class="sorting"></span></th>
				<th data-sortby='email' data-order='ASC'>Customer Email<span class="sorting"></span></th>
				<th data-sortby='amount' data-order='ASC'>Amount<span class="sorting"></span></th>
				<th data-sortby='currency' data-order='ASC'>Currency<span class="sorting"></span></th>
				<th data-sortby='paypal_status' data-order='ASC'>Status<span class="sorting"></span></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>