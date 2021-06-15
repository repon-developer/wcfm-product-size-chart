(function ($) {
    $('#chart-categories, #chart-exclude-products').select2();

    const chart_table = $('#chart-editor-container table');

    $('#chart-editor-container .btn-add-column').on('click', function (e) {
        e.preventDefault();

        chart_table.find('thead tr').append('<th><input name="chart_data" type="text" /></th>');
        chart_table.find('tbody tr').append('<td><input name="chart_data" type="text" /></td>');

        chart_table.trigger('update')
    })

    $('#chart-editor-container .btn-add-row').on('click', function (e) {
        e.preventDefault();

        const row_no = chart_table.find('tr').length;

        const row = $('<tr />');        
        chart_table.find('thead th').each(() => {
            row.append(`<td><input name="chart_data" type="text" /></td>`);
        });

        row.appendTo(chart_table.find('tbody'));

        chart_table.trigger('update');
    })

    chart_table.on('keyup', 'input', function(event) {

        chart_table.trigger('update');
    })

    chart_table.on('update', function(){
        var chart_data = [];

        chart_table.find('thead tr, tbody tr').each(function(row){
            const cell_data = [];
            $(this).find('th input, td input').each(function(){
                cell_data.push($(this).val())
            })

            chart_data.push(cell_data);
        })

        $('#product_size_table').val( JSON.stringify(chart_data))

    });

})(jQuery)