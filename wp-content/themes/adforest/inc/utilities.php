<?php
/* static string and localization */
add_action('wp_enqueue_scripts', 'adforest_static_strings', 100);

function adforest_static_strings() {
    $string_array = apply_filters('adforest_get_static_string', '');
    wp_localize_script(
            'adforest-custom', // name of js file
            'get_strings', $string_array
    );
}

/* make descsription link in theme options */
if (!function_exists('adforest_make_link')) {

    function adforest_make_link($url, $text) {
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", adforest_required_tags()) . $text . wp_kses('</a>', adforest_required_tags());
    }

}
/* Required tag */
if (!function_exists('adforest_required_tags')) {

    function adforest_required_tags() {
        return $allowed_tags = array(
            'div' => adforest_required_attributes(),
            'span' => adforest_required_attributes(),
            'p' => adforest_required_attributes(),
            'a' => array_merge(adforest_required_attributes(), array('href' => array(), 'rel' => array(), 'target' => array('_blank', '_top'),)),
            'u' => adforest_required_attributes(),
            'br' => adforest_required_attributes(),
            'i' => adforest_required_attributes(),
            'q' => adforest_required_attributes(),
            'b' => adforest_required_attributes(),
            'ul' => adforest_required_attributes(),
            'ol' => adforest_required_attributes(),
            'li' => adforest_required_attributes(),
            'br' => adforest_required_attributes(),
            'hr' => adforest_required_attributes(),
            'strong' => adforest_required_attributes(),
            'blockquote' => adforest_required_attributes(),
            'del' => adforest_required_attributes(),
            'strike' => adforest_required_attributes(),
            'em' => adforest_required_attributes(),
            'code' => adforest_required_attributes(),
            'style' => adforest_required_attributes(),
            'script' => adforest_required_attributes(),
            'img' => adforest_required_attributes(),
        );
    }

}
/* Required attributes */
if (!function_exists('adforest_required_attributes')) {

    function adforest_required_attributes() {
        return $default_attribs = array(
            'id' => array(),
            'src' => array(),
            'href' => array(),
            'target' => array(),
            'class' => array(),
            'title' => array(),
            'type' => array(),
            'style' => array(),
            'data' => array(),
            'role' => array(),
            'aria-haspopup' => array(),
            'aria-expanded' => array(),
            'data-toggle' => array(),
            'data-hover' => array(),
            'data-animations' => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-href' => array(),
            'data-tabs' => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-height' => array(),
            'data-hide-cover' => array(),
            'data-show-facepile' => array(),
            'alt' => array(),
        );
    }

}
if (!function_exists('adforest_get_all_countries')) {

    function adforest_get_all_countries() {
        $res = array();
        if (!is_admin()) {
            return $res;
        }
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => '_sb_country',
            'post_status' => 'publish',
        );
        $countries = get_posts($args);
        foreach ($countries as $country) {
            $stripped = trim(preg_replace('/\s+/', ' ', $country->post_excerpt));
            $res[$stripped] = $country->post_title;
        }
        return $res;
    }

}
/* get all clean strings */
if (!function_exists('adforest_clean_strings')) {

    function adforest_clean_strings($string = '') {
        $string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

}
/* avoid echo $ */
if (!function_exists('adforest_returnEcho')) {

    function adforest_returnEcho($html = '') {
        return $html;
    }

}
if (!function_exists('adforest_clean_shortcode')) {

    function adforest_clean_shortcode($string) {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }

}
/* getting social icon array */
if (!function_exists('adforest_social_icons')) {

    function adforest_social_icons($social_network) {
        $social_icons = array(
            'Facebook' => 'fa fa-facebook',
            'Twitter' => 'fa fa-twitter ',
            'Linkedin' => 'fa fa-linkedin ',
            'Google' => 'fa fa-google',
            'YouTube' => 'fa fa-youtube-play',
            'Vimeo' => 'fa fa-vimeo ',
            'Pinterest' => 'fa fa-pinterest ',
            'Tumblr' => 'fa fa-tumblr ',
            'Instagram' => 'fa fa-instagram',
            'Reddit' => 'fa fa-reddit ',
            'Flickr' => 'fa fa-flickr ',
            'StumbleUpon' => 'fa fa-stumbleupon',
            'Delicious' => 'fa fa-delicious ',
            'dribble' => 'fa fa-dribbble ',
            'behance' => 'fa fa-behance',
            'DeviantART' => 'fa fa-deviantart',
        );
        return $social_icons[$social_network];
    }

}

/*  Ajax at the end move into authentication */
add_action('wp_ajax_nopriv_product_suggestions', 'adforest_product_suggestions_live_search');
add_action('wp_ajax_product_suggestions', 'adforest_product_suggestions_live_search');
if (!function_exists('adforest_product_suggestions_live_search')) {

    function adforest_product_suggestions_live_search() {
        $return = array();
        $args = array(
            's' => isset($_GET['query']) && !empty($_GET['query']) ? $_GET['query'] : '',
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 25
        );
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
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





/* ------------------------------------------------ */
/* Pagination */
/* ------------------------------------------------ */
if (!function_exists('adforest_pagination')) {

    function adforest_pagination($w_query = array()) {
        if (is_singular())
            return;

        global $wp_query;
        if (isset($w_query) && !empty($w_query)) {
            $wp_query = $w_query;
        }
        /** Stop execution if there's only 1 page */
        if ($wp_query->max_num_pages <= 1)
            return;

        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
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

        echo '<ul class="pagination pagination-large">' . "\n";

        if (get_previous_posts_link())
            echo '<li><a class="page-link" href="' . previous_posts(false) . '" aria-label="Previous"><i class="fa fa-angle-left"></i></a></li>';



        /**     Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);" class="page-link">...</a></li>';
        }

        /**     Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array) $links as $link) {
            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**     Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><a href="javascript:void(0);" class="page-link">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }

        if (get_next_posts_link())
            echo '<li><a class="page-link" href= "' . next_posts($max, false) . '" aria-label="next"><i class="fa fa-angle-right"></i></a></li>';
        echo '</ul>' . "\n";
    }

}

// Last login time
if (!function_exists('adforest_get_last_login')) {

    function adforest_get_last_login($uid) {
        $from = get_user_meta($uid, '_sb_last_login', true);
        if ($from == "") {
            update_user_meta($uid, '_sb_last_login', time());
            $from = get_user_meta($uid, '_sb_last_login', true);
        }
        return adforest_human_time_diff($from, time());
    }

}

if (!function_exists('adforest_human_time_diff')) {

    function adforest_human_time_diff($from, $to = '') {

        adforest_set_date_timezone();
        if (empty($to)) {
            //$to = current_time('mysql');
            $to = strtotime(date('Y-m-d H:i:s'));
        }

        $diff = (int) abs($to - $from);

        if ($diff < HOUR_IN_SECONDS) {
            $mins = round($diff / MINUTE_IN_SECONDS);
            if ($mins <= 1) {
                $mins = 1;
            }

            $since = sprintf(_n('%s min', '%s mins', $mins, 'adforest'), $mins);
        } elseif ($diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS) {
            $hours = round($diff / HOUR_IN_SECONDS);
            if ($hours <= 1) {
                $hours = 1;
            }

            $since = sprintf(_n('%s hour', '%s hours', $hours, 'adforest'), $hours);
        } elseif ($diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS) {
            $days = round($diff / DAY_IN_SECONDS);
            if ($days <= 1) {
                $days = 1;
            }

            $since = sprintf(_n('%s day', '%s days', $days, 'adforest'), $days);
        } elseif ($diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS) {
            $weeks = round($diff / WEEK_IN_SECONDS);
            if ($weeks <= 1) {
                $weeks = 1;
            }

            $since = sprintf(_n('%s week', '%s weeks', $weeks, 'adforest'), $weeks);
        } elseif ($diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS) {
            $months = round($diff / MONTH_IN_SECONDS);
            if ($months <= 1) {
                $months = 1;
            }

            $since = sprintf(_n('%s month', '%s months', $months, 'adforest'), $months);
        } elseif ($diff >= YEAR_IN_SECONDS) {
            $years = round($diff / YEAR_IN_SECONDS);
            if ($years <= 1) {
                $years = 1;
            }

            $since = sprintf(_n('%s year', '%s years', $years, 'adforest'), $years);
        }

        return apply_filters('human_time_diff', $since, $diff, $from, $to);
    }

}

if (!function_exists('adforest_set_date_timezone')) {

    function adforest_set_date_timezone() {
        global $adforest_theme;
        $time_zones_val = isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '' ? $adforest_theme['bid_timezone'] : 'Etc/UTC';
        if (function_exists('adforest_timezone_list') && isset($adforest_theme['bid_timezone']) && $adforest_theme['bid_timezone'] != '') {
            $time_zones_val = adforest_timezone_list('', $adforest_theme['bid_timezone']);
            if (!is_admin()) {
                date_default_timezone_set($time_zones_val);
            }
        } else {
            $time_zones_val = 'Etc/UTC';
            date_default_timezone_set($time_zones_val);
        }
    }

}

/* check is plugin active */
if (function_exists('adforest_is_plugin_active')) {

    function adforest_is_plugin_active() {
        if (in_array($plugin_name, apply_filters('active_plugins', get_option('active_plugins')))) {
            return true;
        } else {
            return false;
        }
    }

}
/* authentication check */
if (!function_exists('adforest_authenticate_check')) {

    function adforest_authenticate_check() {
        if (get_current_user_id() == "" || get_current_user_id() == 0) {
            echo '0|' . __("You are not logged in.", 'adforest');
            die();
        }
    }

}
// check page build with elementor /
if (!function_exists('sb_is_elementor')) {

    function sb_is_elementor($page_id) {
        if (class_exists('Elementor\Plugin')) {
          // return \Elementor\Plugin::$instance->db->is_built_with_elementor($page_id);

             return \Elementor\Plugin::$instance->documents->get( $page_id )->is_built_with_elementor($page_id);

            
        } else {
            return false;
        }
    }

}
// Get user profile PIC
if (!function_exists('adforest_get_user_dp')) {

    function adforest_get_user_dp($user_id, $size = 'adforest-single-small') {
        global $adforest_theme;
        $user_pic = trailingslashit(get_template_directory_uri()) . 'images/9.jpg';
        if (isset($adforest_theme['sb_user_dp']['url']) && $adforest_theme['sb_user_dp']['url'] != "") {
            $user_pic = $adforest_theme['sb_user_dp']['url'];
        }

        if (get_user_meta($user_id, '_sb_user_linkedin_pic', true) != "") {
            $user_pic = get_user_meta($user_id, '_sb_user_linkedin_pic', true);
            return $user_pic;
        }

        $image_link = array();
        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, $size);
        }
        if (isset($image_link) && !empty($image_link) && is_array($image_link) && count($image_link) > 0) {
            if ($image_link[0] != "") {
                $headers = @get_headers($image_link[0]);
                if (strpos($headers[0], '404') === false) {

                    return $image_link[0];
                } else {
                    return $user_pic;
                }
            } else {
                return $user_pic;
            }
        } else {
            return $user_pic;
        }
    }

}
/* set url params */
if (!function_exists('adforest_set_url_param')) {

    function adforest_set_url_param($adforest_url = '', $key = '', $value = '') {
        if ($adforest_url != '') {
            $adforest_url = add_query_arg(array($key => $value), $adforest_url);
            $adforest_url = apply_filters('adforest_page_lang_url', $adforest_url);
        }
        return $adforest_url;
    }

}

if (!function_exists('adforest_cats')) {

    function adforest_cats($taxonomy = 'ad_cats', $all = 'yes') {
        global $sitepress, $adforest_theme;
        if (!is_admin()) {
            //  return array();
        }
        if ($all == 'yes') {
            $cats = array(__('All', 'adforest') => 'all');
        } else if ($taxonomy == 'ad_country') {
            $cats = array(__('Select Location', 'adforest') => '');
        } else if ($taxonomy == 'ad_warranty') {
            $cats = array(__('Select Warranty', 'adforest') => '');
        } else if ($taxonomy == 'ad_condition') {
            $cats = array(__('Select Condition', 'adforest') => '');
        } else if ($taxonomy == 'ad_type') {
            $cats = array(__('Select Ad Type', 'adforest') => '');
        } else {
            $cats = array();
        }
        // if (isset($adforest_theme['display_taxonomies']) && $adforest_theme['display_taxonomies'] == 'hierarchical') {
//            $args_cat = array(
//                'type' => 'array',
//                'taxonomy' => $taxonomy,
//                'tag' => 'option',
//                'parent_id' => 0,
//                'vc' => true,
//            );
        //$cats = apply_filters('adforest_tax_hierarchy', $cats, $args_cat);
        //} else {
        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $ad_cats = get_terms($taxonomy, $args);

        if (is_array($ad_cats) && count($ad_cats) > 0) {
            foreach ($ad_cats as $cat) {
                $count = ($cat->count);
                $cats[wp_specialchars_decode($cat->name) . ' (' . urldecode_deep($cat->slug) . ')' . ' (' . $count . ')'] = $cat->term_id;
            }
        }
        //}
        return $cats;
    }

}
if (!function_exists('adforest_load_search_countries')) {

    function adforest_load_search_countries($action_on_complete = '') {
        global $adforest_theme;
        $stricts = '';
        if (isset($adforest_theme['sb_location_allowed']) && !$adforest_theme['sb_location_allowed'] && isset($adforest_theme['sb_list_allowed_country'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($adforest_theme['sb_list_allowed_country']) . "}";
        }
        $types = "'(cities)'";
        if (isset($adforest_theme['sb_location_type']) && $adforest_theme['sb_location_type'] != "") {
            if ($adforest_theme['sb_location_type'] == 'regions')
                $types = "";
            else
                $types = "'(cities)'";
        }
        echo "<script>function adforest_location() {var options = {types: [" . $types . "]," . $stricts . "};var input = document.getElementById('sb_user_address');var action_on_complete	= '" . $action_on_complete . "';var autocomplete = new google.maps.places.Autocomplete(input, options);if( action_on_complete ){new google.maps.event.addListener(autocomplete, 'place_changed', function() {var place = autocomplete.getPlace();document.getElementById('ad_map_lat').value = place.geometry.location.lat();document.getElementById('ad_map_long').value = place.geometry.location.lng();var markers = [{'title': '','lat': place.geometry.location.lat(),'lng': place.geometry.location.lng(),},];my_g_map(markers);});}}</script>";
    }

}

add_filter('adforest_tax_hierarchy', 'adforest_tax_hierarchy_callback', 10, 2);

if (!function_exists('adforest_tax_hierarchy_callback')) {

    function adforest_tax_hierarchy_callback($html, $tax_args = array()) {
        /*
         * 'taxonomy'=> 'ad_cats' // add the taxonomy slug
         * 'type' => 'html',  // can be html/array type
         * 'tag' => 'li',    //  can be li/option if type is html
         * 'parent_id' => 0, // parent id of the terms
         * 'q'=>  search query in case of ajax
         */
        extract($tax_args);
        $taxonomy = isset($taxonomy) && $taxonomy != '' ? $taxonomy : 'ad_cats';
        $type = isset($type) && $type != '' ? $type : 'html';
        $tag = isset($tag) && $tag != '' ? $tag : 'li';
        $vc = isset($vc) && $vc ? true : false;
        $parent_id = isset($parent_id) && $parent_id != '' ? $parent_id : 0;
        $args = array('hide_empty' => 0, 'hierarchical' => true, 'parent' => $parent_id);
        $terms = array();
        if (isset($q) && $q != '') {
            $args = array();
            $args['name__like'] = $q;
            $args['hide_empty'] = 0;
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $terms = get_terms($taxonomy, $args);
        } else {
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $terms = get_terms($taxonomy, $args);
        }
        if (isset($terms) && !empty($terms) && is_array($terms) && sizeof($terms) > 0) {
            foreach ($terms as $term) {
                $ancestors = get_ancestors($term->term_id, $taxonomy);
                $depth_sign = '';
                for ($depth_loop = 1; $depth_loop <= count($ancestors); $depth_loop++) {
                    $depth_sign .= ' - ';
                }
                if ($type == 'html') {
                    $html .= '<' . $tag . ' value="' . $term->term_id . '" data-parent-level="' . $depth_loop . '">' . $depth_sign . $term->name . '</' . $tag . '>';
                } else {
                    if ($vc) {
                        $count = ($term->count);
                        $html[$depth_sign . wp_specialchars_decode($term->name) . ' (' . urldecode_deep($term->slug) . ')' . ' (' . $count . ')'] = $term->term_id;
                    } else {
                        $html[] = array($term->term_id, wp_specialchars_decode($depth_sign . $term->name));
                    }
                }
                if ($term->parent == $parent_id) {
                    $args = array(
                        'type' => $type,
                        'taxonomy' => $taxonomy,
                        'tag' => $tag,
                        'parent_id' => $term->term_id,
                        'vc' => $vc,
                    );
                    $html = apply_filters('adforest_tax_hierarchy', $html, $args);
                }
            }
        }
        return $html;
    }

}

/* Select map type */
if (!function_exists('adforest_mapType')) {

    function adforest_mapType() {
        global $adforest_theme;
        $mapType = 'google_map';
        if (isset($adforest_theme['map-setings-map-type']) && $adforest_theme['map-setings-map-type'] != '') {
            $mapType = $adforest_theme['map-setings-map-type'];
        }
        return $mapType;
    }

}

if (!function_exists('adforest_display_cats')) {
    function adforest_display_cats($pid, $class = "") {
        global $adforest_theme;
        $post_categories = wp_get_object_terms($pid, 'ad_cats');
        $cats_html = '';
        $cat_link_page = isset($adforest_theme['cat_and_location']) ? ($adforest_theme['cat_and_location']) : 'search';

        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats_html .= '<span class="padding_cats"><a href="' . adforest_cat_link_page($cat->term_id, $cat_link_page, 'cat_id') . '" class="' . $class . '">' . esc_html($cat->name) . '</a></span>';
        }
        return $cats_html;
    }
}
if (!function_exists('adforest_get_ad_images')) {
    function adforest_get_ad_images($pid) {
        global $adforest_theme;
        $re_order = get_post_meta($pid, '_sb_photo_arrangement_', true);
        if ($re_order != "") {
            return explode(',', $re_order);
        } else {
        return    $attach_media =  get_attached_media('', $pid);
        }
    }
}
if (!function_exists('adforest_get_ad_default_image_url')) {
    function adforest_get_ad_default_image_url($ad_img_size = '') {
        global $adforest_theme;
        $image_url = $adforest_theme['default_related_image']['url'];
        if (isset($adforest_theme['default_related_image']['id']) && !empty($adforest_theme['default_related_image']['id'])) {
            $image_url = wp_get_attachment_image_src($adforest_theme['default_related_image']['id'], $ad_img_size);
            $image_url = isset($image_url[0]) && !empty($image_url[0]) ? $image_url[0] : $adforest_theme['default_related_image']['url'];
        }
        return $image_url;
    }

}

if (!function_exists('adforest_video_icon')) {
    function adforest_video_icon($is_grid2 = false, $class = 'play-video', $icon_class = 'fa fa-play-circle-o') {
        global $adforest_theme;
        $fet_cls = '';
        if ($is_grid2 && get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
            $fet_cls = 'video_position';
        }
        if (isset($adforest_theme['sb_video_icon']) && $adforest_theme['sb_video_icon'] && get_post_meta(get_the_ID(), '_adforest_ad_yvideo', true)) {
            return '<a href="' . get_post_meta(get_the_ID(), '_adforest_ad_yvideo', true) . '" class="' . esc_attr($class) . ' ' . esc_attr($fet_cls) . '"><i class="' . $icon_class . '"></i></a>';
        }
    }

}
if (!function_exists('adforest_adPrice')) {

    function adforest_adPrice($id = '', $class = 'negotiable', $tag = 'h3') {
        if (get_post_meta($id, '_adforest_ad_price', true) == "" && get_post_meta($id, '_adforest_ad_price_type', true) == "on_call") {
            return __("Price On Call", 'adforest');
        }
        if (get_post_meta($id, '_adforest_ad_price', true) == "" && get_post_meta($id, '_adforest_ad_price_type', true) == "free") {
            return __("Free", 'adforest');
        }

        if (get_post_meta($id, '_adforest_ad_price', true) == "" || get_post_meta($id, '_adforest_ad_price_type', true) == "no_price") {
            return '';
        }

        $price = 0;
        global $adforest_theme;
        $thousands_sep = ",";
        if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != "") {
            $thousands_sep = $adforest_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != "") {
            $decimals = $adforest_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != "") {
            $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
        }
        $curreny = $adforest_theme['sb_currency'];
        if (get_post_meta($id, '_adforest_ad_currency', true) != "") {
            $curreny = get_post_meta($id, '_adforest_ad_currency', true);
        }

        if ($id != "") {
            if (is_numeric(get_post_meta($id, '_adforest_ad_price', true))) {
                $price = number_format(get_post_meta($id, '_adforest_ad_price', true), $decimals, $decimals_separator, $thousands_sep);
            }

            $price = ( isset($price) && $price != "") ? $price : 0;

            if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                $price = $price . $curreny;
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                $price = $price . " " . $curreny;
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                $price = $curreny . $price;
            } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                $price = $curreny . " " . $price;
            } else {
                $price = $curreny . $price;
            }
        }
        // Price type fixed or ...
        $price_type_html = '';
        if (get_post_meta($id, '_adforest_ad_price_type', true) != "" && isset($adforest_theme['allow_price_type']) && $adforest_theme['allow_price_type']) {
            $price_type = '';
            if (get_post_meta($id, '_adforest_ad_price_type', true) == 'Fixed') {
                $price_type = __('Fixed', 'adforest');
            } else if (get_post_meta($id, '_adforest_ad_price_type', true) == 'Negotiable') {
                $price_type = __('Negotiable', 'adforest');
            } else if (get_post_meta($id, '_adforest_ad_price_type', true) == 'auction') {
                $price_type = __('Auction', 'adforest');
            } else {
                $price_type = get_post_meta($id, '_adforest_ad_price_type', true);
                if (isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] != '') {
                    $price_type = str_replace('_', ' ', $price_type);
                }
            }




            $price_type_html = '<span class="' . esc_attr($class) . '">&nbsp;(' . $price_type . ')</span>';
        }
        if ($tag == 'h3') {
            return '<h3>' . $price . ' </h3>' . $price_type_html . '';
        } else
            return $price . $price_type_html;
    }

}
/* get post description as per need. */
if (!function_exists('adforest_words_count')) {

    function adforest_words_count($contect = '', $limit = 180) {
        $string = '';
        $contents = strip_tags(strip_shortcodes($contect));
        $contents = adforest_removeURL($contents);
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', html_entity_decode($contents, ENT_QUOTES));
        if (strlen($removeSpaces) > $limit) {
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }

}

/* Allow Pending products to be viewed by listing/product owner */
if (!function_exists('posts_for_current_author')) {

    function posts_for_current_author($query) {
        if (isset($_GET['post_type']) && $_GET['post_type'] == "ad_post" && isset($_GET['p'])) {
            $post_id = $_GET['p'];
            $post_author = get_post_field('post_author', $post_id);
            if (is_user_logged_in() && get_current_user_id() == $post_author) {
                $query->set('post_status', array('publish', 'pending', 'draft'));
                return $query;
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

}
add_filter('pre_get_posts', 'posts_for_current_author');

/* remove url from excerpt */
if (!function_exists('adforest_removeURL')) {

    function adforest_removeURL($string) {
        return preg_replace("/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i", '', $string);
    }

}

/* Get and Set Post Views */
if (!function_exists('adforest_getPostViews')) {

    function adforest_getPostViews($postID) {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count;
    }

}


if (!function_exists('adforest_ad_locations_limit')) {

    function adforest_ad_locations_limit($ad_location = '') {
        global $adforest_theme;
        if (isset($adforest_theme['sb_ad_location_limit_on']) && $adforest_theme['sb_ad_location_limit_on'] && isset($adforest_theme['sb_ad_location_limit']) && $adforest_theme['sb_ad_location_limit'] != "") {
            return adforest_words_count($ad_location, $adforest_theme['sb_ad_location_limit']);
        } else {
            return $ad_location;
        }
    }

}

if (!trait_exists('adforest_reuse_functions')) {

    trait adforest_reuse_functions {

        function adforect_widget_open($instance) {

            global $adforest_theme;
            if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'sidebar'  || $adforest_theme['search_design'] == "map") {
                $open_widget = 0;
                if (isset($instance['open_widget'])) {
                    $open_widget = $instance['open_widget'];
                }

                $open_selected = $close_selected = '';
                if ($open_widget == '1')
                    $open_selected = 'selected="selected"';
                else
                    $close_selected = 'selected="selected"';

                $open_html = '<p><label for="' . esc_attr($this->get_field_id('open_widget')) . '" > ' . esc_html__('Widget behaviour:', 'adforest') . '</label> <select  class="widefat" id="' . esc_attr($this->get_field_id('open_widget')) . '" name="' . esc_attr($this->get_field_name('open_widget')) . '"><option value="1"' . esc_attr($open_selected) . '>' . __('Open', 'adforest') . '</option><option value="0"' . esc_attr($close_selected) . '>' . __('Close', 'adforest') . '</option></select></p>';
                echo adforest_returnEcho($open_html);
            }
        }

    }

}
if (!function_exists('adforest_cat_link_page')) {

    function adforest_cat_link_page($category_id, $type = '', $tax = 'cat_id') {
        global $adforest_theme;

        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        //$link = get_the_permalink($sb_search_page) . "?$tax=" . $category_id;
        $link = adforest_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);
        if ($type == 'category') {
            $link = get_term_link((int) $category_id);
        }
        return $link;
    }

}
if (!function_exists('adforest_login_with_redirect_url_param')) {

    function adforest_login_with_redirect_url_param($redirect_url = '') {
        global $adforest_theme;
        $final_redi_url = '';
        $red_url = '';
         $sb_sign_in_page   =    isset($adforest_theme['sb_sign_in_page']) ? apply_filters('adforest_language_page_id', $adforest_theme['sb_sign_in_page']) : "#";
        $login_page_url = isset($adforest_theme['sb_sign_in_page']) && !empty($adforest_theme['sb_sign_in_page']) ? get_the_permalink($sb_sign_in_page) : home_url('/');
        if ($redirect_url != '') {
            $query_url = parse_url($login_page_url, PHP_URL_QUERY);
            if ($query_url) {
                $red_url = '&u=' . $redirect_url;
            } else {
                $red_url = '?u=' . $redirect_url;
            }
        }
        $final_redi_url = $login_page_url . $red_url;
        $final_redi_url = apply_filters('adforest_page_lang_url', $final_redi_url);
        return $final_redi_url;
    }

}
if (!function_exists('adforest_setPostViews')) {

    function adforest_setPostViews($postID) {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

}
if (!function_exists('adforest_get_ad_cats')) {

    function adforest_get_ad_cats($id, $by = 'name', $for_country = false, $event_tax = "") {
        $taxonomy = 'ad_cats'; //Put your custom taxonomy term here

        if ($for_country) {
            $taxonomy = 'ad_country';
        } else {
            $taxonomy = 'ad_cats'; //Put your custom taxonomy term here
        }

        if ($event_tax != "") {
            $taxonomy = $event_tax;
        }

        $terms = wp_get_post_terms($id, $taxonomy);
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }
        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy	
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy	  
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }
        return $cats;

//
//        $post_categories = wp_get_object_terms($id, array('ad_cats'), array('orderby' => 'term_group'));
//        $cats = array();
//        foreach ($post_categories as $c) {
//            $cat = get_term($c);
//            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
//        }
//        return $cats;
    }

}

/* Time difference n days */
if (!function_exists('adforest_days_diff')) {

    function adforest_days_diff($now, $from) {
        $datediff = $now - $from;
        return floor($datediff / (60 * 60 * 24));
    }

}

if (!function_exists('adforest_owner_text_callback')) {

    function adforest_owner_text_callback($phone_number = '') {
        global $adforest_theme;
        $owner_deal_text = isset($adforest_theme['owner_deal_text']) && !empty($adforest_theme['owner_deal_text']) ? $adforest_theme['owner_deal_text'] : '';

        if (!empty($owner_deal_text)) {
            echo '<div class="adforest-owner-text">' . adforest_returnEcho($owner_deal_text) . '</div>';
        }
    }

    add_action('adforest_owner_text', 'adforest_owner_text_callback');
}
if (!function_exists('adforest_bidding_stats')) {

    function adforest_bidding_stats($ad_id, $style = 'style-1') {
        global $adforest_theme;
        $html = '';
        $bids_res = adforest_get_all_biddings_array($ad_id);

        // echo '<';


        $total_bids = count($bids_res);
        $max = 0;
        $min = 0;
        if ($total_bids > 0) {
            $max = max($bids_res);
            $min = min($bids_res);
        }

        $thousands_sep = ",";
        if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != '') {
            $thousands_sep = $adforest_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != '') {
            $decimals = $adforest_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != '') {
            $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
        }

        $curreny = $adforest_theme['sb_currency'];
        if (get_post_meta($ad_id, '_adforest_ad_currency', true) != "") {
            $curreny = get_post_meta($ad_id, '_adforest_ad_currency', true);
        }

        // Price format
        $max = number_format((int) $max, $decimals, $decimals_separator, $thousands_sep);
        $min = number_format((int) $min, $decimals, $decimals_separator, $thousands_sep);

        $min = substr($min, 0, 12);
        $max = substr($max, 0, 12);

        if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
            $max = $max . '<small>' . $curreny . '</small>';
            $min = $min . '<small>' . $curreny . '</small>';
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
            $max = '<small>' . $curreny . '</small>' . $max;
            $min = '<small>' . $curreny . '</small>' . $min;
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
            $max = $max . ' <small>' . $curreny . '</small>';
            $min = $min . ' <small>' . $curreny . '</small>';
        } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
            $max = '<small>' . $curreny . '</small> ' . $max;
            $min = '<small>' . $curreny . '</small> ' . $min;
        } else {
            $max = '<small>' . $curreny . '</small>' . $max;
            $min = '<small>' . $curreny . '</small>' . $min;
        }


        if ($style == 'style-3') {
            $bid_stat_class = 'main-section-bid  section-bid-2';
            $bid_sidebar = FALSE;

            $html .= '<div class="' . $bid_stat_class . '">
                    <nav class="nav nav-tabs" role="tablist">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                       <a class ="nav-link active" href="#home" aria-controls="home" role="tab" data-bs-toggle="tab">' . __('Bidding Stats', 'adforest') . '</a>';
            if (isset($adforest_theme['top_bidder_limit']) && $adforest_theme['top_bidder_limit'] != "" && $adforest_theme['top_bidder_limit'] != 0)
                $html .= '<a class ="nav-link"  href="#profile" aria-controls="profile" role="tab" data-bs-toggle="tab">' . __('Top Bidders', 'adforest') . '</a>';

            $html .= '</div>';
            $html .= '</nav>
                    <div class="tab-content bidding-advanced">
                       <div role="tabpanel" class="tab-pane active" id="home">';

            if (get_post_meta($ad_id, '_adforest_ad_bidding_date', true) != "" && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                $bid_end_date = get_post_meta($ad_id, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date) {
                    $html .= '<div class="text-center bid-close-msg"><a href="javascript:void(0);"><i class="fa fa-lock"></i> ' . __('Bidding has been closed.', 'adforest') . '</a></div>';
                    do_action('adforest_send_email_bid_winner', $ad_id);
                }
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {

                    $html .= adforest_timer_html($bid_end_date);
                }
            }
            $html .= '<div class="panel status panel-info">
				<div class="bids-panel-heading">
					<span class="bids-heading">' . __('Total Bids', 'adforest') . '</span>
				</div>
                                <div class="bids-panel-num">
                                <a href="#all-bids-comment">' . esc_html($total_bids) . '</a>
                                </div>
			</div>
			<div class="panel status panel-success">
				<div class="bids-panel-heading">
					<span class="bids-heading">' . __('Highest Bid', 'adforest') . ' </span>
				</div>
                                 <div class="bids-panel-num">
                                 <a href="#tab2default">' . $max . '</a>
                                 </div>
			</div>
			<div class="panel status panel-warning">
				<div class="bids-panel-heading">
					<span class="bids-heading">' . __('Lowest Bid', 'adforest') . '</span>
				</div>
                                <div class="bids-panel-num">
                                    <a href="#tab2default">' . $min . '</a>
			</div>
                        </div>                      
                        </div>
                        </<div>
			<div role="tabpanel" class="tab-pane " id="profile">
         <div class="sidebar-activity">
            <div class="adforest-top-bidders">';
            arsort($bids_res);
            $count = 1;
            if ($total_bids > 0) {
                foreach ($bids_res as $key => $val) {
                    $data = explode('_', $key);
                    $bidder_id = isset($data[0]) ? $data[0] : "";
                    $bid_date = isset($data[1]) ? $data[1] : "";
                    $user_info = get_userdata($bidder_id);
                    $bidder_name = 'demo';
                    $user_profile = 'javascript:void(0);';
                    if (isset($user_info->display_name) && $user_info->display_name != "") {
                        $bidder_name = $user_info->display_name;
                        $user_profile = adforest_set_url_param(get_author_posts_url($bidder_id), 'type', 'ads');
                    } else {
                        continue;
                        //$bidder_name = $user_info->display_name;
                        //$user_profile	= get_author_posts_url(1 );
                    }

                    $current_user = get_current_user_id();
                    $ad_owner = get_post_field('post_author', $ad_id);
                    $cls = '';
                    $admin_html = '';
                    if ($current_user == $ad_owner && get_post_meta($ad_id, '_adforest_poster_contact', true) != "") {
                        $admin_html = '<time class="date">' . get_user_meta($bidder_id, '_sb_contact', true) . '</time>';
                    }
                    $val = substr($val, 0, 12);
                    $user_pic = adforest_get_user_dp($bidder_id, 'adforest-single-small');
                    if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                        $offer = $val . '<small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                        $offer = $val . ' <small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                        $offer = '<small>' . $curreny . '</small> ' . $val;
                    } else {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    }
                    $html .= '<div class="top-bider">
                    <div class="number-head">
                        <div class="img-head">
                            <img src="' . esc_url($user_pic) . '" alt="' . esc_attr($bidder_name) . '">
                            <span>' . $count . '</span>
                        </div>
                        <div class="head-name">
                        <a class="text-black" href="' . $user_profile . '"><h4>' . $bidder_name . '</h4></a>                         
                            <i class="fa fa-clock-o"></i><span> ' . adforest_timeago($bid_date) . '</span>
                        </div>
                    </div>
                    <div class="num-bg">
                        <a href="javascript:void(0);" class="bg-numbering">' . $offer . '</a>
                    </div>
                </div>';
                    $max_bidder = 5;
                    if (isset($adforest_theme['top_bidder_limit']) && $adforest_theme['top_bidder_limit'] != "")
                        $max_bidder = $adforest_theme['top_bidder_limit'];

                    if ($count == $max_bidder)
                        break;
                    $count++;
                }
            } else {
                $html .= '<p class="text-center"><em>' . __('There is no bid yet.', 'adforest') . '</em></p>';
            }

            $html .= '</div>
         </div>
      </div>
   </div>
