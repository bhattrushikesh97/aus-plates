<?php global $dwt_listing_options;
$ad_id = '';$fetch_profile = '';$user_id =''; $user_email =''; $user_contact =''; $user_name ='';
$ad_id  = get_the_ID();

$user_id  =   get_current_user_id();
$user_contact   =   get_user_meta($user_id, '_sb_contact', true);
$user_data = get_userdata( $user_id );
$user_name  =   $user_data->display_name;

?>
<!-- Claim Modal -->
<div class="modal fade claim-ad-model"  tabindex="-1" role="dialog">
  <div class="modal-dialog login animated">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"> <?php echo esc_html__("Claim Listing", 'adforest'); ?></h4>
        </div>
        <div class="modal-body">  
            <div class="box">
                <div class="content">
                 <div class="form">
                    <form method="post" id="claim-form" data-disable="false">
                    
                    <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Your Name','adforest');?><span>*</span></label>
                                    <input type="text" class="form-control" name="claimer_name" placeholder="<?php echo esc_html__('Your name','adforest');?>" value="<?php echo esc_attr($user_name); ?>" data-parsley-required="true" data-parsley-error-message= "<?php echo esc_html__('This field is required','adforest');?>">
                                    <div class="help-block"></div>
                                </div>
                    

          <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Contact Number','adforest');?><span>*</span></label>
                                    <input  class="form-control" name="claimer_contact" placeholder="<?php echo esc_html__('Phone number or mobile number','adforest');?>" value="<?php echo esc_attr($user_contact); ?>" data-parsley-required="true" data-parsley-error-message= "<?php echo esc_html__('This field is required','adforest');?>">
                                    <div class="help-block"></div>
                                </div>
                    
                    <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Additional Proof','adforest');?><span>*</span></label>
                                    <textarea cols="6" name="claimer_message" rows="6" placeholder="<?php echo esc_html__('Additional proof to expedite your claim approval...','adforest');?>" class="form-control" data-parsley-required="true" data-parsley-error-message= "<?php echo esc_html__('This field is required','adforest');?>"></textarea>
                                </div>            
                               <input type="hidden" name="claim_ad_id" id="claim_ad_id" value="<?php echo esc_attr($ad_id); ?>">                               <input type="hidden" name="claimer_id" id="claimer_id" value="<?php echo esc_attr($user_id); ?>">  
                    <button type="submit" class="btn btn-theme sonu-button-<?php echo esc_attr($ad_id); ?>"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing", 'adforest'); ?>"><?php echo esc_html__("Claim Your Business Now", 'adforest'); ?></button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
                
      </div>
  </div>
</div>