<fieldset class="search-fields">
    <?php if($this->pick_start_address=='true') { ?>
    <legend>Delivery Addresses</legend>
        <div class="address-wrap">
            <div class="field bt-flabels__wrapper full-width">
                <label for="pick_up">Collection Address</label>
                <a href="#" class="no-address no-address-0">I can&apos;t find my address</a>
                <input tabindex="10" class="text addresspicker" required type="text" name="address_0_address" id="address_0" value="" autocomplete="false"/>
                <span class="bt-flabels__error-desc">Required: Collection Address</span>
            </div>
            <?php if($this->ask_for_unit_no){ ?>
            <div class="inline-block bt-flabels__wrapper half left">
                <input class="inline-block half-field" type="text" id="address_0_appartment_no" name="address_0_appartment_no" placeholder="Unit" value=""/>
            </div>
            <?php } ?>
            <?php if($this->ask_for_postcode){ ?>
            <div class="inline-block bt-flabels__wrapper half right last-address-field">
                <input class="inline-block postcode half-field half-field-right" type="text" id="address_0_postal_code" name="address_0_postal_code" placeholder="Postcode" value=""/>
            </div>
            <?php } ?>
        </div>
        <div class="address-wrap">
            <div class="field bt-flabels__wrapper full-width">
                <label for="drop_off">Destination Address</label>
                <a href="#" class="no-address no-address-1">I can&apos;t find my address</a>
                <input  tabindex="11" class="text addresspicker" required type="text" name="address_1_address" id="address_1" value="" autocomplete="false"/>
                <span class="bt-flabels__error-desc">Required: Destination Address</span>
            </div>
            <?php if($this->ask_for_unit_no){ ?>
            <div class="inline-block bt-flabels__wrapper half left">
                <input class="inline-block half-field " type="text" id="address_1_appartment_no" name="address_1_appartment_no" placeholder="Unit" value=""/>
            </div>
            <?php } ?>
            <?php if($this->ask_for_postcode){ ?>
            <div class="inline-block bt-flabels__wrapper half right last-address-field">
                <input class="inline-block postcode half-field half-field-right" type="text" id="address_1_postal_code" name="address_1_postal_code" placeholder="Postcode" value=""/>
            </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <legend>Delivery Addresses</legend>
        <div class="address-wrap">
            <div class="field bt-flabels__wrapper dest-only full-width">
                <label for="drop_off">Destination Address</label>
                <a href="#" class="no-address no-address-1">I can&apos;t find my address</a>
                <input tabindex="10" class="text addresspicker" required type="text" name="address_1_address" id="address_1" value="" autocomplete="false"/>
                <span class="bt-flabels__error-desc">Required: Destination Address</span>
            </div>
            <div class="inline-block bt-flabels__wrapper half left">
                <input class="inline-block half-field" type="text" id="address_1_appartment_no" name="address_1_appartment_no" placeholder="Unit" value=""/>
            </div>
            <div class="inline-block bt-flabels__wrapper half right last-address-field">
                <input class="inline-block postcode right half-field half-field-right" type="text" id="address_1_postal_code" name="address_1_postal_code" placeholder="Postcode" value=""/>
            </div>
        </div>    
    <?php }; ?>
</fieldset>