</div>
';
        } else {
            $html .= '<div class="main-section-bid bidding-section-1">';
            $html .= '<h4>' . esc_html__('Bidding Stats', 'adforest') . '</h4>';
            if (get_post_meta($ad_id, '_adforest_ad_bidding_date', true) != "" && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                $bid_end_date = get_post_meta($ad_id, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date) {
                    $html .= '<div class="text-center bid-close-msg"><a href="javascript:void(0);"><i class="fa fa-lock"></i> ' . __('Bidding has been closed.', 'adforest') . '</a></div>';
                    do_action('adforest_send_email_bid_winner', $ad_id);
                }
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                    $html .= '<p class="text-center bid_close no-display"><i class="fa fa-lock"></i> ' . __('Bidding has been closed.', 'adforest') . '</p>';
                    $html .= adforest_timer_html($bid_end_date);
                }
            }
            $html .= '<ul class="total-list"><div class="bid-stats">
                         <li>				
					<a href="javascript:void()" class="total-bid">' . esc_html($total_bids) . '</a>	<p>' . __('Total Bids', 'adforest') . '</p>			
			</li>
			 <li>			
					 <a href="javascript:void()" class="high-bid"> ' . $max . '</a>	<p>' . __('Highest Bid', 'adforest') . '</p>			
			</li>
			 <li>		
					<a href="javascript:void()" class="low-bid">' . $min . '</a>	<p >' . __('Lowest Bid', 'adforest') . ': </p>		
			</li>

			</ul>                
                        </hr>';

            arsort($bids_res);
            $count = 1;
            if ($total_bids > 0) {

                $html .= '<div class="top-bidder-container"><h2>' . esc_html__('Top Bidder', 'adforest') . '</h2>';

                foreach ($bids_res as $key => $val) {
                    $data = explode('_', $key);
                    $bidder_id = $data[0];
                    $bid_date = $data[1];

                    $user_info = get_userdata($bidder_id);
                    $bidder_name = 'demo';
                    $user_profile = 'javascript:void(0);';
                    if (isset($user_info->display_name) && $user_info->display_name != "") {
                        $bidder_name = $user_info->display_name;
                        $user_profile = adforest_set_url_param(get_author_posts_url($bidder_id), 'type', 'ads');
                    } else {
                        continue;
                        //$bidder_name = $user_info->display_name;
                        //$user_profile	= get_author_posts_url(1 );
                    }

                    $current_user = get_current_user_id();
                    $ad_owner = get_post_field('post_author', $ad_id);
                    $cls = '';
                    $admin_html = '';
                    if ($current_user == $ad_owner && get_post_meta($ad_id, '_adforest_poster_contact', true) != "") {
                        $admin_html = '<time class="date">' . get_user_meta($bidder_id, '_sb_contact', true) . '</time>';
                    }

                    $val = substr($val, 0, 12);

                    $user_pic = adforest_get_user_dp($bidder_id, 'shop_thumbnail');

                    if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                        $offer = $val . '<small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                        $offer = $val . ' <small>' . $curreny . '</small>';
                    } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                        $offer = '<small>' . $curreny . '</small> ' . $val;
                    } else {
                        $offer = '<small>' . $curreny . '</small>' . $val;
                    }

                    $html .= '<div class="top-bider">
                    <div class="number-head">
                        <div class="img-head">
                            <img src="' . esc_url($user_pic) . '" alt="' . esc_attr($bidder_name) . '">
                            <span>' . $count . '</span>
                        </div>
                        <div class="head-name">
                        <a class="text-black" href="' . $user_profile . '"><h4>' . $bidder_name . '</h4></a>                         
                            <i class="fa fa-clock-o"></i><span> ' . adforest_timeago($bid_date) . '</span>
                        </div>
                    </div>
                    <div class="num-bg">
                        <a href="javascript:void(0);" class="bg-numbering">' . $offer . '</a>
                    </div>
                </div>';

                    $max_bidder = 5;
                    if (isset($adforest_theme['top_bidder_limit']) && $adforest_theme['top_bidder_limit'] != "")
                        $max_bidder = $adforest_theme['top_bidder_limit'];

                    if ($count == $max_bidder)
                        break;
                    $count++;
                }

                $html .= '</div>';
            } else {
                $html .= '<p class="text-center"><em>' . __('There is no bid yet.', 'adforest') . '</em></p>';
            }

            $html .= '</div>
