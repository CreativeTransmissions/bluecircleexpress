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

paypal.Button.render({

    env: 'sandbox', // sandbox | production

    // Show the buyer a 'Pay Now' button in the checkout flow
    commit: true,

    // payment() is called when the button is clicked
    payment: function() {

        // Set up a url on your server to create the payment
        var CREATE_URL = TransitQuotePremiumSettings.paypal.createPaymentUrl;

        // Make a call to your server to set up the payment
        return paypal.request.post(CREATE_URL)
            .then(function(res) {
                return res.payment_id;
            });
    },

    // onAuthorize() is called when the buyer approves the payment
    onAuthorize: function(data, actions) {
        console.log(data);

        // Set up a url on your server to execute the payment
        var EXECUTE_URL = TransitQuotePremiumSettings.paypal.executePaymentURL;

        // Set up the data you need to pass to your server
        var data = {
            paymentID: data.paymentID,
            payerID: data.payerID
        };

        // Make a call to your server to execute the payment
        return paypal.request.post(EXECUTE_URL, data)
            .then(function (res) {
                window.alert('Payment Complete!');
            });
    }

}, '#paypal-button-container');


}(jQuery));
