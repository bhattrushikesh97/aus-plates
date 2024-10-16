<?php
$user_id = get_current_user_id();
$paged = get_query_var('paged', 1);
$args = array(
    'post_type' => 'ad_post',
    'author' => $user_id,
    'post_status' => 'publish',
    'posts_per_page' =>  get_option('posts_per_page'),
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'date'
);
$fav_ads = 'no';
$is_feature  =  false;
?>    
<div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
       <h2>
           
        <?php echo esc_html__('My Ads','adforest'); ?>
       </h2>
    </div>
        <div class="row">
        <?php
      echo  adforest_pro_get_ads_list($args, $fav_ads);
        ?>
        </div>
    </div>
</div>