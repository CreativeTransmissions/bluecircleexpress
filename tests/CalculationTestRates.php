<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;



final class CalculationTestRates extends TestCase
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

    public function test_with_additional_stop(){
        $test_config = json_decode('{"debugging":true,"rates":[{"id":"5","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"0.00","amount":"62.00","unit":"0.40","hour":"0.00","additional_stop":"10.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-05 08:05:54","modified":"2018-10-05 08:05:54"},{"id":"15","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"39.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:26","modified":"2018-10-04 13:09:26"},{"id":"16","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"50.00","amount":"47.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:09:57","modified":"2018-10-04 13:09:57"},{"id":"17","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"75.00","amount":"62.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 13:10:34","modified":"2018-10-04 13:10:34"},{"id":"18","service_id":"1","vehicle_id":"1","journey_length_id":"1","distance":"25.00","amount":"46.00","unit":"0.00","hour":"0.00","additional_stop":"0.00","daily_hire_rate":"0.00","hourly_hire_rate":"0.00","created":"2018-10-04 18:14:55","modified":"2018-10-04 18:14:55"}],"hours":"1.15","charge_from_stop":"4","stops":["0","1","2","3"],"include_return_journey":true,"distance":"46.69","return_percentage":"100","return_distance":"21.12","return_time":"0.45","tax_rate":"21","tax_name":"VAT","rounding_type":"Round to 2 decimal points"}',true);

        $calculator = new TransitQuote_Pro4\TQ_Calculation($test_config);
        $quote = $calculator->run();

        $this->assertEquals(true, is_array($quote), 'quote result not an array');

        $this->assertEquals($quote['distance'],$quote['outward_distance']+$quote['return_distance'], 'distance = outward_distance('.$quote['outward_distance'].') + return_distance('.$quote['return_distance'].')');


        $this->assertEquals($calculator->set_amount, 47, ' set amount is correct');  
        $this->assertEquals($calculator->destinations_are_chargeable(), true, ' destinations_are_chargeable not returning true');
        $this->assertEquals($calculator->charging_for_destinations(), true, 'charging_for_destinations returning false');
        $this->assertEquals($calculator->max_distance_rate_not_empty(), true, 'max_distance_rate_not_empty returning false');        
        $this->assertEquals($calculator->no_stops_to_charge_for, 1, ' no_stops_to_charge_for ('.$calculator->no_stops_to_charge_for.') <> 1');  
        $this->assertEquals($calculator->extra_destination_surcharge, 10, 'extra_destination_surcharge('.$calculator->extra_destination_surcharge.') <> 10');         
        $this->assertEquals($calculator->basic_cost, 57, ' basic cost ('.$calculator->basic_cost.') <> 57');  

        $this->assertEquals($quote['total'], 68.97, ' total_cost correct');

        $this->assertNotEquals($calculator->max_distance_rate['amount'], $calculator->final_rate['amount'], ' max distance rate is not final rate we are within distance boundary');                
    }    


    
}