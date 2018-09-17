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
class TransitQuote_Pro_Settings_Field_Check_Group extends TransitQuote_Pro_Settings_Field {

    public function render(){

        echo '<fieldset class="tq-checkbox tq-'.$this->field_name.'">';
        foreach ($this->config['options'] as $key => $option) {
            $option_id = $option[$this->config['id_field']];
            $option_name = $option[$this->config['display_field']];
            $checked = self::get_checked_for_option($option_id);

            echo '<input type="checkbox" name="'.$this->field_name.'[]" value="'.$option_id.'" '.checked( 1 == $checked,true,false).'>'.$option_name.'<br/>';
        };

        echo '</fieldset>';
        echo '<p>'.$this->help.'</p>';

    }

    private function get_checked_for_option($option_id){
        if(is_array($this->value)){
            foreach ($this->value as $key => $value) {
                if($value == $option_id){
                    return true;
                }
            };
        };
        return false;
    }


}
