<?php

/* ------------------------------------------------ */
/* Ads- Cats based boxes */
/* ------------------------------------------------ */
if (!function_exists('ads_cats_slider_short')) {
    function ads_cats_slider_short() {
        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');
        vc_map(array(
            "name" => __("Category Slider", 'adforest'),
            "description" => __("Once on a Page.", 'adforest'),
            "base" => "ads_cats_slider_short_base",
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
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats_round',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "class" => "",
                            "heading" => __("Category image", 'adforest'),
                            "param_name" => "bg_img",
                        ),
                    ),
                ),
            ),
        ));
    }
}
add_action('vc_before_init', 'ads_cats_slider_short');
if (!function_exists('ads_cats_slider_short_base_func')) {
    function ads_cats_slider_short_base_func($atts, $content = '') {
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
            'section_bg' => '',
            'cats_round'=> ''
                        ), $atts));
        extract($atts);
        $cats_card = "";
        $cats_round_html = '';
        
        
       
        if (isset($atts['cats_round'])) {
            if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = ($atts['cats_round']);
            } else {
                $rows = vc_param_group_parse_atts($atts['cats_round']);
                 $rows = apply_filters('adforest_validate_term_type', $rows);
            }
            if (isset($rows) && !empty($rows) && count($rows) > 0) {
                foreach ($rows as $row) {        
                    if (isset($row['cat']) && $row['cat'] != "") {
                        if (isset($adforest_elementor) && $adforest_elementor) {
                            $cat_id = $row['cat'];
                        } else {
                            $cat_id = vc_param_group_parse_atts($row['cat']);

                        }
                        $term = get_term($cat_id, 'ad_cats');
                        if ($term) {                

                            if (isset($adforest_elementor) && $adforest_elementor) {
                                $bgImageURL =  isset($row['img']['url'])  ? $row['img']['url']  : "#" ;
                            } else {
                                 $bgImageURL =  isset($row['bg_img'])  ? adforest_returnImgSrc($row['bg_img']): "#" ;
                            }
                            $cat_link_page = isset($cat_link_page) ? $cat_link_page : '';
                            $cats_round_html .= '<div class="visited-content-items"><a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
						<div class="visited-state"><img alt="' . $term->name . '" src="' . esc_url($bgImageURL) . '" title="' . $term->name . '"></div><div class="state-heading"><h5>' . $term->name . '</h5></div></a></div>';
                        }
                    }
                }
            }
        }
        return
                '<section class="cat-hero-section">
    <div class="container">
        <div class="div-section">
            <div class="cat-hero-slider">
             ' . $cats_round_html . '
            </div>
        </div>
    </div>
</section>';
    }
}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_cats_slider_short_base', 'ads_cats_slider_short_base_func');
}