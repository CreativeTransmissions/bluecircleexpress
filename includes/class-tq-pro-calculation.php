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
class TQ_Calculation {

 	private $default_config = array('distance'=>0,
 									'return_distance'=>0,
 									'return_percentage'=>100,
 									'return_time'=>0,
 									'time_mins'=>0,
 									'rates'=>array(),
 									'include_return_journey'=>false,
 									'boundary_mode'=>'final');  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function init_calculation(){
		$this->total = 0;
		$this->accumulated_total = 0;
		$this->breakdown = array();
		$this->rates = $this->config['rates'];
		$this->distance = $this->config['distance'];
		$this->full_distance = $this->distance;
		$this->return_distance = $this->config['return_distance'];
		$this->units_charged_for = 0;
		$this->max_distance_rate = self::get_max_distance_rate();
		$this->tax_rate = $this->config['tax_rate'];
		$this->tax_name = $this->config['tax_name'];

		if($this->config['include_return_journey']===true){
			if($this->config['return_percentage'] !== 100){
				// calculate differently for return
				echo 'calculate differently for return';
				$this->distance = self::get_outward_distance();
			}		
		}
	}

	private function get_outwards_distance(){
		$outward_distance = $this->distance - $this->return_distance;
	}

	private function get_max_distance_rate(){
		$max_distance_rate = false;
		foreach ($this->rates as $key => $rate) {
			if($rate['distance']==0){
				$max_distance_rate = $rate;
			}
		}
		return $max_distance_rate;
	}

	public function run(){
		self::init_calculation();
	//	echo 'boundary_mode: '.$this->config['boundary_mode'];
		switch ($this->config['boundary_mode']) {
			case 'final':
				self::calc_with_final_boundary_rates();
				break;
			case 'all':
				self::calc_with_all_boundary_rates();
				break;
		};

		$this->distance_cost = $this->total;
		if($this->tax_rate>0){
			self::add_tax();
		};
		return self::build_quote();
	
	}

	private function set_distance($distance){
		if(is_nan($distance)){
			return false;
		};

		$this->distance = $distance;
		return true;
	}

	private function calc_with_final_boundary_rates(){

		$final_rate = false;
		//rates are ordered by distance boundary from 0 to max
		foreach ($this->rates as $key => $rate) {
			if($rate['distance']==0){
				continue;
			};
			if(self::is_distance_within_boundary($rate)){
				$this->final_rate = $rate;
			//	echo $this->distance.' is within '.$rate['distance'];
				self::add_boundary_set_amount_to_total($rate);
				break;
			} else {
			//	echo $this->distance.' is NOT within '.$rate['distance'];
				self::add_boundary_set_amount_to_total($rate);
			}
		};
		//echo '*charged for '.$this->units_charged_for.' of '.$this->distance.' units';
		$units_left_to_charge_for = $this->distance - $this->units_charged_for;
		if($units_left_to_charge_for > 0 ){
		//	echo ' still to charge for '.$units_left_to_charge_for.' units.';
			if($final_rate === false){
		//		echo ' Using max distance rate for long journey.';
			};	$final_rate = $this->max_distance_rate;

			self::add_max_distance_cost_to_total($final_rate);
			
		};
		
		
	}

	private function calc_with_all_boundary_rates(){
		//rates are ordered by distance boundary from 0 to max
		foreach ($this->rates as $key => $rate) {
			if(self::is_distance_within_boundary($rate)){
				self::add_remaining_distance_cost_to_total($rate);
				exit;
			} else {
				self::add_boundary_set_amount_to_total($rate);
				self::add_boundary_distance_cost_to_total($rate);
			}
		}

	}

	private function is_distance_within_boundary($rate){
		if($this->distance <= $rate['distance']){
			return true;
		} else {
			return false;
		}
	}

	private function add_boundary_set_amount_to_total($rate){
		if($rate['amount']>0){
			$this->total = $this->total + $rate['amount'];
			if($rate['distance'] < $this->distance){
				$this->units_charged_for = $this->units_charged_for + $rate['distance'];		
			} else {
				$miles_remaining_within_boundary = $rate['distance'] - $this->distance;
				$this->units_charged_for = $this->units_charged_for + $miles_remaining_within_boundary;
			}

			$this->breakdown[] = array(	'distance'=>$rate['distance'],
										'units_charged_for'=>$this->units_charged_for,
										//'miles_remaining_within_boundary'=>$miles_remaining_within_boundary,
										'type'=>'set amount',
										'rate'=>$rate['amount'],
										'cost'=>$rate['amount']);
		}
	}

