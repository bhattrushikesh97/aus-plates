<?php

/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('grid_modern_type_short')) {

    function grid_modern_type_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'yes');

        vc_map(array(
            "name" => __("Cats , ads , sidebar", 'adforest'),
            "base" => "grid_modern_type_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('grid_modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Section Background", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                    __('White', 'adforest') =>  '',
                    __('Gray', 'adforest')=>   'bg-gray',
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
                    "heading" => __("Section Description /when cat section hidden", 'adforest'),
                    "param_name" => "section_desc",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Ads Section Title", 'adforest'),
                    "param_name" => "ads_section_title",
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Ads Type", 'adforest'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads Type', 'adforest') => '',
                        __('Featured Ads', 'adforest') => 'feature',
                        __('Simple Ads', 'adforest') => 'regular',
                        __('Both', 'adforest') => 'both'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Order By", 'adforest'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Ads order', 'adforest') => '',
                        __('Oldest', 'adforest') => 'asc',
                        __('Latest', 'adforest') => 'desc',
                        __('Random', 'adforest') => 'rand'
                    ),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Number fo Ads to display", 'adforest'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 500),
                ),
                array(
                    "group" => __("Ads Settings", "adforest"),
                    "type" => "vc_link",
                    "heading" => __("View all button link", 'adforest'),
                    "param_name" => "view_all",
                ),
                array
                    (
                    'group' => __('Categories for ads', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category ( Selective )', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        ($cat_array)
                ),
                 array(
                    "group" => __("Categories", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Show Category Section", 'adforest'),
                    "param_name" => "show_cat",
                    "admin_label" => true,
                    "value" => array(
                    __('Show', 'adforest' )=> 'show',
                    __('hide', 'adforest' )=> 'hide' ,
                    ),
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
                array(
                    "group" => __("Categories", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Category Section Title", 'adforest'),
                    "param_name" => "cat_section_title",
                ),
                array
                    (
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats_round',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            "group" => __("Basic", "adforest"),
                            "type" => "attach_image",
                            "holder" => "img",
                            "heading" => __("Category Image", 'adforest'),
                            "param_name" => "img",
                            "description" => __('100x100', 'adforest'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'grid_modern_type_short');
if (!function_exists('grid_modern_type_short_base_func')) {

    function grid_modern_type_short_base_func($atts, $content = '') {
          extract(shortcode_atts(array(
            'cat_section_title' => '',
            'cat_link_page' => '',
            'ads_section_title' => '',
            'cats' => '',
            'cats_round' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'view_all' => '',
            'section_bg' => '',
            'show_cat'=>'',
            'section_tagline'=>'',
             'section_title' =>'',
              'section_desc'=>'',
              'link_title'=>'',
                        ), $atts));
        extract($atts);
         
          $cats_array     =   array();      
          if (isset($adforest_elementor) && $adforest_elementor) {
                $cats_arr = isset($atts['cats']) ? $atts['cats'] : array();
            } else {
                $cats_arr = vc_param_group_parse_atts($atts['cats']);
                $cats_arr = apply_filters('adforest_validate_term_type', $cats_arr);
            }
        
        if (is_array($cats_arr)  &&  count($cats_arr) > 0) {
            foreach ($cats_arr as $cta_idd) {
                
                 if (isset($adforest_elementor) && $adforest_elementor) {
                        $cta_idd = $cta_idd;
                    } else {
                        $cta_idd = $cta_idd['cat'];
                    }
                
                if (isset($cta_idd)) {
                    if ($cta_idd != 'all') {
                        $cats_array[] = $cta_idd;
                    }
                }
            }
        }

       
        $category = '';
        if (count($cats_array) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => $cats_array,
                ),
            );
        }
        $is_feature = '';
         
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $is_active = array(
            'key' => '_adforest_ad_status_',
            'value' => 'active',
            'compare' => '=',
        );
        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        
        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
         $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                $is_feature,
                $is_active,
            ),
            'tax_query' => array(
                $category,
                $countries_location,
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
         $ads_html  =   "";
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $results = new \WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $function = "";

                $ads_html .= adforest_search_layout_list_5(get_the_ID(), false);
            }
        }
        wp_reset_postdata();
        
        ob_start();
        dynamic_sidebar('sb_themes_grid_sidebar');
        $sidebar = ob_get_contents();
        ob_end_clean();
        
        $cats_card   =  "";
        

        if($show_cat  !=  'hide'){                      
         $cats_round_html = '';  
          if (isset($atts['cats_round'])) {
               if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = ($atts['cats_round']);
            } else {
                $rows = vc_param_group_parse_atts($atts['cats_round']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }                   
            if (isset($rows) && !empty($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && $row['cat'] != "" && isset($row['img']) && $row['img'] != "") {
                        $term = get_term($row['cat'], 'ad_cats');
                        if ($term) {
                           if (isset($adforest_elementor) && $adforest_elementor) {
                                $bgImageURL = adforest_returnImgSrc($row['img']['id']);
                            }else{
                                $bgImageURL = adforest_returnImgSrc($row['img']);
                            }                                                     
                            $cat_link_page = isset($cat_link_page) ? $cat_link_page : '';                            
                            $cats_round_html .= '<div class="visited-content-items"><a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
						<div class="visited-state"><img alt="' . $term->name . '" src="' . esc_url($bgImageURL) . '" title="' . $term->name . '"></div><div class="state-heading"><h5>' . $term->name . '</h5></div></a></div>';
                        }
                    }
                }
            }     
            }          
             $cats_card   =  '<div class="visited-content">
					 <div class="col-md-12">
						<div class="visited-heading"><h2 class="main-title text-left">' . $cat_section_title . '  </h2></div>
						<div class="section-visited-content">' . $cats_round_html . '</div>
					</div>       
				 </div>';
             
             $ads_section_head    =   '<div class="visited-heading"><h2 class="main-title text-left">' . $section_title . '  </h2></div>';
            
             
             $ads_section_class  =    'ad-home-list';
        }
        
        else{
            
             $ads_section_head   =   '    <div class="sb-short-head">
                      <span>'. esc_html($section_tagline).'</span>
                    <h2>' . $section_title . '</h2>
                    <p>' . $section_desc . '</p>
                </div>';
                  
             $ads_section_class   =  '';        
        }
        
        
         
        $btn_html = '';
        if (isset($adforest_elementor) && $adforest_elementor) {
            $btn_args = array(
                'btn_key' => $view_all,
                'adforest_elementor' => $adforest_elementor,
                'btn_class' => 'btn btn-theme btn-block btn-white',
                'iconBefore' => '',
                'iconAfter' => '',
                'titleText' => $link_title,
            );

            $btn_html = apply_filters('adforest_elementor_url_field', $btn_html, $btn_args);
        } else {
            $btn_html = adforest_ThemeBtn($view_all, 'btn btn-theme btn-block btn-white', false);
        }

        

        return '<section class="gp-great-product  '.$section_bg.'">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    '.$cats_card.'  
                     <div class="'. esc_attr($ads_section_class).'">  
                     '.$ads_section_head.'
                     '.$ads_html.'
                         
					<div class="text-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="load-more-btn">' . $btn_html . '</div></div></div>
				 </div>  
                    </div>                
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                     <div class="ad_grid_sidebar">
                         '. $sidebar.'
                      </div>     
                    </div>           
                </div>
            </div>
        </section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('grid_modern_type_short_base', 'grid_modern_type_short_base_func');
}