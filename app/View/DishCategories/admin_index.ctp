<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Dish Categories'); ?></h1>
                </div>
                <div class="page_content">
                    <?php $x = $this->Session->flash(); ?>
            		<?php if ($x) { ?>
		            <div class="alert success">
		                <span class="icon"></span>
		                <strong></strong><?php echo $x; ?>
		            </div>
        			<?php } ?>

                    <?php //echo $this->Form->create('Restaurant', array("action" => "deleteall", 'id' => 'mbc')); ?>
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
									<th><?php echo $this->Paginator->sort('name'); ?></th>
									<th><?php echo $this->Paginator->sort('name_ar'); ?></th>
			                        <th><?php echo $this->Paginator->sort('Image'); ?></th>
			                        <th><?php echo $this->Paginator->sort('Icon'); ?></th>
									<th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dishCategories as $dishCategory): ?>
                                <tr>
                                    <td><?php echo h($dishCategory['DishCategory']['id']); ?>&nbsp;</td>
									<td><?php echo h($dishCategory['DishCategory']['name']); ?>&nbsp;</td>
									<td><?php echo h($dishCategory['DishCategory']['name_ar']); ?>&nbsp;</td>
							        <td><img src="<?php echo $this->webroot ?>/files/catimage/<?php echo h($dishCategory['DishCategory']['image']); ?>" width="100px" height="100px"/>&nbsp</td>
							        <td><img src="<?php echo $this->webroot ?>/files/caticon/<?php echo h($dishCategory['DishCategory']['icon']); ?>" width="50px" height="50px"/>&nbsp</td> 
									<td class="actions">
										<?php echo $this->Html->link(__(''), array('action' => 'view', $dishCategory['DishCategory']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye', 'title' => 'View')); ?>
                                                                                <?php if($loggedin['role']=='admin'){ ?>
										<?php echo $this->Html->link(__(''), array('action' => 'edit', $dishCategory['DishCategory']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil', 'title' => 'Edit')); ?>
                                                                              
										  <?php echo $this->Form->postLink('', array('action' => 'delete', $dishCategory['DishCategory']['id']), array('class' => 'btn btn-default btn-xs fa fa-trash','title'=>'Delete'), __('Are you sure you want to delete # %s?', $dishCategory['DishCategory']['id'])); ?>										
									
										  <?php } ?>
								</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- End Here -->
                    <p>
						<?php
						echo $this->Paginator->counter(array(
							'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
						));
						?>	
					</p>
					<div class="paging">
						<?php
							echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => ''));
							echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
						?>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>