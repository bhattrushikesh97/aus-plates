<?php

if (!class_exists('ads')) {

    class ads {

        var $obj;

        public function __construct() {
            
        }

        function adforest_search_layout_list_4($pid) {
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid" height="127" width="169"> </a>';
                    break;
                }
            } else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
            }
            $ad_title = wp_trim_words(get_the_title(), 5, '...');

            $html = '';
            $html .= '<div class="prop-real-estates"><div class="prop-estate-image-section">' . ($img) . '</div><div class="prop-real-estate-box"><div class="prop-estate-text-section"><a href="' . get_the_permalink() . '"><div class="directory-ad-title">' . esc_html($ad_title) . '</div></a><a href="javascript:void(0)"> <p><i class="fa fa-map-marker"></i>' . adforest_words_count(get_post_meta(get_the_ID(), '_adforest_ad_location', true), 20) . '</p></a><span>' . adforest_adPrice(get_the_ID(), '', '') . '</span> </div><div class="prop-estate-table"><ul class="list-inline prop-content-area"><li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li><li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li></ul></div></div></div>';

            return $html;
        }

        /* Search Layout list one */

        function adforest_search_layout_list_1($pid, $is_show = true) {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $total_view = 0;
            if (class_exists('Post_Views_Counter')) {
                $pre_view = (int) adforest_getPostViews($pid);
                $ad_view = (int) pvc_get_post_views($pid);
                $total_view = $pre_view + $ad_view;
            } else {
                $total_view = adforest_getPostViews($pid);
            }
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-list');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-list') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }
            $cats_html = adforest_display_cats($pid);
            $cat_class = "no_cats";

            if ($cats_html != "") {
                $cat_class = "";
                $cats_html = '<div class="category-title">' . $cats_html . '</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $rtl_fet = 'featured-ribbon';
                if (is_rtl()) {
                    $rtl_fet = 'featured-ribbon-rtl';
                }
                $is_feature = '<div class="red-white-star">
                 <i class="fa fa-star"></i>
             </div>';
            }
            $author_id = get_post_field('post_author', $pid);
            $author_data = get_userdata($author_id);
            $author_name = $author_data->display_name;

            $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
            if ($poster_name == "") {

                $poster_name = $author_name;
            }
            $dp = "";
            if (function_exists('adforest_get_user_dp')) {
                $dp = adforest_get_user_dp($author_id);
            }

            ;

            $poster_contact = '';
            if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {
                $poster_contact = '<li> <a href="javascript:void(0);"><i class="flaticon-phone-call"></i>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</a></li>';
            }
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }
            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = 'ad_to_fav ad-favourited';
            }


            return '<div class="col-lg-12 col-md-12 col-sm-12">

    <figure class="great-product">
        <div class="great-product-herro">
            ' . $img . '
            <div class="aln-img">
                <img src="' . esc_url($dp) . '" alt=' . esc_attr($poster_name) . '>
                <span><a href ="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '">' . $poster_name . '</a></span>
            </div>
            <div class="heart-icons-1">
                <a href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>
            </div>     
            <div class =  "video_icon_container"> ' . adforest_video_icon() . ' </div>
            ' . $is_feature . '
        </div>
        <div class="great-product-content">
            ' . $cats_html . '  
          <div class="star-shining">
                 <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                     <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                      </div>
                 </div>
            <div class="great-product-title">
                <h2 class="great-product-heading"><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h2>
            </div>
            <div class="pro-great-rating">
                <span class="great-date">
                    <i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), $pid) . '
                 </span>
            </div>
            <p>' . adforest_words_count(get_the_excerpt(), 50) . '</p>
            <h4>' . adforest_adPrice($pid, '', '') . '</h4>
            <span><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span>
            <div class="detail-btn-1">
                <a  class="btn btn-theme btn-detail" href="' . get_the_permalink() . '">' . esc_html__('View Detail', 'adforest') . '</a>              
            </div>
        </div>
    </figure>
</div>';
        }

        function adforest_search_layout_list_2($pid, $is_show = true) {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $total_view = 0;
            if (class_exists('Post_Views_Counter')) {
                $pre_view = (int) adforest_getPostViews($pid);
                $ad_view = (int) pvc_get_post_views($pid);
                $total_view = $pre_view + $ad_view;
            } else {
                $total_view = adforest_getPostViews($pid);
            }
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-list');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<a href= "' . get_the_permalink($pid) . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"></a>';
                    break;
                }
            } else {
                $img = '<a href= "' . get_the_permalink($pid) . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-list') . '" alt="' . get_the_title() . '" class="img-fluid"></a>';
            }
            $cats_html = adforest_display_cats($pid);
            $cat_class = "no_cats";

            if ($cats_html != "") {
                $cat_class = "";
                $cats_html = '<div class="category-title">' . $cats_html . '</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $rtl_fet = 'featured-ribbon';
                if (is_rtl()) {
                    $rtl_fet = 'featured-ribbon-rtl';
                }
                $is_feature = '<div class="red-white-star">
                 <i class="fa fa-star"></i>
             </div>';
            }
            $author_id = get_post_field('post_author', $pid);
            $author_data = get_userdata($author_id);
            $author_name = $author_data->display_name;

            $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
            if ($poster_name == "") {

                $poster_name = $author_name;
            }
            $dp = "";
            if (function_exists('adforest_get_user_dp')) {
                $dp = adforest_get_user_dp($author_id);
            }

            $warranty = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {
                $warranty = ' <li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-check-square-o"></i></span><div class="tooltip-content"><strong>' . __('Warranty', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '</span></div></div></li>';
            }
            $condition = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {

                $condition = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-cog"></i></span><div class="tooltip-content"><strong>' . __('Condition', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '</span>
					</div></div></li>';
            }


            $poster_contact = '';
            if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

                $showPhone_to_users = adforest_showPhone_to_users();
                if (!$showPhone_to_users) {
                    $poster_contact = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-phone"></i></span><div class="tooltip-content"><h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</h4></div></div></li>';
                }
            }

            $options_html = '';
            if ($is_show) {
                $options_html = '<ul class="add_info">' . $poster_contact . '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-map-marker"></i></span><div class="tooltip-content">' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</div></div></li>' . $condition . '' . $warranty . '</ul>';
            }
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }
            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = 'ad_to_fav ad-favourited';
            }


            return '<div class="col-lg-12 col-md-12 col-sm-12">

    <figure class="great-product  sb-search-list-2">
        <div class="great-product-herro">
            ' . $img . '
            <div class="aln-img">
                <img src="' . esc_url($dp) . '" alt=' . esc_attr($poster_name) . '>
                <span><a href ="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '">' . $poster_name . '</a></span>
            </div>
            <div class="heart-icons-1">
                <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>
            </div>     
            <div class =  "video_icon_container"> ' . adforest_video_icon() . ' </div>
            ' . $is_feature . '
        </div>
        <div class="great-product-content">
        <h4 class = "sb-list-2-price">' . adforest_adPrice($pid, '', '') . '</h4>
            <div class="great-product-title">
                <h2 class="great-product-heading"><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h2>
            </div>
             ' . $cats_html . '  
           
            <p>' . adforest_words_count(get_the_excerpt(), 120) . '</p>
               ' . $options_html . '
                 <div class="pro-great-rating">
                <span class="great-date">
                   ' . get_the_date(get_option('date_format'), $pid) . '
            </div>        
            <div class="detail-btn-1">
                <a  class="btn btn-theme btn-detail" href="' . get_the_permalink() . '">' . esc_html__('View Detail', 'adforest') . '</a>              
            </div>
        </div>
    </figure>
