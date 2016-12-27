<form id="email_options_form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'email_options' ); ?>
	<?php do_settings_sections( 'email_options' ); ?>
	<?php submit_button(); ?>
</form>	
