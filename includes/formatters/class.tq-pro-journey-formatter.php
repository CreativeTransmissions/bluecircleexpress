<?php

/**
 * Define journey Formatter  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Transitjourney_Pro
 * @subpackage Transitjourney_Pro/public
 */

/**
 * 
 * Accepts array of journey data
 * Returns filtered array of fields eachof which contains a label and value formatted for user-readable output
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage Transitjourney_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_JourneyFormatter {

 	private $default_config = array(
 									'journey'=>array(), // associative array of journey data
 									'output_def'=>array()  // output definition: array('field_name1','field_name2')
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['journey'])) {
        //    echo 'TQ_JourneyFormatter: no journey in params';            
            return false;
        };
        $this->journey = $this->config['journey'];

        if (empty($this->config['output_def'])) {
           // echo 'TQ_JourneyFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        if (empty($this->config['labels'])) {
           // echo 'TQ_JourneyFormatter: no labels in params';
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
            if (!isset($this->journey[$key])) {
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
            if (!isset($this->journey[$key])) {
                continue;
            };
            $value = $this->journey[$key];
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
		$value = $this->journey[$key];
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