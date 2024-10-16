<?php $sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']); ?>
<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
    <form method="get" action="<?php echo get_the_permalink($sb_search_page); ?>">
        <div class="form-group">
            <label><?php $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);  
                echo esc_html($title); 
                $perm_name = (is_home() || is_front_page()) ? 'ad_currency' : 'ad_currency';
            ?> </label>
            <select class="category form-control submit_on_select" name="<?php echo esc_attr($perm_name);?>" data-placeholder="<?php echo __('Select Option', 'adforest') ?>">
                <option label=""></option>
                <?php
                
                $conditions = adforest_get_cats('ad_currency', 0);
                foreach ($conditions as $con) { ?>
                    <option value="<?php echo esc_attr($con->term_id); ?>" <?php if ($cur_type == $con->term_id) { echo esc_attr("selected"); } ?>>
                    <?php echo esc_html($con->name); ?>
                    </option>
                    <?php } ?>
            </select>
        </div>
        <?php echo adforest_search_params($perm_name); ?>
    </form>
    <?php adforest_widget_counter(); ?>
</div>
<?php adforest_advance_search_container(); ?>