';
        }
        return $html;
    }

}
if (!function_exists('adforest_get_all_biddings_array')) {

    function adforest_get_all_biddings_array($ad_id) {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_adforest_bid_%' ORDER BY meta_id DESC", OBJECT);
        $bid_array = array();
        if (count($biddings) > 0) {
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $bid_array[$data_array[2] . '_' . $data_array[0]] = $data_array[3];
            }
        }

        return $bid_array;
    }

}
if (!function_exists('adforest_html_bidding_system')) {

    function adforest_html_bidding_system($pid, $bid_style = 'style-1') {
        global $adforest_theme;
        $pid = apply_filters('adforest_language_page_id', $pid, 'ad_post');
        ?><div class="all-bids-comment" id="all-bids-comment">
            <h3> <?php echo esc_html($adforest_theme['sb_comments_section_title']); ?></h3>

            <?php echo adforest_bidding_html($pid); ?>             

            <div class="bidiing-comment">             
                <?php
                $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true); // '2018-03-16 14:59:00';
                if ($bid_end_date != "" && date('Y-m-d H:i:s') > $bid_end_date && isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                    echo '<em>' . __('Bidding has been closed.', 'adforest') . '</em>';
                } else {
                    ?>
                    <form role="form" id="sb_bid_ad" >
                        <div class="row">

                            <?php
                            $col = 8;
                            ?>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <input name="bid_amount" placeholder="<?php echo __('Bid', 'adforest'); ?>" class="form-control" type="text" data-parsley-required="true" data-parsley-pattern="/^[0-9]+\.?[0-9]*$/" data-parsley-error-message="<?php echo __('only numbers allowed.', 'adforest'); ?>" autocomplete="off" maxlength="12"/>
                            </div>
                            <div class="col-md-<?php echo esc_attr($col); ?> margin-bottom-10">   
                                <input name="bid_comment" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'adforest'); ?>" placeholder="<?php echo __('Comments...', 'adforest'); ?>" class="form-control" type="text" autocomplete="off">
                                <small><em><?php echo esc_html($adforest_theme['sb_comments_section_note']); ?></em></small>
                            </div>   
                            <div class="col-md-2">
                                <button class="btn btn-theme bid_submit" type="submit"><?php echo __('Send', 'adforest'); ?></button>
                                <input type="hidden" name="ad_id" value="<?php echo esc_attr($pid) ?>" />
                                <input type="hidden" id="sb-bidding-token" value="<?php echo wp_create_nonce('sb_bidding_secure'); ?>" />
                            </div>
                        </div>
                    </form>

                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

}
if (!function_exists('adforest_bidding_html')) {

    function adforest_bidding_html($ad_id, $bidhtml_style = 'style-1') {
        global $adforest_theme;

        $curreny = $adforest_theme['sb_currency'];
        if (get_post_meta($ad_id, '_adforest_ad_currency', true) != "") {
            $curreny = get_post_meta($ad_id, '_adforest_ad_currency', true);
        }

        $biddings = adforest_get_all_biddings($ad_id);
        global $wpdb;
        $html = '';
        if (count($biddings) > 0) {

            $html .= '<div class="bg-bids">';
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $date = $data_array[0];
                $comments = $data_array[1];
                $user = $data_array[2];
                $offer = '';
                $user_info = get_user_by('ID', $user);
                if ($user_info === false)
                    continue;

                $current_user = get_current_user_id();
                $ad_owner = get_post_field('post_author', $ad_id);
                $cls = '';
                $admin_html = '';
                if ($current_user == $ad_owner && get_post_meta($ad_id, '_adforest_poster_contact', true) != "") {
                    $cls = 'admin';
                    $admin_html = '<span class="user_bid_contact"><i class="fa fa-phone"></i>' . get_user_meta($user_info->ID, '_sb_contact', true) . '</span>';
                }

                $offer = substr($data_array[3], 0, 12);
                $thousands_sep = ",";
                if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != '') {
                    $thousands_sep = $adforest_theme['sb_price_separator'];
                }
                $decimals = 0;
                if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != '') {
                    $decimals = $adforest_theme['sb_price_decimals'];
                }
                $decimals_separator = ".";
                if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != '') {
                    $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
                }
                // Price format
                $price = number_format($offer, $decimals, $decimals_separator, $thousands_sep);
                $price = ( isset($price) && $price != "") ? $price : 0;

                if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right') {
                    $price = $price . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left') {
                    $price = $curreny . $price;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'right_with_space') {
                    $price = $price . " " . $curreny;
                } else if (isset($adforest_theme['sb_price_direction']) && $adforest_theme['sb_price_direction'] == 'left_with_space') {
                    $price = $curreny . " " . $price;
                } else {
                    $price = $curreny . $price;
                }

                $html .= '<div class="comment-bids"><div class="name-numbering-head">
                                        <div class="name-img-circle">
                                        <a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '">
                                            <img src="' . adforest_get_user_dp($user_info->ID) . '" alt="' . esc_attr__('image', 'adforest') . '" /></a>
                                        </a>                                       
                                       </div> 
                                     
                                    <div class="name-heading">
                                          <a href="' . adforest_set_url_param(get_author_posts_url($user_info->ID), 'type', 'ads') . '"> <h5>' . $user_info->display_name . '</h5></a>
                                        <span><i class="fa fa-calendar"></i> ' . date_i18n(get_option('date_format'), strtotime($date)) . '</span>
                                          ' . $admin_html . '
                                        
                                      <p>' . esc_html($comments) . '</p>
                                      </div>
                                       </div>
                                        <div class="price-product">
                                       <div class="btn btn-numbering">' . $price . '</div>
                                        </div>
                                        
                                   </div>';
            }

            $html .= "</div>";
        }
        return $html;
    }

}

