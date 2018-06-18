<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
//App::uses('ConnectionManager', 'Model');
/**
 * Restaurants Controller
 *
 * @property Restaurant $Restaurant
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
App::import('Sanitize');
ini_set('memory_limit', '256M');

class RestaurantsController extends AppController {

  
    //var $name = 'Restaurant';

    public function beforeFilter() { 
        parent::beforeFilter();
        $this->Auth->allow(array('api_restaurantslist', 'api_getresmenu','api_restaurantDetail','api_restaurantsOnSelectedDate',
            'api_restaurantslistbyadd', 'api_dishsubcat', 'detail', 'search',
            'api_mobilefilter', 'api_frestaurantsbyaddname', 'api_frestaurantsbyaddnameb',
            'api_advancepayment','api_promocode','searchCat','searchlisting')); 
    }

    /**
     * Components  
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Cart','RequestHandler');
    public $distance = 20;             
 
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Restaurant->recursive = 0;
        $this->set('restaurants', $this->Paginator->paginate());
    }
    
      public function searchlisting() {   
         configure::write('debug',0);  
         
         
              $search = null;
        if(!empty($this->request->query['search']) || !empty($this->request->data['name'])) {
            $search = empty($this->request->query['search']) ? $this->request->data['name'] : $this->request->query['search'];
            $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $search);
            $terms = explode(' ', trim($search));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                'Restaurant.status' => 1,
            );
            foreach($terms as $term) {
                $terms1[] = preg_replace('/[^a-zA-Z0-9]/', '', $term);
                $conditions[] = array('Restaurant.name LIKE' => '%' . $term . '%');
            }
            $rest = $this->Restaurant->find('all', array(
                'recursive' => -1,
                'conditions' => $conditions,
                'limit' => 200,
            ));
            if(count($rest) == 1) {
                return $this->redirect(array('controller' => 'restaurants', 'action' => 'menu/'. $rest[0]['Restaurant']['id']));
            }
            $terms1 = array_diff($terms1, array(''));
          
            $this->set(compact('rest', 'terms1')); 
        }
            if($this->request->is('post')){
                if($this->request->data['ordertype']=='catring'){
                  $sortcatering = 1;  
                }elseif($this->request->data['ordertype']=='delivery'){    
                  $sortdelivery  = 1;  
                }elseif($this->request->data['ordertype']=='pickup'){
                  $sortpickup   = 1; 
                }
                
           $lat                   = $this->request->data['lat'];
          $long                  = $this->request->data['long'];
		  $catedis               = $this->request->data['discat']; 
          $eventdate = $this->request->data['date'];
            }else{
          $catedis               = $this->params['url']['discat']; 
          $orderby_leadtime      = $this->params['url']['leadtime'];  
          $lat                   = $this->params['url']['lat'];
          $long                  = $this->params['url']['long'];
          $orderbyrating         = $this->params['url']['rating'];
          $restname              = $this->params['url']['restname'];
          $sortrapid             = $this->params['url']['sortrapid'];  
          $sortcatering          = $this->params['url']['catering'];
          $sortdelivery          = $this->params['url']['delivery'];
          $sortpickup            = $this->params['url']['pickup'];
           $eventdate = $this->params['url']['date']; 
            }
          
          
          if($lat == null && $long==null  ){  
            $lat  = "23.885942";  
            $long = "45.079162";        
          }
          
         $datetime1 = date_create($eventdate);
         $today = date('Y-m-d H:i:s');
         $datetime2 = date_create($today);
        $interval = date_diff($datetime1, $datetime2);
        $days = $interval->format('%a');
        $hours = $interval->h + ($days * 24);
       
          
          
          
       $this->loadModel('DishCategory'); 
       $this->loadModel('Product');
        $this->loadModel('Cat');
       
         $dishCategory = $this->DishCategory->find('all');
         $this->set(compact('dishCategory')); 
         if($catedis){
         $restfilterbydish = $this->Product->find('all', array('conditions' =>array('Product.dishcategory_id' => $catedis),
             
            'group' => array('Product.res_id'),  
             
             ));
         
         
         foreach($restfilterbydish as $restid){
             
           $res_id[] =  $restid['Product']['res_id'];   
         }
         
       
            
            if($res_id) {       
			 $conditions[] = array(   
                'Restaurant.id' => $res_id, 
                    );
		}   
            }
            if(!empty($hours)){   
                 $conditions[] = array('AND'=>array(
                        'Restaurant.lead_time <='=>$hours    
                        ));
            }
            
             if($sortrapid != null) { 
			 $conditions[] = array(
                'Restaurant.rapid_booking' => $sortrapid, 
                    );
		}

               if($sortcatering != null) { 
			 $conditions[] = array( 
                'Restaurant.catering' => $sortcatering,   
                    );
		}
                
                  if($sortdelivery != null) { 
			 $conditions[] = array( 
                'Restaurant.delivery' => $sortdelivery, 
                    );
		}
                
                if($sortpickup != null) { 
			 $conditions[] = array( 
                'Restaurant.takeaway' => $sortpickup,       
                    );
		}
                
          /*if($location != null || $lat != null || $long != null) {              
            $conditions[] = array('OR' => array('Restaurant.city LIKE' => '%' . $location . '%' ,
            'Restaurant.latitude' => $lat, 'Restaurant.longitude' => $long)) ;            
          }*/ 
          
                 if($orderbyrating != null) {
		 $orderby[] =  array(
                'Restaurant.review_avg' => $orderbyrating 
                ); 	
		}
                
                    if($restname != null) { 
			 $orderby[] = array( 
                'Restaurant.name' => $restname,   
                    );
		}
                
                if($orderby_leadtime != null) {
		 $orderby[] =  array(
                'Restaurant.lead_time' => $orderby_leadtime 
                ); 	
		}
  
       // $restfilter = $this->Restaurant->find('all', array('conditions' =>$conditions,'order' => $orderby)); 
        $this->Restaurant->recursive=1;   
         $data = $this->Restaurant->find('all', array(
            'conditions' =>$conditions ,  
             'order' => $orderby,  
                "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*"),
            ));  
  
         $event_date_format = date("Y-m-d",strtotime($eventdate));
         
         
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                     $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'UnavailableDate.unavailabledate'=>$event_date_format,
                            'UnavailableDate.restaurant_id'=>$data[$i]['Restaurant']['id']
                        )
                    )));
                    if($unavailable_for_selectedDate){
                        unset($data[$i]);
                    }else{
                         $dataa[]=$data[$i]; 
                    }
                   
                } else {
                    unset($data[$i]); 
                }
            }
			$i= 0;
			   foreach($dataa as $datalist){
				 
				      $today_day = date('l');
                $today_time = date("g:iA");
               if($today_day =='Saturday' || $today_day =='Sunday'){
                   $opening_time = date("g:iA", strtotime($datalist['Restaurant']['weekend_opening_time']));
                   $closing_time = date("g:iA", strtotime($datalist['Restaurant']['weekend_closing_time']));
               }else{
                    $opening_time=date("g:iA", strtotime($datalist['Restaurant']['opening_time']));
                    $closing_time=date("g:iA", strtotime($datalist['Restaurant']['closing_time']));
               }
               
               if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                    $dataa[$i]['Restaurant']['is_open']=1;
                }else{
                    $dataa[$i]['Restaurant']['is_open']=0;
                }
				 $i++;  
			   }
			   $j=0;
			    foreach($dataa as $list){
			    foreach($list['UnavailableDate'] as $date){
		
				if($date['unavailabledate']== date('Y-m-d')){
                   $dataa[$j]['UnavailableDate']['unavailabltoday']= 1;
                }else{
                    $dataa[$j]['UnavailableDate']['unavailabltoday']= 0;
                }
				   
			   }
			   $j++; 
				}
			
              $this->loadModel('Favrest') ; 
            $user_id  = $this->Auth->user('id');
            foreach($dataa as $datalist){
                
          $fav = $this->Favrest->find('all', array('conditions' => array('AND' => array('Favrest.res_id' => $datalist['Restaurant']['id'], 'Favrest.user_id' => $user_id))));
          foreach($fav as $flist){
             $favid[] =$flist['Favrest']['res_id'] ;  
          }
          }
		  
		 // print_r($dataa);
          //$map = $this->Restaurant->find('all');   
          $this->set('maps',$dataa); 
          $this->set('favid',$favid);    
 
        /* $latestDeal = $this->Restaurant->find('all', array(    
            'limit' => 10,  
            'order' => 'Restaurant.id DESC', 
           
        ));*/ 
       
      //  $this->set('latestdeal',$latestDeal); 
      
       // $this->set('restfilter',$restfilter); 
          
     

        }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));

        $this->set('restaurant', $this->Restaurant->find('first', $options));
    }


    /**
     * cartdetail method
     *
     * @throws NotFoundException
     * @param string $id
     * @param string $id
     * @return void
     */
    /*public function admin_cartdetail($id = null, $table = null, $dishid = NULL) {
        $this->Restaurant->recursive = 2;
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $this->loadModel('Product');
        $this->loadModel('DishSubcat');
        $dishoptions = array('conditions' => array('DishSubcat.dish_catid' => $dishid));
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $prooptions = array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $dishid)));
        $countdata = $this->DishSubcat->find('all', $dishoptions);
        foreach ($countdata as $d) {
            $d['DishSubcat']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishsubcat_id' => $d['DishSubcat']['id']))));
            if ($d['DishSubcat']['cnt'] == 0) {
                
            } else {
                $data['DishSubcat'][] = $d['DishSubcat'];
            }
        }
        $this->set('restaurant', $this->Restaurant->find('first', $options));
        $this->set('product', $this->Product->find('all', $prooptions));
        $this->set('DishSubcat', $data);
        $this->set('tno', $table);
        $this->Session->write('Cart.tableno', $table);
         $this->Session->write('Cart.resid', $id);
    } */

    public function admin_menudetai($id = null, $table = null) {
        Configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->loadModel('DishCategory');  
        $this->loadModel('Product');   
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $dishdata = $this->DishCategory->find('all');
        foreach ($dishdata as $d) {

            $d['DishCategory']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $d['DishCategory']['id']))));
            if ($d['DishCategory']['cnt'] == 0) {
                
            } else {
                $data['DishCategory'][] = $d['DishCategory'];
            }
        }
        $this->set('restaurant', $this->Restaurant->find('first', $options));
        $this->set('discategory', $data);
        $this->Session->write('Shop.Order.restaurant_id', $id);
        $this->set('tno', $table);
        $this->set('rno', $id);
    }

    /**
     * menu method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	 
	 
	  private function getDiscountOnRepeatOrderswebesc($user_id,$res_id,$session_id){
         
           $this->loadModel('Order'); 
		   $this->loadModel('Cart'); 
            $this->loadModel('Discount'); 
            $exist_cart_data = $this->Cart->find('all',array(
                'conditions'=>array(
                    'AND'=>array(
                        'Cart.uid'=>$user_id,
                        'Cart.sessionid'=>$session_id
                    )
                )
                    ));
            if(!empty($exist_cart_data)){
                foreach($exist_cart_data as $cart){
                    if($cart['Cart']['offer_id'] != 0){
                        $is_offer = 1;
                    }
                    if($cart['Cart']['promocode_id'] !=0){
                        $is_promocode_applied = 1;
                    }
                }
            }
            if(isset($is_offer) && $is_offer == 1){
                return false;
            }else if(isset($is_promocode_applied) && $is_promocode_applied==1){ 
                return false;
                //getDiscountOnRepeatOrders($user_id,$res_id,$session_id)
            }else{
                $order_count = $this->Order->find('count',array('conditions'=>array("AND"=>  array(
                    'Order.restaurant_id'=>$res_id,
                    'Order.uid'=>$user_id
                ))));
                $discount = $this->Discount->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Discount.res_id'=>$res_id,
                        'Discount.min_order <='=>$order_count+1,
                        'Discount.max_order >='=>$order_count+1
                    )
                )));
                if(!empty($discount)){
                    return $discount;
                   // $response['isSuccess']=true;
                   // $response['data']=$discount;
                    //$response['order_count']=$order_count;
                }else{
                    return false;
                   // $response['isSuccess']=false;
                   // $response['msg']='No discount';
                    //$response['discount']=$discount;
                   // $response['order_count']=$order_count;
                }
            }
    }
	
	 /*
     * Get refferal discount
     */
    private function refferalDiscountwebsec($user_id) {
		$this->loadModel('User');
		$this->loadModel('Order');
		$this->loadModel('Setting');
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                if($users){
                    $user_ids = array_keys($users);
                    $order = $this->Order->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        //'group'=>'Order.uid',
                        'recursive'=>1,
                        'order'=>array('Order.created ASC')
                        ));
                    // min amount for referral discount
                    $min_amount_for_refferal_discount= $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'min_amount_for_referral_discount')));
                    
                    $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                    if($discount_setting['Setting']['dimension']==2){
                        $discount['type']="SAR";
                       $discount_for_refferal= "SAR".$discount_setting['Setting']['value'];
                    }else if($discount_setting['Setting']['dimension']==1){
                        $discount['type']="%";
                        $discount_for_refferal= $discount_setting['Setting']['value']."%";
                    }else{
                        $discount_for_refferal= $discount_setting['Setting']['value'];
                    }
                    $discount['amount']=$discount_setting['Setting']['value'];
                    $created_date = strtotime($order['Order']['created']);
                    $discount['valid_till']=date('d M,y h:i A', strtotime('+1 months',$created_date));
                    $discount['min_amount_to_avail_discount']=$min_amount_for_refferal_discount['Setting'];
                    return $discount;
                } 
            }
    }
	
	

