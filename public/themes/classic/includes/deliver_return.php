
<div class="tq-row">
	<?php if($this->ask_for_date){ ?>    
		<div class="bt-flabels__wrapper half left">
			<label for="collection_date"><?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?></label>
			<input tabindex="6" data-parsley-trigger="select change" type="text" class="datepicker"  placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?>*"  name="collection_date" id="collection_date" required readonly="">
			<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_date_label', 'Collection Date'); ?></span>
		</div>
    <?php } ?>
	<?php if($this->ask_for_time){ ?>		
		<div class="bt-flabels__wrapper half right last-address-field">
			<label for="collection_time"><?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></label>
			<input tabindex="7" data-parsley-trigger="select change" type="text" class="timepicker" readonly="" placeholder="<?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?>*" name="delivery_time" id="collection_time" required>
			<span class="bt-flabels__error-desc">Required / Invalid <?php echo self::get_setting('tq_pro_form_options','collection_time_label', 'Collection Time'); ?></span>
		</div>
	<?php } ?>		
</div>
<?php
	switch ($this->show_deliver_and_return) {
		case 'Ask': ?>
		<div class="tq-row">
			<div class="tq-row bt-flabels__wrapper">
				<p class="radio-group-label">Deliver from collection to destination and then return to the collection address</p>
				    <input type="radio" id="deliver_and_return1" name="deliver_and_return" value="0" checked="checked" /><label for="one_way" class="radio-label" >One Way</label>
				    <input type="radio" id="deliver_and_return2" name="deliver_and_return" value="1"/><label for="deliver_and_return" class="radio-label">Deliver and Return</label>
			</div>
		</div> 
<?php  	break;
		case 'Always': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="1"/>
<?php  	break;
		case 'Never': ?>
		<input type="hidden" id="deliver_and_return" name="deliver_and_return" value="0"/>
<?php  	break;
	}; ?>
	