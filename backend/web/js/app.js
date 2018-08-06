/**
 * Плагин для создания ЧПУ адреса из любого инпута в форме
 */
(function ( $ ) {

    $.fn.sef_url = function( options ) {

        var settings = $.extend({
            selector_in: "",
            selector_out: "",
            sef_url: ""
        }, options );

        $(this).on('click', function(event){
            event.preventDefault();

            var sef_url = $(settings.selector_out);
            sef_url.val('loading...');

            $.post(settings.sef_url, {title: $(settings.selector_in).val()}, function(data) {
                sef_url.val(data);
            });
        });

        return this;
    };

}( jQuery ));