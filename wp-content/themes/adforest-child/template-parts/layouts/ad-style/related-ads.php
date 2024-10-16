<?php
global $adforest_theme;
$pid = get_the_ID();
if ($adforest_theme['Related_ads_on']) {
    $cats = wp_get_post_terms($pid, 'ad_cats');
    $categories = array();
    foreach ($cats as $cat) {
        $categories[] = $cat->term_id;
    }
    $is_active = array(
        'key' => '_adforest_ad_status_',
        'value' => 'active',
        'compare' => '=',
    );
    $args = array(
        'post_type' => 'ad_post',
        'post_status' => 'publish',
        'posts_per_page' => $adforest_theme['max_ads'],
        'order' => 'DESC',
        'post__not_in' => array($pid),
        'tax_query' => array(
            array(
                'taxonomy' => 'ad_cats',
                'field' => 'id',
                'terms' => $categories,
                'operator' => 'IN',
                'include_children' => 0,
            )
        ),
        'meta_query' => array(
            $is_active,
        ),
    );
         $ads = new ads();
         $related_style = isset($adforest_theme['related_ad_style']) ? $adforest_theme['related_ad_style'] : "1";
         
         
         
         if($related_style  == "1"){
              echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['sb_related_ads_title'], 4, ''));
         }
         else {   
             $output  = "";
             $heading = '<div class="promotional-feat-heading"><h3>' . $adforest_theme['sb_related_ads_title'] . '</h3></div>';
 
             $results = new WP_Query($args);
             if($results->have_posts()){
             while ($results->have_posts()) {
             $results->the_post();
             $pid = get_the_ID();

            $output  .=    adforest_returnEcho($ads->adforest_search_layout_list_2($pid, $adforest_theme['sb_related_ads_title'], 4, ''));                              
         } 

        wp_reset_postdata();
       echo  $output  =   '<div class="promotional_slider"><div class="col-xs-12 col-md-12 col-sm-12 margin-bottom-30">' . $heading . ''.$output.'</div></div>';
         }
  
             }
    }