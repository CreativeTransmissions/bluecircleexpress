<div class="tq-row date-wrap optional-date-time" style="display: none;">
	<?php if($this->ask_for_date){ ?>    
	    <div class="coll_date_wrap bt-flabels__wrapper">
	    	<input name="delivery_date" id="delivery_date" data-parsley-trigger="select change" required readonly="" class="left collection_date dateclass placeholderclass datepicker" type="text" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Delivery Date'); ?>">
	    	<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Delivery Date'); ?></span>
	    </div>
    <?php } ?>
	<?php if($this->ask_for_time){ ?>
	    <div class="coll_time_wrap bt-flabels__wrapper">
	    	<input class="right collection_time dateclass placeholderclass timepicker" readonly="" type="text" data-parsley-trigger="select change" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Delivery Time'); ?>" name="delivery_time" id="delivery_time" required>
	    	<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Delivery Time'); ?></span>
	    </div>
	<?php } ?>
</div>  