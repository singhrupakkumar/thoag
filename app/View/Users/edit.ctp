 <style type="text/css">
  .list-first{
    width: 100%;
    float: left;
  }
  .list-first span{
    display: inline-block;
    height: 46px;
    line-height: 46px;
    padding: 0px 26px;
    border: 1px solid #e4e6e8;
    font-size: 16px;
    color: #555;
    float: left;
  }
  .list-first input.form-control{
    width: 82% !important;
    float: right !important;
    display: inline-block !important;
  }
</style>
<!---------------------caterer_sec------------------------->
<?php //print_r($addressdata);?>
<div class="update_sec menu">
  <div class="container-fluid">
    
   
    <div class="col-sm-12">
    <div class="update_prfl">
      <div class="accordion" id="accordion2">
            <div class="accordion-group">
            <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" aria-expanded="true" data-parent="#accordion2" href="#collapseOne">
           <?php if ($arabic != 'ar') { ?>Edit Profile<?php }else{ echo "تعديل الملف الشخصي"; } ?> 
            </a>
            </div>
            <div id="#" class="accordion-body collapse in"> 
            <div class="accordion-inner clearfix">
            <div class="clearfix">
              <div class="col-sm-6 col-xs-12">
                  <h2><strong> <?php if ($arabic != 'ar') { ?>Personal Details<?php }else{ echo "تفاصيل شخصية"; } ?></strong></h2>
                    
                </div>
                
                <div class="col-sm-6 col-xs-12">
                <div class="delivery_addrs">
                  <h2><strong><?php if ($arabic != 'ar') { ?>Address<?php }else{ echo "عنوان"; } ?></strong></h2>
                    <div class="checkmsg"></div>
 <a href="#" class="active btn defult_btn pull-right"  data-toggle="modal" data-target="#Address">
     <?php if ($arabic != 'ar') { ?>Add New Address<?php }else{ echo "إضافة عنوان جديد"; } ?></a>                  
 </div>  
                </div>
               </div> 
       
                 
