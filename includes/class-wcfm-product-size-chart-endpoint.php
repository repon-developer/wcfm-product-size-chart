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
 * Product size chart endpoint for WCFM plugin
 *
 * @since 1.0.1
 */
class WCFM_Endpoint_Product_Size_Chart {
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
		//add_action( 'init', array( &$this, 'wcfm_init_endpoint' ), 20 );
		add_filter( 'wcfm_menus', array( $this, 'wcfm_add_endpoint_menu' ), 20 );
		add_filter( 'wcfm_query_vars', array( $this, 'wcfm_endpoint_query_vars' ), 20 );

		add_action( 'wcfm_load_scripts', array( $this, 'wcfm_load_scripts' ), 30 ); 


		add_action( 'wcfm_load_views', array( $this, 'wcfm_product_size_chart_views' ), 30 );

		include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/includes/class-wcfm-product-size-chart-form.php';

		add_action( 'init', function(){
			$this->form = new WCFM_Product_Size_Chart_Form();
		});
		
	}


	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function wcfm_init_endpoint() {
		global $WCFM_Query;

        $WCFM_Query->init_query_vars();
        $WCFM_Query->add_endpoints();

        if( !get_option( 'wcfm_updated_end_point_product_size_chart' ) ) {
            flush_rewrite_rules();
            update_option( 'wcfm_updated_end_point_product_size_chart', 1 );
        }
	}

	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function wcfm_add_endpoint_menu($menus) {
		global $WCFM;
        
        $featured_menus = array( 'wcfm-product-size-chart' => array(   'label'  => __( 'Product Size Chart', 'wc-frontend-manager'),
            'label' => 'Product Size Chart',
            'url' => wcfm_product_sizes_chart_url(),
            'icon' => 'star',
            'priority' => 5
        ) );

        $menus = array_merge( $menus, $featured_menus );
          
        return $menus;
	}

	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function wcfm_endpoint_query_vars($query_vars) {
		global $WCFM;

        $query_vars['wcfm-product-size-chart'] = 'product-size-chart';
          
        return $query_vars;
	}

	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function wcfm_load_scripts($end_point) {
		if ( $end_point !== 'wcfm-product-size-chart') {
			return;
		}

		global $WCFM;
		wp_enqueue_script( 'select2_js', $WCFM->plugin_url . 'includes/libs/select2/select2.js', array('jquery'), $WCFM->version, true );
		wp_enqueue_style( 'select2_css',  $WCFM->plugin_url . 'includes/libs/select2/select2.css', array(), $WCFM->version );
	}


	/**
	 * Registers and enqueues scripts and CSS.
	 *
	 */
	public function wcfm_product_size_chart_views($end_point) {
		if ( $end_point !== 'wcfm-product-size-chart') {
			return;
		}

		if ( isset($_GET['chart']) ) {
			$form = $this->form;

			$get_vendor_products = wc_get_products([
				'author' => get_current_user_id(  )
			]);

			$vendor_products = [];
			while ($product = current($get_vendor_products) ) {
				next($get_vendor_products);
				$vendor_products[$product->get_id()] = $product->get_title();
			}
			

			$product_cats = get_terms([
				'taxonomy' => 'product_cat',
    			'hide_empty' => false,
			]);


			include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/templates/product-size-chart-edit.php';

		} else {
			include_once WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/templates/product-size-charts.php';
		}

	}

	
}
