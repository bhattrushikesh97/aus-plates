<?php
global $adforest_theme;
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$user_info = get_userdata(get_current_user_id());
$user_id = $user_info->ID;
$user_pic = adforest_get_user_dp($user_info->ID);
/* user type html */
$user_type = get_user_meta($user_info->ID, '_sb_user_type', true);
$is_indiviual = '';
$user_type_txt = '';
$is_dealer = '';
if ($user_type == 'Dealer') {
    $is_dealer = 'selected="selected"';
    $user_type_txt = __('Dealer', 'adforest');
}
if ($user_type == 'Indiviual') {
    $is_indiviual = 'selected="selected"';
    $user_type_txt = __('Individual', 'adforest');
}
$user_type_html = '<option value="Indiviual"  ' . $is_indiviual . '>' . __('Individual', 'adforest') . '</option>
					 <option value="Dealer" ' . $is_dealer . '>' . __('Dealer', 'adforest') . '</option>';

$sb_disable_linkedin_edit = isset($adforest_theme['sb_disable_linkedin_edit']) && $adforest_theme['sb_disable_linkedin_edit'] ? TRUE : FALSE;

/* User social links */
$social_html = '';
if (isset($adforest_theme['sb_enable_social_links']) && $adforest_theme['sb_enable_social_links']) {

    $profiles = adforest_social_profiles();
    foreach ($profiles as $key => $value) {

        $disabled_field = '';
        if ($key == 'linkedin' && $sb_disable_linkedin_edit) {
            $disabled_field = ' disabled="disabled" ';
        }
        $social_html .= '<div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                <div class="form-group">
						  <label class="form-label">' . $value . '</label>
						  <input ' . $disabled_field . 'type="text" class="form-control" value="' . esc_attr(get_user_meta($user_id, '_sb_profile_' . $key, true)) . '" name="_sb_profile_' . $key . '">
					      </div>
                                            </div>';
    }
}




/* Phone number verification */

$is_verified = '';
$is_firebase = $adforest_theme['sb_phone_verification_firebase'] ? $adforest_theme['sb_phone_verification_firebase'] : false;
$sms_gateway = adforest_verify_sms_gateway();
$is_number_verified = get_user_meta($user_id, '_sb_is_ph_verified', true);


if ($sms_gateway != "" && !$is_firebase) {
    if ($is_number_verified == '1') {
        $is_verified = '<span class="mb-2 mr-2 badge badge-success sb_user_type">' . __('Verified', 'adforest') . '</span>';
    } else {
        $is_verified = '&nbsp;
				<a data-target="#verification_modal" data-toggle="modal" class="small_text" id="sb-verify-phone">' . __('Verify now', 'adforest') . '</a>';
    }
} else if ($is_firebase) {
    if ($is_number_verified == '1') {
        $is_verified = '<span class="mb-2 mr-2 badge badge-success sb_user_type">' . __('Verified', 'adforest') . '</span>';
    } else {
        $app_key = isset($adforest_theme['sb_firebase_apikey']) && $adforest_theme['sb_firebase_apikey'] != "" ? $adforest_theme['sb_firebase_apikey'] : "";
        $project_id = isset($adforest_theme['sb_firebase_projectId']) && $adforest_theme['sb_firebase_projectId'] != "" ? $adforest_theme['sb_firebase_projectId'] : "";
        $sender_id = isset($adforest_theme['sb_firebase_messagingSenderId']) && $adforest_theme['sb_firebase_messagingSenderId'] != "" ? $adforest_theme['sb_firebase_messagingSenderId'] : "";
        $app_id = isset($adforest_theme['sb_firebase_appId']) && $adforest_theme['sb_firebase_appId'] != "" ? $adforest_theme['sb_firebase_appId'] : "";
        wp_enqueue_script('firebase-app', "https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js", false, false, true);
        wp_enqueue_script('firebase-analytics', "https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js", false, false, true);
        wp_enqueue_script('firebase-auth', "https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js", false, false, false);
        wp_enqueue_script('firebase-custom', trailingslashit(get_template_directory_uri()) . 'assests/js/firebase-custom.js', array(), false, false);

        $is_verified = '&nbsp;         
	 <a   class="small_text" id="sb-verify-phone-firebase">' . __('Verify now', 'adforest') . '</a><div id="firebase-recaptcha" class="firebase-recaptcha"></div><input type="hidden" id="user-otp-num" value="' . get_user_meta($user_id, '_sb_contact', true) . '"> <input type="hidden"   id="sb-fb-apikey" value= "' . $app_key . '"> 
                 <input type="hidden"   id="sb-fb-projectid"   value= "' . $project_id . '"> 
                 <input type="hidden"   id="sb-fb-senderid"   value= "' . $sender_id . '"> 
                 <input type="hidden"   id="sb-fb-appid"    value= "' . $app_id . '"> ';
    }
}

