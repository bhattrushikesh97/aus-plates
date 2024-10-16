<?php
global $adforest_theme, $template;

$page_template = basename($template);
if ($page_template == 'page-theme-dashboard.php') {
    wp_footer();
    return;
}
$footer_style = isset($adforest_theme['footer_style']) ? $adforest_theme['footer_style'] : "default";

if (isset($_GET['footer_style']) && $_GET['footer_style'] != "") {

    $footer_style = $_GET['footer_style'];
}
$page_template = basename($template);




if (!function_exists('adforest_footer_content_html')) {
    function adforest_footer_content_html() {
        global $adforest_theme;
        $footer_style = isset($adforest_theme['footer_style']) ? $adforest_theme['footer_style'] : "default";
        if (isset($_GET['footer_style']) && $_GET['footer_style'] != "") {
            $footer_style = $_GET['footer_style'];
        }
        get_template_part('template-parts/footers/footer', $footer_style);
    }

}
if ($footer_style == "13" && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    elementor_theme_do_location('footer');
} else {
    do_action('adforestAction_footer_content', 'adforest_footer_content_html');
}

 
wp_footer();

?>    
</body>
</html>