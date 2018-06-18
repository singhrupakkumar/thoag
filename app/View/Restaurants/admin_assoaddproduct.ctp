<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Associate Product</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Product', array('type' => 'file', 'id' => 'addpro')); ?>
                        <?php echo $this->Form->input('dishcategory_id', ['options' => $DishCategory, 'label' => 'Associate Dish Category:', 'id' => "dishcatname", 'empty' => 'Choose Associate Dish category','required','class'=>'form-control']); ?> 
                        
                        <?php
                        //if (!empty($DishSubcat)) {
                        //    echo $this->Form->input('dishsubcat_id', ['options' => $DishSubcat, 'label' => 'Dish Sub Category:', 'id' => "dishsubcatname"]);
                        //} else {
                        //    echo $this->Form->input('dishsubcat_id', ['options' => array("Select Dish Category"), 'label' => 'Dish Sub Category:', 'id' => "dishsubcatname"]);
                        //}
                        ?> 

                        <?php echo $this->Form->input('res_id', array('class' => 'form-control', 'type' => 'hidden')); ?>
                        <?php echo $this->Form->input('name', array('class' => 'form-control','required')); ?> 

                        <?php echo $this->Form->input('name_ar', array('class' => 'form-control','required')); ?>
                        <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
                        <?php echo $this->Form->input('description_ar', array('class' => 'form-control')); ?>

                        <?php echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control', 'label' => 'Image:','required' => true)); ?>

                        <?php echo $this->Form->input('price', array('class' => 'form-control','required' => true)); ?>

                        <?php //echo $this->Form->input('weight', array('class' => 'form-control')); ?>
                         <?php // echo $this->Form->input('box', array('class' => 'form-control','label'=>'Box price')); ?>

                        <?php //echo $this->Form->input('sizes', array('class' => 'form-control','label'=>'Choose weight in kg,gm,pound')); ?>

                    <input type="hidden" name="rid" id="rid" value="<?php echo $id; ?>">
                    <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.tokenize.js"></script>
                    <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot; ?>/js/jquery.tokenize.css" />
           
                    <script type="text/javascript">
                        $('#tokenizea').tokenize();
                    </script>
                    <?php echo $this->Form->input('sale', array('class' => 'form-control1','type'=>'hidden','value'=>'1')); ?>
                    <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                    <?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php //echo $this->Html->link('Lsit of Products', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
<script type="text/javascript">
    $('#sbtna').off("click").on("click", function () {
        $('#proassociatea').val('');
        $('#proassociatea').val($('#tokenizea').tokenize().toArray());
       
    });
</script>