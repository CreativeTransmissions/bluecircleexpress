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
<div class="requestform round">
<div class="spinner-div"> </div>
<form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
        <?php $hide_section = $this->form_includes[0]['hidden'];
            include $this->form_includes[0]['template'].'.php';
            $hide_section = $this->form_includes[1]['hidden'];
            include $this->form_includes[1]['template'].'.php'; ?>
    <div class="tq-address-container round">
    <?php   $hide_section = $this->form_includes[2]['hidden']; 
            include  $this->form_includes[2]['template'].'.php' ;
            $hide_section = $this->form_includes[3]['hidden']; 
            include $this->form_includes[3]['template'].'.php' ?>

        <div class="tq-row buttons">
            <div class="tq-col100 tq-button-center">
                <input tabindex="12" name="tq-form-submit" type="submit" value="Get Estimate" class="tq-button">
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
                    <span class="sub-total"><?php echo $this->currency_code; ?></span>
                    <span class="sub-total noticeCost"></span>
                    
                </div>
                <div class="field">
                    <label class="" for="totalCost"><b>Estimated</b> Cost:</label>
                    <span class="sub-total"><?php echo $this->currency_code; ?></span>
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
    <input type="hidden" name="action" value="tq_pro3_save_job"/>
    <input type="hidden" id="delivery_date" name="delivery_date" value=""/>
</form>
<div class="payment-result">
    <div class="on-delivery text-center" style="display: none;">
        <div class="on-delivery-msg-succcess on-delivery" style="display: none;"><?php echo $this->success_message; ?></div>
    </div>
</div>
<div id="paypal" style="display: none;">
    <?php
        if(self::check_payment_config(2)){  
            include $this->paypal_partials_dir.'paypal-button.php';
        };
    ?>
</div>
    
</div>