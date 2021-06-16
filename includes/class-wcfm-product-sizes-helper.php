<?php 

/**
 * Get product size chart endpoint url
 *
 * @since 1.0.1
 */
function wcfm_product_sizes_chart_url() {
    return wcfm_get_endpoint_url('product-size-chart', '', get_wcfm_page());
}

/**
 * Get product size chart endpoint url
 *
 * @since 1.0.1
 */
function get_wcfm_product_size_charts($args = []) {
    $args = wp_parse_args( $args, [
        'post_type' => 'wcfm_product_size',
        'author' => get_current_user_id(  ),
    ]);


    return get_posts( $args);     
}