<?php 

if (!function_exists('adforest_VCImage')) {

    function adforest_VCImage($imgName = '') {
        $val = '';
        if ($imgName != "") {
            $path = esc_url(trailingslashit(get_template_directory_uri()) . 'vc_images/' . $imgName);
            $val = '<img src="' . esc_url($path) . '" style="width:100%" class="img-fluid"  alt="' . esc_attr__('image', 'adforest') . '"  />';
        }

        return $val;
    }

}
// For Section header
if (!function_exists('adforest_getHeader')) {



    function adforest_getHeader($sb_section_title, $sb_section_description, $style = 'classic', $view_all_btn = '' ,$sb_section_tagline  = '') {
        if ($style == 'classic') {
            $desc = '';
            if ($sb_section_description != '') {
                $desc = '<p class="heading-text">' . $sb_section_description . '</p>';
            }
            $main_title = adforest_color_text($sb_section_title);
            return '<div class="heading-panel"><div class="col-xs-12 col-md-12 col-sm-12 text-center"><h2>' . $main_title . '</h2> ' . $desc . '</div></div>';
        } else if ($style == 'regular') {
            $sb_section_title = adforest_color_text($sb_section_title);
            return '<div class="heading-panel"><div class="col-xs-12 col-md-12 col-sm-12"><h3 class="main-title text-left">' . ($sb_section_title) . '</h3></div></div>';
        } else if ($style == 'fancy') {
            $sb_section_title = adforest_color_text($sb_section_title);

            $btn_html = '';
            if (isset($view_all_btn) && !empty($view_all_btn)) {
                $btn_html = adforest_ThemeBtn($view_all_btn, "btn btn-theme", false);
            }
            return '<div class="col-xs-12 col-md-12 col-sm-12"><div class="prop-newset-heading"><h2> ' . ($sb_section_title) . '</h2>' . $btn_html . '</div></div>';
        }

        else if ($style == 'modern') {
            $sb_section_title = adforest_color_text($sb_section_title);
            $btn_html = '';
            if (isset($view_all_btn) && !empty($view_all_btn)) {
                $btn_html = adforest_ThemeBtn($view_all_btn, "btn btn-theme", false);
            }
            return '<div class="hading text-left"><h3> ' . ($sb_section_title) . '</h3><p> ' . $sb_section_description . '</p></div>';
        }

       else if ($style == 'new') {
            $sb_section_title = adforest_color_text($sb_section_title);
           
            return '<div class="sb-short-head center"><span>'.$sb_section_tagline.'</span><h2> ' . ($sb_section_title) . '</h2><p> ' . $sb_section_description . '</p></div>';
        }





    }
}

add_filter('adforest_admin_category_load_field', 'adforest_admin_category_load_field_callback', 10, 2);

function adforest_admin_category_load_field_callback($cat_field = array(), $term_group = 'Categories') {

    $group = __("Categories", "adforest");
    if ($term_group != 'Categories') {
        $group = $term_group;
    }

    $cat_field = array(
        "group" => $group,
        "type" => "dropdown",
        "heading" => __("Categories Load on frontend", 'adforest'),
        "param_name" => "cat_frontend_switch",
        "admin_label" => true,
        "value" => array(
            __('Default', 'adforest') => '',
            __('Ajax Based ( Load All )', 'adforest') => 'ajax_based',
        ),
        'edit_field_class' => 'vc_col-sm-12 vc_column',
        'description' => __('Please choose categories load type on frontend for this element. ', 'adforest'),
    );
    return $cat_field;
}
add_filter('adforest_validate_term_type', 'adforest_validate_term_type_callback', 10, 1);

