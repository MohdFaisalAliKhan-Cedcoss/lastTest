<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the welcome html.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-sc-main-wrapper">
	<div class="mwb-sc-go-pro">
		<div class="mwb-sc-go-pro-banner">
			<div class="mwb-sc-inner-container">
				<div class="mwb-sc-name-wrapper" id="mwb-sc-page-header">
					<h3><?php esc_html_e( 'Welcome To MakeWebBetter', 'shortcode-cpt' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="mwb-sc-inner-logo-container">
				<div class="mwb-sc-main-logo">
					<img src="<?php echo esc_url( SHORTCODE_CPT_DIR_URL . 'admin/images/logo.png' ); ?>">
					<h2><?php esc_html_e( 'We make the customer experience better', 'shortcode-cpt' ); ?></h2>
					<h3><?php esc_html_e( 'Being best at something feels great. Every Business desires a smooth buyer’s journey, WE ARE BEST AT IT.', 'shortcode-cpt' ); ?></h3>
				</div>
				<div class="mwb-sc-active-plugins-list">
					<?php
					$mwb_sc_all_plugins = get_option( 'mwb_all_plugins_active', false );
					if ( is_array( $mwb_sc_all_plugins ) && ! empty( $mwb_sc_all_plugins ) ) {
						?>
						<table class="mwb-sc-table">
							<thead>
								<tr class="mwb-plugins-head-row">
									<th><?php esc_html_e( 'Plugin Name', 'shortcode-cpt' ); ?></th>
									<th><?php esc_html_e( 'Active Status', 'shortcode-cpt' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( is_array( $mwb_sc_all_plugins ) && ! empty( $mwb_sc_all_plugins ) ) { ?>
									<?php foreach ( $mwb_sc_all_plugins as $sc_plugin_key => $sc_plugin_value ) { ?>
										<tr class="mwb-plugins-row">
											<td><?php echo esc_html( $sc_plugin_value['plugin_name'] ); ?></td>
											<?php if ( isset( $sc_plugin_value['active'] ) && '1' != $sc_plugin_value['active'] ) { ?>
												<td><?php esc_html_e( 'NO', 'shortcode-cpt' ); ?></td>
											<?php } else { ?>
												<td><?php esc_html_e( 'YES', 'shortcode-cpt' ); ?></td>
											<?php } ?>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<?php
					}
					?>
				</div>
			</div>
		</div>
