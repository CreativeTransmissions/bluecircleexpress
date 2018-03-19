<div class="transit_inner cost <?php echo $hide_section; ?> quote-fields"> <!-- Estimate cost section start here -->
    <div class="transit_header">   <!-- Delivery Address section start here -->
        <h2>Delivery Cost</h2>
    </div>
    <div class="transit_body">
        <span>ESTIMATE COST</span>
        <h3><span class="totalCost" ></span> <?php echo $this->currency_symbol; ?></h3>
        <ul>
            <li>Distance (<?php echo $this->distance_unit; ?>s): <span id="distance"></span></li>
            <li class="<?php echo $tax_hidden_class; ?>">Estimated Travel Time: <span id="hours"></span></li>
            <li class="<?php echo $tax_hidden_class; ?>">Short Notice Cost: <span class="noticeCost"></span><?php echo $this->currency_symbol; ?></li>
            <li class="field <?php echo $tax_hidden_class; ?>">Estimated Cost: <span class="basicCost"></span> <?php echo $this->currency_symbol; ?></li>
            <li class="<?php echo $tax_hidden_class; ?>">Tax: <span class="taxCost"></span> <?php echo $this->currency_symbol; ?></li>
            <!-- <li>Total Cost: <span class="totalCost" ></span> <?php //echo $this->currency_symbol; ?></li> -->
        </ul>

    </div>
</div>