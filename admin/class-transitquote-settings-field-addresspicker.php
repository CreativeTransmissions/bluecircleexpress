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
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
class TransitQuote_Pro_Settings_Field_AddressPicker extends TransitQuote_Pro_Settings_Field {

    public function render(){
    	echo '<input id="place_selector_address" type="text" class="addresspicker wide" name="'.$this->field_name.'" value="'.$this->value.'"/>';
		echo '<div id="place-selector"></div>';
    }

}
