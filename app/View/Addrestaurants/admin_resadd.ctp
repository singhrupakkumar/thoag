<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Restaurant User</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="page_content">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('User');?>
                       <?php echo $this->Form->input('role', array('class' => 'form-control', 'options' => array('rest_admin'=> 'Store User'))); ?>
                        <?php echo $this->Form->input('name', array('class' => 'form-control','label'=>'Restaurant Name','required' => true)); ?>
                        <?php echo $this->Form->input('username', array('class' => 'form-control','placeholder'=>'E-mail','type'=>'email','required' => true)); ?>
                        <?php echo $this->Form->input('password', array('class' => 'form-control','required' => true)); ?>
                        <?php echo $this->Form->input('active', array('type' => 'checkbox','required' => true)); ?>
                        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>