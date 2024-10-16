<?php
/*
 * Adforest Elementor Function Class
 */

if(!class_exists('Adforest_AdPost_Categories')) {
Class Adforest_AdPost_Categories {

    public function __construct() {
        global $adforest_theme;
        $adpost_cat_style = isset($adforest_theme['adpost_cat_style']) && $adforest_theme['adpost_cat_style'] == 'grid' ? TRUE : FALSE;
        if (!$adpost_cat_style)
            return;
        add_filter('adforest_adpost_modern_categories', array($this, 'adforest_adpost_modern_categories_callback'), 10, 3);
        add_filter('adforest_adpost_categories_modal', array($this, 'adforest_adpost_categories_modal_callback'), 10, 1);
    }

    public function adforest_adpost_categories_modal_callback($modal_html = '') {
        $modal_html = '<div class="panel panel-default my_panel">
                            <div class="search-modal modal fade cats_model" id="cat_modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title text-center" id="lineModalLabel"> <i class="fa fa-cogs"></i> ' . __('Select Any Category', 'adforest') . '
                                                <button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only">Close</span></button>
                                            </h3>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="search-block">
                                                <div class="row"> </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12 col-sm-12 popular-search" id="cats_response"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        return $modal_html;
    }

    private function adforest_add_remaining_cat_fields($count = 0) {

        if ($count == 1) {
            echo '<input type="hidden" name="ad_cat_sub_sub_sub" id="ad_cat_sub_sub_sub" value="" />
                    <input type="hidden" name="ad_cat_sub_sub" id="ad_cat_sub_sub" value="" />
                    <input type="hidden" name="ad_cat_sub" id="ad_cat_sub" value="" />';
        } elseif ($count == 2) {
            echo '<input type="hidden" name="ad_cat_sub_sub_sub" id="ad_cat_sub_sub_sub" value="" />
                    <input type="hidden" name="ad_cat_sub_sub" id="ad_cat_sub_sub" value="" />';
        } elseif ($count == 3) {
            echo '<input type="hidden" name="ad_cat_sub_sub_sub" id="ad_cat_sub_sub_sub" value="" />';
        }
    }

    public function adforest_adpost_modern_categories_callback($cats_html = '', $ad_id = 0, $post_style = 'modern') {

        ob_start();
        $ad_cats = adforest_get_cats('ad_cats', 0, 0, 'post_ad');
        $slctd_cats = '';
        if (isset($ad_cats) && !empty($ad_cats) && is_array($ad_cats) && count($ad_cats) > 0) {
            if ($ad_id != 0) {
                $selected_terms = wp_get_post_terms($ad_id, 'ad_cats');              
                if (isset($selected_terms) && !empty($selected_terms) && is_array($selected_terms) && sizeof($selected_terms) > 0) {
                    $total = count($selected_terms);
                    $count = 0;
                    $active_cat_id = '';
                    
                      $selected_terms     =    array_reverse($selected_terms);
                    foreach ($selected_terms as $single_terms) {
                        $slctd_cats .= '<li> ' . $single_terms->name . ' </li> ';
                        $term_level = adforest_get_taxonomy_depth($single_terms->term_id, 'ad_cats');
                        if ($term_level == '1') {
                            $active_cat_id = $single_terms->term_id;
                            echo '<input type="hidden" name="ad_cat" id="ad_cat" value="' . $single_terms->term_id . '" />';
                        } elseif ($term_level == '2') {
                            echo '<input type="hidden" name="ad_cat_sub" id="ad_cat_sub" value="' . $single_terms->term_id . '" />';
                        } elseif ($term_level == '3') {
                            echo '<input type="hidden" name="ad_cat_sub_sub" id="ad_cat_sub_sub" value="' . $single_terms->term_id . '" />';
                        } elseif ($term_level == '4') {
                            echo '<input type="hidden" name="ad_cat_sub_sub_sub" id="ad_cat_sub_sub_sub" value="' . $single_terms->term_id . '" />';
                        }
                    }
                    $this->adforest_add_remaining_cat_fields($total);
                }
            } else {
              echo '<input type="hidden" name="ad_cat_sub_sub_sub" id="ad_cat_sub_sub_sub" value="" />
                    <input type="hidden" name="ad_cat_sub_sub" id="ad_cat_sub_sub" value="" />
                    <input type="hidden" name="ad_cat_sub" id="ad_cat_sub" value="" />
                    <input type="hidden" name="ad_cat" id="ad_cat" value="" data-parsley-required="true"/>';
            }
            $ad_post_style = '';
            if ($post_style == 'fancy') {
                $ad_post_style = ' sb-fancy-cats';
            }

            $cat_style = ' style="display:none"';
            if (isset($slctd_cats) && $slctd_cats != '') {
                $cat_style = '';
            }
            ?>

            <div class="card-header sub-header sb-selected-cats-header" <?php echo adforest_returnEcho($cat_style); ?>  >
                <ul class="sb-selected-cats item-sub-information"><?php echo adforest_returnEcho($slctd_cats); ?></ul>
            </div>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                <div class="sb-adpost-cats<?php echo adforest_returnEcho($ad_post_style); ?>">
                    <ul class="category-grid-ist">
                     <?php
                     foreach ($ad_cats as $ad_cat) {
                       $count = ($ad_cat->count);
                        $cat_meta = get_option("taxonomy_term_$ad_cat->term_id");
                           $icon = (isset($cat_meta['ad_cat_icon'])) ? $cat_meta['ad_cat_icon'] : '';
                             $cat_search_page = 'javascript:void(0);';
                           $cat_search_page = apply_filters('adforest_filter_taxonomy_popup_actions', $cat_search_page, $ad_cat->term_id, 'ad_cats');
                        $term_level = adforest_get_taxonomy_depth($ad_cat->term_id, 'ad_cats');
                       $active_class = '';
                      if (isset($active_cat_id) && $active_cat_id == $ad_cat->term_id) {
                        $active_class = ' sb-cat-active';
                      }
                        $imgUrl = adforest_taxonomy_image_url($ad_cat->term_id, NULL, TRUE);
                     ?>
                        <li class="sb-cat-box<?php echo adforest_returnEcho($active_class); ?>"> <a href="<?php echo adforest_returnEcho($cat_search_page); ?>" data-term-name="<?php echo esc_html($ad_cat->name); ?>" data-term-level="<?php echo esc_attr($term_level); ?>" data-cat-id="<?php echo esc_attr($ad_cat->term_id); ?>"> <img src="<?php echo   esc_url($imgUrl) ?>" alt="<?php echo esc_html__('img','adforest') ?>"><?php echo esc_html($ad_cat->name); ?></a></li>
                        <?php
                      }
                     ?>
                   </ul>	
               </div>
            </div>
            <?php
        }
        $contents = ob_get_contents();
        ob_end_clean();
        
            return $contents;
        
    }

}
}
new Adforest_AdPost_Categories();