</div>';
        }

        function adforest_search_layout_grid_1($pid, $col = 6, $sm = 6, $holder = '') {

            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);
            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $outer_html = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1)
                        break;

                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                    }


                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');

                    $image[0] = isset($image[0]) ? $image[0] : "";
                    $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . $image[0] . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
                    $counting++;
                }
            } else {
                $timer_html = '';
                $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                    $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                }

                $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
            }

            //$ad_title = get_the_title();
			$ad_title = mb_strimwidth(get_the_title(), 0, 12, '...');

            /* if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            } */

            $my_ads = '';

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-1-column-2');

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-xxl-' . esc_attr($col) . ' col-xl-' . esc_attr($col) . '  col-md-4  col-lg-4 col-sm-' . esc_attr($sm) . ' ' . $col2_style . '" id="' . $holder . '.holder-' . get_the_ID() . '">';
            }

            $my_ads .= '<div class="white category-grid-box-1 ad-grid-1">
          ' . adforest_video_icon() . '
             ' . $is_feature . '
                ' . $outer_html . '
             <div class="short-description-1 ">
                <div class="category-title"> ' . $cats_html . ' </div>
                <h2><a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a></h2>
                <p class="location"><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p>
                 <span class="ad-price">' . adforest_adPrice(get_the_ID(), '', '') . '</span> 
             </div>
             <div class="ad-info-1">
                <ul class="pull-left ' . esc_attr($flip_it) . '">
                   <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</a> </li>
                   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
                </ul>
                <ul class="pull-right">
                </ul>
             </div>
          </div>
       </div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_2($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<span class="ad-status">' . __('Featured', 'adforest') . '</span>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            ;

            $condition_html = '';
            if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {
                $condition_html = '<p>' . __('Condition', 'adforest') . ": " . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '</p>';
            }

            $ad_type_html = '';
            if (get_post_meta(get_the_ID(), '_adforest_ad_type', true) != "") {
                $ad_type_html = '<p>' . __('Ad Type', 'adforest') . ": " . get_post_meta(get_the_ID(), '_adforest_ad_type', true) . '</p>';
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }


            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-2-column-2');
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $my_ads .= '<div class="category-grid-box ad-grid-2"><div class="category-grid-img">
                 ' . $timer_html . ' ' . $img . ' ' . $is_feature . '<div class="user-preview"><a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '"><img src="' . adforest_get_user_dp($author_id) . '" class="avatar avatar-small" alt="' . get_the_title() . '"></a></div>' . adforest_video_icon(true) . '<a href="' . get_the_permalink() . '" class="view-details">' . __('View Details', 'adforest') . '</a><div class="additional-information"><p>' . __('Posted on', 'adforest') . ": " . get_the_date(get_option('date_format'), get_the_ID()) . '</p> ' . $ad_type_html . ' ' . $condition_html . '</div></div><div class="short-description"><div class="category-title"> ' . $cats_html . ' </div><h2><a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a></h2><div class="price">' . adforest_adPrice(get_the_ID(), '', '') . '</div></div><div class="ad-info">
                    <ul><li><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</li></ul></div></div></div>';
            return $my_ads;
        }

        function adforest_search_layout_grid_3($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"> <span>' . __('Featured', 'adforest') . '</span></div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }
            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-3-column-2');

            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $my_ads .= '<div class="category-grid-box-1 ad-grid-3">' . $is_feature . '' . adforest_video_icon() . '<div class="image"><a href="' . get_the_permalink() . '">' . $img . '</a></div><div class="short-description-1 clearfix"><div class="price-tag"><div class="price"><span>' . adforest_adPrice(get_the_ID(), '', '') . '</span></div></div><div class="category-title">' . $cats_html . '</div><h2><a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . $ad_title . '</a></h2><i class="fa fa-clock-o"></i><small>' . get_the_date(get_option('date_format'), get_the_ID()) . '</small>' . $timer_html . '</div><div class="ad-info-1"><ul><li> <i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</li></ul></div></div></div>';
            return $my_ads;
        }

        function adforest_search_layout_grid_4($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-4-column-2');
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $my_ads .= '<div class="listing-card ad-grid-4"><div class="image-area"> ' . adforest_video_icon() . ' ' . $timer_html . ' ' . $is_feature . '<div class="photo-count-flag">' . count($media) . ' <i class="fa fa-camera"></i></div><a href="' . get_the_permalink() . '">' . $img . '</a></div><div class="listing-detail"><div class="listing-content"><h2 class="listing-title"><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2><span class="listing-price">' . adforest_adPrice(get_the_ID(), '', '') . '</span><ul><li> <i class="fa fa-th-large fa-fw"></i><span>' . $cats_html . ' </span> </li><li> <i class="fa fa-map-marker fa-fw"></i><span>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</span> </li><li> <i class="fa fa-clock-o fa-fw"></i><span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </li></ul></div><div class="clearfix"></div></div></div></div>';
            return $my_ads;
        }

        function adforest_search_layout_grid_5($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid);

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '">
          <span>' . __('Featured', 'adforest') . '</span>
       </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-5-column-2');
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $my_ads .= '<div class="new-small-grid ad-grid-5">' . adforest_video_icon() . '' . $is_feature . ' <a href="' . get_the_permalink() . '"><figure class="new-small-grid-img">' . $timer_html . '' . $img . '</figure></a><div class="new-small-grid-description"><h2><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2><div class="category-title">' . $cats_html . '</div><span class="ad-price">' . adforest_adPrice(get_the_ID(), '', '') . '</span></div></div></div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_6($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats_html .= '<li><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-6-column-2');
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }


            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad_to_fav ad-favourited" ';
            }

            $my_ads .= '<div class="feature-section ad-grid-6"><div class="feature-shops">' . $is_feature . '<a href="' . get_the_permalink() . '">' . $img . '</a><div class="new-feature-products-maker"><div class="feature-products new-feature-products"><span>' . adforest_adPrice(get_the_ID(), '', '') . '</span></div></div><div class="feature-icons new-feature-icons">' . adforest_video_icon(false, 'play-video-new') . '<a href="javascript:void(0);"  data-adid="' . esc_attr(get_the_ID()) . '" ' . $is_fav . '><i class="fa fa-heart"></i></a></div></div><div class="feature-description"><div class="feature-text new-feature-text"><div class="feature-shop-colors"> <ul class="list-inline"> ' . $cats_html . ' </ul> </div><h2 class="fonts"><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2><h4><i class="fa fa-map-marker no-padding"></i><a href="javascript:void(0);">' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</a></h4></div><div class="feature-shadow"><ul class="list-inline"><li><i class="fa fa-clock-o"></i><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></li><li><i class="fa fa-eye"></i><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></li></ul></div></div></div></div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_7($pid, $col = 6, $sm = 6, $holder = '') {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
            }


            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                    break;
                }
            } else {
                $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid">';
            }



            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats_html .= '<li><a href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-7-column-2');
            if ($col == 0) {
                $my_ads .= '<div class="item">';
            } else {
                $my_ads .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad_to_fav ad-favourited" ';
            }

            $my_ads .= '<div class="browse-feature-details ad-grid-7"><div class="browse-featured-list"><div class="browse-featured-images">' . $is_feature . '<a href="' . get_the_permalink() . '">' . $img . '</a><div class="browse-feature-icons">' . adforest_video_icon(false, 'play-video-new') . '<a href="javascript:void(0);" ' . $is_fav . ' data-adid="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart"></i></a></div><div class="browse-timer"><p>' . $timer_html . '</p></div></div></div><div class="browse-feature-text"><div class="browse-feature-products"><ul class="list-inline">' . $cats_html . '</ul></div><div class="browse-heading-h2"><h2><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . $ad_title . '</a></h2></div><div class="browse-text-h4"><p><i class="fa fa-map-marker"></i><a href="javascript:void(0);">' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</a></p></div>';

            if (adforest_adPrice(get_the_ID()) != '') {
                $my_ads .= ' <div class="browse-price-section"><ul class="list-inline"><li><a href="javascript:void(0);">' . adforest_adPrice(get_the_ID(), '', '') . '</a></li></ul></div>';
            }

            $my_ads .= '</div></div></div>';

            return $my_ads;
        }

        function adforest_search_layout_grid_8($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
                    break;
                }
            } else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));

            if (isset($post_categories) && !empty($post_categories) && is_array($post_categories)) {
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html = ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                    // break;
                }
            }




            $author_id = get_post_field('post_author', $pid);
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . __('Featured', 'adforest') . '</span></div>';
            }

            // time code
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-8-column-2');

            if ($col == 0) {
                $html .= '<div class="item">';
            } else {
                $html .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }

            $is_fav = ' class=ad_to_fav ';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad_to_fav ad-favourited" ';
            }

            $html .= ' <div class="prop-newest-main-section ad-grid-8"><div class="prop-newest-image">  ' . $timer_html . $is_feature . ($img) . '<div class="prop-estate-links"> <a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '"> <img src="' . adforest_get_user_dp($author_id) . '" alt="' . get_the_title() . '" class="avatar avatar-small img-fluid"></a> </div><div class="prop-estate-icons"> <a href="javascript:void(0);" ' . $is_fav . '  data-adid="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart"></i></a> </div> </div><div class="prop-main-contents"><div class="prop-real-estate-box"><div class="prop-estate-advertisement"><div class="prop-estate-text-section"><div class="prop-estate-rent"> ' . ($cats_html) . ' </div><a href="' . get_the_permalink() . '"><h2>' . esc_html($ad_title) . '</h2></a> <a href="javascript:void(0);"><p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p></a> <span>' . adforest_adPrice(get_the_ID(), '', '') . '</span></div></div><div class="prop-estate-table"><ul class="list-inline prop-content-area"><li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li><li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li></ul></div></div></div></div></div>';
            return $html;
        }

        function adforest_search_layout_grid_9($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
                    break;
                }
            } else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            if (isset($taxonomy_obj) && !empty($taxonomy_obj) && is_object($taxonomy_obj)) {
                $cats_html .= '<a href="' . get_term_link($taxonomy_obj->term_id) . '" class="btn-theme">' . esc_html($taxonomy_obj->name) . '</a>';
            } else {
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html .= ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                }
            }


            $author_id = get_post_field('post_author', $pid);
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

                $is_feature = '<div class="dec-featured-icons"><i class="fa fa-star"></i><span>' . __('Featured', 'adforest') . '</span></div>';
            }

            // time code
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-9-column-2');

            if ($col == 0) {
                $html .= '<div class="item">';
            } else {
                $html .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            }



            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad_to_fav ad-favourited" ';
            }

            $html .= '<div class="dec-featured-box ad-grid-9"><div class="dec-featured-box-img">' . $img . '' . $timer_html . '<div class="img-options-wrap">' . $is_feature . '<div class="dec-featured-cam"><i class="fa fa-camera"></i><span>' . count($media) . ' ' . esc_html__('Photo', 'adforest') . '</span></div><div class="dec-featured-ht"><a href="javascript:void(0);" ' . $is_fav . ' data-adid="' . esc_attr(get_the_ID()) . '"><i class="fa fa-heart"></i></a><span>' . esc_html__('Bookmark', 'adforest') . '</span></div></div></div><div class="dec-featured-details-section"> <a href="' . get_the_permalink() . '"><h2>' . esc_html($ad_title) . '</h2></a> <a href="javascript:void(0)"><p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p></a> <span>' . adforest_adPrice(get_the_ID()) . '</span> </div><div class="dec-featured-new-categories"><ul class="list-inline dec-featured-select"><li><i class="fa fa-clock-o"><span class="items">' . get_the_date(get_option('date_format'), get_the_ID()) . '</span></i></li><li><i class="fa fa-eye"><span class="items">' . adforest_getPostViews(get_the_ID()) . ' ' . __('Views', 'adforest') . '</span></i></li></ul></div></div></div>';

            return $html;
        }

        function adforest_search_layout_grid_10($pid, $col = 12) {
            global $adforest_theme;
            $img = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;
                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');

                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $img = '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
                    break;
                }
            } else {
                $img = '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"> </a>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }

            $cats_html = '';
            if (isset($taxonomy_obj) && !empty($taxonomy_obj) && is_object($taxonomy_obj)) {
                $cats_html .= '<a href="' . get_term_link($taxonomy_obj->term_id) . '" class="btn-theme">' . esc_html($taxonomy_obj->name) . '</a>';
            } else {
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $cats_html .= ' <a href="' . get_term_link($cat->term_id) . '" class="btn-theme">' . esc_html($cat->name) . '</a> ';
                }
            }


            $poster_id = get_post_field('post_author', $pid);
            $user_pic = adforest_get_user_dp($poster_id, 'adforest-single-small');
            $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
            if ($poster_name == "") {
                $user_info = get_userdata($poster_id);
                $poster_name = $user_info->display_name;
            }
            $html = '';
            // featured code
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
                $is_feature = '<div class="' . $ribbion . '"> <span>' . __('Featured', 'adforest') . '</span></div>';
            }
            // time code
            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, true, 'style-2') . '</div>';
            }

            $categories_html = '';
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            if (isset($post_categories) && !empty($post_categories) && sizeof($post_categories) > 0) {
                $categories_html .= '<ul>';
                foreach ($post_categories as $c) {
                    $cat = get_term($c);
                    $link = get_term_link($cat->term_id);
                    $categories_html .= '<li> <a href="' . esc_url($link) . '">' . esc_html($cat->name) . '</a></li>';
                }
                $categories_html .= '</ul>';
            }
            $is_fav = 'class="ad_to_fav"';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = ' class="ad_to_fav ad-favourited" ';
            }

            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-10-column-2');

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $img_count = count($media) > 0 ? count($media) : 0;
            $html .= '<div class="col-lg-4  col-xl-' . esc_attr($col) . ' ' . $col2_style . ' col-md-4  col-sm-6">';
            $html .= '<div class="ads-grid-container ad-grid-10"><div class="ads-grid-style"> <div class="' . $ribbion . '">  ' . $is_feature . ' </div> ' . adforest_video_icon() . '  ' . $img . ' ' . $timer_html . '</div><div class="ads-grid-content">' . $categories_html . '<a href="' . get_the_permalink() . '"><h3>' . esc_html($ad_title) . '</h3></a><p><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</p></div><div class="ads-grid-price"><div class="ads-grid-panel"> <span>' . adforest_adPrice(get_the_ID(), '', '') . '</span> </div><div class="ads-grid-vc"><span data-toggle="tooltip" data-placement="top" title="' . $img_count . '"><i class="fa fa-camera"></i></span><a ' . $is_fav . ' href="javascript:void(0);"  data-adid="' . get_the_ID() . '"><i class="fa fa-heart"></i> </a></div></div><div class="ads-grid-views"><ul><li> <a href="' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '"> <img src="' . $user_pic . '" alt="' . __('User image', 'adforest') . '" class="img-fluid"></a> <span><a href="' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '">' . $poster_name . '</a></span> </li><li><p>' . __('Views', 'adforest') . ' : ' . adforest_getPostViews(get_the_ID()) . '</p></li></ul></div></div>';
            $html .= '</div>';

            return $html;
        }

        function adforest_search_layout_grid_11($pid, $col = 6, $sm = 6, $holder = '', $for = "", $col_lg = 4) {
            $my_ads = '';
            $number = 0;
            global $adforest_theme;
            $cats_html = adforest_display_cats($pid, 'cat-btn');

            $total_view = 0;
            if (class_exists('Post_Views_Counter')) {
                $pre_view = (int) adforest_getPostViews($pid);
                $ad_view = (int) pvc_get_post_views($pid);
                $total_view = $pre_view + $ad_view;
            } else {
                $total_view = adforest_getPostViews($pid);
            }

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $outer_html = '';
            $media = adforest_get_ad_images($pid);
            if (count($media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1)
                        break;

                    $mid = '';
                    if (isset($m->ID))
                        $mid = $m->ID;
                    else
                        $mid = $m;

                    $timer_html = '';
                    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, true, 'style-1') . '</div>';
                    }


                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                    $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                    $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
                    $counting++;
                }
            } else {
                $timer_html = '';
                $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                    $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
                }

                $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

                $is_feature = '<div class="found-featured   ' . esc_attr($ribbion) . '">' . __('Featured', 'adforest') . '
                <div class="fold"></div></div>';
            }

            $ad_title = get_the_title();
            if (function_exists('adforest_title_limit')) {
                $ad_title = adforest_title_limit($ad_title);
            }
            $my_ads = '';
            $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-1-column-2');

            $wrapper_start = '<div class="col-xl-' . esc_attr($col) . ' col-lg-' . esc_attr($col_lg) . '   col-md-4  col-sm-6  ' . esc_attr($col2_style) . '">';
            $wrapper_end = "</div>";
            if ($for == "slider") {
                $sb_2column = (isset($adforest_theme['sb_2column_mobile_layout']) && $adforest_theme['sb_2column_mobile_layout'] == true) ? true : false;

                $grid_class = "";
                if ($sb_2column) {
                    $grid_class = "grid-1-column-2";
                }


                $wrapper_start = '<div class="promotionalslider_single ' . $grid_class . '">';
                $wrapper_end = "</div>";
            }
            $is_fav = 'ad_to_fav';
            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                $is_fav = 'ad_to_fav ad-favourited';
            }

            return '' . $wrapper_start . ' 
