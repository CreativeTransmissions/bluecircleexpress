<div class="tq-row success  <?php echo $hide_section; ?> quote-fields" >
    <fieldset>
        <legend>Delivery Cost</legend>
        <div class="field">
            <label class="" for="distance">Distance (<?php echo $this->distance_unit; ?>s):</label>
            <span class="sub-total" id="distance"></span>
        </div>
        <div class="field <?php echo $drive_time_hidden_class; ?>">
            <label class="" for="time">Estimated Travel Time:</label>
            <span class="sub-total" id="time"></span>
        </div>
        <div class="field notice-field">
            <label class="" for="notice">Short Notice Cost:</label>
            <span class="sub-total"><?php echo $this->currency_symbol; ?></span>
            <span class="sub-total noticeCost"></span>
            
        </div>
        <div class="field <?php echo $tax_hidden_class; ?>">
            <label class="" for="basicCost">Estimated Cost:</label>
            <span class="sub-total"><?php echo $this->currency_symbol; ?></span>
            <span class="basicCost"></span>
        </div>
        <div class="field <?php echo $tax_hidden_class; ?>">
            <label class="" for="hours">Tax</label>
            <span class="taxCost"></span>
        </div>
        <div class="field">
            <label class="" for="totalCost">Total Cost:</label>
            <span class="sub-total"><?php echo $this->currency_symbol; ?></span>
            <span class="totalCost quote" id="totalCost"></span>
        </div> 
    </fieldset>
</div>