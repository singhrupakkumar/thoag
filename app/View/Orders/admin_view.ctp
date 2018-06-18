<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Order</h1>
                </div>
            </div>
                <div class="page_content">
                <div class="col-sm-5">
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <td><?php echo h($order['Order']['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Restaurant Name</th>
                                    <td><?php echo h($order['Restaurant']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo h($order['Order']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo h($order['Order']['email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><?php echo h($order['Order']['phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Recipent Mobile</th>
                                    <td><?php echo h($order['Order']['recipent_mobile']); ?></td>
                                </tr>


                                 <tr>
                                    <th>Billing Address</th>
                                    <td><?php echo h($order['Order']['billing_address']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Social Responsible</th>
                                    <td><?php echo h($order['Order']['social_responsible']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Demand for waiter</th>
                                    <td><?php echo h($order['Order']['demand_waiter']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Demand for waitress</th>
                                    <td><?php echo h($order['Order']['demand_waitress']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Order Notes</th>
                                    <td><?php echo h($order['Order']['notes']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Order Type</th>
                                    <td><?php if ($order['Order']['delivery_status'] == 1) {
                                            echo "Catering";
                                        } else if ($order['Order']['delivery_status'] == 2) {
                                            echo "Delivery";
                                        } else {
                                            echo "Pickup";
                                        } ?></td>
                                </tr>
                                <?php if($order['Order']['event_datetime']){ ?>
                                <tr>
                                    <th>Delivery Date</th>
                                    <td><?php echo date("d M,Y H:i A",strtotime($order['Order']['event_datetime'])) ?></td>
                                </tr>
                                <?php } ?>
                                 <tr>
                                    <th>Order Item Count</th>
                                    <td><?php echo h($order['Order']['order_item_count']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Subtotal</th>
                                    <td><?php echo h($order['Order']['subtotal']); ?></td>
                                </tr>
                                 <tr>
                                    <th>Discount Percentage</th>
                                    <td><?php echo h($order['Order']['discount_percentage'])."%"; ?></td>
                                </tr>
                                 <tr>
                                    <th>Total</th>
                                    <td><?php echo h($order['Order']['total']); ?></td>
                                </tr>




                                <tr>
                                    <th>Order Type</th>
                                    <td><?php echo h($order['Order']['order_type']); ?></td>
                                </tr>
                                <?php if($order['Order']['order_type'] == "paypal"){ ?>
                                <tr>
                                    <th>Paypal Status</th>
                                    <td><?php echo h($order['Order']['payment_status']); ?></td>
                                </tr>
                                <tr>
                                    <th>Paypal Transaction Id</th>
                                    <td><?php echo h($order['Order']['transaction_id']); ?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($order['Order']['order_type'] == "payfort"){ ?>
                                <tr>
                                    <th>Payfort Status</th>
                                    <td><?php echo h($order['Order']['payment_status']); ?></td>
                                </tr>
                                <tr>
                                    <th>Payfort Transaction Id</th>
                                    <td><?php echo h($order['Order']['transaction_id']); ?></td>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th>Order Status</th>
                                    <td><?php echo h($order['OrderStatus']['status']); ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td><?php echo h($order['Order']['created']); ?></td>
                                </tr>
                                <tr>
                                    <th>Modified</th>
                                    <td><?php echo h($order['Order']['modified']); ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- End Here -->
                </div>
            </div>



                            <div class="page_content">
                <div class="col-sm-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Contents of Order</h1>
                </div>
                    <div class="restaurants index">
                    <?php if (!empty($order['OrderItem'])):
                    ?>
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
        <th>Id</th>
        <th>Order Id</th>
        <th>Product Id</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th>Created</th>
        <th>Modified</th>
        <th>Actions</th>
    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['OrderItem'] as $orderItem): ?>
    <tr>
        <td><?php echo $orderItem['id']; ?></td>
        <td><?php echo $orderItem['order_id']; ?></td>
        <td><?php if($orderItem['product_id'] == ''){
                echo $orderItem['offer_id'];
            }else{
                echo $orderItem['product_id'];
            }
            
            ?></td>
        <td><?php echo $orderItem['name']; ?></td>
        <td><?php echo $orderItem['quantity']; ?></td>
        <td><?php echo $orderItem['price']; ?></td>
        <td><?php echo $orderItem['subtotal']; ?></td>
        <td><?php echo $orderItem['created']; ?></td>
        <td><?php echo $orderItem['modified']; ?></td>
        <td>
            <?php
                echo $this->Html->link('', array('controller' => 'order_items', 'action' => 'view', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View'));
             ?>
            
            <?php //echo $this->Html->link('', array('controller' => 'order_items', 'action' => 'view', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>

            <?php //echo $this->Html->link('', array('controller' => 'order_items', 'action' => 'edit', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil','title'=>'Edit')); ?>
            <?php //echo $this->Form->postLink('', array('controller' => 'order_items', 'action' => 'delete', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-trash','title'=>'Delete'), __('Are you sure you want to delete # %s?', $orderItem['id'])); ?>

        </td>
    </tr>
    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>