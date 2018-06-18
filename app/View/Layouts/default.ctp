<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/x-icon" href="<?php echo $this->webroot."home/images/android-icon-36x36.png";?>" />
    <title><?php echo "Thoag-". $title_for_layout; ?></title>     
 <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <!-- Bootstrap -->
    <link href="<?php echo $this->webroot."home/";?>css/bootstrap.min.css" rel="stylesheet">    
        <!--Open Sense Font Css-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
    <!--Font Awesome CSS-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    
     <!-- Material Design Bootstrap --> 
    <link href="<?php echo $this->webroot."home/";?>css/mdb.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- Style Sheet-->
    <link href="<?php echo $this->webroot."home/";?>css/style.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot."home/";?>css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot."home/";?>css/slick-theme.css">
    
   <link href="<?php echo $this->webroot."home/";?>css/hover.css" rel="stylesheet" media="all">   
     <!--label checked-->     
     <link href="<?php echo $this->webroot."home/";?>css/jquery-labelauty.css" rel="stylesheet" media="all">
     <script src="<?php echo $this->webroot."home/";?>js/1.12.4-jquery.min.js"></script>     
   
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <?php  echo $this->App->js(); ?>  
    <?php echo $this->fetch('meta'); ?>
    <?php echo $this->fetch('css'); ?> 
    <?php  echo $this->fetch('script'); ?>      
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.css">
  <style type="text/css">
    #myform .list-this span{
      display: inline-block;
    height: 46px;
    line-height: 46px;
    padding: 0px 15px;
    border: 1px solid #e4e6e8;
    font-size: 16PX;
    margin: 0PX;
    float: left;
    }
    #myform .list-this input.form-control{
      width: 70%;
    display: inline-block;
    margin: 0PX;
    float: left;
    margin-left: 4%;
    }
	.cart-menu-ab{
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
    height: 96px;
}
  </style>
  </head> 
  <?php
  $title = $this->fetch('title');
  if($title == 'Restaurantsearch' || $title == 'orderlist' || $title =='Orderhistory'){
    $class = ' for-menu';
  }else{
    $class = '';
  }
  ?>
  <body class="<?php echo $this->fetch('title').$class; ?>"> 
     <div class="float-panel" data-top="0" data-scroll="500">  
    <div class="header_sec">
    <nav class="navbar navbar-default ">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        <div class="col-sm-4">
        <div class="leftop_menu">
<?php 
echo $this->I18n->flagSwitcher(array(
	'class' => 'nav navbar-nav',
	'id' => 'language-switcher'
));
 
?>         
          </div>
          </div>
          <div class="col-sm-4"> 
          	 <div class="logo">
              <?php
