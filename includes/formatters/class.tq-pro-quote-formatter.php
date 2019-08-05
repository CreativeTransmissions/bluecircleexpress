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
 									'output_def'=>array(),  // output definition: array('field_name1','field_name2')
 									'tax_name'=>'Tax' // ie VAT etc
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['quote'])) {
            echo 'TQ_QuoteFormatter: no quote in params';            
            return false;
        };
        $this->quote = $this->config['quote'];

        if (empty($this->config['output_def'])) {
            echo 'TQ_QuoteFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        if (empty($this->config['labels'])) {
            echo 'TQ_QuoteFormatter: no labels in params';
            return false;
        };
        $this->labels = $this->config['labels'];

        return true; 
	}

	public function format(){

		if(!$this->has_required_params()){
			return false;
		};

 		$output = array();
        foreach ($this->output_def as $key) {
            if (!isset($this->quote[$key])) {
                continue;
            };
            $output[] = $this->format_field($key);
        };

        return $output;
	}

	public function format_field($key){
		
        $name = $key;        
		$valueType = $this->format_value($key);
        $label = $this->labels[$key];

		$field = array('label'=>$label,
                        'name'=>$name,
						'value'=>$valueType['value'],
                        'type'=>$valueType['type']
                    );

		return $field;
	}

	public function format_value($key){
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