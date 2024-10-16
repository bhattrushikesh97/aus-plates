<?php

/* ------------------------------------------------ */
/* About Us */
/* ------------------------------------------------ */
if (!function_exists('about_us_short')) {

    function about_us_short() {
        vc_map(array(
            "name" => __("About Us", 'adforest'),
            "base" => "about_us_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('about-us-new.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
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
                    "group" => __("About Us", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => __("large image", 'adforest'),
                    "param_name" => "img_1",
                    "description" => "524x464",
                ),
                array(
                    "group" => __("About Us", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "heading" => __("large image", 'adforest'),
                    "param_name" => "img_2",
                    "description" => "294x280",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Youtube video Link", 'adforest'),
                    "param_name" => "link",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                    (
                    'group' => __('Points', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Points', 'adforest'),
                    'param_name' => 'clients',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Small title", 'adforest'),
                            "param_name" => "small_title",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Small description", 'adforest'),
                            "param_name" => "small_desc",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Font awesome icons", 'adforest'),
                            "param_name" => "icon",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                            "value" => __("fa fa-heart", "adforest"),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'about_us_short');
if (!function_exists('about_us_short_base_func')) {

    function about_us_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'link' => '',
            ''
                        ), $atts));
        extract($atts);

        wp_enqueue_script('anime-slider');
        wp_enqueue_script('popup-video-iframe');
        wp_enqueue_style('popup-video-iframe');

        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = isset($atts['clients']) ? $atts['clients'] : array();
        } else {
            $rows = vc_param_group_parse_atts($atts['clients']);
            $rows = apply_filters('adforest_validate_term_type', $rows);
        }



        //$rows = vc_param_group_parse_atts($atts['clients']);
        $short_content = '';
        if (isset($rows) && is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                if (isset($adforest_elementor) && $adforest_elementor) {
                    $icon = $row['icon']['value'];
                } else {
                    $icon = $row['icon'];
                }
                $short_content .= ' <div class="tag-content">
            <div class="tag-icon">
                <i class="' . $icon . '"></i>
            </div>
            <div class="tag-heading">
                 <h5>' . $row['small_title'] . '</h5>
                <p>' . $row['small_desc'] . '</p>
            </div>
        </div>';
            }
        }

        $img_1_html = "";
        $img_2_html = "";

        if (isset($adforest_elementor) && $adforest_elementor) {
            if (isset($img_1 ['url']) && $img_1 ['url'] != "") {
                $img_1_html .= '<img src="' . $img_1 ['url'] . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '">';
            }

            if (isset($img_2['url']) && $img_2['url'] != "") {
                $img_2_html .= '<img src="' . $img_2['url'] . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '">';
            }
        } else {
            if ($img_1 != "") {
                $img_1_html .= '<img src="' . adforest_returnImgSrc($img_1) . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '">';
            }
            if ($img_2 != "") {
                $img_2_html .= '<img src="' . adforest_returnImgSrc($img_2) . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '">';
            }
        }
        echo '<section class="best-new">
<div class="container">
  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
<div class="best-new-img">
  ' . $img_1_html . '
    <a id="play-video" class="video-play-button" href="' . $link . '">
        <span></span>
    </a>
    <div id="video-overlay" class="video-overlay">
        <a class="video-overlay-close">&times;</a>
    </div>
    <div class="best-new-img-2">
       ' . $img_2_html . '
    </div>
</div>

</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 wow">

    <div class="best-new-content">
        <span>' . $section_tagline . '</span>
        <h3>' . $section_title . '</h3>
        <p>' . $section_description . '</p>
            ' . $short_content . '
    </div>
</div>
</div>
<div class="circles">
    <img class="circle-1" src="' . get_template_directory_uri() . '/images/circle-1.png" alt="Hero Circle" style="transform: translateX(4.89985px) translateY(9.7997px);">
    <img class="circle-2" src="' . get_template_directory_uri() . '/images/circle-2.png" alt="Hero Circle" style="transform: translateX(9.7997px) translateY(9.7997px);">
</div>
<div class="popular-1" style="transform: translateX(-0.667667px) translateY(0.934733px);"></div>
</div>
</section>
';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('about_us_short_base', 'about_us_short_base_func');
}  