echo $this->Html->image("/home/images/thoag-01.svg", array(
    "alt" => "logo",
    'url' => array('controller' => 'products', 'action' => 'index')
));              
 ?>         

          </div>
           </div>
          <div class="col-sm-4">
          <div class="righttp_sec">
              <ul class="nav navbar-nav navbar-right cart-menu">
                      <?php 
                            if($arabic=='ar'){
                                $arb = $arabic;  
                                 }else{
                                  $arb = "eng";   
                                  }
                      
                   $cshop = $this->Session->read('cart_count'); 
				  
                  if($cshop > 0 ){
                        ?>
                    <li><a class="cartslide" href="<?php echo $this->webroot.$arb."/shop/address"; ?>"><?php if ($arabic != 'ar') { ?><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php }else { echo "سلة التسوق"; } ?><span id="cartcount"><?php  $cshop = $this->Session->read('cart_count'); if($cshop) {  echo $cshop;}else{ echo "0"; } ?> </span></a></li>  
                    <?php 
               
                   }
                    ?>
              </ul>
              <ul class="nav navbar-nav navbar-right cart-menu-ab">
               <?php if (empty($loggeduser)){ ?>   
               <li class="bf-lg-mn"><a href="#"  role="button" data-toggle="modal" data-target="#Login"><?php if ($arabic != 'ar') { ?>  
                           Log In
                        <?php }else { echo "تسجيل الدخول"; } ?></a></li>
                <li class="bf-lg-mn"><a href="#" class="active"  data-toggle="modal" data-target="#RegisterModal">
                      <?php if ($arabic != 'ar') { ?>   
                           Sign Up 
                        <?php }else { echo "سجل"; } ?> 
                    </a></li> 
                <?php } else { ?>
                
                
                <li><a href="">&nbsp;</a></li>
                  <?php       
          if ($loggeduserimg != '') {  
                    if (!filter_var($loggeduserimg, FILTER_VALIDATE_URL) === false) {
                         $image = $loggeduserimg;
                    } else {
                      $image= $this->webroot."files/profile_pic/".$loggeduserimg;
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                     $image= $this->webroot."files/profile_pic/no_img.png";
                }                     
          ?>  
                
                <li class="profilepic"><a href="#"><img src="<?php echo $image; ?>" height="20" width="20"></a></li>   
                <li class="dropdown"> 
                    <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                         <?php if ($arabic != 'ar') { ?>  
                           Hi
                        <?php }else { echo "مرحبا"; }  ?> 
						
                        <strong><?php if(empty($loggedusername)){ ?> <?php if ($arabic != 'ar') { ?>Welcome<?php }else { echo "أهلا بك"; } ?> <?php }else{ echo $loggedusername ;} ?></strong> <img src="<?php echo $this->webroot;?>home/images/signupdropdwn.png"  alt="" class="arrw_drop"></a>
                  <ul class="dropdown-menu">
                      
                    <li><a href="<?php echo $this->webroot.$arb."/users/myaccount" ;?>"><?php if ($arabic != 'ar') { ?>My Account<?php }else { echo "حسابي"; } ?></a></li> 
                    <li><a href="<?php echo $this->webroot.$arb."/users/edit"; ?>"><?php if ($arabic != 'ar') { ?>Edit Profile<?php }else { echo "تعديل الملف الشخصي"; } ?></a></li>
                    <li><a href="<?php echo $this->webroot.$arb."/users/changepassword"; ?>"><?php if ($arabic != 'ar') { ?>Change Password<?php }else { echo "تغيير كلمة السر"; } ?></a></li>
               
                    <li><a href="<?php echo $this->webroot.$arb.'/users/logout'; ?>"><?php if ($arabic != 'ar') { ?>Log Out<?php }else { echo "الخروج"; } ?></a></li>
              
                  </ul>
                </li> 
            	 <?php } ?>	 
                  
              </ul>
          </div>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    </div>
    </div>
   <?php $pageTitle = $this->fetch('title'); 
 if($pageTitle == 'Products'):
 $x=$this->Session->flash(); 
           if($x)
           {
               echo $x;  
           }  
     ?>  
      
    <header> 
    <div class="header">
        <div class="bg_vdio">
         <video  controls autoplay width="100%" loop> 
  <source src="<?php echo $this->webroot."home/";?>video/intro.mp4" type="video/mp4" >
 
  Your browser does not support the video tag.
</video> 
        
         </div>
        <div class="overlay container">
            <?php 
            if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";  
            }
           
            echo $this->Form->create(null, [
    'url' => "/".$arb.'/restaurants/searchlisting/', 
    'type' => 'POST']); ?> 
           
            <div class="col-sm-12">
             <div class="row">
             <div class="form-group">
      <div class="col-md-6">
        <h1><?php if ($arabic != 'ar') { ?>I am looking for <?php }else { echo "أنا أبحث عن"; } ?></h1>
      </div>

      <div class="col-md-6">
      <div class="lookg_sec">
       <div class="form-group bmd-form-group is-filled">     
    <select class="form-control select" id="" name="ordertype">
        <option value="" class="service-small"><?php if ($arabic != 'ar') { ?>Select Type<?php }else { echo "اختر صنف"; } ?></option>
        <option value="catring"><?php if ($arabic != 'ar') { ?>Catering<?php }else { echo "تقديم الطعام"; } ?></option>
        <option value="pickup"><?php if ($arabic != 'ar') { ?>Pickup<?php }else { echo "امسك"; } ?></option>
        <option value="delivery"><?php if ($arabic != 'ar') { ?>Delivery<?php }else { echo "توصيل"; } ?></option>
         
    </select>
  </div>
  </div>
      
      </div>
    </div>
    </div>
    </div>
    <div class="col-sm-12">
          <div class="search_msg" style="text-align: left;color: red;"></div>
    <div class="search_sec">
      
   <ul class="list-inline clearfix"> 
   <li>
    <div class="form-group"> 
     <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i> </div>      
     
        <div class="form-group bmd-form-group"> 
         
            <input class="form-control" id="address" name="location" type="text" placeholder="<?php if ($arabic != 'ar') { ?>Location<?php }else { echo "موقعك"; } ?>">  
            <input class="form-control" id="cityLat" name="lat" type="hidden" value=""> 
            <input class="form-control" id="cityLng" name="long" type="hidden" value="">
        </div>
        
      
        
        </div>
    </div>
    </li>
    <li>
    <div class="form-group">       
       <div class="input-group">
        <div class="input-group-addon"> <i class="fa fa-calendar"></i></div>
        <input class="form-control" id="date" name="date" placeholder="<?php if ($arabic != 'ar') { ?>Event Date<?php }else { echo "تاريخ الحدث"; } ?>" type="text"/>
       </div>  
  
    </div>
    </li>
    <li>
    <div class="form-group">   
       
        <div class="input-group bootstrap-timepicker timepicker">
             <div class="input-group-addon"><i class="glyphicon glyphicon-time"></i></div>  
           <input id="timepicker" name="eventtime" placeholder="<?php if ($arabic != 'ar') { ?>Event Time<?php }else { echo "وقت الحدث"; } ?>" class="time ui-timepicker-input form-control" autocomplete="off">           
        </div>
        
    </div>
    </li>
    </ul>
    </div>
     <div class="go_btn">
         <input type="submit" value="<?php if ($arabic != 'ar') { ?>Go<?php }else { echo "اذهب"; } ?>" class="btn btn-raised btn-danger defult_btn">
     </div>
    </div>
   	 
    
     
        <?php echo $this->Form->end(); ?> 
        </div>
    </div>
</header>
<?php endif; ?>

      
  <!-----------catagorie_sec---------->   
   <div class="<?php if( $this->fetch('title') !='Restaurantsearch' 
          && $this->fetch('title') !='Single Product'    
          && $this->fetch('title') !='Address'){ echo "smart_container"; } ?>">  
      
    <?php echo $this->fetch('content'); ?>      
      
  
       
  </div>    
  
      
 

