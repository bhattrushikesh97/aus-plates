<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
    <?php
    $radius = '';
    $area = isset($_GET['location']) && $_GET['location'] != '' ? $_GET['location'] : '';
    if (isset($_GET['location']) && $_GET['location'] != "" && isset($_GET['rd']) && $_GET['rd'] != "") {
        $radius = $_GET['rd'];
        $area = $_GET['location'];
    }
    $radius_placeholder = __('Radius in km', 'adforest');
    $search_radius_type = isset($adforest_theme['search_radius_type']) ? $adforest_theme['search_radius_type'] : 'km';
    if ($search_radius_type == 'mile') {
        $radius_placeholder = __('Radius in Miles', 'adforest');
    }
    ?>
    <form id="sb-radius-form" class="for-radius">
        <div class="form-group">
            <label><?php echo esc_html($instance['title']);?></label>

            <div class="with-top-bar clearfix row">
                
                <div class="col-md-9 no-padding">
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
                    <input name="location" class="form-control" id="sb_user_address" placeholder="<?php echo adforest_returnEcho($placeHolder);?>" type="text" data-parsley-required="true" data-parsley-error-message="" value="<?php echo esc_attr($area);?>" <?php echo adforest_returnEcho($attr_leaflet);?>>


                    <i id="you_current_location_text" class="fa fa-bullseye"></i>
                </div>
                <div class="col-md-3  no-padding radius_field">
                    <input name="rd" value="<?php echo esc_attr($radius);?>" placeholder="<?php echo adforest_returnEcho($radius_placeholder);?>" type="number" data-parsley-required="true" data-parsley-error-message="" class="form-control" >
                  <button class="btn btn-default radius_submit" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div> 
        <?php echo adforest_search_params('location', 'rd','country_id');?>
    </form>
    <?php
    adforest_widget_counter();
    ?>
</div>
<?php adforest_advance_search_container();?>