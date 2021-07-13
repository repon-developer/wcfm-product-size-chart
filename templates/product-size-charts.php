<?php $product_sizes_query = new WCFM_Product_Size_Query();

$post_statuses = wcfm_get_chart_statuses();
$post_statuses['trash'] = __('Trash'); ?>

<div class="collapse wcfm-collapse" id="wcfm_product_size_chart">

    <div class="wcfm-collapse-content">

        <div class="wcfm-container wcfm-top-element-container">
            <h2><?php _e( 'Product size charts', 'wcfm-product-size-chart' ); ?></h2>
            <a class="add_new_wcfm_ele_dashboard" href="<?php echo add_query_arg( 'edit_chart', 'new', wcfm_product_sizes_chart_url() ) ?>"><span
                    class="wcfmfa fa-table"></span><span class="text"><?php _e('Add Size Chart', 'wcfm-product-size-chart') ?></span></a>
        </div><br>

        <div class="wcfm-container">
            <div class="wcfm-content">

                <table class="table-wcfm-product-sizes">
                    <thead>
                        <tr>
                            <th><?php _e('Title', 'wcfm-product-size-chart') ?></th>
                            <th><?php _e('Status', 'wcfm-product-size-chart') ?></th>
                            <th><?php _e('Action', 'wcfm-product-size-chart') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if ( $product_sizes_query->have_posts() ) : ?>

						<?php while( $product_sizes_query->have_posts() ) : $product_sizes_query->the_post();
							$edit_permalink = add_query_arg( 'edit_chart', get_the_ID(), wcfm_product_sizes_chart_url() ); 
							$delete_permalink = add_query_arg( [
                                'chart' =>  get_the_ID(),
                                '_nonce' => wp_create_nonce( 'delete_chart_size' )
                            ], wcfm_product_sizes_chart_url() );                             
                            
                            ?>
							<tr>
								<td>
									
									<a href="<?php echo $edit_permalink; ?>"><?php the_title(); ?></a>
								</td>

                                <td>
									<?php echo $post_statuses[get_post_status()] ?>
								</td>

                                <td class="actions">
                                    <a class="wcfmfa fa-edit" href="<?php echo $edit_permalink ?>"></a>
                                    <a class="wcfmfa fa-trash" href="<?php echo $delete_permalink ?>"></a>
                                </td>
							</tr>

						<?php endwhile; 
					else:

						printf('<tr><td colspan="9">%s</td></tr>', __('No Product Sizes Found', 'wcfm-product-size-chart'));

					endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>