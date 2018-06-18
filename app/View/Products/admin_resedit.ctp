<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Product</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="page_content">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Product',array('type'=>'file')); ?>
        <?php echo $this->Form->input('id'); ?>

        <?php echo $this->Form->input('dishcategory_id',  ['options' => $DishCategory, 'label' => 'Dish Category:', 'id' => "dishcatname",'class'=>'form-control','selected'=>$product['Product']['dishcategory_id']]); ?>
        <?php echo $this->Form->input('res_id', ['options' => $restaurants, 'label' => 'Restaurant Name:','class'=>'form-control']); ?>

<?php echo $this->Form->input('name', array('class' => 'form-control','required' => true)); ?>
<?php echo $this->Form->input('name_ar', array('class' => 'form-control','required' => true,'label'=>'Name in arabic')); ?>
        
        <?php echo $this->Form->input('description', array('class' => 'form-control ckeditor','required' => true)); ?>
        <?php echo $this->Form->input('description_ar', array('class' => 'form-control ckeditor','required' => true,'label'=>'Description in arabic')); ?>
        <?php
        echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image'));
        echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control'));
        ?>
        
        <?php echo $this->Form->input('price', array('class' => 'form-control','required' => true)); ?>
		
		 <?php echo $this->Form->input('quantity', array('class' => 'form-control','required' => true)); ?>
		  <?php echo $this->Form->input('serving_unit', array('class' => 'form-control','required' => true)); ?>
		 	  <?php echo $this->Form->input('preparation_time', array('class' => 'form-control','type' => 'text','label'=>'Preparation Time(in hrs)')); ?>
		  <?php echo $this->Form->input('setup_time', array('class' => 'form-control','type' => 'text','label'=>'Setup Time(in hrs)')); ?>
		  <?php echo $this->Form->input('service_time', array('class' => 'form-control','type' => 'text','label'=>'Service Time(in hrs)')); ?>
		 
		  <?php echo $this->Form->input('min_order_quantity', array('class' => 'form-control','required' => true)); ?>
		  
		   <?php echo $this->Form->input('max_order_quantity', array('class' => 'form-control','required' => true)); ?>

   
           
         <input type="hidden" class="form-control" name="rid" id="rid" value="<?php echo $id; ?>">
		 		<!--script src="https://code.jquery.com/jquery-1.10.2.js"></script-->
				 <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.tokenize.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot; ?>/js/jquery.tokenize.css" />
            <div class="form-group">
            <label>Associate Dish:</label>
            <select id="tokenize" multiple="multiple" class="tokenize-sample" style="width: 100%;">
            </select>
</div>
            <input type="hidden" name="data[Product][proassociate]" class="form-control" id="proassociate"/>
            <div id="sbtn">Click to Associate sub items</div>
			
			
			<div class="input checkbox">
				<?php echo $this->Form->input('most_popular', array('type' => 'checkbox')); ?>
		
			</div>
			
			<div class="input checkbox">
			<?php echo $this->Form->input('catering', array('type' => 'checkbox')); ?>


			</div>
			<div class="input checkbox">
				<?php echo $this->Form->input('delivery', array('type' => 'checkbox')); ?>
		
			</div>
			<div class="input checkbox">
			<?php echo $this->Form->input('pickup', array('type' => 'checkbox')); ?>
			</div>
	
			
			
			
<!--            Associate Alergy:
            <select id="tokenizea" multiple="multiple" class="tokenize-sample">
            </select><br />
            <input type="hidden" name="data[Product][alergi]"  value="" id="proassociatea"/>
            <div id="sbtna">Click to Associate Alergy</div><br />-->
          
            <!--        <div class="check_box">
        <?php //echo $this->Form->input('active', array('type' => 'checkbox')); ?>
                    </div>-->
            <br />

            <script type="text/javascript">

               jQuery('#tokenize').tokenize().clear();
               //jQuery('#proassociate').val('');
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

            </script>
            
             <script type="text/javascript">

                jQuery(document).ready(function () {
                   jQuery('#tokenize').tokenize();
                    var pro_edit = {};
                    pro_edit =<?php echo json_encode($pro_product); ?>;
                    for (key in pro_edit)
                    {
                        console.log(key)
                        jQuery('#tokenize').tokenize().tokenAdd(key, pro_edit[key]);
                    }
                    //jQuery('#proassociate').val('');
                    jQuery('#proassociate').val(jQuery('#tokenize').tokenize().toArray());
                });

            </script>
            <script type="text/javascript">
                jQuery('#tokenize').tokenize();
            </script>
              <?php //echo $this->Form->input('sale', array('class' => 'form-control1','type'=>'checkbox','label'=>'Not for individual Sale')); ?>
<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>
<?php //echo $this->Html->script('ckeditor/ckeditor', array('inline' => false)); ?>
<script type="text/javascript">
//    var basePath = "<?php echo Router::url('/'); ?>";
//    CKEDITOR.replace('ProductDescription', {
//        filebrowserBrowseUrl: basePath + 'js/kcfinder/browse.php?type=files',
//        filebrowserImageBrowseUrl: basePath + 'js/kcfinder/browse.php?type=images',
//        filebrowserFlashBrowseUrl: basePath + 'js/kcfinder/browse.php?type=flash',
//        filebrowserUploadUrl: basePath + 'js/kcfinder/upload.php?type=files',
//        filebrowserImageUploadUrl: basePath + 'js/kcfinder/upload.php?type=images',
//        filebrowserFlashUploadUrl: basePath + 'js/kcfinder/upload.php?type=flash'
//    });

</script>
<script type="text/javascript">
    jQuery('#sbtn').off("click").on("click", function () {
        var assoc_pro = "<?php echo $pro_product; ?>"
        //$('#proassociate').val('');
        //jQuery('#proassociate').val(jQuery('#tokenize').tokenize().toArray());
        
        
        
        var updated_values = [];

$('.Tokenize').each(function(){
        
        $(this).find('ul li').each(function(){
            if($(this).attr('data-value')){
                updated_values.push($(this).attr('data-value'));
            }
        });
    });
        console.log(updated_values);
        jQuery('#proassociate').val(updated_values);
        
    });
</script>
<style type="text/css">
    div.Tokenize{
        width: 100%;
    }
</style>