<?php

/**
 * Define Calculation functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro3;
class TQ_Rates_List {

 	private $default_config = array('range_start'=>0,
 									'range_end'=>100,
 									'step'=>5,
 									'return_distance'=>0,
 									'return_percentage'=>100,
 									'return_time'=>0,
 									'time_mins'=>0,
 									'rates'=>array(),
 									'include_return_journey'=>false,
 									'boundary_mode'=>'final',
 									'tax_rate'=>0);  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		$this->cdb = $this->config['cdb'];
	}

	public function get_rate_variations(){
		return $this->rate_variations = self::get_all_possible_rate_variations();
	}

	private function get_all_possible_rate_variations(){
		$rate_variations_sql = self::get_rate_variations_sql();
		return $this->cdb->query($rate_variations_sql);
	}

	private function get_rate_variations_sql(){
		return "SELECT distinct service_id, vehicle_id, journey_length_id
					FROM transitquotepro.wp_tq_pro3_rates
			 	order by service_id asc, vehicle_id asc, journey_length_id asc";
	}

	public function render_rates_list($variation){
		$rates_list = self::get_rates_list_for_variation($variation);
		self::render_table($rates_list);
	}

	private function get_rates_list_for_variation($variation){
		$results = array();
		$calculation = self::get_calculation_for_variation($variation);
		
		$start_distance = $this->config['range_start'];
		$end_distance = $this->config['range_end'];
		$step = $this->config['step'];

		for ($i=$start_distance; $i <= $end_distance; $i+=$step) { 
			if(!$calculation->set_distance($i)){
				return false;
			};

			$quote = $calculation->run();
			$results[] = array('distance'=>$i,
							   'quote'=>$quote);

		};

		echo 'Journeys calculated: '.count($results);
		return $results;

	}

	private function get_calculation_for_variation($variation){
		$this->rates = self::get_rates_for_variation($variation);
		$calculation = new TQ_Calculation(array('debugging'=>$this->config['debug'],
																		'rates'=>$this->rates,
																		'include_return_journey'=>false,
																		'tax_rate'=>$this->config['tax_rate'],
																		'tax_name'=>'VAT'));
		return $calculation;
	}

	private function get_rates_for_variation($variation){
		$rates = false;
		$query = self::get_rates_query_for_journey_options($variation);
		if($query === false){
			//echo 'could not get query';
			return false;
		}
		//echo 'rates query';
		//print_r($query);
		return $this->cdb->get_rows('rates', $query);

	}

	private function get_rates_query_for_journey_options($variation){

		$rates_query = array('service_id'=>$variation['service_id'],
							 'vehicle_id'=>$variation['vehicle_id'],
							 'journey_length_id'=>$variation['journey_length_id']);
		
		return $rates_query;
		
	}

	private function render_table($rates_list){
		$journey_rows = array();
		$header_row = '<tr><th>Distance</th><th>Cost</th><th>Tax</th><th>Total</th></tr><tr>';
		foreach ($rates_list as $key => $journey) {
			$journey_rows[] = '<td>'.$journey['distance'].'</td><td>'.$journey['quote']['distance_cost'].'</td><td>'.$journey['quote']['tax_cost'].'</td><td>'.$journey['quote']['total'].'</td>';
			/*echo '<pre>';
			print_r($journey['quote']);
					echo '</pre>';*/

		}
		$html = '<table>'.implode($journey_rows, '</tr><tr>').'</tr></table>';
		echo $html;
	}
}

