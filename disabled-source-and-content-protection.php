<?php
/**
 * Plugin Name:       Disabled Source, Disabled Right Click and Content Protection
 * Plugin URI:        https://themefic.com/
 * Description:       Disabled source, disabled right click and disabled to copy content of your wordpress website.
 * Version:           1.0 
 * Requires at least: 4.7
 * Tested up to: 6.0.1
 * Requires PHP:      5.3
 * Text Domain: disabled_source
 * Author:            jahidcse
 * Author URI:        https://profiles.wordpress.org/jahidcse/


 */

/**
* OOP Class Disabled Source and Content Protection
*/

class JH_Disabledsource{

public function __construct() {

$file_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );

$this->plugin                           = new stdClass;
$this->plugin->name                     = 'disabled-source-and-content-protection';
$this->plugin->version                  = $file_data['Version'];
$this->plugin->folder                   = plugin_dir_path( __FILE__ );
$this->plugin->url                      = plugin_dir_url( __FILE__ );

/**
* Hooks
*/

add_action('wp_enqueue_scripts', array($this,'disabled_source_front_page_script'), 100);

}

function disabled_source_front_page_script(){
	if (!is_user_logged_in() )
    {
		wp_enqueue_style( 'disabled-source-and-content-protection-css', plugins_url('/assets/css/style.css', __FILE__), false, $this->plugin->version);
		wp_enqueue_script( 'disabled-source-and-content-protection-js', plugins_url('/assets/js/protection.js', __FILE__), array('jquery'), $this->plugin->version, true );
	}
}


}


$JH_Disabledsource = new JH_Disabledsource();