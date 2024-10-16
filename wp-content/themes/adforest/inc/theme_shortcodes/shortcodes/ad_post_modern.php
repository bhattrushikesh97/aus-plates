<?php

/* ------------------------------------------------ */
/* Post Ad  */
/* ------------------------------------------------ */
if (!function_exists('ad_post_short')) {

    function ad_post_short() {
        vc_map(array(
            "name" => __("Ad Post - Modern", 'adforest'),
            "base" => "ad_post_short_base",
            "category" => __("Theme Shortcodes", 'adforest'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Ad Post Form Type", 'adforest'),
                    "param_name" => "ad_post_form_type",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Post Form', 'adforest') => '',
                        __('Default Form', 'adforest') => 'no',
                        __('Categories Based Form', 'adforest') => 'yes',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => 'no',
                    "description" => __("Select the ad post form type default or with dynamic categories based. Extra fields will only works with default form.", 'adforest'),
                ),
                adforest_generate_type(__('Terms & Condition Field', 'adforest'), 'dropdown', 'terms_switch', '', '', array(
                    __('Hide', 'adforest') => 'hide',
                    __('Show', 'adforest') => 'show',
                )),
                adforest_generate_type(__('Terms & Condition Title', 'adforest'), 'textfield', 'terms_title', '', '', '', '', 'vc_col-sm-12 vc_column', array(
                    'element' => 'terms_switch',
                    'value' => 'show',
                )),
                adforest_generate_type(__('Terms & Conditions', 'adforest'), 'vc_link', 'terms_link', '', '', '', '', 'vc_col-sm-12 vc_column', array(
                    'element' => 'terms_switch',
                    'value' => 'show',
                )),
                adforest_generate_type(__('Extra Fields Section Title', 'adforest'), 'textfield', 'extra_section_title'),
                // Making add more loop for fields
                array
                    (
                    'group' => __('Extra Fields', 'adforest'),
                    'type' => 'param_group',
                    'heading' => __('Add field', 'adforest'),
                    'param_name' => 'fields',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'ad_post_form_type',
                        'value' => 'no',
                    ),
                    'params' => array
                        (
                        adforest_generate_type(__('Title', 'adforest'), 'textfield', 'title'),
                        adforest_generate_type(__('Slug', 'adforest'), 'textfield', 'slug', __('This should be unique and if you change it the pervious data of this field will be lost', 'adforest')),
                        adforest_generate_type(__('Type', 'adforest'), 'dropdown', 'type', '', "", array("Please select" => "", "Textfield" => "text", "Select/List" => "select")),
                        adforest_generate_type(__('Values for Select/List', 'adforest'), 'textarea', 'option_values', __('Like: value1,value2,value3', 'adforest'), '', '', '', 'vc_col-sm-12 vc_column', array('element' => 'type', 'value' => 'select')),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'ad_post_short');
if (!function_exists('ad_post_short_base_func')) {

    function ad_post_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'extra_section_title' => '',
            'tips_description' => '',
            'fields' => '',
            'ad_post_form_type' => 'no',
            'terms_link' => '',
            'terms_title' => '',
            'terms_switch' => 'hide'
                        ), $atts));
        extract($atts);
        global $adforest_theme;
        do_action('adforest_validate_phone_verification');
        require trailingslashit(get_template_directory()) . 'inc/class-adpost-categories.php';
        $size_arr = explode('-', $adforest_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];
        adforest_user_not_logged_in();
        $description = '';
        $title = '';
        $price = '';
        $poster_name = '';
        $poster_ph = '';
        $ad_location = '';
        $ad_condition = '';
        $is_update = '';
        $level = '';
        $cats_html = '';
        $sub_cats_html = '';
        $sub_sub_cats_html = '';
        $sub_sub_sub_cats_html = '';
        $type_selected = '';
        $ad_type = '';
        $ad_warranty = '';
        $tags = '';
        $id = '';
        $ad_yvideo = '';
        $ad_map_lat = '';
        $ad_map_long = '';
        $ad_bidding = '';
        $ad_price_type = '';
        $is_feature_ad = 0;
        $ad_currency = '';
        $levelz = '';
        $country_html = '';
        $country_states = '';
        $country_cities = '';
        $country_towns = '';
        $ad_condition_html = '';
        $ad_warranty_html = '';
        $ad_type_html = '';
        $extra_fields_html = '';
        $video_html = '';
        $tags_html = '';
        $ad_bidding_date = '';
        $update_notice = '';
        $adforest_ad_html = isset($adforest_theme['sb_ad_desc_html']) ? $adforest_theme['sb_ad_desc_html'] : false;
        $sb_upload_limit_admin = isset($adforest_theme['sb_upload_limit']) && !empty($adforest_theme['sb_upload_limit']) && $adforest_theme['sb_upload_limit'] > 0 ? $adforest_theme['sb_upload_limit'] : 0;
        $user_upload_max_images = $sb_upload_limit_admin;
        $max_upload_vid_limit_opt = isset($adforest_theme['sb_upload_video_limit']) ? $adforest_theme['sb_upload_video_limit'] : "";

        $selected_cats_list = "";
        $cat_style = ' style="display:none"';
        $busniess_hours = "";
        $cat_list = "";
        $libutton = "";
        $user_info = get_userdata(get_current_user_id());

        $poster_name = $user_info->display_name;
        $poster_email = $user_info->user_email;

        if (is_user_logged_in()) {
            $current_user = get_current_user_id();
            if ($current_user) {
                update_user_meta($current_user, '_sb_last_login', time());
            }

            $user_packages_images = get_user_meta($current_user, '_sb_num_of_images', true);
            if (isset($user_packages_images) && $user_packages_images == '-1') {
                $user_upload_max_images = 'null';
            } else if (isset($user_packages_images) && $user_packages_images > 0) {
                $user_upload_max_images = $user_packages_images;
            }
        }


        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (isset($id) && $id != "") {
                $update_notice = '
                      <div role="alert" class="alert alert-info alert-dismissible">
                      <i class="fa fa-info-circle"></i>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      ' . $adforest_theme['sb_ad_update_notice'] . '
                      </div>                    
                    ';
            }

            $my_url = adforest_get_current_url();
            if (strpos($my_url, 'adforest.scriptsbundle.com') !== false && !is_super_admin(get_current_user_id())) {
                echo adforest_redirect(home_url('/'));
                exit;
            }
            if (get_post_field('post_author', $id) != get_current_user_id() && !is_super_admin(get_current_user_id())) {
                echo adforest_redirect(home_url('/'));
                exit;
            } else {
                $post = get_post($id);
                $description = $post->post_content;
                $description = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $description);
                $title = esc_html($post->post_title);
                $price = get_post_meta($id, '_adforest_ad_price', true);
                $poster_name = get_post_meta($id, '_adforest_poster_name', true);
                $poster_ph = get_post_meta($id, '_adforest_poster_contact', true);
                $ad_location = get_post_meta($id, '_adforest_ad_location', true);
                $ad_condition = get_post_meta($id, '_adforest_ad_condition', true);
                $ad_type = get_post_meta($id, '_adforest_ad_type', true);
                $ad_warranty = get_post_meta($id, '_adforest_ad_warranty', true);
                $ad_yvideo = get_post_meta($id, '_adforest_ad_yvideo', true);
                $ad_map_lat = get_post_meta($id, '_adforest_ad_map_lat', true);
                $ad_map_long = get_post_meta($id, '_adforest_ad_map_long', true);
                $ad_bidding = get_post_meta($id, '_adforest_ad_bidding', true);
                $ad_price_type = get_post_meta($id, '_adforest_ad_price_type', true);
                $is_feature_ad = get_post_meta($id, '_adforest_is_feature', true);
                $ad_currency = get_post_meta($id, '_adforest_ad_currency', true);

                $ad_bidding_date = get_post_meta($id, '_adforest_ad_bidding_date', true);

                $tags_array = wp_get_object_terms($id, 'ad_tags', array('fields' => 'names'));
                $tags = implode(',', $tags_array);

                $is_update = $id;
                $cats = adforest_get_ad_cats($id);

                $level = count($cats);
                /* Make cats selected on update ad */
                $ad_cats = adforest_get_cats('ad_cats', 0, 0, 'post_ad');

                $cats_html = '';
                foreach ($ad_cats as $ad_cat) {
                    $selected = '';
                    if ($level > 0 && $ad_cat->term_id == $cats[0]['id']) {
                        $selected = ' selected="selected"';

                        $selected_cats_list .= '<li> ' . $ad_cat->name . ' </li> ';
                    }
                    $cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '  data-name = "' . $ad_cat->name . '">' . $ad_cat->name . '</option>';
                }
                if ($level >= 2) {
                    $ad_sub_cats = adforest_get_cats('ad_cats', $cats[0]['id'], 0, 'post_ad');
                    $sub_cats_html = '';
                    foreach ($ad_sub_cats as $ad_cat) {
                        $selected = '';
                        if ($level > 0 && $ad_cat->term_id == $cats[1]['id']) {
                            $selected = ' selected="selected"';
                            $selected_cats_list .= '<li> ' . $ad_cat->name . ' </li> ';
                        }
                        $sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '  data-name = "' . $ad_cat->name . '">' . $ad_cat->name . '</option>';
                    }
                }
                if ($level >= 3) {
                    $ad_sub_sub_cats = adforest_get_cats('ad_cats', $cats[1]['id'], 0, 'post_ad');
                    $sub_sub_cats_html = '';
                    foreach ($ad_sub_sub_cats as $ad_cat) {
                        $selected = '';
                        if ($level > 0 && $ad_cat->term_id == $cats[2]['id']) {
                            $selected = ' selected="selected"';
                            $selected_cats_list .= '<li> ' . $ad_cat->name . ' </li> ';
                        }
                        $sub_sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . '  data-name = "' . $ad_cat->name . '">' . $ad_cat->name . '</option>';
                    }
                }

                if ($level >= 4) {
                    $ad_sub_sub_sub_cats = adforest_get_cats('ad_cats', $cats[2]['id'], 0, 'post_ad');
                    $sub_sub_sub_cats_html = '';
                    foreach ($ad_sub_sub_sub_cats as $ad_cat) {
                        $selected = '';
                        if ($level > 0 && $ad_cat->term_id == $cats[3]['id']) {
                            $selected = ' selected="selected"';
                            $selected_cats_list .= '<li> ' . $ad_cat->name . ' </li> ';
                        }
                        $sub_sub_sub_cats_html .= '<option value="' . $ad_cat->term_id . '" ' . $selected . ' data-name = "' . $ad_cat->name . '" >' . $ad_cat->name . '</option>';
                    }
                }



                if (isset($cats_html) && $cats_html != '') {
                    $cat_style = '';
                }


                //Countries
                $countries = adforest_get_ad_cats($id, '', true);
                $levelz = count($countries);
                /* Make cats selected on update ad */
                $ad_countries = adforest_get_cats('ad_country', 0, 0, 'post_ad');

                $country_html = '';
                foreach ($ad_countries as $ad_country) {
                    $selected = '';
                    if ($levelz > 0 && $ad_country->term_id == $countries[0]['id']) {
                        $selected = 'selected="selected"';
                    }
                    $country_html .= '<option value="' . $ad_country->term_id . '" ' . $selected . '>' . $ad_country->name . '</option>';
                }

                if ($levelz >= 2) {
                    $ad_states = adforest_get_cats('ad_country', $countries[0]['id'], 0, 'post_ad');
                    $country_states = '';
                    foreach ($ad_states as $ad_state) {
                        $selected = '';
                        if ($levelz > 0 && $ad_state->term_id == $countries[1]['id']) {
                            $selected = 'selected="selected"';
                        }
                        $country_states .= '<option value="' . $ad_state->term_id . '" ' . $selected . '>' . $ad_state->name . '</option>';
                    }
                }

                if ($levelz >= 3) {
                    $ad_country_cities = adforest_get_cats('ad_country', $countries[1]['id'], 0, 'post_ad');
                    $country_cities = '';
                    foreach ($ad_country_cities as $ad_city) {
                        $selected = '';
                        if ($levelz > 0 && $ad_city->term_id == $countries[2]['id']) {
                            $selected = 'selected="selected"';
                        }
                        $country_cities .= '<option value="' . $ad_city->term_id . '" ' . $selected . '>' . $ad_city->name . '</option>';
                    }
                }

                if ($levelz >= 4) {
                    $ad_country_town = adforest_get_cats('ad_country', $countries[2]['id'], 0, 'post_ad');
                    $country_towns = '';
                    foreach ($ad_country_town as $ad_town) {
                        $selected = '';
                        if ($levelz > 0 && $ad_town->term_id == $countries[3]['id']) {
                            $selected = 'selected="selected"';
                        }
                        $country_towns .= '<option value="' . $ad_town->term_id . '" ' . $selected . '>' . $ad_town->name . '</option>';
                    }
                }
            }
        } else {

       $pay_per_post_check = isset($adforest_theme['sb_packages_page']) ? $adforest_theme['sb_packages_page']: "";
        if($pay_per_post_check == ""){
            if (!$adforest_theme['admin_allow_unlimited_ads']) {
                adforest_check_validity();
            }
            if (!is_super_admin(get_current_user_id())) {
                adforest_check_validity();
            }

            }

            $poster_ph = get_user_meta($user_info->ID, '_sb_contact', true);
            //$ad_location	=	get_user_meta($profile->user_info->ID, '_sb_address', true );

            $ad_cats = adforest_get_cats('ad_cats', 0, 0, 'post_ad');
            $cats_html = '';
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '" data-name = "' . $ad_cat->name . '">' . $ad_cat->name . '</option>';
            }
            //Countries
            $ad_country = adforest_get_cats('ad_country', 0, 0, 'post_ad');
            $country_html = '';
            foreach ($ad_country as $ad_count) {
                $country_html .= '<option value="' . $ad_count->term_id . '">' . $ad_count->name . '</option>';
            }
        }


        /* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */

        wp_enqueue_style('jquery-tagsinput', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.tagsinput.min.css');
        wp_enqueue_style('jquery-te', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery-te.css');
        wp_enqueue_style('dropzone', trailingslashit(get_template_directory_uri()) . 'assests/css/dropzone.css');
        wp_enqueue_style('adforest-dt', trailingslashit(get_template_directory_uri()) . 'assests/css/datepicker.min.css');

        $rtl = 0;
        if (function_exists('icl_object_id')) {
            if (apply_filters('wpml_is_rtl', NULL)) {
                $rtl = 1;
            }
        } else {
            if (is_rtl()) {
                $rtl = 1;
            }
        }

        adforest_load_search_countries(1);
        wp_enqueue_script('google-map-callback');
        wp_enqueue_script('adforest-dt');
        $extra_fields_html = '';

        // Making fields
        if (isset($atts['fields']) && $atts['fields'] != '') {



            if (isset($adforest_elementor) && $adforest_elementor) {
                $rows = ($atts['fields']);
            } else {
                $rows = vc_param_group_parse_atts($atts['fields']);
            }

            $rows   =  array();

            if (isset($rows) && is_array($rows) && count($rows) > 0 && count($rows[0]) > 0) {
                $total_fileds = 1;
                $extra_fields_html .= '<div class="card-header sub-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapseExtra" aria-expanded="false">
                                <h2 class="mb1-1">
                                    <button type="button" class="btn btn-link">
                                        <i class="fa fa-angle-right"></i>' . $extra_section_title . '</button>									
                                </h2>
                            </div>
                            <div id="collapseExtra" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample"><div class="ad-extra-information"><div class="row">';
                foreach ($rows as $row) {
                    if (isset($row['title']) && isset($row['type']) && isset($row['slug'])) {
                        $extra_fields_html .= '
			  <div class="col-md-12 col-lg-6 col-xs-12 col-sm-12">
				 <label class="control-label">' . $row['title'] . ' <span class="required">*</span></label>';
                        if ($row['type'] == 'text') {
                            $extra_fields_html .= '<input class="form-control" value="' . get_post_meta($id, '_sb_extra_' . $row['slug'], true) . '" type="text" name="sb_extra_' . $total_fileds . '" id="sb_extra_' . $total_fileds . '" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '"></div>';
                        }
                        if ($row['type'] == 'select' && isset($row['option_values'])) {
                            $extra_fields_html .= '<select class="category form-control" id="sb_extra_' . $total_fileds . '" name="sb_extra_' . $total_fileds . '">';
                            $extra_fields_html .= '<option value="">' . __('None', 'adforest') . '</option>';
                            $options = explode(',', $row['option_values']);
                            foreach ($options as $key => $value) {
                                $is_select = '';
                                if ($value == get_post_meta($id, '_sb_extra_' . $row['slug'], true)) {
                                    $is_select = 'selected';
                                }
                                $extra_fields_html .= '<option value="' . $value . '" ' . $is_select . '>' . $value . '</option>';
                            }
                            $extra_fields_html .= '</select></div>';
                        }
                        $extra_fields_html .= '<input type="hidden" name="title_' . $total_fileds . '" value="' . $row['slug'] . '">';
                        $total_fileds++;
                    }
                }
                $total_fileds = $total_fileds - 1;
                $extra_fields_html .= '<input type="hidden" name="sb_total_extra" value="' . $total_fileds . '">';
                $extra_fields_html .= '</div></div></div>';
            }
        }


        $isCustom = $ad_post_form_type;

        $someStaticHtml2 = $videoStaticHTML = $imageStaticHTML = $priceStaticHTML = $priceTypeHTML = $ad_curreny_html = $someStaticHTML = $customDynamicFields = $customDynamicAdType = '';

        if ($isCustom == 'no') {

            $price_fixed = '';
            $price_negotiable = '';
            $price_on_call = '';
            $free = '';
            $no_price = '';
            $price_auction = '';
            if ($ad_price_type == 'Fixed') {
                $price_fixed = 'selected=selected';
            } else if ($ad_price_type == 'Negotiable') {
                $price_negotiable = 'selected=selected';
            } else if ($ad_price_type == 'on_call') {
                $price_on_call = 'selected=selected';
            } else if ($ad_price_type == 'free') {
                $free = 'selected=selected';
            } else if ($ad_price_type == 'no_price') {
                $no_price = 'selected=selected';
            } else if ($ad_price_type == 'auction') {
                $price_auction = 'selected=selected';
            }

            $sb_price_types_strings = array(
                'Fixed' => __('Fixed', 'adforest')
                , 'Negotiable' => __('Negotiable', 'adforest'),
                'on_call' => __('Price on call', 'adforest'),
                'auction' => __('Auction', 'adforest'),
                'free' => __('Free', 'adforest'),
                'no_price' => __('No price', 'adforest')
            );

            if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) > 0) {
                $sb_price_types = $adforest_theme['sb_price_types'];
            } else if (isset($adforest_theme['sb_price_types']) && count($adforest_theme['sb_price_types']) == 0 && isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] == "") {
                $sb_price_types = array('Fixed', 'Negotiable', 'on_call', 'auction', 'free', 'no_price');
            } else {
                $sb_price_types = array();
            }


            $types = adforest_get_cats('ad_type', 0);
            $type_val = "";
            $ad_type_html = '<div class="form-section">
                <label class="control-label">' . __('Type of Ad', 'adforest') . '</label>';
            foreach ($types as $type) {
                $selected = '';
                if ($ad_type == $type->name) {
                    $selected = 'btn-selected';
                    $type_val = $type->term_id . '|' . $type->name;
                }
                $ad_type_html .= '<a href="javascript:void(0)" class="btn btn-type ' . esc_attr($selected) . '" data-id ="' . $type->term_id . '|' . $type->name . '">' . $type->name . '</a>';
            }
            $ad_type_html .= '<input type="hidden" id="type" name="buy_sell" value = "' . $type_val . '"></div>';
            $ad_condition_html = '';
            if ($adforest_theme['allow_tax_condition']) {
                $ad_condition_html = '
			  <!-- Category  -->
			  <div class="col-lg-6 col-md-6 col-sm-12">
			  <div class="form-group">
			  <label class="control-label">' . __('Item Condition', 'adforest') . '</label>';

                $conditions = adforest_get_cats('ad_condition', 0);
                $condition_val = "";
                foreach ($conditions as $con) {
                    $selected = '';
                    if ($ad_condition == $con->name) {
                        $selected = 'btn-selected';
                        $condition_val = $con->term_id . '|' . $con->name;
                    }

                    $ad_condition_html .= '<a href="javascript:void(0)" class="btn btn-condition  ' . esc_attr($selected) . '" data-id = "' . $con->term_id . '|' . $con->name . '">' . $con->name . '</a>';
                }
                $ad_condition_html .= '<input type="hidden" id="condition" name="condition" value="' . $condition_val . '"></div></div>';
            }
            $ad_warranty_html = '';
            $ad_warranty_val = "";
            if ($adforest_theme['allow_tax_warranty']) {
                $ad_warranty_html = '
			  <!-- Category  -->
			  <div class="col-lg-6 col-md-6 col-sm-12">
			  <div class="form-group">
			  <label class="control-label">' . __('Warranty', 'adforest') . '</label>';

                $ad_warraty = adforest_get_cats('ad_warranty', 0);
                foreach ($ad_warraty as $warranty) {
                    $selected = '';
                    if ($ad_warranty == $warranty->name) {
                        $selected = 'btn-selected';
                        $ad_warranty_val = $warranty->term_id . '|' . $warranty->name;
                    }
                    $ad_warranty_html .= '<a href="javascript:void(0)" class="btn btn-warranty  ' . esc_attr($selected) . '" data-id ="' . $warranty->term_id . '|' . $warranty->name . '">' . $warranty->name . '</a>';
                }
                $ad_warranty_html .= '<input id="warranty" name="ad_warranty" type="hidden" value = "' . $ad_warranty_val . '"></div></div>';
            }

            $someStaticHTML = '<div class="form-section">
                                    <div class="row">
                                        ' . $ad_condition_html . '
                                        ' . $ad_warranty_html . '
                                    </div>
                                </div>';

            $sb_price_types_html = '';
            if (count($sb_price_types) > 0) {
                foreach ($sb_price_types as $p_type) {
                    $p_selected = '';
                    if ($p_type == $ad_price_type)
                        $p_selected = 'selected="selected"';

                    $sb_price_types_html .= '<option value="' . $p_type . '" ' . $p_selected . '>' . $sb_price_types_strings[$p_type] . '</option>';
                }
            }

            if (isset($adforest_theme['sb_price_types_more']) && $adforest_theme['sb_price_types_more'] != "") {
                $sb_price_types_more_array = explode('|', $adforest_theme['sb_price_types_more']);
                foreach ($sb_price_types_more_array as $p_type_more) {
                    $p_selected = '';
                    if ($p_type_more == $ad_price_type)
                        $p_selected = 'selected="selected"';

                    $sb_price_types_html .= '<option value="' . $p_type_more . '" ' . $p_selected . '>' . $p_type_more . '</option>';
                }
            }

            $priceTypeHTML = '<div class="col-lg-6 col-md-6 col-sm-12">
			 <label class="control-label">' . __('Price', 'adforest') . ' <span class="required">*</span></label>
			 <input class="form-control" type="text" name="ad_price" id="ad_price" data-parsley-required="true" data-parsley-pattern="/^[0-9]+\.?[0-9]*$/" data-parsley-error-message="' . __('only numbers allowed.', 'adforest') . '" value="' . $price . '">
		  </div>';

            if (isset($adforest_theme['allow_price_type'])) {
                if ($adforest_theme['allow_price_type']) {
                    $priceStaticHTML = '<div class="col-lg-6 col-md-6 col-sm-12">
					 <label class="control-label">' . __('Price Type', 'adforest') . '</label>
					 <select class="form-control" name="ad_price_type" id="ad_price_type">
							<option value="">' . __('None', 'adforest') . '</option>
							' . $sb_price_types_html . '
					</select>
				  </div>';
                }
            }
            $priceStaticHTML .= $priceTypeHTML;
            $_sb_video_links = get_user_meta(get_current_user_id(), '_sb_video_links', true);
            $_sb_allow_tags = get_user_meta(get_current_user_id(), '_sb_allow_tags', true);

            $video_html = '';
            if (isset($_sb_video_links) && $_sb_video_links == "" || $_sb_video_links == 'no') {
                $video_html = '';
            } else {
                $valid_text = __('Should be valid youtube video url.', 'adforest');
                $video_html = '<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">                                   
                                           <label class="control-label">' . __('Youtube Video Link', 'adforest') . '</label>
                                           <input data-parsley-required="false" data-parsley-error-message="' . $valid_text . '" data-parsley-pattern="/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/" class="form-control" type="text" name="ad_yvideo" id="ad_yvideo" value="' . $ad_yvideo . '"></div>';
            }
            $currenies = adforest_get_cats('ad_currency', 0);
            $ad_curreny_html = "";
            $defult_currency = $adforest_theme['sb_currency'];
            $ad_currency_option =  $adforest_theme['sb_currency_option_ad_post'];
            if($defult_currency == ""){
            if($ad_currency_option != ""){
            if (count($currenies) > 0) {
                $ad_curreny_html = '
			<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
			<label class="control-label">' . __('Select Currency', 'adforest') . '</label><select class="category form-control" id="ad_currency" name="ad_currency" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
					<option value="">' . __('Select Option', 'adforest') . '</option>';
                foreach ($currenies as $currency) {
                    $selected = '';
                    if ($ad_currency == $currency->name) {
                        $selected = ' selected="selected"';
                    }

                    if ($ad_currency == "" && isset($adforest_theme['sb_multi_currency_default']) && $adforest_theme['sb_multi_currency_default'] != "") {
                        if ($adforest_theme['sb_multi_currency_default'] == $currency->term_id) {
                            $selected = ' selected="selected"';
                        }
                    }
                    $ad_curreny_html .= '<option value="' . $currency->term_id . '|' . $currency->name . '"' . $selected . '>' . $currency->name . '</option>';
                }
                $ad_curreny_html .= '</select></div>';
            }
            }
         }
            if ($priceStaticHTML != "" || $priceStaticHTML != "") {
                $someStaticHtml2 = '<div class="form-section">
                                    <div class="row">  
                                        ' . $ad_curreny_html . '
                                        ' . $priceStaticHTML . '
                                        ' . $video_html . '
                                    </div>
                                </div>';
            }

            $sb_default_img_required = isset($adforest_theme['sb_default_img_required']) && $adforest_theme['sb_default_img_required'] ? true : false; // get image req or not in default template ad post
            $req_images_html = '';
            if ($sb_default_img_required && $isCustom == 'no') {
                $req_images_html = '<span class="required">*</span>';
            }

            $req_video_html = "";

            $max_upload_vid_size = isset($adforest_theme['sb_upload_video_mb_limit']) ? $adforest_theme['sb_upload_video_mb_limit'] : 2;

            $imageStaticHTML = '<div class="form-group"><div class="row">
		  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			 <label class="control-label">' . __('Click the box below to ad photos', 'adforest') . ' ' . $req_images_html . ' <small>' . __('upload only jpg, png and jpeg files with a max file size of', 'adforest') . " " . $display_size . '</small></label>
			 <div id="dropzone" class="dropzone"></div>
		  </div>
		</div></div>';

            if (isset($adforest_theme['sb_allow_upload_video']) && $adforest_theme['sb_allow_upload_video']) {
                $videoStaticHTML = '<div class="form-group"><div class="row">
		  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			 <label class="control-label">' . __('Click the box below to ad Videos', 'adforest') . ' ' . $req_video_html . ' <small>' . __('upload only videos (mp4, ogg, webm) files with a max file size of', 'adforest') . " " . $max_upload_vid_size . '</small></label>
			 <div id="dropzone_video" class="dropzone"></div>
		  </div>
		</div></div>';
            }
            $tags_html = '';
            if (isset($_sb_allow_tags) && !empty($_sb_allow_tags) && $_sb_allow_tags == 'no') {
                $tags_html = '';
            } else {
                $tags_html = '<div class="form-group"><div class="tags"><div class="row">
				<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
					 <label class="control-label">' . __('Tags', 'adforest') . ' <small>' . __('Comma(,) separated', 'adforest') . '</small></label>
					 <input class="form-control" name="tags" id="tags" value="' . $tags . '" >
				</div>
			</div></div></div>';
            }
        } else {

            $customDynamicAdType = '';
            $customDynamicFields = '<div id="dynamic-fields" class="dynamic-fields-container"> ' . adforest_returnHTML($id) . ' </div>';
        }
        $mapType = adforest_mapType();
        $lat_long_html = '';
        $lat_lon_script = '';
        $for_g_map = '';
        $is_allow_map = 1;

        if (isset($adforest_theme['allow_lat_lon']) && !$adforest_theme['allow_lat_lon']) {
            $is_allow_map = 2;
        } else {
            $pin_lat = $ad_map_lat;
            $pin_long = $ad_map_long;
            if ($ad_map_lat == "" && $ad_map_long == "" && isset($adforest_theme['sb_default_lat']) && $adforest_theme['sb_default_lat'] && isset($adforest_theme['sb_default_long']) && $adforest_theme['sb_default_long']) {
                $pin_lat = $adforest_theme['sb_default_lat'];
                $pin_long = $adforest_theme['sb_default_long'];
            }

            $libutton = '';
            if ($mapType != 'leafletjs_map') {
                $libutton = '<li><a href="javascript:void(0);" id="your_current_location" title="' . __('You Current Location', 'adforest') . '"><i class="fa fa-crosshairs"></i></a></li>';
            }

            $for_g_map = '<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <div id="dvMap" style="width: 100%; height: 350px"></div>
			 
			  <em><small>' . __('Drag pin for your pin-point location.', 'adforest') . '</small></em>
			  </div></div>';
?>
            <?php

            if ($mapType == 'leafletjs_map') {
                $lat_lon_script = '<script type="text/javascript">var mymap = L.map(\'dvMap\').setView([' . $pin_lat . ', ' . $pin_long . '], 13); L.tileLayer(\'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png\', {maxZoom: 18,attribution: \'\'}).addTo(mymap);var markerz = L.marker([' . $pin_lat . ', ' . $pin_long . '],{draggable: true}).addTo(mymap);var searchControl 	=	new L.Control.Search({url: \'//nominatim.openstreetmap.org/search?format=json&q={s}\',jsonpParam: \'json_callback\',propertyName: \'display_name\',propertyLoc: [\'lat\',\'lon\'],marker: markerz,autoCollapse: true,autoType: true,minLength: 2,});searchControl.on(\'search:locationfound\', function(obj) {		var lt	=	obj.latlng + \'\';var res = lt.split( "LatLng(" );res = res[1].split( ")" );res = res[0].split( "," );document.getElementById(\'ad_map_lat\').value = res[0];document.getElementById(\'ad_map_long\').value = res[1];});mymap.addControl( searchControl );markerz.on(\'dragend\', function (e) {document.getElementById(\'ad_map_lat\').value = markerz.getLatLng().lat;document.getElementById(\'ad_map_long\').value = markerz.getLatLng().lng;});</script>';
            } 
            else if ($mapType == 'google_map') {
            $lat_lon_script = '<script type="text/javascript">
			var my_map;var marker;
			var markers = [{"title": "","lat": "' . $pin_lat . '","lng": "' . $pin_long . '",},];
			window.onload = function () {my_g_map(markers);}
				function my_g_map(markers1){var mapOptions = {center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),zoom: 12,mapTypeId: google.maps.MapTypeId.ROADMAP };
				var infoWindow = new google.maps.InfoWindow();
				var latlngbounds = new google.maps.LatLngBounds();
				var geocoder = geocoder = new google.maps.Geocoder();
				my_map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
					var data = markers1[0]
					var myLatlng = new google.maps.LatLng(data.lat, data.lng);
					marker = new google.maps.Marker({position: myLatlng,map: my_map,title: data.title,draggable: true, animation: google.maps.Animation.DROP });
					(function (marker, data) {
						google.maps.event.addListener(marker, "click", function (e) {
							infoWindow.setContent(data.description);
							infoWindow.open(map, marker);
						});
						google.maps.event.addListener(marker, "dragend", function (e) {
							document.getElementById("sb_loading").style.display	= "block";
							var lat, lng, address;
							geocoder.geocode({ "latLng": marker.getPosition() }, function (results, status) {
								
								if (status == google.maps.GeocoderStatus.OK) {
									lat = marker.getPosition().lat();
									lng = marker.getPosition().lng();
									address = results[0].formatted_address;
									document.getElementById("ad_map_lat").value = lat;
									document.getElementById("ad_map_long").value = lng;
                                                                        
                                                                         if(document.getElementById("sb_user_address") !=  null  ){

									document.getElementById("sb_user_address").value = address;
                                                                        
                                                                         }
									document.getElementById("sb_loading").style.display	= "none";
								}
							});
						});
					})(marker, data);
					latlngbounds.extend(marker.position);
				}
				jQuery(document).ready(function($) {
			$("#your_current_location").click(function() {
				$.ajax({
				url: "https://geolocation-db.com/jsonp",
				jsonpCallback: "callback",
				dataType: "jsonp",
				success: function( location ) {
                                
                                      console.log(location);
					var pos = new google.maps.LatLng(location.latitude, location.longitude);
					my_map.setCenter(pos);
					my_map.setZoom(12);
					$("#sb_user_address").val(location.city + ", " + location.state + ", " + location.country_name );
					document.getElementById("ad_map_long").value = location.longitude;
					document.getElementById("ad_map_lat").value = location.latitude;
					var markers2 = [{title: "",lat: location.latitude,lng: location.longitude,},];my_g_map(markers2);}});});});</script>';
                }
                $lat_long_html = $for_g_map . '<div class="row">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                    <label class="control-label">' . __('Latitude', 'adforest') . '</label>
                    <input class="form-control" type="text" name="ad_map_lat" id="ad_map_lat" value="' . $pin_lat . '">
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                    <label class="control-label">' . __('Longitude', 'adforest') . '</label>
                    <input class="form-control" name="ad_map_long" id="ad_map_long" value="' . $pin_long . '" type="text">
                </div>
            </div>';
        }

        // Check phone is required or not
        $ph_reg = '';
        if (isset($adforest_theme['sb_phone_verification']) && $adforest_theme['sb_phone_verification'] && isset($adforest_theme['sb_change_ph']) && $adforest_theme['sb_change_ph'] == false) {
            $phone_html = '<input class="form-control"  id="adforest_contact_number" name="sb_contact_number" readonly value="' . get_user_meta(get_current_user_id(), '_sb_contact', true) . '" type="text">';
        } else {
            $phone_html = '<input class="form-control"  id="adforest_contact_number" name="sb_contact_number" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '" value="' . $poster_ph . '" type="text">';
            $ph_reg = '<span class="required">*</span>';
            if (isset($adforest_theme['sb_user_phone_required']) && !$adforest_theme['sb_user_phone_required']) {
                $phone_html = '<input class="form-control"  id="adforest_contact_number" name="sb_contact_number" value="' . $poster_ph . '" type="text">';
                $ph_reg = '';
            }
        }

        $categorize_bid = true;
        $categorize_bid = apply_filters('adforest_make_bid_categ', $categorize_bid);

        $bid_style_cat = '';
        if (!$categorize_bid) {
            $bid_style_cat = ' style="display:none" ';
        }

        $bidable = '';
        if (isset($adforest_theme['sb_enable_comments_offer']) && $adforest_theme['sb_enable_comments_offer'] && isset($adforest_theme['sb_enable_comments_offer_user']) && $adforest_theme['sb_enable_comments_offer_user']) {
            $bidable .= '   <div class="card-header sub-header collapsed bidding-content"' . $bid_style_cat . '"  data-bs-toggle="collapse" data-bs-target="#biddingSection" aria-expanded="false">
                                <h2 class="mb1-1">
                                    <button type="button" class="btn btn-link">
                                        <i class="fa fa-angle-right"></i> ' . $adforest_theme['sb_enable_comments_offer_user_title'] . '</button>									
                                </h2>
                            </div>
                         <div id="biddingSection" class="collapse" ' . $bid_style_cat . ' aria-labelledby="headingTwo" data-parent="#accordionExample"><div class="ad-bidding-information"><div class="row">';

            $bid_on = 'selected=selected';
            $bid_off = '';
            if ($ad_bidding == 1) {
                $bid_on = 'selected=selected';
            } else {
                $bid_off = 'selected=selected';
            }

            $bidding_options = '<option value="1" ' . $bid_on . '>' . __('ON', 'adforest') . '</option>';
            $bidding_options .= '<option value="0" ' . $bid_off . '>' . __('OFF', 'adforest') . '</option>';
            $bidable .= '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                 <label class="control-label">' . __('Choose Bidding option', 'adforest') . '</label>
			 <select class="form-control" name="ad_bidding" id="ad_bidding" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
					' . $bidding_options . '
			</select>
		  </div>';
            if (isset($adforest_theme['bidding_timer']) && $adforest_theme['bidding_timer']) {
                $bidable .= '
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 biddind_div">
			       <label class="control-label">' . __('Bidding close date', 'adforest') . '<small>' . __('For countdown', 'adforest') . '</small></label>
			       <input class="form-control" placeholder="' . __('Click to select', 'adforest') . '" type="text" name="ad_bidding_date" id="ad_bidding_date"  value="' . $ad_bidding_date . '"  autocomplete="off">
			     </div>
                           ';
            }
            $bidable .= '</div></div></div>';
        }

        $bump_ad_html = '';
        $sb_packages_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_packages_page']);

        if (isset($is_update) && $is_update != "") {
            $is_package_notification = true;
            if (isset($adforest_theme['sb_allow_free_bump_up']) && $adforest_theme['sb_allow_free_bump_up']) {
                $is_package_notification = false;
                $bump_ad_html = '<div class="card  make-bump-up">
                              	<div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                 <div class="pricing-list">
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                          <h3>
										  <input type="checkbox" name="sb_bump_up" id="sb_bump_up" class="custom-checkbox" />
										  ' . __('Bump it up', 'adforest') . '  <small>' . __('Bump-up ads remaining: unlimited', 'adforest') . '</small></h3>
                                          <p>' . __('Bump it up on the top of the list.', 'adforest') . '</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>';
            } else if (get_user_meta(get_current_user_id(), '_sb_expire_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_sb_expire_ads', true) >= date('Y-m-d')) {
                if (get_user_meta(get_current_user_id(), '_sb_bump_ads', true) > 0 || get_user_meta(get_current_user_id(), '_sb_bump_ads', true) == '-1') {
                    $is_package_notification = false;
                    $bump_remaining = get_user_meta(get_current_user_id(), '_sb_bump_ads', true);
                    if (get_user_meta(get_current_user_id(), '_sb_bump_ads', true) == '-1') {
                        $bump_remaining = __('unlimited', 'adforest');
                    }

                    $bump_ad_html = '<div class="card  make-bump-up">
                              	<div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                 <div class="pricing-list">
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                          <h3>
										  <input type="checkbox" name="sb_bump_up" id="sb_bump_up" />
										  ' . __('Bump it up', 'adforest') . '  <small>' . __('Bump-up ads remaining:', 'adforest') . $bump_remaining . '</small></h3>
                                          <p>' . __('Bump it up on the top of the list.', 'adforest') . '</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>';
                }
            }






            if ($is_package_notification && isset($adforest_theme['sb_show_bump_up_notification']) && $adforest_theme['sb_show_bump_up_notification']) {
                $bump_ad_html = '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><div role="alert" class="alert alert-info alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
				' . __('If you want to bump it up then please have a look on', 'adforest') . ' 
				<a href="' . get_the_permalink($sb_packages_page) . '" class="sb_anchor" target="_blank">
				' . __('Packages. ', 'adforest') . '
                </a></div></div></div>';
            }
         }

           if(isset($adforest_theme['make_bump_up_paid']) && $adforest_theme['make_bump_up_paid'] ){
              $bump_ad_html   = "";
               }


        $simple_feature_html = '';
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
 
             if (isset($adforest_theme['allow_featured_on_ad']) && $adforest_theme['allow_featured_on_ad'] ) { 
            
            if ($is_feature_ad == 0 && ( get_user_meta(get_current_user_id(), '_sb_expire_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_sb_expire_ads', true) >= date('Y-m-d') )) {
                if (get_user_meta(get_current_user_id(), '_sb_featured_ads', true) == '-1' || get_user_meta(get_current_user_id(), '_sb_featured_ads', true) > 0) {
                    $count_featured_ads = __('Featured ads remaining: Unlimited', 'adforest');

                    if (get_user_meta(get_current_user_id(), '_sb_featured_ads', true) > 0) {
                        $count_featured_ads = __('Featured ads remaining:', 'adforest') . get_user_meta(get_current_user_id(), '_sb_featured_ads', true);
                    }
                    $feature_text = '';
                    if (isset($adforest_theme['sb_feature_desc']) && $adforest_theme['sb_feature_desc'] != "") {
                        $feature_text = $adforest_theme['sb_feature_desc'];
                    }
                    $simple_feature_html = '<div class="card  make-feature">
                              	<div class="no-padding col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                 <div class="pricing-list">
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                          <h3>
										  <input type="checkbox" name="sb_make_it_feature" id="sb_make_it_feature"  class="custom-checkbox" />
										  ' . __('Make it featured', 'adforest') . '  <small>' . $count_featured_ads . '</small></h3>
                                          <p>' . $feature_text . '</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>';
                } else {
                    $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
				' . __('If you want to make it featured then please have a look on', 'adforest') . ' 
				<a href="' . get_the_permalink($sb_packages_page) . '" class="sb_anchor" target="_blank">
				' . __('Packages. ', 'adforest') . '
                </a></div>';
                }
            } else {
                $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
			<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
			' . __('If you want to make it featured then please have a look on', 'adforest') . ' 
			<a href="' . get_the_permalink($sb_packages_page) . '" class="sb_anchor" target="_blank">
			' . __('Packages. ', 'adforest') . '
			</a></div>';


            }



            if ($is_feature_ad == 1) {
                $simple_feature_html = '<div role="alert" class="alert alert-info alert-dismissible">
				<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
				' . __('This ad is already featured.', 'adforest') . '</div>';
            }


        }


           
              if(isset($adforest_theme['make_feature_paid']) && $adforest_theme['make_feature_paid'] ){
                          $simple_feature_html   = "";
               }
        }

        $custom_locations_html = '';
        if (isset($adforest_theme['sb_custom_location']) && $adforest_theme['sb_custom_location']) {
            $loc_lvl_1 = __('Select Your Country', 'adforest');
            $loc_lvl_2 = __('Select Your State', 'adforest');
            $loc_lvl_3 = __('Select Your City', 'adforest');
            $loc_lvl_4 = __('Select Your Town', 'adforest');
            if (isset($adforest_theme['sb_location_titles']) && $adforest_theme['sb_location_titles'] != "") {
                $titles_array = explode("|", $adforest_theme['sb_location_titles']);

                if (count($titles_array) > 0) {
                    if (isset($titles_array[0]))
                        $loc_lvl_1 = $titles_array[0];
                    if (isset($titles_array[1]))
                        $loc_lvl_2 = $titles_array[1];
                    if (isset($titles_array[2]))
                        $loc_lvl_3 = $titles_array[2];
                    if (isset($titles_array[3]))
                        $loc_lvl_4 = $titles_array[3];
                }
            }
            $custom_locations_html = '<div class="row">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				 <label class="control-label">' . $loc_lvl_1 . ' <span class="required">*</span></label>
				 <select class="country form-control" id="ad_country" name="ad_country" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'adforest') . '">
					<option value="">' . esc_html__('Select Option', 'adforest') . '</option>
					' . $country_html . '
				 </select>
				 <input type="hidden" name="ad_country_id" id="ad_country_id" value="" />
			  </div>
		   </div>
		   <div class="row" id="ad_country_sub_div">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" >
			  <label class="control-label">' . $loc_lvl_2 . '</label>
				<select class="category form-control" id="ad_country_states" name="ad_country_states">
					' . $country_states . '
				</select>
			  </div>
			</div>
			 <div class="row" id="ad_country_sub_sub_div" >
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . $loc_lvl_3 . '</label>
				<select class="category form-control" id="ad_country_cities" name="ad_country_cities">
					' . $country_cities . '
				</select>
			  </div>
			</div>
			 <div class="row" id="ad_country_sub_sub_sub_div">
			  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			  <label class="control-label">' . $loc_lvl_4 . '</label>
				<select class="category form-control" id="ad_country_towns" name="ad_country_towns">
					' . $country_towns . '
				</select>
			  </div>
			</div>
		';
        }

        $ad_post_title_limit = isset($adforest_theme['ad_post_title_limit']) ? $adforest_theme['ad_post_title_limit'] : 50;
        $tems_cond_field = '';

        $terms_text = esc_html__(' Terms & conditions', 'adforest');
        if (isset($terms_title) && !empty($terms_title)) {
            $terms_text = $terms_title;
        }

        $term_link_html = '';
        if (isset($terms_link) && $terms_link != "") {

            if (isset($adforest_elementor) && $adforest_elementor) {
                $btn_args = array(
                    'btn_key' => $terms_link,
                    'adforest_elementor' => true,
                    'btn_class' => '',
                    'iconBefore' => '',
                    'iconAfter' => '',
                    'titleText' => $terms_title,
                );
                $term_link_html = apply_filters('adforest_elementor_url_field', $term_link_html, $btn_args);
            } else {
                $res = adforest_extarct_link($terms_link);
                $term_link_html = '<a href="' . $res['url'] . '" title="' . $res['title'] . '" target="' . $res['target'] . '"> ' . $terms_text . '</a>';
            }

            if (isset($terms_switch) && $terms_switch == 'show') {
                $tems_cond_field = '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"><div class="skin-minimal check-detail"><ul class="list"><li><input  type="checkbox" id="minimal-checkbox-1" name="minimal-checkbox-1" data-parsley-required="true" data-parsley-error-message="' . __('Please accept terms and conditions.', 'adforest') . '"><label for="minimal-checkbox-1">' . __('I agree to', 'adforest') . $term_link_html . ' </label></li></ul></div></div>';
            }
        }

        global $adforest_theme;
        $stricts = '';
        if (isset($adforest_theme['sb_location_allowed']) && !$adforest_theme['sb_location_allowed'] && isset($adforest_theme['sb_list_allowed_country'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($adforest_theme['sb_list_allowed_country']) . "}";
        }
        $types = "'(cities)'";
        if (isset($adforest_theme['sb_location_type']) && $adforest_theme['sb_location_type'] != "") {
            if ($adforest_theme['sb_location_type'] == 'regions')
                $types = "";
            else
                $types = "'(cities)'";
        }
        $loc_scropts = '';
        if (isset($adforest_theme['map-setings-map-type']) && $adforest_theme['map-setings-map-type'] == 'google_map') {
            $loc_scropts = "<script> function adforest_location() { console.log('asddasdasdd'); var options = {types: [" . $types . "], " . $stricts . "}; var input = document.getElementById('sb_user_address'); var action_on_complete = '1'; var autocomplete = new google.maps.places.Autocomplete(input, options); if( action_on_complete ){new google.maps.event.addListener(autocomplete, 'place_changed', function() { var place = autocomplete.getPlace();
                            document.getElementById('ad_map_lat').value = place.geometry.location.lat();
                            document.getElementById('ad_map_long').value = place.geometry.location.lng();
                                var markers = [{'title': '', 'lat': place.geometry.location.lat(), 'lng': place.geometry.location.lng(), }, ]; my_g_map(markers); }); }}</script>";
        }


        
           
        $sub_cat_required =  isset($adforest_theme['is_sub_cat_required'])   ? $adforest_theme['is_sub_cat_required']  :   false;
        
        $is_req  =   false;
        if(isset($adforest_theme['is_sub_cat_required'])  && $adforest_theme['is_sub_cat_required']){           
            $is_req  =  true;
        }

        
        $categories_style_html = '<div class="form-group cats-dropdown"> <div class="row">
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                           <label class="control-label">' . __('Category', 'adforest') . ' <span class="required">*</span> <small>' . __('Select suitable category for your ad', 'adforest') . '</small></label>
                                           <select class="category form-control" id="ad_cat" name="ad_cat" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                                                  <option value="">' . __('Select Option', 'adforest') . '</option>
                                                  ' . $cats_html . '
                                           </select>
                                           <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
                                    </div>
                                   </div>
                                    <div class="row" id="ad_cat_sub_div">
                                           <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" >
                                                <label class="control-label"><small>' . __('Select suitable subcategory for your ad', 'adforest') . '</small></label>
                                                 <select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">
                                                         ' . $sub_cats_html . '
                                                 </select>
                                           </div>
                                         </div>
                                        <div class="row" id="ad_cat_sub_sub_div" >
                                        <label class="control-label"><small>' . __('Select suitable subcategory for your ad', 'adforest') . '</small></label>
                                           <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <select class="category form-control" id="ad_cat_sub_sub" name="ad_cat_sub_sub">
                                                         ' . $sub_sub_cats_html . '
                                                 </select>
                                           </div>
                                         </div>
                                        <div class="row" id="ad_cat_sub_sub_sub_div">
                                        <label class="control-label"><small>' . __('Select suitable subcategory for your ad', 'adforest') . '</small></label>
                                           <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <select class="category form-control" id="ad_cat_sub_sub_sub" name="ad_cat_sub_sub_sub">' . $sub_sub_sub_cats_html . '</select>
                                           </div>
                                  </div></div>';
        $categories_style_html = apply_filters('adforest_adpost_modern_categories', $categories_style_html, isset($_GET['id']) ? $_GET['id'] : 0);
        $ad_id = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
        $bid_ad_id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : $ad_id;

