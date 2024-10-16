<?php

/* ------------------------------------------------ */
/* Select Product */
/* ------------------------------------------------ */
if (!function_exists('select_product_short')) {

    function select_product_short() {
        vc_map(array(
            "name" => __("Product with Bg", 'adforest'),
            "base" => "select_product_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('select_product.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    "description" => __("1280x480", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Tagline", 'adforest'),
                    "param_name" => "section_tag_line",
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
                    "type" => "vc_link",
                    "holder" => "div",
                    "heading" => __("Button Title & Link", 'adforest'),
                    "param_name" => "view_all",
                ),
                array
                    (
                    'group' => __('Products', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select product', 'adforest'),
                    'param_name' => 'one_product',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "holder" => "div",
                            "heading" => __("Product", 'adforest'),
                            "param_name" => "product",
                            "value" => adforest_get_products()
                        ),
                    )
                ),
                array
                    (
                    'group' => __('Key Points', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'points',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => __("Point", 'adforest'),
                            "param_name" => "title",
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'select_product_short');
if (!function_exists('select_product_short_base_func')) {

    function select_product_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'bg_img' => '',
            'section_title' => '',
            'section_tag_line' => '',
            'one_product' => '',
            'link' => '',
            'view_all' => '',
            'points' => '',
                        ), $atts));
        extract($atts);

        global $adforest_theme;
        $allow_arr = array(
            'no' => __('No', 'adforest'),
            'yes' => __('Yes', 'adforest'),
        );

        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = ($atts['points']);
        } else {
            $rows = vc_param_group_parse_atts($atts['points']);
        }


        $btn_html = '';
        if (isset($adforest_elementor) && $adforest_elementor) {
            $btn_args = array(
                'btn_key' => $link,
                'adforest_elementor' => true,
                'btn_class' => 'btn btn-lg btn-theme',
                'iconBefore' => '<i class="fa fa-refresh"></i>',
                'iconAfter' => '',
                'titleText' => $link_title,
            );
            $btn_html = apply_filters('adforest_elementor_url_field', $btn_html, $btn_args);
        } else {
            $btn_html = adforest_ThemeBtn($view_all, 'btn btn-lg btn-theme', false, '', '');
        }

        $style = '';
        if ($bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $point_html = '';
        if (count($rows) > 0) {
            $point_html .= '<ul>';
            foreach ($rows as $row) {
                if (isset($row['title'])) {
                    $point_html .= '<li>' . $row['title'] . '</li>';
                }
            }
            $point_html .= '</ul>';
        }

        $inner_html = '';
        $product_html = '';

        $price = '';
        $single_pop_script = '';

        $rows = isset($one_product) ? $one_product : array();

        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = $one_product;
        } else {
            $rows = vc_param_group_parse_atts($one_product);
        }

        $product_html = '';
        if (is_array($rows) && !empty($rows)) {
            $inner_html = '';
            $count = 0;
            foreach ($rows as $row) {
                
                
                  if (isset($adforest_elementor) && $adforest_elementor) {
                    $prod_id = $row;
                } else {
                    $prod_id = $row['product'];
                }
                $product_satus = get_post_status($prod_id);
                if ($product_satus == false || $product_satus != 'publish') {
                    return;
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


                if(class_exists('SbPro')){

                  
                if (get_post_meta($prod_id, 'number_of_events', true) == "-1") {
                    $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Number of events', 'adforest') . ': ' . __('Unlimited', 'adforest') . '</span></li>';
                } else if (get_post_meta($prod_id, 'number_of_events', true) != "") {
                    $inner_html .= '<li class="mb-3"><span class="f_custom"><i class="fa fa-check text-success"></i>' . __('Number of events', 'adforest') . ': ' . get_post_meta($prod_id, 'number_of_events', true) . ' ' . __('Days', 'adforest') . '</span></li>';
                }
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
                        $inner_html .= '<li class="mb-3"><span id="' . $poped_over_id . '" class="f_custom" data-toggle="popover" data-placement="top" data-toggle="popover" title="' . __('Allowed Categories ', 'adforest') . '">' . __('Categories ', 'adforest') . ': ' . __('See All ', 'adforest') . '<i class="fa fa-question-circle"></i> ' . $cat_list_ . '</span></li>';
                    }

                     if (get_post_meta($prod_id, 'number_of_events', true) != "") {
                        $package_allow_events = get_post_meta($prod_id, 'number_of_events', true);
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


              //$sb_prod_price = sb_product_currency($sb_regular_price, 'span', 'dollartext');
                
                 $thousands_sep = ",";
        if (isset($adforest_theme['sb_price_separator']) && $adforest_theme['sb_price_separator'] != '') {
            $thousands_sep = $adforest_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($adforest_theme['sb_price_decimals']) && $adforest_theme['sb_price_decimals'] != '') {
            $decimals = $adforest_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($adforest_theme['sb_price_decimals_separator']) && $adforest_theme['sb_price_decimals_separator'] != '') {
            $decimals_separator = $adforest_theme['sb_price_decimals_separator'];
        }
               $sb_regular_price = $product->get_regular_price();
    $sb_sale_price = $product->get_sale_price();


     $sb_regular_price = number_format((float) $sb_regular_price, $decimals, $decimals_separator, $thousands_sep);
    $sb_sale_price = number_format((float) $sb_sale_price, $decimals, $decimals_separator, $thousands_sep);

     $sb_prod_price = sb_product_currency($sb_regular_price, 'span', 'dollartext');
             if ($product->is_on_sale()) {
                   $sb_prod_price = sb_product_currency($sb_sale_price, 'span', 'dollartext') . '<small class="sale-value"><del>' . sb_product_currency($sb_regular_price) . '</del></small>';
                }

                $product_html .= ' <div class="col-xxl-6 col-lg-6 col-md-6 col-sm-12">
                                 <div class="card ' . esc_attr($color_class) . ' bg-pricing-content mb-5 mb-lg-0 rounded-lg shadow">
                               <div class="' . esc_attr($header_class) . '">
                                   <div class="package-pricing">
                                       <div class="' . esc_attr($star_color) . '">
                                           <i class="fa fa-star"></i>                                       
                                       </div>
                                   <div class="pricing-pack-heading">
                                        <h4><strong>' . (get_the_title($prod_id)) . '</strong></h4>
                                        <h6 class="h1">' .   $sb_prod_price  . '</h6>
                                   </div>   
                               </div>
                             </div>  
                               <div class="card-body bg-lighting"> 
                                   <ul class="list-unstyled mb-4">
                                       ' . $inner_html . '
                                   </ul>
                                    <a href="javascript:void(0);" class="btn  ' . esc_attr($btn_color) . ' sb_add_cart" data-product-id="' . $prod_id . '" data-product-qty="1">' . __('Add to Cart', 'adforest') . ' <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>                 
                             </div>
                            </div></div> ';

                $count++;
            }
        }

        $scrtpt = '';
        if ($single_pop_script != '') {
            $scrtpt = '<script>jQuery(document).ready(function () { ' . $single_pop_script . ' });</script>';
        }
        return $scrtpt . '<section class="morden-pricing pistachio-classified-pricing parallex for-modern-type"  ' . $style . '>
            <div class="container">
               <div class="row">
                  <div class="col-lg-4  col-md-12 col-sm-12">
                     <div class="app-text-section">
                        <span>' . esc_html($section_tag_line) . '</span>
                        <h3>' . esc_html($section_title) . '</h3>
                            ' . $point_html . '
                            ' . $btn_html . '
                     </div>
                  </div>
                  <div class="col-lg-8 col-md-12 col-sm-12 no-padding">
                    <div class="pistachio-content-section">
                        <div class="row">            
                        ' . $product_html . '
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>';
    }

}



if (function_exists('adforest_add_code')) {
    adforest_add_code('select_product_short_base', 'select_product_short_base_func');
}