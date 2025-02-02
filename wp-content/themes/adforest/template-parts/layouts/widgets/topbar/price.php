<?php
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
    <form method="get" action="<?php echo get_the_permalink($sb_search_page); ?>">
        <div class="form-group">
            <label><?php
                $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                echo esc_html($title);
                ?>
            </label>
            <span id="price-min"></span>
            - 
            <span id="price-max"></span>
            </span>
            <div id="price-slider" class="noui-rang"></div>



            <div class="input-group margin-top-10 width-100-per">
                <?php
                $conditions = adforest_get_cats('ad_currency', 0);
                $full_width = (isset($conditions) && count($conditions) > 0 ) ? '' : 'width-100-per';
                ?>
                <input type="text" class="form-control mini-calus price_slider_padding <?php echo adforest_returnEcho($full_width); ?>" size="10" name="min_price" id="min_selected" value="<?php echo esc_attr($min_price); ?>" />
                <span class="input-group-addon">-</span>
                <input type="text" class="form-control maxi-calus price_slider_padding <?php echo adforest_returnEcho($full_width); ?>" size="10" name="max_price" id="max_selected" value="<?php echo esc_attr($max_price); ?>" />
                <?php if (is_array($conditions) && count($conditions) > 0) { ?>

                    <span class="input-group-addon min-max-aline">
                        <select class="remove_select2 custom-select" name="c" >
                            <option value=""><?php echo __('currency', 'adforest'); ?></option>
                            <option value=""><?php echo __('all', 'adforest'); ?></option>
                            <?php

                            
                            if(is_array($conditions ) && !empty($conditions))
                            foreach ($conditions as $con) {
                                ?>
                                <option value="<?php echo esc_attr($con->name); ?>" <?php
                                if ($currency == $con->name) {
                                    echo esc_attr("selected");
                                }
                                ?>>
                                            <?php echo esc_html($con->name); ?>
                                </option>
                                <?php
                            }


                            ?>

                        </select>
                    </span>
                <?php } 
                      else {
                        ?>
                          <span class="input-group-addon min-max-aline">
                                <select class="remove_select2 custom-select" name="c" >
                                 <option value="<?php $adforest_theme['sb_currency']; ?>"> <?php  echo $adforest_theme['sb_currency']  ?> </option>
                                </select>
                          </span>

                   <?php 
                      }

                ?>
                <span class="input-group-addon fa_cursor  addon-searching"><i class="fa fa-search"></i></span>
                <input type="hidden" id="min_price" value="<?php echo esc_attr($instance['min_price']); ?>" />
                <input type="hidden" id="max_price" value="<?php echo esc_attr($instance['max_price']); ?>" />




            </div>
        </div>
        <?php echo adforest_search_params('min_price', 'max_price', 'c'); ?>
    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container(); ?>