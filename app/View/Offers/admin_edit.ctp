
<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Offer'); ?></h1>
                </div>
            </div>
<div class="col-md-5">
<div class="offers form">
<?php echo $this->Form->create('Offer', array('type' => 'file')); ?>
	<fieldset>

	<?php
		echo $this->Form->input('res_id',array('class'=> 'select-style form-control',"selected"=>$this->request->data['Offer']['res_id'],"options"=>$restaurant_list));
		echo $this->Form->input('name');
                echo $this->Form->input('name_ar',array('label'=>'Name in Arabic'));

		echo $this->Form->input('description',array('class'=>'form-control'));
                echo $this->Form->input('description_ar',array('class'=>'form-control','label'=>'Description in Arabic'));
                if($this->request->data['Offer']['image']){
                    $img_url = "../files/offers/". $this->request->data['Offer']['image'];
                    echo $this->Html->image($img_url,array('alt'=>'Offer Image','style'=>'width:100px; height:100px;'));

                    echo $this->Form->input('old_image', array('class'=>'form-control','type' => 'hidden','value'=>$this->request->data['Offer']['image']));
                    
                }
		        echo $this->Form->input('image', array('class'=>'form-control','type' => 'file'));
                echo $this->Form->input('price',array('class'=>'form-control','type'=>'number'));
                echo $this->Form->input('quantity',array('class'=>'form-control','type'=>'number'));
                echo $this->Form->input('start_date',array('class'=>'form-control','type'=>'date'));
                echo $this->Form->input('end_date',array('class'=>'form-control','type'=>'date'));
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
<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); 
  ?>
</div>
</div>

</div>
        </div>
    </div>
</section>
<style type="text/css">
    .input.date select{
        width: auto;
        display: inline-block;
    }
</style>