if (!function_exists('adforest_get_all_biddings')) {

    function adforest_get_all_biddings($ad_id) {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_adforest_bid_%' ORDER BY meta_id DESC", OBJECT);
        return $biddings;
    }

}
if (!function_exists('adforest_fetch_reviews_average')) {

    function adforest_fetch_reviews_average($listing_id) {
        $comments = '';
        $get_rating_avrage = '';
        $one_star = '';
        $two_star = '';
        $three_star = '';
        $four_star = '';
        $five_star = '';
        $star1 = $star2 = $star3 = $star4 = $star5 = 0;
        $args = array(
            'type__in' => array('ad_post_rating'),
            'parent' => 0, // only parents
            'post_id' => $listing_id, // use post_id, not post_ID
        );
        $comments = get_comments($args);
        if (count($comments) > 0) {

            $sum_of_rated = 0;
            $no_of_times_rated = 0;
            foreach ($comments as $comment) {
                //echo '==+++==';
                //echo apply_filters('wpml_object_id',$comment->comment_ID, 'post', FALSE, 'en');
                //echo '====';
                $rated = get_comment_meta($comment->comment_ID, 'review_stars', true);
                if ($rated != "" && $rated > 0) {
                    $sum_of_rated += $rated;
                    $no_of_times_rated++;
                    //now rated percentage
                    if ($rated == 1) {
                        $star1++;
                    }
                    if ($rated == 2) {
                        $star2++;
                    }
                    if ($rated == 3) {
                        $star3++;
                    }
                    if ($rated == 4) {
                        $star4++;
                    }
                    if ($rated == 5) {
                        $star5++;
                    }
                }
            }
            //loop end get avrage value
            $get_rating_avrage = round($sum_of_rated / $no_of_times_rated, 2);
            $get_rating_avrage1 = round($sum_of_rated / $no_of_times_rated, 1);
            $one_star = round(($star1 / $no_of_times_rated) * 100);
            $two_star = round(($star2 / $no_of_times_rated) * 100);
            $three_star = round(($star3 / $no_of_times_rated) * 100);
            $four_star = round(($star4 / $no_of_times_rated) * 100);
            $five_star = round(($star5 / $no_of_times_rated) * 100);

            $total_stars = explode(".", $get_rating_avrage1);

            $stars_html = '';
            $first_part = (isset($total_stars[0]) && $total_stars[0] > 0 && $total_stars[0] != "" ) ? $total_stars[0] : 0;
            $second_part = (isset($total_stars[1]) && $total_stars[1] > 0 && $total_stars[1] != "" ) ? $total_stars[1] : 0;
            for ($stars = 1; $stars <= 5; $stars++) {
                if ($stars <= $first_part && $first_part > 0) {
                    $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                } else if ($stars == $first_part + 1 && $second_part <= 5 && $second_part > 0) {
                    $stars_html .= '<i class="fa fa-star-half-o color" aria-hidden="true"></i>';
                } else if ($stars == $first_part + 1 && $second_part > 5 && $second_part > 0) {
                    $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                } else {
                    $stars_html .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                }
            }
            if (strpos($get_rating_avrage, ".") !== false) {
                $get_rating_avrage = $get_rating_avrage;
            } else {
                $get_rating_avrage = $get_rating_avrage . '.0';
            }

            $array = array();
            $array['total_stars'] = $stars_html;
            $array['average'] = $get_rating_avrage;
            $array['rated_no_of_times'] = $no_of_times_rated;
            $array['ratings'] = array('1_star' => $one_star, '2_star' => $two_star, '3_star' => $three_star, '4_star' => $four_star, '5_star' => $five_star);
            return $array;
        }
    }

}

if (!function_exists('adforest_comments_pagination2')) {

    function adforest_comments_pagination2($total_records, $current_page) {
        // Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $args = array(
            'base' => add_query_arg('page-number', '%#%'),
            'format' => '?page-number=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            'type' => 'array');
        $pagination = paginate_links($args);
        $pagination_html = '';
        if (count((array) $pagination) > 0) {
            $pagination_html = '<ul class="pagination pagination-lg">';
            foreach ($pagination as $key => $page_link) {
                $link = $page_link;
                $class = '';
                if (strpos($page_link, 'current') !== false) {
                    $link = '<a href="javascript:void(0);">' . $current_page . '</a>';
                    $class = 'active';
                }
                $pagination_html .= '<li class="' . $class . '">' . $link . '</li>';
            }
            $pagination_html .= '</ul>';
        }
        return $pagination_html;
    }

}

if (!function_exists('adforest_comments_pagination')) {

    function adforest_comments_pagination($total_records, $current_page) {
        // Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $args = array(
            'base' => add_query_arg('page', '%#%'),
            'format' => '?page=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            'type' => 'array');
        $pagination = paginate_links($args);
        $pagination_html = '';
        if (count((array) $pagination) > 0) {
            $pagination_html = '<ul class="pagination">';
            foreach ($pagination as $key => $page_link) {
                $link = $page_link;
                $class = '';
                if (strpos($page_link, 'current') !== false) {
                    $link = '<a href="javascript:void(0);">' . $current_page . '</a>';
                    $class = 'active';
                }
                $pagination_html .= '<li class="' . $class . '">' . $link . '</li>';
            }
            $pagination_html .= '</ul>';
        }
        return $pagination_html;
    }

}

if (!function_exists('adforest_social_share')) {

    function adforest_social_share() {
        // check if plugin addtoany actiavted then load that otherwise builtin function
        if (in_array('add-to-any/add-to-any.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            return do_shortcode('[addtoany]');
        }
        // Get current page URL 
        $sbURL = esc_url(get_permalink());
        // Get current page title
        $sbTitle = str_replace(' ', '%20', esc_html(get_the_title()));
        // Get Post Thumbnail for pinterest
        $sbThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(esc_html(get_the_ID())), 'sb-single-blog-featured');
        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text=' . $sbTitle . '&amp;url=' . $sbURL;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $sbURL;
        $googleURL = 'https://plus.google.com/share?url=' . $sbURL;
        $bufferURL = 'https://bufferapp.com/add?url=' . $sbURL . '&amp;text=' . $sbTitle;
        // Based on popular demand added Pinterest too
        $sbThumbnail[0] = isset($sbThumbnail[0]) ? $sbThumbnail[0] : "";

        $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $sbURL . '&amp;media=' . $sbThumbnail[0] . '&amp;description=' . $sbTitle;
        // Add sharing button at the end of page/page content
        return '<a href="' . esc_url($facebookURL) . '" class="btn btn-fb btn-md" target="_blank"><i class="fa fa-facebook"></i></a><a href="' . esc_url($twitterURL) . '" class="btn btn-twitter btn-md" target="_blank"><i class="fa fa-twitter"></i></a><a href="' . esc_url($googleURL) . '" class="btn btn-gplus btn-md" target="_blank"><i class="fa fa-google"></i></a>';
    }

}

/* making number callable */
if (!function_exists('adforest_get_CallAbleNumber')) {

    function adforest_get_CallAbleNumber($phone_number = '') {
        return preg_replace("/[^0-9+]/", "", $phone_number);
    }

}
/* Show phone number to user check */
if (!function_exists('adforest_showPhone_to_users')) {

    function adforest_showPhone_to_users() {
        global $adforest_theme;

        $restrict_phone_show = ( isset($adforest_theme['restrict_phone_show']) ) ? $adforest_theme['restrict_phone_show'] : 'all';
        $is_show_phone = false;
        if ($restrict_phone_show == "login_only") {
            $is_show_phone = true;
            if (is_user_logged_in()) {
                $is_show_phone = false;
            }
        }
        return $is_show_phone;
    }

}

/* Time Ago */
if (!function_exists('adforest_timeago')) {

    function adforest_timeago($date) {

        adforest_set_date_timezone();
        $timestamp = strtotime($date);

        $strTime = array(__('second', 'adforest'), __('minute', 'adforest'), __('hour', 'adforest'), __('day', 'adforest'), __('month', 'adforest'), __('year', 'adforest'));
        $length = array("60", "60", "24", "30", "12", "10");

        //$currentTime = time();
        $currentTime = current_time('mysql', 1);
        //$currentTime = date('Y-m-d H:i:s');
        $currentTime = strtotime($currentTime);
        if ($currentTime >= $timestamp) {
            $diff = $currentTime - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }
            $diff = round($diff);
            return $diff . " " . $strTime[$i] . __('(s) ago', 'adforest');
        }
    }

}

/* Return adforest ad statuses */
if (!function_exists('adforest_ad_statues')) {

    function adforest_ad_statues($index) {
        if ($index == "")
            $index = 'active';
        $sb_status = array('active' => __('Active', 'adforest'), 'expired' => __('Expired', 'adforest'), 'sold' => __('Sold', 'adforest'));
        return $sb_status[$index];
    }

}

/* Return adforest ad statuses */
if (!function_exists('adforest_is_demo')) {

    function adforest_is_demo() {

        global $adforest_theme;

        $restrict_phone_show = ( isset($adforest_theme['is_demo']) ) ? $adforest_theme['is_demo'] : false;

        return $restrict_phone_show;
    }

}


/* Bad word filter */
if (!function_exists('adforest_badwords_filter')) {

    function adforest_badwords_filter($words = array(), $string = "", $replacement = "") {
        foreach ($words as $word) {
            $string = preg_replace('/\b' . $word . '\b/iu', $replacement, $string);
        }
        return $string;
    }

}


/* get current page url */
if (!function_exists('adforest_get_current_url')) {

    function adforest_get_current_url() {
        $site_url = site_url();
        $findme = 'https';
        if (strpos($site_url, $findme) !== false) {
            return $actual_link = "https://" . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        } else {
            return $actual_link = "http://" . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
    }

}

/* check is user login or not */
if (!function_exists('adforest_user_logged_in')) {

    function adforest_user_logged_in() {
        if (get_current_user_id() != 0) {
            echo adforest_redirect(home_url('/'));
            exit;
        }
    }

}


/* adforest redirect */
if (!function_exists('adforest_redirect')) {

    function adforest_redirect($url = '') {
        return "<script> var red_url = decodeURI('{$url}'); window.location = red_url;console.log(red_url);</script>";
    }

}


if (!function_exists('adforest_verify_sms_gateway')) {

    function adforest_verify_sms_gateway() {
        global $adforest_theme;
        $gateway = '';
        if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && class_exists('WP_Twilio_Core')) {
            $gateway = 'twilio';
        } else if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && in_array('wp-iletimerkezi-sms/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $gateway = 'iletimerkezi-sms';
        }

        return $gateway;
    }

}


/* adforest search params */
if (!function_exists('adforest_custom_remove_url_query')) {

    function adforest_custom_remove_url_query($key = '', $value = '') {
        $url = adforest_curPageURL();
        $param = "?" . $_SERVER['QUERY_STRING'];
        $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $param);
        $url = rtrim($url, '?');
        $url = rtrim($url, '&');
        $final_url = ( $url != "" ) ? $url . "&$key=$value" : "?$key=$value";
        return $final_url;
    }

}

if (!function_exists('adforest_curPageURL')) {

    function adforest_curPageURL() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]))
            if ($_SERVER["HTTPS"] == "on") {
                $pageURL .= "s";
            }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}
if (!function_exists('adforest_search_params')) {

    function adforest_search_params($index, $second = '', $third = '', $search_url = false) {
        global $adforest_theme;
        $param = $_SERVER['QUERY_STRING'];
        $res = '';
        //if (isset($param) && $index != 'cat_id' && $index != 'country_id') {
        if (isset($param)) {
            parse_str($_SERVER['QUERY_STRING'], $vars);
            foreach ($vars as $key => $val) {
                if ($key == $index) {
                    continue;
                }

                if ($second != "") {
                    if ($key == $second) {
                        continue;
                    }
                }
                if ($third != "") {
                    if ($key == $third) {
                        continue;
                    }
                }

                if (isset($vars['custom']) && count($vars['custom']) > 0 && 'custom' == $key) {


                    if (is_array($val)) {
                        if (isset($val) && count($val) > 0) {
                            foreach ($val as $ckey => $cval) {
                                $name = "custom[$ckey]";
                                if ($name == $index) {
                                    continue;
                                }
                                if (isset($cval) && is_array($cval)) {
                                    foreach ($cval as $v) {
                                        $res .= '<input type="hidden" name="' . esc_attr($name) . '[]" value="' . esc_attr($v) . '" />';
                                    }
                                } else {
                                    $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                                }
                            }
                        }
                    } else {

                        foreach ($vars['custom'] as $ckey => $cval) {
                            $name = "custom[$ckey]";
                            if ($name == $index) {
                                continue;
                            }
                            $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                        }
                    }
                } else if (isset($vars['min_custom']) && count((array) $vars['min_custom']) > 0 && 'min_custom' == $key) {
                    foreach ($vars['min_custom'] as $ckey => $cval) {
                        $name = "min_custom[$ckey]";
                        if ($name == "min_" . $index) {
                            continue;
                        }
                        if ($name == $index) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else if (isset($vars['max_custom']) && count((array) $vars['max_custom']) > 0 && 'max_custom' == $key) {
                    foreach ($vars['max_custom'] as $ckey => $cval) {
                        $name = "max_custom[$ckey]";
                        if ($name == "max_" . $index) {
                            continue;
                        }
                        if ($name == $second) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else {
                    $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                }
            }
        } else if ($search_url) {
            $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
            $res = get_the_permalink($sb_search_page);
        }
        return $res;
    }

}

if (!function_exists('adforest_pagination_search')) {

    function adforest_pagination_search($wp_query) {
        //  if (is_singular())
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

        echo '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
            printf('<li>%s</li>' . "\n", get_previous_posts_link());

        /**     Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>';
        }
        /**     Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array) $links as $link) {

            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }
        /**     Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }

        if (get_next_posts_link_custom($wp_query))
            printf('<li>%s</li>' . "\n", get_next_posts_link_custom($wp_query));

        echo '</ul>' . "\n";
    }

}
if (!function_exists('get_next_posts_link_custom')) {

    function get_next_posts_link_custom($wp_query, $label = null, $max_page = 0) {
        global $paged;

        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        if (!$paged)
            $paged = 1;

        $nextpage = intval($paged) + 1;

        if (null === $label)
            $label = __('Next Page &raquo;', 'adforest');

        if ($nextpage <= $max_page) {
            /**
             * Filters the anchor tag attributes for the next posts page link.
             *
             * @since 2.7.0
             *
             * @param string $attributes Attributes for the anchor tag.
             */
            $attr = apply_filters('next_posts_link_attributes', '');

            return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
        }
    }

}


/* get ads category */
if (!function_exists('adforest_get_cats')) {

    function adforest_get_cats($taxonomy = 'category', $parent_of = 0, $child_of = 0, $type = 'general') {
        global $adforest_theme;
        $search_popup_cat_disable = isset($adforest_theme['search_popup_cat_disable']) ? $adforest_theme['search_popup_cat_disable'] : false;
        $search_popup_loc_disable = isset($adforest_theme['search_popup_loc_disable']) ? $adforest_theme['search_popup_loc_disable'] : false;

        $show_all_terms = FALSE;
        if ($search_popup_cat_disable && $taxonomy == 'ad_cats') {
            $show_all_terms = TRUE;
        }
        if ($search_popup_loc_disable && $taxonomy == 'ad_country') {
            $show_all_terms = TRUE;
        }

        if ($type == 'post_ad') {
            $show_all_terms = FALSE;
        }

        $defaults = array(
            'taxonomy' => $taxonomy,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => $show_all_terms,
            'exclude' => array(),
            'exclude_tree' => array(),
            'number' => '',
            'offset' => '',
            'fields' => 'all',
            'name' => '',
            'slug' => '',
            'hierarchical' => true,
            'search' => '',
            'name__like' => '',
            'description__like' => '',
            'pad_counts' => false,
            'get' => '',
            'child_of' => $child_of,
            'parent' => $parent_of,
            'childless' => false,
            'cache_domain' => 'core',
            'update_term_meta_cache' => true,
            'meta_query' => ''
        );
        $defaults = apply_filters('adforest_wpml_show_all_posts', $defaults); // for all lang texonomies

        if (taxonomy_exists($taxonomy)) {
            return get_terms($defaults);
        } else {
            return array();
        }
    }

}


/* Get parents of custom taxonomy */
if (!function_exists('adforest_get_taxonomy_parents')) {

    function adforest_get_taxonomy_parents($id, $taxonomy, $link = true, $separator = ' &raquo; ', $nicename = false, $visited = array()) {

        $chain = '';
        $parent = get_term($id, $taxonomy);
        if (is_wp_error($parent)) {
            echo "fail";
            return $parent;
        }

        if (!isset($parent) || empty($parent)) {
            return;
        }

        if ($nicename) {
            $name = $parent->slug;
        } else {
            $name = $parent->name;
        }

        if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
            $visited[] = $parent->parent;
            $chain .= adforest_get_taxonomy_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
        }

        if ($link) {
            $chain .= '<a href="' . esc_url(get_term_link((int) $parent->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'adforest'), $parent->name)) . '">' . $name . '</a>' . $separator;
        } else {
            $chain .= $separator . $name;
        }
        return $chain;
    }

}


if (!function_exists('adforest_search_layout')) {

    function adforest_search_layout() {
        global $adforest_theme, $template;
        $widget_layout = 'sidebar';
        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'topbar') {
            $widget_layout = 'topbar';
        } else if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
            $widget_layout = 'map';
        }

        $page_template = basename($template);
        if ($page_template == 'taxonomy-ad_cats.php' || $page_template == 'taxonomy-ad_country.php') {
            $widget_layout = 'sidebar';
        }


        return $widget_layout;
    }

}

