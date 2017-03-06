<?php

/*
Plugin Name: WooCommerce Variation Details on Page Product
Plugin URI: https://github.com/pereirinha/woocommerce-variation-details-on-page-product
Description: Display physical size and weight of product within product meta details.
Version: 3.3.2
Author: Marco Pereirinha
Author URI: http://www.linkedin.com/in/marcopereirinha
*/

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product' ) ) {

		class MP_WC_Variation_Details_On_Page_Product {

			// Definition of version
			const VERSION             = '3.3.2';
			const VERSION_OPTION_NAME = 'mp_wc_vdopp_version';

			public $plugin_prefix;
			private $settings;
			private $variations;
			private $debug;

			public function __construct() {
				$this->plugin_prefix   = 'mp_wc_vdopp';
				$this->old_option_name = 'mp_wc_vdopp_keys';
				$this->debug           = WP_DEBUG;
			}

			public function load() {
				add_action( 'init', array( $this, 'load_hooks' ) );
				add_filter( 'woocommerce_before_add_to_cart_form', array( &$this, 'create_vars' ), 10 );

				// Load the JS
				add_filter( 'wp_enqueue_scripts', array( &$this, 'register_scripts' ), 15 );

				// Load text domain
				add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );

				// Installation
				if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
					$this->install();
				}
			}

			private function includes() {
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

			public function create_vars() {
				global $product;

				if ( ! is_product() || ! $product->is_type( 'variable' ) ) {
					return;
				}

				$att_data_hook     = get_option( 'mp_wc_vdopp_data_hook' ); // Hook data
				$att_data_sel      = get_option( 'mp_wc_vdopp_data_selector' ); // Data Selector
				$att_before_size   = apply_filters( 'mp_wc_vdopp_before_size'  , rtrim( get_option( 'mp_wc_vdopp_before_size' ) ) ) . ' ';
				$att_before_weight = apply_filters( 'mp_wc_vdopp_before_weight', rtrim( get_option( 'mp_wc_vdopp_before_weight' ) ) ) . ' ';
				$att_after_size    = apply_filters( 'mp_wc_vdopp_after_size'   , ' ' . ltrim( get_option( 'mp_wc_vdopp_after_size' ) ) );
				$att_after_weight  = apply_filters( 'mp_wc_vdopp_after_weight' , ' ' . ltrim( get_option( 'mp_wc_vdopp_after_weight' ) ) );
				$children          = $product->get_children( true );

				$index = 0;
				foreach ( $children as $value ) {
					$product_variatons = new WC_Product_Variation( $value );
					if ( $product_variatons->exists() && $product_variatons->variation_is_visible() ) {
						$variations = $product_variatons->get_variation_attributes();

						foreach ( $variations as $key => $variation ) {
							$this->variations[ $index ][ $key ] = array(
								$variation,
								sanitize_title( $variation )
							);

							$this->variations[ $index ][ $key ] = array_filter( $this->variations[ $index ][ $key ] );
						}
						$weight = $product_variatons->get_weight();
						if ( $weight ) {
							$weight .= get_option( 'woocommerce_weight_unit' );
						}
						$this->variations[ $index ]['weight']     = $weight ;
						$this->variations[ $index ]['dimensions'] = str_replace( ' ', '', $product_variatons->get_dimensions() );
						$index++;
					}
				}

				$this->variations = wp_json_encode( $this->variations );

				$params = array(
					'variations'        => $this->variations,
					'att_data_hook'     => $att_data_hook,
					'att_data_sel'      => $att_data_sel,
					'att_before_size'   => $att_before_size,
					'att_before_weight' => $att_before_weight,
					'att_after_size'    => $att_after_size,
					'att_after_weight'  => $att_after_weight,
				);

				// enqueue the script
				wp_enqueue_script( 'mp_wc_variation_details' );
				wp_localize_script( 'mp_wc_variation_details', 'mp_wc_variations', $params );
			}

			public function register_scripts() {
				$min = 'min.';

				if ( $this->debug ) {
					$min = '';
				}

				$js_url  = plugins_url( 'js/wc-attributes-on-page.' . $min . 'js', __FILE__ );
				$js_file = WP_PLUGIN_DIR . '/woocommerce-variation-details-on-page-product/js/wc-attributes-on-page.' . $min . 'js';

				if ( file_exists( $js_file ) ) {
					// register your script location, dependencies and version
					wp_register_script( 'mp_wc_variation_details', $js_url, array() );
				}
			}

			public function load_plugin_textdomain() {
				load_plugin_textdomain( 'mp_wc_vdopp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			}

			/** Lifecycle methods **/

			// Run every time. Used since the activation hook is not executed when updating a plugin
			private function install() {
				$installed_version = get_option( MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME );

				if ( ! $installed_version ) {
					// initial install, set the version of the plugin on options table
					add_option( $installed_version, MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME );
				}

				if ( MP_WC_Variation_Details_On_Page_Product::VERSION !== $installed_version ) {
					$this->upgrade( $installed_version );

					// new version number
					update_option( MP_WC_Variation_Details_On_Page_Product::VERSION_OPTION_NAME, MP_WC_Variation_Details_On_Page_Product::VERSION );
				}
			}

			// Run when plugin version number changes
			private function upgrade( $installed_version ) {
				if ( get_option( $this->old_option_name ) ) {
					delete_option( $this->old_option_name );
				}
				if ( get_option( 'mp_wc_vdopp_dom_selector' ) ) {
					delete_option( 'mp_wc_vdopp_dom_selector' );
				}
			}
		}
	}

	$mp_wc_vdopp = new MP_WC_Variation_Details_On_Page_Product;
	$mp_wc_vdopp->load();
}
