<?php

/**
 * Define Calculation functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Pro
 * @subpackage TransitQuote_Pro/public
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      3.0.0
 * @package    TQ_Calculation
 * @subpackage TransitQuote_Pro/admin
 * @author     Andrew van Duivenbode <hq@transitquote.co.uk>
 */
namespace TransitQuote_Pro4;
class TQ_RefGenerator {

 	private $default_config = array('cdb'=>null,
 									'prefix'=>'',
 									'length'=>0); 

    public function __construct($config = null) {
        //merge config with defaults so all properties are present
		$this->config = array_merge($this->default_config, $config);
	}

	public function genearte_unique_ref(){

		do {
			$ref = $this->generate_ref();
			$is_unique = $this->ref_is_unique($ref);
			if($is_unique==='db error'){
				return false;
			};
		} while (!$is_unique);
		return $ref;

	}
	public function generate_ref(){
		$ref = $this->config['prefix'];
		$length = $this->config['length'];
		$random_digits = $this->generate_random_digits($length);
		$ref = $ref.$random_digits;
		return $ref;
	}

	function generate_random_digits($length, $keyspace = '0123456789'){
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    };
	    return implode('', $pieces);
	}

	public function ref_is_unique($ref){
		$jobs_refs = $this->config['cdb']->get_rows('jobs',array('job_ref'=>$ref),array('job_ref'));
		if(count($jobs_refs)===0){
			return true;
		};
		if($jobs_refs===false){
			return 'db error';
		};
		return false;

	}

}

