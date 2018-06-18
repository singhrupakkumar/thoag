<?php 
//print_r($maps);
$page  = $this->set('title_for_layout', 'Restaurantsearch');    
?> 
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
    float: left;
    height: 400px;
    width: 100%;
}
      /* Optional: Makes the sample page fill the window. */ 


      #map #infowindow-content {
        display: inline;
      }


      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
	  
	  .checkpffer .offers-btn {}
	  
    </style>

    <div id="map"></div>

 

    
<div class="process_sec process_sec2">    
  <div class="steps_sec">
  	<ul class="breadcrumb"> 
    		<li class="active"><a href="javascript:void(0);"> <?php if ($arabic != 'ar') { ?>Select Caterer<?php }else { echo "حدد كاتيرر"; } ?> </a></li>
		<li><a href="javascript:void(0);"> <?php if ($arabic != 'ar') { ?>Choose menu items<?php }else { echo "اختر عناصر القائمة"; } ?></a></li>
		<li><a href="javascript:void(0);"><?php if ($arabic != 'ar') { ?>Confirm Order<?php }else { echo "أكد الطلب"; } ?></a></li>
	</ul>
  </div>
  <?php //print_r($data);?>	
    <div class="container">
          <?php 
              $x=$this->Session->flash(); echo $x; 
          ?>  
        <div class="process_inrsec">
        <div class="row"> 
            <div class="col-sm-10 col-sm-offset-2">
            <form class="form-horizontal clearfix" method="get"> 
            <div class="col-sm-5">
            	 <div class="form-group">
                  <label for="usr"><?php if ($arabic != 'ar') { ?>Location<?php }else { echo "موقعك"; } ?></label>
                  <input type="text" class="form-control" value="<?php if(isset($_GET['location'])) { echo $_GET['location'];}elseif(isset($_POST['location'])){ echo $_POST['location']; } ?>" name="location" id="pac-input" placeholder="<?php if ($arabic != 'ar') { ?>Location<?php }else { echo "موقعك"; } ?>">
                  <input type="hidden" name="lat" class="form-control" id="lat" value="<?php if(isset($_POST['lat'])){ echo $_POST['lat']; }?>"> 
                  <input type="hidden" name="long" class="form-control" id="long" value="<?php if(isset($_POST['long'])){ echo $_POST['long']; }?>">     
                </div>
            </div>    
            <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="date"><?php if ($arabic != 'ar') { ?>Date<?php }else { echo "تاريخ"; } ?></label>
                  <input type="text" name="date" value="<?php if(isset($_GET['date'])) { echo $_GET['date'];}elseif(isset($_POST['date'])){ echo $_POST['date']; } ?>" placeholder="<?php if ($arabic != 'ar') { ?>Event Date<?php }else { echo "تاريخ الحدث"; } ?>" class="form-control" id="eventdateonserch" >   
                </div>
            </div>
            
            <div class="col-sm-2">    
                <div class="form-group"> 
                  <label for="time"><?php if ($arabic != 'ar') { ?>Time<?php }else { echo "زمن"; } ?></label>
                  <input type="text" value="<?php if(isset($_GET['eventtime'])){ echo $_GET['eventtime'];}elseif(isset($_POST['eventtime'])){ echo $_POST['eventtime']; } ?>" name="eventtime" placeholder="<?php if ($arabic != 'ar') { ?>Event Time<?php }else { echo "وقت الحدث"; } ?>" class="form-control" id="timep">  
                </div>
                
            </div>
            
            <div class="col-sm-1">
                <div class="form-group">
                
                 <button class="form-control btn defult_btn go_btn" type="submit"><?php if ($arabic != 'ar') { ?>Go<?php }else { echo "اذهب"; } ?></button>
                </div>
                
            </div>   
                </form>
            </div>
        </div>   
        </div> 
    </div>    
  </div>
    
<!---------------------Process_sec------------------------->
<!---------------------caterer_sec------------------------->

