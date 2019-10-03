<?php if (($this->ask_for_weight)||($this->ask_for_customer_ref)) {?>
    <div class="tq-row transit_inner transit_body tq-form-bg-color">
         <?php if ($this->ask_for_weight) {?>
        <div class="left half bt-flabels__wrapper">
            <span class="sub_title"><i class="icon icon-icn-name"></i>Weight (<?php echo $this->weight_unit_name; ?>)</span>
            <input type="text" name="weight" data-parsley-maxlength="45" placeholder="Enter Weight (<?php echo $this->weight_unit_name; ?>)">
            <span class="bt-flabels__error-desc">Required / Invalid Weight</span>
        </div>
        <?php }; ?>
        <?php if ($this->ask_for_customer_ref) {?>
        <div class="right half bt-flabels__wrapper">
            <span class="sub_title"><i class="icon icon-icn-name"></i>Reference Number</span>
            <input type="text" name="customer_reference"  data-parsley-maxlength="45" placeholder="Enter Reference Number (If any)">
        </div>
         <?php }; ?>
    </div>
<?php }; ?>


