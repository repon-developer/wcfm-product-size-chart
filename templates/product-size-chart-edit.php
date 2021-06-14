<?php
    $post_status = $form->post_status ? $form->post_status : 'publish';
?>

<div class="collapse wcfm-collapse" id="wcfm_product_size_chart">
    <div class="wcfm-collapse-content">
        <div class="wcfm-container">
            <div class="wcfm-content">

                <?php //var_dump($product_cats); ?>


                <form method="post">
                    <?php wp_nonce_field('nonce_product_size_edit', '_nonce_product_size_edit') ?>
                    <input type="hidden" name="form_id" value=<?php echo $form->ID ?>>
                    <table class="table-product-size-chart-edit">
                        <tr>
                            <th>Title</th>
                            <td><input type="text" name="post_title" value="<?php echo $form->post_title ?>"></td>
                        </tr>

                        <tr>
                            <th>Chart size image & content</th>
                            <td><?php wp_editor( $form->post_content, 'post_content') ?></td>
                        </tr>

                        <tr>
                            <th>Product Categories</th>
                            <td>
                                <select id="chart-categories" name="chart_categories[]" multiple="multiple">
                                    <?php foreach ($product_cats as $product_cat) {
                                    $selected = in_array($product_cat->term_id, (array) $form->chart_categories) ? 'selected="selected"' : '';
                                    printf('<option value="%s" %s>%s</option>', $product_cat->term_id, $selected, $product_cat->name);                                        
                                }
                                ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Exclude Products</th>
                            <td>
                                <select id="chart-exclude-products" name="exclude_products[]" multiple="multiple">
                                    <?php foreach ($vendor_products as $product_id => $product_title) {
                                        $selected = in_array($product_id, (array) $form->products) ? 'selected="selected"' : '';
                                        printf('<option value="%s" %s>%s</option>', $product_id, $selected, $product_title);                                        
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Chart Table</th>
                            <td>
                                <div id="chart-editor-container">
                                    <table class="table-wcfm-chart-editor">
                                        <thead>
                                            <tr>
                                                <th><input type="text"></th>
                                                <th><input type="text"></th>
                                                <th><input type="text"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>

                                            <tr>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="20"><a class="btn-add-row" href="#">Add Row</a></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a class="btn-add-column" href="#">Add Column</a>
                                </div>


                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <select name="post_status">
                                    <?php foreach (get_post_statuses() as $key => $status) {
                                        printf('<option value="%s" %s>%s</option>', $key, selected( $post_status, $key ), $status);                                        
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <button class="btn-submit">Save Now</button>
                </form>
            </div>
        </div>
    </div>
</div>