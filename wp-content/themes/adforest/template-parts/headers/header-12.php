<?php
global $adforest_theme, $woocommerce;
$site_logo = isset($adforest_theme['sb_site_logo']['url']) ? $adforest_theme['sb_site_logo']['url'] : ADFOREST_IMAGE_PATH . "/logo.png";
$is_cart = isset($adforest_theme['sb_cart_in_menu']) ? $adforest_theme['sb_cart_in_menu'] : false;
$social_icons = isset($adforest_theme['sidebar_social_icons']) ? $adforest_theme['sidebar_social_icons'] : array();
$sb_sign_in_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']);
$sb_sign_up_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_up_page']);
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
$user_name = isset($user_data->display_name) ? $user_data->display_name : "";


$sb_notification_page = apply_filters('adforest_language_page_id', isset($adforest_theme['sb_notification_page'])  ?  $adforest_theme['sb_notification_page'] : "");

global $wpdb;
$query = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key like '_product_fav_id_%' ";
$products = $wpdb->get_results($query);
$fav_product_list = "";
if (!empty($products)  && function_exists('wc_get_product')) {
    foreach ($products as $product) {
        $product_id = $product->meta_value;
        $_product = wc_get_product($product_id);
       if(!empty($_product)) {       
        $fav_class = "";
        if (get_user_meta(get_current_user_id(), '_product_fav_id_' . $product_id, true) == $product_id) {
            $fav_class = 'favourited';
        }
        $product_price = $_product->get_price_html();
        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_gallery_thumbnail'));
        $product_name = $_product->get_name();
        $fav_product_list .= '<li>
                                    <a href="javascript:void(0)" class="product_to_fav  ' . $fav_class . '" data-productid="' . $product_id . '"> <span class="fa fa-heart hear-btn"></span></a>                        
                                        <div class="img-produt-1">
                                          <a href="'.get_the_permalink($product_id).'">     ' . $thumbnail . '</a>
                                        </div>
                                        <div class="product-cart-head">
                                           <a href="'.get_the_permalink($product_id).'"> <h3>' . $product_name . '</h3></a>
                                                ' . $product_price . '
                                                </div>
                                        </li>';
 }
 }
}
else {
        $fav_product_list .= '<div class="mini-cart-items">
                                  <p>' . esc_html__('Do not have favourite products', 'adforest') . '</p>
                               </div>';
                            }  