<form method="POST" id="editform">
<div class="details">
                <div class="col-sm-12 col-xs-12">
                <div class="col-sm-6 col-xs-12 border-right">
                 <div class="col-sm-6">
                 <div class="edit_fld">
         
                    <label> <?php if ($arabic != 'ar') { ?>Your Full Name<?php }else{ echo "اسمك الكامل"; } ?></label> 
                     <div class="edit_prflicn">
           <input  name="data[User][username]" id="username1" value="<?php echo $data['User']['username']; ?>" type="hidden"/>
           <input class="form-control" id="name" placeholder="Please Enter Your Full Name" name="name" value="<?php echo $data['User']['name']; ?>" type="text"/>
                       
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div>
                    </div>                 
                    </div>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Email Address<?php }else{ echo "عنوان البريد الإلكتروني"; } ?></label>
                    <div class="edit_prflicn">
          <input class="form-control" id="email" placeholder="Please Enter Email Address" name="email" value="<?php echo $data['User']['email']; ?>" type="email"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                     </div> 
                    </div>                  
                    </div>
                    
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Gender<?php }else{ echo "جنس"; } ?></label>
                    <div class="edit_prflicn">
                        <select name="gender" id="egender" class="form-control">
                            <option value=""></option>
                             <option <?php if($data['User']['gender']=='male'){ echo "selected"; }  ?> value="male">
                                 <?php if ($arabic != 'ar') { ?>Male<?php }else{ echo "الذكر"; } ?>
                             </option>
                             <option <?php if($data['User']['gender']=='female'){ echo "selected"; }  ?> value="female">
                                 <?php if ($arabic != 'ar') { ?>Female<?php }else{ echo "إناثا"; } ?> 
                             </option>
                        </select>    
                    </div>  
                    </div>                  
                    </div>
                    
                      <div class="col-sm-6">
                    <div class="edit_fld">
                    <label> <?php if ($arabic != 'ar') { ?>Date of Birth<?php }else{ echo "تاريخ الولادة"; } ?> </label>
                    <div class="edit_prflicn">
                    <input class="form-control" id="edob" placeholder="Please Enter Your Birth" name="edob" value="<?php $date = $data['User']['dob']; $date = date('d-m-Y'); echo $date; ?>" type="text"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div> 
                    </div>                  
                    </div>
                    <?php
						$phone = substr($data['User']['phone'],5);
				

					?>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Phone Number<?php }else{ echo "رقم الهاتف"; } ?></label>  
                    <div class="edit_prflicn">
          <input class="form-control" id="phone" placeholder="Please Enter Your Phone" maxlength="9" name="phone" value="<?php echo $phone; ?>" type="text"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div> 
                    </div>                  
                    </div>
                  
                    <div class="col-sm-6">
            <div class="edit_fld">
              <label><?php if ($arabic != 'ar') { ?>Your Address<?php }else{ echo "عنوانك"; } ?></label>  
              <div class="edit_prflicn"> 
                <input placeholder="Please Enter Your Address" id="address1" name="address" value="<?php echo $data['User']['address']; ?>" type="text"/>
                <div class="edit_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div>
              </div> 
            </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Your City<?php }else{ echo "مدينتك"; } ?></label>
                    <div class="edit_prflicn">
          <input class="form-control" id="city" placeholder="Please Enter Your City" name="city1" value="<?php echo $data['User']['city']; ?>" type="text"/>
                     
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div>  
                    </div>
                    </div>                  
                    </div>
          
           <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Your Zip<?php }else{ echo "الرمز البريدي الخاص بك"; } ?></label>  
                    <div class="edit_prflicn">
          <input placeholder="Please Enter Zip Code" id="zip" name="zip" value="<?php echo $data['User']['zip']; ?>" type="text"/>
                     
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div>  
                    </div>
                    </div>                  
                    </div>
          
          
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Your State<?php }else{ echo "ولايتك"; } ?></label>
                    <div class="edit_prflicn">
          <input class="form-control" id="state" placeholder="Please Enter Your State" name="state" value="<?php echo $data['User']['state']; ?>" type="text"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div>  
                     </div> 
                    </div>                  
                    </div>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Your Country<?php }else{ echo "بلدك"; } ?></label> 
                     <div class="edit_prflicn">
           <input class="form-control" id="country" placeholder="Please Enter your Country" name="country" value="<?php echo $data['User']['country']; ?>" type="text"/>
                    
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div>
                    </div>                  
                    </div>
          <div class="col-sm-12"> 
          <div class="edit_fld">
          <input name="submit" id="editsubmit" type="button" value="<?php if ($arabic != 'ar') { ?>Submit<?php }else{ echo "عرض"; } ?>"/>
          </div>
                    </div>  
                   </div> 
                   
                   <div class="col-sm-6 col-xs-12"> 
            <div class="row">
      <div class="left_address">
              <div class="col-sm-12">
                <?php if($data['User']['address'] || $data['User']['city'] || $data['User']['zip'] ||$data['User']['country'] || $data['User']['state']) {?>
                <div class="user_details-inner">
                  <label><?php if ($arabic != 'ar') { ?>Default Address<?php }else{ echo "العنوان الافتراضي"; } ?></label>  
                  <p><?php echo $data['User']['address']; ?></p>
                  <p><?php echo $data['User']['city']; ?></p>
                  <p><?php echo $data['User']['state']; ?></p>
                  <p><?php echo $data['User']['zip']; ?></p>
                  <p><?php echo $data['User']['country']; ?></p>                                               
                </div>
              <?php  } ?>
             </div>        
      </div>
      <div class="right_address">
                                                            <?php foreach($addressdata as $addess):?>   
                <div class="col-sm-12">
              
                <div class="user_details-inner">
                <label><?php echo $addess['Address']['title']; ?></label>    
                  <p><?php echo $addess['Address']['name']; ?></p>
                                                                        <p><?php echo $addess['Address']['phone']; ?></p>
                  <p><?php echo $addess['Address']['recipent_mobile']; ?></p>
                  <p><?php echo $addess['Address']['address']; ?></p>
                  <div class="user_action">
                    <a href="<?php echo $this->webroot."addresses/edit/".$addess['Address']['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                    <a onclick="return confirm('Are you sure you want to delete?');" href="<?php  echo $this->webroot."addresses/delete?add=".$addess['Address']['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                  </div>
                                </div> 
              </div>
                                                         <?php endforeach;?>    
      </div>

              </div>
                                                        </div>
               
                   </div>

             
               
                   </div>
                  
            
           
                    </div>
                
                </div>
           </form>
            
            </div>
            </div>
            </div>
            
            </div>    
    </div>
      </div>
      
      
   
  </div>
</div> 
<!--Register Popup-->  
<div id="Address" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal Content Start Here -->
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d71e24;">
        <button type="button" class="close" style="color:#fff;" data-dismiss="modal">&times;</button>
        <h2 style="margin:0px; color:#fff;"><?php if ($arabic != 'ar') { ?>Add New Address<?php }else{ echo "إضافة عنوان جديد"; } ?></h2>
      </div><!-- End Here -->
      <div class="modal-body">
        <form id='addressform'> 
          <div class="form-group">
            <div class="msg" style="color:red;"></div>
            <input class="form-control" autocomplete="off" id="title" name="title" placeholder="Address Title" type="text" required>
            <input  id="uid" name="uid" value="<?php echo $loggeduser; ?>" type="hidden">
          </div>
          <div class="form-group">
            <input class="form-control" autocomplete="off"  id="aname" name="aname" placeholder="User Name" type="text" required>
          </div>
          <div class="form-group list-first">
            <span>+966</span>
            <input class="form-control field" autocomplete="off" maxlength="9"  id="aphone" name="aphone" placeholder="Mobile Number" type="text" required>
          </div>
          <div class="form-group list-first">  
              <span>+966</span>
            <input class="form-control field" autocomplete="off" maxlength="9" id="recipent_mobile" name="recipent_mobile" placeholder="Recipient Number" type="text" required>
          </div>
          <div class="form-group">
            <div class="msg" style="color:red;"></div>
			<div class="map-locator">
				<input class="form-control addr" autocomplete="off" id="aaddress" name="aaddress" placeholder="Address" type="text" required>
				<input id="aalat"  type="hidden">
				<input id="aalong" type="hidden">
				<a class="btn btn-primary" id='getlatlongadd' style="position: absolute;right:30px; top:-8px;" ><img src="<?php echo $this->webroot; ?>img/location.png"></a>
        <p class="amsg" style="color:red;"></p>
			</div>
			<div class="map_outer">
				<div id="mapaddress" style="position: absolute; right:-600px;top:0; width:500px;height:300px"></div>
			</div>
          </div>
          <div class="form-group" style="text-align:right;">
            <button class="btn btn-default defltflat_btn text-center" id="addressubmit"  type="button" >
                <?php if ($arabic != 'ar') { ?>Submit<?php }else{ echo "عرض"; } ?> 
            <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
          </div>
        </form>
      </div><!-- End Here -->
    </div><!-- End Here -->
  </div>
</div>
<script type="text/javascript">    
 jQuery.noConflict()(function ($) {   
    
jQuery(document).ready(function() {
jQuery('.map_outer').hide();		
	
	
	
    jQuery("#getlatlongadd").click(function(){
        console.log('clicked')
		if(jQuery("#aaddress").val()==''){
			jQuery(".amsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Enter Address and click Map Icon!');
		}else{
	jQuery(".amsg").html(' ');
		jQuery('.map_outer').show();	
        jQuery.post("http://rajdeep.crystalbiltech.com/thoag/eng/restaurants/LatLongFromAddress",
        {
            address: jQuery("#aaddress").val()
        },
        function(data, status){
			console.log(data)
            console.log("Data: " + data + "\nStatus: " + status);
            if(status=='success'){
                var res = JSON.parse(data);
                displayMap(res.latitude,res.longitude)
            }
            
        });
	}
    });
	
	    function displayMap(latitude,longitude){
        console.log('display mapaddress')
       // $('#RestaurantLatitude').val(latitude)
       // $('#RestaurantLongitude').val(longitude)
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var mapCanvas = document.getElementById("mapaddress");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter,draggable: true});
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function(evt){
            //console.log('dragged')
			//console.log(evt)
			//console.log(marker)
            $('#aalat').val(evt.latLng.lat())
            $('#aalong').val(evt.latLng.lng())
			GetAddress(evt.latLng.lat(),evt.latLng.lng());
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }
	
	
	 function GetAddress(lat,lng) {
            //var lat = parseFloat(document.getElementById("aalat").value);
           // var lng = parseFloat(document.getElementById("aalong").value);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                       // alert("Location: " + results[1].formatted_address);
					jQuery("#aaddress").val(results[1].formatted_address);
						//console.log(results[1].formatted_address)
                    }
                }
            });
        }
	
	
	
	
   
          var addressform = jQuery("#addressform").validate({
  errorClass: "my-error-class",
    validClass: "my-valid-class", 
        rules: {
              aphone : {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  },
			title:{ required: true },	  
          recipent_mobile : {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  }
        },
        messages: {
          
          title: {  
                    required: "Please enter valid title name", 
                },
                phone: {  
                    required: "Please enter valid number(9 digits)",  
                },
         recipent_mobile: {  
                    required: "Please enter valid number(9 digits)",  
                }
        }
    });


     jQuery("#addressubmit").click(function(e){    

     e.preventDefault();
       
        if(addressform.form())
        {
        } 
        else{
            return false;
        }      
var uid = jQuery("#uid").val();
var aaddress = jQuery("#aaddress").val();
var title = jQuery("#title").val();
var aphone = jQuery("#aphone").val();
var aname = jQuery("#aname").val();
var recipent_mobile = jQuery("#recipent_mobile").val();

// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[Address][name]='+ aname+ '&data[Address][title]='+ title+ 
        '&data[Address][address]='+ aaddress+ '&data[Address][recipent_mobile]='+ recipent_mobile+
        '&data[Address][user_id]='+ uid+'&data[Address][phone]='+ aphone;    
 
// AJAX Code To Submit Form.
jQuery.ajax({ 
type: "POST", 
url: "<?php echo $this->webroot; ?>addresses/add", 
data: dataString,
cache: false,
success: function(result){
    if(result){
     // alert('Your Address has been saved.');  
  window.location.reload();
       jQuery(".checkmsg").html(' ');
      jQuery(".checkmsg").html('The Address has been Saved!');
		
    jQuery('html, body').animate({
        scrollTop: jQuery(".checkmsg").offset().top 
    }, 2000);  
    } 

}
});

return false;
});

  });
        }); 

</script>    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initAutocomplete"
        async defer></script>        