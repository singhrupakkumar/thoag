<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Add Offer'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<?php echo $this->Form->create('Offer', array('type' => 'file')); ?>
                    		<?php
								echo $this->Form->input('res_id',array('options'=>$restaurant_list,'class'=>'form-control'));
								echo $this->Form->input('name',array('class'=>'form-control'));
                                                                echo $this->Form->input('name_ar',array('class'=>'form-control','label'=>'Title in Arabic'));
								echo $this->Form->input('description',array('class'=>'form-control'));
                                                                echo $this->Form->input('description_ar',array('class'=>'form-control','label'=>'Description in Arabic'));
								echo $this->Form->input('image',array('type'=>'file','class'=>'form-control'));
						                echo $this->Form->input('price',array('type'=>'number','class'=>'form-control'));
						                echo $this->Form->input('quantity',array('type'=>'number','class'=>'form-control'));
						                echo $this->Form->input('start_date',array('type'=>'date','class'=>'form-control'));
						                echo $this->Form->input('end_date',array('type'=>'date','class'=>'form-control'));
						                echo $this->Form->input('catering',array('type'=>'checkbox'));
						                echo $this->Form->input('delivery',array('type'=>'checkbox'));
						                echo $this->Form->input('pickup',array('type'=>'checkbox'));
							?>
							<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                    </div><!-- End Here -->
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