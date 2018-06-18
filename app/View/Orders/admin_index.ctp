<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Orders</h1>
                </div>
                <div class="page_content">
                    <div class="btn-toolbar list-toolbar">
                        <?php
                         if($loggedUserRole!='rest_admin'){ //print_r($orders); exit;
                        echo $this->Form->create('Order', array());
                        ?>
                        <div class="col-lg-2"> 
<?php echo $this->Form->input('restaurant_id', ['options' => $res, 'label' => false, 'class' => 'form-control', 'empty' => 'Choose Store','selected' => $all['restaurant_id']]); ?>
    </div>
    <div class="col-lg-2">
        <?php        
        echo $this->Form->input('filter', array(
            'label' => false,
            'class' => 'form-control',
            'options' => array(
                'id' => 'Order ID',
                'phone' => 'Phone',
                'name' => 'Name',
            ),
            'selected' => $all['filter']
        ));
        ?>
    </div>    
      <div class="col-lg-2">
        <?php  
        echo $this->Form->input('type', array(
            'label' => false,
            'class' => 'form-control',
            'options' => array(  
                 "3" => 'PickUp',
                 "2" => 'Delivery',
                 "1" => 'Catering',
            ),'empty' => 'Choose Order Type',
            'selected' => $all['type']
        ));
        ?>
    </div>
    <div class="col-lg-2">
<?php echo $this->Form->input('name', array('label' => false,'placeholder'=>'Enter Filter Value', 'id' => false, 'class' => 'form-control', 'value' => $all['name'])); ?>
    </div>
    <!--div class="col-lg-2">
        <input type="date" name="data[Order][date]" value=""/>
        
    </div>
     <div class="col-lg-2">
         <input type="date" name="data[Order][date1]" value=""/>
    </div-->
    <div class="col-lg-4">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-danger')); ?>
        &nbsp;
<?php echo $this->Html->link('Reload', array('controller' => 'orders', 'action' => 'reset', 'admin' => true), array('class' => 'btn btn-default')); ?>
</div>
    <?php }?>
                    </div><!-- Button Group End Here -->
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th><?php echo $this->Paginator->sort('Order ID'); ?></th>
            <th><?php echo $this->Paginator->sort('Store Name'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('email'); ?></th>
            <th><?php echo $this->Paginator->sort('phone'); ?></th>
            <th><?php echo $this->Paginator->sort('Order Type'); ?></th>
            <th><?php echo $this->Paginator->sort('subtotal'); ?></th>
            <th><?php echo $this->Paginator->sort('total'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th>Actions</th>
        </tr>
<?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo h($order['Order']['id']); ?></td>
                <td><?php echo h($order['Restaurant']['name']); ?></td>
                <td><?php echo h($order['Order']['name']); ?></td>
                <td><?php echo h($order['Order']['email']); ?></td>
                <td><?php echo h($order['Order']['phone']); ?></td>
                <td><?php if ($order['Order']['delivery_status'] == 1) {
        echo "Catering";
    } else if ($order['Order']['delivery_status'] == 2) {
        echo "Delivery";
    } else if ($order['Order']['delivery_status'] == 3) {
        echo "Pickup";
    } ?></td>
    <!--                <td><?php //echo h($order['Order']['billing_city']);  ?></td>
                <td><?php //echo h($order['Order']['billing_zip']);  ?></td>
                <td><?php //echo h($order['Order']['billing_state']);  ?></td>
                <td><?php //echo h($order['Order']['billing_country']);  ?></td>
                <td><?php //echo h($order['Order']['shipping_city']);  ?></td>
                <td><?php //echo h($order['Order']['shipping_zip']);  ?></td>
                <td><?php //echo h($order['Order']['shipping_state']);  ?></td>
                <td><?php //echo h($order['Order']['shipping_country']);  ?></td>
                <td><?php //echo h($order['Order']['weight']);  ?></td>-->
                <td><?php echo h($order['Order']['subtotal']); ?></td>
    <!--                <td><?php //echo h($order['Order']['tax']); ?></td>
                <td><?php //echo h($order['Order']['shipping']);  ?></td>-->
                <td><?php echo h($order['Order']['total']); ?></td>
    <!--                <td><?php //echo h($order['Order']['status']);  ?></td>-->
                <td><?php echo h($order['Order']['created']); ?></td>
                <td class="actions">
                        <?php echo $this->Html->link('', array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>

                        <?php //echo $this->Html->link('', array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil', 'title'=>'Edit')); ?>
                        <select name="dlsts" class="dlsts">
                            <?php foreach($OrderStatus as $status){
                                if($status['OrderStatus']['id']==$order['Order']['order_status']){ ?>
                                <option selected="selected" value="<?php echo $order['Order']['uid'] . '-' .$status['OrderStatus']['id'].'-'.$order['Order']['id']; ?>"><?php echo $status['OrderStatus']['status']; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $order['Order']['uid'] . '-' . $status['OrderStatus']['id'].'-'.$order['Order']['id']; ?>"><?php echo $status['OrderStatus']['status']; ?></option>
                               <?php }
                               } ?>
                        </select>
                </td>
            </tr>
<?php endforeach; ?>
    </table>
                    </div><!-- End Here -->
        <div class="bottom_button">
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>
        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(".dlsts").change(function () {
        var a = $(this).val();
        $.post('http://rajdeep.crystalbiltech.com/thoag/admin/orders/dlstas', {id: a}, function (d) {
            console.log(d);
        });
        //alert(a);
    });
</script>