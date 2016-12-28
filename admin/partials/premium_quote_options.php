<form id="quote-option-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'premium_quote_options' ); ?>
	<?php do_settings_sections( 'premium_quote_options' ); ?>
	<?php submit_button(); ?>
</form>
