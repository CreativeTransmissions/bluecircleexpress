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

    <div class="transit_main">
        <form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
            <?php 
                include( TQ_PLUGIN_PATH."public/themes/classic/form.php" );       
             ?>
            <div class="clear"></div>    
            <p class="hidden">
            <?php include 'hidden_fields.php';?>
            </p>
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
    	<div id="woocommerce" style="display: none;"></div>
    </div>

</div>