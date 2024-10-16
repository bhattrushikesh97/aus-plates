<?php
$current_id = get_current_user_id();

$ad_alerts = sb_get_ad_alerts($current_id);

$alerts_html = "";
$count = 0;

if (is_array($ad_alerts) && !empty($ad_alerts)) {    
    foreach($ad_alerts  as $key => $val) {
       $count ++ ; 
       $alert_name   =    isset($val['alert_name'])  ?  $val['alert_name']  :  "";
       $cat_id   =   isset($val['alert_category'])  ?   $val['alert_category']   :  "";             
       $terms     =   get_term_by('id', $cat_id, 'ad_cats');
       $term_name =   isset($terms->name)  ?  $terms->name   :  "";  
       $alerts_html .= '<tr>
  
<td id="'.$key.'">'.$count.'</td>
    <td>
        <a class="text-dark" href="">'.$alert_name.'</a>
    </td>
    <td class="d-none d-lg-table-cell">'.$term_name.'</td>
    <td>
       <a href="javascript:void(0)"  data-value =  '.$key.'  class="badge badge-danger del_save_alert"> <span>'.esc_html__('Delete','adforest').'</span>
    </td>
</tr>';
}

    }
?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">

                <!-- Recent Order Table -->
                <div class="card card-table-border-none recent-orders" id="recent-orders">
                    <div class="card-header justify-content-between">
                        <h2><?php echo esc_html__('Subscribed Alerts','adforest'); ?></h2>

                    </div>
                    <div class="card-body pt-0 pb-5">
                        <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo esc_html__('Alert name','adforest'); ?></th>
                                    <th class="d-none d-lg-table-cell"><?php echo esc_html__('Category','adforest'); ?></th>
                                    <th class="d-none d-lg-table-cell"><?php echo esc_html__('Action','adforest'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php echo adforest_returnEcho($alerts_html); ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>









    </div> <!-- End Content -->
</div>