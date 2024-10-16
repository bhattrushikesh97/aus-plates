<?php
/* ------------------------------------------------ */
/* Search Simple */
/* ------------------------------------------------ */
if (!function_exists('search_hero_short')) {

    function search_hero_short() {
        vc_map(array(
            "name" => __("Search - with bg-video", 'adforest'),
            "base" => "search_hero_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'adforest'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'adforest'),
                    'param_name' => 'order_field_key',
                    'description' => adforest_VCImage('search-simple.png') . __('Ouput of the shortcode will be look like this.', 'adforest'),
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("BG Video", 'adforest'),
                    "description" => __("Youtube video url.", 'adforest'),
                    "param_name" => "section_video",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'adforest'),
                    "description" => __("%count% for total ads.", 'adforest'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => __("Basic", "adforest"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Tagline", 'adforest'),
                    "param_name" => "section_tag_line",
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'search_hero_short');
if (!function_exists('search_hero_short_base_func')) {

    function search_hero_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'section_video' => '',
            'section_title' => '',
            'section_tag_line' => '',
                        ), $atts));
        global $adforest_theme;

        extract($atts);
        $count_posts = wp_count_posts('ad_post');
        $main_title = str_replace('%count%', '<b>' . $count_posts->publish . '</b>', $section_title);
        $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
        // for video start point


       
return 
'<section class="hero hero-cashew  video-section">   
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="hero-cashew-heading"> 
                    <h1>' . $main_title . '</h1>
                    <p>' . esc_html($section_tag_line) . '</p>
                </div>
                <form method="get" action="' . urldecode(get_the_permalink($sb_search_page)) . '">
                    <div class="cashew-input-search">
                        <input type="text" autocomplete="off" name="ad_title" class="form-control" placeholder="' . __('What Are You Looking For...', 'adforest') . '" /> 
                        ' . apply_filters('adforest_form_lang_field', false) . ' 
                  
                    <div class="cashew-search-icon">
                        <button class="btn btn-theme" type="submit"> <span class="fa fa-search"></span> </button>              
                    </div>
                     </div>
                </form>                   
            </div>
        </div>
    </div>
</section>';
    }

}

if (function_exists('adforest_add_code')) {
    adforest_add_code('search_hero_short_base', 'search_hero_short_base_func');
}