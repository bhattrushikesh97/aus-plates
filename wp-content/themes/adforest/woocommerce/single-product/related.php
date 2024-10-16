<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

global  $adforest_theme;


if ( isset( $adforest_theme['shop-related-single-on'] ) && $adforest_theme['shop-related-single-on'] ) { 
$cats = wp_get_post_terms(get_the_ID(), 'product_cat');
$categories = array();
foreach ($cats as $cat) {
    $categories[] = $cat->term_id;
}
$countRelated = ( isset( $adforest_theme['shop-number-of-related-products-single'] ) ) ? $adforest_theme['shop-number-of-related-products-single'] : 4;
$relatedTitle = ( isset( $adforest_theme['shop-related-single-title'] ) ) ? $adforest_theme['shop-related-single-title'] : __( "Related Products", "adforest" );
$loop_args = array(
    'post_type' => 'product',
    'posts_per_page' => $countRelated,
    'order' => 'DESC',
    'post__not_in' => array(get_the_ID()),
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $categories
        )
    )
);
$loop_args = apply_filters('adforest_wpml_show_all_posts', $loop_args);
$related_products = new WP_Query($loop_args);
if ($related_products->have_posts()) {
    ?>
</div>
    <section class="two-day-product">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="two-day-product-head">
                        <h4><?php echo esc_html($relatedTitle); ?></h4>
                        <ul class="day-item">
                            <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php echo esc_html__('View All Product','adforest') ?></a></li>
                        </ul>
                    </div>
                    <section class="team-style-1">
                        <div class="owl-carousel1 carousel-team-style-1 staff-list">
                            <?php
                            while ($related_products->have_posts()) {         
                                $related_products->the_post();
                                $product_id = get_the_ID();
                                global $product;
                                $currency = get_woocommerce_currency_symbol();
                                $price = $product->get_regular_price();
                                $sale = $product->get_sale_price();
                                 $newness_days = isset($adforest_theme['shop_newness_product_days']) ? $adforest_theme['shop_newness_product_days'] : 30;
                    $created = strtotime($product->get_date_created());
                    $new_badge_html = '';
                    /* here we use static badge date. */
                    if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
                        $new_badge_html = '<span class="new-product">'.esc_html__('new', 'adforest').'</span>';
                    }
                                
                                
                                $fav_class   =  "";
                                $heart_filled  =  "fa-heart";
                                if (get_user_meta(get_current_user_id(), '_product_fav_id_' . $product_id, true) == $product_id) {
                                    $fav_class = 'favourited';
                                    $heart_filled = 'fa-heart';
                                }
                                ?>
                                <div class="wrapper-latest-product woocommerce listing-list-items">
                                    <div class="top-product-img">
                                        <?php if (get_the_post_thumbnail(get_the_ID())) { ?>
                                            <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail'); ?></a>
                                        <?php } else { ?>
                                            <a href="<?php echo esc_url(get_the_permalink('woocommerce_thumbnail')); ?>"><img
                                                    class="img-fluid" alt="<?php echo get_the_title(); ?>"
                                                    src="<?php echo esc_url(wc_placeholder_img_src()); ?>"></a>
                                            <?php } ?>
                                    </div>
                                    <div class="bottom-listing-product">
                                        <?php if ($product->get_average_rating() > 0) { ?>
                                            <div class="listing-ratings">
                                                <div class="woocommerce-product-rating">     <?php echo wc_get_rating_html($product->get_average_rating()); ?>   
                                                    <span class="product-review-count"><?php echo esc_html($product->get_review_count() . '  ' . esc_html__('Reviews', 'adforest')); ?></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <h4><a href="<?php echo get_the_permalink() ?>"><?php echo esc_html(get_the_title()); ?> </a></h4>
                                        
                                        <h5><?php echo adforest_returnEcho($product->get_price_html()); ?></h5>
                                        <div class="shop-detail-listing">
                                            <a href="<?php get_the_permalink(); ?>" class="btn btn-theme btn-listing"> <?php echo esc_html__('Shop Now','adforest') ?></a>                                         
                                                 </div>

                                                
                                    </div>
                                    <?php if ($sale) { ?>
                                            <span class="sale-shop"><?php echo esc_html__('Sale', 'adforest') ?></span>
                                        <?php } 
                                           echo adforest_returnEcho($new_badge_html);
                                           
                                        ?>
                                             <div class="fav-product-container">
                                                     <a href="javascript:void(0)" class="product_to_fav  <?php esc_attr($fav_class)?>" data-productid = "<?php echo esc_attr($product_id) ?>"> <span class="fa <?php echo esc_attr($heart_filled) ?> hear-btn"></span></a>
                                                 </div>
                                </div>
                            <?php } ?>  
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <?php
}}
                                       