//////////////////////////////////////////////////
	
    
    public function webCartData($uid, $sid) {
         $this->loadModel('Cart');    
         $this->loadModel('Offer');
         $this->loadModel('Product');
         $this->loadModel('Promocode');
         
         
    
         $shop = $this->Cart->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.uid' => $uid,
                    'Cart.sessionid' => $sid
        )),
            'order' => array('Cart.created' => 'ASC'),
            'recursive'=>1  
            ));

       
        $quantity = 0;
        $weight = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;
        //print_r($shop); //exit;
        $cartparent=array();
        $cartdata = array();
        $cart_using_dates = array();
        foreach ($shop as $key => $value) {
            if($value['Cart']['offer_id']!=0){
				$is_offer = 1;
				
                $parent_id =  $value['Cart']['parent_id'];
                $product = $this->Offer->find('first', array(
                   'conditions' => array(
                           'Offer.id' => $value['Cart']['offer_id']
               )));
                //$value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
               // $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];

                $value['Cart']['image'] = FULL_BASE_URL . "/thoag/files/offers/" . $value['Cart']['image'];
               // print_r($value['Cart']);
               if(!in_array($parent_id, $cartparent)){
                   array_push($cartparent, $value['Cart']['parent_id']);
               }
               
               // Dates section start
               $dates= array();
               
               if(!in_array($value['Cart']['created'],$dates)){
                   array_push($dates, $value['Cart']['created']);
               }
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['offer_id'] == $value['Cart']['parent_id']){
                       $cart_using_dates[$value['Cart']['created']]['parent_product']=$value;
					   $cart_using_dates[$value['Cart']['created']]['parent_product']['Product']=$product['Offer'];
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cart_using_dates[$value['Cart']['created']]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it
                   $cart_using_dates[$value['Cart']['created']][$parent_id]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
               
               // Dates section end
               
               // print_r($cartparent); 
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['offer_id'] == $value['Cart']['parent_id']){
                       $cartdata[$parent_id]['parent_product']=$value;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cartdata[$parent_id]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it
                   $cartdata[$parent_id]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
            }else{
				  $is_offer = 0; 
				
				
                $parent_id =  $value['Cart']['parent_id'];
                $product = $this->Product->find('first', array(
                   'conditions' => array(
                           'Product.id' => $value['Cart']['product_id']
               )));
                $value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
                $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];

                $value['Cart']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $value['Cart']['image'];
               // print_r($value['Cart']);
               if(!in_array($parent_id, $cartparent)){
                   array_push($cartparent, $value['Cart']['parent_id']);
               }
               // print_r($cartparent); 
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                       $cartdata[$parent_id]['parent_product']= $value;
                   }else{
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                       $cartdata[$parent_id]['associated_products'][]=$value;
                   }
               }else{
                   // create key and push data into it
                   $cartdata[$parent_id]=$value;
                   //$cartdata[$parent_id]=$value['Cart'];
               }
               
               
               // Dates section start
               $dates= array();
               
               if(!in_array($value['Cart']['created'],$dates)){
                   array_push($dates, $value['Cart']['created']);
               }
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
                       $cart_using_dates[$value['Cart']['created']]['parent_product']=$value;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cart_using_dates[$value['Cart']['created']]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it 
                   $cart_using_dates[$value['Cart']['created']]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
               
               // Dates section end
            }
             
            
            # code...
        }
        // print_r($cartdata);
        // exit;
        // $cnt = count($shop);
        // for ($i = 0; $i < $cnt; $i++) {

        //     $shop[$i]['Cart']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $shop[$i]['Cart']['image'];
        // }


        if (count($shop) > 0) {
            foreach ($shop as $item) {
                $quantity += $item['Cart']['quantity'];
                $weight += $item['Cart']['weight'];
                $subtotal += $item['Cart']['subtotal'];
                $total += $item['Cart']['subtotal'];
                $restaurant_name = $this->Restaurant->find('first', array(
                    'conditions' => array(
                            'Restaurant.id' => $item['Cart']['resid']
                )));
                $res_id = $item['Cart']['resid'];
                
                // order_type
                $order_type = $item['Cart']['order_type'];
                
                
                if($item['Cart']['promocode_id'] != 0){
                    $promocode_id = $item['Cart']['promocode_id'];
                }
                // down payment
//                if($item['Cart']['down_payment'] != 0){
//                    $down_payment = $item['Cart']['down_payment'];
//                    $down_payment_percentage = $restaurant_name['Restaurant']['down_payment_percentage'];
//                }
                $order_item_count++;
            }
            if(isset($promocode_id)){
                $promocode = $this->Promocode->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Promocode.id'=>$promocode_id
                    )
                )));
                $promocode_discount=$promocode['Promocode']['discount']*$subtotal/100;
                // max discount amount starts here
                $max_amount = $promocode['Promocode']['max_discount_amount'];
                $d['calculated_promo_discount']=$promocode_discount;
                if($max_amount <=  $promocode_discount){
                    
                    $promocode_discount=$max_amount;
                    $d['max_promo_discount']=$max_amount;
                }
                // ends here
                $d['promocode_discount']=sprintf('%01.2f', $promocode_discount);
                $d['promocode_percentage']=$promocode['Promocode']['discount'];
                $d['promocode']=$promocode;
            }else{
                $d['calculated_promo_discount']=0;
                $d['promocode_discount']=0;
                $d['promocode_percentage']=0;
            }
            $discount_available = $this->getDiscountOnRepeatOrderswebesc($uid,$res_id,$sid);
            if($discount_available){
                $discount_amount = $discount_available['Discount']['discount']*$subtotal/100;
                
                // max discount amount starts here
                $max_dis_amount = $discount_available['Discount']['max_discount_amount'];
                $d['calculated_repeat_discount']=$discount_amount;
                if($max_dis_amount <=  $discount_amount){
                    
                    $discount_amount=$max_dis_amount;
                    $d['max_repeat_discount']=$max_dis_amount;
                }
                // ends here
                
                $d['discount_amount']=sprintf('%01.2f', $discount_amount);
                $d['discount_percentage']=$discount_available['Discount']['discount'];
                $d['min_order_amount_for_discount']=$discount_available['Discount']['min_order_amount'];
            }else{
                $d['calculated_repeat_discount']=0;
                 $d['discount_amount']=0;
                 $d['discount_percentage']=0;
                 $d['min_order_amount_for_discount']=0;
            }
            // Refferal Discount
            $refferal_discount = $this->refferalDiscountwebsec($uid);
            if($refferal_discount){
                if((float)$total > (float)$refferal_discount['min_amount_to_avail_discount']['value']){
                    $d['refferal_discount']=$refferal_discount['amount'];
                    $d['refferal_discount_type']=$refferal_discount['type'];
                    $d['refferal_percentage']=0;
					$d['min_amount_for_refferal']= $refferal_discount['min_amount_to_avail_discount']['value'];
                }else{
                    $d['refferal_discount']=0;
                    $d['refferal_discount_type']=0;
                    $d['refferal_percentage']=0;
                }
                
            }else{
                $d['refferal_discount']=0;
                $d['refferal_discount_type']=0;
                $d['refferal_percentage']=0;
            }
            
            
            // Down Payment
//            if(isset($down_payment)){
//                $downpayment_amount = $down_payment_percentage*$subtotal/100;
//                $d['downpayment_amount']=$downpayment_amount;
//                $d['downpayment_percentage']=$down_payment_percentage;
//            }
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
			$this->Session->write('cart_count',$quantity); 
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            $d['order_type']=(int)$order_type;
            $d['restaurant']= $restaurant_name;
			
            $cart['cartInfo']=$d;
			$cart['cartcount']= $quantity;
			$cart['is_offer']= $is_offer;
            //$cart['products']=$cartdata;
            
            $cart['products']=$cart_using_dates;

            //return array($d, $shop);
        } else {
            $d['quantity'] = 0;
            $d['weight'] = 0;
            $d['subtotal'] = 0;
            $d['total'] = 0;
			$this->Session->write('cart_count',0);
			$cart['cartcount']= 0;	
            $cart['cartInfo']=$d;
            //$cart['products']=$cartdata;
            $cart['products']=$cart_using_dates;
            //return array($d, $shop);
        }
        return $cart;    
    }
    public function menu($id = null) {    
        Configure::write('debug',0); 
        if($this->request->is('post')){
			
			 
			
					if($this->request->data['placeorder'] !='placesubmit'){
                  $eventdate  =  $this->request->data['eventdate'];
                  $res_id  =  $this->request->data['res_id'];
                   $restaurant = $this->Restaurant->find("first",array(
                "conditions"=>array("Restaurant.id"=>$res_id),
                'recursive'=>2,
//                "contain"=>array('Reviews')
                ));
				  $remove_quotes=trim($this->request->data['eventdate'],'"');
                 $evendate = trim($remove_quotes,'"');
                $event_date_format = date("Y-m-d",strtotime($eventdate));
                  $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'UnavailableDate.unavailabledate'=>$event_date_format,
                            'UnavailableDate.restaurant_id'=>$res_id    
                        )
                    )));
                    
                    if($unavailable_for_selectedDate['UnavailableDate']['unavailabledate']==$event_date_format){
                        $response['isSucess'] = "false";
                        $response['msg'] = "Caterer not available for this date. Please select another date";   
                    }else{
						
						$today_day = date('l',strtotime($evendate));
                        $today_time = date("g:iA",strtotime($evendate));
                       if($today_day =='Saturday' || $today_day =='Sunday'){
                           $opening_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));
                           $closing_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
                       }else{
                            $opening_time=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                            $closing_time=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
                       }

                       if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                            $restaurant['Restaurant']['is_open']=1;
                        }else{
                            $restaurant['Restaurant']['is_open']=0;
                        }
                        if($restaurant['Restaurant']['is_open']==0){
                            $response['isSuccess']=  "false";
                            $response['msg']="Restaurant is Closed Now. Either choose another Restaurant or select another Date/Time";
                            $response['now']=$today_time;
                            $response['opening']=$opening_time;
                            $response['closing']=$closing_time;
                        }else{
							 $response['isSuccess']=  true;
						}
						
						
						
						
						
                       // $response['isSucess'] = "true"; 
                       // $response['msg'] = "Caterer available"; 
                    }
                 echo json_encode($response);
                 exit; 
					}	
            }
        if($id){
            $restaurant = $this->Restaurant->find("first",array(
                "conditions"=>array("Restaurant.id"=>$id),
                'recursive'=>2,
//                "contain"=>array('Reviews')
                ));
//            $this->loadModel('RestaurantsReview');
            if($restaurant){
                $restaurant_Detail=array();
                $today_day = date('l');
                $today_time = date("g:iA");
               if($today_day =='Saturday' || $today_day =='Sunday'){
                   $opening_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));
                   $closing_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
               }else{
                    $opening_time=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                    $closing_time=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
               }
               
               if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                    $restaurant['Restaurant']['is_open']=1;
                }else{
                    $restaurant['Restaurant']['is_open']=0;
                }
               
                $restaurant['Restaurant']['opening_time']=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                $restaurant['Restaurant']['closing_time']=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
                $restaurant['Restaurant']['weekend_closing_time']=date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
                $restaurant['Restaurant']['weekend_opening_time']=date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));

                $pickup=0;
                $delivery=0;
                $catering=0;

                
                $this->loadModel('Product');
                $this->loadModel('Cart');
                $products = $this->Product->find("all",array("conditions"=>array( "Product.res_id"=>$id)));
                $category_ids=array(); 
                foreach($products as $product){
                    if(!in_array($product['Product']['dishcategory_id'],$category_ids)){
                        array_push($category_ids, $product['Product']['dishcategory_id']);
                    }
                }
                // List Dish Categories
                $this->loadModel('DishCategory');
                $dish_categories = $this->DishCategory->find("all",array("conditions"=>array(
                    "AND"=>array(
                     "DishCategory.id"=>$category_ids,
                     "DishCategory.isshow"=>0
                    )
                        )));
                
                $category_products = array();
                foreach($dish_categories as $category){
                    $cat_products = $this->Product->find("all",array("conditions"=>array("AND"=>array(
                        "Product.res_id"=>$id,
                        "Product.dishcategory_id"=>$category['DishCategory']['id']
                    ))));
       
                    $category['DishCategory']['image'] = FULL_BASE_URL . $this->webroot . "files/catimage/" . $category['DishCategory']['image'];
                    $inner_array =array();
                    $inner_array['products']=$cat_products;
                    $inner_array['category']= $category['DishCategory'];
                    $category_products[$category['DishCategory']['name']]=$inner_array;
                }
                // Reviews
                $reviews=array();
                if(!empty($restaurant['Reviews'])){
                    foreach($restaurant['Reviews'] as $review){
                        // print_r($review); exit;
                        // Time difference
                        $start_date = new DateTime($review['created']);
                        $today = date("Y-m-d h:i:s");
                        $end_date = new DateTime($today);
                        $interval = $start_date->diff($end_date);
                        //print_r($interval);
                        //echo "Result " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
                        if($interval->y == 0){
                            if($interval->m == 0){
                                if($interval->d == 0){
                                    if($interval->h==0){
                                        if($interval->i==0){
                                            if($interval->s==0){
                                                $review['time_difference']="Just Now";
                                            }else{
                                                $review['time_difference'] = $interval->s." s";
                                            }
                                        }else{
                                            $review['time_difference'] = $interval->i." i";
                                        }
                                    }else{
                                        $review['time_difference'] = $interval->h." h";
                                    }
                                }else{
                                    $review['time_difference'] = $interval->d." d";
                                }
                            }else{
                                $review['time_difference'] = $interval->m." m";
                            }
                        }else{
                            $review['time_difference'] = $interval->y." y";
                        }
  

                        if(!empty($review['User']['image'])){
                           // $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $review['User']['image'];
                        }else{  
                           // $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                        }
                        $reviews[]=$review;
                    }
                }
               
                $restaurant_Detail['Restaurant']=$restaurant['Restaurant'];
				$restaurant_Detail['Promocode']= $restaurant['Promocode'];
				$restaurant_Detail['Discount']= $restaurant['Discount'];
				$restaurant_Detail['UnavailableDate']= $restaurant['UnavailableDate'];
                $restaurant_Detail['category_products']=$category_products;
                $restaurant_Detail['Reviews']=$reviews;
				  
				  
			  $productsmost = $this->Product->find("all",array("conditions"=>array("Product.res_id"=>$id,"Product.most_popular"=>1))); 
				  
               $j=0;
			  
			    foreach($restaurant_Detail['UnavailableDate'] as $date){
		
				if($date['unavailabledate']== date('Y-m-d')){
                   $restaurant_Detail['UnavailableDate']['unavailabltoday']= 1;
                }else{
                    $restaurant_Detail['UnavailableDate']['unavailabltoday']= 0;
                }
				   
			   }
			   
			  $this->set('restaurant',$restaurant_Detail);  
               $this->set('productsmost',$productsmost);  
             

            }
             $this->loadModel('Favrest');
             $user_id = $this->Auth->user('id');
            $fav = $this->Favrest->find('count', array('conditions' => array('AND' => array('Favrest.res_id' => $id, 'Favrest.user_id' => $user_id))));
            $this->set('fav',$fav);    
        }
       // $uid = $this->Auth->user('id');    
       // $shop = $this->Cart->find('all',array('conditions' => array('Cart.uid' => $uid))); 
      $shop = $this->Session->read('Shop'); 
      $this->set(compact('shop')); 
     
         $uid = $this->Auth->user('id');  
        $user_id = $uid?$uid:0;
        $sid = $this->Session->id();    
        if (!empty($sid)) {
            $cartdata = $this->webCartData($user_id , $sid); 

        }  
        $this->set(compact('cartdata'));           
}
    
  
    /**
     * menu method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_rescart() {

        $id = $this->params['url']['res_id'];
        $tableId = $this->params['url']['table'];
        $this->Restaurant->recursive = 2;
        $this->loadModel('DishCategory');
        $this->loadModel('Product');
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $dishdata = $this->DishCategory->find('all');
        foreach ($dishdata as $d) {

            $d['DishCategory']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $d['DishCategory']['id']))));
            if ($d['DishCategory']['cnt'] == 0) {
                
            } else {
                $data['DishCategory'][] = $d['DishCategory'];
            }
        }
        $this->set('restaurant', $this->Restaurant->find('first', $options));
        $this->set('discategory', $data);
        $tableID = $this->params['url']['table'];
    }

    public function addresmenu($id = null) {
//        $shop = $this->Session->read('Shop');
//        $this->Cart->clear();
        $this->Restaurant->recursive = 2;
        $this->loadModel('DishCategory');
        $this->loadModel('Product');
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $dishdata = $this->DishCategory->find('all');
        foreach ($dishdata as $d) {

            $d['DishCategory']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $d['DishCategory']['id']))));
            if ($d['DishCategory']['cnt'] == 0) {
                
            } else {
                $data['DishCategory'][] = $d['DishCategory'];
            }
        }
        $this->set('restaurant', $this->Restaurant->find('first', $options));
        $this->set('discategory', $data);
    }

    /**
     * res search on index
     */
    /*public function discovery() {
          Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {
            $d = $this->request->data;
            $lat = $d['Restaurant']['lat']; //=30.5389944;
            $long = $d['Restaurant']['long']; //  =75.9550329;
            $this->Session->write('searchlat', $lat);
            $this->Session->write('searchlong', $long);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $this->distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        } else {
            if ($this->Session->read('searchlat')) {
                $lat = $this->Session->read('searchlat');
            } else {
                $lat = 0;
            }
            if ($this->Session->read('searchlong')) {
                $long = $this->Session->read('searchlong');
            } else {
                $long = 0;
            }
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
              
                $distanve = $_GET['distance'];
                $type = $_GET['type'];
                $rate = $_GET['rate'];
                $dlchk = $_GET['dlchk'];
                $tkchk = $_GET['tkchk'];
               
                $conditions = array();
                $this->loadModel("RestaurantsType");
                if ($distanve) {
                    $distanve = $_GET['distance'];
                } else {
                    $distanve = $this->distance;
                }
                if ($this->params->query['rate']) {
                    $conditions[] = array('Restaurant.review_avg' => $this->params->query['rate']);
                }
                if ($this->params->query['type']) {
                     $td=explode(',',$type);               
                    $conditions[] = array('Restaurant.typeid' => serialize($td));
                }
                if ($this->params->query['dlchk']) {
                    $conditions[] = array('Restaurant.delivery' => 1);
                }
                if ($this->params->query['tkchk']) {
                    $conditions[] = array('Restaurant.takeaway' => 1);
                }
//                print_r($conditions);
//                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)));
                //print_r($data);
                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)), array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distanve) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        }
        $this->set('restauranttype', $this->RestaurantsType->find('all'));
        $this->set('resdata', $finaldata);
    }*/

    /**
     * res search on index
     */
   /* public function search() {
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {
            $d = $this->request->data;
            $lat = $d['Restaurant']['lat']; //=30.5389944;
            $long = $d['Restaurant']['long']; //  =75.9550329;
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $this->distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        } else {
            return $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        $this->set('restauranttype', $this->RestaurantsType->find('all'));
        $this->set('resdata', $finaldata);
    }*/

    /*public function restaurantsearch() {
        Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {
            $d = $this->request->data;
            $lat = $d['Restaurant']['lat']; //=30.5389944;
            $long = $d['Restaurant']['long']; //  =75.9550329;
            $this->Session->write('searchlat', $lat);
            $this->Session->write('searchlong', $long);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $this->distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        } else {
            if ($this->Session->read('searchlat')) {
                $lat = $this->Session->read('searchlat');
            } else {
                $lat = 0;
            }
            if ($this->Session->read('searchlong')) {
                $long = $this->Session->read('searchlong');
            } else {
                $long = 0;
            }
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
              
                $distanve = $_GET['distance'];
                $type = $_GET['type'];
                $rate = $_GET['rate'];
                $dlchk = $_GET['dlchk'];
                $tkchk = $_GET['tkchk'];
               
                $conditions = array();
                $this->loadModel("RestaurantsType");
                if ($distanve) {
                    $distanve = $_GET['distance'];
                } else {
                    $distanve = $this->distance;
                }
                if ($this->params->query['rate']) {
                    $conditions[] = array('Restaurant.review_avg' => $this->params->query['rate']);
                }
                if ($this->params->query['type']) {
                     $td=explode(',',$type);               
                    $conditions[] = array('Restaurant.typeid' => serialize($td));
                }
                if ($this->params->query['dlchk']) {
                    $conditions[] = array('Restaurant.delivery' => 1);
                }
                if ($this->params->query['tkchk']) {
                    $conditions[] = array('Restaurant.takeaway' => 1);
                }
//                print_r($conditions);
//                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)));
                //print_r($data);
                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)), array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distanve) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        }
        $this->set('restauranttype', $this->RestaurantsType->find('all'));
        $this->set('resdata', $finaldata);
    }*/

    
