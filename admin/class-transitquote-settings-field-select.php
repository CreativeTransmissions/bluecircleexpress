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
class TransitQuote_Premium_Settings_Field_Select extends TransitQuote_Premium_Settings_Field{

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
