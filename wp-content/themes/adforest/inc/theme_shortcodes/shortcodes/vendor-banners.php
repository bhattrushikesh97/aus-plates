<?php

/* ------------------------------------------------ */
/* services on vendor page */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_vendor_banners_shortcode');
if (!function_exists('adforest_vendor_banners_shortcode')) {

    function adforest_vendor_banners_shortcode() {
        vc_map(array(
            'name' => __('Vendor Banners', 'adforest'),
            'description' => '',
            'base' => 'vendor_banners',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('vendor-banners.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Left col", 'adforest'),
                    "param_name" => "col-style-left",
                    "admin_label" => true,
                    "value" => array(
                        __('Col 3', 'adforest') => 'col-xl-3',
                        __('col 6', 'adforest') => 'col-xl-6',
                        __('col 9', 'adforest') => 'col-xl-9'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Banner Left", 'adforest'),
                    "param_name" => "banner_left",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Right col", 'adforest'),
                    "param_name" => "col-style-right",
                    "admin_label" => true,
                    "value" => array(
                        __('Col 3', 'adforest') => 'col-xl-3',
                        __('col 6', 'adforest') => 'col-xl-6',
                        __('col 9', 'adforest') => 'col-xl-9'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Banner Right", 'adforest'),
                    "param_name" => "banner_right",
                ),
            )
        ));
    }

}

if (!function_exists('adforest_vendor_banners_func')) {

    function adforest_vendor_banners_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'col-style-left' => '',
            'col-style-right' => '',
            'banner_left' => '',
            'banner_left' => '',
                        ), $atts));

        extract($atts);

        $left_col = (isset($atts['col-style-left']) && $atts['col-style-left'] != "") ? $atts['col-style-left'] : 'col-xl-6';
        $right_col = (isset($atts['col-style-right']) && $atts['col-style-right'] != "") ? $atts['col-style-right'] : 'col-xl-6';
       

        if (isset($adforest_elementor) && $adforest_elementor) {
            $left_image = isset($atts['banner_left']['url']) ? $atts['banner_left']['url'] : '';
            $right_image = isset($atts['banner_right']['url']) ? $atts['banner_right']['url'] : '';
        } else {          
            $left_image = isset($atts['banner_left']) ? adforest_returnImgSrc($atts['banner_left']) : '';
            $right_image = isset($atts['banner_right']) ? adforest_returnImgSrc($atts['banner_right']) : '';
        }

        $col_arr = array(
            'col-xl-3' => 'col-xl-3 col-lg-3 col-md-3 col-sm-12',
            'col-xl-6' => 'col-xl-6 col-lg-6 col-md-6 col-sm-12',
            'col-xl-9' => 'col-xl-9 col-lg-9 col-md-9 col-sm-12',
        );

        $left_col = $col_arr[$left_col];
        $right_col = $col_arr[$right_col];

        echo '<section class="brands-poster">
<div class="container">
  <div class="row">
    <div class="' . $left_col . '">
      <div class="brand-img">
        <img src="' . $left_image . '" alt="discount-img" class="img-fluid">
      </div>
    </div>
    <div class="' . $right_col . '">
      <div class="brand-img-2">
        <img src="' . $right_image . '" alt="discount-img" class="img-fluid">
      </div>
    </div>
  </div>
</div>
</section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('vendor_banners', 'adforest_vendor_banners_func');
}