<div class="caterer_sec">
<div class="container-fluid">
<div class="row">
	<div class="col-sm-3">
     <div class="sort_sec clearfix">  
     <h1><?php if ($arabic != 'ar') { ?>Sort by<?php }else { echo "ترتيب حسب"; } ?> 
          <form method="get"> 
         <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
         <button type="submit"><img src="<?php echo $this->webroot."home/images/filtter.png" ;?>"></button> 
         </form>
     
     
     </h1>   
      <form method="get" name="restnameform"> 
        <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
        <input type="hidden" name="restname" value="ASC"> 
     <div class="sort_box <?php if($_GET['restname']) echo "active"; ?>" onClick="document.forms['restnameform'].submit();"> 
     <div class="sort_img">
     	<img src="<?php echo $this->webroot;?>home/images/name.png" alt="" > 
     </div>
     <p><?php if ($arabic != 'ar') { ?>Name<?php }else{ echo "اسم"; } ?> </p>
     </div> 
     </form>    
         
         
         
    <form method="get" name="ratingform"> 
        <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
        <input type="hidden" name="rating" value="DESC">
     <div class="sort_box <?php if($_GET['rating']) echo "active"; ?>" onClick="document.forms['ratingform'].submit();">
     <div class="sort_img">
     	<img src="<?php echo $this->webroot;?>home/images/rating_sort_icon.png" alt="" >
     </div>
     <p><?php if ($arabic != 'ar') { ?>Rating<?php }else{ echo "تقييم"; } ?></p>  
     </div>
	 </form>
    
      <form method="get" name="rapidform"> 
     <div class="sort_box <?php if($_GET['sortrapid']) echo "active"; ?>" onClick="document.forms['rapidform'].submit();"> 
     <div class="sort_img">
         <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
         <input type="hidden" name="sortrapid" value="1">    
     	<img src="<?php echo $this->webroot;?>home/images/rapid_sort_icon.png" alt="" >
     </div>
     <p><?php if ($arabic != 'ar') { ?>Rapid<?php }else{ echo "سريعون"; } ?> <br><?php if ($arabic != 'ar') { ?>Confirmation<?php }else{ echo "التأكيد"; } ?></p> 
     </div>
     </form>
     <form method="get" name="leadtimeform"> 
     <div class="sort_box <?php if($_GET['leadtime']) echo "active"; ?>" onClick="document.forms['leadtimeform'].submit();">
     <div class="sort_img">
         <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
         <input type="hidden" name="leadtime" value="DESC">  
     	<img src="<?php echo $this->webroot;?>home/images/lead_sort_icon.png" alt="" >
     </div>
     <p><?php if ($arabic != 'ar') { ?>Lead Time<?php }else{ echo "المهلة"; } ?></p> 
     </div>
     </form>
     
     </div>
    <!-----------------Filter section------------------->  
     <div class="filter_sec clearfix">
     <h1><?php if ($arabic != 'ar') { ?>Filter by Category<?php }else{ echo "تصفية حسب الفئة"; } ?></h1>   
    <form method="get" name="cateringform">
        <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
      <input type="hidden" name="catering" value="1">   
     <div class="filter_box <?php if($_POST['ordertype']=='catring'){ echo "active";}elseif($_GET['catering']){ echo "active"; } ?>" onClick="document.forms['cateringform'].submit();">      
     <p><?php if ($arabic != 'ar') { ?>Catering<?php }else{ echo "تقديم الطعام"; } ?></p>
     </div>     
    </form>
     
      <form method="get" name="deliveryform">
     <div class="filter_box <?php if($_POST['ordertype']=='delivery'){ echo "active";}elseif($_GET['delivery']){ echo "active"; } ?>" onClick="document.forms['deliveryform'].submit();"> 
     <input type="hidden" name="delivery" value="1"> 
     <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
     <p><?php if ($arabic != 'ar') { ?>Delivery<?php }else{ echo "توصيل"; } ?></p>
     </div>
     </form>
     
     <form method="get" name="pickupform">  
     <div class="filter_box <?php if($_POST['ordertype']=='pickup') { echo "active";}elseif($_GET['pickup']){ echo "active"; } ?>" onClick="document.forms['pickupform'].submit();">
     <input type="hidden" name="pickup" value="1">
     <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
        <input type="hidden" name="long" value="<?php if($_GET['long']) { echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long'];} ?>"> 
     <p><?php if ($arabic != 'ar') { ?>Pick-up<?php }else{ echo "امسك"; } ?></p>
     </div>
     </form>  
     
     </div>
     
     <!-----------------Filter section------------------->
     
      <!-------------------Filter by cisine----------------------->
     
     
     <div class="sort_sec clearfix">
     <h1 class="fltr"><?php if ($arabic != 'ar') { ?>Filter by Dish Category<?php }else{ echo "تصفية حسب الفئة الطبق"; } ?></h1>    
     
