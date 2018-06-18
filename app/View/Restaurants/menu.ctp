<style type="text/css">
  label span.labelauty-unchecked-image,
  label span.labelauty-checked-image{
    display: none !important;
  }
</style>
<div id="fb-root"></div>
<script>     
window.fbAsyncInit = function() {  
FB.init({appId: '1366372560094822', status: true, cookie: true,
xfbml: true});
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol +
'//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());
</script>
<?php //  print_r($cartdata); ?>     
<!--------------------Process_sec----------------------->
<?php echo $this->Html->script(array('addtocart.js'), array('inline' => false)); ?>
<?php // echo $this->Html->script(array('cart.js'), array('inline' => false)); ?> 
<?php // print_r($shop['Shop']) ;?> 
 <?php echo $this->Session->flash(); ?>  
<div class="process_sec menudashbrd"> 
  <div class="steps_sec">
    <ul class="breadcrumb">
        <li><a href="javascript:void(0);"> <?php if ($arabic != 'ar') { ?>Select Caterer<?php }else { echo "حدد كاتيرر"; } ?> </a></li>
	<li class="active"><a href="javascript:void(0);"> <?php if ($arabic != 'ar') { ?>Choose menu items<?php }else { echo "اختر عناصر القائمة"; } ?></a></li>
	<li><a href="javascript:void(0);"><?php if ($arabic != 'ar') { ?>Confirm Order<?php }else { echo "أكد الطلب"; } ?></a></li>
   
    </ul>
  </div>
</div>


<!---------------------Process_sec-------------------------> 

<!--------------------Map_sec----------------------->


<div class="menu_sec">
 <div class="overlay"></div>
  <div class="slider_bg">
  

<div id="mycarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
    <li data-target="#mycarousel" data-slide-to="1"></li>
    <li data-target="#mycarousel" data-slide-to="2"></li>
    <li data-target="#mycarousel" data-slide-to="3"></li>
    <li data-target="#mycarousel" data-slide-to="4"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img style="width:100%;" src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>" data-color="lightblue" alt="First Image">
      <div class="carousel-caption">
        <h3>First Image</h3>
      </div>
    </div>
    <div class="item">
      <img style="width:100%;" src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>" data-color="firebrick" alt="Second Image">
      <div class="carousel-caption">
        <h3>Second Image</h3>
      </div>
    </div>
    <div class="item">
      <img style="width:100%;" src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>" data-color="violet" alt="Third Image">
      <div class="carousel-caption">
        <h3>Third Image</h3>
      </div>
    </div>
    <div class="item">
      <img style="width:100%;" src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>" data-color="lightgreen" alt="Fourth Image">
      <div class="carousel-caption">
        <h3>Fourth Image</h3>
      </div>
    </div>
    <div class="item">
      <img style="width:100%;"  src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>" data-color="tomato" alt="Fifth Image">
      <div class="carousel-caption">
        <h3>Fifth Image</h3> 
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
    <span class="fa fa-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
   

  </a>
  <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
    <span class="fa fa-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php  //print_r($restaurant); ?>
  
  </div>
   <div class="container-fluid"> 
 <?php if($restaurant['Restaurant']['verified']==1){ ?><div class="verifylogo">  <img src="<?php echo $this->webroot."images/award.svg" ;?>" width="50" height="50" />  </div> <?php } ?>   
 <?php if(!empty($restaurant['Discount'])){ ?> <div class="verifylogo"><img src="<?php echo $this->webroot."images/discount-offer.svg" ;?>" width="50" height="50" />  </div> <?php } ?>
 <?php if(!empty($restaurant['Promocode'])){ ?><div class="verifylogo"> <img src="<?php echo $this->webroot."images/donation-sharing.svg" ;?>" width="50" height="50" />  </div> <?php } ?> 
  <div class="menu_secinner clearfix">

   <div class="col-sm-2">
    <div class="caterer_img">
        <img src="<?php echo $this->webroot; ?>files/restaurants/<?php echo $restaurant['Restaurant']['logo']; ?>" alt="" class="img-responsive center-block" >
    </div> 
    </div>
    <div class="col-sm-10">
    <div class="caterer_details">

        <h1><?php if ($arabic != 'ar') { echo $restaurant['Restaurant']['name']; }else{ echo $restaurant['Restaurant']['name_ar']; } ?></h1>
        <p><?php if ($arabic != 'ar') { echo $restaurant['Restaurant']['description']; }else{ echo $restaurant['Restaurant']['description_ar']; } ?></p>
        <p><a href="<?php echo $this->webroot."staticpages/caterer_policy"; ?>" target="_blank"><?php if ($arabic != 'ar') { ?>Caterer Policy<?php }else { echo "سياسة الممولين"; } ?></a></p> 
        
                <p><?php if ($arabic != 'ar') { ?>Note: All prices are provided by this establishment not THOAG.<?php }else { echo "ملاحظة: يتم توفير جميع الأسعار من قبل هذه المؤسسة لا ثواغ."; } ?></p>
                
            <p>Minimum Order Required: SAR <?php echo $restaurant['Restaurant']['min_order']; ?></p> 
        <form action="<?php echo $this->webroot."restaurants/favourities"?>" method="POST"> 
         <input type="hidden" name="uid" value="<?php echo $loggeduser ;?>"> 
         <input type="hidden" name="rest_id" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 
         <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
             <?php if (!empty($loggeduser)) { ?>  
       <button type="submit" class="btn btn-sm defult_btn fav_btn"><?php if ($arabic != 'ar') { ?><?php if($fav !=1){ ?>Add to favourities<?php }else{ echo "Unfavourite"; } ?><?php }else { echo "اضافة الى المفضلة"; } ?></button>
           
                 <?php   }else{ ?>
         <button type="button"  class="btn btn-sm defult_btn fav_btn check"><?php if ($arabic != 'ar') { ?>Add to favourities<?php }else { echo "اضافة الى المفضلة"; } ?></button>   
       <?php 
       
                 }
        ?> 
        
        </form> 

   
   

 <div class="openhr">
  <button type="button" class="btn btn-sm defult_btn fav_btn waves-effect waves-light" data-toggle="collapse" data-target="#demo">WORKING HOURS</button>
  <div id="demo" style="padding-left: 15px;" class="collapse adres_style">
    <h5><span>WEEKDAYS</span>(MON-FRI) <?php echo $restaurant['Restaurant']['opening_time']; ?> <?php echo $restaurant['Restaurant']['closing_time']; ?></h5>
    <h5><span>WEEKENDS</span>(SAT-SUN) <?php echo $restaurant['Restaurant']['weekend_opening_time']; ?> <?php echo $restaurant['Restaurant']['weekend_closing_time']; ?></h5>
   <input type="hidden" id="is_open" value="<?php echo $restaurant['Restaurant']['is_open']; ?>"> 
  </div>
</div>




 <div class="openhr" id="msgscroll" > 
  <button type="button"  class="btn btn-sm defult_btn fav_btn waves-effect waves-light" data-toggle="collapse" data-target="#demo2">CONTACT</button>
  <div id="demo2" style="padding-left: 15px;" class="collapse adres_style">
    <h5>ADDRESS : <?php echo $restaurant['Restaurant']['address']; ?></h5>
    <h5>PHONE : <?php echo $restaurant['Restaurant']['phone']; ?></h5>
    <h5>EMAIL : <?php echo $restaurant['Restaurant']['email']; ?></h5>
    <input type="hidden" id="min_order" value="<?php echo $restaurant['Restaurant']['min_order']; ?>"> 
<input type="hidden" id="shoptotal" value="<?php echo $shop['Order']['total']; ?>"> 


  </div>
</div>


    </div> 
	
    </div>

    </div>
   </div>

</div>

<!---------------------Map_sec-------------------------> 

<div class="smart_container">

<!---------------------caterer_sec------------------------->

<div class="caterer_sec menu">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3"> 
        <div class="filter_sec clearfix shairediv"> 
            <h5 class="sizes">Share: 
              <span class="size" id="share_button1"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></span> 
             <a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $this->html->url('/', true); ?>restaurants/menu/<?php echo $restaurant['Restaurant']['id']; ?>&pubid=ra-42fed1e187bae420&title=Thoag Restaurants&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a> 
                         
             <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $this->html->url('/', true); ?>restaurants/menu/<?php echo $restaurant['Restaurant']['id']; ?>&media=<?php echo $this->html->url('/', true); ?>files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>&description=<?php echo $restaurant['Restaurant']['description']; ?>" class="pin-it-button" count-layout="horizontal">
  <img src="https://addons.opera.com/media/extensions/55/19155/1.1-rev1/icons/icon_64x64.png" width="33" height="33">  
</a> 
 
            <a href="https://plus.google.com/share?url=<?php echo $this->html->url('/', true); ?>restaurants/menu/<?php echo $restaurant['Restaurant']['id']; ?>" onclick="javascript:window.open(this.href,
                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" ><img style="height:32px; width: 32px;" src="<?php echo $this->webroot."img/icon.jpg"; ?>" width="50" height="50"> </a>   
          </h5>   
        </div>
        <!-----------------Filter section------------------->
      <div class="filter_sec clearfix">
        <p id="otdertypemsg" style="color:red"></p>   
        <ul id="lby-checkbox-demo">      
        <li class="filter_box new-one <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='catering'){ echo "active-one"; }elseif(empty($ordertype)){ echo "active-one"; } ?>" id="first_box">
        <input class="jquery-checkbox-label synch-icon" id="catering" name="ordertype" value="1" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Catering<?php }else { echo "تقديم الطعام"; } ?>"
			   <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='catering'){ echo "checked"; }elseif(empty($ordertype)){ echo "checked"; } ?>/>
        </li>
        <li class="filter_box new-one <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='delivery'){ echo "active-one"; } ?>" id="second_box">
        <input class="jquery-checkbox-label terms-icon" id="delivery" name="ordertype" value="1" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Delivery<?php }else { echo "توصيل"; } ?>"
			   <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='delivery'){ echo "checked"; } ?>/>
        </li>
		
		
        <li class="filter_box new-one <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='pickup'){ echo "active-one"; } ?>" id="thired_box">
        <input class="jquery-checkbox-label terms-icon" id="pickup" name="ordertype" value="1" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Pick-up<?php }else { echo "امسك"; } ?>"
			   <?php $ordertype = $this->Session->read('ordertype'); if($ordertype=='pickup'){ echo "checked"; } ?>/> 
        </li>
       
        </ul>
         
          <!--div class="filter_box active">
            <p>Catering</p>
          </div>
          <div class="filter_box">
            <p>Delivery</p>
          </div>
          <div class="filter_box">  
            <p>Pick-up</p>
          </div -->
        </div>
        
        <!-----------------Filter section-------------------> 
        
        <!-------------------Filter by cisine----------------------->
        
        <div class="comments_sec clearfix">
          <h1 class="fltr"><?php if ($arabic != 'ar') { ?>Comments & Reviews<?php }else { echo "التعليقات والتعليقات"; } ?></h1>
          <hr>
          <div class="comment_slid">
         <?php
         
         if(!empty($restaurant['Reviews'])){
         foreach($restaurant['Reviews'] as $review): ?>
              
              <div class="comment_sec">
         <div class="clearfix">
            <div class="post-heading">   
                <div class="image">
                    <img src="<?php echo $this->webroot."files/profile_pic/".$review['User']['image']; ?>" class="img-circle avatar" alt="<?php echo $review['User']['name']; ?>">
                </div>
                <div class="meta">
                    <div class="title h5">
                        <a href="#"><?php echo $review['User']['name']; ?></a>                        
                    </div>
                    <h6 class="text-muted star"> 
                        
                                <?php
			 $i= round($review['rating']);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                        <i class="fa fa-star active" aria-hidden="true"></i>
                                        <?php 
                                        
                                        }  
			                    ?>   
             
		   </h6>
                    <p><?php echo $review['text']; ?></p>
                </div>
            </div> 
            </div>
            </div>
             <?php endforeach;
         } 
             ?> 
        
         </div>
        </div>
        
        <!-------------------Filter by cisine-----------------------> 
        
      </div>
      <div class="col-sm-6">
        <div class="cntr_srch_sec clearfix">
		
		       <div class="clearfix">
            <div class="col-xs-12 col-sm-12"> 
				<?php
			if($restaurant['UnavailableDate']['unavailabltoday']== 1){
				?>
            <div class="cusines_sec">
                <h2 class="print_msg">Restaurant is not available for today!</h2>
				<?php // echo $date['unavailabledate']; ?>
                <!--  <div class="reltd_cusines"> <span class="label label-default">Breaffast</span> <span class="label label-default">Individual Salad Boxes</span> <span class="label label-default">individual Hot Boxes</span> <span class="label label-default">Sharing Buffet Packages</span> <span class="label label-default">Shweet Stuff</span> <span class="label label-default">Drinks</span> </div>-->
            </div>
				<?php 
			}else{  ?>
			<?php if($restaurant['Restaurant']['is_open']== 0)  { ?><div class="cusines_sec"><h2 class="print_msg">Closed Now</h2></div><?php } ?>		
				
		<?php 
		}
		 ?>
		
            </div>
          </div>
		
		
		
		
            <h1><?php if ($arabic != 'ar') { ?>Menu<?php }else { echo "قائمة طعام"; } ?>
            </h1>   
   
          <!-----------sreach_head------------->
		  <div class="cat_filter">
			<div class="filter_inner" id="catring_one">
			<?php if(!empty($productsmost)){ ?>
			
			
			<div class="populr_sec clearfix">
			<?php
			$count=0;
            foreach($productsmost as $most_populr) :
			if($most_populr['Product']['catering']==1 && $most_populr['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
			<div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo "Most Popular"; }else{ echo "الأكثر شعبية"; } ?></h3> 
              <hr>
            </div>
            </div>
			<?php 
			}
			foreach($productsmost as $most_populr) :
			if($most_populr['Product']['catering']==1 && $most_populr['Product']['quantity'] !=0){
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $most_populr['Product']['name']; }else{ echo $most_populr['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $most_populr['Product']['description'];}else{ echo $most_populr['Product']['description_ar']; } ?></span>  
               <?php
				
	$asso_id = unserialize($most_populr['Product']['pro_id']);
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $most_populr['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $most_populr['Product']['min_order_quantity']; ?>" max="<?php if($most_populr['Product']['max_order_quantity']==0){ echo $most_populr['Product']['quantity']; }else{  if($most_populr['Product']['max_order_quantity']< $most_populr['Product']['quantity']){ echo $most_populr['Product']['max_order_quantity'] ;}else{ echo $most_populr['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $most_populr['Product']['min_order_quantity']; ?>"> 
								<input type="hidden" class="order_type" name="data[Product][order_type]" value="1"> 
								<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $most_populr['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$most_populr['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php
			} endforeach; ?>
            </div>
			
				  <?php
				  }
         //print_r($restaurant);  
          if(!empty($restaurant['category_products'])){
          foreach($restaurant['category_products'] as $cat ):
			
		  ?>
          <div class="populr_sec clearfix">
		  <?php if(!empty($cat['products'])){
				$count=0;
            foreach($cat['products'] as $product) :
			if($product['Product']['catering']==1 && $product['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
          <div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo $cat['category']['name']; }else{ echo $cat['category']['name_ar']; } ?></h3> 
              <hr>
            </div>
            </div>
			<?php } } 
           
            if(!empty($cat['products'])){
            foreach($cat['products'] as $product) :
			if($product['Product']['catering']==1 && $product['Product']['quantity'] !=0){
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $product['Product']['name']; }else{ echo $product['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $product['Product']['description'];}else{ echo $product['Product']['description_ar']; } ?></span>  
               <?php
				
	$asso_id = unserialize($product['Product']['pro_id']);
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $product['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $product['Product']['min_order_quantity']; ?>" max="<?php if($product['Product']['max_order_quantity']==0){ echo $product['Product']['quantity']; }else{  if($product['Product']['max_order_quantity']< $product['Product']['quantity']){ echo $product['Product']['max_order_quantity'] ;}else{ echo $product['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $product['Product']['min_order_quantity']; ?>"> 
								<input type="hidden" class="order_type" name="data[Product][order_type]" value="1"> 
								<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $product['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$product['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php
			}
			 endforeach; 
            }
             ?> 
    
          </div>
          <?php 
          endforeach;
          }
          ?>
          <!-------------INDIVIDUAL SALAD BOXES--------------->	
			</div>
			<div class="filter_inner" id="delivery_one">
			
				<?php if(!empty($productsmost)){ ?>
			
			<div class="populr_sec clearfix">
				<?php
			$count=0;
            foreach($productsmost as $most_populr) :
			if($most_populr['Product']['delivery']==1 && $most_populr['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
			<div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo "Most Popular"; }else{ echo "الأكثر شعبية"; } ?></h3> 
              <hr>
            </div>
            </div>
			<?php 
			}
			foreach($productsmost as $most_populr) :
			if($most_populr['Product']['delivery']==1 && $most_populr['Product']['quantity'] !=0){
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $most_populr['Product']['name']; }else{ echo $most_populr['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $most_populr['Product']['description'];}else{ echo $most_populr['Product']['description_ar']; } ?></span>  
               <?php
				
	$asso_id = unserialize($most_populr['Product']['pro_id']);
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $most_populr['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $most_populr['Product']['min_order_quantity']; ?>" max="<?php if($most_populr['Product']['max_order_quantity']==0){ echo $most_populr['Product']['quantity']; }else{  if($most_populr['Product']['max_order_quantity']< $most_populr['Product']['quantity']){ echo $most_populr['Product']['max_order_quantity'] ;}else{ echo $most_populr['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $most_populr['Product']['min_order_quantity']; ?>"> 
								<input type="hidden" class="order_type" name="data[Product][order_type]" value="2"> 
								<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $most_populr['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$most_populr['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php
			} endforeach; ?>
            </div>
			
				  <?php
				  }
         //print_r($restaurant);  
          if(!empty($restaurant['category_products'])){
          foreach($restaurant['category_products'] as $cat ): ?>
          <div class="populr_sec clearfix">
		    <?php if(!empty($cat['products'])){
				$count=0;
            foreach($cat['products'] as $product) :
			if($product['Product']['delivery']==1 && $product['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
          <div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo $cat['category']['name']; }else{ echo $cat['category']['name_ar']; } ?></h3> 
              <hr>
            </div>
            </div>
            <?php 
			}
			
			}
            if(!empty($cat['products'])){
            foreach($cat['products'] as $product) :
if($product['Product']['delivery']==1 && $product['Product']['quantity'] !=0){
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $product['Product']['name']; }else{ echo $product['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $product['Product']['description'];}else{ echo $product['Product']['description_ar']; } ?></span>  
               <?php 
			   
			   $asso_id = unserialize($product['Product']['pro_id']);
			   
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $product['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $product['Product']['min_order_quantity']; ?>" max="<?php if($product['Product']['max_order_quantity']==0){ echo $product['Product']['quantity']; }else{  if($product['Product']['max_order_quantity']< $product['Product']['quantity']){ echo $product['Product']['max_order_quantity'] ;}else{ echo $product['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $product['Product']['min_order_quantity']; ?>" > 
							<input type="hidden" class="order_type" name="data[Product][order_type]" value="2"> 
							<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 							
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $product['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$product['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
			
             <?php
			 }
			 endforeach; 

            }
             ?> 
    
          </div>
          <?php 
          endforeach;
          }
          ?>
          <!-------------INDIVIDUAL SALAD BOXES--------------->
			</div>
			<div class="filter_inner" id="pickup_one">
			
				<?php if(!empty($productsmost)){ ?>
			
			<div class="populr_sec clearfix">
					<?php
			$count=0;
            foreach($productsmost as $most_populr) :
			if($most_populr['Product']['pickup']==1 && $most_populr['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
			<div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo "Most Popular"; }else{ echo "الأكثر شعبية"; } ?></h3> 
              <hr>
            </div>
            </div>
			<?php
				}			
			foreach($productsmost as $most_populr) :
			if($most_populr['Product']['pickup']==1 && $most_populr['Product']['quantity'] !=0){  
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $most_populr['Product']['name']; }else{ echo $most_populr['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $most_populr['Product']['description'];}else{ echo $most_populr['Product']['description_ar']; } ?></span>  
               <?php
				
	$asso_id = unserialize($most_populr['Product']['pro_id']);
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $most_populr['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $most_populr['Product']['min_order_quantity']; ?>" max="<?php if($most_populr['Product']['max_order_quantity']==0){ echo $most_populr['Product']['quantity']; }else{  if($most_populr['Product']['max_order_quantity']< $most_populr['Product']['quantity']){ echo $most_populr['Product']['max_order_quantity'] ;}else{ echo $most_populr['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $most_populr['Product']['min_order_quantity']; ?>"> 
								<input type="hidden" class="order_type" name="data[Product][order_type]" value="3"> 
								<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $most_populr['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$most_populr['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php
			} endforeach; ?>
            </div>
			
				  <?php
				  }
          if(!empty($restaurant['category_products'])){
          foreach($restaurant['category_products'] as $cat ): ?>
          <div class="populr_sec clearfix">
		    <?php if(!empty($cat['products'])){
				$count=0;
            foreach($cat['products'] as $product) :
			if($product['Product']['pickup']==1 && $product['Product']['quantity'] !=0){
				$count ++;
				}
				endforeach; 
			if($count >0){ ?>
          <div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo $cat['category']['name']; }else{ echo $cat['category']['name_ar']; } ?></h3> 
              <hr>
            </div>
            </div>
            <?php 
		  }}
            if(!empty($cat['products'])){
            foreach($cat['products'] as $product) :
        if($product['Product']['pickup']==1 && $product['Product']['quantity'] !=0){
			?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $product['Product']['name']; }else{ echo $product['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $product['Product']['description'];}else{ echo $product['Product']['description_ar']; } ?></span>  
               <?php 
			   	   $asso_id = unserialize($product['Product']['pro_id']);
			   if (!empty($asso_id)) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $product['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span>  
										<input type="number" min="<?php echo $product['Product']['min_order_quantity']; ?>" max="<?php if($product['Product']['max_order_quantity']==0){ echo $product['Product']['quantity']; }else{ if($product['Product']['max_order_quantity']< $product['Product']['quantity']){ echo $product['Product']['max_order_quantity'] ;}else{ echo $product['Product']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $product['Product']['min_order_quantity']; ?>"> 
										<input type="hidden" class="order_type" name="data[Product][order_type]" value="3">
										<input type="hidden"  name="data[Product][rest_id]" value="<?php echo $restaurant['Restaurant']['id']; ?>"> 	
                                         <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $product['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$product['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php
         }
			 endforeach; 
            }
             ?> 
    
          </div>
          <?php 
          endforeach;
          }
          ?>
          <!-------------INDIVIDUAL SALAD BOXES--------------->
			</div>
		  </div>
          <?php
         //print_r($restaurant);  
          if(!empty($restaurant['category_products'])){
          foreach($restaurant['category_products'] as $cat ): ?>
         <!-- <div class="populr_sec clearfix">
          <div class="clearfix">
            <div class="col-xs-12 col-sm-12">
              <h3><?php if ($arabic != 'ar') { echo $cat['category']['name']; }else{ echo $cat['category']['name_ar']; } ?></h3> 
              <hr>
            </div>
            </div>
            <?php 
            if(!empty($cat['products'])){
            foreach($cat['products'] as $product) : ?>  
            <div class="clearfix most_populr">
              <div class="col-xs-12 col-sm-9">
                <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $product['Product']['name']; }else{ echo $product['Product']['name_ar']; }  ?></p>
                <span><?php if ($arabic != 'ar') { echo $product['Product']['description'];}else{ echo $product['Product']['description_ar']; } ?></span>  
               <?php if (!empty($product['Product']['pro_id'])) {  ?> <p class="descrip_txt"><?php if ($arabic != 'ar') { ?>-Customizations Available-<?php }else { echo "-التخصيصات المتاحة-"; } ?></p> <?php } ?>  
              </div>  
               
              <div class="col-xs-12 col-sm-3">
                <div class="text-center">
                  <label><?php echo $restaurant['Restaurant']['currency']; ?> <?php echo $product['Product']['price']; ?></label>
                   <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>

					<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>

					        <div class="pull-right add-btn btn-addcart">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" name="data[Product][quantity]" value="1" >        
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $restaurant['Restaurant']['id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $product['Product']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div> 
					  <?php echo $this->Form->end(); ?>  									
                 <a href="<?php echo $this->webroot.$arb."/products/view/".$product['Product']['id']; ?>" class="btn btn-sm defult_btn view_btn" ><?php if ($arabic != 'ar') { ?>View Details<?php }else { echo "عرض التفاصيل"; } ?></a>
    
                </div>
              </div>
            </div>
             <?php endforeach; 
            }
             ?> 
    
          </div-->
          <?php 
          endforeach;
          }
          ?>
          <!-------------INDIVIDUAL SALAD BOXES--------------->
          
           
        </div>
      </div>
          <?php  
		
		 // exit;
            if(!empty($cartdata ) && $cartdata['cartInfo']['order_item_count'] > 0 ) {?>   
      <div class="col-sm-3">
        <div class="review_order clearfix">
                  <form method="post" action="<?php echo $this->webroot."shop/address"; ?>" id="checkoutform">  
          <div class="review_sec">
            <?php $ordertype = $this->Session->read('ordertype');
 //if($ordertype=='catering' || empty($ordertype)){?> 
            <div class="clearfix" id="datetimediv"> 
              <div class="date">
                <div class="form-group">
                  <h3><?php if ($arabic != 'ar') { ?>Date:<?php }else{ echo "تاريخ:"; } ?></h3>
                  <input type="text" id="eventdate" class="eventdate" value="<?php if(isset($shop['Order']['eventdate'])) { echo $shop['Order']['eventdate']; }else{ echo date('Y/m/d'); } ?>" 
                         placeholder="<?php if ($arabic != 'ar') { ?>Event Date<?php }else { echo "تاريخ الحدث"; } ?>" name="eventdate">  
		<input type="hidden" value="<?php echo $restaurant['Restaurant']['id'] ;?>" id="restu_id">				 
                </div>
              </div>
              <div class="time">
                <div class="form-group ">
                  <h3><?php if ($arabic != 'ar') { ?>Time:<?php }else{ echo "زمن:"; } ?></h3>
                  <p id="datepairExample">
                   <input type="text" id="etime" name="event_time" value="<?php if(isset($shop['Order']['event_time'])) { echo $shop['Order']['event_time']; }else { echo date("h:i:sa"); } ?>"
                          placeholder="<?php if ($arabic != 'ar') { ?>Event Time<?php }else { echo "وقت الحدث"; } ?>" class="time start" />  
                  </p>   
                </div>
              </div>
		<div class="checkmsg" style="color:red;" id="checkmsg"></div> 	
            </div> 
			<?php // } ?>	
            <div class="my_cartsec clearfix">
              <h3><?php if ($arabic != 'ar') { ?>My Cart<?php }else{ echo "سلة التسوق"; } ?></h3>
              <hr/>
              <p class="cartmesage" style="color:red;"></p> 
              <div id="added_items">
              </div> 
<?php
//print_r($cartdata);     
if(!empty($cartdata)){    
  if (array_key_exists("products",$cartdata)) {   
foreach ($cartdata['products'] as $item):    
              
            //  print_r($key); ?>     
              <!---------------mycart_view---------------->
             <!-- <div class="mycart_view clearfix"> 
                <div class="mycart_left">
                  <div class="clearfix">
                    <div class="cart_frm" id="divid">   
                     
                        <div class="border_crt">     
                            <a href="#" id="<?php echo $item['parent_product']['product_id'];  ?>" class="qtyminus qtyminus_bg cplus"></a>
                            <a href="#" id="<?php echo $item['parent_product']['product_id'];  ?>" class="qtyplus cmins"></a>
                            <input type="hidden" id="redirect" value="<?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['id'])) { echo $cartdata['cartInfo']['restaurant']['Restaurant']['id']; } ?>">
                        </div>  
                          <input type='text' name='quantity' value='<?php if(!empty($item['parent_product']['quantity'])){ echo $item['parent_product']['quantity']; }?>' class='qty' />
                 
                      <p><?php echo $item['parent_product']['name']; ?></p> 
                      <?php if(isset($item['associated_products'])){
                          foreach ($item['associated_products'] as $assoc_product){ ?> 
                      <p><small>-<?php echo $assoc_product['name'];  ?></small><span>SAR <?php echo $assoc_product['price'];  ?></span></p>          
                            <?php 
                          }  
                      } 
                      ?>  
                    </div>  
                  </div>   
                </div>
                <div class="mycart_right">  
                  <div class="cart_price text-right"> 
                    <div><?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['currency']))  echo $cartdata['cartInfo']['restaurant']['Restaurant']['currency']; ?>  <?php echo $item['parent_product']['price']*$item['parent_product']['quantity']; ?><a href="<?php  echo $this->webroot."shop/remove?pro_id=".$item['parent_product']['product_id']."&res_id=".$cartdata['cartInfo']['restaurant']['Restaurant']['id']; ?>"><img src="<?php echo $this->webroot."home/";?>images/cross.png"  alt=""></a></div>
                  </div>   
                </div> 
              </div-->
              <!---------------mycart_view---------------->
              <?php endforeach;
                }
}
              ?>
      
              <!---------------mycart_view---------------->
              <?php if($ordertype=='catering' || empty($ordertype)){ ?>   
              <div class="social_res">
                <div class="checkbox checkbox-red checkbox-circle">
                    <input id="checkbox8" value="1" <?php if(isset($shop['Order']['social_responsible'])&& $shop['Order']['social_responsible']==1) { echo "checked"; } ?> name="social_respons"  type="checkbox" checked>
                  <label for="checkbox8"><?php if ($arabic != 'ar') { ?>Social Responsibility<?php }else{ echo "مسؤولية اجتماعية"; } ?></label> 
                  <p><?php if ($arabic != 'ar') { ?>I agree to donate my leftover food to the people in need in my community.<?php }else{ echo "أوافق على التبرع بقايا الطعام إلى الناس المحتاجين في مجتمعي."; } ?></p>
                </div>
              </div>  
			  <?php } ?>
            </div>
            <!------------My Cartsec Close---------->
             <?php if($ordertype=='catering' || empty($ordertype)){ ?> 
            <div class="my_cartsec clearfix ourvalue">
              <h3><?php if ($arabic != 'ar') { ?>Our Values<?php }else{ echo "قيمنا"; } ?></h3>
              <hr>
               <div class="checkbox checkbox-red checkbox-circle">
                   <input id="checkbox" <?php if(isset($shop['Order']['demand_m_w'])&& $shop['Order']['demand_m_w']==1) { echo "checked"; } ?> name="demand" value="1" type="checkbox" >  
                <label for="checkbox"> <?php if ($arabic != 'ar') { ?>On Demand Waiter & Waitress <?php }else{ echo "على الطلب النادل والنادلة"; } ?></label> 
              </div>
              
              	<div class="male">
                    <div class="checkbox checkbox-red checkbox-circle"> 
                    <input id="checkbox2" value="1" <?php if(isset($shop['Order']['waitress'])&& $shop['Order']['waitress']==1) { echo "checked"; } ?> name="waitress" type="checkbox">
                    <label for="checkbox2"> </label>
                  </div>
                            
                  <select name="waitre_male">     
                 <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==1) { echo "selected"; } ?>   value="1">1</option>
                <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==2) { echo "selected"; } ?>  value="2">2</option>
                 <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==3) { echo "selected"; } ?>   value="3">3</option> 
                
                </select>
                <label><?php if ($arabic != 'ar') { ?>Male<?php }else{ echo "الذكر"; } ?></label>     
                </div> 
              
              <div class="female"> 
                <div class="checkbox checkbox-red checkbox-circle">
                    <input id="checkbox1" value="1" <?php if(isset($shop['Order']['waitre_female_true'])&& $shop['Order']['waitre_female_true']==1) { echo "checked"; } ?> name="waitre_female_true" type="checkbox" > 
                    <label for="checkbox1"> </label>
                  </div>
               <select name="waitre_female">       
                 <option <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==1) { echo "selected"; } ?>  value="1">1</option>
                <option  <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==2) { echo "selected"; } ?> value="2">2</option>
                 <option <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==3) { echo "selected"; } ?> value="3">3</option> 
               </select>
                <label><?php if ($arabic != 'ar') { ?>Female<?php }else{ echo "إناثا"; } ?></label>
              </div>    
      
            </div>
			 <?php } ?> 
            <div id="total_items">
             </div>    
            
           <!-- <div class="fotr_totl">  
            <div class="text-left">Sub Total</div>            
            </div>
            <div class="price_totl"> 
            <div class="text-right"><?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['currency'])) { echo $cartdata['cartInfo']['restaurant']['Restaurant']['currency']; } ?><?php if(!empty($cartdata['cartInfo']['subtotal'])) { echo $cartdata['cartInfo']['subtotal']; } ?></div>            
            </div>
            
            <div class="fotr_totl"> 
            <div class="text-left">Delivery</div>            
            </div>
            <div class="price_totl">
            <div class="text-right"><?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['currency'])) { echo $cartdata['cartInfo']['restaurant']['Restaurant']['currency']; } ?> 0.00</div>             
            </div>
            
             <div class="fotr_totl">
            <div class="text-left total">Total</div>            
            </div>
            <div class="price_totl">
            <div class="text-right price"><?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['currency'])) { echo $cartdata['cartInfo']['restaurant']['Restaurant']['currency']; } ?><?php if(!empty($cartdata['cartInfo']['total'])){ echo $cartdata['cartInfo']['total']; } ?></div>             
            </div>--> 
            <input type="hidden" value="<?php echo $restaurant['Restaurant']['name']; ?>" name="order_rest">  
            <div class="textarea_bx">  
            <p class="minordermsg" style="color:red;"></p> 
            <textarea class="form-control" name="ordernotes"  placeholder="<?php if ($arabic != 'ar') { ?>Enter any special dietary or menu instructions here<?php }else{ echo "أدخل أي طعام خاص أو تعليمات القائمة هنا"; } ?>"><?php if(!empty($shop['Order']['notes'])) { echo $shop['Order']['notes']; }  ?></textarea>
           <input type="hidden" value="placesubmit" name="placeorder">
            </div>     
           
            
       
     <div class="col-sm-12">
     <div class="button_outer">
        <?php 
        if(!empty($cartdata)){ 
        if (!empty($loggeduser)) {
            ?>
			  <!--button id="restavadate" class="btn btn-sm defult_btn view_btn waves-effect waves-light place-btn" type="button"><?php if ($arabic != 'ar') { ?>Place Order<?php }else{ echo "مكان الامر"; } ?></button-->
			  
             <button type="submit" class="btn btn-sm defult_btn view_btn waves-effect waves-light place-btn placeorder" id="placeorder"><?php if ($arabic != 'ar') { ?>Place Order<?php }else{ echo "مكان الامر"; } ?></button>
      
        <?php 
        }else{ ?>
       <button type="button" class="btn btn-sm defult_btn view_btn waves-effect waves-light order-btn check " style="line-height: 15px !important;height: 40px;"><?php if ($arabic != 'ar') { ?>Place Order<?php }else{ echo "مكان الامر"; } ?></button>   
      <?php  }
        } 
        ?>  
     </div>
  
            </div>
          </div> 
        </div>
		
              </form>   
      </div>
       <?php } ?>         
       <input type="hidden" value='' id="leadtime"> 
       <input type="hidden" value="<?php echo $restaurant['Restaurant']['lead_time']; ?>" id="rest_leadtime"> 
       <input type="hidden" value="<?php $ordertype = $this->Session->read('ordertype'); if(!empty($ordertype)){ echo $ordertype;}else{ echo "catering"; } ?>" id="rest_ordertype"> 
	   
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){ 
jQuery('#share_button1').click(function(e){ 
e.preventDefault();   
FB.ui(
{
method: 'feed',
name: '<?php echo $restaurant['Restaurant']['name']; ?>',   
link: 'http://rajdeep.crystalbiltech.com/thoag/eng/restaurants/menu/<?php echo $restaurant['Restaurant']['id']; ?>',
picture: 'http://rajdeep.crystalbiltech.com/thoag/files/restaurants/<?php echo $restaurant['Restaurant']['banner']; ?>',   
caption: 'Thoag',
description: 'Welcome to Thoag Restaurant',      
message: ''
}); 
});
});
</script>
<script type="text/javascript"> 
jQuery.noConflict()(function ($) {     
jQuery(document).ready(function(){

jQuery('#etime').addClass('checkalert');	

jQuery("#<?php $ordertype = $this->Session->read('ordertype');
 if($ordertype=='catering'){ echo "catring_one"; }elseif($ordertype=='delivery'){ echo "delivery_one"; }elseif($ordertype=='pickup'){ echo "pickup_one"; }elseif(empty($ordertype)){ echo "catring_one"; } ?>").show();	
 jQuery('input').click(function () {
       jQuery('input:not(:checked)').parent().removeClass("active-one");
       jQuery('input:checked').parent().addClass("active-one");
    }); 
var ordertype = '<?php echo $this->Session->read('ordertype'); ?>'
if(ordertype =='delivery' || ordertype =='pickup'){
jQuery('#checkbox8').prop('checked', false);	
}else{
jQuery('#checkbox8').prop('checked', true);		
}	
//jQuery('.placeorder').hide();	
	
jQuery('.check').click(function(e){ 
 alert('You must login first');  

 jQuery('#Login').modal('show');  

});

    jQuery('#placeorder').on('click', function(e){ 
	 e.preventDefault();	
var form = jQuery("#checkoutform");
	var eventdate = jQuery("#eventdate").val();
	var etime = jQuery("#etime").val();
var cat = jQuery("#catering").is(':checked');
var pick = jQuery("#delivery").is(':checked');
var del = jQuery("#pickup").is(':checked');


        var min_order = jQuery('#min_order').val();
 var shoptotal = jQuery('#carttotal').val(); 
 var rest_leadtime = jQuery('#rest_leadtime').val(); 
  var is_offer = '<?php echo $cartdata['is_offer']; ?>'; 
//var is_open = jQuery("#is_open").val();

if(cat ===false && pick===false && del===false){
jQuery("#otdertypemsg").html(' ');    
jQuery("#otdertypemsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Select Order Type'); 
 jQuery('html, body').animate({
        scrollTop: jQuery("#msgscroll").offset().top 
    }, 2000); 
e.preventDefault();
}else{
jQuery("#otdertypemsg").html(' ');   	
//if(eventdate == '' && cat=== true){checkalert
if(jQuery("#etime").hasClass("checkalert")){	
//jQuery('.placeorder').hide();	
jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Select Event Date and Time'); 

  jQuery('html, body').animate({
        scrollTop: jQuery("#msgscroll").offset().top 
    }, 2000); 
e.preventDefault();  
}else{

var rest_id = jQuery("#restu_id").val();
var dataString = 'eventdate='+ eventdate+" "+etime+'&res_id='+rest_id;    
 
// AJAX Code To Submit Form.
jQuery.ajax({ 
type: "POST",  
url: "<?php echo $this->webroot; ?>restaurants/menu", 
data: dataString,
cache: false,
success: function(result){
	console.log(result); 
 var obj = $.parseJSON( result);
  if(obj.isSucess =='false'){ 
    jQuery(".checkmsg").html(' ');
      jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Restaurant is Unavailable for your selected Date. Either choose another restaurant or select another Date.');
		
    jQuery('html, body').animate({
        scrollTop: jQuery("#msgscroll").offset().top 
    }, 2000); 
 e.preventDefault();	
 }else if(obj.isSucess =='true'){ 
 jQuery(".checkmsg").html(' '); 
//jQuery('#restavadate').hide();  
//jQuery('.placeorder').show();
  	
}
else if(obj.isSuccess =='false'){  
     jQuery(".checkmsg").html(' ');
      jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Restaurant is Closed for selected Time. Either choose another Restaurant or select another Date/Time');
		
    jQuery('html, body').animate({
        scrollTop: jQuery("#msgscroll").offset().top 
    }, 2000); 
  e.preventDefault();		
}else if (Math.round(min_order) <= Math.round(shoptotal) && is_offer==0) {
	jQuery(".checkmsg").html(' ');
		if(jQuery("#rest_ordertype").val() == 'catering'){
			
		if (jQuery('#leadtime').val() >= rest_leadtime || rest_leadtime == 0) { 
            form.submit();
        }else{  
             	
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Lead Time required : ' +rest_leadtime+ ' hours');
			
			e.preventDefault();	 
		 } 
		}else{
		form.submit();	
		}	
        }else{ 
				
				if(is_offer==1){
				if(jQuery("#rest_ordertype").val() == 'catering'){
			
		if (jQuery('#leadtime').val() >= rest_leadtime || rest_leadtime == 0) { 
            form.submit();
        }else{  
             jQuery(".checkmsg").html(' ');	
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Lead Time required : ' +rest_leadtime+ ' hours');
			//alert('<p style="color:red;">Opps! Min Order required: SAR '+min_order+'</p>'); 
			 e.preventDefault();	
		} 
		}else{
		 form.submit();	
		}	
				}else{
				jQuery(".checkmsg").html(' ');
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Order required: SAR '+min_order);
			//alert('<p style="color:red;">Opps! Min Order required: SAR '+min_order+'</p>'); 
				e.preventDefault();
		}
		}
}
});
}

	 }
	


			
    });



   /*  jQuery("#restavadate").click(function(){     
     

return false; 
});*/



/* For Tab Menu
================*/
jQuery("#first_box").click(function(){
	jQuery("#catring_one").show();
	jQuery("#delivery_one").hide();
	jQuery("#pickup_one").hide();
	jQuery(".social_res").show();
	jQuery(".ourvalue").show();
        jQuery('#checkbox8').prop('checked', true); 
        jQuery("#datetimediv").show(); 
  jQuery(".order_type").val(1);	
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
jQuery("#second_box").click(function(){
	jQuery("#delivery_one").show();
	jQuery("#catring_one").hide();
	jQuery("#pickup_one").hide();
	jQuery(".social_res").hide();
	jQuery(".ourvalue").hide();
	//jQuery("#datetimediv").hide();
        jQuery('#checkbox8').prop('checked', false);
	jQuery(".order_type").val(2);	
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
jQuery("#thired_box").click(function(){
	jQuery("#pickup_one").show();
	jQuery("#delivery_one").hide();
	jQuery("#catring_one").hide();
	jQuery(".social_res").hide();
	jQuery(".ourvalue").hide();
	//jQuery("#datetimediv").hide();
        jQuery('#checkbox8').prop('checked', false);
		jQuery(".order_type").val(3);	
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



$('.time').on('change', function(){
	
jQuery('#etime').removeClass('checkalert');	  
	  var event_time = jQuery('ul .ui-timepicker-selected').html();
	  var event_date = jQuery('#eventdate').val();

	$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: 'event_time='+event_time+'&event_date='+event_date,
cache: false,
dataType: "json",
success: function(result){
	console.log(result)
jQuery('#leadtime').val(result.leadtime);

}
});

 }); 
 
$('#eventdate').on('change', function(){
	  jQuery('#etime').removeClass('checkalert');	
	  var event_time = jQuery('ul .ui-timepicker-selected').html();
	  var event_date = jQuery('#eventdate').val();

	$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: 'event_time='+event_time+'&event_date='+event_date,
cache: false,
dataType: "json",
success: function(result){
	console.log(result)
jQuery('#leadtime').val(result.leadtime);

}
});

 }); 

 
});

});     
</script>       