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
class TransitQuote_Pro_Settings_Field_Select extends TransitQuote_Pro_Settings_Field{

    public function render(){
        echo '<select name="'.$this->field_name.'">';
        foreach ($this->config['options'] as $key => $option) {
            $selected_att = '';
            if($option===$this->value){
                $selected_att = 'selected="selected"';
            };
            echo '<option '.$selected_att.'>'.$option.'</option>';
        };
        echo '<p>'.$this->help.'</p>';
    }



}
