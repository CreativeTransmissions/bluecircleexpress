<div class="transit_inner"> <!-- Delivery Address section start here -->
    <div class="transit_header">
        <h2><?php echo $this->view_labels['map_title']; ?></h2>
    </div>
	<div class="map-ctr transit_body">
		 <div id="feedback" class="tq-feedback text-center" style="display: none;"></div>
	    <div id="map" class="map">
	    	<a href="//transitquote.co.uk/" target="_blank">Powered by TransitQuote</a>
	    </div>
	    <?php  
			include( "route_options.php" );
		?>
	</div>
</div>