<?php

/*
Plugin Name: WooCommerce Variation Details on Page Product
Plugin URI: https://github.com/pereirinha/woocommerce-variation-details-on-page-product
Description: Display physical size and weight of product within product meta details.
Version: 3.1.1
Author: Marco Pereirinha
Author URI: http://www.linkedin.com/in/marcopereirinha
*/

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product' ) ) {
		
		class MP_WC_Variation_Details_On_Page_Product {
			
			// Definition of version
			const VERSION = "3.1.1";
			const VERSION_OPTION_NAME = "mp_wc_vdopp_version";
			
			public $plugin_prefix;
			public $settings;
			public $sibling;
			
			public function __construct() {
				$this->plugin_prefix  	= 'mp_wc_vdopp';
				$this->old_option_name	= 'mp_wc_vdopp_keys';
			}
			
			public function load() {
				add_action( 'init', array( $this, 'load_hooks' ) );
				add_filter( 'woocommerce_before_add_to_cart_form', array( &$this,'mp_wc_variation_details_on_page_product' ), 10);

				// Load the JS
				add_filter( 'wp_enqueue_scripts', array ( &$this, 'mp_wc_variation_details_on_page_product_scripts' ), 15);

				// Installation
				if ( is_admin() && ! defined( 'DOING_AJAX' ) ) $this->install();
			}
			
			public function includes() {
				include_once( 'classes/class-mp-wc-vdopp-settings.php' );
				include_once( 'classes/class-mp-wc-vdopp-shortcodes.php' );
			}
			
			public function load_hooks() {
				$this->includes();
				$this->settings = new MP_WC_Variation_Details_On_Page_Product_Settings();
				$this->settings->load();
				$this->shortcodes = new MP_WC_Variation_Details_On_Page_Product_Shortcodes();
				$this->shortcodes->load();
			}
			
			public function mp_wc_variation_details_on_page_product() {
				
				if ( !is_product() ) return '';
				global $product;
				$att_dim_unit 	= get_option('woocommerce_dimension_unit'); // Default dimension unit
				$att_wei_unit 	= get_option('woocommerce_weight_unit'); // Default weight unit
				$att_data_hook	= get_option('mp_wc_vdopp_data_hook'); // Hook data
				$att_dom_sel  	= get_option('mp_wc_vdopp_dom_selector'); // DOM Selector
				$att_data_sel 	= get_option('mp_wc_vdopp_data_selector'); // Data Selector

				$children	= $product->get_children( $args = '', $output = OBJECT );

				foreach ($children as $value) {
					$this->sibling[] = new WC_Product_Variation($value);
				}

				$siblings = json_encode($this->sibling);
				$params = array(
					'siblings'     	=> $siblings,
					'att_dim_unit' 	=> $att_dim_unit,
					'att_wei_unit' 	=> $att_wei_unit,
					'att_data_hook'	=> $att_data_hook,
					'att_dom_sel'  	=> $att_dom_sel,
					'att_data_sel' 	=> $att_data_sel
				);
				
				// enqueue the script
				wp_enqueue_script( 'mp_wc_variation_details' );
				wp_localize_script( 'mp_wc_variation_details', 'Variations', $params );
			}
			
			public function mp_wc_variation_details_on_page_product_scripts() {
				
				$js_url  = plugins_url ( 'js/wc-attributes-on-page.min.js', __FILE__ ); 
				$js_file = WP_PLUGIN_DIR . '/woocommerce-variation-details-on-page-product/js/wc-attributes-on-page.min.js';
				
				if ( file_exists( $js_file ) ) :
					// register your script location, dependencies and version
					wp_register_script( 'mp_wc_variation_details', $js_url, array ( 'jquery' ) );
				endif;
			}
			
			/** Lifecycle methods **/
			
			// Run every time. Used since the activation hook is not executed when updating a plugin
			private function install() {
				$installed_version = get_option( MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME );
				
				if ( ! $installed_version ) {
					// initial install, set the version of the plugin on options table
					add_option( $installed_version, MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME );
				}
				
				if ( $installed_version != MP_WC_Variation_Details_On_Page_Product::VERSION ) {
					$this->upgrade( $installed_version );
					
					// new version number
					update_option( MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME,MP_WC_Variation_Details_On_Page_Product::VERSION );
				}
			}
			
			// Run when plugin version number changes
			private function upgrade( $installed_version ) {
				if( get_option( $this->old_option_name ) ) {
					delete_option( $this->old_option_name );
				}
			}
		}
	}
	
	$mp_wc_vdopp = new MP_WC_Variation_Details_On_Page_Product();
	$mp_wc_vdopp->load();
}