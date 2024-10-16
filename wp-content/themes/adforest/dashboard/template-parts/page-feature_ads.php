<?php
$user_id   = get_current_user_id();
$args = array(
    'post_type' => 'ad_post',
    'author' => $user_id,
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'meta_key' => '_adforest_is_feature',
    'meta_value' => '1',
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'ID'
);
$fav_ads = 'featured_ads';
?>  
<div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
       <h2>
           
        <?php echo esc_html__('Featured Ads','adforest'); ?>
       </h2>
    </div>
        <div class="row">
        <?php
      echo  adforest_pro_get_ads_list($args, $fav_ads);
        ?>
        </div>
    </div>
</div>