<!----------------------Footer------------------------------->
<footer class="footer_sec">
  
    	<div class="container">
        <div class="footer_secinner voffset5">
        	<div class="row">
           <div class="col-sm-12">
           <div class="col-sm-4">
           <div class="footer_menu">
           <h4><?php if ($arabic != 'ar') { ?>Information<?php }else { echo "معلومات"; } ?></h4>
           <ul>
		   
               <li><a href="<?php echo $this->webroot.$arb."/staticpages/about_us"; ?>"><?php if ($arabic != 'ar') { ?>About Us<?php }else { echo "قيمنا"; } ?></a></li>
            <li><a href="<?php echo $this->webroot.$arb."/staticpages/blog"; ?>"><?php if ($arabic != 'ar') { ?>Blog<?php }else { echo "مدونة"; } ?></a></li>
             <li><a href="<?php echo $this->webroot.$arb."/staticpages/career"; ?>"><?php if ($arabic != 'ar') { ?>Careers<?php }else { echo "وظائف"; } ?></a></li>
              <li><a href="<?php echo $this->webroot.$arb."/staticpages/term_conditon"; ?>"><?php if ($arabic != 'ar') { ?>Terms & Conditions<?php }else { echo "البنود و الظروف"; } ?></a></li>
              <li><a href="<?php echo $this->webroot.$arb."/staticpages/faq"; ?>"><?php if ($arabic != 'ar') { ?>FAQ<?php }else { echo "شرط"; } ?></a></li>
           </ul> 
           </div>  
           </div>
           
           <div class="col-sm-4">
           <div class="footer_menu">
           <h4><?php if ($arabic != 'ar') { ?>My Account<?php }else { echo "حسابي"; } ?></h4>   
           <ul>
          <li><a href="#"><?php if ($arabic != 'ar') { ?>Why Caterers Must Join<?php }else { echo "لماذا يجب على أصحاب المطاعم الانضمام"; } ?></a></li>
            <li><a href="#"><?php if ($arabic != 'ar') { ?>Recommed Your Favourite Restaurant <?php }else { echo "يوصي مطعم المفضلة لديك"; } ?></a></li>
             <li><a href="<?php echo $this->webroot.$arb."/staticpages/contact_us"; ?>"><?php if ($arabic != 'ar') { ?>Contact Us <?php }else { echo "اتصل بنا"; } ?></a></li>
              <li><a href="<?php echo $this->webroot.$arb."/staticpages/support"; ?>"><?php if ($arabic != 'ar') { ?>Support <?php }else { echo "اتصل بنا"; } ?></a></li>
         
           </ul>
           </div>  
           </div>
           
           
           <div class="col-sm-4">
           <div class="social_menu">
           <h4><?php if ($arabic != 'ar') { ?>We would love new Friends to connect with<?php }else { echo "كنا نحب أصدقاء جدد للتواصل مع"; } ?></h4>
           <p><?php if ($arabic != 'ar') { ?>Follow the latest news, events, special offers and more on the following platforms
               <?php }else { echo "متابعة أحدث الأخبار والأحداث والعروض الخاصة وأكثر على المنصات التالية"; } ?>.</p>  
           <ul>
               
               <li><a href="<?php if(!empty($admin_setting[8]['Setting']['value'])){ echo $admin_setting[8]['Setting']['value']; } ?>" class="hvr-wobble-vertical"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="<?php if(!empty($admin_setting[10]['Setting']['value'])){ echo $admin_setting[10]['Setting']['value']; } ?>" class="hvr-wobble-vertical"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="<?php if(!empty($admin_setting[9]['Setting']['value'])){ echo $admin_setting[9]['Setting']['value']; } ?>" class="hvr-wobble-vertical"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li> 
            
           </ul>
           </div> 
           </div>
           
           </div>
           
           <div class="col-sm-12">
           	<div class="copyright voffset4">
            	<p>&copy; <?php if ($arabic != 'ar') { ?>2016|Thoag Rights Reserved<?php }else { echo "2016 | ثواغ ريتس ريسرفيد"; } ?></p>
            </div>
           </div>
          </div>
         </div>
       </div>

  </footer>
  
  
        
  
 <!---------------Register Popup------------------->  

<div id="RegisterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title"><img src="<?php echo $this->webroot."home/";?>images/thoag.svg" alt="" ></h1>
        <h2><?php if ($arabic != 'ar') { ?>Welcome<?php }else { echo "أهلا بك"; } ?></h2>
        <p class="heading"><?php if ($arabic != 'ar') { ?>Please sign up to see our Caterers, Menus and Thoag Values
            <?php }else { echo "يرجى الاشتراك لمعرفة لدينا مقدمي الطعام والقوائم وقيم ثواغ"; } ?>.</p>  
             
      </div>
      <div class="modal-body">
      <div class="sign_sec">
        
      <p><?php if ($arabic != 'ar') { ?>Sign in with your favourite Social Account<?php }else { echo "سجل الدخول باستخدام الحساب الاجتماعي المفضل لديك"; } ?></p>
         <div class="col-sm-4">
      	<div class="lgsocl_icon">
              <a type="button" class="fb-fb" id="facebook">
            <img src="<?php echo $this->webroot."home/";?>images/loginfb_icon.png" class="pull-left"> 
            </a>
        </div>
      </div>       
    
      
      <div class="col-sm-4">
      	<div class="lgsocl_icon">
       <a type="button" href="<?php echo $authUrl; ?>"><img src="<?php echo $this->webroot."home/";?>images/logingpls_icon.png" ></a></div>
      </div>       
     
      
      <div class="col-sm-4">
      	<div class="lgsocl_icon">
            <a href="<?php echo $this->webroot."users/twitter_process"?>"><img src="<?php echo $this->webroot."home/";?>images/logintwiter_icon.png" class="pull-right" ></a>
        </div>
      </div> 
            
    <div class="clearfix"></div>
      </div>
      
      <div class="text-center or_sec">  
        <h3><span class="line-center"><?php if ($arabic != 'ar') { ?>OR<?php }else { echo "أو"; } ?></span></h3> 
      
      </div>
      
        <div class="register_form">
                
        <form class="form-horizontal" id='myform'> 
        
        
   
    <div class="form-group"> 
     <div class="col-sm-11"> 
         <div class="msg" style="color:red;"></div>
        <input class="form-control" autocomplete="off" id="email1" name="data[User][email]"
               placeholder="<?php if ($arabic != 'ar') { ?>Email Address<?php }else { echo "عنوان البريد الإلكتروني"; } ?>" type="email" required>
      </div>
    </div>
    
    <div class="form-group"> 
    <div class="col-sm-3">
     <label for="inputEmail" class="col-md-2 control-label lbl-gndr"><?php if ($arabic != 'ar') { ?>Gender<?php }else { echo "جنس"; } ?></label>
     </div>
     <div class="col-sm-9">
        <ul id="lby-checkbox-demo">      
        <li>
        <input class="jquery-checkbox-label synch-icon" id="gender1" name="data[User][gender]" value="male" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Male<?php }else { echo "الذكر"; } ?>" checked/>
        </li>
        <li>
        <input class="jquery-checkbox-label terms-icon" id="gender2" name="data[User][gender]" value="female" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Female<?php }else { echo "إناثا"; } ?>"/>
        </li>
        
         
        </ul>
      </div>
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" id="dob" name="data[User][dob]" 
               placeholder="<?php if ($arabic != 'ar') { ?>Date of Birth<?php }else { echo "تاريخ الولادة"; } ?>" type="text" required>
      </div>
    </div>
    
    <div class="form-group">  
     <div class="col-sm-12">
         <div class="numberpre list-this">
        <span>+966</span> <input class="form-control field" autocomplete="off" id="contact" maxlength="9" name="phone"
               placeholder="<?php if ($arabic != 'ar') { ?>Mobile Number<?php }else { echo "رقم الهاتف المحمول"; } ?>" type="text" required>
        </div>
      </div>  
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" id="password1" name="password"
               placeholder="<?php if ($arabic != 'ar') { ?>Password<?php }else { echo "كلمه السر"; } ?>" type="password"> 
      </div>
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" name="data[User][cpassword]" id="password2"
               placeholder="<?php if ($arabic != 'ar') { ?>Confirm Password<?php }else { echo "تأكيد كلمة المرور"; } ?>" type="password">
      </div>
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
         <div class="refer" style="color:red;"></div> 
        <input class="form-control" autocomplete="off" id="referral_code" name="data[User][referral_code]" 
               placeholder="<?php if ($arabic != 'ar') { ?>Enter you friend's Referral Code (Optional)<?php }else { echo "أدخل رمز إحالة صديقك (اختياري)"; } ?>" type="text">
      </div>
    </div>
  
    
        </div>
         
        
      </div> 
      <div class="modal-footer ">
         
