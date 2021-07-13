<?php
    $post_status = $form->post_status ? $form->post_status : 'publish';
?>

<div class="collapse wcfm-collapse" id="wcfm_product_size_chart">
    <div class="wcfm-collapse-content">
        <div class="wcfm-container">
            <div class="wcfm-content">
                <form method="post">
                    <?php wp_nonce_field('nonce_product_size_edit', '_nonce_product_size_edit') ?>
                    <input type="hidden" name="form_id" value=<?php echo $form->ID ?>>
                    <table class="table-product-size-chart-edit">
                        <tr>
                            <th><?php _e('Title', 'wcfm-product-size-chart') ?></th>
                            <td><input type="text" name="post_title" value="<?php echo $form->post_title ?>"></td>
                        </tr>

                        <tr>
                            <th><?php _e('Chart size image & content', 'wcfm-product-size-chart') ?></th>
                            <td><?php wp_editor( $form->post_content, 'post_content') ?></td>
                        </tr>

                        <tr>
                            <th><?php _e('Chart Table', 'wcfm-product-size-chart') ?></th>
                            <td>
                                <?php

                                $product_size_table = $form->product_size_table;
                                if ( !is_array($product_size_table) || empty($product_size_table)) {
                                    $product_size_table = [['', ''], ['', '']];
                                }
                                
                                $headers = array_shift($product_size_table);
                                ?>
                                <div id="chart-editor-container">
                                    <input id="product_size_table" name="product_size_table" type="hidden" value='<?php echo json_encode($form->product_size_table) ?>'>
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
                                                <td colspan="20"><a class="btn-add-row" href="#"><?php _e('Add Row', 'wcfm-product-size-chart') ?></a></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a class="btn-add-column" href="#"><?php _e('Add Column', 'wcfm-product-size-chart') ?></a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th><?php _e('Status', 'wcfm-product-size-chart') ?></th>
                            <td>
                                <select name="post_status">
                                    <?php foreach (wcfm_get_chart_statuses() as $key => $status) {
                                        printf('<option value="%s" %s>%s</option>', $key, selected( $post_status, $key ), $status);                                        
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <button class="btn-submit"><?php _e('Save Now', 'wcfm-product-size-chart') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>