<?php 
//echo $this->set('title_for_layout', 'Home');   
?>   
<script type="text/javascript">
//window.close();
</script>  
<?php // print_r($homeproducts); ?>
<div class="catagorie_sec">
  	<div class="container">
    <div class="catagorie_sec_inner clearfix">
    <div class="col-sm-12 voffset5">
           <div class="table_head">
             <h1><?php if ($arabic != 'ar') { ?>Categories<?php }else { echo "الاقسام"; } ?></h1>
			
            </div>

        </div>
    <div class="col-sm-12">
    	<div class="row voffset5">
        
     
   <div class="regular slider ">
         
    <?php foreach ($dishCategory as $val): ?>     
    <div> 
	<?php 
            if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";  
            }
           ?> 
	<form action="<?php echo $this->webroot.$arb."/restaurants/searchlisting/";?>" method="post" name="cat<?php echo $val['DishCategory']['id']; ?>">
	<input type="hidden" class="latl" name="lat" value="">
	<input type="hidden" class="longl" name="long" value="">
	<input type="hidden" name="discat" value="<?php echo $val['DishCategory']['id']; ?>">
	 </form>
        <img style="height: 50px;" src="<?php echo $this->webroot."files/caticon/".$val['DishCategory']['icon']; ?>" alt="<?php echo $val['DishCategory']['name']; ?>">
       <div class="catg_title" onClick="document.forms['cat<?php echo $val['DishCategory']['id']; ?>'].submit();"><?php if($arabic != 'ar') { echo $val['DishCategory']['name']; }else { echo $val['DishCategory']['name_ar']; } ?></div>
   
	</div>
     <?php endforeach ;?>      
     
   
      </div>        </div>
        </div>
    </div>
  </div> 
  
  <!-----------catagorie_sec---------->
  
  <!------------why love thoag------------->
  
  <div class="why_sec">
  <div class="container">
  <div class="why_sec_inner voffset6">
  	<div class="row">
    	 <div class="col-sm-12">
         <div class="table_head">
             <h1><?php if ($arabic != 'ar') { ?>Why<?php }else { echo "لماذا ا"; } ?>
                 <span><?php if ($arabic != 'ar') { ?>Love<?php }else { echo "حب"; } ?>
                 </span> <?php if ($arabic != 'ar') { ?>Thoag?<?php }else { echo "Thoag؟"; } ?></h1>   			
            </div> 
            
            <p><?php if ($arabic != 'ar') { ?> We understand to you every event is important and you must look good<?php }else { echo "نحن نفهم لكم كل حدث مهم ويجب أن تبدو جيدة"; } ?>
               
            </p>         
         </div>
         
          <div class="col-sm-12 voffset6">
          <div class="col-sm-4">
          <div class="getstrd_sec">
          	<div class="getstrd_sec_img">
            <img src="<?php echo $this->webroot;?>home/images/best-caterers.png" alt=""  class="hvr-buzz">
            </div>
            <div class="getstrd_sec_title">
           <?php if ($arabic != 'ar') { ?>One-Click Social <br />Responsibility<?php }else { echo "بنقرة واحدة المسؤولية الاجتماعية"; } ?> 
            </div>
            <p>
              <?php if ($arabic != 'ar') { ?>We only work with the best caterers for a range of budgetary
                  <?php }else { echo "نحن نعمل فقط مع أفضل وتلبية مجموعة من الميزانية"; } ?>    
                
            </p>
          </div>          
          </div>
          
          <div class="col-sm-4">
          <div class="getstrd_sec">
          	<div class="getstrd_sec_img">
            <img src="<?php echo $this->webroot;?>home/images/one-click.png" alt=""  class="hvr-buzz">
            </div>
            <div class="getstrd_sec_title">
           <?php if ($arabic != 'ar') { ?>Complete Catering and Event Delivery Services
                  <?php }else { echo "خدمات كاملة لتقديم الطعام وتقديم المناسبات"; } ?>       
            
            </div>
            <p> 
                 <?php if ($arabic != 'ar') { ?>Thoag's team is on hand to ensure everthing goes smoothly from start to finish
                  <?php }else { echo "فريق الكلب هو في متناول اليد لضمان كل شيء يمر بسلاسة روم البداية إلى النهاية"; } ?>  
                
            </p>
          </div>          
          </div>
          
          <div class="col-sm-4">
          <div class="getstrd_sec">
          	<div class="getstrd_sec_img">
            <img src="<?php echo $this->webroot;?>home/images/delivery-service.png" alt="" class="hvr-buzz">
            </div>
            <div class="getstrd_sec_title">
             <?php if ($arabic != 'ar') { ?>Best Selected Caterers and Menus
                  <?php }else { echo "أفضل المطاعم المختارة والقوائم"; } ?>      
            
            </div>
            <p>
                 <?php if ($arabic != 'ar') { ?>We only work with the best caterers for a range of budget
                  <?php }else { echo "نحن نعمل فقط مع أفضل وتلبية مجموعة من الميزانية"; } ?> 
                
            </p>
          </div>          
          </div> 
           
          </div>
          
          <div class="col-sm-12 voffset6">
          <div class="text-center"><a href="javascript:void(0)" id="getstart" class="btn btn-raised defult_btn text-center">
             <?php if ($arabic != 'ar') { ?>Get Started
                  <?php }else { echo "البدء"; } ?>       <img src="<?php echo $this->webroot;?>home/images/rright_circle.png" ></a>
          </div>
          </div>
    </div>
  </div>
  </div>  
  </div>
  
  <!------------Why Love Thoag------------->
  
  <?php 

