(function ($) {

    if ( typeof select2 === 'function' ) {
        $('#chart-categories, #chart-exclude-products').select2();
    }

    const chart_table = $('#chart-editor-container table');

    $('#chart-editor-container .btn-add-column').on('click', function (e) {
        e.preventDefault();

        chart_table.find('thead tr').append('<th><input type="text" /> <span class="wcfmfa fa-close" data-delete-column /></th>');
        chart_table.find('tbody tr').append('<td><input type="text" /></td>');

        chart_table.trigger('update')
    })

    $('#chart-editor-container .btn-add-row').on('click', function (e) {
        e.preventDefault();
        const row = $('<tr />').append('<td class="remove-row"><span class="wcfmfa fa-close" data-delete-row></span></td>');
        chart_table.find('thead th:not(.remove-row)').each(() => {
            row.append(`<td><input type="text" /></td>`);
        });

        row.appendTo(chart_table.find('tbody'));
        chart_table.trigger('update');
    })

    chart_table.on('click', 'thead [data-delete-column]', function (e) {
        if ( $(this).closest('tr').children().length <= 2 ) {
            return;
        }

        const column_no = $(this).closest('th').index();

        chart_table.find('tr th').eq(column_no).remove();
        chart_table.find('tbody tr').each(function(){
            $(this).children().eq(column_no).remove()
        });

        chart_table.trigger('update');
    })

    chart_table.find('tbody').on('click', 'td.remove-row', function (e) {
        $(this).closest('tr').remove();
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

    $('.wcfm-product-size-chart-popup-btn').on('click', function(e){
        e.preventDefault();
        $('.wcfm-product-size-chart-popup').addClass('opened');
    })

    $('.wcfm-product-size-chart-popup [data-close]').on('click', function(){
        $('.wcfm-product-size-chart-popup').removeClass('opened');
    });

})(jQuery)