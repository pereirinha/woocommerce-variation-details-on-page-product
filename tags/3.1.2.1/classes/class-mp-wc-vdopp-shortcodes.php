<?php
/**
*
* Shortcode class
*
* @since 3.1
*/

if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product_Shortcodes' ) ) {
	class MP_WC_Variation_Details_On_Page_Product_Shortcodes {
		
		public function load() {
			add_shortcode( 'mp_wc_vdopp_variations', array( $this, 'variations' ) );
		}

		public function variations() {
			return '<div class="mp_wc_vdopp_variations"></div>';
		}
	}
}