<?php 
$ik =0;
    foreach ($dishCategory as $val):
$ik++;
 ?>  
 <form method="get" name="searchform<?php echo $ik ;?>">  
     <div class="sort_box <?php if($_GET['discat']== $val['DishCategory']['id']){ echo "active"; }elseif($_POST['discat']== $val['DishCategory']['id']){ echo "active"; } ?>" onClick="document.forms['searchform<?php echo $ik ;?>'].submit();">
   
     <div class="sort_img" id="cat<?php echo $ik;?>"> 
     <input type="hidden" name="discat" id="ca" value="<?php echo $val['DishCategory']['id']; ?>">
     <input type="hidden" name="lat" value="<?php if($_GET['lat']) { echo $_GET['lat'];}elseif($_POST['lat']){ echo $_POST['lat'];} ?>">
     <input type="hidden" name="long" value="<?php if($_GET['long']){ echo $_GET['long'];}elseif($_POST['long']){ echo $_POST['long']; } ?>"> 
     	<img src="<?php echo $this->webroot;?>home/images/category-barbecue.png" alt="" >
     </div>
     <p><?php if ($arabic != 'ar') { echo $val['DishCategory']['name']; }else{ echo $val['DishCategory']['name_ar']; } ?></p>  

     </div>  
  </form>
	 
      <?php endforeach ;?>  
 

     
     </div>
     
     <!-------------------Filter by cisine----------------------->
     
     
    </div>
    <div class="col-sm-8">
    <div class="cntr_srch_sec clearfix">
   		<div class="sreach_head clearfix">       
       <div class="col-xs-12 col-sm-9">
        	<div class="search form-inline">
                    
                  
                    <form  id="ProductIndexForm" method="get" accept-charset="utf-8">
                    <input name="search" id="restname" class="form-control input-sm s ui-autocomplete-input" placeholder="<?php if ($arabic != 'ar') { ?>Search Caterer Name<?php }else { echo "ابحث عن اسم مقدم الخدمة"; } ?>" autocomplete="off" type="text">                   
                    <button type="submit" class="btn defult_btn scrh_btn"><i class="fa fa-search" aria-hidden="true"></i></button>
        
                    </form>      
  
         <?php if(!empty($loggeduser)) { ?>  <div class="serchpop" style="display:block;"><a href="#" data-toggle="modal" data-target="#EventModal"><img src="<?php echo $this->webroot."home/"; ?>images/male-waiter.png" ></a></div><?php } ?>
            </div>
            </div>  

       
        <div class="col-xs-12 col-sm-3">
        <!--<div class="filter_pric">
        	<h2>Filter by Price Range</h2>
           <div class="filter_range">
               <div class="lft_price">SAR 5</div>
              <div data-target="#value1" class="ui-slider"></div>
               <div class="rght_price">SAR 20</div>      
           </div>
           
        </div-->
     
        
        <!--------Filter by Price Range--------->
        </div>
        </div><!-----------sreach_head------------->
         <?php 
      // $latestlist =  $restfilter?$restfilter:$maps; 
         
          if(empty($maps)){   
					?> <div class="norestava"> <?php echo "No Restaurant Available! Fill the form below and you will be informed when services are available in the area."; ?></div>
        
        <div class="con_main pass_gap share_form">

    <div class="edit">
    <?php /*?>  <h2>
        <figure class="form-logo">
          <img src="<?php // echo $this->webroot."home/";?>images/thoag-01.svg" alt="" >
        </figure>
      </h2><?php */?>
      <div class="col-sm-9 col-center">  
        <div class="edit_box">     
 
   <form action="<?php echo $this->webroot; ?>restaurants/addunavailable_area" id="usereditform" class="jquery-validation" method="post" accept-charset="utf-8">
       <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
       <div class="input text">
           <label for="RestaurantCity">City</label> 
           <input name="data[UnavailableArea][city]" maxlength="250" type="text" id="RestaurantCity">
       </div><div class="input text">
           <label for="RestaurantArea">Area</label>
           <input name="data[UnavailableArea][area]" type="text" id="RestaurantArea"></div>
       <div class="input email">
           <label for="RestaurantEmail">Email</label>
           <input name="data[UnavailableArea][email]" maxlength="250" type="email" id="RestaurantEmail">
       </div>  

      <div class="btnbox">
       <a href="<?php echo $this->webroot; ?>" style="text-transform: capitalize !important;" class="btn btn-danger waves-effect waves-light">Cancel</a>            
        <div class="submit"><input type="submit" value="Submit"></div>
        </div> 
   </form>
         
 </div> 
      </div>
    </div>
  
    </div>
        
                                     <?php
				}else{ 

					//print_r($maps);
         foreach ($maps as $data) :?>
        <div class="result_sec clearfix">
          <div class="col-xs-12 col-sm-4">
         		<div class="feature_grid hvr-wobble-horizontal">
                    <div class="feature_img"><img src="<?php echo $this->webroot."files/restaurants/".$data['Restaurant']['banner'];?>" class="img-responsive" alt="<?php echo $data['Restaurant']['name'];?>"></div>
                    <div class="feature_txt">
                    <div class="feature_title"><?php if ($arabic != 'ar') { echo $data['Restaurant']['name']; }else{ echo $data['Restaurant']['name_ar']; } ?></div>                      
                        <div class="feature_star">
                                        <?php
			 $i=round($data['review_avg']);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                       <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <?php 
                                        
                                        } 
			                    ?>   

                        </div>
                         <div class="feature_time">
                         <?php if ($arabic != 'ar') { ?>Lead time:<?php }else{ echo "المهلة:"; } ?> <?php echo $data['Restaurant']['lead_time'];?> hrs
                         </div>
						 
						 	  <?php							  
			if($data['UnavailableDate']['unavailabltoday']== 1){
							?> 
						<div class="feature_time2">
                         <div class="close_rest"><?php if ($arabic != 'ar') { ?> Closed Today<?php }else{ echo  "إغلاق الآن"; } ?></div> 
                         </div>
							
						<?php  
							}else{ ?>
							
							 <?php if($data['Restaurant']['is_open']==0) { ?> 
						  <div class="feature_time2">
                         <div class="close_rest"><?php if ($arabic != 'ar') { ?> Closed Now<?php }else{ echo "إغلاق الآن"; } ?></div> 
                         </div>
						 <?php } ?>	
								
						<?php	
							
						}?>
						
                         <div class="feature_redbg"><span><?php if ($arabic != 'ar') { ?>Rapid Boking<?php }else{ echo "التقيأ السريع"; } ?></span></div>
                         <span class="feat_cater"><?php if ($arabic != 'ar') { ?>featured<?php }else{ echo "متميز"; } ?></span>  
                         <div class="feature_wtricon"><img src="<?php echo $this->webroot."files/restaurants/".$data['Restaurant']['logo'];?>" alt=""></div>
                    </div>
                    
                    	
                    </div>
          </div>
           <div class="col-xs-12 col-sm-6">
                 <p class="descrip_txt"><?php if ($arabic != 'ar') { echo $data['Restaurant']['description']; }else{ echo $data['Restaurant']['description_ar']; } ?></p>
             <div class="leadtime">
             	<h3><?php if ($arabic != 'ar') { ?>Lead time:<?php }else{ echo "المهلة:"; } ?> <?php echo $data['Restaurant']['lead_time'];?>
                    <?php if ($arabic != 'ar') { ?>hours<?php }else{ echo "ساعة"; } ?> 
              
                 </h3>
             </div>
          </div>
           <div class="col-xs-12 col-sm-2">
                       <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?> 
              <?php if(!empty($data['Offer'])){ ?>  <div class="checkpffer">
                    <a style="text-transform:capitalize;" href="<?php echo $this->webroot.$arb."/restaurants/restoffer/".$data['Restaurant']['id']; ?> "><button style="margin:0px; width:100%;" class="btn btn-md defult_btn offers-btn pull-right">
                        <?php if ($arabic != 'ar') { ?>Available Offers<?php }else{ echo "عروض"; } ?>    
                    </button></a>
              </div> <?php } ?>  
          
               <a class="btn btn-sm defult_btn view_btn" href="<?php echo $this->webroot.$arb."/restaurants/menu/".$data['Restaurant']['id']; ?> "><?php if ($arabic != 'ar') { ?>View Menu<?php }else{ echo "عرض القائمة"; } ?></a>  
             
                      
           <form action="<?php echo $this->webroot."restaurants/favourities"?>" method="POST"> 
         <input type="hidden" name="uid" value="<?php echo $loggeduser ;?>"> 
         <input type="hidden" name="rest_id" value="<?php echo $data['Restaurant']['id'] ;?>"> 
         <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
         
           <?php if (!empty($loggeduser)) { ?>  
         <button style="margin:0px;" type="submit" class="btn btn-sm defultgrey_btn view_btn"><?php if ($arabic != 'ar') { ?><?php if(in_array($data['Restaurant']['id'],$favid)) { ?>Unfavourite<?php }else{ echo "Add to Favourites"; }  ?><?php }else{ echo "أضف إلى المفضلة"; } ?></button>
           
                 <?php   }else{ ?>
         <button style="margin:0px;" type="button" id="checklogin" class="btn btn-sm defultgrey_btn view_btn"><?php if ($arabic != 'ar') { ?>Add to Favourites<?php }else{ echo "أضف إلى المفضلة"; } ?></button>     
      <?php    
      }
        ?> 
      
        </form>
               
          </div>
        
        
        </div>
        <?php endforeach ;
         }
        ?>
       
        
    </div>
    </div>
