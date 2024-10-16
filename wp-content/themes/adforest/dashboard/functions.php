<?php
add_action('wp_ajax_sb_fav_remove_ad', 'adforest_sb_fav_remove_ad');
if (!function_exists('adforest_sb_fav_remove_ad')) {

    function adforest_sb_fav_remove_ad() {
        adforest_authenticate_check();

        $ad_id = $_POST['ad_id'];


        if (delete_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id)) {
            echo '1|' . __("Ad removed successfully.", 'adforest');
        } else {
            echo '0|' . __("There'is some problem, please try again later.", 'adforest');
        }
        die();
    }

}

add_action('wp_ajax_sb_change_password', 'adforest_change_password');
if (!function_exists('adforest_change_password')) {

    function adforest_change_password() {
        adforest_authenticate_check();
        global $adforest_theme;
        // Getting values

    $is_demo = ( isset($adforest_theme['is_demo']) ) ? $adforest_theme['is_demo'] : false;
        
          if($is_demo){
            echo '0|' . __("Not allowed in demo mode", 'adforest');
                die();
        }


        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_profile_reset_pass_secure', 'security');
        $current_pass = $params['current_pass'];
        $new_pass = $params['new_pass'];
        $con_new_pass = $params['con_new_pass'];
        if ($current_pass == "" || $new_pass == "" || $con_new_pass == "") {
            echo '0|' . __("All fields are required.", 'adforest');
            die();
        }
        if ($new_pass != $con_new_pass) {
            echo '0|' . __("New password not matched.", 'adforest');
            die();
        }
        $user = get_user_by('ID', get_current_user_id());
        if ($user && wp_check_password($current_pass, $user->data->user_pass, $user->ID)) {
            wp_set_password($new_pass, $user->ID);
            echo '1|' . __("Password changed successfully.", 'adforest');
        } else {
            echo '0|' . __("Current password not matched.", 'adforest');
        }

        die();
    }

}
add_action('wp_ajax_sb_get_ad_package_info', 'sb_get_ad_package_info_callback');

if (!function_exists('sb_get_ad_package_info_callback')) {
function sb_get_ad_package_info_callback() {
  
    global $adforest_theme;
    $aid    =   isset($_POST['ad_id'])     ?  $_POST['ad_id']  : "";
    $expiry_days = '-1';
    $package_ad_expiry_days = get_post_meta($aid, 'package_ad_expiry_days', true);
    
    $ad_status   =   get_post_meta($aid, '_adforest_ad_status_', true);
    
    if(get_post_field('post_author', $aid) != get_current_user_id()){
        
        echo esc_html__('Only ad author can view these details', 'adforest');   
        die();
    }
    
       if('expired' ==  $ad_status){ 
        echo esc_html__('This ad is expired', 'adforest');   
        die();
       }
    
       if (isset($package_ad_expiry_days) && $package_ad_expiry_days != '') {
           $expiry_days = $package_ad_expiry_days;
        } else if (isset($adforest_theme['simple_ad_removal']) && $adforest_theme['simple_ad_removal'] != '') {
            $expiry_days = $adforest_theme['simple_ad_removal'];
        } else {
       
        }
        
        $posted_date = (get_the_date('Y-m-d',$aid)); 
        
        $expiry_date   =  "";
        if($expiry_days ==  "-1"){       
            $expiry_date  =  esc_html__('Unlimited days','adforest');
        }
        else  {         
            $now = time(); // or your date as well          
            $expiry_date  =  date('Y-m-d', strtotime($posted_date. ' + '.$expiry_days.' days'));                   
        }
          
        /*feature expiry */
        $featured_expiry_days = '-1';
        $package_adFeatured_expiry_days = get_post_meta($aid, 'package_adFeatured_expiry_days', true);
        if (isset($package_adFeatured_expiry_days) && $package_adFeatured_expiry_days != '') {
            $featured_expiry_days = $package_adFeatured_expiry_days;
        } else if (isset($adforest_theme['featured_expiry']) && $adforest_theme['featured_expiry'] != '') {
            $featured_expiry_days = $adforest_theme['featured_expiry'];
        }
              
         $featured_date          =  "" ;
         $feature_expiry_date    =  "";
         if(get_post_meta($aid, '_adforest_is_feature', true) == '1'){
          $featured_date   =    get_post_meta($aid, '_adforest_is_feature_date', true);
      
         if (get_post_meta($aid, '_adforest_is_feature', true) == '1' && $featured_expiry_days == '-1') {            
             $feature_expiry_date   =   esc_html__('Unlimited days','adforest');
         }
         else if(get_post_meta($aid, '_adforest_is_feature', true) == '1' && $featured_expiry_days != '-1'){           
             $feature_expiry_date  =   date('Y-m-d', strtotime($featured_date. ' + '.$featured_expiry_days.' days'));   
         }         
       }
       
       else  {
           $featured_date         =  esc_html__('Not featured ad','adforest');
           $feature_expiry_date   =  esc_html__('Not featured ad','adforest');
                
       }
         
         
         
      $response   =  '<ul>
                        <li>
                            <lable> '.esc_html__('Posted date  :' ,'adforest').' </lable>
                            <span>'.$posted_date.' </span>               
                        </li>
                        <li>
                           <lable> '.esc_html__('Expiry date  :','adforest').' </lable>
                            <span>'.$expiry_date.' </span>             
                        </li>
                       <li>
                           <lable> '.esc_html__('Featured date  :','adforest').' </lable>
                           <span>'.$featured_date.' </span>             
                       </li>
                       <li>
                           <lable> '.esc_html__('Featured expiry date:','adforest').' </lable>
                           <span>'.$feature_expiry_date.' </span>             
                       </li>
                    </ul>';          
      echo adforest_returnEcho($response);   
      wp_die();
 }
}


add_action('wp_ajax_sb_verification_system', 'adforest_verification_system');
if (!function_exists('adforest_verification_system')) {

    function adforest_verification_system() {
        global $adforest_theme;
        $ph = sanitize_text_field($_POST['sb_phone_numer']);
        if (!preg_match("/\+[0-9]+$/", $ph)) {
            echo '0|' . __('Please update valid phone number +CountrycodePhonenumber in profile.', 'adforest');
            die();
        }

        $user_id = get_current_user_id();

        if (isset($adforest_theme['sb_resend_code']) && $adforest_theme['sb_resend_code'] != "" && get_user_meta($user_id, '_ph_code_', true) != "") {
            $timeFirst = strtotime(get_user_meta($user_id, '_ph_code_date_', true));
            $timeSecond = strtotime(date('Y-m-d H:i:s'));
            $differenceInSeconds = $timeSecond - $timeFirst;
            $adforest_theme['sb_resend_code'] . "<" . $differenceInSeconds;
            if ($adforest_theme['sb_resend_code'] > $differenceInSeconds) {
                $after_seconds = $adforest_theme['sb_resend_code'] - $differenceInSeconds;
                echo '0|' . __("You can't resend the verification code before", 'adforest') . " " . $after_seconds . '-' . __("seconds.", 'adforest');
                die();
            }
        }

        $code = mt_rand(100000, 500000);
        $res = adforest_send_sms($ph, $code);

        $gateway = adforest_verify_sms_gateway();
        $sms_sent = false;
        if ($gateway == "iletimerkezi-sms" && $res == true) {
            $sms_sent = true;
        }
        if ($gateway == "twilio" && $res->sid) {
            $sms_sent = true;
        }

        if ($sms_sent) {
            //if( true )
            update_user_meta($user_id, '_ph_code_', $code);
            update_user_meta($user_id, '_sb_is_ph_verified', '0');
            update_user_meta($user_id, '_ph_code_date_', date('Y-m-d H:i:s'));
            echo '1|' . __("Verification code has been sent.", 'adforest');
        } else {
            echo '0|' . __("Server not responding.", 'adforest');
            update_user_meta($user_id, '_sb_is_ph_verified', '0');
        }
        die();
    }

}