<p class="text-left voffset4">         
    <!--<input  type="checkbox" id="mycheck" name="termcondition" value="1" required>-->
    <?php if ($arabic != 'ar') { ?>By creating this account you agree to THOAG <?php }else { echo "من خلال إنشاء هذا الحساب فإنك توافق على ثواغ"; } ?>
  
   
	<span class="terms_text"><a href="#" class="fnt_redclr"><?php if ($arabic != 'ar') { ?>Terms and Conditions<?php }else { echo "الأحكام والشروط"; } ?></a></span>
        
        <p class='error_accept' style='color:red;text-align: left;'></p>
</p>
<div class="term_text">
	<p>
        <?php if ($arabic != 'ar') {  if(!empty($staticpage )){ echo $staticpage[7]['Staticpage']['description'];  } ?>
           <?php }else { if(!empty($staticpage )){ echo $staticpage[7]['Staticpage']['description_ar']; } }?>     
	</p>
</div>
<div class="text-center">
       <!-- <button type="button" class="btn btn-default defltflat_btn text-center" data-dismiss="modal" data-target="#vrfymodal">Create Account  <i class="fa fa-angle-right" aria-hidden="true"></i>
       </button>-->
  <p>
      <button class="btn btn-default defltflat_btn text-center" id="submitform"  type="button" >
          <?php if ($arabic != 'ar') { ?>Create Account<?php }else { echo "إصنع حساب"; } ?> 
      <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
  </p>
</div>

<p class="text-center"> <?php if ($arabic != 'ar') { ?>Already have an Account?<?php }else { echo "هل لديك حساب بالفعل؟"; } ?> <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#Login" > <?php if ($arabic != 'ar') { ?> Log In<?php }else { echo "تسجيل الدخول"; } ?></a></p>
<p class="text-center">
    <a href="<?php echo $this->webroot; ?>users/forgetpwd" style="color:#3d3d3d;" class="fnt_redclr">
      <?php if ($arabic != 'ar') { ?> Forgot Password?<?php }else { echo "هل نسيت كلمة المرور؟"; } ?> 
    </a>
</p>
      </div>
     </form>
        	     
    </div>

  </div>
</div>
 
 
  <!---------------Register Popup-------------------> 
  
  
  
      <!---------------Caterer Register Popup------------------->  

<div id="catereregisterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title"><img src="<?php echo $this->webroot."home/";?>images/thoag.svg" alt="" ></h1>
        <h2><?php if ($arabic != 'ar') { ?>Welcome<?php }else { echo "أهلا بك"; } ?></h2>
        <p class="heading"><?php if ($arabic != 'ar') { ?>Please sign up to see our Caterers, Menus and Thoag Values
            <?php }else { echo "يرجى الاشتراك لمعرفة لدينا مقدمي الطعام والقوائم وقيم ثواغ"; } ?>.</p>  
             
      </div>
      <div class="modal-body" style="padding-bottom:0;">
      <div class="sign_sec">
            
    <div class="clearfix"></div>
      </div>
      
      <div class="text-center or_sec">  
      
      
      </div>
      
        <div class="register_form">
                
        <form class="form-horizontal" id='catereform'> 
        
        <div class="form-group"> 
     <div class="col-sm-11"> 
         <div class="msg" style="color:red;"></div>
        <input class="form-control" autocomplete="off" id="namec" name="name"
               placeholder="<?php if ($arabic != 'ar') { ?>Enter Name<?php }else { echo "أدخل الاسم"; } ?>" type="text" required>
      </div>
    </div>
   
    <div class="form-group"> 
     <div class="col-sm-11"> 
         <div class="msg" style="color:red;"></div>
        <input class="form-control" autocomplete="off" id="emailc" name="data[User][email]"
               placeholder="<?php if ($arabic != 'ar') { ?>Email Address<?php }else { echo "عنوان البريد الإلكتروني"; } ?>" type="email" required>
      </div>
    </div>
    
    <div class="form-group"> 
    <div class="col-sm-3">
     <label for="inputEmail" class="col-md-2 control-label lbl-gndr"><?php if ($arabic != 'ar') { ?>Gender<?php }else { echo "جنس"; } ?></label>
     </div>
     <div class="col-sm-9">
        <ul id="lby-checkbox-demo">      
        <li>
        <input class="jquery-checkbox-label synch-icon" id="gender1c" name="data[User][gender]" value="male" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Male<?php }else { echo "الذكر"; } ?>" checked/>
        </li>
        <li>
        <input class="jquery-checkbox-label terms-icon" id="gender2c" name="data[User][gender]" value="female" type="radio"
               data-labelauty="<?php if ($arabic != 'ar') { ?>Female<?php }else { echo "إناثا"; } ?>"/>
        </li>
        
         
        </ul>
      </div>
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" id="dobc" name="data[User][dob]" 
               placeholder="<?php if ($arabic != 'ar') { ?>Date of Birth<?php }else { echo "تاريخ الولادة"; } ?>" type="text" required>
      </div>
    </div>
    
    <div class="form-group">  
     <div class="col-sm-12">
         <div class="numberpre list-this">
        <span>+966</span> <input style="margin:0; border-left:none;" class="form-control field" autocomplete="off" id="contactc" maxlength="9" name="phone"
               placeholder="<?php if ($arabic != 'ar') { ?>Mobile Number<?php }else { echo "رقم الهاتف المحمول"; } ?>" type="text" required>
        </div>
      </div>  
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" id="password1c" name="password"
               placeholder="<?php if ($arabic != 'ar') { ?>Password<?php }else { echo "كلمه السر"; } ?>" type="password"> 
      </div>
    </div>
    
    <div class="form-group"> 
     <div class="col-sm-11">
        <input class="form-control" autocomplete="off" name="data[User][cpassword]" id="password2c"
               placeholder="<?php if ($arabic != 'ar') { ?>Confirm Password<?php }else { echo "تأكيد كلمة المرور"; } ?>" type="password">
      </div>
    </div>

  
    
        </div>
         
        
      </div> 
	  
      <div class="modal-footer ">
         
