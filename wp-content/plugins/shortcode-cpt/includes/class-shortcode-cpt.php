<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shortcode_cpt {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Shortcode_cpt_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'SHORTCODE_CPT_VERSION' ) ) {

			$this->version = SHORTCODE_CPT_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'shortcode-cpt';

		$this->shortcode_cpt_dependencies();
		$this->shortcode_cpt_locale();
		$this->shortcode_cpt_admin_hooks();
		$this->shortcode_cpt_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Shortcode_cpt_Loader. Orchestrates the hooks of the plugin.
	 * - Shortcode_cpt_i18n. Defines internationalization functionality.
	 * - Shortcode_cpt_Admin. Defines all hooks for the admin area.
	 * - Shortcode_cpt_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shortcode_cpt_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shortcode-cpt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shortcode-cpt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-shortcode-cpt-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-shortcode-cpt-public.php';

		$this->loader = new Shortcode_cpt_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Shortcode_cpt_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shortcode_cpt_locale() {

		$plugin_i18n = new Shortcode_cpt_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shortcode_cpt_admin_hooks() {

		$sc_plugin_admin = new Shortcode_cpt_Admin( $this->sc_get_plugin_name(), $this->sc_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $sc_plugin_admin, 'sc_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $sc_plugin_admin, 'sc_admin_enqueue_scripts' );

		// Add settings menu for shortcode-cpt.
		$this->loader->add_action( 'admin_menu', $sc_plugin_admin, 'sc_options_page' );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $sc_plugin_admin, 'sc_admin_submenu_page', 15 );
		$this->loader->add_filter( 'sc_general_settings_array', $sc_plugin_admin, 'sc_admin_general_settings_page', 10 );
		// Settings tab.
		$this->loader->add_action( 'woocommerce_settings_tabs_array', $sc_plugin_admin, 'add_settings_tab', 50 );
		$this->loader->add_action( 'woocommerce_settings_tabs_settings_tab_demo', $sc_plugin_admin, 'settings_tab' );
		$this->loader->add_action( 'woocommerce_update_options_settings_tab_demo', $sc_plugin_admin, 'update_settings' );
		$this->loader->add_filter( 'woocommerce_product_data_tabs', $sc_plugin_admin, 'misha_product_settings_tabs' );
		$this->loader->add_filter( 'woocommerce_product_data_panels', $sc_plugin_admin, 'misha_product_panels' );
// ( ! ) Warning: Illegal string offset 'settings_tab_demo' in /home/cedcoss/Local Sites/lasttask/app/public/wp-content/plugins/shortcode-cpt/admin/class-shortcode-cpt-admin.php on line 260
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function shortcode_cpt_public_hooks() {

		$sc_plugin_public = new Shortcode_cpt_Public( $this->sc_get_plugin_name(), $this->sc_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $sc_plugin_public, 'sc_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $sc_plugin_public, 'sc_public_enqueue_scripts' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function sc_run() {
		$this->loader->sc_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function sc_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Shortcode_cpt_Loader    Orchestrates the hooks of the plugin.
	 */
	public function sc_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function sc_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_sc_plug tabs.
	 *
	 * @return  Array       An key=>value pair of shortcode-cpt tabs.
	 */
	public function mwb_sc_plug_default_tabs() {

		$sc_default_tabs = array();

		$sc_default_tabs['shortcode-cpt-general'] = array(
			'title'       => esc_html__( 'General Setting', 'shortcode-cpt' ),
			'name'        => 'shortcode-cpt-general',
		);
		$sc_default_tabs = apply_filters( 'mwb_sc_plugin_standard_admin_settings_tabs', $sc_default_tabs );

		$sc_default_tabs['shortcode-cpt-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'shortcode-cpt' ),
			'name'        => 'shortcode-cpt-system-status',
		);

		return $sc_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_sc_plug_load_template( $path, $params = array() ) {

		$sc_file_path = SHORTCODE_CPT_DIR_PATH . $path;

		if ( file_exists( $sc_file_path ) ) {

			include $sc_file_path;
		} else {

			/* translators: %s: file path */
			$sc_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'shortcode-cpt' ), $sc_file_path );
			$this->mwb_sc_plug_admin_notice( $sc_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $sc_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_sc_plug_admin_notice( $sc_message, $type = 'error' ) {

		$sc_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$sc_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$sc_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$sc_classes .= 'notice-success is-dismissible';
				break;

			default:
				$sc_classes .= 'notice-error is-dismissible';
		}

		$sc_notice  = '<div class="' . esc_attr( $sc_classes ) . '">';
		$sc_notice .= '<p>' . esc_html( $sc_message ) . '</p>';
		$sc_notice .= '</div>';

		echo wp_kses_post( $sc_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $sc_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_sc_plug_system_status() {
		global $wpdb;
		$sc_system_status = array();
		$sc_wordpress_status = array();
		$sc_system_data = array();

		// Get the web server.
		$sc_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$sc_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'shortcode-cpt' );

		// Get the server's IP address.
		$sc_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$sc_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$sc_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'shortcode-cpt' );

		// Get the server path.
		$sc_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'shortcode-cpt' );

		// Get the OS.
		$sc_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'shortcode-cpt' );

		// Get WordPress version.
		$sc_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'shortcode-cpt' );

		// Get and count active WordPress plugins.
		$sc_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'shortcode-cpt' );

		// See if this site is multisite or not.
		$sc_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'shortcode-cpt' ) : __( 'No', 'shortcode-cpt' );

		// See if WP Debug is enabled.
		$sc_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'shortcode-cpt' ) : __( 'No', 'shortcode-cpt' );

		// See if WP Cache is enabled.
		$sc_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'shortcode-cpt' ) : __( 'No', 'shortcode-cpt' );

		// Get the total number of WordPress users on the site.
		$sc_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'shortcode-cpt' );

		// Get the number of published WordPress posts.
		$sc_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'shortcode-cpt' );

		// Get PHP memory limit.
		$sc_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'shortcode-cpt' );

		// Get the PHP error log path.
		$sc_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'shortcode-cpt' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$sc_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'shortcode-cpt' );

		// Get PHP max post size.
		$sc_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'shortcode-cpt' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$sc_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$sc_system_status['php_architecture'] = '64-bit';
		} else {
			$sc_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$sc_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'shortcode-cpt' );

		// Show the number of processes currently running on the server.
		$sc_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'shortcode-cpt' );

		// Get the memory usage.
		$sc_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$sc_system_status['is_windows'] = true;
			$sc_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'shortcode-cpt' );
		}

		// Get the memory limit.
		$sc_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'shortcode-cpt' );

		// Get the PHP maximum execution time.
		$sc_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'shortcode-cpt' );

		// Get outgoing IP address.
		$sc_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'shortcode-cpt' );

		$sc_system_data['php'] = $sc_system_status;
		$sc_system_data['wp'] = $sc_wordpress_status;

		return $sc_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $sc_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_sc_plug_generate_html( $sc_components = array() ) {
		if ( is_array( $sc_components ) && ! empty( $sc_components ) ) {
			foreach ( $sc_components as $sc_component ) {
				switch ( $sc_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'password':
					case 'email':
					case 'text':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $sc_component['id'] ); ?>"><?php echo esc_html( $sc_component['title'] ); // WPCS: XSS ok. ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $sc_component['type'] ) ); ?>">
								<input
								name="<?php echo esc_attr( $sc_component['id'] ); ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								type="<?php echo esc_attr( $sc_component['type'] ); ?>"
								value="<?php echo esc_attr( $sc_component['value'] ); ?>"
								class="<?php echo esc_attr( $sc_component['class'] ); ?>"
								placeholder="<?php echo esc_attr( $sc_component['placeholder'] ); ?>"
								/>
								<p class="sc-descp-tip"><?php echo esc_html( $sc_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'textarea':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $sc_component['id'] ); ?>"><?php echo esc_html( $sc_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $sc_component['type'] ) ); ?>">
								<textarea
								name="<?php echo esc_attr( $sc_component['id'] ); ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								class="<?php echo esc_attr( $sc_component['class'] ); ?>"
								rows="<?php echo esc_attr( $sc_component['rows'] ); ?>"
								cols="<?php echo esc_attr( $sc_component['cols'] ); ?>"
								placeholder="<?php echo esc_attr( $sc_component['placeholder'] ); ?>"
								><?php echo esc_textarea( $sc_component['value'] ); // WPCS: XSS ok. ?></textarea>
								<p class="sc-descp-tip"><?php echo esc_html( $sc_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $sc_component['id'] ); ?>"><?php echo esc_html( $sc_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $sc_component['type'] ) ); ?>">
								<select
								name="<?php echo esc_attr( $sc_component['id'] ); ?><?php echo ( 'multiselect' === $sc_component['type'] ) ? '[]' : ''; ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								class="<?php echo esc_attr( $sc_component['class'] ); ?>"
								<?php echo 'multiselect' === $sc_component['type'] ? 'multiple="multiple"' : ''; ?>
								>
								<?php
								foreach ( $sc_component['options'] as $sc_key => $sc_val ) {
									?>
									<option value="<?php echo esc_attr( $sc_key ); ?>"
										<?php
										if ( is_array( $sc_component['value'] ) ) {
											selected( in_array( (string) $sc_key, $sc_component['value'], true ), true );
										} else {
											selected( $sc_component['value'], (string) $sc_key );
										}
										?>
										>
										<?php echo esc_html( $sc_val ); ?>
									</option>
									<?php
								}
								?>
								</select> 
								<p class="sc-descp-tip"><?php echo esc_html( $sc_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc"><?php echo esc_html( $sc_component['title'] ); ?></th>
							<td class="forminp forminp-checkbox">
								<label for="<?php echo esc_attr( $sc_component['id'] ); ?>"></label>
								<input
								name="<?php echo esc_attr( $sc_component['id'] ); ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								type="checkbox"
								class="<?php echo esc_attr( isset( $sc_component['class'] ) ? $sc_component['class'] : '' ); ?>"
								value="1"
								<?php checked( $sc_component['value'], '1' ); ?>
								/> 
								<span class="sc-descp-tip"><?php echo esc_html( $sc_component['description'] ); // WPCS: XSS ok. ?></span>

							</td>
						</tr>
						<?php
						break;

					case 'radio':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $sc_component['id'] ); ?>"><?php echo esc_html( $sc_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $sc_component['type'] ) ); ?>">
								<fieldset>
									<span class="sc-descp-tip"><?php echo esc_html( $sc_component['description'] ); // WPCS: XSS ok. ?></span>
									<ul>
										<?php
										foreach ( $sc_component['options'] as $sc_radio_key => $sc_radio_val ) {
											?>
											<li>
												<label><input
													name="<?php echo esc_attr( $sc_component['id'] ); ?>"
													value="<?php echo esc_attr( $sc_radio_key ); ?>"
													type="radio"
													class="<?php echo esc_attr( $sc_component['class'] ); ?>"
												<?php checked( $sc_radio_key, $sc_component['value'] ); ?>
													/> <?php echo esc_html( $sc_radio_val ); ?></label>
											</li>
											<?php
										}
										?>
									</ul>
								</fieldset>
							</td>
						</tr>
						<?php
						break;

					case 'button':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="button" class="button button-primary" 
								name="<?php echo esc_attr( $sc_component['id'] ); ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								value="<?php echo esc_attr( $sc_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					case 'submit':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo esc_attr( $sc_component['id'] ); ?>"
								id="<?php echo esc_attr( $sc_component['id'] ); ?>"
								value="<?php echo esc_attr( $sc_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