if (!function_exists('adforest_send_sms')) {

    function adforest_send_sms($receiver_ph, $code) {
        global $adforest_theme;
        $message = __('Your verification code is', 'adforest') . " " . $code;
        $gateway = adforest_verify_sms_gateway();

        if ($gateway == "iletimerkezi-sms") {
            $ilt_data = get_option('ilt_option');

            $options = ilt_get_options();
            $options['number_to'] = $receiver_ph;
            $options['message'] = $message;
            $args = wp_parse_args($args, $options);
            $is_args_valid = ilt_validate_sms_args($args);

            if (!$is_args_valid) {
                extract($args);
                $message = apply_filters('ilt_sms_message', $message, $args);
                try {
                    $client = Emarka\Sms\Client::createClient(['api_key' => $args['public_key'], 'secret' => $args['private_key'], 'sender' => $args['sender'],]);
                    $response = $client->send($receiver_ph, $message);
                    if (!$response) {
                        $is_args_valid = ilt_log_entry_format(__('[Api Error] Connection error', 'adforest'), $args);
                        $return = false;
                    } else {
                        $is_args_valid = ilt_log_entry_format(sprintf(__('Success! Message ID: %s', 'adforest'), $response), $args);
                        $return = true;
                    }
                } catch (\Exception $e) {
                    $is_args_valid = ilt_log_entry_format(sprintf(__('[Api Error] %s ', 'adforest'), $e->getMessage()), $args);
                    $return = false;
                }
            } else {
                $return = false;
            }

            ilt_update_logs($is_args_valid, $args['logging']);
            return $return;
        }

        if ($gateway == "twilio") {
            $twl_data = get_option('twl_option');

            $account_sid = $twl_data['account_sid'];
            $auth_token = $twl_data['auth_token'];
            $twilio_phone_number = $twl_data['number_from'];

            $client = new Twilio\Rest\Client($account_sid, $auth_token);
            try {
                $response = $client->messages->create($receiver_ph, array("from" => $twilio_phone_number, "body" => $message));
                return $response;
            } catch (\Exception $e) {
                echo '0|' . $e->getMessage();
                die();
            }
        }
    }

}
add_action('wp_ajax_sb_verify_firebase_otp', 'sb_verify_firebase_otp_fun');
if (!function_exists('sb_verify_firebase_otp_fun')) {

    function sb_verify_firebase_otp_fun() {

         $is_demo  =   adforest_is_demo();
          if($is_demo){
            wp_send_json_error(array("message" => esc_html__('Not allowed in demo mode', 'adforest')));
            die();
        }

        $user_id = get_current_user_id();
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : "";
        $saved_num = get_user_meta($user_id, '_sb_contact', true);
        if ($phone_number == "") {
            wp_send_json_error(array("message" => esc_html__('Phone Number not exist', 'adforest')));
        } else if ($phone_number != $saved_num) {
            wp_send_json_error(array("message" => esc_html__('Phone Number not match', 'adforest')));
        } else {
            update_user_meta($user_id, '_sb_is_ph_verified', "1");
            wp_send_json_success(array("message" => esc_html__('Verified succesfully', 'adforest')));
        }
    }

}
// Ajax hander for update profile processing
add_action('wp_ajax_sb_update_profile', 'adforest_profile_update_ajax_processed');
if (!function_exists('adforest_profile_update_ajax_processed')) {

    function adforest_profile_update_ajax_processed() {
        // Getting values
        
         $is_demo  =   adforest_is_demo();
          if($is_demo){
            echo esc_html__('Not allowed in demo mode', 'adforest');
            die();
        }

     

        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_profile_secure', 'security');

        $uid = get_current_user_id();
        $email = (isset($params['user_email']) && $params['user_email'] != "") ? $params['user_email'] : "";
        global $adforest_theme;
        $sms_gateway = adforest_verify_sms_gateway();
        if ($sms_gateway != "") {
            $ph_num = sanitize_text_field($params['sb_user_contact']);
            if (!preg_match("/\+[0-9]+$/", $ph_num)) {
                echo __('Please enter valid phone number +CountrycodePhonenumber', 'adforest');
                die();
            }
            $saved_ph = get_user_meta($uid, '_sb_contact', true);
            if ($saved_ph != $ph_num) {
                update_user_meta($uid, '_sb_is_ph_verified', '0');
            }
        }
        /* if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
          $ph_num = sanitize_text_field($params['sb_user_contact']);
          if (!preg_match("/\+[0-9]+$/", $ph_num)) {
          echo __('Please enter valid phone number +CountrycodePhonenumber', 'adforest');
          die();
          }

          $saved_ph = get_user_meta($uid, '_sb_contact', true);
          if ($saved_ph != $ph_num) {
          update_user_meta($uid, '_sb_is_ph_verified', '0');
          }
          } */
        wp_update_user(array('ID' => $uid, 'display_name' => sanitize_text_field($params['sb_user_name'])));
       
        update_user_meta($uid, '_sb_address', sanitize_text_field($params['sb_user_address']));
        update_user_meta($uid, '_sb_user_type', sanitize_text_field($params['sb_user_type']));
        update_user_meta($uid, '_sb_user_intro', sanitize_textarea_field($params['sb_user_intro']));
        $sb_disable_linkedin_edit = isset($adforest_theme['sb_disable_linkedin_edit']) && $adforest_theme['sb_disable_linkedin_edit'] ? TRUE : FALSE;
        $profiles = adforest_social_profiles();
        foreach ($profiles as $key => $value) {
            if ($key == 'linkedin' && $sb_disable_linkedin_edit) {
                continue;
            }
            update_user_meta($uid, '_sb_profile_' . $key, sanitize_textarea_field($params['_sb_profile_' . $key]));
        }
        do_action('adforest_directory_update_profile_opening_hours', $uid, $params);
        if ($email != "") {
            $args = array(
                'ID' => $uid,
                'user_email' => $email,
            );
            $update = wp_update_user($args);
            if (is_wp_error($update)) {
                echo adforest_returnEcho($update->get_error_message());
                die();
            } else {
                echo '1';
                die();
            }
        }


       
       if(isset($params['sb_user_contact']) &&  $params['sb_user_contact'] != ""){
           global  $wpdb;
           $user_contact  =  $params['sb_user_contact'];
           $query_user = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_sb_contact' AND meta_value  =  '$user_contact'";
            $result = $wpdb->get_results($query_user);

        if(is_array($result) && isset($result[0]->user_id) && $result[0]->user_id != $uid)
          {            
            echo  __('Phone Number already registered', 'adforest');
            die();
          }


          update_user_meta($uid, '_sb_contact', $user_contact);
           
        }
        echo '1';
        die();
    }

}

