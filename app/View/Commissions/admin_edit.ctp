<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Commission'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-6">
                	<div class="restaurants index">
                    	<?php echo $this->Form->create('Commission'); ?>
                    		<?php
                                
                                echo $this->Form->input('id',array('type'=>'hidden'));
				                echo $this->Form->input('restaurant_id',array('type'=>'hidden'));
				                echo $this->Form->input('commission',array('label'=>'Commission(%)'));
                                               
							?>
							<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                                                        <?php echo $this->Form->end; ?>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
	select{
		width: auto;
    float: left;
    border: none;
    border-radius: 0px;
    background: #fff;
    border: 1px solid #ddd;
    padding: 7px 7px !important;
    color: #777 !important;
    font-size: 16px !important;
    box-shadow: none !important;
    margin: 0px;
	}
</style>