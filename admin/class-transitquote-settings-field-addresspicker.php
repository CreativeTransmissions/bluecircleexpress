<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Settings_Field_AddressPicker extends TransitQuote_Premium_Settings_Field {


	public function __construct($config = null) {
		$this->config = $config;
		$this->section_id = $this->config['section_id'];
		$this->admin = $this->config['admin'];
		$this->cdb = $this->admin->cdb;
        $this->page = $this->config['page'];
        $this->fields = array();
	}

	public function add_field(){
    	//register an admin tab from a config array
    	if(empty($this->config)){
    		return false;
    	};
    	add_settings_field( $this->config['id'],
                            $this->config['label'], 
                            array( $this, 'render' ), 
                            $this->page,
                            $this->section_id);

        if(isset($this->config['fields'])){
            $this->register_fields();
        };
    }

    public function render(){
       
        $field_name= $this->config['id'].'['.$this->config['id'].']';
    	echo '<input type="text" name="'.$field_name.'" value="'.$value.'"/>';
        echo "<p>Please enter the class or id of the html element in which to display the final quote.</p>".
            "<p>Note that by specifying a class you can have the quote amount appear in multiple elements such as a visible element for displaying to the customer and a hidden form element for saving the amount.</p>";
    }

    private function get_value_if_exists(){
        $value = '';
        if(isset($this->config['value'])){
            $value = $this->config['value'];
        };
        return $value;
    }

}
