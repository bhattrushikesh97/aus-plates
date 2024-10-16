<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingEight">
    <h4 class="ad-widget-title"><a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight"><i class="more-less fa fa-plus"></i>
            <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?></a></h4>
</div>
    <?php
   if (isset($instance['open_widget']) && $instance['open_widget'] == '1') { $expand = 'show';}
    global $wp;
    
    ?>
    <form method="get" action="<?php echo get_the_permalink()?>" >
        <div id="collapseEight" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel" aria-labelledby="headingFive">
            <div class="panel-body">
                <div class="search-widget">
                    <input placeholder="<?php echo __('search', 'adforest'); ?>" type="text" name="user_title" value="<?php echo esc_attr($title); ?>" autocomplete="off"><button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('user_title');
        ?>
    </form>
</div>