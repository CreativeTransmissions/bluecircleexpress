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
 									'tax_name'=>'Tax', // ie VAT etc
                                    'include_zeros'=>true // dont include name/values if value is 0
 									);

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function has_required_params(){
        if (empty($this->config['quote'])) {
        //    echo 'TQ_QuoteFormatter: no quote in params';            
            return false;
        };
        $this->quote = $this->config['quote'];

        if (empty($this->config['output_def'])) {
           // echo 'TQ_QuoteFormatter: no output_def in params';

            return false;
        };
        $this->output_def = $this->config['output_def'];

        if (empty($this->config['labels'])) {
           // echo 'TQ_QuoteFormatter: no labels in params';
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
            if(is_array($this->quote[$key])){
                $formatted_array_fields = $this->format_field_from_array($key, $this->quote[$key]);
                $output = array_merge($output, $formatted_array_fields);
            } else {
                $output[] = $this->format_field($key);

            }
        };

        return $output;
	}

    public function format_non_zero_only(){

        if(!$this->has_required_params()){
            return false;
        };

        $output = array();
        foreach ($this->output_def as $key) {
            if (!isset($this->quote[$key])) {
                continue;
            };
            $value = $this->quote[$key];
            if (is_numeric($value)) {
                if($value==0){
                    continue;
                };
            };            
            if(is_array($this->quote[$key])){
                $formatted_array_fields = $this->format_field_from_array($key, $this->quote[$key]);
                $output = array_merge($output, $formatted_array_fields);                
            } else {
                $output[] = $this->format_field($key);
            }
        };

        return $output;
    }

	public function format_field($key){
		
        $name = $key;        
		$valueType = $this->format_value($key);
        if(isset($this->labels[$key])){
            $label = $this->labels[$key];
        } else {
            $label = ucfirst($key);
        };
		$field = array('label'=>$label,
                        'name'=>$name,
                        'value'=>$valueType['value'],
                        'type'=>$valueType['type']                        
                    );

		return $field;
	}

    public function format_field_from_array($name, $values = array()){
        $base_name = rtrim($name,'s'); //'surcharge', 'stage'
        $output_rows = array();
        foreach ($values as $key => $row) {
            $name = $base_name.'_'.$key;
            if(isset($this->labels[$key])){
                $label = $this->labels[$base_name].' ('.$key.')';
            } else {
                $label = ucfirst($base_name).' ('.$key.')';
            };

            switch ($base_name) {
                case 'surcharge':
                    $value = $this->format_surcharge_for_output($row);
                    $label = $row['name'];
                    break;
                case 'stage':
                    $value = $this->format_stage_for_output($row);
                    $rate_type = $this->get_rate_type_for_id($row['rates']);
                    if(isset($this->labels[$key])){
                        $label = $this->labels[$base_name].' '.$key.' ('.$rate_type.' Rate)';
                    } else {
                        $label = ucfirst($base_name).' '.$key.' ('.$rate_type.' Rate)';
                    };                    
                default:
                    break;
            };

            $field = array( 'label'=>$label,
                            'name'=>$name,
                            'value'=>$value,
                            'type'=>$base_name                        
            );

            $output_rows[] = $field;         
        };
        return $output_rows;
    }

	public function format_value($key, $value = null){
        if($value === null){
            $value = $this->quote[$key];
        }
        $field = array();
 		switch ($key) {
            case 'notice_cost':
            case 'time_cost':
            case 'rate_hour':
            case 'rate_tax':
            case 'tax_cost':
            case 'rates':
                if(is_string($value)){
                    $field['value'] = ucfirst($value);
                    $field['type'] = 'text';
                } else {
                    return [];
                };
                break;
            default:
                $field['value'] = $value;
                $field['type'] = 'number';
                break;                
          };

          return $field;

	}

    public function format_stage_for_output($stage_row){
        $value_html =  $stage_row['stage_total'];
        return $value_html;
    }

    public function get_rate_type_for_id($rate_type_id){
        if($rate_type_id===1){
            $rate_type = $this->labels['dispatch_stage_label'];
        } else {
            $rate_type = $this->labels['standard_stage_label'];
        };
        return $rate_type;
    }
    public function format_surcharge_for_output($surcharge_row){
        $value_html =  $surcharge_row['amount'];
        return $value_html;
    }


}
?>