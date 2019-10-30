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
class TQ_CalculationAreaSurcharges {

 	private $default_config = array('area_surcharges'=>array(),
 									'surcharge_ids'=>array());  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	private function init_calculation(){
		$this->surcharges = array();
		$this->surcharge_total = 0;
		$this->quote_surcharge_record_data = array();

	}

	private function params_are_valid(){
		if(!is_array($this->config['area_surcharges'])) {
			return false;
		};
		if(!is_array($this->config['surcharge_ids'])) {
			return false;
		};
		return true;
	}

	public function run(){
		$this->init_calculation();
		if(!$this->params_are_valid()){
			return false;
		};
		$this->calc_area_surcharges();
		return $this->surcharges;
	}

	private function calc_area_surcharges(){
		foreach ($this->config['surcharge_ids'] as $surcharge_id) {
			if(!is_numeric($surcharge_id)){
				continue;
			};
			$surcharge = $this->get_surcharge_for_id($surcharge_id);
			$surcharge_cost = $this->get_surcharge_cost_for_id($surcharge_id);
			$surcharge_name_formatted = strtolower(str_replace(' ', '_', $surcharge['surcharge_name']));
			if(is_numeric($surcharge_cost)){
				$this->surcharge_total = $this->surcharge_total+$surcharge_cost;
				$this->surcharges[$surcharge_name_formatted] = $surcharge_cost;
				$this->surcharges[$surcharge_name_formatted] = $surcharge_cost;
				$this->quote_surcharge_record_data[] = array('surcharge_id'=>$surcharge_id, 'amount'=>$surcharge_cost);
			};
		};
		$this->surcharges['area_surcharges_cost'] = $this->surcharge_total;
	}


	private function get_surcharge_cost_for_id($surcharge_id){
		$surcharge = $this->get_surcharge_for_id($surcharge_id);
		return $surcharge['amount'];
	}

	public function get_surcharge_for_id($surcharge_id){
		if(!isset($this->config['area_surcharges'][$surcharge_id])){
			trigger_error('get_surcharge_for_id: '.$surcharge_id.' has no surcharge record', E_USER_WARNING);            
		};
		return $this->config['area_surcharges'][$surcharge_id];
	}

	public function get_surcharges(){
		return $this->surcharges;
	}

	public function get_quote_surcharges_record_data(){
		return $this->quote_surcharge_record_data;
	}

}

