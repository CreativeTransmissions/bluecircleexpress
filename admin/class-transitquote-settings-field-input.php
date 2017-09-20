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
class TransitQuote_Pro_Settings_Field_Input extends TransitQuote_Pro_Settings_Field {

    public function render(){

        $label = $this->config['label'];
        $help = $this->config['help'];
        $value = $this->config['value'];
    	echo '<input type="text" name="'.$this->field_name.'" value="'.$value.'"/>';
        echo '<p>'.$this->config['help'].'</p>';
    }

}
