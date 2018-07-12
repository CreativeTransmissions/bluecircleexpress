casper.test.begin('TransitQuote Pro Tests', 1, function suite(test) {
    casper.start('http://localhost/pro', function() {

    	testExistenceOfElements();

    });

	function testExistenceOfElements(){
		test.assertExists('form.tq-form', "main form is found");
		test.assertExists('form.tq-form input[name="first_name"]', 'First Name field is found.');
		test.assertExists('form.tq-form input[name="last_name"]', 'Last Name field is found.');
		test.assertExists('form.tq-form input[name="phone"]', 'phone field is found.');
		test.assertExists('form.tq-form input[name="email"]', 'email field is found.');
		test.assertExists('form.tq-form textarea[name="description"]', 'description field is found.');
		test.assertExists('form.tq-form input[name="collection_date"]', 'collection_date field is found.');
		test.assertExists('form.tq-form input[name="delivery_time"]', 'delivery_time field is found.');
		test.assertExists('form.tq-form select[name="service_id"]', 'service_id field is found.');
		test.assertExists('form.tq-form select[name="vehicle_id"]', 'vehicle_id field is found.');
		test.assertExists('form.tq-form input[name="address_0_address"]', 'address_0_address field is found.');
		test.assertExists('form.tq-form input[name="address_0_appartment_no"]', 'address_0_appartment_no field is found.');
		test.assertExists('form.tq-form input[name="address_0_postal_code"]', 'address_0_postal_code field is found.');
		test.assertExists('form.tq-form input[name="address_1_address"]', 'address_1_address field is found.');
		test.assertExists('form.tq-form input[name="address_1_appartment_no"]', 'address_1_appartment_no field is found.');
		test.assertExists('form.tq-form input[name="address_1_postal_code"]', 'address_1_postal_code field is found.');
		test.assertExists('form.tq-form input[name="tq-form-submit"]', 'submit button tq-form-submit is found.');
	}
 
  /*  casper.then(function() {
        test.assertTitle("casperjs - Recherche Google", "google title is ok");
        test.assertUrlMatch(/q=casperjs/, "search term has been submitted");
        test.assertEval(function() {
            return __utils__.findAll("h3.r").length >= 10;
        }, "google search for \"casperjs\" retrieves 10 or more results");
    });
*/
    casper.run(function() {
        test.done();
    });
});