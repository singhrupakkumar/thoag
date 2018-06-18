<div class="dishCategories form">
<?php echo $this->Form->create('Cuisine',array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Cuisine'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('required' => true));
                ?>
                <img src="<?php echo $this->webroot;?>files/catimage/<?php echo $this->request->data['Cuisine']['image']; ?>" width="100" height="100"/>
                <input type="hidden" value="<?php echo $this->request->data['Cuisine']['image']; ?>" name="data[Cuisine][img]"/>	
	<?php  
        
        echo $this->Form->input('image',array('type'=>'file'));

        ?>
       <img src="<?php echo $this->webroot;?>files/caticon/<?php echo $this->request->data['Cuisine']['icon']; ?>" width="50" height="50"/>
       <input type="hidden" value="<?php echo $this->request->data['Cuisine']['icon']; ?>" name="data[Cuisine][ion]"/>	         
        <?php 
        
        echo $this->Form->input('icon',array('type'=>'file')); 

        ?>        
                
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>


<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cuisine.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Cuisine.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cuisine'), array('action' => 'index')); ?></li>
	
	</ul>
</div>
