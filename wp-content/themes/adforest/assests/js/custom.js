(function ($) {

    var sb_options = get_strings;
    var ajax_url = sb_options.ajax_url;
    var adforest_ajax_url = ajax_url;
    var autoplay = parseInt(sb_options.auto_slide_time);
    var is_rtl_check = sb_options.is_rtl;
    
    is_rtl = false;
    var navTextAngle = ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"];
    if (is_rtl_check == "1") {
        is_rtl = true;
        var navTextAngle = ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"];
    }
    if (is_rtl) {
        $("select").select2({dir: "rtl", placeholder: sb_options.select_place_holder, allowClear: true, width: '100%'});
    }
    setTimeout(function () {
        $('body').addClass('loaded');
    }, 3000);



    /* open and close nav bar*/
    $('#opennav').on('click', function () {
        $('#mySidenav').toggleClass("navigationOpen");
    });

    $('.closebtn').on('click', function () {
        $('#mySidenav').toggleClass("navigationOpen");
    });
    /*Search suggestion for product categories*/
    if ($('#product_text').length > 0) {
        $('#product_text').typeahead({
            minLength: 1,
            delay: 250,
            scrollBar: true,
            autoSelect: true,
            fitToElement: true,
            highlight: false,
            hint: true,
            source: function (query, process) {
                return $.get(ajax_url, {query: query, action: 'product_suggestions'}, function (data) {
                    jQuery('.adforest-search-spinner').remove();
                    data = $.parseJSON(data);
                    return process(data);
                });
            }
        });
    }
    

    $(document).ready(function () {
        $(".account-my").click(function () {
            $(".dropd").slideToggle("slow");
        });

         if ($('#spinner').length > 0) {
        document.getElementById('spinner').style.display = 'none';
    }
    });
    if ($(".carousel-team-style-1").length > 0) {
        $(".carousel-team-style-1").owlCarousel({
            items: 5,
            autoplay: autoplay,
            autoplayTimeout: 225000,
            margin: 10,
            loop: false,
            nav: true,
            responsiveClass: true,
            rtl: is_rtl,
            responsive: {
                0: {
                    items: 1

                },
                600: {
                    items: 1

                },
                767: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 3
                },
                1000: {
                    items: 3,
                    loop: false
                },
                1200: {
                    items: 5,
                    loop: false
                },
                1300: {
                    items: 5,
                    loop: $('.carousel-team-style-1 .wrapper-latest-product').length > 5 ? true : false,
                }

            },
            navText: ["<i class='fa fa-chevron-left arrow1'></i>", "<i class='fa fa-chevron-right arrow'></i>"]
        });
    }
    /*------------------------------------
     SUB MENU
     --------------------------------------*/
    $('.sub-menu ul').hide();
    $(".sub-menu a").click(function () {
        $(this).parent(".sub-menu").children("ul").slideToggle("100");
        $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
    });

    /*submit product search in header*/
    $("select").select2({placeholder: sb_options.select_place_holder, allowClear: true, width: '100%'});
    /*product archive change 4 /3 col*/
    $('#four-col').on('click', function () {
        elem = $('.listing-list-items');
        container = $('.change_archive_col');
        if (elem.hasClass('listing-list-items')) {
            elem.removeClass('listing-list-items');
            container.removeClass('col-lg-3');
        }
        elem.addClass('listing-list-items-1');
        container.addClass('col-lg-4');
    });

    $('#three-col').on('click', function () {
        elem = $('.listing-list-items-1');
        container = $('.change_archive_col');
        if (elem.hasClass('listing-list-items-1')) {
            elem.removeClass('listing-list-items-1');
            container.removeClass('col-lg-4');
        }
        elem.addClass('listing-list-items');
        container.addClass('col-lg-3');
    });


    if ($('#carousel-product').length > 0) {
        $('#carousel-product').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: true,
            itemWidth: 105,
            itemMargin: 10,
            asNavFor: '#slider-product',
            rtl: is_rtl,
        });
    }

    if ($('#slider-product').length > 0) {
        $('#slider-product').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: true,
            slideshow: true,
            sync: "#carousel-product",
            rtl: is_rtl
        });
    }

    /* Contact to Vendor on Vendor detail Page. */
    if ($('#vendro-owner-contact').length > 0) {
        $('#vendro-owner-contact').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {

            $('#sb_loading').show();
            $.post(ajax_url, {
                action: 'sb_send_email_to_store_vendor',
                sb_data: $("form.vendro-owner-contact").serialize(),
                vendor_id: $('#vendor_id').val(),
            }).done(function (response) {
                $('#sb_loading').hide();
                var res_arr = response.split("|");

                if ($.trim(res_arr[0]) != "0") {
                    toastr.success(res_arr[1], '', {
                        timeOut: 4000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 4000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            });
            return false;
        });
    }

    if (jQuery('[data-fancybox]').length > 0) {
        jQuery('[data-fancybox]').fancybox();
    }



    if ($('#hero_product_slider').length > 0) {
        $('#hero_product_slider').owlCarousel({
            autoplay: 2500,
            autoplayHoverPause: true,
            autoplayTimeout: autoplay,
            items: 4,
            loop: true,
            margin: 15,
            nav: true,
            rt: is_rtl,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1200: {
                    items: 4
                },
            },
            navText: ["<i class='fa fa-angle-left left-angle' data-inline='false' aria-hidden='true'></i>", "<i class='fa fa-angle-right right-angle' data-inline='false' aria-hidden='true'></i>"]
        });
    }


    $(".products_tabs_slider").each(function (i, obj) {

        var $this = $(this);
        var items = $this.find('.wrapper-latest-product').length;
        $this.owlCarousel({
            items: 4,
            autoplayHoverPause: true,
            autoplay: 2500,
            autoplayTimeout: autoplay,
            margin: 5,
            rtl: is_rtl,
            loop: $(".active .products_tabs_slider .wrapper-latest-product").length > 1 ? true : false,
            nav: true,
            responsiveClass: true,
            responsive: {0: {items: 1, nav: true}, 600: {items: 2, nav: true}, 1000: {items: 3, nav: true, loop: (items > 3) ? true : false}, 1200: {items: 4, nav: true, loop: (items > 4) ? true : false, }},
            navText: ["<i class='fa fa-chevron-left arrow1'></i>", "<i class='fa fa-chevron-right arrow'></i>"]
        });
        //test
    });


    $(".products_tabs_slider_full").each(function (i, obj) {

        var $this = $(this);
        var items = $this.find('.wrapper-latest-product').length;
        $this.owlCarousel({
            items: 5,
            autoplay: 2500,
            autoplayTimeout: autoplay,
            autoplayHoverPause: true,
            margin: 5,
            rtl: is_rtl,
            loop: $(".active .products_tabs_slider_full .wrapper-latest-product").length > 1 ? true : false,
            nav: true,
            responsiveClass: true,
            responsive: {0: {items: 1, nav: true}, 600: {items: 2, nav: true}, 1000: {items: 3, nav: true, loop: (items > 3) ? true : false}, 1200: {items: 5, nav: true, loop: (items > 5) ? true : false, }},
            navText: ["<i class='fa fa-chevron-left arrow1'></i>", "<i class='fa fa-chevron-right arrow'></i>"]
        });
        //test
    });



    $(".account-cart").click(function () {
        $(".product-cart-sb").slideToggle("slow");
    });
    $("#fav_product_btn").click(function () {
        $(".product-favourite-sb").slideToggle("slow");
    });

    /* ======================
     * Product favourites/un-favourites shop layout 5
     ========================*/
    $('.product_to_fav').on('click', function () {
        $(this).toggleClass("favourited");
        var status_class = $(this).hasClass("favourited");
        var status_code;
        if (status_class == true) {
            status_code = "true";
        } else {
            status_code = "false";
        }
        $('#sb_loading').show();
        $.post(ajax_url, {
            action: 'product_fav_add',
            product_id: $(this).attr('data-productId'),
            status_code: status_code,
        }).done(function (response) {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == 1) {
                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else if ($.trim(get_p[0]) == 0) {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });

    });

    /* ======================
     * vendor favourites/un-favourites
     ========================*/
    $('.vendor_to_fav').on('click', function () {
        $(this).toggleClass("favourited_v");
        var status_class = $(this).hasClass("favourited_v");
        var status_code;
        if (status_class == true) {
            status_code = "true";
        } else {
            status_code = "false";
        }
        $('#sb_loading').show();
        $.post(ajax_url, {
            action: 'vendor_fav_ad',
            vendor_id: $(this).attr('data-vendorid'),
            status_code: status_code,
        }).done(function (response) {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == 1) {

                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else if ($.trim(get_p[0]) == 0) {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });

    if ($(".login-user").length > 0) {
        $(".login-user").click(function () {
            $(".dropdown-user-login").slideToggle("slow");
        });
    }



    function adforest_disableEmptyInputs(form) {
        var controls = form.elements;
        for (var i = 0, iLen = controls.length; i < iLen; i++) {
            controls[i].disabled = controls[i].value == "";
        }
    }

    /*ad ads to favourite*/
    $('.ad_to_fav,.save-ad').on('click', function ()
    {
        var $this = $(this);
        $('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_fav_ad', ad_id: $(this).attr('data-adid'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == '1')
            {
                $this.addClass("ad-favourited");
                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });


    if ($('.clients-list').length > 0) {
        var $clientcarousel = $('.clients-list');
        var clients = $clientcarousel.children().length;
        var clientwidth = (clients * 220); // 140px width for each client item 
        $clientcarousel.css('width', clientwidth);

        var rotating = true;
        var clientspeed = 0;
        var seeclients = setInterval(rotateClients, clientspeed);

        $(document).on({
            mouseenter: function () {
                rotating = false; // turn off rotation when hovering
            },
            mouseleave: function () {
                rotating = true;
            }
        }, '.clients');

        function rotateClients() {
            if (rotating != false) {
                var $first = $('.clients-list li:first');
                $first.animate({'margin-left': '-220px'}, 4000, function () {
                    $first.remove().css({'margin-left': '0px'});
                    $('.clients-list li:last').after($first);
                });
            }
        }
    }

    /* Add to Cart*/
    $('body').on('click', '.sb_add_cart', function ()
    {
        $('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_add_cart', product_id: $(this).attr('data-product-id'), qty: $(this).attr('data-product-qty'), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location = get_r[2];
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location = get_r[2];
            }
        });
    });

    $('#client-logos').owlCarousel({
        loop: true,
        margin: 15,
        dots: false,
        rtl: is_rtl,
        nav: true,

        responsive: {
            0: {
                items: 1
            },
            450:{
                items:2
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            },
            1200: {
                items: 3
            },
            1300: {
                items: 5
            }
        },
        navText: ["<i class='fa fa-angle-left left-arrow' aria-hidden='true'></i>", "<i class='fa fa-angle-right right-arrow' aria-hidden='true'></i>"]
    });

    $('.location-ad-carousel').owlCarousel({
        loop: true,
        margin: 15,
        dots: false,
        rtl: is_rtl,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            768: {

                items: 2
            },
            1000: {
                items: 3
            },
            1200: {
                items: 3
            },
            1300: {
                items: 4
            }
        },
        navText: ["<i class='fa fa-angle-left chevron-1' aria-hidden='true'></i>", "<i class='fa fa-angle-right chevron-2' aria-hidden='true'></i>"]
    });

    if ($('.circle-1').length > 0) {
        var circle1 = anime({
            targets: '.circle-1',
            translateX: 50,
            translateY: 30,
            direction: 'alternate',
            duration: 4000,
            loop: true,
            easing: 'linear'
        });

        var circle2 = anime({
            targets: '.circle-2',
            translateX: 50,
            translateY: 30,
            direction: 'alternate',
            duration: 2000,
            loop: true,
            easing: 'linear'
        });


        var popular1 = anime({
            targets: '.popular-1',
            translateX: -50,
            translateY: 70,
            direction: 'alternate',
            duration: 3000,
            loop: true,
            easing: 'linear'
        });

    }


    
    if ($('#slider').length > 0) {
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 120,
            itemMargin: 5,
            asNavFor: '#slider',
            rtl: is_rtl,

        });

        $('#slider').flexslider({
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            animation: "slide",
            rtl: is_rtl,

        });
    }
    
    /* Ad Location */
    if ($('#lat').length > 0)
    {
        var lat = $('#lat').val();
        var lon = $('#lon').val();
        var map_type = sb_options.adforest_map_type;
        if (map_type == 'leafletjs_map')
        {
            /*For leafletjs map*/
            var map = L.map('itemMap').setView([lat, lon], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: ''}).addTo(map);
            L.marker([lat, lon]).addTo(map);
        } else if (map_type == 'google_map')
        {
            /*For Google Map*/
            var map = "";
            var latlng = new google.maps.LatLng(lat, lon);
            var myOptions = {zoom: 13, center: latlng, scrollwheel: false, mapTypeId: google.maps.MapTypeId.ROADMAP, size: new google.maps.Size(480, 240)}
            map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: latlng
            });
        }
    }


    /* Bidding System  */
    if ($('#sb_bid_ad').length > 0)
    {
        $('#sb_bid_ad').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(ajax_url, {action: 'sb_submit_bid', security: $('#sb-bidding-token').val(), sb_data: $("form#sb_bid_ad").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var res_arr = response.split("|");
                if ($.trim(res_arr[0]) != "0")
                {
                    toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
            );
            return false;
        });
    }


    if ($('#input-21b').length > 0)
    {
        var star_rtl = false;
        if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1") {
            star_rtl = true;
        }
        $('#input-21b').rating({filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>', starCaptions: {1: sb_options.one, 2: sb_options.two, 3: sb_options.three, 4: sb_options.four, 5: sb_options.five}});
    }

    /* Ad rating Logic */
    if ($('#ad_rating_form').length > 0) {
        $('#ad_rating_form').parsley().on('field:validated', function () {
            // Validation logic
        }).on('form:submit', function () {
            $('#sb_loading').show();
    
            var fileInput = $('#files')[0].files[0];
            var formSerialized = $('#ad_rating_form').serialize();
           
            var formData = new FormData();
            formData.append('formdata', formSerialized);
            formData.append('file', fileInput);
            formData.append('action', 'sb_ad_rating');
    
            // Use Parsley.js to prevent form submission
            var parsleyForm = $('#ad_rating_form').parsley();
            if (parsleyForm.isValid()) {
                $.post({
                    url: ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function (response) {
                    $('#sb_loading').hide();
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1') {
                        toastr.success(get_r[1], '', { timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right" });
                        location.reload();
                    } else {
                        toastr.error(get_r[1], '', { timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right" });
                    }
                }).fail(function () {
                    $('#sb_loading').hide();
                    toastr.error($('#_nonce_error').val(), '', { timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right" });
                });
            }
            return false; // Prevent default behavior
        });
    }

    
    $('.reply_ad_rating').on('click', function ()
    {
        var p_comment_id = $(this).attr('data-comment_id');
        $('#reply_to_rating').html($(this).attr('data-commenter-name'));
        $('#parent_comment_id').val(p_comment_id);
    });
    /*Send message to ad owner*/
    if ($('#rating_reply_form').length > 0)
    {
        $('#rating_reply_form').parsley().on('field:validated', function () {
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(ajax_url, {action: 'sb_ad_rating_reply', security: $('#sb-review-reply-token').val(), sb_data: $("form#rating_reply_form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == '1')
                {
                    toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {

                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
            return false;
        });
    }

    $('.sb-click-num').click(function () {
        var ad_id = jQuery(this).data('ad-id');
        var spinner_html = '<span><i class="fa fa-spinner spin"></i></span>';
        jQuery('.sb-phonenumber').html(spinner_html);
        $.post(adforest_ajax_url, {action: 'sb_display_phone_num', ad_id: ad_id}).done(function (response)
        {
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                jQuery('.sb-phonenumber').html(get_r[1]);
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                jQuery('.sb-phonenumber').html(sb_options.click_to_view);
            }
        });
    });

    if ($('#file_attacher').length > 0) {
        adforest_ajax_url = adforest_ajax_url;
        var attachmentsDropzone = new Dropzone(document.getElementById('file_attacher'), {// Make the whole body a dropzone
            url: adforest_ajax_url,
            autoProcessQueue: true,
            previewsContainer: "#attachment-wrapper", // Define the container to display the previews
            previewTemplate: '<span class="dz-preview dz-file-preview"><span class="dz-details"><span class="dz-filename"><i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;<span data-dz-name></span></span>&nbsp;&nbsp;&nbsp;<span class="dz-size" data-dz-size></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="cursor:pointer;font-size:15px;" data-dz-remove></i></span><span class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></span><i class="ti ti-refresh ti-spin"></i></span>',
            clickable: "a.msgAttachFile",
            acceptedFiles: $('#provided_format').val(),
            maxFilesize: 15,
            maxFiles: 4
        });


        attachmentsDropzone.on("sending", function () {
            $("#send_msg ,#send_ad_message").attr("disabled", true);
        });
        attachmentsDropzone.on("queuecomplete", function () {
            $("#send_msg, #send_ad_message").attr("disabled", false);
        });

    }

    /*Send message to ad owner*/
    if ($('#send_message_pop').length > 0)
    {
        $('#send_message_pop').parsley().on('field:validated', function () { }).on('form:submit', function () {
            $('#sb_loading').show();
            var fd = new FormData();

            if ($('#file_attacher').length > 0) {
                var fileUpload = $('#file_attacher').get(0).dropzone;

                var files = fileUpload.files;

// Looping over all files and add it to FormData object  
                for (var i = 0; i < files.length; i++) {
                    fd.append("message_file[]", files[i]);
                }

            }
            var sb_data = $("form#send_message_pop").serialize()
            var security = $('#sb-msg-token').val();
            fd.append('action', 'sb_send_message');
            fd.append('sb_data', sb_data);
            fd.append('security', security)
            $('#sb_loading').show();
            $.ajax({
                type: 'POST',
                url: adforest_ajax_url,
                data: fd,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#sb_loading').hide();
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == "1")
                    {
                        toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        $('#sb_forest_message').val('');

                        if ($('.dz-preview').length > 0) {
                            Dropzone.forElement('#file_attacher').removeAllFiles(true);
                            $('.dz-preview').remove();
                            $('.dz-success').fadeOut('slow');
                        }
                        $(".close").trigger("click");
                    } else
                    {
                        toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        $(".close").trigger("click");
                    }
                },
                error: function () {
                    $('#sb_loading').hide();
                    toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            });

            return false;
        });
    }


    /*image sortable for ad detail page*/
    if ($("#sortable").length > 0)
    {
        $("#sortable").sortable({
            stop: function (event, ui) {
                $('#post_img_ids').val('');
                var current_img = '';
                $(".ui-state-default img").each(function (index) {
                    current_img = current_img + $(this).attr('data-img-id') + ",";
                });
                $('#post_img_ids').val(current_img.replace(/,\s*$/, ""));
            }
        });
        $("#sortable").disableSelection();
    }
    $('#sb_sort_images').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_sort_images', ids: $('#post_img_ids').val(), ad_id: $('#current_pid').val(), }).done(function (response)
        {
            toastr.success($('#re-arrange-msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            location.reload();
            $('#sb_loading').hide();
        });
    });

    $('.skin-minimal .list li input').iCheck({checkboxClass: 'icheckbox_minimal', radioClass: 'iradio_minimal', increaseArea: '20%'});
    $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_minimal', radioClass: 'iradio_minimal', increaseArea: '20%'});



    if ($('#sb-login-form').length > 0)
    {

        $('#sb_login_msg').hide();
        $('#sb_login_redirect').hide();
        $('#sb-login-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    $('#sb_login_submit').hide();
                    $('#sb_login_msg').show();
                    $.post(adforest_ajax_url, {action: 'sb_login_user', security: $('#sb-login-token').val(), sb_data: $("form#sb-login-form").serialize(), }).done(function (response)
                    {

                        $('#sb_loading').hide();
                        $('#sb_login_msg').hide();
                        if ($.trim(response) == '1')
                        {
                            $('#sb_login_redirect').show();
                            window.location = sb_options.sb_after_login_page;
                        } else
                        {
                            $('#sb_login_submit').show();
                            toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_login_submit').show();
                        $('#sb_loading').hide();
                        $('#sb_login_msg').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    }
    /* Forgot Password*/
    if ($('#sb-forgot-form').length > 0)
    {
        $('#sb_forgot_msg').hide();
        $('#sb-forgot-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_forgot_submit').hide();
            $('#sb_forgot_msg').show();
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_forgot_password', security: $('#sb-forgot-pass-token').val(), sb_data: $("form#sb-forgot-form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $('#sb_forgot_msg').hide();
                if ($.trim(response) == '1')
                {
                    $('#sb_forgot_submit').show();
                    $('#sb_forgot_email').val('');
                    toastr.success($('#adforest_forgot_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    $('#myModal').modal('hide');
                } else
                {
                    $('#sb_forgot_submit').show();
                    toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_forgot_submit').show();
                $('#sb_forgot_email').val('');
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
            return false;
        });
    }


    /*Register user*/
    if ($('#sb-sign-form').length > 0)
    {
        $('#sb_register_msg').hide();
        $('#sb_register_redirect').hide();
        $('#sb-sign-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();
            var google_recaptcha_type = jQuery("#google_recaptcha_type").val();
            google_recaptcha_type = typeof google_recaptcha_type !== 'undefined' ? google_recaptcha_type : 'v2';
            var google_recaptcha_site_key = jQuery("#google_recaptcha_site_key").val();
            if (google_recaptcha_type == 'v3' && google_recaptcha_site_key !== 'undefined' && google_recaptcha_site_key != '') {
                grecaptcha.ready(function () {
                    var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                    try {
                        grecaptcha.execute(google_recaptcha_site_key, {action: "register_form"}).then(function (token) {
                            jQuery("#sb-sign-form").prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                            jQuery.post(adforest_ajax_url, {action: "sb_goggle_captcha3_verification", token: token}, function (result) {
                                result = JSON.parse(result);
                                if (result.success) {
                                    $('#sb_register_submit').hide();
                                    $('#sb_register_msg').show();
                                    $.post(adforest_ajax_url, {action: 'sb_register_user', security: $('#sb-register-token').val(), sb_data: $("form#sb-sign-form").serialize(), }).done(function (response)
                                    {
                                        $('#sb_loading').hide();
                                        $('#sb_register_msg').hide();
                                        if ($.trim(response) == '1')
                                        {
                                            $('#sb_register_redirect').show();
                                            window.location = sb_options.sb_after_login_page;
                                        } else if ($.trim(response) == '2')
                                        {
                                            $('.resend_email').show();
                                            toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        } else if ($.trim(response) == '3')
                                        {
                                            toastr.success($('#admin_verify_account').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        } else
                                        {
                                            $('#sb_register_submit').show();
                                            toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        }
                                    }).fail(function () {
                                        $('#sb_loading').hide();
                                        $('#sb_register_msg').hide();
                                        $('#sb_register_submit').show();
                                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                    });
                                } else {
                                    $('#sb_loading').hide();
                                    $('#sb_register_submit').show();
                                    toastr.error(result.msg, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        });
                    } catch (err) {
                        var google_recaptcha_error_text = jQuery("#google_recaptcha_error_text").val();
                        google_recaptcha_error_text = typeof google_recaptcha_error_text !== 'undefined' ? google_recaptcha_error_text : err;
                        jQuery('#sb_loading').hide();
                        toastr.error(google_recaptcha_error_text, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });

            } else {
                $('#sb_register_submit').hide();
                $('#sb_register_msg').show();
                $.post(adforest_ajax_url, {action: 'sb_register_user', security: $('#sb-register-token').val(), sb_data: $("form#sb-sign-form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    $('#sb_register_msg').hide();

                    if ($.trim(response) == '1')
                    {
                        $('#sb_register_redirect').show();
                        window.location = sb_options.sb_after_login_page;
                    } else if ($.trim(response) == '2')
                    {
                        $('.resend_email').show();
                        toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else if ($.trim(response) == '3')
                    {
                        toastr.success($('#admin_verify_account').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else
                    {
                        $('#sb_register_submit').show();
                        toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                }).fail(function () {
                    $('#sb_loading').hide();
                    $('#sb_register_msg').hide();
                    $('#sb_register_submit').show();
                    toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                });
            }
            return false;
        });
    }
    /*Resend Email*/
    $('#resend_email').on('click', function ()
    {
        var usr_email = $('#sb_reg_email').val();
        $.post(adforest_ajax_url, {action: 'sb_resend_email', usr_email: usr_email, }).done(function (response)
        {
            toastr.success($('#verify_account_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            $('.resend_email').hide();
            $('.contact_admin').show();
        });
    });
    if (sb_options.facebook_key != "" && sb_options.google_key != "")
    {
        hello.init({facebook: sb_options.facebook_key, google: sb_options.google_key, }, {redirect_uri: sb_options.redirect_uri});
    } else if (sb_options.facebook_key != "" && sb_options.google_key == "")
    {
        hello.init({facebook: sb_options.facebook_key, }, {redirect_uri: sb_options.redirect_uri});
    } else if (sb_options.google_key != "" && sb_options.facebook_key == "")
    {
        hello.init({google: sb_options.google_key, }, {redirect_uri: sb_options.redirect_uri});
    }
    $('.social-item a.btn-social').on('click', function ()
    {
        hello.on('auth.login', function (auth) {
            $('#sb_loading').show();
            hello(auth.network).api('me').then(function (r) {

                if ($('#get_action').val() == 'login' || $('#get_action').val() == 'register')
                {
                    var access_token = hello(auth.network).getAuthResponse().access_token;
                    var sb_network = hello(auth.network).getAuthResponse().network;
                    $.post(adforest_ajax_url, {action: 'sb_social_login', access_token: access_token, sb_network: sb_network, security: $('#sb-social-login-nonce').val(), email: r.email, key_code: $('#nonce').val()}).done(function (response)
                    {
                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1')
                        {
                            $('#nonce').val(get_r[1]);
                            if ($.trim(get_r[2]) == '1')
                            {
                                toastr.success(get_r[3], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                               window.location = sb_options.sb_after_login_page;
                            } else
                            {
                                toastr.error(get_r[3], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                        } else {
                            toastr.error(get_r[3], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    );

                } else
                {
                    $('#sb_reg_name').val(r.name);
                    $('#sb_reg_email').val(r.email);
                }
                $('#sb_loading').hide();
            });
        });
    });

    var column2inmobile = sb_options.sb_2_column;
    var column_count = (column2inmobile == true) ? 2 : 1;

    if (column2inmobile == true && $(".featured-slider-1 .item .col-6").length > 0) {
        $(".featured-slider-1 .item .col-6").removeClass('col-6 col-sm-6').addClass('col-12 col-sm-12');

    }


    if ($(".featured-slider-1 .item .col-md-4").length > 0) {
        $(".featured-slider-1 .item .col-md-4").removeClass('col-md-4 col-lg-4').addClass('col-md-12 col-lg-12');
    }

    if ($(".featured-slider .item .col-lg-4").length > 0) {
        $(".featured-slider .item .col-lg-4").removeClass('col-md-6 col-lg-4 col-md-4').addClass('col-md-12 col-lg-12');
    }
    if (column2inmobile == true && $(".featured-slider .item .col-6").length > 0) {
        $(".featured-slider .item .col-6").removeClass('col-6 col-sm-6').addClass('col-12 col-sm-12');

    }

    $('.featured-slider').owlCarousel({
        rtl: is_rtl,
        dots: false,
        loop: ($(".featured-slider .item").length > 1) ? true : false,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: autoplay,
        margin: 10,
        responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {0: {items: column_count, nav: true}, 600: {items: 2, nav: true}, 768: {items: ipad_item, nav: true}, 1000: {items: 3, nav: true}, 1200: {items: $('#slider_item').val(), nav: true, loop: ($(".featured-slider .item").length > 1) ? true : false, }}
    });


    /* Featured Carousel 2 */

    var searchLayout = $('#search_layout').val();


    var ipad_item = 3;
    var ipadpro_item = 3;
    if (searchLayout == 'topbar') {
        ipad_item = 2;
    }
    if (searchLayout == 'map') {
        ipadpro_item = 2;
    }

    $('.featured-slider-1').owlCarousel({
        rtl: is_rtl,
        dots: ($(".featured-slider-1 .item").length > 1) ? false : false,
        loop: ($(".featured-slider-1 .item").length > 1) ? true : false,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: autoplay,
        margin: 10,
        responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {0: {items: column_count, nav: true}, 600: {items: 2, nav: true}, 768: {items: ipad_item, nav: true}, 1000: {items: ipadpro_item, nav: true}, 1200: {items: $('#slider_item').val(), nav: true, loop: ($(".featured-slider-1 .item").length > $('#slider_item').val()) ? true : false, }}
    });

    /* Featured  Carousel 3 */



    /*
     if ($('.promotionalslider_wrapper_4').length > 0) {
     var slideItem = $('.promotionalslider_wrapper_4  .found-listing-item').length;
     if (slideItem > 4) {
     slideItem = 4;
     }
     var searchLayout = $('#search_layout').val();
     if (searchLayout == "map" && slideItem > 2) {
     slideItem = 2;
     } else if (searchLayout == "topbar" && slideItem > 3) {
     slideItem = 3;
     }
     var sb_2_column = sb_options.sb_2_column;
     mobilItem = 1;
     if (sb_2_column) {
     mobilItem = 2;
     }
     $('.promotionalslider_wrapper_4').slick({
     dots: false,
     infinite: true,
     speed: 300,
     slidesToShow: slideItem,
     slidesToScroll: 1,
     rtl: is_rtl,
     responsive: [
     {
     breakpoint: 1024,
     settings: {
     slidesToShow: 2,
     slidesToScroll: 2,
     infinite: true,
     dots: false
     }
     },
     {
     breakpoint: 1200,
     settings: {
     slidesToShow: 2,
     slidesToScroll: 2,
     infinite: true,
     dots: false
     }
     },
     {
     breakpoint: 600,
     settings: {
     slidesToShow: mobilItem,
     slidesToScroll: 2
     }
     },
     {
     breakpoint: 480,
     settings: {
     slidesToShow: mobilItem,
     slidesToScroll: 1
     }
     }
     ]
     });
     }
     */




    if ($('.feature-ads-carousel').length > 0) {
        $('.feature-ads-carousel').slick({
            loop: false,
            stagePadding: 15,
            autoplaySpeed: autoplay,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            nav: true,
            rtl: is_rtl,
            prevArrow: '<span class="slick-prev prev-ads"><i class="fa fa-angle-left"></i></span>',
            nextArrow: '<span class="slick-next  next-ads"><i class="fa fa-angle-right"></i></span>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },

                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },

                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    $('select.submit_on_select').on("select2:select", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });
    $('.fa_cursor').on("click", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });
    $('.submit_on_select').on('click', function () {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });


    if ($('.custom-select').length > 0) {
        $('.custom-select').select2('destroy');
    }
    $("#you_current_location_text").click(function () {

        $('#sb_loading').show();
        $.ajax({
            url: "https://geolocation-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                $('#sb_loading').hide();
                $('#sb-radius-form #sb_user_address').val(location.city + ", " + location.state + ", " + location.country_name);
                var map_type = sb_options.adforest_map_type;
                if (map_type == 'leafletjs_map')
                {
                    $('#sb_user_address_lat').val(location.latitude);
                    $('#sb_user_address_long').val(location.longitude);
                }
            }
        });
    });


    /*Location while ad posting*/
    $('#sb_user_address').on('focus', function () {
        
        var map_type = sb_options.adforest_map_type;
        if (map_type == 'google_map') {
            adforest_location();
        }
    });


    /*More Js Added On Descmber 5*/
    $(".mobile-filters-btn a, a.filter-close-btn").on("click", function () {
        $('.mobile-filters').toggleClass("active");
    });
    /*Scroll to top when arrow up clicked BEGIN*/
    $(window).scroll(function () {
        var height = $(window).scrollTop();
        if (height > 120) {
            /*$('.mobile-filters-btn a').fadeOut();*/
        } else {
            $('.mobile-filters-btn a').fadeIn();
        }
    });
    $(document).ready(function () {
        $(".mobile-filters-btn a").click(function (event) {
            event.preventDefault();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        });
    });
    /*Scroll to top when arrow up clicked END*/


    function adforest_disableEmptyInputs(form) {
        var controls = form.elements;
        for (var i = 0, iLen = controls.length; i < iLen; i++) {
            controls[i].disabled = controls[i].value == "";
        }
    }



    /* Show Number */
    /* improvement for crawler **/
    $('.sb-click-num-user').click(function () {
        var user_id = jQuery(this).data('user_id');


        var spinner_html = '<span><i class="fa fa-spinner spin"></i></span>';
        jQuery('.sb-phonenumber').html(spinner_html);
        $.post(adforest_ajax_url, {action: 'sb_display_phone_num_user', user_id: user_id}).done(function (response)
        {

            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                jQuery('.sb-phonenumber').html(get_r[1]);
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                jQuery('.sb-phonenumber').html(sb_options.click_to_view);
            }
        });
    });


    /* Contact from profile  */
    if ($('#user_contact_form').length > 0)
    {
        $('#user_contact_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();

            var google_recaptcha_type = sb_options.google_recaptcha_type;

            google_recaptcha_type = typeof google_recaptcha_type !== 'undefined' ? google_recaptcha_type : 'v2';
            var google_recaptcha_site_key = jQuery("#google_recaptcha_site_key").val();


            if (google_recaptcha_type == 'v3' && google_recaptcha_site_key !== 'undefined' && google_recaptcha_site_key != '') {
                grecaptcha.ready(function () {
                    try {



                        grecaptcha.execute(google_recaptcha_site_key, {action: "contact_form"}).then(function (token) {
                            jQuery("#user_contact_form").prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');

                            jQuery.post(adforest_ajax_url, {
                                action: "sb_goggle_captcha3_verification",
                                token: token,
                            }, function (result) {
                                result = JSON.parse(result);
                                if (result.success) {
                                    $.post(adforest_ajax_url, {action: 'sb_user_contact_form', receiver_id: $('#receiver_id').val(), sb_data: $("form#user_contact_form").serialize(), }).done(function (response)

                                    {
                                        $('#sb_loading').hide();
                                        var res_arr = response.split("|");
                                        if ($.trim(res_arr[0]) != "0")
                                        {
                                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                         location.reload(); 
                                        } else
                                        {
                                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        }
                                    });
                                } else {
                                    $('#sb_loading').hide();
                                    $('#sb_register_submit').show();
                                    toastr.error(result.msg, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        });
                    } catch (err) {
                        var google_recaptcha_error_text = jQuery("#google_recaptcha_error_text").val();
                        google_recaptcha_error_text = typeof google_recaptcha_error_text !== 'undefined' ? google_recaptcha_error_text : err;
                        jQuery('#sb_loading').hide();
                        toastr.error(google_recaptcha_error_text, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
            } else {
                $.post(adforest_ajax_url, {action: 'sb_user_contact_form', receiver_id: $('#receiver_id').val(), sb_data: $("form#user_contact_form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    var res_arr = response.split("|");
                    if ($.trim(res_arr[0]) != "0")
                    {
                        toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                    } else
                    {
                        toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
            }
            return false;
        });
    }

    if ($('#user_ratting_form').length > 0)
    {
        $('#user_ratting_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            // Ajax for Registration
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_post_user_ratting', security: $('#sb-user-rating-token').val(), sb_data: $("form#user_ratting_form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var res_arr = response.split("|");
                if ($.trim(res_arr[0]) != "0")
                {
                    toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
            );
            return false;
        });
    }

    $('.clikc_reply').on('click', function ()
    {
        $('#rator_name').html($(this).attr('data-rator-name'));
        $('#rator_reply').val($(this).attr('data-rator-id'));
    });

    /* Replay to Rator */
    if ($('#sb-reply-rating-form').length > 0)
    {
        $('#sb-reply-rating-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_reply_user_rating', security: $('#sb-user-rate-reply-token').val(), sb_data: $("form#sb-reply-rating-form").serialize(), }).done(function (response)
            {
                $('#sb_loading').hide();
                var res_arr = response.split("|");
                if ($.trim(res_arr[0]) != "0")
                {
                    toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    location.reload();
                } else
                {
                    toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
            );
            return false;
        });
    }



    $(".client-item").owlCarousel({
        items: 1,
        autoplay: true,
        autoplayTimeout: autoplay,
        margin: 30,
        speed: 500,
        dots: false,
        singleItem: true,
        height: 100,
        direction: 'alternate',
        duration: 4000,
        loop: true,
        nav: true,
        rtl: is_rtl,
        responsiveClass: true,
        responsive: {
            0: {

                items: 1
            },
            600: {

                items: 1
            },
            767: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            },
            1000: {
                items: 1,

                loop: true
            },
            1200: {
                items: 1,
                loop: true
            },
            1300: {
                items: 1,
                loop: true
            }
        },
        navText: ["<img src =" + $('#testimonial_img').val() + ">"]
    });


    adforest_timerCounter_function();


    /* Add Post*/
    if ($('#ad_post_form').length > 0)
    {
        $('#ad_cat_sub_div').hide();
        $('#ad_cat_sub_sub_div').hide();
        $('#ad_cat_sub_sub_sub_div').hide();
        $('#ad_country_sub_div').hide();
        $('#ad_country_sub_sub_div').hide();
        $('#ad_country_sub_sub_sub_div').hide();
        if ($('#is_update').val() != "")
        {
            var level = $('#is_level').val();
            if (level >= 2) {
                $('#ad_cat_sub_div').show();
            }
            if (level >= 3) {
                $('#ad_cat_sub_sub_div').show();
            }
            if (level >= 4) {
                $('#ad_cat_sub_sub_sub_div').show();
            }

            var country_level = $('#country_level').val();
            if (country_level >= 2) {
                $('#ad_country_sub_div').show();
            }
            if (country_level >= 3) {
                $('#ad_country_sub_sub_div').show();
            }
            if (country_level >= 4) {
                $('#ad_country_sub_sub_sub_div').show();
            }
        }

        $('#ad_post_form').parsley().on('field:validated', function () {
        }).on('form:error', function () {
            $('.ad_errors').show();
            $('.parsley-errors-list').show();
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_ad_posting', security: $('#sb-post-token').val(), sb_data: $("form#ad_post_form").serialize(), is_update: $('#is_update').val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                if ($.trim(response) == "0")
                {
                    toastr.error($('#not_logged_in').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else if ($.trim(response) == "1")
                {
                    toastr.error($('#ad_limit_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    //  window.location = $('#sb_packages_page').val();
                } else if ($.trim(response) == "img_req")
                {
                    toastr.error(sb_options.required_images, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else if ($.trim(response) == "2") {
                    toastr.error('Not allowed in demo mode', '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else
                {
                    if ($('#is_update').val() != 'undefined' && $('#is_update').val() != '') {
                        toastr.success($('#ad_updated').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else {
                        toastr.success($('#ad_posted').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                    window.location = response;
                }


            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
            return false;
        });
    }

    /*initilize jquery text editor */
    var ad_html_switch = $('#adforest_ad_html').val();
    ad_html_switch = typeof ad_html_switch !== 'undefined' && ad_html_switch == '1' ? true : false;
    if ($('#ad_description').length > 0)
    {
        if (ad_html_switch) {
            $('#ad_description').jqte({color: false});
        } else {
            $('#ad_description').jqte({link: false, unlink: false, formats: false, format: false, funit: false, fsize: false, fsizes: false, color: false, strike: false, source: false, sub: false, sup: false, indent: false, outdent: false, right: true, left: true, center: true, remove: false, rule: false, title: false, });
        }
    }

    /* ad post on bluring ad title */
    $('#ad_title').on('blur', function ()
    {
        if ($('#is_update').val() == "")
        {
            $.post(adforest_ajax_url, {action: 'post_ad', title: $('#ad_title').val(), is_update: $('#is_update').val(), }).done(function (response) { });
        }
    });


    if (jQuery('input[name=ad_title]').length > 0) {
        jQuery('input[name=ad_title]').keypress(function () {
            var spinner_html = '<span class="adforest-search-spinner"><i class="fa fa-spinner spin"></i></span>';
            if (jQuery(this).after(spinner_html)) {
                jQuery('.adforest-search-spinner').remove();
            }
            jQuery(this).after(spinner_html);
        });
    }



    $('input[name=ad_title]').typeahead({
        minLength: 1,
        delay: 250,
        scrollBar: true,
        autoSelect: true,
        fitToElement: true,
        highlight: false,
        hint: true,
        source: function (query, process) {
            return $.get(ajax_url, {query: query, action: 'fetch_suggestions'}, function (data) {
                jQuery('.adforest-search-spinner').remove();


                data = $.parseJSON(data);
                return process(data);
            });
        }
    });

    if ($('#is_sub_active').val() == "1") { /*images uplaod*/
        sbDropzone_image();
    }
    if ($('#is_sub_active').val() == "1") { /*images uplaod*/
        sbDropzone_video();
    }

    function sbDropzone_video()
    {
        if ($('#dropzone_video').length) {
            let videoLogoUrl = $('#video_logo_url').val();
            Dropzone.autoDiscover = false;
            var video_ajax_callback = adforest_ajax_url + "?action=upload_ad_videos&is_update=" + $('#is_update').val();
            if (adforest_ajax_url.indexOf('?lang=') !== -1) {
                video_ajax_callback = adforest_ajax_url + "&action=upload_ad_videos&is_update=" + $('#is_update').val();
            }
            var fileList = new Array;
            var acceptedFileTypes = "video/mp4,video/ogg,video/webm";
            var i = 0;
            var sb_max_files = typeof $('#sb_upload_video_limit').val() !== 'undefined' && $('#sb_upload_video_limit').val() == 'null' ? null : $('#sb_upload_video_limit').val();
            $("#dropzone_video").dropzone({
                timeout: 5000000,
                maxFilesize: 50000000,
                addRemoveLinks: true,
                paramName: "my_single_video_upload",
                maxFiles: sb_max_files, //change limit as per your requirements
                acceptedFiles: acceptedFileTypes,
                dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
                url: video_ajax_callback,
                parallelUploads: 1,
                dictDefaultMessage: $('#dictDefaultMessage').val(),
                dictFallbackMessage: $('#dictFallbackMessage').val(),
                dictFallbackText: $('#dictFallbackText').val(),
                dictFileTooBig: $('#dictFileTooBig').val(),
                dictInvalidFileType: $('#dictInvalidFileType').val(),
                dictResponseError: $('#dictResponseError').val(),
                dictCancelUpload: $('#dictCancelUpload').val(),
                dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
                dictRemoveFile: $('#dictRemoveFile').val(),
                dictRemoveFileConfirmation: null,
                init: function () {
                    var thisDropzone = this;
                    $.post(adforest_ajax_url, {action: 'get_uploaded_video', is_update: $('#is_update').val()}).done(function (data)
                    {

                        if (typeof data !== 'undefined' && data != 0) {
                            $.each(data, function (key, value) {
                                var mockFile = {
                                    name: value.video_name,
                                    size: value.video_size,
                                };
                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, videoLogoUrl);
                                $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.video_id);
                                i++;
                                $(".dz-progress").remove();
                            });
                        }
                        if (i > 0)
                            $('.dz-message').hide();
                        else
                            $('.dz-message').show();
                    });

                    this.on("addedfile", function (file) {
                        $('.dz-message').hide();

                    });
                    this.on("success", function (file, responseText) {

                        var res_arr = responseText.split("|");
                        if ($.trim(res_arr[0]) != "0")
                        {
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                            i++;
                            $('.dz-message').hide();
                        } else
                        {
                            if (i == 0)
                                $('.dz-message').show();
                            this.removeFile(file);
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    });
                    this.on("removedfile", function (file) {
                        var img_id = file._removeLink.attributes[2].value;
                        if (img_id != "")
                        {
                            i--;
                            if (i == 0)
                                $('.dz-message').show();
                            $.post(adforest_ajax_url, {action: 'delete_upload_video', video: img_id, is_update: $('#is_update').val(), }).done(function (response)
                            {
                                if ($.trim(response) == "1") { /*this.removeFile(file);*/
                                }
                            });
                        }
                    });
                    this.on("maxfilesexceeded", function (file) {
                        toastr.error($('#adforest_max_upload_reach').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        this.removeFile(file);
                    });


                },
            });
        }
    }

    function sbDropzone_image()
    {
        if ($('#dropzone').length) {
            Dropzone.autoDiscover = false;
            var images_ajax_callback = adforest_ajax_url + "?action=upload_ad_images&is_update=" + $('#is_update').val();
            if (adforest_ajax_url.indexOf('?lang=') !== -1) {
                images_ajax_callback = adforest_ajax_url + "&action=upload_ad_images&is_update=" + $('#is_update').val();
            }
            var fileList = new Array;
            var acceptedFileTypes = "image/jpeg,image/png,image/jpg";
            var i = 0;
            var sb_max_files = typeof $('#sb_upload_limit').val() !== 'undefined' && $('#sb_upload_limit').val() == 'null' ? null : $('#sb_upload_limit').val();
            $("#dropzone").dropzone({
                timeout: 5000000,
                maxFilesize: 50000000,
                addRemoveLinks: true,
                paramName: "my_file_upload",
                maxFiles: sb_max_files, //change limit as per your requirements
                acceptedFiles: acceptedFileTypes,
                dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
                url: images_ajax_callback,
                parallelUploads: 1,
                dictDefaultMessage: $('#dictDefaultMessage').val(),
                dictFallbackMessage: $('#dictFallbackMessage').val(),
                dictFallbackText: $('#dictFallbackText').val(),
                dictFileTooBig: $('#dictFileTooBig').val(),
                dictInvalidFileType: $('#dictInvalidFileType').val(),
                dictResponseError: $('#dictResponseError').val(),
                dictCancelUpload: $('#dictCancelUpload').val(),
                dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
                dictRemoveFile: $('#dictRemoveFile').val(),
                dictRemoveFileConfirmation: null,
                init: function () {
                    var thisDropzone = this;
                    $.post(adforest_ajax_url, {action: 'get_uploaded_ad_images', is_update: $('#is_update').val()}).done(function (data)
                    {
                        if (typeof data !== 'undefined' && data != 0) {
                            $.each(data, function (key, value) {
                                var mockFile = {name: value.dispaly_name, size: value.size};
                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                                $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                                i++;
                                $(".dz-progress").remove();
                            });
                        }
                        if (i > 0)
                            $('.dz-message').hide();
                        else
                            $('.dz-message').show();
                    });

                    this.on("addedfile", function (file) {
                        $('.dz-message').hide();

                    });
                    this.on("success", function (file, responseText) {

                        var res_arr = responseText.split("|");
                        if ($.trim(res_arr[0]) != "0")
                        {
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                            i++;
                            $('.dz-message').hide();
                        } else
                        {
                            if (i == 0)
                                $('.dz-message').show();
                            this.removeFile(file);
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    });
                    this.on("removedfile", function (file) {
                        var img_id = file._removeLink.attributes[2].value;
                        if (img_id != "")
                        {
                            i--;
                            if (i == 0)
                                $('.dz-message').show();
                            $.post(adforest_ajax_url, {action: 'delete_ad_image', img: img_id, is_update: $('#is_update').val(), }).done(function (response)
                            {
                                if ($.trim(response) == "1") { /*this.removeFile(file);*/
                                }
                            });
                        }
                    });
                    this.on("maxfilesexceeded", function (file) {
                        toastr.error(sb_options.max_upload_images, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        this.removeFile(file);
                    });


                },
            });
        }
    }

    $('#ad_country').on('change', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country").val(), }).done(function (response)
        {
            $('#sb_loading').hide();
            $("#ad_country_states").val('');
            $("#ad_country_cities").val('');
            $("#ad_country_towns").val('');
            if ($.trim(response) != "")
            {
                $('#ad_country_id').val($("#ad_cat").val());
                $('#ad_country_sub_div').show();
                $('#ad_country_states').html(response);
                $('#ad_country_sub_sub_sub_div').hide();
                $('#ad_country_sub_sub_div').hide();
            } else
            {
                $('#ad_country_sub_div').hide();
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });
    /* Level 2 */
    $('#ad_country_states').on('change', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country_states").val(), }).done(function (response)
        {
            $('#sb_loading').hide();
            $("#ad_country_cities").val('');
            $("#ad_country_towns").val('');
            if ($.trim(response) != "")
            {
                $('#ad_country_id').val($("#ad_country_states").val());
                $('#ad_country_sub_sub_div').show();
                $('#ad_country_cities').html(response);
                $('#ad_country_sub_sub_sub_div').hide();
            } else
            {
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });
    /* Level 3 */
    $('#ad_country_cities').on('change', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_get_sub_states', country_id: $("#ad_country_cities").val(), }).done(function (response)
        {
            $('#sb_loading').hide();
            $("#ad_country_towns").val('');
            if ($.trim(response) != "")
            {
                $('#ad_country_id').val($("#ad_country_cities").val());
                $('#ad_country_sub_sub_sub_div').show();
                $('#ad_country_towns').html(response);
            } else
            {
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });


    $('.btn-condition').on('click', function () {


        $('.btn-condition').removeClass('btn-selected');
        $(this).addClass('btn-selected');
        $('#condition').val(($(this).data('id')));
    });

    $('.btn-type').on('click', function () {
        $('.btn-type').removeClass('btn-selected');
        $(this).addClass('btn-selected');
        $('#type').val(($(this).data('id')));
    });

    $('.btn-warranty').on('click', function () {
        $('.btn-warranty').removeClass('btn-selected');
        $(this).addClass('btn-selected');
        $('#warranty').val(($(this).data('id')));
    });



  sub_cat_req  =   false;
    if($('#is_sub_cat_required').length > 0 && $('#is_sub_cat_required').val() != ""){
        sub_cat_req  =  true;      
    }
   
    $('#ad_cat').on('change', function ()
    {
        if ($("#ad_cat").val())
        {
            $('#sb_loading').show();
            term_label = $(this).find(':selected').data('name');
            if ($('#alert_category').length > 0) {
                $('#alert_category').val($("#ad_cat").val());
            }
            if ($('.sb-selected-cats-header').length > 0 && term_label != "" && term_label != undefined) {
                jQuery('.sb-selected-cats-header').css("display", "block");
                jQuery('.sb-selected-cats-header2').css("display", "block");
                jQuery('.sb-selected-cats').html('');
                jQuery('.sb-selected-cats').append(' <li> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').html('');
                jQuery('.sb-selected-cats2').append(' <li> ' + term_label + ' </li> ');

            }
            $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                if ($.trim(response) == 'cat_error') {
                    $("#ad_cat").val('');
                   // $("#select2-ad_cat-container").html($("#select_place_holder").val());
                    toastr.error((sb_options.cat_pkg_error), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
                } else {
                    $("#ad_cat_sub").val('');
                    $("#ad_cat_sub_sub").val('');
                    $("#ad_cat_sub_sub_sub").val('');
                    if ($.trim(response) != "")
                    {
                        $('#ad_cat_id').val($("#ad_cat").val());
                        $('#ad_cat_sub_div').show();
                        $('#ad_cat_sub').html(response);
                        $('#ad_cat_sub_sub_div').hide();
                        $('#ad_cat_sub_sub_sub_div').hide();
                        if(sub_cat_req  == true){                       
                        $('#ad_cat_sub').attr("data-parsley-required","true");
                        $('#ad_cat_sub_sub').attr("data-parsley-required","false");
                        $('#ad_cat_sub_sub_sub').attr("data-parsley-required","false");
                        $('#ad_cat_sub').attr("data-parsley-error-message",$('#field_required').val());
                        }       
                    } else
                    {
                        $('#ad_cat_sub_div').hide();
                        $('#ad_cat_sub_sub_div').hide();
                        $('#ad_cat_sub_sub_sub_div').hide();
                        
                         if(sub_cat_req  == true){                       
                             $('#ad_cat_sub').attr("data-parsley-required","false");
                             $('#ad_cat_sub_sub').attr("data-parsley-required","false");
                             $('#ad_cat_sub_sub_sub').attr("data-parsley-required","false");
                        } 
                    }
                    getCustomTemplate(adforest_ajax_url, $("#ad_cat").val(), $("#is_update").val());
                    adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat").val(), $("#bid_ad_id").val());
                }
                /*For Category Templates*/
            });
        } else
        {
            $('#ad_cat_sub_div').hide();
            $('#ad_cat_sub_sub_div').hide();
            $('#ad_cat_sub_sub_sub_div').hide();
        }
    });


    /* Level 2 */
    $('#ad_cat_sub').on('change', function ()
    {
        if ($("#ad_cat_sub").val())
        {

            term_label = $(this).find(':selected').data('name');

            if ($('#alert_category').length > 0) {
                $('#alert_category').val($("#ad_cat_sub").val());
            }
            if ($('.sb-selected-cats-header').length > 0 && term_label != "" && term_label != undefined) {
                jQuery('.sb-selected-cats-header').css("display", "block");
                jQuery('.sb-selected-cats-header2').css("display", "block");

                $('.level1_cat').length > 0 ? $('.level1_cat').remove() : "";
                $('.level2_cat').length > 0 ? $('.level2_cat').remove() : "";
                $('.level3_cat').length > 0 ? $('.level3_cat').remove() : "";

                jQuery('.sb-selected-cats').append(' <li class="level1_cat"> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').append(' <li class = "level1_cat"> ' + term_label + ' </li> ');

            }
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                if ($.trim(response) == 'cat_error') {
                    $("#ad_cat_sub").val('');
                    $("#select2-ad_cat_sub-container").html($("#select_place_holder").val());
                    toastr.error((sb_options.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else {
                    $("#ad_cat_sub_sub").val('');
                    $("#ad_cat_sub_sub_sub").val('');
                    if ($.trim(response) != "")
                    {
                        $('#ad_cat_id').val($("#ad_cat_sub").val());
                        $('#ad_cat_sub_sub_div').show();
                        $('#ad_cat_sub_sub').html(response);
                        $('#ad_cat_sub_sub_sub_div').hide();
                                             
                        if(sub_cat_req  == true){                       
                             $('#ad_cat_sub_sub').attr("data-parsley-required","true");
                             $('#ad_cat_sub_sub_sub').attr("data-parsley-required","false");
                                      $('#ad_cat_sub_sub').attr("data-parsley-error-message",$('#field_required').val());
                        } 
         
                        
                    } else
                    {
                        $('#ad_cat_sub_sub_div').hide();
                        $('#ad_cat_sub_sub_sub_div').hide(); 
                        if(sub_cat_req  == true){                       
                             $('#ad_cat_sub_sub').attr("data-parsley-required","false");
                             $('#ad_cat_sub_sub_sub').attr("data-parsley-required","false");
                        } 
                    }
                    getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub").val(), $("#is_update").val());
                    adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub").val(), $("#bid_ad_id").val());
                }
            });
        } else
        {
            $('#ad_cat_sub_sub_div').hide();
            $('#ad_cat_sub_sub_sub_div').hide();
        }
    });
    /* Level 3 */
    $('#ad_cat_sub_sub').on('change', function ()
    {
        if ($("#ad_cat_sub_sub").val())
        {


            if ($('#alert_category').length > 0) {
                $('#alert_category').val($("#ad_cat_sub_sub").val());
            }

            term_label = $(this).find(':selected').data('name');
            if ($('.sb-selected-cats-header').length > 0 && term_label != "" && term_label != undefined) {
                jQuery('.sb-selected-cats-header').css("display", "block");
                jQuery('.sb-selected-cats-header2').css("display", "block");

                $('.level2_cat').length > 0 ? $('.level2_cat').remove() : "";
                $('.level3_cat').length > 0 ? $('.level3_cat').remove() : "";
                jQuery('.sb-selected-cats').append(' <li class="level2_cat"> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').append(' <li class="level2_cat"> ' + term_label + ' </li> ');

            }
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub_sub").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                if ($.trim(response) == 'cat_error') {
                    $("#ad_cat_sub_sub").val('');
                    $("#select2-ad_cat_sub_sub-container").html($("#select_place_holder").val());
                    toastr.error((sb_options.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                } else {
                    $("#ad_cat_sub_sub_sub").val('');
                    if ($.trim(response) != "")
                    {
                        $('#ad_cat_id').val($("#ad_cat_sub_sub").val());
                        $('#ad_cat_sub_sub_sub_div').show();
                        $('#ad_cat_sub_sub_sub').html(response);
                        
                         if(sub_cat_req  == true){                       
                             $('#ad_cat_sub_sub_sub').attr("data-parsley-required","true");
                              $('#ad_cat_sub_sub_sub').attr("data-parsley-error-message",$('#field_required').val());
                        } 
                    } else
                    {
                       $('#ad_cat_sub_sub_sub').attr("data-parsley-required","false");
                    }
                    getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub_sub").val(), $("#is_update").val());
                    adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub_sub").val(), $("#bid_ad_id").val());
                }
            });
        } else
        {
            $('#ad_cat_sub_sub_sub_div').hide();
        }
    });
    /* Level 4 */
    $('#ad_cat_sub_sub_sub').on('change', function ()
    {
        $('#sb_loading').show();


        if ($('#alert_category').length > 0) {
            $('#alert_category').val($("#ad_cat_sub_sub_sub").val());
        }
        $.post(adforest_ajax_url, {action: 'sb_get_sub_cat', cat_id: $("#ad_cat_sub_sub_sub").val(), }).done(function (response)
        {
            term_label = $(this).find(':selected').data('name');
            if ($('.sb-selected-cats-header').length > 0 && term_label != "" && term_label != undefined) {
                jQuery('.sb-selected-cats-header').css("display", "block");
                jQuery('.sb-selected-cats-header2').css("display", "block");
                $('.level3_cat').length > 0 ? $('.level3_cat').remove() : "";
                jQuery('.sb-selected-cats').append(' <li class="level3_cat"> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').append(' <li class="level3_cat"> ' + term_label + ' </li> ');
            }
            $('#sb_loading').hide();
            if ($.trim(response) == 'cat_error') {
                $("#ad_cat_sub_sub_sub").val('');
                $("#select2-ad_cat_sub_sub_sub-container").html($("#select_place_holder").val());
                toastr.error((sb_options.cat_pkg_error), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else {
                getCustomTemplate(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val(), $("#is_update").val());
                adforest_make_bidding_catbase(adforest_ajax_url, $("#ad_cat_sub_sub_sub").val(), $("#bid_ad_id").val());
            }
        });
    });

    $('form.custom-search-form select').on("select2:select", function (e) {
        $('#sb_loading').show();
        $(this).closest("form").submit();
    });


    function getCustomTemplate(ajax_url, catId, updateId)
    {
        /*For Category Templates*/
        $('#sb_loading').hide();
        $.post(ajax_url, {action: 'sb_get_sub_template', 'cat_id': catId, 'is_update': updateId, }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) != "")
            {
                $("#dynamic-fields").html(response);
                $('#dynamic-fields select').select2({placeholder: sb_options.select_place_holder, allowClear: true, width: '100%'});
                sbDropzone_image();
                adforest_inputTags();
                sbDropzone_video();
                $('.skin-minimal .list li input').iCheck({checkboxClass: 'icheckbox_minimal', radioClass: 'iradio_minimal', increaseArea: '20%'});
            }
            if ($('#theme_type').val() == 1 && updateId == "") {
            }
        });
        /*For Category Templates*/
    }
    function adforest_make_bidding_catbase(ajax_url, catId, bid_ad_id) {
        /*For Category Templates*/
        $('#sb_loading').hide();
        bid_ad_id = typeof bid_ad_id !== 'undefined' && bid_ad_id != '' ? bid_ad_id : '';
        $.post(ajax_url, {action: 'sb_display_bidding_section', 'cat_id': catId, 'bid_ad_id': bid_ad_id}).done(function (response)
        {
            $('#sb_loading').hide();
            if (response == '1') {
                $('.bidding-content').show();
            } else {
                $('.bidding-content').hide();
            }
        });
        /*For Category Templates*/
    }

    $(document).on('change', '#ad_price_type', function ()
    {
        if (this.value == "on_call" || this.value == "free" || this.value == "no_price")
        {
            $('#ad_price').attr("data-parsley-required", "false");
            $('#ad_currency').attr("data-parsley-required", "false");
            $('#ad_price').val('');
            $('#ad_price').parent('div').hide();
            $('#ad_currency').parent('div').hide();
        } else
        {
            $('#ad_price').attr("data-parsley-required", "true");
            $('#ad_currency').attr("data-parsley-required", "true");
            $('#ad_price').parent('div').show();
            $('#ad_currency').parent('div').show();
        }
    });

    if ($('#is_sub_active').val() == "1") { /* Tags*/
        adforest_inputTags();
    }



    if ($('.dynamic-form-date-fields').length > 0) {
        jQuery('.dynamic-form-date-fields').datepicker({
            timepicker: false,
            dateFormat: 'yyyy-mm-dd',
            language: {
                days: [sb_options.Sunday, sb_options.Monday, sb_options.Tuesday, sb_options.Wednesday, sb_options.Thursday, sb_options.Friday, sb_options.Saturday],
                daysShort: [sb_options.Sun, sb_options.Mon, sb_options.Tue, sb_options.Wed, sb_options.Thu, sb_options.Fri, sb_options.Sat],
                daysMin: [sb_options.Su, sb_options.Mo, sb_options.Tu, sb_options.We, sb_options.Th, sb_options.Fr, sb_options.Sa],
                months: [sb_options.January, sb_options.February, sb_options.March, sb_options.April, sb_options.May, sb_options.June, sb_options.July, sb_options.August, sb_options.September, sb_options.October, sb_options.November, sb_options.December],
                monthsShort: [sb_options.Jan, sb_options.Feb, sb_options.Mar, sb_options.Apr, sb_options.May, sb_options.Jun, sb_options.Jul, sb_options.Aug, sb_options.Sep, sb_options.Oct, sb_options.Nov, sb_options.Dec],
                today: sb_options.Today,
                clear: sb_options.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
        });
    }

    function adforest_inputTags()
    {
        var total_tags = $("#tags_count").val();
        if (typeof total_tags === 'undefined' || total_tags == '') {
            total_tags = 0;
        }
        if ($('#tags').length !== 'undefined' && $('#tags').length > 0) {
            $('#tags').tagsInput({
                'width': '100%',
                'height': '5px;',
                'defaultText': '',
                onAddTag: function (elem, elem_tags) {
                    total_tags = parseInt(total_tags) + 1;
                    if (total_tags > sb_options.adforest_tags_limit_val) {
                        alert(sb_options.adforest_tags_limit);
                        $(this).removeTag(elem);
                    }
                    if ($.sanitize(elem) == '') {
                        $(this).removeTag(elem);
                    }
                },
                onRemoveTag: function () {
                    total_tags = parseInt(total_tags) - 1;
                }
            });
        }
        if ($("#is_update").val() == "" && $('.dynamic-form-date-fields').length > 0) {
            if ($('.dynamic-form-date-fields').length > 0) {
                $('.dynamic-form-date-fields').datepicker({
                    timepicker: false,
                    dateFormat: 'yyyy-mm-dd',
                    language: {
                        days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
                        daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
                        daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
                        months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
                        monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
                        today: get_strings.Today,
                        clear: get_strings.Clear,
                        dateFormat: 'mm/dd/yyyy',
                    },
                });
            }
        }

    }
    $('#ad_bidding').on('change', function ()
    {
        if ($('#ad_bidding').val() == "1") {
            $('.biddind_div').show();
        } else {
            $('.biddind_div').hide();
        }
    });
    $('#ad_bidding_date').datepicker({
        timepicker: true,
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        language: {
            days: [sb_options.Sunday, sb_options.Monday, sb_options.Tuesday, sb_options.Wednesday, sb_options.Thursday, sb_options.Friday, sb_options.Saturday],
            daysShort: [sb_options.Sun, sb_options.Mon, sb_options.Tue, sb_options.Wed, sb_options.Thu, sb_options.Fri, sb_options.Sat],
            daysMin: [sb_options.Su, sb_options.Mo, sb_options.Tu, sb_options.We, sb_options.Th, sb_options.Fr, sb_options.Sa],
            months: [sb_options.January, sb_options.February, sb_options.March, sb_options.April, sb_options.May, sb_options.June, sb_options.July, sb_options.August, sb_options.September, sb_options.October, sb_options.November, sb_options.December],
            monthsShort: [sb_options.Jan, sb_options.Feb, sb_options.Mar, sb_options.Apr, sb_options.May, sb_options.Jun, sb_options.Jul, sb_options.Aug, sb_options.Sep, sb_options.Oct, sb_options.Nov, sb_options.Dec],
            today: sb_options.Today,
            clear: sb_options.Clear,
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
        minDate: new Date()
    });
    (function ($) {
        $.sanitize = function (input) {
            var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').replace(/<[\/\!]*?[^<>]*?>/gi, '').replace(/<style[^>]*?>.*?<\/style>/gi, '').replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
            return output;
        };
    })(jQuery);
    if ($('.posts-masonry').length > 0) {
        $('.posts-masonry').imagesLoaded(function () {
            $('.posts-masonry').isotope({layoutMode: 'masonry', transitionDuration: '0.3s', });
        });
    }
    if ($('.sb_rating_input').length > 0)
    {
        var star_rtl = false;
        if ($('#is_rtl').val() != "" && $('#is_rtl').val() == "1") {
            star_rtl = true;
        }
        $('.user_ratting_input  .fa-star').on('click', function (event) {
            setTimeout(function () {
                $('#user_search_rating').submit();
            },
                    1000);
            jQuery('#sb_loading').show();
        });
    }
    function adforest_validateEmail(sEmail)
    {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }
    if ($('.listing-list-salesman').length > 0) {
        $('.dt-detaial-page').remove();
    }

    if (sb_options.msg_notification_on != "" && sb_options.msg_notification_on != 0 && sb_options.msg_notification_time != "")
    {
        if (sb_options.is_logged_in == '1')
        {
            setInterval(function ()
            {
                $.post(adforest_ajax_url, {action: 'sb_check_messages', new_msgs: $('#is_unread_msgs').val(), }).done(function (response)
                {

                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});

                    }
                });
            }, sb_options.msg_notification_time);
        }
    }
    /*Report Ad*/
    $('#sb_mark_it').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_report_ad', option: $('#report_option').val(), comments: $('#report_comments').val(), ad_id: $('#ad_id').val(), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                $('.report-quote').modal('hide');
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    /* Emoji Reaction Against Reviews  */
    $(".Emoji").on("click", function ()
    {
        var reaction_id = $(this).data("reaction");
        var c_id = $(this).data("cid");
        $("#reaction-loader-" + c_id).show();
        $.post(adforest_ajax_url, {action: 'adforest_ads_rating_reaction', r_id: reaction_id, c_id: c_id}).done(function (response)
        {
            $("#reaction-loader-" + c_id).hide();

            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '0')
            {
                alert($.trim(get_r[1]));
                return false;
            } else
            {
                if (reaction_id === 1) {
                    $('.emoji-count.likes-' + c_id).text(response);
                }
                if (reaction_id === 2)
                {
                    $('.emoji-count.loves-' + c_id).text(response)
                }
                if (reaction_id === 3) {
                    $('.emoji-count.wows-' + c_id).text(response);
                }
                if (reaction_id === 4) {
                    $('.emoji-count.angrys-' + c_id).text(response);
                }
            }
        });
        return false;
    });
    /* Back To Top */
    $(window).scroll(function () {
        var offset = 300,
                offset_opacity = 1200,
                scroll_top_duration = 700,
                $back_to_top = $('.cd-top');
        var ad_post_btn = $('.sticky-post-button');
        ($(this).scrollTop() > offset) ? ad_post_btn.addClass('sticky-post-button-visible') : ad_post_btn.removeClass('sticky-post-button-visible').removeClass('sticky-post-button-fadeout');
        ($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('cd-fade-out');
            ad_post_btn.addClass('sticky-post-button-fadeout');
        }
    });
    $back_to_top = $('.cd-top');
    $(document).on('click', '.cd-top', function (event) {
        event.preventDefault();
        $('body,html').animate({scrollTop: 0, }, 700);

    });
    /* Counter FunFacts */
    var timer = $('.timer');
    if (timer.length) {
        timer.appear(function () {
            timer.countTo();
        });
    }
    $('.top-loc-selection').on('click', function () {
        var loc_id = $(this).attr("data-loc-id");
        $('#sb_loading').show();
        jQuery.post(adforest_ajax_url, {action: 'sb_set_site_location', location_id: loc_id}).done(function (response)
        {
            $('#sb_loading').hide();
            if (typeof response !== undefined && response == 1) {
                window.location.reload();
            } else {
                alert(get_strings.adforest_location_error);
            }
        });
        return false;
    });

    if ($(".cat-hero-slider").length > 0) {
        $(".cat-hero-slider").slick({
            slidesToShow: 9,
            slidesToScroll: 1,
            autoplay: true,
            autoplayTimeout: 5000,
            rtl: is_rtl,
            arrows: true,
            dots: false,
            margin: 10,
            autoplaySpeed: autoplay,
            pauseOnHover: false,
            prevArrow: '<i class="slick-prev fa fa-angle-left"></i>',
            nextArrow: '<i class="slick-next fa fa-angle-right"></i>',
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 2
                    }
                }]
        });
    }
    var dd_bottoms = $('.sb-top-loc');
    if ($('.sb-top-loc').length > 0) {
        const pss = new PerfectScrollbar(".sb-top-loc");
    }
    if ($(".map-sidebar").length > 0) {
        // $(".map-sidebar").niceScroll();
    }

    function adforest_save_adpost_cat_val(term_id, term_level) {
        if (term_level == '1') {
            jQuery('#ad_cat').val(term_id);
            jQuery('#ad_cat_sub').val('');
            jQuery('#ad_cat_sub_sub').val('');
            jQuery('#ad_cat_sub_sub_sub').val('');
        } else if (term_level == '2') {
            jQuery('#ad_cat_sub').val(term_id);
        } else if (term_level == '3') {
            jQuery('#ad_cat_sub_sub').val(term_id);
        } else if (term_level == '4') {
            jQuery('#ad_cat_sub_sub_sub').val(term_id);
        }
    }
    jQuery(document).on('click', '.sb-adpost-cats ul li a', function ()
    {
        var cat_s_id = jQuery(this).attr('data-cat-id');
        var term_level = jQuery(this).attr('data-term-level');
        jQuery('.sb-selected-cats').html('');
        adforest_save_adpost_cat_val(cat_s_id, term_level);
        jQuery(".sb-cat-box").removeClass("sb-cat-active");
        jQuery(this).parent().addClass("sb-cat-active");

        var term_label = jQuery(this).attr('data-term-name');
        if (cat_s_id != "")
        {
            jQuery('#cat_id').val(cat_s_id);
            jQuery('#sb_loading').show();
            jQuery('#cats_response').html('');
            jQuery.post(jQuery('#adforest_ajax_url').val(), {action: 'sb_get_sub_cat_search', cat_id: cat_s_id, type: 'ad_post'}).done(function (response)
            {
                jQuery('#sb_loading').hide();
                jQuery('.sb-selected-cats-header').css("display", "block");
                jQuery('.sb-selected-cats-header2').css("display", "block");
                jQuery('.sb-selected-cats').append(' <li> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').html('');
                jQuery('.sb-selected-cats2').append(' <li> ' + term_label + ' </li> ');
                getCustomTemplate(jQuery('#adforest_ajax_url').val(), $("#ad_cat").val(), $("#is_update").val());
                adforest_make_bidding_catbase(jQuery('#adforest_ajax_url').val(), $("#ad_cat").val(), $("#bid_ad_id").val());
                if (jQuery.trim(response) == 'submit')
                {


                } else
                {
                    jQuery('#cat_modal').modal('show');
                    jQuery('#cats_response').html(response);
                }
            });
        }
    });

    if ($('#ad_post_form').length > 0) {
        jQuery(document).on('click', '#ajax_cat', function ()
        {
            jQuery('#sb_loading').show();
            var cat_s_id = jQuery(this).attr('data-cat-id');
            var term_level = jQuery(this).attr('data-term-level');
            adforest_save_adpost_cat_val(cat_s_id, term_level);
            var cat_slc_val = $("#ad_cat").val();
            if (term_level == '1') {
                cat_slc_val = jQuery('#ad_cat').val();
            } else if (term_level == '2') {
                cat_slc_val = jQuery('#ad_cat_sub').val();
            } else if (term_level == '3') {
                cat_slc_val = jQuery('#ad_cat_sub_sub').val();
            } else if (term_level == '4') {
                cat_slc_val = jQuery('#ad_cat_sub_sub_sub').val();
            }
            var term_label = jQuery(this).html();
            jQuery('#cat_id').val(cat_s_id);
            jQuery.post(jQuery('#adforest_ajax_url').val(), {action: 'sb_get_sub_cat_search', cat_id: cat_s_id, type: 'ad_post'}).done(function (response)
            {

                jQuery('.sb-selected-cats').append(' <li> ' + term_label + ' </li> ');
                jQuery('.sb-selected-cats2').append(' <li> ' + term_label + ' </li> ');

                getCustomTemplate(jQuery('#adforest_ajax_url').val(), cat_slc_val, $("#is_update").val());
                adforest_make_bidding_catbase(jQuery('#adforest_ajax_url').val(), $("#ad_cat").val(), $("#bid_ad_id").val());

                if (jQuery.trim(response) == 'submit')
                {
                    jQuery('#cat_modal').modal('toggle');
                } else
                {

                    jQuery('#cats_response').html(response);
                    jQuery('#cat_modal').modal('show');
                    jQuery('#sb_loading').hide();
                }
            });
        });
    }

    $('.no-display-custom').hide();
    $('.sw-btn-next').on('click', function () {
        
             console.log($('#ad_cat_sub').val());
        if ($('#ad_cat').length > 0 && $('#ad_cat').val() == "") {
            
            console.log("sss");
            toastr.error($('#select_cat_first').val(), '', {
                timeOut: 4000,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });
        } else if(sub_cat_req && $('#ad_cat_sub').val() == "" && $('#ad_cat_sub').attr('data-parsley-required') == "true" ){        
             toastr.error($('#select_cat_first').val(), '', {
                timeOut: 4000,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });            
        }
        else if(sub_cat_req && $('#ad_cat_sub_sub').val() == "" && $('#ad_cat_sub_sub').attr('data-parsley-required') == "true" ){        
             toastr.error($('#select_cat_first').val(), '', {
                timeOut: 4000,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });            
        }
        else if(sub_cat_req && $('#ad_cat_sub_sub_sub').val() == "" && $('#ad_cat_sub_sub_sub').attr('data-parsley-required') == "true" ){        
             toastr.error($('#select_cat_first').val(), '', {
                timeOut: 4000,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });            
        }
        else {
            $('.step-0').hide();
            $('.step-1').show();
        }
    });

    $('#change-cat').on('click', function () {
        $('.step-0').show();
        $('.step-1').hide();

    });


    $('.search-cat-submit').on('click', function (e)
    {

        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'search_cat_grid', title: $('.search-cat-input').val()}).done(function (response) {
            if (response != "") {


                $('#sb_loading').hide();
                $('.category-grid-ist').html(response);
            }

        });
    });

    $('.search-cat-input').on('input', function (e)
    {


        if (e.target.value == "") {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'search_cat_grid', title: e.target.value}).done(function (response) {
                if (response != "") {

                    $('#sb_loading').hide();

                    $('.category-grid-ist').html(response);
                }

            });
        }
    });

    if ($("#ad_price_type").length > 0) {
        $("#ad_price_type").trigger("change");
    }




    if ($('.send-message-to-author').length > 0)
    {
        $('.send-message-to-author').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        }).on('form:submit', function () {
            $('#sb_loading').show();
            var google_recaptcha_type = get_strings.google_recaptcha_type;
            google_recaptcha_type = typeof google_recaptcha_type !== 'undefined' ? google_recaptcha_type : 'v2';
            var google_recaptcha_site_key = get_strings.google_recaptcha_site_key;



            if (google_recaptcha_type == 'v3' && google_recaptcha_site_key !== 'undefined' && google_recaptcha_site_key != '') {
                grecaptcha.ready(function () {
                    try {
                        var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                        grecaptcha.execute(google_recaptcha_site_key, {action: "contact_form"}).then(function (token) {
                            jQuery("#user_contact_form").prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                            jQuery.post(adforest_ajax_url, {
                                action: "sb_goggle_captcha3_verification",
                                token: token,
                            }, function (result) {
                                result = JSON.parse(result);
                                if (result.success) {
                                    $.post(adforest_ajax_url, {action: 'sb_send_message_to_author', ad_id: $('#ad_id').val(), sb_data: $("form.send-message-to-author").serialize(), }).done(function (response)
                                    {
                                        $('#sb_loading').hide();
                                        var res_arr = response.split("|");
                                        if ($.trim(res_arr[0]) != "0")
                                        {
                                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        } else
                                        {
                                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                        }
                                    });
                                } else {
                                    $('#sb_loading').hide();
                                    $('#sb_register_submit').show();
                                    toastr.error(result.msg, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        });
                    } catch (err) {
                        var google_recaptcha_error_text = jQuery("#google_recaptcha_error_text").val();
                        google_recaptcha_error_text = typeof google_recaptcha_error_text !== 'undefined' ? google_recaptcha_error_text : err;
                        jQuery('#sb_loading').hide();
                        toastr.error(google_recaptcha_error_text, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
            } else {
                $.post(adforest_ajax_url, {action: 'sb_send_message_to_author', ad_id: $('#ad_id').val(), sb_data: $("form.send-message-to-author").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    var res_arr = response.split("|");
                    if ($.trim(res_arr[0]) != "0")
                    {
                        toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    } else
                    {
                        toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                });
            }
            return false;
        });
    }


    $('.ads-with-sidebar-section a.ajax-anchor').on('click', function ()
    {
        var cat_id = $(this).data('sidebar-term-id');
        var unique_id = $(this).data('unique-id');
        $(".ads-sidebar-loader").show();
        $('#sb_loading').show();
        var no_of_ads = $("#no_of_ads_" + unique_id).val();
        var layout_type = $("#layout_type_" + unique_id).val();
        var ad_order = $("#ad_order_" + unique_id).val();
        var ad_type = $("#ad_type_" + unique_id).val();
        var cat_link_page = $("#cat_link_page_" + unique_id).val();
        var wpnonce = $("#ads_with_sidebar_ajax_" + unique_id).val();
        var view_all = $("#view_all_" + unique_id).val();
        $("#ads-with-sidebar-section-" + unique_id).html('');
        $.post(adforest_ajax_url, {action: 'get_ads_with_sidebar_section', cat_id: cat_id, unique_id: unique_id, no_of_ads: no_of_ads, layout_type: layout_type, ad_order: ad_order, ad_type: ad_type, cat_link_page: cat_link_page, view_all: view_all, wpnonce: wpnonce}).done(function (response)
        {
            $("#ads-with-sidebar-section-" + unique_id).html(response);
            adforest_timerCounter_function();
            $(".ads-sidebar-loader").hide();
            $('#sb_loading').hide();
        });
    });
    if (jQuery('.dec-latest-products-s').length > 0) {
        jQuery('.dec-latest-products-s').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            rtl: is_rtl,
            smartSpeed: 550,
            autoplay: false,
            //dots: false,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {0: {items: 1, }, 600: {items: 4, }, 768: {items: 6, }, 1000: {items: 6, }}
        });
    }

    if (jQuery('.dec-location').length > 0) {
        jQuery('.dec-location').owlCarousel({
            loop: true,
            margin: 15,
            dots: false,
            rtl: is_rtl,
            autoplay: true,
            responsiveClass: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            responsive: {0: {items: 1, }, 600: {items: 3, }, 1000: {items: 3, }
            }
        });
    }


    $('.success-stories-2').owlCarousel({
        loop: true,
        margin: 10,
        navText: navTextAngle,
        nav: true,
        dots: false,
        rtl: is_rtl,
        smartSpeed: 600,
        autoplay: true,
        responsive: {0: {items: 1}, 600: {items: 3, }, 1000: {items: 1, }}
    });

    /* slider js for adforest app homepage */
    if (jQuery('.mobile-hero').length > 0) {
        jQuery('.mobile-hero').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            center: true,
            rtl: is_rtl,
            smartSpeed: 750,
            autoplay: false,
            responsive: {0: {items: 1}, 768: {items: 1, stagePadding: 200, }}
        });
    }

    if (jQuery('.toys-new-accessories').length > 0) {
        jQuery('.toys-new-accessories').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            rtl: is_rtl,
            smartSpeed: 550,
            autoplay: true,
            dots: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {0: {items: 1, }, 600: {items: 2, }, 768: {items: 1, }, 1000: {items: 1, }}
        });
    }



     var dd_bottoms = $('#scrolable-ads-real');
    if ($('.scrolable-ads').length > 0) {        
        $('.scrolable-ads').each(function(){ const ps = new PerfectScrollbar($(this)[0]); });
     } 
    


    $('.app-shots-carousal').owlCarousel({
        autoplayHoverPause: true,
        rtl: is_rtl,
        loop: true,
        margin: 20,
        dots: false,
        autoplay: false,
        responsiveClass: true,
        navText: navTextAngle,
        nav: true,
        center: true,
        responsive: {0: {items: 1, }, 600: {items: 3, }, 1000: {items: 5, }}
    });

    $('.land-one-slider-2').owlCarousel({
        rtl: is_rtl,
        loop: true,
        margin: 10,
        autoplay: true,
        smartSpeed: 700,
        nav: false,
        dots: true,
        responsive: {0: {items: 1}, 600: {items: 3}, 1000: {items: 1}}
    });

    /* Category Carousel */
    $('.category-slider').owlCarousel({
        loop: true,
        rtl: is_rtl,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        margin: 0,
        responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
        navText: ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"],
        responsive: {
            0: {items: 1, nav: false},
            600: {items: 2, nav: false},
            1000: {items: 4, nav: false, loop: true}
        }
    });

    /* Background Image Rotator Carousel */
    $('.background-rotator-slider').owlCarousel({
        loop: false,
        rtl: is_rtl,
        dots: false,
        margin: 0,
        autoplay: true,
        autoplayHoverPause: true,
        mouseDrag: true,
        touchDrag: true,
        responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
        nav: false,
        responsive: {
            0: {items: 1, },
            600: {items: 1, },
            1000: {items: 1, }
        }
    });



    if ($('.play-video-new').length > 0) {
        $("a.play-video-new").YouTubePopUp();
    }



    $(document).on('click', '#sb_feature_ad', function ()
    {
        adID = $(this).attr('aaa_id');
        confirm_btn = $(this).attr('data-btn-ok-label');
        cancel_btn = $(this).attr('data-btn-cancel-label');
        title = $(this).attr('data-title');

        $.confirm({
            title: title,
            content: '',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                        $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'sb_make_featured', ad_id: adID, }).done(function (response)
                        {
                            $('#sb_loading').hide();
                            var get_r = response.split('|');
                            if ($.trim(get_r[0]) == '1')
                            {
                                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            } else
                            {
                                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                        });
                    }, },
                cancel: {
                    text: cancel_btn,
                    function() {
                    },
                }}
        });
    });


    $(".sb_show_pass").on('click', function (event) {
        event.preventDefault();

        var passwordField = $("input[name='sb_reg_password']");
        var iconField = $('.sb_show_pass i');
        if (passwordField.attr("type") == "text") {

            passwordField.attr('type', 'password');
            iconField.addClass("fa-eye");
            iconField.removeClass("fa-eye-slash");

        } else if (passwordField.attr("type") == "password") {

            passwordField.attr('type', 'text');
            iconField.removeClass("fa-eye");
            iconField.addClass("fa-eye-slash");

        }
    });



    $(".sb_show_pass2").on('click', function (event) {
        event.preventDefault();

        var passwordField = $("input[name='sb_reg_password_confirm']");
        var iconField = $('.sb_show_pass2 i');
        if (passwordField.attr("type") == "text") {

            passwordField.attr('type', 'password');
            iconField.addClass("fa-eye");
            iconField.removeClass("fa-eye-slash");

        } else if (passwordField.attr("type") == "password") {

            passwordField.attr('type', 'text');
            iconField.removeClass("fa-eye");
            iconField.addClass("fa-eye-slash");

        }
    });

    $(".ad_alerts").click(function () {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {
            action: 'job_alert_subscription_check',
        }).done(function (response) {
            $('#sb_loading').hide();
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0") {
                $('#ad_cat_sub_div').hide();
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_cat_sub_sub_sub_div').hide();
                $("select").select2({placeholder: sb_options.select_place_holder, allowClear: true, width: '100%'});

                $('#sb_loading').show();
                $("#ad-alert-subscribtion").modal('show');
                $('#sb_loading').hide();
            } else {
                toastr.error(res_arr[1], '', {
                    timeOut: 4000,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        });
    });



    $(document).on('click', '#submit_alert', function () {
        $('#alert_job_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    // Ajax Submitting Resume
                    $.post(adforest_ajax_url, {
                        action: 'job_alert_subscription',
                        submit_alert_data: $("form#alert_job_form").serialize(),
                    }).done(function (response) {
                        $('#sb_loading').hide();
                        var res_arr = response.split("|");

                        if ($.trim(res_arr[0]) != "0") {
                            toastr.success(res_arr[1], '', {
                                timeOut: 4000,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $("#ad-alert-subscribtion").modal('hide');

                        } else {
                            toastr.error(res_arr[1], '', {
                                timeOut: 4000,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });


    jQuery(document).ready(function ($) {
        /* Reset Password*/
        if ($('#sb-reset-password-form').length > 0)
        {
            $('#sb_reset_password_modal').modal('show');
            $('#sb_reset_password_msg').hide();
            $('#sb-reset-password-form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
            }).on('form:submit', function () {
                if ($('#sb_new_password').val() != $('#sb_confirm_new_password').val())
                {
                    toastr.error($('#adforest_password_mismatch_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    return false;
                }
                $('#sb_reset_password_submit').hide();
                $('#sb_reset_password_msg').show();
                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'sb_reset_password', security: $('#sb-reset-pass-token').val(), sb_data: $("form#sb-reset-password-form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    $('#sb_reset_password_msg').hide();

                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        $('#sb_reset_password_modal').modal('hide');
                        $('#sb_reset_password_submit').show();
                        window.location = $('#login_page').val();
                    } else
                    {
                        $('#sb_reset_password_submit').show();
                        toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                }).fail(function () {
                    $('#sb_loading').hide();
                    $('#sb_reset_password_msg').hide();
                    $('#sb_reset_password_submit').show();
                    toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                });
                return false;
            });
        }
    });


    if ($('.claim_ad').length > 0) {
        $('.claim_ad').on('click', function () {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'check_user_claim'}).done(function (response)
            {
                $('#sb_loading').hide();
                $('#sb_reset_password_msg').hide();
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == '1')
                {
                    //  toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    $('.claim-ad-model').modal('show');

                } else
                {
                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }).fail(function () {
                $('#sb_loading').hide();
                toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            });
        });
    }



    if ($('#claim-form').length > 0) {
        if ($('#claim-form').length > 0)
        {
            $('#claim-form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
            }).on('form:submit', function () {

                $('#sb_loading').show();
                $.post(adforest_ajax_url, {action: 'for_claim_listing', collect_data: $("form#claim-form").serialize(), }).done(function (response)
                {
                    $('#sb_loading').hide();
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        $('.claim-ad-model').modal('hide');
                    } else
                    {
                        $('#sb_reset_password_submit').show();
                        toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    }
                }).fail(function () {
                    $('#sb_loading').hide();
                    toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                });
                return false;
            });
        }
    }

    $(document).on('click', '#map-hide-search', function () {
        if ($(this).prop('checked')) {
            $(this).closest("form").submit();
        } else {
            $(this).closest("form").submit();

        }
    });
    $(document).on('click', '#filter-hide-search', function () {
        if ($(this).prop('checked')) {
            $(this).closest("form").submit();
        } else {
            $(this).closest("form").submit();
        }
    });  
    if ($('.no-filters').length > 0) {
        $('.map-sidebar').hide();
    }
    if ($('.no-filters').length > 0) {
        $('.col-lg-4').addClass('col-lg-6').removeClass('col-lg-4');
    }


    $('#show_more').on('click',function(){

    
      $('#cat-half-text').hide();
      $('#cat-full-text').show();
     

    });

    $('#show_less').on('click',function(){
       $('#cat-half-text').show();
      $('#cat-full-text').hide();

    }); 


/*destroy select2 of vendor page*/
    if ($('.mvx-filter-dtdd').length > 0) {
        $('.mvx-filter-dtdd,.bulk-actions').select2('destroy');
    }

          if ($('.country_to_state').length > 0) {
            $('.country_to_state, .state_select, #timezone_string').select2('destroy');
        }

           if ($('#mvx_vendor_stats_report_filter').length > 0) {
            $('#mvx_vendor_stats_report_filter').select2('destroy');
        }   
         if ($('#mvx_visitor_stats_date_filter').length > 0) {
            $('#mvx_visitor_stats_date_filter').select2('destroy');
        }        

        if($('#radiusSelect').length > 0){
             $('#radiusSelect').select2('destroy');
        }

        if($('#distanceSelect').length > 0){
             $('#distanceSelect').select2('destroy');
        }

         $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });

    /* ============================
     * Feature ad Pad adforest
     ==============================*/
if ($('#feature_ad_form').length > 0) {
    $('#feature_ad_form').on('submit',function(e) {
        event.preventDefault();
        var package = $('input[name="package"]:checked').val();
        var pid = $("#pid").val();
       
        $('#sb_loading').show();
        $.post(adforest_ajax_url ,{action: 'feature_ad_posting', package_id : package, pid : pid,}).done(function (response)
        {

            if ( true === response.success)
            {
                  $('#sb_loading').show();
                toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
                if(response.data.url)
                {
                    location.replace(response.data.url);
                }
                else
                {

                    setTimeout(function(){
                      location.reload(true);
                        $('#sb_loading').show();
                    },600);
                }
                 
            }
            else
            {
                $('.loader-outer').hide();
                toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
            }

        })
  
    });
}

    /* ============================
     * Bump up ad Pade adforest
     ==============================*/
if ($('#bumup_ad_form').length > 0) {
    $('#bumup_ad_form').on('submit',function(e) {
        event.preventDefault();
        var package = $('input[name="package"]:checked').val();
        var pid = $("#pid").val();
       
        $('#sb_loading').show();
        $.post(adforest_ajax_url ,{action: 'bumup_ad_posting', package_id : package, pid : pid,}).done(function (response)
        {
            //console.log(response);

            if ( true === response.success)
            {
                  $('#sb_loading').show();
                toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
                if(response.data.url)
                {
                    location.replace(response.data.url);
                }
                else
                {

                    setTimeout(function(){
                      location.reload(true);
                        $('#sb_loading').show();
                    },600);
                }
                 
            }
            else
            {
                $('.loader-outer').hide();
                toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
            }

        })
  
    });
}

   /* ============================
    * Delete User rating adforest
    ==============================*/
     $('.user_rating_dlt').on('click', function () {
    
        var confirmed =  confirm($(this).attr('data-confirmation'));
        $('#sb_loading').show();
        if (confirmed) {
        $.post(ajax_url, {
            action: 'sb_delete_user_rating_frontend',
            user_id: $(this).attr('data-userid'), 
        }).done(function (response) {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == 1) {
                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location.reload();
            } else if ($.trim(get_p[0]) == 0) {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    }
    });


    /* ============================
     * Delete ADS Rating adforest
     ==============================*/
    $('.ads_rating_dlt').on('click', function () {
    
        var confirmed = get_strings.confirm;
         var this_elem  = $(this);
        $('#sb_loading').show();
        if (confirmed) {
        $.post(ajax_url, {
            action: 'ads_rating_delete',
            comment_id: $(this).attr('data-comment_id'), 
             ad_id: $(this).attr('data-ad_id'), 
        }).done(function (response) {
            $('#sb_loading').hide();
            var get_p = response.split('|');
            if ($.trim(get_p[0]) == 1) {
                toastr.success(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
               
                 this_elem.parents('.review-content').remove();
            } else if ($.trim(get_p[0]) == 0) {
                toastr.error(get_p[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    }
    });

    if ($('.play-video').length > 0) {
        $('.play-video').YouTubePopUp();
    }

    
    if ($('#play-video').length > 0) {
        $('#play-video').YouTubePopUp();
    }



           
}(jQuery));