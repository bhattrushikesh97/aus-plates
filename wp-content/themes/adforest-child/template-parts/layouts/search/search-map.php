<?php
//wp_enqueue_script( 'infobox', trailingslashit( get_template_directory_uri () ) . 'js/infobox.js' , array('google-map-callback'), false, false);
//wp_enqueue_script( 'marker-clusterer', trailingslashit( get_template_directory_uri () ) . 'js/markerclusterer.js' , false, false, false);

$mapType = adforest_mapType();
if ($mapType == 'google_map') {
    wp_enqueue_script('search-map');
    wp_enqueue_script('oms');
}


wp_enqueue_style('pretty-checkbox');

$map_script = '<script> var show_radius = "";';
if (isset($adforest_theme['sb_radius_search']) && $adforest_theme['sb_radius_search']) {
    $radius = '';
    $area = isset($_GET['location']) && $_GET['location'] != '' ? $_GET['location'] : '';
    if (isset($_GET['location']) && $_GET['location'] != "" && isset($_GET['rd']) && $_GET['rd'] != "") {
        $radius = $_GET['rd'];
        $area = $_GET['location'];
        $map_script .= ' var show_radius = "yes";';
    }
}
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$dis_map = (isset($_GET['hide-map']) && $_GET['hide-map'] != '') ? $_GET['hide-map'] : '';
$dis_filters = (isset($_GET['hide-filters']) && $_GET['hide-filters'] != '') ? $_GET['hide-filters'] : '';

$checked_map = $checked_filter = $map_style = $map_style_class = $col_class = $filter_style = $filter_style = $filter_style_class = "";