<p class="voffset4 txt_frt" >         
    <!--<input  type="checkbox" id="mycheck" name="termcondition" value="1" required>-->
    <?php if ($arabic != 'ar') { ?>By creating this account you agree to THOAG <?php }else { echo "من خلال إنشاء هذا الحساب فإنك توافق على ثواغ"; } ?>
    <!--<span>Terms and Conditions</span> --> 
   
	<span class="terms_text"><a href="#" class="fnt_redclr"><?php if ($arabic != 'ar') { ?>Terms and Conditions<?php }else { echo "الأحكام والشروط"; } ?></a></span>
        
        <p class='error_accept' style='color:red;text-align: center;'></p>
</p>
<div class="term_text">
	<p>
	
       <?php if ($arabic != 'ar') {  if(!empty($staticpage )){ echo $staticpage[7]['Staticpage']['description'];  } ?>
           <?php }else { if(!empty($staticpage )){ echo $staticpage[7]['Staticpage']['description_ar']; }} ?>     
		
	</p>
</div>
<div class="text-center">
       <!-- <button type="button" class="btn btn-default defltflat_btn text-center" data-dismiss="modal" data-target="#vrfymodal">Create Account  <i class="fa fa-angle-right" aria-hidden="true"></i>
       </button>-->
  <p>
      <button class="btn btn-default defltflat_btn text-center" id="cateresubmitform"  type="button" >
          <?php if ($arabic != 'ar') { ?>Join Us<?php }else { echo "إصنع حساب"; } ?> 
      <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
  </p>
</div>

      </div>
     </form>
        	     
    </div>

  </div>
</div>
  
  
  
  
  <!------------------Popup Verify------------------------------>



  </div>
</div>   
 
  
   <!---after signup--->
   

   
   <div id="vrfymodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button> 
       <img src="<?php echo $this->webroot."home/";?>images/thoag.svg"  alt="">
       <h3><?php if ($arabic != 'ar') { ?> Verify your Account<?php }else { echo "تحقق من حسابك"; } ?></h3>
       <p>
         <?php if ($arabic != 'ar') { ?> Please sign up to see our Caterers, Menus and Thoag Values.
             
             <?php }else { echo "يرجى الاشتراك لمعرفة لدينا مقدمي الطعام والقوائم وقيم ثواغ."; } ?>  
       </p>
        
      </div>
      <div class="modal-body verify">       
      <form id="verifyForm">
          <p id="thanks" class="msg"></p> 
          <input class="form-control" autocomplete="off" name="verify_code" id="verify_code" type="text"
                 placeholder="<?php if ($arabic != 'ar') { ?>Enter Code Here<?php }else { echo "أدخل رمز هنا"; } ?>">
        <input class="form-control" type="hidden" name="v_userid" id="v_userid" value="">
        <button type="button" id="verifybtn" class="btn defult_btn btn-md vrfy_btn">
                <?php if ($arabic != 'ar') { ?>Continue
             
             <?php }else { echo "استمر"; } ?> 
             
            <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
        <button class="txt_red" id="resend" > <?php if ($arabic != 'ar') { ?>Resend Code
             
             <?php }else { echo "أعد إرسال الرمز"; } ?> </button>       
     </form>  
       
      </div>
      
        
         
      </div>
    </div>
   </div>    
    <!-------end verifed pop------>   
  

     <!-------Alert box------> 
<div id="loginsuccess" class="modal fade" role="dialog">
  <div class="modal-dialog asff">
 
    <!-- Modal content-->
    <div class="modal-content">	 
<div class="alert_box">  
      <div class="modal-header">  
        <h1 class="modal-title"><img src="/thoag/home/images/thoag.svg" alt=""></h1> 
      </div>
      <div class="modal-body">
        <center><img src="/thoag/home/images/logintick.png" alt=""></center>
        <h2 class="login fnt_opensans">Welcome to Thoag! <br>Login Successful </h2>    
        <div style="text-align:center">
          <a href="#" id="successclose" class="btn defult_btn">Ok</a>
        </div>
      </div>
</div>

 </div>
</div>
</div>
</div>
   
  
         
