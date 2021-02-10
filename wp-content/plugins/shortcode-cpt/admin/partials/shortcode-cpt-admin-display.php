<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shortcode_cpt
 * @subpackage Shortcode_cpt/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $sc_mwb_sc_obj;
$sc_active_tab   = isset( $_GET['sc_tab'] ) ? sanitize_key( $_GET['sc_tab'] ) : 'shortcode-cpt-general';
$sc_default_tabs = $sc_mwb_sc_obj->mwb_sc_plug_default_tabs();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-sc-main-wrapper">
	<div class="mwb-sc-go-pro">
		<div class="mwb-sc-go-pro-banner">
			<div class="mwb-sc-inner-container">
				<div class="mwb-sc-name-wrapper">
					<p><?php esc_html_e( 'shortcode-cpt', 'shortcode-cpt' ); ?></p></div>
					<div class="mwb-sc-static-menu">
						<ul>
							<li>
								<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="_blank">
									<span class="dashicons dashicons-phone"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/hubspot-woocommerce-integration/' ); ?>" target="_blank">
									<span class="dashicons dashicons-media-document"></span>
								</a>
							</li>
							<?php $sc_plugin_pro_link = apply_filters( 'sc_pro_plugin_link', '' ); ?>
							<?php if ( isset( $sc_plugin_pro_link ) && '' != $sc_plugin_pro_link ) { ?>
								<li class="mwb-sc-main-menu-button">
									<a id="mwb-sc-go-pro-link" href="<?php echo esc_url( $sc_plugin_pro_link ); ?>" class="" title="" target="_blank"><?php esc_html_e( 'GO PRO NOW', 'shortcode-cpt' ); ?></a>
								</li>
							<?php } else { ?>
								<li class="mwb-sc-main-menu-button">
									<a id="mwb-sc-go-pro-link" href="#" class="" title=""><?php esc_html_e( 'GO PRO NOW', 'shortcode-cpt' ); ?></a>
								</li>
							<?php } ?>
							<?php $sc_plugin_pro = apply_filters( 'sc_pro_plugin_purcahsed', 'no' ); ?>
							<?php if ( isset( $sc_plugin_pro ) && 'yes' == $sc_plugin_pro ) { ?>
								<li>
									<a id="mwb-sc-skype-link" href="<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>" target="_blank">
										<img src="<?php echo esc_url( SHORTCODE_CPT_DIR_URL . 'admin/images/skype_logo.png' ); ?>" style="height: 15px;width: 15px;" ><?php esc_html_e( 'Chat Now', 'shortcode-cpt' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="mwb-sc-main-template">
			<div class="mwb-sc-body-template">
				<div class="mwb-sc-navigator-template">
					<div class="mwb-sc-navigations">
						<?php
						if ( is_array( $sc_default_tabs ) && ! empty( $sc_default_tabs ) ) {

							foreach ( $sc_default_tabs as $sc_tab_key => $sc_default_tabs ) {

								$sc_tab_classes = 'mwb-sc-nav-tab ';

								if ( ! empty( $sc_active_tab ) && $sc_active_tab === $sc_tab_key ) {
									$sc_tab_classes .= 'sc-nav-tab-active';
								}
								?>
								
								<div class="mwb-sc-tabs">
									<a class="<?php echo esc_attr( $sc_tab_classes ); ?>" id="<?php echo esc_attr( $sc_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=shortcode_cpt_menu' ) . '&sc_tab=' . esc_attr( $sc_tab_key ) ); ?>"><?php echo esc_html( $sc_default_tabs['title'] ); ?></a>
								</div>

								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="mwb-sc-content-template">
					<div class="mwb-sc-content-container">
						<?php
							// if submenu is directly clicked on woocommerce.
						if ( empty( $sc_active_tab ) ) {

							$sc_active_tab = 'mwb_sc_plug_general';
						}

							// look for the path based on the tab id in the admin templates.
						$sc_tab_content_path = 'admin/partials/' . $sc_active_tab . '.php';

						$sc_mwb_sc_obj->mwb_sc_plug_load_template( $sc_tab_content_path );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
