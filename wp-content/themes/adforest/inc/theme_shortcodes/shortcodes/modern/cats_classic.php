<?php

/* ------------------------------------------------ */
/* Cats Classic */
/* ------------------------------------------------ */
if (!function_exists('cats_classic_short')) {

    function cats_classic_short() {

        $cat_array = array();
        $cat_array = apply_filters('adforest_ajax_load_categories', $cat_array, 'cat', 'no');
        vc_map(array(
            "name" => __("Categories - Classic", 'adforest'),
            "base" => "cats_classic_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('cat-classic.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
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
                    "description" => __('For color ', 'adforest') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . __('warp text within this tag', 'adforest') . '<strong>' . esc_html('{/color}') . '</strong>',
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
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "dropdown",
                    "heading" => __("Sub cats limit", 'adforest'),
                    "param_name" => "sub_limit",
                    "admin_label" => true,
                    "value" => range(0, 500),
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

add_action('vc_before_init', 'cats_classic_short');
if (!function_exists('cats_classic_short_base_func')) {

    function cats_classic_short_base_func($atts, $content = '') {
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


            $counter = 1;
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['icon'])) {
                        $category = get_term($row['cat']);
                        if (count((array) $category) == 0) {
                            continue;
                        }

                        $sub_cat_html = '';
                        $ad_sub_cats = adforest_get_cats('ad_cats', $row['cat']);
                        $i = 1;
                        if ($sub_limit != 0) {
                            foreach ($ad_sub_cats as $sub_cat) {

                                $subcount = ($sub_cat->count);
                                $sub_cat_html .= '<li>
							<a href="' . adforest_cat_link_page($sub_cat->term_id, $cat_link_page) . '">
							' . $sub_cat->name . '<span>' . $subcount . '</span>
							</a>
							</li>';
                                if ($i == $sub_limit) {
                                    break;
                                }

                                $i++;
                            }
                        }

                        $icon_class = $row['icon'];
                        if (isset($adforest_elementor) && $adforest_elementor) {
                            $icon_class = $row['icon']['value'];
                        }

                        $categories_html .= '
					<div class="col-xl-3 col-lg-3  col-md-6 col-sm-6">
                        <div class="category-list">
                           <div class="category-list-icon">
                              <i class="' . $icon_class . '"></i>
                              <div class="category-list-title">
                                 <h5>
                                    <a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
                                    ' . $category->name . '
                                    </a>
                                 </h5>
                              </div>
                           </div>
                           <ul class="category-list-data">
                              ' . $sub_cat_html . '
                           </ul>
						   <div class="clearfix"></div>
                           <div class="traingle"></div>
                           <div class="post-tag-section clearfix">
						   <a href="' . adforest_cat_link_page($row['cat'], $cat_link_page) . '">
						   <div class="cat-all">' . __('View All', 'adforest') . '</div>
						   </a>
						   </div>
                        </div>
                     </div>
					';
                        if ($counter % 4 == 0 && !wp_is_mobile()) {
                            $categories_html .= '<div class="clearfix"></div>';
                        }
                        $counter++;
                    }
                }
            }
        }

        return '<section class="custom-padding categories ' . $bg_color . '" ' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-md-12 col-xs-12 col-sm-12">
				  	<div class="row">
				  		' . $categories_html . '
					</div>	
				</div>
			   </div>
            </div>
         </section>
';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('cats_classic_short_base', 'cats_classic_short_base_func');
}