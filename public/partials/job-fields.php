<?php 
	$has_services = $this->has_services(); 
	$has_vehicles = $this->has_vehicles(); 
?>
<!-- job fields here -->
<div class="clear"></div>
<div class="tq-form-fields-container">
	<div class="tq-form-fields-inner">
		<div class="tq-row">
			<div class="tq-col48">
				<div class="tq-row bt-flabels__wrapper">
					<label for="first_name">First Name</label>
					<input tabindex="1" type="text" name="first_name" id="first_name" required placeholder="First Name*">
					<span class="bt-flabels__error-desc">Required / Invalid First Name</span>
				</div>
				<div class="tq-row bt-flabels__wrapper">
					<label for="phone">Phone Number</label>
					<input tabindex="3" type="text" data-parsley-type="number" data-parsley-length="[6, 15]" required name="phone" class="phone" placeholder="Phone Number*">
					<span class="bt-flabels__error-desc">Required / Invalid Phone Number </span>
				</div>
			</div>
			<div class="tq-col48 right">
				<div class="tq-row bt-flabels__wrapper">
					<label for="last_name">Last Name</label>
					<input tabindex="2" type="text" name="last_name" id="last_name" required placeholder="Last Name*">
					<span class="bt-flabels__error-desc">Required / Invalid Last Name </span>
				</div>
				<div class="tq-row bt-flabels__wrapper">
					<label for="email">Email Address</label>
					<input tabindex="4" type="text" name="email" id="email" data-parsley-type="email"  placeholder="Email Address*" required>
					<span class="bt-flabels__error-desc">Required / Invalid Email</span>
				</div>
			</div>
		</div>
		<div class="tq-row">
			<div class="tq-col100 bt-flabels__wrapper">
				<label for="description">Delivery Details</label>
				<textarea tabindex="5" name="description" id="description" cols="30" rows="5" placeholder="Additional Information"></textarea>
				<span class="bt-flabels__error-desc">Required / Invalid </span>
			</div>
		</div>
		<div class="tq-row">
			<div class="tq-col48">
				<div class="tq-row bt-flabels__wrapper">
					<label for="collection_date">Pick up date</label>
					<input tabindex="6" data-parsley-trigger="select change" type="text" class="datepicker"  placeholder="Collection Date*"  name="collection_date" id="collection_date" required readonly="">
					<span class="bt-flabels__error-desc">Required / Invalid Pick up date</span>
				</div>
			</div>
			<div class="tq-col48 right">
				<div class="tq-row bt-flabels__wrapper">
					<label for="collection_time">Pick up time</label>
					<input tabindex="7" data-parsley-trigger="select change" type="text" class="timepicker" readonly="" placeholder="Collection Time*" name="delivery_time" id="collection_time" required>
					<span class="bt-flabels__error-desc">Required / Invalid Pick up time</span>
				</div>
			</div>
		</div>
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
								<?php echo $this->render_vehicle_descriptions(); ?>
							</div>
						</div>			
				<?php }; ?>
			<?php }; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<input type="hidden" name="action" value="tq_pro3_save_job"/>
<input type="hidden" id="delivery_date" name="delivery_date" value=""/>