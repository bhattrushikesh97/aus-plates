<?php

/* ------------------------------------------------ */
/* Ads- Cats based boxes */
/* ------------------------------------------------ */
if (!function_exists('ads_cats_tabs_short')) {

    function ads_cats_tabs_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');

        vc_map(array(
            "name" => __("ADs Tabs Modern", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_cats_tabs_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('add_cat_tab.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Background", "adforest"),
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
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
                    "heading" => __("Number fo Ads for each category", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                //Group For Left Section
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_cats_tabs_short');

if (!function_exists('ads_cats_tabs_short_base_func')) {

    function ads_cats_tabs_short_base_func($atts, $content = '') {
        global $adforest_theme;
        $no_title = 'yes';

 

        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'layout_type' => 'grid_1',
            'ad_order' => '',
            'no_of_ads' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_desc' => '',
            'section_bg' =>''
                        ), $atts));

        extract($atts);
        $is_type = '';
        if ($ad_type == 'feature') {
            $is_type = 1;
        } else {
            $is_type = 0;
        }
        $cats = array();
          if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = isset($atts['cats']) && $atts['cats'] != '' ? ($atts['cats']) : '';
        } else {
            $cats_data = isset($atts['cats']) && $atts['cats'] != '' ? vc_param_group_parse_atts($atts['cats']) : '';
            $rows = apply_filters('adforest_validate_term_type', $cats_data);
        }

        $categories_html = '';
        $ads_html = '';
        $counnt = 1;
        if (isset($rows) && is_array($rows) && !empty($rows[0]) > 0) {
            $categories_html .= '';

            $adforest_tab = 'ad-tab-';
            foreach ($rows as $row) {
                $rand_id = rand(1234, 99999);
                   if (isset($adforest_elementor) && $adforest_elementor) {
                    $cat_idd = $row;
                }else{
                   $cat_idd = $row['cat'];
                }
                if (isset($cat_idd)) {
                    $is_active = '';
                    $show = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $show = 'show';
                        $counnt++;
                    }
                    $cat_obj = get_term($cat_idd);
                    if (count((array) $cat_obj) == 0)
                        continue;
                    $categories_html .= '<li role="presentation" class="nav-item  ">
					<a class="nav-link ' . esc_attr($is_active) . '" href="#' . $adforest_tab . $rand_id . '" aria-controls="home" role="tab" data-bs-toggle="tab" title="' . $cat_obj->name . '">' . $cat_obj->name . '</a></li>';
                    $ads_html .= '<div role="tabpanel" class="tab-pane fade  ' . esc_attr($is_active) . '  ' . $show . '" id="' . $adforest_tab . $rand_id . '"><div class =  "row">';

                    $category = array(
                        array(
                            'taxonomy' => 'ad_cats',
                            'field' => 'term_id',
                            'terms' => $cat_idd,
                        ),
                    );
                    $is_feature = '';
                    if ($ad_type == 'feature') {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else if ($ad_type == 'both') {
                        $is_feature = '';
                    } else {
                        $is_feature = array(
                            'key' => '_adforest_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }
                    $is_active = array(
                        'key' => '_adforest_ad_status_',
                        'value' => 'active',
                        'compare' => '=',
                    );

                    $ordering = 'DESC';
                    $order_by = 'date';
                    if ($ad_order == 'asc') {
                        $ordering = 'ASC';
                    } else if ($ad_order == 'desc') {
                        $ordering = 'DESC';
                    } else if ($ad_order == 'rand') {
                        $order_by = 'rand';
                    }
                    $countries_location = '';
                    $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_ads,
                        'meta_query' => array(
                            $is_feature,
                            $is_active,
                        ),
                        'tax_query' => array(
                            $category,
                            $countries_location,
                        ),
                        'orderby' => $order_by,
                        'order' => $ordering,
                    );
                    $args = apply_filters('adforest_wpml_show_all_posts', $args);
                    $results = new \WP_Query($args);
                    if ($results->have_posts()) {
                        while ($results->have_posts()) {
                            $results->the_post();
                            $ads_html .= adforest_search_layout_grid_1(get_the_ID(), 3);
                        }
                    }
                }
                $ads_html .= '</div></div>';
            }
            wp_reset_postdata();
        }

        echo '<section class="cashew-multiple-grid custom-padding ' . $section_bg . '">
             <div class="container">
                 <div class="sb-short-head center">
                           <span>' . esc_html($section_tagline) . '</span>
                           <h2>' . $section_title . '</h2>
                           <p> ' . $section_description . '</p>
                         </div>
               <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                     ' . $categories_html . '
               </ul>
               <div class="tab-content" id="pills-tabContent">
                ' . $ads_html . '
               </div>
             </div>
        </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_cats_tabs_short_base', 'ads_cats_tabs_short_base_func');
}