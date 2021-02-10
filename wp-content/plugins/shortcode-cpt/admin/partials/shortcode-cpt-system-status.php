<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $sc_mwb_sc_obj;
$sc_default_status = $sc_mwb_sc_obj->mwb_sc_plug_system_status();
$sc_wordpress_details = is_array( $sc_default_status['wp'] ) && ! empty( $sc_default_status['wp'] ) ? $sc_default_status['wp'] : array();
$sc_php_details = is_array( $sc_default_status['php'] ) && ! empty( $sc_default_status['php'] ) ? $sc_default_status['php'] : array();
?>
<div class="mwb-sc-table-wrap">
	<div class="mwb-sc-table-inner-container">
		<table class="mwb-sc-table" id="mwb-sc-wp">
			<thead>
				<tr>
					<th><?php esc_html_e( 'WP Variables', 'shortcode-cpt' ); ?></th>
					<th><?php esc_html_e( 'WP Values', 'shortcode-cpt' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $sc_wordpress_details ) && ! empty( $sc_wordpress_details ) ) { ?>
					<?php foreach ( $sc_wordpress_details as $wp_key => $wp_value ) { ?>
						<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
							<tr>
								<td><?php echo esc_html( $wp_key ); ?></td>
								<td><?php echo esc_html( $wp_value ); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="mwb-sc-table-inner-container">
		<table class="mwb-sc-table" id="mwb-sc-php">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Sysytem Variables', 'shortcode-cpt' ); ?></th>
					<th><?php esc_html_e( 'System Values', 'shortcode-cpt' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $sc_php_details ) && ! empty( $sc_php_details ) ) { ?>
					<?php foreach ( $sc_php_details as $php_key => $php_value ) { ?>
						<tr>
							<td><?php echo esc_html( $php_key ); ?></td>
							<td><?php echo esc_html( $php_value ); ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
