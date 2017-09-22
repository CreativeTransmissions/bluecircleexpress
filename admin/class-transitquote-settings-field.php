<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/admin
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro_Settings_Field {

    private $default_config = array('label'=>'',
                                    'help'=>'',
                                    'value'=>'');

	public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		$this->section_id = $this->config['section_id'];
		$this->admin = $this->config['admin'];
		$this->cdb = $this->admin->cdb;
        $this->page = $this->config['page'];
        $this->value = $this->config['value'];
        $this->help = $this->config['help'];
        $this->field_name = $this->page.'['.$this->config['id'].']';
	}

	public function add_field(){
        //register an admin tab from a config array
        if(empty($this->config)){
            return false;
        };

        if(isset($this->config['table'])){
            self::load_options();
        };

        $this->set_start_value();

        add_settings_field( $this->config['id'],
                            $this->config['label'], 
                            array( $this, 'render' ), 
                            $this->page,
                            $this->section_id);
    }

    private function load_options(){
        $this->config['options'] = $this->cdb->get_rows($this->config['table'], array(), array($this->config['id_field'], $this->config['display_field']));
    }

    private function set_start_value(){
        if(isset($this->config['default'])){
            if(empty($this->value)){
                $this->value = $this->config['default'];
            };
        };
    }
}
