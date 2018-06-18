<div class="cities form">
<?php echo $this->Form->create('Cuisine',array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Cuisine'); ?></legend>
	<?php
		echo $this->Form->input('name');
		 echo $this->Form->input('image',array('type'=>'file','required' => true));
                
                echo $this->Form->input('icon',array('type'=>'file','required' => true)); 
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cuisine'), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		
	</ul>
</div>
