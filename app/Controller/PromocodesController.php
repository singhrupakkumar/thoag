<?php

App::uses('AppController', 'Controller');

/**
 * Promocodes Controller
 *
 * @property Promocodes $Promocodes
 * @property PaginatorComponent $Paginator
 */
class PromocodesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','RequestHandler');

       public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_promocode');
    }
    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        
        $this->Promocode->recursive=1;
        $this->Paginator = $this->Components->load('Paginator');
        
        if($this->Auth->user('role') == "rest_admin"){
            $this->loadModel('Restaurant');
            $restaurants = $this->Restaurant->find('list',array('conditions'=>  array('Restaurant.user_id'=>$this->Auth->user('id'))));
            $user_restaurants = array_keys($restaurants);
            $this->Paginator->settings = array(            
                'Promocode' => array(
                    'conditions'=>array(
                        'Promocode.res_id'=>$user_restaurants
                    ),
                    'limit' => 20
                )
            );
        }else{
            $this->Paginator->settings = array(            
                'Promocode' => array(
                    'limit' => 20
                )
            );
        }
        $this->set('promocodes', $this->Paginator->paginate());
        
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Promocode->exists($id)) {
            throw new NotFoundException(__('Invalid alergy'));
        }
        $options = array('conditions' => array('Promocode.' . $this->Promocode->primaryKey => $id));
        $this->set('promocode', $this->Promocode->find('first', $options));
          
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $exist = $this->Promocode->find('first',array('conditions'=>array('Promocode.promocode'=>$this->request->data['Promocode']['promocode'])));
           
            if($exist){
                $this->Session->setFlash(__('Promocode already taken. Please add Unique Entry!','flash_error'));
            }else{
                $this->Promocode->create();
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }
            
        }
        if($this->Auth->user('role') == "rest_admin"){
            $this->loadModel('Restaurant');
            $restaurants = $this->Restaurant->find('list',array('conditions'=>  array('Restaurant.user_id'=>$this->Auth->user('id'))));
            $this->set('restaurants',$restaurants);
        }else{
            $this->loadModel('Restaurant');
            $restaurants = array('Universal');
            $list = $this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1)));
            $list['0']='Universal';
            $this->set('restaurants',$list);
            //print_r($list);
            
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        Configure::write("debug", 2);
        if (!$this->Promocode->exists($id)) {
            throw new NotFoundException(__('Invalid Promocode'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $exist = $this->Promocode->find('first',array('conditions'=>array('Promocode.promocode'=>$this->request->data['Promocode']['promocode'])));
           
            if($exist){
                $this->request->data['Promocode']['id']=$id;
                 //$this->Session->setFlash(__('Promocode already taken. Please add Unique Entry!'));
                $this->request->data['Promocode']['promocode']=$exist['Promocode']['promocode'];
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('controller'=>'promocodes','action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }else{
                $this->Promocode->id=$id;
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('controller'=>'restaurants','action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }
            
        } else {
            $options = array('conditions' => array('Promocode.' . $this->Promocode->primaryKey => $id));
            $this->request->data = $this->Promocode->find('first', $options);
        }
    }
    
    
    ////////////////////
    
      private function getDiscountOnRepeatOrderswebpromo($user_id,$res_id,$session_id){
         
           $this->loadModel('Order'); 
            $this->loadModel('Discount'); 
            $this->loadModel('Cart');
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
	
	/////////////////////////
	
	 private function refferalDiscountweb1($user_id) {
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
             public function webCartDatapromo($uid, $sid) {   
        
         $this->loadModel('Restaurant');   
         $this->loadModel('Cart');    
         $this->loadModel('Offer');
         $this->loadModel('Product');

       
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
            $discount_available = $this->getDiscountOnRepeatOrderswebpromo($uid,$res_id,$sid);
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
            $refferal_discount = $this->refferalDiscountweb1($uid);
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
    
        public function webdisplaycart1() { 
        // $this->Session->delete('Shop');      
        configure::write('debug',0);
          $sid   = $this->Session->id();
          $uid = $this->Auth->user('id'); 
          $data = $this->webCartDatapromo($uid, $sid);
		 $orderapply = $this->Session->read('orderapply');	
			if (!empty($data)) { 
				$response['error'] = "0";
				$response['data'] = $data;
				$response['apply'] = $orderapply; 
			   
			} else {
				$response['error'] = "1";
				$response['data'] = "error";
			} 
		return $response;
        // echo json_encode($response);
        // exit; 
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Promocode->id = $id;
        if (!$this->Promocode->exists()) {
            throw new NotFoundException(__('Invalid alergy'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Promocode->delete()) {
            $this->Session->setFlash(__('The Promocode has been deleted.'));
        } else {
            $this->Session->setFlash(__('The Promocode could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    public function api_promocode() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);   
        $this->layout = "ajax";
        if (!empty($redata)) {
            $resid = $redata->res_id;
            $restaurants=array(0);
            array_push($restaurants,$resid);
            
            $procode = $redata->promocode;
            if(isset($redata->user_id) && $redata->user_id !=0){
                $this->loadModel('Cart');
                $cart_data = $this->Cart->find('all',array(
				"conditions"=>array(
					'AND'=>array(
                        'Cart.uid'=>$redata->user_id,
                        'Cart.sessionid'=>$redata->session_id
                    )
				)
                    
                        ));
                if(!empty($cart_data)){
                    foreach($cart_data as $cart){
                        if($cart['Cart']['offer_id'] != 0){
                            $is_offer = 1;
                        }
                    }
                }
                if(isset($is_offer) && $is_offer == 1){
                    $response['error'] = '1'; 
                    $response['msg'] = 'You are already purchasing an offer. So you cannot apply promocode.'; 
                }else{
                //$resid=1;
                // $procode='FLAT10';
                    $data=$this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.res_id'=>$restaurants,
                         'Promocode.promocode'=>$procode,
                         'Promocode.expired >'=>date('Y-m-d h:i:s')
                         ))));
                    
                    
                    if($data){
                        if(isset($redata->order_amount)){
                            if((float)$redata->order_amount <= $data['Promocode']['min_order_amount']){
                                $response['error'] = '1'; 
                                $response['msg'] = 'Minimum Order Amount should be SAR'.$data['Promocode']['min_order_amount']; 
                            }else{
                                $this->loadModel('UserPromocode');
                                 $exists = $this->UserPromocode->find('first',array('conditions'=>array(
                                        "AND"=>array(
                                        'UserPromocode.user_id'=>$redata->user_id,
                                        'UserPromocode.session_id'=>$redata->session_id,
                                        'UserPromocode.order_id'=>0
                                    )
                                    )));
                                 $this->request->data['UserPromocode']['user_id']=$redata->user_id;
                                $this->request->data['UserPromocode']['res_id']=$redata->res_id;
                                $this->request->data['UserPromocode']['session_id']=$redata->session_id;
                                $this->request->data['UserPromocode']['promocode_id']=$data['Promocode']['id'];
                                $this->UserPromocode->create();
                                if($this->UserPromocode->save($this->request->data)){
                                    $this->loadModel('Cart');
                                    $this->Cart->updateAll(
                                        array('Cart.promocode_id' => $data['Promocode']['id']),
                                        array('Cart.uid'=>$redata->user_id,
                                                'Cart.sessionid'=>$redata->session_id)
                                    );

                                    $response['error'] = '0'; 
                                    $response['msg'] = 'Promo code Applied'; 
                                    $response['data'] = $data;
                                }else{
                                    $response['error'] = '1'; 
                                    $response['msg'] = 'Some issue occured. Try again later.'; 
                                }
                            }
                        }
//                        $response['error'] = '0'; 
//                        $response['msg'] = 'Promo code Applied'; 
//                        $response['data'] = $data;
                    }else {
                        $response['error'] = '1'; 
                        $response['msg'] = 'Invalid Promocode'; 
                    }
                }
            }else{
                $response['error'] = '1'; 
                $response['msg'] = 'You need to login first'; 
            }
        }else{
            $response['error'] = '1'; 
            $response['msg'] = 'No data to filter'; 
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    } 
    public function api_promocode_old() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);   
        $this->layout = "ajax";
       // $redata="gfg";
        if (!empty($redata)) {
            $resid = $redata->res_id;
            $restaurants=array(0);
            array_push($resid,$restaurants);
            
            $procode = $redata->promocode;
            if(isset($redata->user_id) && $redata->user_id !=0){
                $this->loadModel('Cart');
                $cart_data = $this->Cart->find('all',array(
				"conditions"=>array(
					'AND'=>array(
                        'Cart.uid'=>$redata->user_id,
                        'Cart.sessionid'=>$redata->session_id
                    )
				)
                    
                        ));
                if(!empty($cart_data)){
                    foreach($cart_data as $cart){
                        if($cart['Cart']['offer_id'] != 0){
                            $is_offer = 1;
                        }
                    }
                }
                if(isset($is_offer) && $is_offer == 1){
                    $response['error'] = '1'; 
                    $response['msg'] = 'You are already purchasing an offer. So you cannot apply promocode.'; 
                }else{
                //$resid=1;
                // $procode='FLAT10';
                    if(isset($redata->order_amount)){
                        $data=$this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.res_id'=>$restaurants,
                         'Promocode.promocode'=>$procode,
                         'Promocode.expired >'=>date('Y-m-d h:i:s'),
                         'Promocode.min_order_amount <='=>(float)$redata->order_amount
                         ))));
                        // $log = $this->Promocode->getDataSource()->getLog(false, false);
                        //    debug($log);
                    }else{
                       // echo "2";
                        $data=$this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.res_id'=>$restaurants,
                         'Promocode.promocode'=>$procode,
                         'Promocode.expired >'=>date('Y-m-d h:i:s')
                         ))));
                    }
                    
                    if($data){
                        $response['error'] = '0'; 
                        $response['msg'] = 'Promo code Applied'; 
                        $response['data'] = $data;
                    }else {
                        $chk_data=$this->Promocode->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'Promocode.res_id'=>0,
                            'Promocode.promocode'=>$procode,
                            'Promocode.expired >'=>date('Y-m-d h:i:s'),
                            'Promocode.min_order_amount <='=>(float)$redata->order_amount
                            ))));
                        if($chk_data){
                            $this->loadModel('UserPromocode');
                            $exists = $this->UserPromocode->find('first',array('conditions'=>array(
                                "AND"=>array(
                                'UserPromocode.user_id'=>$redata->user_id,
                                'UserPromocode.session_id'=>$redata->session_id,
                                'UserPromocode.order_id'=>0
                            )
                            )));
                            
//                            if(!empty($exists)){
//                                $response['error'] = '0'; 
//                                $response['data'] = $chk_data;
//                                $response['msg'] = 'Promocode Applied';
//                                //$response['msg'] = 'Only one promocode can be applied.'; 
//                            }else{
                                $this->request->data['UserPromocode']['user_id']=$redata->user_id;
                                $this->request->data['UserPromocode']['res_id']=$redata->res_id;
                                $this->request->data['UserPromocode']['session_id']=$redata->session_id;
                                $this->request->data['UserPromocode']['promocode_id']=$chk_data['Promocode']['id'];
                                $this->UserPromocode->create();
                                if($this->UserPromocode->save($this->request->data)){
                                    $this->loadModel('Cart');
                                    $this->Cart->updateAll(
                                        array('Cart.promocode_id' => $chk_data['Promocode']['id']),
                                        array('Cart.uid'=>$redata->user_id,
                                                'Cart.sessionid'=>$redata->session_id)
                                    );

                                    $response['error'] = '0'; 
                                    $response['msg'] = 'Promo code Applied'; 
                                    $response['data'] = $chk_data;
                                }else{
                                    $response['error'] = '1'; 
                                    $response['msg'] = 'Some issue occured. Try again later.'; 
                                }
                            //}
                        }else{
                            $response['error'] = '1'; 
                            $response['msg'] = 'Invalid Promocode'; 
                        }
                    }
                }
            }else{
                $response['error'] = '1'; 
                $response['msg'] = 'You need to login first'; 
            }
        }else{
            $response['error'] = '1'; 
            $response['msg'] = 'No data to filter'; 
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }  
    
    
    
    
      public function webpromocode() {
        configure::write('debug', 0);
        $this->layout = "ajax";
          $uid = $this->Auth->user('id');
         $session = $this->Session->id();

    
	  if ($this->request->is('post')) {
		  
		          $resid = $this->request->data['rest_id']; 
            $procode = $this->request->data['promocode'];
            $subtotal = $this->request->data['subtotal'];
            $restaurants=array(0);
            array_push($restaurants,$resid);
            
            if(isset($uid) && $uid !=0){
                $this->loadModel('Cart');
                $cart_data = $this->Cart->find('all',array(
				"conditions"=>array(
					'AND'=>array(
                        'Cart.uid'=>$uid,
                        'Cart.sessionid'=>$session
                    )
				)
                    
                        ));
                if(!empty($cart_data)){
                    foreach($cart_data as $cart){
                        if($cart['Cart']['offer_id'] != 0){
                            $is_offer = 1;
                        }
                    }
                }
                if(isset($is_offer) && $is_offer == 1){
                    $response['error'] = '1'; 
                    $response['msg'] = 'You are already purchasing an offer. So you cannot apply promocode.'; 
                }else{
                //$resid=1;
                // $procode='FLAT10';
                    $data=$this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.res_id'=>$restaurants,
                         'Promocode.promocode'=>$procode,
                         'Promocode.expired >'=>date('Y-m-d h:i:s')
                         ))));
                    
                    
                    if($data){
                        if(isset($subtotal)){
                            if((float)$subtotal <= $data['Promocode']['min_order_amount']){
                                $response['error'] = '1'; 
                                $response['msg'] = 'Minimum Order Amount should be SAR '.$data['Promocode']['min_order_amount']; 
                            }else{
                                $this->loadModel('UserPromocode');
                                 $exists = $this->UserPromocode->find('first',array('conditions'=>array(
                                        "AND"=>array(
                                        'UserPromocode.user_id'=>$uid,
                                        'UserPromocode.session_id'=>$session,
                                        'UserPromocode.order_id'=>0
                                    )
                                    )));
                                 $this->request->data['UserPromocode']['user_id']= $uid;
                                $this->request->data['UserPromocode']['res_id']=$resid;
                                $this->request->data['UserPromocode']['session_id']=$session;
                                $this->request->data['UserPromocode']['promocode_id']=$data['Promocode']['id'];
                                $this->UserPromocode->create();
                                if($this->UserPromocode->save($this->request->data)){
                                    $this->loadModel('Cart');
                                    $this->Cart->updateAll(
                                        array('Cart.promocode_id' => $data['Promocode']['id']),
                                        array('Cart.uid'=>$uid,
                                                'Cart.sessionid'=>$session)
                                    );

                                    $response['error'] = '0'; 
                                    $response['msg'] = 'Promo code Applied'; 
                                    $response['data'] = $data;
                                }else{
                                    $response['error'] = '1'; 
                                    $response['msg'] = 'Some issue occured. Try again later.'; 
                                }
                            }
                        }
//                        $response['error'] = '0'; 
//                        $response['msg'] = 'Promo code Applied'; 
//                        $response['data'] = $data;
                    }else {
                        $response['error'] = '1'; 
                        $response['msg'] = 'Invalid Promocode'; 
                    }
                }
            }else{
                $response['error'] = '1'; 
                $response['msg'] = 'You need to login first'; 
            }
        }else{
            $response['error'] = '1'; 
            $response['msg'] = 'No data to filter'; 
        }
			
		
	
       $response['cartdata']= $this->webdisplaycart1();   
        echo json_encode($response);     
       exit;

    }
    
    
    public function api_promocodeById() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata); 
        if(!empty($redata)){
            $promocode = $this->Promocode->find('first',array("conditions"=>array('Promocode.id'=>$redata->Promocode->id)));
            if($promocode){
                $response['isSuccess']=true;
                $response['data']=$promocode;
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Some error occured';
            }
        }else{
            $response['isSuccess'] = false; 
            $response['msg'] = 'No data to filter'; 
        }
        
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    /*
     * @parameters: user_id, session_id,promocode_id
     * @remove from users_promocode table
     * @update promocode_id in cart table
     */
    public function api_removePromocode() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata); 
        //$redata ='ghfghf';
        if($redata){
            $this->loadModel('UserPromocode');
            //"AND"=>array(
             //       'UserPromocode.user_id'=>$redata->user_id,
             //       'UserPromocode.session_id'=>$redata->session_id,
             //       'UserPromocode.promocode_id'=>$redata->promocode_id
             //   )
            if($this->UserPromocode->deleteAll(array(
                "AND"=>array(
                    'UserPromocode.user_id'=>$redata->user_id,
                    'UserPromocode.session_id'=>$redata->session_id,
                    'UserPromocode.promocode_id'=>$redata->promocode_id
                )
            ))){
                $this->loadModel('Cart');
                if($this->Cart->updateAll(array('Cart.promocode_id'=>0),array('Cart.uid'=>$redata->user_id,'Cart.sessionid'=>$redata->session_id))){
                   $response['isSuccess'] = true; 
                    $response['msg'] = 'Deleted'; 
                }else{
                    $response['isSuccess'] = false; 
                    $response['msg'] = 'Unable to update';
                }
                
                
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Error while deleting';
            }
        }else{
            $response['isSuccess'] = false; 
            $response['msg'] = 'No data to filter'; 
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    ////////////////////////////////
    
    
        public function removePromocode() {  
        configure::write('debug', 0);
        if($this->request->is('post')){
             $user_id =  $this->Auth->user('id');
            $promocode_id =$this->request->data['promocode_id'];
  
            $this->loadModel('UserPromocode');
           
            if($this->UserPromocode->deleteAll(array(
                "AND"=>array(
                    'UserPromocode.user_id'=>$user_id,
                    'UserPromocode.session_id'=>$this->Session->id(),
                    'UserPromocode.promocode_id'=> $promocode_id
                )
            ))){
                $this->loadModel('Cart');
                if($this->Cart->updateAll(array('Cart.promocode_id'=>0),array('Cart.uid'=>$user_id,'Cart.sessionid'=>$this->Session->id()))){
                   $response['isSuccess'] = true; 
                    $response['msg'] = ''; 
                }else{
                    $response['isSuccess'] = false; 
                    $response['msg'] = 'Unable to update';
                }
                
                  
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Error while deleting';
            }
        }
    // return $this->webdisplaycart1();
		  $response['cartdata']= $this->webdisplaycart1();   
        echo json_encode($response);     
       exit;
    }
    
}
