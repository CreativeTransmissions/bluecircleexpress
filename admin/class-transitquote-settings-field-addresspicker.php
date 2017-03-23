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

    public function render(){
    	echo '<input id="place_selector_address" type="text" class="addresspicker wide" name="'.$this->field_name.'" value="'.$this->value.'"/>';
		echo '<div id="place-selector"></div>';
    }

}
