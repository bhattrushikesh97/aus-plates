(function ($) {
    
    if ($('#sb-verify-phone-firebase').length > 0) {
        projectID = $('#sb-fb-projectid').val();
        appID = $('#sb-fb-appid').val();
        senderID = $('#sb-fb-senderid').val();
        apiKey = $('#sb-fb-apikey').val();

        var firebaseConfig = {
            apiKey: apiKey,
            projectId: projectID,
            messagingSenderId: senderID,
            appId: appID
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();
        firebase.auth().languageCode = document.documentElement.lang;
        var loginphone = $('#sb-verify-phone-firebase');
        if (loginphone.length > 0) {
            var otpNum = $("#user-otp-num").val();
            loginphone.on('click', function () {
                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha', {
                    'size': 'normal',
                    'callback': function (response) {
                        // reCAPTCHA solved, allow signInWithPhoneNumber.
                        // ...
                    },
                    'expired-callback': function () {
                        // Response expired. Ask user to solve reCAPTCHA aga
                        // ...
                    }
                });
                var cverify = window.recaptchaVerifier;
                firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (response) {
                    $('#verification_modal').modal('show');
                    var notice = $('#verification-notice').val() + " " + otpNum;
                    toastr.success(notice, '', {
                        timeOut: 3000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });

                    window.confirmationResult = response;
                }).catch(function (error) {

                    toastr.error(error['code'], error['message'], {timeOut: 2000, "closeButton": true, "positionClass": "toast-top-right"});
                })
            });
            /*  verifying otp  */
            $('#sb_verify_otp').on('click', function () {
                var otp = $('#sb_ph_number_code').val();
                $(this).hide();
                $("#sb_verification_ph_back").show();
                confirmationResult.confirm(otp).then(function (response) {
                    var userobj = response.user;
                    var phoneNum = userobj.phoneNumber;
                    var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                    $.post(adforest_ajax_url, {action: 'sb_verify_firebase_otp', phone_number: phoneNum}).done(function (response) {

                        $("#sb_verification_ph_back").hide();
                        $('#sb_verify_otp').show();
                        if (response['success'] == true) {
                            toastr.success(response['data']['message'], '', {
                                timeOut: 2000,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.error(response['data']['message'], "", {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                        window.location.reload();
                    });
                }).catch((error) => {
                    toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                })
            });
        }
    }
  
  
if($('#sb-pre-code').length > 0 && $('#sb-pre-code').val() == 1){  
     $.getJSON("https://extreme-ip-lookup.com/json/", function(data) {
         
         console.log(data);
         if(typeof data.country !== 'undefined'){   
              $.getJSON("https://restcountries.eu/rest/v2/name/"+data.country, function(datas) {        
                if(data.country  ==  "India"){
             $("#sb_reg_email").val("+91");
             }          
            else if(typeof datas[0].callingCodes[0] !== undefined){                              
                   $("#sb_reg_email").val("+" + datas[0].callingCodes[0]);
               }
        });
         }             
    })
}  
    function ValidateEmail(mail) 
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
  {
    return (true)
  }
   
    return (false)
}


 if ($('#sb-sign-multi-form').length > 0) {  
     
        $('#sb-sign-multi-form').on('submit', function (e) {
            e.preventDefault();          
             var form = $(this);
            form.parsley().validate();
            var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
          if (form.parsley().isValid()){               
               $('#sb_loading').show();
               $('#sb_register_msg').show();              
                $('#sb_register_submit').hide();                     
              var email_val   =  $("#sb_reg_email").val();                                                     
            if(email_val.includes("+")){    
            $.post(adforest_ajax_url, {action: 'sb_register_check_user', form_data:$("#sb-sign-multi-form").serialize()}).done(function (response) {                      
                 $('#sb_loading').hide();
                 $('#sb_register_msg').hide();
                if (response['success'] == true) {                   
                   $('#sb_register_submit').hide();
                    projectID = $('#sb-fb-projectid').val();
                    appID = $('#sb-fb-appid').val();
                    senderID = $('#sb-fb-senderid').val();
                    apiKey = $('#sb-fb-apikey').val();
                    var firebaseConfig2 = {
                        apiKey: apiKey,
                        projectId: projectID,
                        messagingSenderId: senderID,
                        appId: appID
                    };
                    // Initialize Firebase

                    !firebase.apps.length ? firebase.initializeApp(firebaseConfig2) : firebase.app()
                    firebase.analytics();
                   firebase.auth().languageCode = document.documentElement.lang;

                    var otpNum = $("#sb_reg_email").val();
                    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha', {
                        'size': 'normal',
                        'callback': function (response) {
                            // reCAPTCHA solved, allow signInWithPhoneNumber.
                            // ...
                        },
                        'expired-callback': function () {
                            // Response expired. Ask user to solve reCAPTCHA aga
                            // ...
                        }
                    });                                     
                      toastr.success($('#verify_recaptcha').val(), '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });  

                    var cverify = window.recaptchaVerifier;
                    firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (response) {
                        $('#verification_modal').modal('show');
                        var notice = $('#verification-notice').val() + " " + otpNum;
                        toastr.success(notice, '', {
                            timeOut: 3000,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        window.confirmationResult = response;
                    }).catch(function (error) {                     
                        toastr.error(error['code'], error['message'], {timeOut: 2000, "closeButton": true, "positionClass": "toast-top-right"});
                    })
                    
                    
                        /* Resend code to user number  */
                    $('#sb_verification_resend').on('click',function(){   
                          $('#firebase-recaptcha2').show();
                           window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha2', {
                        'size': 'normal',
                        'callback': function (response) {
                            // reCAPTCHA solved, allow signInWithPhoneNumber.
                            // ...
                        },
                        'expired-callback': function () {
                            // Response expired. Ask user to solve reCAPTCHA aga
                            // ...
                        }
                    });                                     
                      toastr.success($('#verify_recaptcha').val(), '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });           
                    var cverify = window.recaptchaVerifier;                                                          
                        firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (response) {  
                        var notice = $('#verification-notice').val() + " " + otpNum;
                        
                        $('#firebase-recaptcha2').hide();
                        
                        toastr.success(notice, '', {
                            timeOut: 3000,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        window.confirmationResult = response;
                    }).catch(function (error) {                                                     
                        toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                    })                 
                     
                    });
                    
                    /*  verifying otp  */
                    $('#sb_verify_otp').on('click', function () {
                        var otp = $('#sb_ph_number_code').val();
                        $(this).hide();
                        $("#sb_verification_ph_back").show();
                        confirmationResult.confirm(otp).then(function (response) {
                            var userobj = response.user;
                            var phoneNum = userobj.phoneNumber;
                            var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                            var form_data = $("#sb-sign-multi-form").serialize();
                            $.post(adforest_ajax_url, {action: 'sb_register_user_with_otp', phone_number: phoneNum, form_data: form_data}).done(function (response) {
                                $("#sb_verification_ph_back").hide();
                                $('#sb_verify_otp').show();
                                if (response['success'] == true) {

                                    $("#sb_verification_ph_back").hide();
                                    $('#sb_verify_otp').show();
                                    toastr.success(response['data']['message'], '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });
                                    
                                  window.location   =   $('#profile_page').val();
                                } else {
                                    $("#sb_verification_ph_back").hide();
                                    $('#sb_verify_otp').show();
                                    toastr.error(response['data']['message'], "", {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                               
                            });
                        }).catch((error) => {
                            
                             $("#sb_verification_ph_back").hide();
                             $('#sb_verify_otp').show();
                            toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                        })
                    });
                } else {   
                      $('#sb_register_submit').show();
                    toastr.error(response['data']['message'], "", {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                }           
            });
              }         
              else{
                   $('#sb_loading').hide();
               $('#sb_register_msg').hide();              
                $('#sb_register_submit').show();
                   toastr.error($('#invalid_phone').val(), "", {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});                               
              }
       
        }
        })
    }  
 /*Login multiple form*/
     if ($('#sb-login-multi-form').length > 0) {  
         
         $('#sb_login_submit').prop('disabled', true);
         
         var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{8,15})$/;
        $("#sb_reg_email").bind("change input keyup", function () {           
            if(($(this).val().match(phoneno)))
         {                    
               $('#sb_login_submit').prop('disabled', false);
          }
          else{
             $('#sb_login_submit').prop('disabled', true);
          }
        });
        $('#sb-login-multi-form').on('submit', function (e) {           
            e.preventDefault();          
             var form = $(this);
            form.parsley().validate();
            var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
          if (form.parsley().isValid()){              
                $('#sb_loading').show();
                $('#sb_login_submit').hide();
                $('#sb_login_msg').show();          
              var email_val   =  $("#sb_reg_email").val();             
            
    
             
           if(email_val.includes("+")){                    
            $.post(adforest_ajax_url, {action: 'sb_login_check_user', form_data:$("#sb-login-multi-form").serialize()}).done(function (response) {                                   
               
                  $('#sb_loading').hide();
                $('#sb_login_submit').hide();
                $('#sb_login_msg').hide();                
                if (response['success'] == true) {                                        
                    userID  =    response['data']['user_id'];
                    secureToken    =   response['data']['secure_token'];    
                    projectID = $('#sb-fb-projectid').val();
                    appID = $('#sb-fb-appid').val();
                    senderID = $('#sb-fb-senderid').val();
                    apiKey = $('#sb-fb-apikey').val();
                    var firebaseConfig2 = {
                        apiKey: apiKey,
                        projectId: projectID,
                        messagingSenderId: senderID,
                        appId: appID
                    };
                    // Initialize Firebase
                    !firebase.apps.length ? firebase.initializeApp(firebaseConfig2) : firebase.app()

                    firebase.analytics();
                    firebase.auth().languageCode = document.documentElement.lang;
                    var otpNum = $("#sb_reg_email").val();
                    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha', {
                        'size': 'normal',
                        'callback': function (response) {
                            // reCAPTCHA solved, allow signInWithPhoneNumber.
                            // ...
                        },
                        'expired-callback': function () {
                            // Response expired. Ask user to solve reCAPTCHA aga
                            // ...
                        }
                    });                                     
                      toastr.success($('#verify_recaptcha').val(), '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });           
                    var cverify = window.recaptchaVerifier;
                    
                    console.log(cverify);
                    
                     !firebase.apps.length ? firebase.initializeApp(firebaseConfig2) : firebase.app()
                    
                    firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (response) {
                        $('#verification_modal').modal('show');
                        var notice = $('#verification-notice').val() + " " + otpNum;
                        toastr.success(notice, '', {
                            timeOut: 4000,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        window.confirmationResult = response;
                    }).catch(function (error) {
                        
                        toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                    })
                    /*Resend otp */
                      /* Resend code to user number  */
                    $('#sb_verification_resend').on('click',function(){       
                        
                        $('#firebase-recaptcha2').show();
                           window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha2', {
                        'size': 'normal',
                        'callback': function (response) {
                            // reCAPTCHA solved, allow signInWithPhoneNumber.
                            // ...
                        },
                        'expired-callback': function () {
                            // Response expired. Ask user to solve reCAPTCHA aga
                            // ...
                        }
                    });                                     
                      toastr.success($('#verify_recaptcha').val(), '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });           
                    var cverify = window.recaptchaVerifier;                                                          
                        firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (response) {  
                             $('#firebase-recaptcha2').hide();
                        var notice = $('#verification-notice').val() + " " + otpNum;
                        toastr.success(notice, '', {
                            timeOut: 3000,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        window.confirmationResult = response;
                    }).catch(function (error) {                                                     
                        toastr.error(error['code'], error['message'], {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    })                                    
                    });
                    /*  verifying otp  */
                    $('#sb_verify_otp').on('click', function () {
                        var otp = $('#sb_ph_number_code').val();
                        $(this).hide();
                        $("#sb_verification_ph_back").show();
                        confirmationResult.confirm(otp).then(function (response) {
                            var userobj = response.user;
                            var phoneNum = userobj.phoneNumber;
                            var adforest_ajax_url = jQuery("#adforest_ajax_url").val();
                            var form_data = $("#sb-login-multi-form").serialize();
                            $.post(adforest_ajax_url, {action: 'sb_login_user_with_otp', phone_number: phoneNum, form_data: form_data ,user_id:userID , token:secureToken}).done(function (response) {
                                $("#sb_verification_ph_back").hide();
                                $('#sb_verify_otp').show();
                                if (response['success'] == true) {

                                    $("#sb_verification_ph_back").hide();
                                    $('#sb_verify_otp').show();
                                    toastr.success(response['data']['message'], '', {
                                        timeOut: 3000,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });
                                    
                                  window.location   =   $('#profile_page').val();
                                } else {
                                    $("#sb_verification_ph_back").hide();
                                    $('#sb_verify_otp').show();
                                    toastr.error(response['data']['message'], "", {timeOut: 2000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                               
                            });
                        }).catch((error) => {
                            
                             $("#sb_verification_ph_back").hide();
                             $('#sb_verify_otp').show();
                            toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                        })
                    });
                } else {   
                      $('#sb_register_submit').show();
                    toastr.error(response['data']['message'], "", {timeOut: 2000, "closeButton": true, "positionClass": "toast-top-right"});
                }           
            });  
                }
                
                else{    
                     $('#sb_loading').hide();
                $('#sb_login_submit').show();
                $('#sb_login_msg').hide();  
                     toastr.error($('#invalid_phone').val(), "", {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});               
                }
       
        }
        });
    }
}(jQuery));