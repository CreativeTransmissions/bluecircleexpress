<?php $is_transitteam_active =  $this->is_transitteam_active(); ?>
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
	<?php echo $this->filter_bar(); ?>

<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'transportation_requests' ); ?>
	<?php do_settings_sections( 'transportation_requests' ); ?>
	<table id="jobs_table" class="settings-table">
		<thead>
			<tr><th>Status</th>
			<th data-sortby='id' data-order='DESC'>Ref<span class="sorting"></span></th>
			<th data-sortby='created' data-order='DESC'>Received<span class="sorting"></span></th>
			<th data-sortby='name' data-order='ASC'>Customer Name<span class="sorting"></span></th>
			<th data-sortby='pick_up' data-order='ASC'>Collection Address<span class="sorting"></span></th>
			<th data-sortby='drop_off' data-order='ASC'>Delivery Address<span class="sorting"></span></th>
			<th data-sortby='delivery_time' data-order='ASC'>Pick Up Time<span class="sorting"></span></th>
			<th data-sortby='payment_method' data-order='ASC'>Payment Method<span class="sorting"></span></th>
			<th data-sortby='payment_status' data-order='ASC'>Payment Status<span class="sorting"></span></th>
			<?php if ($is_transitteam_active){?>
				<th data-sortby='driver_id' data-order='ASC'>Drivers<span class="sorting"></span></th>
			<?php }?>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>

<div id="dialog-confirm" title="Delete Request?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This request will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>