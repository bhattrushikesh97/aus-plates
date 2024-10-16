<?php global $adforest_theme;?>
<?php
$is_bg = 'no-bg';
$style = ' style="color:#000"';
if (isset($adforest_theme['footer_options']) && $adforest_theme['footer_options'] == 'with_bg') {
    $is_bg = '';
    $style = ' style="color:#FFF"';
}


$section1_title = isset($adforest_theme['section_1_title']) ? $adforest_theme['section_1_title'] : esc_html__('Quick Links', 'Adforest');

$section2_title = isset($adforest_theme['section_2_title']) ? $adforest_theme['section_2_title'] : esc_html__('Hot Links', 'Adforest');

$section3_title = isset($adforest_theme['section_3_title']) ? $adforest_theme['section_3_title'] : esc_html__('Recent Posts', 'Adforest');


$section4_title = isset($adforest_theme['section_4_title']) ? $adforest_theme['section_4_title'] : esc_html__('Our Info', 'Adforest');
?>


<footer class="footer-area sb-foot-1 <?php echo esc_attr($is_bg);?>">
<div class="footer-content">
    <div class="container">
        <div class="row clearfix">
            <!--Two 4th column-->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row clearfix">
                    <div class="col-lg-7 col-xl-7 col-xxl-7 col-sm-6 col-xs-12 column">
                        <div class="footer-widget about-widget">
                            <div class="logo">
                                <a href="<?php echo home_url('/');?>">
                                    <?php if (isset($adforest_theme['footer_logo']['url']) && $adforest_theme['footer_logo']['url'] != "") { ?><img src="<?php echo esc_url($adforest_theme['footer_logo']['url']);?>" class="img-fluid" alt="<?php echo esc_attr__('Site Logo', 'adforest');?>">
                                        <?php } else {  ?><img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png'?>" class="img-fluid" alt="<?php echo esc_attr__('Site Logo', 'adforest');?>" /><?php } ?></a>
                            </div>
                            <div class="text">
                                <p></p>
                            </div>
                            <ul class="contact-info">
                                <?php
                                foreach ($adforest_theme['footer-contact-details'] as $ar => $val) {
                                    if ($ar == "Address" && $val != "") {
                                        echo '<li><i class="icon fa fa-home"></i> ' . esc_html($val) . '</li>';
                                    } else if ($ar == "Phone" && $val != "") {
                                        echo '<li><i class="icon fa fa-phone"></i> ' . esc_html($val) . '</li>';
                                    } else if ($ar == "Fax" && $val != "") {
                                        echo '<li><i class="icon fa fa-fax"></i> ' . esc_html($val) . '</li>';
                                    } else if ($ar == "Email" && $val != "") {
                                        echo '<li><i class="icon fa fa-envelope-o"></i> ' . esc_html($val) . '</li>';
                                    } else if ($ar == "Timing" && $val != "") {
                                        echo '<li><i class="icon fa fa-clock-o"></i> ' . esc_html($val) . '</li>';
                                    }
                                }
                                ?>                        
                            </ul>
                            <div class="social-links-two clearfix"> 
                                <?php
                                foreach ($adforest_theme['social_media'] as $index => $val) { ?> <?php
                                    if ($val != "") { ?><a <?php do_action('adforest_relation_follow_links');?>class="img-circle" href="<?php echo esc_url($val);?>"><span class="<?php echo adforest_social_icons($index);?>"></span></a><?php  }  }  ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xxl-5  col-xl-5   col-sm-6 col-xs-12 column">
                        <div class="heading-panel">
                            <div class="main-title text-left"<?php echo adforest_returnEcho($style);?>><?php echo esc_html($section2_title);?></div>
                        </div>
                        <div class="footer-widget links-widget">
                            <ul><?php
                                if (isset($adforest_theme['sb_footer_pages'])) {
                                    foreach ($adforest_theme['sb_footer_pages'] as $foot_page) {
                                        $foot_page = apply_filters('adforest_language_page_id', $foot_page);
                                        echo '<li><a href="' . esc_url(get_the_permalink($foot_page)) . '">' . esc_html(get_the_title($foot_page)) . '</a></li>';
                                    }
                                }
                                ?></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 col-xl-6 col-xxl-6" >
                <div class="row clearfix">
                    <!--Footer Column-->
                    <div class="col-lg-7 col-sm-6 col-xs-12 column">
                        <div class="footer-widget news-widget">
                            <div class="heading-panel">
                                <div class="main-title text-left"<?php echo adforest_returnEcho($style);?>><?php echo esc_html($section3_title);?></div>
                            </div>
                            <?php
                            $params = array(
                                'orderby' => 'date',
                                'post_type' => 'post',
                                'posts_per_page' => $adforest_theme['footer_post_numbers'],
                                'meta_query' => array(array('key' => '_thumbnail_id', 'compare' => 'EXISTS'))
                            );

                            $foot_posts = get_posts($params);
                            if (count($foot_posts) > 0) {
                                foreach ($foot_posts as $post_f) {
                                    $response = adforest_get_feature_image($post_f->ID, 'adforest-single-small');
                                    ?>
                                    <div class="news-post">
                                        <div class="icon"></div>
                                        <div class="news-content">
                                            <?php if (isset($response[0]) && $response[0] != "") { ?><figure class="image-thumb"><img src="<?php echo esc_url($response[0]);?>" alt="<?php echo esc_attr(get_the_title($post_f->ID));?>"></figure><?php  } ?><a href="<?php echo esc_url(get_the_permalink($post_f->ID));?>"><?php echo get_the_title($post_f->ID);?></a>
                                        </div>
                                        <div class="time"><?php echo get_the_date(get_option('date_format'), $post_f->ID);?></div>
                                    </div>
                                    <?php }  ?>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!--Footer Column-->
                    <div class="col-lg-5 col-sm-6 col-xs-12 column  col-xl-5 col-xxl-5">
                        <div class="footer-widget links-widget">
                            <div class="heading-panel">
                                <div class="main-title text-left"<?php echo adforest_returnEcho($style);?>><?php echo esc_html($section4_title);?></div>
                            </div>
                            <ul>
                                <?php
                                if (isset($adforest_theme['sb_footer_links'])) {
                                    foreach ($adforest_theme['sb_footer_links'] as $foot_page) {
                                        $foot_page = apply_filters('adforest_language_page_id', $foot_page);
                                        echo '<li><a href="' . esc_url(get_the_permalink($foot_page)) . '">' . esc_html(get_the_title($foot_page)) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-copyright">
    <div class="container clearfix">
        <div class="copyright text-center">
            <?php
            if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
            } else {
                echo wp_kses("Copyright 2021 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", adforest_required_tags());
            }
            ?>
        </div>
    </div>
</div>
</footer>	