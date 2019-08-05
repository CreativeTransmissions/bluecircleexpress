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

<div class="requestform round">

    <div class="spinner-div"> </div>
    <form id="quote-form" class="request-calc-form tq-form" autocomplete="off" data-parsley-errors-messages-disabled>
    <h3>Delivery Reference: <?php echo $this->job['id']; ?></h3>
	<div class="contact_details" >
    <?php
        $this->table_renderer->render(array('header'=>'Contact Details','data'=>$this->format_customer($this->job['customer']))); 
	?>
	</div>
	<div class="additional_information" >
	<?php
	if (!empty($this->format_job($this->job))) {
        $this->table_renderer->render(array('header'=>'Additional Information','data'=>$this->format_job($this->job))); 
	}
	?>
	</div>
	<?php
    $this->route_details_table();
?>
<table class="tq-quote-table">
    <tr><th colspan="2">Date and Time</th></tr>
    <tr><td>Collection Date</td><td><?php echo $this->job['job_date'][0]['value']; ?></td></tr>
    <tr><td>Collection Time</td><td><?php echo $this->job['job_date'][1]['value']; ?></td></tr>    
</table>
<?php

    if(isset($this->job['surcharges'])){
        $this->table_renderer->render(array('header'=>'Surcharges','data'=>$this->format_surcharges_web($this->job['surcharges']))); 
    };

    if(isset($quote_data)){
        print_r($quote_data);
        $this->table_renderer->render(array('header'=>'<h3>Quote</h3>', 'data'=>$quote_data)); 
    };

?>