<div class="found-listing-item ad-grid-11">
    <div class="found-listing-img">
        ' . $outer_html . '
        <div class="found-heart">
            <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>
        </div>
    </div>
    <div class="found-listing-heading">
        <div class = "list-cat">
            <div class="category-title">
                ' . $cats_html . '
            </div> 

            <h4><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h4>

            <h5>' . adforest_adPrice($pid, '', '') . '</h5>
            <div class="fr-address_star"> 
                <div class="fr-add">   <span class="found-listing-head-address"><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span></div>
            </div> 
        </div>
        <div class="listing-bottom"> 
            <span class="found-listing-head-date"><i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), $pid) . '</span>
            <div class="found-star-icon">
                <div class="star-shining">
                    <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                        <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    ' . $is_feature . '
</div>
' . $wrapper_end . '';
        }

        function adforest_get_ads_grid_slider($args, $title, $col = 12, $css_class = '') {

            $my_ads = '';
            global $adforest_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = apply_filters('adforest_wpml_show_all_posts', $args);
            $args = apply_filters('adforest_site_location_ads', $args, 'ads');

            $grid_type = 'grid_1';
            if (isset($adforest_theme['featured_ad_slider_layout']) && $adforest_theme['featured_ad_slider_layout'] != "") {
                $grid_type = $adforest_theme['featured_ad_slider_layout'];
            }



            $ads = new WP_Query($args);
            $no_padding = '';
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $pid = get_the_ID();

                    $function = "adforest_search_layout_$grid_type";
                    $my_ads .= '<div class="item">';
                    $my_ads .= $this->$function($pid, 12, 12, '', 'slider');
                    $my_ads .= '</div>';
                }
            }
            if ($my_ads == '') {
                return '';
            }
            wp_reset_postdata();
            $no_padding .= $no_padding . ' ' . $css_class;

            $direction = is_rtl() ? 'rtl' : "";

            $heading = "";
            if ($title != "") {
                $heading = '<div class="promotional-feat-heading"><h3>' . $title . '</h3></div>';
            }
            return '<div class="promotional_slider ' . $css_class . '"><div class="col-xs-12 col-md-12 col-sm-12 margin-bottom-30">' . $heading . '<div class="featured-slider-1  owl-carousel owl-theme">' . $my_ads . '</div></div></div>';
        }

    }

}

