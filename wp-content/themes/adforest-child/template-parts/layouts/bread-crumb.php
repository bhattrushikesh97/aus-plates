<?php
global $adforest_theme, $template;
if (in_array('dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    global $WCMp;
    if (isset($WCMp->taxonomy->taxonomy_name) && is_tax($WCMp->taxonomy->taxonomy_name)) {
        return;
    } else if (shortcode_exists('wcmp_vendorslist')) {
        // return;
    }
}
$page_template = basename($template);
$sb_profile_page = apply_filters('adforest_language_page_id', isset($adforest_theme['sb_profile_page']) ? $adforest_theme['sb_profile_page'] : "" );

global $post;
$header_style   =   isset($adforest_theme['sb_header'])  ? $adforest_theme['sb_header'] :  '1';
if ( is_author() || $header_style == '3') {
    return;
} 
            

if (is_archive() || is_category() || is_tax() || is_author() || is_404() || is_home()) {
    ?>
    <section class="dt-detaial-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="detail-page-item">
                        <li> <h1><a href="javascript:void(0);" class="active"><?php echo adforest_bread_crumb_heading(); ?></a></h1>  </li>                 
                       
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>

    <section class="dt-detaial-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="detail-page-item">
                         <li><a href="<?php echo home_url('/'); ?>"><?php echo esc_html__('Home', 'adforest'); ?> </a></li>   
                         <?php
                         
                         if(is_singular( 'ad_post' )){
                             $single_ad_post_title  =   isset($adforest_theme['sb_single_ad_text'])  ?  $adforest_theme['sb_single_ad_text']  : "";                            
                              echo  '<li><a href="javascript:void(0);">'. esc_html($adforest_theme['sb_single_ad_text']).'</a></li>';                             
                         }  

                        else if(is_singular( 'events' )){
                                                         
                              echo  '<li><a href="javascript:void(0);">'. esc_html__('Event Detail','adforest').'</a></li>';                             
                         }                    
                       else if(is_single()){                       
                            $single_ad_post_title  =   isset($adforest_theme['sb_blog_single_title'])  ?  $adforest_theme['sb_blog_single_title']  : "";
                            echo  '<li><a href="javascript:void(0);">'. esc_html($single_ad_post_title).'</a></li>';           
                         }
                         ?>
                         <li><a href="javascript:void(0);" class="active"><?php echo adforest_breadcrumb(); ?></a></li>
                      
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?php
}
