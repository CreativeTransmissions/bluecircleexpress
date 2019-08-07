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

 	private $default_config = array('waypoints'=>array(), // associative array of waypoint data
 									'output_def'=>array(),  // output definition: array('field_name1','field_name2')
                                    'labels'=>array() // array('appartment_no'=>'Unit No', 'postal_code'=>'Postcode'),
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
        $this->labels = array();
        $this->output = array();
	}

	public function has_required_params(){

        if (empty($this->config['waypoints'])) {
            echo 'TQ_waypointFormatter: no waypoint in params';            
            return false;
        };
        $this->waypoints = $this->config['waypoints'];

        if (empty($this->config['output_def'])) {
            echo 'TQ_waypointFormatter: no output_def in params';

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

        foreach ($this->waypoints as $waypoint) {
            $formatted_waypoint = $this->format_waypoint($waypoint);
            if(is_array($formatted_waypoint)){
                $this->output[] = $formatted_waypoint;
            }
        }
 		return $this->output;
	}

    public function format_waypoint($waypoint){

        $output = array();
        foreach ($this->output_def as $key) {
            if (!isset($waypoint[$key])) {
                continue;
            };
            $value = $waypoint[$key];            
            $output[] = $this->format_field($value, $key);
        };

        return $output;
    }

    public function format_not_empty_only(){

        if(!$this->has_required_params()){
            return false;
        };

        foreach ($this->waypoints as $waypoint) {
            $formatted_waypoint = $this->format_waypoint_not_empty($waypoint);
            if(is_array($formatted_waypoint)){
                $this->output[] = $formatted_waypoint;
            }
        }
        return $this->output;
    }

    public function format_waypoint_not_empty($waypoint){

        $output = array();
        foreach ($this->output_def as $key) {
            if (!isset($waypoint[$key])) {
                continue;
            };
            if (empty($waypoint[$key])) {
                continue;
            };            
            $value = $waypoint[$key];
            if($value===''){
                continue;
            };
            $output[] = $this->format_field($value, $key);
        };

        return $output;
    }


	public function format_field($value, $key){
		
        $name = $key;        
		$valueType = $this->format_value($value, $key);

		$field = array( 'name'=>$name,
						'value'=>$valueType['value'],
                        'type'=>$valueType['type']
                    );

        if(isset($this->labels[$key])){
            if(!empty($this->labels[$key])){
                $field['label'] = $this->labels[$key];
            };
        };

		return $field;
	}

	public function format_value($value, $key){
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