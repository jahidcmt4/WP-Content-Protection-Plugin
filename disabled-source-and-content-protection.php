<?php
/**
 * Plugin Name:       Disabled Source, Disabled Right Click and Content Protection
 * Plugin URI:        https://themefic.com/
 * Description:       Disabled Source(Ctrl+U), Disabled Right click, Disable F12 functional key, and Disable save the page(Ctrl+S) and Content Protection of your WordPress Blog.
 * Version:           1.1.1 
 * Requires at least: 4.7
 * Tested up to: 6.0.1
 * Requires PHP:      5.3
 * Text Domain: disabled-source-disabled-right-click-and-content-protection
 * Author:            jahidcse
 * Author URI:        https://profiles.wordpress.org/jahidcse/
 */


// don't load directly
defined( 'ABSPATH' ) || exit;


//URL

define( 'JH_URL', plugin_dir_url( __FILE__ ) );
define( 'JH_PATH', plugin_dir_path( __FILE__ ) );


/**
 * Functions include
*/

if ( file_exists( JH_PATH . 'includes/functions/functions.php' ) ) {
    require_once JH_PATH . 'includes/functions/functions.php';
}

/**
 * Plugin Activation redirect page
 * https://developer.wordpress.org/reference/hooks/activated_plugin/
*/


function disablde_source_activated_deshboard_settings($plugin){
    if (plugin_basename(__FILE__)==$plugin) {
        wp_redirect(admin_url('admin.php?page=disabled-source-disabled-right-click-and-content-protection'));
        die();
    }
}
add_action('activated_plugin','disablde_source_activated_deshboard_settings');

/**
 * Plugin Settings page
*/

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),'disablde_source_deshboard_settings');

function disablde_source_deshboard_settings( $links ) {
  $link = sprintf( "<a href='%s' style='color:#2271b1;'>%s</a>", admin_url( 'admin.php?page=disabled-source-disabled-right-click-and-content-protection'), __( 'Settings', 'disabled-source-disabled-right-click-and-content-protection' ) );
  array_push( $links, $link );

  return $links;
}
