<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/public/partials
 */
   

?>
<!-- job fields here -->
<div id="feedback"></div>
<div class="requestform">
	<div class="spinner-div"> </div>
	<form id="quote-form" class="request-calc-form" autocomplete="off" data-parsley-errors-messages-disabled>
	    <h3>Choose a voucher type</h3>
		<div id="voucher_opt">
			<label id="digital_label"  for="digital">
			<input id="digital" class="switch_radios" type="radio" value="digital" name="vtype">
			Digital Gift Voucher
			</label>
			<label id="postal_label" for="postal">
			<input id="postal" class="switch_radios" type="radio" value="postal" name="vtype">
			Postal Gift Voucher
			</label>
		</div>
	<div class="hide_box" id="digital_form">
		<fieldset>
			<h2>Digital Gift Voucher</h2>
			<p>Fill out the information below to create and email a Digital Gift Voucher. Amount is in <abbr title="British Pounds Sterling">GBP</abbr>. Enter whole pounds only, e.g. 100</p>
			<div class="">
				<label for="digital_vvalue">Amount</label>
				<input type="text" id="digital_vvalue" value="" name="digital_vvalue" required>
				<span class="bt-flabels__error-desc">Required / Invalid Amount</span>
			</div>
			<div class="">
				<label for="digital_to_someone">Send To Who?</label>
				<span class="radios">
				  <label for="digital_to_me"><input type="radio" checked="checked" id="digital_to_me" value="digital_to_me" name="digital_to"> to me</label>
				  <label for="digital_to_someone"><input type="radio" id="digital_to_someone" value="digital_to_someone" name="digital_to"> to someone else</label>
				</span>
			</div>
			<div class="hide_box" id="digital_to_someone_box">
				<div class="">
				  <label for="to_email">(Send To) Email</label>
				  <input type="text" id="to_email" value="" name="to_email" required>
				  <span class="bt-flabels__error-desc">Required / Invalid  Email</span>
				</div>
				<div>
				<label for="digital_to_name">(Send To) Name</label>
				<input type="text" id="digital_to_name" value="" name="digital_to_name" required>
				<span class="bt-flabels__error-desc">Required / Invalid (Send To) Name</span>
				</div>
				<div>
				  <label for="digital_from_name">(From) Name</label>
				  <input type="text" id="digital_from_name" value="" name="digital_from_name" required>
				  <span class="bt-flabels__error-desc">Required / Invalid (From) Name</span>
				</div>
				<div class="">
				  <label for="digital_message">Message</label>
				  <textarea id="digital_message" name="digital_message" required></textarea>
				  <span class="bt-flabels__error-desc">Required / Invalid Message</span>
				</div>
				<div>
				  <label for="digital_delivery_date">Delivery Date</label>
				  <input type="text" id="digital_delivery_date" value="now" name="digital_delivery_date" class="hasDatepicker"required> (dd/mm/yyyy)
				</div>
				<div>
					<label for="digital_event">Occasion</label>
					<select class="" name="digital_event">
						<option value="choose">Choose
						</option><option value="valentines-day">Valentine's Day
						</option><option value="happy-mothers-day">Happy Mother's Day
						</option><option value="happy-fathers-day">Happy Father's Day
						</option><option value="merry-christmas">Merry Christmas
						</option><option value="happy-easter">Happy Easter
						</option><option value="happy-birthday">Happy Birthday
						</option><option value="thank-you">Thank You
						</option><option value="wedding-anniversary">Wedding Anniversary
						</option><option value="congratulations">Congratulations
						</option><option value="seasonal-wishes">Seasonal Wishes
						</option><option value="party-time">Party Time
						</option><option value="a-new-baby">A New Baby
						</option><option value="on-your-graduation">On Your Graduation
						</option><option value="keep-in-touch">Keep in Touch</option>            	
						<option>Other</option>
					</select>
					<div class="hide_box" id="other_box">
						 <label for="digital_other">Other<input type="text" id="digital_other" value="" name="digital_other"></label>
					</div>
				</div>  
			</div>
		</fieldset>
		<input type="submit" value="Add Digital Gift Voucher To Basket" name="add_digital_voucher" class="button alt">
	</div>
		<div id="postal_form" class="hide_box">
			<fieldset>
			<h2>Postal Gift Voucher</h2>
			<p>Choose a Postal Gift Voucher value from the options below and then fill out the rest of the information. Amount is in <abbr title="British Pounds Sterling">GBP</abbr>.</p>
			<div class="fixed_denominations "> 
			    <?php while ( $this->voucher_list->have_posts() ) : $this->voucher_list->the_post(); global $product; ?>
				<label class="" ><input type="radio"  value='<?php echo $this->voucher_list->post->ID; ?>' name="postal_vvalue">
					<?php echo get_woocommerce_currency_symbol().$product->get_price(); ?>                					
				</label>
				<?php endwhile; ?>
			</div>
			<div>
				<label for="design_standard">Voucher Design</label>
				<span class="radios">
				  <label for="design_standard"><input type="radio" checked="checked" id="design_standard" value="design_standard" name="design"> Standard balance Voucher</label>
				  <label for="design_xmas"><input type="radio" id="design_xmas" value="design_xmas" name="design"> Christmas Voucher</label>
				</span>
			</div>
			<div class="">
				<label for="postal_to_someone">Send To Who?</label>
				<span class="radios">
				  <label for="postal_to_me"><input type="radio" checked="checked" id="postal_to_me" value="postal_to_me" name="postal_to"> to me</label>
				  <label for="postal_to_someone"><input type="radio" id="postal_to_someone" value="postal_to_someone" name="postal_to"> to someone else</label>
				</span>
			</div>
			<div  id="postal_to_someone_box" class="hide_box">
				<div id="this_address">
					  <h3>Send the Postal Gift Voucher to this person's address</h3>
					  <div class="">
						<label for="postal_to_first_name">First Name</label>
						<input type="text" id="postal_to_first_name" value="" name="postal_to_first_name" required>
						<span class="bt-flabels__error-desc">Required / Invalid First Name</span>
					  </div>
					  <div class="">
						<label for="postal_to_surname">Surname</label>
						<input type="text" id="postal_to_surname" value="" name="postal_to_surname" required>
						<span class="bt-flabels__error-desc">Required / Invalid Surname</span>
					  </div>
					  
					  <div class="">
						<label for="postal_to_address_1">Address (Line 1)</label>
						<input type="text" id="postal_to_address_1" value="" name="postal_to_address_1" required>
						<span class="bt-flabels__error-desc">Required / Invalid Address</span>
					  </div>
					  
					  <div>
						<label for="postal_to_address_2">Address (Line 2)</label>
						<input type="text" id="postal_to_address_2" value="" name="postal_to_address_2" >
					  </div>
					  
					  <div class="">
						<label for="postal_to_town">Town / City</label>
						<input type="text" id="postal_to_town" value="" name="postal_to_town" required> 
						<span class="bt-flabels__error-desc">Required / Invalid Town / City</span>
					  </div>
					  
					  <div class="">
						<label for="postal_to_county">County / Region</label>
						<input type="text" id="postal_to_county" value="" name="postal_to_county" required> 
						<span class="bt-flabels__error-desc">Required / Invalid  County / Region</span>
					  </div>
					  
					  <div class="">
						<label for="postal_to_postcode">Postcode</label>
						<input type="text" id="postal_to_postcode" value="" name="postal_to_postcode" required>
                        <span class="bt-flabels__error-desc">Required / Invalid  Postcode</span>						
					  </div>
					  
					  <div>
						<label>Country</label>
						<input type="text" value="United Kingdom" disabled="disabled" required>
						<span class="bt-flabels__error-desc">Required / Invalid  Country</span>
					  </div>
					  
					</div>	
				<div>
				    <label for="postal_from_name">(From) Name</label>
				    <input type="text" id="postal_from_name" value="" name="postal_from_name" required>
				    <span class="bt-flabels__error-desc">Required / Invalid  Name</span>
				</div>
				<div>
				    <label for="postal_message">Message</label>
				    <textarea id="postal_message" name="postal_message" required></textarea>
				    <span class="bt-flabels__error-desc">Required / Invalid  Message</span>
				</div>
				
				<div>
				    <label for="postal_delivery_date">Delivery Date</label>
				    <input type="text" id="postal_delivery_date" value="" name="postal_delivery_date" class="hasDatepicker" required> (dd/mm/yyyy)
				    <span class="bt-flabels__error-desc">Required / Invalid  Delivery Date</span>
				</div>
			</div>
            </fieldset>
			<input type="submit" value="Add Postal Gift Voucher To Basket" name="add_postal_voucher" class="button">
	    </div>

	</form> 

	<div class="tq-address-container" >
        <?php include 'form-messages.php';?>
    </div>
</div>