</div>
</div>

</div> 



<div id="EventModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form method="post" action="<?php echo $this->webroot."restaurants/customer_support" ?>"> 
      <div class="modal-header"> 
		<button type="button" class="close" style="color:#fff;" data-dismiss="modal">×</button>	
        <h2 class="modal-title"><img src="<?php echo $this->webroot."home/" ;?>images/thoag.svg" alt="logo" ></h2>
        <p>Help us to find you the Perfect Option!</p>
      </div>
      <div class="modal-body clearfix">
      <h3>How big is your event?</h3>
      <input type="text" name="big_your" class="form-control" placeholder="20">
        <p>People</p>
        <div class="budget">
        <span>Your budget per:</span><span><select class="form-control" name="budget_per"><option value="Head">Head</option><option value="Plate">Plate</option></select></span>
        </div>
		    <input name="r11" id="r1" class="form-control" value="10" type="hidden">
			  <input name="r12" id="r2" class="form-control" value="150" type="hidden"> 
        <!--div class="filter_range">
               <div class="lft_price">&pound;5</div>
              <div data-target="#value1" class="ui-slider"></div>
               <div class="rght_price">&pound;20</div>
        </div-->
		 <div id="slider" class="filter_range">
                     
         </div> 
      </div>
	  <input type="hidden" id="server" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
      <div class="modal-footer">
        <button type="submit" class="btn btn-default defult_btn">Select <i class="fa fa-angle-right"></i></button>
      </div>
	</form> 
    </div>

  </div>
