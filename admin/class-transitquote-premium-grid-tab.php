<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/grid_tab
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/grid_tab
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Grid_Tab extends TransitQuote_Premium_Tab {

    public function filter_bar(){
        $defaults = $this->admin->get_job_filters();
        echo $this->dbui->filter_bar(array('table' =>'status_types',
                                            'name_col'=>'name',
                                            'value_col'=>'id',
                                            'title'=>'<legend>Display jobs with status:</legend>',
                                            'defaults'=>$defaults['status_type_id']));
    }

}