if(!function_exists('adforest_search_layout_list')){

function adforest_search_layout_list($pid, $col = 12) {
    global $adforest_theme;
    $author_id = get_post_field('post_author', $pid);
    $condition_html = '';
    if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta($pid, '_adforest_ad_condition', true) != "") {
        $condition_html = '<div class="ad-stats hidden-xs">
	<span>' . __('Condition', 'adforest') . '  : </span>
	' . get_post_meta($pid, '_adforest_ad_condition', true) . '
	</div>';
    }
    $ad_type_html = '';
    if (get_post_meta($pid, '_adforest_ad_type', true) != "") {
        $ad_type_html = '<div class="ad-stats hidden-xs">
                <span>' . __('Ad Type', 'adforest') . '  : </span>
                ' . get_post_meta($pid, '_adforest_ad_type', true) . '
                </div>';
    }
    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
        $rtl_fet = 'featured-ribbon';
        if (is_rtl()) {
            $rtl_fet = 'featured-ribbon-rtl';
        }
        $is_feature = '<div class="' . esc_attr($rtl_fet) . '">
		  <span>' . __('Featured', 'adforest') . '</span>
	   </div>';
    }

    $poster_contact = '';
    if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {
        $showPhone_to_users = adforest_showPhone_to_users();
        if (!$showPhone_to_users) {
            $poster_contact = '<li><div class="tooltip1" data-placement="top"><a href="javascript:void(0);" class="fa fa-phone"></a><span class="tooltiptext"> ' . get_post_meta($pid, '_adforest_poster_contact', true) . '</span></div></li>';
        }
    }
    $price = '<div class="price"><span>' . adforest_adPrice(get_the_ID()) . '</span></div>';
    $output = '<li><div class="sb-modern-list well ad-listing clearfix "><div class="row"><div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 grid-style no-padding">';
    $img = adforest_get_ad_default_image_url('adforest-ad-related');
    $media = adforest_get_ad_images($pid);
    $total_imgs = count($media);
    if (count($media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $img = isset($image[0]) ? $image[0] : adforest_get_ad_default_image_url('adforest-ads-medium');
            break;
        }
    } else {
        $img = adforest_get_ad_default_image_url('adforest-ads-medium');
    }
    $output .= '<div class="img-box">' . adforest_video_icon() . ' ' . $is_feature . ' <img src="' . esc_url($img) . '" class="img-fluid" alt="' . get_the_title() . '"><div class="total-images"><strong>' . esc_html($total_imgs) . '</strong> ' . __('photos', 'adforest') . ' </div><div class="quick-view"><a href="' . $img . '" class="view-button" data-fancy="group"><i class="fa fa-search"></i></a></div>';

    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
        $output .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
    }

    $output .= '</div><div class="user-preview"><a href="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '"><img src="' . adforest_get_user_dp($author_id) . '" class="avatar avatar-small" alt="' . get_the_title() . '"></a></div></div><div class="col-lg-9 col-md-8 col-sm-12 col-xs-12"><div class="row"><div class="content-area"><div class= "row"><div class="col-md-9 col-sm-12 col-xs-12">';

    $cats_html = '';
    $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
    $it_one = 1;
    foreach ($post_categories as $c) {
        $cls = '';
        if ($it_one != 1)
            $cls = is_rtl() ? 'padding-right' : 'padding-left';
        $cat = get_term($c);
        $cats_html .= '<span><a class="' . $cls . '" href="' . get_term_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></span>';
        $it_one++;
    }
    $output .= '<div class="category-title">' . $cats_html . '</div><h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
    <ul class="additional-info pull-right">' . $poster_contact . '
    <li><div class="tooltip1" data-placement="top"><a href="javascript:void(0);" class="fa fa-heart save-ad" data-adid="' . esc_attr($pid) . '"></a><span class="tooltiptext">' . __('Save', 'adforest') . '</span></div></li></ul><ul class="ad-meta-info"><li> <i class="fa fa-map-marker"></i><a href="javascript:void(0);">' . get_post_meta($pid, '_adforest_ad_location', true) . '</a></li><li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), $pid) . '</li></ul><div class="ad-details"><p>' . adforest_words_count(get_the_excerpt(), 250) . '</p></div></div><div class="col-md-3 col-xs-12 col-sm-12"><div class="short-info">' . $ad_type_html . '' . $condition_html . '<div class="ad-stats hidden-xs"> <span>' . __('Visits', 'adforest') . '  : </span> ' . adforest_getPostViews($pid) . ' </div></div>' . $price . '<a href="' . get_the_permalink() . '" class="btn btn-block btn-theme">' . __('View Ad', 'adforest') . '</a></div></div></div></div></div></div></div></li>';
    return $output;
}
}

