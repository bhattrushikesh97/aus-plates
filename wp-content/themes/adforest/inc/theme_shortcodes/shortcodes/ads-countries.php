<?php

/* ------------------------------------------------ */
/* Ads */
/* ------------------------------------------------ */

if (!function_exists('ads_by_countries')) {

    function ads_by_countries() {
        vc_map(array(
            "name" => __("Custom Locations Slider", 'adforest'),
            "base" => "location_short_modern_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('location-new-slider.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
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
                    'group' => esc_html__('Locations', 'adforest'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Locations', 'adforest'),
                    'param_name' => 'select_locations',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => __("Locations", 'adforest'),
                            "param_name" => "location",
                            "admin_label" => true,
                            "value" => adforest_cats('ad_country', 'no'),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Location Background Image", 'adforest'),
                            "param_name" => "img",
                            "description" => __("Recommended size 270 by 283", 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_by_countries');

if (!function_exists('location_short_modern_modern_base_func')) {

    function location_short_modern_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'select_locations' => '',
            'name' => '',
            'attach_image' => '',
            'cat_link_page '=>''
                        ), $atts));
        extract($atts);
        $adforest_render_params = array();

        wp_enqueue_script('lightslider');
        wp_enqueue_style('lightslider');

        $section_bg = isset($section_bg) && $section_bg != "" ? 'bg-gray' : "";
        
        
          $cat_link_page    =     isset($cat_link_page)  ? $cat_link_page  : "category";

        $marker_div = '<div class="marker-img"><img src="' . trailingslashit(get_template_directory_uri()) . 'images/route.png' . '" alt="' . __(' location', 'adforest') . '"></div>';
        $locations_html = '';
        if (isset($atts['select_locations']) && $atts['select_locations'] != '') {

            if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = $atts['select_locations'];
            } else {
                $rows = vc_param_group_parse_atts($atts['select_locations']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }

            if (count($rows) > 0) {
                foreach ($rows as $r) {
                    if ($r != '') {
                        $img_thumb = '';
                        if (isset($adforest_elementor) && $adforest_elementor) {
                            $img = (isset($r['img']['id'])) ? $r['img']['id'] : '';
                        } else {
                            $img = (isset($r['img'])) ? $r['img'] : '';
                        }
                        if (isset($adforest_elementor) && $adforest_elementor) {
                            $id = (isset($r['name'])) ? $r['name'] : '';
                        } else {
                            $id = (isset($r['location'])) ? $r['location'] : '';
                        }
                        $img_url = wp_get_attachment_image_src($img, 'adforest-ad-country');
                        $img_thumb = $img_url[0];
                        $term = get_term_by('id', $id, 'ad_country');
                        if (isset($term->name)) {
                            $id_get = $term->term_id;
                            $slug = $term->slug;
                            $name = $term->name;
                            $count = $term->count;
                            $link = get_term_link($id_get, 'ad_country');
                            if (is_wp_error($link)) {
                                continue;
                            }
                            $parent = $term->parent;
                            $locations_html .= '          <div class="item">
                                                    <div class="most-popular-city">
                                                <a href="'.adforest_cat_link_page($id_get, $cat_link_page, 'country_id').'">        <img src="' . $img_thumb . '" alt="' . $name . '"></a>
                                                    </div>
                                                     <div class="places-content">

                                                     <div class="place-content-heding">
                                                     <a href="' . adforest_cat_link_page($id_get, $cat_link_page, 'country_id') . '"> <h5>' . $name . '</h5></a>
                                                      <span class="">( ' . $count . ' ' . esc_html__('ads', 'adforest') . ' )</span>
                                                      </div>
                                                <div class="places-icon">
                                            <img src="' . get_template_directory_uri() . '/images/icon-map.png" alt="' . esc_html__('icon', 'adforest') . '">
                                           </div>
                                       </div>
                                    </div>';
                        }
                    }
                }
            }
        }
        ?>

        <?php

        //echo location_short_modern_base_func($adforest_render_params);

        echo '<section class="most-popular custom-padding  ' . $section_bg . '">
   <div class="container">
<div class="sb-short-head center">
 <span>' . esc_html($section_tagline) . '</span>
      <h2>' . $section_title . '</h2>
      <p>' . $section_description . '</p>
    </div>
    <div class="carousel-wrap">
    <div class="owl-carousel1  location-ad-carousel">

  ' . $locations_html . '
</div>
</div>
</div>
</section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('location_short_modern_base', 'location_short_modern_base_func');
}