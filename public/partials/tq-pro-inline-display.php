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
            <?php
                $hide_section = $this->form_includes[0]['hidden'];
                include $this->form_includes[0]['template'].'.php';
                $hide_section = $this->form_includes[1]['hidden'];
                include $this->form_includes[1]['template'].'.php'; ?>
        <div class="tq-address-container round">
        <?php   $hide_section = $this->form_includes[2]['hidden']; 
                include  $this->form_includes[2]['template'].'.php' ;
                $hide_section = $this->form_includes[3]['hidden']; 
                include $this->form_includes[3]['template'].'.php';
                $hide_section = $this->form_includes[4]['hidden']; 
                include $this->form_includes[4]['template'].'.php';
        ?>
        </div>

        
        <?php include 'form-messages.php';?>
                
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
</div>