?>
<header class="main-header">
    <div class="nav-open">
        <div id="mySidenav" class="sidenav animated bounceInDown style-scroll ">
            <a href="javascript:void(0)" class="closebtn">×</a>
            
            <h2 class="menu-heading"><?php echo esc_html__('Main menu', 'adforest'); ?></h2>
           
            <ul class="nav-main-item">
                <?php adforest_themeMenu('wc_menu'); ?>
            </ul>
            <ul class="socials-links-side">
                <?php
                if (!empty($social_icons)) {
                    foreach ($social_icons as $index => $val) {

                        if ($val != "") {
                            echo '<li><a href="' . $val . '" class="icon-social"><i class="' . adforest_social_icons($index) . '"></i></a></li>';
                        }
                    }
                }
                ?>

            </ul>
            <a href="javascript:void(0)" class="btn btn-checki"><?php echo esc_html__('Check out', 'adforest'); ?></a>
        </div>
        <span  id="opennav"><img src="<?php echo esc_url(ADFOREST_IMAGE_PATH . "/app.png") ?>" alt="<?php echo esc_html__('Sidebar nav', 'adforest') ?>"></span>       
    </div>
    <div class="container-fluid">
        <div class="row header-item">
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>"><img src="<?php echo esc_url($site_logo) ?>" alt="<?php echo esc_html__('site logo', 'adforest') ?>"></a>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="icon-search-head">    
                    <?php
                    if ($adforest_theme['sb_menu_product_cat_switch'] == 1) {
                        $args = array();
                        $args = array('hide_empty' => 0);
                        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
                        $terms = get_terms('product_cat', $args);
                        if (!empty($terms)) {
                            ?>
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo esc_html__('Product Categories', 'adforest') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink" style="">
                                <?php
                                foreach ($terms as $prod_cat) {
                                    if (isset($prod_cat->term_id)) {
                                        echo '<li><a class="dropdown-item action-menu" href="' . get_term_link($prod_cat->term_id) . '")">' . $prod_cat->name . '</a></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>     
                        <?php
                    }
                    if (IS_WOOCOMMERCE_ACTIVE) {
                        ?>
                        <div class="search-header">
                            <form action="<?php echo get_permalink(wc_get_page_id('shop')) ?>">
                                <my-wrapper>
                                    <div class="input-group with-icon search-content">
                                        <input class="form-control rounded" name="s" type="search" placeholder="<?php echo esc_attr__('What are you looking for...', 'adforest') ?>" autocomplete="off" id = "product_text">
                                    </div>
                                    <div class="search-icon">
                                        <button type="submit" class="btn btn-seach" id="submit_search"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </my-wrapper>
                            </form>
                        </div>     

                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="all_account-list">
                        <?php
                        if ($is_cart && IS_WOOCOMMERCE_ACTIVE) {
                            $items = $woocommerce->cart->get_cart();
                            $items_html = "";
                            if (!WC()->cart->is_empty()) {
                                $items = array();
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_gallery_thumbnail'), $cart_item, $cart_item_key);
                                    $prodcut_reguler_price = $_product->get_regular_price();
                                    $prodcut_sale_price = $_product->get_sale_price();
                                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                    $items_html .= '<li>
                                                       <a href="' . esc_url(wc_get_cart_remove_url($cart_item_key)) . '" class="wc-forward" > <span class="close">×</span></a>
                        
                                                        <div class="img-produt-1">
                                                           ' . $thumbnail . '
                                                        </div>
                                                        <div class="product-cart-head">
                                                            <h3>' . $product_name . '</h3>
                                                            ' . $product_price . '

                                                        </div>
                                                    </li>';
                                }
                            } else {
                                $items_html = '<div class="mini-cart-items">
                                                             <p>'.esc_html__('Your Shopping Cart is empty', 'adforest').'</p>
                                                        </div>';
                            }
                            ?>
                           

                                <div class="my-cart mini-cart">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" class="iconify icon-color1" data-icon="carbon:shopping-bag" data-inline="false" style="transform: rotate(360deg);"><path d="M28.76 11.35A1 1 0 0 0 28 11h-6V7a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3v4H4a1 1 0 0 0-1 1.15L4.88 24.3a2 2 0 0 0 2 1.7h18.26a2 2 0 0 0 2-1.7L29 12.15a1 1 0 0 0-.24-.8zM12 7a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v4h-8zm13.14 17H6.86L5.17 13h21.66z" fill="currentColor"></path></svg>
                                    <ul class="cart-account mini-cart-button">
                                        <li><a href="<?php echo esc_html(wc_get_cart_url()) ?>" class="cart-my"><?php echo esc_html__('My Cart', 'adforest') ?></a></li>
                                        <li><a href="javascript:void(0)" class="account-cart"><?php echo adforest_returnEcho($woocommerce->cart->get_cart_total()) ?></a>
                                            <div class="product-cart-sb">
                                                <ul class="product-section-content">
                                                    <?php echo adforest_returnEcho($items_html); ?>
                                                </ul>          
                                            </div>
                                        </li>
                                    </ul>
                                </div>                            
                        <?php } ?>
                            <div class="my-heart">
                                <a href="javascript:void(0)" class="fav_product_btn" id="fav_product_btn">  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 50 50" class="iconify icon-color" data-icon="ei:heart" data-inline="false" style="transform: rotate(360deg);"><path d="M25 39.7l-.6-.5C11.5 28.7 8 25 8 19c0-5 4-9 9-9c4.1 0 6.4 2.3 8 4.1c1.6-1.8 3.9-4.1 8-4.1c5 0 9 4 9 9c0 6-3.5 9.7-16.4 20.2l-.6.5zM17 12c-3.9 0-7 3.1-7 7c0 5.1 3.2 8.5 15 18.1c11.8-9.6 15-13 15-18.1c0-3.9-3.1-7-7-7c-3.5 0-5.4 2.1-6.9 3.8L25 17.1l-1.1-1.3C22.4 14.1 20.5 12 17 12z" fill="currentColor"></path></svg></a>
                                <span class="favourite-count"> <?php echo esc_html(count($products)) ?></span>
                                <div class="product-favourite-sb">
                                    <ul class="product-section-content">
                                        <?php echo adforest_returnEcho($fav_product_list); ?>
                                    </ul>          
                                </div>
                            </div>                   
                            <div class="my-sign">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36" class="iconify icon-color2" data-icon="clarity:user-line" data-inline="false" style="transform: rotate(360deg);"><path d="M18 17a7 7 0 1 0-7-7a7 7 0 0 0 7 7zm0-12a5 5 0 1 1-5 5a5 5 0 0 1 5-5z" class="clr-i-outline clr-i-outline-path-1" fill="currentColor"></path><path d="M30.47 24.37a17.16 17.16 0 0 0-24.93 0A2 2 0 0 0 5 25.74V31a2 2 0 0 0 2 2h22a2 2 0 0 0 2-2v-5.26a2 2 0 0 0-.53-1.37zM29 31H7v-5.27a15.17 15.17 0 0 1 22 0z" class="clr-i-outline clr-i-outline-path-2" fill="currentColor"></path></svg>
                                <ul class="sign-account">
                                    <?php
                                    if (is_user_logged_in()) {
                                        echo '<li><a href="javascript:void(0)" class="sign-my">' . $user_name . '</a></li>';
                                    }                                 
                                    else{                                     
                                        echo '<li><a href="javascript:void(0)" class="sign-my">' . esc_html__('Hello, Sign In','adforest') . '</a></li>';
                                    }
                                    echo '<li><a href="javascript:void(0)" class="account-my">' . esc_html__('My account', 'adforest') . '</a>'
                                    ?>
                                    <ul class="dropd">
                                        <?php
                                        if (is_user_logged_in()) {
                                            $sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);
                                            ?>
                                            <?php echo apply_filters('adforest_vendor_dashboard_profile', '', $user_id); ?>
                                            <li><a role="menuitem" class="menu-item" href="<?php echo get_the_permalink($sb_profile_page); ?>"><?php echo esc_html__('Profile', 'adforest') ?></a></li>
                                            <li><a role="menuitem" class="menu-item" href="<?php echo wp_logout_url(get_the_permalink($sb_sign_in_page)); ?>"><?php echo esc_html__('Logout', 'adforest') ?></a></li>
                                        <?php } else { ?>
                                            <li><a href="<?php echo get_the_permalink($sb_sign_in_page); ?>"><?php echo __("Log in", "adforest"); ?>
                                                </a></li>
                                            <li><a href="<?php echo get_the_permalink($sb_sign_up_page); ?>"><?php echo __("Register", "adforest"); ?>
                                                </a></li>


                                        <?php } ?>
                                    </ul>

                                    </li>
                                </ul>
                            </div>
                  
                        <?php if (IS_WOOCOMMERCE_ACTIVE) { ?>
              
                                <div class="check-out">
                                    <a href="<?php echo esc_url(wc_get_checkout_url()) ?>" class="btn btn-checkout btn-theme"><?php echo esc_html__('Checkout', 'adforest') ?></a>
                                </div>
                        <?php } ?>
                   
                </div>
            </div>  
        </div>
    </div>
</header>