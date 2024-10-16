(function ($) {
    var confirm_btn = $('#confirm_btn').val();
    var cancel_btn = $('#cancel_btn').val();
    var confirm_text = $('#confirm_text').val();
    var confirm_profile = $('#confirm_profile').val();
    var adforest_ajax_url = $('#adforest_ajax_url').val();


    setTimeout(function () {
        $('body').addClass('loaded');
    }, 3000);

  
  
    /* Update user profile */
    $(document).on('click', '#sb_verification_ph,#resend_now', function ()
    {
        var ph_number = $('#sb_ph_number').val();
        $('#sb_verification_ph_code').hide();
        $('#sb_verification_ph').hide();
        $('#sb_verification_ph_back').show();
        $.post(adforest_ajax_url, {action: 'sb_verification_system', sb_phone_numer: ph_number, }).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0")
            {
                $('#sb_verification_ph_back').hide();
                $('.sb_ver_ph_div').hide();
                $('.sb_ver_ph_code_div').show();
                $('#sb_verification_ph_code').show();
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                $('#sb_verification_ph').show();
                $('#sb_verification_ph_back').hide();
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    $(document).on('click', '#change_pwd', function () {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_change_password', security: $('#sb-profile-reset-pass-token').val(), sb_data: $("form#sb-change-password").serialize(), }).done(function (response)
        {
            $('#sb_loading').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                $('#myModal').modal('hide');
                window.location = $('#login_page').val();
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        });
    });
    $(document).on('submit', '#sb_update_profile', function (e) {
        e.preventDefault();
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_update_profile', security: $('#sb-profile-token').val(), sb_data: $("form#sb_update_profile").serialize(), }).done(function (response)
        {
            $('#sb_loading').hide();
            if ($.trim(response) == '1')
            {
                var sb_user_name = $.sanitize($('input[name=sb_user_name]').val());
                var sb_user_address = $.sanitize($('input[name=sb_user_address]').val());
                var sb_user_type = $.sanitize($('select[name=sb_user_type]').val());
                if (sb_user_name != '') {
                    $('.sb_put_user_name').html(sb_user_name);
                }
                if (sb_user_address != '') {
                    $('.sb_put_user_address').html(sb_user_address);
                }
                if (sb_user_type != '') {
                    $('.sb_user_type').html(sb_user_type);
                }
                toastr.success($('#adforest_profile_msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                location.reload();
            } else
            {

                toastr.error(response, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        }
        );
    });


    /*Location while ad posting*/
    $('#sb_user_address').on('focus', function () {
        
        var map_type = sb_options.adforest_map_type;
        if (map_type == 'google_map') {
            adforest_location();
        }
     });



    $('body').on('click', '.user_list', function ()
    {

        $('#sb_loading').show();
        $('.message-history-active').removeClass('message-history-active');
        $(this).addClass('message-history-active');
        var second_user = $(this).attr('second_user');
        var inbox = $(this).attr('inbox');
        var msg_token = $(this).attr('sb_msg_token');
        var prnt = 'no';
        if (inbox == 'yes') {
            prnt = 'yes';
        }


        $('.block_user').hide();
        $('.unblock_user').hide();
        $('.block-to-' + second_user).show();
        $('.hide_receiver').hide();
        var cid = $(this).attr('cid');
        $('#' + second_user + '_' + cid).html('');
        $.post(adforest_ajax_url, {action: 'sb_get_messages', security: msg_token, ad_id: cid, user_id: second_user, receiver: second_user, inbox: prnt}).done(function (response)
        {
            $('#usr_id').val(second_user);
            $('#rece_id').val(second_user);
            $('#msg_receiver_id').val(second_user);
            $('#ad_post_id').val(cid)
            $('#sb_loading').hide();
            $('#messages').html(response);
            var dd_bottom = $('.list-wraps');
            $(dd_bottom).prop({scrollTop: $('.messages').prop("scrollHeight") - 590});
        }).fail(function () {
            $('#sb_loading').hide();
            $('#messages').html($('#_nonce_error').val());
        });
    });
    $(document).on('click', '.ad_title_show', function ()
    {
        var cur_ad_id = $(this).attr('cid');
        $('.sb_ad_title').hide();
        $('#title_for_' + cur_ad_id).show();
    });
    $('body').on('click', '.remove_fav_ad', function (e)
    {
        var id = $(this).attr('data-aaa-id');
        $.post(adforest_ajax_url, {action: 'sb_fav_remove_ad', ad_id: $(this).attr('data-aaa-id'), }).done(function (response)
        {
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1')
            {
                $('body').find('.holder-' + id).remove();
                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    (function ($) {
        $.sanitize = function (input) {
            var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').replace(/<[\/\!]*?[^<>]*?>/gi, '').replace(/<style[^>]*?>.*?<\/style>/gi, '').replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
            return output;
        };
    })(jQuery);
    //upload direct resume from shortcode hero section 1 and 2

    if ($("#upload_user_dp").length > 0) {
        $('#upload_user_dp').on('click', function () {
            document.getElementById('imgInp').click();
        })
    }

    /*Upload user profile picture */
    $('body').on('change', '.sb_files-data', function (e) {
        var fd = new FormData();
        var files_data = $('.sb_files-data');
        console.log(files_data);
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_file_upload[' + j + ']', file);
            });
        });
        fd.append('action', 'upload_user_pic');
        $('#sb_loading').show();
        $.ajax({
            type: 'POST',
            url: adforest_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#sb_loading').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1")
                {
                    $('#user_dp').attr('src', res_arr[1]);
                    $('#img-upload').attr('src', res_arr[1]);
                } else
                {
                    toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                }
            }
        });
    });
    /*
     * Assign role vendor to user on profile page.
     */
    $('#role_as_vendor').on('click', function () {
        var user_id = $('#role_as_vendor').attr("data-user_id");
        var vendor_approve = $('#role_as_vendor').attr('data-vendor_approve');
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_change_role_user_to_vendor', user_id: user_id, vendor_approve: vendor_approve}).done(function (response) {
            $('#sb_loading').hide();
            window.location.reload();
            toastr.success(response, '', {
                timeOut: 4000,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });
            location.reload();
        });
    });

    $(document).on('click', '.sb_make_feature_ad', function ()
    {
        adID = $(this).attr('data-aaa-id');
        var url   =  $(this).attr('data-url');


        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                       
                        if(url != undefined){
                            window.location.href = url;
                            return;
                        }
                         $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'sb_make_featured', ad_id: adID, }).done(function (response)
                        {
                            $('#sb_loading').hide();
                            var get_r = response.split('|');
                            if ($.trim(get_r[0]) == '1')
                            {
                                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            
                                  window.location.reload();
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
                }

            }
        });
    });
    $(document).on('click', '.delete-my-events', function ()
    {
        event_id = $(this).attr('data-myevent-id');
        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                        $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'remove_my_event', event_id: event_id, }).done(function (response)
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
                }

            }
        });
    });
    $(document).on('click', '.bump_it_up', function ()
    {
        adID = $(this).attr('data-aaa-id');
        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {

                        $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'sb_bump_it_up', ad_id: adID, }).done(function (response)
                        {
                            $('#sb_loading').hide();
                           // var get_r = response.split('|');
                           // var get_rs = response;
                            if ( true === response.success)
                            {
                                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                if(response.data.url){
                                     location.replace(response.data.url);
                                 }
                                  
                            } else
                            {
                                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
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
    /*My ads pagination*/
    $('body').on('focus', '.ad_status', function ()
    {
        previous = this.value;
    }).on('click', '.ad_status', function ()
    {
        adID = $(this).attr('data-adid');
        if (adID != "")
        {
            var $this = $(this);
            var status_val = $(this).attr('data-value');
            var bg_color_status = '#4caf50';
            if (status_val == 'active') {
                bg_color_status = '#4caf50';
            } else if (status_val == 'sold') {
                bg_color_status = '#3498db';
            } else if (status_val == 'expired') {
                bg_color_status = '#d9534f';
            }
            $.confirm({
                title: confirm_text,
                content: '',
                theme: 'Material',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    confirm: {
                        text: confirm_btn,
                        action: function () {
                            $('#sb_loading').show();
                            $.post(adforest_ajax_url, {action: 'sb_update_ad_status', ad_id: adID, status: status_val}).done(function (response)
                            {
                                $('#sb_loading').hide();
                                var get_r = response.split('|');
                                if ($.trim(get_r[0]) == '1')
                                {
                                    toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                    previous = this.value;
                                    jQuery('#status-dyn-' + $this.attr('adid') + '').css({"background-color": bg_color_status, "text-transform": "capitalize"});
                                    window.location.reload();
                                    //  jQuery('#status-dyn-' + $this.attr('adid') + '').html(status_text);
                                } else
                                {
                                    toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        }, },
                    cancel:
                            {text: cancel_btn,
                                function() {
                                },
                            }
                }
            });
        }
    });
    $('.ad_package_info').on('click', function () {

        $('#sb_loading').show();
        var id = $(this).attr('data-adid');
        $.post(adforest_ajax_url, {action: 'sb_get_ad_package_info', ad_id: id}).done(function (response)
        {
            $('#sb_loading').hide();
            $.dialog({
                title: $('#ad_info_text').val(),
                content: response,
            });
        })


    });
    $('body').on('click', '.remove_ad', function (e)
    {
        var id = $(this).attr('data-adid');
        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                        $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'sb_remove_ad', ad_id: id}).done(function (response)
                        {
                            $('#sb_loading').hide();
                            var get_r = response.split('|');
                            if ($.trim(get_r[0]) == '1')
                            {
                                $('body').find('.holder-' + id).remove();
                                toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            } else
                            {
                                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                        });
                    }, },
                cancel: {
                    text: cancel_btn,
                    function() {

                    },
                }
            }
        });
    });
    /*select profile tabs*/
    $(document).on('click', '.messages_actions', function ()
    {
        var sb_action = $(this).attr('sb_action');
        if (sb_action != "")
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: sb_action}).done(function (response)
            {
                $('#sb_loading').hide();
                $('#adforest_res').html(response);
                $('[data-toggle="tooltip"]').tooltip();
                var dd_bottom = $('.list-wraps');
                $(dd_bottom).prop({scrollTop: $(dd_bottom).prop("scrollHeight")});
            });
        }
    });
    var dd_bottoms = $('.package-details');
    if (dd_bottoms.length > 0) {
        const pss = new PerfectScrollbar(".package-details");
    }


    var dd_bottom = $('.sms-notification-admin');
    if (dd_bottom.length > 0) {
        const pss = new PerfectScrollbar(".sms-notification-admin");
    }



    /*Load Messages*/
    $('body').on('click', '.get_msgs', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_load_messages', ad_id: $(this).attr('ad_msg'), }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#adforest_res').html(response);
            if ($('#file_attacher').length > 0) {
                adforest_ajax_url = adforest_ajax_url;
                var attachmentsDropzone = new Dropzone(document.getElementById('file_attacher'), {
                    url: adforest_ajax_url,
                    autoProcessQueue: true,
                    previewsContainer: "#attachment-wrapper",
                    previewTemplate: '<span class="dz-preview dz-file-preview"><span class="dz-details"><span class="dz-filename"><i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;<span data-dz-name></span></span>&nbsp;&nbsp;&nbsp;<span class="dz-size" data-dz-size></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="cursor:pointer;font-size:15px;" data-dz-remove></i></span><span class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></span><i class="ti ti-refresh ti-spin"></i></span>',
                    clickable: "a.msgAttachFile",
                    acceptedFiles: $('#provided_format').val(),
                    maxFilesize: 15,
                    maxFiles: 4
                });
                attachmentsDropzone.on("sending", function () {
                    console.log("eeeee");
                    $("#send_msg ,#send_ad_message").attr("disabled", true);
                });
                attachmentsDropzone.on("queuecomplete", function () {
                    $("#send_msg, #send_ad_message").attr("disabled", false);
                });
            }
            var dd_bottom = $('.list-wraps');
            $(dd_bottom).prop({scrollTop: $(dd_bottom).prop("scrollHeight")});
               


                if($('#is_mobile').length > 0){
                     if($('#is_mobile').val() == '1'){
                         setTimeout(function () {
                              $('.list-wrap').attr('data-ps-id','');

                              $('.list-wraps').attr('data-ps-id','');
                             $('.list-wraps').css({"maxHeight":"unset"});
                          }, 1000);
                  }
              }





        });
    });
    $('body').on('click', '#send_msg', function ()
    {
        $('#send_message').parsley().on('field:validated', function () {
        }).on('form:submit', function () {

            var inbox = $('#send_msg').attr('inbox');
            var sb_msg_token = $('#send_msg').attr('sb_msg_token');
            var prnt = 'no';
            if (inbox == 'yes') {
                prnt = 'yes';
            }
            var fd = new FormData();
            if ($('#file_attacher').length > 0) {
                var fileUpload = $('#file_attacher').get(0).dropzone;
                  
                   if(undefined != fileUpload){ 
                 var files = fileUpload.files;
                for (var i = 0; i < files.length; i++) {
                    fd.append("message_file[]", files[i]);
                }
            }
            }
            var sb_data = $("form#send_message").serialize()
            fd.append('action', 'sb_send_message');
            fd.append('sb_data', sb_data);
            fd.append('security', sb_msg_token)
            $('#sb_loading').show();
            $.ajax({
                type: 'POST',
                url: adforest_ajax_url,
                data: fd,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    $('#sb_loading').hide();
                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        $('#sb_forest_message').val('');
                        if ($('.dz-preview').length > 0) {
                            $('.dz-preview').remove();
                            Dropzone.forElement('#file_attacher').removeAllFiles(true);
                        }
                        $.post(adforest_ajax_url, {action: 'sb_get_messages', security: sb_msg_token, ad_id: $("#ad_post_id").val(), user_id: $('#usr_id').val(), inbox: prnt}).done(function (response)
                        {
                            var get_r = response.split('|');
                            if (typeof response !== undefined && $.trim(get_r[0]) == '0') {
                                $('#sb_loading').hide();
                                toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            } else {
                                $('#sb_loading').hide();
                                $('#messages').html(response);
                                $('.message-details .list-wraps').scrollTop(20000).perfectScrollbar('update');
                            }
                        });
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
    });
    if (jQuery('[data-fancybox]').length > 0) {
        jQuery('[data-fancybox]').fancybox();
    }


    /*======== DROPDOWN NOTIFY ========*/
    var dropdownToggle = $('.notify-toggler');
    var dropdownNotify = $('.dropdown-notify');
    if (dropdownToggle.length !== 0) {
        dropdownToggle.on('click', function () {
            if (!dropdownNotify.is(':visible')) {
                dropdownNotify.fadeIn(5);
            } else {
                dropdownNotify.fadeOut(5);
            }
        });
    }

    $("#sidebar-toggler").on("click", function () {
        var sidebar = $('.sidebar-fixed');
        if (
                sidebar.hasClass("sidebar-fixed") ||
                sidebar.hasClass("sidebar-static")
                ) {
            $(this)
                    .addClass("sidebar-toggle")
                    .removeClass("sidebar-offcanvas-toggle");
            if (window.isMinified === false) {
                sidebar
                        .removeClass("sidebar-collapse sidebar-minified-out")
                        .addClass("sidebar-minified");
                window.isMinified = true;
                window.isCollapsed = false;
            } else {
                sidebar.removeClass("sidebar-minified");
                sidebar.addClass("sidebar-minified-out");
                window.isMinified = false;
            }
        }
    });
    if ($(window).width() >= 768 && $(window).width() < 992) {
        var sidebar = $('.sidebar-fixed');
        if (
                sidebar.hasClass("sidebar-fixed") ||
                sidebar.hasClass("sidebar-static")
                ) {
            sidebar
                    .removeClass("sidebar-collapse sidebar-minified-out")
                    .addClass("sidebar-minified");
            window.isMinified = true;
        }
    }


    if ($(window).width() < 768) {
        $(".sidebar-toggle").on("click", function () {
// $("body").css("overflow", "hidden");
            $('body').prepend('<div class="mobile-sticky-body-overlay"></div>')
        });
        $(document).on("click", '.mobile-sticky-body-overlay', function (e) {
            $(this).remove();
            sidebar = $('.sidebar-fixed');
            sidebar.removeClass("sidebar-mobile-in").addClass("sidebar-mobile-out");
            $("body").css("overflow", "auto");
        });
    }

    /*======== SIDEBAR TOGGLE FOR MOBILE ========*/
    if ($(window).width() < 768) {
        $(document).on("click", ".sidebar-toggle", function (e) {
            e.preventDefault();
            var min = "sidebar-mobile-in",
                    min_out = "sidebar-mobile-out",
                    sidebar = $('.sidebar-fixed');
            $(sidebar).hasClass(min)
                    ? $(sidebar)
                    .removeClass(min)
                    .addClass(min_out)
                    : $(sidebar)
                    .addClass(min)
                    .removeClass(min_out)
        });
    }

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
    /* Candidate Deleting Saved alerts */
    $(".del_save_alert").on("click", function () {
        var alert_id = $(this).attr("data-value");
        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                confirm: function () {
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {
                        action: 'del_job_alerts',
                        alert_id: alert_id, }).done(function (response)
                    {
                        $('#sb_loading').hide();
                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1')
                        {
                            $("#" + alert_id).remove();
                            toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else
                        {
                            toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    });
                },
               cancel: {
                    text: cancel_btn,
                    function() {

                    },
                }
            }
        });
    });
    $(".delete_site_user").on("click", function () {
       userID = $(this).attr('data-user-id');
        $.confirm({
            title: confirm_text,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'delete_site_user_func', del_user_id: userID, }).done(function (response)
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
                    });
                }},
                cancel: {
                    text: cancel_btn,
                    function() {

                    }},
            }
        });
    });
    
    $(document).on('click', '#sb_verification_ph_code', function ()
   {
        var ph_code = $('#sb_ph_number_code').val();
        $('#sb_verification_ph_code').hide();
        $('#sb_verification_ph_back').show();
        $.post(adforest_ajax_url, {action: 'sb_verification_code', sb_code: ph_code, }).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) != "0")
            {
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                location.reload();
            } else
            {
                $('#sb_verification_ph_code').show();
                $('#sb_verification_ph_back').hide();
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    /*======== 1. SCROLLBAR SIDEBAR ========*/
    $(".sidebar-scrollbar")
            .slimScroll({
                opacity: 0,
                height: "100%",
                color: "#808080",
                size: "5px",
                wheelStep: 10
            })
            .mouseover(function () {
                $(this)
                        .next(".slimScrollBar")
                        .css("opacity", 0.5);
            });

             $("select").select2({placeholder: $("#select_place_holder"), allowClear: true, width: '100%'});
   


  $(document).ready(function () {

          if ($('#spinner').length > 0) {
              document.getElementById('spinner').style.display = 'none';
          }
    });

    /* Profile Badge Start */
    $(document).on('click', '#profile-badge', function ()
    {
       adID = $(this).attr('data-aaa-id');
        var url   =  $(this).attr('data-url');
        $.confirm({
            title: confirm_profile,
            content: '',
            theme: 'Material',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                confirm: {
                    text: confirm_btn,
                    action: function () {
                         $('#sb_loading').show();
                        $.post(adforest_ajax_url, {action: 'sb_profile_badge', ad_id: adID, }).done(function (response)
                        {
                            $('#sb_loading').hide();
                            if ( true === response.success)
                            {
                                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                if(response.data.url){
                                     location.replace(response.data.url);
                                 }
                                  
                            } else
                            {
                                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            }
                        });
                    }, },
                cancel: {
                    text: cancel_btn,
                    function() {

                    },
                }

            }
        });
    });
    /* Profile Badge Ends */

    /*end of directory listing code*/
})(jQuery);