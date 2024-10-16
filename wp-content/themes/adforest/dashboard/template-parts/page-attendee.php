<?php
$event_id = isset($_GET['id']) ? $_GET['id'] : "";
$user_id = get_current_user_id();
$all_attendees = get_post_meta($event_id, 'attending_users', true);
if (is_array($all_attendees) && !empty($all_attendees)) {
    $attendee_html = "";
    foreach ($all_attendees as $user) {
        $user_info = get_userdata($user);
        $poster_name = $user_info->display_name;
        $user_pic = adforest_get_user_dp($poster_id);
        $user_address = get_user_meta($poster_id, '_sb_address', true);

        $attendee_html .= '<div class ="col-3">
                                        <div class="attendee-container">
                                            <div class="attendee_avatr">
                                                <img src="' . $user_pic . '">
                                            </div>
                                            <div class="attendee_avatr">
                                                <a href=' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '>' . $poster_name . '</a>                                       
                                            </div>
                                      </div>
                             </div>';
    }
?>
<div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
            <h2><?php echo esc_html__('Attendees', 'sb_pro'); ?> </h2>
            <div class="row">
                <?php echo $attendee_html ?> 
            </div>
        </div>

    </div>
</div>
<?php 
}


else {
    
    $ads_list = '<div class="col-lg-12"><div class="card "><div class="card-body">

            <div class="alert alert-primary no-found-alert" role="alert">
                ' . esc_html__('No Result Found for the following', 'adforest') . '
            </div></div></div></div>';
?>  
 
   <div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
            <h2><?php echo esc_html__('Attendees', 'sb_pro'); ?> </h2>
            <div class="row">
                <?php echo $ads_list ?> 
            </div>
        </div>
    </div>
</div>
<?php }

?>

