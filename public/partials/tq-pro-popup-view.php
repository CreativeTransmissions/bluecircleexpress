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
<form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
        <?php
            $hide_section = $this->form_includes[0]['hidden'];
            include $this->form_includes[0]['template'].'.php';
            $hide_section = $this->form_includes[1]['hidden'];
            include $this->form_includes[1]['template'].'.php';
            $hide_section = $this->form_includes[2]['hidden']; ?>
    <div class="round">
    <?php   
            include  $this->form_includes[2]['template'].'.php' ;
            $hide_section = $this->form_includes[3]['hidden']; 
            include $this->form_includes[3]['template'].'.php';
    ?>
    </div>

    
    <?php include 'form-messages.php';?>
            
    <div class="clear"></div>    
    <input type="hidden" name="distance" value=""/>
    <input class="hours" type="hidden" name="time" value=""/>
    <input class="noticeCost" type="hidden" name="notice_cost" value=""/>
    <input class="totalCost" type="hidden" name="total" value=""/>
    <input class="basicCost" type="hidden" name="distance_cost" value=""/>
    <input type="hidden" name="action" value="tq_pro4_save_job"/>
    <input type="hidden" id="delivery_date" name="delivery_date" value=""/>
    <?php include 'popup-map.php'; ?>
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
    
<div id="woocommerce" style="display: none;">
    
</div>
</div>