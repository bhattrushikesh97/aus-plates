<?php

/* ------------------------------------------------ */
/* Faq */
/* ------------------------------------------------ */
if (!function_exists('faq_short')) {

    function faq_short() {
        vc_map(array(
            "name" => __("FAQ", 'adforest'),
            "base" => "faq_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('faq.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array
                    (
                    'group' => __('FAQ', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Question & Answer', 'adforest'),
                    'param_name' => 'cats_faq',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "heading" => __("Question", 'adforest'),
                            "param_name" => "title",
                            "admin_label" => true,
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => __("Answer", 'adforest'),
                            "param_name" => "description",
                            "admin_label" => true,
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'faq_short');
if (!function_exists('faq_short_base_func')) {

    function faq_short_base_func($atts, $content = '') {
        global $adforest_theme;
        
         extract(shortcode_atts(array(
            'section_tagline'=>'',
            'section_title' =>'',
            'section_description'=>'',
            'cats_faq'=>''
                        ), $atts));
        extract($atts);


        if (isset($adforest_elementor) && $adforest_elementor) {
            $rows = ($atts['cats_faq']);
        } else {
            $rows = vc_param_group_parse_atts($atts['cats_faq']);
        }

          
        $faq_html = '';
        if (is_array($rows) && count($rows) > 0) {
            $faq_html .= '<ul class="accordion">';
            foreach ($rows as $row) {
                if (isset($row['title']) && isset($row['description'])) {
                    $rand   =  rand(1,100);
                    $faq_html .= '<li>
                           <h3 class="accordion-title faq-titlle"><a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapse-'.$rand.'" aria-expanded="true" aria-controls="collapse-'.$rand.'">' . esc_html($row['title']) . '</a></h3>
                           <div  id="collapse-'.$rand.'" class="accordion-content panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                              <p>' . esc_html($row['description']) . '</p>
                           </div>
                        </li>';
                }
            }
            $faq_html .= '</ul>';
        }
        echo  '<section class="custom-padding faqs-section '.$section_bg.' ">
            <div class="container">
             <div class="sb-short-head center">
                           <span>'. esc_html($section_tagline).'</span>
                           <h2>'.$section_title.'</h2>
                           <p> '.$section_description.'</p>
                         </div>
               <div class="row">
                  
                  <div class="col-md-12 col-xs-12 col-sm-12">
                    ' . $faq_html . '
                  </div>
              </div>
          </div>
       </section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('faq_short_base', 'faq_short_base_func');
}