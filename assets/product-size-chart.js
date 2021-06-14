(function ($) {
    $('#chart-categories, #chart-exclude-products').select2();

    const chart_table = $('#chart-editor-container table');

    $('#chart-editor-container .btn-add-column').on('click', function (e) {
        e.preventDefault();

        chart_table.find('thead tr').append('<th><input name="chart_data[]" type="text" /></th>');
        chart_table.find('tbody tr').append('<td><input name="chart_data[]" type="text" /></td>');
    })

    $('#chart-editor-container .btn-add-row').on('click', function (e) {
        e.preventDefault();

        const row = $('<tr />');        
        chart_table.find('thead th').each(() => {
            row.append('<td><input name="chart_data[]" type="text" /></td>');
        });

        row.appendTo(chart_table.find('tbody'));
    })

})(jQuery)