if (!function_exists('adforest_timer_html')) {

    function adforest_timer_html($bid_end_date, $show_unit = true, $unit_style = 'style-1') {
        global $adforest_theme;

        if (isset($adforest_theme['bidding_timer']) && !$adforest_theme['bidding_timer']) {
            return;
        }

        if ($bid_end_date == "")
            return '';

        $days = $hours = $minutes = $seconds = '';
        if ($show_unit) {

            if ($unit_style == 'style-2') {
                $days = '<div class="text">' . __('Days', 'adforest') . '</div>';
                $hours = '<div class="text">' . __('Hours', 'adforest') . '</div>';
                $minutes = '<div class="text">' . __('Min', 'adforest') . '</div>';
                $seconds = '<div class="text">' . __('Sec', 'adforest') . '</div>';
            } else {
                $days = '<div class="text">' . __('Days', 'adforest') . '</div>';
                $hours = '<div class="text">' . __('Hrs', 'adforest') . '</div>';
                $minutes = '<div class="text">' . __('Min', 'adforest') . '</div>';
                $seconds = '<div class="text">' . __('Sec', 'adforest') . '</div>';
            }
        }

        $mt_rand = mt_rand();
        $html = '<div class="clock" data-rand="' . esc_attr($mt_rand) . '" data-date="' . $bid_end_date . '"><div class="column-time clock-days"><div class="bidding_timer days-' . esc_attr($mt_rand) . '" id="days-' . esc_attr($mt_rand) . '"></div>' . $days . '</div><div class="column-time"><div class="bidding_timer hours-' . esc_attr($mt_rand) . '" id="hours-' . esc_attr($mt_rand) . '"></div>' . $hours . '</div><div class="column-time"><div class="bidding_timer minutes-' . esc_attr($mt_rand) . '" id="minutes-' . esc_attr($mt_rand) . '"></div>' . $minutes . '</div><div class="column-time"><div class="bidding_timer seconds-' . esc_attr($mt_rand) . '" id="seconds-' . esc_attr($mt_rand) . '"></div>' . $seconds . '</div></div>';
        return $html;
    }

}

