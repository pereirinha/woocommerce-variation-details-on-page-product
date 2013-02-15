<?php

/**
 * Settings class
 */
if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product_Settings' ) ) {

	class MP_WC_Variation_Details_On_Page_Product_Settings extends WC_Settings_API {
		
		public $plugin_id;
		public $tab_name;
		public $option_name;
		
		public function __construct() {
			global $mp_wc_vdopp;
			$this->plugin_id		= 'mp_wc_vdopp';
			$this->tab_name			= &$this->plugin_id;
			$this->option_name		= $mp_wc_vdopp->option_name;
			$this->init_form_fields();
		}
		
		// Load the class
		public function load() {
			add_action( 'admin_init', array( $this, 'load_hooks' ) );
		}
		
		// Call for actions
		public function load_hooks() {	
			add_filter( 'woocommerce_settings_tabs_array', array( &$this, 'add_settings_tab' ) );
			add_action( 'woocommerce_settings_tabs_' . $this->tab_name, array( &$this, 'create_settings_page' ) );
			add_action( 'woocommerce_update_options_' . $this->tab_name, array( &$this, 'save_settings_page' ) );
		}
		
		// Create Variations tab
		public function add_settings_tab($tabs) {
			$tabs[$this->tab_name] = __( 'Variations', $this->tab_name );		
			return $tabs;
		}
		
		// Initialization of form fields
		public function init_form_fields() {
			global $woocommerce;
			$attribute_taxonomies = $woocommerce->get_attribute_taxonomies();
			if ( $attribute_taxonomies ) :
				$keys = '';
				foreach ( $attribute_taxonomies as $tax ) :
					$keys[ $tax->attribute_name ] = $tax->attribute_label;
				endforeach;
				if ( taxonomy_exists ( $woocommerce->attribute_taxonomy_name ( $tax->attribute_name ) ) ) :
					$this->form_fields = array(
						'keys' => array(
							'title' => 'Keys',
							'type' => 'multiselect',
							'options' => $keys
						)
					);					
				endif;
			endif;
		}
		
		// Create settings page
		public function create_settings_page() {
			$this->init_settings();
			$this->settings['keys']  = get_option($this->option_name);
			?>
			<h3>Variation details on page product</h3>
			<p>Select (using CTRL key on Windows and Linux, or CMD key on Mac ) which attributes will be shown on Product Detail Page</p>
			<?php
			//print_R($this->settings);
			$this->generate_settings_html();
			$this->donation();
		}
		
		// Save the array of attribute keys to be shown
		public function save_settings_page() {
			foreach ( $_POST as $key => $value ) {
				if ( strpos( $key, $this->plugin_id ) !== false ) :
					if ( get_option ( $this->option_name ) ) :
						update_option( $this->option_name, $value );
					else :
						add_option( $this->option_name, $value );
					endif;
					$control = 1;
				endif;
			}
			
			if ( !isset ( $control ) ) delete_option( $this->option_name ) ;
		}
		
		private function donation(){
			?>
			<p>Please, support further development of this plugin by buying the guy an extra dose of caffeine.</p>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S626RA3BPS74S" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></a>
			<?php
		}
	}
}