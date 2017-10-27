<div class="requestform tq-form"> 
    <div class="spinner-div"> </div>
    <div class="request-contact-form">  
        <form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
            <!-- <h2>Request a Quote</h2> <div class="subtext">Want a quick quote for move. Fill this quick form</div> -->
            <div class="request-form"> 
                <input type="hidden" name="service_type_id" value="2">
                
                <div class="clear"></div>
                <div class="tq-address-container">
                    
                    <fieldset class="search-fields">
                        <legend>Enter Addresses</legend>
                        <div class="row"> 
                            <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
                                <label for="pick_up">Collection Address</label>
                                <input type="text" required id="moving-from" name="moving_from" class="popup-with-form moving-from" placeholder="Collection">
                                <span class="bt-flabels__error-desc">Required Move From</span>
                             </div>
                            <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
                                <label for="drop_off">Delivery Address</label>
                                <input type="text" required name="moving_to" id="moving-to"class="popup-with-form moving-to"  placeholder="Delivery"><span class="bt-flabels__error-desc">Required Move To</span>
                            </div>
                        </div>
                    
                    </fieldset>
                    <?php include 'delivery_fields.php'; ?>
                    <?php include_once 'customer_fields.php'; ?>


                    <div class="row"> 
                        <div class="tq-col100 tq-button-center">
                        <div class="columns small-13"> <input type="submit" value="Get quote" id="get-quote" class="tq-button get-quote request_form_btn"> </div>
                        </div>
                    </div>

                    <input type="hidden" name="action" value="tq_pro_save_job"/>
                </div>

            </div>
            
            <div class="tq-address-container">
                <div class="tq-row success" style="display:none;">
                        <fieldset class="quote-fields">
                            <legend>Esitmated Removal Cost</legend>
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
                                <label class="" for="totalCost">Estimated Cost:</label>
                                <span class="sub-total"><?php echo $this->currency_code; ?></span>
                                <span class="sub-total quote" id="totalCost"></span>
                            </div>      
                        </fieldset>
                </div>
                <?php include 'form-messages.php';?>
            </div>
            <input type="hidden" name="action" value="tq_pro3_save_job"/>
            <input type="hidden" id="delivery_date" name="delivery_date" value=""/>
            <?php include 'popup-map.php'; ?>
        </form>            
    </div>
</div>




