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
class WCFM_Product_Size_Chart_Woocommerce {
    var $chart = null;
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
        add_action( 'wp', [$this, 'init']);        
	}

    public function init() {
        if(!is_product()) {
            return;
        }

        $this->chart = $this->get_chart();
        if ( false == $this->chart ) {
            return '';
        }

        if ( $this->chart->chart_position === 'before_cart_form' ) {
            add_filter('woocommerce_single_product_summary', [$this, 'wcfm_product_size_chart_popup'], 25);
        }

        if ( $this->chart->chart_position === 'tab' ) {
            add_filter('woocommerce_product_tabs', [$this, 'wcfm_product_size_chart_tab'], 50);
        }
    }

    public function get_chart() {
        global $post;

        $vendor_id = wcfm_get_vendor_id_by_post( $post->ID );
        if ( !wcfm_is_vendor($vendor_id) ) {
            return false;
        }

        $size_charts = get_wcfm_product_size_charts(['author' => $vendor_id]);
        if ( sizeof($size_charts) == 0 ) {
            return false;
        }

        $product_cats = get_the_terms( $post->ID, 'product_cat' );

        $cat_ids = is_array($product_cats) ? wp_list_pluck( $product_cats, 'term_id') : [];

        array_walk($size_charts, function(&$item){
            $item->chart_categories = is_array($item->chart_categories) ? $item->chart_categories : [];
            $item->exclude_products = is_array($item->exclude_products) ? $item->exclude_products : [];
            $item->total_categories = sizeof($item->chart_categories);
        });
        
        $size_charts = array_filter($size_charts, function($item) use ($cat_ids, $post) {
            if ( in_array($post->ID,$item->exclude_products)) {
                return false;
            }
            
            return sizeof( array_diff($item->chart_categories, $cat_ids) ) == 0;
        });

        if ( empty($size_charts) ) {
            return false;
        }

        usort($size_charts, function($a, $b) {
            return $b->total_categories <=> $a->total_categories;
        });

        return $size_charts[0];
    }

    public function wcfm_product_size_chart_popup() {
        $chart = $this->chart;
        echo '<a class="wcfm-product-size-chart-popup-btn" href="#">Size Chart</a>';
        echo '<div class="wcfm-product-size-chart-popup">';
            echo '<div class="wcfm-chart-popup-content">';
                echo '<span class="wcfmfa fa-close" data-close></span>';
                echo '<h3 class="chart-title">'. get_the_title( $chart->ID ) .'</h3>';
                include WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/templates/product-size-chart-table.php';
            echo '</div>';
        echo '</div>';
    }

    public function wcfm_product_size_chart_tab($tabs) {  
        $tabs['wcfm_size_chart'] = [
            'title' => __('Size Chart'),
            'callback' => function() {
                $this->wcfm_product_size_chart_tab_content($this->chart);
            }
        ];
        
        return $tabs;
    }
    
    public function wcfm_product_size_chart_tab_content($chart) {
        include WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR . '/templates/product-size-chart-table.php';
    }

}
