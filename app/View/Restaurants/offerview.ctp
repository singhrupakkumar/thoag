<?php $this->set('title_for_layout', 'Single Offer');   ?> 
 <?php echo $this->Session->flash(); 
 
// print_r($offerdata);  
 ?>  
		
<section class="st-content">
		<section class="single_head">
                    <img src="<?php echo $this->webroot."files/offers/".$offerdata['Offer']['image'] ;?>" alt="<?php echo $offerdata['Offer']['name'] ;?>">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-center">
						<div class="product_name">
                                                        <h2 class="dish_name"><?php if ($arabic != 'ar') { echo $offerdata['Offer']['name']; }else{ echo $offerdata['Offer']['name_ar']; }?></h2>
							<span class="price_add"><?php // echo $prodata['data']['Restaurant']['currency'] ;?>SAR <?php echo $offerdata['Offer']['price'] ;?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="clr"></div>    
		</section><!-- End Here --> 
		<section class="product_choice">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-center">
                                            <h4> <?php if ($arabic != 'ar') { ?>Description<?php }else { echo "وصف"; } ?></h4>
                                                <p class="choice-sec"><?php if ($arabic != 'ar') { echo $offerdata['Offer']['description']; }else{ echo $offerdata['Offer']['description_ar']; } ?></p> 
						
					
					<!--<ul class="product-details">
							<li>
								<div class="serv_img">
									<img src="<?php echo $this->webroot;?>images/first-one.png" alt="">
								</div>
								<div class="serv_name">
									<p><?php if ($arabic != 'ar') { ?>Minimum Food <?php }else { echo "الحد الأدنى للأغذية"; } ?><br />
                                                                          <?php if ($arabic != 'ar') { ?>Quantity<?php }else { echo "كمية"; } ?>
                                                                        </p>
								</div>
								<h5><?php echo $offerdata['Product']['min_order_quantity'] ;?><?php if ($arabic != 'ar') { ?>Units<?php }else { echo "وحدات"; } ?> </h5>
							</li>
							<li>
								<div class="serv_img">
									<img src="<?php echo $this->webroot;?>images/per-unit.png" alt="">
								</div>
								<div class="serv_name">
									<p> <?php if ($arabic != 'ar') { ?>Serves Per Unit<?php }else { echo "يخدم لكل وحدة"; } ?></p> 
								</div>
								<h5><?php echo $offerdata['Product']['serving_unit'] ;?></h5>  
							</li>
							<li>
								<div class="serv_img"> 
									<img src="<?php echo $this->webroot;?>images/clock-one.png" alt="">
								</div>  
								<div class="serv_name">
									<p><?php if ($arabic != 'ar') { ?>Preparation Time of <?php }else { echo "وقت إعداد "; } ?><br />
                                                                          <?php if ($arabic != 'ar') { ?>Dish<?php }else { echo "طبق"; } ?>  
                                                                        </p>
								</div>
								<h5><?php echo $offerdata['Product']['preparation_time'] ;?></h5>
							</li>
							<li>
								<div class="serv_img">
									<img src="<?php echo $this->webroot;?>images/clock-two.png" alt="">
								</div>
								<div class="serv_name">
									<p><?php if ($arabic != 'ar') { ?>Setup Time<?php }else { echo "وقت الإعداد"; } ?><br />
                                                                         <?php if ($arabic != 'ar') { ?>Required<?php }else { echo "مطلوب"; } ?>   
                                                                        </p>
								</div>
								<h5><?php $offerdata['Product']['setup_time'] ;?></h5>
							</li>
							<li>
								<div class="serv_img">
									<img src="<?php echo $this->webroot;?>images/clock-last.png" alt="">
								</div>
								<div class="serv_name">
									<p><?php if ($arabic != 'ar') { ?>Services<?php }else { echo "خدمات"; } ?> <br /><?php if ($arabic != 'ar') { ?>Expectations<?php }else { echo "التوقعات"; } ?></p>
								</div>
								<h5><?php if ($arabic != 'ar') { ?>Lorem Ipsum<?php }else { echo "أبجد هوز"; } ?></h5>
							</li>
						</ul>-->     
					</div>
				</div>
			</div>
			<div class="clr"></div> 
		</section><!-- End Here -->
		<section class="extras-sec">
			<div class="container">
				<div class="row">
		
                                    	<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'addoffercart'))); ?>
					<div class="col-md-10 col-center">
                                          
					
               
						<div class="comment_sec"> 
							
								<div class="form-group">
									<h4><?php if ($arabic != 'ar') { ?>Special Instructions<?php }else { echo "تعليمات خاصة"; } ?></h4>
									<textarea name="data[Product][notes]" class="form-control" placeholder="Enter any special instructions or dietary requirements"></textarea>
								</div>
                                                     <?php  
                                                     if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                     }else{
                                                    $arb = "eng";   
                                                      }
                                                    ?> 
                                                    <a href="<?php echo $this->webroot.$arb."/restaurants/menu/". $offerdata['Offer']['id'] ; ?>" class="btn btn-sm defult_btn"><?php if ($arabic != 'ar') { ?>Back to Menu<?php }else { echo "العودة إلى القائمة"; } ?></a>

                                                    <div class="pull-right add-btn">
                                                        <?php
                                                         if($arabic=='ar'){
                                                        $arb = $arabic;  
                                                         }else{
                                                      $arb = "eng";   
                                                          }
                                                        ?>  
                                                    	<span class="qt_add">Qty</span> 
							<input type="number" min="<?php echo $offerdata['Offer']['min_order_quantity']; ?>" max="<?php if($offerdata['Offer']['max_order_quantity']==0){ echo $offerdata['Offer']['quantity']; }else{  if($offerdata['Offer']['max_order_quantity']< $offerdata['Offer']['quantity']){ echo $offerdata['Offer']['max_order_quantity'] ;}else{ echo $offerdata['Offer']['quantity'] ; }  }?>" name="data[Product][quantity]" value="<?php echo $offerdata['Offer']['min_order_quantity']; ?>" > 
							<input type="hidden" class="order_type" name="data[Product][rest_id]" value="<?php  echo $offerdata['Restaurant']['id']; ?>"> 
							<input type="hidden" class="order_type" name="data[Product][order_type]" value="<?php $ordertype = $this->Session->read('ordertype');
							if($ordertype=='catering'){ echo "1"; }elseif($ordertype=='delivery'){echo "2";}elseif($ordertype=='pickup'){echo "3";}elseif(empty($ordertype)){ echo "1"; } ?>">	
                                                        <input type="hidden" name="server" value="<?php echo $this->webroot.$arb."/restaurants/menu/". $offerdata['Offer']['res_id'] ; ?>" >    
                                           <input type="hidden" name="data[Product][id]" value="<?php echo $offerdata['Offer']['id']; ?>" id="ProductId"> 
                                             <input type="hidden" name="data[User][id]" value="<?php if(!empty($loggeduser)){ echo $loggeduser ;}else{ echo "0" ; } ?>">
                                            <button class="btn btn-sm defult_btn view_btn waves-effect waves-light" type="submit"><?php if ($arabic != 'ar') { ?>Add to Cart<?php }else { echo "أضف إلى السلة"; } ?></button>  
				
                                                    </div>     	
						</div>
					</div>
                                    
                                      <?php echo $this->Form->end(); ?>  
				</div>
			</div>
		</section><!-- End Here -->
	</section><!-- End Here -->
	<!-- Footer section end here -->      