</div>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript" charset="utf-8">
jQuery.noConflict()(function ($) { // this was missing for me
    
 
               
    jQuery(document).ready(function() {
           var vLeft  = '<?php if(isset($_POST['r11'])) { echo $_POST['r11'] ;}else { echo "10" ;} ?>',
         vRight = '<?php if(isset($_POST['r12'])) { echo $_POST['r12']; }else { echo "150" ;} ?>';
        var slider = jQuery("#slider").slider({
        range: true, 
        min: 0,
        max: 1000,
        step: 1,
         values: [vLeft, vRight],
          slide: function(event, ui) {
          jQuery(ui.handle).find('.tooltip').text(ui.value);
           jQuery( "#r1" ).val(ui.values[ 0 ]);
        jQuery( "#r2" ).val(ui.values[ 1 ]);
         },
         create: function(event, ui) {
           var tooltip = jQuery('<div class="tooltip" />');
           
           jQuery(event.target).find('.ui-slider-handle').append(tooltip);
           var firstHandle  = $(event.target).find('.ui-slider-handle')[0];
          var secondHandle = $(event.target).find('.ui-slider-handle')[1];
          firstHandle.firstChild.innerText = vLeft;
          secondHandle.firstChild.innerText = vRight;
         },
         change: function(event, ui) {
             $('#hidden').attr('value', ui.value);
             }
         });
       });
	     });
