(function ($) {
    "use strict";
    var adforest_ajax_url = $('#adforest_ajax_url').val();

    $('#clock').countdown($('#when_live').val(), function (event) { var $this = $(this).html(event.strftime($('#get_time').val())); });
})(jQuery);

function adforest_validateEmail(sEmail)
{
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) { return true; } else { return false; }
}


