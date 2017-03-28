<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * @package   TransitQuote
 * @author    Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @license   GPL-2.0+
 * @link      http://customgooglemaptools.com
 * @copyright 2015 Creative Transmissions
 */
?>
<div id="feedback"></div>
<div class="requestform">
<div class="spinner-div"> </div>
<form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
    <?php include_once 'job-fields.php'; ?>
    <div class="tq-address-container">
        <fieldset class="map-ctr">
            <legend>Address Locations</legend>
            <div id="map"></div>
        </fieldset>
        <fieldset class="search-fields">
            <legend>Enter Addresses</legend>
            <div class="field bt-flabels__wrapper">
                <label for="pick_up">Customer Location</label>
                <a href="#" class="no-address no-address-0">I can't find my address</a>
                <input tabindex="8" class="text addresspicker" required type="text" name="address_0" id="address_0" value="" autocomplete="false"/>
                <span class="bt-flabels__error-desc">Required: Customer Location</span>
                <input class="small inline-block" type="text" id="address_0_appartment_no" name="address_0_appartment_no" placeholder="Unit" value=""/>
                <input class="small inline-block postcode right" type="text" id="address_0_postal_code" name="address_0_postal_code" placeholder="Postcode" value=""/>
            </div>

            <div class="field bt-flabels__wrapper">
                <label for="drop_off">Customer Destination</label>
                <a href="#" class="no-address no-address-1">I can't find my address</a>
                <span class="bt-flabels__error-desc">Required: Destination Address</span>
                <input  tabindex="11" class="text addresspicker" required type="text" name="address_1" id="address_1" value="" autocomplete="false"/>
                <input class="small inline-block" type="text" id="address_1_appartment_no" name="address_1_appartment_no" placeholder="Unit" value=""/>
                <input class="small inline-block postcode right" type="text" id="address_1_postal_code" name="address_1_postal_code" placeholder="Postcode" value=""/>
            </div>
        </fieldset>

        <div class="tq-row buttons">
            <div class="tq-col100 tq-button-center">
                <input  tabindex="12" id="form-submit" type="submit" value="Get Estimate" class="tq-button">
            </div>
        </div>
    </div>
    <div class="tq-row success" style="display:none;">
            <fieldset class="quote-fields">
                <legend>Transportation Cost</legend>
                <div class="field">
                    <label class="" for="distance">Distance (<?php echo $this->distance_unit; ?>s):</label>
                    <span class="sub-total" id="distance"></span>
                    
                </div>
                <div class="field">
                    <label class="" for="hours">Estimated Travel Time:</label>
                    <span class="sub-total" id="hours"></span>
                </div>
                <div class="field notice-field">
                    <label class="" for="notice">Short Notice Cost:</label>
                    <span class="sub-total"><?php echo $this->currency; ?></span>
                    <span class="sub-total noticeCost"></span>
                    
                </div>
                <div class="field">
                    <label class="" for="totalCost"><b>Estimated</b> Cost:</label>
                    <span class="sub-total"><?php echo $this->currency; ?></span>
                    <span class="sub-total quote" id="totalCost"></span>
                </div>      
            </fieldset>
    </div>
    <?php include 'form-messages.php';?>
            
    <div class="clear"></div>    
    <input type="hidden" name="distance" value=""/>
    <input class="hours" type="hidden" name="time" value=""/>
    <input class="noticeCost" type="hidden" name="notice_cost" value=""/>
    <input class="totalCost" type="hidden" name="total" value=""/>
    <input class="basicCost" type="hidden" name="distance_cost" value=""/>

</form>
<div id="paypal" style="display: none;"></div>
    
</div>