<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Associate Product</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Product',array('type'=>'file')); ?>
                        <?php echo $this->Form->input('id'); ?>
                        <?php echo $this->Form->input('dishcategory_id', ['options' => $DishCategory, 'label' => 'Dish Category:', 'id' => "dishcatname",'selected'=>$product['Product']['dishcategory_id'],'class'=>'form-control']); ?> <br />
                        <?php
                        //if (!empty($DishSubcat)) {
                         //   echo $this->Form->input('dishsubcat_id', ['options' => $DishSubcat, 'label' => 'Dish Sub Category:', 'id' => "dishsubcatname"]);
                        //} else {
                        //    echo $this->Form->input('dishsubcat_id', ['options' => $DishSubcat, 'label' => 'Dish Sub Category:', 'id' => "dishsubcatname"]);
                        //}
                        ?> 
                        <?php echo $this->Form->input('res_id', ['options' => $restaurants, 'label' => 'Restaurant Name:','class'=>'form-control']); ?>

                       <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                        
                        <?php echo $this->Form->input('description', array('class' => 'form-control ckeditor')); ?>
                        
                        <?php
                        echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image'));
                        echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control'));
                        ?>
                        
                        <?php echo $this->Form->input('price', array('class' => 'form-control','label'=>'Price(SAR)')); ?>
                        
                        <?php //echo $this->Form->input('weight', array('class' => 'form-control')); ?>
                        <?php //echo $this->Form->input('box', array('class' => 'form-control','label'=>'Box price')); ?>
                         
                        <?php //echo $this->Form->input('sizes', array('class' => 'form-control')); ?>
                        <div class="check_box">
                        <?php //echo $this->Form->input('active', array('type' => 'checkbox')); ?>
                        </div>
                        <input type="hidden" name="rid" id="rid" value="<?php echo $id; ?>">
                        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.tokenize.js"></script>
                        <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot; ?>/js/jquery.tokenize.css" />
                        <script type="text/javascript">

                $.get("http://rajdeep.crystalbiltech.com/ecasnik/admin/products/getalergy", function (d) {
                    var html = '';
                    var data = jQuery.parseJSON(d);
                    console.log(data);
                    for (var key in data) {
                        html += '<option value="' + key + '">' + data[key] + '</option>';
                    }
                    jQuery('#tokenizea').html('');
                    jQuery('#tokenizea').html(html);
                     jQuery('#sbtna').css('color','red');
                });

            </script>
            
             <script type="text/javascript">

                jQuery(document).ready(function () {
             
                    var pro_alrg = {};
                    pro_alrg =<?php echo json_encode($alrgi); ?>;
                    console.log(pro_alrg);
                    for (key in pro_alrg)
                    {
                        $('#tokenizea').tokenize().tokenAdd(key, pro_alrg[key]);
                    }
                    jQuery('#proassociatea').val('');
                    jQuery('#proassociatea').val(jQuery('#tokenizea').tokenize().toArray());
                });

            </script>
            <script type="text/javascript">
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