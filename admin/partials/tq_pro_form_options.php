<form id="form-option-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'tq_pro_form_options' ); ?>
	<?php do_settings_sections( 'tq_pro_form_options' ); ?>
	<?php submit_button(); ?>
</form>
