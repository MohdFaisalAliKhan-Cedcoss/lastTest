<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $sc_mwb_sc_obj;
$sc_genaral_settings = apply_filters( 'sc_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="sc-secion-wrap">
	<table class="form-table sc-settings-table">
		<?php
			$sc_general_html = $sc_mwb_sc_obj->mwb_sc_plug_generate_html( $sc_genaral_settings );
			echo esc_html( $sc_general_html );
		?>
	</table>
</div>
