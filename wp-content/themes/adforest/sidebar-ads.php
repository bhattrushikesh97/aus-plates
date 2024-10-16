<?php
global $adforest_theme;
$right_col = 'col-md-4 col-xs-12';
$show_mob_filter  = false;
if(isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'sidebar')
{
	if(isset($adforest_theme['search_design_sidebar_mob_filter']) && $adforest_theme['search_design_sidebar_mob_filter'] == true)
	{
		$show_mob_filter  = true;
	}
}
$ext_class   = '';
 $map_style = '';
if(isset($adforest_theme['search_design']) && $adforest_theme['search_design'] == 'map')
{
		$ext_class   = 'map-sidebar';
                 
}
   if(isset($_GET['hide-filters'])){      
       $map_style = ' style="display:none;" ';
   }
 ?>

    <div class="sidebar   <?php echo $ext_class ; echo adforest_returnEcho($show_mob_filter) ?  'mobile-filters' : ''; ?>" <?php echo $map_style ?>>
    	<?php if($show_mob_filter){ ?>
    	<div class="mobile-filter-heading"><?php esc_html__("Search Filters", "adforest"); ?></div>
    	<a class="btn btn-theme filter-close-btn" href="javascript:void(0);"><i class="fa fa-close"></i></a>
    	<?php }?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="collapse-heading-search"><h1><?php echo esc_html__('Search Filters','adforest'); ?></h1> 

</div>
            <?php dynamic_sidebar('adforest_search_sidebar');?>
        </div>
    </div>

	<?php if($show_mob_filter){ ?>
	<div class="mobile-filters-btn">
		<a class="btn btn-theme" href="javascript:void(0);"><?php esc_html_e("Filters", "adforest"); ?><i class="fa fa-filter"></i></a>
	</div>
	<?php }?>