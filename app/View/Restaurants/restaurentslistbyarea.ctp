<div class="caterer_sec menu">
  <div class="container-fluid">

        	<div class="row">
  
  <div class="col-sm-12">
               <?php foreach($listbyarea as $val1) : ?>   
                <div class="col-sm-4">
                	<div class="feature_grid hvr-wobble-horizontal voffset6">
                   <a href="<?php echo $this->webroot."restaurants/detail/".$val1['Restaurant']['id'];?>"> 
                       <div class="feature_img "><img src="<?php echo $this->webroot."files/restaurants/".$val1['Restaurant']['banner'];?>" class="img-responsive" alt="" >
                       </div>
                   </a>
                    <div class="feature_txt">
                    <div class="feature_title"><?php echo $val1['Restaurant']['name'] ;?></div>
                    <div class="feature_type">
                    	<span class="label label-default">Italian</span>
                        <span class="label label-default">Mission</span>
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
                         Lead time: 3hrs
                         </div>
                         <div class="feature_redbg"><span>Featured</span></div>
                         <div class="feature_wtricon"><img src="<?php echo $this->webroot."files/restaurants/".$val1['Restaurant']['logo'];?>" alt="" ></div>
                    </div>
                    
                    	
                    </div>
                </div><!--col-sm-4-->
              <?php  endforeach; ?>   
 
                </div>
       </div>
     </div>
 </div>     