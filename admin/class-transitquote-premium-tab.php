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
		$this->key = $this->config['key'];
	}

	public function register_tab(){
    	//register an admin tab from a config array
    	if(empty($this->config)){
    		return false;
    	};
    	//register settings tab
    	register_setting($this->config['key'], $this->config['key']); 

    	//register settings for tab
    	foreach ($this->config['sections'] as $key => $section) {
    		add_settings_section(	$this->config['key'],
    								$section['title'],
    								array( $this, 'tab_callback' ),
    								$this->config['key']);
    	}
	    
    }

    public function render(){
    	echo '<div class="wrap">';
    	include_once $this->config['partials_path'].$this->key.'.php';
    	echo '</div>';
    }

    public function render_nav($active = ''){
    	// render links for nav
   		echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->config['plugin_slug'] . '&tab=' . $this->key . '">' . $this->config['title'] . '</a>';
    }

    public function tab_callback(){
    	echo 'This is the tab callback for: '.$this->config['key'];
    }

}
