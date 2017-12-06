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
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro_Calculation {

 	private $default_config = array('distance'=>0,
 									'rates'=>array()); //rates are for the selected 

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		
		$this->plugin = $this->config['plugin'];
		$this->cdb = $this->plugin->cdb;
	}

	public function init_calculation(){
		$this->total = 0;
		$this->accumulated_total = 0;
	}

	public function calculate(){
		//rates are ordered by distance boundary from 0 to max
		foreach ($this->rates as $key => $rate) {
			if(self::is_distance_within_boundary($rate)){
				self::add_remaining_distance_cost_to_total();
				exit;
			} else {
				self::add_boundary_distance_cost_to_total($rate);
			}
		}
	}

	public function add_boundary_distance_cost_to_total($rate){

	}

	public function add_remaining_distance_cost_to_total(){
		
	}

}
