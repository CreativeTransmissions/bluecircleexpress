<div class="search-fields">

<?php if($this->pick_start_address=='true') { ?>
    <div class="collection_wrap">
        <span class="sub_title">
            <i class="icon icon-icn-collection-address"></i><?php echo self::get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'); ?>
        </span>
        <div class="address-wrap">
            <span class="transit_noadress"><a href="#" class="no-address no-address-0">I can&apos;t find my address</a></span>
            <div class="bt-flabels__wrapper full">
                <input tabindex="10" class="text addresspicker" required type="text" name="address_0_address" id="address_0" value="" autocomplete="false"/>
                <span class="bt-flabels__error-desc">Required: Collection Address</span>
            </div>
            <?php if($this->ask_for_unit_no){ ?>       
                <div class="inline-block bt-flabels__wrapper half left">     
                    <input class="left" type="text" id="address_0_appartment_no" name="address_0_appartment_no" placeholder="Unit" value=""/>
                </div>
            <?php } ?>
            <?php if($this->ask_for_postcode){ ?>    
                <div class="inline-block bt-flabels__wrapper half right last-address-field">    
                    <input class="postcode right" type="text" id="address_0_postal_code" name="address_0_postal_code" placeholder="Postcode" value=""/>
                </div>
            <?php } ?>
        </div>
    </div>


    <div class="destination_wrap_sub">
        <div class="destination_wrap">
            <span class="sub_title">
                <i class="icon icon-icn-collection-address"></i><?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?>
            </span>
            <div class="address-wrap">
                <a href="#" class="transit_noadress no-address no-address-1">I can&apos;t find my address</a>
                <div class="bt-flabels__wrapper full">
                    <input  tabindex="11" class="text addresspicker" required type="text" name="address_1_address" id="address_1" value="" autocomplete="false"/>
                    <span class="bt-flabels__error-desc">Required: <?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?></span>
                </div>
                <?php if($this->ask_for_unit_no){ ?>
                <div class="inline-block bt-flabels__wrapper half left">   
                    <input class="left" type="text" id="address_1_appartment_no" name="address_1_appartment_no" placeholder="Unit" value=""/>
                </div>
                <?php } ?>
                <?php if($this->ask_for_postcode){ ?>
                <div class="inline-block bt-flabels__wrapper half right last-address-field">
                    <input class="postcode right" type="text" id="address_1_postal_code" name="address_1_postal_code" placeholder="Postcode" value=""/>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- DATE FIELDS STARTS -->
    <?php include( "date_time.php" );?>
    <!-- DATE FIELDS STARTS --> 

<?php } else {?>

    <div class="address-wrap">
        <div class="destination_wrap_sub">
            <div class="destination_wrap">
                <div class="destination_title_wrap">
                    <span class="sub_title">
                        <i class="icon icon-icn-collection-address"></i><?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?>
                    </span>                    
                    <a href="#" class="transit_noadress no-address no-address-1">I can&apos;t find my address</a>
                </div>
                <div class="full bt-flabels__wrapper">
                    <input tabindex="10" class="left text addresspicker" required type="text" name="address_1_address" id="address_1" value="" autocomplete="false"/>
                    <span class="bt-flabels__error-desc">Required: <?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?></span>
                </div>
                <div class="bt-flabels__wrapper half">
                    <input class="left" type="text" id="address_1_appartment_no" name="address_1_appartment_no" placeholder="Unit" value=""/>
                    <input class="postcode right" type="text" id="address_1_postal_code" name="address_1_postal_code" placeholder="Postcode" value=""/>
                </div>        
            </div>    
        </div>    
    </div>    
    <!-- DATE FIELDS STARTS -->
    <?php include( "date_time.php" );?>
    <!-- DATE FIELDS STARTS --> 
<?php }?>

</div>

