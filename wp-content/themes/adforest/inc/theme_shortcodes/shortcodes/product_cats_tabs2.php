<?php

/* ------------------------------------------------ */
/* Shop Modern 5 */
/* ------------------------------------------------ */
if (!function_exists('products_cats_tabs2_data_shortcode2')) {

    function products_cats_tabs2_data_shortcode2($term_type = 'ad_country') {
        $result = array();
        if (!is_admin()) {
            return $result;
        }

        $args = array('hide_empty' => 0);
        $args = apply_filters('adforest_wpml_show_all_posts', $args); // for all lang texonomies
        $terms = get_terms($term_type, $args);

        if ($terms && !is_wp_error($terms)) {
            if (count($terms) > 0) {
                foreach ($terms as $term) {
                    $result[] = array('value' => $term->slug, 'label' => $term->name,);
                }
            }
        }

        return $result;
    }

}
if (!function_exists('products_cats_tabs25_short')) {

    function products_cats_tabs25_short() {
        vc_map(array(
            "name" => __("Product cats tabs 2", 'adforest'),
            "base" => "products_cats_tabs25_short_base",
            "category" => __("Theme Shortcodes - 2", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('shop-layout5.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "group" => __("Products Setting", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Select Number of Product", 'adforest'),
                    "param_name" => "max_limit",
                    "value" => range(1, 1000),
                ),
                array
                    (
                    'group' => __('Products Setting', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Product Categories", 'adforest'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => products_cats_tabs2_data_shortcode2('product_cat'),
                            "description" => __("Remove All categories to show products from all categories.", "adforest"),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'products_cats_tabs25_short');
if (!function_exists('products_cats_tabs25_short_base_func')) {

    function products_cats_tabs25_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_title' => '',
            'banner_img' => '',
            'banner_postion' => '',
            'woo_products' => '',
            'max_limit' => '',
                        ), $atts));
        
        extract($atts);

        $section_title = isset($atts['section_title']) ? $atts['section_title'] : '';
        $max_limit = isset($atts['max_limit']) ? $atts['max_limit'] : 5;
     
        $cat_menu_html = "";
        $cat_posts_html = "";
        
        
        if (isset($adforest_elementor) && $adforest_elementor) {
            $woo_products = ($atts['woo_products']);
        } else {
            $woo_products = vc_param_group_parse_atts($atts['woo_products']);
        }
        if (is_array($woo_products) && !empty($woo_products)) {
            $count = 1;
            foreach ($woo_products as $woo_product) {
                $rand = "check-" . rand();
                $is_active_tab = '';       
                if (isset($adforest_elementor) && $adforest_elementor) {
                    $woo_product = $woo_product;
                } else {
                    $woo_product = $woo_product['product'];
                }
                $category_obj = get_term_by('slug', $woo_product, 'product_cat');
                $categ_id = isset($category_obj->term_id) ? $category_obj->term_id : '';
                $categ_slug = isset($category_obj->slug) ? $category_obj->slug : '';
                $categ_name = isset($category_obj->name) ? $category_obj->name : '';
                $categ_count = isset($category_obj->count) ? $category_obj->count : 0;

                if ($categ_id != '' && $categ_count > 0) {
                    $is_active_tab = $is_active_desc = '';
                    if ($count == 1) {
                        $is_active_tab = 'active';
                        $is_active_desc = 'in active';
                    }
                    $count = $count + 1;
                    /* creating tabs */
                    $cat_menu_html .= '<li class="nav-item" role="presentation">
                                          <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#' . $rand . '" role="tab" aria-controls="' . $rand . '" aria-selected="false">' . $categ_name . '</a>
                                        </li>';
                    /* creating product grids */ 
                    $cat_posts_html .= ' <div class="tab-pane fade show ' . $is_active_tab . '" id="' . $rand . '" role="tabpanel" aria-labelledby="home-tab"><div class="owl-carousel1 products_tabs_slider_full staff-list">';
                    $cat_posts_html .=   get_products_by_category($categ_id, $max_limit, 'term_id' );
                    $cat_posts_html .= '</div></div>';
                }
            }
        }
        return  '<section class="latest-product  product_slider_2">
    <div class="container">
        <div class="row">       
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="latest-product-heading">
                <div class="heading-latest">
                    <h4>'.$section_title.'</h4>
                </div>
                <ul class="product-items nav"   role="tablist">
                    '.$cat_menu_html.'
                </ul>
            </div>
            <div class="tab-content">
                '.$cat_posts_html.'
                </div>    
            </div>         
        </div>
    </div>
</section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('products_cats_tabs25_short_base', 'products_cats_tabs25_short_base_func');
}