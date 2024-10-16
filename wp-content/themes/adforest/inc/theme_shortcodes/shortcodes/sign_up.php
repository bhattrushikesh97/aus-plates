<?php

/* ------------------------------------------------ */
/* Services */
/* ------------------------------------------------ */
if (!function_exists('register_short')) {

    function register_short() {
        vc_map(array(
            "name" => __("Sign Up", 'adforest'),
            "base" => "register_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                adforest_generate_type(__('Terms & Conditions', 'adforest'), 'vc_link', 'terms_link'),
                adforest_generate_type(__('Terms & Condition Title', 'adforest'), 'textfield', 'terms_title'),
                adforest_generate_type(__('Capcha Code', 'adforest'), 'dropdown', 'is_captcha', __("Captcha is for stop spamming", 'adforest'), "", array("Please select" => "", "With Capcha" => "with", "Without Capcha" => "without")),
                // Making add more loop
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Section 2", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_2",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Section 2", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "description_2",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Section 2", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Section image", 'adforest'),
                    "param_name" => "bg_img",
                ),
                // Making add more loop
                array(
                    "group" => __("Section 2", "adforest"),
                    "type" => "vc_link",
                    "heading" => __("View All Link", 'adforest'),
                    "param_name" => "main_link",
                    "description" => __("view all button link.", "adforest"),
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'register_short');
if (!function_exists('register_short_base_func')) {

    function register_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'section_title' => '',
            'description' => '',
            'section_title_2' => '',
            'description_2' => '',
            'terms_link' => '',
            'terms_title' => '',
            'section_title' => '',
            'is_captcha' => '',
            'bg_img' => '',
            'description_2' => '',
            'main_link' => ''
                        ), $atts));
        extract($atts);

        if (!adforest_vc_forntend_edit() && !is_admin()) {
            adforest_user_logged_in();
        }


        global $adforest_theme;
             if (isset($adforest_elementor) && $adforest_elementor) {
       $sec_img   = isset($atts['bg_img']['url']) ? $atts['bg_img']['url'] : '#';
          }
          
          else{
              $sec_img   =  isset($atts['bg_img']) ? adforest_returnImgSrc($atts['bg_img']) : '#';
          }
        wp_enqueue_script('recaptcha');

        $sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
        $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
        // Making features

        if (isset($adforest_elementor) && $adforest_elementor) {
            $link_attr = '';
            $btn_args = array(
                'btn_key' => $button_link,
                'adforest_elementor' => true,
                'btn_class' => 'btn btn-theme',
                'iconBefore' => '',
                'iconAfter' => '',
                'onlyAttr' => false,
                'titleText' => $button_title,
            );
            $link_attr = apply_filters('adforest_elementor_url_field', "", $btn_args);
        } else {

            $link_attr = adforest_ThemeBtn($main_link, 'btn btn-theme', false);
        }



        $social_login = '';
        $social_linked = (isset($social_linked) && $social_linked != "") ? $social_linked : __("Signin With LinkedIn", "adforest");
        $linkedin_api_key = '';
        if ((isset($adforest_theme['adforest_linkedin_api_key'])) && $adforest_theme['adforest_linkedin_api_key'] != '' && (isset($adforest_theme['adforest_linkedin_api_secret'])) && $adforest_theme['adforest_linkedin_api_secret'] != '' && (isset($adforest_theme['adforest_redirect_uri'])) && $adforest_theme['adforest_redirect_uri'] != '') {
            $linkedin_api_key = ($adforest_theme['adforest_linkedin_api_key']);
            $linkedin_secret_key = ($adforest_theme['adforest_linkedin_api_secret']);
            $redirect_uri = ($adforest_theme['adforest_redirect_uri']);
            $linkedin_url = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . $linkedin_api_key . '&redirect_uri=' . $redirect_uri . '&state=popup&scope=r_liteprofile r_emailaddress';
            $social_login .= '<li>
   <a href="' . esc_url($linkedin_url) . '" class="btn-social btn-linkedIn socials-links-items">
    <img src="' . get_template_directory_uri() . '/images/linkedin.png"  alt="' . esc_html__('facebook logo', 'adforest') . '" />
    </a></li>';
        }

        if ($adforest_theme['fb_api_key'] != "") {
            $social_login .= '<li><a class="btn socials-links-items btn-social btn-facebook" onclick="hello(\'facebook\').login(' . "{
                                    scope : 'email',
                                    }" . ')">
                          <img src="' . get_template_directory_uri() . '/images/fb.png"  alt="' . esc_html__('facebook logo', 'adforest') . '" />
                          </a></li>';
        }
        if ($adforest_theme['gmail_api_key'] != "") {
            $social_login .= '<li><a class="btn socials-links-items btn-social btn-google" onclick="hello(\'google\').login(' . "{scope : 'email'}" . ')">
                                <img src="' . get_template_directory_uri() . '/images/btn_google.png"  alt="' . esc_html__('google logo', 'adforest') . '" />
                              </a></li>';
        }


        if ($social_login != '') {
            $social_login .= '<input type="hidden" id="sb-social-login-nonce" value="' . wp_create_nonce('sb_social_login_nonce') . '" />';
        }

        $authentication = new \authentication();
        $code = time();
        $_SESSION['sb_nonce'] = $code;

        $ajax_url = apply_filters('adforest_set_query_param', admin_url('admin-ajax.php'));
        $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
        $after_login_redirect = get_the_permalink($sb_profile_page);
        if (isset($_GET['u']) && $_GET['u'] != "") {
            $after_login_redirect = $_GET['u'];
        }

        $authentication = new \authentication();
        $code = time();
        $_SESSION['sb_nonce'] = $code;

        $ajax_url = apply_filters('adforest_set_query_param', admin_url('admin-ajax.php'));
        $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
        $after_login_redirect = get_the_permalink($sb_profile_page);
        if (isset($_GET['u']) && $_GET['u'] != "") {
            $after_login_redirect = $_GET['u'];
        }

        $is_captcha = isset($is_captcha) && $is_captcha != '' ? $is_captcha : 'without';

        $sb_register_with_phone = isset($adforest_theme['sb_register_with_phone']) ? $adforest_theme['sb_register_with_phone'] : false;
        $app_key = $app_id = $sender_id = $project_id = "";

        if ($sb_register_with_phone) {

            wp_enqueue_script('firebase-app', "https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js", false, false, true);
            wp_enqueue_script('firebase-analytics', "https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js", false, false, true);
            wp_enqueue_script('firebase-auth', "https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js", false, false, true);

            wp_enqueue_script('firebase-custom', trailingslashit(get_template_directory_uri()) . 'assests/js/firebase-custom.js', array(), false, true);

            $app_key = isset($adforest_theme['sb_firebase_apikey']) && $adforest_theme['sb_firebase_apikey'] != "" ? $adforest_theme['sb_firebase_apikey'] : "";
            $project_id = isset($adforest_theme['sb_firebase_projectId']) && $adforest_theme['sb_firebase_projectId'] != "" ? $adforest_theme['sb_firebase_projectId'] : "";
            $sender_id = isset($adforest_theme['sb_firebase_messagingSenderId']) && $adforest_theme['sb_firebase_messagingSenderId'] != "" ? $adforest_theme['sb_firebase_messagingSenderId'] : "";
            $app_id = isset($adforest_theme['sb_firebase_appId']) && $adforest_theme['sb_firebase_appId'] != "" ? $adforest_theme['sb_firebase_appId'] : "";
        }

        $admin_contact_url = isset($adforest_theme['admin_contact_page']) ? get_the_permalink($adforest_theme['admin_contact_page']) : "#";
        $class_hidden = 'style="display:none;"';
        $resend_alert = '  	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 resend_email" ' . $class_hidden . '>
          	<div role="alert" class="alert alert-info alert-dismissible ">
          	<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
          	' . __('Did not get an email?', 'adforest') . '<a href="javascript:void(0)" id="resend_email"> ' . __('Resend now.', 'adforest') . '</a>
          	</div>
          	</div>

          	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 contact_admin" ' . $class_hidden . '>
          	<div role="alert" class="alert alert-info alert-dismissible"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>' . __('Still not get the email? ', 'adforest') . '<a href="' . trailingslashit(esc_url($admin_contact_url)) . '"  id="resend_email"> ' . __('Contact to admin.', 'adforest') . '</a></div>
          	</div>';

        $sb_register_with_phone = isset($adforest_theme['sb_register_with_phone']) ? $adforest_theme['sb_register_with_phone'] : false;
        $default_registration_form = isset($adforest_theme['sb_default_registration_form']) ? $adforest_theme['sb_default_registration_form'] : "email";
        $register_with_phone_button = "";

        if (isset($_GET['reg_type']) && $_GET['reg_type'] != "") {
            $default_registration_form = $_GET['reg_type'];
        }

        if ($default_registration_form == "email" && $sb_register_with_phone) {
            $redirect_url = get_the_permalink() . "?reg_type=phone";
            $register_with_phone_button = '<a class="btn btn-theme btn-lg btn-block"  href="' . $redirect_url . '">' . esc_html__('Register with Phone Number', 'adforest') . '</a>';
        } else if ($default_registration_form == "phone" && $sb_register_with_phone) {
            $redirect_url = get_the_permalink() . "?reg_type=email";
            $register_with_phone_button = '<a class="btn btn-theme btn-lg btn-block"  href="' . $redirect_url . '">' . esc_html__('Register with Email', 'adforest') . '</a>';
        }


        $if_social_login_enable = '';
        if ($social_login != "" || $sb_register_with_phone) {
            $if_social_login_enable = '<div class="option-social">
                                                 <span>' . esc_html__('or', 'adforest') . '</span>
                                       </div>';
        }


        $adforest_elementor   =   isset($adforest_elementor)   ?  $adforest_elementor  : false;
        
        
   return 
        '<section class="register-section-content">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="main-section-content">                   
                    <div class="row">
                        <div class="col-xl-7 col-xxl-7 col-lg-6 col-md-6 col-sm-12">
                            <div class="wel-register-heading">
                                <h1>' . $section_title_2 . '</h1>
                                <p>' . $description_2 . '</p>
                                 ' . $link_attr . '

                                <div class="container">
                                    <div id="register-user-img" class="register-user">
                                        <img src="' . $sec_img . '" alt="' . esc_attr__('image', 'adforest') . '">
                                    </div>
                                </div>

                            </div>

                        </div>
                         <div class="col-xl-5 col-xxl-5 col-lg-6 col-md-6 col-sm-12">
                         <div class="sign-in-account">
                         
                          ' . $resend_alert . '
                         <h3>' . $section_title . '</h3>
                         <p>' . $description . '</p>
                        ' . $authentication->adforest_sign_up_form($terms_link, $terms_title, $adforest_theme['google_api_key'], $is_captcha, $code, $adforest_elementor, $default_registration_form) . '
                         ' . $if_social_login_enable . '
                             ' . $register_with_phone_button . '
                         <div class="social-list">
                           <ul class="social-item">
                          ' . $social_login . '
                              </ul>
                          </div>
                          <div class="register-account-here">
                           <p class="text-center"><span>' . esc_html__("Already Registered? ", "adforest") . '</span><a href="' . get_the_permalink($sb_sign_in_page) . '">' . __('Login here.', 'adforest') . '</a>
                        
                          </div>
                            
                         </div>
                          </div>

                    </div>
               
                </div>
            </div>
            <input type="hidden"   id="sb-fb-apikey" value= "' . $app_key . '"> 
            <input type="hidden"   id="sb-fb-projectid"   value= "' . $project_id . '"> 
            <input type="hidden"   id="sb-fb-senderid"   value= "' . $sender_id . '"> 
            <input type="hidden"   id="sb-fb-appid"    value= "' . $app_id . '">  
                <input type ="hidden" value= "' . $ajax_url . '" id="ajax_url">
          <input type="hidden" id="verification-notice" value="' . esc_html__('Verification code has been sent to ', 'adforest') . '" />
              <input type="hidden" id="profile_page" value="' . esc_url($after_login_redirect) . '" />
        </div>
    </div>
            </section>
            ';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('register_short_base', 'register_short_base_func');
}    