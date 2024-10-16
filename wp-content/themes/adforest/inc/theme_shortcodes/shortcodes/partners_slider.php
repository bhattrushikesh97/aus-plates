<?php
/* ------------------------------------------------ */
/* About Us */
/* ------------------------------------------------ */
if (!function_exists('partners_sliders_short')) {

    function partners_sliders_short() {
        vc_map(array(
            "name" => __("Clients or Partners - Modern", 'adforest'),
            "base" => "partners_sliders_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('client-new-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),

                array
                    (
                    'group' => __('Clients', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Clients', 'adforest'),
                    'param_name' => 'clients',
                    'value' => '',
                    'params' => array
                        (
                    array(
                    "group" => __("Client Image", "adforest"),
                    "type" => "attach_image",
                     "holder" => "bg_img",
                    "heading" => __("large image", 'adforest'),
                    "param_name" => "logo",
                    "description" => "320x150",
                ),
                    array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Logo link", 'adforest'),
                    "param_name" => "link",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                   
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'partners_sliders_short');
if (!function_exists('partners_sliders_short_base_func')) {
    function partners_sliders_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'link'=>'',
                        ), $atts));
         extract($atts);         
         wp_enqueue_script('anime-slider');        
             if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = $atts['clients'];
                //$rows = apply_filters('adforest_validate_term_type', $rows);
            } else {
                $rows = vc_param_group_parse_atts($atts['clients']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }               
                    // print_r($rows);                    
        //$rows = vc_param_group_parse_atts($atts['clients']);
        $clients_html = '';     
        if (isset($rows) && is_array($rows)  && count($rows) > 0) {
            foreach ($rows as $row) {
               
                if(isset($adforest_elementor) && $adforest_elementor){
                    $logo_url   =   isset($row['logo']['url'])  ?  $row['logo']['url']   :  "#";
                }           
                else {   
                     $logo_url   =   isset($row['logo'])  ?  adforest_returnImgSrc($row['logo'])   :  "#";
                }
                if (isset($logo_url)) {
                    $link   =   isset($row['link']) ? $row['link']  : "#";
                    $clients_html .= '<li><a href="'.$link.'"><img src="'.$logo_url.'" alt="Black Ace"></a></li>';
                }
            }
        }
return   '<div class="client-adfor '.$section_bg.'">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div id="clients" class="clients">
                    <div class="clients-wrap">
                        <ul id="clients-list" class="clearfix clients-list">
                            '.$clients_html.'                      
                        </ul>
                    </div><!-- @end .clients-wrap -->
                </div><!-- @end #clients -->

            </div>
        </div>
    </div>
</div>';
    }
   
}
if (function_exists('adforest_add_code')) {
    adforest_add_code('partners_sliders_short_base', 'partners_sliders_short_base_func');
}  