<?php if (isset($instance['open_widget']) && $instance['open_widget'] == '1') { 
    $expand = 'show'; 
    $toggle = "";
 }?>
 <div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingEight">
    <h4 class="ad-widget-title"><a class="<?php echo esc_attr($toggle); ?>" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight"><i class="more-less fa fa-plus"></i>
            <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])); ?></a></h4>
</div>
<?php

global $wp;
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
$sb_search_page = apply_filters('adforest_category_widget_form_action',$sb_search_page);
?>
<form method="get" action="<?php echo adforest_returnEcho($sb_search_page);?>" >
    <div id="collapseEight" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel" aria-labelledby="headingEight">
        <div class="panel-body">
            <div class="skin-minimal">
                <ul class="list"><?php
                    $conditions = adforest_get_cats('ad_warranty', 0);
                    foreach ($conditions as $con) { ?>
                        <li><input tabindex="7" type="radio" id="minimal-radio-<?php echo esc_attr($con->term_id); ?>" name="warranty" value="<?php echo esc_attr($con->name); ?>" <?php if ($cur_war == $con->name) {echo esc_attr("checked"); } ?>  > <label for="minimal-radio-<?php echo esc_attr($con->term_id); ?>" ><?php echo esc_html($con->name); ?></label></li>
                        <?php  } ?></ul>
            </div>
        </div>
    </div>
<?php echo adforest_search_params('warranty'); ?>
</form>
</div>