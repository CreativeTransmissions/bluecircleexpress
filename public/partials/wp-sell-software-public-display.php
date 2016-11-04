<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Sell_Software
 * @subpackage WP_Sell_Software/public/partials
 */
?>
<!-- job fields here -->
<div id="feedback"></div>
<div class="requestform">
	<div class="spinner-div"> </div>
	<form id="quote-form" class="request-calc-form" autocomplete="off" data-parsley-errors-messages-disabled>
		<div class="clear"></div>
		<div class="tq-form-fields-container">
			<div class="tq-form-fields-inner">
				<div class="tq-row">
					<div class="tq-col48">
						<div class="tq-row bt-flabels__wrapper">
							<label for="first_name">First Name</label>
							<input tabindex="2" type="text" name="first_name" id="first_name" required placeholder="YOUR FIRST NAME*">
							<span class="bt-flabels__error-desc">Required / Invalid First Name</span>
						</div>
						<div class="tq-row bt-flabels__wrapper">
							<label for="phone">Phone Number</label>
							<input tabindex="4" type="text" data-parsley-type="number" value='' data-parsley-length="[6, 15]" required name="phone" class="phone" placeholder="PHONE NUMBER*">
							<span class="bt-flabels__error-desc">Required / Invalid Phone Number </span>
						</div>
					</div>
					<div class="tq-col48 right">
						<div class="tq-row bt-flabels__wrapper">
							<label for="last_name">Last Name</label>
							<input tabindex="3" type="text" name="last_name" id="last_name" required placeholder="YOUR LAST NAME*">
							<span class="bt-flabels__error-desc">Required / Invalid Last Name </span>
						</div>
						<div class="tq-row bt-flabels__wrapper">
							<label for="email">Email Address</label>
							<input tabindex="5" type="text" name="email" id="email" value="" data-parsley-type="email"  placeholder="EMAIL ADDRESS*" required>
							<span class="bt-flabels__error-desc">Required / Invalid Email</span>
						</div>
					</div>
				</div>
				<div class="tq-row">
					<div class="tq-col100 bt-flabels__wrapper">
						<label for="job_title">Job title</label>
						<input tabindex="6" type="text" name="job_title" id="job_title" placeholder="JOB TITLE">
						
						<span class="bt-flabels__error-desc">Required / Invalid </span>
					</div>
					<div class="tq-col100 bt-flabels__wrapper">
						<label for="company">Type of business</label>
						<input tabindex="7" type="text" name="company" id="company" placeholder="TYPE OF BUSINESS">
						<span class="bt-flabels__error-desc">Required / Invalid </span>
					</div>
				</div>
				<input type="hidden" name="action" value="save_customer"/>
				<div class="tq-row buttons">
				    <div class="tq-col100 tq-button-center">
				        <input  tabindex="12" id="form-submit" type="submit" value="Submit" class="tq-button">
				    </div>
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form> 

	<div class="tq-address-container" >
        <?php include 'form-messages.php';?>
    </div>
</div>