add_action('wp_ajax_upload_user_pic', 'adforest_user_profile_pic');
if (!function_exists('adforest_user_profile_pic')) {

    function adforest_user_profile_pic() {
        /* img upload */

         $is_demo  =   adforest_is_demo();
        if($is_demo){
            
              echo '0|' . __("Not allowed in demo mode", 'adforest');
            die();
        }
        $condition_img = 7;
        $img_count = 1;
        if (!empty($_FILES["my_file_upload"])) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $files = $_FILES["my_file_upload"];
            $attachment_ids = array();
            $attachment_idss = '';

            if ($img_count >= 1) {
                $imgcount = $img_count;
            } else {
                $imgcount = 1;
            }
            $ul_con = '';
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array("my_file_upload" => $file);

                    // Allow certain file formats
                    $imageFileType = strtolower(end(explode('.', $file['name'])));
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'adforest');
                        die();
                    }

                    // Check file size
                    if ($file['size'] > 2097152) {
                        echo '0|' . __("Max allowd image size is 2MB", 'adforest');
                        die();
                    }


                    foreach ($_FILES as $file => $array) {

                        if ($imgcount >= $condition_img) {
                            break;
                        }
                        $attach_id = media_handle_upload($file, $post_id);
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src($attach_id, 'adforest-user-profile');
                    }
                    if ($imgcount > $condition_img) {
                        break;
                    }
                    $imgcount++;
                }
            }
        }
        /* img upload */
        $attachment_idss = array_filter($attachment_ids);
        $attachment_idss = implode(',', $attachment_idss);

        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] = $ul_con;

        $uid = get_current_user_id();
        update_user_meta($uid, '_sb_user_pic', $attach_id);
        update_user_meta($uid, '_sb_user_linkedin_pic', '');
        echo '1|' . $image_link[0];
        die();
    }

}
/* Make ad featured  */
add_action('wp_ajax_sb_make_featured', 'adforest_make_featured');
if (!function_exists('adforest_make_featured')) {

    function adforest_make_featured() {
        $ad_id = $_POST['ad_id'];
        $user_id = get_current_user_id();
         $is_demo  =   adforest_is_demo();
          if($is_demo){
             echo '0|' . __("Not allowed in demo mode", 'adforest');
             die();
        }      
        if (get_post_field('post_author', $ad_id) == $user_id) {
            if (get_post_meta($ad_id, '_adforest_is_feature', true) == '1') {
                echo '0|' . __("This ad is featured already.", 'adforest');
                die();
            }

            $featured_ads =  get_user_meta($user_id, '_sb_featured_ads', true);
            if ($featured_ads != 0  && $featured_ads != "") {
    
                if (get_user_meta($user_id, '_sb_expire_ads', true) != '-1') {
                    if (get_user_meta($user_id, '_sb_expire_ads', true) < date('Y-m-d')) {
                        echo '0|' . __("Your package has expired", 'adforest');
                        die();
                    }
                }
                $feature_ads = get_user_meta($user_id, '_sb_featured_ads', true);
                $feature_ads =  (int)$feature_ads - 1;
                update_user_meta($user_id, '_sb_featured_ads', $feature_ads);
                update_post_meta($ad_id, '_adforest_is_feature', '1');
                update_post_meta($ad_id, '_adforest_is_feature_date', date('Y-m-d'));

                     $package_adFeatured_expiry_days = get_user_meta($user_id, 'package_adFeatured_expiry_days', true);
                if ($package_adFeatured_expiry_days) {
                    update_post_meta($ad_id, 'package_adFeatured_expiry_days', $package_adFeatured_expiry_days);
                }
                
                do_action('adforest_wpml_make_featured', $ad_id);
                echo '1|' . __("This ad has been featured successfullly", 'adforest');
            } else {
                echo '0|' . __("Get package in order to make it featured", 'adforest');
            }
        } else {
            echo '0|' . __("You must be the Ad owner to make it featured.", 'adforest');
        }
        die();
    }
}
/* Adforest Profile Badge start */
add_action('wp_ajax_sb_profile_badge', 'adforest_profile_badge');
add_action('wp_ajax_nopriv_sb_profile_badge', 'adforest_profile_badge'); // Allow non-logged-in users to use this action

if (!function_exists('adforest_profile_badge')) {
    function adforest_profile_badge() {
        global $adforest_theme;
        global $woocommerce;

        $user_id = get_current_user_id();
        $package_id = isset($adforest_theme['sb_profile_badge_package']) ? $adforest_theme['sb_profile_badge_package'] : "";
        $product = wc_get_product($package_id);
        $product_price = $product->get_price();
        if (empty($product_price)) {
            update_user_meta($user_id, 'user_profile_badge', array($package_id));
            wp_send_json_success(array("message" => __("Successfully bought badge", 'adforest')));
            die();
        }
        // Check if WooCommerce is active
        if (class_exists('WC_Cart')) {
            $woocommerce->cart->add_to_cart($package_id);
            // Get the cart URL
            $redirect_url = wc_get_cart_url();
            wp_send_json_success(array("message" => __("Added to cart.", 'adforest'), 'url' => $redirect_url));
            die();
        }
    }
}

add_action('woocommerce_order_status_completed', 'sb_term_product_data_updating_on_completion');
if (!function_exists('sb_term_product_data_updating_on_completion')) {
    function sb_term_product_data_updating_on_completion($order_id) {
        $term_id = '';
        $product_id = '';
        $order = wc_get_order($order_id);
        $items = $order->get_items();
        $user_id = $order->get_user_id();
        if (count($items) > 0) {
            foreach ($items as $key => $item) {
                $product_id = $item->get_product_id();
                if ($order_id) {
                    if ($user_id) {
                        update_user_meta($user_id, 'user_profile_badge', $order_id);
                    }
                }
            }
        }
    }
}
/* Adforest Profile Badge Ends */


