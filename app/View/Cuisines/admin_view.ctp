<div class="cities view">
<h2><?php echo __('Cuisine'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cuisine['Cuisine']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cuisine Name'); ?></dt>
		<dd>
			<?php echo h($cuisine['Cuisine']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
                    
        <img src="<?php echo $this->webroot;?>files/catimage/<?php echo h($cuisine['Cuisine']['image']); ?>" width="100" height="100"/>  
			
			&nbsp;
		</dd>
		<dt><?php echo __('Icon'); ?></dt>
		<dd>
                    
              <img src="<?php echo $this->webroot;?>files/caticon/<?php echo h($cuisine['Cuisine']['icon']); ?>" width="50" height="50"/>          
			
			&nbsp;
		</dd>
	
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cuisine'), array('action' => 'edit', $cuisine['Cuisine']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cuisine'), array('action' => 'delete', $cuisine['Cuisine']['id']), array(), __('Are you sure you want to delete # %s?', $cuisine['Cuisine']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cuisine'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cuisine'), array('action' => 'add')); ?> </li>
		
	</ul>
</div>
