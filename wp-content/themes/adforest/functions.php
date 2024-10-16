<?php
/**
 * adforest functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package adforest
 */
add_action('after_setup_theme', 'adforest_setup');
if (!function_exists('adforest_setup')) :

    function adforest_setup() {
    global $adforest_theme;
        global $template;
        $page_template = $template != ""  ?  basename($template) : "";
        define('ADFOREST_IMAGE_PATH', get_template_directory_uri() . "/images");
        $is_active_woocomerce = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ? true : false;
        define('IS_WOOCOMMERCE_ACTIVE', $is_active_woocomerce);
        /* ------------------------------------------------ */
        /* Theme Utilities */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/utilities.php';
        require trailingslashit(get_template_directory()) . 'inc/authentication.php';
        require trailingslashit(get_template_directory()) . 'inc/ads.php';
        /* ------------------------------------------------ */
        /* Theme Settings */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/theme_settings.php';
        /* ------------------------------------------------ */
        /* TGM */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'tgm/tgm-init.php';
        /* ------------------------------------------------ */
        /* Theme Options */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/options-init.php';
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'inc/theme_shortcodes/shortcodes.php';

        /* ------------------------------------------------ */
        /* Theme Nav */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/nav.php';
        /* ------------------------------------------------ */
        /* Shop Settings */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/shop-func.php';

        /* Wcmarket Place Vendor */
        /* ------------------------------------------------ */
        if (in_array('dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            require trailingslashit(get_template_directory()) . 'MultiVendorX/wcmarket-functions.php';
        }
        require trailingslashit(get_template_directory()) . 'inc/categories-images.php';
        /* ------------------------------------------------ */
        /* Search Widgets */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/ads-widgets.php';
        require trailingslashit(get_template_directory()) . 'inc/widgets.php';
        require trailingslashit(get_template_directory()) . 'inc/woo_functions.php';
        adforest_set_date_timezone();
        /* for dashbboard only */
        require trailingslashit(get_template_directory()) . 'dashboard/functions.php';
    }
endif;
require trailingslashit(get_template_directory()) . 'inc/adforest-footer-functions.php';
if (class_exists('SitePress')) {

    require trailingslashit(get_template_directory()) . 'inc/multilingual-functions.php';
}
/* Enque Scripts and style for theme  */
if (!function_exists('adforest_google_fonts_service')) {

    function adforest_google_fonts_service() {
        if (!is_rtl()) {
            $query_args = array('family' => 'Lato:400,700,900', 'subset' => '',);
            wp_register_style('adforest-google_fonts', add_query_arg($query_args, "//fonts.googleapis.com/css"), array(), null);
            wp_enqueue_style('adforest-google_fonts');
        }
    }

}

add_action('wp_enqueue_scripts', 'adforest_google_fonts_service');
add_action('wp_enqueue_scripts', 'adforest_scripts');

function adforest_scripts() {
    global $adforest_theme;

    /* JS files */
    


    global $adforest_theme, $template;

    $page_template = $template != "" ?  basename($template) : "";
    $is_active_woocomerce = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ? true : false;

    /* gloabal file for dashboard and other front end */
    wp_enqueue_script('toastr', trailingslashit(get_template_directory_uri()) . 'assests/js/toastr.min.js', false, false, true);
    wp_enqueue_style('toastr', trailingslashit(get_template_directory_uri()) . 'assests/css/toastr.min.css');
    wp_enqueue_style('adforest-pro-font-awesome', trailingslashit(get_template_directory_uri()) . 'assests/css/font-awesome.css');
    wp_register_script('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.fancybox.min.js', array('jquery'), false, false);
    wp_enqueue_script('select-2', trailingslashit(get_template_directory_uri()) . 'assests/js/select2.min.js', false, false, true);
    wp_enqueue_style('adforest-select2', trailingslashit(get_template_directory_uri()) . 'assests/css/select2.min.css');



     if(isset($adforest_theme['sb_android_app'])  && $adforest_theme['sb_android_app'] ){
     wp_enqueue_style('animate', trailingslashit(get_template_directory_uri()) . 'assests/css/animate.min.css');
      }
    
        $mapType = adforest_mapType();
        if ($mapType == 'leafletjs_map') {
            /* Open Street Map In The API */
            if (!is_rtl()) {
                wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet.css');
            } else {
                wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet-rtl.css');
            }
            wp_enqueue_style('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet-search.min.css');
            wp_register_script('leaflet', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet.js', false, false, false);
            wp_register_script('leaflet-markercluster', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet.markercluster.js', false, false, false);

            wp_register_script('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assests/leaflet/leaflet-search.min.js', false, false, false);

            wp_enqueue_script('leaflet');
            wp_enqueue_script('leaflet-markercluster');
            wp_enqueue_script('leaflet-search');
        } else if ($mapType == 'no_map') {
            /* No Mapp In The Theme */
        } else {
            /* Default is google map */
            if (isset($adforest_theme['gmap_api_key']) && $adforest_theme['gmap_api_key'] != "") {
                $map_lang = 'fr';
                if (isset($adforest_theme['gmap_lang']) && $adforest_theme['gmap_lang'] != "") {
                    $map_lang = $adforest_theme['gmap_lang'];
                }
                $map_lang = apply_filters('adforest_languages_code', $map_lang); // apply switcher language in case of wpml
                wp_register_script('google-map', '//maps.googleapis.com/maps/api/js?key=' . $adforest_theme['gmap_api_key'] . '&language=' . $map_lang, false, false, true);
                wp_register_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $adforest_theme['gmap_api_key'] . '&libraries=geometry,places&language=' . $map_lang . '&callback=' . 'adforest_location', false, false, true);
          
               if(is_singular( 'events' )){
      
                wp_enqueue_script('google-map-callback');  
                }
               
                }
        }

       
    define("ADFOREST_DASHBOARD_URL_CSS", trailingslashit(get_template_directory_uri()) . "dashboard/css/");
    define("ADFOREST_DASHBOARD_URL_JS", trailingslashit(get_template_directory_uri()) . "dashboard/js/");
    if ($page_template == 'page-theme-dashboard.php') {
        if (is_rtl()) {
            wp_enqueue_style('dashboard-bundle', ADFOREST_DASHBOARD_URL_CSS . 'app-rtl.css', false, false);
        } else {
            wp_enqueue_style('dashboard-bundle', ADFOREST_DASHBOARD_URL_CSS . 'app.css', false, false);
        }
        wp_enqueue_style('flaticon', trailingslashit(get_template_directory_uri()) . 'assests/css/flaticon.css');
        wp_enqueue_style('dashboard-style', ADFOREST_DASHBOARD_URL_CSS . 'dashboard.css', false, false);
        // add new file for pagination default styling
        wp_enqueue_style('custom-style', ADFOREST_DASHBOARD_URL_CSS . 'custom_style.css', false, false);
        wp_enqueue_script('bootstrap', ADFOREST_DASHBOARD_URL_JS . 'bootstrap.js', array(), false, true);

        if (isset($_GET['page_type']) && $_GET['page_type'] != "") {
            wp_enqueue_style('jquery-confirm', ADFOREST_DASHBOARD_URL_CSS . 'jquery-confirm.min.css', false, false);
            wp_enqueue_script('jquery-confirm', ADFOREST_DASHBOARD_URL_JS . 'jquery-confirm.min.js', array(), false, true);
        }
        if ( (isset($_GET['page_type']) && $_GET['page_type'] == "msg")  ||  (isset($_GET['page_type']) &&  $_GET['page_type'] == "events") ||  (isset($_GET['page_type']) &&  $_GET['page_type'] == "bookings") ) {
            wp_enqueue_script('dropzone', trailingslashit(get_template_directory_uri()) . 'assests/js/dropzone.js', false, false, true);
            wp_enqueue_script('parsley', trailingslashit(get_template_directory_uri()) . 'assests/js/parsley.min.js', false, false, true);
            wp_enqueue_script('adforest-fancybox');
            wp_enqueue_style('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.fancybox.min.css');
        }
         if ( (isset($_GET['page_type']) && $_GET['page_type'] == "events")) {
              wp_enqueue_script('tagsinput', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.tagsinput.min.js', false, false, true);
             wp_enqueue_script('jquery-te', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery-te.min.js', false, false, true);
         
        
         }
        if (isset($_GET['page_type']) && $_GET['page_type'] == "msg") {
            wp_enqueue_script('adforest-perfect-scrollbar2', trailingslashit(get_template_directory_uri()) . 'assests/js/perfect-scrollbar2.js', '', '', false);
        } else {
            wp_enqueue_script('adforest-perfect-scrollbar', trailingslashit(get_template_directory_uri()) . 'assests/js/perfect-scrollbar.js', '', '', false);
        }


       wp_enqueue_script('slimscroll', ADFOREST_DASHBOARD_URL_JS . 'jquery.slimscroll.min.js', false, false, true);
        wp_enqueue_style('adforest-perfect-scrollbar', trailingslashit(get_template_directory_uri()) . 'assests/css/perfect-scrollbar.css', '', '', false);
        wp_enqueue_script('chart', ADFOREST_DASHBOARD_URL_JS . 'chart.js', array(), false, true);
        wp_enqueue_script('adforest-dashboard-custom', ADFOREST_DASHBOARD_URL_JS . 'dashboard-custom.js', array(), false, true);
    } else {


        wp_enqueue_script('bootstrap', trailingslashit(get_template_directory_uri()) . 'assests/js/bootstrap.min.js', false, false, true);
        wp_enqueue_script('typeahead', trailingslashit(get_template_directory_uri()) . 'assests/js/typeahead.min.js', false, false, true);
        wp_enqueue_script('carousel', trailingslashit(get_template_directory_uri()) . 'assests/js/carousel.min.js', false, false, true);
        

        wp_enqueue_script('flexslider-jquery', trailingslashit(get_template_directory_uri()) . 'assests/js/flexslider.js', false, false, true);
        if (isset($adforest_theme['sb_header']) && $adforest_theme['sb_header'] == '2') {

            wp_enqueue_style('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.fancybox.min.css');
        }
        if ($is_active_woocomerce && function_exists('is_product') && is_product()) {
            wp_enqueue_script('adforest-fancybox');
            wp_enqueue_style('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.fancybox.min.css');
        }
      
        $language_code = apply_filters('adforest_languages_code', get_bloginfo('language'));
      
        if (isset($adforest_theme['google_api_key']) && !empty($adforest_theme['google_api_key']) && isset($adforest_theme['google_api_secret']) && !empty($adforest_theme['google_api_secret'])) {
            if (isset($adforest_theme['google-recaptcha-type']) && $adforest_theme['google-recaptcha-type'] == 'v3') {
                $captcha_site_key = isset($adforest_theme['google_api_key']) && !empty($adforest_theme['google_api_key']) ? $adforest_theme['google_api_key'] : '';
                wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . $language_code . '&render=' . $captcha_site_key . '', false, false, false);
            } else {
                wp_enqueue_script('recaptcha', '//www.google.com/recaptcha/api.js?hl=' . $language_code . '', false, false, true);
            }
        }
        wp_register_script('lightslider', trailingslashit(get_template_directory_uri()) . 'assests/js/lightslider.js', false, false, true);
        wp_register_script('adforest-dt', trailingslashit(get_template_directory_uri()) . 'assests/js/datepicker.min.js', false, false, true);    //  its air datepicker
        wp_register_script('anime-slider', trailingslashit(get_template_directory_uri()) . 'assests/js/anime.js', false, false, true);
        wp_register_script('slick-slider', trailingslashit(get_template_directory_uri()) . 'assests/js/slick.js', false, false, true);
        wp_register_script('popup-video-iframe', trailingslashit(get_template_directory_uri()) . 'assests/js/YouTubePopUp.js', false, false, true);
        wp_register_script('star-rating', trailingslashit(get_template_directory_uri()) . 'assests/js/star-rating.js', false, false, true);
        wp_register_script('jquery-ui-all', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery-ui.min.js', false, false, true);
        wp_register_style('popup-video-iframe', trailingslashit(get_template_directory_uri()) . 'assests/css/YouTubePopUp.css');
        wp_register_script('adforest-search', trailingslashit(get_template_directory_uri()) . 'assests/js/search.js', false, false, true);
        // wp_register_script('isotope', trailingslashit(get_template_directory_uri()) . 'assests/js/isotope.min.js', false, false, true);
        wp_register_script('nouislider-all', trailingslashit(get_template_directory_uri()) . 'assests/js/nouislider.all.min.js', false, false, true);
        wp_register_script('search-map', trailingslashit(get_template_directory_uri()) . 'assests/js/map.js', false, false, true);
        wp_register_script('element-map', trailingslashit(get_template_directory_uri()) . 'assests/js/map-element.js', false, false, true);
        wp_register_script('oms', trailingslashit(get_template_directory_uri()) . 'assests/js/oms.min.js', false, false, true);

        wp_enqueue_script('jquery-appear', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.appear.min.js', false, false, true);
        wp_enqueue_script('jquery-countTo', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.countTo.js', false, false, true);

        wp_enqueue_script('isotope', trailingslashit(get_template_directory_uri()) . 'assests/js/isotope.min.js', false, false, true);

        $body_classes = get_body_class();

        // Check if "blog" class exists in the array
        wp_enqueue_script('isotope');
        wp_enqueue_script('imagesloaded');
        if (is_singular('ad_post') ) {
            wp_enqueue_script('google-map');
            wp_enqueue_script('star-rating');
            wp_enqueue_script('jquery-ui-all');
            wp_enqueue_style('jquery-confirm', ADFOREST_DASHBOARD_URL_CSS . 'jquery-confirm.min.css', false, false);
            wp_enqueue_script('jquery-confirm', ADFOREST_DASHBOARD_URL_JS . 'jquery-confirm.min.js', array(), false, true);
        }
        if (is_author() || $page_template == 'page-users.php' ||  is_singular('events')) {
            wp_enqueue_script('star-rating');
        }
        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
            wp_enqueue_script('nicescroll', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.nicescroll.min.js', array('jquery'), false);
        }
        // if (isset($adforest_theme["sb_top_location"]) && $adforest_theme["sb_top_location"]) {
        wp_enqueue_script('adforest-perfect-scrollbar', trailingslashit(get_template_directory_uri()) . 'assests/js/perfect-scrollbar.js', '', '', true);
        wp_enqueue_style('adforest-perfect-scrollbar', trailingslashit(get_template_directory_uri()) . 'assests/css/perfect-scrollbar.css', '', '', false);
        // }
        wp_enqueue_style('popup-video-iframe');
        wp_enqueue_script('tagsinput', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.tagsinput.min.js', false, false, true);
        wp_enqueue_script('jquery-te', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery-te.min.js', false, false, true);
        wp_enqueue_script('dropzone', trailingslashit(get_template_directory_uri()) . 'assests/js/dropzone.js', false, false, true);
        wp_enqueue_script('sb-menu', trailingslashit(get_template_directory_uri()) . 'assests/js/sb.menu.js', false, false, true);
        wp_enqueue_script('wow-js', trailingslashit(get_template_directory_uri()) . 'assests/js/wow.min.js', false, false, true);
        wp_enqueue_script('adforest-moment', trailingslashit(get_template_directory_uri()) . 'assests/js/moment.js', false, false, true);
        wp_enqueue_script('adforest-moment-timezone-with-data', trailingslashit(get_template_directory_uri()) . 'assests/js/moment-timezone-with-data.js', false, false, true);
        wp_enqueue_script('adforest-timer', trailingslashit(get_template_directory_uri()) . 'assests/js/timer.js', false, false, true);
        wp_enqueue_script('hello', trailingslashit(get_template_directory_uri()) . 'assests/js/hello.js', false, false, true);
        wp_enqueue_script('icheck', trailingslashit(get_template_directory_uri()) . 'assests/js/icheck.min.js', false, false, true);
        wp_enqueue_script('parsley', trailingslashit(get_template_directory_uri()) . 'assests/js/parsley.min.js', false, false, true);
        //wp_enqueue_script('forest-megamenu', trailingslashit(get_template_directory_uri()) . 'assests/js/forest-megamenu.js', false, false, true);
          if(is_singular('ad_post') && wp_is_mobile()){
               wp_enqueue_script('touchpan', trailingslashit(get_template_directory_uri()) . 'assests/js/jquery.ui.touch-punch.min.js', false, false, true);
           }
        wp_enqueue_script('adforest-custom', trailingslashit(get_template_directory_uri()) . 'assests/js/custom.js', array('jquery', 'lightslider', 'anime-slider', 'slick-slider', 'popup-video-iframe', 'adforest-fancybox', 'nouislider-all', 'adforest-dt'), false, true);

        wp_enqueue_script('adforest-shortcode-functions', trailingslashit(get_template_directory_uri()) . 'assests/js/sb-shortcode-functions.js', array('jquery', 'adforest-dt', 'typeahead'), false, true);
        $ajax_url = apply_filters('adforest_set_query_param', admin_url('admin-ajax.php'));
        $shortcode_function = array('errorLoading' => __('Loding error', 'adforest'), 'inputTooShort' => __('Too Short Input', 'adforest'), 'searching' => __('Searching', 'adforest'), 'noResults' => __('No Result Found', 'adforest'), 'ajax_url' => $ajax_url);

        wp_localize_script('adforest-shortcode-functions', 'shortcode_globals', $shortcode_function);

        /* CS files */
        wp_enqueue_style('adforest-pro-style', get_stylesheet_uri());
        wp_enqueue_style('bootstrap', trailingslashit(get_template_directory_uri()) . 'assests/css/bootstrap.css');

        wp_enqueue_style('adforest-pro-font-awesome', trailingslashit(get_template_directory_uri()) . 'assests/css/font-awesome.css');
        wp_enqueue_style('flaticon', trailingslashit(get_template_directory_uri()) . 'assests/css/flaticon.css');

        wp_enqueue_style('owl-carousel-carousel', trailingslashit(get_template_directory_uri()) . 'assests/css/owl.carousel.css');

        wp_enqueue_style('owl-theme', trailingslashit(get_template_directory_uri()) . 'assests/css/owl.theme.css');
   

        wp_enqueue_style('adforest-main', trailingslashit(get_template_directory_uri()) . 'assests/css/adforest-main.css');

        wp_enqueue_style('adforest-menu', trailingslashit(get_template_directory_uri()) . 'assests/css/sb.menu.css');
        
       wp_register_style('pretty-checkbox', trailingslashit(get_template_directory_uri()) . 'assests/css/pretty-checkbox.css');

        if (isset($adforest_theme['sb_comming_soon_mode']) && $adforest_theme['sb_comming_soon_mode']) {
            wp_enqueue_style('adforest-coming-soon', trailingslashit(get_template_directory_uri()) . 'assests/css/coming-soon.css');
            wp_enqueue_script('coundown-timer', trailingslashit(get_template_directory_uri()) . 'assests/js/coundown-timer.js', false, false, true);
            wp_enqueue_script('adforest-custom-coming-soon', trailingslashit(get_template_directory_uri()) . 'assests/js/custom-coming-soon.js', array('jquery'), false, true);
        }

        // if (in_array('dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        wp_enqueue_style('adforest-vendor', trailingslashit(get_template_directory_uri()) . 'assests/css/wcvendor.css');
        wp_enqueue_style('adforest-sidebar', trailingslashit(get_template_directory_uri()) . 'assests/css/sidebar.css');
        if (is_rtl()) {
            // wp_enqueue_style('adforest-wcmvendor-rtl', trailingslashit(get_template_directory_uri()) . 'css/wcmvendor-rtl.css');
        }
        // }
        wp_enqueue_style('minimal', trailingslashit(get_template_directory_uri()) . 'assests/skins/minimal/minimal.css');
        wp_register_style('lightslider', trailingslashit(get_template_directory_uri()) . 'assests/css/lightslider.css');
        wp_enqueue_style('nouislider', trailingslashit(get_template_directory_uri()) . 'assests/css/nouislider.min.css');

        wp_enqueue_style('adforest-pro-style2', trailingslashit(get_template_directory_uri()) . 'assests/css/adforest-style.css');

        if (is_rtl()) {
            wp_enqueue_style('bootstrap-rtl', trailingslashit(get_template_directory_uri()) . 'assests/css/bootstrap.rtl.min.css', false, false, true);
            wp_enqueue_style('adforest-pro-rtl-style2', trailingslashit(get_template_directory_uri()) . 'assests/css/adforest-style-rtl.css');
        }


        wp_enqueue_style('adforest-responsive', trailingslashit(get_template_directory_uri()) . 'assests/css/responsive.css');

        
        
    }


    if (in_array('sb_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
           
            wp_enqueue_style('theme_custom_css', get_template_directory_uri() . '/assests/css/custom_style.css');

            global $adforest_theme;
            $h2_color = isset($adforest_theme['adforest-body-typo']['color']) ? $adforest_theme['adforest-body-typo']['color'] : "";
            $main_btn_color = $adforest_theme['opt-theme-btn-color']['regular'] ? $adforest_theme['opt-theme-btn-color']['regular'] : "";
            $main_btn_color_hover = isset($adforest_theme['opt-theme-btn-color']['hover']) ? $adforest_theme['opt-theme-btn-color']['hover'] : "";
            $main_btn_color_shadow = isset($adforest_theme['opt-theme-btn-shadow-color']['rgba']) ? $adforest_theme['opt-theme-btn-color']['hover'] : "";
            $main_btn_color_text = isset($adforest_theme['opt-theme-btn-text-color']['regular']) ? $adforest_theme['opt-theme-btn-text-color']['regular'] : "";

            $main_btn_hover_color_text = isset($adforest_theme['opt-theme-btn-text-color']['hover']) ? $adforest_theme['opt-theme-btn-text-color']['hover'] : "";

            $adforest_h2_typo = isset($adforest_theme['adforest-h2-typo']['color']) ?
                    $adforest_theme['adforest-h2-typo']['color'] : '';

            $custom_css = "

                 h2 a { color  : $adforest_h2_typo }
                .btn-theme  {
                 border: 1px solid $main_btn_color; background-color: $main_btn_color; color: $main_btn_color_text;
                 }
                a.btn-condition:hover, a.btn-warranty:hover, a.btn-type:hover , li a.page-link:hover , .chevron-2:hover , .chevron-1:hover ,.btn-theme:hover ,form div input#searchsubmit:hover  
                { 
                   background-color: $main_btn_color_hover; 
                   border: 1px solid $main_btn_color_hover;
                   box-shadow: 0 0.5rem 1.125rem -0.5rem $main_btn_color_shadow ;
                   color: $main_btn_hover_color_text;
                }
                
               ul.pagination-lg a:hover {
                 background: $main_btn_color_hover ;
                 color:  $main_btn_hover_color_text;
               
                  }
               ul.tabs.wc-tabs li:hover a , .padding_cats .cat-btn:hover  ,.prop-it-work-sell-section:hover .prop-it-sell-text-section span
                {
                    color: $main_btn_hover_color_text; 
                } 
                
               .noUi-connect , ul.cont-icon-list li:hover ,  li a.page-link:hover ,ul.socials-links li:hover ,ul.filterAdType li .filterAdType-count:hover{
                     background: $main_btn_color_hover;
          
                      } 

                 ul.tabs.wc-tabs li:hover    {
                    background-color: $main_btn_color_hover; 
                    color: $main_btn_hover_color_text;   
                  }
                                             
             .tags-share ul li a:hover , .header-location-icon , .header-3-input .looking-form-search-icon i ,.footer-anchor-section a , .address-icon , .num-icon , .gmail-icon ,.wb-icon  ,.personal-mail i , .personal-phone i ,.personal-addres i ,.woocommerce-tabs .wc-tabs li.active a ,.woocommerce .woocommerce-breadcrumb a ,p.price .amount bdi , .wrapper-latest-product .bottom-listing-product h5 ,.dec-featured-details-section span h3 , .sb-modern-list.ad-listing .content-area .price ,.ad-grid-modern-price h5 ,.ad-grid-modern-heading span i,.item-sub-information li , .post-ad-container .alert a , ul.list li label a ,.active ,.found-adforest-heading h5 span a , .register-account-here p a ,.land-classified-heading h3 span ,.land-classified-text-section .list-inline li i ,.land-qs-heading-section h3 span ,.land-fa-qs .more-less ,.land-bootsrap-models .btn-primary ,.recent-ads-list-price  ,.ad-detail-2-content-heading h4 ,.ads-grid-container .ads-grid-panel span ,.ads-grid-container .ads-grid-panel span ,.new-small-grid .ad-price ,.testimonial-product-listing span ,.client-heading span , .best-new-content span  , .bottom-left .new-price , .map-location i ,.tags-share ul li i ,.item-sub-information li  , div#carousel ul.slides li.flex-active-slide img , ul.clendar-head li a i , ul.list li label a , .post-ad-container .alert a , .new-footer-text-h1 p a ,.app-download-pistachio .app-text-section h5 , .prop-agent-text-section p i , .sb-header-top2 .sb-dec-top-ad-post a i , .srvs-prov-text h4 ,.top-bk-details i ,.bk-sel-price span , .bk-sel-rate i ,.white.category-grid-box-1 .ad-price ,.bk-hero-text h4 , .sb-modern-header-11 .sb-bk-srch-links .list-inline.sb-bk-srch-contents li a ,.sb-header-top-11 .sb-dec-top-ad-post a i , .mat-new-candidates-categories p  ,.mat-hero-text-section h1 span , .feature-detail-heading h5 , .copyright-heading p a 
                    ,.great-product-content h4 ,.sb-short-head span ,span.heading-color,
                    .app-download span ,.cashew-main-counter h4 span ,.blog-post .post-info-date a ,
                    .found-listing-heading h5 ,.pistachio-classified-grid .ad-listing .content-area .price h3 ,.pistachio-classified-grid .negotiable ,
                    .category-grid-box .short-description .price ,.new-feature-products span ,
                    .post-info i ,.tag-icon  ,
                    .funfacts.fun_2 h4 span  ,
                    .listing-detail .listing-content span.listing-price, .adforest-user-ads b,.tech-mac-book h1 span ,
                  #event-count ,.buyent-ads-hero .main-content .title , .ad-listing-hero-main .ad-listing-hero .search-bar-box .srh-bar .input-srh span, .ad-listing-hero-main .ad-listing-hero .search-bar-box .srh-bar .ctg-srh .title, .ad-listing-hero-main .ad-listing-hero .search-bar-box .srh-bar .loct-srh .title ,.ad-listing-hero-main .ad-listing-hero .search-bar-box .srh-bar .input-srh span , .filter-date-event:hover ,.filter-date-event:focus, .tech-mac-book h1 .color-scheme ,.tech-latest-primary-section h3 .explore-style ,.tech-call-to-action .tech-view-section h2 span
                        {
                        color: $main_btn_color;
                     }
                              @media (min-width: 320px) and (max-width: 995px) {
                             .sb-header-top2 .sb-dec-top-bar {
                                        background: linear-gradient( 
                                                 45deg
                                         , $main_btn_color 24%,$main_btn_color 0%);
                                            }
                                            }
                                @media (min-width: 995px) {
                                        .sb-header-top2 .sb-dec-top-bar {
                                        background: linear-gradient( 
                                                 45deg
                                         , #ffffff 24%,$main_btn_color 0%);
                                            }
                                        }
                   .ad-listing-hero-main .ctg-ads-carousel .ad-category-carousel .item:hover , span.tag.label.label-info.sb_tag ,.sb-header-top3 .sb-mob-top-bar , ul.pagination-lg li.active a ,.ad-event-detail-section .nav-pills .nav-item .nav-link.active {
                        color: $main_btn_color_text;
                        background-color: $main_btn_color;
                    }
                   
                      @media (min-width: 1200px){
                         .sb-menu.submenu-top-border li > ul {
                           border-top: 3px solid $main_btn_color;
                         }
                     }               
                .ad-event-detail-section .main-dtl-box .meta-share-box .share-links ul li .icon:hover  , .sb-notify .point , .section-footer-bottom-mlt .line-bottom ,.img-head span  ,ul.filterAdType li.active .filterAdType-count ,.mob-samsung-categories .owl-nav i ,.select2-container--default .select2-results__option--highlighted[aria-selected] , .toys-call-to-action ,.toys-hero-section .toys-new-accessories .toys-hero-content ,.sb-modern-header-11 .sb-bk-search-area .sb-bk-side-btns .sb-bk-srch-links .sb-bk-srch-contents .sb-bk-absolute , .sb-header-11  , .img-options-wrap .dec-featured-ht , .new-all-categories ,.noUi-connect  ,.home-category-slider .category-slider .owl-nav .owl-prev, 
                    .home-category-slider .category-slider .owl-nav .owl-next ,.sb-notify .point:before ,.sb-header-top1.header-classy-header .flo-right .sb-notify .point, .sb-header-top1.transparent-3-header .flo-right .sb-notify .point, .sb-header-top1.transparent-2-header .flo-right .sb-notify .point, .sb-header-top1.transparent-header .flo-right .sb-notify .point, .sb-header-top1.with_ad-header .flo-right .sb-notify .point, .sb-header-top1.black-header .flo-right .sb-notify .point, .sb-header-top1.white-header .flo-right .sb-notify .point{
                     background-color: $main_btn_color; 

                      }
                      div#carousel ul.slides li.flex-active-slide img , ul.dropdown-user-login , .woocommerce-tabs .wc-tabs ,.land-bootsrap-models .btn-primary  , .chevron-1 ,.chevron-2 , .heading-panel .main-title ,.sb-modern-header-11 .sb-bk-search-area .sb-bk-side-btns .sb-bk-srch-links .sb-bk-srch-contents li:first-child  ,.product-favourite-sb{
                       border-color  :  $main_btn_color;
                           }
                     
              .img-head img ,li.active .page-link ,.section-bid-2 .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link , a.btn.btn-selected ,.shop-layout-2 .shops-cart a , .mat-success-stories .owl-nav i ,input[type=submit], button[type=submit] ,.featured-slider-1.owl-theme.ad-slider-box-carousel .owl-nav [class*=owl-] ,
                  .cashew-multiple-grid .nav-pills .nav-link.active, .nav-pills .show > .nav-link ,.pg-new .select-buttons .btn-primary,
                  .widget-newsletter .fieldset form .submit-btn ,a.follow-now-btn ,.tab-content input.btn {
                     background-color: $main_btn_color;              
                     color: $main_btn_color_text;
                         border-color  :  $main_btn_color;
                   }
                
                .prop-newest-section .tabbable-line > .nav-tabs > li a.active , .woocommerce input:hover[type='submit'] , .woocommerce button:hover[type='submit'] , .woocommerce .checkout-button:hover , a.follow-now-btn:hover ,.tab-content input.btn:hover{
                              background-color: $main_btn_color_hover !important; 
                              border: 1px solid $main_btn_color_hover !important;           
                               color: $main_btn_hover_color_text !important;
                            }
                            
                        input[type=submit]  {
                         background-color: $main_btn_color ; color: $main_btn_color_text; border: 1px solid $main_btn_color;
                         }
                           .detail-product-search form button , .sticky-post-button ,.woocommerce input[type='submit'] , .woocommerce button[type='submit']  ,.woocommerce 
                            .checkout-button {
                            background-color: $main_btn_color !important ; color: $main_btn_color_text !important ; border: 1px solid $main_btn_color;}

                            .cd-top {background-color : $main_btn_color !important }

            ";
            wp_add_inline_style('theme_custom_css', $custom_css);
        }




    
    if(class_exists('SbPro')){
     wp_enqueue_script('sb-pro-custom', trailingslashit(get_template_directory_uri()) . 'assests/js/sb-custom.js', array('jquery'), false, true);
     $string_array = apply_filters('adforest_get_static_string', '');
                wp_localize_script('sb-pro-custom', 'sb_ajax_object', $string_array);
     }

    }

/* function needed to be moved on plugin side  */
/**
 * Add a custom product data tab
 */
add_filter('woocommerce_product_tabs', 'woo_new_product_tab');

function woo_new_product_tab($tabs) {

    // Adds the new tab
    global $product;
    $tabs['test_tab'] = array(
        'title' => __('Write a Review', 'adforest'),
        'priority' => 20,
        'callback' => 'woo_new_product_tab_content'
    );
    return $tabs;
}

function woo_new_product_tab_content($tab) {

    global $product;
    $product_id = $product->get_ID();
    $args = array('post_id' => $product_id, 'status' => 'approve');
    $comments = get_comments($args);

    if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) :
        ?>
        <div id="review_form_wrapper">
            <div id="review_form">
                <?php
                $commenter = wp_get_current_commenter();
                $comment_form = array(
                    /* translators: %s is product title */
                    'title_reply' => !empty($comments) ? esc_html__('Add a review', 'adforest') : sprintf(esc_html__('Be the first to review &ldquo;%s&rdquo;', 'adforest'), get_the_title()),
                    /* translators: %s is product title */
                    'title_reply_to' => esc_html__('Leave a Reply to %s', 'adforest'),
                    'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                    'title_reply_after' => '</span>',
                    'comment_notes_after' => '',
                    'label_submit' => esc_html__('Submit', 'adforest'),
                    'logged_in_as' => '',
                    'comment_field' => '',
                );

                $name_email_required = (bool) get_option('require_name_email', 1);
                $fields = array(
                    'author' => array(
                        'label' => __('Name', 'adforest'),
                        'type' => 'text',
                        'value' => $commenter['comment_author'],
                        'required' => $name_email_required,
                        'placeholder' => __('Enter Your name', 'adforest')
                    ),
                    'email' => array(
                        'label' => __('Email', 'adforest'),
                        'type' => 'email',
                        'value' => $commenter['comment_author_email'],
                        'required' => $name_email_required,
                        'placeholder' => __('Enter Your Email', 'adforest')
                    ),
                );
                $comment_form['fields'] = array();

                foreach ($fields as $key => $field) {
                    $field_html = '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  comment-form-' . esc_attr($key) . '">';
                    $field_html .= '<label for="' . esc_attr($key) . '">' . esc_html($field['label']);

                    if ($field['required']) {
                        $field_html .= '&nbsp;<span class="required">*</span>';
                    }

                    $field_html .= '</label><input class="form-control keyword-des" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . '    placeholder = "' . esc_html($field['placeholder']) . '" /></div>';

                    $comment_form['fields'][$key] = $field_html;
                }
                $account_page_url = wc_get_page_permalink('myaccount');
                if ($account_page_url) {
                    /* translators: %s opening and closing link tags respectively */
                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'adforest'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
                }
                if (wc_review_ratings_enabled()) {
                    $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'adforest') . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'adforest') . '</option>
						<option value="5">' . esc_html__('Perfect', 'adforest') . '</option>
						<option value="4">' . esc_html__('Good', 'adforest') . '</option>
						<option value="3">' . esc_html__('Average', 'adforest') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'adforest') . '</option>
						<option value="1">' . esc_html__('Very poor', 'adforest') . '</option>
					</select></div>';
                }
                $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__('Your review', 'adforest') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
                comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                ?>
            </div>
        </div>
    <?php else : ?>
        <p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'adforest'); ?></p>
    <?php endif; ?>

    <div class="clear"></div>    
    <?php
}

add_action('wp_head', 'sb_add_custom_header');
if (!function_exists('sb_add_custom_header')) {

    function sb_add_custom_header() {

        ?>
        <div class="loading" id="sb_loading"><?php __('Loading', 'adforest'); ?>&#8230;</div>
        <?php 
        global $adforest_theme, $wpdb;
        $user_id = get_current_user_id();
        $unread_msgs = 0;
        if ($user_id > 0) {
            $unread_msgs = $wpdb->get_var("SELECT COUNT(meta_id) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
        }
        define('ADFOREST_MESSAGE_COUNT', $unread_msgs);
    }

}
add_action('admin_enqueue_scripts', 'adforest_load_admin_js');

function adforest_load_admin_js() {
    wp_enqueue_media();
    wp_register_script('adforest-admin', trailingslashit(get_template_directory_uri()) . 'assests/js/admin.js', false, false, true);
    wp_enqueue_script('adforest-admin');

    wp_enqueue_style('adforest-admin-style', trailingslashit(get_template_directory_uri()) . 'assests/css/sb-admin.css', false, false, true);

    wp_enqueue_style('flaticon', trailingslashit(get_template_directory_uri()) . 'assests/css/flaticon.css');
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('init', 'adforest_add_new_star_rating');

function adforest_add_new_star_rating() {
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 4);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25);
}

if (!function_exists('adforestAction_app_notifier')) {
    function adforestAction_app_notifier() {
        global $adforest_theme, $template;
        $page_template = basename($template);
        $rtl = 0;
        if (function_exists('icl_object_id')) {
            if (apply_filters('wpml_is_rtl', NULL)) {
                $rtl = 1;
            }
        } else {
            if (is_rtl()) {
                $rtl = 1;
            }
        }

         $sb_sign_in_page   =    isset($adforest_theme['sb_sign_in_page']) ? apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']) : "#";


        $slider_item = 4;
        if ($page_template == 'taxonomy-ad_cats.php' || $page_template == 'taxonomy-ad_country.php') {
            $search_cat_page = isset($adforest_theme['search_cat_page']) && $adforest_theme['search_cat_page'] ? TRUE : FALSE;

            $slider_item = 4;
        } else if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'topbar' && is_page_template('page-search.php')) {

            $slider_item = 4;
        } else if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'sidebar' && is_page_template('page-search.php')) {

            $slider_item = 4;
        } else if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map' && is_page_template('page-search.php')) {
            $slider_item = 3;
            
              if(isset($_GET['hide-map']) && $_GET['hide-map'] == 'on' && isset($_GET['hide-filters'])  && $_GET['hide-filters']  ==  'on' ){
             
                   $slider_item = 4;
              }
            
        } else if (is_singular('page')) {
            $slider_item = 4;
        }


        $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;

        $user_upload_max_images = $sb_upload_limit_admin;

        if (is_user_logged_in()) {
            $current_user = get_current_user_id();
            if ($current_user) {
                update_user_meta($current_user, '_sb_last_login', time());
            }

            $user_packages_images = get_user_meta($current_user, '_sb_num_of_images', true);
            if (isset($user_packages_images) && $user_packages_images == '-1') {
                $user_upload_max_images = 'null';
            } else if (isset($user_packages_images) && $user_packages_images > 0) {
                $user_upload_max_images = $user_packages_images;
            }
        }
        
        $sub_cat_req  = "";
        if(isset($adforest_theme['is_sub_cat_required'])  && $adforest_theme['is_sub_cat_required']){           
            $sub_cat_req =   "req";
        }

        $time_zones_val = isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '' ? $adforest_theme['bid_timezone'] : 'Etc/UTC';
        if (function_exists('adforest_timezone_list') && isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '') {
            $time_zones_val = adforest_timezone_list('', $adforest_theme['bid_timezone']);
            date_default_timezone_set($time_zones_val);
        }
        echo '<input type="hidden" id="sb-bid-timezone" value="' . $time_zones_val . '"/>';
        ?>
        <?php $ajax_url = apply_filters('adforest_set_query_param', admin_url('admin-ajax.php')); ?>
        
    
        
        <input type="hidden" id="is_sub_cat_required" value="<?php echo adforest_returnEcho($sub_cat_req); ?>" />
        <input type="hidden" id="field_required" value="<?php echo esc_attr__('This field is required.','adforest') ?>" />
        <input type="hidden" id="adforest_ajax_url" value="<?php echo adforest_returnEcho($ajax_url); ?>" />
        <input type="hidden" id="_nonce_error" value="<?php echo __('There is something wrong with the security please check the admin panel.', 'adforest'); ?>" />
        <input type="hidden" id="invalid_phone" value="<?php echo esc_attr__('Invalid format , Valid format is +16505551234', 'adforest'); ?>" />
        <input type="hidden" id="is_rtl" value="<?php echo esc_attr($rtl); ?>" />
        <input type="hidden" id="slider_item" value="<?php echo esc_attr($slider_item); ?>" />
        <input type="hidden" id="login_page" value="<?php echo get_the_permalink($sb_sign_in_page); ?>" />
        <input type="hidden" id="select_place_holder" value="<?php echo __('Select an option', 'adforest'); ?>" />
        <input type="hidden" id="adforest_forgot_msg" value="<?php echo __('Password reset link sent to your email.', 'adforest'); ?>" />
       <input type="hidden" id="sb_upload_limit" value="<?php echo esc_attr($user_upload_max_images);?>"/>  
        
        <input type="hidden" id="theme_path" value="<?php echo esc_attr(get_template_directory_uri());?>" /> 
      
           
        <?php 
        echo '
                            <input type="hidden" id="select2-noresutls" value="' . esc_attr__("No results found", "adforest") . '">
                            <input type="hidden" id="select2-tooshort" value="' . esc_attr__("Please enter 3 or more characters", 'adforest') . '">
                            <input type="hidden" id="select2-searching"   value="' . esc_attr__("Searching ads", "adforest") . '">';
        ?>
       
       
         <input type="hidden" id="google_recaptcha_site_key" value="<?php echo esc_attr($adforest_theme['google_api_key']);?>" />
<input type="hidden" id="adforest_max_upload_reach" value="<?php echo __('Maximum upload limit reached', 'adforest');?>" />
  <?php
        get_template_part('template-parts/linkedin', 'access');
        get_template_part('template-parts/verification', 'logic');
        get_template_part('template-parts/app', 'notifier');
        get_template_part('template-parts/layouts/sell', 'button');
        get_template_part('template-parts/layouts/scroll', 'up');
        
        
    if(isset($adforest_theme['sb_ad_alerts']) &&  $adforest_theme['sb_ad_alerts'] && is_page_template('page-search.php')) {  
         get_template_part('template-parts/ad', 'alerts');
  
    }

        $footer_js = isset($adforest_theme['footer_js_and_css']) ? $adforest_theme['footer_js_and_css'] : "";
        echo adforest_returnEcho($footer_js);
        
        if (class_exists('Redux')) {
            $hide_captcha_badge = Redux::get_option('adforest_theme', 'hide_captcha_badge');
        }
        $hide_captcha_badge = isset($hide_captcha_badge) ? $hide_captcha_badge : false;
        if (isset($hide_captcha_badge) && $hide_captcha_badge) {
            ?>
            <style>
                .grecaptcha-badge {
                    display: none;
                }
            </style>
            <?php
        }
        
    }

}

add_action('wp_footer', 'adforestAction_app_notifier');

add_action('init', function () {
    /* some sec and rand */
     sb_get_my_theme_notifier();     
       
}, 9);

add_action('init', function () {
    if (!get_option(implode(array("_", "w", "p_t", "kn", "_", "st", "r", "ng", "_s", "b")))) {
        update_option(implode(array("_", "wp", "_t", "k", "n_", "s", "t", "rn", "g_", "sb")), str_shuffle(implode(array_merge(array_merge(array_merge(range('A', 'Z'), range(rand(1, 5), rand(90, 123))), range('a', 'z'))))));
    }
});

add_filter('cron_schedules', 'sb_validate_code_daily');

function sb_validate_code_daily($schedules) {
    $schedules['once_daily'] = array(
        'interval' => 86400,
        'display' => __('once daily', 'adforest')
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if (!wp_next_scheduled('sb_validate_code_daily')) {

    wp_schedule_event(time(), 'once_daily', 'sb_validate_code_daily');
}
// Hook into that action that'll fire every three minutes
add_action('sb_validate_code_daily', 'sb_validate_code_daily_fun');

function sb_validate_code_daily_fun() {

    $pc = get_option(implode(array("_", "s", "b_", "pur", "ch", "as", "e", "_c", "od", "e")));
    $kn = get_option(implode(array("_", "w", "p_t", "kn", "_", "st", "r", "ng", "_s", "b")));
    if ($pc && $kn) {
        $inf = array('method' => 'POST', 'timeout' => 45, 'redirection' => 5, 'httpversion' => '1.0', 'blocking' => true,
            'headers' => array('theme-sb-validation' => true), 'body' => array('purchase_code' => $pc, 'id' => get_option('admin_email'), 'url' => get_option('siteurl'), 'theme_name' => implode(array("A", "d", "fo", "r", "e", "st")), 'token' => $kn, 'request-type' => 'validate'), 'cookies' => array());
        //$ur = implode(array('h','t','t','p',':','/','/','l','oc','al','h','o','s','t','/a','u','t','h','/','a','d','f','o','r','e','s','t','/','r','e','-','v','e','r','i','f','y','.','p','h','p'));
        //
        $ur = 'https://authenticate.scriptsbundle.com/adforest/tm-re-verify.php';
        //
        $rsp = wp_remote_post($ur, $inf);
    }
}

add_action('call_me_as_function', 'adforest_call_some_action', 11, 1);
if (!function_exists('adforest_call_some_action')) {

    function adforest_call_some_action($post_data = array()) {

        if (isset($post_data['data'])) {
            parse_str($post_data['data'], $params);
        }
        $sb_theme_pcode = ( isset($params['p_the_code']) ) ? $params['p_the_code'] : '';
        $p_the_action = ( isset($params['p_the_action']) ) ? $params['p_the_action'] : '';

        /* Main Key Starts */
        $is_validate_token = false;
        $sb_theme_token = '';
        $check_token = ( isset($_POST['sb-tf-theme-token']) && $_POST['sb-tf-theme-token'] != "") ? $_POST['sb-tf-theme-token'] : '';

        $sb_theme_token = get_option(implode(array("_", "w", "p", "_", "t", "k", "n", "_", "s", "t", "r", "n", "g", "_", "s", "b")));
        $is_validate_token = ($sb_theme_token == $check_token) ? true : false;

        /* Main Key Ends */
        if ($sb_theme_pcode == "") {
            $sb_theme_pcode = get_option(implode(array("_", "s", "b", "_", "p", "u", "r", "c", "h", "a", "s", "e", "_", "c", "o", "d", "e")));
        }


        if ($sb_theme_pcode != "") {

            $info = array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array('theme-sb-validation' => true),
                'body' => array(
                    'purchase_code' => $sb_theme_pcode,
                    'id' => get_option('admin_email'),
                    'url' => get_option('siteurl'),
                    'theme_name' => 'Adforest',
                    'token' => $sb_theme_token,
                    'request-type' => $p_the_action
                ),
                'cookies' => array()
            );
            //$ur = implode(array('h','t','t','p',':','/','/','l','o','c','a','l','h','o','s','t','/','a','u','t','h','/','a','d','f','o','r','e','s','t','/','r','e','-','v','e','r','i','f','y','.','p','h','p'));
            $ur = 'https://authenticate.scriptsbundle.com/adforest/tm-re-verify.php';
            $response = wp_remote_post($ur, $info);

            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "Something went wrong: $error_message";
            } else {
                echo $response['body'];

                $body_param = isset($response['body']) && !is_array($response['body']) ? json_decode($response['body'], true) : array();
                if (is_array($body_param) && isset($body_param['status']) && $body_param['status']) {
                    if (isset($params['p_the_code']) && $params['p_the_code'] != "") {
                        if ($params['p_the_action'] == 'activate') {
                            update_option('_sb_purchase_code', $params['p_the_code']);
                        }
                        if ($params['p_the_action'] == 'deactive') {
                            update_option('_sb_purchase_code', '');
                        }
                    }
                }
                if ($params['p_the_action'] == 'deactive') {
                    update_option('_sb_purchase_code', '');
                }
            }
        }

        $is_validate = false;
        if (isset($_POST['sb-tf-theme-validate']) && $_POST['sb-tf-theme-validate'] != "") {
            $my_keyname = array("_", "s", "b", "_", "p", "u", "r", "c", "h", "a", "s", "e", "_", "c", "o", "d", "e");
            $kyname = implode($my_keyname);
            $sb_theme_pcode = get_option($kyname);
            if ($sb_theme_pcode == $_POST['sb-tf-theme-validate']) {
                $is_validate = true;
            }
        }
        ($is_validate == true) ? 'purchase is valid' : 'purchase is not valid';
        ($is_validate_token == true) ? 'token is valid' : 'token is not valid';
    }
}
if (!is_admin()) {
    //add_action("init", "adforest_call_some_action");    
}

if (!function_exists('adforest_validate_theme_purchase_func')) {
    function adforest_validate_theme_purchase_func() {
        $post_data = ( isset($_POST)) ? $_POST : array();
        do_action('call_me_as_function', $post_data);
        wp_die();
    }
}
//add_action('wp_ajax_sb_deactivate_license', 'adforest_validate_theme_purchase_func');
add_action('wp_ajax_adforest_validate_theme_purchase_ajax', 'adforest_validate_theme_purchase_func');
if (!function_exists('adforest_theme_info_page_menu_func')) {
    function adforest_theme_info_page_menu_func() {
        add_menu_page(
                __('Theme Info', 'adforest'),
                __('Theme Info', 'adforest'),
                'manage_options',
                'adforest-theme-info',
                'adforest_theme_info_page_func',
                'dashicons-schedule',
                3
        );
    }
}
add_action('admin_menu', 'adforest_theme_info_page_menu_func');

if (!function_exists('adforest_theme_info_page_func')) {

    function adforest_theme_info_page_func() {

        global $pagenow;

        //if( isset($_GET['page']) && 'adforest-theme-info' == $_GET['page'] )
        ?>

        <h1><?php esc_html_e('Welcome To Theme Info Page.', 'adforest'); ?></h1>

        <div class="wr-ap">
            <br />
            <div id="welcome-panel" class="welcome-panel">
                <div class="">
                    <h2><?php esc_html_e("AdForest - Classified WordPress Theme", "adforest"); ?></h2>
                </div>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e("Get Started", "adforest"); ?></h3>
                        <p>
        <?php esc_html_e("Docementation will helps you to understand the theme flow and will help you to setup the theme accordingly. Click the button below to go to the docementation.", "adforest"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://documentation.scriptsbundle.com/"  target="_blank"><?php esc_html_e("Docementation", "adforest"); ?></a>
                    </div>
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e("Having Issues? Get Support!", "adforest"); ?></h3>
                        <p>
        <?php esc_html_e("If you are facing any issue regarding setting up the theme. You can contact our support team they will be very happy to assist you.", "adforest"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.ticksy.com/"  target="_blank"><?php esc_html_e("Get Theme Support", "adforest"); ?></a>                    
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <h3><?php esc_html_e("Looking For Customizations?", "adforest"); ?></h3>
        <?php esc_html_e("Looking to add more features in the theme no problem. Our development team will customize the theme according to your requirnments. Click the link below to contact us.", "buyent-framework"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.com/freelancer/"  target="_blank"><?php esc_html_e("Looking For Customization?", "adforest"); ?></a>  
                    </div>
                </div>
                <br />
                <p class="hide-if-no-customize" style="color: white;">
        <?php esc_html_e("by", "adforest"); ?>, <a href="https://themeforest.net/user/scriptsbundle/portfolio" target="_blank" style="color: white;"><?php esc_html_e("ScriptsBundle", "adforest"); ?></a>
                </p>

            </div>
        </div>


        <div class="wrap-2">
            <div class="welcome-panel-column-container">
                <div class="content-wrapper" style="background-color:white; margin: 10px; padding:35px">
                    <h2><?php echo esc_html__("Validate Theme Purchase Code", "adforest"); ?></h2>
                    <form method="post" class="inner-code-from">
                        <span class="updated success code-message theme-tf-message"><p></p></span>
                        <p><strong><?php echo esc_html__("Enter Purchase Code", "adforest"); ?></strong><br />
        <?php
        $btn_txt = __("Click To Validate", "adforest");
        $action_a = 'activate';
        $onlick = "";

        if (get_option('_sb_purchase_code') != "") {
            $btn_txt = __("Click To De-Activate", "adforest");
            $action_a = 'deactive';
            $onlick = 'onClick="javascript:return confirm(' . esc_attr__('Are you sure you want to deactivate licence from this domain?', 'adforest') . ')"';
        }
        $onlick = '';
        ?>
                            <input class="p-the-code" type="password" name="p_the_code" size="75" value="<?php echo esc_attr(get_option('_sb_purchase_code')); ?>" />
                            <span data-toggle="#password-field" class="toggle-password"><?php echo __("Show", "adforest"); ?></span>
                            <input type="hidden" name="p_the_action" size="75" value="<?php echo esc_attr($action_a); ?>" />
                            <input type="button" name="submit" value="<?php echo esc_attr($btn_txt); ?>" class="button button-primary bt-start-action" <?php echo $onlick; ?>/>
                        </p>


                    </form>


                    <style type="text/css">
                        .theme-tf-message{display: none;}
                        form.inner-code-from{ 
                            position: relative;
                            width: auto;
                            display: inline-block;
                        }
                        form.inner-code-from span.toggle-password{
                            position: absolute;
                            bottom: 18px;
                            right: 25%;
                            cursor: pointer;
                        }
                        body.rtl form.inner-code-from span.toggle-password{
                            left: 20%;
                            bottom: 20px;
                            right: auto;
                        }                    
                    </style>
                    <script type="text/javascript">
                        jQuery(".toggle-password").click(function () {

                            var input = jQuery(this).closest("form").find("input.p-the-code");
                            if (input.attr("type") === "password") {
                                input.attr("type", "text");
                                jQuery(this).html("<?php echo __("Hide", "adforest"); ?>");
                            } else {
                                input.attr("type", "password");
                                jQuery(this).html("<?php echo __("Show", "adforest"); ?>");
                            }
                        });
                        jQuery('.bt-start-action').on('click', function () {
                            jQuery(this).attr("disabled", "disabled");
                            jQuery.post('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {action: 'adforest_validate_theme_purchase_ajax', data: jQuery('form.inner-code-from').serialize(), }).done(function (response) {

                                jQuery(".bt-start-action").removeAttr("disabled");
                                if (response)
                                {

                                    console.log(response);
                                    var obj = jQuery.parseJSON(response);
                                    jQuery('span.code-message p').html(obj.message);
                                    jQuery('span.code-message').show();
                                    window.setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                } else {

                                    window.setTimeout(function () {
                                        location.reload();
                                    }, 1000);

                                }
                            }).fail(function () {
                                window.setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            });
                        });
                    </script>
                    <br />
                </div>
            </div>
        </div>   


        <div class="wrap-2">
            <div class="welcome-panel">
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column1">
                        <h3><?php esc_html_e("Having Issue In Theme Activation?", "adforest"); ?></h3>
                        <p>
        <?php esc_html_e("If you are facing any issue regarding the activation or deactivation please contact our support by clicking below link.", "adforest"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.ticksy.com/"  target="_blank"><?php esc_html_e("Contact Support Here", "adforest"); ?></a>

                        <p>
        <?php esc_html_e("Always use valid license purchased from themeforest only. You can buy it from the following link. Haven't buy theme yet.", "adforest"); ?></p>
                    </div>
                </div>            
            </div>
        </div>    


        <?php
    }

}


function disable_new_posts_for_claim() {
    // Hide sidebar link
    global $submenu;
    unset($submenu['edit.php?post_type=ad_claims'][10]);
    unset($submenu['edit.php?post_type=sb_bookings'][10]);
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'ad_claims') {    
       echo '<style type="text/css">
        a.page-title-action { display:none !important; }
        </style>';
    }
     if (isset($_GET['post_type']) && $_GET['post_type'] == 'sb_bookings') {   
        echo '<style type="text/css">
        a.page-title-action { display:none !important; }
        </style>';
    }
}
add_action('admin_menu', 'disable_new_posts_for_claim');
if(!function_exists('sb_ads_text')){
  function sb_ads_text ($text){
    global $adforest_theme;
     $is_directory  =   isset($adforest_theme['is_directory'])  ? $adforest_theme['is_directory']  : "";
     if($is_directory){
        return esc_html__('Listings','adforest');
     }
     else {
        return $text;
     }
  }
}

add_action( 'send_headers', 'sb_block_iframes');
if(!function_exists('sb_block_iframes')){
    function sb_block_iframes(){         
        $is_demo = adforest_is_demo();
        if (!$is_demo) {
          header( 'X-FRAME-OPTIONS: SAMEORIGIN');   
        }  
  }
}

function adforest_set_ad_featured_img($single_template) {
    global $post;
    if ($post->post_type == 'ad_post') {
        $media = adforest_get_ad_images($post->ID);
        $img_ids = '';
        if (is_array($media) && count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)){  $mid = $m->ID; }  else{  $mid = $m; }
                if ($mid != get_post_thumbnail_id($post->ID)) {
                    set_post_thumbnail($post->ID, $mid);
                    break;
                }
            }
        }
    }
    return $single_template;
}
add_filter('single_template', 'adforest_set_ad_featured_img');

if (in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))){
add_action( 'elementor/theme/register_locations', 'sb_pro_register_elementor_locations' );  
function sb_pro_register_elementor_locations( $elementor_theme_manager ) {

    $elementor_theme_manager->register_location( 'header' );
    $elementor_theme_manager->register_location( 'footer' );
}  
}

function get_product_ids_by_meta_query($selecte_cate) {
    $args = array(
        'post_type' => 'product', // You can specify a specific post type or 'any' to search all post types
        'posts_per_page' => -1, // Get all posts that match the criteria
        'meta_query' => array(
            array(
                'key' => 'adforest_package_cats',
                'value' => sprintf(':"%s";', $selecte_cate),
                'compare' => 'LIKE',
            ),
        ),
    );
    $posts = get_posts($args);
    $product_ids = array();
    foreach ($posts as $post) {
        $product_ids[] = $post->ID;
    }
    return $product_ids;
}