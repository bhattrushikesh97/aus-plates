<?php global $adforest_theme ;
$allow_events  =  $adforest_theme['allow_event_create']   ?   $adforest_theme['allow_event_create']   : false; 
  if(!$allow_events){
      return ;
  }
  ?>
<div class="content-wrapper">
    <div class="content">
        <?php
        echo apply_filters('events_stats', '');
        ?>

        <div class="row">
            <div class="content">
                <div class="sb-dash-heading">
                    <h2>
                        <?php echo esc_html__('Pending Events', 'adforest'); ?>
                    </h2>
                </div>
                <div class="row">
                    <?php
                    echo apply_filters('sb_get_event_list', 'pending');
                    ?> 

                </div>
            </div>

        </div>
    </div>
</div>
