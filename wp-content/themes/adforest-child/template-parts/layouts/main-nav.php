<?php
global $adforest_theme;
$menu_ul_flag = true;
$sb_disable_menu = isset($adforest_theme['sb_disable_menu']) ? $adforest_theme['sb_disable_menu'] : false;
if (!$sb_disable_menu) {
    // menu links 
    if ($menu_ul_flag) {
        echo '<ul class="menu-links">';
    }
    adforest_themeMenu('main_menu');
    if ($menu_ul_flag) {
        echo '</ul>';
    }
}