<!---------------Login Popup------------------->   
<!-- Modal -->
<div id="Login" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">  
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title"><img src="<?php echo $this->webroot."home/";?>images/thoag.svg" alt="" ></h1>
        <p class="heading">
            <?php if ($arabic != 'ar') { ?> We work hard even while you're away to bring the BEST delights to any event.
             
             <?php }else { echo "نحن نعمل بجد حتى في حين كنت بعيدا لجلب أفضل المسرات إلى أي حدث."; } ?> 
           
        </p>
        <h2 class="login fnt_opensans">  <?php if ($arabic != 'ar') { ?> Log In
             
             <?php }else { echo "تسجيل الدخول"; } ?> </h2>
      </div>
      <div class="modal-body">      
      
         <form  id="myLogin" class="login-frm">
       
         <div class="form-group label-floating">
         <div class="invalid" style="color:red;"> </div>   
         <div class="uemail" style="color:red;"> </div>   
	<input type="text" autocomplete="off" id="uemail" name="username"
               placeholder="<?php if ($arabic != 'ar') { ?>Email Address<?php }else { echo "عنوان البريد الإلكتروني"; } ?>" class="form-control" >
         </div>
          <div class="form-group label-floating">
               <div class="upass" style="color:red;"> </div>  
			<input type="Password"  autocomplete="off" id="upass" name="password"
                               placeholder="<?php if ($arabic != 'ar') { ?>Password<?php }else { echo "كلمه السر"; } ?>" class="form-control">
			<input type="hidden" id="server" name="data[User][server]" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
         </div>
            <div class="chckbox">  
				<input type="checkbox">
                                <?php if ($arabic != 'ar') { ?> Login as Caterer
             
             <?php }else { echo "تسجيل الدخول كمزود"; } ?>
                                
			</div>  
        <div class="text-center">
            <div class="button_outer">
                <input style="line-height:30px; height: 30px;" type="submit" value="<?php if ($arabic != 'ar') { ?> Log In<?php }else { echo "تسجيل الدخول"; } ?>" id="loinbtn"></div>
			<div class="spacer_ten"></div>
			<p><a href="<?php echo $this->webroot; ?>users/forgetpwd">
                               <?php if ($arabic != 'ar') { ?>  
                                Forgot Password?
                        <?php }else { echo "هل نسيت كلمة المرور؟"; } ?>
                               
                            </a></p>
			<h3><span class="line-center"> <?php if ($arabic != 'ar') { ?>  
                               OR
                        <?php }else { echo "أو"; } ?></span></h3>
			<p class="fnt_drkgry"><?php if ($arabic != 'ar') { ?>  
                             Access with your Favourite Social Account
                        <?php }else { echo "الوصول مع الحساب الاجتماعي المفضلة لديك"; } ?></p>
		</div>
        </form>
       
      </div>
      <div class="modal-footer">
      
      <div class="col-xs-4">
        
          
      	<div class="lgsocl_icon">
            <a type="button" class="fb-fb" id="facebook1"> 
                <img src="<?php echo $this->webroot."home/";?>images/loginfb_icon.png" class="pull-left">
            </a>
        </div>
      </div>       
    
      
      <div class="col-xs-4">
      	<div class="lgsocl_icon">
          <a type="button" href="<?php echo $authUrl; ?>"> <img src="<?php echo $this->webroot."home/";?>images/logingpls_icon.png" ></a>
        </div>
      </div>       
     
      
      <div class="col-xs-4">
      	<div class="lgsocl_icon">
          <a href="<?php echo $this->webroot."users/twitter_process"?>">  <img src="<?php echo $this->webroot."home/";?>images/logintwiter_icon.png" class="pull-right" ></a>
        </div>
      </div>       
    
      
    </div>

  </div>
</div> 


     
  <!---------------Login Popup------------------->  
  

  
 
<!----------------------Footer------------------------------->
  
    
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

      <script src="<?php echo $this->webroot."home/";?>js/slick.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    jQuery(document).on('ready', function() {
      jQuery(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 7,
        slidesToScroll: 3
		
      });
     
    });
  </script>     
    <!-- Include all compiled plugins (below), or include individual files as needed -->    
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script> 
    <!-- MDB core JavaScript -->
   <!-- <script type="text/javascript" src="js/material.min.js"></script>
    <script type="text/javascript" src="js/ripples.min.js"></script>-->
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.1.0/jquery.form.js"></script>     
    <script type="text/javascript">

