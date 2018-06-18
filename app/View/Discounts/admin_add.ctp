<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Discount</h1>
                </div>
            </div>
                <div class="page_content">
                    <p>
                        <?php $x=$this->Session->flash(); ?>
                        <?php if($x){ ?>
                        <div class="alert success">
                            <span class="icon"></span>
                            <strong></strong>
                            <?php echo $x; ?>
                        </div>
                        <?php } ?>
                    </p>
                    <div class="col-sm-5">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Discount'); ?>
                            <?php
                                echo $this->Form->input('id',array('class'=>'form-control'));
                                echo $this->Form->input('res_id',array('class'=>'form-control','options'=>$restaurantlist,'label'=>'Restaurant','empty'=>'Select Restaurant'));
                                echo $this->Form->input('min_order',array('class'=>'form-control','label'=>'From Order(Min)'));
                                echo $this->Form->input('max_order',array('class'=>'form-control','label'=>'To Order(Max)'));
                                echo $this->Form->input('discount',array('class'=>'form-control'));
                                echo $this->Form->input('min_order_amount',array('class'=>'form-control','type'=>'number','required'=>'true'));
                                echo $this->Form->input('max_discount_amount',array('class'=>'form-control','type'=>'number','required'=>'true'));
                            ?>
                        <?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>