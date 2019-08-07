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
class TQ_ListRenderer {

 	private $default_config = array();

    public function __construct($config = array()) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->data = null;
        $this->header = null;
	}

	public function has_required_params(){
        if (empty($this->params['data'])) {
            return false;
        };
        $this->data = $this->params['data'];

        return true; 
	}

    public function render($params = null) {
        $this->params = $params;
        if(!$this->has_required_params()){
            //echo 'TQ_ListRenderer: Missing params';
            return false;
        };

        $html = $this->generate_html();
        echo $html;
        return $html;
    }

    public function generate($params = null) {
        $this->params = $params;
        if(!$this->has_required_params()){
            //echo 'TQ_ListRenderer: Missing params';
            return false;
        };

        $html = $this->generate_html();
        return $html;
    }

    public function generate_html(){

        if (count($this->data) === 0) {
            
            $html = '<ul class="tq-list"><ul><li>No information available</li></ul>';

        } else {

            $this->rows = array();
            foreach ($this->data as $field) {
                if(!isset($field['value'])){
                    continue;
                };
                if(!isset($field['label'])){
                    $this->rows[] = '<li>' . $field['value'] . '</li>';
                } else if (empty($field['label'])) {
                    $this->rows[] = '<li>'.$field['value'] . '</li>';
                } else {
                    $this->rows[] = '<li>'.$field['label'].': '.$field['value'] . '</li>';                    
                }
            };

            $html = '<ul class="tq-list">';
            $html .= implode('', $this->rows);            
        };

        $html .= '</ul>';
        return $html;        
    }

}

?>