jQuery.noConflict()(function ($) { // this was missing for me
    
 
               
    $(document).ready(function() {
       
       $('#imageupload').on('change', function()	
{ 
    var A=$("#preview");

$("#preview").html('');

$("#imageform").ajaxForm(
{
target: '#preview',
beforeSubmit:function()

               {
                   A.html('');
$("#preview").html('<img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" alt="Uploading...."/>');
                
  
                }, success:function(){A.html(''); 
                    
    window.location.reload();
    },

                   error:function(){ A.html(''); } }).submit();
 //window.location = 'http://rajdeep.crystalbiltech.com/thoag/users/myaccount'; 
});

       
       
        $.validator.addMethod("lettersonly", function(value, element) {  
                return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);         
              }, "Letters only please"); 
              
              $.validator.addMethod("zeronot", function(value, element) {  
                return this.optional(element) || /^[1-9][0-9]*$/.test(value);          
              }, "Number starting with zero not allow");  

         
        var vlogin = $("#myform").validate({ 
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              phone : { 
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  },
             password:{ 
                required: true,
                minlength: 5 ,    
                maxlength:15                
                  } 
   
        }, 
        messages: { 
          
          phone: {
                    required: "Please enter valid Moblie Number(9 digits)",
                },
          password: {
                    required: "Please correct password format",
           }
        }
    });
	
	
	  var catere = $("#catereform").validate({ 
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              phone : { 
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  },
             password:{ 
                required: true,
                minlength: 5 ,    
                maxlength:15                
                  },
				name: { 
                required: true,
				lettersonly:true                
                  } 
   
        }, 
        messages: { 
          
          phone: {
                    required: "Please enter valid Moblie Number(9 digits)",
                },
          password: {
                    required: "Please correct password format",
           }
		   ,
          name: {
                    required: "Letters only allow",
           }
        }
    });
	
           var userlogin = $("#myLogin").validate({
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              username : { 
                required: true,
                email: true    
                  },
             password:{ 
                required: true              
                  }     
                  
        },
        messages: {
          
          username: {
                    required: "Please Enter valid Email Id",
                },
          password: {
                    required: "Please enter your password",
           }
        }
    });
    
    
          var useredit = $("#editform").validate({
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              zip : { 
                 number: true
                  } 
                 ,phone : {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  },state: {  
                 lettersonly:true 
                  } 
                  ,country:{  
                 lettersonly:true 
                  }
				  
        },
        messages: {
          
          zip: {  
                    required: "Please enter valid zip code", 
                },
                city1: {  
                    required: "Please enter valid city name",  
                },
                state: {   
                    required: "Please enter valid state name",  
                },
                phone: {  
                    required: "Please enter valid number(9 digits)",  
                }, country: {  
                    required: "Please enter valid country name", 
                }
        }
    });
    
  
   $("#submitform").click(function(e){ 
       
       e.preventDefault();
        if(vlogin.form())
        {
      /* if($('#mycheck').is(':checked')===true ){
             $(".error_accept").text("");
        }
        else{
            $(".error_accept").text("Please accept the terms and condition");
            return false;
        }*/
 
        }
        else{
            return false;
        }

var referral_code = $("#referral_code").val();
var email = $("#email1").val();
var password = $("#password1").val();
var contact = $("#contact").val();
 var pss2 = $("#password2").val();
  var dob = $("#dob").val();
 var gnder = $("#gender1").val();
var gnder1 = $("#gender2").val();
   var gender = '';
    if(gnder != ''){
        gender = gnder;
    }else if(gnder1 != ''){
        gender = gnder1;
    }
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][referral_code]='+ referral_code + '&data[User][dob]='+ dob +'&data[User][email]='+ email + '&data[User][password]='+ password + '&data[User][phone]='+ contact +'&data[User][gender]='+ gender;


if(email==''||password==''||contact==''||dob=='')
{
alert("Please Fill All Fields");
}else if(password != pss2){
           alert('password mismatch');
           return false ;
} 
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/add",
data: dataString,
cache: false,
success: function(result){
 var obj = $.parseJSON( result);
 if(obj.msg =='Email_id already exist'){
      $(".msg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);    
      $('#RegisterModal').animate({ scrollTop: 100 }, 'fast'); 
      $(".refer").html(' ');
 }else if(obj.msg =='Invalid refferal code'){
    $(".refer").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);    
    $('#RegisterModal').animate({ scrollTop: 500 }, 'fast');  
    $(".msg").html(' ');  
 }
 else if(obj.msg =='Email_id already exist. Please verify your account for activation.'){    
     $("#thanks").html(obj.msg);  
     $("#v_userid").val(obj.user_id)
      $("#RegisterModal").modal('hide');  
   $('#vrfymodal').modal('show');  
 }else{
  $("#thanks").html(obj.msg)
  $("#v_userid").val(obj.user_id)
$("#RegisterModal").modal('hide');   
$('#vrfymodal').modal('show');
 }
}
});
}
return false;
});



 $("#cateresubmitform").click(function(e){ 
       
       e.preventDefault();
        if(catere.form())
        {
      /* if($('#mycheck').is(':checked')===true ){
             $(".error_accept").text("");
        }
        else{
            $(".error_accept").text("Please accept the terms and condition");
            return false;
        }*/
 
        }
        else{
            return false;
        }

var email = $("#emailc").val();
var namec = $("#namec").val();
var password = $("#password1c").val();
var contact = $("#contactc").val();
 var pss2 = $("#password2c").val();
  var dob = $("#dobc").val();
 var gnder = $("#gender1c").val();
var gnder1 = $("#gender2c").val();
   var gender = '';
    if(gnder != ''){
        gender = gnder;
    }else if(gnder1 != ''){
        gender = gnder1;
    }
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][dob]='+ dob +'&data[User][email]='+ email + '&data[User][password]='+ password +
 '&data[User][phone]='+ contact +'&data[User][gender]='+ gender +'&data[User][name]='+ namec;


if(email==''||password==''||contact==''||dob=='') 
{
alert("Please Fill All Fields");
}else if(password != pss2){
           alert('password mismatch');
           return false ;
} 
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/catereradd",
data: dataString,
cache: false,
success: function(result){
 var obj = $.parseJSON( result);
 if(obj.msg =='Email_id already exist'){
      $(".msg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);    
      $('#catereregisterModal').animate({ scrollTop: 100 }, 'fast'); 
      $(".refer").html(' ');
 }else if(obj.msg =='Email_id already exist. Please verify your account for activation.'){     
     $("#thanks").html(obj.msg);  
     $("#v_userid").val(obj.user_id)
      $("#catereregisterModal").modal('hide');  
   $('#vrfymodal').modal('show');  
 }else{
  $("#thanks").html(obj.msg)
  $("#v_userid").val(obj.user_id)
$("#catereregisterModal").modal('hide');   
$('#vrfymodal').modal('show');
 }
}
});
}
return false;
});


  /////////////////verify form//////////////
  
     $("#verifybtn").click(function(){ 

var code = $("#verify_code").val();
var v_userid = $("#v_userid").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'verification_code='+ code + '&user_id='+ v_userid;
if(code=='')
{
alert("Please Fill code");
} 
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/verifyEmail",
data: dataString,
cache: false,
success: function(result){
 var obj = $.parseJSON( result);
  if(obj.msg =='Your account Verified Successfully Welcome to Thoag'){
 alert('Your account verified Successfully. Welcome to Thoag'); 
  window.location.href ='<?php echo $this->webroot; ?>';
// window.location = 'http://rajdeep.crystalbiltech.com/thoag/'; 
 }else{
   $("#thanks").html(obj.msg);   
 }

}
});
}
return false;
});

  /////////////////Login form//////////////
  
     $("#loinbtn").click(function(e){
     
        e.preventDefault();
       
        if(userlogin.form())
        {
        }
        else{
            return false;
        }

var uemail = $("#uemail").val();
var upass = $("#upass").val();
var server = $("#server").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][username]='+ uemail + '&data[User][password]='+ upass+ '&data[User][server]='+ server;

// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/login",
data: dataString,
cache: false,
success: function(result){
 //alert(result);
 var obj = $.parseJSON( result);

  if(obj.msg =='Login successfully'){
  $('#Login').modal('hide');
  
  $('#loginsuccess').modal('show');

 //alert('Login successful. Welcome to Thoag'); 
 //window.location = 'http://rajdeep.crystalbiltech.com/thoag/';  
   // window.location.reload();     
 }else if(obj.msg =='admintrue'){
   $('#Login').modal('hide');
   window.location.href ='<?php echo $this->webroot."admin/dashboards"; ?>';
 }else{
   if(obj.msg =='User does not Exist'){      
       $(".uemail").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg); 
        $(".upass").html(' ');    
        $(".invalid").html(' ');    
   }else if(obj.msg =='Wrong Password'){
           $(".upass").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);  
         $(".uemail").html(' ');
         $(".invalid").html(' ');
   }else if(obj.msg =='Invalid User'){ 
           $(".invalid").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);  
         $(".uemail").html(' ');
         $(".upass").html(' ');
   }  
 }   

} 
}); 

return false;
});


