<div class="content">
    <div class="header">

        <h1 class="page-title"><?php echo __('Cuisines'); ?></h1>
        <ul class="breadcrumb">
            <li class="active"><?php echo __('Cuisines'); ?></li>
        </ul>

    </div>
    <div class="main-content">
            <?php $x = $this->Session->flash(); ?>
            <?php if ($x) { ?>
            <div class="alert success">
                <span class="icon"></span>
                <strong></strong><?php echo $x; ?>
            </div>
        <?php } ?>
        <div class="btn-toolbar list-toolbar">

            <div class="btn-group">            </div>
        </div>

<div class="dishCategories index">
	<h2><?php echo __('Cuisines'); ?></h2>
        <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('Image'); ?></th>
            <th><?php echo $this->Paginator->sort('Icon'); ?></th>
                        
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($cuisine as $city): ?>
	<tr>
		<td><?php echo h($city['Cuisine']['id']); ?>&nbsp;</td>
		<td><?php echo h($city['Cuisine']['name']); ?>&nbsp;</td>
                  <td><img src="<?php echo $this->webroot ?>/files/catimage/<?php echo h($city['Cuisine']['image']); ?>" width="100px" height="100px"/>&nbsp</td>
                  <td><img src="<?php echo $this->webroot ?>/files/caticon/<?php echo h($city['Cuisine']['icon']); ?>" width="50px" height="50px"/>&nbsp</td> 
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $city['Cuisine']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $city['Cuisine']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $city['Cuisine']['id']), array(), __('Are you sure you want to delete # %s?', $city['Cuisine']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
