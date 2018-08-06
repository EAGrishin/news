setInterval(function () {
    $('.shiny-text').addClass('shiny-text-active');
    setTimeout(function () {
        $('.shiny-text').removeClass('shiny-text-active');
    }, 500);
}, 10000);
