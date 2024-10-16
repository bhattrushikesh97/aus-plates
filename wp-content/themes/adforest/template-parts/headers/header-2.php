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
$is_sticky_header   =   isset($adforest_theme['sb_sticky_header'])  && $adforest_theme['sb_sticky_header'] ? '' :  'no-sticky  ';
?>
<?php get_template_part('template-parts/headers/topbar/top', 'bar'); ?>
<header class="header-search sb-header-2">
    <div class="container">
        <div class="row">
            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <!--Logo-->
                <div class="log-header" data-mobile-logo="<?php echo esc_url($responsive_logo) ?>" data-sticky-logo="<?php echo esc_url($responsive_logo) ?>">             
                    <a href="<?php echo home_url('/'); ?>"><img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_html__('logo', 'adforest') ?>"></a>
                </div>
            </div>
         <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-12 col-sm-12 col-ptm-1">
            <div class="looking-input">
                <form action="<?php echo urldecode(get_the_permalink($sb_search_page)) ?>" class="header-2-form">
                    <div class="header-2-input">
                        <div class="row"> 
                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-8 header-2-input-pbm col-8">
                                <div class="looking-form">
                                   
                                    <input type="text" class ="form-control looking-input-form"   placeholder="<?php echo esc_attr__('What Are You Looking For?', 'adforest') ?>"  name="ad_title"/>         
                                </div>  
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-4 col-btn col-4">
                                <div class="looking-form-search-icon-1">
                                    <button class="btn btn-theme" type="submit"> <?php echo esc_html__('Search','adforest') ?> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
            <div class="sign-in-up">
                <ul class="list-sign-in">
                    <?php
                    if (!is_user_logged_in()) {
                        echo '<li class="login-me"><a href="' . get_the_permalink($sb_sign_in_page) . '"><i class="fa fa-sign-in color-point"></i> ' . esc_html__('Login', 'adforest') . '</a></li>
                                      <li class="register-me"><a href="' . get_the_permalink($sb_sign_up_page) . '" class=""><i class="fa fa-user-plus color-point"></i>' . esc_html__('Register', 'adforest') . '</a></li>
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
                                <img class="img-circle" class = "sb_site_logo" src="<?php echo esc_url($dp); ?>" alt="<?php __('user prfile picture', 'adforest'); ?>" width="32" height="32"></span></a>                                  

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
                    <li class="ad-post-btn"><?php get_template_part('template-parts/layouts/ad', 'button') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div> 
</header>
<div class="sb-header  header-2 <?php echo esc_attr($is_sticky_header)?>">
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