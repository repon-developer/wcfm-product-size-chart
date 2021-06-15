<?php 

function wcfm_product_sizes_chart_url() {
    return wcfm_get_endpoint_url('product-size-chart', '', get_wcfm_page());
}

function get_wcfm_product_size_charts($args = []) {

    $args = wp_parse_args( $args, [
        'post_type' => 'wcfm_product_size',
        'author' => get_current_user_id(  ),
    ]);


    $charts = get_posts( $args);


    return $charts;
}