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

 	private $default_config = array('distance_unit',
 									'journey'=>array(), // associative array of journey data
 									'output_def'=>array('distance','time')  // output definition: array('field_name1','field_name2')
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['journey'])) {
           //echo 'TQ_JourneyFormatter: no journey in params';            
            return false;
        };
        $this->journey = $this->config['journey'];

        if (!empty($this->config['output_def'])) {
            $this->output_def = $this->config['output_def'];
        };


        if (empty($this->config['distance_unit'])) {
            echo 'TQ_JourneyFormatter: no distance_unit in params';

            return false;
        };
        $this->distance_unit = $this->config['distance_unit'];

        if (!empty($this->config['labels'])) {
            $this->labels = $this->config['labels'];

        };

        return true; 
	}

	public function format(){

		if(!$this->has_required_params()){
            echo 'TQ_JourneyFormatter: doesnt have requried params';
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
		$value = $this->journey[$key];
        $field = array();
        $field['name'] = $key;
        $label = $this->labels[$key.'_label'];        
        switch ($key) {
            case 'distance':
                $field['label'] = $label.' (' . $this->distance_unit . 's)';
                $field['value'] = number_format((float) $value, 2, '.', '');
                $field['type'] = 'number';                
                break;
            case 'time':
                $field['label'] = $label.' (Hours)';
                $field['value'] = number_format((float) $value, 2, '.', '');
                $field['type'] = 'number';
                break;            
            default:
                $field['label'] = $label;
                $field['value'] = $value;
                $field['type'] = 'text';
                break;                
          };

          return $field;
	}


}
?>