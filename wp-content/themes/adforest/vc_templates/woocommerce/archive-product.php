<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
if (!defined('ABSPATH')) {
    exit;
}

global $adforest_theme;
if (isset($adforest_theme['shop-turn-on']) && $adforest_theme['shop-turn-on']) {
    get_header();
    $category = get_queried_object();
    $refresh_url = isset($category->term_id) ? get_term_link($category->term_id) : get_permalink(wc_get_page_id('shop'));
 
    $layoutCol = (isset($adforest_theme['shop-layout-col']) && $adforest_theme['shop-layout-col'] == true) ? $adforest_theme['shop-layout-col'] : 'col-lg-3';
    $container_class = 'listing-list-items';
    if ('col-lg-4' == $layoutCol) {
        $container_class = 'listing-list-item-1s';
    }

    $sidebar_position = (isset($adforest_theme['shop-sidebar-position'])) ? $adforest_theme['shop-sidebar-position'] : 'left';
    ?>

    <section class="listing-list-salesman">
        <div class="container">
            <div class="first-heading">
                <?php
                woocommerce_breadcrumb();
                ?>
            </div>
        </div>
    </section>

    <section class="detail-page"> 
        <div class="container">
            <div class="row"> 
                <?php if ($sidebar_position == 'left') { ?>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12"> 
                        <div class="detail-product-search">

                            <?php
                            if (is_active_sidebar('adforest_woocommerce_widget')) :
                                get_sidebar('shop');

                            endif;
                            ?>                   

                        </div>
                    </div>
                <?php } ?>
                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12"> 
                    <?php if (have_posts()) { ?>
                        <div class="listing-head">
                            <div class="show-head">
                                <?php woocommerce_result_count(); ?>
                            </div>
                            <div class="ref-sort">
                                <ul class="refresh-sort-item">
                                    <li><a href="<?php echo esc_url($refresh_url) ?>" class="refresh-icon-head"><i class="fa fa-refresh"></i> <?php echo esc_html__('Refresh', 'adforest') ?></a></li>
                                    <li> <?php woocommerce_catalog_ordering(); ?></li>
                                   
                                    
                                </ul>
                            </div>
                        </div>
                        <?php
                        echo '<div class="row clear-custom">';
                        while (have_posts()) {
                            the_post();
                            global $product;
                            $product_id = get_the_ID();
                            $product_type = wc_get_product($product_id);

                            $currency = get_woocommerce_currency_symbol();
                            //$price = get_post_meta(get_the_ID(), '_regular_price', true);
                            //$sale = get_post_meta(get_the_ID(), '_sale_price', true);
                            $price = $product->get_regular_price();
                            $sale = $product->get_sale_price();
                            $product_typee = adforest_get_product_type(get_the_ID());
                            if (isset($product_typee) && $product_typee == 'variable') {
                                $available_variations = $product->get_available_variations();
                                if (isset($available_variations[0]['variation_id']) && !empty($available_variations[0]['variation_id'])) {
                                    $variation_id = $available_variations[0]['variation_id'];
                                    $variable_product1 = new WC_Product_Variation($variation_id);
                                    $price = $variable_product1->get_regular_price();
                                    $sale = $variable_product1->get_sale_price();
                                }
                            }

                                $currency = get_woocommerce_currency_symbol();
                                $price = $product->get_regular_price();
                                $sale = $product->get_sale_price();
                                $newness_days = isset($adforest_theme['shop_newness_product_days']) ? $adforest_theme['shop_newness_product_days'] : 30;
                                $created = strtotime($product->get_date_created());
                                $new_badge_html = '';
                                /* here we use static badge date. */
                                
                               
                                $prod_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail');
                                $prod_img_html = '';
                                if (isset($prod_image_src) && is_array($prod_image_src)) {
                                    $prod_img_html = '<img src="' . $prod_image_src[0] . '" alt="' . get_the_title($product_id) . '" class="img-fluid"/>';
                                } else {
                                    $prod_img_html = '<img class="img-fluid" alt="' . get_the_title() . '" src="' . esc_url(wc_placeholder_img_src('woocommerce_thumbnail')) . '">';
                                }
                                
                                $sale_html   =  "";
                                $price_html = '<h5>' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</h5>';
                                $new_space =   ''; 
                                if ($sale) {
                                    $price_html = '<h5>' . esc_html(adforest_shopPriceDirection($sale, $currency)) . '<span class="del">' . esc_html(adforest_shopPriceDirection($price, $currency)) . '</span></h5>';
                                    $sale_html = '<span class="sale-shop">'. esc_html__('sale','adforest').'</span>';
                                    $new_space =  "new_top";
                                    }
                                    $new_html  = "";
                                if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
                                        $new_html = '<span class="new-product '.$new_space.'">'. esc_html__('new','adforest').'</span>';
                                  }
                                                                 
                                $rating_html = "";
                                if ($product->get_average_rating() > 0) {
                                    $rating_html = '<div class="listing-ratings">
                                                <div class="woocommerce-product-rating">' . wc_get_rating_html($product->get_average_rating()) . '  
                                                    <span class="product-review-count">' . $product->get_review_count() . '&nbsp' . esc_html__('Reviews', 'adforest') . '</span>
                                                </div>

                                            </div>';
                                }
                                /* check already favourite or not */
                                $heart_filled = 'fa-heart';
                                $fav_class ="";
                                if (get_user_meta(get_current_user_id(), '_product_fav_id_' . $product_id, true) == $product_id) {
                                    $fav_class = 'favourited';
                                    $heart_filled = 'fa-heart';
                                }

                                
                            $title_limit  =  isset($adforest_theme['shop-title-limit']) && $adforest_theme['shop-title-limit'] != "" ? $adforest_theme['shop-title-limit']      :  20;


                                echo '<div class="' . $layoutCol . ' col-md-4  col-sm-6 col-12 col-lg-4 col-xl-4  change_archive_col">'
                                        . '<div class="' . $container_class . '  wrapper-latest-product woocommerce">
                                                <div class="top-product-img">
                                                  <a href="'.get_the_permalink() .'">
                                                     ' . $prod_img_html . '
                                                     </a>
                                                </div>
                                               <div class="bottom-listing-product">
                                                     <div class="listing-ratings">
                                                         ' . $rating_html . '
                                                               </div>
                                         <h4><a  title = "'.get_the_title().'"  href="' . get_the_permalink() . '">' . adforest_words_count(get_the_title(),$title_limit) . '</a></h4>
                                                ' . $price_html . '
                                                 <div class="shop-detail-listing">
                                                    <a href="'. get_the_permalink().'" class="btn btn-theme btn-listing">'.esc_html__('Shop Now','adforest').'</a>
                                              </div>
                                                </div>  
                                                <div class= "fav-product-container">    
                                              <a href="javascript:void(0)" class="product_to_fav   '.$fav_class.'"  data-productid="'.$product_id.'">  <span class="fa '.$heart_filled.' hear-btn"></span></a>
                                                 </div>
                                          '.$sale_html.'
                                         '.$new_html.'
                                          </div>
                                            
                                        </div>';
                           
                        }
                        echo '<div class="clearfix"></div><div>';
                        adforest_pagination();
                        echo '</div></div>';
                    } else {
                        echo '<p class="woocommerce-info">' . __('No Product Found', 'adforest') . '</p>';
                    }
                    ?>
                </div>
                <?php if ($sidebar_position == 'right') { ?>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12"> 
                        <div class="detail-product-search">

                            <?php
                            if (is_active_sidebar('adforest_woocommerce_widget')) :
                                get_sidebar('shop');

                            endif;
                            ?>                   

                        </div>
                    </div>
                <?php } ?>
            </div>  
        </div>
    </section>
    <?php
    get_footer();
} else {
    $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
    $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);
    wp_redirect(get_the_permalink($sb_packages_page));
    exit;
}