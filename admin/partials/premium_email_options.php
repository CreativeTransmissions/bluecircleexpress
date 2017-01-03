<form id="email_options_form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'premium_email_options' ); ?>
	<?php do_settings_sections( 'premium_email_options' ); ?>
	<?php submit_button(); ?>
</form>	
