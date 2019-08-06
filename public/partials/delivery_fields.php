<?php 
    $has_services = $this->has_services(); 
    $has_vehicles = $this->has_vehicles();
    $using_service_descript = $this->using_service_descript();
    $using_vehicle_descript = $this->using_vehicle_descript();
    $hide_all = ''; ?>
<fieldset class="delivery-fields">
<?php if(($has_services)||($has_vehicles)){ ?>
<div class="tq-row">
	<?php if($has_services){ ?>
	<div class="tq-col48">
		<div class="tq-row bt-flabels__wrapper">
			<label for="service_id">Service</label>
			<select tabindex="7" name="service_id" id="service_id">
			<?php $this->render_service_options_with_rates(); ?>
			</select>
		</div>
	</div>
	<div class="tq-col48 right">
		<div class="tq-row bt-flabels__wrapper">
			<label for="vehicle_id">Vehicle</label>
			<select tabindex="8" name="vehicle_id" id="vehicle_id">
			<?php $this->render_vehicle_options_with_rates(); ?>
			</select>
		</div>
	</div>
	<?php } else { ?>
		<?php if($has_vehicles){ ?>
				<div class="tq-col48">
					<div class="tq-row bt-flabels__wrapper">
						<label for="vehicle_id">Vehicle</label>
						<select tabindex="8" name="vehicle_id" id="vehicle_id">
						<?php $this->render_vehicle_options_with_rates(); ?>
						</select>
					</div>
				</div>
				<div class="tq-col48 right">
					<div class="tq-row bt-flabels__wrapper">
						<?php 
							if($using_vehicle_descript){
								echo $this->render_vehicle_descriptions();
							};
						?>
					</div>
				</div>			
			<?php }; ?>
		<?php }; ?>
</div>
<?php } ?>
<div class="tq-row">
		<div class="bt-flabels__wrapper half left">
			<label for="collection_date"><?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?></label>
			<input tabindex="6" data-parsley-trigger="select change" type="text" class="datepicker"  placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?>*"  name="collection_date" id="collection_date" required readonly="">
			<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?></span>
		</div>
		<div class="bt-flabels__wrapper half right last-address-field">
			<label for="collection_time"><?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></label>
			<input tabindex="7" data-parsley-trigger="select change" type="text" class="timepicker" readonly="" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?>*" name="delivery_time" id="collection_time" required>
			<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></span>
		</div>
</div>
<?php
	switch ($this->show_deliver_and_return) {
		case 'Ask': ?>
		<div class="tq-row">
			<div class="tq-row bt-flabels__wrapper">
				<p class="radio-group-label">Deliver from collection to destination and then return to the collection address</p>
				    <input type="radio" id="deliver_and_return1" name="deliver_and_return" value="0" checked="checked" /><label for="one_way" class="radio-label" >One Way</label>
				    <input type="radio" id="deliver_and_return2" name="deliver_and_return" value="1"/><label for="deliver_and_return" class="radio-label double-height">Deliver and Return</label>
			</div>
		</div> 
<?php  	break;
		case 'Always': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="1"/>
<?php  	break;
		case 'Never': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="0"/>
<?php  	break;
	}; ?>
</fieldset>