$readonly = "";
 $email_name = "name=user_email";
if (isset($user_info->user_email) && $user_info->user_email != "") {
    $readonly = "readonly";
    $email_name = "";
}
$ph_placeholder = '';
$sms_gateway = adforest_verify_sms_gateway();
if ($sms_gateway != "") {
    $ph_placeholder = __('+CountrycodePhonenumber', 'adforest');
}

$delete_account_html = '';
if (isset($adforest_theme['sb_new_user_delete_option']) && $adforest_theme['sb_new_user_delete_option']) {
    $data_title = __("Are you sure you want to delete this account?", "adforest");
    $delete_account_html = '<a class="remove_user_profile delete_site_user  btn btn-danger  btn-lg my-4" href="javascript:void(0);" data-btn-ok-label="' . __("Yes", "adforest") . '" data-btn-cancel-label="' . __("No", "adforest") . '" data-toggle="confirmation" data-singleton="true" data-title="' . $data_title . '" data-content="" data-user-id="' . $user_info->ID . '" title="' . __("Delete Account?", "adforest") . '" aria-describedby="confirmation151400">' . __("Delete Account?", "adforest") . '</a>';
}


$badge = '';
if (get_user_meta($user_id, '_sb_badge_type', true) != "" && get_user_meta($user_id, '_sb_badge_text', true) != "") {
    $badge = ' <span class="label ' . get_user_meta($user_id, '_sb_badge_type', true) . '">
	' . get_user_meta($user_id, '_sb_badge_text', true) . '</span>';
}


$package_type_html = '';
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    $package_type = get_user_meta($user_id, '_sb_pkg_type', true);
    if (get_user_meta($user_id, '_sb_pkg_type', true) != 'free') {
        $package_type = __('Paid', 'adforest');
    } else {
        $package_type = __('Free', 'adforest');
    }
    $package_type_html = '<span class="label label-warning">' . $package_type . '</span>';
}

$rating = '';
if (isset($adforest_theme['sb_enable_user_ratting']) && $adforest_theme['sb_enable_user_ratting']) {

    $rating = '<a href="' . adforest_set_url_param(get_author_posts_url($user_id), 'type', 1) . '">
			<div class="rating">';
    $got = get_user_meta($user_id, "_adforest_rating_avg", true);
    if ($got == "")
        $got = 0;
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= round($got))
            $rating .= '<i class="fa fa-star"></i>';
        else
            $rating .= '<i class="fa fa-star-o"></i>';
    }
    $rating .= '<span class="rating-count">
			   (' . count(adforest_get_all_ratings($user_id)) . ')
			   </span>
			</div>
			</a>';
}
$social_icons = "";
$profiles = adforest_social_profiles();
foreach ($profiles as $key => $value) {
    if (get_user_meta($user_id, '_sb_profile_' . $key, true) != "") {
        $social_icons .= '<a href="' . esc_url(get_user_meta($user_id, '_sb_profile_' . $key, true)) . '" target="_blank" class="mb-1 btn btn-outline rounded-circle btn-' . esc_attr($key) . '"><i class="fa fa-' . $key . '"></i></a>';
    }
}


