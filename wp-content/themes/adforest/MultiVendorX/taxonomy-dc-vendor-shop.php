<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/taxonomy-dc_vendor_shop.php
 *
 * @author 		WC Marketplace
 * @package 	WCMp/Templates
 * @version   2.2.0
 */
global $MVX;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Get vendor
$vendor = get_mvx_vendor_by_term (get_queried_object()->term_id);
if(!$vendor){
	// Redirect if not vendor
	wp_safe_redirect(get_permalink( woocommerce_get_page_id( 'shop' ) ));
	exit();
}
$is_block = get_user_meta($vendor->id, '_vendor_turn_off' , true);


if($is_block) {
	get_header( 'shop' ); ?>
	<?php
	/**
	 * woocommerce_before_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
	?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

	<?php endif; ?>

	<?php do_action( 'woocommerce_archive_description' );
	$block_vendor_desc = apply_filters('wcmp_blocked_vendor_text', __('Site Administrator has blocked this vendor', 'dc-woocommerce-multi-vendor'), $vendor);
	?>
    <p class="blocked_desc">
		<?php echo esc_attr($block_vendor_desc); ?>
    <p>
	<?php
	/**
	 * woocommerce_after_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
	?>

	<?php
	/**
	 * woocommerce_sidebar hook
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );
	?>

	<?php get_footer( 'shop' );

} else {
	if ( apply_filters( 'wcmp_load_default_vendor_store', false ) ) {
		wc_get_template( 'archive-product.php' );
	} else {
		$MVX->template->get_store_template('mvx-archive-page-vendor.php');
	}
}