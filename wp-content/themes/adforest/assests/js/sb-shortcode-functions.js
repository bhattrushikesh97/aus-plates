/*Adforest Shorcode functions*/ !(function (r) {
    
    

    var e = jQuery("#is_rtl").val(),
    
        o = !1;
    "undefined" != e && "1" == e && (o = !0);
    var t = shortcode_globals.ajax_url;
    jQuery(document).ready(function () {
        
        jQuery(".sb-load-ajax-cats") &&
            jQuery(".sb-load-ajax-cats").select2({
                allowClear: !0,
                width: "100%",
                rtl: o,
                ajax: {
                    url: t,
                    dataType: "json",
                    delay: 250,
                    data: function (r) {
                        void 0 !== r.page && r.page;
                        var e = void 0 !== r.term ? r.term : "";
                        return "" == e ? { action: "load_categories_frontend_html" } : { q: e, action: "load_categories_frontend_html" };
                    },
                    escapeMarkup: function (r) {
                        return r;
                    },
                    processResults: function (e) {
                        var o = [];
                        return (
                            e &&
                                r.each(e, function (r, e) {
                                    o.push({ id: e[0], text: e[1] });
                                }),
                            { results: o }
                        );
                    },
                    cache: !0,
                },
                language: {
                    errorLoading: function () {
                        return shortcode_globals.errorLoading;
                    },
                    inputTooShort: function () {
                        return shortcode_globals.inputTooShort;
                    },
                    searching: function () {
                        return shortcode_globals.searching;
                    },
                    noResults: function () {
                        return shortcode_globals.noResults;
                    },
                },
            });
    });
})(jQuery);
