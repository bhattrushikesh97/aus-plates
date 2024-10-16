<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('search_hero_1_short')) {

    function search_hero_1_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Main Hero 1", 'adforest'),
            "base" => "search_hero_1_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('main-hero-new1.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    "description" => __("1280x800", 'adforest'),
                ),
                   array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "signature_img",
                    "class" => "",
                    "heading" => __("Signature image", 'adforest'),
                    "param_name" => "signature_img",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Keyword Label", 'adforest'),
                    "param_name" => "keyword_label",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Keyword Search Place holder", 'adforest'),
                    "param_name" => "keyword_placeholder",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Location Label", 'adforest'),
                    "param_name" => "location_label",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Location Search Place holder", 'adforest'),
                    "param_name" => "location_placeholder",
                ),
                array(
                    "group" => __("Location type", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Location type", 'adforest'),
                    "param_name" => "location_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Google', 'adforest') => 'g_locations',
                        __('Custom Location', 'adforest') => 'custom_locations',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                    array(
                    'group' => __('Location type', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Location', 'adforest'),
                    'param_name' => 'locations',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'location_type',
                        'value' => array('custom_locations'),
                    ),
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Locations", 'adforest'),
                            "param_name" => "location",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_country', 'yes'),
                        ),
                    )
                ),
                array(
                    "group" => __("Categories", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Category link Page", 'adforest'),
                    "param_name" => "cat_link_page",
                    "admin_label" => true,
                    "value" => array(
                        __('Search Page', 'adforest') => 'search',
                        __('Category Page', 'adforest') => 'category',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( All or Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'cat_frontend_switch',
                        'value' => array(''),
                    ),
                    'params' => array
                        ($cat_array)
                ),
            
            ),
        ));
    }

}

add_action('vc_before_init', 'search_hero_1_short');
if (!function_exists('search_hero_1_short_base_func')) {

    function search_hero_1_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_description' => '',
            'section_title_regular' => '',
            'location_type' => '',
            'keyword_label' => '',
            'keyword_placeholder' => '',
            'location_label' => '',
            'location_placeholder' => '',
            'locations' => '',
            'cats' => '',
            'signature_img' => ''
                        ), $atts));
        
        if(is_array($atts)){
        extract($atts);
        
        
        }
        else {
            return ;
        }
        wp_enqueue_script('slick-slider');
        global $adforest_theme;
        $locations_html = "";

        if (isset($location_type) && $location_type == 'custom_locations') {
            $args = array('hide_empty' => 0);
            $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
            $final_loc_html = '';
            $locations_html = '';
            $loc_flag = FALSE;

            $rows = isset($locations) && $locations != '' ? $locations : array();

            if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = ($locations);
            } else {
                $rows = vc_param_group_parse_atts($atts['locations']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }


            if (is_array($rows) && !empty($rows)) {
                $locations_html .= '';
                foreach ($rows as $row) {
                    
          

                    if (isset($adforest_elementor) && $adforest_elementor) {
                        $loc_id = $row;
                    } else {
                        $loc_id = isset($row['location'])  ? $row['location']  : "";
                    }
                    if ($loc_id == "all") {
                        $loc_flag = TRUE;
                        break;
                    }
                    if (isset($loc_id) && $loc_id != "" ) {
                        $term = get_term($loc_id, 'ad_country');
                        $locations_html .= ' <option value="' . $loc_id . '">' . $term->name . '</option> ';
                    }
                }
            }

            if ($loc_flag) {
                $locations_html .= ' <option value="">' . esc_html__('Select location', 'adforest') . ' </option> ';
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
            }
        }

        $contries_script = '';
        if (isset($location_type) && $location_type == 'custom_locations') {
            $final_loc_html .= '<select class="js-example-basic-single" name="country_id" data-placeholder="' . __('Select Location', 'adforest') . '">';
            $final_loc_html .= '<option label="' . __('Select Location', 'adforest') . '" value="">' . __('Select Location', 'adforest') . '</option>';
            $final_loc_html .= $locations_html;
            $final_loc_html .= '</select>';
        } else {
            ob_start();
            adforest_load_search_countries();
            $contries_script = ob_get_contents();
            ob_end_clean();
            wp_enqueue_script('google-map-callback');
            $final_loc_html = '<input class="form-control" name="location"  id="sb_user_address" placeholder="' . $location_placeholder . '"  type="text">';
        }
        $html = '';
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);

        if (isset($adforest_elementor) && $adforest_elementor) {
            $cats_arr = $cats;
        } else {
            $cats_arr = vc_param_group_parse_atts($atts['cats']);
            $cats_arr = apply_filters('adforest_validate_term_type', $cats_arr);
        }

        $cats_html = "";
        $cat_link_page = isset($cat_link_page) ? $cat_link_page : "";
        foreach ($cats_arr as $cat_id) {
            
           $cat_id = $cat_id;
            if (isset($adforest_elementor) && $adforest_elementor) {
                $cat_id = $cat_id;
            } else {
                $cat_id = $cat_id['cat'];
            }

            if (isset($cat_id)) {
                $term = get_term($cat_id, 'ad_cats');
                $cat_image = get_term_meta($cat_id, 'taxonomy_image', 'true');
                if (isset($term->term_id)) {

                    $imgUrl = adforest_taxonomy_image_url($cat_id, NULL, TRUE);
                    $cats_html .= ' 
                                    <div class="item">
                                        <div class="category-logo">
                                            <div class="cate-img">
                                                <img src="' . $imgUrl . '" alt="' . $term->name . '"/>
                                            </div>
                                            <div class="cate-head">
                                                <h5><a href="' . adforest_cat_link_page($term->term_id, $cat_link_page, 'cat_id') . '">' . $term->name . '</a></h5>
                                                <span>' . $term->count . esc_html__('  Ads', 'adforest') . '</span>
                                            </div>
                                        </div>  
                                    </div>';
                }
            }
        }


        
       if(isset($adforest_elementor) && $adforest_elementor ){
        $signature_img = isset($atts['signature_img']['url']) ? $atts['signature_img']['url'] : '#';
        }     
        else {          
            $signature_img = adforest_returnImgSrc($signature_img);         
        }
        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ')  no-repeat scroll center center / cover ;"' : "";
        }
 
        return ''.$contries_script.'<div class="search-bg"  ' . $style . '>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="clasfied-head">
                            <span class="reguler-label">' . $section_title . '</span>
                            <h1>' . $section_description . '</h1>
                            <div class="s013">
                                <form class="form-join" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
                                    <div class="inner-form">
                                        <div class="left">
                                            <div class="input-wrap first">
                                                <div class="input-field first">
                                                    <label>' . $keyword_label . '</label>
                                                    <i class="fa fa-search search-icon-1"></i>
                                                    <input type="text" placeholder="' . esc_attr($keyword_placeholder) . '"  name="ad_title"/>
                                                </div>
                                            </div>
                                            <div class="input-wrap second">
                                                <div class="input-field second">
                                                    <label>' . $location_label . '</label>
                                                    <i class="fa fa-crosshairs location-select"></i>
                                                    <div class="input-select">
                                                      ' . adforest_returnEcho($final_loc_html) . '
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-theme" type="submit">' . esc_html__('Search', 'adforest') . '</button>
                                    </div>
                                </form>
                            </div>
                            <div class="arrow-goal">
                                <img src="' . $signature_img . '" alt="'.esc_attr__('img','adforest').'">
                            </div>
                               <div class="cover-wrapper">
                                <div id="client-logos" class="owl-carousel2">         
                                  ' . $cats_html . '
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_hero_1_short_base', 'search_hero_1_short_base_func');
}