// Bump it up
add_action('wp_ajax_sb_bump_it_up', 'adforest_bump_it_up');
if (!function_exists('adforest_bump_it_up')) {

    function adforest_bump_it_up() {
         $is_demo  =   adforest_is_demo();
          if($is_demo){
             echo '0|' . __("Not allowed in demo mode", 'adforest');
             die();
        }
        $ad_id = $_POST['ad_id'];
        $user_id = get_current_user_id();
        adforest_set_date_timezone();
        if (get_post_field('post_author', $ad_id) == $user_id) {
            global $adforest_theme;
            // Uptaing remaining ads.
            $bump_ads = get_user_meta($user_id, '_sb_bump_ads', true);

            if ($bump_ads > 0 || $bump_ads == '-1' || ( isset($adforest_theme['sb_allow_free_bump_up']) && $adforest_theme['sb_allow_free_bump_up'] )) {
                wp_update_post(
                    array(
                        'ID' => $ad_id, // ID of the post to update
                        'post_date' => current_time('mysql'),
                        'post_type' => 'ad_post',
                        'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                    )
                );
                do_action('adforest_wpml_bumpup_ads', $pid);
             if (isset($adforest_theme['make_bump_up_paid']) && $adforest_theme['make_bump_up_paid'] &&  get_post_meta($pid, '_sb_bump_ads', true)  != "1" ){
                     $url = get_the_permalink($adforest_theme['sb_bump_up_template_page']);
                     $redirect_url = $url."?pid=".$ad_id;
                     wp_send_json_success(array("message" => __("Bumped up successfully.", 'adforest'),  'url' => $redirect_url)) ;    
              }else{
                if (!$adforest_theme['sb_allow_free_bump_up'] && $bump_ads != '-1') {
                    $bump_ads = $bump_ads - 1;
                    update_user_meta($user_id, '_sb_bump_ads', $bump_ads);
                    wp_send_json_success(array("message" => esc_html__('Bumped up successfully.', 'adforest')));
                    die();
                 }
               }
               
            } else {
                wp_send_json_error(array("message" => esc_html__('Buy package to make it bump.', 'adforest')));
                die();
            }
        } else {
             wp_send_json_error(array("message" => esc_html__('You must be the Ad owner to make it featured.', 'adforest')));
        }

        die();
    }

}
// Remove Ad
add_action('wp_ajax_sb_update_ad_status', 'adforest_sb_update_ad_status');
if (!function_exists('adforest_sb_update_ad_status')) {

    function adforest_sb_update_ad_status() {
        adforest_authenticate_check();
         $is_demo  =   adforest_is_demo();
          if($is_demo){
             echo '0|' . __("Not allowed in demo mode", 'adforest');
             die();
        }
       
        global $adforest_theme;
        $ad_id = $_POST['ad_id'];
         $status = $_POST['status'];
         $previous_staus  =   get_post_meta($ad_id, '_adforest_ad_status_', true);
        if($previous_staus ==  $status){    
              $message   =  __("Already", 'adforest') . $previous_staus;
              echo '0|' . 
              die();
        }

         /*if activating from inactive to active bump it up automatically*/

      if($status   ==  'active' && $previous_staus != 'active') {
        
          $user_id    =   get_current_user_id();

           $simple_ads = get_user_meta($user_id, '_sb_simple_ads', true);
            $expiry = get_user_meta($user_id, '_sb_expire_ads', true);
            if ($simple_ads == -1) {
                
            } else if ($simple_ads <= 0) {
              echo '0|' . __("Please buy package first to reactivate.", 'adforest');
              die();
            }
            if ($expiry != '-1' ) {

                   if ($expiry < date('Y-m-d')) {
               echo '0|' . __("Please buy package first reactivate.", 'adforest');
               die();
           }
            }

              wp_update_post(
                        array(
                            'ID' => $ad_id, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_type' => 'ad_post',
                             'post_status' => 'publish',
                            'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                        // 'post_date_gmt' => get_gmt_from_date(date('Y-m-d H:i:s'))
                        )
                );

            $package_ad_expiry_days = get_user_meta($user_id, 'package_ad_expiry_days', true);
            if ($package_ad_expiry_days != "") {
                update_post_meta($ad_id, 'package_ad_expiry_days', $package_ad_expiry_days);                  
                   if ($simple_ads > 0) {
                      $simple_ads = $simple_ads - 1;
                      update_user_meta($user_id, '_sb_simple_ads', $simple_ads);
                  }
            }
      



         }

       
        $after_expired_ads = isset($adforest_theme['after_expired_ads']) ? $adforest_theme['after_expired_ads'] : "";
        $after_sold_ads = isset($adforest_theme['after_sold_ads']) ? $adforest_theme['after_sold_ads'] : "";
        $expired = "draft";
        if ($after_expired_ads == 'published') {
            $expired = "publish";
        }
        $sold = "draft";
        if ($after_sold_ads == 'published') {
            $sold = "publish";
        }
        
        $sb_status_array = array(
            'expired' => $expired,
            'sold' => $sold,
            'active' => 'publish',
        );
        update_post_meta($ad_id, '_adforest_ad_status_', $status);
        $my_post = array(
            'ID' => $ad_id,
            'post_status' => $sb_status_array[$status],
            'post_type' => 'ad_post',
        );
        wp_update_post($my_post);

     
        echo '1|' . __("Updated successfully.", 'adforest');
        die();
    }

}

add_action('wp_ajax_del_job_alerts', 'nokri_del_job_alerts');
if (!function_exists('nokri_del_job_alerts')) {
    function nokri_del_job_alerts() {
        global $nokri;
        $user_id = get_current_user_id();
        $alert_id = $_POST['alert_id'];
        /* demo check */
        if ($alert_id != "") {
            if (delete_user_meta($user_id, $alert_id)) {
                echo '1|' . __("Deleted successfully.", 'adforest');
                die();
            } else {
                echo '0|' . __("Unable to delete", 'adforest');
                die();
            }
        }
        echo '0|' . __("Unable to delete", 'adforest');
        die();
    }
}

// Remove Ad
add_action('wp_ajax_sb_remove_ad', 'adforest_sb_remove_ad');
if (!function_exists('adforest_sb_remove_ad')) {

    function adforest_sb_remove_ad() {
         $is_demo  =   adforest_is_demo();
          if($is_demo){
             echo '0|' . __("Not allowed in demo mode", 'adforest');
             die();
        }

        
        adforest_authenticate_check();

        $ad_id = $_POST['ad_id'];
        $stored_status = get_post_meta($ad_id, '_adforest_ad_status_', true);
        if (wp_trash_post($ad_id)) {
            echo '1|' . __("Ad removed successfully.", 'adforest');
        } else {
            echo '0|' . __("There'is some problem, please try again later.", 'adforest');
        }

        die();
    }

}
// Ajax handler my_ads_msgs
add_action('wp_ajax_received_msgs_ads_list', 'adforest_received_msgs_ads_list');
if (!function_exists('adforest_received_msgs_ads_list')) {

    function adforest_received_msgs_ads_list() {

        echo adforest_returnEcho(adforest_get_user_ads_list());

        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_sb_load_messages', 'adforest_load_messages');
if (!function_exists('adforest_load_messages')) {

    function adforest_load_messages() {
        $ad_id = isset($_POST['ad_id']) ? $_POST['ad_id']  : "";
        $args = array(
            'post_type' => 'ad_post',
            'author' => get_current_user_id(),
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        echo adforest_returnEcho(adforest_load_ad_messages($ad_id));
        wp_die();
    }

}
// Get all messages of particular ad
add_action('wp_ajax_sb_get_messages', 'adforest_get_messages_all');
if (!function_exists('adforest_get_messages_all')) {

    function adforest_get_messages_all() {

        adforest_authenticate_check();
        check_ajax_referer('sb_msg_secure', 'security');
        $ad_id = $_POST['ad_id'];
        $user_id = $_POST['user_id'];
        $authors = array($user_id, get_current_user_id());

        //$blocked_user_array2 = get_user_meta(get_current_user_id(), 'adforest_blocked_users', true);
        //if (isset($blocked_user_array2) && !empty($blocked_user_array2) && is_array($blocked_user_array2) && in_array($user_id, $blocked_user_array2)) {
        //echo '0|' . __("Unblock this user to send message.", 'adforest');
        // die();
        //}
        // Mark as read conversation
        update_comment_meta(get_current_user_id(), $ad_id . "_" . $user_id, 1);

        // do_action('adforest_switch_language_code_from_id', $ad_id);


        $parent = $user_id;
        if ($_POST['inbox'] == 'yes') {
            $parent = get_current_user_id();
        }
        $args = array(
            'author__in' => $authors,
            'post_id' => $ad_id,
            'parent' => $parent,
            'orderby' => 'comment_date',
            'order' => 'ASC',
        );
        $comments = get_comments($args);
        $messages = '';
        $i = 1;
        $total = count($comments);
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $user_pic = '';
                $class = 'friend-message';
                if ($comment->user_id == get_current_user_id()) {
                    $class = 'my-message';
                }
                $user_pic = adforest_get_user_dp($comment->user_id);
                $id = '';
                if ($i == $total) {
                    $id = 'id="last_li"';
                }
                $i++;

                $images_meta = get_comment_meta($comment->comment_ID, 'comment_image_meta', true);
                $images_meta = $images_meta != "" ? unserialize($images_meta) : array();
                $images_html = "";
                $counter = 0;
                if (!empty($images_meta)) {
                    foreach ($images_meta as $attach_id) {
                        $img_src = wp_get_attachment_image_src($attach_id);
                        $images_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox = "gallery"><img src="' . $img_src[0] . '"></a>';
                        $counter++;
                    }
                }

                if ($counter > 4) {
                    $images_html .= '<div class="img_more">' . esc_html__('More', 'adforest') . '</div>';
                }

                $file_meta = get_comment_meta($comment->comment_ID, 'comment_file_meta', true);

                $file_meta = $file_meta != "" ? unserialize($file_meta) : array();
                $files_html = "";
                if (!empty($file_meta)) {
                    $files_html .= '<div>';
                    foreach ($file_meta as $attach_id) {
                        if (wp_attachment_is_image($attach_id)) {
                            $img_src = wp_get_attachment_image_src($attach_id);
                            $files_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox="gallery"><img src="' . $img_src[0] . '"></a>';
                        } else {
                            $file_url = wp_get_attachment_url($attach_id);
                            $files_html .= '<a class="sb_msg_file" href="' . $file_url . '" target="_blank">' . basename(get_attached_file($attach_id)) . '</a>';
                        }
                    }
                    $files_html .= '</div>';
                }



                $messages .= '<li class="' . $class . ' clearfix" ' . $id . '>
							 <figure class="profile-picture">
                                                         <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
								<img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"  alt="image">
                                                          </a>          
							 </figure>
							 <div class="message">
								' . $comment->comment_content . '
                                                                   
                                                                    ' . $files_html . '
								<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div>
							 </div>
						  </li>';
            }
        }
        echo adforest_returnEcho($messages);
        die();
    }

}

// Ajax handler for messages
add_action('wp_ajax_my_msgs', 'adforest_my_msgs');
if (!function_exists('adforest_my_msgs')) {

    function adforest_my_msgs() {
        echo adforest_returnEcho(adforest_get_messages(get_current_user_id()));
        die();
    }

}



// Ajax handler for messages
add_action('wp_ajax_adforest_all_blocked_users', 'adforest_all_blocked_users_callback');
if (!function_exists('adforest_all_blocked_users_callback')) {

    function adforest_all_blocked_users_callback() {
        echo adforest_returnEcho(adforest_all_blocked_users_list(get_current_user_id()));
        die();
    }

}

function adforest_get_user_ads_list() {
    global $adforest_theme;
    $script = '<script type="text/javascript">jQuery(document).ready(function($){"use strict";$(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');function scrollbar() {var $scrollbar = $(\'.message-inbox .list-wrap\');$scrollbar.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar.perfectScrollbar(\'update\');}scrollbar();$(\'.messages\').wrap(\'<div class="list-wraps"></div>\');function scrollbar1() {var $scrollbar1 = $(\'.message-details .list-wraps\');$scrollbar1.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar1.perfectScrollbar(\'update\');}scrollbar1();});</script>';

    global $wpdb;

    $args = array(
        'post_type' => 'ad_post',
        'author' => get_current_user_id(),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'ID',
    );

    $args = apply_filters('adforest_wpml_show_all_posts', $args);
    $args = apply_filters('adforest_site_location_ads', $args, 'ads');

    $ads = new WP_Query($args);
    if ($ads->have_posts()) {
        $number = 0;
        $ads_list = '';
        while ($ads->have_posts()) {
            $ads->the_post();
            $pid = get_the_ID();

            $ad_img = adforest_get_ad_default_image_url('adforest-ad-related');
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $img = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $ad_img = $img[0];
                    break;
                }
            }

            $is_unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '" . get_current_user_id() . "' AND meta_value = '0' AND meta_key like '" . $pid . "_%'");

            $unread_html = '';

            $status = '';
            if ($is_unread_msgs > 0) {
                $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';

                $unread_html .= '<li class="get_msgs" ad_msg="' . esc_attr($pid) . '"><a href="javascript:void(0);">
						<div class="image"><img src="' . $ad_img . '" alt="' . get_the_title($pid) . '"></div>
						<div class="user-name">
						   <div class="author"><span>' . get_the_title($pid) . '</span></div>
						   <div class="time">' . $status . '</div>
						</div>
					 </a>
					 </li>';
            } else {
                $ads_list .= '<li class="get_msgs" ad_msg="' . esc_attr($pid) . '"><a href="javascript:void(0);">
						<div class="image"><img src="' . $ad_img . '" alt="' . get_the_title($pid) . '"></div>
						<div class="user-name">
						   <div class="author"><span>' . get_the_title($pid) . '</span></div>
						   <div class="time">' . $status . '</div>
						</div>
					 </a>
					 </li>';
            }

            $ads_list = $unread_html . $ads_list;
        }
    }
    wp_reset_postdata();
    $msg = '<div class="text-center">' . __('Please click to your ad in order to see messages.', 'adforest') . '</div>';

    return $script . '<div >
               <div class="message-body row">
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="message-inbox">
                       <div class="message-header">
                          <h4>' . __('Ads :', 'adforest') . '</h4>
                              <div class="message-tabs"> 
		       <span><a class="messages_actions" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions active" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>     
                               </div>
                       </div>
                            <ul class="message-history">' . $ads_list . '</ul>
                    </div>
                 </div>
                 <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
                    <div class="message-details">
                       <div class="chat-form ">' . $msg . '</div>
                    </div>
                 </div>
              </div>
           </div>';
}

function adforest_load_ad_messages($ad_id) {


    global $adforest_theme;
    adforest_set_date_timezone();

    $script = '<script type="text/javascript"> jQuery(document).ready(function($){ "use strict";  $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\'); function scrollbar() { var $scrollbar = $(\'.message-inbox .list-wrap\'); $scrollbar.perfectScrollbar({ maxScrollbarLength: 150, }); $scrollbar.perfectScrollbar(\'update\'); }  scrollbar(); $(\'.messages\').wrap(\'<div class="list-wraps"></div>\'); function scrollbar1() { var $scrollbar1 = $(\'.message-details .list-wraps\'); $scrollbar1.perfectScrollbar({ maxScrollbarLength: 150, }); $scrollbar1.perfectScrollbar(\'update\');}scrollbar1();  });</script>';
    $script = apply_filters('adforest_blocked_user_scripts', $script);
    global $wpdb;
    $rows = $wpdb->get_results("SELECT comment_author, user_id FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND comment_type = 'ad_post'  GROUP BY user_id ORDER BY MAX(comment_date) DESC");
    $users = '';
    $messages = '';
    $author_html = '';
    $form = '<div class="text-center">' . __('No message received on this ad yet.', 'adforest') . '</div>';
    $turn = 1;
    $level_2 = '';

    $block_user_html = "";

    foreach ($rows as $row) {
        if (get_current_user_id() == $row->user_id)
            continue;
        
        $user_dp = adforest_get_user_dp($row->user_id);

        $last_date = $wpdb->get_var("SELECT comment_date FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND user_id = '" . $row->user_id . "' AND comment_type = 'ad_post' ORDER BY comment_date DESC LIMIT 1");

        
        $date = explode(' ', $last_date);
        $cls = '';
        $ext_class = "";
        $display = "";
        if ($turn == 1) {
            $cls = 'message-history-active';
        } else {
            $ext_class = "hidden_btn";
        }
        $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $row->user_id, true);

        $status = '';
        if ($msg_status == '0') {
            $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
        }
        $users .= '<li class="user_list ' . $cls . '" cid="' . $ad_id . '" second_user="' . $row->user_id . '" id="sb_' . $row->user_id . '_' . $ad_id . '" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">
					 <a href="javascript:void(0);">
						<div class="image"> <img src="' . $user_dp . '" alt="' . $row->comment_author . '"> </div>
						<div class="user-name">
						   <div class="author"> <span>' . $row->comment_author . '</span> </div>
						   <p>' . get_the_title($ad_id) . '</p>
						   <div class="time" id="' . $row->user_id . '_' . $ad_id . '"> ' . $status . ' </div>
						</div>
					 </a>
				  </li>';

        $block_user_html .= apply_filters('adforest_blocked_button_html', "", $row->user_id, get_current_user_id(), false, $ext_class, true);

        $authors = array($row->user_id, get_current_user_id());

        if ($turn == 1) {
            //do_action('adforest_switch_language_code_from_id', $ad_id);
            $args = array(
                'author__in' => $authors,
                'post_id' => $ad_id,
                'parent' => $row->user_id,
                'orderby' => 'comment_date',
                'order' => 'ASC',
            );
            $comments = get_comments($args);

            if (count($comments) > 0) {

                $level_2 = '<input type="hidden" id="usr_id" name="usr_id" value="' . $row->user_id . '" />
                            <input type="hidden" id="user_id"  value="' . $row->user_id . '" />
                                <input type="hidden" id="rece_id" name="rece_id" value="' . $row->user_id . '" />
                                <input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($row->user_id) . '" />';

                foreach ($comments as $comment) {
                    $user_pic = '';
                    $class = 'friend-message';
                    if ($comment->user_id == get_current_user_id()) {
                        $class = 'my-message';
                    }


                    $images_meta = get_comment_meta($comment->comment_ID, 'comment_image_meta', true);
                    $images_meta = $images_meta != "" ? unserialize($images_meta) : array();
                    $images_html = "";
                    $counter = 0;
                    if (!empty($images_meta)) {

                        foreach ($images_meta as $attach_id) {

                            $img_src = wp_get_attachment_image_src($attach_id);
                            $images_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox="gallery"><img src="' . $img_src[0] . '"></a>';

                            $counter++;
                        }
                    }

                    if ($counter > 4) {

                        $images_html .= '<div class="img_more">' . esc_html__('More', 'adforest') . '</div>';
                    }


                    $file_meta = get_comment_meta($comment->comment_ID, 'comment_file_meta', true);

                    $file_meta = $file_meta != "" ? unserialize($file_meta) : array();
                    $files_html = "";
                    if (!empty($file_meta)) {
                        $files_html .= '<div>';
                        foreach ($file_meta as $attach_id) {
                            if (wp_attachment_is_image($attach_id)) {
                                $img_src = wp_get_attachment_image_src($attach_id);
                                $files_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox="gallery"><img src="' . $img_src[0] . '"></a>';
                            } else {
                                $file_url = wp_get_attachment_url($attach_id);
                                $files_html .= '<a class="sb_msg_file" href="' . $file_url . '" target="_blank">' . basename(get_attached_file($attach_id)) . '</a>';
                            }
                        }
                        $files_html .= '</div>';
                    }


                    $user_pic = adforest_get_user_dp($comment->user_id);
                    $messages .= '<li class="' . $class . ' clearfix">
								 <figure class="profile-picture"><a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank"><img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"></a></figure>
								 <div class="message">
									' . $comment->comment_content . '
                                                                        ' . $images_html . '
                                                                            ' . $files_html . '
									<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div>
								 </div>
							  </li>';
                }
            }

            $allow_attachment = isset($adforest_theme['allow_media_upload_messaging']) ? $adforest_theme['allow_media_upload_messaging'] : false;

            $attachment_html = "";
            if ($allow_attachment) {
                $attachment_html = '<div id="attachment-wrapper" class="attachment-wrapper"></div>           
                                       <div class="file_attacher" id="file_attacher">
                                         <a href="javascript:void(0)" class="msgAttachFile dz-clickable"><i class="fa fa-link"></i>' . esc_html__('Add Attachment', 'adforest') . '</a>
                                         
                                         </div>                             
                                    ';
            }
            // Message form


            $verifed_phone_number = adforest_check_if_phoneVerified();
            if ($verifed_phone_number) {
                $form = '<div role="alert" class="alert alert-info alert-dismissible">
                                ' . __("Please verify your phone number to send message.", "adforest") . ' 
                             </div>';
            } else {
                
                $user_info  =   get_userdata(get_current_user_id() );
                $form = '<form role="form" class="form-inline" id="send_message">
                            
                                  ' . $attachment_html . '
                             <div class="form-group">
							 <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
							 <input type="hidden" name="name" value="' . $user_info->display_name . '" />
							 <input type="hidden" name="email" value="' . $user_info->user_email . '" />
                                                                
							 ' . $level_2 . '
                                <input name="message" id="sb_forest_message" placeholder="' . __('Type a message here...', 'adforest') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                             </div>

                              
                             
                             <button class="btn btn-theme" id="send_msg" type="submit" inbox="no" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">' . __('Send', 'adforest') . '</button>
                           
                          </form>';
            }
        }
        $turn++;
    }
    if ($users == '') {
        $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('No message received on this ad yet.', 'adforest') . '</div></li>';
    }
    $title = '';
    if (isset($ad_id) && $ad_id != "") {
        $title = '<a href="' . get_the_permalink($ad_id) . '" target="_blank">' . get_the_title($ad_id) . '</a>';
    }
    $title_html = '<h2 class="padding-top">' . $title . '    ' . $block_user_html . ' </h2>';

    return $script . '<div>
              <div class="message-body row">
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="message-inbox">
                       <div class="message-header">
                          <h4>' . __('Users', 'adforest') . '</h4>
                              <div class="message-tabs"> 
                                <span><a class="messages_actions" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                                <span><a class="messages_actions active" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                                <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                              </div>
                       </div>
                        <ul class="message-history"> ' . $users . ' </ul>
                    </div>
                 </div>
                 <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
				 	' . $title_html . '
                    <div class="message-details">
                       <ul class="messages" id="messages"> ' . $messages . ' </ul>
                       <div class="chat-form "> ' . $form . ' </div>
                    </div>
                 </div>
              </div>
     </div>';
}

