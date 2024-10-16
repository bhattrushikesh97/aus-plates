<?php
/**
 * Site Info widget.
 */
if (!class_exists('Adforest_Site_Info_Widget')) {
    class Adforest_Site_Info_Widget extends WP_Widget {
        /**
         * Register widget with WordPress.
         */
        public function __construct() {
            parent::__construct(
                    'adforest_site_info', // Base ID.
                    __('SB : Site Info', 'adforest'), // Name.
                    array('classname' => 'widget_site_info', 'description' => __('Site Info widget for site information.', 'adforest'))
            );
        }
        public function form($instance) {
            $siteinfo_title = isset($instance['siteinfo_title']) ? esc_attr($instance['siteinfo_title']) : '';
            $siteinfo_desc = isset($instance['siteinfo_desc']) ? esc_attr($instance['siteinfo_desc']) : '';
            $siteinfo_google_app_url = isset($instance['siteinfo_google_app_url']) ? esc_attr($instance['siteinfo_google_app_url']) : '';
            $siteinfo_apple_app_url = isset($instance['siteinfo_apple_app_url']) ? esc_attr($instance['siteinfo_apple_app_url']) : '';
            $image_uri = isset($instance['image_uri']) ? ($instance['image_uri']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('siteinfo_title')); ?>"><?php echo esc_html_e('Title', 'adforest'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('siteinfo_title')); ?>" name="<?php echo esc_attr($this->get_field_name('siteinfo_title')); ?>" type="text" value="<?php echo esc_attr($siteinfo_title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('image_uri')); ?>">Image</label>
                <img class="<?php echo esc_attr($this->id); ?>_img" src="<?php echo esc_url($image_uri); ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
                <input type="text" class="widefat <?php echo esc_attr($this->id); ?>_url" name="<?php echo esc_attr($this->get_field_name('image_uri')); ?>" value="<?php echo esc_url($image_uri); ?>" style="margin-top:5px;" />
                <input type="button" id="<?php echo esc_attr($this->id); ?>" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('siteinfo_desc')); ?>" >
                    <?php echo esc_html__('Description', 'adforest'); ?>
                </label> 
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('siteinfo_desc')); ?>" name="<?php echo esc_attr($this->get_field_name('siteinfo_desc')); ?>"><?php echo esc_attr($siteinfo_desc); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('siteinfo_google_app_url')); ?>"><?php echo esc_html_e('Google App Url', 'adforest'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('siteinfo_google_app_url')); ?>" name="<?php echo esc_attr($this->get_field_name('siteinfo_google_app_url')); ?>" type="text" value="<?php echo esc_attr($siteinfo_google_app_url); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('siteinfo_apple_app_url')); ?>"><?php echo esc_html_e('Apple App Url', 'adforest'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('siteinfo_apple_app_url')); ?>" name="<?php echo esc_attr($this->get_field_name('siteinfo_apple_app_url')); ?>" type="text" value="<?php echo esc_attr($siteinfo_apple_app_url); ?>">
            </p>
            <?php
        }
        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['siteinfo_title'] = $new_instance['siteinfo_title'];
            $instance['siteinfo_desc'] = $new_instance['siteinfo_desc'];
            $instance['siteinfo_google_app_url'] = $new_instance['siteinfo_google_app_url'];
            $instance['siteinfo_apple_app_url'] = $new_instance['siteinfo_apple_app_url'];
            $instance['image_uri'] = strip_tags($new_instance['image_uri']);
            return $instance;
        }

        public function widget($args, $instance) {

            $title = empty($instance['siteinfo_title']) ? '' : apply_filters('widget_title', $instance['siteinfo_title']);
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            $siteinfo_desc = isset($instance['siteinfo_desc']) ? $instance['siteinfo_desc'] : '';
            $google_app_url = isset($instance['siteinfo_google_app_url']) ? $instance['siteinfo_google_app_url'] : '';
            $apple_app_url = isset($instance['siteinfo_apple_app_url']) ? $instance['siteinfo_apple_app_url'] : '';
            $image_uri = isset($instance['image_uri']) ? $instance['image_uri'] : '';

            echo adforest_returnEcho($before_widget);
            if ('' !== $title) {
                echo adforest_returnEcho($before_title) . esc_html($title) . ( $after_title );
            }
            ?>
            <div class="widget">
                <?php if (isset($image_uri) && !empty($image_uri)) { ?>
                    <div class="logo">
                        <a href="<?php echo esc_url(site_url()); ?>"><img src="<?php echo esc_url($image_uri); ?>" class="img-fluid" alt="<?php echo esc_html__('Site Logo', 'adforest') ?>"></a>
                    </div>
                <?php } if (isset($siteinfo_desc) && !empty($siteinfo_desc)) { ?>
                    <p><?php echo esc_html($siteinfo_desc); ?></p>
                <?php } ?>
                <?php if (isset($google_app_url) && !empty($google_app_url) || isset($apple_app_url) && !empty($apple_app_url)) { ?>
                    <ul><?php if (isset($google_app_url) && !empty($google_app_url)) { ?>
                            <li><a href="<?php echo esc_url($google_app_url); ?>"><img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/googleplay.png'; ?>" alt="Android App"></a></li>
                        <?php }if (isset($apple_app_url) && !empty($apple_app_url)) { ?>
                            <li><a href="<?php echo esc_url($apple_app_url); ?>"><img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/appstore.png'; ?>" alt="IOS App"></a></li>
                        <?php } ?></ul>
                <?php } ?>
            </div>
            <?php
            echo adforest_returnEcho($after_widget);
        }

    }

}
/* * * Site Info widget End. */
/** Social Links widget. */
if (!class_exists('Adforest_Social_links')) {

    class Adforest_Social_links extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        public function __construct() {
            parent::__construct(
                    'adforest_social_links', // Base ID.
                    __('SB : Social Links', 'adforest'), // Name.
                    array('classname' => 'socail-icons', 'description' => __('Social Links widget for social information.', 'adforest'))
            );
        }

        public function form($instance) {

            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html_e('Title', 'adforest'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>

            <?php
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];

            return $instance;
        }

        public function widget($args, $instance) {
            global $adforest_theme;
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $before_widget = isset($args['before_widget']) ? $args['before_widget'] : '';
            $after_widget = isset($args['after_widget']) ? $args['after_widget'] : '';
            $before_title = isset($args['before_title']) ? $args['before_title'] : '';
            $after_title = isset($args['after_title']) ? $args['after_title'] : '';

            echo adforest_returnEcho($before_widget);
            if ('' !== $title) {
                echo adforest_returnEcho($before_title) . esc_html($title) . ( $after_title );
            }
            ?>
            <ul>
                <?php
                foreach ($adforest_theme['social_media'] as $index => $val) {
                    ?>
                    <?php
                    if ($val != "") {
                        ?>
                        <li>
                            <a  <?php do_action('adforest_relation_follow_links');?>  class="<?php echo esc_attr($index); ?>" href="<?php echo esc_url($val); ?>">
                                <i class="<?php echo adforest_social_icons($index); ?>"></i>
                            </a>
                            <span><?php echo esc_html($index); ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <?php
            echo adforest_returnEcho($after_widget);
        }

    }

}
/* Social Links widget End. */
/* Most Visited Ads Widget */
if (!class_exists('adforest_visited_ads')) {

    class adforest_visited_ads extends WP_Widget {

        use adforest_reuse_functions;

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            $widget_ops = array(
                'classname' => 'adforest_visited_ads',
                'description' => __('Only for search and single ad sidebar.', 'adforest'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Most Visited Ads', 'adforest'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            $max_ads = $instance['max_ads'];
            global $adforest_theme;

            if (!is_singular('ad_post') && isset($adforest_theme['search_design'])) {
                if (is_page_template('page-search.php') && $adforest_theme['search_design'] == 'topbar') {
                    return;
                }
            }
            ?>

            <div class="feature-ads panel panel-default">
                <div class="panel-heading feature-ads-heading">
                    <h4 class=""><?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?></h4>
                </div>
                <div class="feature-ads-carousel">

                    <?php
                    $f_args = array(
                        'post_type' => 'ad_post',
                        'post_status' => 'publish',
                        'posts_per_page' => $max_ads,
                        'meta_key' => 'sb_post_views_count',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                    );
                    $f_args = apply_filters('adforest_wpml_show_all_posts', $f_args);
                    $f_args = apply_filters('adforest_site_location_ads', $f_args, 'ads');
                    $f_ads = new WP_Query($f_args);

                    $ribbion = 'featured-ribbon';
                    if (is_rtl()) {
                        $flip_it = 'flip';
                        $ribbion = 'featured-ribbon-rtl';
                    }
                    if ($f_ads->have_posts()) {
                        $number = 0;
                        while ($f_ads->have_posts()) {
                            $f_ads->the_post();
                            $pid = get_the_ID();
                            $author_id = get_post_field('post_author', $pid);
                            $author = get_user_by('ID', $author_id);
                            $img = adforest_get_ad_default_image_url('adforest-ad-related');
                            $media = adforest_get_ad_images($pid);
                            $total_imgs = count($media);
                            $full_image[0] = "";
                            if (count($media) > 0) {
                                foreach ($media as $m) {
                                    $mid = '';
                                    if (isset($m->ID))
                                        $mid = $m->ID;
                                    else
                                        $mid = $m;
                                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                                    $full_image = wp_get_attachment_image_src($mid, 'full');
                                    $full_image[0] = isset($full_image[0]) ? $full_image[0] : "";
                                    $img = isset($image[0])  ? $image[0] : "";
                                    break;
                                }
                            }
                            $timer_html = '';

                            $bid_end_date = get_post_meta($pid, '_adforest_ad_bidding_date', true);
                            if ($bid_end_date != "" && date('Y-m-d H:i:s') < $bid_end_date) {
                                $timer_html .= '<div class="listing-bidding" id="countdown">' . adforest_timer_html($bid_end_date, false) . '</div>';
                            }
                            $is_feature = '';
                            if (get_post_meta($pid, '_adforest_is_feature', true) == '1') {
                                $is_feature = '<div class="found-featured   featured-ribbon  ' . esc_attr($ribbion) . '">' . __('Featured', 'adforest') . '
                                                 <div class="fold"></div></div>';
                            }
                            $is_fav = 'ad_to_fav';
                            if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                                $is_fav = 'ad_to_fav ad-favourited';
                            }
                            ?>
                            <div class="feature-detail">
                                <div class="feaure-ads-img">
                                   <a href="<?php echo esc_url(get_the_permalink($pid)); ?>">  <img class="img-fluid" alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url($img); ?>"></a>
                                    <div class="overlay-feature">
                                        <ul class="overlay-feature-icon">
                                            <li><a href="<?php echo esc_url($full_image[0]) ?>"><i class="fa fa-search"></i></a></li>
                                            <li> <a href="javascript:void(0)" data-adid="<?php echo get_the_ID() ?>" class="<?php echo esc_attr($is_fav) ?>"> <i class="fa fa-heart"></i></a>  </li>

                                        </ul>
                                    </div>
                                    <?php echo adforest_returnEcho($is_feature); ?>
                                    <?php echo adforest_returnEcho($timer_html); ?>                               
                                </div>
                                <div class="feature-detail-heading">
                                    <div class="category-title">
                                        <?php echo adforest_display_cats(get_the_ID()); ?>
                                    </div>
                                    <h4><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <h5><?php echo(adforest_adPrice(get_the_ID(), '', '')); ?></h5>
                                    <span><i class="fa fa-eye"></i><?php echo adforest_getPostViews(get_the_ID()) . " " . __('Views', 'adforest'); ?></span>
                                </div>
                            </div>                      
                            <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>

                </div>
            </div>


            <?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {

            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Most Visited Ads', 'adforest');
            }
            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
            }
            $this->adforect_widget_open($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"></p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" >
                    <?php echo esc_html__('Max # of Ads:', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" name="<?php echo esc_attr($this->get_field_name('max_ads')); ?>" type="text" value="<?php echo esc_attr($max_ads); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['max_ads'] = (!empty($new_instance['max_ads']) ) ? strip_tags($new_instance['max_ads']) : '';
            $instance['open_widget'] = (!empty($new_instance['open_widget']) ) ? strip_tags($new_instance['open_widget']) : '';
            return $instance;
        }

    }

    // Most Visited Ads
}






/* Social Links widget End. */
/* Most Visited Ads Widget */
if (!class_exists('adforest_ads_categories')) {

    class adforest_ads_categories extends WP_Widget {

        use adforest_reuse_functions;

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            $widget_ops = array(
                'classname' => 'adforest_ads_categories',
                'description' => __('ads categories for home page side bar', 'adforest'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Adforest ads categories list', 'adforest'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {

            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Our Categories', 'adforest');
            }

            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
            }
            if (isset($instance['order_by'])) {
                $order_by = $instance['order_by'];
            } else {
                $order_by = 'name';
            }
            if (isset($instance['order'])) {
                $order = $instance['order'];
            } else {
                $order = 'asc';
            }
            $defaults = array(
                'taxonomy' => 'ad_cats',
                'orderby' => $order_by,
                'order' => $order,
                //'hide_empty' => true,
                'exclude' => array(),
                'exclude_tree' => array(),
                'number' => $max_ads,
                'parent' => 0,
            );
            $defaults = apply_filters('adforest_wpml_show_all_posts', $defaults); // for all lang texonomies        
            $ad_cats = get_terms($defaults);
            ?>

            <div class="card categories">
                <div class="card-header main-categories"><?php echo esc_html($title) ?></div>
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($ad_cats as $ad_cat) {
                        $category = get_term($ad_cat->term_id);
                        $count = ($ad_cat->count);
                        $cat_meta = get_option("taxonomy_term_$ad_cat->term_id");
                        $icon = (isset($cat_meta['ad_cat_icon'])) ? $cat_meta['ad_cat_icon'] : '';
                        $cat_search_page = 'javascript:void(0);';
                        $cat_search_page = apply_filters('adforest_filter_taxonomy_popup_actions', $cat_search_page, $ad_cat->term_id, 'ad_cats');
                        $imgUrl = adforest_taxonomy_image_url($ad_cat->term_id, NULL, TRUE);
                        ?>                        
                        <li class="list-group-item">
                            <ul class="child-list-item">
                                <li><div class="furnit-item">
                                     <a href="<?php echo adforest_returnEcho($cat_search_page); ?>">  
                                      <img src="<?php echo esc_url($imgUrl) ?>" alt="category-img"></a>
                                    </div>
                                    <a href="<?php echo adforest_returnEcho($cat_search_page); ?>" data-cat-id="<?php echo esc_attr($ad_cat->term_id); ?>"><span class="span-furniture"><?php echo esc_html($ad_cat->name); ?></span></a>
                                <li><button class="btn-ads"><?php echo esc_html($count); ?></button></li>
                            </ul>
                        </li>

                    <?php } ?>                
                </ul>
            </div>



            <?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {

            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Most Visited Ads', 'adforest');
            }
            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
            }

            if (isset($instance['order_by'])) {
                $order_by = $instance['order_by'];
            } else {
                $order_by = 'name';
            }
            if (isset($instance['order'])) {
                $order = $instance['order'];
            } else {
                $order = 'asc';
            }
            $this->adforect_widget_open($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"></p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" >
                    <?php echo esc_html__('Max # of Categories', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" name="<?php echo esc_attr($this->get_field_name('max_ads')); ?>" type="text" value="<?php echo esc_attr($max_ads); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order_by')); ?>" >
                    <?php echo esc_html__('Order by:', 'adforest'); ?>
                </label> 
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_by')); ?>" name="<?php echo esc_attr($this->get_field_name('order_by')); ?>">

                    <option><?php echo esc_html__('Select Option', 'adforest') ?></option>
                    <option value="name"  <?php echo esc_html($order_by) == 'name' ? 'selected' : "" ?>><?php echo esc_html__('Name', 'adforest') ?></option>
                    <option value="count" <?php echo esc_html($order_by) == 'count' ? 'selected' : "" ?>><?php echo esc_html__('Count', 'adforest') ?></option>

                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>" >
                    <?php echo esc_html__('Order', 'adforest'); ?>
                </label> 
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
                    <option><?php echo esc_html__('Select Option', 'adforest') ?></option>
                    <option value="asc"  <?php echo esc_html($order) == 'asc' ? 'selected' : "" ?>><?php echo esc_html__('ASC', 'adforest') ?></option>
                    <option value="dsc" <?php echo esc_html($order) == 'dsc' ? 'selected' : "" ?>><?php echo esc_html__('DSC', 'adforest') ?></option>
                </select>
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['max_ads'] = (!empty($new_instance['max_ads']) ) ? strip_tags($new_instance['max_ads']) : '';
            $instance['order_by'] = (!empty($new_instance['order_by']) ) ? strip_tags($new_instance['order_by']) : '';
            $instance['order'] = (!empty($new_instance['order']) ) ? strip_tags($new_instance['order']) : '';
            $instance['open_widget'] = (!empty($new_instance['open_widget']) ) ? strip_tags($new_instance['open_widget']) : '';
            return $instance;
        }

    }

    // Most Visited Ads
}



if (!class_exists('adforest_recent_ads2')) {

    class adforest_recent_ads2 extends WP_Widget {

        use adforest_reuse_functions;

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            $widget_ops = array(
                'classname' => 'adforest_recent_ads2',
                'description' => __('For home page sidebar.', 'adforest'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Ads Recent 2', 'adforest'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            $max_ads = $instance['max_ads'];
            global $adforest_theme;
              if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Recent Ads', 'adforest');
            }
            ?>
            <div class="recent-prodcut">
                <div class="recent-prodcut-heading">
                    <h2><?php echo esc_html($title);?></h2>
                </div>

                <div class="ads-recent-content">
                    <?php
                    $f_args = array(
                        'post_type' => 'ad_post',
                        'posts_per_page' => $max_ads,
                        'meta_query' => array(
                            array('key' => '_adforest_ad_status_', 'value' => 'active', 'compare' => '=',),),
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );
                    $f_args = apply_filters('adforest_wpml_show_all_posts', $f_args);
                    $f_args = apply_filters('adforest_site_location_ads', $f_args, 'ads');
                    $f_ads = new WP_Query($f_args);

                    $ribbion = 'featured-ribbon';
                    if (is_rtl()) {
                        $flip_it = 'flip';
                        $ribbion = 'featured-ribbon-rtl';
                    }
                    if ($f_ads->have_posts()) {
                        $number = 0;
                        while ($f_ads->have_posts()) {
                            $f_ads->the_post();
                            if (get_post_status() != "pending") {

                                $pid = get_the_ID();
                                $author_id = get_post_field('post_author', $pid);
                                $author = get_user_by('ID', $author_id);

                                $img = adforest_get_ad_default_image_url('adforest-ad-related');
                                $media = adforest_get_ad_images($pid);
                                $is_fav = '';
                                if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $pid, true) == $pid) {
                                    $is_fav = 'ad-favourited';
                                }
                                $total_imgs = count($media);
                                $is_feature = '';
                                if (get_post_meta($pid, '_adforest_is_feature', true) == '1') {
                                    $is_feature = '<div class="found-featured   featured-ribbon  ' . esc_attr($ribbion) . '">' . __('Featured', 'adforest') . '
                                                 <div class="fold"></div></div>';
                                }
                                $full_image[0] = "";
                                if (count($media) > 0) {
                                    foreach ($media as $m) {
                                        $mid = '';
                                        if (isset($m->ID))
                                            $mid = $m->ID;
                                        else
                                            $mid = $m;

                                        $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                                        $img = isset($image[0]) && $image[0] != "" ? $image[0] : adforest_get_ad_default_image_url();

                                        $full_image = wp_get_attachment_image_src($mid, 'full');
                                        $full_image[0] = isset($full_image[0]) ? $full_image[0] : "";
                                        break;
                                    }
                                }
                                ?>
                                <div class="recent-section-content">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="img-recent-1">
                                                <a href="<?php echo get_the_permalink($pid);?>">   <img class="img-fluid" alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url($img); ?>"></a>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="recent-ads-list-content">
                                                <div class="recent-ads-list-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo adforest_words_count(get_the_title(), 25); ?> </a></div>
                                                <ul class="recent-ads-list-location"><li><?php echo adforest_words_count(get_post_meta(get_the_ID(), '_adforest_ad_location', true), 30); ?></li></ul>
                                                <div class="recent-ads-list-price"><?php echo(adforest_adPrice(get_the_ID(), '', '')); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
        }
        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Recent Ads', 'adforest');
            }
            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
            }
            $this->adforect_widget_open($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" >
                    <?php echo esc_html__('Max # of Ads:', 'adforest'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads')); ?>" name="<?php echo esc_attr($this->get_field_name('max_ads')); ?>" type="text" value="<?php echo esc_attr($max_ads); ?>">
            </p>
            <?php
        }
        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['max_ads'] = (!empty($new_instance['max_ads']) ) ? strip_tags($new_instance['max_ads']) : '';
            $instance['open_widget'] = (!empty($new_instance['open_widget']) ) ? strip_tags($new_instance['open_widget']) : '';
            return $instance;
        }
    }
}
add_action('widgets_init', function () {
    if (function_exists('adforest_register_custom_widgets')) {
        adforest_register_custom_widgets('Adforest_Site_Info_Widget');
        adforest_register_custom_widgets('Adforest_Social_links');
        adforest_register_custom_widgets('adforest_visited_ads');
        adforest_register_custom_widgets('adforest_recent_ads2');
        adforest_register_custom_widgets('adforest_ads_categories');
    }
});
