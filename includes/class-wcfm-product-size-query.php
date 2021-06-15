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
class WCFM_Product_Size_Query extends WP_Query {
	

	/**
	 * Constructor.
	 */
	public function __construct() {

        parent::__construct( [
            'post_type' => 'wcfm_product_size',
            'author' => get_current_user_id(  ),
			'post_status' => ['publish', 'pending', 'draft', 'future', 'trash']
        ] );
	}

}
