<?php settings_fields( 'holiday_dates' ); ?>
<?php do_settings_sections( 'holiday_dates' ); ?>

<form class="admin-form tq-admin-form box-form round" id="edit_holiday_dates_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Add  start/end date range for holiday dates:</legend>
		
		<div class="row row-services">
			<div class="field">
				<label for="start_date">Start Date</label>
				<input class="input-long datepicker" name="start_date" id="start_date"/>
				<!-- <input id="start_date_alt"  name="start_date" type="hidden" /> -->
			</div>
			<div class="field">
				
				<label for="end_date">End Date</label>
				<input class="input-long datepicker" name="end_date"  id="end_date" />
				<!-- <input id="end_date_alt" name="end_date"  type="hidden" /> -->
			</div>
		</div>
	</fieldset>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro4_save_record"/>
	<input type="hidden" name="update" value="holiday_dates"/>
	<div class="inline-field">
		<?php submit_button('Save Date', 'primary', 'save_holiday_date', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<?php submit_button('Clear Form', 'primary', 'clear_holiday_date', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>



<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">


	<table id="holiday_dates_table" class="settings-table">
		<thead>
			<!-- <th>Id</th> -->
			<th>Start Date</th>
			<th>End Date</th>
		</tr>
		</thead>
		<tbody>
		<tr><td colspan="2" class="empty-table"><div class="spinner"></div><?php echo $this->get_empty_message(); ?></td></tr>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Service?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This date range will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
