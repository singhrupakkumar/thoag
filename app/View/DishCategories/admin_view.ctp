<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Dish Category'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
	                	<div class="restaurants index">
	                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
	                            <thead>
	                                <tr>
	                                    <th><?php echo __('Id'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['id']); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Name'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['name']); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Name in arabic'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['name_ar']); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Image'); ?></th>
	                                    <td><img src="<?php echo $this->webroot.'files/catimage/'. $dishCategory['DishCategory']['image']; ?>" width="100" height="100"/></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Icon'); ?></th>
	                                    <td><?php echo $this->Html->image('/files/caticon/'.$dishCategory['DishCategory']['icon'], array('alt' => 'icon',"style"=>'width:50px; height:50px;')); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Created'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['created']); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Modified'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['modified']); ?></td>
	                                </tr>
	                                <tr>
	                                    <th><?php echo __('Status'); ?></th>
	                                    <td><?php echo h($dishCategory['DishCategory']['status']); ?></td>
	                                </tr>
	                            </thead>
	                        </table>
	                    </div><!-- End Here -->
                	</div>
            	</div>
        </div>
    </div>
</section>