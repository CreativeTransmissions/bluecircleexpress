<div class="transit_inner cost <?php echo $hide_section; ?> quote-fields"> <!-- Estimate cost section start here -->
    <div class="transit_header">   <!-- Delivery Address section start here -->
        <h2>Delivery Cost</h2>
    </div>
    <div class="transit_body">
        <span>Our Quote</span>
        <h3><?php echo $this->currency_symbol; ?><span class="totalCost" ></span></h3>
        <ul>
            <li>Distance (<?php echo $this->distance_unit; ?>s): <span id="distance"></span></li>
            <li class="<?php echo $drive_time_hidden_class; ?>">Estimated Travel Time: <span id="time"></span></li>
            <li class="hidden">Short Notice Cost: <?php echo $this->currency_symbol; ?><span class="noticeCost"></span></li>
            <li class="field">Delivery Cost: <?php echo $this->currency_symbol; ?><span class="basicCost"></span></li>
            <li class="<?php echo $tax_hidden_class; ?>">Tax: <?php echo $this->currency_symbol; ?><span class="taxCost"></span></li>
        </ul>

    </div>
</div>