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
class TQ_QuoteFormatter {

 	private $default_config = array('currency'=>'£',
 									'quote'=>array(), // associative array of quote data
 									'output_def'=>array(),  // output definition: array(array('field_name1'=>'field_label1'),array('field_name2'=>'field_label2'))
 									'tax_name'=>'Tax' // ie VAT etc
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
		$this->output_def = $this->config['output_def'];
		$this->quote = $this->config['quote'];
	}

	public function has_required_params(){
        if (empty($this->quote)) {
            return false;
        };

        if (empty($this->output_def)) {
            return false;
        };

        return true; 
	}

	public function format(){

		if(!$this->has_required_params()){
			return false;
		};

 		$output = array();
        foreach ($this->config['output_def'] as $key => $label) {
            echo 'format: '.$key;
            if (!isset($this->quote[$key])) {
                echo ' not set.';
                continue;
            };
            $output[] = $this->format_field($key, $label);
        };

        return $output;
	}

	public function format_field($key, $label){
		
        $name = $key;        
		$valueType = $this->format_value($key);

		$field = array('label'=>$label,
                        'name'=>$name,
						'value'=>$valueType['value'],
                        'type'=>$valueType['type']
                    );

		return $field;
	}

	public function format_value($key){

          echo ' *** format_value key: '.$key;

		$value = $this->quote[$key];
        $field = array();
 		switch ($key) {
            case 'notice_cost':
            case 'time_cost':
            case 'rate_hour':
            case 'rate_tax':
            case 'tax_cost':
            case 'job_rate':
                $field['value'] = ucfirst($value);
                $field['type'] = 'text';
                break;

            default:
                $field['value'] = $value;
                $field['type'] = 'number';
                break;                
          };

          return $field;

	}

}
?>