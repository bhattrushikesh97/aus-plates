<?php

/* ------------------------------------------------ */
/* services on vendor page */
/* ------------------------------------------------ */
add_action('vc_before_init', 'adforest_vendor_services_shortcode');
if (!function_exists('adforest_vendor_services_shortcode')) {

    function adforest_vendor_services_shortcode() {
        vc_map(array(
            'name' => __('Vendor Services', 'adforest'),
            'description' => '',
            'base' => 'vendor_services',
            'show_settings_on_create' => true,
            'category' => __('Theme Shortcodes - 2', 'adforest'),
            'params' => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('vendor-service.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),       
                array
                    (
                    'group' => __('Services', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Services', 'adforest'),
                    'param_name' => 'vendor_services',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "group" => __("Services", "adforest"),
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Section Title", 'adforest'),
                            "param_name" => "vservice_title",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "group" => __("Services", "adforest"),
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Section Description", 'adforest'),
                            "param_name" => "vservice_desc",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "group" => __("Icon Image", "adforest"),
                            'type' => 'attach_image',
                            'holder' => 'div',
                            'class' => '',
                            'admin_label' => true,
                            'param_name' => 'vservice_icon_img',
                            'description' => __('Put Icon Image by size 42x28', 'adforest'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                    )
                ),
            )
        ));
    }

}

if (!function_exists('adforest_vendor_services_func')) {

    function adforest_vendor_services_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'vendor_services' => '',
                        ), $atts));
        
        

        extract($atts);
   
         if (isset($adforest_elementor) && $adforest_elementor) {
                $vendor_services = ($atts['vendor_services']);
            } else {
                $vendor_services = vc_param_group_parse_atts($atts['vendor_services']);
            }
        $services_html = '';
        if (!empty($vendor_services)) {
            foreach ($vendor_services as $vendor_service) {
                
                
            if (isset($adforest_elementor) && $adforest_elementor) {
                $img_url    =    isset($vendor_service['vservice_icon_img']['url'])  ?  $vendor_service['vservice_icon_img']['url']  : "#";
            } else {
                $img_url    =    isset($vendor_service['vservice_icon_img'])  ? adforest_returnImgSrc($vendor_service['vservice_icon_img']) : "#";
            }
                
                $services_html .= '<div class="p-2 flex-fill bd-highlight mb-3 mb-md-0">
                             <ul class="free-shipping-1">
                                <li class="fre-ship"><img src="' . $img_url. '" alt="ship-icon"></li>
                                <li><h5>' . $vendor_service['vservice_title'] . '</h5> 
                                <p class="mb-0">' . $vendor_service['vservice_desc'] . '</p></li>
                            </ul>
                       </div> ';
            }
        }
        return  '<section class="method-icon">
    <div class="container">
      <div class="row">
            <div class="line mx-auto"></div>
            <div class="d-md-flex px-5 justify-content-around bd-highlight col-md-12 pt-4">             
             ' . $services_html . '
            </div>
            <div class="line mb-3 mx-auto"></div>
        </div>
    </div>
    <div></div></section>';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('vendor_services', 'adforest_vendor_services_func');
}