(function ( $ ) {
	"use strict";

	$(function () {
		$('#wpbody-content').wpSellSoftwareAdmin({
			ajaxUrl:ajaxurl,
			data: TransitQuotePremiumSettings
		});
	});

}(jQuery));