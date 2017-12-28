<?php settings_fields( 'journey_lengths' ); ?>
<?php do_settings_sections( 'journey_lengths' ); ?>
<p>You can use a completely different set of rates depending on the journey length for a delivery. Use this option if your business requires either:</p>
	<ul><li>A different set of distance boundaries depending on journey length</li>
		<li>Different rates for the same distance boundaries depending on journey length</li>
	</ul>
<form class="admin-form tq-admin-form box-form round" id="edit_journey_length_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Enter the maximum journey length in <?php echo $this->admin->distance_unit; ?>s for each set of rates.</legend>
		<p>For example, to have a set of rates that only applies to journeys up to 20 miles, make sure that 20 appears in the table below.</p>
		<p><em>Please note that the rates set for a maximum distance of 0 will apply to journeys that are longer than any maximum distance set.</em>
		<div class="row row-journey-lengths">
			<div class="field">
				<label for="distance">Maximum Distance</label>
				<input class="input-small" type="text" name="distance" />
			</div>
		</div>
	</fieldset>

	<div class="buttons">
		<div class="inline-field">
			<?php submit_button('Save journey Length', 'primary', 'save_journy_length', true, array('class'=>'submit')); ?>
		</div>
		<div class="inline-field">
			<?php submit_button('Clear Journey Length', 'primary', 'clear_journy_length', true, array('class'=>'submit')); ?>
		</div>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="tq_pro3_save_record"/>
	<input type="hidden" name="update" value="journey_lengths"/>	
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<table id="journey_lengths_table" class="settings-table">
		<thead>
			<tr><th>Maximum Distance</th><th class="actions"><div class="spinner"></div></tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</form>
<div id="dialog-confirm" title="Delete Maximum Distance?" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This maximum distance and the rates associated with it will be permanently deleted and cannot be recovered. To preserve any rates set click Edit. Are you sure you would like to delete?</p>
</div>