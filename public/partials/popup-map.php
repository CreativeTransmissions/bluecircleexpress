<div id="address-popup" class="mfp-hide white-popup-block">
    <h3 class="heading-popup"><?php echo self::get_setting('tq_pro_form_options','map_title', 'Address Locations'); ?></h3>
    <div class="tq-row">
        <div class="moving-from-div">
            <input type="text" id="address_0" name="address_0" class="addresspicker columns " placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_address_label', 'Collection Address'); ?>"> 
            <a href="#" class="no-address no-address-0">I can&#39;t find my address</a>
        </div>
        <div class="moving-to-div">
            <input type="text" id="address_1" name="address_1" class="addresspicker columns " placeholder="<?php echo self::get_setting('tq_pro_form_options','destination_address_label', 'Destination Address'); ?>">
            <a href="#" class="no-address no-address-1">I can&#39;t find my address</a>
        </div>

    </div>   
    <div class="tq-row">
        <div id ="map"></div>
    </div>
    <input type="hidden" name="distance" value=""/>
    <input class="hours" type="hidden" name="time" value=""/>
    <div style="clear: left; text-align: center;"><input type="button" class="tq-button" name="addresses-ok" value="Addresses Are Correct"/></div>
</div>