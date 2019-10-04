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
 * Accepts form parameters related to tax and the calculated quote including all surcharges
 * Calculates or recalculates taxes and returns them in an array for merging with quote
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_CalculationTax {

 	private $default_config = array('tax_name'=>'',
 									'tax_rate'=>0,
 									'subtotal'=>0);  // final or all

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function run(){
		$this->init_calculation();
		if(!$this->params_are_valid()){
			return false;
		};		
		$this->calc_tax();
		return $this->taxes;
	}

	private function init_calculation(){
		$this->taxes = $this->config;
	}

	private function params_are_valid(){
		if(!is_numeric($this->config['tax_rate'])) {
			return false;
		};
		if(!is_numeric($this->config['subtotal'])) {
			return false;
		};
		if(!is_string($this->config['tax_name'])) {
			return false;
		};	

		return true;
	}

	private function calc_tax(){
		$this->tax_cost = $this->config['subtotal'] * ($this->config['tax_rate']/100);
		$this->taxes['tax_cost'] = number_format((float)$this->tax_cost, 2, '.', '');
		$this->config['subtotal'] = number_format((float)$this->config['subtotal'], 2, '.', '');
		$this->taxes['total_cost'] = $this->config['subtotal'] + $this->taxes['tax_cost'];
		$this->taxes['total'] = number_format((float)$this->taxes['total_cost'], 2, '.', '');

	}

	public function get_tax(){
		return $this->taxes;
	}


}