if(!function_exists('adforest_search_layout_list_1')){
function adforest_search_layout_list_1($pid, $is_show = true, $cols = '') {
    $number = 0;
    global $adforest_theme;
    $cats_html = adforest_display_cats($pid);

    $img = '';
    $media = adforest_get_ad_images($pid);

    if (get_the_post_thumbnail_url($pid) != "") {
        $img = '<img src="' . get_the_post_thumbnail_url($pid, 'adforest-ad-related') . '" class="card-img-top" alt="' . get_the_title() . '">';
    } else if (count((array) $media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
            $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="card-img-top">';
            break;
        }
    } else {
        $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="card-img-top">';
    }

    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
        $rtl_fet = 'featured-ribbon';
        if (is_rtl()) {
            $rtl_fet = 'featured-ribbon-rtl';
        }
        $is_feature = '<div class="percentsaving">' . esc_html__('Featured', 'adforest') . '<div class="fold"></div> </div>';
    }

    $pid = get_the_ID();
    $author_id = get_post_field('post_author', $pid);
    $author_data = get_userdata($author_id);
    $author_name = $author_data->display_name;
    $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
    if ($poster_name == "") {

        $poster_name = $author_name;
    }
    $dp = "";
    if (function_exists('adforest_get_user_dp')) {
        $dp = adforest_get_user_dp($author_id);
    }




    $poster_contact = '';
    if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

        $showPhone_to_users = adforest_showPhone_to_users();
        if (!$showPhone_to_users) {
            $poster_contact = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-phone"></i></span><div class="tooltip-content"><h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</h4></div></div></li>';
        }
    }


    if (isset($_GET['view-type']) && $_GET['view-type'] == 'list') {
        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
            $options_html = '';
        }
    }

    $timer_html = '';
    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
    }

    $is_fav = 'ad_to_fav';
    if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
        $is_fav = 'ad_to_fav ad-favourited';
    }

    $total_view = 0;
    if (class_exists('Post_Views_Counter')) {
        $pre_view = (int) adforest_getPostViews($pid);
        $ad_view = (int) pvc_get_post_views($pid);
        $total_view = $pre_view + $ad_view;
    } else {
        $total_view = adforest_getPostViews($pid);
    }


    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }
    return '<div class="bs-example">
        <div class="card car-property">
            <div class="row no-gutters">
                <div class="col-md-5 col-sm-12">
                    ' . $img . '
                    <div class="aln-img">
                        <img src="' . $dp . '" alt="' . $poster_name . '">
                        <span>' . $poster_name . '</span>
                    </div>
                    <div class="heart-icons-1">
                      <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>          
                   </div>                
                   ' . $is_feature . '
                </div>
                <div class="col-md-7 col-sm-12">
                    <div class="sb-list">
                        <div class="product-main-heading">
                            <div class="star-shining">
                              <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                                      <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                                    </div>
                            </div>
                            <div class="product-heading ">
                            <div class="category-title">' . adforest_display_cats($pid) . '</div>                    
                                <h2><a href="#" class="the-beat-chaff">' . $ad_title . '</a></h2>
                                     <span><i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), get_the_ID()) . '</span><i></i>
                                <p>' . adforest_words_count(get_the_excerpt(), 100) . '</p>
                                <h4>' . adforest_adPrice(get_the_ID()) . '</h4>
                                <span class="address-tiem"><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</span>
                                <div class="detail-btn">
                                    <a href="' . get_the_permalink() . '" class="btn btn-detail">' . esc_html__('Detail Now', 'adforest') . '</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>';
}}


if(!function_exists('adforest_search_layout_list_2')){
function adforest_search_layout_list_2($pid, $is_show = true, $cols = '') {
    $number = 0;
    global $adforest_theme;
    $cats_html = adforest_display_cats($pid);

    $img = '';
    $media = adforest_get_ad_images($pid);

    if (get_the_post_thumbnail_url($pid) != "") {
        $img = '<img src="' . get_the_post_thumbnail_url($pid, 'adforest-ad-related') . '" class="h-100" alt="' . get_the_title() . '">';
    } else if (count((array) $media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
            $img = '<a href="'.get_the_permalink().'"><img src="' . $image . '" alt="' . get_the_title() . '" class="h-100"></a>';
            break;
        }
    } else {
        $img = '<a href="'.get_the_permalink().'"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="h-100"></a>';
    }

    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
        $rtl_fet = 'featured-ribbon';
        if (is_rtl()) {
            $rtl_fet = 'featured-ribbon-rtl';
        }
        $is_feature = '<div class="percentsaving">' . esc_html__('Featured', 'adforest') . '<div class="fold"></div> </div>';
    }

    $pid = get_the_ID();
    $author_id = get_post_field('post_author', $pid);
    $author_data = get_userdata($author_id);
    $author_name = $author_data->display_name;
    $dp = "";
    if (function_exists('adforest_get_user_dp')) {
        $dp = adforest_get_user_dp($author_id);
    }


    $warranty = '';
    if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {
        $warranty = ' <li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-check-square-o"></i></span><div class="tooltip-content"><strong>' . __('Warranty', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '</span></div></div></li>';
    }
    $condition = '';
    if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {

        $condition = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-cog"></i></span><div class="tooltip-content"><strong>' . __('Condition', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '</span>
					</div></div></li>';
    }



    $poster_contact = '';
    if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

        $showPhone_to_users = adforest_showPhone_to_users();
        if (!$showPhone_to_users) {
            $poster_contact = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-phone"></i></span><div class="tooltip-content"><h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</h4></div></div></li>';
        }
    }

    $options_html = '';
    if ($is_show) {
        $options_html = '<ul class="add_info">' . $poster_contact . '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-map-marker"></i></span><div class="tooltip-content">' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</div></div></li>' . $condition . '' . $warranty . '</ul>';
    }
    if (isset($_GET['view-type']) && $_GET['view-type'] == 'list') {
        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
            $options_html = '';
        }
    }

    $timer_html = '';
    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
    }

    $is_fav = 'ad_to_fav';
    if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
        $is_fav = 'ad_to_fav ad-favourited';
    }

    $total_view = 0;
    if (class_exists('Post_Views_Counter')) {
        $pre_view = (int) adforest_getPostViews($pid);
        $ad_view = (int) pvc_get_post_views($pid);
        $total_view = $pre_view + $ad_view;
    } else {
        $total_view = adforest_getPostViews($pid);
    }


    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }
    return ' 
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 wow">
        <div class="feature-img-content">
    ' . $img . '
    <div class="overlay-feature" data-url  = "' . get_the_permalink(get_the_ID()) . '">
      <div class="bottom-left"> 
      <span class="new-price">' . adforest_adPrice($pid, '', '') . '</span>
      <h4><a href="' . esc_url(get_the_permalink()) . '">' . $ad_title . '</a></h4>
      <span class="address-bottom"><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</span>
     </div>
     <div class="feature-hear-icon">
       <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>  
    </div>

     <div class="star-shining">
                              <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                                      <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                                    </div>
                            </div>
    ' . $is_feature . '
  </div>
  </div></div>';
}
}


if(!function_exists('adforest_search_layout_list_3')){

function adforest_search_layout_list_3($pid, $is_show = true, $cols = '') {
    $number = 0;
    global $adforest_theme;
    $cats_html = adforest_display_cats($pid);

    $img = '';
    $media = adforest_get_ad_images($pid);

    if (get_the_post_thumbnail_url($pid) != "") {
        $img = '<img src="' . get_the_post_thumbnail_url($pid, 'adforest-ad-related') . '" class="h-100" alt="' . get_the_title() . '">';
    } else if (count((array) $media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
            $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="h-100">';
            break;
        }
    } else {
        $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="h-100">';
    }

    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
        $rtl_fet = 'featured-ribbon';
        if (is_rtl()) {
            $rtl_fet = 'featured-ribbon-rtl';
        }
        $is_feature = ' <div class="red-white-star">
              <i class="fa fa-star"></i>
              </div>';
    }

    $pid = get_the_ID();
    $author_id = get_post_field('post_author', $pid);
    $author_data = get_userdata($author_id);
    $author_name = $author_data->display_name;
    $dp = "";
    if (function_exists('adforest_get_user_dp')) {
        $dp = adforest_get_user_dp($author_id);
    }


    $warranty = '';
    if (get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) != "" && isset($adforest_theme['allow_tax_warranty']) && $adforest_theme['allow_tax_warranty']) {
        $warranty = ' <li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-check-square-o"></i></span><div class="tooltip-content"><strong>' . __('Warranty', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_warranty', true) . '</span></div></div></li>';
    }
    $condition = '';
    if (isset($adforest_theme['allow_tax_condition']) && $adforest_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_adforest_ad_condition', true) != "") {

        $condition = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-cog"></i></span><div class="tooltip-content"><strong>' . __('Condition', 'adforest') . '</strong><span class="label label-danger">' . get_post_meta(get_the_ID(), '_adforest_ad_condition', true) . '</span>
					</div></div></li>';
    }



    $poster_contact = '';
    if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {

        $showPhone_to_users = adforest_showPhone_to_users();
        if (!$showPhone_to_users) {
            $poster_contact = '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-phone"></i></span><div class="tooltip-content"><h4>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</h4></div></div></li>';
        }
    }

    $options_html = '';
    if ($is_show) {
        $options_html = '<ul class="add_info">' . $poster_contact . '<li><div class="custom-tooltip tooltip-effect-4"><span class="tooltip-item"><i class="fa fa-map-marker"></i></span><div class="tooltip-content">' . get_post_meta(get_the_ID(), '_adforest_ad_location', true) . '</div></div></li>' . $condition . '' . $warranty . '</ul>';
    }
    if (isset($_GET['view-type']) && $_GET['view-type'] == 'list') {
        if (isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map') {
            $options_html = '';
        }
    }

    $timer_html = '';
    $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
    if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
        $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
    }

    $is_fav = 'ad_to_fav';
    if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
        $is_fav = 'ad_to_fav ad-favourited';
    }

    $total_view = 0;
    if (class_exists('Post_Views_Counter')) {
        $pre_view = (int) adforest_getPostViews($pid);
        $ad_view = (int) pvc_get_post_views($pid);
        $total_view = $pre_view + $ad_view;
    } else {
        $total_view = adforest_getPostViews($pid);
    }


    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }
    return '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">    
        <div class="product-card">
            <div class="product-front">
              <div class="oerlay-img"></div> 
              ' . $img . '
              <div class="feature-heart-icon">
                      <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>          
                   </div>
              </div> 
               <div class="stats">        	
                        <div class="star-shining">
                              <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                                      <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                                    </div>
                            </div>
                        <span class="product_name"><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta(get_the_ID(), '_adforest_ad_location', true)) . '</span>                                                   
            </div>	
            <div class="feature-pro-head">
                  <h3>' . adforest_adPrice($pid) . '</h3>
                  <h5>' . $ad_title . '</h5>
            </div>
            ' . $is_feature . '
              
    </div>	    
    </div>';
}}