foreach($rest_city as $val):

//if (array_key_exists("Area",$val)):  
?>
    <!------------Featured Restuarant's in Riyadh------------->
    <div class="featured_sec">
    	<div class="container">
        <div class="featured_secinner">
        	<div class="row">
            	<div class="col-sm-12">
                <div class="table_head">
             <h1>  <?php if ($arabic != 'ar') { ?>Featured Restaurants in
                  <?php }else { echo "المطاعم المميزة في"; } ?>  <?php echo $val['Restaurant']['city']; ?></h1>
			
            </div>
                
                </div>
                
                <div class="col-sm-12">
                    
               <?php
             if(!empty($rest)){
               foreach($rest as $val1) :
                 //if (array_key_exists("Area",$val)): 
      foreach($val1 as $val1){
         
                   if($val['Restaurant']['city'] == $val1['Restaurant']['city']){
					   
					   
					     $today_day = date('l');
                $today_time = date("g:iA");
               if($today_day =='Saturday' || $today_day =='Sunday'){
                   $opening_time = date("g:iA", strtotime($val1['Restaurant']['weekend_opening_time']));
                   $closing_time = date("g:iA", strtotime($val1['Restaurant']['weekend_closing_time']));
               }else{
                    $opening_time=date("g:iA", strtotime($val1['Restaurant']['opening_time']));
                    $closing_time=date("g:iA", strtotime($val1['Restaurant']['closing_time']));
               }
               
               if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                    $is_open = 1;
                }else{
                    $is_open = 0;
                }
				
				if(!empty($val1['UnavailableDate'])){
			    foreach($val1['UnavailableDate'] as $date){
		
				if($date['unavailabledate']== date('Y-m-d')){
                 $cosetoday = 1;
                }else{
                    $cosetoday = 0;
                }
				   
			   }
			    } 
					   
					   
					   
                   ?>  
                    <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?>
                    <a href="<?php echo $this->webroot.$arb."/restaurants/menu/".$val1['Restaurant']['id'];?>">    
                <div class="col-sm-4">
                	<div class="feature_grid hvr-wobble-horizontal voffset6">
                
                       <div class="feature_img "><img src="<?php echo $this->webroot."files/restaurants/".$val1['Restaurant']['banner'];?>" class="img-responsive" alt="" >
                       </div>
                  
                    <div class="feature_txt">
                    <div class="feature_redbg">
                      <span><?php if ($arabic != 'ar') { ?>Featured
                        <?php }else { echo "متميز"; } ?>
                      </span>
                    </div>
                    <div class="feature_title"><?php echo $val1['Restaurant']['name'] ;?></div>
                    <div class="feature_type">
                   
                    </div>
                        <div class="feature_star">
                                        <?php
			 $i=round($val1['Restaurant']['review_avg']);
                                        
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
                         <?php if ($arabic != 'ar') { ?>Lead time:
                  <?php }else { echo "المهلة:"; } ?>  <?php echo $val1['Restaurant']['lead_time'] ;?> hrs
                         </div>
						 
						  <?php							  
						  if($cosetoday==1){
							?> 
						<div class="feature_time2">
                         <div class="close_rest"><?php if ($arabic != 'ar') { ?> Closed Today<?php }else{ echo  "إغلاق الآن"; } ?></div> 
                         </div>
							
						<?php  }else{
						  if($is_open==0) { ?> 
						  <div class="feature_time2">
                         <div class="close_rest"><?php if ($arabic != 'ar') { ?> Closed Now<?php }else{ echo  "إغلاق الآن"; } ?></div> 
                         </div>
						<?php } }?>
						 
						 
                        
                         <div class="feature_wtricon"><img src="<?php echo $this->webroot."files/restaurants/".$val1['Restaurant']['logo'];?>" alt="" ></div>
                    </div>
                    
                    	
                    </div> 
                </div></a> <!--col-sm-4-->
              <?php 
                   } 
	  }
              endforeach;
             } 
                foreach($rest as $val1){
              if(count($val1) > 6){ 
                  
       
              ?>  

                <div class="col-sm-4">
                	<div class="feature_grid hvr-wobble-horizontal voffset6">
                    <div class="feature_img"><img src="<?php echo $this->webroot;?>home/images/feature_img-view.png" class="img-responsive" alt="" ></div>
                    <div class="feature_txt">  
                         <div class="feature_viewall"> 
                           <?php $area = base64_encode($val);  ?>  
                        <a href="<?php echo $this->webroot."restaurants/restaurentslistbyarea/".$area;?>"> View all Restuarants</a>
                         </div>
                    </div>
                    
                    	
                    </div>
                    
                    <div class="clearfix"></div>
                </div><!--col-sm-4-->
              <?php }
                     }
              ?>
                </div>
            </div>
        </div>
        </div>
    </div>
  <?php
