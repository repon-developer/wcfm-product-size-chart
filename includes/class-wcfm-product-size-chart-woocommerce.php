<?php
/**
 * File containing the class WCFM_Product_Size_Chart_Woocommerce.
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
        add_action('wcfm_product_manager_right_panel_after', [$this, 'wcfm_add_product_size_chart_dropdown']);
        add_action('after_wcfm_products_manage_meta_save', [$this, 'wcfm_product_save_product_size_chart_id'], 30, 2);
        add_action('woocommerce_single_product_summary', [$this, 'wcfm_product_size_chart_popup'], 25);
	}

    public function wcfm_add_product_size_chart_dropdown($product_id) {
        global $WCFM, $WCFMu, $wp;

        $charts = ['' => __('No Chart', 'wcfm-product-size-chart')];
        foreach (get_wcfm_product_size_charts() as $chart_item) {
            $charts[$chart_item->ID] = sprintf( esc_html__( '%1$s (#%2$s)', 'wcfm-product-size-chart' ), $chart_item->post_title, $chart_item->ID );            
        }

        $chart_id = get_post_meta( $product_id, 'wcfm_product_size_chart_id', true);

        $WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_size_chart_select', array(
            "wcfm_product_size_chart" => array('label' => __( 'Select Size Chart', 'wcfm-product-size-chart' ), 'type' => 'select', 'options' => $charts, 'class' => 'wcfm-select wcfm_ele wcfm_full_ele catalog_visibility_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_full_ele catalog_visibility_ele', 'value' => $chart_id ),
        )) );

        echo '<a style="color:#666; margin-top: -10px!important;font-size:14px;text-align:left" class="wcfm_side_tag_cloud wcfm_fetch_tag_cloud" href="'. add_query_arg( 'edit_chart', 'new', wcfm_product_sizes_chart_url() ) . '">'. __('create a chart', 'wcfm-product-size-chart') .'</a>';
    }

    public function wcfm_product_save_product_size_chart_id($product_id, $proudct_data) {
        update_post_meta( $product_id, 'wcfm_product_size_chart_id', $proudct_data['wcfm_product_size_chart']);
    }

    public function wcfm_product_size_chart_popup() {
        global $product;

        $chart_id = get_post_meta( $product->get_id(), 'wcfm_product_size_chart_id', true);
        if ( !$chart_id ) {
            return;
        }

        $chart = get_post( $chart_id );
        echo '<a class="wcfm-product-size-chart-popup-btn" href="#">Size Chart</a>';
        echo '<div class="wcfm-product-size-chart-popup">';
            echo '<div class="wcfm-chart-popup-content">';
                echo '<span class="wcfmfa fa-close" data-close></span>';
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
