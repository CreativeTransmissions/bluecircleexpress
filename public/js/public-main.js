window.addEventListener("error", function (e) {
   console.log("Error occurred: " + e.error.message);
   return false;
}, true);

(function ( $ ) {
	"use strict";

	$(document).on({
    'DOMNodeInserted': function() {
        $('.pac-item, .pac-item span', this).addClass('needsclick');
    	}
	}, '.pac-container');

	// Code by AS
	$(function () {
		if($('#quote-form').length>0){

			$('#quote-form').TransitQuotePro({
				ajaxUrl: TransitQuoteProSettings.ajaxurl,
				data: TransitQuoteProSettings,
			});
		}

	});


}(jQuery));
