<?php
App::uses('AppController', 'Controller');
class DashboardsController extends AppController {
       public function beforeFilter() {
        parent::beforeFilter();
       
    }
    
    public function admin_index(){
        if($this->Auth->user('role')=='admin'){
            // Total Users
            $this->loadModel('User');
            $total_users = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role !='=>'admin','User.active'=>1))));
        
            // Total Restaurant Owners
            $total_caterer = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role'=>'rest_admin','User.active'=>1))));

            // Total Restaurant Owners
            $total_customer = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role'=>'customer','User.active'=>1))));

            // Total Sales
            $this->loadModel('Order');
            $total_orders = $this->Order->find('count',array('conditions'=>array('Order.order_status'=>5)));

            // catering Orders
            $total_catering_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>1, 'Order.order_status'=>5))));

            // delivered Orders
            $total_delivered_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>2, 'Order.order_status'=>5))));

            // pickup Orders
            $total_pickup_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>3, 'Order.order_status'=>5))));

            // pending Orders
            $total_pending_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>1))));
        
            // placed Orders
            $total_placed_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>2))));

            // processing Orders
            $total_processing_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>3))));

            // user cancelled Orders
            $total_userCancelled_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>6))));

            // user freeze Orders
            $total_freeze_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>7))));

            // latest orders
            $latest_orders = $this->Order->find('all',array('conditions'=>array('Order.order_status !='=>0),'order'=>array('Order.id DESC'),'limit'=>5,'recursive'=>1));
            
            // latest products
            $this->loadModel('Product');
            $products = $this->Product->find('all',array('order'=>array('Product.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($products as $product){
                if ($product['Product']['image']) {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $product['Product']['image'];
                } else {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                $latest_products[] = $product;
            }
            
            // latest members
            $members = $this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'customer','User.active'=>1)),'order'=>array('User.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($members as $member){
                if ($member['User']['image'] != '') {
                    if (!filter_var($member['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $member['User']['image'] = $member['User']['image'];
                    } else {
                        $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $member['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_members[] = $member;
            }
            // latest restaurant admins
            $caterers = $this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'rest_admin','User.active'=>1)),'order'=>array('User.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($caterers as $member){
                if ($member['User']['image'] != '') {
                    if (!filter_var($member['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $member['User']['image'] = $member['User']['image'];
                    } else {
                        $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $member['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_caterers[] = $member;
            }
            
            // recent reviews
            $this->loadModel('RestaurantsReview');
            $reviews = $this->RestaurantsReview->find('all',array('order'=>array('RestaurantsReview.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($reviews as $review){
                if ($review['User']['image'] != '') {
                    if (!filter_var($review['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $review['User']['image'] = $review['User']['image'];
                    } else {
                        $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $review['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_reviews[] = $review;
            }
            
            // recent reviews
            $this->loadModel('Dispute');
            $disputes = $this->Dispute->find('all',array('order'=>array('Dispute.id DESC'),'limit'=>5,'recursive'=>1));
            
            // sales
            //$sales = $this->Order->find('all',array('conditions'=>array('Order.order_status !='=>0),'fields'=>array('id','MONTH("Order.created")'),'group'=>array("MONTH('Order.created')")));
            //print_r($sales);
           // $log = $this->Order->getDataSource()->getLog(false, false);
    //debug($log);
        $sales = $this->Order->query("SELECT COUNT(id) as total_orders ,MONTH(created) as Month FROM orders GROUP BY YEAR(created), MONTH(created);");
       // print_r($sales);         
            $this->set(compact('total_users','total_caterer','total_customer','total_orders','total_catering_orders','total_delivered_orders','total_pickup_orders','total_pending_orders','total_placed_orders','total_processing_orders','total_userCancelled_orders','total_freeze_orders','latest_orders','latest_products','latest_members','latest_caterers','latest_reviews','disputes'));
        }else{
            $this->loadModel('Restaurant');
            $authuserRestaurants = $this->Restaurant->find('list',array('conditions'=>array('Restaurant.user_id'=>$this->Auth->User('id'))));
            $catererRestaurants=array_keys($authuserRestaurants);
             // Total Users
            $this->loadModel('User');
            $total_users = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role !='=>'admin','User.active'=>1))));
        
            // Total Restaurant Owners
            $total_caterer = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role'=>'rest_admin','User.active'=>1))));

            // Total Restaurant Owners
            $total_customer = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role'=>'customer','User.active'=>1))));

            // Total Sales
            $this->loadModel('Order');
            $total_orders = $this->Order->find('count',array('conditions'=>array("AND"=>array('Order.restaurant_id'=>$catererRestaurants,'Order.order_status'=>5))));

            // catering Orders
            $total_catering_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>1, 'Order.order_status'=>5))));

            // delivered Orders
            $total_delivered_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>2, 'Order.order_status'=>5))));

            // pickup Orders
            $total_pickup_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.delivery_status'=>3, 'Order.order_status'=>5))));

            // pending Orders
            $total_pending_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>1))));
        
            // placed Orders
            $total_placed_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>2))));

            // processing Orders
            $total_processing_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>3))));

            // user cancelled Orders
            $total_userCancelled_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>6))));

            // user freeze Orders
            $total_freeze_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>7))));

            // latest orders
            $latest_orders = $this->Order->find('all',array('conditions'=>array('Order.restaurant_id'=>$catererRestaurants),'order'=>array('Order.id DESC'),'limit'=>5,'recursive'=>1));
            
            // latest products
            $this->loadModel('Product');
            $products = $this->Product->find('all',array('conditions'=>array('Product.res_id'=>$catererRestaurants),'order'=>array('Product.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($products as $product){
                if ($product['Product']['image']) {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $product['Product']['image'];
                } else {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                $latest_products[] = $product;
            }
            
            // latest members
            $members = $this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'customer','User.active'=>1)),'order'=>array('User.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($members as $member){
                if ($member['User']['image'] != '') {
                    if (!filter_var($member['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $member['User']['image'] = $member['User']['image'];
                    } else {
                        $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $member['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_members[] = $member;
            }
            // latest restaurant admins
            $caterers = $this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'rest_admin','User.active'=>1)),'order'=>array('User.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($caterers as $member){
                if ($member['User']['image'] != '') {
                    if (!filter_var($member['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $member['User']['image'] = $member['User']['image'];
                    } else {
                        $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $member['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_caterers[] = $member;
            }
            
            // recent reviews
            $this->loadModel('RestaurantsReview');
            $reviews = $this->RestaurantsReview->find('all',array('conditions'=>array('RestaurantsReview.restaurant_id'=>$catererRestaurants),'order'=>array('RestaurantsReview.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($reviews as $review){
                if ($review['User']['image'] != '') {
                    if (!filter_var($review['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $review['User']['image'] = $review['User']['image'];
                    } else {
                        $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $review['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $review['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_reviews[] = $review;
            }
            
            // recent reviews
            $this->loadModel('Dispute');
            $disputes = $this->Dispute->find('all',array('order'=>array('Dispute.id DESC'),'limit'=>5,'recursive'=>1));
            
            // sales
            //$sales = $this->Order->find('all',array('conditions'=>array('Order.order_status !='=>0),'fields'=>array('id','MONTH("Order.created")'),'group'=>array("MONTH('Order.created')")));
            //print_r($sales);
           // $log = $this->Order->getDataSource()->getLog(false, false);
    //debug($log);
        $sales = $this->Order->query("SELECT COUNT(id) as total_orders ,MONTH(created) as Month FROM orders GROUP BY YEAR(created), MONTH(created);");
       // print_r($sales);         
            $this->set(compact('total_users','total_caterer','total_customer','total_orders','total_catering_orders','total_delivered_orders','total_pickup_orders','total_pending_orders','total_placed_orders','total_processing_orders','total_userCancelled_orders','total_freeze_orders','latest_orders','latest_products','latest_members','latest_caterers','latest_reviews','disputes'));
        
        }
        
    }

    public function admin_dashboard() {
//        Configure::write("debug", 2);
//        $this->loadModel('Dashboard');
//        $data=$this->Dashboard->find('all',array('limit'=>30, 'order' => array(
//                'Dashboard.id' => 'desc'
//            )));
//        $this->set('data',$data);
    }
    public function admin_dashboardview($id=NULL) {
        Configure::write("debug", 2);
        $this->loadModel('Dashboard');
        $data=$this->Dashboard->find('all',array('conditions'=>array('Dashboard.id'=>$id)),array('limit'=>30, 'order' => array(
                'Dashboard.id' => 'desc'
            )));
        $this->set('data',$data);
    }
}