</script>
<script>
jQuery(document).ready(function ($) {
  jQuery(".tooltip").eq(0).addClass("slid1");
   jQuery(".tooltip").eq(1).addClass("slid2");
   var k1 = $(".slid1").text();
   var k2 = $(".slid2").text();
   jQuery("#r1").val(k1);
   jQuery("#r2").val(k2);
  });
 </script>
 
  <script>
 jQuery(document).ready(function ($) {
   jQuery(".tooltip").eq(2).addClass("slid11");
   jQuery(".tooltip").eq(3).addClass("slid21");
   var k11 = $(".slid11").text();
   var k22 = $(".slid21").text();
    jQuery("#r11").val(k11);
    jQuery("#r21").val(k22);
    

    
  });
  </script>
  
  
  <style>
#slider1 {
 width: 64%;
 position: absolute;
 height: 7px;
 background: #e1e1e1 ;
       border-radius:5px;
top:13px;
margin-left:10px;
}
.tooltip {
 
 /* color: #000;
    display: block;
    font: 10px Arial,sans-serif;
    height: 15px;
    opacity: 1;
    position: absolute;
    text-align: center;
    top: -8px;
    width: 31px;*/
}
.ui-slider-handle {
   border-color: transparent transparent #eecb19;
    border-style: solid;
    border-width: 0 0 11px;
    cursor: pointer;
    height: 16px;
    margin-left: -12px;
    outline: medium none;
    position: absolute;
    top: -7px;
    width: 12px;
    z-index: 2;
 /*background: url('./img/range_arrow.png') no-repeat 50% 50%;*/

}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { background:#eecb19; border:1px solid #eecb19;}

.ui-slider-handle:after {     border-color: #eecb19 transparent transparent;
    border-style: solid;
    border-width: 9px 9px 0;
    content: "";
    height: 0;
    left: 0;
    position: absolute;
    top: 16px;
    width: 0;}
 
.ui-slider-range {
 background:#d2b728;
 position: absolute;
 border: 0;
 top: 1px;
 height: 7px;
 border-radius: 25px;
}
#textarea_one{
 margin-left: 0;
    margin-top: -18px;
}
#textarea_two {
 margin-left: 192px;
 margin-top: -25px;
}
#textarea_one, #textarea_two {
 font-weight: 700;
 font-family: Arial;
 font-size: 11px;
 color: #959595;
}
  </style>
.
<style>

.tooltip {
 
  color: #fff;
    display: block;
    font: 10px Arial,sans-serif;
    height: 15px;
    opacity: 1;
    position: absolute;
    text-align: center;
    top: -21px;
    width: auto;
 background-color:#626262;
 padding:1px 2px;
}
.ui-slider-handle {
/* position: absolute;
 z-index: 2;
 width: 29px;
 height: 31px;
 cursor: pointer;
 /*background: url('./img/range_arrow.png') no-repeat 50% 50%;*/
 outline: none;
 top: -7px;
 margin-left: -12px;*/
}
.ui-slider-range {
 background:#eecb19;
 position: absolute;
 border: 0;
 top: 1px;
 height: 7px;
 border-radius: 25px;
}
#textarea_one{
 margin-left: 0;
    margin-top: -18px;
}
#textarea_two {
 margin-left: 192px;
 margin-top: -25px;
}
#textarea_one, #textarea_two {
 font-weight: 700;
 font-family: Arial;
 font-size: 11px;
 color: #959595;
}
  </style>

