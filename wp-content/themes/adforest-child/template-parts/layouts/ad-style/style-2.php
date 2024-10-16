<?php
global $adforest_theme;
$pid = get_the_ID();
$type = $adforest_theme['cat_and_location'];
$poster_id = get_post_field('post_author', $pid);
$user_pic = adforest_get_user_dp($poster_id);
$allow_whatsapp = isset($adforest_theme['sb_ad_whatsapp_chat']) ? $adforest_theme['sb_ad_whatsapp_chat'] : false;
$allow_whizchat = isset($adforest_theme['sb_ad_whizchat_chat']) ? $adforest_theme['sb_ad_whizchat_chat'] : false;
$contact_num = get_user_meta($poster_id, '_sb_contact', true);
if ($contact_num == "") {
    $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
}
$ad_status = get_post_meta($pid, '_adforest_ad_status_', true);
$address = get_post_meta($pid, '_adforest_ad_location', true);

 
 


?>
<section class="ad-detail-2">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="ad-detail-2-main-section">
                    <div class="row">
                        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                            <div class="ad-detail-2-img">
                                <?php get_template_part('template-parts/layouts/ad-style/slider', '1'); ?>
                                <?php get_template_part('template-parts/layouts/ad-style/status', 'watermark'); ?>
                            </div>
                        </div>
                        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                            <div class="ad-detail-2-content-heading">
                             <?php if(isset($adforest_theme['sb_show_ad_id']) && $adforest_theme['sb_show_ad_id'] ){
                           ?>
                              <p class="sb_ad"> ID :  <?php echo $pid; ?> </p>
                       <?php  }
                       ?>                           
                                <ul class="ad-detail-2-category">
                                    <?php
                                    $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'parent'));
                                    foreach ($post_categories as $c) {
                                        $cat = get_term($c);
                                        if ($type == 'search') {
                                            $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                                            $link = get_the_permalink($sb_search_page) . '?cat_id=' . $cat->term_id;
                                        } else {
                                            $link = get_term_link($cat->term_id);
                                        }

                                        echo '<li><a href="' . $link . '" class="home-item">' . esc_html($cat->name) . '</a></li>';
                                    }
                                    ?>
                                </ul>
                                <h1><?php echo esc_html(get_the_title()) ?></h1>
                                <ul class="ad-detail-2-posted">
                                    <li><a href="javascript:void(0)" class="ad-detail-2-date" alt="<?php echo esc_attr__('void', 'adforest'); ?>"><?php echo esc_html__('Posted:', 'adforest') ?></a><span><?php echo get_the_date(); ?></span></li>
                                    <li><a href="javascript:void(0)" class="ad-detail-2-view" alt="<?php echo esc_attr__('void', 'adforest'); ?>"><?php echo esc_html__('Views:', 'adforest') ?></a><span><?php
                                            if (class_exists('Post_Views_Counter')) {
                                                $pre_view = (int) adforest_getPostViews($pid);
                                                $ad_view = (int) pvc_get_post_views($pid);
                                                $total_view = $pre_view + $ad_view;
                                                echo adforest_returnEcho($total_view);
                                            } else {
                                                echo adforest_getPostViews($pid);
                                            }
                                            ?></span></li>


                                    <?php
                                    $is_demo = adforest_is_demo();

                                    if (!$is_demo && get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) {
                                        $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
                                        $ad_update_url = adforest_set_url_param(get_the_permalink($sb_post_ad_page), 'id', $pid);
                                        ?><li><a href="<?php echo esc_url($ad_update_url); ?>"><?php echo __('Edit', 'adforest'); ?></a></li><?php }
                                    ?>
                                </ul>
                                <?php if (get_post_meta($pid, '_adforest_ad_location', true) != "") { ?>
                                    <span class="ad-location"><i class="fa fa-map-marker"></i><?php echo get_post_meta($pid, '_adforest_ad_location', true); ?><span></span></span>
                                <?php } ?>

                                <?php
                                $price_type = get_post_meta($pid, '_adforest_ad_price_type', true);
                                if ($price_type == "no_price") {
                                    
                                } else {
                                    echo '<h4>' . adforest_adPrice($pid, 'negotiable-single', '') . '</h4>';
                                }

                                get_template_part('template-parts/layouts/ad-style/short', 'features');
                                ?>
                                <div class="row">                               
                                    <?php if (get_post_meta($pid, '_adforest_ad_type', true) != "") { ?>
                                        <div class="col-xxl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="ad-detail-2-ad-type">
                                                <?php
                                                $link1 = trailingslashit(get_template_directory_uri()) . 'images/sell-1.png';
                                                $link2 = trailingslashit(get_template_directory_uri()) . 'images/sell-2.png';
                                                ?>
                                                <div class="ad-detail-2-sell-content">
                                                    <img src="<?php echo esc_url($link1); ?>" alt="<?php echo esc_html__('ad type', 'adforest'); ?>"> <span class="ad-type-text"><?php echo get_post_meta($pid, '_adforest_ad_type', true); ?></span>
                                                    <span class="ad-detail-2-sell-icon"><img src="<?php echo esc_url($link2); ?>" alt="<?php echo esc_html__('ad type', 'adforest'); ?>"></span>
                                                </div>                           
                                            </div>  
                                        </div>
                                    <?php }
                                    ?>
                                    <?php
                                    if ($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone') {
                                        $call_now = 'javascript:void(0);';
                                        if (wp_is_mobile())
                                            $call_now = 'tel:' . adforest_get_CallAbleNumber(get_post_meta($pid, '_adforest_poster_contact', true));

                                        $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                                        $batch_text = '';
                                        if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification']) {
                                            $contact_num = get_user_meta($poster_id, '_sb_contact', true);
                                            if ($contact_num != "") {
                                                if (get_user_meta($poster_id, '_sb_is_ph_verified', true) == '1') {
                                                    $batch_text = __('Verified', 'adforest');
                                                } else {
                                                    $batch_text = __('Not verified', 'adforest');
                                                }
                                            } else {
                                                $contact_num = get_post_meta($pid, '_adforest_poster_contact', true);
                                                $batch_text = __('Not verified', 'adforest');
                                            }
                                        }
                                        if ($contact_num != "") {
                                            if (adforest_showPhone_to_users()) {
                                                $contact_num = __("Login To View", "adforest");
                                                $call_now = "javascript:void(0)";
                                                $adforest_login_page = isset($adforest_theme['sb_sign_in_page']) ? $adforest_theme['sb_sign_in_page'] : '';
                                                $adforest_login_page = apply_filters('adforest_language_page_id', $adforest_login_page);
                                                if ($adforest_login_page != '') {

                                                    $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                                                    $call_now = $redirect_url;
                                                }
                                                ?>
                                                <div class="col-xxl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="ad-detail-2-click-view phone">
                                                        <a data-ad-id="<?php echo intval($pid); ?>"  href="<?php echo adforest_returnEcho($call_now); ?>" class="sb-click-num2" id="show_ph_div">
                                                            <span class="info-heading"><i class="fa fa-phone"></i><?php echo esc_html__('Phone :', 'adforest') ?></span>
                                                            <span class="sb-phonenumber"><?php echo __('Login to view', 'adforest'); ?></span>
                                                            <?php if ($batch_text != "") { ?>
                                                                <small class="sb-small">-<?php echo adforest_returnEcho($batch_text); ?></small><?php } ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>

                                                <div class="col-xxl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="ad-detail-2-click-view phone">
                                                        <a data-ad-id="<?php echo intval($pid); ?>"  href="<?php echo adforest_returnEcho($call_now); ?>" class="sb-click-num" id="show_ph_div">
                                                            <span class="info-heading"><i class="fa fa-phone"></i><?php echo esc_html__('Phone :', 'adforest') ?></span>
                                                            <span class="sb-phonenumber"><?php echo __('Click to view', 'adforest'); ?></span>
                                                            <?php if ($batch_text != "") { ?>
                                                                <small class="sb-small">-<?php echo adforest_returnEcho($batch_text); ?></small><?php } ?>
                                                        </a>
                                                    </div>
                                                </div>






                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ad-detail-2-details">
    <div class="container">
        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="ad-detail-2-feature">
                    <?php get_template_part('template-parts/layouts/ad-style/ad', 'status'); ?>
                    <?php get_template_part('template-parts/layouts/ad-style/rearrange', 'notification'); ?>
                    <?php get_template_part('template-parts/layouts/ad-style/feature', 'notification'); ?>
                    <div class="ad-detail-2-feature-banner">
                        <?php
                        if (isset($adforest_theme['style_ad_720_1']) && $adforest_theme['style_ad_720_1'] != "") {
                            ?>
                            <?php echo adforest_returnEcho($adforest_theme['style_ad_720_1']); ?>                           
                            <?php
                        }
                        ?>
                    </div>

                    <div class="ad-detail-2-short-features">
                        <h2><?php echo esc_html__('Description', 'adforest') ?></h2>

                        <div class="desc-points">
                            <?php
                            $contents = get_the_content();
                            $contents = apply_filters('the_content', $contents);
                            echo adforest_returnEcho($contents);
                            ?>
                        </div>
                        <?php do_action('adforest_owner_text'); ?>
                    </div>
                    <?php get_template_part('template-parts/layouts/ad-style/ad', 'tags'); ?>
                    <?php
                    if (get_post_meta($pid, '_adforest_ad_yvideo', true) != "") {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($pid, '_adforest_ad_yvideo', true), $match);

                        if (isset($match[1]) && $match[1] != "") {

                            $video_id = $match[1];
                            ?><div class="ad-detail-video"><div id="video">

                                    <h3><?php echo esc_html__('Video', 'adforest') ?></h3>
                                    <?php
                                    $iframe = 'iframe';
                                    echo '<' . $iframe . ' width="560" height="450" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></' . $iframe . '>';
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    if (isset($adforest_theme['allow_lat_lon']) && $adforest_theme['allow_lat_lon']) {
                        ?>          
                        <div id="map-location" class="map-location"> 
                            <h3><?php echo esc_html__('Location', 'adforest') ?></h3>
                            <?php
                            if (get_post_meta($pid, '_adforest_ad_location', true) != "") {

                                echo '<span><i class="fa fa-map-marker"></i>' . get_post_meta($pid, '_adforest_ad_location', true) . '</span>';
                            }
                            ?>
                            <?php
                            $map_lat = get_post_meta($pid, '_adforest_ad_map_lat', true);
                            $map_long = get_post_meta($pid, '_adforest_ad_map_long', true);
                            if ($map_lat != "" && $map_long != "") {
                                ?>
                                <div id="itemMap" style="width: 100%; height: 370px; margin-bottom:5px;"></div>
                                <input type="hidden" id="lat" value="<?php echo esc_attr($map_lat); ?>" />
                                <input type="hidden" id="lon" value="<?php echo esc_attr($map_long); ?>" />
                                <?php
                            } else {
                                $res_arr = adforest_get_latlon($address);
                                if (isset($res_arr) && count($res_arr) > 0) {
                                    ?>
                                    <div id="itemMap" style="width: 100%; height: 370px; margin-bottom:5px;"></div>
                                    <input type="hidden" id="lat" value="<?php echo esc_attr($res_arr[0]); ?>" />
                                    <input type="hidden" id="lon" value="<?php echo esc_attr($res_arr[1]); ?>" />
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                        if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                            echo adforest_html_bidding_system($pid);
                        } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                            
                        } else {
                            echo adforest_html_bidding_system($pid);
                        }
                        ?>
                    <?php } ?>
                    <?php
                    if (isset($adforest_theme['sb_ad_rating']) && $adforest_theme['sb_ad_rating']) {
                        get_template_part('template-parts/layouts/ad-style/ad', 'rating');
                    }
                    ?>
                     <div class="ad-detail-2-feature-banner">
                        <?php
                        if (isset($adforest_theme['style_ad_720_2']) && $adforest_theme['style_ad_720_2'] != "") {
                            ?>
                            <?php echo adforest_returnEcho($adforest_theme['style_ad_720_2']); ?>                           
                            <?php
                        }
                        ?>
                    </div>

                </div>

            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="ad-detail-2-icon">
                    <ul class="cont-icon-list">
                        <li><a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads'); ?>" ><svg class="iconify icon-start" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.86em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1792"><path d="M1201 784q47 14 89.5 38t89 73t79.5 115.5t55 172t22 236.5q0 154-100 263.5T1195 1792H341q-141 0-241-109.5T0 1419q0-131 22-236.5t55-172T156.5 895t89-73t89.5-38q-79-125-79-272q0-104 40.5-198.5T406 150T569.5 40.5T768 0t198.5 40.5T1130 150t109.5 163.5T1280 512q0 147-79 272zM768 128q-159 0-271.5 112.5T384 512t112.5 271.5T768 896t271.5-112.5T1152 512t-112.5-271.5T768 128zm427 1536q88 0 150.5-71.5T1408 1419q0-239-78.5-377T1104 897q-145 127-336 127T432 897q-147 7-225.5 145T128 1419q0 102 62.5 173.5T341 1664h854z" fill="#626262"/></svg></a></li>
                        <?php
                        if (isset($adforest_theme['share_ads_on']) && $adforest_theme['share_ads_on']) {
                            ?>
                            <li><a data-bs-toggle="modal" data-bs-target=".share-ad"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify icon-start" data-icon="bi:share" data-inline="false" style="transform: rotate(360deg);"><g fill="currentColor"><path d="M13.5 1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z"></path></g></svg> </a></li>
                            <?php
                        }
                        $is_fav = '';
                                $pid =  get_the_ID();
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                    $is_fav = 'ad-favourited';
            }
                        ?><li class="<?php echo $is_fav; ?>"><a href="javascript:void(0);" class="ad_to_fav" data-adid="<?php echo get_the_ID(); ?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify icon-start" data-icon="bi:heart" data-inline="false" style="transform: rotate(360deg);"><g fill="currentColor"><path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385c.92 1.815 2.834 3.989 6.286 6.357c3.452-2.368 5.365-4.542 6.286-6.357c.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path></g></svg></i> </a></li>
                        <li><a data-bs-target=".report-quote" data-bs-toggle="modal"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify icon-start" data-icon="bi:exclamation-triangle" data-inline="false" style="transform: rotate(360deg);"><g fill="currentColor"><path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016a.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06a.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017a.163.163 0 0 1-.054-.06a.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"></path><path d="M7.002 12a1 1 0 1 1 2 0a1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"></path></g></svg></i></a></li>
                    </ul>

                </div>
                <div class="ad-detail-2-user">
                    <div class="heading-detail">
                        <div class="detail-img">
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads'); ?>"><img src="<?php echo esc_attr($user_pic); ?>" id="user_dp" alt="<?php echo __('Profile Picture', 'adforest'); ?>" class="img-fluid"></a>

                            <?php
                            if (get_user_meta($poster_id, '_sb_badge_type', true) != "" && get_user_meta($poster_id, '_sb_badge_text', true) != "" && isset($adforest_theme['sb_enable_user_badge']) && $adforest_theme['sb_enable_user_badge']) {
                                ?>
                                <div class="heading-detail-check <?php echo get_user_meta($poster_id, '_sb_badge_type', true); ?>">
                                    <i class="fa fa-check label "></i>
                                </div>
                                &nbsp; <?php }
                            ?>
                        </div>
                        <div class="deatil-head">
                            <div class="listing-ratings">
                                <?php
                                if (isset($adforest_theme['sb_enable_user_ratting']) && $adforest_theme['sb_enable_user_ratting']) {
                                    ?>
                                    <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 1); ?>">
                                        <div class="seller-public-profile-star-icons">
                                            <?php
                                            $got = get_user_meta($poster_id, "_adforest_rating_avg", true);
                                            //  $got = count(adforest_get_all_ratings($poster_id));
                                            $total = 0;
                                            if ($got == "")
                                                $got = 0;
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= round($got))
                                                    echo '<i class="fa fa-star"></i>';
                                                else
                                                    echo '<i class="fa fa-star-o"></i>';

                                                $total++;
                                            }
                                            ?>
                                            <span class="rating-count count-clr">
                                                (<?php
                                                $ratings = adforest_get_all_ratings($poster_id);
                                                echo count($ratings);
                                                ?>)
                                            </span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads'); ?>"><h5><?php
                                    $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
                                    if ($poster_name == "") {
                                        $user_info = get_userdata($poster_id);
                                        $poster_name = $user_info->display_name;
                                    }
                                    ?><?php echo esc_html($poster_name); ?></h5></a>
                            <?php
                              

                             $user_type = __('Dealer', 'adforest');
                            if (get_user_meta($poster_id, '_sb_user_type', true) == 'Indiviual') {
                                $user_type = __('Individual', 'adforest');
                            } else if (get_user_meta($poster_id, '_sb_user_type', true) == 'Dealer') {
                                $user_type = __('Dealer', 'adforest');
                            }
                            // if ($user_type == "") {
                            ?><span class="label-user label-success"><?php echo adforest_returnEcho($user_type); ?></span>
                                    <?php //}    ?>
                        </div>
                    </div>

                    <?php
                    if ($allow_whizchat) {
                        ?>
                        <a  href="javascript:void(0)" class="btn btn-whizchat chat_toggler btn-block"  data-page_id="<?php echo esc_attr(get_the_ID()); ?>"   data-user_id ="<?php echo esc_attr($poster_id) ?>">
                            <i class="fa fa-commenting-o"></i> 
                            <span class=""><?php echo __('Live Chat', 'adforest'); ?></span>
                        </a>
                        <?php
                    }
                    if ($allow_whatsapp && $contact_num != "") {
                         $contact_num = preg_replace('/[^\dxX]/', '', $contact_num);
                        $redirect_url = "https://api.whatsapp.com/send?phone=$contact_num";
                        if (adforest_showPhone_to_users()) {
                            $adforest_login_page = isset($adforest_theme['sb_sign_in_page']) ? $adforest_theme['sb_sign_in_page'] : '';
                            $adforest_login_page = apply_filters('adforest_language_page_id', $adforest_login_page);
                            if ($adforest_login_page != '') {
                                $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                            }
                        }
                        ?>
                        <a  href="<?php echo esc_url($redirect_url); ?>" class="btn btn-whatsap btn-block" target ="_blank">
                            <i class="fa fa-whatsapp"></i> 
                            <span class=""><?php echo __('WhatsApp', 'adforest'); ?></span>
                        </a>
                        <?php
                    }
                    ?>                                     
                    <?php
                    if (($adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' ) && $ad_status == 'active') {
                        $allow_attachment = isset($adforest_theme['allow_media_upload_messaging']) ? $adforest_theme['allow_media_upload_messaging'] : false;
                        $user_info = get_userdata(get_current_user_id());
                        if (get_current_user_id() == "" || get_current_user_id() == 0) {
                            $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                            ?>
                            <div class="contact-message">
                                <form>
                                    <div class="cont-seller">
                                        <h4><?php echo __('Send Messages', 'adforest'); ?></h4>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                                    </div>
                                    <a class="btn btn-theme btn-block" href="<?php echo esc_url($redirect_url); ?>">
                                        <?php echo __('Send Message', 'adforest'); ?>
                                    </a>
                                </form>

                            <?php } else {
                                ?>
                                <div class="contact-message">
                                    <form id="send_message_pop" method="post">
                                        <div class="form-group no-display">
                                            <label><?php echo __('Your Name', 'adforest'); ?></label>
                                            <input type="text" name="name" readonly class="form-control" value="<?php echo esc_attr($user_info->display_name); ?>"> 
                                        </div>
                                        <div class="form-group no-display">
                                            <label><?php echo __('Email Address', 'adforest'); ?></label>
                                            <input type="email" name="email" readonly class="form-control" value="<?php echo esc_attr($user_info->user_email); ?>"> 
                                        </div>
                                        <div class="cont-seller">
                                            <h4><?php echo __('Send Messages', 'adforest'); ?></h4>
                                        </div>

                                        <div class="form-group">
                                            <textarea id="sb_forest_message" name="message" placeholder="<?php echo __('Type here...', 'adforest'); ?>" rows="7" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>"></textarea>
                                        </div>

                                        <?php if ($allow_attachment) { ?>
                                            <div id="attachment-wrapper" class="attachment-wrapper"></div>

                                            <div class="file_attacher"id="file_attacher">
                                                <a href="javascript:void(0)" class="msgAttachFile  dz-clickable"><i class="fa fa-link"></i>&nbsp; <?php echo esc_html__('Add Attachment', 'adforest'); ?></a><!-- comment -->
                                                <input type="hidden" name="attachments_list" value="[]">
                                            </div>       
                                        <?php } ?>                 
                                        <input type="hidden" name="ad_post_id"  id="ad_post_id"  value="<?php echo esc_attr($pid); ?>" />
                                        <input type="hidden" name="usr_id" value="<?php echo get_current_user_id(); ?>" />
                                        <input type="hidden" id="user_id" value="<?php echo get_current_user_id(); ?>" />
                                        <input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="<?php echo esc_attr($poster_id); ?>" />
                                        <input type="hidden" id="sb-msg-token" value="<?php echo wp_create_nonce('sb_msg_secure'); ?>" />
                                        <button type="submit" id="send_ad_message" class="btn btn-theme btn-block"> <?php echo __('Submit', 'adforest'); ?></button>
                                    </form>
                                </div>                  
                                <?php
                            }
                        }
                        ?>
                    </div>                
                    <?php
                    if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && $ad_status != 'sold' && $ad_status != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
                        if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
                            echo adforest_bidding_stats($pid, 'style-3');
                        } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
                            
                        } else {
                            echo adforest_bidding_stats($pid, 'style-3');
                        }
                    }
                    ?>                       
                    <?php
                    if (isset($adforest_theme['sb_custom_location']) && $adforest_theme['sb_custom_location'] != "" && count(wp_get_post_terms($pid, 'ad_country')) > 0) {
                        ?>
                        <div class="main-section-bid">
                            <div class="country-locations">
                                <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/earth-globe.png'; ?>" alt="<?php echo esc_html__('Globe location', 'adforest'); ?>"/>
                                <div class="class-name"><div id="word-count"><?php echo adforest_display_adLocation($pid); ?></div></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }

                    if (isset($adforest_theme['allow_claim']) && $adforest_theme['allow_claim']) {
                        $img_medal = get_template_directory_uri() . "/images/medal.png";
                        $checked_img = get_template_directory_uri() . "/images/checked.png";
                        if (get_post_meta($pid, 'sb_listing_is_claimed', true) != '' && get_post_meta($pid, 'sb_listing_is_claimed', true) == '1') {
                            ?>
                            <div class="main-section-bid claim-now">
                                <div class="widget">   
                                    <div class="claim"> <a href="javascript:void(0)"> <img src="<?php echo esc_url($checked_img); ?>" alt="<?php echo esc_html__('Claimed', 'adforest'); ?>"><?php echo esc_html__('Claimed', 'adforest'); ?> </a> </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>    
                            <div class="main-section-bid claim-now">
                                <div class="widget">    
                                    <div class="claim"> <a class="claim_ad" href="javascript:void(0)" > <img src="<?php echo esc_url($img_medal) ?>" alt="Claim Now" ><?php echo esc_html__('Claim Now', 'adforest') ?> <i class="fa fa-angle-right"></i></a></div>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    if (class_exists('SbPro')) {                           
                        echo apply_filters('sb_show_business_hours', $pid);
                    }
                     if (class_exists('SbPro')) {
                        echo apply_filters('sb_show_booking_option', $pid);
                    }  

                    if ($adforest_theme['tips_title'] != '' && $adforest_theme['tips_for_ad'] != "") {
                        ?>
                        <div class="main-section-bid safety-tips">
                            <div class="widget-heading">
                                <div class="panel-title"><span><?php echo adforest_returnEcho($adforest_theme['tips_title']); ?></span></div>
                            </div>
                            <div class="widget-content saftey">
                                <?php echo adforest_returnEcho($adforest_theme['tips_for_ad']); ?>
                            </div>
                        </div>
                        <?php
                    }
                    if (is_active_sidebar('adforest_ad_sidebar_bottom')) {
                        echo '<div class = "ad-bottom-sidebar">';
                        dynamic_sidebar('adforest_ad_sidebar_bottom');
                        echo '</div>';
                    }
                    ?>          
                </div>
            </div>
            <div class="row">
                <div class="related-ads-container" id="related-ads-container">
                    <?php get_template_part('template-parts/layouts/ad-style/related', 'ads'); ?>
                </div>
            </div>  
        </div>
</section>
<?php
if (isset($adforest_theme['share_ads_on']) && $adforest_theme['share_ads_on']) {
    get_template_part('template-parts/layouts/ad-style/share', 'ad');
}
get_template_part('template-parts/layouts/ad-style/report', 'ad');
if (isset($adforest_theme['allow_claim']) && $adforest_theme['allow_claim']) {
    get_template_part('template-parts/layouts/ad-style/claim', 'ad');
}