?>
<div class="content-wrapper">
    <div class="content">
        <div class="bg-white border rounded">
            <div class="row no-gutters">
                <div class="col-lg-4 col-xl-3">
                  
                    <div class="profile-content-left profile-left-spacing pt-5 pb-3 px-3 px-xl-5">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto user-dp-container">
                                <?php
                                 if(isset($user_profile_badge) && $user_profile_badge !=""){
                                  echo  $badge_img; 
                                 }
                                ?>
                                <img src="<?php echo esc_url($user_pic); ?>" alt="<?php echo esc_html('img', 'adforest') ?>" id="img-upload">
                                <div class="edit-dp"
                                     ><a href="#"><i class="fa fa-camera" aria-hidden="true" id="upload_user_dp"></i></a>                                   					
                                </div>
                                <input type="file" id="imgInp"   name="my_file_upload[]" accept = "image/*" class="sb_files-data form-control">
                            </div>

                            <div class="card-body profile-main-body">
                                <h4 class="py-2 text-dark"><?php echo esc_html($user_info->display_name) ?></h4>
                                <p><?php echo esc_html($user_info->user_email) ?></p>
                                <?php
                                echo   adforest_returnEcho($package_type_html);
                        if(get_user_meta($user_id, '_sb_user_type', true) != ""){
                            $user_type_meta = get_user_meta($user_id, '_sb_user_type', true);
                                            $user_type  = "";
                                            if ($user_type_meta == 'Indiviual') {
                                                $user_type = esc_html__('Indiviual', 'adforest');
                                            } else if ($user_type_meta == 'Dealer') {
                                                $user_type = esc_html__('Dealer', 'adforest');
                                            }
                             echo     '<span class="label label-success sb_user_type">' . $user_type . '</span>' ;

                            }
                                    echo   adforest_returnEcho ($badge );					                echo  $rating  ;
                                ?>
                            </div>
                        </div>
                        <hr class="w-100">
                        <div class="contact-info pt-4">
                            <h5 class="text-dark mb-1"><?php echo esc_html__('Contact Information', 'adforest'); ?></h5>
                            <p class="font-weight-medium pt-4 mb-2"><i class="fa fa-volume-control-phone"></i><?php echo esc_html__('Phone number', 'adforest') ?></p>
                            <p><?php echo esc_html(get_user_meta($user_id, '_sb_contact', true)) . $is_verified; ?> </p>
                            <p class="font-weight-medium pt-4 mb-2"><i class="fa fa-users"></i><?php echo esc_html__('Social Profile', 'adforest') ?></p>
                            <p class="pb-3 social-button">
                                <?php
                                echo adforest_returnEcho($social_icons);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="profile-content-right profile-right-spacing py-5">
                        <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="false"><?php echo esc_html__('Edit Profile', 'adforest') ?></a>
                            </li>
                        </ul>
                        <div class="tab-content px-3 px-xl-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby=edit-profile-tab>
                                <div class="tab-pane-content mt-5">

                                      <?php   wp_enqueue_script('google-map-callback');?>
                                     <?php adforest_load_search_countries(); ?>
                                    <form class="form-pill" id="sb_update_profile">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="sb_user_name"><?php echo esc_html__('Your Name', 'adforest') ?></label>
                                                    <input type="text" class="form-control" value="<?php echo esc_attr($user_info->display_name) ?>" name="sb_user_name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                             <label><?php echo __('Email Address', 'adforest')  ?> <span class="color-red">*</span></label>
                                            <input <?php echo esc_attr($email_name); ?> type="text" class="form-control margin-bottom-20" value="<?php echo esc_attr($user_info->user_email) ?>" <?php echo esc_attr($readonly) ?>>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label><?php echo __('Contact Number', 'adforest') ?><span class="color-red">*</span></label>
                                                    <input type="text" class="form-control margin-bottom-20" name="sb_user_contact" id="sb_user_contact" value="<?php echo esc_attr(get_user_meta($user_info->ID, '_sb_contact', true)) ?>" placeholder="<?php echo esc_attr($ph_placeholder) ?>">                                         
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label><?php echo __('I am', 'adforest') ?> <span class="color-red">*</span></label>
                                                    <select class="category form-control" name="sb_user_type">
                                                        <?php echo adforest_returnEcho($user_type_html) ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            echo adforest_returnEcho($social_html);
                                            echo '<div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 col-12">
                                                  <div class="form-group">
                                            <label>' . __('Location', 'adforest') . '</label>
                                            <input type="text" class="form-control margin-bottom-20" placeholder="' . __('Enter a location', 'adforest') . '"  name="sb_user_address" id="sb_user_address" autocomplete="on" value="' . esc_attr(get_user_meta($user_info->ID, '_sb_address', true)) . '">
                                                                    </div>
                                             </div>
                                                            <div class="col-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                            <label>' . __('Introduction', 'adforest') . ' <span class="color-red"></span></label>
                                            <textarea name="sb_user_intro" class="form-control" rows="6">' . esc_attr(get_user_meta($user_info->ID, '_sb_user_intro', true)) . '</textarea>
                                            </div>
                                              </div>                                                                                         
                                               <input type="hidden" id="adforest_profile_msg" value="' . __('Profile saved successfully.', 'adforest') . '" />
                                               <input type="hidden" id="sb-profile-token" value="' . wp_create_nonce('sb_profile_secure') . '" />
                                                   <a data-target="#myModal" data-toggle="modal" class="btn btn-success  btn-lg my-4">' . __('Change Password', 'adforest') . '</a>
                                                       ' . $delete_account_html . '
                                              <input class="btn btn-primary  btn-lg my-4" id="sb_user_profile_update"  type="submit" value = "' . esc_html__('Update My Info', 'adforest') . '" >
                                           ';
                                            ?>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                echo '<div id="myModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header rte">
                                                <h2 class="modal-title">' . __('Password Change', 'adforest') . '</h2>
                                            </div>
                                            <form id="sb-change-password">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>' . __('Current Password', 'adforest') . '</label>
                                                        <input placeholder="' . __('Current Password', 'adforest') . '" class="form-control" type="password"  name="current_pass" id="current_pass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>' . __('New Password', 'adforest') . '</label>
                                                        <input placeholder="' . __('New Password', 'adforest') . '" class="form-control" type="password" name="new_pass" id="new_pass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>' . __('Confirm New Password', 'adforest') . '</label>
                                                        <input placeholder="' . __('Confirm Password', 'adforest') . '" class="form-control" type="password" name="con_new_pass" id="con_new_pass">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" id="sb-profile-reset-pass-token" value="' . wp_create_nonce('sb_profile_reset_pass_secure') . '" />
                                                    <button class="btn btn-primary btn-pill" type="button" id="change_pwd">' . __('Reset My Account', 'adforest') . '</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>';
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Content -->
</div>
<?php
$sb_user_phone_num = get_user_meta($user_id, '_sb_contact', true);
$phone_verified_html = "";
if (isset($sb_user_phone_num) && $sb_user_phone_num != '' && !$is_firebase) {
    $phone_verified_html = '<form id="sb-ph-verification">
                                        <div class="modal-body">
                                           <div class="form-group sb_ver_ph_div">
                                             <label>' . __('Phone number', 'adforest') . '</label>
                                             <input class="form-control" value="' . esc_html($sb_user_phone_num) . '" type="text" name="sb_ph_number" id="sb_ph_number" readonly>
                                           </div>
                                           <div class="form-group sb_ver_ph_code_div no-display">
                                             <label>' . __('Enter code', 'adforest') . '</label>
                                             <input class="form-control" type="text" name="sb_ph_number_code" id="sb_ph_number_code">
                                               <small class="pull-right">' . __('Did not get code?', 'adforest') . ' <a href="javascript:void(0);" class="small_text" id="resend_now">' . __('Resend now', 'adforest') . '</a></small>
                                           </div>
                                        </div>
                                        <div class="modal-footer">
                                              <button class="btn btn-danger btn-pill" type="button" id="sb_verification_ph">' . __('Verify now', 'adforest') . '</button>
                                              <button class="btn btn-primary btn-pill no-display" type="button" id="sb_verification_ph_back">' . __('Processing ...', 'adforest') . '</button>
                                              <button class="btn btn-primary btn-pill no-display" type="button" id="sb_verification_ph_code">' . __('Verify now', 'adforest') . '</button>
                                        </div>
                                 </form>';
} else if ($is_firebase) {
    $phone_verified_html .= '<form id="sb-ph-verification">
    <div class="modal-body">           
        <div class="form-group sb_ver_ph_code_div ">
            <label>' . __('Enter code', 'adforest') . '</label>
            <input class="form-control" type="text" name="sb_ph_number_code" id="sb_ph_number_code">                                              
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger btn-pill" type="button" id="sb_verify_otp">' . __('Verify now', 'adforest') . '</button>
        <button class="btn btn-primary btn-pill no-display" type="button" id="sb_verification_ph_back">' . __('Processing ...', 'adforest') . '</button>
        <button class="btn btn-primary btn-pill  no-display" type="button" id="sb_verification_ph_code">' . __('Verify now', 'adforest') . '</button>

    </div>
</form>';
}
echo '<div class="custom-modal">
                            <div id="verification_modal" class="sb-verify-modal modal fade" role="dialog">
                               <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <span class="modal-title">' . __('Verify phone number', 'adforest') . '</span>
                                     </div>
                                      ' . $phone_verified_html . '
                                  </div>
                               </div>
                            </div>
                       </div>';