if(!function_exists('adforest_search_layout_grid_1')){

function adforest_search_layout_grid_1($pid, $col = 6, $sm = 6, $holder = '', $for = "", $col_lg = 4) {
    $my_ads = '';
    $number = 0;
    global $adforest_theme;
    $cats_html = adforest_display_cats($pid, 'cat-btn');

    $total_view = 0;
    if (class_exists('Post_Views_Counter')) {
        $pre_view = (int) adforest_getPostViews($pid);
        $ad_view = (int) pvc_get_post_views($pid);
        $total_view = $pre_view + $ad_view;
    } else {
        $total_view = adforest_getPostViews($pid);
    }

    $flip_it = '';
    $ribbion = 'featured-ribbon';
    if (is_rtl()) {
        $flip_it = 'flip';
        $ribbion = 'featured-ribbon-rtl';
    }
    $outer_html = '';
    $media = adforest_get_ad_images($pid);
    if (count($media) > 0) {
        $counting = 1;
        foreach ($media as $m) {
            if ($counting > 1)
                break;

            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, true, 'style-1') . '</div>';
            }


            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
            $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
            $counting++;
        }
    } else {
        $timer_html = '';
        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
        if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
            $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
        }

        $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
    }
    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

        $is_feature = '<div class="found-featured   ' . esc_attr($ribbion) . '">' . __('Featured', 'adforest') . '
                <div class="fold"></div></div>';
    }

    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }
    $my_ads = '';
    $col2_style = apply_filters('adforest_grid_two_column', 'col-12', 'grid-1-column-2');

    $wrapper_start = '<div class="col-xl-' . esc_attr($col) . ' col-lg-' . esc_attr($col_lg) . '   col-md-4  col-sm-6  ' . esc_attr($col2_style) . '">';
    $wrapper_end = "</div>";
    if ($for == "slider") {
        $sb_2column = (isset($adforest_theme['sb_2column_mobile_layout']) && $adforest_theme['sb_2column_mobile_layout'] == true) ? true : false;

        $grid_class = "";
        if ($sb_2column) {
            $grid_class = "grid-1-column-2";
        }


        $wrapper_start = '<div class="promotionalslider_single ' . $grid_class . '">';
        $wrapper_end = "</div>";
    }
    $is_fav = 'ad_to_fav';
    if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
        $is_fav = 'ad_to_fav ad-favourited';
    }

    return '' . $wrapper_start . ' 
<div class="found-listing-item">
    <div class="found-listing-img">
        ' . $outer_html . '
        <div class="found-heart">
            <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>
        </div>
    </div>
    <div class="found-listing-heading">
        <div class = "list-cat">
            <div class="category-title">
                ' . $cats_html . '
            </div> 

            <h4><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h4>

            <h5>' . adforest_adPrice($pid, '', '') . '</h5>
            <div class="fr-address_star"> 
                <div class="fr-add">   <span class="found-listing-head-address"><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span></div>
            </div> 
        </div>
        <div class="listing-bottom"> 
            <span class="found-listing-head-date"><i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), $pid) . '</span>
            <div class="found-star-icon">
                <div class="star-shining">
                    <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                        <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    ' . $is_feature . '
</div>
' . $wrapper_end . '';
}
}

if(!function_exists('adforest_search_layout_grid_2')){
function adforest_search_layout_grid_2($pid, $col = 6, $sm = 6, $holder = '', $for = "", $col_lg = 4) {
    $my_ads = '';
    $number = 0;
    global $adforest_theme;
    $cats_html = adforest_display_cats($pid, 'cat-btn');

    $total_view = 0;
    if (class_exists('Post_Views_Counter')) {
        $pre_view = (int) adforest_getPostViews($pid);
        $ad_view = (int) pvc_get_post_views($pid);
        $total_view = $pre_view + $ad_view;
    } else {
        $total_view = adforest_getPostViews($pid);
    }

    $flip_it = '';
    $ribbion = 'featured-ribbon';
    if (is_rtl()) {
        $flip_it = 'flip';
        $ribbion = 'featured-ribbon-rtl';
    }
    $outer_html = '';
    $media = adforest_get_ad_images($pid);
    if (count($media) > 0) {
        $counting = 1;
        foreach ($media as $m) {
            if ($counting > 1)
                break;

            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $timer_html = '';
            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, '', 'style-1') . '</div>';
            }


            $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
            $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
            $counting++;
        }
    } else {
        $timer_html = '';
        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
        if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
            $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
        }

        $outer_html = '<div class="image">' . $timer_html . '<a href="' . get_the_permalink() . '"><img src="' . adforest_get_ad_default_image_url('adforest-ad-related') . '" alt="' . get_the_title() . '" class="img-fluid"></a></div>';
    }
    $is_feature = '';
    if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {

        $is_feature = '<div class="found-featured   ' . esc_attr($ribbion) . '">' . __('Featured', 'adforest') . '
                <div class="fold"></div></div>';
    }

    $ad_title = get_the_title();
    if (function_exists('adforest_title_limit')) {
        $ad_title = adforest_title_limit($ad_title);
    }
    $my_ads = '';

    $is_fav = 'ad_to_fav';
    if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
        $is_fav = 'ad_to_fav ad-favourited';
    }


    $video_icon = "";
    $video = adforest_video_icon(false, 'play-video', 'fa fa-play');
    if ($video != "") {
        $video_icon = '<li>' . adforest_video_icon(false, 'play-video', 'fa fa-play') . '</li>';
    }
    return '<div class="ad-grid-modern">
       
            <div class="ad-grid-modern-img">
              ' . $outer_html . '
                <div class="ad-grid-modern-heading">
                    <a href="' . get_the_permalink() . '"><h4>' . $ad_title . '</h4></a>
                    <span><i class="fa fa-map-marker"></i>' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span>
                </div>
                ' . $is_feature . '
                <div class="loreum-recusandae-ads-overlay"></div>
            </div>
     
        <div class="ad-grid-modern-content">
            <div class="ad-grid-modern-price">
                <h5>' . adforest_adPrice($pid, '', '') . '</h5>
            </div>
            <div class="ad-grid-modern-item">
                <ul>
                     ' . $video_icon . '
                    <li class="tooltip1"><a href="javascript:void(0)"><i class="fa fa-eye"></i></a> <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span></li>
                    <li><a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a></li>
                </ul>
            </div>
        </div>
    </div>';
}
}


