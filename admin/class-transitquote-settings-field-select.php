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
class TransitQuote_Pro_Settings_Field_Select extends TransitQuote_Pro_Settings_Field {

    public function render(){

        echo '<select name="'.$this->field_name.'">';

        foreach ($this->config['options'] as $key => $option) {
            $selected_att = '';
            if(is_array($option)){
                $option_id = $option[$this->config['id_field']];
                $option_name = $option[$this->config['display_field']];
            } else {
                $option_id = $option;
                $option_name = $option;
            };

            if($option_id==$this->value){
                $selected_att = 'selected="selected"';
            };

            echo '<option '.$selected_att.' value="'.$option_id.'">'.$option_name.'</option>';
        };

        echo '</select>';
        echo '<p>'.$this->help.'</p>';

    }



}
