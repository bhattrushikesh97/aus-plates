<?php
global $adforest_theme;
$user_id  = get_current_user_id();
$user_info = get_userdata(get_current_user_id());
$block_user_html  =  "";

  if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && $_GET['sb_action'] == 'sb_load_messages') {
           
   
                $nonce_create = wp_create_nonce('sb_msg_secure');
       echo          "<script>	jQuery(document).ready(function($){
   					
                    adforest_select_msg('$_GET[ad_id]', '$_GET[uid]', 'no','$nonce_create');

      function adforest_select_msg(cid, second_user, prnt, msg_token)
{
    jQuery('.message-history-active').removeClass('message-history-active');
    jQuery(document).find('#' + second_user + '_' + cid).html('');
    jQuery(document).find('#sb_' + second_user + '_' + cid).addClass('message-history-active');
    jQuery('#sb_loading').show();
    jQuery.post(jQuery('#adforest_ajax_url').val(), {action: 'sb_get_messages', security: msg_token, ad_id: cid, user_id: second_user, receiver: second_user, inbox: prnt}).done(function (response)
    {
        jQuery('#usr_id').val(second_user);
        jQuery('#rece_id').val(second_user);
        jQuery('#msg_receiver_id').val(second_user);
        jQuery('#ad_post_id').val(cid)
        jQuery('#sb_loading').hide();
        jQuery('#messages').html(response);
    }).fail(function () {
        $('#sb_loading').hide();
        jQuery('#messages').html($('#_nonce_error').val());
    });

}

                            });
  </script>";
       
       echo '<div class="content-wrapper"><div class="content"><div id="adforest_res">'. adforest_load_ad_messages($_GET['ad_id']).'</div></div></div>';
       
  }


else {
$script = '<script type="text/javascript">jQuery(document).ready(function($){"use strict";      
                
              if ($("#file_attacher").length > 0) {
               var attachmentsDropzone = new Dropzone(document.getElementById(\'file_attacher\'), {
                    url: adforest_ajax_url,
                    autoProcessQueue: true,
                    previewsContainer: "#attachment-wrapper",
                    previewTemplate: \'<span class="dz-preview dz-file-preview"><span class="dz-details"><span class="dz-filename"><i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;<span data-dz-name></span></span>&nbsp;&nbsp;&nbsp;<span class="dz-size" data-dz-size></span>&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="cursor:pointer;font-size:15px;" data-dz-remove></i></span><span class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></span><i class="ti ti-refresh ti-spin"></i></span>\',
                    clickable: "a.msgAttachFile",
                    acceptedFiles: $(\'#provided_format\').val(),
                    maxFilesize: 15,
                    maxFiles: 4
                });
                attachmentsDropzone.on("sending",function(){
                        console.log("eeeee");
			$("#send_msg ,#send_ad_message").attr("disabled",true);
		});
                attachmentsDropzone.on("queuecomplete",function(){
			$("#send_msg, #send_ad_message").attr("disabled",false);
		});                

                  } $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');function scrollbar() {var $scrollbar = $(\'.message-inbox .list-wrap\');$scrollbar.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar.perfectScrollbar(\'update\');}scrollbar();$(\'.messages\').wrap(\'<div class="list-wraps"></div>\');function scrollbar1() {var $scrollbar1 = $(\'.message-details .list-wraps\');$scrollbar1.perfectScrollbar({maxScrollbarLength: 150,});$scrollbar1.perfectScrollbar(\'update\');}scrollbar1();});</script>';

$script = apply_filters('adforest_blocked_user_scripts', $script);
global $wpdb;
$rows = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type = 'ad_post' AND user_id = '$user_id' AND comment_parent = '$user_id' GROUP BY comment_post_ID ORDER BY comment_ID DESC");

$users = '';
$messages = '';
$form = '<div class="text-center">' . __('No message received on this ad yet.', 'adforest') . '</div>';
$author_html = '';
$turn = 1;
$level_2 = '';
$title_html = '';

foreach ($rows as $row) {
    $last_date = $row->comment_date;
    $date = explode(' ', $last_date);
    $author = get_post_field('post_author', $row->comment_post_ID);

    $cls = '';
    if ($turn == 1)
        $cls = 'message-history-active';

    $ad_img = adforest_get_ad_default_image_url('adforest-ad-related');
    $media = adforest_get_ad_images($row->comment_post_ID);
    if (count($media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID))
                $mid = $m->ID;
            else
                $mid = $m;

            $img = wp_get_attachment_image_src($mid, 'adforest-ad-related');
            $ad_img = $img[0];
            break;
        }
    }


    if (isset($row->comment_post_ID) && $row->comment_post_ID != "") {
        if ($turn == 1) {
            $title_html .= '<h2 class="padding-top-20 sb_ad_title" id="title_for_' . esc_attr($row->comment_post_ID) . '"><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
        } else {
            $title_html .= '<h2 class="padding-top-20 sb_ad_title no-display" id="title_for_' . esc_attr($row->comment_post_ID) . '" ><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
        }
    }


    $ad_id = $row->comment_post_ID;
    $comment_author = get_userdata($author);

    $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);
    $status = '';
    if ($msg_status == '0') {
        $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
    }

    $users .= '<li class="user_list ad_title_show ' . $cls . '" cid="' . $row->comment_post_ID . '" second_user="' . $author . '" inbox="yes" id="sb_' . $author . '_' . $ad_id . '" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">
					 <a href="javascript:void(0);">
						<div class="image"><img src="' . $ad_img . '" alt="' . $comment_author->display_name . '"></div>
						<div class="user-name">
						   <div class="author"><span>' . get_the_title($ad_id) . '</span></div>
						   <p>' . $comment_author->display_name . '</p>
						   <div class="time" id="' . $author . '_' . $ad_id . '">' . $status . '</div>
						</div>
					 </a>
				  </li>
