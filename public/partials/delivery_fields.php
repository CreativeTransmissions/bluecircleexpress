<?php 
    $has_services = $this->has_services(); 
    $has_vehicles = $this->has_vehicles();
    $using_service_descript = $this->using_service_descript();
    $using_vehicle_descript = $this->using_vehicle_descript();
?>
<fieldset class="search-fields">
<div class="tq-row  <?php echo $hide_section; ?>">
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
<div class="tq-row">
	<div>
		<div class="bt-flabels__wrapper half left">
			<label for="collection_date">Pick up date</label>
			<input tabindex="6" data-parsley-trigger="select change" type="text" class="datepicker"  placeholder="Collection Date*"  name="collection_date" id="collection_date" required readonly="">
			<span class="bt-flabels__error-desc">Required / Invalid Pick up date</span>
		</div>
		<div class="bt-flabels__wrapper half right last-address-field">
			<label for="collection_time">Pick up time</label>
			<input tabindex="7" data-parsley-trigger="select change" type="text" class="timepicker" readonly="" placeholder="Collection Time*" name="delivery_time" id="collection_time" required>
			<span class="bt-flabels__error-desc">Required / Invalid Pick up time</span>
		</div>
	</div>
</div>
<?php if($this->show_deliver_and_return){ ?>
<div class="tq-row">
	<div class="tq-row bt-flabels__wrapper">
		<p class="radio-group-label">Deliver from collection to destination and then return to the collection address</p>
		    <input type="radio" id="one_way" name="deliver_and_return" value="0" checked="checked"/><label for="one_way" class="radio-label">One Way</label>
		    <input type="radio" id="deliver_and_return" name="deliver_and_return" value="1"/><label for="deliver_and_return" class="radio-label">Deliver and Return</label>
	</div>
</fieldset>
<?php }; ?>