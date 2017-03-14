<?php

/**
 * Define Admin Tab functionality
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    TransitQuote_Premium
 * @subpackage TransitQuote_Premium/admin
 * @author     Your Name <email@example.com>
 */
class TransitQuote_Premium_Tab {


	public function __construct($config = null) {
		$this->config = $config;
		$this->tab_key = $this->config['tab_key'];
		$this->admin = $this->config['admin'];
		$this->cdb = $this->admin->cdb;
        $this->sections = array();
	}

	public function register_tab(){
    	//register an admin tab from a config array
    	if(empty($this->config)){
    		return false;
    	};
    	//register settings tab
    	register_setting($this->config['tab_key'], $this->config['tab_key']); 


    	//register settings for tab
    	foreach ($this->config['sections'] as $key => $section_config) {
            $section_config['page'] = $this->tab_key;
            $section_config['admin'] = $this->admin;
            $this->sections[$key] = new TransitQuote_Premium_Settings_Section($section_config);
            $this->sections[$key]->add_section();
    	}
	    
    }

    public function render_nav($active = ''){
    	// render links for nav
   		echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->config['plugin_slug'] . '&tab=' . $this->tab_key . '">' . $this->config['title'] . '</a>';
    }

    public function render(){
    	echo '<div class="wrap">';
        include_once $this->config['partials_path'].$this->tab_key.'.php';
        echo '</div>';
    }

    public function get_empty_message(){
    	// where a table is in use, return default messag within table html before ajax load
    	$empty_message = 'No data in database';

    	if(isset($this->config['table'])){
    		$table_count = $this->get_table_count();
			if($table_count == 0){
				$empty_message = 'There are no '.$this->config['table'].' in the database yet.';
			} else {
				$empty_message = 'Loading '.$this->config['table'].'...';
			}
    	};

		return $empty_message;
    }

    private function get_table_count(){
    	return $this->cdb->get_count($this->config['table']);
    }
}
