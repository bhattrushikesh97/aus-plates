<?php

/* ------------------------------------------------ */
/* About Us */
/* ------------------------------------------------ */
if (!function_exists('vendro_grid')) {

    function vendro_grid() {
        vc_map(array(
            "name" => __("Vendor Grid", 'adforest'),
            "base" => "vendor_grid_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('vendor-grid.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Products Setting", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Category title", 'adforest'),
                    "param_name" => "section_title_category",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Vendors Settings", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("vendor section title", 'adforest'),
                    "param_name" => "section_title_vendor",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Vendors Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Vendors", 'adforest'),
                    "param_name" => "no_of_vendors",
                    "admin_label" => true,
                    "value" => range(1, 500),
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
                            "value" => products_cats_tabs_data_shortcode2('product_cat'),
                            "description" => __("Remove All categories to show products from all categories.", "adforest"),
                        ),
                    )
                ),
            )
        ));
    }

}

add_action('vc_before_init', 'vendro_grid');

if (!function_exists('vendro_grid_base_func')) {

    function vendro_grid_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_title_vendor' => '',
            'woo_products' => '',
            'section_title_category' => '',
            'no_of_vendors' => '',
            'no_of_vendors' => '',
            'no_of_vendors' => '',
                        ), $atts));

        extract($atts);

        $no_of_vendors = isset($atts['no_of_vendors']) ? $atts['no_of_vendors'] : 6;

        if (isset($adforest_elementor) && $adforest_elementor) {
            $categories = isset($atts['woo_products'])  ? $atts['woo_products'] : array() ;
        } else {
            $categories = vc_param_group_parse_atts($atts['woo_products']);
        }


        $vendors_grid = "";
        global $WCMp;
        $vendors_id = get_users(
                array(
                    'fields' => 'ids',
                    'role' => 'dc_vendor',
                )
        );
        if (function_exists('adforest_all_vendors_style1')) {
            $vendors_grid = adforest_all_vendors_style1($vendors_id, $no_of_vendors);
        }
        $category_list = "";
        if (!empty($categories)) {
            foreach ($categories as $cat_slug) {

                if (isset($adforest_elementor) && $adforest_elementor) {
                    $cat_slug = $cat_slug;
                } else {
                    $cat_slug = isset($cat_slug['product'])  ? $cat_slug['product']  : "" ;
                }
                $cat_obj = get_term_by('slug', $cat_slug, 'product_cat');

                if(isset($cat_obj->term_id)){
                    
                   
             

                $category_image_id = get_term_meta($cat_obj->term_id, 'thumbnail_id', true);
                $image_arr = "";
                if ($category_image_id != 0) {
                    $image_arr = wp_get_attachment_image_src($category_image_id);
                    $image_arr = isset($image_arr[0]) ? $image_arr[0] : "";
                }

                $category_list .= '<li class="list-group-item">
               <ul class="child-list-item">
                 <li><div class="furnit-item">

                  <img src="' . $image_arr . '" alt="' . esc_html__('img', 'adforest') . '">
                      
                  </div><a href="'.get_term_link($cat_obj->term_id).'"><span class="span-furniture">' . $cat_obj->name . '</span></a></li>
                 <li><button class="btn-ads">' . $cat_obj->count . '</button></li>
              </ul>
           </li>';
        }
            }
        }
        echo '<section class="multi-vendor">
<div class="container">
<div class="row">
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
  <div class="multi-vendor-heading">
    <h4>' . $section_title_vendor . '</h4>
  </div>
  <div class= "vendor-grid">
  <div class="row"> 
  ' . $vendors_grid . '
      </div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
  <div class="card categories">
    <div class="card-header main-categories">' . $section_title_category . '</div>
    <ul class="list-group list-group-flush">
     
    ' . $category_list . '
    </ul>
  </div>

</div>
</div>  
</div>
<div></div></section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('vendor_grid_short_base', 'vendro_grid_base_func');
}