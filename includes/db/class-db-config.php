<?php

/**
 * Define the database structure
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Premium;
class DB_Config {

	public function __construct() {
		$this->debugging = true;
	}

	public function get_config($table){

		$method = 'config_'.$table;
		return self::$method();

	}


private function config_customers(){
 return array (
  'name' => 'customers',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d'
    ),
    'first_name' => 
    array (
      'name' => 'first_name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'last_name' => 
    array (
      'name' => 'last_name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'email' => 
    array (
      'name' => 'email',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'phone' => 
    array (
      'name' => 'phone',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    )
  ),
  'pk' => 'id',
);

}

private function config_quotes(){
 return array (
  'name' => 'quotes',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'total' => 
    array (
      'name' => 'total',
      'type' => 'decimal(10,2)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'rate_per_unit' => 
    array (
      'name' => 'rate_per_unit',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'distance_cost' => 
    array (
      'name' => 'distance_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'time_cost' => 
    array (
      'name' => 'time_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
   'notice_cost' => 
    array (
      'name' => 'notice_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_vehicle_types(){
 return array (
  'name' => 'vehicle_types',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_payment_types(){
 return array (
  'name' => 'payment_types',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'available' => 
    array (
      'name' => 'available',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_payment_status_types(){
 return array (
  'name' => 'payment_status_types',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'description' => 
    array (
      'name' => 'description',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_status_types(){
 return array (
  'name' => 'status_types',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_jobs(){
 return array (
  'name' => 'jobs',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d'
    ),
    'delivery_contact_name' => 
    array (
      'name' => 'delivery_contact_name',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'delivery_time' => 
    array (
      'name' => 'delivery_time',
      'type' => 'datetime',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'description' => 
    array (
      'name' => 'description',
      'type' => 'text',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'customer_id' => 
    array (
      'name' => 'customer_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d'
    ),
    'accepted_quote_id' => 
    array (
      'name' => 'accepted_quote_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d'
    ),
    'payment_type_id' => 
    array (
      'name' => 'payment_type_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'payment_status_id' => 
    array (
      'name' => 'payment_status_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'status_type_id' => 
    array (
      'name' => 'status_type_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'vehicle_type_id' => 
    array (
      'name' => 'vehicle_type_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'service_type_id' =>
    array (
      'name' => 'service_type_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '1',
      'format' => '%d'
    ),
    'move_size_id' => 
    array (
      'name' => 'move_size_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_locations(){
 return array (
  'name' => 'locations',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'address' => 
    array (
      'name' => 'address',
      'type' => 'text',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'appartment_no' => 
    array (
      'name' => 'appartment_no',
      'type' => 'varchar(10)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'street_number' => 
    array (
      'name' => 'street_number',
      'type' => 'varchar(10)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'postal_town' => 
    array (
      'name' => 'postal_town',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'route' => 
    array (
      'name' => 'route',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'administrative_area_level_2' => 
    array (
      'name' => 'administrative_area_level_2',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'administrative_area_level_1' => 
    array (
      'name' => 'administrative_area_level_1',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'country' => 
    array (
      'name' => 'country',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'postal_code' => 
    array (
      'name' => 'postal_code',
      'type' => 'varchar(16)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_surcharges(){
 return array (
  'name' => 'surcharges',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'decimal(10,2)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_quote_surcharges(){
 return array (
  'name' => 'quote_surcharges',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'quote_id' => 
    array (
      'name' => 'quote_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'surcharge_id' => 
    array (
      'name' => 'surcharge_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_journeys(){
 return array (
  'name' => 'journeys',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'job_id' => 
    array (
      'name' => 'job_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'origin_location_id' => 
    array (
      'name' => 'origin_location_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'dest_location_id' => 
    array (
      'name' => 'dest_location_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'distance' => 
    array (
      'name' => 'distance',
      'type' => 'decimal(10,4)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'time' => 
    array (
      'name' => 'time',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_rates(){
 return array (
  'name' => 'rates',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'service_type_id' => 
    array (
      'name' => 'service_type_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '1',
      'format' => '%d',
    ),
    'distance' => 
    array (
      'name' => 'distance',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'unit' => 
    array (
      'name' => 'unit',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'hour' => 
    array (
      'name' => 'hour',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}
private function config_event_logs(){
 return array (
  'name' => 'event_logs',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'event_type' => 
    array (
      'name' => 'event_type',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    )
  ),
  'pk' => 'id',
);

}

private function config_event_data(){
 return array (
  'name' => 'event_data',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'asc',
    'user_id' => false,
    'since' => false,
    'until' => false,
    'number' => -1,
    'offset' => 0,
  ),
  'cols' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => 'auto_increment',
      'default' => '',
      'format' => '%d',
    ),
    'event_id' => 
    array (
      'name' => 'event_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'name' => 
    array (
      'name' => 'name',
      'type' => 'text',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'value' => 
    array (
      'name' => 'value',
      'type' => 'text',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
  ),
  'pk' => 'id',
);

}

}?>