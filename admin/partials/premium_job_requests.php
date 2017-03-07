<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'transportation_requests' ); ?>
	<?php do_settings_sections( 'transportation_requests' ); ?>
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

	<table id="jobs_table" class="settings-table">
		<thead>
			<tr><th>Request Recieved</th><th>Customer Name</th><th>Customer Location</th><th>Customer Destination</th><th>Pick Up Date and Time</th><th>Payment Method</th><th>Payment Status</th></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>

<div id="dialog-confirm" title="Delete Request?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This request will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>