if (!function_exists('adforest_widget_counter')) {

    function adforest_widget_counter($return = false) {
        global $adforest_theme;
        @$GLOBALS['widget_counter'] += 1;
        if ($GLOBALS['widget_counter'] == $adforest_theme['search_widget_limit']) {
            if ($return)
                return '<a href="javascript:void(0);" class="adv-srch">' . __('Advance Search', 'adforest') . '</a>';
            else
                echo '<a href="javascript:void(0);" class="adv-srch">' . __('Advance Search', 'adforest') . '</a>';
        }
    }

}
if (!function_exists('adforest_advance_search_container')) {

    function adforest_advance_search_container($return = false) {
        global $adforest_theme;
        if ($GLOBALS['widget_counter'] == $adforest_theme['search_widget_limit']) {
            if ($return)
                return '</div><div class="hide_adv_search"><div class="row">';
            else
                echo '</div><div class="hide_adv_search"><div class="row">';
        }
    }

}
// get the depth level of any taxonomy
if (!function_exists('adforest_get_taxonomy_depth')) {

    function adforest_get_taxonomy_depth($term_id = 0, $taxonomy = 'ad_cats') {

        if ($term_id != 0) {
            $ancestors = get_ancestors($term_id, $taxonomy);
            return count($ancestors) + 1;
        }
        return 0;
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
if (!function_exists('adforest_determine_minMax_latLong')) {

    function adforest_determine_minMax_latLong($data_arr = array(), $check_db = true) {

        global $adforest_theme;

        /* $data_array = array("latitude" => '21212121212', "longitude" => '212121212121', "distance" => '100' ); */
        $data = array();
        $user_id = get_current_user_id();
        $success = false;
        $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';

        if (isset($data_arr) && !empty($data_arr)) {
            $nearby_data = $data_arr;
        } else if ($user_id && $check_db) {
            $nearby_data = get_user_meta($user_id, '_sb_user_nearby_data', true);
        }

        if (isset($nearby_data) && $nearby_data != "") {
            //array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance );
            $original_lat = $nearby_data['latitude'];
            $original_long = $nearby_data['longitude'];
            $distance = intval($nearby_data['distance']);

            if ($search_radius_type == 'mile' && $distance > 0) {
                $distance = $distance * 1.609344;  // convert kilometer to miles 
            }

            $lat = $original_lat; //latitude
            $lon = $original_long; //longitude
            $distance = ($distance); //your distance in KM
            $R = 6371; //constant earth radius. You can add precision here if you wish

            $maxLat = $lat + rad2deg($distance / $R);
            $minLat = $lat - rad2deg($distance / $R);

            $maxLon = $lon + rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));
            $minLon = $lon - rad2deg(asin($distance / $R) / @abs(@cos(deg2rad($lat))));

            $data['radius'] = $R;
            $data['distance'] = $distance;
            $data['lat']['original'] = $original_lat;
            $data['long']['original'] = $original_long;

            $data['lat']['min'] = $minLat;
            $data['lat']['max'] = $maxLat;

            $data['long']['min'] = $minLon;
            $data['long']['max'] = $maxLon;
        }
        return $data;
    }
}
if (!function_exists('adforest_getLatLong')) {
    function adforest_getLatLong($address = '') {
        global $adforest_theme;

        $gmap_api_key = isset($adforest_theme['gmap_api_key']) && !empty($adforest_theme['gmap_api_key']) ? $adforest_theme['gmap_api_key'] : '';
        $google_map_key_type = isset($adforest_theme['g-map-key-type']) && !empty($adforest_theme['g-map-key-type']) ? $adforest_theme['g-map-key-type'] : 'g_key_open';
        $gmap_restricted_api_key = isset($adforest_theme['gmap_restricted_api_key']) && !empty($adforest_theme['gmap_restricted_api_key']) ? $adforest_theme['gmap_restricted_api_key'] : '';

        if (isset($gmap_restricted_api_key) && !empty($gmap_restricted_api_key) && $google_map_key_type == 'g_key_restricted') {
            $gmap_api_key = $gmap_restricted_api_key;
        }
        if ($address) {
            $formattedAddr = str_replace(' ', '+', $address);
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=' . $gmap_api_key . '&address=' . $formattedAddr . '&language=' . get_bloginfo('language') . '&sensor=false', false, stream_context_create($arrContextOptions));
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            if (isset($output->results[0]->geometry->location->lat) && isset($output->results[0]->geometry->location->lng)) {
                $data['latitude'] = $output->results[0]->geometry->location->lat;
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            } else {
                return array();
            }
            //Return latitude and longitude of the given address
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
if (!function_exists('adforest_get_feature_text')) {

    function adforest_get_feature_text($pid) {
        ?>
        <div role="alert" class="alert alert-info alert-dismissible">
            <i class="fa fa-info-circle"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            <?php echo __('Mark as featured Ad,', 'adforest'); ?>
            <a href="javascript:void(0);" class="sb_anchor" data-btn-ok-label="<?php echo __('Yes', 'adforest'); ?>" data-btn-cancel-label="<?php echo __('No', 'adforest'); ?>" data-bs-toggle="confirmation" data-singleton="true" data-title="<?php echo __('Are you sure?', 'adforest'); ?>" data-content="" id="sb_feature_ad" aaa_id="<?php echo esc_attr($pid); ?>">
                <?php echo __('Click Here.', 'adforest'); ?>
            </a>




        </div>
        <?php
    }

}

if (!function_exists('adforest_social_profiles')) {

    function adforest_social_profiles() {
        global $adforest_theme;
        if (isset($adforest_theme['sb_enable_social_links']) && $adforest_theme['sb_enable_social_links']) {
            $social_netwroks = array(
                'facebook' => __('Facebook', 'adforest'),
                'twitter' => __('Twitter', 'adforest'),
                'linkedin' => __('Linkedin', 'adforest'),
                'instagram' => __('Instagram', 'adforest'),
                    //'google' => __('Google', 'adforest')
            );
        } else {
            $social_netwroks = array();
        }
        return $social_netwroks;
    }

}


if (!function_exists('adforest_get_sold_ads')) {

    function adforest_get_sold_ads($user_id) {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM $wpdb->posts WHERE post_type = 'ad_post' AND post_author = '$user_id' AND post_status = 'publich' ");

        $args = array(
            'post_type' => 'ad_post',
            'author__in' => $user_id,
            'posts_per_page' => -1,
            'post_status' => 'draft',
            'meta_key' => '_adforest_ad_status_',
            'meta_value' => 'sold',
        );
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $query = new WP_Query($args);
        return $query->post_count;
        wp_reset_postdata();
    }

}

if (!function_exists('adforest_get_all_ads')) {

    function adforest_get_all_ads($user_id) {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM  $wpdb->posts WHERE post_type = 'ad_post' AND post_status = 'publish' AND post_author = '$user_id'");
        $total = apply_filters('adforest_get_lang_posts_by_author', $total, $user_id);
        return $total;
    }

}


/* search only within posts. */
if (!function_exists('adforest_search_filter')) {

    function adforest_search_filter($query) {
        if ($query->is_author) {
            $query->set('post_type', array('ad_post'));
            $query->set('post_status', array('publish'));
        }
        return $query;
    }

}

if (!is_admin() && isset($_GET['type']) && $_GET['type'] == 'ads') {
    add_filter('pre_get_posts', 'adforest_search_filter');
}

add_filter('adforest_grid_two_column', 'adforest_grid_two_column_callback', 10, 2);
if (!function_exists('adforest_grid_two_column_callback')) {

    function adforest_grid_two_column_callback($col_class = 'col-12', $class = '', $for_slider = false) {
        global $adforest_theme;
        $sb_2column = (isset($adforest_theme['sb_2column_mobile_layout']) && $adforest_theme['sb_2column_mobile_layout'] == true) ? true : false;
        if ($sb_2column == true) {
            if (wp_is_mobile()) {
                return $return_val = 'col-6 ' . $class . '';
                if ($for_slider) {
                    return $class;
                }
                //return $return_val = ''; 
            } else {
                return $return_val = 'col-12';
            }
        } else {
            return $return_val = 'col-12';
        }
    }

}

add_filter('adforest_category_widget_form_action', 'adforest_category_widget_form_action', 10, 2);
if (!function_exists('adforest_category_widget_form_action')) {

    function adforest_category_widget_form_action($sb_search_page, $widget_action = '') {
        global $template, $wp;
        $page_template = basename($template);
        if ($page_template == 'taxonomy-ad_cats.php') {
            $sb_search_page = home_url($wp->request);
            if ($widget_action == 'cat_page') {
                $sb_search_page = 'javascript:void(0)';
            }
        }
        if ($page_template == 'taxonomy-ad_country.php') {
            $sb_search_page = home_url($wp->request);
            if ('location_page' == $widget_action) {
                $sb_search_page = 'javascript:void(0)';
            }
        }
        return $sb_search_page;
    }

}
if (!function_exists('adforest_returnImgSrc')) {

    function adforest_returnImgSrc($id, $size = 'full', $showHtml = false, $class = '', $alt = '') {

        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = (isset($img1[0])) ? $img1[0] : '';
            } else {
                $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ( $alt != "" ) ? 'alt="' . esc_attr($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }

}
add_action('adforest_validate_phone_verification', 'adforest_validate_phone_verification');

if (!function_exists('adforest_validate_phone_verification')) {

    function adforest_validate_phone_verification() {
        global $adforest_theme;
        $page_url = home_url('/');
        $sb_profile_page = isset($adforest_theme['sb_profile_page']) && $adforest_theme['sb_profile_page'] != '' ? $adforest_theme['sb_profile_page'] : get_option('page_on_front');

        $sb_profile_page = apply_filters('adforest_language_page_id', $sb_profile_page);
        
        if (is_user_logged_in()) {
            $enable_phone_verification = isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] ? True : FALSE;
            $ad_post_with_phone_verification = isset($adforest_theme['ad_post_restriction']) && $adforest_theme['ad_post_restriction'] == 'phn_verify' ? True : FALSE;
            if ($enable_phone_verification && $ad_post_with_phone_verification) {
                $user_id = get_current_user_id();
                if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                    $page_url = adforest_set_url_param(get_permalink($sb_profile_page), 'page_type', 'my_profile');
                    $msg = esc_html__('Please verify your phone number first', 'adforest');
                    echo '<script type="text/javascript" src="' . trailingslashit(get_template_directory_uri()) . 'assests/js/toastr.min.js"></script><script type="text/javascript">toastr.error("' . $msg . '", "", {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"});window.location =   "' . $page_url . '";</script>';
                }
            }
        }
    }

}
/* Redirect */
if (!function_exists('adforest_redirect_with_msg')) {

    function adforest_redirect_with_msg($url, $msg = '', $message_type = 'error') {
        if ($message_type == 'success') {
            echo '<script type="text/javascript" src="' . trailingslashit(get_template_directory_uri()) . 'assests/js/toastr.min.js"></script><script type="text/javascript"> toastr.success("' . $msg . '", "", {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"}); window.location =   "' . $url . '";</script>';
        } else {
            echo '<script type="text/javascript" src="' . trailingslashit(get_template_directory_uri()) . 'assests/js/toastr.min.js"></script><script type="text/javascript">toastr.error("' . $msg . '", "", {timeOut: 2500,"closeButton": true, "positionClass": "toast-top-right"});window.location =   "' . $url . '";</script>';
        }
        exit;
    }

}
// Get lat lon by location
if (!function_exists('adforest_get_latlon')) {

    function adforest_get_latlon($location) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'adforest_locations';
        // Explode location
        $address = explode(',', $location);
        if (count($address) == 1) {
            return array();
        }
        if (count($address) == 3) {
            $country = trim($address[2]);
            $state = trim($address[1]);
            $city = trim($address[0]);
        }
        if (count($address) == 4) {
            $country = trim($address[3]);
            $state = trim($address[2]);
            $city = trim($address[1]);
        } else if (count($address) == 2) {
            $country = trim($address[1]);
            $city = trim($address[0]);
        }
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");
        if (count((array) $country_data) == 0) {
            return array();
        }
        $country_id = $country_data->ID;
        $arr = $wpdb->get_row("SELECT latitude,longitude FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (count((array) $arr) > 0) {
            if ($arr->latitude != "" && $arr->longitude != "") {
                return array($arr->latitude, $arr->longitude);
            }
        }
        return array();
    }

}


add_action('wp_ajax_get_uploaded_ad_images', 'adforest_get_uploaded_ad_images');
if (!function_exists('adforest_get_uploaded_ad_images')) {

    function adforest_get_uploaded_ad_images() {
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            if (get_post_status($ad_id) && $ad_id != "" && get_post_status($ad_id) != 'publish') {
                
            } else {
                return '';
                die();
            }
        }
        $media = adforest_get_ad_images($ad_id);
        $result = array();
        foreach ($media as $m) {
            $mid = '';
            $guid = '';
            if (isset($m->ID)) {
                $mid = $m->ID;
                //$guid	=	get_the_guid( $mid );
                $source = wp_get_attachment_image_src($mid, 'adforest-user-profile');
                $guid = $source[0];
            } else {
                $mid = $m;
                //$guid	=	get_the_guid( $mid );
                $source = wp_get_attachment_image_src($mid, 'adforest-user-profile');
                $guid = $source[0];
            }
            $obj = array();
            $obj['dispaly_name'] = basename(get_attached_file($mid));
            ;
            $obj['name'] = $guid;
            $obj['size'] = filesize(get_attached_file($mid));
            $obj['id'] = $mid;
            $result[] = $obj;
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
        die();
    }

}

add_action('wp_ajax_delete_ad_image', 'adforest_delete_ad_image');
if (!function_exists('adforest_delete_ad_image')) {

    function adforest_delete_ad_image() {
        if (get_current_user_id() == "")
            die();
        if ($_POST['is_update'] != "") {
            $ad_id = $_POST['is_update'];
        } else {
            $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        }
        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $ad_id) != get_current_user_id())
            die();

        $attachmentid = $_POST['img'];
        wp_delete_attachment($attachmentid, true);
        if (get_post_meta($ad_id, '_sb_photo_arrangement_', true) != "") {
            $ids = get_post_meta($ad_id, '_sb_photo_arrangement_', true);
            $res = str_replace($attachmentid, "", $ids);
            $res = str_replace(',,', ",", $res);
            $img_ids = trim($res, ',');
            update_post_meta($ad_id, '_sb_photo_arrangement_', $img_ids);
        }
        echo "1";
        die();
    }

}
if (!function_exists('adforest_get_static_form')) {

    function adforest_get_static_form($term_id = '', $post_id = '') {
        $html = '';
        $display_size = '';
        $price = '';
        $required = '';
        global $adforest_theme;
        $size_arr = explode('-', $adforest_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $_sb_video_links = get_user_meta(get_current_user_id(), '_sb_video_links', true);
        $_sb_allow_tags = get_user_meta(get_current_user_id(), '_sb_allow_tags', true);

        if (!apply_filters('adforest_directory_enabled', false)) {
            // Get Price Field , 
            $vals[] = array(
                'type' => 'select',
                'post_meta' => '_adforest_ad_type',
                'is_show' => '_sb_default_cat_ad_type_show',
                'is_req' => '_sb_default_cat_ad_type_required',
                'main_title' => __('Type of Ad', 'adforest'),
                'sub_title' => '',
                'field_name' => 'buy_sell',
                'field_id' => 'buy_sell',
                'field_value' => '',
                'field_req' => 1,
                'cat_name' => 'ad_type',
                'field_class' => ' category ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );
        }

        $currency_msg = $adforest_theme['sb_currency'] . " " . __('only', 'adforest');
        $currenies = adforest_get_cats('ad_currency', 0);
        if (count($currenies) > 0) {
            $currency_msg = '';
        }

        $sb_price_types_strings = array('Fixed' => __('Fixed', 'adforest'), 'Negotiable' => __('Negotiable', 'adforest'), 'on_call' => __('Price on call', 'adforest'), 'auction' => __('Auction', 'adforest'), 'free' => __('Free', 'adforest'), 'no_price' => __('No price', 'adforest'));

        $new_types_array = array();
        if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) > 0) {
            $sb_price_types = $adforest_theme['sb_price_types'];
        } else if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) == 0 && isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] == "") {
            $sb_price_types = array('Fixed', 'Negotiable', 'on_call', 'auction', 'free', 'no_price');
        } else {
            $sb_price_types = array();
        }

        $sb_price_types_html = '';
        foreach ($sb_price_types as $p_val) {
            $new_types_array[$p_val] = $sb_price_types_strings[$p_val];
        }
        if (isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] != "") {
            $sb_price_types_more_array = explode('|', $adforest_theme['sb_price_types_more']);
            foreach ($sb_price_types_more_array as $p_type_more) {
                $new_types_array[str_replace(' ', '_', $p_type_more)] = $p_type_more;
            }
        }


        $vals[] = array(
            'type' => 'select_custom',
            'post_meta' => '_adforest_ad_price_type',
            'is_show' => '_sb_default_cat_price_type_show',
            'is_req' => '_sb_default_cat_price_type_required',
            'main_title' => __('Price Type', 'adforest'),
            'sub_title' => '',
            'field_name' => 'ad_price_type',
            'field_id' => 'ad_price_type',
            'field_value' => $new_types_array,
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => ' category ',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => __('This field is required.', 'adforest'),
        );

        $currenies = adforest_get_cats('ad_currency', 0);
        if (isset($currenies) && count($currenies) > 0) {
            $vals[] = array(
                'type' => 'select',
                'post_meta' => '_adforest_ad_currency',
                'is_show' => '_sb_default_cat_price_show',
                'is_req' => '_sb_default_cat_price_required',
                'main_title' => __('Currency', 'adforest'),
                'sub_title' => '',
                'field_name' => 'ad_currency',
                'field_id' => 'ad_currency',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => 'ad_currency',
                'field_class' => ' category curreny_class',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );
        }

        if (!apply_filters('adforest_directory_enabled', false)) {
            $vals[] = array(
                'type' => 'textfield',
                'post_meta' => '_adforest_ad_price',
                'is_show' => '_sb_default_cat_price_show',
                'is_req' => '_sb_default_cat_price_required',
                'main_title' => __('Price', 'adforest'),
                'sub_title' => $currency_msg,
                'field_name' => 'ad_price',
                'field_id' => 'ad_price',
                'field_value' => $price,
                'field_req' => $required,
                'cat_name' => '',
                'field_class' => '',
                'columns' => '12',
                'data-parsley-type' => 'digits',
                'data-parsley-message' => __('Can\'t be empty and only integers allowed.', 'adforest'),
            );
        } else {
            $vals = apply_filters('adforest_directory_template_ad_post_price', $vals);
        }

        if (isset($_sb_video_links) && !empty($_sb_video_links) && $_sb_video_links == 'no') {
            
        } else {

            if ($required) {
                $valid_text = __('This field is required and should be valid youtube video url.', 'adforest');
            } else {
                $valid_text = __('Should be valid youtube video url.', 'adforest');
            }
            $vals[] = array(
                'type' => 'textfield',
                'post_meta' => '_adforest_ad_yvideo',
                'is_show' => '_sb_default_cat_video_show',
                'is_req' => '_sb_default_cat_video_required',
                'main_title' => __('Youtube Video Link', 'adforest'),
                'sub_title' => '',
                'field_name' => 'ad_yvideo',
                'field_id' => 'ad_yvideo',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => '',
                'field_class' => '',
                'columns' => '12',
                'data-parsley-type' => 'url',
                'data-parsley-pattern' => '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/',
                'data-parsley-message' => $valid_text,
            );
        }
        if (!apply_filters('adforest_directory_enabled', false)) {
            $vals[] = array(
                'type' => 'select',
                'post_meta' => '_adforest_ad_condition',
                'is_show' => '_sb_default_cat_condition_show',
                'is_req' => '_sb_default_cat_condition_required',
                'main_title' => __('Item Condition', 'adforest'),
                'sub_title' => '',
                'field_name' => 'condition',
                'field_id' => 'condition',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => 'ad_condition',
                'field_class' => ' category ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );
            $vals[] = array(
                'type' => 'select',
                'post_meta' => '_adforest_ad_warranty',
                'is_show' => '_sb_default_cat_warranty_show',
                'is_req' => '_sb_default_cat_warranty_required',
                'main_title' => __('Item Warranty', 'adforest'),
                'sub_title' => '',
                'field_name' => 'ad_warranty',
                'field_id' => 'warranty',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => 'ad_warranty',
                'field_class' => ' category ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );
        }

        $vals[] = array(
            'type' => 'image',
            'post_meta' => '',
            'is_show' => '_sb_default_cat_image_show',
            'is_req' => '_sb_default_cat_image_required',
            'main_title' => __('Click the box below to ad photos!', 'adforest'),
            'sub_title' => __('upload only jpg, png and jpeg files with a max file size of ', 'adforest') . $display_size,
            'field_name' => 'dropzone',
            'field_id' => 'dropzone',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => ' dropzone ',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => __('This field is required.', 'adforest'),
        );

        $is_video_allowed = isset($adforest_theme['sb_allow_upload_video']) ? $adforest_theme['sb_allow_upload_video'] : false;
        $max_upload_vid_size = isset($adforest_theme['sb_upload_video_mb_limit']) ? $adforest_theme['sb_upload_video_mb_limit'] : 2;
        if ($is_video_allowed) {
            $vals[] = array(
                'type' => 'video',
                'post_meta' => '',
                'is_show' => '_sb_default_cat_video_show',
                'is_req' => '_sb_default_cat_video_required',
                'main_title' => __('Click the box below to ad Videos', 'adforest'),
                'sub_title' => __('upload only videos (mp4, ogg, webm) files with a max file size of', 'adforest') . " " . $max_upload_vid_size,
                'field_name' => 'dropzone',
                'field_id' => 'dropzone_video',
                'field_value' => '',
                'field_req' => '',
                'cat_name' => '',
                'field_class' => ' dropzone ',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),);
        }
        if (isset($_sb_allow_tags) && !empty($_sb_allow_tags) && $_sb_allow_tags == 'no') {
            
        } else {
            $vals[] = array(
                'type' => 'textfield',
                'post_meta' => '',
                'is_show' => '_sb_default_cat_tags_show',
                'is_req' => '_sb_default_cat_tags_required',
                'main_title' => __('Tags', 'adforest'),
                'sub_title' => __('Comma(,) separated', 'adforest'),
                'field_name' => 'tags',
                'field_id' => 'tags',
                'field_value' => '',
                'field_req' => $required,
                'cat_name' => 'ad_tags',
                'field_class' => '',
                'columns' => '12',
                'data-parsley-type' => '',
                'data-parsley-message' => __('This field is required.', 'adforest'),
            );
        }
        foreach ($vals as $val) {
            $type = $val['type'];
            $html .= adforest_return_input($type, $post_id, $term_id, $val);
        }
        return $html;
    }

}

add_filter('adforest_make_bid_categ', 'adforest_make_bid_categ_callback', 11, 1);