function adforest_validate_term_type_callback($arr_data = array()) {
    global $adforest_theme;
    $ajax_base_load = isset($adforest_theme['sb_cat_load_style']) && $adforest_theme['sb_cat_load_style'] == 'live' ? TRUE : FALSE;

    if (isset($arr_data) && !empty($arr_data) && is_array($arr_data) && sizeof($arr_data) > 0) {
        $final_arr_data = array();
        foreach ($arr_data as $each_val) {
            $arr_exp = '';
            $final_arr_dataa = array();
            foreach ($each_val as $key => $each_vali) {
                $arr_exp = explode("|", $each_vali);
                $final_arr_dataa[$key] = $arr_exp[0];
            }
            $final_arr_data[] = $final_arr_dataa;
        }
        $arr_data = $final_arr_data;
    }
    return $arr_data;
}
if (!function_exists('adforest_ThemeBtn')) {

    function adforest_ThemeBtn($section_btn = '', $class = '', $onlyAttr = false, $iconBefore = '', $iconAfter = '') {
        $buttonHTML = "";
        if (isset($section_btn) && $section_btn != "") {
            $button = adforest_extarct_link($section_btn);
            $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
            $rel = ( isset($button["rel"]) && $button["rel"] != "" ) ? ' rel="' . esc_attr($button["rel"]) . ' "' : "";
            $href = ( isset($button["url"]) && $button["url"] != "" ) ? ' href="' . esc_url($button["url"]) . ' "' : "javascript:void(0);";
            $title = ( isset($button["title"]) && $button["title"] != "" ) ? ' title="' . esc_attr($button["title"]) . '"' : "";
            $target = ( isset($button["target"]) && $button["target"] != "" ) ? ' target="' . esc_attr(trim($button["target"])) . '"' : "";
            $titleText = ( isset($button["title"]) && $button["title"] != "" ) ? esc_html($button["title"]) : "";

            if (isset($button["url"]) && $button["url"] != "") {
                $btn = ( $onlyAttr == true ) ? $href . $target . $class . $rel : '<a ' . $href . ' ' . $target . ' ' . $class . ' ' . $rel . '>' . $iconBefore . ' ' . esc_html($titleText) . ' ' . $iconAfter . '</a>';
                $buttonHTML = ( isset($title) ) ? $btn : "";
            }
        }
        return $buttonHTML;
    }

}
if (!function_exists('adforest_extarct_link')) {
    function adforest_extarct_link($string) {
        $arr = @explode('|', $string);
        $rel = '';
        $target = '';
        $title = '';
        $url = '';
        if (isset($arr) && !empty($arr) && is_array($arr) && sizeof($arr) > 0) {
            foreach ($arr as $value) {
                $ext_val = adforest_themeGetExplode($value, ':');
                if (isset($ext_val[0]) && $ext_val[0] == 'url') {
                    $url = isset($ext_val[1]) && $ext_val[1] != '' ? urldecode($ext_val[1]) : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'title') {
                    $title = isset($ext_val[1]) && $ext_val[1] != '' ? urldecode($ext_val[1]) : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'target') {
                    $target = isset($ext_val[1]) && $ext_val[1] != '' ? $ext_val[1] : '';
                } elseif (isset($ext_val[0]) && $ext_val[0] == 'rel') {
                    $rel = isset($ext_val[1]) && $ext_val[1] != '' ? $ext_val[1] : '';
                }
            }
        }
        return array("url" => $url, "title" => $title, "target" => $target, "rel" => $rel);
    }
}
if (!function_exists('adforest_themeGetExplode')) {

    function adforest_themeGetExplode($string = "", $explod = "", $index = "") {
        $ar = '';
        if ($string != "") {
            $exp = explode($explod, $string);
            $ar = ( $index != "" ) ? $exp[$index] : $exp;
        }
        return ( $ar != "" ) ? $ar : "";
    }

}

if (!function_exists('adforest_get_products')) {
    function adforest_get_products() {
        global $adforest_theme;
        $products = array(__('Select Product', 'adforest') => '');
        if (!is_admin()) {
            return $products;
        }
        if (isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on']) {
            $args = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => array('adforest_classified_pkgs','subscription','variable-subscription')
                    ),
                ),
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
            );
        } else {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
            );
        }
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
        }
        wp_reset_postdata();
        return $products;
    }
}

// Get param array
if (!function_exists('adforest_generate_type')) {

    function adforest_generate_type($heading = '', $type = '', $para_name = '', $description = '', $group = '', $values = array(), $default = '', $class = 'vc_col-sm-12 vc_column', $dependency = '', $holder = 'div') {

        $val = '';
        if (is_array($values) && count($values) > 0) {
            $val = $values;
        }

        return array(
            "group" => $group,
            "type" => $type,
            "holder" => $holder,
            "class" => "",
            "heading" => $heading,
            "param_name" => $para_name,
            "value" => $val,
            "description" => $description,
            "edit_field_class" => $class,
            "std" => $default,
            'dependency' => $dependency,
        );
    }

}

if (!function_exists('adforest_vc_forntend_edit')) {
    function adforest_vc_forntend_edit() {
        return function_exists('vc_is_inline') && vc_is_inline() ? true : false;
    }
}

if (!function_exists('adforest_color_text_custom_html')) {

    function adforest_color_text_custom_html($str = '', $before = '', $after = '') {
        preg_match_all('~{color}([^{]*){/color}~i', $str, $matches);
        $i = 1;
        $found = array();
        foreach ($matches as $key => $val) {
            if ($i == 2) {
                $found = $val;
            }
            $i++;
        }
        foreach ($found as $k) {
            $search = "{color}" . $k . "{/color}";
            $replace = $before . $k . $after;
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

}

if (!function_exists('adforest_color_text')) {

    function adforest_color_text($str) {
        preg_match_all('~{color}([^{]*){/color}~i', $str, $matches);
        $i = 1;
        $found = array();
        foreach ($matches as $key => $val) {
            if ($i == 2) {
                $found = $val;
            }
            $i++;
        }
        foreach ($found as $k) {
            $search = "{color}" . $k . "{/color}";
            $replace = '<span class="heading-color">' . $k . '</span>';
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }
}