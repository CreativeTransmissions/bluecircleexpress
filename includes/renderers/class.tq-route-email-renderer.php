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
class TQ_RouteEmailRenderer {

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

        if (empty($this->params['labels'])) {
            echo 'NO labels!';
            return false;
        };
        $this->labels = $this->params['labels'];

        if (!empty($this->params['header'])) {
            $this->header = $this->params['header'];
        };

        return true; 
    }

    public function render($params = null) {
        $this->params = $params;
        if(!$this->has_required_params()){
            echo 'TQ_RouteEmailRenderer: Missing params';
            return false;
        };

        $body = $this->generate_body();
        echo $body;
        return $body;
    }

 
    public function generate_body(){
        $body = '';
        if(!empty($this->header)){
             $body .= $this->header . "\r\n";
        };

        $this->waypoint_text_lists = $this->generate_list_for_each_waypoint();

        

        $this->rows = array();
        foreach ($this->waypoint_text_lists as $list_html) {
            $this->rows[] = $list_html['value'];
        };

        $body .= implode("\r\n\r\n", $this->rows);             
        
        $body .= "\r\n";
        return $body;        
    }

   public function generate_list_for_each_waypoint(){
       $waypoint_text_lists = array(); //array of ul's each containing the address data
        $email_renderer = new TQ_EmailRenderer();
        $header = $this->labels['collection_address_label'];
        foreach ($this->data as $key=>$waypoint) {
            if($key>0){
                $header = $this->labels['destination_address_label'];
            };

            $email_renderer->data = $waypoint;
            $waypoint_text = $header. "\r\n".$email_renderer->generate_content_section();
            $waypoint_text_lists[] = array('value'=>$waypoint_text);
        };
        return $waypoint_text_lists;
    }

}

?>