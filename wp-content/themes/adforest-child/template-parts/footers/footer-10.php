<?php global $adforest_theme; ?>
<!--New Foter-->
<?php
$footer_class = '';
$style = ' style="color:#FFF"';
if (isset($adforest_theme['design_type']) && $adforest_theme['design_type'] == 'modern' && isset($adforest_theme['footer_color']) && $adforest_theme['footer_color'] == 'new-demo') {
    $footer_class = $adforest_theme['footer_color'];
    $style = ' style="color:#000"';
}
?>
<section class="section-footer-bottom-mlt">
    <div class="footer-15-inner">
        <div class="container container-15-custom">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="footer-heading">
                        <h3><?php echo esc_html($adforest_theme['section_1_title']); ?></h3>
                        <hr class="line-bottom">
                    </div>
                    <div class="footer-15-widget footer-15-first-row">
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
                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="footer-heading">
                        <h3><?php echo esc_html($adforest_theme['section_2_title']); ?></h3>
                        <hr class="line-bottom">
                    </div>
                    <div class="footer-15-widget">
                        <ul>
                            <?php
                            if (isset($adforest_theme['sb_footer_pages'])) {
                                foreach ($adforest_theme['sb_footer_pages'] as $foot_page) {
                                    $foot_page = apply_filters('adforest_language_page_id', $foot_page);
                                    echo '<li><a href="' . esc_url(get_the_permalink($foot_page)) . '">' . esc_html(get_the_title($foot_page)) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4  clearfix">
                    <div class="footer-heading">
                        <h3><?php echo esc_html($adforest_theme['section_3_title']); ?></h3>
                        <hr class="line-bottom">
                    </div>
                    <div class="footer-15-text">
                        <ul>
                            <li class="text-capitalize">
                                <p><?php echo esc_html($adforest_theme['section_3_text']); ?></p>
                            </li>
                            <?php
                            if (isset($adforest_theme['section_3_mc']) && $adforest_theme['section_3_mc']) {
                                ?>
                                <li class="text-capitalize">
                                    <form>
                                        <div class="input-group margin-top-30">
                                            <input type="email" class="form-control" name="sb_email" id="sb_email"
                                                   placeholder="<?php echo __('Enter your email address', 'adforest');?>"
                                                   aria-describedby="basic-addon2">
                                            <span class="input-group-addon" id="basic-addon2">
                                                <a href="javascript:void(0);" id="save_email">
                                                    <i class="fa fa-long-arrow-right"></i>
                                                </a>
                                            </span>
                                            <span class="input-group-addon no-display" id="processing_req">
                                                <a href="javascript:void(0);">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </a>
                                            </span>
                                            <input type="hidden" id="sb_action" value="footer_action" />
                                        </div>
                                    </form>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="social-15-links clearfix margin-top-30">
                        <?php
                        foreach ($adforest_theme['social_media'] as $index => $val) {
                            $all_socials = array(
                                'Facebook' => __('Facebook', 'adforest'),
                                'Twitter' => __('Twitter', 'adforest'),
                                'Linkedin' => __('Linkedin', 'adforest'),
                                'Google' => __('Google', 'adforest'),
                                'YouTube' => __('YouTube', 'adforest'),
                                'Vimeo' => __('Vimeo', 'adforest'),
                                'Pinterest' => __('Pinterest', 'adforest'),
                                'Tumblr' => __('Tumblr', 'adforest'),
                                'Instagram' => __('Instagram', 'adforest'),
                                'Reddit' => __('Reddit', 'adforest'),
                                'Flickr' => __('Flickr', 'adforest'),
                                'StumbleUpon' => __('StumbleUpon', 'adforest'),
                                'Delicious' => __('Delicious', 'adforest'),
                                'dribble' => __('dribble', 'adforest'),
                                'behance' => __('behance', 'adforest'),
                                'DeviantART' => __('DeviantART', 'adforest'),
                            );
                            if ($val != "") {
                                ?>
                                <a class="<?php echo esc_attr($index); ?>" href="<?php echo esc_url($val); ?>">
                            <span class="<?php echo adforest_social_icons($index); ?>"></span></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="footer-heading">
                        <?php
                        if (isset($adforest_theme['footer_logo']['url']) && $adforest_theme['footer_logo']['url'] != "") {
                            ?>
                            <div class="logo"><a href="<?php echo get_site_url(); ?>"><img
                                            alt="<?php echo esc_attr__('Site Logo', 'adforest'); ?>"
                                            class="img-fluid"
                                            src="<?php echo esc_url($adforest_theme['footer_logo']['url']); ?>"></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="footer-15-about about-widget">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($footer_class != '') {
        ?>
        <div class="footer-15-copyright">
            <div class="container clearfix">
                <?php
                if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                    echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
                } else {
                    echo wp_kses("Copyright 2021 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", adforest_required_tags());
                }
                ?> </div>
        </div>
        <?php
    }
    ?>
    <?php
    if ($footer_class == '') {
        ?>
        <div class="footer-15-copyright">
            <div class="container clearfix">
                <?php
                if (isset($adforest_theme['sb_footer']) && $adforest_theme['sb_footer'] != "") {
                    echo wp_kses($adforest_theme['sb_footer'], adforest_required_tags());
                } else {
                    echo wp_kses("Copyright 2017 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", adforest_required_tags());
                }
                ?></div>
        </div>
    <?php } ?>
</section>