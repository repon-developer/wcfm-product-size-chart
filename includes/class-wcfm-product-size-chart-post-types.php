<?php
/**
 * File containing the class WCFM_Product_Size_Chart_Post_Types.
 *
 * @package wcfm-product-size-chart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles displays and hooks for the WCFM Product Size Chart custom post type.
 *
 * @since 1.0.0
 */
class WCFM_Product_Size_Chart_Post_Types {

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0.1
	 */
	private static $instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
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
		add_action( 'init', [ $this, 'register_post_types' ], 0 );	
	}

	/**
	 * Registers the custom post type and taxonomies.
	 */
	public function register_post_types() {
		if ( post_type_exists( 'wcfm_product_size' ) ) {
			return;
		}

		$singular = __( 'Product Size Chart', 'wcfm-product-size-chart' );
		$plural   = __( 'Product Size Charts', 'wcfm-product-size-chart' );

		register_post_type('wcfm_product_size', array(
			'labels'                => [
				'name'                  => $plural,
				'singular_name'         => $singular,
				//'menu_name'             => $plural,
				'all_items'             => sprintf( __( 'All %s', 'wcfm-product-size-chart' ), $plural ),
				'add_new'               => __( 'Add New', 'wcfm-product-size-chart' ),
				'add_new_item'          => sprintf( __( 'Add %s', 'wcfm-product-size-chart' ), $singular ),
				'edit'                  => __( 'Edit', 'wcfm-product-size-chart' ),
				'edit_item'             => sprintf( __( 'Edit %s', 'wcfm-product-size-chart' ), $singular ),
				'new_item'              => sprintf( __( 'New %s', 'wcfm-product-size-chart' ), $singular ),
				'view'                  => sprintf( __( 'View %s', 'wcfm-product-size-chart' ), $singular ),
				'view_item'             => sprintf( __( 'View %s', 'wcfm-product-size-chart' ), $singular ),
				'search_items'          => sprintf( __( 'Search %s', 'wcfm-product-size-chart' ), $plural ),
				'not_found'             => sprintf( __( 'No %s found', 'wcfm-product-size-chart' ), $plural ),
				'not_found_in_trash'    => sprintf( __( 'No %s found in trash', 'wcfm-product-size-chart' ), $plural ),
				'parent'                => sprintf( __( 'Parent %s', 'wcfm-product-size-chart' ), $singular ),
				'featured_image'        => __( 'Product Size', 'wcfm-product-size-chart' ),
				'set_featured_image'    => __( 'Set Product Size Image', 'wcfm-product-size-chart' ),
				'remove_featured_image' => __( 'Remove Product Size Image', 'wcfm-product-size-chart' ),
				'use_featured_image'    => __( 'Use as Product Size Image', 'wcfm-product-size-chart' ),
			],
			'description'           => sprintf( __( 'This is where you can create and manage %s.', 'wcfm-product-size-chart' ), $plural ),
			'public'                => false,
			'hierarchical'          => false,
			'supports'              => [ 'title', 'editor', 'custom-fields', 'thumbnail', 'author'],
			'menu_position'         => 10,
			'menu_icon' 			=> 'dashicons-schedule'
		));
	}
}
