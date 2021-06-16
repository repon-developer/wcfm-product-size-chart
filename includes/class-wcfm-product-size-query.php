<?php
/**
 *
 * @package wcfm-product-size-chart
 * @since   1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend WP_Query class for product size query
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
