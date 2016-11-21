<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Balance_Voucher
 * @subpackage WP_Balance_Voucher/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        <?php self::plugin_options_tabs(); ?>
        <?php include_once $this->current_tab.'.php'; ?>
</div>
