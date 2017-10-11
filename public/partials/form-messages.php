<div class="tq-row progress" style="display:none;">
	<h2>One moment please</h2><p>Sending request...</p>
</div>
<div class="tq-row success buttons" style="display:none;">
	<fieldset class="payment-options">
	    <legend>Payment Options</legend>
	    <?php echo self::get_payment_buttons(); ?>
	    <input type="hidden" name="job_id" value="<?php echo self::get_job_id(); ?>"/>
	 </fieldset>
</div>
<div class="tq-row failure" style="display:none;">
		<h2>Error!</h2><p>Sorry we were unable to save your request, please contact us above for assistance.</p>
</div>
<p class="min-cost-msg tq-warning" style="display: none;"><?php echo self::get_min_cost_msg(); ?></p>
<p class="min-distance-msg tq-warning" style="display: none;"><?php echo self::get_min_distance_msg(); ?></p>