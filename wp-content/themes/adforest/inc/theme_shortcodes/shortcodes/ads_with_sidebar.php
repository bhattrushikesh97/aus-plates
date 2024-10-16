<?php
/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('ads_with_sidebar')) {
    function ads_with_sidebar() {
        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');
        vc_map(array(
            "name" => __("Ads With sidebar", 'adforest'),
            "base" => "ads_with_sidebar_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('grid_modern.png') . __('output of the shortcode will be look like this.', 'adforest'),
                ),
               array(
                    "group" => __("Background", "adforest"),
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
                    "group" => __("Background", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Show Sidebar", 'adforest'),
                    "param_name" => "show_sidebar",
                    "admin_label" => true,
                    "value" => array(
                    __('Yes', 'adforest') =>  'yes',
                    __('No', 'adforest')=>   'no',
                    ),
                ),
                
                 array
                    (
                    'group' => __('Ads setings', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Ads settings', 'adforest'),
                    'param_name' => 'ads_data',
                    'value' => '',
                    'params' => array (
                        
                        
                        array(
                  
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section tagline", 'adforest'),
                    "param_name" => "section_tagline",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                  
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                   
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description /when cat section hidden", 'adforest'),
                    "param_name" => "section_desc",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
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
                    "param_name" => "main_link",
                ),
                        
                   array(
                    "group" => __("Map", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Banner image", 'adforest'),
                    "param_name" => "banner",
                    "description" => __("870x330", 'adforest'),
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
                        )),
              
            ),
        ));
    }

}

add_action('vc_before_init', 'ads_with_sidebar');
if (!function_exists('ads_with_sidebar_base_func')) {

    function ads_with_sidebar_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'main_link' => '',
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_desc' => '',
            'link_title' => '',
            'main_link' => '',
            'adforest_elementor' => '',
            'show_sidebar' =>'',
            'ads_data'=>'',
             'banner'=>''
                        ), $atts));
        extract($atts);

      $section_html   =  '';
      
      
        if (isset($adforest_elementor) && $adforest_elementor) {
                $ads_data = ($atts['ads_data']);
            } else {
                $ads_data = vc_param_group_parse_atts($atts['ads_data']);
            }
      
      


     if(isset($ads_data) && is_array($ads_data)){
       foreach ($ads_data as $ad_data) {           
          if (isset($adforest_elementor) && $adforest_elementor) {
                $cats_arr = isset($ad_data['cats'])  ? $ad_data['cats'] : "" ;
            } else {
                $cats_arr = vc_param_group_parse_atts($ad_data['cats']);
            }
        
        $cats_array = array();
        if (is_array($cats_arr) && count($cats_arr) > 0) {
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
        $ad_type    =   isset($ad_data['ad_type'])  ? $ad_data['ad_type'] : "";
        $ad_order    =   isset($ad_data['ad_order'])  ? $ad_data['ad_order'] : "";
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

       $order_by    =   isset($ad_data['order_by'])  ? $ad_data['order_by'] : "";
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
        $no_of_ads     =     isset($ad_data['no_of_ads'])  ? $ad_data['no_of_ads'] : 10;   
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
         
        $section_tagline    =   isset($ad_data['section_tagline'])  ? $ad_data['section_tagline'] : "";
        $section_title    =   isset($ad_data['section_title'])  ? $ad_data['section_title'] : "";
        $section_desc    =   isset($ad_data['section_desc'])  ? $ad_data['section_desc'] : "";
        $button_text    =   isset($ad_data['link_title'])  ? $ad_data['link_title'] : "";
        $button_link    =   isset($ad_data['view_all'])  ? $ad_data['view_all'] : "";   
        $main_link    =   isset($ad_data['main_link'])  ? $ad_data['main_link'] : "";  
        $link_attr = '';
        
        
        
         if (isset($adforest_elementor) && $adforest_elementor) {
            $btn_args = array(
                        'btn_key' => $button_link,
                        'adforest_elementor' => true,
                        'btn_class' => 'btn btn-theme',
                        'iconBefore' => '',
                        'iconAfter' => '',
                        'onlyAttr' => false,
                        'titleText' =>  $button_text,
                        );
         $view_all_button = apply_filters('adforest_elementor_url_field', "", $btn_args);
         
         }
         else {
                $view_all_button = adforest_ThemeBtn($main_link, 'btn btn-theme', false);
         }
         
        
     
         $ads_section_head = '    <div class="sb-short-head">
                     <span>' . esc_html($section_tagline) . '</span>
                      <h2>' . $section_title . '</h2>
                    <p>' . $section_desc . '</p>
                    '.$view_all_button.'
               </div>';  


        $ads_html = "";
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $results = new \WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                 $function = "";              
               $ads_html .= '             
                          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12"> 
                            '.adforest_search_layout_grid_2(get_the_ID()).'
                          </div>';
                }
                 wp_reset_postdata();
             }
             $banner_img    =  "";

              if (isset($adforest_elementor) && $adforest_elementor) {
             if(isset($ad_data['banner']['url'])){
                $banner_img   =  '<img src ="'.$ad_data['banner']['url'].'" alt = '.esc_html__('img','adforest').'>';
                }  
             }
             else {
                 if(isset($ad_data['banner'])){   
                     $banner_img   =  '<img src ="'.adforest_returnImgSrc($ad_data['banner']).'" alt = '.esc_html__('img','adforest').'>';
                 }                 
             }

             $section_html .=    '<div class="ad-home-list">  
                                       '.$ads_section_head.'                             
                                        <div class="row">
                                           '.$ads_html.'
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                             '.$banner_img .'
                                              </div>
                                        </div>    
                                    </div>';
       }
     } 
     
          $section_class   =  "";
          $sidebar   =  "";          
          if($show_sidebar != 'no'){
             ob_start();
             dynamic_sidebar('sb_themes_grid_sidebar');
             $sidebar = ob_get_contents();
            $sidebar   = '<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                 '. $sidebar.'
                         </div> ';
             ob_end_clean();  
             
          }
               
$ads_section_class = '';
$banner_img   =   isset($banner['url'])   ?  $banner['url']  : "";
echo  
'<section class="gp-great-product ads-with-sidebar '.$section_bg.'  ">
    <div class="container">
        <div class="row"> 
            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12">
                      '.$section_html.'
                    </div>
                 '.$sidebar.'  
        </div>
    </div>
</section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ads_with_sidebar_base', 'ads_with_sidebar_base_func');
}