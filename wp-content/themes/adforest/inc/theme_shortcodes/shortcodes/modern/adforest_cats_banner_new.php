<?php
/* ------------------------------------------------ */
/* services */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_hero_sports_shortcode_new');
if (!function_exists('adforest_hero_sports_shortcode_new')) {

    function adforest_hero_sports_shortcode_new() {
        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');
        vc_map(array(
            'name' => __('Hero - Category Banner', 'adforest'),
            'description' => '',
            'base' => 'adforest_hero_sports_new',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('hero-sport.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 1", "adforest"),
                    "param_name" => "heading_1",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading 2", "adforest"),
                    "param_name" => "heading_2",
                    "value" => '',
                    "description" => '',
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __("Description", "adforest"),
                    "param_name" => "banner_description",
                    "value" => '',
                    "description" => __("Enter banner description here .", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __("Background Image", "adforest"),
                    "param_name" => "bg_image",
                    "value" => '',
                    "description" => __("Add an image of  background : Recommended size (1920x946)", "adforest"),
                    'group' => __('Basic', 'adforest'),
                ),
                array
                (
                'group' => __('Categories', 'adforest'),
                'type' => 'param_group',
                'heading' => __('Select Category ( All or Selective )', 'adforest'),
                'param_name' => 'cats',
                'value' => '',
                'params' => array
                    (
                    $cat_array,
                
                )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_hero_sports_callback_new')) {

    function adforest_hero_sports_callback_new($atts, $content = '') {
         extract(
                shortcode_atts(
                        array(
            'heading_1' => '',
            'heading_2' => '',
            'banner_description' => '',
            'bg_image' => '',
            'cats' => '',
                        ), $atts)
        );
        extract($atts);

        $bg_image_id = isset($bg_image) ? $bg_image : '';
        $heading_1 = isset($heading_1) ? $heading_1 : '';
        $heading_2 = isset($heading_2) ? $heading_2 : '';
        $banner_description = isset($banner_description) ? $banner_description : '';
        $banner_image = adforest_returnImgSrc($bg_image_id);
        if (!empty($bg_image_id)) {
            $bg_style = ' style="background: url(' . esc_url($banner_image) . ') center center no-repeat;background-size: cover !important;"';
        }



            $html = '';
            $ad_categories = $atts['cats'];
            // For custom locations
            $ad_categories_html = '';
            if (isset($atts['cats'])) {

                if (isset($adforest_elementor) && $adforest_elementor) {
                    $rows = ($atts['cats']);
                } else {
                    $rows = vc_param_group_parse_atts($atts['cats']);
                    $rows = apply_filters('adforest_validate_term_type', $rows);
                }

                if (count((array) $rows) > 0) {
                    foreach ($rows as $row) {
                        if (isset($row['cat'])) {
                            $term = get_term($row['cat'], 'ad_cats');
                            
                            if(is_wp_error($term)){
                                continue;
                            }

                            $term_link = adforest_cat_link_page($row['cat'] );

                            if ($term) {

                                $ad_categories_html .= '<a href="' . esc_url($term_link) . '"><li><span>' . esc_html($term->name) . '</span></li> </a>';
                                
                            }
                        }
                    }
                }
            }

  
             
         
        
        
        $html = '';
        $html .= ' <div class="container-fluid"> 
        <div class="row">
                <div class="col-12 col-md-4 col-lg-3 col-xl-3 col-xxl-2">
               </div>
                 <div class="col-12 col-md-8 col-lg-9 col-xl-9 col-xxl-10">
            <div class="ad-popular-category-tags" '.$bg_style.'>
            <i>' .esc_html($heading_1). '</i>
            <h2>' .esc_html($heading_2).'</h2>
            <ul>
                <li><strong>'.esc_html($banner_description).'.</strong></li>
                '. $ad_categories_html .'
            </ul>
        </div>
    </div>
    </div>
    </div>';
        return $html;
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adforest_hero_sports_new', 'adforest_hero_sports_callback_new');
}