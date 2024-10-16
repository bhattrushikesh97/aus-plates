<?php
global $adforest_theme;
$footer_logo = isset($adforest_theme['footer_logo']['url']) ? $adforest_theme['footer_logo']['url'] : ADFOREST_IMAGE_PATH . "/footer-logo.png";
$footer_desc = isset($adforest_theme['footer_description']) ? $adforest_theme['footer_description'] : "";
$social_icons = isset($adforest_theme['footer_social_icons']) ? $adforest_theme['footer_social_icons'] : array();

$section1_title = isset($adforest_theme['section_1_title']) ? $adforest_theme['section_1_title'] : esc_html__('Quick Links', 'Adforest');
$section2_title = isset($adforest_theme['section_2_title']) ? $adforest_theme['section_2_title'] : esc_html__('Hot Links', 'Adforest');
$section3_title = isset($adforest_theme['section_3_title']) ? $adforest_theme['section_3_title'] : esc_html__('Recent Posts', 'Adforest');
$section4_title = isset($adforest_theme['section_4_title']) ? $adforest_theme['section_4_title'] : esc_html__('Our Info', 'Adforest');

$footer_contact_details = isset($adforest_theme['footer-contact-details']) ? $adforest_theme['footer-contact-details'] : array();


$footer_contact_details = isset($adforest_theme['footer-contact-details']) ? $adforest_theme['footer-contact-details'] : array();

$footer_style =  isset($adforest_theme['footer_style'])   ?   $adforest_theme['footer_style']  :  11;
?>

<!---Footer-->
<footer class="wheel-footer">
    <div class="container">  
        <?php if (isset($adforest_theme['section_3_mc']) && $adforest_theme['section_3_mc'] ) { ?>
            <div class="will-never">
                <div class="row">
                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12">
                        <div class="will-never-send">
                            <h3><?php echo isset($adforest_theme['mc_title']) ? $adforest_theme['mc_title'] : ""; ?></h3>
                            <p><?php echo isset($adforest_theme['mc_description']) ? $adforest_theme['mc_description'] : ""; ?></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                       <form>
                                    <input name="sb_email" id="sb_email" placeholder="Enter your email address" type="text" autocomplete="off" required="">
                                    <input class="submit-btn btn-theme" id="save_email" value="Submit" type="button">
                                    <input class="submit-btn no-display" id="processing_req" value="Processing..." type="button" style="display: none;">
                                    <input type="hidden" id="sb_action" value="footer_action">
                                </form>

                    </div>
                </div>
            </div>


        <?php } ?>
        <!--Footer Row-->
        <div class="row">
            <!--Footer Logo-->
            <div class="col-12 col-md-12 col-lg-4">
                <div class="wheel-logo-img">
                    <a href="<?php echo esc_url(home_url()); ?>">
                    <img src="<?php echo esc_url($footer_logo); ?>"   alt="<?php echo esc_html__('logo','adforest') ?>">
                </a>
                </div>
                <div class="footer-p-heading">
                    <p><?php echo esc_html($footer_desc) ?></p>
                </div>
                <!--Payment Method-->
                <div class="follow-heading">
                    <h2><?php echo esc_html__('Follow Us', 'adforest') ?></h2>
                    <div class="heading-dots browse-type-dot clearfix">
                        <span class="h-dot line-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                    </div>
                    <ul class="socials-links">
                        <?php
                        if (!empty($social_icons)) {
                            foreach ($social_icons as $index => $val) {
                                if ($val != "") {  ?>
                                    
                                    
                        <li><a  href="<?php echo esc_url($val)?>" <?php  do_action('adforest_relation_follow_links') ?> ><i class=" <?php echo  adforest_social_icons($index) ?> "></i></a></li>
                                   
                               <?php  }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <!--Footer Contact-->
            <div class="col-lg-2 col-6 col-sm-6 col-md-6 ">
                <div class="contact-heading">
                    <h2><?php echo esc_html($section1_title) ?></h2>
                    <div class="heading-dots like-also-dot clearfix">
                        <span class="h-dot line-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                    </div>
                </div>

                <ul class="links-items">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_1'
                    ));
                    ?>
                </ul>

            </div>

            <!--Footer Category-->	
            <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                <div class="info-filter">
                    <h2><?php echo esc_html($section2_title) ?></h2>
                    <div class="heading-dots like-also-dot clearfix">
                        <span class="h-dot line-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                    </div>
                </div>
                <ul class="links-items">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_2'
                    ));
                    ?>
                </ul>
            </div>

            <!--Footer Category-->	
            <div class="col-6 col-sm-6 col-md-6 col-lg-2 filter">
                <div class="perfomance-explore">
                    <h2><?php echo esc_html($section3_title) ?></h2>
                    <div class="heading-dots like-also-dot clearfix">
                        <span class="h-dot line-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                    </div>
                </div>
                <ul class="links-items">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_3'
                    ));
                    ?>
                </ul>  
            </div>
            <!--Footer Quick Link-->
            <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                <div class="city-links">
                    <h2><?php echo esc_html($section4_title) ?></h2>
                    <div class="heading-dots like-also-dot clearfix">
                        <span class="h-dot line-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                        <span class="h-dot"></span>
                    </div>
                </div>
                <ul class="links-items">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_4'
                    ));
                    ?>
                </ul>

            </div>
        </div><!--End Footer Row-->
    </div>

</footer>


<div class="<?php   echo esc_attr($footer_style)  == 1  ?  "footer-black"  :  '' ;?>" >
<div class="links-items-contact">
    <div class="container">
        <div class="row">

            <?php
            foreach ($adforest_theme['footer-contact-details'] as $ar => $val) {
                if ($ar == "Address" && $val != "") {
                    echo '<div class="col-12 col-md-6 col-lg-6 col-xl-3">
                <div class="location-address">
                    <div class="address-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="addess-heading">
                       <h3>' . esc_html__('Address', 'adforest') . '</h3>
                        <p>' . $val . '</p>
                    </div>
                </div>
            </div>';
                } else if ($ar == "Phone" && $val != "") {
                    echo '  <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                <div class="phone-num">
                    <div class="num-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="num-heading">
                        <h3>' . esc_html__('Phone', 'adforest') . '</h3>
                       <p>' . $val . '</p>
                    </div>
                </div>
            </div>';
                } else if ($ar == "Email" && $val != "") {
                    echo ' <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                <div class="gmail-map">
                    <div class="gmail-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="gmail-heading">
                       <h3>' . esc_html__('Email', 'adforest') . '</h3>
                        <p>' . $val . '</p>
                    </div>
                </div>
            </div>';
                } else if ($ar == "Timing" && $val != "") {
                    echo ' <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                <div class="wb-links">
                    <div class="wb-icon">
                        <i class="fa fa-calendar-o"></i>
                    </div>
                    <div class="wb-heading">
                     <h3>' . esc_html__('Timing', 'adforest') . '</h3>
                        <p>' . $val . '</p>
                    </div>
                </div>
            </div>';
                }
            }
            ?>   
        </div>
    </div>
</div>
</div>

<!-- Copyright -->

<?php
$footer_text = isset($adforest_theme['sb_footer']) ? $adforest_theme['sb_footer'] : "";

if ($footer_text != "") {
    ?>
    <div class="copyright-heading">
        <div class="row theme-created">
            <div class="col-md-12 col-sm-12 cpy_right">
                <?php echo adforest_returnEcho($footer_text); ?>
            </div>
        </div>
    </div>
    <?php
}