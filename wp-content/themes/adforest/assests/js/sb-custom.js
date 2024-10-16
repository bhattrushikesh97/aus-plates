(function ($) {
    var ajax_url = $('#adforest_ajax_url').val();
    var inputShortText = $('#select2-tooshort').val();
    var noResultsText = $('#select2-noresutls').val();
    var searchingText = $('#select2-searching').val();
    var confirm_btn = $('#confirm_btn').val();
    var cancel_btn = $('#cancel_btn').val();
    var confirm_text = $('#confirm_text').val();
    var adforest_ajax_url = ajax_url;
    sb_options = sb_ajax_object;
    var ajax_url = sb_ajax_object.ajax_url;
    var adforest_ajax_url = ajax_url;
    var autoplay = parseInt(sb_ajax_object.auto_slide_time);
    var is_rtl_check = sb_ajax_object.is_rtl;

 
    /*Destroy select */
    
    if ($('#event_start').length > 0) {
        $('#event_start').datepicker({
            timepicker: true,
            dateFormat: 'yyyy-mm-dd',
            language: {
                days: [sb_ajax_object.Sunday, sb_ajax_object.Monday, sb_ajax_object.Tuesday, sb_ajax_object.Wednesday, sb_ajax_object.Thursday, sb_ajax_object.Friday, sb_ajax_object.Saturday],
                daysShort: [sb_ajax_object.Sun, sb_ajax_object.Mon, sb_ajax_object.Tue, sb_ajax_object.Wed, sb_ajax_object.Thu, sb_ajax_object.Fri, sb_ajax_object.Sat],
                daysMin: [sb_ajax_object.Su, sb_ajax_object.Mo, sb_ajax_object.Tu, sb_ajax_object.We, sb_ajax_object.Th, sb_ajax_object.Fr, sb_ajax_object.Sa],
                months: [sb_ajax_object.January, sb_ajax_object.February, sb_ajax_object.March, sb_ajax_object.April, sb_ajax_object.May, sb_ajax_object.June, sb_ajax_object.July, sb_ajax_object.August, sb_ajax_object.September, sb_ajax_object.October, sb_ajax_object.November, sb_ajax_object.December],
                monthsShort: [sb_ajax_object.Jan, sb_ajax_object.Feb, sb_ajax_object.Mar, sb_ajax_object.Apr, sb_ajax_object.May, sb_ajax_object.Jun, sb_ajax_object.Jul, sb_ajax_object.Aug, sb_ajax_object.Sep, sb_ajax_object.Oct, sb_ajax_object.Nov, sb_ajax_object.Dec],
                today: sb_ajax_object.Today,
                clear: sb_ajax_object.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
            minDate: new Date()
        });
    }
    if ($('#event_end').length > 0) {
        $('#event_end').datepicker({
            timepicker: true,
            dateFormat: 'yyyy-mm-dd',
            language: {
                days: [sb_ajax_object.Sunday, sb_ajax_object.Monday, sb_ajax_object.Tuesday, sb_ajax_object.Wednesday, sb_ajax_object.Thursday, sb_ajax_object.Friday, sb_ajax_object.Saturday],
                daysShort: [sb_ajax_object.Sun, sb_ajax_object.Mon, sb_ajax_object.Tue, sb_ajax_object.Wed, sb_ajax_object.Thu, sb_ajax_object.Fri, sb_ajax_object.Sat],
                daysMin: [sb_ajax_object.Su, sb_ajax_object.Mo, sb_ajax_object.Tu, sb_ajax_object.We, sb_ajax_object.Th, sb_ajax_object.Fr, sb_ajax_object.Sa],
                months: [sb_ajax_object.January, sb_ajax_object.February, sb_ajax_object.March, sb_ajax_object.April, sb_ajax_object.May, sb_ajax_object.June, sb_ajax_object.July, sb_ajax_object.August, sb_ajax_object.September, sb_ajax_object.October, sb_ajax_object.November, sb_ajax_object.December],
                monthsShort: [sb_ajax_object.Jan, sb_ajax_object.Feb, sb_ajax_object.Mar, sb_ajax_object.Apr, sb_ajax_object.May, sb_ajax_object.Jun, sb_ajax_object.Jul, sb_ajax_object.Aug, sb_ajax_object.Sep, sb_ajax_object.Oct, sb_ajax_object.Nov, sb_ajax_object.Dec],
                today: sb_ajax_object.Today,
                clear: sb_ajax_object.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
            minDate: new Date()
        });
    }


    if ($('#already_booked_day').length > 0) {
        var cal = $('#already_booked_day').datepicker({
            timepicker: false,
            dateFormat: 'yyyy-mm-dd',
            multipleDates: true,

            //minDate: new Date(),
            language: {
                days: [sb_ajax_object.Sunday, sb_ajax_object.Monday, sb_ajax_object.Tuesday, sb_ajax_object.Wednesday, sb_ajax_object.Thursday, sb_ajax_object.Friday, sb_ajax_object.Saturday],
                daysShort: [sb_ajax_object.Sun, sb_ajax_object.Mon, sb_ajax_object.Tue, sb_ajax_object.Wed, sb_ajax_object.Thu, sb_ajax_object.Fri, sb_ajax_object.Sat],
                daysMin: [sb_ajax_object.Su, sb_ajax_object.Mo, sb_ajax_object.Tu, sb_ajax_object.We, sb_ajax_object.Th, sb_ajax_object.Fr, sb_ajax_object.Sa],
                months: [sb_ajax_object.January, sb_ajax_object.February, sb_ajax_object.March, sb_ajax_object.April, sb_ajax_object.May, sb_ajax_object.June, sb_ajax_object.July, sb_ajax_object.August, sb_ajax_object.September, sb_ajax_object.October, sb_ajax_object.November, sb_ajax_object.December],
                monthsShort: [sb_ajax_object.Jan, sb_ajax_object.Feb, sb_ajax_object.Mar, sb_ajax_object.Apr, sb_ajax_object.May, sb_ajax_object.Jun, sb_ajax_object.Jul, sb_ajax_object.Aug, sb_ajax_object.Sep, sb_ajax_object.Oct, sb_ajax_object.Nov, sb_ajax_object.Dec],
                today: sb_ajax_object.Today,
                clear: sb_ajax_object.Clear,
            },
        });
    }

    function sb_eventz_zone()
    {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "image/*";
        var fileList = new Array;
        var i = 0;
        $("#event_dropzone").dropzone({
            addRemoveLinks: true,
            paramName: "my_file_upload",
            maxFiles: $('#event_upload_limit').val(),
            acceptedFiles: '.jpeg,.jpg,.png',
            dictMaxFilesExceeded: $('#max_upload_reach').val(),
            url: ajax_url + "?action=upload_sb_pro_events_images&is_update=" + $('#is_update').val(),
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
                $.post(ajax_url, {action: 'get_event_images', is_update: $('#is_update').val()}).done(function (data)
                {
                    if (data != 0)
                    {
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
                        $.post(ajax_url, {action: 'delete_event_image', img: img_id, is_update: $('#is_update').val(), }).done(function (response)
                        {
                            if ($.trim(response) == "1")
                            {
                                //   $("#listing_msgz").hide();
                                this.removeFile(file);
                            }
                        });
                    }
                });
                this.on("maxfilesexceeded", function (file) {
                    alert('can upload only one image');
                    this.removeFile(file);
                });
            },
        });
    }
    /*--- Registration Form Action ---*/
    if ($('#event_dropzone').length > 0) {
        sb_eventz_zone();
    }
    $('#show-me').hide();
    $('#event_title').on('blur', function ()
    {
        $('#show-me').show();
        $.post(ajax_url, {action: 'create_new_event', event_title: $('#event_title').val(), is_update: $('#is_update').val(), }).done(function (response)
        {
            $('#show-me').hide();
        });
    });

    $(document).on('click', '.show_book_form', function () {

        $('.calender-container').toggle('slow');
        $('.booking-form-container').toggle('slow');

        if (jQuery(this).closest('li').hasClass("lp-booking-disable")) {
            return false;
        } else {
            var $this = jQuery(this),
                    timeslot = $this.closest('li').attr('data-booking-slot'),
                    stratSlot = $this.find('.start_time').text();
            endSlot = $this.find('.end_time').text();
            bookingDay = $('.selectd_booking_day').text();
            bookingDate = $('.selectd_booking_date').text();
            bookingMonth = $('.selectd_booking_month').text();

            /*form list values*/
            $('.slot_start').html(stratSlot);
            $('.slot_end').html(endSlot);

            timeSlot = stratSlot + endSlot;
            $('#selectd_booking_time').html(timeSlot);

            $('.booking_day').html(bookingDay);
            $('.booking_date').html(bookingDate);
            $('.booking_month').html(bookingMonth);
            /*hidden input values*/
            $('.form_slot_start').val(stratSlot);
            $('.form_slot_end').val(endSlot);
            $('.creat-booking-submit').prop("disabled", false);
        }
    });


    if ($('.create-booking-form').length > 0) {
        $('.creat-booking-submit i').hide();
        $('.create-booking-form').on('submit', function (e) {
            e.preventDefault();
            $('.creat-booking-submit i').show();
            $('.creat-booking-submit').prop("disabled", true);
            $.post(ajax_url, {action: 'sb_pro_create_booking', data: $('.create-booking-form').serialize()})
                    .done(function (response)
                    {
                        if (response.success == true) {
                            $('.booking-form-container').hide();
                            $('.booking-confirmed').show();
                            $('.calender-container').hide();
                            $('.current-selected-date').hide();


                            toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else {
                            toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                             window.location = response.data.url;        
                        }

                        $('.creat-booking-submit i').hide();
                        $('.creat-booking-submit').prop("disabled", false);

                    });
        });
    }


    $('.booking-confirmation-close i').on('click', function () {
        $('.booking-form-container').hide();
        $('.booking-confirmed').hide();
        $('.calender-container').show();
        $('#selectd_booking_time').html('');
        $('.current-selected-date').show();
    });



    /* Business Hours Selection */
    $('.tab-pane .is_closed').on('ifChecked', function (event) {
        var checkbox = $(this).attr("value");

        $("#to-" + checkbox).prop('readonly', true);
        $("#from-" + checkbox).prop('readonly', true);

    });

    $('.tab-pane .is_closed').on('ifUnchecked', function (event) {
        var checkbox = $(this).attr("value");

        $("#to-" + checkbox).prop('readonly', false);
        $("#from-" + checkbox).prop('readonly', false);

    });

    $('.tab-pane .is_break').on('ifChecked', function (event) {
        var checkbox = $(this).attr("value");
        $("#breakto-" + checkbox).prop('readonly', false);
        $("#breakfrom-" + checkbox).prop('readonly', false);
    });
    $('.tab-pane .is_break').on('ifUnchecked', function (event) {
        var checkbox = $(this).attr("value");

        $("#breakto-" + checkbox).prop('readonly', true);
        $("#breakfrom-" + checkbox).prop('readonly', true);
    });

    $(document).on('ifChecked', '.frontend_hours input[type="radio"]', function () {
        var valzz = $(this).val();
        $('input[name=hours_type]').val(valzz);
        if (valzz == 2) {
            $("#timezone").show();
            $("#business-hours-fields").show();
            $("input#timezones").prop('required', true);
        } else {
            $("#timezone").hide();
            $("#business-hours-fields").hide();
            $("input#timezones").prop('required', false);
        }
    });

    if ($('.frontend_hours input[type="radio"]').is(':checked')) {
        var selected_valz = $('#hours_type').val();
        if (selected_valz == 2) {
            $("#timezone").show();
            $("#business-hours-fields").show();
            $("input#timezones").prop('required', true);
        } else {
            $("#timezone").hide();
            $("#business-hours-fields").hide();
            $("input#timezones").prop('required', false);
        }
    }

    $(document).ready(function () {
        if ($('.for_specific_page').is('.timepicker')) {
            $('.timepicker').timeselect({'step': 15, autocompleteSettings: {autoFocus: true}});
        }
        /*Directory   listing start code  hours*/
    
    if ($('#timezones').length >0) {
        var tzones = document.getElementById('theme_path').value + "/assests/js/zones.json";
        $.get(tzones, function (data) {

            typeof $.typeahead === 'function' && $.typeahead({
                input: ".myzones-t",
                minLength: 0,
                //   emptyTemplate: get_strings.no_r_for + "{{query}}",
                searchOnFocus: true,
                blurOnTab: true,
                order: "asc",
                hint: true,
                source: data,
                debug: false,
            });
        }, 'json');
    }

    });



    if ($('#calender-booking').length > 0) {
        var bookedDays = $('#booked_days').val();
        var bookedDaysArr = bookedDays.split(',');
        enabledDays = bookedDaysArr;
        $('#calender-booking').datepicker({
            timepicker: false,
            dateFormat: 'yyyy-mm-dd',
            minDate: new Date(),
            language: {
                days: [sb_ajax_object.Sunday, sb_ajax_object.Monday, sb_ajax_object.Tuesday, sb_ajax_object.Wednesday, sb_ajax_object.Thursday, sb_ajax_object.Friday, sb_ajax_object.Saturday],
                daysShort: [sb_ajax_object.Sun, sb_ajax_object.Mon, sb_ajax_object.Tue, sb_ajax_object.Wed, sb_ajax_object.Thu, sb_ajax_object.Fri, sb_ajax_object.Sat],
                daysMin: [sb_ajax_object.Su, sb_ajax_object.Mo, sb_ajax_object.Tu, sb_ajax_object.We, sb_ajax_object.Th, sb_ajax_object.Fr, sb_ajax_object.Sa],
                months: [sb_ajax_object.January, sb_ajax_object.February, sb_ajax_object.March, sb_ajax_object.April, sb_ajax_object.May, sb_ajax_object.June, sb_ajax_object.July, sb_ajax_object.August, sb_ajax_object.September, sb_ajax_object.October, sb_ajax_object.November, sb_ajax_object.December],
                monthsShort: [sb_ajax_object.Jan, sb_ajax_object.Feb, sb_ajax_object.Mar, sb_ajax_object.Apr, sb_ajax_object.May, sb_ajax_object.Jun, sb_ajax_object.Jul, sb_ajax_object.Aug, sb_ajax_object.Sep, sb_ajax_object.Oct, sb_ajax_object.Nov, sb_ajax_object.Dec],
                today: sb_ajax_object.Today,
                clear: sb_ajax_object.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
            selectedDates: ['2022-03-06'],
            onRenderCell: function onRenderCell(date, cellType) {
                if (cellType == 'day') {
                    var day = (date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2)));
                    var isDisabled = enabledDays.indexOf(day) != -1;
                    return {
                        disabled: isDisabled
                    }
                }
            },
            onSelect: function (date, obj) {

                var ad_id = $('#calender-booking').data('ad-id');
                $('.panel-dropdown-scrollable').html('');

                $('.booking-spin-loader').show();
                $.post(ajax_url, {
                    action: 'sb_get_calender_time',
                    date: date,
                    ad_id: ad_id,
                }).done(function (response) {
                    $('.booking-spin-loader').hide();
                    if (response.success == true) {
                        $('.panel-dropdown-scrollable').html(response.data.timing_html);
                        var date_obj = response.data.date_data;

                        $('.selectd_booking_day').html(date_obj.day_name);
                        $('.selectd_booking_date').html(date_obj.date);
                        $('.selectd_booking_month').html(date_obj.month_name);
                        $('.selectd_booking_year').html(date_obj.year);

                        $('.form_booking_day').val(date_obj.day_name);
                        $('.form_booking_date').val(date_obj.date);
                        $('.form_booking_month').val(date_obj.month);
                        $('.form_booking_month_name').val(date_obj.month_name);
                        $('.form_booking_year').val(date_obj.year);
                        console.log(response);
                    }

                    else {
                        toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        window.location = response.data.url;        

                    }

                });
            }
        });
    }
    /*Directory listing end code*/

    /*   directory listing code   */

    if ($('#my-events').length > 0)
    {
        $('#my-events').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    $.post(adforest_ajax_url, {action: 'my_new_event', sb_data: $("#my-events").serialize(), }).done(function (response)
                    {
                        if (response.success == true) {
                            $('#sb_loading').hide();

                            $.confirm({
                                title: confirm_text,
                                content: $('#visit_text').val(),
                                theme: 'Material',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'blue',
                                buttons: {
                                    confirm: {
                                        text: confirm_btn,
                                        action: function () {
                                            window.location = response.data.url;
                                        }, },
                                    cancel: {
                                        text: cancel_btn,
                                        function() {
                                           window.location.reload;
                                        },
                                    }
                                }
                            });
                            toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else {
                              $('#sb_loading').hide();
                            toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    }

    var inputShortText = $('#select2-tooshort').val();
    var noResultsText = $('#select2-noresutls').val();
    var searchingText = $('#select2-searching').val();
    jQuery('.sb-select2-ajax').select2({
        ajax: {
            url: adforest_ajax_url,
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'select2_ajax_ads' // AJAX action for admin-ajax.php
                };
            },
            processResults: function (data) {
                var options = [];
                var disabled_opts = false;

                console.log(data);

                if (data) {

                    // data is the array of arrays, and each of them contains ID and the Label of the option
                    jQuery.each(data, function (index, text) { // do not forget that "index" is just auto incremented value
                        var disabled_opts = false;
                        if (text[2] == 'yes')
                        {
                            disabled_opts = true;
                        }
                        options.push({id: text[0], text: text[1], disabled: disabled_opts});
                    });
                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return inputShortText;
            },
            noResults: function () {
                return noResultsText;
            },
            searching: function () {
                return searchingText;
            }
        }
    });


    if ($('#my-bookings-listing').length > 0) {
        $('#my-bookings-listing').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    var booked_days = $('#already_booked_day').datepicker().val();
                    $('#booked_days').val(booked_days);

                    $.post(adforest_ajax_url, {action: 'sb_allow_booking', sb_data: $("#my-bookings-listing").serialize(), }).done(function (response)
                    {
                        if (response.success == true) {
                            $('#sb_loading').hide();
                            toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});

                            //  window.location.reload();
                        } else {
                            $('#sb_loading').hide();
                            toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });
                    return false;
                });
    }


    $(document).on('submit', '#update-booking-listing', function (e) {

        e.preventDefault();

        $.post(adforest_ajax_url, {action: 'sb_allow_booking', sb_data: $("#update-booking-listing").serialize(), }).done(function (response)
        {
            if (response.success == true) {
                $('#sb_loading').hide();
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else {
                $('#sb_loading').hide();
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        });
    });
    $('.booking_status').on('change', function () {
        var val = $(this).val();
        var bookingID = $(this).data('id');
        $.confirm({
            title: $('#prompt_heading').val(),
            content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<textarea  placeholder="' + $('#prompt_heading').val() + '" class="name form-control" rows="8"></textarea>' +
                    '</div>' +
                    '</form>',
            buttons: {
                formSubmit: {
                    text: confirm_btn,
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert($('#no-detail-notify').val());
                            return false;
                        } else {
                            $('#sb_loading').show();
                            $.post(adforest_ajax_url, {action: 'sb_booking_status', val: val, booking_id: bookingID, extra_detail: name}).done(function (response)
                            {
                                $('#sb_loading').hide();
                                if (response.success == true)
                                {
                                    toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                } else
                                {
                                    toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        }
                    }
                },
                cancel: {
                    text: cancel_btn,
                    function() {
                    },
                }
            },
        });
    });
    
    
    
    
    $(document).on('click', '.view_booking_details', function ()
    {
        var bookingID = $(this).data('id');
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_get_booking_details', booking_id: bookingID, }).done(function (response)
        {
            if (response.success)
            {
                $('#booking-detail-content').html(response.data.detail)
                $('#booking-detail-modal').modal('show');
                $('#sb_loading').hide();
            } else
            {
                $('#sb_loading').hide();
            }
        });
    });


    $('#order_booking').on('change', function () {
        $(this).closest('form').submit();
    });


    $('.sb_remove_booking').on('click', function () {
        adID = $(this).attr('data-aaa-id');
        elem = $(this);
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
                        $.post(adforest_ajax_url, {action: 'sb_remove_booking', ad_id: adID, }).done(function (response)
                        {
                            $('#sb_loading').hide();
                            if (response.success == true)
                            {
                                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                console.log(elem);
                                elem.parents('.col-lg-6').remove();
                            } else
                            {
                                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
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


    $('.edit_booking_option').on('click', function () {
        adID = $(this).attr('data-aaa-id');
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_get_booking_options', ad_id: adID, }).done(function (response)
        {
            $('#sb_loading').hide();
            $('#ad-booking-content').html(response);
            if ($('#already_booked_day').length > 0) {
                var bookedDays = $('#booked_days').val();
                var bookedDaysArr = bookedDays.split(', ');
                enabledDays = bookedDaysArr;
                var cal = $('#already_booked_day').datepicker({
                    timepicker: false,
                    dateFormat: 'yyyy-mm-dd',
                    language: {
                        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        today: 'Today',
                        clear: 'Clear',
                        dateFormat: 'mm/dd/yyyy',
                    },
                    multipleDates: true,
                    selectedDates: ['2022-06-03', '2022-03-06'],
                });
                $('#already_booked_day').datepicker().val('2022-06-03', '2022-03-06');
            }
            ;
            $('#ad-booking-modal').modal('show');
        });
    });

    if ($('.event_desc').length > 0) {

        $('.event_desc').jqte({color: false});
    }

    is_rtl = false;

    if (is_rtl_check == "1") {
        is_rtl = true;
        var navTextAngle = ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"];
    }

//    if ($('.event-carousel').length > 0) {
//        $('.event-carousel').owlCarousel({
//            autoplay: 3500,
//            autoplayHoverPause: true,
//            autoplayTimeout: autoplay,
//            items: 4,
//            loop: true,
//            margin: 15,
//            nav: true,
//            dots: false,
//            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
//            rt: is_rtl,
//            responsive: {
//                0: {
//                    items: 1
//                },
//                600: {
//                    items: 1
//                },
//                1000: {
//                    items: 1
//                }
//            }
//        });
//
//    }

    /* Ad Location */
    if ($('#event_latt').length > 0)
    {
        var lat = $('#event_latt').val();
        var lon = $('#event_long').val();
        var map_type = sb_options.adforest_map_type;
        if (map_type == 'leafletjs_map')
        {
            /*For leafletjs map*/
            var map = L.map('event_detail_map').setView([lat, lon], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: ''}).addTo(map);
            L.marker([lat, lon]).addTo(map);
        } else if (map_type == 'google_map')
        {
            /*For Google Map*/
            var map = "";
            var latlng = new google.maps.LatLng(lat, lon);
            var myOptions = {zoom: 13, center: latlng, scrollwheel: false, mapTypeId: google.maps.MapTypeId.ROADMAP, size: new google.maps.Size(480, 240)}
            map = new google.maps.Map(document.getElementById("event_detail_map"), myOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: latlng
            });
        }
    }



    /* event  rating Logic */
    if ($('#event_rating_form').length > 0)
    {
        $('#event_rating_form').parsley().on('field:validated', function () {
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(ajax_url, {action: 'sb_event_rating', security: $('#sb-review-token').val(), sb_data: $("form#event_rating_form").serialize(), }).done(function (response)
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
    $('.reply_event_rating').on('click', function ()
    {
        var p_comment_id = $(this).attr('data-comment_id');
        $('#reply_to_rating').html($(this).attr('data-commenter-name'));
        $('#parent_comment_id').val(p_comment_id);
    });
    /*Send message to ad owner*/
    if ($('#event_rating_reply_form').length > 0)
    {
        $('#event_rating_reply_form').parsley().on('field:validated', function () {
        }).on('form:submit', function () {
            $('#sb_loading').show();
            $.post(ajax_url, {action: 'sb_event_rating_reply', security: $('#sb-review-reply-token').val(), sb_data: $("form#event_rating_reply_form").serialize(), }).done(function (response)
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

    $('#ad-to-fav-event').on('click', function ()
    {
        var $this = $(this);
        var id = $(this).attr('data-id');
        $('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_fav_event', event_id: id, }).done(function (response)
        {
            $('#sb_loading').hide();

            if (response.success == true)
            {
                $this.toggleClass("ad-favourited");
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });
    var addClick = 0;
    $('#add_event_btn').on('click', function () {
        addClick += 1;
        var randNum = Math.floor((Math.random() * 1000000000) + 1);
        var my_Divs = randNum;
        var room = my_Divs + 1;
        var end_date_class = my_Divs + 2;
        var objTo = document.getElementById('event_question_continer');
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group remove-que removeclass_question" + room);
        var rdiv = 'removeclass_edu' + (room);
        var inst_html = '<div class="row group" ><div class="col-md-12 col-sm-12 col-12"><div class="form-group"><label>Question</label><input type="text"  placeholder="Question" name="event_question[\'question\'][]" class="form-control"></div>\n\
<div class="form-group"><label>Answer</label><input type="text"  placeholder="Answer" name="event_question[\'answer\'][]" class="form-control"></div><div class= "form-group"><button type="button" class="btn btn-danger btnRemoveQuestion" data-id ="removeclass_question' + randNum + '" >Remove</button></div></div>';

        divtest.innerHTML = inst_html;
        objTo.appendChild(divtest);
    });

    $(document).on('click', '.btnRemoveQuestion', function () {
        $(this).closest('.remove-que').remove();
    });
    /*event schedules*/
    if ($('.event_day_schedule').length > 0) {
        $('.event_day_schedule').jqte({color: false});
    }
    var addDay = 0;
    $('#add_event_schedule').on('click', function () {
        addDay += 1;
        var randNum = Math.floor((Math.random() * 1000000000) + 1);
        var my_Divs = randNum;
        var room = my_Divs + 1;
        var end_date_class = my_Divs + 2;
        var objTo = document.getElementById('event_schedule_continer');
        var divtest = document.createElement("div");

        var randClass = "schedule_editor" + room;
        divtest.setAttribute("class", "form-group remove-schedule removeclass_question" + room);
        var rdiv = 'removeclass_edu' + (room);
        var inst_html = '<div class="row group" ><div class="col-md-12 col-sm-12 col-12"><div class="form-group"><label>Day</label><input type="text"  placeholder="Day" name="event_schedules[\'day\'][]" class="form-control"></div>\n\
<div class="form-group"><label>Answer</label><textarea   placeholder="Schedule" name="event_schedules[\'day_val\'][]" class="form-control event_day_schedule ' + randClass + '"></textarea></div><div class= "form-group"><button type="button" class="btn btn-danger btnRemoveDay" data-id ="removeclass_schedule ' + randNum + '" >Remove</button></div></div>';

        divtest.innerHTML = inst_html;
        objTo.appendChild(divtest);

        $('.' + randClass).jqte({color: false});
    });




    $(document).on('click', '.btnRemoveDay', function () {
        $(this).closest('.remove-schedule').remove();
    });



    /* event search page queryy **/

    /*For Title & Location*/
    $('#get_title,#get_locz,#get_start_date_filter,#get_end_date_filter').on('click', function () {
        sb_search_events_content('');
    });

    $('#event_cat,#event_custom_loc,.event_orer_by').on('change', function () {
        sb_search_events_content('');
    });

    function add_event_skeletons(append_class, view) {
        append_class.addClass('content-loading-skeleton-grid');
    }
    function remoove_event_skeletons(append_class, view) {
        append_class.removeClass('content-loading-skeleton-grid');
    }

    function sb_search_events_content(page_num) {
         document.getElementById('event-content').scrollIntoView({
        });
        $('.event-content').html('');
        $('.event-pagination').html('');
        add_event_skeletons($('.event-search-content'), 'grid');
        $.post(adforest_ajax_url,
                {
                    action: 'sb_ajax_search_events',
                    form_data: $('#d_events_filters').serialize(),
                    page_no: page_num,
                    pagination: 'yes',
                    grid_type: $('#layout_type').val(),
                    sort_by: $('.event_orer_by').val(),
                }).done(function (response)
        {
            remoove_event_skeletons($('.event-search-content'), 'grid');
            adforest_timerCounter_function();
            $('.event-content').html(response.data.data);
            if (response.data.pagination) {
                $('.event-pagination').html(response.data.pagination);
                $('.event-pagination li').removeClass('active');

            }
            $('#event-count').html(response.data.total);
        });
    }

    $(document).on('click', '.event-pagination a', function (e) {
        e.preventDefault();
        document.getElementById('event-content').scrollIntoView({
        });
        sb_search_events_content($(this).text());
        
    });


    if ($('#distance-slider').length > 0) {
        /*getting current current lat long */
        getCurLocation();
        function getCurLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(setCurrentLatLong, errorMsg);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        function setCurrentLatLong(position) {
            
            console.log(position);
            
            $('#event-lat').val(position.coords.latitude);
            $('#event-long').val(position.coords.longitude);
        }
        function errorMsg(error) {
            alert('Enable Location to work with distance search');
        }
        /*  slider  */
        $('#distance-slider').noUiSlider({
            start: 0,
            connect: 'lower',
            range: {
                'min': 0,
                'max': 100
            }
        });
        $('#distance-slider').Link('lower').to($('#min_dis'), null, wNumb({decimals: 0}));
        $('.submit-distance').on('click', function () {
            sb_search_events_content();
        })
    }
    // Ad-category-carousel
    if ($('.ad-category-carousel').length > 0) {
        $('.ad-category-carousel').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            nav: true,
            navText: ["<span class='iconify'; data-icon='bi:chevron-left'></span>", "<span class='iconify' data-icon='bi:chevron-right'></span>"],
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 4
                },
                1200: {
                    items: 5
                },
            }
        });
    }


    function regenerate_masnory()
    {
        // init Isotope
        var $item = $('.posts-masonry');
        $item.isotope('destroy');
        $item.imagesLoaded(function () {
            $item.isotope({
                itemSelector: '.masonery_item',
                percentPosition: true,
                originLeft: 'is_rtlz',
                layoutMode: 'fitRows',
                transitionDuration: '0.7s',
                masonry: {
                    columnWidth: '.masonery_item'
                }
            });
        });
    }

    $('.filter-date-event').on('click', function () {
        $container = $(this).closest('.event-grids').find('.posts-masonry').html('');
        $this = $(this);
        var date_val = $(this).attr('data-id');
        add_event_skeletons($container, 'grid');
        $.post(adforest_ajax_url,
                {
                    action: 'sb_ajax_search_events',
                    form_data: $('#d_events_filters').serialize(),
                    page_no: 1,
                    grid_type: 3,
                    data_date: date_val,
                    grid_col : $('#grid_col').val(),
                }).done(function (response)
        {
            remoove_event_skeletons($container, 'grid');
            adforest_timerCounter_function();
            $container.html(response.data.data);
            console.log(response.data.no_result);
            $('#event-count').html(response.data.total);
            if (response.data.no_result == true) {
                $this.parents('.ads-grid-selector').find('.posts-masonry').height('auto');
                $('.ads-grid-selector .btn-theme').hide();
                
            } else {
                regenerate_masnory();
                 $('.ads-grid-selector .btn-theme').show();
            }

        });
    });

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
    /* end event search page*/
    $('#going_to_event').on('click', function () {
        eventID = $(this).attr('data-id');
        going = $(this).attr('data-going');
        notgoing = $(this).attr('data-notgoing');
        staus = $(this).attr('data-status');
        $('#sb_loading').show();
        $.post(adforest_ajax_url,
                {
                    action: 'sb_going_to_event',
                    event_id: eventID,
                    staus: staus,
                }).done(function (response)
        {
            if (response.success == true) {
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
               window.location.reload();
            } else {
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
              window.location.reload();
            }
            $('#sb_loading').hide();
        });

    });

    if ($('#my-events').length > 0) {
        $('#event_country_sub_div').hide();
        $('#event_country_sub_sub_div').hide();
        $('#event_country_sub_sub_sub_div').hide();
        if ($('#is_update').val() != "")
        {
            var country_level = $('#country_level').val();
            if (country_level >= 2) {
                $('#event_country_sub_div').show();
            }
            if (country_level >= 3) {
                $('#event_country_sub_sub_div').show();
            }
            if (country_level >= 4) {
                $('#event_country_sub_sub_sub_div').show();
            }
        }
        $('#event_country').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#event_country_states").val('');
                $("#event_country_cities").val('');
                $("#event_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#event_country_id').val($("#ad_cat").val());
                    $('#event_country_sub_div').show();
                    $('#event_country_states').html(response);
                    $('#event_country_sub_sub_sub_div').hide();
                    $('#event_country_sub_sub_div').hide();
                } else
                {
                    $('#event_country_sub_div').hide();
                    $('#ad_cat_sub_sub_div').hide();
                    $('#event_country_sub_sub_div').hide();
                    $('#event_country_sub_sub_sub_div').hide();
                }
            });
        });

        /* Level 2 */
        $('#event_country_states').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country_states").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#event_country_cities").val('');
                $("#event_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#event_country_id').val($("#event_country_states").val());
                    $('#event_country_sub_sub_div').show();
                    $('#event_country_cities').html(response);
                    $('#event_country_sub_sub_sub_div').hide();
                } else
                {
                    $('#event_country_sub_sub_div').hide();
                    $('#event_country_sub_sub_sub_div').hide();
                }
            });
        });
        /* Level 3 */
        $('#event_country_cities').on('change', function ()
        {
            $('#sb_loading').show();
            $.post(adforest_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country_cities").val(), }).done(function (response)
            {
                $('#sb_loading').hide();
                $("#event_country_towns").val('');
                if ($.trim(response) != "")
                {
                    $('#event_country_id').val($("#event_country_cities").val());
                    $('#event_country_sub_sub_sub_div').show();
                    $('#event_country_towns').html(response);
                } else
                {
                    $('#event_country_sub_sub_sub_div').hide();
                }
            });
        });
    }
    
    
       $('#sb_sort_event_images').on('click', function ()
    {
        $('#sb_loading').show();
        $.post(adforest_ajax_url, {action: 'sb_sort_event_images', ids: $('#post_img_ids').val(), ad_id: $('#current_pid').val(), }).done(function (response)
        {
            toastr.success($('#re-arrange-msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            location.reload();
            $('#sb_loading').hide();
        });
    });
    
    $('.adv-srch').on('click', function ()
    {
        $(this).hide();
        $('.hide_adv_search').show();
    });

    if ($('.custom-select2').length > 0) {
         $('.custom-select2').select2('destroy');
    }
    
}(jQuery));