<?php

/**
 * Define waypoint Formatter  functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Transitwaypoint_Pro
 * @subpackage Transitwaypoint_Pro/public
 */

/**
 * 
 * Accepts array of waypoint data
 * Returns filtered array of fields eachof which contains a label and value formatted for user-readable output
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage Transitwaypoint_Pro/admin
 * @author     Andrew van Duivenbode <hq@customgooglemaptools.com>
 */
namespace TransitQuote_Pro4;
class TQ_WaypointFormatter {

 	private $default_config = array('waypoint'=>array(), // associative array of waypoint data
 									'output_def'=>array()  // output definition: array('field_name1','field_name2')
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['waypoint'])) {
            echo 'TQ_waypointFormatter: no waypoint in params';            
            return false;
        };
        $this->waypoint = $this->config['waypoint'];

        if (empty($this->config['output_def'])) {
            echo 'TQ_waypointFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        return true; 
	}

	public function format(){

		if(!$this->has_required_params()){
			return false;
		};

 		$output = array();
        foreach ($this->output_def as $key) {
            if (!isset($this->waypoint[$key])) {
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
            if (!isset($this->waypoint[$key])) {
                continue;
            };
            $value = $this->waypoint[$key];
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

		$field = array( 'name'=>$name,
						'value'=>$valueType['value'],
                        'type'=>$valueType['type']
                    );

		return $field;
	}

	public function format_value($key){
		$value = $this->waypoint[$key];
        $field = array();
 		switch ($key) {
            case 'lat':
            case 'lng':
                $field['value'] = $value;
                $field['type'] = 'number';
                break;

            default:
                $field['value'] = ucfirst($value);
                $field['type'] = 'text';
                break;                
          };

          return $field;

	}

}
?>