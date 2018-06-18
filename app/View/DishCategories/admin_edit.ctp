<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Dish Category'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">
				<?php echo $this->Form->create('DishCategory',array('type'=>'file')); ?>
				<div class="page_content">
					<div class="restaurants index">
						<?php
							echo $this->Form->input('id');
							echo $this->Form->input('name',array('required' => true));
                			echo $this->Form->input('name_ar',array('required' => true));
                		?>
                		<img src="<?php echo $this->webroot;?>files/catimage/<?php echo $this->request->data['DishCategory']['image']; ?>" width="100" height="100"/>
                		<input type="hidden" value="<?php echo $this->request->data['DishCategory']['image']; ?>" name="data[DishCategory][img]"/>	
						<?php
							echo $this->Form->input('image',array('type'=>'file', 'class'=>'form-control'));
        				?>
        				<img src="<?php echo $this->webroot;?>files/caticon/<?php echo $this->request->data['DishCategory']['icon']; ?>" width="50" height="50"/>
       					<input type="hidden" value="<?php echo $this->request->data['DishCategory']['icon']; ?>" name="data[DishCategory][ion]"/>
       					<?php
        				echo $this->Form->input('icon',array('type'=>'file', 'class'=>'form-control')); 
        				?> 
					</div>
				</div>
				<?php echo $this->Form->submit(__('Submit',true), array('class'=>'btn btn-primary'));  ?>
			</div>
		</div>
	</div>
</section>