<?php

/**
 * Define the admin structure
 *
 * @link       http://transitquote.co.uk
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Pro4;
class Theme_Config {

  public function __construct() {
    $this->debugging = false;
  }

  public static function get_config($config_name){

    $method = 'config_'.$config_name;
    return self::$method();

  }

  // List of fields to be parsed by the get quote request parser in addion to the core fields
  private static function config_get_quote_fields(){
    return array('locations'=>array('visit_type'=>array('required'),
                                           'time_type'=>array('required'),
                                            'collection_date'=>array('optional','dependant'=>array('time_type'=>'collection at','collection by')),
                                            'collection_time'=>array('optional','dependant'=>array('time_type'=>'collection at','collection by')))
                  );
  }

  // List of fields to be parsed by the pay now request parser in addion to the core fields
  private static function config_pay_now_fields(){
    return array('locations'=>array('visit_type'=>array('required'),
                                       'time_type'=>array('required'),
                                        'collection_date'=>array('optional','dependant'=>array('time_type'=>'collection at','collection by')),
                                        'collection_time'=>array('optional','dependant'=>array('time_type'=>'collection at','collection by')))
                  );
  } 
}?>