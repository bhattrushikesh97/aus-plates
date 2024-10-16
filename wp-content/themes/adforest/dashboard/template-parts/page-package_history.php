<?php
 $args = array(
            'customer_id' => get_current_user_id(),
        );
 $history_html   =  "";
 $orders = wc_get_orders($args);
        if (count((array) $orders) > 0) {
            foreach ($orders as $order) {
                $items = $order->get_items();
                $product_name = '';
                foreach ($items as $item) {
                    $product_name .= $item->get_name() . ',';
                }

                $history_html .= '<tr class="row-content">
                           <td></td>
			   <td>' . $order->get_id() . '</td>
			   <td>' . rtrim($product_name, ',') . '</td>
			   <td> <span class="label label-default"> ' . wc_get_order_status_name($order->get_status()) . ' </span></td>
			   <td>' . date_i18n(get_option('date_format'), strtotime($order->get_date_created())) . '</td>
			   <td>' . $order->get_total() . '</td>
			</tr>';
            }
        } else {
            $history_html .= '<td colspan="5">' . __('There is no order history found.', 'adforest') . '</td>';
        }
?>
<div class="main">    
  <main class="content my_ads">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3"><?php echo esc_html__('My Ads', 'adforest') ?></h1>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo esc_html__('My Ads','adforest') ?></h4>
                            <div class="table-responsive custom-tabel-label">
                                <table class="custom-tabel">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><?php echo esc_html__('Order #','adforest') ?></th>
                                            <th><?php echo esc_html__('Package(s)','adforest') ?></th>
                                            <th><?php echo esc_html__('Status','adforest') ?></th>
                                            <th><?php echo esc_html__('Date','adforest') ?></th>
                                            <th><?php echo esc_html__('Order total','adforest') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                      echo  $history_html;
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>