if (!function_exists('adforest_search_layout_list_4')) {
    /* Search Layout list one */

    function adforest_search_layout_list_4($pid) {
        $my_ads = '';
        $number = 0;
        global $adforest_theme;
        $ad_title = get_the_title();
        if (function_exists('adforest_title_limit')) {
            $ad_title = adforest_title_limit($ad_title);
        }
        $img = '';
        $media = adforest_get_ad_images($pid);
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

                $image = wp_get_attachment_image_src($mid, 'adforest-ad-list');
                $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                $img = '<img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid">';
                break;
            }
        } else {
            $img = '<img src="' . adforest_get_ad_default_image_url('adforest-ad-list') . '" alt="' . get_the_title() . '" class="img-fluid">';
        }
        $cats_html = adforest_display_cats($pid);
        $cat_class = "no_cats";

        if ($cats_html != "") {

            $cat_class = "";

            $cats_html = '<div class="category-title">' . $cats_html . '</div>';
        }
        $is_feature = '';
        if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
            $rtl_fet = 'featured-ribbon';
            if (is_rtl()) {
                $rtl_fet = 'featured-ribbon-rtl';
            }
            $is_feature = '<div class="found-featured ' . esc_attr($rtl_fet) . '">' . __('Featured', 'adforest') . '
    <div class="fold"></div>
</div>';
        }
        $author_id = get_post_field('post_author', $pid);
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;

        $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
        if ($poster_name == "") {

            $poster_name = $author_name;
        }
        $dp = "";
        if (function_exists('adforest_get_user_dp')) {
            $dp = adforest_get_user_dp($author_id);
        }

        ;

        $poster_contact = '';
        if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {
            $poster_contact = '<li> <a href="javascript:void(0);"><i class="flaticon-phone-call"></i>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</a></li>';
        }
        $timer_html = '';
        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
        if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
            $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
        }
        $is_fav = 'ad_to_fav';
        if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
            $is_fav = 'ad_to_fav ad-favourited';
        }


        return '<div class="col-lg-12 col-md-12 col-sm-12">

    <div class="found-listing">
        <div class="row">
            <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="found-listing-image">
                    ' . $img . '
                    <div class="found-heart">
                        <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a> 
                    </div>
                    ' . $is_feature . '
                    <div class="aln-img">
                        <img src="' . esc_url($dp) . '" alt=' . esc_attr($poster_name) . '>
                        <span>' . $poster_name . '</span>
                    </div>
                    <div class =  "video_icon_container"> ' . adforest_video_icon() . ' </div>
                </div>
            </div>
            <div class="col-xxl-8 col-lg-8 col-md-8 col-sm-12">
                <div class="found-listing-head ' . $cat_class . '">

                    ' . $cats_html . '
                    <h4><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h4>

                    <span class="sb_ad_date"><i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), $pid) . '</span>
                    <p>' . adforest_words_count(get_the_excerpt(), 150) . '</p>
                    <h5>' . adforest_adPrice($pid, '', '') . '</h5>
                    <span><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span>
                    <div class="founding-star-icon">
                        <div class="popover__wrapper">
                            <a href="#">      
                                <i class="fa fa-star" alt="star-icon" id="pover-first" data-bs-toggle="popover" data-bs-trigger="hover" data-placement="top"></i>
                            </a>
                            <div class="popover__content">
                                <p class="popover__message">5.0 Reviews</p>
                            </div>
                        </div>
                    </div>
                    <div class="found-detail">
                        <a  class="btn btn-theme btn-detailing" href="' . get_the_permalink() . '">' . esc_html__('View Detail', 'adforest') . '</a>
                    </div>
                    </span></div>
            </div>
        </div>

    </div>
</div>';
    }

}

if (!function_exists('adforest_search_layout_list_5')) {
    /* Search Layout list one */

    function adforest_search_layout_list_5($pid) {
        $my_ads = '';
        $number = 0;
        global $adforest_theme;
        $ad_title = get_the_title();
        if (function_exists('adforest_title_limit')) {
            $ad_title = adforest_title_limit($ad_title);
        }

        $total_view = 0;
        if (class_exists('Post_Views_Counter')) {
            $pre_view = (int) adforest_getPostViews($pid);
            $ad_view = (int) pvc_get_post_views($pid);
            $total_view = $pre_view + $ad_view;
        } else {
            $total_view = adforest_getPostViews($pid);
        }
        $img = '';
        $media = adforest_get_ad_images($pid);
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

                $image = wp_get_attachment_image_src($mid, 'adforest-ad-list');
                $image = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();
                $img = '<a href="' . get_the_permalink($pid) . '"><img src="' . $image . '" alt="' . get_the_title() . '" class="img-fluid"></a>';
                break;
            }
        } else {
            $img = '<a href="' . get_the_permalink($pid) . '"> <img src="' . adforest_get_ad_default_image_url('adforest-ad-list') . '" alt="' . get_the_title() . '" class="img-fluid"></a>';
        }
        $cats_html = adforest_display_cats($pid);
        $cat_class = "no_cats";

        if ($cats_html != "") {
            $cat_class = "";
            $cats_html = '<div class="category-title">' . $cats_html . '</div>';
        }
        $is_feature = '';
        if (get_post_meta(get_the_ID(), '_adforest_is_feature', true) == '1') {
            $rtl_fet = 'featured-ribbon';
            if (is_rtl()) {
                $rtl_fet = 'featured-ribbon-rtl';
            }
            $is_feature = '<div class="red-white-star">
                 <i class="fa fa-star"></i>
             </div>';
        }
        $author_id = get_post_field('post_author', $pid);
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;

        $poster_name = get_post_meta($pid, '_adforest_poster_name', true);
        if ($poster_name == "") {

            $poster_name = $author_name;
        }
        $dp = "";
        if (function_exists('adforest_get_user_dp')) {
            $dp = adforest_get_user_dp($author_id);
        }

        ;

        $poster_contact = '';
        if (get_post_meta(get_the_ID(), '_adforest_poster_contact', true) != "" && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'phone' )) {
            $poster_contact = '<li> <a href="javascript:void(0);"><i class="flaticon-phone-call"></i>' . get_post_meta(get_the_ID(), '_adforest_poster_contact', true) . '</a></li>';
        }
        $timer_html = '';
        $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
        if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
            $timer_html .= '<div class="listing-bidding">' . adforest_timer_html($bid_end_date, false) . '</div>';
        }
        $is_fav = 'ad_to_fav';
        if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
            $is_fav = 'ad_to_fav ad-favourited';
        }


        return '<div class="col-lg-12 col-md-12 col-sm-12">

    <figure class="great-product">
        <div class="great-product-herro">
            ' . $img . '
            <div class="aln-img">
                <img src="' . esc_url($dp) . '" alt=' . esc_attr($poster_name) . '>
                <span><a href ="' . adforest_set_url_param(get_author_posts_url($author_id), 'type', 'ads') . '">' . $poster_name . '</a></span>
            </div>
            <div class="heart-icons-1">
                <a href="javascript:void(0);"  data-adid="' . get_the_ID() . '" class="' . $is_fav . '"> <i class="fa fa-heart"></i></a>
            </div>     
            <div class =  "video_icon_container"> ' . adforest_video_icon() . ' </div>
            ' . $is_feature . '
        </div>
        <div class="great-product-content">
            ' . $cats_html . '  
          <div class="star-shining">
                 <div class="tooltip1" data-placement="top"><i class="fa fa-eye"></i>
                     <span class="tooltiptext"> ' . $total_view . ' ' . esc_html__('Views', 'adforest') . '</span>
                      </div>
                 </div>
            <div class="great-product-title">
                <h2 class="great-product-heading"><a href="' . get_the_permalink() . '">' . $ad_title . '</a></h2>
            </div>
            <div class="pro-great-rating">
                <span class="great-date">
                    <i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), $pid) . '
                   </span>
            </div>
            <div>  <p>' . adforest_words_count(get_the_excerpt(), 50) . '</p>
            <h4>' . adforest_adPrice($pid, '', '') . '</h4>

            </div>
            <span><i class="fa fa-map-marker"></i> ' . adforest_ad_locations_limit(get_post_meta($pid, '_adforest_ad_location', true)) . '</span>
            <div class="detail-btn-1">
                <a  class="btn btn-theme btn-detail" href="' . get_the_permalink() . '">' . esc_html__('View Detail', 'adforest') . '</a>              
            </div>
        </div>
    </figure>
</div>';
    }

}


