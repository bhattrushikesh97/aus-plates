<?php
/* ------------------------------------------------ */
/* About Us */
/* ------------------------------------------------ */
if (!function_exists('partners_short')) {

    function partners_short() {
        vc_map(array(
            "name" => __("Clients", 'adforest'),
            "base" => "partners_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('about_us.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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

add_action('vc_before_init', 'partners_short');
if (!function_exists('partners_short_base_func')) {

    function partners_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            'link'=>'',
                        ), $atts));
         extract($atts);
        
         
       if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = $atts['clients'];
                //$rows = apply_filters('adforest_validate_term_type', $rows);
            } else {
                $rows = vc_param_group_parse_atts($atts['clients']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }
 
        $clients_html = '';
        if (is_array($rows)  && count($rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['logo'])) {                 
                    $bgImageURL = adforest_returnImgSrc($row['logo']);}
                    $link = 'javascript:void(0);';
                    if (isset($row['link']))
                        $link = esc_url($row['link']);    
                    
                        if(isset($adforest_elementor) &&  $adforest_elementor ){
                        $logo_url = isset($row['logo']['url'])    ? $row['logo']['url']   : "#"  ; 
                        
                        }                            
                        else {
                            $logo_url = isset($row['logo'])    ? adforest_returnImgSrc($row['logo'])   : "#"  ; 
                        }
                    $clients_html .= '<div class="sigle-clients-brand">
                           <a href="' . $link . '" target="_blank">
						   <img src="' . $logo_url . '" alt="' . __('logo', 'adforest') . '">
						   </a>
                        </div>';
                }
            }
        
        return  '<div class="happy-clients-area pistachio-client-happy  fix ' . $section_bg . '">
            <div class="container">
               <div class="row clients-space">		   	
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <div class="client-brand-list">
					 	' . $clients_html . '
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 ';
    }
   
}


if (function_exists('adforest_add_code')) {
    adforest_add_code('partners_short_base', 'partners_short_base_func');
}  