<?php
/**
 *
 * Settings class
 *
 * @since 2.0
 */
if ( ! class_exists( 'MP_WC_Variation_Details_On_Page_Product_Settings' ) ) {

	class MP_WC_Variation_Details_On_Page_Product_Settings extends WC_Settings_API {

		public $plugin_id;
		public $tab_name;
		public $options_name;
		public $id;

		public function __construct() {
			global $mp_wc_vdopp;
			$this->plugin_id    = $mp_wc_vdopp->plugin_prefix;
			$this->tab_name     = &$this->plugin_id;
			$this->options_name = array( $this->plugin_id . '_data_hook', $this->plugin_id . '_dom_selector', $this->plugin_id . '_data_selector' );
			add_action( 'admin_init', array( $this, 'verify_first_use' ) );
			add_action( 'admin_init', array( $this, 'init_form_fields' ) );
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

		// Start default settings
		public function verify_first_use() {
			if ( ! get_option( 'mp_wc_vdopp_data_hook' ) ) :
				add_option( 'mp_wc_vdopp_data_hook', '.variations' );
			endif;
			if ( ! get_option( 'mp_wc_vdopp_dom_selector' ) ) :
				add_option( 'mp_wc_vdopp_dom_selector', 'form.cart select' );
			endif;
			if ( ! get_option( 'mp_wc_vdopp_data_selector' ) ) :
				add_option( 'mp_wc_vdopp_data_selector', '.product_details' );
			endif;
		}

		// Create Variations tab
		public function add_settings_tab($tabs) {
			$tabs[ $this->tab_name ] = __( 'Variations', $this->tab_name );
			return $tabs;
		}

		// Initialization of form fields
		public function init_form_fields() {
			global $woocommerce;
			$attribute_taxonomies = wc_get_attribute_taxonomies();

			$defaults = array(
				'data_hook'     => get_option( $this->plugin_id . '_data_hook' ),
				'dom_selector'  => get_option( $this->plugin_id . '_dom_selector' ),
				'data_selector' => get_option( $this->plugin_id . '_data_selector' ),
			);

			$args = array(
				'data_hook'     => sanitize_text_field( $_POST[ $this->plugin_id . '_data_hook' ] ),
				'dom_selector'  => sanitize_text_field( $_POST[ $this->plugin_id . '_dom_selector' ] ),
				'data_selector' => sanitize_text_field( $_POST[ $this->plugin_id . '_data_selector' ] ),
			);

			$args = wp_parse_args( $args, $defaults );

			$this->form_fields = array(
				'data_hook' => array(
					'title'       => '<b>Place holder for variation data</b>',
					'description' => 'Choose a CSS class or id where you want to hook variation data. For instance: .variations or .product_meta. Default value: .variations',
					'type'        => 'text',
					'default'     => $args['data_hook'],
				),
				'dom_selector' => array(
					'title'       => '<b>DOM Selector</b>',
					'description' => 'Define the selector that will trigger show data event. Default value: form.cart select',
					'type'        => 'text',
					'default'     => $args['dom_selector'],
				),
				'data_selector' => array(
					'title'       => '<b>Data Selector</b>',
					'description' => 'Choose the id/class of displayed data. Default value: .product_details',
					'type'        => 'text',
					'default'     => $args['data_selector'],
				),
			);
		}

		// Create settings page
		public function create_settings_page() {
			$this->init_settings();
			foreach ( $this->options_name as $option_name ) {
				$this->settings[ $option_name ]  = get_option( $option_name );
			}
			?>
			<h3>WooCommerce Variation Details on Page Product</h3>
			<p>This plugin has predefined settings outside the box. If you feel comfortable, you are welcome to update data to meet your requirements.</p>
			<p><strong>Important:</strong> Use a . to identify a class and a # to identify an id.</p>
			<table class="form-table">
				<?php $this->generate_settings_html();?>
			</table>
			<?php $this->donation();
		}

		// Save the array of attribute keys to be shown
		public function save_settings_page() {
			$control = true;
			foreach ( $_POST as $key => $value ) {
				if ( false !== strpos( $key, $this->plugin_id ) ) {
					if ( get_option( $key ) ) {
						update_option( $key, $value );
					} else {
						add_option( $key, $value );
					}
					$control = false;
				}
				if ( $control ) {
					foreach ( $this->options_name as $option_name ) {
						delete_option( $option_name );
					};
				}
			}
		}

		private function donation() {
			?>
			<p>Please, support further development of this plugin by buying the guy an extra dose of caffeine.</p>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S626RA3BPS74S" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></a>
			<?php
		}
	}
}