';
    $authors = array($author, get_current_user_id());

    if ($turn == 1) {

        $block_user_html = '';

        // do_action('adforest_switch_language_code_from_id', $ad_id);
        $args = array(
            'author__in' => $authors,
            'post_id' => $ad_id,
            'parent' => get_current_user_id(),
            'post_type' => 'ad_post',
            'orderby' => 'comment_date',
            'order' => 'ASC',
        );

        $comments = get_comments($args);
        if (count($comments) > 0) {

            foreach ($comments as $comment) {
                $user_pic = '';
                $class = 'friend-message';
                if ($comment->user_id == get_current_user_id()) {
                    $class = 'my-message';
                }
                $user_pic = adforest_get_user_dp($comment->user_id);

                $images_meta = get_comment_meta($comment->comment_ID, 'comment_image_meta', true);
                $images_meta = $images_meta != "" ? unserialize($images_meta) : array();
                $images_html = "";
                $counter = 0;
                if (!empty($images_meta)) {
                    foreach ($images_meta as $attach_id) {
                        $img_src = wp_get_attachment_image_src($attach_id);
                        $images_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox = "gallery"><img src="' . $img_src[0] . '"></a>';
                        $counter++;
                    }
                }

                if ($counter > 4) {
                    $images_html .= '<div class="img_more">' . esc_html__('More', 'adforest') . '</div>';
                }

                $file_meta = get_comment_meta($comment->comment_ID, 'comment_file_meta', true);
                $file_meta = $file_meta != "" ? unserialize($file_meta) : array();
                $files_html = "";
                if (!empty($file_meta)) {
                    $files_html .= '<div>';
                    foreach ($file_meta as $attach_id) {
                        if (wp_attachment_is_image($attach_id)) {
                            $img_src = wp_get_attachment_image_src($attach_id);
                            $files_html .= '<a class="sb_msg_image" href="' . esc_url(wp_get_attachment_url($attach_id)) . '" data-fancybox="gallery"><img src="' . $img_src[0] . '"></a>';
                        } else {
                            $file_url = wp_get_attachment_url($attach_id);
                            $files_html .= '<a class="sb_msg_file" href="' . $file_url . '" target="_blank">' . basename(get_attached_file($attach_id)) . '</a>';
                        }
                    }
                    $files_html .= '</div>';
                }


                $messages .= '<li class="' . $class . ' clearfix"><figure class="profile-picture"><a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank"><img src="' . $user_pic . '" class="img-circle" alt="' . __('Profile Pic', 'adforest') . '"></a></figure><div class="message">' . $comment->comment_content . '' . $images_html . '
                                                                    ' . $files_html . '<div class="time"><i class="fa fa-clock-o"></i> ' . adforest_timeago($comment->comment_date) . '</div></div></li>';
            }
        }


        $allow_attachment = isset($adforest_theme['allow_media_upload_messaging']) ? $adforest_theme['allow_media_upload_messaging'] : false;

        $attachment_html = "";
        if ($allow_attachment) {
            $attachment_html = '<div id="attachment-wrapper" class="attachment-wrapper"></div>           
                                       <div class="file_attacher" id="file_attacher">
                                         <a href="javascript:void(0)" class="msgAttachFile dz-clickable"><i class="fa fa-link"></i>' . esc_html__('Add Attachment', 'adforest') . '</a>
                                         
                                         </div>                             
                                    ';
        }


        // Message form
     
        $level_2 = '<input type="hidden" name="usr_id" value="' . $user_id . '" id="user_id"/><input type="hidden" id="usr_id" value="' . $author . '" /><input type="hidden" id="rece_id" name="rece_id" value="' . $author . '" /><input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($author) . '" />';

        $block_user_html = apply_filters('adforest_blocked_button_html', $block_user_html, $author, $user_id);

        $verifed_phone_number = adforest_check_if_phoneVerified();
        if ($verifed_phone_number) {
            $form = '<div role="alert" class="alert alert-info alert-dismissible">' . __("Please verify your phone number to send a message.", "adforest") . ' 
                 </div>';
        } else {

            $form = '<form role="form" class="form-inline" id="send_message">
                             ' . $attachment_html . '
                             <div class="form-group">
                            
                                <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
                                <input type="hidden" name="name" value="' . $user_info->display_name . '" />
                                <input type="hidden" name="email" value="' . $user_info->user_email . '" />
							 ' . $level_2 . '
                                <input name="message" id="sb_forest_message" placeholder="' . __('Type a message here...', 'adforest') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . __('This field is required.', 'adforest') . '">
                             </div>
                             <button class="btn btn-theme" id="send_msg" type="submit" inbox="yes" sb_msg_token="' . wp_create_nonce('sb_msg_secure') . '">' . __('Send', 'adforest') . '</button>
                          </form>';
        }
    }
    $turn++;
}


