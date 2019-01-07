<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationTest extends TestCase
{
	protected function setUp()
    {
        parent::setUp();
        $this->default_config = array('distance'=>0,
                                    'return_distance'=>0,
                                    'return_percentage'=>100,
                                    'return_time'=>0,
                                    'time_mins'=>0,
                                    'rates'=>array(),
                                    'include_return_journey'=>false,
                                    'boundary_mode'=>'final',
                                    'rouunding_type'=>'Round to 2 decimal points',
                                    'tax_name'=>'',
                                    'tax_rate'=>0);

        $this->test_rates = array();
        $this->test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","additional_stop":"10.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-05 08:05:54","modified":"2018-10-05 08:05:54"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"},{"id":"18","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"46.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 18:14:55","modified":"2018-10-04 18:14:55"}],"hours":"1.15","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"46.69","return_percentage":"100","return_distance":"21.12","return_time":"0.45","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

    }
   

    public function testInitCalculation() {
        $calculator = new TransitQuote_Pro4\TQ_Calculation($this->default_config);

        $calculator->init_calculation();
        $this->assertContains('rates', $calculator->config, 'testInitCalculation error: config has no rates element');
        $this->assertContains('tax_name', $calculator->config, 'testInitCalculation error: config not merged');
    }

    public function testConfigNotEmpty() {
        $calculator = new TransitQuote_Pro4\TQ_Calculation($this->default_config);
        $calculator->init_calculation();
        $this->assertNotEmpty($calculator->config, 'testInitCalculation error: config is empty');
    }

    public function testConfigHasProperties() {
        $calculator = new TransitQuote_Pro4\TQ_Calculation($this->default_config);
        $calculator->init_calculation();
        $this->assertContains('rates', $calculator->config, 'testInitCalculation error: config has no rates element');
    }

    public function testRatesNotEmpty() {
        $calculator = new TransitQuote_Pro4\TQ_Calculation($this->test_config);
        $calculator->init_calculation();
        $this->assertNotEmpty($calculator->config['rates'], 'testInitCalculation error: rates array is empty');
    }

    public function testChargingForDestinationOk(){
         $test_config = array_merge($this->test_config, array(  
                                                        'charge_from_stop'=>0,
                                                         'stops'=>array(0,1,2,3)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertTrue($calculator->charging_for_destinations(), 'returns false in error');        
    }

    public function testChargingForDestinationNoRate(){
         $test_config = array_merge($this->test_config, array(
                                                                    'charge_from_stop'=>0,
                                                                     'stops'=>array(0,1,2,3)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $calculator->max_distance_rate['additional_stop'] = '';
        $this->assertFalse($calculator->charging_for_destinations());        
    }


    public function testChargingForDestinationNoStops(){
         $test_config = array_merge($this->test_config, array(
                                                                    'charge_from_stop'=>4,
                                                                     'stops'=>array()));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertFalse($calculator->charging_for_destinations());        
    }      

    public function testChargingForDestinationInvalidStops(){
         $test_config = array_merge($this->test_config, array( 
                                                                    'charge_from_stop'=>4,
                                                                     'stops'=>null));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertFalse($calculator->charging_for_destinations());        
    }

    public function testDChargingForDestinationInvalidChargeFromStops(){
         $test_config = array_merge($this->test_config, array( 
                                                                    'charge_from_stop'=>'zzz',
                                                                     'stops'=>null));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertFalse($calculator->charging_for_destinations());        
    }

    public function testDestinationsChargeableOk(){
         $test_config = array_merge($this->test_config, array(   'additional_stop_rate'=>100,
                                                                    'charge_from_stop'=>2,
                                                                     'stops'=>array(0,1,2,3)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertTrue($calculator->destinations_are_chargeable());        
    }

    public function testDestinationsChargeableTooFewStops(){
         $test_config = array_merge($this->test_config, array(   'additional_stop_rate'=>100,
                                                                    'charge_from_stop'=>20,
                                                                     'stops'=>array(1,2,3,4)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertFalse($calculator->destinations_are_chargeable());        
    }      


    public function testGetNoStopsToChargeForOk(){
         $test_config = array_merge($this->test_config, array(   'additional_stop_rate'=>100,
                                                                    'charge_from_stop'=>3,
                                                                     'stops'=>array(1,2,3,4)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertEquals($calculator->get_no_stops_to_charge_for(), 2);        
    }

    public function testGetNoStopsToChargeForTooFewStops(){
         $test_config = array_merge($this->test_config, array(   'additional_stop_rate'=>100,
                                                                    'charge_from_stop'=>2,
                                                                     'stops'=>array(0)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertEquals($calculator->get_no_stops_to_charge_for(), 0);        
    }      

    public function test_calc_extra_destination_surcharge_ok(){
         $test_config = array_merge($this->test_config, array( 
                                                                    'charge_from_stop'=>1,
                                                                     'stops'=>array(1,2,3,4,5)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertEquals($calculator->calc_extra_destination_surcharge(), 50);        
    }

    public function test_calc_extra_destination_surcharge_from_3(){
         $test_config = array_merge($this->test_config, array(
                                                                    'charge_from_stop'=>3,
                                                                     'stops'=>array(1,2,3,4,5)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertEquals($calculator->calc_extra_destination_surcharge(), 30);        
    }

    public function test_add_extra_destination_surcharge(){
         $test_config = array_merge($this->test_config, array( 
                                                                    'charge_from_stop'=>3,
                                                                     'stops'=>array(1,2,3,4,5)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $calculator->basic_cost = 10;
        $calculator->add_extra_destination_surcharge();
        $this->assertEquals($calculator->basic_cost, 40);        
    }     

    public function test_add_extra_destination_surcharge_one_stop(){
         $test_config = array_merge($this->test_config, array(
                                                                    'charge_from_stop'=>5,
                                                                     'stops'=>array(1,2,3,4,5)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $calculator->basic_cost = 10;
        $calculator->add_extra_destination_surcharge();
        $this->assertEquals($calculator->basic_cost, 20);        
    }

    public function test_add_extra_destination_surcharge_too_few_stops(){
         $test_config = array_merge($this->test_config, array(  
                                                                    'charge_from_stop'=>6,
                                                                     'stops'=>array(1,2,3,4,5)));

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $calculator->basic_cost = 10;
        $calculator->add_extra_destination_surcharge();
        $this->assertEquals($calculator->basic_cost, 10);        
    }

    public function test_using_different_rate_for_return_journey(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $using_different_rate_for_return_journey =  $calculator->using_different_rate_for_return_journey();
        $this->assertEquals($using_different_rate_for_return_journey,false);
    }

    public function test_get_highest_rate_idx(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $hightest_rate_idx =  $calculator->get_highest_rate_idx();
        $this->assertEquals($hightest_rate_idx,3);
    }

    public function test_get_highest_rate(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $hightest_rate =  $calculator->get_highest_rate();
        $this->assertEquals($hightest_rate['id'],17);
        $this->assertEquals($hightest_rate['amount'],62);        
    }

    public function test_get_highest_distance_boundary(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $highest_distance_boundary =  $calculator->get_highest_distance_boundary();
        $this->assertEquals($highest_distance_boundary,75);   
    }

    public function test_including_return_journey(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $calculator->init_calculation();
        $this->assertEquals($calculator->including_return_journey(),true, 'including_return_journey ok');
        
    }

    public function test_route_service_1_122km(){

        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:03","modified":"2018-10-04 13:09:03"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.79","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"122.62","return_percentage":"100","return_distance":"37.20","return_time":"0.53","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals($quote['distance'],122.62, 'quote returns different distance');

        $this->assertEquals($quote['return_distance'],37.20, 'quote returns different distance');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');

        $this->assertEquals($calculator->set_amount, 62, ' set amount is correct');  

         
        $this->assertEquals($calculator->basic_cost, 81.048, ' basic cost is correct');  

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate used for final rate as over highest distance boundary');
    }

    public function test_within_last_distance_boundary(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 15:43:12","modified":"2018-10-04 15:43:12"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"1.24","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"61.94","return_percentage":"100","return_distance":"34.03","return_time":"0.47","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');
        $this->assertEquals($quote['distance'],61.94, 'quote returns different distance');

        $this->assertEquals($quote['return_distance'],34.03, 'quote returns different distance');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');


        $this->assertEquals($calculator->set_amount, 62, ' set amount is correct');  

         
        $this->assertEquals($calculator->basic_cost, 62, ' basic cost is correct');  

        $this->assertEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate used for final rate as over highest distance boundary');                
    }

    public function test_within_first_distance_boundary(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 15:43:12","modified":"2018-10-04 15:43:12"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"0.37","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"11.40","return_percentage":"100","return_distance":"5.11","return_time":"0.17","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');
        $this->assertEquals($quote['distance'],11.40, 'quote returns different distance');


        $this->assertEquals($calculator->set_amount, 39, ' set amount is correct');  

         
        $this->assertEquals($calculator->basic_cost, 39, ' basic cost is correct');  

        $this->assertEquals($quote['total_before_rounding'], $calculator->basic_cost+8.19);

        $this->assertNotEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is not final rate we are within distance boundary');

        $this->assertEquals($calculator->total, 47.19);


    }


    public function test_within_second_distance_boundary(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 15:43:12","modified":"2018-10-04 15:43:12"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"}],"hours":"0.89","additional_stop_rate":"10","charge_from_stop":"4","stops":["0","1","2"],"include_return_journey":true,"distance":"41.60","return_percentage":"100","return_distance":0,"return_time":0,"tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');


        $this->assertEquals($calculator->set_amount, 47, ' set amount is correct');  

         
        $this->assertEquals($calculator->basic_cost, 47, ' basic cost is correct');  

        $this->assertEquals($quote['total'], 56.87, ' total_cost correct');

        $this->assertNotEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is not final rate we are within distance boundary');                
    }        

    public function test_run(){
      
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"1","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"2.00","hour":"0.00","created":"2018-10-10 08:06:36","modified":"2018-10-10 08:06:36"}],"include_return_journey":false,"distance":"175.19","return_percentage":"100","hours":"2.04","return_distance":0,"return_time":0,"tax_rate":"0","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}', true);
        print_r($test_config);
        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();
        $this->assertTrue(is_array($calculator->config), 'config is not an array');
        $this->assertContains('rates', $calculator->config, 'test_run error: config has no rates element');
        $this->assertNotEmpty($calculator->config['rates'], 'test_run error: rates config element is empty');
        $this->assertNotEmpty($calculator->rates, 'test_run error: rates prop element is empty');


        $this->assertEquals(true, is_array($quote), 'quote result not an array');
        $this->assertEquals(175.19, $calculator->distance , 'distance prop is not 175.19');
        $this->assertEquals(175.19, $calculator->full_distance, ' full distance prop is not 175.19');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');

        $this->assertNotFalse($calculator->final_rate, 'final rate is false');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');        
        $this->assertNotEquals( 0,$calculator->final_rate['unit'], 'unit rate is 0');
        $this->assertEquals(350.38,$calculator->distance_cost,' calculator->distance_cost result is wrong');        
        $this->assertEquals(350.38,$calculator->basic_cost,' calculator->basic_cost result is wrong');
        $this->assertEquals(350.38,$calculator->total,' calculator->total  is wrong');

        $this->assertGreaterThan(0, $quote['total'],' quote total result is 0');
        $this->assertEquals(350.38,$quote['total'],' quote total result is wrong');

    }

    public function test_run_with_tax(){
      
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"1","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"2.00","hour":"0.00","created":"2018-10-10 08:06:36","modified":"2018-10-10 08:06:36"}],"include_return_journey":false,"distance":"175.19","return_percentage":"100","hours":"2.04","return_distance":0,"return_time":0,"tax_rate":"20","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}', true);

        // tax percentage 20
        // tax amount 70.08
        // total 420.456
        // total rounded 420.46

            $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();
        $this->assertTrue(is_array($calculator->config), 'config is not an array');
        $this->assertContains('rates', $calculator->config, 'test_run error: config has no rates element');
        $this->assertNotEmpty($calculator->config['rates'], 'test_run error: rates config element is empty');
        $this->assertNotEmpty($calculator->rates, 'test_run error: rates prop element is empty');


        $this->assertEquals(true, is_array($quote), 'quote result not an array');
        $this->assertEquals(175.19, $calculator->distance , 'distance prop is not 175.19');
        $this->assertEquals(175.19, $calculator->full_distance, ' full distance prop is not 175.19');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');

        $this->assertNotFalse($calculator->final_rate, 'final rate is false');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');        
        $this->assertNotEquals( 0,$calculator->final_rate['unit'], 'unit rate is 0');
        $this->assertEquals(350.38,$calculator->distance_cost,' calculator->distance_cost result is wrong');        
        $this->assertEquals(350.38,$calculator->basic_cost,' calculator->basic_cost result is wrong');
        $this->assertEquals(420.46,$calculator->total,' calculator->total  is wrong');
        $this->assertEquals(70.08,$calculator->tax_cost,' calculator->total  is wrong');

        $this->assertGreaterThan(0, $quote['total'],' quote total result is 0');
        $this->assertEquals(420.46,$quote['total'],' quote total result is wrong');

    }     

    public function test_run_with_hourly_and_tax(){
      
        $test_config = json_decode('{"debugging":false,"rates":[{"id":"1","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"0.00","unit":"2.00","hour":"50.00","created":"2018-10-10 08:06:36","modified":"2018-10-10 08:06:36"}],"include_return_journey":false,"distance":"175.19","return_percentage":"100","hours":"2.04","return_distance":0,"return_time":0,"tax_rate":"20","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}', true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();
        $this->assertTrue(is_array($calculator->config), 'config is not an array');
        $this->assertContains('rates', $calculator->config, 'test_run error: config has no rates element');
        $this->assertNotEmpty($calculator->config['rates'], 'test_run error: rates config element is empty');
        $this->assertNotEmpty($calculator->rates, 'test_run error: rates prop element is empty');


        $this->assertEquals(true, is_array($quote), 'quote result not an array');
        $this->assertEquals(175.19, $calculator->distance , 'distance prop is not 175.19');
        $this->assertEquals(175.19, $calculator->full_distance, ' full distance prop is not 175.19');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');

        $this->assertNotFalse($calculator->final_rate, 'final rate is false');
        $this->assertTrue(is_array($calculator->final_rate), 'final rate is not an array');        
        $this->assertNotEquals( 0,$calculator->final_rate['unit'], 'unit rate is 0');
        $this->assertEquals(350.38,$calculator->distance_cost,' calculator->distance_cost is wrong');       

        $this->assertEquals(102,$calculator->time_cost,' calculator->time_cost is wrong');

        $this->assertEquals(452.38,$calculator->basic_cost,' calculator->basic_cost result is wrong');
        $this->assertEquals(90.48,$calculator->tax_cost,' calculator->total  is wrong');

        $this->assertEquals(542.86,$calculator->total,' calculator->total  is wrong');
        $this->assertEquals(542.86,$quote['total'],' quote total result is wrong');

    }     
}