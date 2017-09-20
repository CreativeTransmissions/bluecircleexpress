(function ( $ ) {
	"use strict";

	$(function () {
		$('#wpbody-content').transitQuotePremiumAdmin({
			ajaxUrl:ajaxurl,
			data: TransitQuotePremiumSettings
		});
	});

}(jQuery));