if (!function_exists('adforest_get_grid_layout')) {

    function adforest_get_grid_layout() {
        global $adforest_theme;
        $search_ad_layout_for_sidebar = '';
        if (isset($adforest_theme['search_layout_types']) && $adforest_theme['search_layout_types'] == true) {
            if (isset($_GET['view-type']) && $_GET['view-type'] != "") {
                if ($_GET['view-type'] == 'grid') {
                    $search_ad_layout_for_sidebar = isset($adforest_theme['search_layout_types_grid']) ?
                            $adforest_theme['search_layout_types_grid'] : "grid_1";
                }
                if ($_GET['view-type'] == 'list') {
                    $search_ad_layout_for_sidebar = isset($adforest_theme['search_layout_types_list']) ? $adforest_theme['search_layout_types_list'] : 'list_1';
                }
            }
        }
        return $search_ad_layout_for_sidebar;
    }

}
/* adforest dashboard custom function */
if (!function_exists('adforest_pro_get_ads_list')) {

    function adforest_pro_get_ads_list($args, $fav_ads, $hide_feature = false) {
        global $adforest_theme;
        $sb_post_ad_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_post_ad_page']);
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $args = apply_filters('adforest_site_location_ads', $args, 'ads');
        $ads = new WP_Query($args);
        $ads_list = "";

        if ($ads->have_posts()) {
            $number = 0;
            $remove = '';
            while ($ads->have_posts()) {
                $ads->the_post();
                $pid = get_the_ID();
                $status = get_post_meta(get_the_ID(), '_adforest_ad_status_', true);
                $cats_html = adforest_display_cats($pid);
                if ($status == '') {
                    $status = adforest_ad_statues('active');
                }
                $media = adforest_get_ad_images($pid);

                $image[0] = "";
                if (count($media) > 0) {
                    $counting = 1;
                    foreach ($media as $m) {
                        if ($counting > 1)
                            break;
                        $mid = '';
                        if (isset($m->ID))
                            $mid = $m->ID;
                        else
                            $mid = $m;
                        $image = wp_get_attachment_image_src($mid, 'adforest-single-small');

                        $image[0] = isset($image[0]) ? $image[0] : adforest_get_ad_default_image_url('adforest-single-small');
                        $counting++;
                    }
                } else {
                    $image[0] = adforest_get_ad_default_image_url('adforest-single-small');
                }

                $add_ons = '';
                if ($fav_ads == 'no' || 'expired_sold' == $fav_ads || $fav_ads == 'featured_ads') {
                    $ad_featured = '<a class="mb-1 btn btn-sm btn-info mr-2 disabled" href="javascript:void(0);" >' . __('Featured', 'adforest') . '</a>';
                    if (get_post_meta($pid, '_adforest_is_feature', true) != '1') {
                       
                        $ad_featured = '<a class="mb-1 btn btn-sm btn-info mr-2 sb_anchor sb_make_feature_ad" href="javascript:void(0);"  data-aaa-id="' . esc_attr($pid) . '">' . __('Mark featured', 'adforest') . '</a>';
                    
                        if($adforest_theme['make_feature_paid'] &&  isset($adforest_theme['sb_feature_template_page']) && $adforest_theme['sb_feature_template_page'] != 0){

                         $url = (isset($adforest_theme['sb_feature_template_page']) && $adforest_theme['sb_feature_template_page'] != "" ) ?  get_the_permalink($adforest_theme['sb_feature_template_page']) : "#";

                           $url = $url != ""  ? $url."?pid=" . $pid : "#";
                           $ad_featured = '<a class="mb-1 btn btn-sm btn-info mr-2 sb_anchor sb_make_feature_ad" data-url =  "'.$url.'" href="javascript:void(0);"  data-aaa-id="' . esc_attr($pid) . '">' . __('Mark featured', 'adforest') . '</a>';
                           }
                    }
                    
                    if ($hide_feature) {

                        $ad_featured = "";
                    }
                    $add_ons = '<div class="bump-or-feature">
                     ' . $ad_featured . '
                     <a class="mb-1 btn btn-sm btn-info  bump_it_up" href="javascript:void(0);" data-aaa-id="' . esc_attr($pid) . '">' . __('Bump up', 'adforest') . '</a>
                    </div>';
                }



                if ($fav_ads == 'yes') {

                    $add_ons = '<div class="fav_remove">  <a class="mb-1 btn btn-sm btn-info  remove_fav_ad" href="javascript:void(0);" data-aaa-id="' . $pid . '">' . __('Remove', 'adforest') . '</a></div>';
                }

                $ad_status = "";
                $status_container = "";

                $ad_update_url = adforest_set_url_param(get_the_permalink($sb_post_ad_page), 'id', $pid);

                if ($fav_ads == 'no' || 'expired_sold' == $fav_ads) {

                    $ad_status .= '<div class="dropdown show d-inline-block widget-dropdown">
    <a class="ad-actions" href="#" role="button" id="dropdown-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"><i class="fa fa-ellipsis-v"></i></a>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-notification">
        <li class="dropdown-item post-statuses">' . esc_html__('Post status', 'adforest') . '</li>';
                    if ($status == 'expired') {
                        $ad_status .= '<li class="dropdown-item  list-selected"><a href="javascript:void(0)" class = "ad_status  " >' . adforest_ad_statues('expired') . '</a></li>';
                    } else {
                        $ad_status .= ' <li class="dropdown-item"><a href="javascript:void(0)" class = "ad_status" data-adid =  ' . $pid . ' data-value="expired">' . adforest_ad_statues('expired') . '</a></li>';
                    }
                    if ($status == 'sold') {
                        $ad_status .= ' <li class="dropdown-item  list-selected"><a href="javascript:void(0)" class = "ad_status  ">' . adforest_ad_statues('sold') . '</a></li>';
                    } else {
                        $ad_status .= ' <li class="dropdown-item"><a href="javascript:void(0)" class = "ad_status" data-adid =  ' . $pid . ' data-value="sold">' . adforest_ad_statues('sold') . '</a></li>';
                    }
                    if ($status == 'active') {
                        $ad_status .= ' <li class="dropdown-item list-selected"><a href="javascript:void(0)" class = "ad_status ">' . adforest_ad_statues('active') . '</a></li>';
                    } else {
                        $ad_status .= '<li class="dropdown-item"><a href="javascript:void(0)" class = "ad_status" data-adid =  ' . $pid . ' data-value="active">' . adforest_ad_statues('active') . '</a></li>';
                    }

                    $ad_status .= '<li class="dropdown-item"><a href="javascript:void(0)" class = "ad_package_info" data-adid =  ' . $pid . '>' . esc_html__('Info', 'adforest') . '</a></li>';

                    $ad_status .= '<li class="dropdown-item"><a href="' . esc_url($ad_update_url) . '" class = "edit_ad" >' . esc_html__('Edit', 'adforest') . '</a></li>';
                    $ad_status .= '<li class="dropdown-item"><a href="javascript:void()" class = "remove_ad" data-adid =  ' . $pid . '>' . esc_html__('Delete', 'adforest') . '</a></li>';

                    $ad_status .= '</ul>
</div>';
                } else {
                    
                }


                $ads_list .= '<div class="col-lg-6 col-xl-4 holder-' . $pid . '">
    <div class="card card-default p-4">  
        ' . $ad_status . '
        <div class="media text-secondary">
            <img src="' . esc_url($image[0]) . '" class="mr-3 img-fluid rounded my-ads-image" alt="' . esc_attr__('image', 'adforest') . '">
            <div class="media-body">
                <h5 class="mt-0 mb-2 text-dark"><a href="' . get_the_permalink($pid) . '"> ' . get_the_title() . '</a></h5>
                <ul class="list-unstyled">
                    <li class="d-flex mb-1">

                        <span>' . adforest_adPrice(get_the_ID(), '', '') . '</span>
                    </li>
                    <li class="d-flex mb-1">                                    
                        ' . $add_ons . '
                    </li>
                </ul>
            </div>  
        </div>
    </div>
</div>';
            } wp_reset_postdata();

            $ads_list .= '<div  class="col-12"><div class="pagination-item">' . adforest_pagination_ads($ads) . '</div></div>';
        } else {
            $ads_list = '<div class="col-lg-12"><div class="card "><div class="card-body">

            <div class="alert alert-primary no-found-alert" role="alert">
                ' . esc_html__('No Result Found for the following', 'adforest') . '
            </div></div></div></div>';
        }
        return $ads_list;
    }

}