	private function add_boundary_distance_cost_to_total($rate){
		$miles_up_to_boundary = $rate['distance'];
		$cost_of_miles_up_to_boundary = $rate['distance']*$rate['unit'];
		$this->total = $this->total + $cost_of_miles_up_to_boundary;
		$this->units_charged_for = $this->units_charged_for + $miles_up_to_boundary;
		$this->breakdown[] = array(	'distance'=>$miles_up_to_boundary,
									'type'=>'per distance unit',
									'rate'=>$rate['unit'],
									'cost'=>$cost_of_miles_up_to_boundary);
	}

	private function add_remaining_distance_cost_to_total($rate){
		$miles_remaining_within_boundary = $rate['distance'] - $this->distance;
		$cost_of_miles_remaining_within_boundary = $miles_remaining_within_boundary*$rate['unit'];
		$this->total = $this->total + $cost_of_miles_remaining_within_boundary;
		$this->units_charged_for = $this->units_charged_for + $miles_remaining_within_boundary;
		$this->breakdown[] = array(	'distance'=>$miles_remaining_within_boundary,
							'type'=>'per distance unit',
							'rate'=>$rate['unit'],
							'cost'=>$cost_of_miles_remaining_within_boundary);
	}

	private function add_max_distance_cost_to_total($rate){
		/*echo ', add_max_distance_cost_to_total: rate: '.$rate['unit'];
		echo ', add_max_distance_cost_to_total: total_distance: '.$this->distance;
		echo ', add_max_distance_cost_to_total: units_charged_for: '.$this->units_charged_for;*/
		$miles_remaining = $this->distance - $this->units_charged_for;
		//echo ', add_max_distance_cost_to_total: miles_remaining: '.$miles_remaining;
		$cost_of_miles_remaining = $miles_remaining*$rate['unit'];
		$this->total = $this->total + $cost_of_miles_remaining;
		$this->units_charged_for = $this->units_charged_for + $miles_remaining;
		$this->breakdown[] = array(	'distance'=>$miles_remaining,
							'type'=>'per distance unit',
							'rate'=>$rate['unit'],
							'cost'=>$cost_of_miles_remaining);
	}

	private function add_return_distance_cost_to_total($rate){
		/*echo ', add_return_distance_cost_to_total: rate: '.$rate['unit'];
		echo ', add_return_distance_cost_to_total: total_distance: '.$this->distance;
		echo ', add_return_distance_cost_to_total: units_charged_for: '.$this->units_charged_for;*/
		$return_miles = $this->return_miles;

		//echo ', add_max_distance_cost_to_total: miles_remaining: '.$miles_remaining;
		$return_cost = $miles_remaining*$rate['unit'];
		$return_cost = self::apply_return_cost_adjustment($return_cost);

		$this->total = $this->total + $return_cost;
		$this->units_charged_for = $this->units_charged_for + $return_miles;
		$this->breakdown[] = array(	'distance'=>$return_miles,
							'type'=>'per distance unit',
							'rate'=>$rate['unit'],
							'return_percentage'=>$this->config->return_percentage,
							'cost'=>$return_cost);
	}

	private function apply_return_cost_adjustment($return_cost){
		if(!empty( $this->config->return_percentage)){
			$return_percentage = $this->config->return_percentage;
			$return_cost =($this->return_percentage/100)*$return_cost; 
		}
		return $return_cost;
	}

	private function add_tax(){
		$this->tax_cost = ($this->tax_rate/100)*$this->total;
		$this->total = $this->total + $this->tax_cost;
		$this->breakdown[] = array(	'distance'=>$this->tax_name,
									'type'=>'percentage',
									'rate'=>$this->tax_rate,
									'cost'=>$this->tax_cost);
	}

	private function build_quote(){
		$quote = array('total'=>round($this->total,2),
						'distance'=>$this->distance,
						'distance_cost'=>round($this->distance_cost,2),
						'breakdown'=>$this->breakdown,
						'rate_tax'=>$this->tax_rate,
						'tax_cost'=>$this->tax_cost);
		return $quote;
	}

}

