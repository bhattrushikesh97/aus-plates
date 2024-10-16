<?php 
$rating    =    isset($_GET['rating'])   ?   $_GET['rating']    :  1;
wp_enqueue_style('star-rating', trailingslashit(get_template_directory_uri()) . 'assests/css/star-rating.css');
?>
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingEight">
    <h4 class="ad-widget-title"><a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseRating" aria-expanded="true" aria-controls="collapseRating"><i class="more-less fa fa-plus"></i>
            <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?></a></h4>
</div>
    <?php
   if (isset($instance['open_widget']) && $instance['open_widget'] == '1') { $expand = 'show';}
    global $wp;
    
    ?>

    <form method="get" action="<?php echo get_the_permalink()?>" id="user_search_rating">
        <div id="collapseRating" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel" aria-labelledby="headingRating">
            <div class="panel-body">
                <div class="user_ratting_input">
                    <input id="input-21b" name="rating" value="<?php echo esc_html($rating) ?>" type="text"  data-show-clear="false" <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>class="rating  sb_rating_input" data-min="0" data-max="5" data-step="1" data-size="xs"  title="required">
                </div>
            </div>
        </div>
        <?php
        echo adforest_search_params('rating');
        ?>
    </form>
</div>





  