////////////////////////////////////////////////////////////

    /* public function searchjson() {

        $term = null;
        if(!empty($this->request->query['term'])) {
            $term = $this->request->query['term'];
            $terms = explode(' ', trim($term));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                // 'Brand.active' => 1,
                'Restaurant.status' => 1
            );
            foreach($terms as $term) {
                $conditions[] = array('Restaurant.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Restaurant->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    // 'Brand'
                ),
                'fields' => array(
                    'Restaurant.id',
                    'Restaurant.name',
                    'Restaurant.logo'
                ),
                'conditions' => $conditions,
                'limit' => 20,
            ));
        }
        // $products = Hash::extract($products, '{n}.Product.name');
        echo json_encode($products); 
        $this->autoRender = false;

    }*/
    
    
    
    
    
    
    /**
     * res search on index
     */
    /*public function tablesearch() {
         Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {
            $d = $this->request->data;
            $lat = $d['Restaurant']['lat']; //=30.5389944;
            $long = $d['Restaurant']['long']; //  =75.9550329;
            $this->Session->write('searchlat', $lat);
            $this->Session->write('searchlong', $long);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $this->distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        } else {
            if ($this->Session->read('searchlat')) {
                $lat = $this->Session->read('searchlat');
            } else {
                $lat = 0;
            }
            if ($this->Session->read('searchlong')) {
                $long = $this->Session->read('searchlong');
            } else {
                $long = 0;
            }
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
              
                $distanve = $_GET['distance'];
                $type = $_GET['type'];
                $rate = $_GET['rate'];
                $dlchk = $_GET['dlchk'];
                $tkchk = $_GET['tkchk'];
               
                $conditions = array();
                $this->loadModel("RestaurantsType");
                if ($distanve) {
                    $distanve = $_GET['distance'];
                } else {
                    $distanve = $this->distance;
                }
                if ($this->params->query['rate']) {
                    $conditions[] = array('Restaurant.review_avg' => $this->params->query['rate']);
                }
                if ($this->params->query['type']) {
                     $td=explode(',',$type);               
                    $conditions[] = array('Restaurant.typeid' => serialize($td));
                }
                if ($this->params->query['dlchk']) {
                    $conditions[] = array('Restaurant.delivery' => 1);
                }
                if ($this->params->query['tkchk']) {
                    $conditions[] = array('Restaurant.takeaway' => 1);
                }
//                print_r($conditions);
//                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)));
                //print_r($data);
                $data = $this->Restaurant->find('all', array('conditions' => array('AND' => $conditions)), array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distanve) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        }
        $this->set('restauranttype', $this->RestaurantsType->find('all'));
        $this->set('resdata', $finaldata);
    }*/

    /*public function filtersearch() {
        Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {

            $lat = $_POST['lat']; //=30.5389944;
            $long = $_POST['lng']; //  =75.9550329;
            $distance = $_POST['amt'];
            $restype = $_POST['restype1'];
            $restype1 = $_POST['restype'];

            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                if ($restype == '' || $restype == 'all') {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($restype == 'Delivery' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.delivery' => 1),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.takeaway' => 1),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == 'Delivery') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.typeid' => $restype),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
            if ($finaldata) {
                $response['error'] = "0";
                $response['Restaurant'] = $finaldata;
                $response['lat'] = $lat;
                $response['lng'] = $long;
                $response['dist'] = $distance;
            } else {
                $response['error'] = "0";
                $response['data'] = "null";
            }
        } else {
            $response['error'] = "0";
            $response['message'] = "There is no data available";
        }

        echo json_encode($response);
        exit;
    }*/

    public function filterrestype() {
        Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {

            $lat = $_POST['lat']; //=30.5389944;
            $long = $_POST['lng']; //  =75.9550329;
            $distance = $_POST['amt'];
            $restype = $_POST['restype'];

            $restype1 = $_POST['restype1'];
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                if ($restype == '' || $restype == 'all') {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($restype == 'Delivery' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.delivery' => 1),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype == 'Takeaway' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.takeaway' => 1),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype == 'Takeaway' && $restype1 == 'Delivery') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype == 'Delivery' && $restype1 == 'Takeaway') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.typeid' => $restype),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
            if ($finaldata) {
                $response['error'] = "0";
                $response['Restaurant'] = $finaldata;
                $response['lat'] = $lat;
                $response['lng'] = $long;
                $response['dist'] = $distance;
            } else {
                $response['error'] = "0";
                $response['data'] = "null";
            }
        } else {
            $response['error'] = "0";
            $response['message'] = "There is no data available";
        }

        echo json_encode($response);
        exit;
    }

    public function filterbytype() {
        Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {

            $lat = $_POST['lat']; //=30.5389944;
            $long = $_POST['lng']; //  =75.9550329;
            $distance = $_POST['amt'];
            $restype = $_POST['restype'];
            $alltype = $_POST['alltype'];
            $restype1 = $_POST['restype1'];
            $alltypein_array = explode(',', $alltype);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                if ($alltypein_array[0] == 0) {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($restype == 'Delivery' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == 'Delivery') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.typeid' => $alltypein_array),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
            if ($finaldata) {
                $response['error'] = "0";
                $response['Restaurant'] = $finaldata;
                $response['lat'] = $lat;
                $response['lng'] = $long;
                $response['dist'] = $distance;
            } else {
                $response['error'] = "0";
                $response['data'] = "null";
            }
        } else {
            $response['error'] = "0";
            $response['message'] = "There is no data available";
        }

        echo json_encode($response);
        exit;
    }

    public function filterbyratings() {
        Configure::write("debug", 0);
        $this->Restaurant->recursive = 2;
        if ($this->request->is('post')) {

            $lat = $_POST['lat']; //=30.5389944;
            $long = $_POST['lng']; //  =75.9550329;
            $distance = $_POST['amt'];
            $restype = $_POST['restype'];
            $alltype = $_POST['alltype'];
            $restype1 = $_POST['restype1'];
            $alltypein_array = explode(',', $alltype);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return $this->redirect(array('controller' => 'products', 'action' => 'index'));
            } else {
                if ($alltypein_array[0] == 0) {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($restype == 'Delivery' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == 'Delivery') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.review_avg' => $alltypein_array),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
            if ($finaldata) {
                $response['error'] = "0";
                $response['Restaurant'] = $finaldata;
                $response['lat'] = $lat;
                $response['lng'] = $long;
                $response['dist'] = $distance;
            } else {
                $response['error'] = "0";
                $response['data'] = "null";
            }
        } else {
            $response['error'] = "0";
            $response['message'] = "There is no data available";
        }

        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $email_review
     * @return type
     */
    private function isEmail($email_review) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email_review));
    }

    public function review($id = NULL) {
        Configure::write("debug", 0);
        $shop = $this->Session->read('Shop');
        $this->Cart->clear();
        $this->Restaurant->recursive = 2;
        $this->loadModel('DishCategory');
        $this->loadModel('Product');
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $dishdata = $this->DishCategory->find('all');
        foreach ($dishdata as $d) {

            $d['DishCategory']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $d['DishCategory']['id']))));
            if ($d['DishCategory']['cnt'] == 0) {
                
            } else {
                $data['DishCategory'][] = $d['DishCategory'];
            }
        }
        if ($this->request->is('post')) {
            $this->loadModel('Review');
            $this->request->data['Review']['resid'] = $id;
            $this->request->data['Review']['name'] = $_POST['name_review'];
            $this->request->data['Review']['email'] = $_POST['email_review'];
            $this->request->data['Review']['food_quality'] = $_POST['food_review'];
            $this->request->data['Review']['price'] = $_POST['price_review'];
            $this->request->data['Review']['punctuality'] = $_POST['punctuality_review'];
            $this->request->data['Review']['courtesy'] = $_POST['courtesy_review'];
            $this->request->data['Review']['text'] = $_POST['review_text'];
            $this->request->data['Review']['uid'] = $this->Auth->user('id');
            $avg_rtng = $_POST['food_review'] + $_POST['price_review'] + $_POST['punctuality_review'] + $_POST['courtesy_review'];
            //debug($this->request->data);exit;
            $cnt = $this->Review->find('count', array('conditions' => array('AND' => array('Review.uid' => $this->Auth->user('id'), 'Review.resid' => $id))));
            if ($cnt == 0) {
                $this->Review->save($this->request->data);
                $resrev = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $rc = $resrev['Restaurant']['review_count'] + 1;
                $avrc = $resrev['Restaurant']['total_avr'] + $avg_rtng;
                $avg_rtng = ($avrc / $rc) / 4;
                $this->Restaurant->updateAll(array('Restaurant.review_count' => $rc, 'Restaurant.review_avg' => $avg_rtng, 'Restaurant.total_avr' => $avrc), array('Restaurant.id' => $id));
            }
        }
        $this->loadModel('Review');
        $this->loadModel('Gallery');
        $this->Review->recursive = 2;
        $this->set('restaurant', $this->Restaurant->find('first', $options));
        $this->set('discategory', $data);
        $this->set('Review', $this->Review->find('all', array('conditions' => array('Review.resid' => $id))));
        $this->set('Gallery', $this->Gallery->find('all', array('conditions' => array('Gallery.res_id' => $id))));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            debug($this->request->data);
            exit;
            $this->Restaurant->create();
            if ($this->Restaurant->save($this->request->data)) {
                return $this->flash(__('The restaurant has been saved.'), array('action' => 'index'));
            }
        }
        $users = $this->Restaurant->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Restaurant->save($this->request->data)) {
                return $this->flash(__('The restaurant has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
            $this->request->data = $this->Restaurant->find('first', $options);
        }
        $users = $this->Restaurant->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Restaurant->id = $id;
        if (!$this->Restaurant->exists()) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Restaurant->delete()) {
            return $this->flash(__('The restaurant has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The restaurant could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    public function admin_reset() {
        $this->Session->delete('Restaurant');
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function admin_index() {
        // $this->Session->delete('Restaurant');
        $this->layout = "admin";
        if ($this->request->is("post")) {
            //  print_r($this->request->data);exit;
            $filter = $this->request->data['Restaurant']['filter'];
            $name = $this->request->data['Restaurant']['name'];
            $conditions[] = array(
                'Restaurant.' . $filter . ' LIKE' => '%' . $name . '%',
            );
            $this->Session->write('Restaurant.filter', $filter);
            $this->Session->write('Restaurant.name', $name);
            $this->Session->write('Restaurant.conditions', $conditions);
            return $this->redirect(array('action' => 'index'));
        }
        if ($this->Session->check('Restaurant')) {
          
            $all = $this->Session->read('Restaurant');
        } else if($this->Auth->user('role')=="rest_admin"){
          $all = array(
                'name' => '',
                'filter' => '',
                'conditions' => array(
                'Restaurant.user_id' =>$this->Auth->user('id')
            )); 
        } else {
            $all = array(
                'name' => '',
                'filter' => '',
                'conditions' => ''
            );
        }
        $this->set(compact('all'));
        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array(
            'Restaurant' => array(
                'recursive' => 2,
                'contain' => array(
                ),
                'conditions' => array(
                ),
                'order' => array(
                    'Restaurant.created' => 'DESC'
                ),
                'limit' => 20,
                'conditions' => $all['conditions'],
                'paramType' => 'querystring',
            )
        );
        $this->set('restaurants', $this->Paginator->paginate());
    }

    public function admin_tableview($id = NULL) {

        Configure::write("debug", 0);
        $this->layout = "admin";
        $this->loadModel('Product');
        $this->loadModel('Cart');
        $this->Restaurant->recursive = 2;
        $this->Product->recursive = 2;
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $this->loadModel('RestaurantsType');
        $data = $this->Restaurant->find('first', $options);
        $this->set('restaurant', $data);
        $product_data = $this->Product->find('all', array('conditions' => array('Product.res_id' => $id), 'limit' => 4));
        $this->set('products', $product_data);
        //$this->loadModel('Restable');
        //$Restable = $this->Restable->find('all', array('conditions' => array('Restable.res_id' => $id), 'order' => 'Restable.id ASC'));
       // $this->set('rdata', $Restable);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        Configure::write("debug", 2);
        $this->layout = "admin";
        $this->loadModel('Product');
        $this->loadModel('Cart');
        $this->Restaurant->recursive = 2;
        $this->Product->recursive = 2;
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
        $this->loadModel('RestaurantsType');
        $data = $this->Restaurant->find('first', $options);
        $this->set('restaurant', $data);
        $product_data = $this->Product->find('all', array('conditions' => array('Product.res_id' => $id), 'limit' => 4));
        $this->set('products', $product_data);
       // $this->loadModel('Restable');
       // $Restable = $this->Restable->find('all', array('conditions' => array('Restable.res_id' => $id), 'order' => 'Restable.id ASC'));
       // $this->set('rdata', $Restable);
    }

    /**
     * 
     * @param type $param
     */
    /*public function admin_addtableresrv() {
        $this->loadModel('Restable');
        print_r($_POST);

        $this->request->data['Restable']['tableno'] = $_POST['tno'];
        $this->request->data['Restable']['res_id'] = $_POST['resid'];
        $cnt = $this->Restable->find('count', array('conditions' => array('Restable.tableno' => $_POST['tno'], 'Restable.res_id' => $_POST['resid'])));
        if ($cnt <= 0) {
            $this->Restable->save($this->request->data);
            echo "sucess";
        } else {
            echo "You have been Already Added";
        }
        exit;
    }*/

    /**
     * admin_addproduct method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_addproduct($id = null) {
        Configure::write("debug", 2);
        $this->layout = "admin";
        $this->loadModel('Product');
        if ($this->request->is('post')) {
            //debug($this->request->data);exit;

            $this->request->data['Product']['pro_id'] = serialize($this->request->data['Product']['proassociate']);
            //$this->request->data['Product']['alergi'] = serialize($this->request->data['Product']['alergi']);
            $this->request->data['Product']['res_id'] = $id;
            $image = $this->request->data['Product']['image'];
            $uploadFolder = "product";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                $this->Product->create();
                if ($this->Product->save($this->request->data)) {

                    $this->Session->setFlash('The product has been saved');
					return $this->redirect(array(
                                'controller' => 'products',
                                'action' => 'resindex/'.$id,
                                'manager' => false,
                                'admin' => true
                    ));
                  //  return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('The product could not be saved. Please, try again.');
                }
            }
        }
        /* $this->loadModel('Product');
          $this->Restaurant->recursive = 2;
          $this->Product->recursive = 2;
          if (!$this->Restaurant->exists($id)) {
          throw new NotFoundException(__('Invalid restaurant'));
          }
          $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
          $this->loadModel('RestaurantsType');
          $data = $this->Restaurant->find('first', $options);
          $this->set('restaurant', $data);
          $product_data = $this->Product->find('all', array('conditions' => array('Product.res_id' => $id)));
          $this->set('products', $product_data);
          //debug($product_data); */
        $this->loadModel('Product');
        $this->loadModel('DishCategory');
        $this->set('DishCategory', $this->DishCategory->find('list', array('conditions' => array('AND'=>array('DishCategory.isshow' => 0,'DishCategory.status' => 1)))));
        
        $this->set('id', $id);
    }

    public function admin_assoaddproduct($id = null) {
        Configure::write("debug", 2);
        $this->layout = "admin";
        $this->loadModel('Product');
        if ($this->request->is('post')) {
            //debug($this->request->data);exit;
//            $this->request->data['Product']['pro_id'] = serialize($this->request->data['Product']['proassociate']);
           // $this->request->data['Product']['alergi'] = serialize($this->request->data['Product']['alergi']);
            $this->request->data['Product']['res_id'] = $id;
            $image = $this->request->data['Product']['image'];
            $uploadFolder = "product";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                $this->Product->create();
                if ($this->Product->save($this->request->data)) {

                    $this->Session->setFlash('The product has been saved');

                    return $this->redirect(array('controller'=>'products','action' => 'assoresindex',$id));
                } else {
                    $this->Session->setFlash('The product could not be saved. Please, try again.');
                }
            }
        }
        /* $this->loadModel('Product');
          $this->Restaurant->recursive = 2;
          $this->Product->recursive = 2;
          if (!$this->Restaurant->exists($id)) {
          throw new NotFoundException(__('Invalid restaurant'));
          }
          $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
          $this->loadModel('RestaurantsType');
          $data = $this->Restaurant->find('first', $options);
          $this->set('restaurant', $data);
          $product_data = $this->Product->find('all', array('conditions' => array('Product.res_id' => $id)));
          $this->set('products', $product_data);
          //debug($product_data); */
        $this->loadModel('Product');
        $this->loadModel('DishCategory');
        $this->set('DishCategory', $this->DishCategory->find('list', array('conditions' => array('AND'=>array('DishCategory.isshow' => 1,'DishCategory.status' => 1)))));
        $this->set('id', $id);
    }

    /**
     * admin_adddishcat method
     *
     * @return void
     */
    public function admin_adddishcat($id = null) {
        $this->loadModel('DishCategory');
        if ($this->request->is('post')) {
            $this->DishCategory->create();
            if ($this->DishCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The dish category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * admin_adddishsubcat method
     *
     * @return void
     */
   /* public function admin_adddishsubcat($id = null) {
        $this->loadModel('DishSubcat');
        if ($this->request->is('post')) {
            $this->DishSubcat->create();
            if ($this->DishSubcat->save($this->request->data)) {
                $this->Session->setFlash(__('The dish subcat has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The dish subcat could not be saved. Please, try again.'));
            }
        }
        $dishCategories = $this->DishSubcat->DishCategory->find('list');
        $this->set(compact('dishCategories'));
    }*/

    ///////////////////
    /**
     * 
     * @param type $complete_address
     * @return boolean
     */
    private function getLetLong($complete_address) {
        if (!empty($complete_address)) {
            $format_address = str_replace(' ', '+', $complete_address);
            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $format_address . '&sensor=true', false);
            $output = json_decode($geocodeFromAddr);
            if (!empty($output)) {
                $data['latitude'] = $output->results[0]->geometry->location->lat;
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            }
            if (!empty($data)) {

                return $data;
            } else {
                $data['latitude'] = 0;
                $data['longitude'] = 0;
            }
        }
    }
    /*
     * 
     */
    public function LatLongFromAddress() {
        $complete_address=$_POST['address'];
        if (!empty($complete_address)) {
            $format_address = str_replace(' ', '+', $complete_address);
            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $format_address . '&sensor=true', false);
            $output = json_decode($geocodeFromAddr);
            if (!empty($output)) {
                //$data['output']=$output;
                $data['latitude'] = $output->results[0]->geometry->location->lat;
                $data['longitude'] = $output->results[0]->geometry->location->lng;
            }else{
                $data['latitude'] = 0;
                $data['longitude'] = 0;
            }
            print_r(json_encode($data));
        }
        exit;
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {

        if ($this->request->is('post')) {
            $image = $this->request->data['Restaurant']['logo'];
            $imagea = $this->request->data['Restaurant']['banner'];
            $offer_image = $this->request->data['Restaurant']['offer_image'];
            $marker_image = $this->request->data['Restaurant']['marker'];
            $offer_uploadPath = WWW_ROOT . '/files/offers' ;
            //$tax = $this->request->data['Restaurant']['taxes'];
            $uploadFolder = "restaurants";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            
            // 
//            $add = $this->request->data['Restaurant']['address'];
//            $cty = $this->request->data['Restaurant']['city'];
//            $state = $this->request->data['Restaurant']['state'];
//            $complete_address = $add . ',' . $cty . ',' . $state;
//            $latlong = $this->getLetLong($complete_address);
//            $latitude = $latlong['latitude'];
//            $longitude = $latlong['longitude'];
            //
            
            
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['logo'] = $imageName;
                // $this->request->data['Restaurant']['amities_selected'] = $ckbox;
                //upload image to upload folder
                move_uploaded_file($image['tmp_name'], $full_image_path);
            }else{
                $this->request->data['Restaurant']['logo'] = '';
            }
            
            if ($imagea['error'] == 0) {
                //image file name
                $imageName = $imagea['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['banner'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($imagea['tmp_name'], $full_image_path);
            }else{
                $this->request->data['Restaurant']['banner'] = '';
            }
            
            if ($offer_image['error'] == 0) {
                //image file name
                $imageName = $offer_image['name'];
                //check if file exists in upload folder
                if (file_exists($offer_uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $offer_uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['offer_image'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($offer_image['tmp_name'], $full_image_path);
            }else{
                $this->request->data['Restaurant']['offer_image'] = '';
            }
            
            if ($marker_image['error'] == 0) {
                //image file name
                $imageName = $marker_image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['marker'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($marker_image['tmp_name'], $full_image_path);
            }else{
                $this->request->data['Restaurant']['marker'] = '';
            }
            $this->Restaurant->create();
           // $this->request->data['Restaurant']['latitude'] = $latitude;
           // $this->request->data['Restaurant']['longitude'] = $longitude;
            if ($this->Restaurant->save($this->request->data)) {
                $id = $this->Restaurant->getLastInsertID();
              //  $this->loadModel('Tax');
              //  $this->request->data['Tax']['tax'] = $tax;
              //  $this->request->data['Tax']['resid'] = $id;
              //  $this->Tax->save($this->request->data);
                $this->Session->setFlash('The restaurant has been saved.');
                return $this->redirect(array('action' => 'index'));
            }

            $users = $this->Restaurant->User->find('list');
        } else {
            $rname = @$_GET['resname'];
            $this->loadModel('RestaurantsType');
            $restype = $this->RestaurantsType->find("list");
            $this->set('restype', $restype);
            $this->set('rname', $rname);
        }
        $this->set('restaurant_owners',$this->User->find('list',array('conditions'=>array('User.role'=>'rest_admin','User.active'=>1))));
    }

    /**
     * admin_fadd method for foodolic app in which city and state is for soudi arabia country
     *
     * @return void
     */
    public function admin_fadd() {
        if ($this->request->is('post')) {
//            print_r($this->request->data);
//            if($this->request->data['Restaurant']['areas']){
//                print_r($this->request->data['Restaurant']['areas']);
//            }
//            exit;
            $image = $this->request->data['Restaurant']['logo'];
            $uploadFolder = "restaurants";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['logo'] = $imageName;
                // $this->request->data['Restaurant']['amities_selected'] = $ckbox;
                //upload image to upload folder
                move_uploaded_file($image['tmp_name'], $full_image_path);
                $add = $this->request->data['Restaurant']['address'];
                $cty = $this->request->data['Restaurant']['city'];
                if (isset($this->request->data['Restaurant']['state'])) {
                    $state = $this->request->data['Restaurant']['state'];
                    $complete_address = $add . ',' . $cty . ',' . $state;
                    $latlong = $this->getLetLong($complete_address);
                    $latitude = $latlong['latitude'];
                    $longitude = $latlong['longitude'];
                } else {
                    $complete_address = $add . ',' . $cty;
                    $latlong = $this->getLetLong($complete_address);
                    $latitude = $latlong['latitude'];
                    $longitude = $latlong['longitude'];
                }
            }

            $this->Restaurant->create();
            $this->request->data['Restaurant']['latitude'] = $latitude;
            $this->request->data['Restaurant']['longitude'] = $longitude;
            if ($this->Restaurant->save($this->request->data)) {
                $rest_id = $this->Restaurant->getLastInsertID();

                if (isset($this->request->data['Restaurant']['areas'])) {
                    $this->loadModel('DeliverableArea');
                    foreach ($this->request->data['Restaurant']['areas'] as $area) {
                        $this->DeliverableArea->create();
                        $this->request->data['DeliverableArea']['res_id'] = $rest_id;
                        $this->request->data['DeliverableArea']['area_id'] = $area;
                        $this->DeliverableArea->save($this->request->data);
                    }
                }

                $this->Session->setFlash('The restaurant has been saved.');
                return $this->redirect(array('action' => 'index'));
            }

            $users = $this->Restaurant->User->find('list');
        } else {
            $this->loadModel('RestaurantsType');
            $restype = $this->RestaurantsType->find("list");
            $this->set('restype', $restype);

            $this->loadModel('City');
            $cities = $this->City->find("list", array(
                'fields' => array('City.id', 'City.city_name'),
                'conditions' => array(
                    'country_id' => 3
                )
            ));
            $this->set('cities', $cities);
        }
    }

  
    public function admin_edit($id = null, $res_uid = NULL) {
        Configure::write("debug", 2);
        $this->layout = "admin";
        $this->Restaurant->id = $id;
        //$this->Restaurant->user_id = $res_uid;
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        if ($this->request->is(array('post', 'put'))) {
        
            $add = $this->request->data['Restaurant']['address'];           
			$tax =0;
			$this->request->data['Restaurant']['taxes']= 0;
//            if(@$this->request->data['Restaurant']['taxes']){
//              $tax = $this->request->data['Restaurant']['taxes'];  
//             
//            }else {
//                $tax =0;
//            }            
            $cty = $this->request->data['Restaurant']['city'];
            $state = $this->request->data['Restaurant']['state'];
          //  $complete_address = $add . ',' . $cty . ',' . $state;
           // $latlong = $this->getLetLong($complete_address);
           // $latitude = $latlong['latitude'];
           // $longitude = $latlong['longitude'];
           // $this->request->data['Restaurant']['latitude'] = $latitude;
           // $this->request->data['Restaurant']['longitude'] = $longitude;
//            pr($this->request->data);exit;    
           // $this->request->data['Restaurant']['typeid'] = serialize($this->request->data['Restaurant']['typeid']);
            $image = $this->request->data['Restaurant']['logo'];
            $imagea = $this->request->data['Restaurant']['banner'];
            $offer_image = $this->request->data['Restaurant']['offer_image'];
            $marker_image = $this->request->data['Restaurant']['marker'];
            $offer_uploadPath = WWW_ROOT . '/files/offers' ;
            $uploadFolder = "restaurants";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['logo'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {

                $admin_edit = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $this->request->data['Restaurant']['logo'] = !empty($admin_edit['Restaurant']['logo']) ? $admin_edit['Restaurant']['logo'] : 'hotel.png';
            }
            if ($imagea['error'] == 0) {
                //image file name
                $imageName = $imagea['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['banner'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($imagea['tmp_name'], $full_image_path);
            } else {

                $admin_edit = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $this->request->data['Restaurant']['banner'] = !empty($admin_edit['Restaurant']['banner']) ? $admin_edit['Restaurant']['banner'] : 'hotel.png';
            }
            
            if ($offer_image['error'] == 0) {
                //image file name
                $imageName = $offer_image['name'];
                //check if file exists in upload folder
                if (file_exists($offer_uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $offer_uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['offer_image'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($offer_image['tmp_name'], $full_image_path);
            } else {

                $admin_edit = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $this->request->data['Restaurant']['offer_image'] = !empty($admin_edit['Restaurant']['offer_image']) ? $admin_edit['Restaurant']['offer_image'] : 'hotel.png';
            }
            
            if ($marker_image['error'] == 0) {
                //image file name
                $imageName = $marker_image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['marker'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($marker_image['tmp_name'], $full_image_path);
            } else {

                $admin_edit = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $this->request->data['Restaurant']['marker'] = !empty($admin_edit['Restaurant']['marker']) ? $admin_edit['Restaurant']['marker'] : 'marker.png';
            }
            
            if ($this->Restaurant->save($this->request->data)) {

              /*  $this->loadModel('Tax');
                $taxdata = $this->Tax->find('first', array(
                    'conditions' => array('Tax.resid' => $id)
                ));
                //print_r($taxdata);exit;
                $this->Tax->id = $taxdata['Tax']['id'];
                $this->request->data['Tax']['tax'] = $tax;
                //$this->request->data['Tax']['resid']=$id;
                $this->Tax->save($this->request->data);*/

                $this->Session->setFlash('The restaurant has been saved.');
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id),'recursive'=>1);
            $this->request->data = $this->Restaurant->find('first', $options);
            $this->loadModel('RestaurantsType');
            $restype = $this->RestaurantsType->find("list");
            $this->set('restype', $restype);
        }
        $this->loadModel('User');
        $this->set('uname', $this->User->find('first',array('conditions'=>array('User.id'=>$res_uid))));
        
        
        $users = $this->Restaurant->find('list');
        $this->set(compact('users'));
        $this->set('Restaurant', $this->request->data);
    }

    /*
     * admin_fedit method for foodolic app in which city and state is for soudi arabia country
     */

    public function admin_fedit($id = null) {
        $this->layout = "admin";
        $this->Restaurant->id = $id;
        if (!$this->Restaurant->exists($id)) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        if ($this->request->is(array('post', 'put'))) {
//            debug($this->request->data);exit;
            $add = $this->request->data['Restaurant']['address'];
            $cty = $this->request->data['Restaurant']['city'];
            $state = $this->request->data['Restaurant']['state'];
            $complete_address = $add . ',' . $cty . ',' . $state;
            $latlong = $this->getLetLong($complete_address);
            $latitude = $latlong['latitude'];
            $longitude = $latlong['longitude'];
            $this->request->data['Restaurant']['latitude'] = $latitude;
            $this->request->data['Restaurant']['longitude'] = $longitude;
//            pr($this->request->data);exit;        
            $image = $this->request->data['Restaurant']['logo'];
            $uploadFolder = "restaurants";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image name
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Restaurant']['logo'] = $imageName;
                //upload image to upload folder
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {

                $admin_edit = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id)));
                $this->request->data['Restaurant']['logo'] = !empty($admin_edit['Restaurant']['logo']) ? $admin_edit['Restaurant']['logo'] : 'hotel.png';
            }
            if ($this->Restaurant->save($this->request->data)) {
                $this->Session->setFlash('The restaurant has been saved.');
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Restaurant.' . $this->Restaurant->primaryKey => $id));
            $this->request->data = $this->Restaurant->find('first', $options);
            $this->loadModel('RestaurantsType');
            $restype = $this->RestaurantsType->find("list");
            $this->set('restype', $restype);
        }
        $users = $this->Restaurant->find('list');
        $this->set(compact('users'));
        $this->set('Restaurant', $this->request->data);
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->layout = "admin";
        $this->Restaurant->id = $id;
        if (!$this->Restaurant->exists()) {
            throw new NotFoundException(__('Invalid restaurant'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Restaurant->delete()) {
            $this->Session->setFlash(__('The restaurant has been deleted.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The restaurant could not be deleted. Please, try again.'));
            return $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * 
     * @param type $id
     */
    public function admin_activate($id = null) {
        $this->Restaurant->id = $id;
        if ($this->Restaurant->exists()) {
            $x = $this->Restaurant->save(array(
                'Restaurant' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash(__("Activated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }

    /**
     * 
     * @param type $id
     */
    public function admin_deactivate($id = null) {
        $this->Restaurant->id = $id;
        if ($this->Restaurant->exists()) {
            $x = $this->Restaurant->save(array(
                'Restaurant' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash(__("Activated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }

    /**
     * 
     * @param type $id
     * @throws MethodNotAllowedException
     */
    public function admin_activateall($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        foreach ($this->request['data']['Restaurant'] as $k => $v) {
            if ($k == $v) {
                $this->Restaurant->id = $v;
                if ($this->Restaurant->exists()) {
                    $x = $this->Restaurant->save(array(
                        'Restaurant' => array(
                            'status' => 1
                        )
                    ));

                    $this->Session->setFlash(__('Selected Restaurants Activated.', true));
                } else {
                    $this->Session->setFlash(__("Unable to Activate Restaurants."));
                }
            }
        }
        $this->redirect($this->referer());
    }

    public function admin_deleteall($id = null) {



        if (!$this->request->is('post')) {



            throw new MethodNotAllowedException();
        }



        foreach ($this->request['data']['Restaurant'] as $k) {



            $this->Restaurant->id = (int) $k;



            if ($this->Restaurant->exists()) {



                $this->Restaurant->delete();
            }
        }



        $this->Session->setFlash(__('Restaurant deleted....'));



        $this->redirect(array('action' => 'index'));
    }

    /**
     * 
     * @param type $id
     * @throws MethodNotAllowedException
     */
    public function admin_inactivateall($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        foreach ($this->request['data']['Restaurant'] as $k => $v) {
            if ($k == $v) {
                $this->Restaurant->id = $v;
                if ($this->Restaurant->exists()) {
                    $x = $this->Restaurant->save(array(
                        'Restaurant' => array(
                            'status' => 0
                        )
                    ));
                    $this->Session->setFlash(__('Selected Restaurants Deactivated.', true));
                } else {
                    $this->Session->setFlash(__("Unable to Deactivate Restaurants."));
                }
            }
        }
        $this->redirect($this->referer());
    }

    /*public function admin_checkin() {
        $this->loadModel('UserCheckin');
        $this->layout = "admin";
        $this->UserCheckin->recursive = 0;
        //pr($this->Paginator->paginate());
        $this->set('userCheckins', $this->Paginator->paginate('UserCheckin', array('UserCheckin.is_check' => 1)));
    }

    public function admin_bookmark() {
        $this->loadModel('BookmarkDishes');
        $this->layout = "admin";
        $this->BookmarkDishes->recursive = 0;
        //pr($this->Paginator->paginate());
        $this->set('bookmarkDishes', $this->Paginator->paginate('BookmarkDish', array('BookmarkDish.restaurant_id' => 1)));
    }*/

    /*     * ****************************Web services for  the restaurants************************ */

    /**
     * url detector
     * @param type $haystack
     * @param type $needle
     * @param type $offset
     * @return boolean
     */
    private function strposa($haystack, $needle, $offset = 0) {
        if (!is_array($needle))
            $needle = array($needle);
        foreach ($needle as $query) {
            if (strpos($haystack, $query, $offset) !== false)
                return true; // stop on first true result
        }
        return false;
    }
    

    /*
      DELIMITER $$

      DROP FUNCTION IF EXISTS `get_distance_in_miles_between_geo_locations` $$
      CREATE FUNCTION get_distance_in_miles_between_geo_locations(geo1_latitude decimal(10,6), geo1_longitude decimal(10,6), geo2_latitude decimal(10,6), geo2_longitude decimal(10,6))
      returns decimal(10,3) DETERMINISTIC
      BEGIN
      return ((ACOS(SIN(geo1_latitude * PI() / 180) * SIN(geo2_latitude * PI() / 180) + COS(geo1_latitude * PI() / 180) * COS(geo2_latitude * PI() / 180) * COS((geo1_longitude - geo2_longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515);
      END $$

      DELIMITER ;

     */

    /**
     * @desc All restaurant listing in specific distance
     * @name All restaurant listing 
     * @link  get_distance_in_miles_between_geo_locations
     */
    public function api_restaurantslist() {
        configure::write('debug', 2);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
       // $lat="28.291666";
       // $long="50.220013";
        //$redata="aafs";
        $lat = $redata->data->Restaurant->latitude; //=30.5389944;
        $long = $redata->data->Restaurant->longitude; //  =75.9550329;
        $response['pos']['lat'] = $lat;
        $response['pos']['lng'] = $long;
        if (!empty($redata)) {
            $this->loadModel("RestaurantsType");
          //  $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*"),
                    "ORDER BY" => 'DESC',
                    'recursive'=>1
                ));
               // print_r($data);
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $today_day = date('l');
                    $today_time = date("g:iA");
                   if($today_day =='Saturday' || $today_day =='Sunday'){
                       $opening_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_opening_time']));
                       $closing_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_closing_time']));
                   }else{
                        $opening_time=date("g:iA", strtotime($data[$i]['Restaurant']['opening_time']));
                        $closing_time=date("g:iA", strtotime($data[$i]['Restaurant']['closing_time']));
                   }

                   if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                        $data[$i]['Restaurant']['is_open']=1;
                    }else{
                        $data[$i]['Restaurant']['is_open']=0;
                    }
                    $data[$i]['Restaurant']['now']=$today_time;
                    // Unavailable Today starts here
                    $today_date_format = date("Y-m-d");
                    $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                               'AND'=>array(
                                   'UnavailableDate.unavailabledate'=>$today_date_format,
                                   'UnavailableDate.restaurant_id'=>$data[$i]['Restaurant']['id']    
                               )
                           )
                        ));
                    if($unavailable_for_selectedDate){
                        $data[$i]['Restaurant']['closed_today']=1;
                    }else{
                        $data[$i]['Restaurant']['closed_today']=0;
                    }
                    // Unavailable Today ends here
                    $data[$i]['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['banner'];
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    $data[$i]['Restaurant']['opening_time']=$opening_time;
                    $data[$i]['Restaurant']['closing_time']=$closing_time;
                    if(!empty($data[$i]['Restaurant']['offer_image'])){
                        $data[$i]['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $data[$i]['Restaurant']['offer_image'];
                    }
                    if(!empty($data[$i]['Promocode'])){
                        $data[$i]['Restaurant']['Promocodes'] = 1;
                    }else{
                        $data[$i]['Restaurant']['Promocodes'] = 0;
                    }
                    if(!empty($data[$i]['Discount'])){
                        $data[$i]['Restaurant']['Discount'] = 1;
                    }else{
                        $data[$i]['Restaurant']['Discount'] = 0;
                    }
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            $featured_restaurants = array();
            foreach ($data as $d) {
                if($d['Restaurant']['is_featured']==1){
                    array_push($featured_restaurants, $d['Restaurant']);
                }
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                if(!empty($d['Promocode'])){
                    $finaldata['Restaurant'][$j]['Promocode'] = $d['Promocode'];
                }
                
               // $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));

                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
            //debug($finaldata);exit;
            $this->loadModel('Offer');
            $this->Offer->recursive=1;
            $offers = $this->Offer->find('all',array(
                'conditions'=>array(
                    'Offer.quantity >'=>0,
                    'Offer.start_date <'=>date('Y-m-d h:i:s'),
                    'Offer.end_date >'=>date('Y-m-d h:i:s')
                ),
                'fields'=>  array(
                "get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*",
                "Offer.res_id","start_date","end_date"
                ),
                'group'=>'Offer.res_id'
                ));
            $offer_list = array();
            if($offers){
                foreach($offers as $offer){
                    
                    $today_day = date('l');
                    $today_time = date("g:iA");
                   if($today_day =='Saturday' || $today_day =='Sunday'){
                       $opening_time = date("g:iA", strtotime($offer['Restaurant']['weekend_opening_time']));
                       $closing_time = date("g:iA", strtotime($offer['Restaurant']['weekend_closing_time']));
                   }else{
                        $opening_time=date("g:iA", strtotime($offer['Restaurant']['opening_time']));
                        $closing_time=date("g:iA", strtotime($offer['Restaurant']['closing_time']));
                   }

                   if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                        $offer['Restaurant']['is_open']=1;
                    }else{
                        $offer['Restaurant']['is_open']=0;
                    }
                    
                    if(!empty($offer['Restaurant']['banner'])){
                        $offer['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['banner'];
                    }
                    if(!empty($offer['Restaurant']['logo'])){
                        $offer['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['logo'];
                    }
                    if(!empty($offer['Restaurant']['offer_image'])){
                        $offer['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Restaurant']['offer_image'];
                    }
                    $offer_list[]=$offer;
                }
            }
            
            if ($finaldata) {
                $response['isSuccess'] = true;
                $response['data'] = $finaldata;
                $response['featured_restaurants']=$featured_restaurants;
                $response['offers']=$offer_list;
            } else {
                $response['isSuccess'] = false;
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = false;
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    
    public function api_offersByRestaurant(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        
        if($redata){
            $this->loadModel('Offer');
            $this->Offer->recursive=1;
            $conditions =[];
            $conditions[]=array( //2017-02-06 10:32:46
                   'Offer.res_id'=>$redata->res_id,
                   'Offer.start_date <'=>date('Y-m-d h:i:s'),
                   'Offer.end_date >'=>date('Y-m-d h:i:s'),
                    'Offer.quantity >'=>0
               );
            if(isset($redata->selected_order_type)){
                if($redata->selected_order_type=='catering'){
                    $conditions['Offer.catering']=1;
                }else if($redata->selected_order_type=='pickup'){
                    $conditions['Offer.pickup']=1;
                }else if($redata->selected_order_type=='delivery'){
                    $conditions['Offer.delivery']=1;
                    //$conditions[]=array('Offer.delivery'=>1);
                }
            }
                
            $offers = $this->Offer->find('all',array('conditions'=>array(
               'AND'=>array( //2017-02-06 10:32:46
                   $conditions
               )
                )));
//            $offers = $this->Offer->find('all',array('conditions'=>array(
//               'AND'=>array( //2017-02-06 10:32:46
//                   'Offer.res_id'=>$redata->res_id,
//                   'Offer.start_date <'=>date('Y-m-d h:i:s'),
//                   'Offer.end_date >'=>date('Y-m-d h:i:s')
//               )
//                )));
            if($offers){
                foreach($offers as $offer){
                    if(!empty($offer['Restaurant']['banner'])){
                        $offer['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['banner'];
                    }
                    if(!empty($offer['Restaurant']['logo'])){
                        $offer['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['logo'];
                    }
                    if(!empty($offer['Restaurant']['offer_image'])){
                        $offer['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Restaurant']['offer_image'];
                    }
                    if(!empty($offer['Offer']['image'])){
                        $offer['Offer']['image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Offer']['image'];
                    }
                    $start_date = date_create($offer['Offer']['start_date']);
                    $end_date = date_create($offer['Offer']['end_date']);
                    $offer['Offer']['start_date']=date_format($start_date,"d M,Y H:i A");
                    $offer['Offer']['end_date']=date_format($end_date,"d M,Y H:i A");
                    $offer_list[]=$offer;
                }
                $response['isSuccess']=true;
                $response['data']=$offer_list;
            }else{
                $response['isSuccess']=false;
                $response['msg']="No offers found";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="No data to filter";
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    public function api_offersDetail(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        
        if($redata){
            $this->loadModel('Offer');
            $this->Offer->recursive=1;
            $offer = $this->Offer->find('first',array('conditions'=>array(
               'AND'=>array( //2017-02-06 10:32:46
                   'Offer.id'=>$redata->id,
                   'Offer.start_date <'=>date('Y-m-d h:i:s'),
                   'Offer.end_date >'=>date('Y-m-d h:i:s')
               )
                )));
            if($offer){
                    if(!empty($offer['Restaurant']['banner'])){
                        $offer['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['banner'];
                    }
                    if(!empty($offer['Restaurant']['logo'])){
                        $offer['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['logo'];
                    }
                    if(!empty($offer['Restaurant']['offer_image'])){
                        $offer['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Restaurant']['offer_image'];
                    }
                    if(!empty($offer['Offer']['image'])){
                        $offer['Offer']['image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Offer']['image'];
                    }
                 
                $response['isSuccess']=true;
                $response['data']=$offer;
            }else{
                $response['isSuccess']=false;
                $response['msg']="No offers found";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="No data to filter";
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    public function api_restaurantDetail(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $res_id = $redata->res_id;
        if($res_id){
            $restaurant = $this->Restaurant->find("first",array(
                "conditions"=>array("Restaurant.id"=>$res_id),
                'recursive'=>2,
//                "contain"=>array('Reviews')
                ));
//            $this->loadModel('RestaurantsReview');
            if($restaurant){
                $restaurant_Detail=array();
                $restaurant['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $restaurant['Restaurant']['banner'];
                $restaurant['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $restaurant['Restaurant']['logo'];
                $restaurant['Restaurant']['opening_time']=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                $restaurant['Restaurant']['closing_time']=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
                $restaurant['Restaurant']['weekend_closing_time']=date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
                $restaurant['Restaurant']['weekend_opening_time']=date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));
                
                // user set this restaurant as favourite or not
                if(isset($redata->user_id)){
                    $this->loadModel('Favrest');
                    $user_id = $redata->user_id;
                    $is_favourite = $this->Favrest->find('first', array('conditions' => array('AND' => array('Favrest.res_id' => $res_id, 'Favrest.user_id' => $user_id))));
                    if(!empty($is_favourite)){
                       $restaurant['Restaurant']['is_favourite'] =1;
                    }else{
                        $restaurant['Restaurant']['is_favourite'] =0;
                    }
                }else{
                    $restaurant['Restaurant']['is_favourite'] =0;
                }
                
                
                $pickup=0;
                $delivery=0;
                $catering=0;

                // if(isset($redata->order_type)){
                //     $.''.$redata->order_type = $redata->order_type;
                //     //$pickup = 1;
                // }
                
                $this->loadModel('Product');
                $products = $this->Product->find("all",array("conditions"=>array(
                    // "OR"=>array(
                    //     "Product.catering"=>$catering,
                    //     "Product.delivery"=>$delivery,
                    //     "Product.pickup"=>$pickup
                    //     ),
                    "AND"=>array(
                        "Product.res_id"=>$res_id,
                         "Product.$redata->order_type"=>1,
                        "Product.quantity >"=>0
                        //"Product.delivery"=>$delivery,
                       // "Product.pickup"=>$pickup
                        )
                    
                    )));
                $category_ids=array();
                foreach($products as $product){
                    if(!in_array($product['Product']['dishcategory_id'],$category_ids)){
                        array_push($category_ids, $product['Product']['dishcategory_id']);
                    }
                }
                // List Dish Categories
                $this->loadModel('DishCategory');
                $dish_categories = $this->DishCategory->find("all",array("conditions"=>array(
                    "AND"=>array(
                     "DishCategory.id"=>$category_ids,
                     "DishCategory.isshow"=>0
                    )
                        )));
                $category_products = array();
                // Most Popular Products
                $popular_products = $this->Product->find("all",array("conditions"=>array("AND"=>array(
                        "Product.res_id"=>$res_id,
                        "Product.most_popular"=>1,
                        "Product.$redata->order_type"=>1,
                    ))));
                if($popular_products){
                    $category_products['Most Popular']['products']=$popular_products;
                    $category_products['Most Popular']['category']['image']=FULL_BASE_URL . $this->webroot . "files/catimage/popular-food.png";
                }
                
                foreach($dish_categories as $category){
                    $cat_products = $this->Product->find("all",array("conditions"=>array("AND"=>array(
                        "Product.res_id"=>$res_id,
                        "Product.dishcategory_id"=>$category['DishCategory']['id']
                    ))));
                    $category['DishCategory']['image'] = FULL_BASE_URL . $this->webroot . "files/catimage/" . $category['DishCategory']['image'];
                    $inner_array =array();
                    $inner_array['products']=$cat_products;
                    $inner_array['category']= $category['DishCategory'];
                    $category_products[$category['DishCategory']['name']]=$inner_array;
                }
                // Reviews
                $reviews=array();
                if(!empty($restaurant['Reviews'])){
                    foreach($restaurant['Reviews'] as $review){
                        // print_r($review); exit;
                        // Time difference
                        $start_date = new DateTime($review['created']);
                        $today = date("Y-m-d h:i:s");
                        $end_date = new DateTime($today);
                        $interval = $start_date->diff($end_date);
                        //print_r($interval);
                        //echo "Result " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
                        if($interval->y == 0){
                            if($interval->m == 0){
                                if($interval->d == 0){
                                    if($interval->h==0){
                                        if($interval->i==0){
                                            if($interval->s==0){
                                                $review['time_difference']="Just Now";
                                            }else{
                                                $review['time_difference'] = $interval->s." s";
                                            }
                                        }else{
                                            $review['time_difference'] = $interval->i." i";
                                        }
                                    }else{
                                        $review['time_difference'] = $interval->h." h";
                                    }
                                }else{
                                    $review['time_difference'] = $interval->d." d";
                                }
                            }else{
                                $review['time_difference'] = $interval->m." m";
                            }
                        }else{
                            $review['time_difference'] = $interval->y." y";
                        }


                        if(!empty($review['User']['image'])){
                            $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $review['User']['image'];
                        }else{
                            $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                        }
                        $reviews[]=$review;
                    }
                }
                
                $restaurant_Detail['Restaurant']=$restaurant['Restaurant'];
                $restaurant_Detail['category_products']=$category_products;
                $restaurant_Detail['Reviews']=$reviews;
                $response['isSuccess']=true;
                $response['data']=$restaurant_Detail;
//                print_r($category_products);
//                exit; 
            }else{
                $response['isSuccess']=false;
                $response['msg']="No restaurant exist with this ID";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="No data to filter data";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }


    /*
    * Restaurant listing according to selected event date time
    * parameters: latitude, longitude, eventdate
    */
    public function api_restaurantsOnSelectedDate() {
        configure::write('debug', 2);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
      //  $lat="24.713552";
      //  $long="46.675296";
       // $eventdate = '2017-03-15T07:48:00.000Z';
        //$redata="aafs";
        //print_r($redata);
        $lat = $redata->data->Restaurant->latitude; //=30.5389944;
        $long = $redata->data->Restaurant->longitude; //  =75.9550329;
        $eventdate = $redata->data->Restaurant->eventdate;
        $today = date('Y-m-d H:i:s');

        $datetime1 = date_create($eventdate);
        $datetime2 = date_create($today);
         $event_date_format = date("Y-m-d",strtotime($eventdate));
   
        $interval = date_diff($datetime1, $datetime2);
        //print_r($interval); 
        $days = $interval->format('%a');
        $hours = $interval->h + ($days * 24);
        $response['pos']['lat'] = $lat;
        $response['pos']['lng'] = $long;
        if (!empty($redata)) {
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all',
                 array(
                    'conditions'=>array('AND'=>array(
                        'Restaurant.lead_time <='=>$hours,
                        'Restaurant.catering'=>1
                        )),
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'UnavailableDate.unavailabledate'=>$event_date_format,
                            'UnavailableDate.restaurant_id'=>$data[$i]['Restaurant']['id']
                        )
                    )));
                    if($unavailable_for_selectedDate){
                        unset($data[$i]);
                    }else{
                        $data[$i]['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['banner'];
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                        $data[$i]['Restaurant']['opening_time']=date("g:iA", strtotime($data[$i]['Restaurant']['opening_time']));
                        $data[$i]['Restaurant']['closing_time']=date("g:iA", strtotime($data[$i]['Restaurant']['closing_time']));
                        if(!empty($data[$i]['Restaurant']['offer_image'])){
                            $data[$i]['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $data[$i]['Restaurant']['offer_image'];
                        }
                    }
                    
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            $featured_restaurants = array();
            foreach ($data as $d) {
                if($d['Restaurant']['is_featured']==1){
                    array_push($featured_restaurants, $d['Restaurant']);
                }
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));

                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
            //debug($finaldata);exit;
            $this->loadModel('Offer');
            $this->Offer->recursive=1;
            $offers = $this->Offer->find('all',array(
                'conditions'=>array(
                    'Offer.quantity >'=>0,
                    'Offer.start_date <'=>date('Y-m-d h:i:s'),
                    'Offer.end_date >'=>date('Y-m-d h:i:s')
                ),
                'fields'=>  array(
                "get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*",
                "Offer.res_id","start_date","end_date"
                ),
                'group'=>'Offer.res_id'
                ));
            $offer_list = array();
            if($offers){
                foreach($offers as $offer){
                    if(!empty($offer['Restaurant']['banner'])){
                        $offer['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['banner'];
                    }
                    if(!empty($offer['Restaurant']['logo'])){
                        $offer['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $offer['Restaurant']['logo'];
                    }
                    if(!empty($offer['Restaurant']['offer_image'])){
                        $offer['Restaurant']['offer_image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $offer['Restaurant']['offer_image'];
                    }
                    $offer_list[]=$offer;
                }
            }
            if ($finaldata) {
                $response['isSuccess'] = true;
                $response['data'] = $finaldata;
                $response['featured_restaurants']=$featured_restaurants;
                $response['offers']=$offer_list;
            } else {
                $response['isSuccess'] = false;
                $response['msg'] = "No restaurant available for this date. Please try using another date.";
            }
        } else {
            $response['isSuccess'] = false;
            $response['msg'] = "There is no data available2";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    /**
     * @desc All restaurant listing in specific distance
     * @name All restaurant listing 
     * @link  get_distance_in_miles_between_geo_locations
     *   ob_start();
      // $postdata = file_get_contents("php://input");
      print_r($postdata );
      $c = ob_get_clean();
      $fc = fopen('files' . DS . 'detail.txt', 'w');
      fwrite($fc, $c);
      fclose($fc);
     * parameters: city, area, address, user_id. user_id to check whether user selects restaurant as favourite or not
     */
    public function api_restaurantslistbyadd() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
//        ob_start();
//       $postdata = file_get_contents("php://input");
//      print_r($redata );
//      $c = ob_get_clean();
//      $fc = fopen('files' . DS . 'detail.txt', 'w');
//      fwrite($fc, $c);
//      fclose($fc);
//        $redata = (object)['city'=>'riyadh','area'=>'','address'=>'','user_id'=>1];
        if (!empty($redata)) {
            $address = $redata->city . ',' . $redata->area . ',' . $redata->address;
            $latlong = $this->getLetLong($address);
            //debug($latlong);
            $lat = $latlong['latitude'];
            $long = $latlong['longitude'];
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no lat long available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC'
                ));
                //  debug($data);
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));
                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }
                $j++;
            }

//            debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no final data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    /*
      DELIMITER $$

      DROP FUNCTION IF EXISTS `get_distance_in_miles_between_geo_locations` $$
      CREATE FUNCTION get_distance_in_miles_between_geo_locations(geo1_latitude decimal(10,6), geo1_longitude decimal(10,6), geo2_latitude decimal(10,6), geo2_longitude decimal(10,6))
      returns decimal(10,3) DETERMINISTIC
      BEGIN
      return ((ACOS(SIN(geo1_latitude * PI() / 180) * SIN(geo2_latitude * PI() / 180) + COS(geo1_latitude * PI() / 180) * COS(geo2_latitude * PI() / 180) * COS((geo1_longitude - geo2_longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515);
      END $$

      DELIMITER ;

     */

    /**
     * @desc All restaurant listing in specific distance
     * @name All restaurant listing 
     * @link  get_distance_in_miles_between_geo_locations
     */
    public function api_restaurantslistb() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $lat = $redata->data->Restaurant->latitude; //=30.5389944;
        $long = $redata->data->Restaurant->longitude; //  =75.9550329;
        $response['pos']['lat'] = $lat;
        $response['pos']['lng'] = $long;
        if (!empty($redata)) {
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "conditions" => array('Restaurant.reservation' => 1),
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];

                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
            //debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    /**
     * @desc All restaurant listing in specific distance
     * @name All restaurant listing 
     * @link  get_distance_in_miles_between_geo_locations
     *   ob_start();
      // $postdata = file_get_contents("php://input");
      print_r($postdata );
      $c = ob_get_clean();
      $fc = fopen('files' . DS . 'detail.txt', 'w');
      fwrite($fc, $c);
      fclose($fc);
     * parameters: city, area, address, user_id. user_id to check whether user selects restaurant as favourite or not
     */
    public function api_restaurantslistbyaddb() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
//        ob_start();
//       $postdata = file_get_contents("php://input");
//      print_r($redata );
//      $c = ob_get_clean();
//      $fc = fopen('files' . DS . 'detail.txt', 'w');
//      fwrite($fc, $c);
//      fclose($fc);
//        $redata = (object)['city'=>'riyadh','area'=>'','address'=>'','user_id'=>1];
        if (!empty($redata)) {
            $address = $redata->city . ',' . $redata->area . ',' . $redata->address;
            $latlong = $this->getLetLong($address);
            //debug($latlong);
            $lat = $latlong['latitude'];
            $long = $latlong['longitude'];
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no lat long available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "conditions" => array('Restaurant.reservation' => 1),
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC'
                ));
                //  debug($data);
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));
                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }
                $j++;
            }

//            debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no final data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_getresmenu() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {
            $id = $redata->Restaurant->id;
            $this->loadModel("RestaurantsType");
            $this->loadModel("DishCategory");
            $this->loadModel("Product");
            $data = $this->Restaurant->find('all', array('conditions' => array('Restaurant.id' => $id)));
            foreach ($data as $d) {
                $d['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $d['Restaurant']['logo'];
                $res[] = $d['Restaurant'];
                $res[]['type'] = $d['RestaurantsType'];
                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $res[]['favrest'] = 1;
                        } else {
                            $res[]['favrest'] = 0;
                        }
                    } else {
                        $res[]['favrest'] = 0;
                    }
                } else {
                    $res[]['favrest'] = 0;
                }
            }
            $dishdata = $this->DishCategory->find('all');
            foreach ($dishdata as $d) {

                $d['DishCategory']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $id, 'Product.dishcategory_id' => $d['DishCategory']['id'],'Product.sale'=>0))));
                if ($d['DishCategory']['cnt'] == 0) {
                    
                } else {
                    
                    $dataa[]['DishCategory'] = $d['DishCategory'];
                }
            }
              
             
               for ($i = 0; $i < count($dataa); $i++) {

                $dataa[$i]['DishCategory']['image'] = FULL_BASE_URL . $this->webroot . "files/catimage/" . $dataa[$i]['DishCategory']['image'];
               }
           // print_r($dataa);exit;
            if ($data) {
                $response['isSuccess'] = "true";
                $response['data'] = $res;
                $response['data']['cat'] = $dataa;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    /*public function api_dishsubcat() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
        if (!empty($redata)) {
            $rid = $redata->Restaurant->id;
            ;
            $id = $redata->DishSubcat->id;
            $this->loadModel('DishSubcat');
            $data = $this->DishSubcat->find('all', array('conditions' => array('DishSubcat.dish_catid' => $id)));
            //debug($data); exit;
            $this->loadModel('Product');
            foreach ($data as $d) {
                $d['DishSubcat']['cnt'] = $this->Product->find('count', array('conditions' => array('AND' => array('Product.res_id' => $rid, 'Product.dishsubcat_id' => $d['DishSubcat']['id']))));

                if ($d['DishSubcat']['cnt'] == 0) {
                    
                } else {
                    $dataa[]['DishSubcat'] = $d['DishSubcat'];
                }
            }
             for ($i = 0; $i < count($dataa); $i++) {

                $dataa[$i]['DishSubcat']['image'] = FULL_BASE_URL . $this->webroot . "files/subcatimage/" . $dataa[$i]['DishSubcat']['image'];
               }
            //  debug($dataa);exit;
            if ($dataa) {
                $response['isSuccess'] = "true";
                $response['data'] = $dataa;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }*/

    public function api_restaurantbyid() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 1;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $resid = $redata->Restaurant->id;
//        $resid=642;
        if (!$resid) {
            $response['isSucess'] = "false";
            $response['msg'] = "There is no data available";
        } else {
            $data = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $resid)));
            $response['data'] = $data['Restaurant'];
            $response['data']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data['Restaurant']['logo'];
        //    $response['data']['typename'] = $data['RestaurantsType']['name'];
            if (!empty($data['Favrest'])) {
                $fav_rest_user = array();
                foreach ($data['Favrest'] as $fav_rest) {
                    array_push($fav_rest_user, $fav_rest['user_id']);
                }
                if (isset($redata->user_id)) {
                    $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                    if ($set_as_fav) {
                        $response['data']['favrest'] = 1;
                    } else {
                        $response['data']['favrest'] = 0;
                    }
                } else {
                    $response['data']['favrest'] = 0;
                }
            } else {
                $response['data']['favrest'] = 0;
            }
            $response['isSucess'] = "true";
        }

        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_restaurantofferbyid() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $resid = $redata->Restaurant->id;

        if (!$resid) {
            $response['isSucess'] = "false";
            $response['msg'] = "There is no data available";
        } else {
            $this->loadModel('Offer');
            $data = $this->Offer->find('all', array('conditions' => array('Offer.res_id' => $resid)));
            $response['data'] = $data;
            for ($i = 0; $i < count($data); $i++)
                $response['data'][$i]['Offer']['image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $data[$i]['Offer']['image'];
            $response['isSucess'] = "true";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_nearestofferbyadd() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {
            $address = $redata->city . ',' . $redata->area . ',' . $redata->address;
            $latlong = $this->getLetLong($address);
            $lat = $latlong['latitude'];
            $long = $latlong['longitude'];
            $this->loadModel("Offer");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*"),
                    "ORDER BY" => 'DESC',
                ));
            }
        }


        $cnt = count($data);
        for ($i = 0; $i < $cnt; $i++) {
            if ($data[$i][0]['distance'] >= $this->distance)
                unset($data[$i]);
            if (isset($data[$i]) && count($data[$i]['Offer']) <= 0)
                unset($data[$i]);
        }
        $final = array();
        foreach ($data as $d)
            array_push($final, $d);

        for ($i = 0; $i < count($final); $i++) {


            for ($j = 0; $j < count($final[$i]['Offer']); $j++) {
                $final[$i]['Offer'][$j]['image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $final[$i]['Offer'][$j]['image'];
            }
        }

        if ($final) {
            $response['isSuccess'] = "true";
            $response['data'] = $final;
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }

        //debug($finaldata);exit;
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_nearestofferbygeo() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if (!empty($redata)) {
            $lat = $redata->data->Restaurant->latitude; //=30.5389944;
            $long = $redata->data->Restaurant->longitude; //  =75.9550329;
            $this->loadModel("Offer");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*"),
                    "ORDER BY" => 'DESC',
                ));
            }
        }


        $cnt = count($data);
        for ($i = 0; $i < $cnt; $i++) {
            if ($data[$i][0]['distance'] >= $this->distance)
                unset($data[$i]);
            if (isset($data[$i]) && count($data[$i]['Offer']) <= 0)
                unset($data[$i]);
        }
        $final = array();
        foreach ($data as $d)
            array_push($final, $d);

        for ($i = 0; $i < count($final); $i++) {
            for ($j = 0; $j < count($final[$i]['Offer']); $j++) {
                $final[$i]['Offer'][$j]['image'] = FULL_BASE_URL . $this->webroot . "files/offers/" . $final[$i]['Offer'][$j]['image'];
            }
        }

        if ($final) {
            $response['isSuccess'] = "true";
            $response['data'] = $final;
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }

        //debug($finaldata);exit;
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_filterbytype() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);

        if (!empty($redata)) {

            $lat = $redata->data->Restaurant->latitude; //=30.5389944;
            $long = $redata->data->Restaurant->longitude; //  =75.9550329;
            $distance = $redata->data->Restaurant->distance;
            $restype = $redata->data->Restaurant->restype;
            $alltype = $redata->data->Restaurant->alltype;
            $restype1 = $redata->data->Restaurant->restype1;
            $alltypein_array = explode(',', $alltype);
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {

                return false;
            } else {
                if ($alltypein_array[0] == 0) {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($restype == 'Delivery' && $restype1 == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == '') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } elseif ($restype1 == 'Takeaway' && $restype == 'Delivery') {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.takeaway' => 1, 'Restaurant.delivery' => 1, 'Restaurant.typeid' => $alltypein_array)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.typeid' => $alltypein_array),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
            if ($finaldata) {
                $response['error'] = "0";
                $response['Restaurant'] = $finaldata;
                $response['lat'] = $lat;
                $response['lng'] = $long;
                $response['dist'] = $distance;
            } else {
                $response['error'] = "0";
                $response['data'] = "null";
            }
        } else {
            $response['error'] = "0";
            $response['message'] = "There is no data available";
        }

        echo json_encode($response);
        exit;
    }

    public function api_frestaurantslistbyadd() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 1;
        $this->layout = "ajax";
//        $redata = (object)['id'=>1,'user_id'=>1];
        if (!empty($redata)) {
            $area_id = $redata->id;
//            $db = $this->Restaurant->getDataSource();
//            $db->fullDebug = true;
            $data = $this->Restaurant->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'deliverable_areas',
                        'alias' => 'AreaJoin',
                        'type' => 'INNER',
                        'conditions' => array(
                            'AreaJoin.res_id = Restaurant.id',
                            'AreaJoin.area_id = "' . $area_id . '"'
                        )
                    ),
                    array(
                        'table' => 'favrests',
                        'alias' => 'Favrestt',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Favrestt.res_id = Restaurant.id',
                            'Favrestt.user_id = "' . $redata->user_id . '"'
                        )
                    )
                ),
                'fields' => array('AreaJoin.*', 'Restaurant.*', 'Favrestt.*', 'RestaurantsType.*')
            ));

//            $log = $db->getLog();
//            print_r($log['log']);
//            debug($data); exit;
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {

                $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];

                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));
                if ($d['Favrestt']['id'] != null) {
                    $finaldata['Restaurant'][$j]['favrest'] = 1;
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
//            debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    /**
     * 
     *   
     */
    public function api_frestaurantsbyaddname() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $res_name = $redata->Restaurant->name; 
       // $redata->user_id=621;
        if (!empty($redata)) {
            $this->loadModel("RestaurantsType");
            if (empty($res_name)) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "conditions" => array('Restaurant.name LIKE' =>'%'.$res_name.'%' ),                  
                    "ORDER BY" => 'DESC',
                ));
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                $data[$i]['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['banner'];
            
                if(!empty($data[$i]['Promocode'])){
                    $data[$i]['Restaurant']['Promocodes'] = 1;
                }else{
                    $data[$i]['Restaurant']['Promocodes'] = 0;
                }
                if(!empty($data[$i]['Discount'])){
                    $data[$i]['Restaurant']['Discount'] = 1;
                }else{
                    $data[$i]['Restaurant']['Discount'] = 0;
                }
                
                $today_day = date('l');
                    $today_time = date("g:iA");
                   if($today_day =='Saturday' || $today_day =='Sunday'){
                       $opening_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_opening_time']));
                       $closing_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_closing_time']));
                   }else{
                        $opening_time=date("g:iA", strtotime($data[$i]['Restaurant']['opening_time']));
                        $closing_time=date("g:iA", strtotime($data[$i]['Restaurant']['closing_time']));
                   }

                   if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                        $data[$i]['Restaurant']['is_open']=1;
                    }else{
                        $data[$i]['Restaurant']['is_open']=0;
                    }
                    $data[$i]['Restaurant']['now']=$today_time;
                    // Unavailable Today starts here
                    $today_date_format = date("Y-m-d");
                    $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                               'AND'=>array(
                                   'UnavailableDate.unavailabledate'=>$today_date_format,
                                   'UnavailableDate.restaurant_id'=>$data[$i]['Restaurant']['id']    
                               )
                           )
                        ));
                    if($unavailable_for_selectedDate){
                        $data[$i]['Restaurant']['closed_today']=1;
                    }else{
                        $data[$i]['Restaurant']['closed_today']=0;
                    }
                    // Unavailable Today ends here
                    
                    $data[$i]['Restaurant']['opening_time']=$opening_time;
                    $data[$i]['Restaurant']['closing_time']=$closing_time;
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));

                if (!empty($d['Favrest'])) {
                    $fav_rest_user = array();
                    foreach ($d['Favrest'] as $fav_rest) {
                        array_push($fav_rest_user, $fav_rest['user_id']);
                    }
                    if (isset($redata->user_id)) {
                        $set_as_fav = in_array($redata->user_id, $fav_rest_user);
                        if ($set_as_fav) {
                            $finaldata['Restaurant'][$j]['favrest'] = 1;
                        } else {
                            $finaldata['Restaurant'][$j]['favrest'] = 0;
                        }
                    } else {
                        $finaldata['Restaurant'][$j]['favrest'] = 0;
                    }
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
            //debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_frestaurantsbyaddnameb() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
//        $redata = (object)['id'=>1,'user_id'=>1];
        if (!empty($redata)) {
            $address = $redata->city;
            $latlong = $this->getLetLong($address);
            //debug($latlong);
            $lat = $latlong['latitude'];
            $long = $latlong['longitude'];
            $res_name = $redata->resname;
//            $db = $this->Restaurant->getDataSource();
//            $db->fullDebug = true;
            $data = $this->Restaurant->find('all', array(
                'conditions' => array(
                    'Restaurant.name LIKE' => '%' . $res_name . '%',
                ),
                "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
            ));

//            $log = $db->getLog();
//            print_r($log['log']);
            //debug($data); exit;
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];

                $finaldata['Restaurant'][$j]['typename'] = $this->RestaurantsType->find('all',array('conditions'=>array('RestaurantsType.id'=>  unserialize($d['Restaurant']['typeid']))));
                if ($d['Favrest']['id'] != null) {
                    $finaldata['Restaurant'][$j]['favrest'] = 1;
                } else {
                    $finaldata['Restaurant'][$j]['favrest'] = 0;
                }

                $j++;
            }
//            debug($finaldata);exit;
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_favlist() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->layout = "ajax";
       // $redata="dgg";
        if (!empty($redata)) {
           $user_id = $redata->id;
           // $user_id = 30;
            $this->loadModel('Favrest');
           // $this->Favrest->recursive = 2;
            $favrests = $this->Favrest->find('all',array(
                'conditions'=>array('Favrest.user_id'=>$user_id),
                'recursive'=>1
                ));
            if($favrests){
                $restaurants = array();
                foreach ($favrests as $favouriteRestaurant) {
                    if(!empty($favouriteRestaurant['Restaurant']['banner'])){
                        $favouriteRestaurant['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $favouriteRestaurant['Restaurant']['banner'];
                    }
                    if(!empty($favouriteRestaurant['Restaurant']['logo'])){
                        $favouriteRestaurant['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $favouriteRestaurant['Restaurant']['logo'];
                    }
                    $favouriteRestaurant['Restaurant']['opening_time']=date("g:iA", strtotime($favouriteRestaurant['Restaurant']['opening_time']));
                    $favouriteRestaurant['Restaurant']['closing_time']=date("g:iA", strtotime($favouriteRestaurant['Restaurant']['closing_time']));

                    
                    $restaurants[]=$favouriteRestaurant;
                }
                $response['isSuccess'] = true;
                $response['data'] = $restaurants;
            }else{
                $response['isSuccess'] = false;
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = false;
            $response['msg'] = "Seems some issue, try again Later.";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_likeit() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $this->loadModel('Favrest');
        if (!empty($redata)) {
            $user_id = $redata->User->id;
            $res_id = $redata->Restaurant->resid;
            $data = $this->Favrest->find('count', array('conditions' => array('AND' => array('Favrest.res_id' => $res_id, 'Favrest.user_id' => $user_id))));
            if ($data > 0) {
                if($this->Favrest->deleteAll(array('Favrest.res_id' => $res_id, 'Favrest.user_id' => $user_id))){
                    $response['isSuccess']=true;
                    $response['is_liked']="no";
                    $response['msg']="Removed from Favourites";
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Unable to delete";
                }
            } else {
                $arr = array("res_id" => $res_id, "user_id" => $user_id);
                if($this->Favrest->save($arr)){
                    $response['isSuccess']=true;
                    $response['is_liked']="yes";
                    $response['msg']="Added to Favourites";
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Unable to save";
                }
            }
        } else {
            $response['error'] = 1;
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    
    
        public function favourities() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->loadModel('Favrest');
       if ($this->request->is('post')) {  
           
             $user_id = $this->request->data['uid'];  
             $res_id = $this->request->data['rest_id'];
            
            $data = $this->Favrest->find('count', array('conditions' => array('AND' => array('Favrest.res_id' => $res_id, 'Favrest.user_id' => $user_id))));
            if ($data > 0) {
                if($this->Favrest->deleteAll(array('Favrest.res_id' => $res_id, 'Favrest.user_id' => $user_id))){
                   
                    $this->Session->setFlash('Removed from Favourites', 'flash_error');  
                     return $this->redirect('http://' . $this->request->data['server']);
                }else{
                    
                    $this->Session->setFlash('Unable to delete', 'flash_error');
                     return $this->redirect('http://' . $this->request->data['server']);
                    
                }
            } else {
                $arr = array("res_id" => $res_id, "user_id" => $user_id);
                if($this->Favrest->save($arr)){
                    
                     $this->Session->setFlash('Added to Favourites', 'flash_success');
                     return $this->redirect('http://' . $this->request->data['server']);
                 
                }else{
                    $this->Session->setFlash('Unable to save', 'flash_error');
                     return $this->redirect('http://' . $this->request->data['server']);
                     
                }
            }
       }
   
    }

    public function api_mobilefilter() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'search.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
        // exit;

            $this->Restaurant->recursive = 1;
        if ($redata) {
            $lat =$redata->data->Restaurant->latitude;
            $long =$redata->data->Restaurant->longitude;
            $this->loadModel("RestaurantsType");
            $cat =$redata->data->Restaurant->category_id;
            $sort= $redata->data->Restaurant->sort_by;
            if($sort=="name"){
                $sort_order="ASC";
            }else{
                 $sort_order="DESC";
            }
             $this->loadModel('Product');
            if ($lat == 0 || $long == 0) {
                return false;
            } else {
                if ($cat) {                    
                   $product=$this->Product->find('all',array('conditions'=>array('Product.dishcategory_id'=>$cat)));                       
                   foreach($product as $proid){
                       $p_res_id[]=$proid['Product']['res_id'];
                   }
                   $product_resid=array_unique($p_res_id);
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('Restaurant.id' =>$product_resid),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        'order'=>array('Restaurant.'.$sort=>$sort_order)
                    ));
                   
                }else{
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*"),
                        'order'=>array('Restaurant.'.$sort=>$sort_order)
                    ));
                }
                if($data){
                    $cnt = count($data);
                    for ($i = 0; $i < $cnt; $i++) {
                        if ($data[$i][0]['distance'] < $this->distance) {
                            $today_day = date('l');
                    $today_time = date("g:iA");
                   if($today_day =='Saturday' || $today_day =='Sunday'){
                       $opening_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_opening_time']));
                       $closing_time = date("g:iA", strtotime($data[$i]['Restaurant']['weekend_closing_time']));
                   }else{
                        $opening_time=date("g:iA", strtotime($data[$i]['Restaurant']['opening_time']));
                        $closing_time=date("g:iA", strtotime($data[$i]['Restaurant']['closing_time']));
                   }

                   if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                        $data[$i]['Restaurant']['is_open']=1;
                    }else{
                        $data[$i]['Restaurant']['is_open']=0;
                    }
                    $data[$i]['Restaurant']['now']=$today_time;
                    // Unavailable Today starts here
                    $today_date_format = date("Y-m-d");
                    $this->loadModel('UnavailableDate');
                    $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                               'AND'=>array(
                                   'UnavailableDate.unavailabledate'=>$today_date_format,
                                   'UnavailableDate.restaurant_id'=>$data[$i]['Restaurant']['id']    
                               )
                           )
                        ));
                    if($unavailable_for_selectedDate){
                        $data[$i]['Restaurant']['closed_today']=1;
                    }else{
                        $data[$i]['Restaurant']['closed_today']=0;
                    }
                    // Unavailable Today ends here
                            
                            
                            $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                             $data[$i]['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['banner'];
                             
                            $data[$i]['Restaurant']['opening_time']=$opening_time;
                            $data[$i]['Restaurant']['closing_time']=$closing_time;
                             
                    } else {
                            unset($data[$i]);
                        }
                    }
                    $finaldata = array();
                    $j = 0;
                    foreach ($data as $d) {
                        $finaldata['Restaurant'][$j] = $d['Restaurant'];
                        //$finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                        $j++;
                    }
                }else{
                    $d['msg']= "No restaurant found";
                    $d['isSucess']='false';
                }
               
            }
        }
        if($finaldata){
           $d['data']= $finaldata;
           $d['isSucess']='true';
           //$d['count']=$cnt;
           //$d['data2']=$data;
        }else {
            $d['msg']= "No restaurant found";
            $d['isSucess']='false';
        }
        echo json_encode($d);
        $this->render('ajax');
        exit;
    }

    public function admin_uploadimage() {
        //print_r($_FILES);
        if (!empty($_FILES)) {
            $image = $_FILES['file'];
            $uploadFolder = "restaurants";
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($image['error'] == 0) {
                $imageName = $image['name'];
                if (file_exists($uploadPath . DS . $imageName)) {
                    $imageName = date('His') . $imageName;
                }
                $full_image_path = $uploadPath . DS . $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            }
        }
    }

    public function admin_prouploadimage() {
        //print_r($_FILES);
        if (!empty($_FILES)) {
            $image = $_FILES['file'];
            $uploadFolder = "product";
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($image['error'] == 0) {
                $imageName = $image['name'];
                if (file_exists($uploadPath . DS . $imageName)) {
                    $imageName = date('His') . $imageName;
                }
                $full_image_path = $uploadPath . DS . $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            }
        }
    }

    public function admin_importres() {
        Configure::write("debug", "0");
        if (!empty($_FILES)) {
            $file = $_FILES['file'];
            $uploadFolder = "resfile";
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($file['error'] == 0) {
                $fileName = $file['name'];
                $full_image_path = $uploadPath . DS . $fileName;
                move_uploaded_file($file['tmp_name'], $full_image_path);
                $messages = $this->Restaurant->import($fileName);
                $this->Session->setFlash($messages['messages'][0]);
            }
        }


        //exit;
    }

    /*
      DELIMITER $$

      DROP FUNCTION IF EXISTS `get_distance_in_miles_between_geo_locations` $$
      CREATE FUNCTION get_distance_in_miles_between_geo_locations(geo1_latitude decimal(10,6), geo1_longitude decimal(10,6), geo2_latitude decimal(10,6), geo2_longitude decimal(10,6))
      returns decimal(10,3) DETERMINISTIC
      BEGIN
      return ((ACOS(SIN(geo1_latitude * PI() / 180) * SIN(geo2_latitude * PI() / 180) + COS(geo1_latitude * PI() / 180) * COS(geo2_latitude * PI() / 180) * COS((geo1_longitude - geo2_longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515);
      END $$

      DELIMITER ;

     */

    /**
     * @desc All restaurant listing in specific distance
     * @name All restaurant listing 
     * @link  get_distance_in_miles_between_geo_locations
     */
    public function api_restaurantslistapp() {
        configure::write('debug', 0);
        $this->Restaurant->recursive = 2;
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $address = $redata->city . ',' . $redata->area . ',' . $redata->address;
        $latlong = $this->getLetLong($address);
        //debug($latlong);
        $lat = $latlong['latitude'];
        $long = $latlong['longitude'];
        if (!empty($redata)) {
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                $response['isSucess'] = "false";
                $response['msg'] = "There is no data available";
            } else {
                $data = $this->Restaurant->find('all', array(
                    "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                    "ORDER BY" => 'DESC',
                ));
            }
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                if ($data[$i][0]['distance'] < $this->distance) {
                    $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                } else {
                    unset($data[$i]);
                }
            }
            $finaldata = array();
            $j = 0;
            foreach ($data as $d) {
                $finaldata['Restaurant'][$j] = $d['Restaurant'];
                $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                $current_time = date("H:i:s", time());
                $sunrise = $d['Restaurant']['opening_time'];
                $sunset = $d['Restaurant']['closing_time'];
                $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                $date2 = DateTime::createFromFormat('H:i:s', $sunrise);
                $date3 = DateTime::createFromFormat('H:i:s', $sunset);
                if ($date1 > $date2 && $date1 < $date3) {
                    $finaldata['Restaurant'][$j]['timestatus'] = "Open";
                } else {
                    $finaldata['Restaurant'][$j]['timestatus'] = "Closed";
                }

                $j++;
            }
            if ($finaldata) {
                $response['isSuccess'] = "true";
                $response['data'] = $finaldata;
            } else {
                $response['isSuccess'] = "false";
                $response['msg'] = "There is no data available";
            }
        } else {
            $response['isSuccess'] = "false";
            $response['msg'] = "There is no data available";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    /*public function admin_booked() {
        Configure::write("debug", 2);
        if ($this->request->is("post")) {
            $this->loadModel('Restable');
            $data = $this->request->data;
            $this->Restable->updateAll(array('Restable.booked' => $data['Restable']['booked']), array('Restable.res_id' => $data['Restable']['res_id'], 'Restable.tableno' => $data['Restable']['tableno']));
            return $this->redirect(array('action' => 'menudetai/' . $data['Restable']['res_id'] . '/' . $data['Restable']['tableno']));
        }
    }*/

    public function admin_uploadresimage($id = NULL) {
        configure::write("debug", 0);
              //echo $this->Session->read("resid");
//       exit;
        if (!empty($_FILES)) {
            $resid=$this->Session->read('resid');
            $image = $_FILES['file'];
            $uploadFolder = "restaurants";
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($image['error'] == 0) {
                $imageName = $image['name'];
                if (file_exists($uploadPath . DS . $imageName)) {
                    $imageName = date('His') . $imageName;
                }
                $full_image_path = $uploadPath . DS . $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                
                $this->loadModel('Gallery');
                $this->request->data['Gallery']['res_id'] =$id;
                $this->request->data['Gallery']['image'] = $imageName;
                $this->Gallery->create();
               // debug($this->request->data);
               $this->Gallery->save($this->request->data);
            }
        } else {
          //  $this->Session->write("resid", $id);
            $this->set('resid', $id);
            $this->loadModel('Gallery');
            $data = $this->Gallery->find('all', array('conditions' => array('Gallery.res_id' => $id)));
            $this->set('gallery', $data);
            
        }
       
    }

    public function admin_getresimage() {
        configure::write("debug", 0);
        $this->layout = "ajax";
        $id = $_POST['id'];
        $rid = $_POST['resid'];
        if ($_POST) {
            $this->loadModel('Gallery');
            $this->Gallery->id = $id;
            $this->Gallery->delete();
            return $this->redirect(array('controller' => 'restaurants', 'action' => 'uploadresimage/' . $rid));
        }
    }

    public function api_advancepayment() {
        $this->layout = "ajax";
        configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->Table->id;
        $totol = $redata->paypal->total;
        $paymentid = $redata->paypal->paymentid;
        $pstatus = $redata->paypal->status;
        $this->loadModel('TableReservation');
        $this->TableReservation->recursive=1;
        $d = $this->TableReservation->updateAll(array('TableReservation.total' => $totol, 'TableReservation.paymentid' => $paymentid, 'TableReservation.pstatus' => $pstatus), array('TableReservation.id' => $id));
        if ($d) {
            $response['isSuccess'] = "true";
            $response['data'] = $this->TableReservation->find('first',array('conditions'=>array('TableReservation.id' =>$id)));
        } else {
            $response['isSuccess'] = "false";
            $response['data'] = "no data";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
        //$this->layout = "ajax";
    }
    
    public function api_resgallery(){
        $this->layout = "ajax";
        configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->loadModel('Gallery');
        $id = 628;//$redata->Res->id;
        //if($id){
          $data=$this->Gallery->find('all', array('conditions' => array('Gallery.res_id' => $id)));
           $cnt=count($data);
             for ($i = 0; $i < $cnt; $i++) {               
                    $data[$i]['Gallery']['image'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Gallery']['image'];
                }                
          if ($data) {
            $response['isSuccess'] = "true";
            $response['data'] = $data;
        } else {
            $response['isSuccess'] = "false";
            $response['data'] = "no data";
        }
//        }else {
//            $response['isSuccess'] = "false";
//            $response['data'] = "no data";
//        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    /*public function api_mytestjob(){
        
        $this->loadModel('Restable');
            $resbook=$this->Restable->find('all',array('conditions'=>array('Restable.res_id'=>666,'Restable.booked'=>0)));
            if(empty($resbook)){
                $data['tid']="0";
                   
            }
            foreach($resbook as $resb){
              $this->Restable->updateAll(array('Restable.booked'=>1),array('Restable.res_id'=>$resb['Restable']['res_id'],'Restable.tableno'=>$resb['Restable']['tableno']));  
            
                 $data['tid']=$resb['Restable']['tableno']; 
             
              break;
            }            
        $response['isSuccess'] = "true";
        $response['data'] = $data;
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }*/
     public function api_promocode(){
        configure::write("debug", 0);
        $this->layout = "ajax";      
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if($redata){   
        $pcode=$redata->order->orderid;
        $this->loadModel('Promocode');
        $d=$this->Promocode->find('first',array('Promocode.orderid'=>$pcode));
        if($d){            
        $response['isSuccess'] = "true";
        $response['data'] = $pcode;
        $response['promocode'] = base64_decode($d['Promocode']['promocode']);
        }else {
        $response['isSuccess'] = "false";
        $response['data'] = '0';     
        }
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    /*
     * restaurant_id, date
     * order_type=1 for catering, check lead time only if order is for catering
     */
    public function api_unavailable_dates(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if($redata){
            //$remove_quotes = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($this->request->data['eventdate'], ENT_QUOTES));
            //$eventdate  =  $this->request->data['eventdate'];
            $remove_quotes=trim($this->request->data['eventdate'],'"');
            $eventdate = trim($remove_quotes,'"');
            $res_id  =  $this->request->data['res_id'];
            $event_date_format = date("Y-m-d",strtotime($eventdate));
            $this->loadModel('UnavailableDate');
             $unavailable_for_selectedDate = $this->UnavailableDate->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'UnavailableDate.unavailabledate'=>$event_date_format,
                            'UnavailableDate.restaurant_id'=>$res_id    
                        )
                    )
                 ));
             if($unavailable_for_selectedDate){
                 $response['isSuccess']=false;
                 $response['msg']="Restaurant is Unavailable for your selected Date. Either choose another restaurant or select another Date.";
             }else{
                    if($this->request->data['order_type']==1){
                        $restaurant = $this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$res_id)));
                        $lead_time = (int)$restaurant['Restaurant']['lead_time'];
                        // restaurant is open/close
                        $today_day = date('l',strtotime($eventdate));
                        $today_time = date("g:iA",strtotime($eventdate));
                       if($today_day =='Saturday' || $today_day =='Sunday'){
                           $opening_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));
                           $closing_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
                       }else{
                            $opening_time=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                            $closing_time=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
                       }

                       if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                            $restaurant['Restaurant']['is_open']=1;
                        }else{
                            $restaurant['Restaurant']['is_open']=0;
                        }
                        if($restaurant['Restaurant']['is_open']==0){
                            $response['isSuccess']=  false;
                            $response['msg']="Restaurant is Closed for selected Time. Either choose another Restaurant or select another Date/Time";
                            $response['now']=$today_time;
                            $response['opening']=$opening_time;
                            $response['closing']=$closing_time;
                        }else{
                            //$date("Y-m-d h:i:s",strtotime($eventdate));
                        $datetime1 = date_create($eventdate);
                        $today = date('Y-m-d H:i:s');
                        $datetime2 = date_create($today);
                        $interval = date_diff($datetime1, $datetime2);
                        $days = $interval->format('%a');
                        $hours = $interval->h + ($days * 24);
                        if($hours>=$lead_time){
                           $response['isSuccess']=  true;
                           $response['msg']="Restaurant Available on the selected Date.";
                           $response['eventdate']=$eventdate;
                           $response['test']=$this->request->data['eventdate'];
                           $response['test2']=$event_date_format;
                           $response['days']=$days;
                           $response['hours']=$hours;
                           $response['interval']=$interval;
                           $response['lead']=$lead_time;
                           $response['today']=$today;
                        }else{
                            $response['isSuccess'] = false;
                            $response['msg'] = "Please Select another Date/Time as Lead Time for this Restaurant is more!";
                            $response['eventdate']=$eventdate;
                            $response['test']=$this->request->data['eventdate'];
                            $response['test2']=$event_date_format;
                            $response['days']=$days;
                            $response['hours']=$hours;
                            $response['interval']=$interval;
                            $response['lead']=$lead_time;
                            $response['today']=$today;
                        }
                            
                            
//                            $response['isSuccess']=  true;
//                            $response['msg']="Restaurant Available on the selected Date.";
//                            $response['eventdate']=$eventdate;
//                            $response['now']=$today_time;
//                            $response['opening']=$opening_time;
//                            $response['closing']=$closing_time;
                        }
                        
                        
                        
                        
                        
                    }else{
                        $this->loadModel('Restaurant');
                        $restaurant = $this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$res_id)));
                        $today_day = date('l',strtotime($eventdate));
                        $today_time = date("g:iA",strtotime($eventdate));
                       if($today_day =='Saturday' || $today_day =='Sunday'){
                           $opening_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_opening_time']));
                           $closing_time = date("g:iA", strtotime($restaurant['Restaurant']['weekend_closing_time']));
                       }else{
                            $opening_time=date("g:iA", strtotime($restaurant['Restaurant']['opening_time']));
                            $closing_time=date("g:iA", strtotime($restaurant['Restaurant']['closing_time']));
                       }

                       if((strtotime($today_time) > strtotime($opening_time)) && (strtotime($today_time) < strtotime($closing_time)) ){
                            $restaurant['Restaurant']['is_open']=1;
                        }else{
                            $restaurant['Restaurant']['is_open']=0;
                        }
                        if($restaurant['Restaurant']['is_open']==0){
                            $response['isSuccess']=  false;
                            $response['msg']="Restaurant is Closed for selected Time. Either choose another Restaurant or select another Date/Time";
                            $response['now']=$today_time;
                            $response['opening']=$opening_time;
                            $response['closing']=$closing_time;
                        }else{
                            $response['isSuccess']=  true;
                            $response['msg']="Restaurant Available on the selected Date.";
                            $response['eventdate']=$eventdate;
                            $response['now']=$today_time;
                            $response['opening']=$opening_time;
                            $response['closing']=$closing_time;
                        }
                    }
                }
            
        }else{
            $response['isSuccess'] = false;
            $response['msg'] = "Please try again";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    
    ///////////////////////rupak//////////////////////////////////
    
        public function restaurentslistbyarea($area = null){
          
            $areasname = base64_decode($area);
         
             $rtdta = $this->Restaurant->find('all', array('conditions' => array('Restaurant.city' =>$areasname))); 
    
           $this->set('listbyarea', $rtdta);   
   
           }
       public function restoffer($rest_id = null){
            $this->loadModel('Offer');
             $this->Offer->recursive=1;
          $catering = $this->Offer->find('all', array('conditions' => array('Offer.res_id' =>$rest_id,'Offer.quantity !=' =>0,'Offer.catering' =>1))); 
		  
		  $delivery = $this->Offer->find('all', array('conditions' => array('Offer.res_id' =>$rest_id,'Offer.quantity !=' =>0,'Offer.delivery' =>1))); 
		  
		  $pickup = $this->Offer->find('all', array('conditions' => array('Offer.res_id' =>$rest_id,'Offer.quantity !=' =>0,'Offer.pickup' =>1))); 
    
			$this->set('catering', $catering); 
			$this->set('delivery', $delivery); 
			$this->set('pickup', $pickup); 		 
       }   
       
       public function offerview($offer_id = null){
            $this->loadModel('Offer');
             $this->Offer->recursive=1;
          $offerdata = $this->Offer->find('first', array('conditions' => array('Offer.id' =>$offer_id))); 
    
           $this->set('offerdata', $offerdata);      
       }
      public function addunavailable_area(){
          $this->loadModel('UnavailableArea'); 
            $uid = $this->Auth->user('id');
            $user_id = $uid?$uid:0;
          	if ($this->request->is('post')) { 
                    
                    $this->request->data['UnavailableArea']['user_id']= $user_id;  
			$this->UnavailableArea->create();  
                        
			if ($this->UnavailableArea->save($this->request->data)) {     
                         $this->Session->setFlash('The Request has been saved.', 'flash_success'); 
		   return $this->redirect(array('controller' => 'products', 'action' => 'index'));
                      //  return $this->redirect(array('action' => 'index'));
			} else {
                   
                           $this->Session->setFlash('The Request could not be saved. Please, try again.', 'flash_error');
		  return $this->redirect(array('controller' => 'products', 'action' => 'index'));
			}
		} 
      }
     
    public function admin_unavailabledates($id=null){
        $this->set('restaurant_id',$id);
        $this->loadModel('UnavailableDate');
//        $unavailable = $this->UnavailableDate->find('first',array('conditions'=>array(
//            'AND'=>array(
//                'UnavailableDate.unavailabledate >='=>date("Y-m-d"),
//                'UnavailableDate.restaurant_id'=>$id
//            )
//        ),'recursive'=>1));
//        $this->set('unavailable',$unavailable);
        
        
        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array(
            'UnavailableDate' => array(
                'recursive' => 1,
                'contain' => array(
                ),
                'conditions' => array(
                    'AND'=>array(
                        'UnavailableDate.unavailabledate >='=>date("Y-m-d"),
                        'UnavailableDate.restaurant_id'=>$id
                    )
                ),
                'order' => array(
                    'UnavailableDate.created' => 'DESC'
                ),
                'limit' => 20,
                'paramType' => 'querystring',
            )
        );
        $this->set('unavailable', $this->Paginator->paginate('UnavailableDate'));
        
    }
	
	public function customer_support(){
			$this->loadModel('Setting');
			$this->loadModel('User');
           $setting = $this->Setting->find('all');
			$email_to =  $setting[2]['Setting']['value'];
			 $user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
		
			if($this->request->is('post')){
				$big_your = $this->request->data['big_your'];
				$budget_per = $this->request->data['budget_per'];
				$price1 = $this->request->data['r11'];
				$price2 = $this->request->data['r12'];

						$ms = "User Email: ".$user['User']['email']."<br/>Event Size: ".$big_your ."<br/>Budget Between: ".$price1."-".$price2 ."<br/>Budget: ".$budget_per." ". "<br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Customer Event Request')->
                         to($email_to)->send($ms);
			 $this->Session->setFlash('Request Sent. We will contact you Soon!', 'flash_success');	
			     return $this->redirect(array('controller' => 'products', 'action' => 'index'));
			 // return $this->redirect('http://' . $this->request->data['server']);	
			}
		
	}

}