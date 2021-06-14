<?php
/**
 * File containing the class WP_Job_Manager.
 *
 * @package wcfm-product-size-chart
 * @since   1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles core plugin hooks and action setup.
 *
 * @since 1.0.1
 */
class WCFM_Product_Size_Chart {
	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0.1
	 */
	private static $instance = null;

	/**
	 * Main WCFM Product Size Chart Instance.
	 *
	 * Ensures only one instance of WCFM Product Size Chart is loaded or can be loaded.
	 *
	 * @since  1.0.1
	 * @static
	 * @see WPJM()
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Includes.
		include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/includes/class-wcfm-product-size-chart-post-types.php';
        WCFM_Product_Size_Chart_Post_Types::instance();

		$this->includes();

		// Actions.
		add_action( 'init', [ $this, 'load_plugin_textdomain' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		
	}

	/**
	 * Loads textdomain for plugin.
	 */
	public function includes() {
		include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/includes/class-wcfm-product-sizes-helper.php';
		include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/includes/class-wcfm-product-size-query.php';
		include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/includes/class-wcfm-product-size-chart-endpoint.php';
        WCFM_Endpoint_Product_Size_Chart::instance();
	}


	/**
	 * Loads textdomain for plugin.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wcfm-product-size-chart', false, WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/languages/' );
	}


	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function frontend_scripts() {
		wp_register_style('wcfm-product-size-chart', WCFM_PRODUCT_SIZE_CHART_PLUGIN_URL . '/assets/product-size-chart.css');
		wp_register_script( 'wcfm-product-size-chart', WCFM_PRODUCT_SIZE_CHART_PLUGIN_URL . '/assets/product-size-chart.js', [ 'jquery' ], WCFM_PRODUCT_SIZE_CHART_VERSION, true );
	}
}
