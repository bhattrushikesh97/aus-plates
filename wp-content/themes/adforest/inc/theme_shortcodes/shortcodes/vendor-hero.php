<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('vendor_hero_1_short')) {

    function vendor_hero_1_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat');

        vc_map(array(
            "name" => __("Adforest - Vendor Hero", 'adforest'),
            "base" => "vendor_hero_1_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Signature image", 'adforest'),
                    "param_name" => "slider_signature_image",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Product Title", 'adforest'),
                    "param_name" => "product_title",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Product Reguler price", 'adforest'),
                    "param_name" => "product_reg_prie",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Product Sale Price", 'adforest'),
                    "param_name" => "product_sale_price",
                ),
                array(
                    "group" => __("About Us", "adforest"),
                    "type" => "vc_link",
                    "heading" => __("Read More Link", 'adforest'),
                    "param_name" => "main_link",
                    "description" => __("Read more Link if any.", "adforest"),
                ),
             
         
                    array(
                    'group' => __('woo products', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Products', 'adforest'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Product", 'adforest'),
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

add_action('vc_before_init', 'vendor_hero_1_short');
if (!function_exists('vendor_hero_1_short_base_func')) {

    function vendor_hero_1_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'slider_signature_image' => '',
            'product_title' => '',
            'product_reg_prie' => '',
            'product_sale_price' => '',
            'link_title' => '',
            'main_link' => '',
            'woo_products' => '',
            'woo_product'=>''
                        ), $atts));
        extract($atts);

       $add_sport_btn = "";
          if (isset($adforest_elementor) && $adforest_elementor) {
        if ($atts['link_title'] != '' && $atts['main_link'] != '') {
            $btn_args = array(
                'btn_key' => $atts['main_link'],
                'adforest_elementor' => true,
                'btn_class' => 'btn btn-theme text-center',
                'iconBefore' => '',
                'iconAfter' => '',
                'titleText' => $atts['link_title'],
            );
            $add_sport_btn = apply_filters('adforest_elementor_url_field', '', $btn_args);
        }
          }    
          else  {
              $add_sport_btn = adforest_ThemeBtn($main_link, '', false);
          }
    
            if (isset($adforest_elementor) && $adforest_elementor) {
                $woo_products = ($atts['woo_products']);
            } else {
                $woo_products = vc_param_group_parse_atts($atts['woo_products']);
            }
        $product_slider   =  "";
        if (is_array($woo_products) && !empty($woo_products) && function_exists('wc_get_product')) {
            foreach ($woo_products as $product_id ) {    

            if (isset($adforest_elementor) && $adforest_elementor) {
                $product_id = $product_id;
            } else {
                $product_id = $product_id['woo_products'];
            }
                $product = wc_get_product($product_id);
                $prod_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'shop_thumbnail');
                $prod_img_html = '';
                if (isset($prod_image_src) && is_array($prod_image_src)) {
                    $prod_img_html = '<a href='.get_the_permalink($product_id).'><img src="' . $prod_image_src[0] . '" alt="' . get_the_title($product_id) . '" class="img-fluid"/></a>';
                } 
                
                $category   =                 
                $product_categories = wp_get_post_terms( $product_id , 'product_cat' );                
                $category_name  = isset($product_categories[0]->name)  ? '<a href="'.get_term_link($product_categories[0]->term_id).'"><span>'.$product_categories[0]->name.'</span></a>' : "";
                $product_slider .= '<div class="item">
                                    <div class="salemain-heading-img">
                                        <div class="shoes-img">
                                            '.$prod_img_html.'
                                        </div>
                                        <div class="shoes-heading">
                                            '.$category_name.'
                                           <h2>'. get_the_title($product_id).'</h2>
                                            <a href="'. get_the_permalink($product_id).'"> '. esc_html__('Shop Now','adforest').' <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>';
            }
        }
        
        $style = '';
        if (isset($bg_img) &&  $bg_img != "") {
            $bgImageURL = adforest_returnImgSrc($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover "' : "";
        }
        
        

         if (isset($adforest_elementor) && $adforest_elementor) {
        $signature_image = isset($atts['slider_signature_image']['url']) ? $atts['slider_signature_image']['url'] : "";
          }
          
          else{
              $signature_image   =  isset($atts['slider_signature_image']) ? adforest_returnImgSrc($atts['slider_signature_image']) : '#';
          }
        
        return 
        '<div id="carousel-example" class="carousel slide" data-ride="carousel"  '.$style.'>
    <div class="carousel-inner">
        <div class="item active main-img" style="color: rgb(0, 0, 0);">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="nike-heading">
                            <img src=" ' . esc_url($signature_image) . '" alt="' . esc_html__('Signature image', 'adforest_elementor') . '">
                            <h1>' . $product_title . '</h1>
                            <h4><span class="dele">' . $product_reg_prie . '</span>' . $product_sale_price . '</h4>
                            ' . $add_sport_btn . '
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="cover-wrapper">
                            <div id="hero_product_slider" class="owl-carousel2">
                                                       
                             ' . $product_slider . '
                       </div>
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
    adforest_add_code('vendor_hero_1_short_base', 'vendor_hero_1_short_base_func');
}