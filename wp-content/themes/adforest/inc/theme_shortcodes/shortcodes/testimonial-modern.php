<?php
/* ------------------------------------------------ */
/* adf_testimonial_modern */
/* ------------------------------------------------ */
if (!function_exists('adf_testimonial_modern_shortcodeBase')) {

    function adf_testimonial_modern_shortcodeBase() {
        vc_map(array(
            'name' => __("Testimonials - Modern", 'adforest'),
            'base' => 'adf_testimonial_modern',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('test-new-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "param_name" => "section_desc",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                    (
                    'group' => __("Point's", 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select points under description.', 'adforest'),
                    'param_name' => 'points',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Title', 'adforest'),
                            'param_name' => 'title',
                        ),
                        
                          array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Designation', 'adforest'),
                            'param_name' => 'designation',
                        ),    
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Description', 'adforest'),
                            'param_name' => 'desc',
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Stars", 'adforest'),
                            "param_name" => "stars",
                            "admin_label" => true,
                            "value" => array(
                                __('Select Option', 'adforest') => '',
                                __('1', 'adforest') => '1',
                                __('2', 'adforest') => '2',
                                __('3', 'adforest') => '3',
                                __('4', 'adforest') => '4',
                                __('5', 'adforest') => '5',
                            ),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                            "std" => '',
                            "description" => __("Select stars", 'adforest'),
                        ),
                        array(
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'heading' => __('Side Image', 'adforest'),
                            'param_name' => 'img',
                            'description' => __('Section side image', 'adforest'),
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}
add_action('vc_before_init', 'adf_testimonial_modern_shortcodeBase');
if (!function_exists('adf_testimonial_modern_func')) {

    function adf_testimonial_modern_func($atts, $content = '') {
        // Attributes
        extract(shortcode_atts(array(
            'points' => '', 
            'section_bg' => '', 
            'section_tagline'=>'',
            'section_title' =>'',
            'section_desc'=>'',
            'designation'=>''), $atts));

        extract($atts);

        // basic
          
        $points_rows    =  array();   
        if (isset($adforest_elementor) && $adforest_elementor) {
                $points_rows = ($atts['points_test']);
            } else {
                $points_rows = vc_param_group_parse_atts($atts['points']);
            }

        $inner_html = "";
        if (is_array($points_rows) && !empty($points_rows)) {
            foreach ($points_rows as $row) {
                if (isset($row['title'])) {
                    if (isset($adforest_elementor) && $adforest_elementor) {
                            $image_url = ( isset($row['img']['id']) ) ? adforest_returnImgSrc($row['img']['id']) : '';
                        } else {
                            $image_url = ( isset($row['img']) ) ? adforest_returnImgSrc($row['img']) : '';
                        }
                    $stars = ( isset($row['stars']) && $row['stars'] != "" ) ? (int) $row['stars'] : 0;
                    $title = ( isset($row['title']) ) ? '<h5>' . $row['title'] . "</h5>" : '';
                    $desc = ( isset($row['desc']) ) ? "<p>" . $row['desc'] . "</p>" : '';
                    $designation = ( isset($row['designation']) ) ? "<span>" . $row['designation'] . "</span>" : '';
                    $stars_html = '';
                    for ($i = 1; $i <= $stars; $i++) {
                        $stars_html .= '<i class="fa fa-star color1"></i>';
                    }


                    $inner_html .= '      <div class="testimonial-product">
        <div class="main-card-content">
         <img src="' . get_template_directory_uri() . '/images/color-circle.png " alt="' . esc_attr__('img', 'adforest') . '"/>
        
        </div>
        <div class="testimonial-product-listing"> 
          <img src="' . $image_url . '" alt="' . esc_attr__('img', 'adforest') . '"/>
              ' . $title . '
              ' . $designation . '
              ' . $desc . '
          <div class="listing-ratings">
           <span class="ratings"> 
            ' . $stars_html . '
         </span>
       </div>
         </div>
      </div>';
                }
            }
        }
        return '<section class="client-say  ' . $section_bg . '">
  <div class="container">
  <div class="new-testi-item">
   <div class="row">
     <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="client-heading">
        <span>' . $section_tagline . '</span>
          <h2>' . $section_title . '</h2>
      <p>' . $section_desc . '</p>
      </div>
      </div>
     <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="owl-carousel2  client-item">
     ' . $inner_html . '
     </div>
   </div>
  </div>
</div>
    </div>
    <input  value="' . get_template_directory_uri() . '/images/testimonial.png" type="hidden"  id="testimonial_img">
  </section>
  ';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('adf_testimonial_modern', 'adf_testimonial_modern_func');
}