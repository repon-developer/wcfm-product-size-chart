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
 *
 * @since 1.0.1
 */
class WCFM_Product_Size_Chart_Form {
	var $post = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->delete();
		$this->submit();

		$product_size = get_post($_GET['edit_chart']);
		
		if ( !is_a($product_size, 'WP_Post') || $product_size->post_type !== 'wcfm_product_size' ) {
			return;
		}

		$this->post = $product_size;
	}

	private function delete() {		
		if ( !wp_verify_nonce($_GET['_nonce'], 'delete_chart_size', ) ) {
			return;
		}

		$post = get_post($_GET['chart']);

		if ( !is_a($post, 'WP_Post') || $post->post_type !== 'wcfm_product_size' || $post->post_author != get_current_user_id() ) {
			return;
		}

		if ( $post->post_status === 'trash' ) {
			wp_delete_post( $_GET['chart'] );
		} else {
			wp_trash_post($_GET['chart']);
		}

		wp_safe_redirect(wcfm_product_sizes_chart_url());
		exit;
	}

	private function submit() {		
		if ( !wp_verify_nonce($_POST['_nonce_product_size_edit'], 'nonce_product_size_edit', ) ) {
			return;
		}

		$product_size_id = wp_insert_post([
			'ID' => $_GET['edit_chart'],
			'post_type' => 'wcfm_product_size',
			'post_title' => $_POST['post_title'],
			'post_content' => $_POST['post_content'],
			'post_status' => $_POST['post_status']
		]);


		update_post_meta( $product_size_id, 'product_size_table', json_decode(stripslashes($_POST['product_size_table']),true));	
		update_post_meta( $product_size_id, 'chart_position', $_POST['chart_position']);

		$redirect_link = wcfm_product_sizes_chart_url();
		exit(wp_safe_redirect($redirect_link));
	}

	public function __get ($name) {
		return $this->post->{$name};
	}


}