//endif ;
 endforeach;

 ?>  
    <!------------Featured Restuarant's in Riyadh------------->

  
  <!----------------------Happy Customer's------------------------------->
  
   <div class="happycust_sec">
    	<div class="container">
        <div class="happycust_secinner voffset5">
        	<div class="row">
           <div class="col-sm-12">
                <div class="table_head">
             <h1><?php if ($arabic != 'ar') { ?>Happy Customers
                  <?php }else { echo "الزبائن سعداء"; } ?>
             </h1>
			
            </div>                
                </div>
                
                <div class="col-sm-12 voffset5">
                <div class="regular2 slider">
                	<div class="col-sm-4">
                    <div class="custmr_review voffset3">
                    <div class="text-left left_qoute">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>

                    <p>
                      <?php if ($arabic != 'ar') { ?>
                       Thoag rep was INCREDIBLE in setting up for me and having the place cards with menu 
                        and ingredients already prepped!! You guys blew my mind today!!
                  <?php }else { echo "كان ثواغ مندوب لا يصدق في إعداد بالنسبة لي وجود بطاقات مكان مع القائمة والمكونات التي تم إعدادها بالفعل !! يا رفاق فجر ذهني اليوم !!"; } ?>  
                       
                    </p>
                    <div class="text-right right_qoute">
                   <i class="fa fa-quote-right" aria-hidden="true"></i>
					</div>
                    <div class="custmr_title"><?php if ($arabic != 'ar') { ?>Esty
                  <?php }else { echo "إيتسي"; } ?></div>
					</div>
                    </div><!--col-sm-4-->
                    
                                    	<div class="col-sm-4">
                    <div class="custmr_review voffset3">
                    <div class="text-left left_qoute">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>

                    <p>
                        <?php if ($arabic != 'ar') { ?>
                  Thoag rep was INCREDIBLE in setting up for me and having the place cards with menu and ingredients already prepped!!
                        You guys blew my mind today!!
                  <?php }else { echo "كان ثواغ مندوب لا يصدق في إعداد بالنسبة لي وجود بطاقات مكان مع القائمة والمكونات التي تم إعدادها بالفعل !! يا رفاق فجر ذهني اليوم !!"; } ?>
                       
                    </p>
                    <div class="text-right right_qoute">
                   <i class="fa fa-quote-right" aria-hidden="true"></i>
					</div>
                    <div class="custmr_title"><?php if ($arabic != 'ar') { ?>Thoughtworks
                  <?php }else { echo "يعتقد أعمال"; } ?></div>
					</div>
                    </div><!--col-sm-4-->
                    
                  <div class="col-sm-4">
                    <div class="custmr_review voffset3">
                    <div class="text-left left_qoute">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>

                    <p>
                      <?php if ($arabic != 'ar') { ?>
                     Thoag rep was INCREDIBLE in setting up for me and having the place cards with menu and ingredients already prepped!!
                        You guys blew my mind today!!
                  <?php }else { echo "كان ثواغ مندوب لا يصدق في إعداد بالنسبة لي وجود بطاقات مكان مع القائمة والمكونات التي تم إعدادها بالفعل !! يا رفاق فجر ذهني اليوم !!"; } ?>  
                        
                    </p>
                    <div class="text-right right_qoute">
                   <i class="fa fa-quote-right" aria-hidden="true"></i>
					</div>
                    <div class="custmr_title"><?php if ($arabic != 'ar') { ?>DHL
                  <?php }else { echo "دل"; } ?></div>
					</div>
                    </div><!--col-sm-4-->
                    
                 </div>   
                </div>  
                
                       
            </div>
           </div>
          </div>
       </div>
  <!----------------------Happy Customer's------------------------------->
  
  
    <!----------------------Newsletter------------------------------->
    
    <div class="newsletter_sec">
      
    	<div class="container">
        <div class="newsletter_secinner voffset5">
        	<div class="row">
           <div class="col-sm-12">
           <h3 class="newsletter"><span><?php if ($arabic != 'ar') { ?>Want to receive more info on THOAG?
                  <?php }else { echo "هل تريد الحصول على مزيد من المعلومات حول ثواغ؟"; } ?>
               
               </span> <?php if ($arabic != 'ar') { ?>Sign-up to our newsletter
                  <?php }else { echo "الاشتراك في النشرة الإخبارية"; } ?></h3>
            <div class="mess" style="text-align:center;font-weight: bold;display: block;color:green;"></div> 
           <div class="clearfix">
           <form method="post" id="subscribe">
               <input id="email" type="text" name="email" value="" required placeholder="<?php if ($arabic != 'ar') { ?>Enter email address to get latest news, catering offers and THOAG Promotions for free.
                   <?php }else { echo "أدخل عنوان البريد الإلكتروني للحصول على آخر الأخبار والعروض المطاعم والترقيات ثونغ مجانا."; } ?>">
               <button type="button" id="nwsltr" class="btn btn-danger defult_btn"><?php if ($arabic != 'ar') { ?>JOIN NOW
                  <?php }else { echo "نضم الان"; } ?></button>
                    
                       
                        
           </form>
            </div>    
           
           </div>
          </div>
         </div>  
    </div>
    </div>
    
