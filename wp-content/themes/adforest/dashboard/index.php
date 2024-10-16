<?php
global $adforest_theme;
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$user_info = get_userdata(get_current_user_id());
$user_id = $user_info->ID;
$user_pic = adforest_get_user_dp($user_info->ID);
$sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
$logo = isset($adforest_theme['sb_dashboard_logo']['url']) ? $adforest_theme['sb_dashboard_logo']['url'] : ADFOREST_IMAGE_PATH . "/logo.png";
$sb_post_ad_page = isset($adforest_theme['sb_post_ad_page']) ? $adforest_theme['sb_post_ad_page'] : "";
$sb_post_ad_page = apply_filters('adforest_ad_post_verified_id', $sb_post_ad_page);
?>

<div class="header-fixed sidebar-fixed sidebar-dark header-light sidebar-minified-out">
    <div class="wrapper">
        <aside class="left-sidebar bg-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <div class="app-brand sb-dashboard-logo">
                    <a href="<?php echo esc_url(home_url()); ?>">
                        <img src="<?php echo adforest_returnEcho($logo) ?>" alt = "<?php echo esc_attr__('logo', 'adforest'); ?>">

                    </a>
                </div>          
                <div class="sidebar-scrollbar">
                    <ul class="nav sidebar-inner" id="sidebar-menu">
                        <li>
                            <a class="sidenav-item-link" href="<?php echo get_the_permalink() ?> ">
                                <i class="fa fa-tachometer"></i>
                                <span class="nav-text"><?php echo esc_html__('Dashboard', 'adforest'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo esc_url(home_url('/my-account/')); ?> ">
                                <i class="fa fa-user"></i>
                                <span class="nav-text"><?php echo esc_html__('My Account', 'adforest'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=my_profile"; ?>">
                                <i class="fa fa-users"></i>
                                <span class="nav-text"><?php echo esc_html__('Edit Profile', 'adforest'); ?></span> 
                            </a>
                        </li>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo adforest_set_url_param(get_author_posts_url($user_id), 'type', 'ads') ?>">
                                <i class="fa fa-user"></i>
                                <span class="nav-text"><?php echo esc_html__('View Profile', 'adforest'); ?></span> 
                            </a>
                        </li>

                        <li class="has-sub ">
                            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#ads_list" aria-expanded="false" aria-controls="ads_list">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="nav-text"><?php echo esc_html__('Manage Ads', 'adforest') ?></span> <b class="caret"></b>
                            </a>
                            <ul class="collapse " id="ads_list" data-parent="#sidebar-menu">
                                <div class="sub-menu">
                                    <li class="">
                                        <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=my_ads"; ?>">
                                            <span class="nav-text"><?php echo esc_html__('My Ads', 'adforest') ?></span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=feature_ads"; ?>">
                                            <span class="nav-text"><?php echo esc_html__('Featured Ads', 'adforest') ?></span>

                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=rej_ads"; ?>">
                                            <span class="nav-text"><?php echo esc_html__('Rejected Ads', 'adforest') ?></span>
                                        </a>
                                    </li>              
                                    <li class="">
                                        <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=inactive_ads"; ?>">
                                            <span class="nav-text"><?php echo esc_html__('Inactive Ads', 'adforest') ?></span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=expire_ads"; ?>">
                                            <span class="nav-text"><?php echo esc_html__('Expired / Sold Ads', 'adforest') ?></span>
                                        </a>
                                    </li> 

                                </div>
                            </ul>
                        </li>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=fav_ads"; ?>">
                                <i class="fa fa-heart"></i>
                                <span class="nav-text"><?php echo esc_html__('Favourite Ads', 'adforest') ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=msg"; ?>">
                                <i class="fa fa-comments"></i>
                                <span class="nav-text"><?php echo esc_html__('My Messages','adforest'); ?></span> 
                            </a>
                        </li>
                        <?php if (class_exists('SbPro')) {
                            echo apply_filters('sb_get_anchor', '', 'page_type', 'events');
                        } ?>

                        <?php if (class_exists('SbPro')) {
                            echo apply_filters('sb_get_booking_anchor', '', 'page_type', 'bookings');
                        } ?>

<?php if (isset($adforest_theme['allow_claim']) && $adforest_theme['allow_claim']) { ?>       
                            <li>
                                <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=claims"; ?>">
                                    <i class="fa fa-check"></i>
                                    <span class="nav-text"><?php echo esc_html__('Claims', 'adforest'); ?></span> 
                                </a>
                            </li>  
                            <?php
                        }
                        ?>
                        <li>
                            <a class="sidenav-item-link" href="<?php echo get_the_permalink() . "?page_type=alerts"; ?>">
                                <i class="fa fa-comments"></i>
                                <span class="nav-text"><?php echo esc_html__('Ad Alerts', 'adforest'); ?></span> 
                            </a>
                        </li>
                         <?php if (( class_exists('woocommerce'))) { ?>
                            <li>
                                <a class="sidenav-item-link" href="<?php echo esc_url(get_the_permalink($sb_packages_page)) ?>"  target = "_blank">
                                    <i class="fa fa-briefcase"></i>
                                    <span class="nav-text"><?php echo esc_html__('Packages', 'adforest'); ?></span> 
                                </a>
                            </li>
                            <?php } ?>
                    </ul>
                    <div class="dash-ad-post">
                        <a class="btn btn-theme"  href="<?php echo esc_url(get_the_permalink($sb_post_ad_page)); ?>"> 
                          <?php echo esc_html__('Post Ad', 'adforest'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        <div class="page-wrapper">
            <header class="main-header " id="header">
                <nav class="navbar navbar-static-top navbar-expand-lg">
                    <button id="sidebar-toggler" class="sidebar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                    </button>  
                    <div class="search-form d-none d-lg-inline-block">                      
                    </div>
                    <div class="navbar-right ">
                        <ul class="nav navbar-nav">
                            <li class="vendor_button"><?php print_r(apply_filters('adforest_vendor_role_assign_button', '', $user_id)); ?></li>
                            <li class="dropdown notifications-menu custom-dropdown">
                                <button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
                                    <i class="fa fa-bell-o"></i>
                                </button>
                                <div class="card card-default dropdown-notify dropdown-menu-right mb-0">
                                    <div class="card-header card-header-border-bottom px-3">
                                        <h2><?php echo esc_html__('Notifications', 'adforest') ?></h2>
                                    </div>
                                    <?php
                                    global $wpdb;
                                    $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC LIMIT 30", OBJECT);
                                    $unread_msgs = count($notes);
                                    ?>
                                    <div class="card-body px-0 py-3">
                                        <ul class="nav-tabs notify-info" id="myTab" role="tablist">

                                            <li><?php echo sprintf(esc_html__("You Have %s New Notification(S)",'adforest'),$unread_msgs) ?></li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent3">
                                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home2-tab">
                                                <ul class="list-unstyled notification-list-topbar" >
                                                    <?php
                                                    if ($unread_msgs > 0) {
                                                        if (count($notes) > 0) {
                                                            ?>
                                                            <?php
                                                            foreach ($notes as $note) {
                                                                $ad_img = adforest_get_ad_default_image_url('adforest-single-small');
                                                                $get_arr = explode('_', $note->meta_key);
                                                                $ad_id = $get_arr[0];
                                                                $media = adforest_get_ad_images($ad_id);
                                                                if (count($media) > 0) {
                                                                    $counting = 1;
                                                                    foreach ($media as $m) {
                                                                        if ($counting > 1) {
                                                                            $mid = '';
                                                                            if (isset($m->ID))
                                                                                $mid = $m->ID;
                                                                            else
                                                                                $mid = $m;

                                                                            $image = wp_get_attachment_image_src($mid, 'adforest-single-small');
                                                                            if ($image[0] != "") {
                                                                                $ad_img = $image[0];
                                                                            }
                                                                            break;
                                                                        }
                                                                        $counting++;
                                                                    }
                                                                }
                                                                $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                                                                $action = get_the_permalink($sb_profile_page) . '?sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1] . '&sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '"';
                                                                $poster_id = get_post_field('post_author', $ad_id);
                                                                if ($poster_id == $user_id) {
                                                                    $action = get_the_permalink($sb_profile_page) . '?page_type=msg&sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1];
                                                                }
                                                                $user_data = get_userdata($get_arr[1]);
                                                                $user_image = adforest_get_user_dp($get_arr[1]);
                                                                echo ' <li>
                                                        <a href="' . $action . '" class="media media-message media-notification">

                                                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 text-white">
                                                              <img src="' . esc_url($user_image) . '" alt="' . adforest_returnEcho($user_data->display_name) . '" class="notify-user-image">
                                                            </div>

                                                            <div class="media-body d-flex justify-content-between">
                                                                <div class="message-contents">
                                                                    <h4 class="title">' . $user_data->display_name . '</h4>
                                                                    <p class="last-msg font-size-14">' . get_the_title($ad_id) . '</p>

                                                                  
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>';
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>                                                                          
                                        </div>
                                    </div>
                                </div>                       
                            </li>

                            <li class="dropdown user-menu">
                                <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="<?php echo esc_url($user_pic) ?>" class="user-image" alt="<?php echo esc_attr__('image', 'adforest') ?>">
                                    <span class="d-none d-lg-inline-block"><?php echo esc_html($user_info->display_name) ?></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="dropdown-header">
                                        <img src="<?php echo esc_url($user_pic) ?>" class="img-circle" alt="<?php echo esc_attr__('image', 'adforest') ?>">
                                        <div class="d-inline-block">
<?php echo esc_html($user_info->display_name) ?> <small class="pt-1"><?php echo esc_html($user_info->email) ?></small>
                                        </div>
                                    </li>

                                    <li>
                                        <a href="<?php echo adforest_set_url_param(get_author_posts_url($user_id), 'type', 'ads') ?>">
                                            <i class="fa fa-user"></i> <?php echo esc_html__('My Profile', 'adforest') ?>
                                        </a>
                                    </li>

                                    <?php echo apply_filters('adforest_vendor_dashboard_profile' ,'',$user_id);?>

                                    <li>
                                        <a href="<?php echo get_the_permalink() . "?page_type=msg"; ?>">
                            <i class="fa fa-comments"></i>  <?php echo esc_html__('Messages','adforest') ?>
                                        </a>
                                    </li>                               
                                    <li class="dropdown-footer">
                                        <a href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page)); ?>"> <i class="fa fa-sign-out"></i><?php echo esc_html__('Log Out', 'adforest') ?></a>


                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <input type="hidden" value="<?php echo esc_html__('Confirm', 'adforest'); ?>"  id="confirm_btn">
            <input type="hidden" value="<?php echo esc_html__('Cancel', 'adforest'); ?>" id="cancel_btn"> 
            <input type="hidden" value="<?php echo esc_html__('Are you sure ?', 'adforest'); ?>" id="confirm_text"> 
            <input type="hidden" value="<?php echo esc_html__('Are you sure you want to purchase ?', 'adforest'); ?>" id="confirm_profile">
             <input type="hidden" value="<?php echo wp_is_mobile(); ?>" id="is_mobile"> 

            <input type="hidden" id="ad_info_text" value="<?php echo esc_html__('Ad info','adforest'); ?>">
            <?php
            if (isset($_GET['page_type']) && $_GET['page_type'] != "") {
                $rating = "";
                get_template_part('dashboard/template-parts/page', $_GET['page_type']);
            } else {
                /* rating */
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
                global $wpdb;
                $query = "
             select 
               concat(year(`post_date`), '-', month(`post_date`)) as `month`, 
                  count(1) as `cnt` 
               from 
                `$wpdb->posts`
              where 
                  (post_type='ad_post') and 
                `post_author` = $user_id 
                group by 
                `month` 
                 order by 
                 `post_date` desc   
                 ";  // change this to include more months. the default is 12 months in the past.

                $result = array_reverse($wpdb->get_results($query));

                $total_listing = array_reduce($result, function ($sum, $entry) {
                    $sum += $entry->cnt;
                    return $sum;
                }, 0);

                $total_listing_published = adforest_get_all_ads($user_id);

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


                $paid_html = "";
                if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                    if (get_user_meta($user_id, '_sb_expire_ads', true) != '-1') {
                        $expiry = get_user_meta($user_id, '_sb_expire_ads', true);
                    } else {
                        $expiry = __('Never', 'adforest');
                    }
                    if (get_user_meta($user_id, '_sb_simple_ads', true) != '-1' && get_user_meta($user_id, '_sb_simple_ads', true) >= 0) {
                        $free_ads = get_user_meta($user_id, '_sb_simple_ads', true);
                    } else {
                        $free_ads = __('Unlimited', 'adforest');
                    }
                    if (get_user_meta($user_id, '_sb_featured_ads', true) != '-1') {
                        $featured_ads = get_user_meta($user_id, '_sb_featured_ads', true);
                    } else {
                        $featured_ads = __('Unlimited', 'adforest');
                    }
                   
                    if (get_user_meta($user_id, '_sb_bump_ads', true) != '-1') {
                        $bump_ads = get_user_meta($user_id, '_sb_bump_ads', true);
                    } else {
                        $bump_ads = __('Unlimited', 'adforest');
                    }


                    if (get_user_meta($user_id, 'package_ad_expiry_days', true) == '-1') {
                         $package_ad_expiry_days = __('Unlimited', 'adforest');
                       
                    } else {
                        $package_ad_expiry_days = get_user_meta($user_id, 'package_ad_expiry_days', true);
                    }


                    if (get_user_meta($user_id, 'package_adFeatured_expiry_days', true) == '-1') {
                         $package_adFeatured_expiry_days = __('Unlimited', 'adforest');
                       
                    } else {
                        $package_adFeatured_expiry_days = get_user_meta($user_id, 'package_adFeatured_expiry_days', true);

                    }

                    $pkg_type_str = '';
                    $profile_td_pkg = get_user_meta($user_id, '_sb_pkg_type', true);
                    if (isset($profile_td_pkg) && $profile_td_pkg == 'free') {
                        $pkg_type_str = __('Free', 'adforest');
                    } else {
                        $pkg_type_str = $profile_td_pkg;
                    }


                    $new_package_features = '';

                    $yes_no_arr = array(
                        'yes' => __('Yes', 'adforest'),
                        'no' => __('No', 'adforest'),
                    );

                    $_sb_video_links = get_user_meta($user_id, '_sb_video_links', true);
                    $_sb_video_links = isset($_sb_video_links) && !empty($_sb_video_links) && ($_sb_video_links == 'yes' || $_sb_video_links == 'no') ? $yes_no_arr[$_sb_video_links] : __('No','adforest_theme');

                    $_sb_allow_tags = get_user_meta($user_id, '_sb_allow_tags', true);
                    $_sb_allow_tags = isset($_sb_allow_tags) && !empty($_sb_allow_tags) && ($_sb_allow_tags == 'yes' || $_sb_allow_tags == 'no') ? $yes_no_arr[$_sb_allow_tags] : __('No','adforest_theme');


                    $bidding_ads  = __('No','adforest_theme');
                    if (get_user_meta($user_id, '_sb_allow_bidding', true) != '-1' && get_user_meta($user_id, '_sb_allow_bidding', true) >= 0) {
                        $bidding_ads = get_user_meta($user_id, '_sb_allow_bidding', true);
                    } 

                    if(get_user_meta($user_id, '_sb_allow_bidding', true) == -1){
                       $bidding_ads =   esc_html__('Unlimited','adforest');
                    }

                    $inner_htmll = '';

                    $selected_categories = get_user_meta($user_id, "package_allow_categories", true);
                    $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
                    $selected_categories_arr = array();
                    if ($selected_categories != '') {
                        $selected_categories_arr = explode(",", $selected_categories);
                    }

                    $cat_list_ = '';

                    $rand = rand(123, 9999);
                    $single_pop_script = "";
                    $poped_over_id = 'popover-' . $rand;
                    $poped_over = 'category_package_list_' . $rand;
                    if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {
                        if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] != 'all') {
                            $cat_list_ .= '<div  class="' . $poped_over . '"  style="display:block;" ><ul>';
                            foreach ($selected_categories_arr as $single_cat_id) {
                                $category = get_term($single_cat_id);
                                $cat_list_ .= '<li > <i class="fa fa-check"></i> ' . $category->name . '</li>';
                                $single_pop_script .= 'jQuery(\'#' . $poped_over_id . '\').popover({
                                                            html: true,
                                                            content: function () {
                                                                return jQuery(\'.' . $poped_over . '\').html();
                                                            }
                                                        });';
                            }
                            $cat_list_ .= '</ul></div>';
                        }
                    }



                    $is_bidding_paid = isset($adforest_theme['sb_make_bid_categorised']) ? $adforest_theme['sb_make_bid_categorised'] : false;
                    $user_paid_biddings = get_user_meta($user_id, '_sb_paid_biddings', true);
                    $paid_biddings = $paid_biddings_html = "";

                    if ($is_bidding_paid) {

                        $paid_biddings_html = ' <tr><td>' . __('Paid biddings', 'adforest') . '</td>
                                           <td class="text-right">
                       ' . $user_paid_biddings . '   </td>';
                    }




                    $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;
                    $user_packages_images = get_user_meta($user_id, '_sb_num_of_images', true);

                    if (isset($user_packages_images) && $user_packages_images == '-1') {
                        $user_upload_max_images = __('Unlimited', 'adforest');
                    } elseif (isset($user_packages_images) && $user_packages_images > 0) {
                        $user_upload_max_images = $user_packages_images;
                    } else {
                        $user_upload_max_images = $sb_upload_limit_admin;
                    }

                
                    $number_of_events_html   = "";
                   if(class_exists('SbPro')){
                     $number_of_events  = get_user_meta($user_id, 'number_of_events', true);
                     if($number_of_events != ""){
                          $number_of_events =  $number_of_events == "-1"  ?   esc_html__('Unlimited','adforest') : $number_of_events;
                         $number_of_events_html .= '<tr><td>' . __('Number of events', 'adforest') . ' </td>
                      <td class="text-right">
                         ' . $number_of_events . '
                       </td></tr>';
                     }
                   }

                    $new_package_features .= '<tr><td>' . __('Allowed Video link', 'adforest') . ' </td>
					  <td class="text-right">
					     ' . $_sb_video_links . '
					   </td></tr>';

                    $new_package_features .= '<tr><td>' . __('Allowed Tags', 'adforest') . ' </td>
					  <td class="text-right">
					     ' . $_sb_allow_tags . '
					   </td></tr>';

                    if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] == true) {
                        $new_package_features .= '<tr><td>' . __('Allowed Bidding', 'adforest') . '</td>
					  <td class="text-right">' . $bidding_ads . '</td></tr>';
                    }

                    $new_package_features .= '<tr><td>' . __('Allowed Images', 'adforest') . ' </td>
					  <td class="text-right">
					     ' . $user_upload_max_images . '
					   </td></tr>';

                    if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {
                        if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] == 'all') {
                            $new_package_features .= '<tr><td class="price-category">' . __('Categories ', 'adforest') . '</td><td class="text-right">' . __('All ', 'adforest') . ' </td></tr>';
                        } else {
                            $new_package_features .= '<tr><td>' . __(' Categories ', 'adforest') . '</td><td> <span id="' . $poped_over_id . '" class="price-category cat-profile" data-placement="top" data-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '"> ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i></span> ' . $cat_list_ . '</td>';
                        }
                    } else {
                        $new_package_features .= '<tr><td>' . __(' Categories', 'adforest') . '</td>
					  <td class="text-right">
					     '.__('No','adforest_theme').'
					   </td></tr>';
                    }





                    $paid_html = '<tr><td class="text-dark">' . __('Package Type', 'adforest') . ' </td>
					<td class="text-right">
					   ' . adforest_returnEcho($pkg_type_str) . '
					</td>
                                        </tr>
                                        <tr><td class="text-dark">' . __('Package Expiry', 'adforest') . ' </td>
					<td class="text-right">
					   ' . $expiry . '
					</td>
                                         </tr>
					<tr><td>' . __('Free Ads Remaining', 'adforest') . ' </td>
					<td class="text-right">
					   ' . $free_ads . '
					</td>
                                         </tr>
                        </tr>
                    <tr><td>' . __('Simple ads expiry days', 'adforest') . ' </td>
                    <td class="text-right">
                       ' . $package_ad_expiry_days . '
                    </td>
                                         </tr>

					<tr><td>' . __('Featured Ads Remaining', 'adforest') . ' </td>
					<td class="text-right">
					   ' . $featured_ads . '
					</td>
                                        </tr>

                                         <tr><td>' . __('Featured ads expiry days', 'adforest') . ' </td>
                    <td class="text-right">
                       ' . $package_adFeatured_expiry_days . '
                    </td>
                                         </tr>

					<tr><td>' . __('Bump-up Ads Remaining', 'adforest') . '</td>
					<td class="text-right">
					   ' . $bump_ads . '
					</td>
                                        </tr>

                                        ' . $new_package_features . '
                                      
                                         ' . $paid_biddings_html . '
                                         '.$number_of_events_html.'
                                        ';
                                        
                }
                ?>
                <div class="content-wrapper">
                    <div class="content">
                        
                        <!-- First Row  -->

                        <?php
                        if (isset($adforest_theme['sb_show_profile_stat']) && $adforest_theme['sb_show_profile_stat']) {
                            echo ' <div class="row"><div class="col-md-6 col-lg-6 col-xl-3">
                              <a href="'. get_the_permalink() . "?page_type=expire_ads" .'"> 
                                <div class="media widget-media p-4 bg-white border">
                                    <div class="icon rounded-circle mr-4 bg-primary">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mb-2">' . adforest_get_sold_ads($user_id) . '</h4>
                                        <p>' . __('Ad Sold', 'adforest') . '</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                            <a href="'. get_the_permalink() . "?page_type=my_ads" .'"> 
                                <div class="media widget-media p-4 bg-white border">
                                    <div class="icon rounded-circle bg-warning mr-4">
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    </div>

                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mb-2">' . $total_listing_published . '</h4>
                                        <p>' . __('Total Listings', 'adforest') . '</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                            <a href="'. get_the_permalink() . "?page_type=inactive_ads" .'"> 
                                <div class="media widget-media p-4 bg-white border">
                                    <div class="icon rounded-circle mr-4 bg-danger">
                                        <i class="fa fa-ban"></i>
                                    </div>

                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mb-2">' . adforest_get_disbale_ads($user_id) . '</h4>
                                        <p>' . __('Inactive ads', 'adforest') . '</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                            <a href="'. adforest_set_url_param(get_author_posts_url($user_id), 'type', 1) .'"> 
                                <div class="media widget-media p-4 bg-white border">
                                    <div class="icon bg-success rounded-circle mr-4">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mb-2">' . count(adforest_get_all_ratings($user_id)) . '</h4>
                                        <p>' . __('Total ratings', 'adforest') . '</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>';
                        }
                        ?>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xl-4">
                                <div class="card card-default" profile-data-height="">
                                    <div class="card-header">
                                        <h2><?php echo esc_html__('Profile', 'adforest') ?></h2>
                                    </div>
                                    <div class="card-body text-center profile-main-body">
                                        <img class="rounded-circle d-flex mx-auto" src="<?php echo esc_url($user_pic) ?>" alt="<?php echo esc_attr__('image', 'adforest'); ?>">
                                        <h4 class="py-2 text-dark"><?php echo esc_html($user_info->display_name) ?></h4>
                                        <?php echo adforest_returnEcho($rating); ?>
                                        <p><?php echo esc_html($user_info->user_email) ?></p>

                                        <p class="description"><?php echo __('Last active', 'adforest') . ': ' . adforest_get_last_login($user_id) . ' ' . __('Ago', 'adforest') . ' ' ?></p>

                                        <?php
                                        echo adforest_returnEcho($package_type_html);

                                        if (get_user_meta($user_id, '_sb_user_type', true) != "") {

                                            $user_type_meta = get_user_meta($user_id, '_sb_user_type', true);
                                            $user_type  = "";
                                            if ($user_type_meta == 'Indiviual') {
                                                $user_type = esc_html__('Indiviual', 'adforest');
                                            } else if ($user_type_meta == 'Dealer') {
                                                $user_type = esc_html__('Dealer', 'adforest');
                                            }
                                            echo '<span class="label label-success sb_user_type">' . $user_type . '</span>';
                                        }

                                        echo adforest_returnEcho($badge);
                                        ?>
                                    </div>
                                    <div class="justify-content-between px-5 pb-4">
                                        <p  class="social-button user-social-icon">
    <?php echo adforest_words_count(get_user_meta($user_id, '_sb_user_intro', true), 120) ?>
                                        </p>
                                    </div>
                                    <div class="card-footer  bg-white p-0">
                                        <div class="text-center p-4">
                                            <p class="pb-3 social-button">
    <?php
    echo adforest_returnEcho($social_icons);
    ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xl-8">

                                <!-- Sales Graph -->
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h2><?php echo esc_html__('Ads statistics', 'adforest') ?></h2>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="linechart" class="chartjs"></canvas>
                                    </div>
                                    <div class="card-footer d-flex flex-wrap bg-white p-0">

                                        <div class="col-6 px-0">
                                            <div class="text-center p-4 border-left">
                                                <h4><?php echo esc_html($total_listing) ?></h4>
                                                <p class="mt-2"><?php echo esc_html__('Total Ads posted by you', 'adforest') ?></p>
                                            </div>
                                        </div>
                                        <div class="col-6 px-0">
                                            <div class="text-center p-4">
                                                <h4><?php echo esc_html($total_listing_published); ?></h4>
                                                <p class="mt-2"><?php echo esc_html__('Total Published ad', 'adforest') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                         <?php
                          $pay_per_post_check = isset($adforest_theme['sb_pay_per_post_option']) ? $adforest_theme['sb_pay_per_post_option'] : false;
                          if(!$pay_per_post_check) {
                         ?>
                            <div class="col-xl-6 col-lg-6 col-12">
                                <!-- Top Sell Table -->
                                <div class="card card-table-border-none">
                                    <div class="card-header justify-content-between">
                                        <h2><?php echo esc_html__('Package Detail', 'adforest') ?></h2>
                                    </div>
                                    <div class="card-body py-0 package-details" data-simplebar="" >
                                        <table class="table ">
                                            <tbody>
                                        <?php echo adforest_returnEcho($paid_html) ?>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>
                            <?php
                            }else{
                                ?>

                                <div class="col-xl-6 col-lg-6 col-12">
                                <!-- Top Sell Table -->
                                <div class="card card-table-border-none">
                                    <div class="card-header justify-content-between">
                                        <h2><?php echo esc_html__('Pay Per Post', 'adforest') ?></h2>
                                    </div>
                                    <div class="card-body py-0 package-details" data-simplebar="" >
                                        <table class="table ">
                                            <tbody>
                                       
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>
                            <?php
                            }
                            ?>

                            <div class="col-xl-6 col-12">

                                <!-- Notification Table -->
                                <div class="card card-default">
                                    <div class="card-header justify-content-between mb-1">
                                        <h2><?php echo esc_html__('Latest Notifications', 'adforest') ?></h2>

                                    </div>
                                    <div class="card-body compact-notifications sms-notification-admin"  data-simplebar="">

                                        <?php
                                        if ($unread_msgs > 0) {
                                            if (count($notes) > 0) {
                                                ?>
                                                <?php
                                                foreach ($notes as $note) {
                                                    $ad_img = adforest_get_ad_default_image_url('adforest-single-small');
                                                    $get_arr = explode('_', $note->meta_key);
                                                    $ad_id = $get_arr[0];
                                                    $media = adforest_get_ad_images($ad_id);
                                                    if (count($media) > 0) {
                                                        $counting = 1;
                                                        foreach ($media as $m) {
                                                            if ($counting > 1) {
                                                                $mid = '';
                                                                if (isset($m->ID))
                                                                    $mid = $m->ID;
                                                                else
                                                                    $mid = $m;

                                                                $image = wp_get_attachment_image_src($mid, 'adforest-single-small');
                                                                if ($image[0] != "") {
                                                                    $ad_img = $image[0];
                                                                }
                                                                break;
                                                            }
                                                            $counting++;
                                                        }
                                                    }
                                                    $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                                                    $action = get_the_permalink($sb_profile_page) . '?sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1] . '&sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '"';
                                                    $poster_id = get_post_field('post_author', $ad_id);
                                                    if ($poster_id == $user_id) {
                                                        $action = get_the_permalink($sb_profile_page) . '?page_type=msg&sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1];
                                                    }
                                                    $user_data = get_userdata($get_arr[1]);
                                                    $user_image = adforest_get_user_dp($get_arr[1]);
                                                    ?> 


                                                    <div class="media py-3 align-items-center justify-content-between">
                                                        <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-success text-white">
                                                            <a href="<?php echo esc_url($action); ?>">   <img src="<?php echo esc_url($user_image); ?>" alt="<?php echo isset($user_data->display_name) ? esc_attr($user_data->display_name) : ""; ?>" class="notify-user-image"> </a>
                                                        </div>
                                                        <div class="media-body pr-3">
                                                            <a class="mt-0 mb-1 font-size-15 text-dark" href="<?php echo adforest_set_url_param(get_author_posts_url($get_arr[1]), 'type', 'ads') ?>"><?php echo isset($user_data->display_name) ? esc_attr($user_data->display_name) : ""; ?></a>
                                                            <p><?php echo get_the_title($ad_id); ?></p>
                                                        </div>

                                                    </div>

                                                <?php } ?>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <div class="media py-3 align-items-center justify-content-between">

                                                <div class="media-body pr-3">                                          
                                                    <p><?php echo esc_html__('You Have 0 New Notification(S)', 'adforest') ?></p>                                                                          
                                                </div>
                                            </div>
        <?php
    }
    ?>     

                                    </div>
                                    <div class="mt-3"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
<?php }
?>
            <!-- ====================================
            ——— CONTENT WRAPPER
            ===================================== --> 
            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        <?php
                        $footer_text = isset($adforest_theme['sb_dashbboard_footer']) ? $adforest_theme['sb_dashbboard_footer'] : "";
                        echo adforest_returnEcho($footer_text);
                        ?>
                    </p>
                </div>
                <input type="hidden" id="adforest_ajax_url"  value="<?php echo apply_filters('adforest_set_query_param', admin_url('admin-ajax.php')) ?>">
                <input type="hidden" id="verification-notice" value="<?php echo esc_html__('Verification code has been sent to ', 'adforest'); ?>" />
            </footer>

        </div> <!-- End Page Wrapper -->
    </div>
