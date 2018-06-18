<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Unavailable Areas'); ?></h1>
                </div>


<div class="offers index">
	
        
    <div class="table-responsive">
	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('area'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($UnavailableAreas as $area): ?>
	<tr>
		<td><?php echo h($area['UnavailableArea']['id']); ?>&nbsp;</td>
		<td><?php echo h($area['UnavailableArea']['city']); ?>&nbsp;</td>
		<td><?php echo h($area['UnavailableArea']['area']); ?>&nbsp;</td>
		<td><?php echo h($area['UnavailableArea']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $area['UnavailableArea']['id']), array('class'=> 'view1 btn btn-default btn-xs fa fa-eye', 'title' => 'View')); ?>
			<?php //echo $this->Html->link(__(''), array('action' => 'edit', $area['UnavailableArea']['id']) , array('class'=> 'edit1 btn btn-default btn-xs fa fa-pencil', 'title' => 'Edit')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $area['UnavailableArea']['id']), array('class'=> 'view1 btn btn-default btn-xs fa fa-trash-o', 'title' => 'Delete'), array(), __('Are you sure you want to delete # %s?', $area['UnavailableArea']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
    </div>
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


		</div>
        </div>
    </div>
</section>

<style type="text/css">
.offers.index {
    float: left;
    width: 100%;
}



</style>