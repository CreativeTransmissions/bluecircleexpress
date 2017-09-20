<form id="email_options_form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'tq_pro_paypal_options' ); ?>
	<?php do_settings_sections( 'tq_pro_paypal_options' ); ?>
	<?php submit_button(); ?>
</form>	
