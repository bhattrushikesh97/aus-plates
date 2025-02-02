<?php
/* ------------------------------------------------ */
/* Cats Minimal */
/* ------------------------------------------------ */
if (!function_exists('cats_minimal_short')) {

    function cats_minimal_short() {

        $cat_array = array();

        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat','no');

        vc_map(array(
            "name" => __("Categories - Minimal", 'adforest'),
            "base" => "cats_minimal_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('cat-minimal.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
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
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Background Color", 'adforest'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Background Color', 'adforest') => '',
                        __('White', 'adforest') => '',
                        __('Gray', 'adforest') => 'gray',
                        __('Image', 'adforest') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Select background color.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "attach_image",
                    "holder" => "img",
                    "heading" => __("Background Image", 'adforest'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Header Style", 'adforest'),
                    "param_name" => "header_style",
                    "admin_label" => true,
                    "value" => array(
                        __('Section Header Style', 'adforest') => '',
                        __('No Header', 'adforest') => '',
                        __('Classic', 'adforest') => 'classic',
                        __('Regular', 'adforest') => 'regular'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => __("Chose header style.", 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title",
                    "description" => __('For color ', 'adforest') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('classic'),
                    ),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "param_name" => "section_title_regular",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    'dependency' => array(
                        'element' => 'header_style',
                        'value' => array('regular'),
                    ),
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
                    'group' => __('Categories', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'adforest'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        $cat_array,
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'adforest'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'cats_minimal_short');
if (!function_exists('cats_minimal_short_base_func')) {

    function cats_minimal_short_base_func($atts, $content = '') {
        global $adforest_theme;
        $bg_bootom = 'yes';
        extract($atts);
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $categories_html = '';
        if (isset($atts['cats'])) {
             if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = $atts['cats'];
            } else {
                $rows = vc_param_group_parse_atts($atts['cats']);
                $rows = apply_filters('adforest_validate_term_type', $rows);
            }
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['icon'])) {
                        $category = get_term($row['cat']);
                        if (count((array) $category) == 0)
                            continue;
                        $count = $category->count;
                        $icon_class = $row['icon'];
                        
                        
                        if (isset($adforest_elementor) && $adforest_elementor) {
                            $icon_class = $row['icon']['value'];
                        }

                        $cat_link_page = isset($cat_link_page) && $cat_link_page != '' ? $cat_link_page : '';
                        
                        $categories_html .= '<li class="col-lg-3 col-md-4 col-sm-6 col-xs-12"><a href="' . adforest_cat_link_page($row['cat'],$cat_link_page) . '">' . $category->name . '<span>(' . $count . ' ' . __('Ads', 'adforest') . ')</span><i class="' . $icon_class . '"></i></a></li>';
                    }
                }
            }
        }

        return '<section class="custom-padding ' . $bg_color . '" ' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
			   <div class="col-md-12 col-xs-12 col-sm-12 ">
			   		<ul class="category-list-style"><div class="row">' . $categories_html . '</div></ul>
				</div>
			   </div>
            </div>
         </section>
	
';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('cats_minimal_short_base', 'cats_minimal_short_base_func');
}