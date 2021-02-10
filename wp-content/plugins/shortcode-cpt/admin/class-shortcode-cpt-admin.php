<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shortcode_cpt_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function sc_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-sc-select2-css', SHORTCODE_CPT_DIR_URL . 'admin/css/shortcode-cpt-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, SHORTCODE_CPT_DIR_URL . 'admin/css/shortcode-cpt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function sc_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-sc-select2', SHORTCODE_CPT_DIR_URL . 'admin/js/shortcode-cpt-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', SHORTCODE_CPT_DIR_URL . 'admin/js/shortcode-cpt-admin.js', array( 'jquery', 'mwb-sc-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'sc_admin_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=shortcode_cpt_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for shortcode-cpt.
	 *
	 * @since    1.0.0
	 */
	public function sc_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'shortcode-cpt' ), __( 'MakeWebBetter', 'shortcode-cpt' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), SHORTCODE_CPT_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$sc_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $sc_menus ) && ! empty( $sc_menus ) ) {
				foreach ( $sc_menus as $sc_key => $sc_value ) {
					add_submenu_page( 'mwb-plugins', $sc_value['name'], $sc_value['name'], 'manage_options', $sc_value['menu_link'], array( $sc_value['instance'], $sc_value['function'] ) );
				}
			}
		}
	}


	/**
	 * shortcode-cpt sc_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function sc_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'shortcode-cpt', 'shortcode-cpt' ),
			'slug'            => 'shortcode_cpt_menu',
			'menu_link'       => 'shortcode_cpt_menu',
			'instance'        => $this,
			'function'        => 'sc_options_menu_html',
		);
		return $menus;
	}


	/**
	 * shortcode-cpt mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require SHORTCODE_CPT_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * shortcode-cpt admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function sc_options_menu_html() {

		include_once SHORTCODE_CPT_DIR_PATH . 'admin/partials/shortcode-cpt-admin-display.php';
	}

	/**
	 * shortcode-cpt admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $sc_settings_general Settings fields.
	 */
	public function sc_admin_general_settings_page( $sc_settings_general ) {
		$sc_settings_general = array(
			array(
				'title' => __( 'Text Field Demo', 'shortcode-cpt' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_text_demo',
				'value' => '',
				'class' => 'sc-text-class',
				'placeholder' => __( 'Text Demo', 'shortcode-cpt' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'shortcode-cpt' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_number_demo',
				'value' => '',
				'class' => 'sc-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'shortcode-cpt' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_password_demo',
				'value' => '',
				'class' => 'sc-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'shortcode-cpt' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_textarea_demo',
				'value' => '',
				'class' => 'sc-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'shortcode-cpt' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'shortcode-cpt' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_select_demo',
				'value' => '',
				'class' => 'sc-select-class',
				'placeholder' => __( 'Select Demo', 'shortcode-cpt' ),
				'options' => array(
					'INR' => __( 'Rs.', 'shortcode-cpt' ),
					'USD' => __( '$', 'shortcode-cpt' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'shortcode-cpt' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_multiselect_demo',
				'value' => '',
				'class' => 'sc-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'shortcode-cpt' ),
				'options' => array(
					'INR' => __( 'Rs.', 'shortcode-cpt' ),
					'USD' => __( '$', 'shortcode-cpt' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'shortcode-cpt' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_checkbox_demo',
				'value' => '',
				'class' => 'sc-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'shortcode-cpt' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'shortcode-cpt' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'shortcode-cpt' ),
				'id'    => 'sc_radio_demo',
				'value' => '',
				'class' => 'sc-radio-class',
				'placeholder' => __( 'Radio Demo', 'shortcode-cpt' ),
				'options' => array(
					'yes' => __( 'YES', 'shortcode-cpt' ),
					'no' => __( 'NO', 'shortcode-cpt' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'sc_button_demo',
				'button_text' => __( 'Button Demo', 'shortcode-cpt' ),
				'class' => 'sc-button-class',
			),
		);
		return $sc_settings_general;
	}
	/**
	 * Add a setting tab.
	 */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['settings_tab_demo'] = __( 'Dropbox Upload ', 'woocommerce-settings-tab-demo' );
		return $settings_tabs;
	}
		/**
		 * Above function get_settings will be called from this function
		 */
	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}
		/**
		 * Function to save the settings made in the function above.
		 */
	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
	}

	/**
	 * Add settings to the setting tab.
	 */
	public function get_settings() {
		$settings = array(
			'section_title' => array(
				'name' => __( 'Upload images in Dropbox', 'woo' ),
				'type' => 'title',
				'desc' => '',
				'id'   => 'wc_settings_tab_demo_section_title',
			),
			'title' => array(
				'name' => __( 'URL', 'woo' ),
				'type' => 'text',
				'desc' => __( 'Please enter URL(POST or GET).', 'woo' ),
				'id'   => 'wc_settings_tab_demo_title',
			),
			'description'   => array(
				'name'     => __( 'cURL request', 'woo' ),
				'type'     => 'textarea',
				'desc'     => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'woocommerce-settings-tab-demo' ),
				'id'       => 'wc_settings_tab_demo_description',
				'desc_tip' => true,
			),
			'section_end' => array(
				'type' => 'sectionend',
				'id'   => 'wc_settings_tab_demo_section_end',
			),
		);
		return apply_filters( 'wc_settings_tab_demo_settings', $settings );
	}
	// ///////////////////////////////////
	public function misha_product_settings_tabs( $tabs ){
		//unset( $tabs['inventory'] );
		$tabs['misha'] = array(
			'label'    => 'Upload image by Access Token',
			'target'   => 'misha_product_data',
			'priority' => 21,
		);
		return $tabs;
	}
	public function misha_product_panels(){
		echo '<div id="misha_product_data" class="panel woocommerce_options_panel hidden">';
		woocommerce_wp_text_input( array(
			'id'                => 'misha_plugin_version',
			'value'             => get_post_meta( get_the_ID(), 'misha_plugin_version', true ),
			'label'             => 'Upload a profile picture by entering the ',
			'description'       => 'Should be in jpg or png format.'
		) );
		// woocommerce_wp_textarea_input( array(
		// 	'id'          => 'misha_changelog',
		// 	'value'       => get_post_meta( get_the_ID(), 'misha_changelog', true ),
		// 	'label'       => 'Changelog',
		// 	'desc_tip'    => true,
		// 	'description' => 'Prove the plugin changelog here',
		// ) );
		woocommerce_wp_select( array(
			'id'          => 'misha_ext',
			'value'       => get_post_meta( get_the_ID(), 'misha_ext', true ),
			'label'       => 'File extension',
			'options'     => array( '' => 'Please select', 'zip' => 'Zip', 'gzip' => 'Gzip'),
		) );
		echo '</div>';
	}
	

}
