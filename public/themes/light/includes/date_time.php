<div class="date-wrap">
	<?php if($this->ask_for_date){ ?>    
	    <div class="coll_date_wrap bt-flabels__wrapper">
	    	<label for="date">
	    		<i class="icon icon-icn-date"></i>
	    		<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?>
	    	</label>
	    	<input name="date" id="date" data-parsley-trigger="select change" required readonly="" class="left collection_date dateclass placeholderclass datepicker" type="text" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?>"/>
	    	<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Time'); ?></span>
	    </div>
    <?php } ?>
	<?php if($this->ask_for_time){ ?>
	    <div class="coll_time_wrap bt-flabels__wrapper">
	    	<label for="delivery_time">
	    			<i class="icon icon-icn-time"></i>
	    			<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?>
	    	</label>
	    	<input class="right collection_time dateclass placeholderclass timepicker" readonly="" type="text" data-parsley-trigger="select change" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?>" name="delivery_time" id="delivery_time" required/>
	    	<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></span>
	    </div>
	<?php } ?>
</div>  