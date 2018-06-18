<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Disputes</h1>
                </div>
                <div class="page_content">
                    <?php
                     if($loggedUserRole!='rest_admin'){ //print_r($orders); exit;
                    echo $this->Form->create('Dispute', array());
                    ?>
                    <div class="btn-toolbar list-toolbar">
                        <!--    <div class="col-lg-2">
                            <?php        
                            echo $this->Form->input('filter', array(
                                'label' => false,
                                'class' => 'form-control',
                                'options' => array(
                                    'id' => 'Order ID',
                                    'phone' => 'Phone',
                                    'first_name' => 'First Name',
                                    'last_name' => 'Last Name',
                                ),
                                'selected' => $all['filter']
                            ));
                            ?>
                        </div>    
                        <div class="col-lg-2">
                    <?php echo $this->Form->input('name', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' => $all['name'])); ?>
                        </div>
                        
                        <div class="col-lg-4">
                            <?php echo $this->Form->button('Search', array('class' => 'btn btn-danger')); ?>
                            &nbsp; &nbsp;
                    <?php echo $this->Html->link('Reload', array('controller' => 'orders', 'action' => 'reset', 'admin' => true), array('class' => 'btn btn-default')); ?>
                        </div><br/><br/>-->
                    </div><!-- Button Group End Here -->
                    <?php }?>
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Dispute ID'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Store Name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Order Id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('User name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('message'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($disputes as $dispute): ?>
                                <tr>
                                    <td><?php echo h($dispute['Dispute']['id']); ?></td>
                                    <td><?php echo h($dispute['Order']['Restaurant']['name']); ?></td>
                                    <td><?php echo h($dispute['Dispute']['order_id']); ?></td>
                                    <td><?php echo h($dispute['User']['name']); ?></td>
                                    <td><?php echo h($dispute['Dispute']['message']); ?></td>
                                    <td><?php echo h($dispute['Dispute']['created']); ?></td>
                                    <td class="actions">
                                            <?php echo $this->Html->link('', array('action' => 'view', $dispute['Dispute']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>
                                            <?php //echo $this->Html->link('', array('action' => 'edit', $dispute['Dispute']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil','title'=>'Edit')); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
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