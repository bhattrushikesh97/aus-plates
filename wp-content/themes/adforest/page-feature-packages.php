<?php /* Template Name: feature template */ ?>
<?php 
get_header();
global $adforest_theme;
$category_pkg_args = array(
    'post_type' => 'product',
    'fields' => 'ids',
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => 'adforest_feature_pkgs',
        ),
    ),
    'posts_per_page' => -1,
);

$category_pkg_posts = new WP_Query($category_pkg_args);


if ($category_pkg_posts->have_posts()) {
   while ($category_pkg_posts->have_posts()) {
     $category_pkg_posts->the_post();
     $post_id = get_the_ID();
     $post_title = get_the_title();
    $Featured_expiry_days = get_post_meta($post_id, 'package_adFeatured_expiry_days', true);
    $regular_price = get_post_meta($post_id, '_regular_price', true);
    $sale_price = get_post_meta($post_id, '_sale_price', true);
    $ads_for_dayes = $post_title." for ".$Featured_expiry_days."Days";
   }

   wp_reset_postdata();

}


$search_page   =  isset($adforest_theme['sb_search_page'])  ?  get_the_permalink($adforest_theme['sb_search_page']) : "#";
  
      
   ?>

    <section class="ad-uploaded-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="uploaded-ad-box">
                        <div class="left-icon">
                            <img src="<?php echo get_template_directory_uri()."/images/hand-shake.svg"?>" alt="hand-shake">
                        </div>
                        <div class="right-meta">
                            <h4><?php echo esc_html__('Your Ad has been uploaded successfully!','adforest'); ?></h4>
                            <p><?php echo esc_html__('Your ad will soon be reachable of ','adforest'); ?><span><?php echo esc_html__('millions','adforest'); ?></span><?php echo esc_html__('of buyers','adforest'); ?></p>
                        </div>
                    </div>
                    <form id="feature_ad_form" class="feature_ad_form">
                    <div class="upgrade-ad-positions">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                                <div class="upgrade-position-detail">
                                    <h4><?php echo esc_html__('Reach More Buyers and sell Faster and Upgrade your Ad to a top position','adforest'); ?></h4>
                                    <h6><?php echo esc_html__('What is Featured Ad?','adforest'); ?></h6>
                                    <ul>
                                        <li>
                                            <img src="<?php echo get_template_directory_uri()."/images/tick-img.png" ?>" alt="tick-icon">
                                             <?php echo esc_html__('Get noticed with','adforest'); ?><span><?php echo esc_html__('"featured"','adforest'); ?></span><?php echo esc_html__('tag in top position','adforest'); ?> 
                                        </li>
                                        <li>
                                            <img src="<?php echo get_template_directory_uri()."/images/tick-img.png" ?>" alt="tick-icon">
                                            <?php echo esc_html__(' Ad will be highlighted to top position','adforest'); ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                                <div class="upgrade-image-box">
                                    <img src="<?php echo get_template_directory_uri()."/images/featured-ad.png" ?>" alt="featured-ad">
                                </div>
                            </div>
                        </div>
                        <div class="featured-ads-box">
                            <div class="top-bar">
                                <h5><?php echo __('Feature AD','adforest') ?></h5>
                                <a href="<?php echo esc_url($search_page); ?>"> <?php  echo __('See example','adforest'); ?> </a>
                            </div>
                            <div class="featured-duration">
                        
                                <ul class="featured-duration-list">
                                <?php
                                 if ($category_pkg_posts->have_posts()) {
                                   while ($category_pkg_posts->have_posts()) {
                                    $category_pkg_posts->the_post();
                                    $post_id = get_the_ID();
                                    $post_title = get_the_title();  

                                 $Featured_expiry_days = get_post_meta($post_id, 'package_adFeatured_expiry_days', true);
                                   $ads_for_dayes = $post_title." for ".$Featured_expiry_days." Days";
                                    $regular_price = get_post_meta($post_id, '_regular_price', true);
                                       $sale_price = get_post_meta($post_id, '_sale_price', true);
                                 ?>
                                    <li>
                                    <input class="form-check-input" type="radio" name="package" id="package-<?php echo $post_id ?>" value="<?php echo get_the_ID(); ?>" required>
                                        <label for="check-one-ctg">
                                            <div class="type-box">
                                                <div class="r-meta">
                                                    <p class="txt"><?php echo $ads_for_dayes; ?></p>
                                                    <span><?php if($sale_price != "") { echo get_woocommerce_currency_symbol().$sale_price; }

                                                    else{ 
                                                        echo get_woocommerce_currency_symbol() .$regular_price;  } ?></span>
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                               <?php 
                                    }
                                  }
                                 
                                 ?>
            
                                </ul>
                            </div>
                          </div>
                        </div>
                        
                        <input type="hidden" name="pid" id="pid" value="<?php echo $_GET['pid']; ?>">
                        <?php $pid = $_GET['pid']; ?>
                            <div class="ad-botm-buttons">
                            <a href="<?php echo get_the_permalink($pid); ?>" class="skip-btn"><?php echo esc_html__('Skip, View Your Ad ','adforest'); ?></a>
                            <button type="submit" class="upgrade-btn"><?php echo esc_html__('Upgrade Your Ad ','adforest'); ?></button>
                        </div>
                  </form>
                </div>
            </div>
        </div>
    </section>
  
  
  <?php 
 get_footer(); ?>