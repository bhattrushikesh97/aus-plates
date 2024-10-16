<?php
/* ------------------------------------------------ */
/* Sign In */
/* ------------------------------------------------ */
if (!function_exists('login_short')) {

    function login_short() {
        vc_map(array(
            "name" => __("Sign In", 'adforest'),
            "base" => "login_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                
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

add_action('vc_before_init', 'login_short');
if (!function_exists('login_short_base_func')) {

    function login_short_base_func($atts, $content = '') {
        
         extract(shortcode_atts(array(        
            'section_title' => '',
            'bg_img' => '',
            'section_title' => '',
            'description' => '',
            'section_title_2' => '',
            'description_2' => '',
            'main_link'=>'',
                        ), $atts));
        extract($atts);

        if (!adforest_vc_forntend_edit() && !is_admin()) {
            adforest_user_logged_in();
        }
        
        
          if (isset($adforest_elementor) && $adforest_elementor) {
       $sec_img   = isset($atts['bg_img']['url']) ? $atts['bg_img']['url'] : '#';
          }
          
          else{
              $sec_img   =  isset($atts['bg_img']) ? adforest_returnImgSrc($atts['bg_img']) : '#';
          }
        extract($atts);  
        
        
        global $adforest_theme;
        $sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);

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

         if (isset($adforest_elementor) && $adforest_elementor) {
                                $btn_args = array(
                                    'btn_key' =>  $button_link,
                                    'adforest_elementor' => true,
                                    'btn_class' => 'btn btn-theme',
                                    'iconBefore' => '',
                                    'iconAfter' => '',
                                    'onlyAttr' => false,
                                    'titleText' => $button_title,
                                );
                                $link_attr = apply_filters('adforest_elementor_url_field', "", $btn_args);
         }
         else {
             
                $link_attr = adforest_ThemeBtn($main_link, 'btn btn-theme', false);
         }
                                
                                
                                
                                

        global $adforest_theme;
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
             </a>

            

             </li>';
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
         
      
        $sb_login_with_phone = isset($adforest_theme['sb_register_with_phone']) ? $adforest_theme['sb_register_with_phone'] : false;
        $default_login_form   =     isset($adforest_theme['sb_default_registration_form']) ? $adforest_theme['sb_default_registration_form']   : "email";
        $login_with_phone_button   =  "";
       
        if(isset($_GET['log_type']) && $_GET['log_type'] != "") {              
              $default_login_form    =  $_GET['log_type'];
              
          }                          
          if($default_login_form   ==  "email" && $sb_register_with_phone){    
           $redirect_url    =      get_the_permalink()."?log_type=phone"    ;
           $login_with_phone_button   =  '<a class="btn btn-theme btn-lg btn-block"  href="'.$redirect_url.'">'.esc_html__('Login with Phone Number','adforest').'</a>';
          }
          else if($default_login_form   ==  "phone" && $sb_login_with_phone){
           $redirect_url    =      get_the_permalink()."?log_type=email"    ;
           $login_with_phone_button   =  '<a class="btn btn-theme btn-lg btn-block login-email-button"  href="'.$redirect_url.'">'.esc_html__('Login with Email','adforest').'</a>';
          }
  
        $if_social_login_enable = '';
        if ($social_login != "" || $sb_login_with_phone) {
            $if_social_login_enable = '<div class="option-social">
                                                 <span>'.esc_html__('or','adforest').'</span>
                                       </div>';
        }
    echo
       '<section class="register-section-content">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="main-section-content">                   
                    <div class="row">
                        <div class="col-xl-7 col-xxl-7 col-lg-6 col-md-6 col-sm-12">

                            <div class="wel-register-heading">
                                <h1>'.$section_title_2.'</h1>
                                <p>'.$description_2.'</p>
                                 '.$link_attr.'

                                <div class="container">
                                    <div id="register-user-img" class="register-user">
                                        <img src="'.$sec_img.'" alt="'.esc_attr__('image','adforest').'">
                                    </div>
                                </div>

                            </div>

                        </div>
                         <div class="col-xl-5 col-xxl-5 col-lg-6 col-md-6 col-sm-12">
                         <div class="sign-in-account">
                         <h3>'.$section_title.'</h3>
                         <p>'.$description.'</p>
                        ' . $authentication->adforest_sign_in_form($code,$default_login_form) . '
                         '.$if_social_login_enable.'
                             '.$login_with_phone_button.'
                         <div class="social-list">
                           <ul class="social-item">
                          '.$social_login.'
                              </ul>
                          </div>
                          <div class="register-account-here">
                            <p class="text-center"><span>'.esc_html__("Don't have account ? ","adforest").'</span><a href="' . get_the_permalink($sb_sign_up_page) . '">' . __('Sign up Now', 'adforest') . '</a></p>
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
                <input type ="hidden" value= "'.$ajax_url.'" id="ajax_url">
          <input type="hidden" id="verification-notice" value="'.esc_html__('Verification code has been sent to ', 'adforest').'" />
              <input type="hidden" id="profile_page" value="'.esc_url($after_login_redirect).'" />
        </div>
    </div>
            </section>
            ';

    }
}
if (function_exists('adforest_add_code')) {
    adforest_add_code('login_short_base', 'login_short_base_func');
}

/*
 * load modal in footer
 */

$authentication = new authentication();

$popup_args = array(
    'adforest_forgot_form' => $authentication->adforest_forgot_password_form(),
);

add_action('wp_footer', function () use ($popup_args) {

    extract(shortcode_atts(array(
        'adforest_forgot_form' => '',
                    ), $popup_args));
    if (!is_user_logged_in()) {
        ?>
        <div class="custom-modal">
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="pass-modal-title"><?php echo __('Forgot Your Password ?', 'adforest') ?></div>
                        </div>
                        <?php echo adforest_returnEcho($adforest_forgot_form); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}, 10, 1);
