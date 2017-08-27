/*==============================================================================*/
/* Casper generated Sun Aug 27 2017 11:35:29 GMT+0100 (GMT Daylight Time) */
/*==============================================================================*/

var x = require('casper').selectXPath;
casper.options.viewportSize = {width: 1536, height: 618};
casper.on('page.error', function(msg, trace) {
   this.echo('Error: ' + msg, 'ERROR');
   for(var i=0; i<trace.length; i++) {
       var step = trace[i];
       this.echo('   ' + step.file + ' (line ' + step.line + ')', 'ERROR');
   }
});
casper.test.begin('Resurrectio test', function(test) {
   casper.start('http://localhost/demo/transitquote-premium-demo/');
   casper.waitForSelector("form#quote-form input[name='first_name']",
       function success() {
           test.assertExists("form#quote-form input[name='first_name']");
           this.click("form#quote-form input[name='first_name']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='first_name']");
   });
   casper.waitForSelector("input[name='first_name']",
       function success() {
           this.sendKeys("input[name='first_name']", "tester1");
       },
       function fail() {
           test.assertExists("input[name='first_name']");
   });
   casper.waitForSelector("input[name='last_name']",
       function success() {
           this.sendKeys("input[name='last_name']", "tester1snmae");
       },
       function fail() {
           test.assertExists("input[name='last_name']");
   });
   casper.waitForSelector("input[name='phone']",
       function success() {
           this.sendKeys("input[name='phone']", "1234567890");
       },
       function fail() {
           test.assertExists("input[name='phone']");
   });
   casper.waitForSelector("form#quote-form input[name='email']",
       function success() {
           test.assertExists("form#quote-form input[name='email']");
           this.click("form#quote-form input[name='email']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='email']");
   });
   casper.waitForSelector("input[name='email']",
       function success() {
           this.sendKeys("input[name='email']", "rtyrty'ertrt.com@asdf");
       },
       function fail() {
           test.assertExists("input[name='email']");
   });
   casper.waitForSelector("#description",
       function success() {
           test.assertExists("#description");
           this.click("#description");
       },
       function fail() {
           test.assertExists("#description");
   });
   casper.waitForSelector("textarea[name='description']",
       function success() {
           this.sendKeys("textarea[name='description']", "stuff");
       },
       function fail() {
           test.assertExists("textarea[name='description']");
   });
   casper.waitForSelector("form#quote-form input[name='collection_date']",
       function success() {
           test.assertExists("form#quote-form input[name='collection_date']");
           this.click("form#quote-form input[name='collection_date']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='collection_date']");
   });
   casper.waitForSelector(x("//a[normalize-space(text())='Next']"),
       function success() {
           test.assertExists(x("//a[normalize-space(text())='Next']"));
           this.click(x("//a[normalize-space(text())='Next']"));
       },
       function fail() {
           test.assertExists(x("//a[normalize-space(text())='Next']"));
   });
   casper.waitForSelector(x("//a[normalize-space(text())='Next']"),
       function success() {
           test.assertExists(x("//a[normalize-space(text())='Next']"));
           this.click(x("//a[normalize-space(text())='Next']"));
       },
       function fail() {
           test.assertExists(x("//a[normalize-space(text())='Next']"));
   });
   casper.waitForSelector("form#quote-form input[name='delivery_time']",
       function success() {
           test.assertExists("form#quote-form input[name='delivery_time']");
           this.click("form#quote-form input[name='delivery_time']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='delivery_time']");
   });
   casper.waitForSelector("#ui-datepicker-div",
       function success() {
           test.assertExists("#ui-datepicker-div");
           this.click("#ui-datepicker-div");
       },
       function fail() {
           test.assertExists("#ui-datepicker-div");
   });
   casper.waitForSelector(".ui-datepicker-close.ui-state-default.ui-priority-primary.ui-corner-all.ui-state-hover",
       function success() {
           test.assertExists(".ui-datepicker-close.ui-state-default.ui-priority-primary.ui-corner-all.ui-state-hover");
           this.click(".ui-datepicker-close.ui-state-default.ui-priority-primary.ui-corner-all.ui-state-hover");
       },
       function fail() {
           test.assertExists(".ui-datepicker-close.ui-state-default.ui-priority-primary.ui-corner-all.ui-state-hover");
   });
   casper.waitForSelector("#service_id",
       function success() {
           test.assertExists("#service_id");
           this.click("#service_id");
       },
       function fail() {
           test.assertExists("#service_id");
   });
   casper.waitForSelector("#vehicle_id",
       function success() {
           test.assertExists("#vehicle_id");
           this.click("#vehicle_id");
       },
       function fail() {
           test.assertExists("#vehicle_id");
   });
   casper.waitForSelector("form#quote-form input[name='address_0_address']",
       function success() {
           test.assertExists("form#quote-form input[name='address_0_address']");
           this.click("form#quote-form input[name='address_0_address']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_0_address']");
   });
   casper.waitForSelector("input[name='address_0_address']",
       function success() {
           this.sendKeys("input[name='address_0_address']", "457");
       },
       function fail() {
           test.assertExists("input[name='address_0_address']");
   });
   casper.waitForSelector("form#quote-form input[name='address_0_appartment_no']",
       function success() {
           test.assertExists("form#quote-form input[name='address_0_appartment_no']");
           this.click("form#quote-form input[name='address_0_appartment_no']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_0_appartment_no']");
   });
   casper.waitForSelector("input[name='address_0_appartment_no']",
       function success() {
           this.sendKeys("input[name='address_0_appartment_no']", "1m");
       },
       function fail() {
           test.assertExists("input[name='address_0_appartment_no']");
   });
   casper.waitForSelector("form#quote-form input[name='address_2_address']",
       function success() {
           test.assertExists("form#quote-form input[name='address_2_address']");
           this.click("form#quote-form input[name='address_2_address']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_2_address']");
   });
   casper.waitForSelector("input[name='address_2_address']",
       function success() {
           this.sendKeys("input[name='address_2_address']", "46");
       },
       function fail() {
           test.assertExists("input[name='address_2_address']");
   });
   casper.waitForSelector("form#quote-form input[name='address_2_appartment_no']",
       function success() {
           test.assertExists("form#quote-form input[name='address_2_appartment_no']");
           this.click("form#quote-form input[name='address_2_appartment_no']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_2_appartment_no']");
   });
   casper.waitForSelector("input[name='address_2_appartment_no']",
       function success() {
           this.sendKeys("input[name='address_2_appartment_no']", "56-2");
       },
       function fail() {
           test.assertExists("input[name='address_2_appartment_no']");
   });
   casper.waitForSelector("form#quote-form input[name='address_1_address']",
       function success() {
           test.assertExists("form#quote-form input[name='address_1_address']");
           this.click("form#quote-form input[name='address_1_address']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_1_address']");
   });
   casper.waitForSelector("input[name='address_1_address']",
       function success() {
           this.sendKeys("input[name='address_1_address']", "987");
       },
       function fail() {
           test.assertExists("input[name='address_1_address']");
   });
   casper.waitForSelector("form#quote-form input[name='address_1_appartment_no']",
       function success() {
           test.assertExists("form#quote-form input[name='address_1_appartment_no']");
           this.click("form#quote-form input[name='address_1_appartment_no']");
       },
       function fail() {
           test.assertExists("form#quote-form input[name='address_1_appartment_no']");
   });
   casper.waitForSelector("input[name='address_1_appartment_no']",
       function success() {
           this.sendKeys("input[name='address_1_appartment_no']", "6");
       },
       function fail() {
           test.assertExists("input[name='address_1_appartment_no']");
   });
   casper.waitForSelector("form#quote-form input[type=submit][value='Get Estimate']",
       function success() {
           test.assertExists("form#quote-form input[type=submit][value='Get Estimate']");
           this.click("form#quote-form input[type=submit][value='Get Estimate']");
       },
       function fail() {
           test.assertExists("form#quote-form input[type=submit][value='Get Estimate']");
   });
   casper.waitForSelector("form#quote-form button[type=submit][value='pay_method_2']",
       function success() {
           test.assertExists("form#quote-form button[type=submit][value='pay_method_2']");
           this.click("form#quote-form button[type=submit][value='pay_method_2']");
       },
       function fail() {
           test.assertExists("form#quote-form button[type=submit][value='pay_method_2']");
   });
   casper.waitForSelector("form[name=confirm] input[type=submit][value='Pay Now']",
       function success() {
           test.assertExists("form[name=confirm] input[type=submit][value='Pay Now']");
           this.click("form[name=confirm] input[type=submit][value='Pay Now']");
       },
       function fail() {
           test.assertExists("form[name=confirm] input[type=submit][value='Pay Now']");
   });

   casper.run(function() {test.done();});
});