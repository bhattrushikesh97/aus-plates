<?php
global $adforest_theme, $template ,$wpdb;
$page_template = basename($template);
get_template_part('template-parts/headers/html', 'head');
if ($page_template == 'page-theme-dashboard.php') {   
    return;
}
$user_id = get_current_user_id();
if (!function_exists('adforest_header_content_html')) {        
    function adforest_header_content_html() 
    {  
      global $adforest_theme;
      $header_type  =  isset($adforest_theme['sb_header'])  ?  $adforest_theme['sb_header']  : "white";
            
      if(isset($_GET['sb_header']) && $_GET['sb_header'] != ""){
          $header_type  =  $_GET['sb_header'];    
      }

      $change_woo_header  =   isset($adforest_theme['shop_change_header'])  ?  $adforest_theme['shop_change_header'] : false;
    if(class_exists( 'woocommerce' ) &&  $change_woo_header){
     if(is_product() || is_product_category() || is_shop()){
       $header_type  =  'vendor-1';   
     }
    }      
         if ($header_type == 'black') {
            get_template_part('template-parts/headers/header', '2');
        } else if ($header_type == 'with_ad') {
            get_template_part('template-parts/headers/header', '3');
        } else if ($header_type  == 'light') {
            get_template_part('template-parts/headers/header', '4');
        } else if ($header_type == 'modern') {
            get_template_part('template-parts/headers/header', '5');
        } else if ($header_type == 'modern2') {
            get_template_part('template-parts/headers/header', '6');
        } else if ($header_type == 'modern3') {
            get_template_part('template-parts/headers/header', '7');
        } else if ($header_type  == 'transparent-2') {
            get_template_part('template-parts/headers/header', '8');
        } else if ($header_type == 'Decore') {
            get_template_part('template-parts/headers/header', '9');
        } else if ($header_type == 'transparent-3') {
            get_template_part('template-parts/headers/header', '10');
        } else if ($header_type == 'modern4') { 
            get_template_part('template-parts/headers/header', '11');
        } else if ($header_type == 'vendor-1') {
            get_template_part('template-parts/headers/header', '12');
        } 
        else if ($header_type == 'transparent') {
            get_template_part('template-parts/headers/header', '13');
        } 
        else if ($header_type == 'header-classy') {
            get_template_part('template-parts/headers/header', '14');
        }   
        else {
            get_template_part('template-parts/headers/header', '1');
        }    
         if (basename(get_page_template()) != 'page-home.php') {
              get_template_part('template-parts/layouts/bread', 'crumb');
          }
    }
}
/* Close ad action here */
$header_type  =  isset($adforest_theme['sb_header'])  ?  $adforest_theme['sb_header']  : "1";
if($header_type  ==  'elementor-pro' && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))){
   elementor_theme_do_location('header');
}
else{   
    do_action('adforestAction_header_content', 'adforest_header_content_html');
}