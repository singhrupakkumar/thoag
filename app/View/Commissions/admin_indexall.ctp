<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Commission Reports</h1>
                </div>
                <div class="page_content">
                    <div class="btn-toolbar list-toolbar">
                         <?php 
                            echo $this->Form->create('Order', array()); ?>
                            <div class="col-lg-2"> 
                             <?php echo $this->Form->input('restaurant_id', ['options' => $restaurants, 'label' => false, 'class' => 'form-control', 'empty' => 'Choose Restaurant','selected'=>$all['restaurant_id']]); ?>   
</div>
    <div class="col-lg-2">
        
        <input type="date" class="form-control" placeholder="DD/MM/YY" name="data[Order][date]" value="<?php echo $all['date']; ?>" /> 
    </div>
    <div class="col-lg-2">
        
         <input type="date" class="form-control" placeholder="DD/MM/YY" name="data[Order][date1]" value="<?php echo $all['date1']; ?>"/>
    </div>   
   <div class="col-lg-4">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-danger')); ?>
        <?php echo $this->Html->link('View All', array('controller' => 'commissions', 'action' => 'indexall', 'admin' => true), array('class' => 'btn btn-default')); ?>
         <?php //echo $this->Html->link('Download All Report', array('controller' => 'tests', 'action' => 'dowloadexcel','admin' => false), array('class' => 'btn btn-danger')); ?>
    </div>
                    </div><!-- Button Group End Here -->
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Store Name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Locality'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Total Orders'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Total Amount'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Commission(%)'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Admin Commission'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Accept Payment Through'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Caterer Payment'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($final as $order): ?>
                                    <tr>
                                        <td><?php echo h($order['restaurant']['name']); ?></td>
                                        <td><?php echo h($order['restaurant']['address']); ?></td>
                                        <td><?php echo h($order['order_total_count']); ?></td> 
                                        <td><?php echo h($order['order_total_amount']); ?></td> 
                                        <td><?php echo h($order['commission_percentage']); ?></td> 
                                        <td><?php echo h($order['admin_commission']); ?></td>
                                        <td>
                                        <?php if($order['caterer']['accept_payment']=='paypal'){ ?>
                                        <?php echo h($order['caterer']['accept_payment']).": ".$order['caterer']['paypal_email']; ?>
                                        <?php } ?>
                                        <?php if($order['caterer']['accept_payment']=='payfort'){ ?>
                                        <?php echo h($order['caterer']['accept_payment']).": ".$order['caterer']['payfort_email']; ?>
                                        <?php } ?>
                                        </td>
                                        <td><?php echo h($order['caterer_amount']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>