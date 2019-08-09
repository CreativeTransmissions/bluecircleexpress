<?php

/**
 * Define job Formatter  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Transitjob_Pro
 * @subpackage Transitjob_Pro/public
 */

/**
 * 
 * Accepts array of job data
 * Returns filtered array of fields eachof which contains a label and value formatted for user-readable output
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage Transitjob_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_JobFormatter {

 	private $default_config = array(
                                    'job'=>array(), // associative array of job data
                                    'services'=>array(), // associative array of job data
 									'vehicles'=>array(), // associative array of job data
 									'output_def'=>array()  // output definition: array('field_name1','field_name2')
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['job'])) {
        //    echo 'TQ_JobFormatter: no job in params';            
            return false;
        };
        $this->job = $this->config['job'];

        if (empty($this->config['output_def'])) {
           // echo 'TQ_JobFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        if (empty($this->config['labels'])) {
           // echo 'TQ_JobFormatter: no labels in params';
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
            if (!isset($this->job[$key])) {
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
            if (!isset($this->job[$key])) {
                continue;
            };
            $value = $this->job[$key];
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
		$value = $this->job[$key];
        $field = array();
 		switch ($key) {
            case 'service_id':
                if (self::using_service_types($value)) {
                    $out[] = self::format_service_type($value);
                };
                break;
            case 'vehicle_id':
                if (self::using_vehicle_types($value)) {
                    $out[] = self::format_vehicle_type($value);
                };
                break;            
            default:
                $field['value'] = urldecode($value);
                $field['type'] = 'text';
                break;                
          };

          return $field;

	}

    private function format_service_type($value) {
        $field = array('label' => 'Service');
        $service_name = '';
        if (isset($this->services[$value])) {
            $service_name = $this->services[$value]['name'];
        };
        $field['value'] = $service_name;
        return $field;
    }

    private function format_vehicle_type($value) {
        $field = array('label' => 'Vehicle');
        $vehicle_name = '';
        if (isset($this->vehicles[$value])) {
            $vehicle_name = $this->vehicles[$value]['name'];
        };
        $field['value'] = $vehicle_name;
        return $field;
    }
}
?>