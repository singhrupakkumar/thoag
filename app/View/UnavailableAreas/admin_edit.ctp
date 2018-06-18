<div class="offers form">
<?php echo $this->Form->create('Offer', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Offer'); ?></legend>
	<?php
		echo $this->Form->input('res_id',array("selected"=>$this->request->data['Offer']['res_id'],"options"=>$restaurant_list));
		echo $this->Form->input('title');
		echo $this->Form->input('description');
                if($this->request->data['Offer']['image']){
                    $img_url = "../files/offers/". $this->request->data['Offer']['image'];
                    echo $this->Html->image($img_url,array('alt'=>'Offer Image','style'=>'width:100px; height:100px;'));
                    echo $this->Form->input('old_image', array('type' => 'hidden','value'=>$this->request->data['Offer']['image']));
                    
                }
		echo $this->Form->input('image', array('type' => 'file'));
                echo $this->Form->input('price',array('type'=>'number'));
                echo $this->Form->input('quantity',array('type'=>'number'));
                echo $this->Form->input('start_date',array('type'=>'date'));
                echo $this->Form->input('end_date',array('type'=>'date'));
                if($this->request->data['Offer']['catering']==1){
                    echo $this->Form->input('catering',array('type'=>'checkbox','checked'=>'checked'));
                }else{
                    echo $this->Form->input('catering',array('type'=>'checkbox'));
                }
                
                if($this->request->data['Offer']['delivery']==1){
                    echo $this->Form->input('delivery',array('type'=>'checkbox','checked'=>'checked'));
                }else{
                    echo $this->Form->input('delivery',array('type'=>'checkbox'));
                }
                
                if($this->request->data['Offer']['pickup']==1){
                    echo $this->Form->input('pickup',array('type'=>'checkbox','checked'=>'checked'));
                }else{
                    echo $this->Form->input('pickup',array('type'=>'checkbox'));
                }
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

