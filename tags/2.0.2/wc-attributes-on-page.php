<?php

/*
Plugin Name: WooCommerce Variation Details on Page Product
Plugin URI: https://github.com/pereirinha/woocommerce-variation-details-on-page-product
Description: Display physical size and weight of product within product meta details.
Version: 2.0.2
Author: Marco Pereirinha
Author URI: http://www.linkedin.com/in/marcopereirinha
*/

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product' ) ) {
		
		class MP_WC_Variation_Details_On_Page_Product{
			const VERSION = "2.0.2";
			const VERSION_OPTION_NAME = "mp_wc_vdopp_version";
			
			public static $plugin_prefix;
			public $settings;
			public $option_name;
			
			public function __construct() {
				self::$plugin_prefix	= 'mp_wc_';
				$this->option_name		= 'mp_wc_vdopp_keys';
			}
			
			public function load() {
				add_action( 'init', array( $this, 'load_hooks' ) );
				add_action( 'woocommerce_after_add_to_cart_button', array( &$this,'mp_wc_variation_details_on_page_product' ), 10);
				
				// Load the JS
				add_action( 'wp_enqueue_scripts', array ( &$this, 'mp_wc_variation_details_on_page_product_scripts' ), 5);
				
				// Installation
				if ( is_admin() && ! defined( 'DOING_AJAX' ) ) $this->install();
			}
			
			public function includes() {
				include_once( 'classes/class-mp-wc-vdopp-settings.php' );
			}
			
			public function load_hooks() {
				$this->includes();
				$this->settings = new MP_WC_Variation_Details_On_Page_Product_Settings();
				$this->settings->load();
			}
			
			public function mp_wc_variation_details_on_page_product() {
				global $post;
				$attributs_units[]		= get_option('woocommerce_dimension_unit'); // Default dimension unit
				$attributs_units[]		= get_option('woocommerce_weight_unit'); // Default weight unit
				$attributs_keys			= get_option($this->option_name);
				foreach ( $attributs_keys as &$value ) $value = 'pa_'.$value;
				$attributs_dimValues	= array ('_length', '_width', '_height');
				$args = array( 
					'post_parent'		=> $post->ID,
					'order'				=> 'ASC',
					'post_type'			=> 'product_variation'
				);
				$children =& get_children( $args );
				$attributs_return = array();
				
				if ( !empty ( $children ) ) {
					foreach ( $children AS $key => $val ) {
						foreach ( $attributs_keys AS $keys ) {
							$attrib = get_post_meta ( $key, 'attribute_'.$keys );
							$attributs_return[$keys][] = get_term_by ( 'slug', $attrib[0],$keys )->name;
							foreach($attributs_dimValues AS $term){
								$attributs_return[$term][] = implode ( get_post_meta ( $key, $term ) );
							}
						}
						$attributs_weightValues[] = implode ( get_post_meta ( $key, '_weight' ) );
					}
				} else {
					return '';
				}
				print_r($weight);
				$return = array();
				$return[] = 'keys = new Array("'. implode( "\", \"" , $attributs_keys) .'")';
				$return[] = 'dimensionalUnit = "' . $attributs_units [0] . '"';
				$return[] = 'weightUnit = "'. $attributs_units[1] .'"';
				$return[] = 'dimensionalValues = new Array ("' . implode( "\", \"" , $attributs_dimValues) . '")';
				foreach($attributs_return AS $key => $val){
					$return[] = $key . ' = new Array("'. implode("\", \"", $val) . '")';
				}
				$return[] = 'weightValues = new Array ("' . implode( "\", \"" , $attributs_weightValues) . '")';
				
				$return = implode( ", ", $return );
			
				echo "<script type=\"text/javascript\">$return;</script>";
			}
			
			public function mp_wc_variation_details_on_page_product_scripts() {
			 
				// Respects SSL, Style.css is relative to the current file
				$js_url  = plugins_url ( 'js/wc-attributes-on-page.js', __FILE__ ); 
				$js_file = WP_PLUGIN_DIR . '/woocommerce-variation-details-on-page-product/js/wc-attributes-on-page.js';
				
				if ( file_exists( $js_file ) ) :
					// register your script location, dependencies and version
					wp_register_script( 'mp_wc_variation_details', $js_url, array ( 'jquery' ) );
					// enqueue the script
					wp_enqueue_script( 'mp_wc_variation_details' );
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
				// upgrade code goes here
			}
		}
	}
	
	$mp_wc_vdopp = new MP_WC_Variation_Details_On_Page_Product();
	$mp_wc_vdopp->load();
}