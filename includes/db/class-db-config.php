<?php

/**
 * Define the database structure
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    WP_Balance_Voucher
 * @subpackage WP_Balance_Voucher/includes
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 * @copyright 2016 Creative Transmissions
 */

namespace WP_Balance_Voucher;
class DB_Config {

	public function __construct() {
		$this->debugging = true;
	}

	public function get_config($table){

		$method = 'config_'.$table;
		return self::$method();

	}

  private function config_ct_customers(){
 return array (
  'name' => 'ct_customers',
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
    'first_name' => 
    array (
      'name' => 'first_name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'last_name' => 
    array (
      'name' => 'last_name',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'email' => 
    array (
      'name' => 'email',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'phone' => 
    array (
      'name' => 'phone',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'company' => 
    array (
      'name' => 'company',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'job_title' => 
    array (
      'name' => 'job_title',
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

private function config_ct_products(){
 return array (
  'name' => 'ct_products',
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
      'type' => 'text',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'paddleid' => 
    array (
      'name' => 'paddleid',
      'type' => 'int',
      'null' => 'null',
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

private function config_ct_customers_products(){
 return array (
  'name' => 'ct_customers_products',
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
    'customer_id' => 
    array (
      'name' => 'customer_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'product_id' => 
    array (
      'name' => 'product_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'purchase_date' => 
    array (
      'name' => 'purchase_date',
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

private function config_ct_event_logs(){
 return array (
  'name' => 'ct_event_logs',
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

private function config_ct_event_data(){
 return array (
  'name' => 'ct_event_data',
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