function adforest_all_blocked_users_list($current_user_id) {
    global $adforest_theme;

    $script = '<script type="text/javascript">jQuery(document).ready(function($){"use strict";$(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');function scrollbar() {var $scrollbar = $(\'.message-inbox .list-wrap\');$scrollbar.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar.perfectScrollbar(\'update\');}scrollbar();$(\'.messages\').wrap(\'<div class="list-wraps"></div>\');function scrollbar1() {var $scrollbar1 = $(\'.message-details .list-wraps\');$scrollbar1.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar1.perfectScrollbar(\'update\');}scrollbar1();});</script>';

    $script = apply_filters('adforest_blocked_user_scripts', $script);

    global $wpdb;

    $users = '';
    $messages = '';
    $messages = '<div class="text-center">' . __('No Blocked user.', 'adforest') . '</div>';
    $author_html = '';
    $turn = 1;
    $level_2 = '';
    $title_html = '<h2 class="padding-top-20 sb_ad_title">' . __('Blocked users', 'adforest') . '</h2>';

    $blocked_user_array = get_user_meta($current_user_id, 'adforest_blocked_users', true);

    if (isset($blocked_user_array) && !empty($blocked_user_array) && is_array($blocked_user_array)) {

        $messages = '';
        foreach ($blocked_user_array as $block_time => $block_user_id) {

            if ($turn == 1)
                $cls = 'message-history-active';

            $user_data = get_userdata($block_user_id);
            $ad_id = $row->comment_post_ID;
            $comment_author = get_userdata($author);

            $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);

            $form = ' ';
            $form = apply_filters('adforest_blocked_button_html', $form, $block_user_id, get_current_user_id(), false);

            $user_pic = adforest_get_user_dp($block_user_id);
            $messages .= '<li class="friend-message clearfix">
                        <figure class="profile-picture"><a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank"><img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"></a></figure>
                        <div class="message block-user-box">
                            <div class="user-detail-wrap">
                               <span class="block-user-name">' . $user_data->display_name . '</span>
                               <span class="block-user-date">' . __('Blocked on', 'adforest') . ' : ' . date('F j, Y', $block_time) . '</span>
                            </div>       
                              ' . $form . '    
                        </div>
                 </li>';
            $turn++;
        }
    }

    if ($users == '') {
        $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('Nothing Found.', 'adforest') . '</div></li>';
    }
    return $script . '<div>
               <div class="message-body row">
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="message-inbox">
                       <div class="message-header">
                          <h4>' . __('Ads :', 'adforest') . '</h4>
                            <div class="message-tabs">  
                          <span><a class="messages_actions" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions active" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                               </div>
                       </div>
                       
                    </div>
                 </div>
                 <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
				 	' . $title_html . '
                    <div class="message-details">
                       <ul class="messages">' . $messages . '</ul>
                    </div>
                 </div>
              </div>
           </div>';
}