<?php  //print_r($maps);?> 
 <script>
   
     var icon2 = "http://rajdeep.crystalbiltech.com/dhdeals2/home/img/maploc.png";
    // var cr = 'http://rajdeep.crystalbiltech.com/dhdeals2/files/restaurants/shop1.png';
     var images =  new Array();
           <?php
         //  $maps = $maps;//$restfilter?$restfilter:$maps; 
            foreach($maps as $mapss){ 
                $markers = $mapss['Restaurant']['marker'];
                
            ?>
           // images.push('<?php //echo 'http://rajdeep.crystalbiltech.com/dhdeals2/files/restaurants/'.$markers; ?>');
         
        <?php } ?>
      var allMarkers = [];
function hover(id) {
    
    for ( var i = 0; i< allMarkers.length; i++) {
        if (id === allMarkers[i].id) {
           allMarkers[i].setIcon(icon2);
           break;
        }
   }
}
function out(id) {  
    for ( var i = 0; i< allMarkers.length; i++) {
        if (id === allMarkers[i].id) {
           allMarkers[i].setIcon(images[i]);
           break;
        }
   }
}

function initializes() {
    var map;
   
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
    mapTypeId: 'roadmap',
        zoom: 10,
        minZoom: 5,
        maxZoom: 15, 
        streetViewControl: false,
        tilt: 0,
        zoomControl: true,
       // scaleControl: true,
        disableDefaultUI: true  
    };
    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map"), mapOptions); 
    map.setTilt(45);
     
        var options1 = {
                types: ['(cities)'],
                componentRestrictions: {country: "SAU"}
               };
      var input = /** @type {HTMLInputElement} */( 
      document.getElementById('pac-input'));  

  var types = document.getElementById('type-selector');

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

  var autocomplete = new google.maps.places.Autocomplete(input,options1);
  autocomplete.bindTo('bounds', map);
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
    //infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('long').value = place.geometry.location.lng();
        
    
    if (!place.geometry) { 
      return;
    }
    
    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location); 
      map.setZoom(17);  // Why 17? Because it looks good. 
    } 

  }); 
  
  // Multiple Markers 
  
   <?php //print_r($maps); ?>
    var markers = [
        
        <?php //print_r($maps);
  //$maps = $maps;//$restfilter?$restfilter:$maps;   
    foreach($maps as $mymap):
        $latitudez = $mymap['Restaurant']['latitude'];
        $longitudez =  $mymap['Restaurant']['longitude'];
        $city =  $mymap['Restaurant']['city'];
        $state =  $mymap['Restaurant']['state'];
        $id =  $mymap['Restaurant']['id'];
         //$marker =  $mymap['Restaurant']['marker'];
        ?>
                   
        ['<?php echo $city;?>, <?php echo $state;?>', <?php echo $latitudez;?>,<?php echo $longitudez;?>],
        //['Palace of Westminster, London', 51.499633,-0.124755],
 <?php endforeach;  ?>  
    ];
     var markid = [
          <?php foreach($maps as $mymap):
       
        $id =  $mymap['Restaurant']['id'];
         //$marker =  $mymap['Restaurant']['marker'];
        ?>
                    [<?php echo $id;?>],
      <?php endforeach;  ?>  
     ];  
      
  // Info Window Content 
    var infoWindowContent = [  
          <?php 
            foreach($maps as $mymap):
                $name = $mymap['Restaurant']['name'];
                $dscr = $mymap['Restaurant']['description'];
           ?>
        ['<div class="info_content">' +
        "<h3><?php echo $name ; ?></h3>" +  
        "<p><?php echo $dscr ; ?></p>" +   
        '</div>'], 
        <?php endforeach;  ?>  
    ];
     
     
                 

   // var image = "http://rajdeep.crystalbiltech.com/dhdeals2/home/img/maploc.png";  
      
           
           var image =  new Array();
           <?php 
            foreach($maps as $mapss){ 
                $markers = $mapss['Restaurant']['marker'];
                
            ?>
            image.push('<?php echo 'http://rajdeep.crystalbiltech.com/thoag/files/restaurants/'.$markers; ?>');
         
        <?php } ?>     
      
            
            
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    console.log(infoWindow);
   
     
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        
        
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
           position: position, 
          map: map,
		  zoom: 5,
            id:markid[i][0],
            title: markers[i][0],
            icon: image[i]
        });
        console.log(marker);
       allMarkers.push(marker);
     var iconIDs = '';
   // alternateMarkers.push(altMarkImg);
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                 infoWindow.open(map, marker);
                var idm = marker.id;
                console.log(idm);
                jQuery("li.markid").each(function() {
                  iconIDs=$(this).attr('id');
                  if(idm == iconIDs){
                     jQuery(this).css('background-color','#D3D3D3');//remove sidebar links back colors 
                  }
                 });
                
            }
        })(marker, i));
       google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                 infoWindow.open(map, marker);
                 infoWindow.close(map, marker);
                var idm = marker.id; 
                console.log(idm);
                jQuery("li.markid").each(function() {
                  iconIDs=jQuery(this).attr('id');
                  if(idm == iconIDs){
                     jQuery(this).css('background-color','#fff');//remove sidebar links back colors 
                  }
                 });
                
            }
        })(marker, i));
        
        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
         
        
    }
    

