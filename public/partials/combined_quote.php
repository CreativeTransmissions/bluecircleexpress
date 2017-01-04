<div class="requestform"> 
<div class="spinner-div"> </div>
    <div class="request-contact-form"> 
        <form id="quote-form" class="request-calc-form" autocomplete="off" data-parsley-errors-messages-disabled>
            <h2>Request a Quote</h2> <div class="subtext">Want a quick quote for move. Fill this quick form</div>
            <div class="request-form"> 
                <fieldset class="enquiry-type"> <legend>Enquiry type</legend> 
                    <div class="row"> 
                        <div class="columns small-12 medium-6"> 
                            <input type="radio" require checked="checked" id="domestic" name="service_type_id" class="domestic service_type_id" value="2"><label for="service_type_id">Domestic</label> 
                        </div>
                        <div class="columns small-12 medium-6">
                            <input type="radio" id="domestic" name="service_type_id" class="service_type_id domestic" value="1"><label for="service_type_id">Commercial</label> 
                        </div>
                    </div>
                </fieldset> 
                <fieldset class="requirements"> <legend>Requirements</legend> 
                    <?php include 'customer-fields.php'; ?>

                    <div class="row"> 
                        <div class="columns small-12 "> 
                           <?php include 'business-size-select.php'; ?>
                            <?php include 'domestic-house-size-select.php'; ?>                    
                        </div>
                    </div>
                    <?php include 'moving-fields.php'; ?>
                </fieldset> 
                <fieldset class="requirements"> 
                    <legend>Message</legend> 
                    <div class="row"> <div class="columns small-13"> <textarea name="description" placeholder="ADDITONAL MESSAGE" id="message" class="message" cols="30" rows="3"></textarea> </div></div>
                </fieldset> 
                <div class="row"> 
                    <div class="columns small-13"> <input type="submit" value="Get quote" id="get-quote" class="get-quote request_form_btn"> </div>
                </div>




        
            </div>
            <?php include 'moving-map.php'; ?>
            <input type="hidden" name="action" value="save_job"/>
        </form>
        <?php include 'form-messages.php';?>
    </div>

    

</div>