if(!function_exists('adforest_get_messages')){
function adforest_get_messages($user_id) {
    global $adforest_theme;
    $script = '<script type="text/javascript">jQuery(document).ready(function($){"use strict";                   
              if ($("#file_attacher").length > 0) {
               var attachmentsDropzone = new Dropzone(document.getElementById(\'file_attacher\'), {
                    url: adforest_ajax_url,
                    autoProcessQueue: true,
                    previewsContainer: "#attachment-wrapper",
                    previewTemplate: \'<span class="dz-preview dz-file-preview"><span class="dz-details"><span class="dz-filename"><i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;<span data-dz-name></span></span>&nbsp;&nbsp;&nbsp;<span class="dz-size" data-dz-size></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="cursor:pointer;font-size:15px;" data-dz-remove></i></span><span class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></span><i class="ti ti-refresh ti-spin"></i></span>\',
                    clickable: "a.msgAttachFile",
                    acceptedFiles: $(\'#provided_format\').val(),
                    maxFilesize: 15,
                    maxFiles: 4
                });
                attachmentsDropzone.on("sending",function(){
                        console.log("eeeee");
			$("#send_msg ,#send_ad_message").attr("disabled",true);
		});
                attachmentsDropzone.on("queuecomplete",function(){
			$("#send_msg, #send_ad_message").attr("disabled",false);
		});                

                  } $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');function scrollbar() {var $scrollbar = $(\'.message-inbox .list-wrap\');$scrollbar.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar.perfectScrollbar(\'update\');}scrollbar();$(\'.messages\').wrap(\'<div class="list-wraps"></div>\');function scrollbar1() {var $scrollbar1 = $(\'.message-details .list-wraps\');$scrollbar1.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar1.perfectScrollbar(\'update\');}scrollbar1();});</script>';

    $script = apply_filters('adforest_blocked_user_scripts', $script);
    global $wpdb;
    $rows = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type = 'ad_post' AND user_id = '$user_id' AND comment_parent = '$user_id' GROUP BY comment_post_ID ORDER BY comment_ID DESC");
    $users = '';
    $messages = '';
    $form = '<div class="text-center">' . __('No message received on this ad yet.', 'adforest') . '</div>';
    $author_html = '';
    $turn = 1;
    $level_2 = '';
    $title_html = '';
    foreach ($rows as $row) {
        $last_date = $row->comment_date;
        $date = explode(' ', $last_date);
        $author = get_post_field('post_author', $row->comment_post_ID);
        $cls = '';
        if ($turn == 1)
            $cls = 'message-history-active';
        $ad_img = adforest_get_ad_default_image_url('adforest-ad-related');
        $media = adforest_get_ad_images($row->comment_post_ID);
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

                $img = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                $ad_img = $img[0];
                break;
            }
        }
        if (isset($row->comment_post_ID) && $row->comment_post_ID != "") {
            if ($turn == 1) {
                $title_html .= '<h2 class="padding-top-20 sb_ad_title" id="title_for_' . esc_attr($row->comment_post_ID) . '"><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
            } else {
                $title_html .= '<h2 class="padding-top-20 sb_ad_title no-display" id="title_for_' . esc_attr($row->comment_post_ID) . '" ><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
            }
        }
        $ad_id = $row->comment_post_ID;
        $comment_author = get_userdata($author);
        $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);
        $status = '';
        if ($msg_status == '0') {
            $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
        }
        $users .= '<li class="user_list ad_title_show ' . $cls . '" cid="' . $row->comment_post_ID . '" second_user="' . $author . '" inbox="yes" id="sb_' . $author . '_' . $ad_id . '" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">
					 <a href="javascript:void(0);">
						<div class="image"><img src="' . $ad_img . '" alt="' . $comment_author->display_name . '"></div>
						<div class="user-name">
						   <div class="author"><span>' . get_the_title($ad_id) . '</span></div>
						   <p>' . $comment_author->display_name . '</p>
						   <div class="time" id="' . $author . '_' . $ad_id . '">' . $status . '</div>
						</div>
					 </a>
				  </li>
';
        $authors = array($author, get_current_user_id());
        if ($turn == 1) {
            $block_user_html = '';
            // do_action('adforest_switch_language_code_from_id', $ad_id);
            $args = array(
                'author__in' => $authors,
                'post_id' => $ad_id,
                'parent' => get_current_user_id(),
                'post_type' => 'ad_post',
                'orderby' => 'comment_date',
                'order' => 'ASC',
            );
            $comments = get_comments($args);
            if (count($comments) > 0) {
                foreach ($comments as $comment) {
                    $user_pic = '';
                    $class = 'friend-message';
                    if ($comment->user_id == get_current_user_id()) {
                        $class = 'my-message';
                    }
                    $user_pic = adforest_get_user_dp($comment->user_id);
                    $images_meta = get_comment_meta($comment->comment_ID, 'comment_image_meta', true);
                    $images_meta = $images_meta != "" ? unserialize($images_meta) : array();
                    $images_html = "";
                    $counter = 0;
                    if (!empty($images_meta)) {
                        foreach ($images_meta as $attach_id) {
                            $img_src = wp_get_attachment_image_src($attach_id);
                            $images_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox = "gallery"><img src="' . $img_src[0] . '"></a>';
                            $counter++;
                        }
                    }
                    if ($counter > 4) {
                        $images_html .= '<div class="img_more">' . esc_html__('More', 'adforest') . '</div>';
                    }
                    $file_meta = get_comment_meta($comment->comment_ID, 'comment_file_meta', true);
                    $file_meta = $file_meta != "" ? unserialize($file_meta) : array();
                    $files_html = "";
                    if (!empty($file_meta)) {
                        $files_html .= '<div>';
                        foreach ($file_meta as $attach_id) {
                            if (wp_attachment_is_image($attach_id)) {
                                $img_src = wp_get_attachment_image_src($attach_id);
                                $files_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox="gallery"><img src="' . $img_src[0] . '"></a>';
                            } else {
                                $file_url = wp_get_attachment_url($attach_id);
                                $files_html .= '<a class="sb_msg_file" href="' . $file_url . '" target="_blank">' . basename(get_attached_file($attach_id)) . '</a>';
                            }
                        }
                        $files_html .= '</div>';
                    }
                    $messages .= '<li class="' . $class . ' clearfix"><figure class="profile-picture"><a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank"><img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"></a></figure><div class="message">' . $comment->comment_content . '' . $images_html . '                                                                ' . $files_html . '<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div></div></li>';
                }
            }
            $allow_attachment = isset($adforest_theme['allow_media_upload_messaging']) ? $adforest_theme['allow_media_upload_messaging'] : false;
            $attachment_html = "";
            if ($allow_attachment) {
                $attachment_html = '<div id="attachment-wrapper" class="attachment-wrapper"></div>           
                                       <div class="file_attacher" id="file_attacher">
                                         <a href="javascript:void(0)" class="msgAttachFile dz-clickable"><i class="fa fa-link"></i>' . esc_html__('Add Attachment', 'adforest') . '</a>
                                         
                                         </div>                             
                                    ';
            }
            // Message form
            $level_2 = '<input type="hidden" name="usr_id" value="' . $user_id . '" id="user_id"/><input type="hidden" id="usr_id" value="' . $author . '" /><input type="hidden" id="rece_id" name="rece_id" value="' . $author . '" /><input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($author) . '" />';
            $block_user_html = apply_filters('adforest_blocked_button_html', $block_user_html, $author, $user_id);
            $verifed_phone_number = adforest_check_if_phoneVerified();
            if ($verifed_phone_number) {
                $form = '<div role="alert" class="alert alert-info alert-dismissible">' . __("Please verify your phone number to send a message.", "adforest") . ' 
                 </div>';
            } else {
                $user_info  =   get_userdata(get_current_user_id() );
                $form = '<form role="form" class="form-inline" id="send_message">
                            
                             <div class="form-group">
                            
                                <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
                                <input type="hidden" name="name" value="' . $user_info->display_name . '" />
                                <input type="hidden" name="email" value="' . $user_info->user_email . '" />
							 ' . $level_2 . '
                                <input name="message" id="sb_forest_message" placeholder="' . __('Type a message here...', 'adforest') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                             </div>

                             <button class="btn btn-theme" id="send_msg" type="submit" inbox="yes" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">' . __('Send', 'adforest') . '</button>
                              ' . $attachment_html . '
                          </form>';
            }
        }
        $turn++;
    }
    if ($users == '') {
        $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('Nothing Found.', 'adforest') . '</div></li>';
    }
    return $script . '<div>
               <div class="message-body row">
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="message-inbox">
                       <div class="message-header">
                          <h4>' . __('Ads :', 'adforest') . '</h4>
                            <div class="message-tabs"> 
                           <span><a class="messages_actions active" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="received_msgs_ads_list"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="adforest_all_blocked_users"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                            </div>   
                       </div>
                        <ul class="message-history">' . $users . '</ul>
                    </div>
                 </div>
                 <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
				 	' . $title_html . '
                    <div class="message-details">
                        ' . $block_user_html . '
                       <ul class="messages" id="messages">' . $messages . '</ul>
                       <div class="chat-form ">' . $form . '</div>
                    </div>
                 </div>
              </div>
           </div>';
}
}