$("#successclose").click(function(e){ 
     
       e.preventDefault();
	     $('#loginsuccess').modal('hide'); 
  window.location.reload();   
});
////////edit form/////////

     $("#editsubmit").click(function(e){ 
     
       e.preventDefault();
       
        if(useredit.form())
        {
        } 
        else{
            return false;
        }   

var email = $("#email").val();
var state = $("#state").val();
var username1 = $("#username1").val();
var edob = $("#edob").val();
var egender = $("#egender").val(); 
var name = $("#name").val();
var zip = $("#zip").val();
var phone = $("#phone").val();
var city = $("#city").val(); 
var address1 = $("#address1").val(); 
var country = $("#country").val(); 
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][name]='+ name+ '&data[User][zip]='+ zip+ 
        '&data[User][city]='+ city+ '&data[User][address]='+ address1+
        '&data[User][username]='+ username1+ '&data[User][email]='+ email+  
        '&data[User][state]='+ state+ '&data[User][phone]='+ phone+ '&data[User][country]='+
        country+ '&data[User][dob]='+ edob+ '&data[User][gender]='+ egender;    
 
// AJAX Code To Submit Form.   
$.ajax({ 
type: "POST", 
url: "<?php echo $this->webroot; ?>users/edit", 
data: dataString,
cache: false,
success: function(result){
    if(result){
      alert('Your profile has been Updated.'); 
 window.location = '<?php echo $this->webroot."users/myaccount"; ?>'; 
   
    } 

}
});

return false;
});



/////////////////Resend Verify pin//////////////
  
     $("#resend").click(function(){ 
var v_userid = $("#v_userid").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'user_id='+ v_userid;

// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/resendVerificationCode",
data: dataString,
cache: false,
success: function(result){
 var obj = $.parseJSON( result);
   $("#thanks").html(obj.msg);   
}
});

return false;
});
  
/////////////////search location validation//////////////////////
  jQuery('#ProductIndexForm').on('submit', function(event){
if(jQuery('#address').val() == ''){  
    event.preventDefault();
        jQuery(".search_msg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Enter Search Location');
        
      }
});

    $("#getstart").click(function(){
		 jQuery('html, body').animate({
        scrollTop: jQuery(".header").offset().top 
    }, 2000); 
	
	$('#ProductIndexForm').submit();
	});
	
	
	




    });
$('#loginsuccess').modal({
  backdrop: 'static',
  keyboard: false,
  show:false
}); 

});

    </script> 
    <script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
    
    
    
    <script type="text/javascript" src="<?php echo $this->webroot."home/";?>js/mdb.js"></script>
     
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	jQuery(document).ready(function(){
		var date_input=jQuery('input[name="date"]'); //our date input has the name "date"
		var container=jQuery('.bootstrap-iso form').length>0 ? jQuery('.bootstrap-iso form').parent() : "body";
		var nowDate = new Date();
		var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
			startDate: today
		})
                
                   
                var dob_input=jQuery('#dob'); //our date input has the name "date" 
		var container=jQuery('.bootstrap-iso form').length>0 ? jQuery('.bootstrap-iso form').parent() : "body";
		dob_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
			endDate: today  
		})
		
		  var dob_input=jQuery('#dobc'); //our date input has the name "date" 
		var container=jQuery('.bootstrap-iso form').length>0 ? jQuery('.bootstrap-iso form').parent() : "body";
		dob_input.datepicker({ 
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
			endDate: today
		})
                
                var dob_input=jQuery('#eventdate'); //our date input has the name "date" 
		var container=jQuery('.bootstrap-iso form').length>0 ? jQuery('.bootstrap-iso form').parent() : "body";
		dob_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
			setDate: today,
			startDate: today
		}) 
                
                var edob_input=jQuery('#eventdateonserch'); //our date input has the name "date" 
		var container=jQuery('.bootstrap-iso form').length>0 ? jQuery('.bootstrap-iso form').parent() : "body";
		edob_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
			startDate: today
		}) 
                
               /*  jQuery('#datepairExample .time').timepicker({  
        'showDuration': true,
        'timeFormat': 'g:ia' 
    }
	,'setTime', new Date(new Date().getTime()-2.5 *3600*1000)
	);*/
                
                
	})
</script>  

<!-- Include Time Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.1/jquery.timepicker.min.js
"></script>

<script type="text/javascript">
          jQuery('#timepicker').timepicker();
 //jQuery('#timepicker').timepicker('setTime', new Date(new Date().getTime()-2.5 *3600*1000));
 jQuery('#etime').timepicker();
 
   jQuery('#timep').timepicker();  

// jQuery('#timep').timepicker('setTime', new Date(new Date().getTime()-2.5*3600*1000));    
        </script>
        
  <!--------------label checked--------------->  
 
  <script src="<?php echo $this->webroot."home/";?>js/jquery-labelauty.js" ></script>
  <script>
 
   jQuery(document).ready(function(){
 
     jQuery(".jquery-checkbox-label").labelauty({ minimum_width: "120px" });
 
       jQuery(".to-labelauty-icon").labelauty({ label: false });
 
});   
 
</script>      
  <!--------------label checked--------------->  
        
<script src="<?php echo $this->webroot."home/";?>js/float-panel.js"></script>
<?php echo $this->Html->script('oauthpopup');  ?>     
<script type="text/javascript">
            jQuery('#facebook').click(function(e){
	//alert('hello');
        jQuery.oauthpopup({ 
            path: '<?php echo $this->webroot;?>users/fblogin', 
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
	
        
              jQuery('#facebook1').click(function(e){
	//alert('hello');
        jQuery.oauthpopup({ 
            path: '<?php echo $this->webroot;?>users/fblogin', 
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
	jQuery(document).ready(function(){
		jQuery('.flash-msg').delay(5000).fadeOut('slow');
                jQuery('.message').delay(5000).fadeOut('slow');  
                
	});
	jQuery(document).ready(function(){
		jQuery('.fnt_redclr').click(function(){
			jQuery('.term_text').toggle();
		});
	});
      
	  /* var abcd = $.noConflict();
	  abcd(document).ready(function(e) {
        abcd(".cartslide").click(function(){
			alert("hello");
			}) */ 
        
  </script> 
 
  
  </body>
</html>       