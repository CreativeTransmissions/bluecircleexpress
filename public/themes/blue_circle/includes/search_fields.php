<div class="transit_inner address pick-start"> <!-- Delivery Address section start heres -->
    <div class="transit_header tq-form-title-color">
        <h2><?php echo self::get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'); ?></h2>
    </div>
    <div class="transit_body tq-form-bg-color">
         <div class="search-fields">
            <div class="collection_wrap">
                <span class="sub_title tq-primary-color">
                    <i class="icon icon-icn-collection-address"></i><span class="address-type-subtitle"><?php echo $this->view_labels['collection_address_label']; ?></span>
                </span>
                <div class="address-wrap">
                    <div class="tq-row">
                        <div class="half left">
                            <span class="sub_title">Purpose of visit</span>
                            <div class="bt-flabels__wrapper select-wrap">
                                <select class="visit_type" name="address_0_visit_type" id="address_0_visit_type">
                                    <option>Collection</option>
                                    <option>Delivery</option>
                                    <option>Collection and Delivery</option>
                                </select>
                            </div>       
                        </div>
                        <div class="half right">
                            <span class="sub_title"><span class="address-type-subtitle">Collection</span> Time</span>
                            <div class="bt-flabels__wrapper select-wrap">
                                <select class="time_type" name="address_0_time_type" id="address_0_time_type">
                                    <option>ASAP</option>
                                    <option class="address-type-subtitle">Collection At</option>
                                    <option class="address-type-subtitle">Collection By</option>
                                </select>
                            </div>       
                        </div>                    
                    </div>       
                    <div class="tq-row optional-date-time" style="display: none;">
                        <?php if($this->ask_for_collection_date_per_address){ ?>    
                            <div class="coll_date_wrap bt-flabels__wrapper">
                                <input name="address_0_collection_date" id="address_0_collection_date" data-parsley-trigger="select change" required readonly="" class="left collection_date dateclass placeholderclass datepicker" type="text" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?>">
                                <span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($this->ask_for_collection_time_per_address){ ?>
                            <div class="coll_time_wrap bt-flabels__wrapper">
                                <input class="right collection_time dateclass placeholderclass timepicker" readonly="" type="text" data-parsley-trigger="select change" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?>" name="address_0_collection_time" id="address_0_collection_time" required>
                                <span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></span>
                            </div>
                        <?php } ?>
                    </div>                    
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
                    <span class="sub_title tq-primary-color">
                        <i class="icon icon-icn-collection-address"></i><span class="address-type-subtitle"><?php echo $this->view_labels['destination_address_label']; ?></span>
                    </span>
                    <div class="address-wrap">
                        <div class="tq-row">
                            <div class="half left">
                                <span class="sub_title"></i>Purpose of visit</span>
                                <div class="bt-flabels__wrapper select-wrap">
                                    <select class="visit_type" name="address_1_visit_type" id="address_1_visit_type">
                                        <option>Collection</option>
                                        <option selected="selected">Delivery</option>
                                        <option>Collection and Delivery</option>
                                    </select>
                                </div>       
                            </div>
                            <div class="half right">
                                <span class="sub_title"><span class="address-type-subtitle">Delivery</span> Time</span>
                                <div class="bt-flabels__wrapper select-wrap">
                                    <select class="time_type" name="address_1_time_type" id="address_1_time_type">
                                        <option>ASAP</option>
                                        <option class="address-type-subtitle">Delivery At</option>
                                        <option class="address-type-subtitle">Delivery By</option>
                                    </select>
                                </div>       
                            </div>                    
                        </div>
                        <?php include( "date_time.php" );?>                        
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
        </div>
    </div>
</div>