if ((isset($dis_map) && $dis_map == 'on')) {
    $map_style = ' style="display:none;" ';
    $map_style_class = ' no-map ';
    $col_class = 'col-4';
    $checked_map = ' checked ';
}
if (isset($dis_filters) && $dis_filters == 'on') {
    $filter_style = ' style="display:none;" ';
    $filter_style_class = ' no-filters ';
    $checked_filter = ' checked ';
}
?>
<div class="map-container-scroll">
    <section class="match-adforest">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-pm bg-white"></div>
                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-pm">
                    <div class="found-adforest">
                        <div class="found-adforest-heading">
                            <h5><?php echo esc_html($results->found_posts); ?> <?php echo __('Ads Found', 'adforest') . ":"; ?>  <?php
                                $param = $_SERVER['QUERY_STRING'];
                                if ($param != "") {
                                    ?>
                                    <span><a class="filterAdType-count" href="<?php echo get_the_permalink($sb_search_page); ?>"><?php echo __('Reset Search', 'adforest'); ?></a></span>
                                <?php } ?></h5>
                        </div>
                        <div class="found-adforest-sorting">

                            <ul class="found-sort-item">
                                <?php if (isset($adforest_theme['hide_search_map']) && $adforest_theme['hide_search_map']) { ?>
                                    <li class="hide-switch">
                                        <form method="get">
                                            <div class="pretty p-switch">
                                                <input type="checkbox" name="hide-map" id="map-hide-search"  <?php echo esc_attr($checked_map); ?>/>
                                                <div class="state p-success">
                                                    <label></label>
                                                </div>
                                            </div><label class="search-label-switch"><?php echo __(' Hide Map ', 'adforest'); ?></label>
                                            <?php echo adforest_search_params('hide-map'); ?>
                                            <?php apply_filters('adforest_form_lang_field', true); ?>

                                        </form>
                                    </li>

                                    <?php
                                }
                                if (isset($adforest_theme['hide_search_filters']) && $adforest_theme['hide_search_filters']) {
                                    ?>
                                    <li class="hide-switch">
                                        <form>
                                            <div class="pretty p-switch" action="<?php echo get_the_permalink(); ?>">
                                                <input type="checkbox" name="hide-filters"  id="filter-hide-search"  <?php echo esc_attr($checked_filter); ?>/>
                                                <div class="state p-success">
                                                    <label></label>
                                                </div>
                                            </div><label class="search-label-switch"><?php echo __(' Hide Filters ', 'adforest'); ?></label>

                                            <?php echo adforest_search_params('hide-filters'); ?>
                                            <?php apply_filters('adforest_form_lang_field', true); ?>
                                        </form>
                                    </li>
                                <?php } ?>
                                <li> 
                                    <?php
                                    $selectedOldest = $selectedLatest = $selectedTitleAsc = $selectedTitleDesc = $selectedPriceHigh = $selectedPriceLow = '';
                                    if (isset($_GET['sort'])) {
                                        $selectedOldest = ( $_GET['sort'] == 'id-asc' ) ? 'selected' : '';
                                        $selectedLatest = ( $_GET['sort'] == 'id-desc' ) ? 'selected' : '';
                                        $selectedTitleAsc = ( $_GET['sort'] == 'title-asc' ) ? 'selected' : '';
                                        $selectedTitleDesc = ( $_GET['sort'] == 'title-desc' ) ? 'selected' : '';
                                        $selectedPriceHigh = ( $_GET['sort'] == 'price-desc' ) ? 'selected' : '';
                                        $selectedPriceLow = ( $_GET['sort'] == 'price-asc' ) ? 'selected' : '';
                                    }
                                    ?>
                                    <form method="get">
                                        <select name="sort"  class="custom-select order_by"  id="select-sort" >
                                            <option value="id-desc" <?php echo esc_attr($selectedLatest); ?>><?php echo esc_html__('Newest To Oldest', 'adforest'); ?></option>
                                            <option value="id-asc" <?php echo esc_attr($selectedOldest); ?>><?php echo esc_html__('Oldest To Newest', 'adforest'); ?></option>
                                            <option value="price-desc" <?php echo esc_attr($selectedPriceHigh); ?>><?php echo esc_html__('Price: High to Low', 'adforest'); ?></option>
                                            <option value="price-asc" <?php echo esc_attr($selectedPriceLow); ?>><?php echo esc_html__('Price: Low to High', 'adforest'); ?></option>
                                        </select>
                                        <?php echo adforest_search_params('sort');?>
                                    </form>
                                </li>
                                <?php
                                $grid_view = adforest_custom_remove_url_query('view-type', 'grid');
                                $list_view = adforest_custom_remove_url_query('view-type', 'list');
                                if (isset($adforest_theme['search_layout_types']) && $adforest_theme['search_layout_types'] == true) {
                                    ?>
                                    <li class="btn found-listing-icon <?php echo (is_rtl() ) ? 'pull-left' : 'pull-right'; ?>">
                                        <a class="filterAdType-count" href="<?php echo esc_url($grid_view); ?>" class="<?php echo (is_rtl() ) ? 'pull-left' : 'pull-right'; ?>"><i class="fa fa-th"></i></a><li>                                       
                                    <li class="btn found-listing-icon-1 <?php echo (is_rtl() ) ? 'pull-left' : 'pull-right'; ?>">
                                        <a class="filterAdType-count" href="<?php echo esc_url($list_view); ?>" class="pull-right">
                                            <i class="fa fa-bars"></i>
                                        </a></li>                      
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="search-vendor-page  search-map-container">
        <div class="container-fluid">
            <div class="row">
                <?php get_sidebar('ads'); ?>
                <div class="left-part  col-pm <?php echo ($map_style_class . $filter_style_class); ?>">
                    <div class="row">
                        <div class=" map-scroller-2">
                            <?php
                            if (isset($adforest_theme['feature_on_search']) && $adforest_theme['feature_on_search']) {
                                $countries_location = '';
                                $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
                                $args = array(
                                    'post_type' => 'ad_post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => $adforest_theme['max_ads_feature'],
                                    'tax_query' => array($category, $countries_location,),
                                    'meta_query' => array(
                                        array('key' => '_adforest_is_feature', 'value' => 1, 'compare' => '=',),
                                        array('key' => '_adforest_ad_status_', 'value' => 'active', 'compare' => '=',),
                                    ),
                                    'orderby' => 'rand',
                                );
                                $ads = new ads();
                                echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['feature_ads_title'], 4, ''));
                            }
                            ?> 
                            <?php if (isset($adforest_theme['search_ad_720_1']) && $adforest_theme['search_ad_720_1'] != "" && $results->have_posts()) {
                                ?>
                                <div class="col-md-12">
                                    <div class="margin-bottom-30 margin-top-10 text-center">
                                        <?php echo "" . $adforest_theme['search_ad_720_1']; ?>
                                    </div>
                                </div>
                                <?php
                            }

                            if (isset($adforest_theme['sb_ad_alerts']) && $adforest_theme['sb_ad_alerts']) {
                                ?>
                                <div class="row  alert-for-map">
                                    <div class="col-md-12  col-lg-1 col-xl-1  col-sm-12"></div>
                                    <div class="col-md-12  col-lg-10 col-xl-10  col-sm-12">
                                        <div class = "ad-alert-box">
                                            <div class = "row">
                                                <div class = "col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                    <h4><?php echo esc_html__('Ads Alerts', 'adforest') ?></h4>
                                                    <p><?php echo esc_html__('Receive emails for the latest Ads matching your search criteria', 'adforest') ?></p>
                                                </div>
                                                <div class = "col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                    <a href = "javascript:void(0)" class = "btn btn-theme  ad_alerts"><?php echo esc_html__('Create Alerts', 'adforest') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12  col-lg-1 col-xl-1  col-sm-12"></div>
                                </div>
                            <?php } ?>
                            
                             <div class="search-found-list">
                                 <div class="row">
                             <?php get_template_part('template-parts/layouts/search/search', 'tags'); ?>
                                <?php
                                    if (isset($adforest_theme['sb_allow_cats_above_filters']) && $adforest_theme['sb_allow_cats_above_filters']) {
                                        if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                                            ?><?php
                                            $cat_id = $_GET['cat_id'];
                                            $ad_cats = adforest_get_cats('ad_cats', $cat_id);
                                            $res = '';
                                            $rows_count = 1;
                                            $max_rows = $adforest_theme['sb_max_sub_cats'];
                                            $show = true;
                                            if (count($ad_cats) > 0) {
                                                parse_str($_SERVER['QUERY_STRING'], $search_params);
                                                unset($search_params['cat_id']);
                                                $new_params = http_build_query($search_params);
                                                $cat_params = '';
                                                $cls = '';
                                                $res .= '<ul class="city-select-city" >';
                                                foreach ($ad_cats as $ad_cat) {
                                                    if ($new_params != "") {
                                                        $cat_params = '?' . $new_params . '&cat_id=' . $ad_cat->term_id;
                                                        $cat_link = get_the_permalink($sb_search_page) . $cat_params;
                                                    } else {
                                                        $cat_params = '?cat_id=' . $ad_cat->term_id;
                                                        $cat_link = get_the_permalink($sb_search_page) . $cat_params;
                                                    }

                                                    $li_col = '3';
                                                    if (isset($adforest_theme['sb_li_cols']) && $adforest_theme['sb_li_cols'] != "") {
                                                        $li_col = $adforest_theme['sb_li_cols'];
                                                    }

                                                    $count = ($ad_cat->count);
                                                    if ($rows_count > $max_rows && $show) {
                                                        $show = false;
                                                        $res .= '<li class="col-md-12 col-sm-12 col-xs-12 hide_cats text-center margin-top-20"><a href="javascript:void(0);"  class="tax-show-more">' . __('Show more', 'adforest') . '</a></li>';
                                                        $cls = 'no-display show_it';
                                                    }
                                                    $res .= '<li class="col-md-' . esc_attr($li_col) . ' col-sm-6 col-xs-12 ' . esc_attr($cls) . '"><a href="' . $cat_link . '" >' . $ad_cat->name . ' <span>(' . $count . ')</span> </a></li>';
                                                    $rows_count++;
                                                }
                                                $res .= '</ul>';
                                                ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="expand-collapse adforest-new-filter">


                                                        <h3> <a role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOnez" aria-expanded="true" aria-controls="collapseOnez">
                                                                <i class="more-less fa fa-plus"></i>
                                                                <?php
                                                                //echo __('Categories', 'adforest');
                                                                $title = adforest_get_taxonomy_parents($cat_id, 'ad_cats', false);
                                                                $find = '&raquo;';
                                                                $replace = '';
                                                                $result = preg_replace("/$find/", $replace, $title, 1);
                                                                echo adforest_returnEcho($result);
                                                                ?> </a>
                                                        </h3>

                                                        <form>
                                                            <div id="collapseOnez" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOnez">
                                                                <div class="panel-body">
                                                                    <div class="search-modal">
                                                                        <div class="search-block"><?php echo adforest_returnEcho($res); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>



                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                 </div>
                             </div>
                            <div class="search-found-list"> 
                                <div class="row  posts-masonry">
                                    <?php
                                    $marker = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
                                     $marker_more = trailingslashit(get_template_directory_uri()) . 'images/car-marker-more.png';
                                      $close_url = trailingslashit(get_template_directory_uri()) . 'images/close.gif';
                                       $map_lon = (isset($adforest_theme['search_map_lat']) && $adforest_theme['search_map_lat'] != "" ) ? $adforest_theme['search_map_lat'] : 39.739236;
                                        $map_lat = (isset($adforest_theme['search_map_long']) && $adforest_theme['search_map_long'] != "" ) ? $adforest_theme['search_map_long'] : -104.990251;
                                    if (isset($adforest_theme['search_map_marker']['url']) && $adforest_theme['search_map_marker']['url'] != "") {
                                         $marker = $adforest_theme['search_map_marker']['url'];
                                    }

                                    if (isset($adforest_theme['search_map_marker_more']['url']) && $adforest_theme['search_map_marker_more']['url'] != "") {
                                         $marker_more = $adforest_theme['search_map_marker_more']['url'];
                                    }

                                    if (isset($adforest_theme['search_map_lat']) && $adforest_theme['search_map_lat'] != "" && isset($adforest_theme['search_map_long']) && $adforest_theme['search_map_long'] != "") {
                                         $map_lat = $adforest_theme['search_map_lat'];
                                          $map_lon = $adforest_theme['search_map_long'];
                                    }

                                    if (isset($_GET['location']) && $_GET['location'] != "") {
                                          $latlng = adforest_getLatLong($_GET['location']);
                                        if (count($latlng) > 0) {
                                            $map_lat = (isset($latlng['latitude'])) ? $latlng['latitude'] : '';
                                             $map_lon = (isset($latlng['longitude'])) ? $latlng['longitude'] : '';
                                        }
                                    }

                                    $map_zoom = 6;
                                    if (isset($adforest_theme['search_map_zoom']) && $adforest_theme['search_map_zoom'] != "") {
                                         $map_zoom = $adforest_theme['search_map_zoom'];
                                    }


                                    if ($mapType == 'leafletjs_map') {
                                         $map_script = '<script>var listing_markers = [';
                                    } else if ($mapType == 'google_map') {
                                        $map_script .= ' var imageUrl = "' . $marker . '";
                                            var imageUrl_more	=	"' . $marker_more . '";
                                            var search_map_lat	=	"' . $map_lat . '";
                                            var search_map_long	=	"' . $map_lon . '";
                                            var search_map_zoom	=	' . $map_zoom . ';
                                            var close_url	=	"' . $close_url . '";
                                            var locations = [';
                                    }
                                    $layouts = array('list_1', 'list_2', 'list_3');
                                    if ($results->have_posts()) {
                                        $col = 4;
                                        $col_lg = 4;

                                        if (isset($dis_map) && $dis_map == 'on' && isset($dis_filters) && $dis_filters == 'on') {

                                            $col = 3;
                                            $col_lg = 3;
                                        }

                                        $layout_type = isset($adforest_theme['search_ad_layout_for_sidebar']) ?
                                                $adforest_theme['search_ad_layout_for_sidebar'] : "grid_1";
                                        $get_grid_layout = adforest_get_grid_layout();
                                        $search_ad_layout_for_sidebar = ($get_grid_layout != "" ) ? $get_grid_layout : $layout_type;
                                        $layout_type = ($get_grid_layout != "" ) ? $get_grid_layout : $layout_type;
                                        if (in_array($search_ad_layout_for_sidebar, $layouts)) {
                                            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad-style/search-layout-list.php";
                                            echo adforest_returnEcho($out);
                                        } else {
                                            require trailingslashit(get_template_directory()) . "template-parts/layouts/ad-style/search-layout-grid.php";
                                            echo adforest_returnEcho($out);
                                        }
                                        /* Restore original Post Data */
                                        wp_reset_postdata();
                                    } else {
                                        $no_found = get_template_directory_uri() . '/images/nothing-found.png';
                                        ?>
                                        <div class="col-xl-12 col-12 col-sm-12 col-md-12">
                                            <div class="nothing-found white search-bar">
                                                <img src="<?php echo esc_url($no_found); ?>" alt="">
                                                <h3><?php echo esc_html__('No Result Found', 'adforest') ?></h3>
                                            </div> 
                                        </div>
                                        <?php
                                    }
                                    $map_script .= "];</script>";
                                    ?>
                                </div>
                            </div>


                            <?php if (isset($adforest_theme['search_ad_720_2']) && $adforest_theme['search_ad_720_2'] != "" && $results->have_posts()) {
                                ?>
                                <div class="col-md-12">
                                    <div class="margin-bottom-30 margin-top-10 text-center">
                                        <?php echo "" . $adforest_theme['search_ad_720_2']; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="pagination-item">
                                <?php adforest_pagination_search($results); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-part col-pm <?php echo ($filter_style_class); ?>"<?php echo ($map_style); ?>>
                    <div class="no-container">
                        <div class="left-area">
                            <div id="map" class="map"></div>
                            <ul id="google-map-btn">
                                <?php if ($mapType != 'leafletjs_map') { ?> 
                                    <li><a href="javascript:void(0);" id="you_current_location" title="<?php echo __('You Current Location', 'adforest'); ?>"><i class="fa fa-crosshairs"></i></a></li>
                                <?php } ?>
                                <li><a href="javascript:void(0);" id="reset_state" title="<?php echo __('Reset map', 'adforest'); ?>"><?php echo __("Reset", "adforest"); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<?php
if ($mapType == 'leafletjs_map') {
    echo adforest_returnEcho($map_script);
}
?>
<script>

<?php
if ($mapType == 'leafletjs_map') {
    /* $marker; $marker_more; $map_lat; $map_lon; $map_zoom; $close_url; */

    $marker_url = trailingslashit(get_template_directory_uri()) . 'images/map-pin.png';
    if ($marker != "") {
        $marker_url = $marker;
    }
    ?>
        jQuery(document).ready(function () {
            var map_lat = "<?php echo esc_html($map_lat); ?>";
            var map_long = "<?php echo esc_html($map_lon); ?>";
            if (map_lat && map_long)
            {

                var my_icons = "<?php echo esc_url($marker_url); ?>";
                if (jQuery('#map').length) {
                    var map = L.map('map').setView([map_lat, map_long], <?php echo esc_html($map_zoom); ?>);
                    L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
                    var myIcon = L.icon({
                        iconUrl: my_icons,
                        iconRetinaUrl: my_icons,
                        iconSize: [25, 40],
                        iconAnchor: [10, 30],
                        popupAnchor: [0, -35]
                    });
                    adforest_mapCluster();
                }
            }

            jQuery('#reset_state').on('click', function () {
                if (jQuery('#map').length)
                {
                    adforest_mapCluster();
                }
            });

            function adforest_mapCluster()
            {
                var markerClusters = L.markerClusterGroup();
                for (var i = 0; i < listing_markers.length; ++i)
                {
                    if (listing_markers[i].lat && listing_markers[i].lon) {
                        var popup = '<div class="recent-ads"><div class="recent-ads-list"> <div class="recent-ads-container"><div class="recent-ads-list-image"><div class="featured-ribbon"><span>' + listing_markers[i].ad_class + '</span></div><a href="' + listing_markers[i].ad_link + '" class="recent-ads-list-image-inner"> <img alt="' + listing_markers[i].title + '" src="' + listing_markers[i].img + '"></a> </div><div class="recent-ads-list-content"><h3 class="recent-ads-list-title"><a href="' + listing_markers[i].ad_link + '">' + listing_markers[i].title + '</a></h3><ul class="recent-ads-list-location"><li><a href="javascript:void(0);">' + listing_markers[i].location + '</a></li></ul><div class="recent-ads-list-price">' + listing_markers[i].price + ' </div></div></div></div></div>';
                    }
                    var m = L.marker([listing_markers[i].lat, listing_markers[i].lon], {icon: myIcon}).bindPopup(popup, {minWidth: 270, maxWidth: 270});
                    markerClusters.addLayer(m);
                    map.addLayer(markerClusters);
                    map.fitBounds(markerClusters.getBounds());
                }

                map.scrollWheelZoom.disable();
                map.invalidateSize();

            }
        });

    <?php
} else if ($mapType == 'google_map') {
    ?>
        function locationData(adImg, adPrice, isFeatured, categoryLink, categorytitle, adTitle, addLocation, adlink, adTime) {
            return ('<div class="recent-ads"><div class="recent-ads-list"> <div class="recent-ads-container"><div class="recent-ads-list-image"><div class="featured-ribbon"><span>' + isFeatured + '</span></div><a href="' + adlink + '" class="recent-ads-list-image-inner"> <img alt="' + adTitle + '" src="' + adImg + '"></a> </div><div class="recent-ads-list-content"><h3 class="recent-ads-list-title"><a href="' + adlink + '">' + adTitle + '</a></h3><ul class="recent-ads-list-location"><li><a href="javascript:void(0);">' + addLocation + '</a></li></ul><div class="recent-ads-list-price">' + adPrice + ' </div></div></div></div></div>');
        }
    <?php
}
?>
</script>
<?php
if ($mapType == 'google_map') {
    echo adforest_returnEcho($map_script);
}