<div class="transit_inner address pick-start"> <!-- Delivery Address section start here -->
    <div class="transit_header">
        <h2><?php echo self::get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'); ?></h2>
    </div>
    <div class="transit_body">
         <div class="search-fields">
            <div class="collection_wrap">
                <span class="sub_title">
                    <i class="icon icon-icn-collection-address"></i><?php echo $this->view_labels['collection_address_label']; ?>
                </span>
                <div class="address-wrap">
                    <span class="transit_noadress"><a href="#" class="no-address no-address-0"><?php echo $this->view_labels['cant_find_address_text']; ?></a></span>
                    <div class="bt-flabels__wrapper full">
                        <input tabindex="10" class="text addresspicker" required type="text" name="address_0_address" id="address_0" value="" autocomplete="false" placeholder = "<?php echo $this->view_labels['collection_address_label']; ?>"/>
                        <span class="bt-flabels__error-desc">Required: <?php echo $this->view_labels['collection_address_label']; ?></span>
                    </div>
                    <?php if($this->ask_for_unit_no){ ?>       
                        <div class="inline-block bt-flabels__wrapper half left">     
                            <input class="left" type="text" id="address_0_appartment_no"  data-parsley-maxlength="20" name="address_0_appartment_no" placeholder="<?php echo $this->view_labels['appartment_no_label']; ?>" value=""/>
                        </div>
                    <?php } ?>
                    <?php if($this->ask_for_postcode){ ?>    
                        <div class="inline-block bt-flabels__wrapper half right last-address-field">    
                            <input class="postcode right" type="text" id="address_0_postal_code" data-parsley-maxlength="16" name="address_0_postal_code" placeholder="<?php echo $this->view_labels['postal_code_label']; ?>" value=""/>
                        </div>
                    <?php } ?>
        			<?php if($this->show_contact_name){ ?>
        				<div class="inline-block bt-flabels__wrapper half left">
        					<input class="left" type="text" id="address_0_contact_name" data-parsley-maxlength="128" name="address_0_contact_name" placeholder="<?php echo $this->view_labels['contact_name_label']; ?>" value=""/>
        				</div>
        			<?php } ?>
        			<?php if($this->show_contact_number){ ?>
        				<div class="inline-block bt-flabels__wrapper half right last-address-field">
        					<input class="right" type="text" id="address_0_contact_phone" data-parsley-maxlength="45" name="address_0_contact_phone" placeholder="<?php echo $this->view_labels['contact_phone_label']; ?>" value=""/>
        				</div>
        			<?php } ?>
                </div>
            </div>
            <div class="destination_wrap_sub">
                <div class="destination_wrap">
                    <span class="sub_title">
                        <i class="icon icon-icn-collection-address"></i><?php echo $this->view_labels['destination_address_label']; ?>
                    </span>
                    <div class="address-wrap">
                        <a href="#" class="transit_noadress no-address no-address-1"><?php echo $this->view_labels['cant_find_address_text']; ?></a>
                        <div class="bt-flabels__wrapper full">
                            <input  tabindex="11" class="text addresspicker" required type="text" name="address_1_address" id="address_1" value="" autocomplete="false" placeholder="<?php echo $this->view_labels['destination_address_label']; ?>" />
                            <span class="bt-flabels__error-desc">Required: <?php echo $this->view_labels['destination_address_label']; ?></span>
                        </div>
                        <?php if($this->ask_for_unit_no){ ?>
                        <div class="inline-block bt-flabels__wrapper half left">   
                            <input class="left" type="text" id="address_1_appartment_no" data-parsley-maxlength="20" name="address_1_appartment_no" placeholder="<?php echo $this->view_labels['appartment_no_label']; ?>" value=""/>
                        </div>
                        <?php } ?>
                        <?php if($this->ask_for_postcode){ ?>
                        <div class="inline-block bt-flabels__wrapper half right last-address-field">
                            <input class="postcode right" type="text" id="address_1_postal_code"  data-parsley-maxlength="16" name="address_1_postal_code" placeholder="<?php echo $this->view_labels['postal_code_label']; ?>" value=""/>
                        </div>
                        <?php } ?>
        				<?php if($this->show_contact_name){ ?>
        				<div class="inline-block bt-flabels__wrapper half left">
        					<input class="left" type="text" id="address_1_contact_name" data-parsley-maxlength="128" name="address_1_contact_name" placeholder="<?php echo $this->view_labels['contact_name_label']; ?>" value=""/>
        				</div>
        			<?php } ?>
        			<?php if($this->show_contact_number){ ?>
        				<div class="inline-block bt-flabels__wrapper half right last-address-field">
        					<input class="right" type="text" id="address_1_contact_phone" data-parsley-maxlength="45" name="address_1_contact_phone" placeholder="<?php echo $this->view_labels['contact_phone_label']; ?>" value=""/>
        				</div>
        			<?php } ?>
                    </div>
                </div>
            </div>
            <!-- DATE FIELDS STARTS -->
            <?php include( "date_time.php" );?>
            <!-- DATE FIELDS STARTS --> 
        </div>
    </div>
</div>

