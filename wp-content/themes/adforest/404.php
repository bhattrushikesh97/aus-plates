<?php get_header(); ?>
<?php global $adforest_theme;


$title  =    isset($adforest_theme['sb_404_title'])  ?   $adforest_theme['sb_404_title']  : esc_html__( 'Sorry, this page does not exist.', 'adforest' );

$desc  =    isset($adforest_theme['sb_404_description'])  ?   $adforest_theme['sb_404_description']  :  "";

?>
<section class="custom-padding error-page pattern-bg ">
<div class="container">
<div class="row">
  <div class="col-md-12 col-xs-12 col-sm-12">
     <div class="error-container">
        <div class="error-text"><?php echo esc_html__( '404', 'adforest' ); ?></div>
        <div class="error-info"><?php echo  esc_html($title )?></div>
        <div class="error-desc">  <?php  echo ($desc); ?>  </div>
     </div>
  </div>
     </div>
</div>
</section>
<?php get_footer(); ?>