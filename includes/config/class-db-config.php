<?php

/**
 * Define the database structure
 *
 * @link       http://transitquote.co.uk
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/includes
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 * @copyright 2016 Creative Transmissions
 */

namespace TransitQuote_Pro4;
class DB_Config {

  public function __construct() {
    $this->debugging = false;
  }

  public function get_config($table){

    $method = 'config_'.$table;
    return self::$method();

  }


/* holds list of companies */
private function config_companies(){
 return array (
  'name' => 'companies',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'desc',
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
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    )
  ),
  'pk' => 'id',
);

}

/* holds list of currencies */
private function config_currencies(){
 return array (
  'name' => 'currencies',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'desc',
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
    'name' => 
    array (
      'name' => 'name',
      'type' => 'varchar(45)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
   'currency_code' => 
    array (
      'name' => 'currency_code',
      'type' => 'varchar(5)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'symbol' => 
    array (
      'name' => 'symbol',
      'type' => 'varchar(10)',
      'null' => 'not null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    )
  ),
  'pk' => 'id',
);

}

/* contacts at the pick up and drop off locations */
private function config_contacts(){
 return array (
  'name' => 'contacts',
  'defaults' => 
  array (
    'fields' => 
    array (
    ),
    'orderby' => 'id',
    'order' => 'desc',
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
    'company_id' => 
    array (
      'name' => 'company_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
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
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
    'modified' => 
    array (
      'name' => 'modified',
      'type' => 'datetime',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s'
    ),
  ),
  'pk' => 'id',
);

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
      'format' => '%f'
    ),
    'rate_unit' => 
    array (
      'name' => 'rate_unit',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
  'rate_hour' => 
    array (
      'name' => 'rate_hour',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),      
    'rate_tax' => 
    array (
      'name' => 'rate_tax',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
    'basic_cost' => 
    array (
      'name' => 'basic_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),    
    'distance_cost' => 
    array (
      'name' => 'distance_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
    'time_cost' => 
    array (
      'name' => 'time_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
   'notice_cost' => 
    array (
      'name' => 'notice_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
    'tax_cost' => 
    array (
      'name' => 'tax_cost',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
    ),
    'breakdown' => 
    array (
      'name' => 'breakdown',
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

private function config_vehicles(){
 return array (
  'name' => 'vehicles',
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
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
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
      'type' => 'tinyint',
      'null' => 'not null',
      'auto' => '',
      'default' => '0',
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
    )
  ),
  'pk' => 'id',
);

}

private function config_request_types(){
 return array (
  'name' => 'request_types',
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
    'name' => 
    array (
      'name' => 'name',
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

private function config_services(){
 return array (
  'name' => 'services',
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
    'amount' => 
    array (
      'name' => 'amount',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
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


private function config_payment_statuses(){
 return array (
  'name' => 'payment_statuses',
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

private function config_table_filters(){
 return array (
  'name' => 'table_filters',
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
    'filter_values' => 
    array (
      'name' => 'filter_values',
      'type' => 'varchar(45)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
    'created' => 
    array (
      'name' => 'created',
      'type' => 'datetime',
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
    ),
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
    'dimensions' => 
    array (
      'name' => 'dimensions',
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
      'default' => '',
      'format' => '%d'
    ),
    'payment_status_id' => 
    array (
      'name' => 'payment_status_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
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
    'vehicle_id' => 
    array (
      'name' => 'vehicle_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d'
    ),
    'service_id' =>
    array (
      'name' => 'service_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
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
    'lat' => 
    array (
      'name' => 'lat',
      'type' => 'decimal(10,6)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'lng' => 
    array (
      'name' => 'lng',
      'type' => 'decimal(10,6)',
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


private function config_journey_lengths(){
 return array (
  'name' => 'journey_lengths',
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
    'distance' => 
    array (
      'name' => 'distance',
      'type' => 'decimal(10,2)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%f'
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

private function config_journeys_locations(){
 return array (
  'name' => 'journeys_locations',
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
    'journey_id' => 
    array (
      'name' => 'journey_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'location_id' => 
    array (
      'name' => 'location_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'journey_order' => 
    array (
      'name' => 'journey_order',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d',
    ),
    'note' => 
    array (
      'name' => 'note',
      'type' => 'text',
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
	'contact_name' => 
    array (
      'name' => 'contact_name',
      'type' => 'varchar(128)',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),
	'contact_phone' => 
    array (
      'name' => 'contact_phone',
      'type' => 'varchar(45)',
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
    'service_id' => 
    array (
      'name' => 'service_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '1',
      'format' => '%d',
    ),
    'vehicle_id' => 
    array (
      'name' => 'vehicle_id',
      'type' => 'int',
      'null' => 'not null',
      'auto' => '',
      'default' => '1',
      'format' => '%d',
    ),
    'journey_length_id'=>
    array (
      'name' => 'journey_length_id',
      'type' => 'int',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%d'
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

private function config_transactions_paypal(){
  return array (
    'name' => 'transactions_paypal',
    'defaults' => array (
        'fields' =>   array (),
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
    'customer_id' => 
      array (
        'name' => 'customer_id',
        'type' => 'int',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%d'
      ),
    'job_id' => 
      array (
        'name' => 'job_id',
        'type' => 'int',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%d'
    ),
    'amount' => 
      array (
        'name' => 'amount',
        'type' => 'decimal(10,2)',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%f'
    ),
    'currency' => 
      array (
        'name' => 'currency',
        'type' => 'varchar(5)',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%s'
    ),
    'paypal_status' => 
      array (
        'name' => 'paypal_status',
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

private function config_transaction_logs_paypal(){
  return array (
    'name' => 'transaction_logs_paypal',
    'defaults' => array (
        'fields' =>   array (),
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
    'transaction_id' => 
      array (
        'name' => 'transaction_id',
        'type' => 'int',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%d'
      ),
    'payment_type_id' => 
      array (
        'name' => 'payment_type_id',
        'type' => 'int',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%d'
    ),
    'request_type_id' => 
      array (
        'name' => 'request_type_id',
        'type' => 'int',
        'null' => 'not null',
        'auto' => '',
        'default' => '',
        'format' => '%d'
    ),
    'request' => 
      array (
        'name' => 'request',
        'type' => 'text',
        'null' => 'null',
        'auto' => '',
        'default' => '',
        'format' => '%s'
    ),
    'response' => 
      array (
        'name' => 'response',
        'type' => 'text',
        'null' => 'null',
        'auto' => '',
        'default' => '',
        'format' => '%s'
    ),
    'message' => 
      array (
        'name' => 'message',
        'type' => 'text',
        'null' => 'null',
        'auto' => '',
        'default' => '',
        'format' => '%s'
    ),
    'success' => 
      array (
        'name' => 'success',
        'type' => 'tinyint(1)',
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
private function config_blocked_dates(){
 return array (
  'name' => 'blocked_dates',
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
    'start_date' => 
    array (
      'name' => 'start_date',
      'type' => 'timestamp',
      'null' => 'null',
      'auto' => '',
      'default' => '',
      'format' => '%s',
    ),   
    'end_date' => 
    array (
      'name' => 'end_date',
      'type' => 'timestamp',
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
    )
  ),
  'pk' => 'id',
);
}

}?>