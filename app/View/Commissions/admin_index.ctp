<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Commission</h1>
                </div>
                <div class="page_content">
                    
                    <div class="btn-toolbar list-toolbar">
                           <div class="col-lg-2">
                            <?php     
                            echo $this->Form->create('Commission',array('controller'=>'commissions','action'=>'index'));
                            echo $this->Form->input('restaurant_id', array(
                            'empty'=>'Select Restaurant',
                                'label' => false,
                                'class' => 'form-control',
                                'options' => $restaurants,
                                'selected' => $all['restaurant_id']
                            ));
                            ?>
                        </div> 
                        
                        <div class="col-lg-4">
                            <?php echo $this->Form->button('Search', array('class' => 'btn btn-danger')); ?>
                            &nbsp; &nbsp;
                    <?php echo $this->Html->link('Reload', array('controller' => 'commissions', 'action' => 'reset', 'admin' => true), array('class' => 'btn btn-default')); ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                        
                    </div><!-- Button Group End Here -->
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('ID'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Store Name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Locality'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Commission'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commissions as $commission): ?>
                                    <tr>
                                        <td><?php echo h($commission['Commission']['id']); ?></td>
                                        <td><?php echo $commission['Restaurant']['name']; ?></td>
                                        <td><?php echo h($commission['Restaurant']['address']); ?></td>
                                        <td><?php echo h($commission['Commission']['commission'])."%"; ?></td>
                                        <td><?php echo h($commission['Commission']['created']); ?></td>
                                        <td class="actions">
                                                <?php echo $this->Html->link('', array('action' => 'view', $commission['Commission']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>
                                                <?php echo $this->Html->link('', array('action' => 'edit', $commission['Commission']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil','title'=>'Edit')); ?>
                                                <?php echo $this->Form->postLink((''), array('action' => 'delete', $commission['Commission']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash-o','href'=>''), __('Are you sure you want to delete # %s?', $commission['Commission']['id'])); ?>
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