</div>
<?php
// reverse the data to get a normal logic flow
$labels = "";
$data = "";

if (isset($result) && $result) {
    foreach ($result as $month) {
        $labels .= '"' . $month->month . '", ';
        $data .= $month->cnt . ',';
    }
} else {
    for ($i = 6; $i >= 1; $i--) {
        $months[] = date("Y-m%", strtotime(date('Y-m-01') . " -$i months"));
        $labels .= '"' . date("Y-m", strtotime(date('Y-m-01') . " -$i months")) . '", ';
        $data .= 0 . ",";
    }
}


$scrtpt = '';

$current_page = isset($_GET['page_type']) ? $_GET['page_type'] : "";

if ($current_page != "events") {
    ?>
    <script language="Javascript">
        window.onload = function () {
            if (document.getElementById("linechart")) {

                var ctx = document.getElementById("linechart").getContext("2d");
                ;
                if (ctx !== null) {
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: "line",
                        // The data for our dataset
                        data: {
                            labels: [
    <?php
    echo adforest_returnEcho($labels);
    ?>
                            ],
                            datasets: [{
                                    label: "", backgroundColor: "transparent",
                                    borderColor: "rgb(82, 136, 255)",
                                    data: [
    <?php
    echo adforest_returnEcho($data);
    ?>

                                    ],
                                    lineTension: 0.3,
                                    pointRadius: 5,
                                    pointBackgroundColor: "rgba(255,255,255,1)",
                                    pointHoverBackgroundColor: "rgba(255,255,255,1)",
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 8,
                                    pointHoverBorderWidth: 1
                                }
                            ]
                        },

                        // Configuration options go here
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            layout: {
                                padding: {
                                    right: 10
                                }
                            },
                            scales: {
                                xAxes: [
                                    {
                                        gridLines: {
                                            display: false
                                        }
                                    }
                                ],
                                yAxes: [
                                    {
                                        gridLines: {
                                            display: true,
                                            color: "#eee",
                                            zeroLineColor: "#eee",
                                        },
                                        ticks: {
                                            callback: function (value) {
                                                var ranges = [
                                                    {divider: 1e6, suffix: "M"},
                                                    {divider: 1e4, suffix: "k"}
                                                ];
                                                function formatNumber(n)
                                                {
                                                    console.log(ranges.length);
                                                    for (var i = 0; i < ranges.length; i++) {
                                                        if (n >= ranges[i].divider) {
                                                            return (
                                                                    (n / ranges[i].divider).toString() + ranges[i].suffix
                                                                    );
                                                        }
                                                    }
                                                    return n;
                                                }
                                                return formatNumber(value);
                                            }
                                        }
                                    }
                                ]
                            },
                            tooltips: {
                                callbacks: {
                                    title: function (tooltipItem, data) {
                                        return data["labels"][tooltipItem[0]["index"]];
                                    },
                                    label: function (tooltipItem, data) {
                                        return  data["datasets"][0]["data"][tooltipItem["index"]] + "   <?php echo esc_html__('Ads', 'adforest') ?>";
                                    }
                                },
                                responsive: true,
                                intersect: false,
                                enabled: true,
                                titleFontColor: "#888",
                                bodyFontColor: "#555",
                                titleFontSize: 12,
                                bodyFontSize: 18,
                                backgroundColor: "rgba(256,256,256,0.95)",
                                xPadding: 20,
                                yPadding: 10,
                                displayColors: false,
                                borderColor: "rgba(220, 220, 220, 0.9)",
                                borderWidth: 2,
                                caretSize: 10,
                                caretPadding: 15
                            }
                        }
                    });
                }
            }
        }
    </script>

<?php
}