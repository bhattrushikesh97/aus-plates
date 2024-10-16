<?php ?>    
<div class="content-wrapper">
    <div class="content">
        <div class="sb-dash-heading">
            <h2>

                <?php echo esc_html__('My Ads', 'adforest'); ?>
            </h2>
        </div>
        <div class="row">
            <?php
            echo apply_filters('adforest_pro_get_booked_ads_list', '');
            ?>
            <div class="modal fade" id="ad-booking-modal" tabindex="-1" aria-labelledby="ad-booking-modal" aria-hidden="true">
                <div class="modal-dialog">   
                    <div class="modal-content"  id = "ad-booking-content" >

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>