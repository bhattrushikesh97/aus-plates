<?php global $adforest_theme; ?>
<?php
$author_id = get_query_var('author');
$author = get_user_by('ID', $author_id);
$user_pic = adforest_get_user_dp($author_id, 'adforest-user-profile');
$contact_num = get_user_meta($author->ID, '_sb_contact', true);
?>
<section class="profile-page">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
            <?php     require trailingslashit(get_template_directory()) . 'template-parts/layouts/profile/profile-header.php'; ?>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">  
                <?php
                    if (have_posts() > 0 && in_array('sb_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        while (have_posts()) {
                            the_post();
                            $pid = get_the_ID();
                           
                            echo adforest_returnEcho(adforest_search_layout_list_5($pid));
                            ?>
                            <?php
                        }
                    } else {


                   $no_found =  get_template_directory_uri() . '/images/nothing-found.png';

                        ?>
                    <div class="col-xl-12 col-12 col-sm-12 col-md-12">
                        <div class="nothing-found white">
                        <img src="<?php echo esc_url($no_found); ?>" alt="">
                    <h3><?php echo esc_html__('No Result Found','adforest') ?></h3>
                  </div> 
                    </div>
                  <?php   }
                     ?>
                <div class="clearfix"></div>
                    <div class="pagination-item">
                        <?php adforest_pagination(); ?>
                    </div>         
            </div>
        </div>
    </div>
</section>