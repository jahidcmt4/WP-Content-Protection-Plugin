<?php 

/**
 * Codestar Framework Integrate
*/

if ( file_exists( JH_PATH . 'includes/admin/framework/codestar-framework.php' ) ) {
    require_once JH_PATH . 'includes/admin/framework/codestar-framework.php';
}

/**
 * Global Option Page
*/

if ( file_exists( JH_PATH . 'includes/admin/options/global.php' ) ) {
    require_once JH_PATH . 'includes/admin/options/global.php';
}


/**
 * Admin assets Enqueue
*/

add_action('admin_enqueue_scripts', 'disabled_source_admin_page_script');
function disabled_source_admin_page_script(){
	wp_enqueue_style( 'disabled-source-and-content-protection-css', JH_URL.'includes/admin/assets/css/admin.css', false, '1.1.0');
}


/**
 * Front End assets Enqueue
*/

add_action('wp_enqueue_scripts', 'disabled_source_front_page_script', 100);
function disabled_source_front_page_script(){

	$jh_disabled_options_script = get_option( 'jh_disabled_option' );
	if (!is_user_logged_in() )
    {
    	if($jh_disabled_options_script['disabled-content-select']=="1"){
			wp_enqueue_style( 'disabled-source-and-content-protection-css', JH_URL.'includes/assets/css/style.css', false, '1.0.0');
		}
		wp_enqueue_script( 'disabled-source-and-content-protection-js', JH_URL.'includes/assets/js/protection.js', array('jquery'), '1.2.0', true );
		$jh_disabled_options_data_pass = array(
		    'disabled_click' => $jh_disabled_options_script['disabled-right-click'],
		    'disabled_ct_u' => $jh_disabled_options_script['disabled-ct-u'],
		    'disabled_f12' => $jh_disabled_options_script['disabled-f12'],
		    'disabled_ctst_i' => $jh_disabled_options_script['disabled-ct-st-i'],
		    'disabled_ctst_j' => $jh_disabled_options_script['disabled-ct-st-j'],
		    'disabled_ctst_c' => $jh_disabled_options_script['disabled-ct-st-c']
		);
		wp_localize_script( 'disabled-source-and-content-protection-js', 'jh_disabled_options_data', $jh_disabled_options_data_pass );
	}
}


/**
 * Front End Comments Control
*/

$jh_disabled_options = get_option( 'jh_disabled_option' );

if($jh_disabled_options['disabled-comments']=="1"){

	add_action('admin_init', function () {

	    // Remove comments metabox from dashboard
	    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

	    // Disable support for comments and trackbacks in post types
	    foreach (get_post_types() as $post_type) {
	        if (post_type_supports($post_type, 'comments')) {
	            remove_post_type_support($post_type, 'comments');
	            remove_post_type_support($post_type, 'trackbacks');
	        }
	    }
	});

	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);

	// Hide existing comments
	add_filter('comments_array', '__return_empty_array', 10, 2);

}

/**
 * IP Address Blocker
*/

function disabled_source_ipblocker(){
	$jh_disabled_ip_address= get_option( 'jh_disabled_option' );
	
    if (!empty($jh_disabled_ip_address['disabled_ip_section'])) {
    	$jh_disabled_ip_address_list = [];
    	foreach($jh_disabled_ip_address['disabled_ip_section'] as $singleip){
    		$jh_disabled_ip_address_list[] = "Deny from {$singleip['disabled_ip']}";
    	}
    	$htaccess = ABSPATH . ".htaccess";
        insert_with_markers($htaccess, 'JHIPBlocker', $jh_disabled_ip_address_list);
    }
}
add_action('csf_jh_disabled_option_save_after', 'disabled_source_ipblocker');


?>