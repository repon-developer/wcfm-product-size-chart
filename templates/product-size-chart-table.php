<div class="wcfm-product-size-chart-container">
    <?php 

echo '<div class="chart-content">' . get_the_content( null, false, $chart_id) . '</div>';

$chart_data = $chart->product_size_table;

if ( is_array($chart_data) && !empty($chart_data)) :
    $header = array_shift($chart_data); ?>
    <table class="wcfm-product-size-chart-table">
        <thead>
            <tr>
                <?php foreach ($header as $header_data) {
                    printf('<th>%s</th>', $header_data);
                }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php 
            foreach ($chart_data as $chart_row) {
                echo '<tr>';

                foreach ($chart_row as $cell_data) {
                    printf('<td>%s</td>', $cell_data);
                }

                echo '</tr>';
            } ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>