<!----------------------Newsletter------------------------------->  
      
      
      
<!----------------------Food Catering Orders------------------------------->
    
    <div class="catgordrs_sec voffset5">
    	<div class="container">
        <div class="catgordrs_secinner voffset5">       
        
        	<div class="row">
           <div class="col-sm-12">
           <div class="col-sm-6">
           <h3><?php if ($arabic != 'ar') { ?>Your App 
                  <?php }else { echo "التطبيق الخاص بك"; } ?><br/>
                  <?php if ($arabic != 'ar') { ?>For Food Catering Orders
                  <?php }else { echo "لأوامر التموين الغذائي"; } ?>
                  
           </h3>
           <p> <?php if ($arabic != 'ar') { ?>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                  <?php }else { echo "أبجد هوز هو مجرد دمية النص من صناعة الطباعة والتنضيد."; } ?></p>
           <div class="row">
           <div class="col-sm-4">
           <div class="text-left">
          	<img src="<?php echo $this->webroot;?>home/images/app_icon.png" alt="" >
            </div>
           </div>
            <div class="col-sm-8">
            <div class="text-left">
          	<img src="<?php echo $this->webroot;?>home/images/google_icon.png" alt="" >
            </div>
           </div>
           </div>
           </div>
           
            <div class="col-sm-6">
            <img src="<?php echo $this->webroot;?>home/images/phone_img.png" alt="" class="img-responsive" >
            </div>
           
           </div>
            </div>
          </div>
          </div>
          </div><!--newsletter_sec--> 
          
          
   <script type="text/javascript">
        function valid_email_address(email)
        {
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            return pattern.test(email);
        }

        jQuery('#nwsltr').on("click", function ($) {
            if (!valid_email_address(jQuery("#email").val()))
            {
                jQuery(".mess").html('Please make sure you enter a valid Email Address.');
            } 
            else
            {

                jQuery(".mess").html("<span style='color:green;'>Almost done, Please check your email address for confirmation.</span>");
                jQuery.ajax({
                    url: '<?php echo $this->webroot ;?>/shop/newsletter',
                    data: jQuery('#subscribe').serialize(),
                    type: 'POST',
                    success: function (msg) {
                        if (msg == "success")
                        {
                            jQuery("#email").val("");
                            jQuery(".mess").html('<span style="color:green;">You have successfully subscribed to our mailing list.</span>');

                        }
                        else
                        {
                            jQuery(".mess").html('<span style="color:green;">Please make sure you enter a valid Email Address.</span>');
                        }
                    }
                });
            }
            return false; 
        });
        
    </script> 




<script>
    jQuery(document).ready(function(){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(position){
            //document.getElementById('latl').value = position.coords.latitude;
           // document.getElementById('longl').value = position.coords.longitude;
            var lat = position.coords.latitude;

            var lon = position.coords.longitude;
            jQuery('.latl').val(lat);
		  jQuery('.longl').val(lon);
              console.log(lat);
              console.log(lon);

            });

         }
        //$('#you_location_img').trigger('click'); 
       //console.log(res);
    });
 </script> 	
          
 
  <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
          var options = {
                types: ['(cities)'],
                componentRestrictions: {country: "SAU"}
               };
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address')),
           options);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        
        
        document.getElementById('cityLat').value = place.geometry.location.lat();
        document.getElementById('cityLng').value = place.geometry.location.lng();
        
        
        for (var component in componentForm) {
   
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
	  
	  
    </script>   
      
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initAutocomplete"
        async defer></script>    
      