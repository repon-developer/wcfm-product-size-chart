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
                                        $selected = in_array($product_id, (array) $form->exclude_products) ? 'selected="selected"' : '';
                                        printf('<option value="%s" %s>%s</option>', $product_id, $selected, $product_title);                                        
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Chart Table</th>
                            <td>
                                <?php
                                $product_size_table = $form->product_size_table;                                
                                if ( !is_array($product_size_table)) {
                                    $product_size_table = [];
                                }
                                
                                $headers = array_shift($product_size_table);
                                ?>
                                <div id="chart-editor-container">
                                    <input id="product_size_table" name="product_size_table" type="hidden" value='[["UK","US","Inch"],["34","54","56"],["24","65","55"]]'>
                                    <table class="table-wcfm-chart-editor">
                                        <thead>
                                            <tr>
                                                <th class="remove-row"></th>
                                                <?php
                                                 foreach ($headers as $header) {
                                                     echo '<th>';
                                                         printf('<input placeholder="Header" type="text" name="chart_data" value="%s">', $header);
                                                         echo '<span class="wcfmfa fa-close" data-delete-column></span>';
                                                     echo '</th>';
                                                 }
                                                ?>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($product_size_table as $key => $row) {
                                                echo '<tr>';
                                                echo '<td class="remove-row"><span class="wcfmfa fa-close" data-delete-row></span></td>';
                                                foreach ($row as $data) {
                                                    printf('<td><input type="text" name="chart_data" value="%s"></td>', $data);
                                                }
                                                echo '</tr>';
                                            } 
                                            ?>
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