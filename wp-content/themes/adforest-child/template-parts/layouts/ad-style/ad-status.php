<?php
$pid	=	get_the_ID();
if( get_post_meta($pid, '_adforest_ad_status_', true ) != ""  && get_post_meta($pid, '_adforest_ad_status_', true ) != 'active' )
{
?>
<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">
         <div role="alert" class="alert alert-info alert-dismissible alert-outline">
             <i class="fa fa-info-circle"></i>
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><?php echo __('Info','adforest'); ?></strong> - 
            <?php echo __('This ad has been','adforest') . " "; ?>
            <?php echo adforest_ad_statues(get_post_meta($pid, '_adforest_ad_status_', true )); ?>.
         </div>
     </div>
 </div>
<?php
 }