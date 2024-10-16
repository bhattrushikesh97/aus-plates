 <?php
     
 ?>
 <div class="profile-content">
                    <div class="profile-header">
                        <div class="profile-main-img">
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($author->ID), 'type', 'ads'); ?>">
                            
                            <img src="<?php echo esc_attr($user_pic); ?>" id="user_dp" alt="<?php echo __('Profile Picture', 'adforest'); ?>" class="img-fluid">
                            </a> 
                            <?php

                            if (get_user_meta($author->ID, '_sb_is_ph_verified', true) == '1') {
                                ?>
                                <i class="fa fa-check-circle  <?php echo get_user_meta($author->ID, '_sb_badge_type', true); ?>"></i>
                                <?php
                            }
                            ?>

                        </div>
                        <?php
                        $user_type = '';
                  
                        if (get_user_meta($author->ID, '_sb_user_type', true) == 'Indiviual') {
                            $user_type = __('Individual', 'adforest');
                        } else if (get_user_meta($author->ID, '_sb_user_type', true) == 'Dealer') {
                            $user_type = __('Dealer', 'adforest');
                        }
                        if ($user_type != "") {
                            ?>                       
                            <div class="profile-dealer"><span class="pro-dealer"><?php echo adforest_returnEcho($user_type); ?></span></div> 
                        <?php }

                         if (get_user_meta($author->ID, '_sb_badge_text', true) != "" && isset($adforest_theme['sb_enable_user_badge']) && $adforest_theme['sb_enable_user_badge']) {
                                ?>
                             
                 <div class="profile-dealer verify-bage"><span class="pro-dealer2 label <?php echo get_user_meta($author->ID, '_sb_badge_type', true); ?>"><?php echo adforest_returnEcho(get_user_meta($author->ID, '_sb_badge_text', true)); ?></span></div> 
                                <?php
                            }
                            ?>

                    </div>
                    <div class="profile-heading">   
                       <h4><a href="<?php echo adforest_set_url_param(get_author_posts_url($author->ID), 'type', 'ads'); ?>"><?php echo esc_html($author->display_name); ?></a></h4>
                        <?php
                        if ( isset($adforest_theme['sb_enable_user_ratting']) && $adforest_theme['sb_enable_user_ratting']) {
                            ?>
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($author->ID), 'type', 1); ?>">
                               <ul class="star-listing">
                                    <?php
                                    $got = get_user_meta($author->ID, "_adforest_rating_avg", true);
                                       
                                    //$got = count(adforest_get_all_ratings($author_id));
                                    $total = 0;
                                    if ($got == "")
                                        $got = 0;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= round($got))
                                            echo '<li><i class="fa fa-star"></i></li>';
                                        else
                                            echo '<li><i class="fa fa-star-o"></i></li>';

                                        $total++;
                                    }
                                    ?>
                                    <span class="rating-count count-clr">
                                        (<?php
                                        $ratings = adforest_get_all_ratings($author_id);
                                        echo count($ratings);

                                      
                                        ?>)
                                    </span>
                               </ul>
                            </a>
                            <?php
                        }
                        ?>

                    </div>

                    <div class="sold-listing">
                        <div class="ad-sold">
                            <h4><?php echo adforest_get_sold_ads($author->ID); ?></h4>
                            <h5><?php echo __('Ad Sold', 'adforest'); ?></h5>
                        </div>
                        <div class="tot-listing">
                            <h4><?php echo adforest_get_all_ads($author->ID); ?></h4>
                            <h5><?php echo __('Total Listings', 'adforest'); ?></h5>
                        </div>
                    </div>

                    <div class="add-phone">
                        <ul class="add-phone-list">
                            
                           <?php   if ($contact_num != "" ) {         
                               if(adforest_showPhone_to_users()){ 
                                   $call_now = "javascript:void(0)";
                                                $adforest_login_page = isset($adforest_theme['sb_sign_in_page']) ? $adforest_theme['sb_sign_in_page'] : '';
                                                $adforest_login_page = apply_filters('adforest_language_page_id', $adforest_login_page);
                                                if ($adforest_login_page != '') {

                                                    $redirect_url = adforest_login_with_redirect_url_param(adforest_get_current_url());
                                                    $call_now = $redirect_url;
                                                }
                                   
                                   
                                   ?>
                                    <li>    <a href="<?php echo esc_url($redirect_url); ?>" class="sb-click-num-user2 phone-list" id="show_ph_div" data-user_id = "<?php echo esc_attr($author->ID); ?>">
                                    <span class="info-heading"><i class="fa fa-phone"></i> <?php echo esc_html__('Phone:','adforest') ?> </span>
                                <span class="sb-phonenumber"><?php echo esc_html__('Login To View','adforest') ?></span>
                                </a></li>
                                   
                             <?php   }  else {
                      ?>    
                            <li>    <a href="javascript:void(0);" class="sb-click-num-user phone-list" id="show_ph_div" data-user_id = "<?php echo esc_attr($author->ID); ?>">
                                    <span class="info-heading"><i class="fa fa-phone"></i> <?php echo esc_html__('Phone:','adforest') ?> </span>
                                <span class="sb-phonenumber"><?php echo esc_html__('Click To View','adforest') ?></span>
                                </a></li>                           
                           <?php }      }                                                
                           ?>                             
                      <li><a href="javascript:void(0)" class="address-list"><span><i class="fa fa-location-arrow"></i> <?php echo esc_html__('Address:','adforest');?> </span> <?php echo get_user_meta($author->ID, '_sb_address', true); ?> </a></li>
                                <li><a href="javascript:void(0)" class="hour-list"><span><i class="fa fa-calendar"></i><?php echo esc_html__('Last Active:','adforest') ?></span> <?php  printf( _x( '%s Ago', 'Last login time', 'adforest' ), adforest_get_last_login($author->ID) );?></a></li>
                        </ul>
                    </div>
             
            <?php  $profiles = adforest_social_profiles();
            
            if(is_array( $profiles ) && !empty( $profiles)){  ?>
                    <div class="profile-social">
                        <div class="social-heading">
                            <h4><?php echo esc_html__('Social links','adforest') ?></h4>
                        </div>
                        <div class="social-link-list">
                            <?php
                            $social_icons = '<ul class="social-item">';
                           
                            foreach ($profiles as $key => $value) {
                               
                                if (get_user_meta($author->ID, '_sb_profile_' . $key, true) != "") {

                                    $social_icons .= '<li><a href="' . esc_url(get_user_meta($author->ID, '_sb_profile_' . $key, true)) . '" target="_blank"><i class="fa fa-' . $key . '"></i></a></li>';
                                }
                            }
                            $social_icons .= '</ul>';
                            echo adforest_returnEcho($social_icons);
                            ?>
                        </div>
                    </div>
      
                     <?php }  ?>
                        
                   <?php  if (get_user_meta($author_id, '_sb_user_intro', true) != "") {  ?>
                    <div class="profile-introduction">
                        <h3><?php echo __('Introduction', 'adforest'); ?></h3>
                        <p><?php echo get_user_meta($author_id, '_sb_user_intro', true); ?></p>                       
                    </div>                 
                   <?php }  ?>
                    
                      <?php
                    require trailingslashit(get_template_directory()) . 'template-parts/layouts/profile/contact_form.php';
                    ?>             
                </div>
