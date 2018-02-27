<fieldset class="search-fields">
    <legend>Enter Addresses</legend>
    <div class="tq-row"> 
        <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
            <label for="pick_up"><?php echo self::get_setting('tq_pro_form_options','search_section_title', 'Enter Addresses'); ?></label>
            <input type="text" required id="moving-from" name="moving_from" class="popup-with-form moving-from" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'); ?>">
            <span class="bt-flabels__error-desc">Required <?php echo self::get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'); ?></span>
         </div>
        <div class="columns small-12 medium-6 bt-flabels__wrapper"> 
            <label for="drop_off"><?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?></label>
            <input type="text" required name="moving_to" id="moving-to"class="popup-with-form moving-to"  placeholder="<?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?>"><span class="bt-flabels__error-desc">Required <?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?></span>
        </div>
    </div>
</fieldset>