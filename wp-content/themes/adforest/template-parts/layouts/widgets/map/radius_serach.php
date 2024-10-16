<?php if (isset($instance['open_widget']) && $instance['open_widget'] == '1') { 
    $expand = 'show'; 
    $toggle = "";
    
 }
 
 $default_radius = isset($instance['default_value'])  ?    $instance['default_value']  : "";

 $read_only  = "";
 $read_only = isset($instance['edit_able'])  ?    $instance['edit_able']  : "yes";
 if($read_only == "no" && $default_radius != ""){
    $read_only =  ' readonly="true"';
   
 }

 $show_hide = isset($instance['show_hide'])  ?    $instance['show_hide']  : "";
 $dispalyStyle = '';
 $btn_search = '<button  type="submit" id="btn-submit"><i class="fa fa-search"></i></button>';
 $btn_other = '<button type="button" id="you_current_location_text" data-place="text_field"><i class="fa fa-crosshairs"></i></button>';

 if($show_hide == 'hide')
 {
    $dispalyStyle = 'hideSearchInput';
 }
 else
 {
    $dispalyStyle = '';
    $btn_search1 = '<button  type="submit" id="btn-submit"><i class="fa fa-search"></i></button>';
    $btn_search ='';
 }
 
 
 ?>

 

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwemty">
        <h4 class="ad-widget-title">
            <a class="<?php echo esc_attr($toggle) ?>" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseTwenty" aria-expanded="true" aria-controls="collapseTwenty">
                <i class="more-less fa fa-plus"></i>
                <?php echo esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']));?>
                <?php echo esc_html($default_value = empty($instance['default_value']))?>
            </a>
        </h4>
    </div>
    <?php

    $radius = '';
    $area = isset($_GET['location']) && $_GET['location'] != '' ? $_GET['location'] : '';
    
    if (isset($_GET['location']) && $_GET['location'] != "" && isset($_GET['rd']) && $_GET['rd'] != "") {
        $radius = $_GET['rd'];
        $area = $_GET['location'];
    }
    else {
        $radius = $default_radius;
    }
    $radius_placeholder = __('Radius in km', 'adforest');
    $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';
    if ($search_radius_type == 'mile') {
        $radius_placeholder = __('Radius in Miles', 'adforest');
    }
    ?>
    <form id="sb-radius-form" class="for-radius">
        <div id="collapseTwenty" class="panel-collapse collapse <?php echo esc_attr($expand);?>" role="tabpanel" aria-labelledby="headingTwemty">
            <div class="panel-body">

                <div class="search-widget">
                    <?php
                    $mapType = adforest_mapType();
                    $attr_leaflet = "";
                    $placeHolder = __('Type Location...', 'adforest');
                    if ($mapType == 'leafletjs_map') {
                        $map_lat = (isset($_GET['lat']) && $_GET['lat']) ? $_GET['lat'] : '';
                        $map_long = (isset($_GET['long']) && $_GET['long']) ? $_GET['long'] : '';
                        echo '<input type="hidden" name="lat" id="sb_user_address_lat" value="' . esc_attr($map_lat) . '"><input type="hidden" name="long" id="sb_user_address_long" value="' . esc_attr($map_long) . '">';

                        $attr_leaflet = ' readonly="readonly"';
                        $placeHolder = __('Get Location...', 'adforest');
                    }
                    ?>                         
                    <input name="location" id="sb_user_address" placeholder="<?php echo adforest_returnEcho($placeHolder);?>" type="text" data-parsley-required="true" data-parsley-error-message="" value="<?php echo esc_attr($area);?>" <?php echo adforest_returnEcho($attr_leaflet);?>>
                 
                   <div><?php  echo $btn_search; echo $btn_other; ?></div> 

                </div>
                <div class="search-widget">
                    <input name="rd" class="<?php echo $dispalyStyle ?>" id="map_radius"  value="<?php echo esc_attr($radius);?>" placeholder="<?php echo adforest_returnEcho($radius_placeholder); ?>" type="number" data-parsley-required="true" data-parsley-error-message="" <?php echo $read_only; ?>>
                    <?php echo $btn_search1;?>
                </div>
            </div>
        </div>   
        <?php echo adforest_search_params('location', 'rd','country_id');?>
    </form>
    <?php adforest_load_search_countries();?>
</div>