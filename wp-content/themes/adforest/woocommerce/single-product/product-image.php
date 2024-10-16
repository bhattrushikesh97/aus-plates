<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */
defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters(
        'woocommerce_single_product_image_gallery_classes',
        array(
            'woocommerce-product-gallery',
            'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
            'woocommerce-product-gallery--columns-' . absint($columns),
            'images',
        )
);
?>
<!-- Place somewhere in the <body> of your page -->
<div id="slider-product" class="flexslider">
    <ul class="slides slide-main gallery"><?php
        $attachment_ids = $product->get_gallery_image_ids(); 
        $title = get_the_title();
        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'adforest_single_product');  

        if($product_image != ""){?>        
        <li class=""><div><a href="<?php echo esc_url($product_image[0]); ?>" data-caption="<?php echo esc_attr($title); ?>" data-fancybox="group"><img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($product_image[0]); ?>"></a></div></li>        
        <?php 
 
        $attachment_ids[]   =   $product_image;
        if (count($attachment_ids) > 0) {
            foreach ($attachment_ids as $m) {
                $img = wp_get_attachment_image_src($m, 'adforest_single_product');
                $full_img = wp_get_attachment_image_src($m, 'full');
                if (!isset($img[0])) {
                    continue;
                }
                $slider_img = $img[0];
   
                ?><li class=""><div><a href="<?php echo esc_url($full_img[0]); ?>" data-caption="<?php echo esc_attr($title); ?>" data-fancybox="group"><img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($slider_img); ?>"></a></div></li>
                <?php
            }
        }}
        else{   ?>
            <li class=""><div><a href="<?php echo wc_placeholder_img_src('adforest_single_product') ?>" data-caption="<?php echo esc_attr($title); ?>" data-fancybox="group"><img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url(wc_placeholder_img_src()); ?>"></a></div></li>
      <?php   }
        ?></ul>
</div>
<?php if (count($attachment_ids) > 0) {  ?>
<div id="carousel-product" class="flexslider">
    <ul class="slides slide-thumbnail">
      <?php   if(isset($product_image[0])){?>        
        <li class=""><div><img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($product_image[0]); ?>"></div></li>        
      <?php }  ?> 
       
        <?php
            foreach ($attachment_ids as $m) {
                $img = wp_get_attachment_image_src($m, 'adforest_single_product');
                if (!isset($img[0]))
                    continue;
                ?><li><img alt="<?php echo esc_attr($title); ?>" draggable="false" src="<?php echo esc_attr($img[0]); ?>"></li><?php
            }
        ?></ul>
</div>
<?php } 