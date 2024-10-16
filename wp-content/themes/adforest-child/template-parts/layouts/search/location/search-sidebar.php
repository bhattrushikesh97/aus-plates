<?php
global $adforest_theme, $template;
$sb_search_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_search_page']);
$sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
$sb_search_page = apply_filters('adforest_category_widget_form_action', $sb_search_page);

$page_template = basename($template);
if ($page_template == 'taxonomy-ad_country.php') {
    $term_id = get_queried_object_id();
}
$texonomy_single_style = isset($adforest_theme['location_single_style']) && $adforest_theme['location_single_style'] != '' ? $adforest_theme['location_single_style'] : 'list';
$sidebar_position = isset($adforest_theme['location_sidebar_position']) ? $adforest_theme['location_sidebar_position'] : 'left';


?>
<?php if ($search_cat_page) { ?>
    <section class="match-adforest sidebar-match-adforest">
        <div class="container-fluid">
            <div class="row">
                <?php if ($search_cat_page && $sidebar_position == 'left') { ?> 
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12"></div>
                <?php } ?>
            <div class="col-xl-10 col-lg-9 col-md-12 col-sm-12 col-pm">
                    <div class="found-adforest found-sidebar">
                        <div class="found-adforest-heading">
                            <h5><?php echo esc_html($results->found_posts); ?> <?php echo __('Found Ads', 'adforest')  . ":"; ?>  <?php
                                $param = $_SERVER['QUERY_STRING'];
                                if ($param != "") {
                                    ?>
                                    <span><a class="filterAdType-count" href="<?php echo esc_url($sb_search_page); ?>"><?php echo __('Reset Search', 'adforest'); ?></a></span>
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
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if ($search_cat_page && $sidebar_position == 'right') { ?> 
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12"></div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<section class="search-vendor-page">
    <div class="<?php echo esc_attr($search_cat_page)  ==  true ?   "container-fluid" :  "container" ; ?>">
        <div class="row">
            <?php if ($search_cat_page && $sidebar_position == 'left') { ?>  
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-pm bg-white">
                    <div class="sidebar ">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="collapse-heading-search"><h2><?php echo esc_html__('Search Filters', 'adforest') ?></h2> 

                            </div>
                            <?php dynamic_sidebar('adforest_location_search'); ?>
                        </div>
                    </div>
                </div>

            <?php } ?>
             <?php if (!$search_cat_page) { ?> 
                    <div class="col-md-1"></div>
                <?php } ?>
            <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-pm">

                <?php if ($search_cat_page) { ?>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <?php get_template_part('template-parts/layouts/search/search', 'tags'); ?>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
                <?php if (isset($term_id) && $term_id != "") { ?>
                    <?php
                    $cat_id = $term_id;
                      $ad_cats = adforest_get_cats('ad_country', $cat_id);

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
                                            $cat_link = get_term_link($ad_cat->slug, 'ad_country');
                                        } else {
                                            $cat_link = get_term_link($ad_cat->slug, 'ad_country');
                                        }
                                        if (isset($adforest_theme['sb_li_cols']) && $adforest_theme['sb_li_cols'] != "") {
                                            $li_col = $adforest_theme['sb_li_cols'];
                                        }

                                        $count = ($ad_cat->count);
                                        if ($rows_count > $max_rows && $show) {
                                            $show = false;
                                            $res .= '<li class="col-md-12 col-sm-12 col-xs-12 hide_cats text-center margin-top-20"><a href="javascript:void(0);" class="tax-show-more">' . __('Show more ', 'adforest') . '</a></li>';
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
                                        $title = adforest_get_taxonomy_parents($cat_id, 'ad_country', false);
                                        $find = '&raquo;';
                                        $replace = '';
                                        $result = preg_replace("/$find/", $replace, $title, 1);
                                        echo adforest_returnEcho($result);
                                        ?> </a>
                                </h3>
                                <form>
                                    <div id="collapseOnez" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOnez">
                                        <div class="panel-body">
                                            <div class="search-modal">
                                                <div class="search-block"><?php echo adforest_returnEcho($res); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php
                if (isset($adforest_theme['feature_on_search']) && $adforest_theme['feature_on_search']) {
                         $countries_location = '';
                            $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
                            $args = array(
                                'post_type' => 'ad_post',
                                'post_status' => 'publish',
                                'posts_per_page' => $adforest_theme['max_ads_feature'],
                                'tax_query' => array(
                                    $category,
                                    $countries_location,
                                ),
                                'meta_query' => array(
                                    array(
                                        'key' => '_adforest_is_feature',
                                        'value' => 1,
                                        'compare' => '=',
                                    ),
                                    array(
                                        'key' => '_adforest_ad_status_',
                                        'value' => 'active',
                                        'compare' => '=',
                                    ),
                                ),
                                'orderby' => 'rand',
                            );
                            $ads   =   new ads();

                    echo adforest_returnEcho($ads->adforest_get_ads_grid_slider($args, $adforest_theme['feature_ads_title'], 4, ''));
                }
                ?>

                <div class="search-found-list"> 
                    <div class="row">
                        <?php
                        if ($results->have_posts()) {
                            $col = 3;
                            $col_lg   =   4;
                            $layouts = array('list_1', 'list_2', 'list');
                             $layout_type = isset($adforest_theme['location_single_style']) ?
                                    $adforest_theme['location_single_style'] : "grid_1";
                            $get_grid_layout = adforest_get_grid_layout();
                            $search_ad_layout_for_sidebar = ($get_grid_layout != "" ) ? $get_grid_layout : $layout_type;    
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
                      <?php
                        }
                        ?>
                    </div>
                </div>
                 <div class="pagination-item">
                    <?php adforest_pagination_search($results); ?>
                </div>
            </div>
                     <?php if (!$search_cat_page) { ?> 
                    <div class="col-md-1"></div>
                <?php } ?>

            <?php if ($search_cat_page && $sidebar_position == 'right') { ?>  
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-pm bg-white">
                    <div class="sidebar ">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="collapse-heading-search"><h2><?php echo esc_html__('Search Filters', 'adforest') ?></h2> 

                            </div>
                            <?php dynamic_sidebar('adforest_location_search'); ?>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</section>