<div class="tq-row success  <?php echo $hide_section; ?> quote-fields" >
    <fieldset>
        <legend>Delivery Cost</legend>
        <p>All prices are subject to change depending on traffic, loading times and package size.</p>
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
            <span class="sub-total"><?php echo $this->currency_symbol; ?></span>
            <span class="sub-total noticeCost"></span>
            
        </div>
        <div class="field">
            <label class="" for="totalCost">Estimated Cost:</label>
            <span class="sub-total"><?php echo $this->currency_symbol; ?></span>
            <span class="sub-total quote" id="totalCost"></span>
        </div>      
    </fieldset>
</div>