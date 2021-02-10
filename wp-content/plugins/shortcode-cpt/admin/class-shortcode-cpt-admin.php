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
				'name' => __( 'API Key', 'woo' ),
				'type' => 'text',
				'desc' => __( 'Please enter API Key.', 'woo' ),
				'id'   => 'wc_settings_tab_demo_title',
			),
			'description'   => array(
				'name'     => __( 'API Secret', 'woo' ),
				'type'     => 'textarea',
				'desc'     => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'woocommerce-settings-tab-demo' ),
				'id'       => 'wc_settings_tab_demo_description',
				'desc_tip' => true,
			),
			'choice' => array(
				'name' => __( 'Show Additional settings in settings tab', 'woo' ),
				'type' => 'checkbox',
				'desc' => __( 'If disabled the additional settings will not show.', 'woo' ),
				'id'   => 'wc_settings_tab_demo_choice',
			),
			'section_end' => array(
				'type' => 'sectionend',
				'id'   => 'wc_settings_tab_demo_section_end',
			),
		);
		return apply_filters( 'wc_settings_tab_demo_settings', $settings );
	}
	// ///////////////////////////////////
	public function misha_product_settings_tabs( $tabs ) {
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
	/**
	 * Function to check if current screen is product edit screen. If yes, only then show metadata.
	 */
	public function check_page_for_wporg_add_custom_box() {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}
		switch ( $screen->id ) {
			case 'product':
				$this->wporg_add_custom_box();
				break;
		}
	}
	/**
	 * Function used to add a meta box to product edit screen.
	 */
	public function wporg_add_custom_box() {
		if ( get_option( 'wc_settings_tab_demo_choice' ) === 'yes' ) {
			add_meta_box(
				'wporg_box_id',                 // Unique ID.
				'Custom Meta Box Title',      // Box title.
				array( $this, 'wporg_custom_box_html' )  // Content callback, must be of type callable.
			);
		}
	}
	/**
	 * Callback function of upper function.
	 */
	public function wporg_custom_box_html( $post ) {
		// Save attachment ID.
		wp_enqueue_media();
		?>
		<!-- <label for="wporg_field">Description for this field</label>
		<select name="wporg_field" id="wporg_field" class="postbox">
			<option value="">Select something...</option>
			<option value="something">Something</option>
			<option value="else">Else</option>
		</select> -->	
		<div class='image-preview-wrapper'>
		<img id='image-preview' src='' width='100' height='100' style='max-height: 100px; width: 100px;'>
		</div>
		<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
		<input name='image_attachment_id' id='image_attachment_id' value=''>
		<input type="submit" name="submit_image_selector" value="Save" class="button-primary">
		<!-- <input type="button" class="button insert-media add_media" value="Add Media" id="imagetosend" name="imagetosend"> -->
		<?php
	}
	/**
	 * To save the data from custom meta box.
	 */
	public function wporg_save_postdata( $post_id ) {
		// if ( array_key_exists( 'wporg_field', $_POST ) ) {
		// 	update_post_meta(
		// 		$post_id,
		// 		'_wporg_meta_key',
		// 		$_POST['wporg_field']
		// 	);
		// }
		if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
			// update_option( 'faisal_option', absint( $_POST['image_attachment_id'] ) );
			update_post_meta(
				$post_id,
				'faisal_meta_key',
				$_POST['image_attachment_id']
			);
		endif;
	}
	public function media_selector_print_scripts() {

		$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
		?><script type='text/javascript'>
			jQuery( document ).ready( function( $ ) {
				// Uploading files
				var file_frame;
				var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
				var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
				jQuery('#upload_image_button').on('click', function( event ){
					event.preventDefault();
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						// Set the post ID to what we want
						file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
						// Open frame
						file_frame.open();
						return;
					} else {
						// Set the wp.media post id so the uploader grabs the ID we want when initialised
						wp.media.model.settings.post.id = set_to_post_id;
					}
					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						title: 'Select a image to upload',
						button: {
							text: 'Use this image',
						},
						multiple: false	// Set to true to allow multiple files to be selected
					});
					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						// We set multiple to false so only get one image from the uploader
						attachment = file_frame.state().get('selection').first().toJSON();
						// Do something with attachment.id and/or attachment.url here
						$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
						$( '#image_attachment_id' ).val( attachment.url );
						// Restore the main post ID
						wp.media.model.settings.post.id = wp_media_post_id;
					});
						// Finally, open the modal
						file_frame.open();
				});
				// Restore the main ID when the add media button is pressed
				jQuery( 'a.add_media' ).on( 'click', function() {
					wp.media.model.settings.post.id = wp_media_post_id;
				});
			});
		</script>
		<?php
	}


}
