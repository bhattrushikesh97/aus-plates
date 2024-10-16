<?php
global $adforest_theme;
$pid = get_the_ID();
$address = get_post_meta($pid, '_adforest_ad_location', true);
?>
<div class="clearfix"></div>

<div class="descs-box" id="description">
    <?php 
    
  $style  =  isset($adforest_theme['ad_layout_style'])  ?  $adforest_theme['ad_layout_style'] : 1;
     if(  $style != 1){
    get_template_part('template-parts/layouts/ad_style/short', 'features');
    }
    ?>
    <div class="desc-points">
        <?php
        $contents = get_the_content();
        $contents =  apply_filters( 'the_content', $contents );
        echo adforest_returnEcho($contents);
        ?>
         <?php do_action('adforest_owner_text');?>
    </div>
   
      
      <?php get_template_part('template-parts/layouts/ad-style/ad', 'tags');?>
    <?php
    if (get_post_meta($pid, '_adforest_ad_yvideo', true) != "") {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($pid, '_adforest_ad_yvideo', true), $match);

        if (isset($match[1]) && $match[1] != "") {

            $video_id = $match[1];
            ?><div class="ad-detail-video"><div id="video">
                
                    <h3><?php echo esc_html__('Video','adforest') ?></h3>
                <?php
                $iframe = 'iframe';
                echo '<' . $iframe . ' width="560" height="450" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></' . $iframe . '>';
                ?>
            </div>
            </div>
            <?php
        }
    }
    ?> 
    <?php
    if (isset($adforest_theme['allow_lat_lon']) && $adforest_theme['allow_lat_lon']) {
        ?>
   
                    
    <div id="map-location" class="map-location"> 
        <h3><?php echo esc_html__('Location','adforest') ?></h3>
          <?php    if (get_post_meta($pid, '_adforest_ad_location', true) != "") {
              
                       echo '<span><i class="fa fa-map-marker"></i>'.get_post_meta($pid, '_adforest_ad_location', true).'</span>';
              
                        }?>
            <?php
            $map_lat = get_post_meta($pid, '_adforest_ad_map_lat', true);
            $map_long = get_post_meta($pid, '_adforest_ad_map_long', true);
            if ($map_lat != "" && $map_long != "") { ?>
                <div id="itemMap" style="width: 100%; height: 370px; margin-bottom:5px;"></div>
                <input type="hidden" id="lat" value="<?php echo esc_attr($map_lat);?>" />
                <input type="hidden" id="lon" value="<?php echo esc_attr($map_long);?>" />
            <?php } else {
                $res_arr = adforest_get_latlon($address);
                if (isset($res_arr) && count($res_arr) > 0) {
                    ?>
                    <div id="itemMap" style="width: 100%; height: 370px; margin-bottom:5px;"></div>
                    <input type="hidden" id="lat" value="<?php echo esc_attr($res_arr[0]);?>" />
                    <input type="hidden" id="lon" value="<?php echo esc_attr($res_arr[1]);?>" />
                    <?php
                }
            }
            ?>
        </div>
        <?php } ?>
    <div class="clearfix"></div>
    <span id="bids"></span>
    <?php
    if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true) != "0") {
        if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 1) {
            echo adforest_html_bidding_system($pid);
        } else if (isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true) == 0) {
            
        } else {
            echo adforest_html_bidding_system($pid);
        }
        ?>
        <?php } ?>
</div>	