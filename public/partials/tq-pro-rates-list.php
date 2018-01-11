<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * @package   TransitQuote
 * @author    Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @license   GPL-2.0+
 * @link      http://customgooglemaptools.com
 * @copyright 2015 Creative Transmissions
 */
?>
<div id="feedback"></div>
<div class="tq-pro-rates-list">
    <?php $rates_variations = $this->rates_list->get_rate_variations(); ?>
    <?php foreach ($rates_variations as $key => $varaition) {
            $this->rates_list->render_rates_list($varaition); 

    }; ?>
</div>