<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * @package   TransitQuote
 * @author    Andrew van Duivenbode <hq@transitquote.co.uk>
 * @license   GPL-2.0+
 * @link      http://transitquote.co.uk
 * @copyright 2015 Creative Transmissions
 */
?>
<div id="feedback"></div>
<div class="requestform round">
    <div class="spinner-div"> </div>
    <div class="transit_main">
        <form id="quote-form" class="tq-form tq-primary-color" autocomplete="off" data-parsley-errors-messages-disabled>
            <?php 
                include( TQ_PLUGIN_PATH."public/themes/".strtolower($this->theme)."/form.php" );       
             ?>
            <div class="clear"></div>    
            <p class="hidden">
            <?php include 'hidden_fields.php';?>
            </p>
        </form>
    
        <div class="payment-result tq-primary-color">
            <div class="on-delivery text-center" style="display: none;">
                <div class="on-delivery-msg-succcess on-delivery" style="display: none;"><?php echo $this->success_message; ?></div>
            </div>
        </div>
        <div id="paypal" style="display: none;" class="tq-primary-color">
            <?php
                if(self::check_payment_config(2)){  
                    include $this->paypal_partials_dir.'paypal-button.php';
                };
            ?>
        </div>
    	<div id="woocommerce" style="display: none;" class="tq-primary-color"></div>
    </div>

</div>