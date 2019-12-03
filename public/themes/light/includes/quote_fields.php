<div class="transit_inner cost <?php echo $hide_section; ?> quote-fields">
    <div class="transit_header tq-form-title-color">  
        <h2><?php echo $this->view_labels['quote_section_title']; ?></h2>
    </div>
    <div class="transit_body quote-success tq-form-bg-color">
        <span><?php echo $this->view_labels['quote_label']; ?>
    </span>
        <h3><span class="quote-currency"><?php echo $this->currency_symbol; ?></span><span class="totalCost"></span>
        </h3>
        <ul>
            <li><?php echo $this->view_labels['distance']; ?> (<?php echo $this->distance_unit; ?>s): <span id="distance"></span></li>
            <li class="<?php echo $drive_time_hidden_class; ?>"><?php echo $this->view_labels['time']; ?>: <span id="hours"></span></li>
            <li class="hidden"><?php echo $this->view_labels['short_notice_cost_label']; ?>: <?php echo $this->currency_symbol; ?><span class="noticeCost"></span></li>
            <li>Weight Surcharge: <?php echo $this->currency_symbol; ?><span class="weightCost"></span></li>
            <li id="areaSurcharge-0" style="display: none;"><span class="area_surcharges_cost"></span>: <?php echo $this->currency_symbol; ?><span class="areaCost"></span></li>             
            <li class="field"><?php echo $this->view_labels['sub_total_label']; ?>: <?php echo $this->currency_symbol; ?><span class="basicCost"></span></li>
            <li class="<?php echo $tax_hidden_class; ?>"><?php echo $this->view_labels['tax_name']; ?>: <?php echo $this->currency_symbol; ?><span class="taxCost"></span></li>
          <!--  <li><span class="job-rate capitalize quote" id="jobRate"></span></li>-->
        </ul>
        <div class="quote-breakdown"></div>
    </div>
    <div class="transit_body quote-fail tq-warning tq-form-bg-color">
        <h3><span class="warning-phone">Sorry</span></h3>
        <ul>
            <li class="min-cost-msg" style="display: none;"><?php echo self::get_min_price_msg(); ?></li>
            <li class="min-distance-msg" style="display: none;"><?php echo self::get_min_distance_msg(); ?></li>
            <li class="max-distance-msg" style="display: none;"><?php echo self::get_max_distance_msg(); ?></li>
        </ul>
    </div>    
</div>