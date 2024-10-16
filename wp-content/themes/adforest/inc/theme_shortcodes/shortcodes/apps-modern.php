<?php

/* ------------------------------------------------ */
/* Apps 2 */
/* ------------------------------------------------ */
if (!function_exists('apps_modern_short')) {

    function apps_modern_short() {
        vc_map(array(
            "name" => __("Apps Modern", 'adforest'),
            "base" => "apps_modern_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('app-new-modern.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "param_name" => "tag_line",
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

                ),
                // Android
                array(
                    "group" => __("Android", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Download Link", 'adforest'),
                    "param_name" => "a_link_mod",
                ),
                array(
                    "group" => __("Android", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("Android image", 'adforest'),
                    "param_name" => "android_img_mod",
                    "description" => __("167x49", 'adforest'),
                ),
                // IOS
                array(
                    "group" => __("IOS", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Download Link", 'adforest'),
                    "param_name" => "i_link_mod",
                ),
                array(
                    "group" => __("IOS", "adforest"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => __("IOS image", 'adforest'),
                    "param_name" => "ios_img_mod",
                    "description" => __("167x49", 'adforest'),
                ),
            )
        ));
    }

}

add_action('vc_before_init', 'apps_modern_short');
if (!function_exists('apps_modern_short_base_func')) {

    function apps_modern_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'attach_image_mod' => '',
            'bg_img_mod' => '',
            'section_title_mod' => '',
            'section_bg_mod' => '',
            'tag_line_mod' => '',
            'a_link_mod' => '',
            'android_img_mod' => '',
            'i_link_mod' => '',
            'ios_img_mod' => '',
               'tag_line'=>'',
             'section_title' =>'',
              'section_description'=>'',
            'section_bg'=>''
                        ), $atts));
        extract($atts);

        $and_html = "";
        $ios_html = "";

        
       if(isset($adforest_elementor) && $adforest_elementor){
        if (isset($android_img ['url']) && $android_img ['url'] != "") {
            $and_html .= '<a href="' . esc_url($a_link) . '" target="_blank"> <img src="' . $android_img ['url'] . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '"></a>';
        }

        if (isset($ios_img['url']) && $ios_img['url'] != "") {
            $ios_html .= '<a href="' . esc_url($i_link) . '" target="_blank"><img src="' . $ios_img['url'] . '" class="img-fluid"  alt="' . esc_attr('image', 'adforest') . '"></a>';
        }
        
       }
       
       
       else   {
           
           if ( $android_img_mod != "" ) {
			$android_img_mod   = adforest_returnImgSrc( $android_img_mod );
			$and_html .= ' <a href="' . esc_url( $a_link_mod ) . '" target="_blank"> <img src="' . $android_img_mod . '" class="img-fluid"  alt="' . esc_attr( 'image', 'adforest' ) . '"></a> ';
		}
		//ios
		$ios_apps_html = '';
		if ( $ios_img_mod != "" ) {
			$ios_img_mod   = adforest_returnImgSrc( $ios_img_mod );
			$ios_html .= ' <a href="' . esc_url( $i_link_mod ) . '" target="_blank"> <img src="' . $ios_img_mod . '" class="img-fluid"  alt="' . esc_attr( 'image', 'adforest' ) . '"></a>';
		}
       }
        


        return '<section class="get-app  ' . $section_bg . '">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="app-download">
                    <span>' . $tag_line . '</span>
                    <h3>' . $section_title . '</h3>
                    <p>' . $section_description. '</p>

                    <div class="app-img">
                        ' . $and_html . '
                        ' . $ios_html . '
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>';
    }
}

if (function_exists('adforest_add_code')) {
    adforest_add_code('apps_modern_short_base', 'apps_modern_short_base_func');
}