//echo $ad_post_modern_html;

        $adpost_cat_style = isset($adforest_theme['adpost_cat_style']) && $adforest_theme['adpost_cat_style'] == 'grid';

        if ($adpost_cat_style != "grid") {
            $cat_list = '<div class="card-header sub-header sb-selected-cats-header" ' . $cat_style . '>
                           <ul class="sb-selected-cats item-sub-information">' . adforest_returnEcho($selected_cats_list) . '</ul>
                          </div>';
            $cat_class = "basic-information-categories";
        }

        $address_req = isset($adforest_theme['sb_default_ad_addres_required']) ? $adforest_theme['sb_default_ad_addres_required'] : true;
        
        $is_allowed_addres = isset($adforest_theme['sb_allow_address']) ? $adforest_theme['sb_allow_address'] : true;
       
       $user_address_html  =  "";
       if($is_allowed_addres ){
       if ($address_req) {
            $user_address_html = '<label class="control-label">' . __('Address', 'adforest') . ' <span class="required">*</span></label><input  name="sb_user_address" style="width: 0; height: 0; border: 0; padding: 0" /><input class="form-control" value="' . $ad_location . '" type="text" name="sb_user_address" id="sb_user_address" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '" placeholder="' . __('Enter a location', 'adforest') . '" onkeydown="return (event.keyCode != 13);">';
        } else {
            $user_address_html = '<label class="control-label">' . __('Address', 'adforest') . '</label><input  name="sb_user_address"  style="width: 0; height: 0; border: 0; padding: 0" /><input class="form-control" value="' . $ad_location . '" type="text" name="sb_user_address" id="sb_user_address" data-parsley-required="false" data-parsley-error-message="' . __('This field is required.', 'adforest') . '" placeholder="' . __('Enter a location', 'adforest') . '" onkeydown="return (event.keyCode != 13);">';
        }
       }
        $user_email_html = "";
        if ($poster_email == "") {
            $user_email_html = ' <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">  <label class="control-label">' . __('Email Address', 'adforest') . ' <span class="required">*</span></label><input class="form-control" data-parsley-type="email" type="email" name="sb_user_email" id="sb_user_email" data-parsley-required="true" data-parsley-error-message="' . __('This a valid email address.', 'adforest') . '" placeholder="' . __('Enter email', 'adforest') . '"></div></div>';
        }
        $cat_search_bar = "";
        if ($adpost_cat_style == "grid") {

            $cat_search_bar = '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group cat-searach-group">
                                                <span class="fa fa-search form-control-feedback search-cat-submit"></span>
                                                <input type="text" class="form-control search-cat-input" placeholder="' . esc_html__('Categories Search ...', 'adforest') . '">
                                            </div>
                                        </div>';
        }

        $video_logo_url = get_template_directory_uri() . '/images/video-logo.jpg';
        $busniess_hours = apply_filters('sb_get_business_hous_post', $is_update);
        if ($busniess_hours == $is_update) {
            $busniess_hours = "";
        }

           echo'
                <section class="choose-category-part">
                  <div class="container">
                    <form class="submit-form" id="ad_post_form" novalidate="">  
                     <div class="row">
                       <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 "></div>     
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12  step-0 ">
                          <div class="bs-example">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header main-header">
                                        <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="chose-catgory-heading">
                                                <h2>' . esc_html__('Basic information', 'adforest') . '</h2>
                                            <p>' . esc_html__('Select Suitable  Category for your ad', 'adforest') . '</p>
                                            </div>
                                        </div>  
                                        ' . $cat_search_bar . '
                                    </div>
                                </div>
                                ' . $cat_list . '
                                <div class ="">                               
                                ' . $categories_style_html . '                                   
                                 </div>
                                <div class="card-header main-header">                               
                                    <div class="btn-group navbar-btn sw-btn-group pull-right" role="group">
                                        <button class="btn btn-theme sw-btn-next" type="button">' . esc_html__('Next', 'adforest') . '</button>
                                    </div>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 step-1 no-display-custom">
                    <div class="accordion post-ad-container" >
                        <div class="card">                                    
                            <div class="card-header main-header">                         
                                <div class="row">                               
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="chose-catgory-heading">
                                            <h2>' . esc_html__('Basic information', 'adforest') . '</h2>
                                            <p>' . esc_html__('Select Suitable  Category for your ad', 'adforest') . '</p>
                                        </div>
                                    </div> 
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group cat-search-input">                                       
                                            <div role="alert" class="alert alert-info alert-dismissible alert-danger ad_errors">
                                                <i class="fa fa-info-circle"></i>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>                                           
                                                ' . esc_html__('Please fill all required (*) fields.', 'adforest') . '
                                            </div>
                                        </div>
                                        ' . $update_notice . '
                                    </div>

                                </div>
                            </div>
                           <div class="card-header sub-header sb-selected-cats-header2 ' . $cat_style . '">
                               <ul class="item-sub-information sb-selected-cats2">' . $selected_cats_list . '</ul>
                                   <a class="switch-cat-sec" id="change-cat"  href="javascript:void(0)">' . esc_html__('Change', 'adforest') . '</a>
                          </div>
                            <div class="basic-information-heading">

                                ' . $someStaticHTML . '
                                <div class="form-group ad_title_group">
                                    <label class="control-label">' . __('Title', 'adforest') . ' <span class="required">*</span></label>
                                    <input maxlength="' . $ad_post_title_limit . '" data-parsley-maxlength="' . $ad_post_title_limit . '" class="form-control" placeholder="' . __('Enter title  character limit', 'adforest') . ' (' . $ad_post_title_limit . '). " type="text" name="ad_title" id="ad_title" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '" value="' . $title . '" autocomplete="off">
                                </div>
                                ' . $ad_type_html . '
                                <div class="form-group">
                                    <div class="ad-descriptions">
                                        <label class="control-label">' . __('Ad Description', 'adforest') . ' <small>' . __('Enter long description.', 'adforest') . '</small></label>
                                        <textarea rows="12" class="form-control" name="ad_description" id="ad_description">' . $description . '</textarea>
                                    </div>
                                </div>
                                ' . $customDynamicFields . '
                                ' . $someStaticHtml2 . '
                                ' . $tags_html . '
                                ' . $imageStaticHTML . '     
                                    ' . $videoStaticHTML . '
                            </div>            

                            ' . $bidable . '
                                
                            ' . $busniess_hours . '
                            <div class="card-header sub-header" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false">
                                <h2 class="mb1-1">
                                    <button type="button" class="btn btn-link">
                                        <i class="fa fa-angle-right"></i>' . esc_html__('User information', 'adforest') . '</button>									
                                </h2>
                            </div>
                            <div id="collapseUser" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="sub-item ad-user-information">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">' . __('Your Name', 'adforest') . ' <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="sb_user_name" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '" value="' . $poster_name . '">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">' . __('Mobile Number', 'adforest') . $ph_reg . '</label>
                                                ' . $phone_html . '
                                            </div>
                                        </div>
                                        ' . $user_email_html . '
                                       
                                           
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group country-heading">
                                            ' . $custom_locations_html . '
                                        </div>
                                    </div>
                                     <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group country-heading">                                            
                                               ' . $user_address_html . '
                                                   
                                             <ul id="google-map-btn" class="ad-post-map">' . $libutton . '</ul>
                                            </div>
                                        </div> 
                                    ' . $lat_long_html . '          
                                    ' . $lat_lon_script . '

                                </div>
                            </div>                          
                            ' . $extra_fields_html . '                            
                            ' . $simple_feature_html . '
                            ' . $bump_ad_html . '
                            
                         </div>

                            <div class="term-condition adforest-ad-post-terms"><div class="row">
                                    ' . $tems_cond_field . ' 
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="submit-button">
                                            <input type="submit" href="javascript:void(0)" class="btn btn-theme btn-submit" value = "' . esc_html__('Submit', 'adforest') . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <input type="hidden" id="sb_form_is_custom" name="sb_form_is_custom" value="' . $isCustom . '" />

                </div>  
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12"></div>
            </div>     

        </form>
    </div>
    <!-- Main Container End -->
    <input type="hidden" id="dictDefaultMessage" value="' . __('Drop files here or click to upload.', 'adforest') . '" />
    <input type="hidden" id="dictFallbackMessage" value="' . __('Your browser does not support drag\'n\'drop file uploads.', 'adforest') . '" />
    <input type="hidden" id="dictFallbackText" value="' . __('Please use the fallback form below to upload your files like in the olden days.', 'adforest') . '" />
    <input type="hidden" id="dictFileTooBig" value="' . __('File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.', 'adforest') . '" />
    <input type="hidden" id="dictInvalidFileType" value="' . __('You can\'t upload files of this type.', 'adforest') . '" />
    <input type="hidden" id="dictResponseError" value="' . __('Server responded with {{statusCode}} code.', 'adforest') . '" />
    <input type="hidden" id="dictCancelUpload" value="' . __('Cancel upload', 'adforest') . '" />
    <input type="hidden" id="dictCancelUploadConfirmation" value="' . __('Are you sure you want to cancel this upload?', 'adforest') . '" />
    <input type="hidden" id="dictRemoveFile" value="' . __('Remove file', 'adforest') . '" />
    <input type="hidden" id="dictMaxFilesExceeded" value="' . __('You can not upload any more files.', 'adforest') . '" />
    <input type="hidden" id="sb-post-token" value="' . wp_create_nonce('sb_post_secure') . '" />
    <input type="hidden" id="is_update" name="is_update" value="' . $is_update . '" />
    <input type="hidden" id="bid_ad_id" name="bid_ad_id" value="' . $bid_ad_id . '" />        
    <input type="hidden" id="is_level" name="is_level" value="' . $level . '" />
    <input type="hidden" id="country_level" name="country_level" value="' . $levelz . '" />
    <input type="hidden" id="adforest_ad_html" value="' . adforest_returnEcho($adforest_ad_html) . '" />
    <input type="hidden" id="is_sub_active" value="1" />
    <input type="hidden" id="sb_upload_limit" value="' . esc_attr($user_upload_max_images) . '" />
    <input type="hidden" id="ad_posted" value="' . __('Ad Posted successfully.', 'adforest') . '" />
    <input type="hidden" id="ad_updated" value="' . __('Ad updated successfully.', 'adforest') . '" />
    <input type="hidden" id="ad_limit_msg" value="' . __('Your package has been used or expired, please purchase now.', 'adforest') . '" />
         <input type="hidden" id="select_cat_first"  value="' . esc_html__('Please Select Category first', 'adforest') . '" />
    <input type="hidden" id="sb_packages_page" value="' . get_the_permalink($sb_packages_page) . '" />
        <input type="hidden" id="sb_upload_video_limit" value="' . $max_upload_vid_limit_opt . '" />
            <input type="hidden" id="video_logo_url" value="' . $video_logo_url . '" />
                

</section>' . apply_filters("adforest_adpost_categories_modal", "") . '';
    }

}
if (function_exists('adforest_add_code')) {
    adforest_add_code('ad_post_short_base', 'ad_post_short_base_func');
}