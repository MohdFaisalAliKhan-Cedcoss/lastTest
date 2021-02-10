<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Shortcode_cpt
 *
 * @wordpress-plugin
 * Plugin Name:       shortcode-cpt
 * Plugin URI:        https://makewebbetter.com/product/shortcode-cpt/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       shortcode-cpt
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_shortcode_cpt_constants() {

	shortcode_cpt_constants( 'SHORTCODE_CPT_VERSION', '1.0.0' );
	shortcode_cpt_constants( 'SHORTCODE_CPT_DIR_PATH', plugin_dir_path( __FILE__ ) );
	shortcode_cpt_constants( 'SHORTCODE_CPT_DIR_URL', plugin_dir_url( __FILE__ ) );
	shortcode_cpt_constants( 'SHORTCODE_CPT_SERVER_URL', 'https://makewebbetter.com' );
	shortcode_cpt_constants( 'SHORTCODE_CPT_ITEM_REFERENCE', 'shortcode-cpt' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function shortcode_cpt_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shortcode-cpt-activator.php
 */
function activate_shortcode_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcode-cpt-activator.php';
	Shortcode_cpt_Activator::shortcode_cpt_activate();
	$mwb_sc_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_sc_active_plugin ) && ! empty( $mwb_sc_active_plugin ) ) {
		$mwb_sc_active_plugin['shortcode-cpt'] = array(
			'plugin_name' => __( 'shortcode-cpt', 'shortcode-cpt' ),
			'active' => '1',
		);
	} else {
		$mwb_sc_active_plugin = array();
		$mwb_sc_active_plugin['shortcode-cpt'] = array(
			'plugin_name' => __( 'shortcode-cpt', 'shortcode-cpt' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_sc_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shortcode-cpt-deactivator.php
 */
function deactivate_shortcode_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcode-cpt-deactivator.php';
	Shortcode_cpt_Deactivator::shortcode_cpt_deactivate();
	$mwb_sc_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_sc_deactive_plugin ) && ! empty( $mwb_sc_deactive_plugin ) ) {
		foreach ( $mwb_sc_deactive_plugin as $mwb_sc_deactive_key => $mwb_sc_deactive ) {
			if ( 'shortcode-cpt' === $mwb_sc_deactive_key ) {
				$mwb_sc_deactive_plugin[ $mwb_sc_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_sc_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_shortcode_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_shortcode_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcode-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shortcode_cpt() {
	define_shortcode_cpt_constants();

	$sc_plugin_standard = new Shortcode_cpt();
	$sc_plugin_standard->sc_run();
	$GLOBALS['sc_mwb_sc_obj'] = $sc_plugin_standard;

}
run_shortcode_cpt();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 'sc_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function sc_add_default_endpoint() {
	register_rest_route(
		'sc-route',
		'/sc-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_sc_default_callback',
			'permission_callback' => 'mwb_sc_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_sc_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_sc_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_sc_default_callback( $request ) {
	require_once SHORTCODE_CPT_DIR_PATH . 'includes/class-shortcode-cpt-api-process.php';
	$mwb_sc_api_obj = new Shortcode_cpt_Api_Process();
	$mwb_sc_resultsdata = $mwb_sc_api_obj->mwb_sc_default_process( $request );
	if ( is_array( $mwb_sc_resultsdata ) && isset( $mwb_sc_resultsdata['status'] ) && 200 == $mwb_sc_resultsdata['status'] ) {
		unset( $mwb_sc_resultsdata['status'] );
		$mwb_sc_response = new WP_REST_Response( $mwb_sc_resultsdata, 200 );
	} else {
		$mwb_sc_response = new WP_Error( $mwb_sc_resultsdata );
	}
	return $mwb_sc_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'shortcode_cpt_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function shortcode_cpt_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=shortcode_cpt_menu' ) . '">' . __( 'Settings', 'shortcode-cpt' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
