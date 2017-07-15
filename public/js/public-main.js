(function ( $ ) {
	"use strict";
	// Code by AS
	$(function () {
		if($('#quote-form').length>0){
			$('#quote-form').TransitQuotePremium({
				ajaxUrl: TransitQuotePremiumSettings.ajaxurl,
				data: TransitQuotePremiumSettings,
			});
		}

	});
	$(function() {
		if($('#quote-form').length>0){
		//for validator
			$('#quote-form').parsley().on('form:error', function () {
	            $.each(this.fields, function (key, field) {
	                if (field.validationResult !== true) {
	                    field.$element.closest('.bt-flabels__wrapper').addClass('bt-flabels__error');
	                }
	            });
	        });
	        $('#quote-form').parsley().on('field:validated', function () {
	            if (this.validationResult === true) {
	                this.$element.closest('.bt-flabels__wrapper').removeClass('bt-flabels__error');
	            } else {
	                this.$element.closest('.bt-flabels__wrapper').addClass('bt-flabels__error');
	            }
	        });	
        }	

 	});

}(jQuery));
