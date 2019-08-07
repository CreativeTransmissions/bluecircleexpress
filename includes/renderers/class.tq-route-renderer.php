<?php

/**
 * Define Route Renderer  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * 
 * Accepts array of quote data
 * Returns filtered array of fields eachof which contains a label and value formatted for user-readable output
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_RouteRenderer {

    private $default_config = array();

    public function __construct($config = array()) {
        //merge config with defaults so all properties are present
        $this->config = array_merge($this->default_config, $config);
        $this->data = null;
        $this->header = null;
    }

    public function has_required_params(){
        if (empty($this->params['data'])) {
            echo 'NO DATA!';
            return false;
        };
        $this->data = $this->params['data'];

        if (!empty($this->params['header'])) {
            $this->header = $this->params['header'];
        };

        return true; 
    }

    public function render($params = null) {
        $this->params = $params;
        if(!$this->has_required_params()){
            echo 'TQ_TableRenderer: Missing params';
            return false;
        };

        $html = $this->generate_html();
        echo $html;
        return $html;
    }

    public function generate_list_for_each_waypoint(){
       $waypoint_html_lists = array(); //array of ul's each containing the address data
        $list_renderer = new TQ_ListRenderer();
        foreach ($this->data as $waypoint) {
            $waypoint_html = $list_renderer->generate(array('data'=>$waypoint));
            $waypoint_html_lists[] = array('value'=>$waypoint_html);
        };
        return $waypoint_html_lists;
    }
    public function generate_html(){

        $this->waypoint_html_lists = $this->generate_list_for_each_waypoint();

        if (count($this->waypoint_html_lists) === 0) {
            
            $html = '<table><tbody><tr><th colspan="1">' . $this->header . '</th></tr><tr><td>No information available.</td>';

        } else {

            $this->rows = array();
            foreach ($this->waypoint_html_lists as $list_html) {
                $this->rows[] =  '<td>' . $list_html['value'] . '</td>';
            };

            $html = '<table><tbody><tr><th colspan="1">' . $this->header . '</th></tr><tr>';
            $html .= implode('</tr><tr>', $this->rows);            
        };

        $html .= '</tr></tbody></table>';
        return $html;        
    }

    public function render_single_col($params = null) {
        $this->params = $params;
        if(!$this->has_required_params()){
            //echo 'TQ_TableRenderer: Missing params';
           // print_r($this->params);
            return false;
        };

        $html = $this->generate_single_col_html();
        echo $html;
        return $html;
    }

    public function generate_single_col_html(){

        if (count($this->data) === 0) {
            
            $html = '<table><tbody><tr><th colspan="1">' . $this->header . '</th></tr><tr><td>No information available.</td>';

        } else {

            $this->rows = array();
            foreach ($this->data as $field) {
                $this->rows[] =  '<td>' . $field['value'] . '</td>';
            };

            $html = '<table><tbody><tr><th colspan="1">' . $this->header . '</th></tr><tr>';
            $html .= implode('</tr><tr>', $this->rows);            
        };

        $html .= '</tr></tbody></table>';
        return $html;        
    }    
}

?>