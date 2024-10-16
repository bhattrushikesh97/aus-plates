<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('ads_gridshort')) {

    function ads_gridshort() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'yes');

        vc_map(array(
            "name" => __("Ads Grid", 'adforest'),
            "base" => "ads_gridshort_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('grid_modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Section Background", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'bg-gray',
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section tagline", 'adforest'),
                    "param_name" => "section_tagline",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description /when cat section hidden", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads to display", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "vc_link",
                    "heading" => __("View all button link", 'adforest'),
                    "param_name" => "main_link",
                ),
                array
                    (
                    'group' => __('Categories for ads', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_gridshort');
if (!function_exists('ads_gridshort_base_func')) {

    function ads_gridshort_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'main_link' => '',
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'link_title' => '',
            'main_link' => '',
            'adforest_elementor' => ''
                        ), $atts));
        extract($atts);

        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = ($cats);
        } else {
            $rows = vc_param_group_parse_atts($cats);
            $rows = apply_filters('adforest_validate_term_type', $rows);
        }
        $cats_arr = array();
        $is_all = false;
        if (isset($rows) && $rows != '' && is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {

                if (isset($adforest_elementor) && $adforest_elementor) {
                    $row = $row;
                } else {
                    $row = $row['cat'];
                }
                if ($row == "all") {
                    $is_all = true;
                    break;
                }
                $cats_arr[] = $row;
            }
        }

        $category = '';
        if (isset($cats_arr) && !empty($cats_arr) && count($cats_arr) > 0 && !$is_all) {
            $category = array('taxonomy' => 'ad_cats', 'field' => 'term_id', 'terms' => $cats_arr);
        }

        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array('key' => '_adforest_is_feature', 'value' => 1, 'compare' => '=',);
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array('key' => '_adforest_is_feature', 'value' => 0, 'compare' => '=',);
        }
        $is_active = array('key' => '_adforest_ad_status_', 'value' => 'active', 'compare' => '=',);
        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'orderby' => $order_by,
            'order' => $ordering,
            'meta_query' => array($is_feature, $is_active,),
        );
        if ($category != '') {
            $args['tax_query'] = array($category);
        }
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');

        $grid_html = '';
        global $adforest_theme;
        $results = new \WP_Query($args);
        if ($results->have_posts()) {

            while ($results->have_posts()) {
                $results->the_post();
                $pid = get_the_ID();
                // $ads = new \ads();

                $grid_html .= adforest_search_layout_grid_1($pid, 3);
            }
            wp_reset_postdata();
        }



        if (isset($adforest_elementor) && $adforest_elementor) {
            $btn_args = array(
                'btn_key' => $main_link,
                'adforest_elementor' => $adforest_elementor,
                'btn_class' => 'btn btn-theme',
                'iconBefore' => '',
                'iconAfter' => '',
                'onlyAttr' => false,
                'titleText' => $link_title,
            );
            $link_attr = apply_filters('adforest_elementor_url_field', "", $btn_args);
        } else {

            $link_attr = adforest_ThemeBtn($main_link, 'btn btn-theme', false);
        }


        echo '<section class="custom-padding  ' . $section_bg . '">
                        <div class="container">
                        <div class="sb-short-head center">
                           <span>' . esc_html($section_tagline) . '</span>
                           <h2>' . $section_title . '</h2>
                           <p> ' . $section_description . '</p>
                         </div>
                         <div clas = "row">
                         <div class="col-md-12 col-xs-12 col-sm-12">
                             <div class="row">                                                                
                                      ' . $grid_html . ' 
                             </div>
                          </div>
                        </div>    
                         <div class="view-more-bottun">
                                 ' . $link_attr . '
                          </div> 
                      </div>    
                </section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_gridshort_base', 'ads_gridshort_base_func');
}