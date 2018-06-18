<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Product</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Product', array('type' => 'file', 'id' => 'addpro')); ?>
                        <?php echo $this->Form->input('dishcategory_id', ['options' => $DishCategory, 'label' => 'Dish Category:', 'id' => "dishcatname", 'empty' => 'Choose Dish category','required','class'=>'form-control']); ?> 
                        <?php
                        //if (!empty($DishSubcat)) {
                         //   echo $this->Form->input('dishsubcat_id', ['options' => $DishSubcat, 'label' => 'Dish Sub Category:', 'id' => "dishsubcatname"]);
                       // } else {
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
						
						
						 <?php echo $this->Form->input('quantity', array('class' => 'form-control','required' => true)); ?>
						 
						   <?php echo $this->Form->input('serving_unit', array('class' => 'form-control','required' => true)); ?>
		  <?php echo $this->Form->input('preparation_time', array('class' => 'form-control','type' => 'text','label'=>'Preparation Time(in hrs)')); ?>
		  <?php echo $this->Form->input('setup_time', array('class' => 'form-control','type' => 'text','label'=>'Setup Time(in hrs)')); ?>
		  <?php echo $this->Form->input('service_time', array('class' => 'form-control','type' => 'text','label'=>'Service Time(in hrs)')); ?>
		 
		  <?php echo $this->Form->input('min_order_quantity', array('class' => 'form-control','required' => true)); ?>
		  
		   <?php echo $this->Form->input('max_order_quantity', array('class' => 'form-control','required' => true)); ?>

                   
                        <?php //echo $this->Form->input('weight', array('class' => 'form-control')); ?>
                         <?php //echo $this->Form->input('box', array('class' => 'form-control','label'=>'Box price')); ?>

                        <?php //echo $this->Form->input('sizes', array('class' => 'form-control','label'=>'Choose weight in kg,gm,pound')); ?>

                        <input type="hidden" name="rid" id="rid" value="<?php echo $id; ?>">
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.tokenize.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot; ?>/js/jquery.tokenize.css" />
            <label>Associate Dish:</label>
            <select id="tokenize" multiple="multiple" class="tokenize-sample">
            </select>
            <input type="hidden" name="data[Product][proassociate]"  value="" id="proassociate"/>
            <div id="sbtn">Write to Add Associate Sub Items.</div>
			<?php echo $this->Form->input('most_popular', array('type' => 'checkbox')); ?>
			<?php echo $this->Form->input('catering', array('type' => 'checkbox')); ?>
		    <?php echo $this->Form->input('delivery', array('type' => 'checkbox')); ?>
			<?php echo $this->Form->input('pickup', array('type' => 'checkbox')); ?>
            <script type="text/javascript">

                $('#tokenize').tokenize().clear();
                $('#proassociate').val('');
                var a = $('#rid').val();
                $.post("http://rajdeep.crystalbiltech.com/thoag/admin/products/getproduct", {'id': a}, function (d) {
                    var html = '';
                    var data = jQuery.parseJSON(d);
                    console.log(data);
                    for (var key in data) {
                        html += '<option value="' + key + '">' + data[key] + '</option>';
                    }
                    //console.log(html);
                    jQuery('#tokenize').html('');
                    jQuery('#tokenize').html(html);
                    jQuery('#sbtn').css('color','red');
                });
                $.get("http://rajdeep.crystalbiltech.com/thoag/admin/products/getalergy", function (d) {
                    var html = '';
                    var data = jQuery.parseJSON(d);
                    console.log(data);
                    for (var key in data) {
                        html += '<option value="' + key + '">' + data[key] + '</option>';
                    }
                    //console.log(html);
                    jQuery('#tokenizea').html('');
                    jQuery('#tokenizea').html(html);
                     jQuery('#sbtna').css('color','red');
                });

            </script>            
            <script type="text/javascript">
                $('#tokenize').tokenize();
                $('#tokenizea').tokenize();
            </script>
            <?php //echo $this->Form->input('sale', array('class' => 'form-control1','type'=>'checkbox','label'=>'Not for individual Sale')); ?>
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<h3>Actions</h3>-->

<?php //echo $this->Html->link('Lsit of Products', array('action' => 'index'), array('class' => 'btn btn-default')); ?>

<br />
<br />
<script type="text/javascript">
    $('#sbtn').off("click").on("click", function () {
        $('#proassociate').val('');
        $('#proassociate').val($('#tokenize').tokenize().toArray());
        
    });
    $('#sbtna').off("click").on("click", function () {
        $('#proassociatea').val('');
        $('#proassociatea').val($('#tokenizea').tokenize().toArray());
       
    });
</script>
<style type="text/css">
.tokenize-sample.Tokenize,
    ul.TokensContainer{
        width: 100%;
        float: left;
    }
    ul.TokensContainer li{
        width: auto;
        float: left;
        padding: 5px;
    }
    div.Tokenize ul.Dropdown{
        top: 100%;
    }
</style>