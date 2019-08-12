<?php

/**
 * Define Quote Formatter  functionality
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
class TQ_EmailRenderer {

    private $default_config = array();

    public function __construct($config = array()) {
        //merge config with defaults so all properties are present
        $this->config = array_merge($this->default_config, $config);
        $this->data = null;
        $this->header = null;
        $this->body = '';
    }

    public function has_required_params(){
        if (empty($this->params['data'])) {
            return false;
        };
        $this->data = $this->params['data'];

        if (!empty($this->params['header'])) {
            $this->header = $this->params['header'];
        };

        $this->labels = $this->params['labels'];

        if (!empty($this->params['labels'])) {
            $this->header = $this->params['labels'];
        };

        return true; 
    }

    public function render($params = null) {
        $this->data = null;
        $this->header = null;
        $this->body = '';          
        $this->params = $params;

        if(!$this->has_required_params()){
            //echo 'TQ_EmailRenderer: Missing params';
            return false;
        };

        $body = '';
        if(!empty($this->header)){
             $body .= $this->header . "\r\n\r\n";
        }

        $body .= $this->generate_content_section();
        echo $body;
        return $body;
    }

    public function generate_content_section(){

        $body = '';

        $this->rows = array();
        foreach ($this->data as $field) {
            if(!isset($field['value'])){
                continue;
            };
            if(!isset($field['label'])){
                $this->rows[] = $field['value'];
            } else if (empty($field['label'])) {
                $this->rows[] = $field['value'];
            } else {
                $this->rows[] = $field['label'].': '.$field['value'];                    
            }
        };
        $body .= implode("\r\n", $this->rows);            
   
        $body .= "\r\n\r\n";
        return $body;        
    }
}

?>