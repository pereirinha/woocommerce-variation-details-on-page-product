<?php

/*
Plugin Name: WooCommerce Variation Details on Page Product
Plugin URI: https://github.com/pereirinha/woocommerce-variation-details-on-page-product
Description: Display physical size and weight of product within product meta details.
Version: 1.0
Author: Marco Pereirinha
Author URI: http://www.linkedin.com/in/marcopereirinha
*/

add_action( 'woocommerce_after_add_to_cart_button', 'mp_wc_variation_details_on_page_product' );

function mp_wc_variation_details_on_page_product() {
	global $post;
	$attributs_units[] = get_option('woocommerce_dimension_unit'); // Default dimension unit
	$attributs_units[] = get_option('woocommerce_weight_unit'); // Default weight unit
 	$attributs_keys = array('pa_tamanho'); // Insert attributes names here
	$attributs_dimValues = array ('_length', '_width', '_height');
	$args = array( 
		'post_parent'	=> $post->ID,
		'order'			=> 'ASC',
		'post_type'		=> 'product_variation'
	);
	$children =& get_children( $args );
	$attributs_return = array();
	
	if (!empty($children)){
		foreach ( $children AS $key => $val ){
			foreach($attributs_keys AS $keys){
				$attributs_return[$keys][] = get_term_by('slug', get_post_meta($key, 'attribute_'.$keys)[0],$keys)->name;
				foreach($attributs_dimValues AS $term){
					$attributs_return[$term][] = implode(get_post_meta($key, $term));
				}
			}
			$attributs_weightValues[] = implode(get_post_meta($key, '_weight'));
		}	
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
	
	$return = implode(", ", $return);

	echo "<script type=\"text/javascript\">$return;</script>";
}

// Load the JS
add_action('wp_enqueue_scripts', 'mp_wc_variation_details_on_page_product_scripts',0);

function mp_wc_variation_details_on_page_product_scripts() {
 
	// Respects SSL, Style.css is relative to the current file
	$js_url  = plugins_url('js/wc-attributes-on-page.js', __FILE__); 
	$js_file = WP_PLUGIN_DIR . '/woocommerce-variation-details-on-page-product/js/wc-attributes-on-page.js';
	
	if ( file_exists( $js_file ) ) :
		// register your script location, dependencies and version
		wp_register_script('mp_wc_variation_details', $js_url, array('jquery'));
		// enqueue the script
		wp_enqueue_script('mp_wc_variation_details');
	endif;
}