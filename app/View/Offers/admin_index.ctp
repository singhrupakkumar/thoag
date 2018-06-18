<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Offers'); ?></h1>
                </div>

<div class="offers index">
	
        
    <div class="table-responsive">
	<table class="table table-bordered" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('res_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
                        <th><?php echo $this->Paginator->sort('name_ar'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($offers as $offer): ?>
	<tr>
		<td><?php echo h($offer['Offer']['id']); ?>&nbsp;</td>
		<td><?php echo h($offer['Restaurant']['name']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['name']); ?>&nbsp;</td>
                <td><?php echo h($offer['Offer']['name_ar']); ?>&nbsp;</td>
		<td><?php if(!empty($offer['Offer']['image'])){
                    $img_url = "../files/offers/". $offer['Offer']['image'];
                    echo $this->Html->image($img_url,array('alt'=>'Offer Image','style'=>'width:100px; height:100px;'));
                    }
                    
                    ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['end_date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $offer['Offer']['id']), array('class'=> 'view1 btn btn-default btn-xs fa fa-eye','title' => 'View')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $offer['Offer']['id']) , array('class'=> 'edit1 btn btn-default btn-xs fa fa-pencil','title' => 'Edit')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $offer['Offer']['id']), array('class'=> 'view1 btn btn-default btn-xs fa fa-trash-o','title' => 'Delete'), array(), __('Are you sure you want to delete # %s?', $offer['Offer']['id'])); ?>
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