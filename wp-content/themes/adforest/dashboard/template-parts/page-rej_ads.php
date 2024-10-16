<?php

$user_id   = get_current_user_id();
$args = array(
    'post_type' => 'ad_post',
    'author' => $user_id,
    'post_status' => 'rejected',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'ID'
);
$show_pagination = 1;
$fav_ads = 'rejected';
?>
<div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
       <h2>
           
        <?php echo esc_html__('Rejected Ads','adforest'); ?>
       </h2>
    </div>
        <div class="row">
        <?php
      echo  adforest_pro_get_ads_list($args, $fav_ads);
        ?>
        </div>
    </div>
</div>