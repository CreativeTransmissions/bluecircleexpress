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
class TransitQuote_Pro_Settings_Field_Checkbox extends TransitQuote_Pro_Settings_Field {

    public function render(){
    	echo '<input type="checkbox" id="'.$this->field_name.'"  name="'.$this->field_name.'" value="1" '.checked( 1 == $this->value,true,false).'/>';
        echo '<p>'.$this->help.'</p>';
    }

}
