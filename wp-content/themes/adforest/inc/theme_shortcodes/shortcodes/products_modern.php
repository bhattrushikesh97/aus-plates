<?php

/* ------------------------------------------------ */
/* Pricing Modern 2 */
/* ------------------------------------------------ */
if (!function_exists('price_modern2_short')) {

    function price_modern2_short() {
        vc_map(array(
            "name" => __("Products - Modern", 'adforest'),
            "base" => "price_modern2_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('pricing-new-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                    (
                    'group' => __('Products', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Product", 'adforest'),
                            "param_name" => "woo_products",
                            "admin_label" => true,
                            "value" => adforest_get_products(),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'price_modern2_short');
if (!function_exists('price_modern2_short_base_func')) {

    function price_modern2_short_base_func($atts, $content = '') {
        extract($atts);

        global $adforest_theme;

        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'woo_products' => ''
                        ), $atts));
        $html = '';
        $allow_arr = array(
            'no' => __('No', 'adforest'),
            'yes' => __('Yes', 'adforest'),
        );

        $product_flag = false;
        $rows = ($woo_products);

        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = $woo_products;
        } else {
            $rows = vc_param_group_parse_atts($woo_products);
            $rows = apply_filters('adforest_validate_term_type', $rows);
        }


        if (isset($rows) && !empty($rows) && is_array($rows) && sizeof($rows) > 0) {
            $product_flag = TRUE;
        }
        $categories_html = '';
        $single_pop_script = '';
        if ($product_flag) {
            $count = 0;
            foreach ($rows as $row) {


                if (isset($adforest_elementor) && $adforest_elementor) {
                    $prod_id = $row;
                } else {
                    $prod_id = isset($row['woo_products']) ? $row['woo_products'] : "";
                }

                if (isset($prod_id) && $prod_id != "") {
                    global $product;
                    $product_satus = get_post_status($prod_id);
                    $product = wc_get_product($prod_id);
                    if (!$product || $product_satus == false || $product_satus != 'publish') {
                        continue;
                    }
                    $product = new \WC_Product($prod_id);
                    $cls = 'block';

                    if (get_post_meta($prod_id, 'package_bg_color', true) == 'dark')
                        $cls = 'block featured';
                    $inner_html = '';
                    if (get_post_meta($prod_id, 'package_expiry_days', true) == "-1") {
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Validity', 'adforest') . ': ' . __('Lifetime', 'adforest') . '</span></li>';
                    } else if (get_post_meta($prod_id, 'package_expiry_days', true) != "") {
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Validity', 'adforest') . ': ' . get_post_meta($prod_id, 'package_expiry_days', true) . ' ' . __('Days', 'adforest') . '</span></li>';
                    }

          

                    if (get_post_meta($prod_id, 'package_free_ads', true) != "") {
                        $free_ads = get_post_meta($prod_id, 'package_free_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_free_ads', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Ads', 'adforest') . ': ' . $free_ads . '</span></li>';
                    }

                    if (get_post_meta($prod_id, 'package_featured_ads', true) != "") {
                        $feature_ads = get_post_meta($prod_id, 'package_featured_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_featured_ads', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Featured Ads', 'adforest') . ': ' . $feature_ads . '</span></li>';
                    }

                    if (get_post_meta($prod_id, 'package_bump_ads', true) != "") {
                        $bump_ads = get_post_meta($prod_id, 'package_bump_ads', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_bump_ads', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Bump-up Ads', 'adforest') . ': ' . $bump_ads . '</span></li>';
                    }
                    //new features
                    if (get_post_meta($prod_id, 'package_num_of_images', true) != "") {
                        $package_num_of_images = get_post_meta($prod_id, 'package_num_of_images', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_num_of_images', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('No Of Images ', 'adforest') . ': ' . $package_num_of_images . '</span></li>';
                    }

                    if (get_post_meta($prod_id, 'package_allow_bidding', true) != "") {
                        $package_allow_bidding = get_post_meta($prod_id, 'package_allow_bidding', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_allow_bidding', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Allow Bidding ', 'adforest') . ': ' . $package_allow_bidding . '</span></li>';
                    }

                     if (get_post_meta($prod_id, 'package_make_bidding_paid', true) != "") {
                        $package_make_bidding_paid = get_post_meta($prod_id, 'package_make_bidding_paid', true) == '-1' ? __('Unlimited', 'adforest') : get_post_meta($prod_id, 'package_make_bidding_paid', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Paid Bidding ', 'adforest') . ': ' . $package_make_bidding_paid . '</span></li>';
                    }


                    if (get_post_meta($prod_id, 'package_video_links', true) != "") {
                        $package_video_links = get_post_meta($prod_id, 'package_video_links', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Video URL ', 'adforest') . ': ' . $allow_arr[$package_video_links] . '</span></li>';
                    }
                    if (get_post_meta($prod_id, 'package_allow_tags', true) != "") {
                        $package_allow_tags = get_post_meta($prod_id, 'package_allow_tags', true);
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Allow Tags ', 'adforest') . ': ' . $allow_arr[$package_allow_tags] . '</span></li>';
                    }

                    if (get_post_meta($prod_id, 'package_allow_categories', true) != "") {
                        $selected_categories = get_post_meta($prod_id, "package_allow_categories", true);
                        $selected_categories = isset($selected_categories) && !empty($selected_categories) ? $selected_categories : '';
                        $selected_categories_arr = array();
                        if ($selected_categories != '') {
                            $selected_categories_arr = explode(",", $selected_categories);
                        }
                        $cat_list_ = '';
                        $poped_over_id = 'popover-' . rand(123, 9999);
                        $poped_over = 'category_package_list_' . rand(123, 9999);

                        if (isset($selected_categories_arr) && !empty($selected_categories_arr) && is_array($selected_categories_arr)) {

                            if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] != 'all') {
                                $cat_list_ .= '<div  class="' . $poped_over . '"  style="display:none;" ><ul>';
                                foreach ($selected_categories_arr as $single_cat_id) {
                                    $category = get_term($single_cat_id);
                                    $cat_list_ .= '<li > <i class="fa fa-check"></i> ' . $category->name . '</li>';
                                }
                                $cat_list_ .= '</ul></div>';
                                $single_pop_script .= 'jQuery(\'#' . $poped_over_id . '\').popover({
                                                            html: true,
                                                            content: function () {
                                                                return jQuery(\'.' . $poped_over . '\').html();
                                                            }
                                                        });';
                            }
                        }
                        if (isset($selected_categories_arr[0]) && $selected_categories_arr[0] == 'all') {
                            $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Categories ', 'adforest') . ': ' . __('All ', 'adforest') . '</span></li>';
                        } else {
                            $inner_html .= '<li class="mb-3"><span id="' . $poped_over_id . '" class="f_custom" data-bs-toggle="popover" data-placement="top" data-bs-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '">' . __('Categories ', 'adforest') . ': ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i> ' . $cat_list_ . '</span></li>';
                        }


                         if (get_post_meta($prod_id, 'number_of_events', true) != "") {
                        $package_allow_events = get_post_meta($prod_id, 'number_of_events', true);

                          if($package_allow_events  == "-1"){
                            
                             $package_allow_events  = __('Unlimited','adforest_theme');

                           }
                        $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Number of events ', 'adforest') . ': ' . $package_allow_events . '</span></li>';
                         }
                    }


                    $color_class = "standard-bg";
                    $btn_color = "btn-block-1";
                    $star_color = "pricing-icon-1";
                    $header_class = 'individual-pricing';
                    if ($count % 2 == 0) {
                        $color_class = "basic-packages";
                        $btn_color = "btn-block";
                        $star_color = "pricing-icon";
                        $header_class = "basic-pricing";
                    }


                    $html .= '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="card ' . $color_class . ' bg-pricing-content mb-5 mb-lg-0 rounded-lg shadow">
                    <div class="' . $header_class . '">
                        <div class="package-pricing">
                            <div class="' . $star_color . '">
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="pricing-pack-heading">
                                <h4>' . get_the_title($prod_id) . '</h4>    
                                    <h6 class="h1"> ' . adforest_product_price($product, 'modern') . '</h6>
                            </div>
                            
                              ' . adforest_sale_html($product, 'modern') . '
                         
                        </div>
                        
                    </div>
                    <div class="card-body bg-lighting">
                        <ul class="list-unstyled mb-4">
                        ' . $inner_html . '
                        </ul>
                        <a href="javascript:void(0);" class="btn  ' . $btn_color . ' sb_add_cart" data-product-id="' . $prod_id . '" data-product-qty="1">' . esc_html__('Add to Cart', 'adforest') . '<i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>';
                    $count++;
                }
            }
        }

        $scrtpt = '';
        if ($single_pop_script != '') {
            $scrtpt = '<script>jQuery(document).ready(function () { ' . $single_pop_script . ' });</script>';
        }
        // basic     
        return '' . $scrtpt . '<section class="content-pricing modern-new-pricing custom-padding  ' . $section_bg . '">
    <div class="container">
        <div class="sb-short-head center">
         <span>' . esc_html($section_tagline) . '</span>
           <h2>' .adforest_color_text($section_title). '</h2>
           <p> ' . $section_description . '</p>
       </div>
        <div class="row">
        ' . $html . '     
        </div>
    </div>
    </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('price_modern2_short_base', 'price_modern2_short_base_func');
}