if (!function_exists('adforest_pagination_ads')) {

    function adforest_pagination_ads($wp_query) {
        if (is_singular())
        //return;

        /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $max = intval($wp_query->max_num_pages);
        /**     Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**     Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (( $paged + 2 ) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }
        
        $pagination   =  "";

        $pagination  .= '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
        $pagination  .=     '<li>'.get_previous_posts_link().'</li>' . "\n";

        /**     Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            $pagination .= '<li  '.$class.'><a href="'.esc_url(get_pagenum_link(1)).'">1</a></li>' . "\n";

            if (!in_array(2, $links))
                $pagination  .=  '<li><a href="javascript:void(0);">...</a></li>';
        }
        /**     Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array) $links as $link) {

            $class = $paged == $link ? ' class="active"' : '';
       $pagination  .=  '<li '.$class.'><a href="'.esc_url(get_pagenum_link($link)).'">'.$link.'</a></li>' . "\n" ;
        }
        /**     Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                $pagination  .=  '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
     $pagination  .=      '<li '.$class.'><a href="'.esc_url(get_pagenum_link($max)).'">'.$max.'</a></li>' . "\n";
        }

        if (get_next_posts_link_custom($wp_query))
         $pagination  .=    '<li>'.get_next_posts_link_custom($wp_query).'</li>' . "\n"  ;

   return      $pagination  .=  '</ul>' . "\n";
    }
}


/* Delete USER */
// Bump it up
add_action('wp_ajax_delete_site_user_func', 'adforest_delete_site_user_func');
if (!function_exists('adforest_delete_site_user_func')) {

    function adforest_delete_site_user_func() {
        $del_user_id = $_POST['del_user_id'];
        $current_user_id = get_current_user_id();
  require_once(ABSPATH.'wp-admin/includes/user.php');
        $success = 0;
        $message = __("Something went wrong.", "adforest");
        $if_user_exists = adforest_user_id_exists($del_user_id);
        if ($current_user_id == $del_user_id && $if_user_exists) {
            if (current_user_can('administrator')) {

                $success = 0;
                $message = __("Admin can not delete his account from here.", "adforest");
            } else {
                adforestTheme_delete_userComments($current_user_id);
                $user_delete = wp_delete_user($current_user_id);
                if ($user_delete) {

                    $success = 1;
                    $message = __("Your account has been deleted successfully.", "adforest");
                    wp_logout();
                }
            }
        }
        echo adforest_returnEcho($success . '|' . $message);
        die();
    }

}

