(function ($) {

    $('.wcfm-product-size-chart-popup-btn').on('click', function (e) {
        e.preventDefault();
        $('.wcfm-product-size-chart-popup').addClass('opened');
    })

    $('.wcfm-product-size-chart-popup [data-close]').on('click', function () {
        $('.wcfm-product-size-chart-popup').removeClass('opened');
    });

})(jQuery)