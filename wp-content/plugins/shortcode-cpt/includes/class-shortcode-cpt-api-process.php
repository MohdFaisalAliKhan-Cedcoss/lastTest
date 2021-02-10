<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Shortcode_cpt_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Hydroshop_Api_Management
	 * @subpackage Hydroshop_Api_Management/includes
	 * @author     MakeWebBetter <makewebbetter.com>
	 */
	class Shortcode_cpt_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   Array $sc_request  data of requesting headers and other information.
		 * @return  Array $mwb_sc_rest_response    returns processed data and status of operations.
		 */
		public function mwb_sc_default_process( $sc_request ) {
			$mwb_sc_rest_response = array();

			// Write your custom code here.

			$mwb_sc_rest_response['status'] = 200;
			$mwb_sc_rest_response['data'] = $sc_request->get_headers();
			return $mwb_sc_rest_response;
		}
	}
}
