<?php
global $wpdb;
$uid = get_current_user_id();
$rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$uid' AND meta_key LIKE '_sb_fav_id_%'");
$pids = array(0);
foreach ($rows as $row) {
    $pids[] = $row->meta_value;
}
$args = array(
    'post_type' => 'ad_post',
    'post__in' => $pids,
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'date'
);
$show_pagination = 1;
$fav_ads = 'yes';
?>
<div class="content-wrapper">
    <div class="content">
    <div class="sb-dash-heading">
       <h2>
           
        <?php echo esc_html__('Favourite Ads','adforest'); ?>
       </h2>

    </div>
    
        <div class="row">
        <?php
      echo  adforest_pro_get_ads_list($args, $fav_ads);
        ?>
        </div>
    </div>
</div>