<?php
global $adforest_theme;
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$sb_notification_page = apply_filters('adforest_language_page_id', isset($adforest_theme['sb_notification_page'])  ?  $adforest_theme['sb_notification_page'] : "");
$site_logo = isset($adforest_theme['sb_site_logo']['url']) ? $adforest_theme['sb_site_logo']['url'] : ADFOREST_IMAGE_PATH . "/logo.png";
$responsive_logo = isset($adforest_theme['sb_site_logo_mobile']['url']) ? $adforest_theme['sb_site_logo_mobile']['url'] : ADFOREST_IMAGE_PATH . "/footer-logo.png";
$home_page_logo = isset($adforest_theme['sb_home_logo']['url']) ? $adforest_theme['sb_home_logo']['url'] : ADFOREST_IMAGE_PATH . "/logo.png";

$sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
$user_id = get_current_user_id();
$header_ext_class = is_front_page() ? "" : "header_home";
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$location_list = isset($adforest_theme["sb_header_location_list"]) ? $adforest_theme["sb_header_location_list"] : array();

$args = array('hide_empty' => 0);
$args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
$final_loc_html = '';
$locations_html = '';
$loc_flag = FALSE;
$rows = isset($location_list) && $location_list != '' ? $location_list : array();

if (isset($rows[0]) && $rows[0] == 'all' && isset($location_type) && $location_type == 'custom_locations') {
    $loc_flag = TRUE;
}
$locations_html .= ' <option value="">' . esc_html__('Select location', 'adforest') . ' </option> ';
if ($loc_flag) {
    
    if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {
        $args = array(
            'type' => 'html',
            'taxonomy' => 'ad_country',
            'tag' => 'option',
            'parent_id' => 0,
        );
        $locations_html = apply_filters('adforest_tax_hierarchy', $locations_html, $args);
    } else {
        $ad_country_arr = get_terms('ad_country', $args);
        if (isset($ad_country_arr) && count($ad_country_arr) > 0) {
            foreach ($ad_country_arr as $loc_value) {
                $locations_html .= ' <option value="' . intval($loc_value->term_id) . '">' . esc_html($loc_value->name) . ' </option> ';
            }
        }
    }
} else {
    if (count((array) $rows) > 0) {

        $locations_html .= '';
        foreach ($rows as $row) {
            $loc_id = $row;
            if (isset($loc_id)) {
                $term = get_term($loc_id, 'ad_country');
                $locations_html .= ' <option value="' . $loc_id . '">' . $term->name . '</option> ';
            }
        }
    }
}
?>
  <?php get_template_part('template-parts/headers/topbar/top', 'bar'); ?>
<header class="header-search sb-header-3">
  
    <div class="container">
        <div class="row">
            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <!--Logo-->
                <div class="log-header" data-mobile-logo="<?php echo esc_url($responsive_logo) ?>" data-sticky-logo="<?php echo esc_url($responsive_logo) ?>">             
                    <a href="<?php echo home_url('/'); ?>"><img class = "sb_site_logo" src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_html__('logo', 'adforest') ?>"></a>
                </div>
            </div>
         <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="looking-input">
                <form action="<?php echo urldecode(get_the_permalink($sb_search_page)) ?>" class="header-3-form">
                    <div class="header-3-input">
                        <div class="row"> 
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7 col-sm-7 header-3-input-pbm">
                                <div class="looking-form">
                                    <div class="looking-form-search-icon">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <input type="text" class ="form-control looking-input-form"   placeholder="<?php echo esc_attr__('What Are You Looking For?', 'adforest') ?>"  name="ad_title"/>         
                                </div>  
                            </div>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-5 col-sm-5 header-3-input-pbm">
                                <div class="looking-form">
                                  <!--   <div class="looking-form-search-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" class="iconify header-location-icon" data-icon="tabler:current-location" data-inline="false" style="transform: rotate(360deg);"><g class="icon-tabler" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><circle cx="12" cy="12" r="8"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="M20 12h2"></path><path d="M2 12h2"></path></g></svg>
                                    </div> -->
                                    <select class="form-control custom-select" name="country_id">

                                        <?php echo adforest_returnEcho($locations_html); ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                                <div class="looking-form-search-icon-1">
                                    <button class="btn btn-theme" type="submit">  <i class="fa fa-search"></i>  </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <div class="sign-in-up">
                <ul class="list-sign-in">
                    <?php
                    if (!is_user_logged_in()) {
                        echo '<li><a href="' . get_the_permalink($sb_sign_in_page) . '"><i class="fa fa-sign-in color-point"></i> ' . esc_html__('Login', 'adforest') . '</a></li>
                                      <li><a href="' . get_the_permalink($sb_sign_up_page) . '" class=""><i class="fa fa-user-plus color-point"></i>' . esc_html__('Register', 'adforest') . '</a></li>
                                         ';
                    } else {
                        ?>
                        <li>
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"  class="login-user">
                                <?php
                                $dp = '';
                                $unread_msgs = ADFOREST_MESSAGE_COUNT;
                                if (function_exists('adforest_get_user_dp')) {
                                    $dp = adforest_get_user_dp($user_id);
                                }
                                ?> 
                                <img class="img-circle" src="<?php echo esc_url($dp); ?>" alt="<?php __('user prfile picture', 'adforest'); ?>" width="32" height="32"></span></a>                                  

                            <ul class="dropdown-user-login">
                                <li><a href="<?php echo get_the_permalink($sb_profile_page); ?>"><i class="fa fa-user"></i> <?php echo __("Profile", "adforest"); ?></a></li>
                                <?php echo apply_filters('adforest_vendor_dashboard_profile', '', $user_id);  ?>
                                <?php
                                if (isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                                    ?>
                                    <li><a href="<?php echo adforest_set_url_param(trailingslashit(get_the_permalink($sb_profile_page)), 'page_type', 'msg'); ?>"><i class="fa fa-envelope"></i> <?php echo __('Messages', 'adforest'); ?> <span class="badge"><?php echo esc_html($unread_msgs); ?></span></a></li>
                                    <?php
                                } if (isset($adforest_theme['sb_cart_in_menu']) && $adforest_theme['sb_cart_in_menu'] && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                    global $woocommerce;
                                    ?>
                                    <li><a href="<?php echo wc_get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i> <?php echo __('Cart', 'adforest'); ?> <span class="badge"><?php echo adforest_returnEcho($woocommerce->cart->cart_contents_count); ?></span></a></li> <?php } ?>
                             
                                <li><a href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page)); ?>"><i class="fa fa-power-off"></i> <?php echo __("Logout", "adforest"); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li><?php get_template_part('template-parts/layouts/ad', 'button') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div> 
</header>
<div class="sb-header  header-shadow no-sticky viewport-lg header-classy header-3" >
    <div class="container">
        <!-- sb header -->
        <div class="sb-header-container">
            <div class="row">
                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <!-- Burger menu -->
                    <div class="burger-menu">
                        <div class="line-menu line-half first-line"></div>
                        <div class="line-menu"></div>
                        <div class="line-menu line-half last-line"></div>
                    </div>
                    <nav class="sb-menu menu-caret submenu-top-border submenu-scale mega-menu">
                        <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                    </nav>
                    <!--Navigation menu-->
                </div>
               
            </div>
        </div>
    </div>
<div class="header-shadow-wrapper"></div></div>