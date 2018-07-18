<div class="full">
	<div class="progress" style="display:none;">
		<h2>One moment please</h2><p>Sending request...</p>
	</div>
	<div class="failure" style="display:none;">
		<h2>Something went wrong.</h2><p>Sorry we were unable to save your request, please contact us for assistance with the error message below.</p>
		<p class="msg"></p>
	</div>
	<div class="success buttons" style="display:none;">
		<?php echo self::get_payment_buttons(); ?>
		<input type="hidden" name="job_id" value="<?php echo self::get_job_id(); ?>"/>
	</div>
	<p class="min-cost-msg tq-warning" style="display: none;"><?php echo self::get_min_price_msg(); ?></p>
	<p class="min-distance-msg tq-warning" style="display: none;"><?php echo self::get_min_distance_msg(); ?></p>
</div>