if ($users == '') {
    $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . __('Nothing Found.', 'adforest') . '</div></li>';
}
echo adforest_returnEcho($script) . '<div class="content-wrapper"><div class="content"><div id="adforest_res">
               <div class="message-body row">
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="message-inbox">
                       <div class="message-header">
                          <h4>' . __('Ads', 'adforest') . '</h4>
                            <div class="message-tabs"> 
                           <span><a class="messages_actions active" sb_action="my_msgs"><small>' . __(' Sent Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="received_msgs_ads_list" href="javascript:void(0)"><small>' . __('Received Offers', 'adforest') . '</small></a></span>
                          <span><a class="messages_actions" sb_action="adforest_all_blocked_users" href="javascript:void(0)"><small>' . __('Blocked users', 'adforest') . ' </small></a></span>  
                            </div>   
                       </div>
                        <ul class="message-history">' . $users . '</ul>
                    </div>
                 </div>
                 <div class="col-md-8 clearfix col-sm-6 col-xs-12 message-content">
				 	' . $title_html . '
                    <div class="message-details">
                        ' . $block_user_html . '
                       <ul class="messages" id="messages">' . $messages . '</ul>
                       <div class="chat-form ">' . $form . '</div>
                    </div>
                 </div>
              </div>
           </div></div></div>';
}