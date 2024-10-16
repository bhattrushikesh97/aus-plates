<?php
global $adforest_theme;
$user_id    =  get_current_user_id() ;
$args = array(
    'post_type' => 'ad_post',
    'author' => $user_id,
    'post_status' => array('draft'),
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'ID'
);

 $after_expired_ads = isset($adforest_theme['after_expired_ads']) ? $adforest_theme['after_expired_ads'] : "";


 if( $after_expired_ads  == "published"){

$args = array(
    'post_type' => 'ad_post',
    'author' => $user_id,
    'post_status' => array('draft','publish'),
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'ID',
    'meta_query' => array(
        'relation' =>  'OR',
        array(
            'key'     => '_adforest_ad_status_',
            'value'   => 'expired',
            'compare' => '=',
       ),
         array(
            'key'     => '_adforest_ad_status_',
            'value'   => 'sold',
            'compare' => '=',
       ),
));

 }


$show_pagination = 1;
$fav_ads = 'no';
?>
<div class="content-wrapper">
    <div class="content">
    <div class="sb-dash-heading">
       <h2>
        <?php echo esc_html__('Expire Ads','adforest'); ?>
       </h2>
  
    </div>
 
        <div class="row">
        <?php
      echo  adforest_pro_get_ads_list($args, $fav_ads ,true );
        ?>
        </div>
    </div>
</div>