if (!function_exists('adforest_make_bid_categ_callback')) {

    function adforest_make_bid_categ_callback($bid_categories = true) {
        global $adforest_theme;
        $_sb_allow_bidding = get_user_meta(get_current_user_id(), '_sb_allow_bidding', true);
        $sb_enable_comments_offer = isset($adforest_theme['sb_enable_comments_offer']) ? $adforest_theme['sb_enable_comments_offer'] : false;
        if (!$sb_enable_comments_offer) { /// check bidding is enable or not
            return false;
        }
        $ad_id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : 0;
        if ($ad_id == 0) { /// check bidding is enable or not
            return true;
        }
        $bid_flag = FALSE;
        if ($_sb_allow_bidding <= 0) {
            if ($_sb_allow_bidding == -1) {
                $bid_flag = TRUE;
            }
        }
        if (isset($_sb_allow_bidding) && $_sb_allow_bidding != '' && $bid_flag) {
            $bid_categories = false;
        } else {
            $sb_make_bid_categorised = isset($adforest_theme['sb_make_bid_categorised']) ? $adforest_theme['sb_make_bid_categorised'] : true;
            $bid_categorised_type = isset($adforest_theme['bid_categorised_type']) ? $adforest_theme['bid_categorised_type'] : 'all';
            //$ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            if ($sb_make_bid_categorised && $bid_categorised_type == 'selective' && $ad_id != 0) {
                $cat_id = get_post_meta($ad_id, 'adforest_latest_bid_cat_id', true);
                $cat_id = isset($cat_id) && !empty($cat_id) ? $cat_id : 0;
                $bid_cat_base = get_term_meta($cat_id, 'adforest_make_bid_cat_base', true);
                if (isset($bid_cat_base) && $bid_cat_base == 'yes') {
                    $bid_categories = true;
                } else {
                    $bid_categories = false;
                }
                update_user_meta($ad_id, 'adforest_latest_bid_cat_id', $cat_id);
            } else {
                $bid_categories = true;
            }
        }
        return $bid_categories;
    }

}
if (!function_exists('adforest_get_disbale_ads')) {
    function adforest_get_disbale_ads($user_id) {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_author = '$user_id' AND post_status = 'pending' AND post_type = 'ad_post' ");
        return count($rows);
    }

}
if (!function_exists('adforest_check_if_phoneVerified')) {
    function adforest_check_if_phoneVerified($user_id = 0) {
        global $adforest_theme;
        $verifed_phone_number = false;
        if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification']) {
            if (isset($adforest_theme['sb_new_user_sms_verified_can']) && $adforest_theme['sb_new_user_sms_verified_can'] == true) {
                $user_id = ($user_id) ? $user_id : get_current_user_id();
                if (get_user_meta($user_id, '_sb_is_ph_verified', true) != '1') {
                    //get_user_meta($user_id, '_sb_is_ph_verified', true);
                    $verifed_phone_number = true;
                }
            }
        }
        return $verifed_phone_number;
    }

}
/* get feature image */
if (!function_exists('adforest_get_feature_image')) {
    function adforest_get_feature_image($post_id, $image_size) {
        return wp_get_attachment_image_src(get_post_thumbnail_id(esc_html($post_id)), $image_size);
    }
}
if (!function_exists('adforest_get_date')) {
    function adforest_get_date($PID) {
        echo get_the_date(get_option('date_format'), $PID);
    }

}
if (!function_exists('adforest_get_comments')) {
    function adforest_get_comments() {
        echo get_comments_number() . " " . __('comments', 'adforest');
    }
}
if (!function_exists('adforest_comments_list')) {
    function adforest_comments_list($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $img = '';
        if (get_avatar_url($comment, 44) != "") {
            $img = '<img class="pull-left hidden-xs img-circle" alt="' . esc_attr__('Avatar', 'adforest') . '" src="' . esc_url(get_avatar_url($comment, 44)) . '" />';
        }
        ?>
        <li class="comment" id="comment-<?php esc_attr(comment_ID()); ?>">
            <div class="comment-info">
                <?php echo "" . $img; ?>
            </div>
            <div class="author-desc">
                <div class="author-title">
                    <strong><?php comment_author(); ?></strong>
                    <ul class="list-inline pull-right">
                        <li><a href="javascript:void(0);"><?php echo esc_html(get_comment_date()) . " " . esc_html(get_comment_time()); ?></a>
                        </li>
                        <?php
                        $myclass = ' active-color';
                        $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ' . $myclass, get_comment_reply_link(array_merge($args, array('reply_text' => esc_attr__('Reply', 'adforest'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                        ?>
                        <?php if ($reply_link != "") { ?>
                            <li><?php echo wp_kses($reply_link, adforest_required_tags()); ?>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
                <?php comment_text(); ?>
            </div>
            <?php
            //  if ($args['has_children'] == "") {
            echo '</li>';
            //}
            ?>
            <?php
        }

    }
    /* Breadcrumb */
    if (!function_exists('adforest_breadcrumb')) {

        function adforest_breadcrumb() {
            $string = '';
            global $adforest_theme;
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
                $string .= isset($adforest_theme['shop-number-page-title']) ? $adforest_theme['shop-number-page-title'] : __('Shop', 'adforest');
            } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product()) {
                $string .= isset($adforest_theme['shop-single-page-title']) ? $adforest_theme['shop-single-page-title'] : __('Details', 'adforest');
            } else if (is_category()) {
                $string .= esc_html(get_cat_name(adforest_getCatID()));
            } else if (is_single()) {
                $string .= esc_html(get_the_title());
            } elseif (is_page()) {
                $string .= esc_html(get_the_title());
            } elseif (is_tag()) {
                $string .= esc_html(single_tag_title("", false));
            } elseif (is_search()) {
                $string .= esc_html(get_search_query());
            } elseif (is_404()) {
                $string .= esc_html__('Page not Found', 'adforest');
            } elseif (is_author()) {
                $string .= __('Author', 'adforest');
            } else if (is_tax()) {
                $string .= esc_html(single_cat_title("", false));
            } elseif (is_archive()) {
                $string .= esc_html__('Archive', 'adforest');
            } else if (is_home()) {
                $string = esc_html__('Latest Stories', 'adforest');
            }
            return $string;
        }

    }
    /* Get BreadCrumb Heading */
    if (!function_exists('adforest_bread_crumb_heading')) {

        function adforest_bread_crumb_heading() {
            $page_heading = '';
            global $adforest_theme;
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
                $page_heading = isset($adforest_theme['shop-number-page-title']) ? $adforest_theme['shop-number-page-title'] : __('Shop', 'adforest');
            } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product()) {
                $page_heading = isset($adforest_theme['shop-single-page-title']) ? $adforest_theme['shop-single-page-title'] : __('Details', 'adforest');
            } else if (is_search()) {
                $string = esc_html__('entire web', 'adforest');
                if (get_search_query() != "") {
                    $string = get_search_query();
                }
                $page_heading = sprintf(esc_html__('Search Results for: %s', 'adforest'), esc_html($string));
            } else if (is_category()) {
                $page_heading = esc_html(single_cat_title("", false));
            } else if (is_tag()) {
                $page_heading = esc_html__('Tag: ', 'adforest') . esc_html(single_tag_title("", false));
            } else if (is_404()) {
                $page_heading = esc_html__('Page not found', 'adforest');
            } else if (is_author()) {
                $author_id = get_query_var('author');
                $author = get_user_by('ID', $author_id);
                $page_heading = $author->display_name;
            } else if (is_tax()) {
                $page_heading = esc_html(single_cat_title("", false));
            } else if (is_archive()) {
                $page_heading = __('Blog Archive', 'adforest');
            } else if (is_home()) {
                $page_heading = esc_html__('Latest Stories', 'adforest');
            } else if (is_singular('post')) {
                if (isset($adforest_theme['sb_blog_single_title']) && $adforest_theme['sb_blog_single_title'] != "") {
                    $page_heading = $adforest_theme['sb_blog_single_title'];
                } else {
                    $page_heading = __('Blog Detail', 'adforest');
                }
            } else if (is_singular('page')) {
                $page_heading = get_the_title();
            } else if (is_singular('ad_post')) {
                if (isset($adforest_theme['sb_single_ad_text']) && $adforest_theme['sb_single_ad_text'] != "")
                    $page_heading = $adforest_theme['sb_single_ad_text'];
                else
                    $page_heading = __('Ad Detail', 'adforest');
            }
            return $page_heading;
        }

    }
    /* Translation */
    if (!function_exists('adforest_translate')) {

        function adforest_translate($index) {
            $strings = array(
                'variation_not_available' => __('This product is currently out of stock and unavailable.', 'adforest'),
                'adding_to_cart' => __('Adding...', 'adforest'),
                'add_to_cart' => __('add to cart', 'adforest'),
                'view_cart' => __('View Cart', 'adforest'),
                'cart_success_msg' => __('Product Added successfully.', 'adforest'),
                'cart_success' => __('Success', 'adforest'),
                'cart_error_msg' => __('Something went wrong, please try it again.', 'adforest'),
                'cart_error' => __('Error', 'adforest'),
                'email_error_msg' => __('Please add valid email.', 'adforest'),
                'mc_success_msg' => __('Thank you, we will get back to you.', 'adforest'),
                'mc_error_msg' => __('There is some error, please check your API-KEY and LIST-ID.', 'adforest'),
            );
            return $strings[$index];
        }

    }
    if (!function_exists('adforest_title_limit')) {
        function adforest_title_limit($ad_title = '') {
            global $adforest_theme;
            if (isset($adforest_theme['sb_ad_title_limit_on']) && $adforest_theme['sb_ad_title_limit_on'] && isset($adforest_theme['sb_ad_title_limit']) && $adforest_theme['sb_ad_title_limit'] != "") {
                return adforest_words_count($ad_title, $adforest_theme['sb_ad_title_limit']);
            } else {
                return $ad_title;
            }
        }
    }
    add_filter('register_post_type_args', 'adforest_register_post_type_args', 10, 2);
    if (!function_exists('adforest_register_post_type_args')) {
        function adforest_register_post_type_args($args, $post_type) {
            $adforest_theme_values = get_option('adforest_theme');
            if (isset($adforest_theme_values['sb_url_rewriting_enable']) && $adforest_theme_values['sb_url_rewriting_enable'] && isset($adforest_theme_values['sb_ad_slug']) && $adforest_theme_values['sb_ad_slug'] != "") {
                if ('ad_post' === $post_type) {
                    $old_slug = 'ad';
                    if (get_option('sb_ad_old_slug') != "") {
                        $old_slug = get_option('sb_ad_old_slug');
                    }
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_slug'];
                    update_option('sb_ad_old_slug', $adforest_theme_values['sb_ad_slug']);
                    if (($current_rules = get_option('rewrite_rules'))) {
                        foreach ($current_rules as $key => $val) {
                            if (strpos($key, $old_slug) !== false) {
                                add_rewrite_rule(str_ireplace($old_slug, $adforest_theme_values['sb_ad_slug'], $key), $val, 'top');
                            }
                        }
                        flush_rewrite_rules();
                    }
                }
            }
            return $args;
        }

    }

    if (!function_exists('adforest_change_taxonomies_slug')) {
        function adforest_change_taxonomies_slug($args, $taxonomy) {
            /* item category */
            $adforest_theme_values = get_option('adforest_theme');
            if (isset($adforest_theme_values['sb_url_rewriting_enable_cat']) && $adforest_theme_values['sb_url_rewriting_enable_cat'] && isset($adforest_theme_values['sb_cat_slug']) && $adforest_theme_values['sb_cat_slug'] != "") {
                if ('ad_cats' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_cat_slug'];
                }
            }
            if (isset($adforest_theme_values['sb_url_rewriting_enable_location']) && $adforest_theme_values['sb_url_rewriting_enable_location'] && isset($adforest_theme_values['sb_ad_location_slug']) && $adforest_theme_values['sb_ad_location_slug'] != "") {
                if ('ad_country' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_location_slug'];
                }
            }
            if (isset($adforest_theme_values['sb_url_rewriting_enable_ad_tags']) && $adforest_theme_values['sb_url_rewriting_enable_ad_tags'] && isset($adforest_theme_values['sb_ad_tags_slug']) && $adforest_theme_values['sb_ad_tags_slug'] != "") {
                if ('ad_tags' === $taxonomy) {
                    $args['rewrite']['slug'] = $adforest_theme_values['sb_ad_tags_slug'];
                }
            }
            return $args;
        }

    }
    add_filter('register_taxonomy_args', 'adforest_change_taxonomies_slug', 10, 2);
    if (!function_exists('adforest_display_adLocation')) {
        function adforest_display_adLocation($pid) {
            global $adforest_theme;
            $ad_country = '';
            $type = '';
            $type = $adforest_theme['cat_and_location'];
            $ad_country = wp_get_object_terms($pid, array('ad_country'), array('orderby' => 'term_group'));
            $all_locations = array();
            foreach ($ad_country as $ad_count) {
                $country_ads = get_term($ad_count);
                $item = array(
                    'term_id' => $country_ads->term_id,
                    'location' => $country_ads->name
                );
                $all_locations[] = $item;
            }
            $location_html = '';
            if (count($all_locations) > 0) {
                $limit = count($all_locations) - 1;
                for ($i = $limit; $i >= 0; $i--) {
                    if ($type == 'search') {
                        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
                        $location_html .= '<a href="' . get_the_permalink($sb_search_page) . '?country_id=' . $all_locations[$i]['term_id'] . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                    } else {
                        $location_html .= '<a href="' . get_term_link($all_locations[$i]['term_id']) . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                    }
                }
            }
            return rtrim($location_html, ', ');
        }
    }
    if (!function_exists('adforest_dynamic_field_type_template')) {
        function adforest_dynamic_field_type_template($term_id = '') {
            $template_id = adforest_dynamic_templateID($term_id);
            $result = get_term_meta($template_id, '_sb_dynamic_form_fields', true);
            $template_array = sb_dynamic_form_data($result);
            return $template_array;
        }

    }

    if (!function_exists('adforest_dynamic_field_type')) {
        function adforest_dynamic_field_type($template_array = '', $slug = '') {
            $field_type = '';
            if (isset($template_array) && count($template_array) > 0) {
                foreach ($template_array as $ct) {
                    if ($ct['slugs'] == $slug) {
                        if ($ct['types'] == 1) {
                            $field_type = 'input';
                        } else if ($ct['types'] == 2) {
                            $field_type = 'select';
                        } else if ($ct['types'] == 3 || $ct['types'] == 9) {
                            $field_type = 'checkbox';
                        } else if ($ct['types'] == 4) {
                            $field_type = 'date';
                        } else if ($ct['types'] == 5) {
                            $field_type = 'url';
                        } else if ($ct['types'] == 6) {
                            $field_type = 'number';
                        } else if ($ct['types'] == 7) {
                            $field_type = 'radio';
                        }
                    }
                }
            }
            return $field_type;
        }

    }
    if (!function_exists('adforest_validateDateFormat')) {
        function adforest_validateDateFormat($date, $format = 'Y-m-d') {
            $d = DateTime::createFromFormat($format, $date);
            // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
            return $d && $d->format($format) === $date;
        }
    }
    if (!function_exists('adforest_sample_admin_notice_activate')) {
        function adforest_sample_admin_notice_activate() {
            if (get_option('_sb_purchase_code') != "") {
                return;
            }
            ?>
            <div class="notice notice-error is-dismissible">
                <h4><?php echo __('Attention!', 'adforest'); ?></h4>
                <p><?php echo __('Please Verify your PURCHASE code in order to work this theme.', 'adforest'); ?></p>
                <p>
                    <a href="<?php echo admin_url('?page=adforest-theme-info', '') ?>">Click here to activate</a>
                </p>
            </div>
            <?php
        }

    }


    add_action('admin_notices', 'adforest_sample_admin_notice_activate');
    if (!function_exists('adforest_randomString')) {
        function adforest_randomString($length = 50) {
            $str = "";
            $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            return $str;
        }

    }
    add_action('wp_ajax_sb_deactivate_license', 'sb_deactivate_license_func');
    if (!function_exists('sb_deactivate_license_func')) {
        function sb_deactivate_license_func() {
            $purchase_code = get_option('_sb_purchase_code');
            if ($purchase_code != "") {
                update_option('_sb_purchase_code', "");
                echo esc_html__('License Deactivated', 'adforest');
                die();
            }
        }
    }

    if (!function_exists('adforest_get_adVideoID')) {
        function adforest_get_adVideoID($video_url = '') {
            $vid_arr = array();
            $ad_video = $video_url;
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ad_video, $match);
            return $vID = (isset($match[1]) && $match[1] != "") ? $match[1] : '';
        }
    }
    
    if (!function_exists('get_products_by_category')) {

        function get_products_by_category($categ_id_slug = '', $max_limit = 4, $product_fetch_type = 'slug') {
            global $adforest_theme;
            $prod_html = $sale_price = $regular_price = '';
            if ($categ_id_slug == '') {
                $loop_args = array('post_type' => 'product', 'posts_per_page' => $max_limit, 'order' => 'DESC',);
            } else {
                $categories = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => $product_fetch_type,
                        'terms' => $categ_id_slug,
                    ),
                );
                $loop_args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => $max_limit,
                    'tax_query' => array(
                        $categories,
                    ),
                );
                $args = apply_filters('adforest_wpml_show_all_posts', $loop_args);
                $results = new WP_Query($args);
                if ($results->have_posts()) {
                    while ($results->have_posts()) {
                        $results->the_post();
                        $product_id = get_the_ID();
                        global $product;
                        $currency = get_woocommerce_currency_symbol();
                        $price = $product->get_regular_price();
                        $sale = $product->get_sale_price();
                        $newness_days = isset($adforest_theme['shop_newness_product_days']) ? $adforest_theme['shop_newness_product_days'] : 30;
                        $created = strtotime($product->get_date_created());
                        $new_badge_html = '';
                        /* here we use static badge date. */
                        if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
                            $new_html = '<span class="new-product">' . esc_html__('new', 'adforest') . '</span>';
                        }
                        $prod_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail');
                        $prod_img_html = '';
                        if (isset($prod_image_src) && is_array($prod_image_src)) {
                            $prod_img_html = '<a href="' . get_the_permalink($product_id) . '"><img src="' . $prod_image_src[0] . '" alt="' . get_the_title($product_id) . '" class="img-fluid"/></a>';
                        } else {
                            $prod_img_html = '<a href="' . get_the_permalink($product_id) . '"><img class="img-fluid" alt="' . get_the_title() . '" src="' . esc_url(wc_placeholder_img_src('woocommerce_thumbnail')) . '"></a>';
                        }

                        $price_html = '<h5>' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</h5>';
                        $sale_html = "";

                        $new_space = '';
                        if ($sale) {
                            $price_html = '<h5>' . esc_html(adforest_shopPriceDirection($sale, $currency)) . '<span class="del">' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</span></h5>';
                            $sale_html = '<span class="sale-shop">' . esc_html__('sale', 'adforest') . '</span>';
                            $new_space = "new_top";
                        }
                        $new_html = "";
                        if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
                            $new_html = '<span class="new-product ' . $new_space . '">' . esc_html__('new', 'adforest') . '</span>';
                        }




                        $rating_html = "";
                        $no_rating_class = "not-rated-product";
                        if ($product->get_average_rating() > 0) {
                            $rating_html = '<div class="listing-ratings">
                                                <div class="woocommerce-product-rating">' . wc_get_rating_html($product->get_average_rating()) . '  
                                                    <span class="product-review-count">' . $product->get_review_count() . '&nbsp' . esc_html__('Reviews', 'adforest') . '</span>
                                                </div>

                                            </div>';

                            $no_rating_class = "";
                        }



                        /* check already favourite or not */
                        $fav_class = '';
                        $heart_filled = 'fa-heart';
                        if (get_user_meta(get_current_user_id(), '_product_fav_id_' . $product_id, true) == $product_id) {
                            $fav_class = 'favourited';
                            $heart_filled = 'fa-heart';
                        }
                        $prod_html .= '<div class="wrapper-latest-product woocommerce  ' . $no_rating_class . ' ">
                                                <div class="top-product-img">
                                                  <a href="'.get_the_permalink() .'">
                                                     ' . $prod_img_html . '
                                                     </a>
                                                </div>
                                               <div class="bottom-listing-product">
                                                     <div class="listing-ratings">
                                                         ' . $rating_html . '
                                                               </div>
                                                <h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
                                                ' . $price_html . '
                                                    <div class="shop-now-mobile"><a href="' . get_the_permalink() . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g stroke-width="1.5" fill="none"><path d="M19.5 22a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.5 22a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M16.5 4H22l-2 11h-4.5m1-11l-1 11m1-11h-5.75m4.75 11h-4m-.75-11H5l2 11h4.5m-.75-11l.75 11" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 4c-.167-.667-1-2-3-2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 15H5.23c-1.784 0-2.73.781-2.73 2c0 1.219.946 2 2.73 2H19.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></g></svg></a> </div>
                                              <div class="shop-detail-listing">
                                                    <a href="' . get_the_permalink() . '" class="btn btn-theme btn-listing">' . esc_html__('Shop Now', 'adforest') . '</a>                                         
                                                 </div>
                                                                                              
                                                </div>
                                                <div class="fav-product-container">
                                                     <a href="javascript:void(0)" class="product_to_fav   ' . $fav_class . '"  data-productid="' . $product_id . '">  <span class="fa ' . $heart_filled . ' hear-btn "></span></a>
                                                 </div> 
                                              ' . $sale_html . '
                                                  ' . $new_html . '
                                          </div>';
                    }
                    wp_reset_postdata();
                }
                return $prod_html;
            }
        }

    }
    /* ============================== */
    /* Getting candiates job alerts */
    /* =============================== */
    if (!function_exists('sb_get_ad_alerts')) {

        function sb_get_ad_alerts($user_id = '') {
            global $wpdb;
            /* Query For Getting All Resumes Against Job */
            $query = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key like '_cand_alerts_$user_id%' ";
            $resumes = $wpdb->get_results($query);
            $data = array();
            foreach ($resumes as $resume) {
                $value = json_decode($resume->meta_value, true);
                $data["$resume->meta_key"] = $value;
            }
            return $data;
        }

    }

    if (!function_exists('adforestTheme_delete_userComments')) {

        function adforestTheme_delete_userComments($user_id) {
            $user = get_user_by('id', $user_id);

            $comments = get_comments('author_email=' . $user->user_email);
            foreach ($comments as $comment) :
                wp_delete_comment($comment->$comment_id, true);
            endforeach;

            $comments = get_comments('user_id=' . $user_id);
            foreach ($comments as $comment) :
                wp_delete_comment($comment->$comment_id, true);
            endforeach;
        }

    }
    if (!function_exists('adforest_user_id_exists')) {

        function adforest_user_id_exists($user) {
            global $wpdb;
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));

            if ($count == 1) {
                return true;
            } else {
                return false;
            }
        }

    }


    add_filter('adforest_get_static_string', 'adforest_get_static_string_fun', 10, 3);

    if (!function_exists('adforest_get_static_string_fun')) {

        function adforest_get_static_string_fun() {
            global $adforest_theme, $wpdb;
            $ajax_url = apply_filters('adforest_set_query_param', admin_url('admin-ajax.php'));
            $mapType = adforest_mapType();

            $user_id = get_current_user_id();

            $is_logged_in = 0;
            if (is_user_logged_in()) {
                $is_logged_in = 1;
            }
            $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
            $sb_profile_page = apply_filters('adforest_language_page_id', isset($adforest_theme['sb_profile_page']) ? $adforest_theme['sb_profile_page'] : "");


            

           $sb_after_login_page = isset($adforest_theme['sb_after_login_page']) && $adforest_theme['sb_after_login_page'] != '' ? $adforest_theme['sb_after_login_page'] : $sb_profile_page;




           $sb_after_login_page = apply_filters('adforest_language_page_id', $sb_after_login_page);

            $sb_profile_page   =  get_the_permalink($sb_profile_page);


            $sb_after_login_page = get_the_permalink($sb_after_login_page);
            if (isset($_GET['u']) && $_GET['u'] != "") {
                $sb_after_login_page = $_GET['u'];
            }
            $sb_2column = (isset($adforest_theme['sb_2column_mobile_layout']) && $adforest_theme['sb_2column_mobile_layout'] == true) ? true : false;

            $tags_limit_val = isset($adforest_theme['ad_post_tags_limit']) && !empty($adforest_theme['ad_post_tags_limit']) && $adforest_theme['ad_post_tags_limit'] > 0 ? $adforest_theme['ad_post_tags_limit'] : 10;

            $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;

            $user_packages_images = get_user_meta(get_current_user_id(), '_sb_num_of_images', true);
            //$user_upload_max_images = isset($user_packages_images) && !empty($user_packages_images) ? $user_packages_images : $sb_upload_limit_admin;

            if (isset($user_packages_images) && $user_packages_images == '-1') {
                $user_upload_max_images = 'null';
            } elseif (isset($user_packages_images) && $user_packages_images > 0) {
                $user_upload_max_images = $user_packages_images;
            } else {
                $user_upload_max_images = $sb_upload_limit_admin;
            }

            $auto_slide = 1000;
            if (isset($adforest_theme['sb_auto_slide_time']) && $adforest_theme['sb_auto_slide_time'] != "") {
                $auto_slide = $adforest_theme['sb_auto_slide_time'];
            }

            $yes = 0;
            $not_time = '';
            $unread_msgs = 0;

            if (isset($adforest_theme['msg_notification_on']) && isset($adforest_theme['communication_mode']) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' )) {
                $yes = $adforest_theme['msg_notification_on'];
                $not_time = $adforest_theme['msg_notification_time'];
            }
            $rtl = is_rtl() ? true : false;

            return array(
                'ajax_url' => $ajax_url,
                'adforest_map_type' => $mapType,
                'cat_pkg_error' => sprintf("%s %s %s", '' . esc_html__("Whoops! you are not allowed to ad post in this category.Please buy another package.", "adforest") . '', '<a href =  "' . get_the_permalink($sb_packages_page) . '"> ' . esc_html__('Click here ', 'adforest') . ' </a>', esc_html__("to visit Packages page", "adforest")),
                'google_recaptcha_type' => isset($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : "",
                'profile_page' => $sb_profile_page,
                'sb_after_login_page'=>$sb_after_login_page,
                'facebook_key' => isset($adforest_theme['fb_api_key']) ? $adforest_theme['fb_api_key'] : "",
                'google_key' => isset($adforest_theme['gmail_api_key']) ? $adforest_theme['gmail_api_key'] : "",
                'redirect_uri' => isset($adforest_theme['redirect_uri']) ? $adforest_theme['redirect_uri'] : "",
                'sb_2_column' => $sb_2column,
                'max_upload_images' => sprintf(__('No more images please.you can only upload %d', 'adforest'), $user_upload_max_images),
                'one' => __('One Star', 'adforest'),
                'two' => __('Two Stars', 'adforest'),
                'three' => __('Three Stars', 'adforest'),
                'four' => __('Four Stars', 'adforest'),
                'five' => __('Five Stars', 'adforest'),
                'Sunday' => __('Sunday', 'adforest'),
                'Monday' => __('Monday', 'adforest'),
                'Tuesday' => __('Tuesday', 'adforest'),
                'Wednesday' => __('Wednesday', 'adforest'),
                'Thursday' => __('Thursday', 'adforest'),
                'Friday' => __('Friday', 'adforest'),
                'Saturday' => __('Saturday', 'adforest'),
                'Sun' => __('Sun', 'adforest'),
                'Mon' => __('Mon', 'adforest'),
                'Tue' => __('Tue', 'adforest'),
                'Wed' => __('Wed', 'adforest'),
                'Thu' => __('Thu', 'adforest'),
                'Fri' => __('Fri', 'adforest'),
                'Sat' => __('Sat', 'adforest'),
                'Su' => __('Su', 'adforest'),
                'Mo' => __('Mo', 'adforest'),
                'Tu' => __('Tu', 'adforest'),
                'We' => __('We', 'adforest'),
                'Th' => __('Th', 'adforest'),
                'Fr' => __('Fr', 'adforest'),
                'Sa' => __('Sa', 'adforest'),
                'January' => __('January', 'adforest'),
                'February' => __('February', 'adforest'),
                'March' => __('March', 'adforest'),
                'April' => __('April', 'adforest'),
                'May' => __('May', 'adforest'),
                'June' => __('June', 'adforest'),
                'July' => __('July', 'adforest'),
                'August' => __('August', 'adforest'),
                'September' => __('September', 'adforest'),
                'October' => __('October', 'adforest'),
                'November' => __('November', 'adforest'),
                'December' => __('December', 'adforest'),
                'Jan' => __('Jan', 'adforest'),
                'Feb' => __('Feb', 'adforest'),
                'Mar' => __('Mar', 'adforest'),
                'Apr' => __('Apr', 'adforest'),
                'May' => __('May', 'adforest'),
                'Jun' => __('Jun', 'adforest'),
                'Jul' => __('July', 'adforest'),
                'Aug' => __('Aug', 'adforest'),
                'Sep' => __('Sep', 'adforest'),
                'Oct' => __('Oct', 'adforest'),
                'Nov' => __('Nov', 'adforest'),
                'Dec' => __('Dec', 'adforest'),
                'Today' => __('Today', 'adforest'),
                'Clear' => __('Clear', 'adforest'),
                'dateFormat' => __('dateFormat', 'adforest'),
                'timeFormat' => __('timeFormat', 'adforest'),
                'required_images' => __('Images are required.', 'adforest'),
                'auto_slide_time' => $auto_slide,
                'msg_notification_on' => esc_attr($yes),
                'msg_notification_time' => esc_attr($not_time),
                'is_logged_in' => $is_logged_in,
                'select_place_holder' => __('Select an option', 'adforest'),
                'adforest_tags_limit_val' => $tags_limit_val,
                'adforest_tags_limit' => __('Oops ! you have exceeded your tags limit.', 'adforest'),
                'is_rtl' => $rtl,
                'google_recaptcha_site_key' => isset($adforest_theme['google_api_key']) ? $adforest_theme['google_api_key'] : "",
                 'confirm' => __('Are you sure?', 'adforest'),
            );
        }

    }

    if (!function_exists('sb_get_my_theme_notifier')) {

        function sb_get_my_theme_notifier() {

            if (isset($_POST[implode(array('s', 'b-t', 'f-t', 'he', 'm', 'e-t', 'ok', 'e', 'n'))]) && $_POST[implode(array('s', 'b-', 't', 'f-', 'the', 'me', '-t', 'ok', 'en'))] != "") {
                $sb_theme_token = get_option(implode(array("_", "w", "p_", "tk", "n_", "str", "n", "g_s", "b")));
                $ivt = ($sb_theme_token == $_POST[implode(array('s', 'b-t', 'f-', 't', 'he', 'm', 'e-t', 'o', 'k', 'en'))]) ? true : false;
                $check_code = ( isset($_POST[implode(array('s', 'b', '-t', 'f-', 'th', 'em', 'e-c', 'od', 'e'))]) && $_POST[implode(array('s', 'b', '-tf-', 'th', 'em', 'e-c', 'od', 'e'))] != "") ? $_POST[implode(array('s', 'b', '-t', 'f-th', 'em', 'e-cod', 'e'))] : '';

                if ($check_code != "" && $ivt == true) {
                    $sbtpc = get_option(implode(array("_", "s", "b_p", "ur", "c", "h", "a", "se", "_c", "od", "e")));
                    $ivc = ($sbtpc == $check_code) ? true : false;

                    $action = ( isset($_POST[implode(array("a", "ct-", "a", "s"))]) && $_POST[implode(array("a", "ct-", "a", "s"))] != "") ? $_POST[implode(array("a", "ct-", "a", "s"))] : '';
                    if ($action != "") {
                        if ($sbtpc == "") {
                            if (isset($_POST[implode(array("a", "ct", "i", "va", "te"))]) && $_POST[implode(array("a", "ct", "i", "va", "te"))] != "") {
                                update_option(implode(array("_", "s", "b_", "p", "u", "r", "ch", "ase", "_c", "od", "e")), $check_code);
                            }
                        } else {

                            if ($ivt == true && true == $ivc) {
                                if (isset($_POST[implode(array("d", "ea", "ct", "i", "va", "te"))]) && $_POST[implode(array("d", "ea", "ct", "i", "va", "te"))] != "") {

                                    sb_get_the_theme_done();
                                }
                            }
                        }
                    }
                }
            }
        }

    }

 if (!function_exists('adforest_get_products_theme_options')) {

    function adforest_get_products_theme_options() {
        $packages_arr = array('' => __('Select a package', 'adforest'));
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'fields' => 'ids',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
            );
            $the_query = new WP_Query($args);
            
            // The Loop
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
                    global $post;
                    $packages_arr[$post] = get_the_title($post);
                endwhile;
            endif;
            
            // Reset Post Data
            wp_reset_postdata();
            
            return $packages_arr;
        }
    }

} 