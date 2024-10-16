<?php global $adforest_theme;?>
<?php if (isset($adforest_theme['ad_in_menu'])  && !$adforest_theme['ad_in_menu']) { return; }
$btn_text = "";
if (isset($adforest_theme['ad_in_menu_text']) && $adforest_theme['ad_in_menu_text'] != "") {
    $btn_text = $adforest_theme['ad_in_menu_text'];
}

$sb_post_ad_page     =   isset($adforest_theme['sb_post_ad_page'])   ?   $adforest_theme['sb_post_ad_page']   :   "";

$sb_post_ad_page = apply_filters('adforest_ad_post_verified_id',$sb_post_ad_page); // phone verification redirection
$sb_post_ad_page = apply_filters('adforest_language_page_id', $sb_post_ad_page);
$sb_ad_post_url = isset($sb_post_ad_page) && !empty($sb_post_ad_page) ? apply_filters('adforest_ad_post_verified_link',get_the_permalink($sb_post_ad_page)) : home_url('/');
?>



<a href="<?php echo esc_url($sb_ad_post_url);?>" class="btn btn-theme"><i class="fa fa-plus" aria-hidden="true"></i><?php echo esc_html($btn_text);?></a>