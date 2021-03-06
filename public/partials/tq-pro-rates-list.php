<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * @package   TransitQuote
 * @author    Andrew van Duivenbode <hq@transitquote.co.uk>
 * @license   GPL-2.0+
 * @link      http://transitquote.co.uk
 * @copyright 2015 Creative Transmissions
 */
?>
<div id="feedback"></div>
<div class="tq-pro-rates-list">
    <?php $rates_variations = $this->get_rate_variations(); ?>
    <?php foreach ($rates_variations as $key => $varaition) { ?>

    	<div class="rates-list">
    		<h3>Rates for:<br/>Service: <?php echo $varaition['service_name'] ?><br/>Vehicle:<?php echo $varaition['vehicle_name']; ?></h3>
           <?php echo $this->render_rates_list($varaition); ?>
        </div>

<?php }; ?>
</div>