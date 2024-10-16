<?php

/* ------------------------------------------------ */
/* Process Cycle */
/* ------------------------------------------------ */
if (!function_exists('process_cycle_short')) {

    function process_cycle_short() {
        vc_map(array(
            "name" => __("Process Cycle", 'adforest'),
            "base" => "process_cycle_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('process_cycle.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'adforest'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                // Step 1
                array(
                    "group" => __("Step 1", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", 'adforest'),
                    "param_name" => "s1_title",
                ),
                array(
                    "group" => __("Step 1", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "s1_description",
                ),
                // Step 2
                array(
                    "group" => __("Step 2", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", 'adforest'),
                    "param_name" => "s2_title",
                ),
                array(
                    "group" => __("Step 2", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "s2_description",
                ),
                // Step 3
                array(
                    "group" => __("Step 3", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", 'adforest'),
                    "param_name" => "s3_title",
                ),
                array(
                    "group" => __("Step 3", "adforest"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", 'adforest'),
                    "param_name" => "s3_description",
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'process_cycle_short');
if (!function_exists('process_cycle_short_base_func')) {

    function process_cycle_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'section_bg' => '',
            'section_tagline' => '',
            'section_title' => '',
            'section_description' => '',
            's1_icon' => '',
            's1_title' => '',
            's1_description' => '',
            's2_icon' => '',
            's2_title' => '',
            's2_description' => '',
            's3_icon' => '',
            's3_title' => '',
            's3_description' => '',
                        ), $atts));
        extract($atts);
        $image_1 = get_template_directory_uri() . "/images/pr1.png";
        $image_2 = get_template_directory_uri() . "/images/icon45.png";
        $image_3 = get_template_directory_uri() . "/images/1231d1dr12.png";
        $image_4 = get_template_directory_uri() . "/images/321524.png";

        return '
<section class="how-its-worksss  custom-padding  ' . $section_bg . '">
    <div class="container">
        <div class="sb-short-head center">
            <h2>' . adforest_color_text($section_title) . '</h2>
            <p>' . $section_description . '</p>
        </div>
        <div class="row wrap-pad">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-ml">
                <div class="card see-work">
                    <div class="card-body account-head">
                        <div class="doted-bg">       
                            <div class="work-num">
                                01</div>
                        </div>    
                        <h5 class="card-title">' . $s1_title . '</h5>
                        <p class="card-text">' . $s1_description . '</p>
                        <div class="bg-icon">
                            <img src="' . $image_2 . '" alt="' . esc_html__('icon', 'adforest') . '">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-ml">
                <div class="card see-work text-center">
                    <div class="card-body account-head">
                        <div class="doted-bg">       
                            <div class="work-numi">
                                02</div>
                        </div> 
                        <h5 class="card-title">' . $s2_title . '</h5>
                        <p class="card-text">' . $s2_description . '</p>
                        <div class="bg-icon-2">
                            <img src="' . $image_2 . '" alt="' . esc_html__('icon', 'adforest') . '">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-ml">
                <div class="card see-working">
                    <div class="card-body sell-your">
                        <div class="doted-bg">       
                            <div class="work-numb">
                                03</div>
                        </div>     
                        <h5 class="card-title">' . $s3_title . '</h5>
                        <p class="card-text">' . $s3_description . '</p>
                        <div class="bg-icon-3">
                            <img src="' . $image_2 . '" alt="' . esc_html__('icon', 'adforest') . '">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('process_cycle_short_base', 'process_cycle_short_base_func');
}