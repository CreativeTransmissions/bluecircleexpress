<div class="map-ctr">
	<?php $map_title = self::get_setting('tq_pro_form_options','map_title', '');
	if(!empty($map_title)){ ?>
    	<legend><?php echo $map_title; ?></legend>
	<?php }; ?>
    <div id="map" class="map">
    	<a href="//transitquote.co.uk/" target="_blank">Powered by TransitQuote</a>
    </div>
    <div id="feedback"></div>
</div>
