<div class="tq-row progress" style="display:none;">
	<h2>One moment</h2><p>Sending request...</p>
</div>
<div class="tq-row success" style="display:none;">
    <h2>Payment Options</h2><p><?php echo self::get_success_message(); ?></p>
    <?php echo self::get_payment_buttons(); ?>
    <input type="hidden" name="job_id" value="<?php echo self::get_job_id(); ?>"/>
    <input type="hidden" name="return_url" value="<?php echo self::get_return(); ?>"/>
</div>
<div class="tq-row failure" style="display:none;">
		<h2>Error!</h2><p>Sorry we were unable to send your move request, please call us on one of the numbers above for assistance.</p>
</div>