// Try HTML5 geolocation.

/*******************    gps location *************************/
 var cr = 'http://rajdeep.crystalbiltech.com/dhdeals2/home/img/current_icon-01.png';
var controlDiv = document.createElement('div');
	
	var firstChild = document.createElement('button');
	firstChild.style.backgroundColor = '#fff';
	firstChild.style.border = 'none';
	firstChild.style.outline = 'none';
	firstChild.style.width = '28px';
	firstChild.style.height = '28px';
	firstChild.style.borderRadius = '2px';
	firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
	firstChild.style.cursor = 'pointer';
	firstChild.style.marginRight = '10px';
	firstChild.style.padding = '0px';
	firstChild.title = 'Your Location';
	controlDiv.appendChild(firstChild);
	
	var secondChild = document.createElement('div');
	secondChild.style.margin = '5px';
	secondChild.style.width = '18px';
	secondChild.style.height = '18px';
	secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
	secondChild.style.backgroundSize = '180px 18px';
	secondChild.style.backgroundPosition = '0px 0px';
	secondChild.style.backgroundRepeat = 'no-repeat';
	secondChild.id = 'you_location_img';
	firstChild.appendChild(secondChild);
	
	google.maps.event.addListener(map, 'dragend', function() {
		jQuery('#you_location_img').css('background-position', '0px 0px');
	});

	firstChild.addEventListener('click', function() { 
		var imgX = '0';
		var animationInterval = setInterval(function(){
			if(imgX == '-18') imgX = '0';
			else imgX = '-18';
			jQuery('#you_location_img').css('background-position', imgX+'px 0px');
		}, 500);
		 if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              document.getElementById('lat').value = position.coords.latitude;
              document.getElementById('long').value = position.coords.longitude;
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
             
            };
 console.log(pos);
        markers = new google.maps.Marker({
            position: pos,
            map: map,
			zoom: 10,
            //title: markers[i][0],
            icon: cr
        });

            map.setCenter(pos);
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
	});
	
	controlDiv.index = 1;
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);

/*******************   End gps location *************************/
       
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }



     
}



 </script> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initializes"
         async defer></script>


  <script type="text/javascript"> 
jQuery(document).ready(function($){   
jQuery('#checklogin').click(function(e){
 alert('You must login first');

jQuery('#Login').modal('show');


return false; 
});
 
});
 
</script> 


 