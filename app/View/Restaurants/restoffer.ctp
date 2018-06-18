<?php // print_r($offerdata);?>
<div class="restoffer">
<div class="container">
	<div class="row">
	<div class="col-md-12">
  <h3>Available Offers</h3>

 <div class="restoffer-tab">
 <div class="menu_tabe">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" id="fordertype" href="#home">Catering</a></li>
    <li><a data-toggle="tab" id="sordertype" href="#menu1">Delivery</a></li>
    <li><a data-toggle="tab" id="tordertype" href="#menu2">Pick-up</a></li>    
  </ul>
</div>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">     
		<?php
                                       if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            } 
           
                
if(!empty($catering)){            
 foreach($catering as $catering) :
		?>
	  <div class="col-sm-4">
	<a href="<?php echo $this->webroot.$arb."/restaurants/offerview/".$catering['Offer']['id']; ?>">   <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."files/offers/".$catering['Offer']['image']; ?>" alt="" >
        </div></a>
	  </div>
	  <?php
	  endforeach;
}else{
?>
	  <div class="col-sm-4">
	<a href="#">   <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."images/data.png";?>" alt="" >
        </div></a>
	  </div>
<?php 	
} 
 ?>
    </div>
    <div id="menu1" class="tab-pane fade">    
  		<?php 
if(!empty($delivery)){ 
foreach($delivery as $catering) :
		?>
	  <div class="col-sm-4">
	  <a href="<?php echo $this->webroot.$arb."/restaurants/offerview/".$catering['Offer']['id']; ?>"> <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."files/offers/".$catering['Offer']['image']; ?>" alt="" >
	</div></a>
	  </div>
	  <?php 
	  endforeach;
}else{
?>
	  <div class="col-sm-4">
	<a href="#">   <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."images/data.png";?>" alt="" >
        </div></a>
	  </div>
<?php 	
} 
 ?>
    </div>
    <div id="menu2" class="tab-pane fade">  
                <?php  

if(!empty($pickup)){  
 foreach($pickup as $catering) :

		?>
	  <div class="col-sm-4"> 
              <a href="<?php echo $this->webroot.$arb."/restaurants/offerview/".$catering['Offer']['id']; ?>"> <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."files/offers/".$catering['Offer']['image']; ?>" alt="" >
            </div></a>
	  </div>
	  <?php 
	endforeach; 
}else{
?>
	  <div class="col-sm-4">
	<a href="#">   <div class="restoffer-img">
	 	<img src="<?php echo $this->webroot."images/data.png";?>" alt="" >
        </div></a>
	  </div>
<?php 	
} 
 ?>
    </div> 
   
  </div>
  </div>
 
<a class="btn btn-sm defult_btn view_btn waves-effect waves-light" href="<?php echo $this->webroot.$arb; ?>">Back to home</a>
<?php if(!empty($offerdata)){ ?>
<a href="<?php echo $this->webroot.$arb."/restaurants/menu/".$offerdata[0]['Restaurant']['id']; ?>" class="btn btn-sm defult_btn view_btn waves-effect waves-light">Go to menu</a>
<?php }  ?>
</div>
</div>
</div>  
	
</div>    
<script type="text/javascript"> 
jQuery.noConflict()(function ($) {     
jQuery(document).ready(function(){
/* For Tab Menu
================*/
jQuery("#fordertype").click(function(){
var dataString = 'ordertype=catering';  
// AJAX Code To Submit Form.
 $.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: dataString,
cache: false,
success: function(result){

}
});  
		
}); 
jQuery("#sordertype").click(function(){
var dataString = 'ordertype=delivery';  
// AJAX Code To Submit Form.
 $.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: dataString,
cache: false,
success: function(result){

}
}); 
	
});
jQuery("#tordertype").click(function(){	
var dataString = 'ordertype=pickup';  
// AJAX Code To Submit Form.
 $.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: dataString,
cache: false,
success: function(result){

}
}); 		
});

});
});     
</script> 