<!-- customer fields here -->
<div class="clear"></div>
<div class="tq-form-fields-container <?php echo $hide_section; ?>">
	<fieldset>
		<legend><?php echo self::get_setting('tq_pro_form_options','contact_section_title', 'Your Contact Information'); ?></legend>
		<div class="tq-form-fields-inner">
			<div class="tq-row">
				<div class="tq-col48">
					<div class="tq-row bt-flabels__wrapper">
						<label for="first_name">First Name</label>
						<input tabindex="1" type="text" name="first_name" id="first_name" data-parsley-maxlength="45" required placeholder="First Name*">
						<span class="bt-flabels__error-desc">Required / Invalid First Name</span>
					</div>
					<div class="tq-row bt-flabels__wrapper">
						<label for="phone">Phone Number</label>
						<input tabindex="3" type="text" data-parsley-type="number" required name="phone" class="phone" data-parsley-maxlength="45" placeholder="Phone Number*">
						<span class="bt-flabels__error-desc">Required / Invalid Phone Number </span>
					</div>
				</div>
				<div class="tq-col48 right">
					<div class="tq-row bt-flabels__wrapper">
						<label for="last_name">Last Name</label>
						<input tabindex="2" type="text" name="last_name" id="last_name" required data-parsley-maxlength="45" placeholder="Last Name*">
						<span class="bt-flabels__error-desc">Required / Invalid Last Name </span>
					</div>
					<div class="tq-row bt-flabels__wrapper">
						<label for="email">Email Address</label>
						<input tabindex="4" type="text" name="email" id="email" data-parsley-type="email" data-parsley-maxlength="128" placeholder="Email Address*" required>
						<span class="bt-flabels__error-desc">Required / Invalid Email</span>
					</div>
				</div>
			</div>
			<div class="tq-row">
				<div class="tq-col100 bt-flabels__wrapper">
					<label for="description"><?php echo self::get_setting('tq_pro_form_options','job_info_label', 'Delivery Details'); ?></label>
					<textarea tabindex="5" name="description" id="description" cols="30" rows="5" placeholder="Additional Information"></textarea>
					<span class="bt-flabels__error-desc">Required / Invalid </span>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</fieldset>
</div>
