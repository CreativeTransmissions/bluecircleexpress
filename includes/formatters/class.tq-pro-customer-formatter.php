<?php

/**
 * Define customer Formatter  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Transitcustomer_Pro
 * @subpackage Transitcustomer_Pro/public
 */

/**
 * 
 * Accepts array of customer data
 * Returns filtered array of fields eachof which contains a label and value formatted for user-readable output
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage Transitcustomer_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_CustomerFormatter {

 	private $default_config = array(
 									'customer'=>array(), // associative array of customer data
 									'output_def'=>array('first_name',
                                                        'last_name',
                                                        'email',
                                                        'phone')  // output definition: array('field_name1','field_name2')
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['customer'])) {
            echo 'TQ_CustomerFormatter: no customer in params';            
            return false;
        };
        $this->customer = $this->config['customer'];

        if (empty($this->config['output_def'])) {
            echo 'TQ_CustomerFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        if (!empty($this->config['labels'])) {
            $this->labels = $this->config['labels'];
        };

        return true; 
	}

	public function format(){

		if(!$this->has_required_params()){
			return false;
		};

 		$output = array();
        foreach ($this->output_def as $key) {
            if (!isset($this->customer[$key])) {
                continue;
            };
            $output[] = $this->format_field($key);
        };

        return $output;
	}

    public function format_not_empty_only(){

        if(!$this->has_required_params()){
            return false;
        };

        $output = array();
        foreach ($this->output_def as $key) {
            if (!isset($this->customer[$key])) {
                continue;
            };
            $value = $this->customer[$key];
            if($value===''){
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
		$value = $this->customer[$key];
        $field = array();
 		switch ($key) {
            default:
                $field['value'] = $value;
                $field['type'] = 'text';
                break;                
          };

          return $field;

	}

}
?>