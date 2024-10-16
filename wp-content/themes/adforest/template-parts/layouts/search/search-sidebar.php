<?php
global $adforest_theme;
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$section_class = '';
if (wp_is_mobile()) {
    $section_class = 'section-no-pad ';
}
?>
<section class="match-adforest sidebar-match-adforest">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-pm"></div>
            <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-pm">
                <div class="found-adforest found-sidebar">
                    <div class="found-adforest-heading">
                        <h5><?php echo esc_html($results->found_posts); ?> <?php echo __('Found Ads', 'adforest'). ":"; ?>  <?php
                            $param = $_SERVER['QUERY_STRING'];
                            if ($param != "") {
                                ?>
                                <span><a class="filterAdType-count" href="<?php echo get_the_permalink($sb_search_page); ?>"><?php echo __('Reset Search', 'adforest'); ?></a></span>
                            <?php } ?></h5>
                    </div>
                    <div class="found-adforest-sorting">
                        <ul class="found-sort-item">
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
<section class="search-vendor-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-pm bg-white">
                <?php get_sidebar('ads'); ?>
            </div>
            <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-pm">
                <div class="clearfix"></div>
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
                             <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                <?php get_template_part('template-parts/layouts/search/search', 'tags'); ?>
                            </div>
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
                            
               <?php if(isset($adforest_theme['sb_ad_alerts']) &&  $adforest_theme['sb_ad_alerts']) {     ?>
                <div class="row sidebar-alert">
               <div class="col-lg-2"></div>
                <div class="col-md-12  col-lg-8 col-xl-8  col-sm-12">
                    <div class = "ad-alert-box">
                        <div class = "row">
                            <div class = "col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                <h4><?php echo esc_html__('Ads Alerts', 'adforest') ?></h4>
                                <p><?php echo esc_html__('Receive emails for the latest Ads matching your search criteria', 'adforest') ?></p>
                            </div>
                            <div class = "col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <a href = "javascript:void(0)" class = "btn btn-theme  ad_alerts"><?php  echo esc_html__('Create Alert','adforest') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-2"></div>
             </div>
  
               <?php } ?>
                <?php
                if (isset($adforest_theme['search_ad_720_1']) && $adforest_theme['search_ad_720_1'] != "" && $results->have_posts()) {
                    ?>

                    <div class="col-md-12">
                        <div class="margin-bottom-30 margin-top-10 text-center">
                            <?php echo "" . $adforest_theme['search_ad_720_1']; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="search-found-list"> 
                    <div class="row posts-masonry">
                        <?php
                        $layouts = array('list_1', 'list_2', 'list');
                        if ($results->have_posts()) {

                            $col = 3;
                            $col_lg = 4;

                           $layout_type = isset($adforest_theme['search_ad_layout_for_sidebar']) ?
                                    $adforest_theme['search_ad_layout_for_sidebar'] : "";
                            $get_grid_layout = adforest_get_grid_layout();
                            $search_ad_layout_for_sidebar = ($get_grid_layout != "" ) ? $get_grid_layout : $layout_type;
                            
                             $layout_type =  ($get_grid_layout != "" ) ? $get_grid_layout : $layout_type;
                            
          
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
                            $no_found =  get_template_directory_uri() . '/images/nothing-found.png';

                        ?>
                    <div class="col-xl-12 col-12 col-sm-12 col-md-12">
                        <div class="nothing-found white search-bar">
                        <img src="<?php echo esc_url($no_found); ?>" alt="">
                    <h3><?php echo esc_html__('No Result Found','adforest') ?></h3>
                  </div> 
                    </div>
                      <?php  }
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
</section>