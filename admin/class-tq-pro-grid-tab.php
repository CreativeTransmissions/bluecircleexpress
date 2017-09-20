<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/grid_tab
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/grid_tab
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
class TransitQuote_Pro_Grid_Tab extends TransitQuote_Pro_Tab {

    public function filter_bar(){
        $defaults = $this->admin->get_job_filters();
        echo $this->dbui->filter_bar(array('table' =>'status_types',
                                            'name_col'=>'name',
                                            'value_col'=>'id',
                                            'title'=>'<legend>Display jobs with status:</legend>',
                                            'defaults'=>$defaults['status_type_id']));
    }

}
