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
 * Accepts form parameters related to surcharges and surcharge costs
 * Calculates Surcharges and returns them in an array for merging with quote
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_CalculationSurcharges {

 	private $default_config = array('stops'=>array(),
 									'charge_from_stop'=>0,
 									'weight'=>0,
 									'cost_per_weight_unit'=>100,
 									'weight_unit_name'=>0);  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	private function init_calculation(){
		$this->surcharges = array('weight_cost'=>0);
	}

	private function params_are_valid(){
		if(!is_numeric($this->config['weight'])) {
			return false;
		};
		if(!is_numeric($this->config['cost_per_weight_unit'])) {
			return false;
		};
		return true;
	}

	public function run(){
		$this->init_calculation();
		if(!$this->params_are_valid()){
			return false;
		};
		$this->calc_surcharge_weight();
		return $this->surcharges;
	}

	private function calc_surcharge_weight(){
		$this->surcharges['weight_cost'] = $this->config['weight'] * $this->config['cost_per_weight_unit'];
	}

	public function get_surcharges(){
		return $this->surcharges;
	}

	public function get_quote_surcharges_record_data(){
		$this->surcharges_record_data = array();
		if(isset($this->surcharges['weight_cost'])&&(isset($this->config['weight_surcharge_id']))){
			$this->surcharges_record_data[] = array('surcharge_id'=>$this->config['weight_surcharge_id'], 'amount'=>$this->surcharges['weight_cost']);
		};
		return $this->surcharges_record_data;
	}
}

