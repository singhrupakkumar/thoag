<?php
App::uses('AppController', 'Controller');

/**
 * CommissionsController Controller
 *
 * @property Restaurant $Restaurant
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class CommissionsController extends AppController {
    
    public function admin_add(){
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is('post')) {
                $res_id = $this->request->data['Commission']['restaurant_id'];
                $exist = $this->Commission->find('first',array('conditions'=>array('Commission.restaurant_id'=>$res_id)));
                if($exist){
                    $this->Commission->id = $exist['Commission']['id'];
                    $this->Commission->saveField('commission',$this->request->data['Commission']['commission']);
                    $this->Session->setFlash('Commission has been Updated!', 'flash_success');
                    return $this->redirect(array('action' => 'index'));
                }else{
                    $this->Commission->create();
                    if($this->Commission->save($this->request->data)){
                        $this->Session->setFlash('Commission has been Saved!', 'flash_success');
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash('Commission has not been Saved!', 'flash_error');
                    }
                }

            }
            $this->loadModel('Restaurant');
            $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1))));
        }
    }
    
    public function admin_index(){
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }
        if($this->request->is('post')){
            $this->Session->write('CommissionList.restaurant_id', $this->request->data['Commission']['restaurant_id']);
            
            $all = $this->Session->read('CommissionList');
            $this->set('all',$all);
            
            $this->Paginator = $this->Components->load('Paginator');
            $this->Paginator->settings = array(
                'Commission' => array(
                    'conditions'=>array(
                      'Commission.restaurant_id'=>$this->request->data['Commission']['restaurant_id']  
                    ),
                    'recursive' => 1,
                    'order' => array(
                        'Commission.created' => 'DESC'
                    ),
                    'limit' => 20,
                    'paramType' => 'querystring',
                )
            );
            $this->set('commissions', $this->Paginator->paginate());
        }else{
            $all = array(
                'restaurant_id' => '');
        $this->set(compact('all'));
            $this->Paginator = $this->Components->load('Paginator');
            $this->Paginator->settings = array(
                'Commission' => array(
                    'recursive' => 1,
                    'order' => array(
                        'Commission.created' => 'DESC'
                    ),
                    'limit' => 20,
                    'paramType' => 'querystring',
                )
            );
            $this->set('commissions', $this->Paginator->paginate());
        }
        $this->loadModel('Restaurant');
        $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1),'order'=>array('Restaurant.name ASC'))));
            
        /* if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->Paginator = $this->Components->load('Paginator');
            $this->Paginator->settings = array(
                'Commission' => array(
                    'recursive' => 1,
                    'order' => array(
                        'Commission.created' => 'DESC'
                    ),
                    'limit' => 20,
                    'paramType' => 'querystring',
                )
            );
            $this->set('commissions', $this->Paginator->paginate());
            $this->loadModel('Restaurant');
            $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1),'order'=>array('Restaurant.name ASC'))));
            
        }*/
    }
    
    public function admin_edit($id = null) {
         Configure::write("debug", 2);
         if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->Commission->exists($id)) {
                throw new NotFoundException(__('Invalid Commission'));
            }

            if ($this->request->is(array('post', 'put'))) {
                if ($this->Commission->save($this->request->data)) {
                    $this->Session->setFlash(__('The Commission has been saved.','flash_success'));
                    return $this->redirect(array('action' => 'index'));
                }else{
                    $this->Session->setFlash(__('Error while updating.Please try again!','flash_error'));
                }
            } else {
                $options = array('conditions' => array('Commission.' . $this->Commission->primaryKey => $id));
                $this->request->data = $this->Commission->find('first', $options);
            }
            $this->loadModel('Restaurant');
            $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1))));
        }
    }
    
    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->Commission->id = $id;
            if (!$this->Commission->exists()) {
                throw new NotFoundException(__('Invalid Commission'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->Commission->delete()) {
                $this->Session->setFlash(__('The Commission has been deleted.','flash_success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Commission could not be deleted. Please, try again.','flash_error'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }
    
    public function admin_indexall() {
        Configure::write("debug", 2);
        $this->loadModel('Restaurant');
        if ($this->request->is("post")) {
            if (empty($this->request->data['Order']['date'])) {
                $this->request->data['Order']['date'] = "2016-01-01";
            }
            if ($this->request->data['Order']['date1'] == '') {
                $this->request->data['Order']['date1'] = date('Y-m-d');
            }
            if ($this->request->data['Order']['restaurant_id'] == '') {
                $resdata = $this->Restaurant->find('list');
            } else {
                $resdata = $this->Restaurant->find('list', array('conditions' => array('Restaurant.id' => $this->request->data['Order']['restaurant_id'])));
            }
            $postres_id = $this->request->data['Order']['restaurant_id'];
            $date = $this->request->data['Order']['date'];
            $date1 = $this->request->data['Order']['date1'];
            
            $this->Session->write('Commission.restaurant_id', $postres_id);
            $this->Session->write('Commission.date', $date);
            $this->Session->write('Commission.date1', $date1);
            
            $all = $this->Session->read('Commission');
            $this->set('all',$all);
            $date=date("Y-m-d", strtotime($date));
            $date1=date("Y-m-d", strtotime($date1));
            
            $final =[];
            if($postres_id){
                $this->loadModel('Order');
                $unique_res = $this->Order->find('all', array('conditions' => array('AND' => array('Order.created  BETWEEN ? and ?' => array($date, $date1),'Order.restaurant_id'=>$postres_id)),'group'=>'Order.restaurant_id','Order.order_status'=>5,'recursive'=>1));
            }else{
                $this->loadModel('Order');
                $unique_res = $this->Order->find('all', array('conditions' => array('AND' => array('Order.created  BETWEEN ? and ?' => array($date, $date1))),'group'=>'Order.restaurant_id','Order.order_status'=>5,'recursive'=>1));
            }
               
            foreach($unique_res as $single_restaurant){
                $commission_res = $this->Commission->find('first',array('conditions'=>array('Commission.restaurant_id'=>$single_restaurant['Order']['restaurant_id'])));
                //print_r($commission_res);
                if($commission_res){
                    $commission_percentage=$commission_res['Commission']['commission'];
                }else{
                    // Default Commission
                    $commission = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'default_commission')));
                    $commission_percentage=$commission['Setting']['value'];
                }
                $all_orders=$this->Order->find('all',array('conditions'=>array('AND'=>array('Order.restaurant_id'=>$single_restaurant['Order']['restaurant_id'],'Order.order_status'=>5))));
                //print_r($all_orders);
                if($all_orders){
                    $total=0;
                    foreach($all_orders as $order){
                        $total+=$order['Order']['total'];
                    }
                        // calculations
                    $admin_commission=$total*$commission_percentage/100;
                    $caterer_amount = $total-$admin_commission;
                    $final[$single_restaurant['Order']['restaurant_id']]['restaurant']=$single_restaurant['Restaurant'];
                    $final[$single_restaurant['Order']['restaurant_id']]['caterer']=$single_restaurant['User'];
                    $final[$single_restaurant['Order']['restaurant_id']]['order_total_count']=count($all_orders);
                    $final[$single_restaurant['Order']['restaurant_id']]['order_total_amount']=$total;
                    $final[$single_restaurant['Order']['restaurant_id']]['commission_percentage']=$commission_percentage;
                    $final[$single_restaurant['Order']['restaurant_id']]['admin_commission']=$admin_commission;
                    $final[$single_restaurant['Order']['restaurant_id']]['caterer_amount']=$caterer_amount;
                }
            }
            if($this->Auth->user('role')=='admin'){
                $this->loadModel('Restaurant');
                $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1),'order'=>array('Restaurant.name ASC'))));
            }else{
                $this->loadModel('Restaurant');
                $owner_restaurants =$this->Restaurant->find('list',array('conditions'=>array('Restaurant.user_id'=>$this->Auth->user('id')),'order'=>array('Restaurant.name ASC'))); 
                $this->set('restaurants',$owner_restaurants);
            }
        } else {
            // echo $this->Auth->user('role'); exit;
            $this->Session->delete('Commission');
            if ($this->Auth->user('role') == 'rest_admin') {

                $current_month = date('Y-m');
                $date = $current_month+"-01";
                $date1 = date('Y-m-d');
                
                $final =[];
                $this->loadModel('Order');
                $all_res = $this->Order->find('all', array('conditions' => array('AND' => array('Order.created  BETWEEN ? and ?' => array($date, $date1))),'group'=>'Order.restaurant_id','Order.order_status'=>5,'recursive'=>1));
                $this->loadModel('Restaurant');
                $owner_restaurants =$this->Restaurant->find('list',array('conditions'=>array('Restaurant.user_id'=>$this->Auth->user('id')))); 
                $this->set('restaurants',$owner_restaurants);
                $owner_restaurants_id= array_keys($owner_restaurants);
                $unique_res=array();
                foreach($all_res as $restaurant){
                    if(in_array($restaurant['Order']['restaurant_id'],$owner_restaurants_id)){
                        $unique_res[]=$restaurant;
                    }else{
                        unset($restaurant);
                    }
                }
                
                foreach($unique_res as $single_restaurant){
                    $commission_res = $this->Commission->find('first',array('conditions'=>array('Commission.restaurant_id'=>$single_restaurant['Order']['restaurant_id'])));
                    //print_r($commission_res);
                    if($commission_res){
                        $commission_percentage=$commission_res['Commission']['commission'];
                    }else{
                        // Default Commission
                        $commission = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'default_commission')));
                        $commission_percentage=$commission['Setting']['value'];
                    }
                    $all_orders=$this->Order->find('all',array('conditions'=>array('AND'=>array('Order.restaurant_id'=>$single_restaurant['Order']['restaurant_id'],'Order.order_status'=>5))));
                    //print_r($all_orders);
                    if($all_orders){
                        $total=0;
                        foreach($all_orders as $order){
                            $total+=$order['Order']['total'];
                        }
                        // calculations
                        $admin_commission=$total*$commission_percentage/100;
                        $caterer_amount = $total-$admin_commission;
                        $final[$single_restaurant['Order']['restaurant_id']]['restaurant']=$single_restaurant['Restaurant'];
                        $final[$single_restaurant['Order']['restaurant_id']]['caterer']=$single_restaurant['User'];
                        $final[$single_restaurant['Order']['restaurant_id']]['order_total_count']=count($all_orders);
                        $final[$single_restaurant['Order']['restaurant_id']]['order_total_amount']=$total;
                        $final[$single_restaurant['Order']['restaurant_id']]['commission_percentage']=$commission_percentage;
                        $final[$single_restaurant['Order']['restaurant_id']]['admin_commission']=$admin_commission;
                        $final[$single_restaurant['Order']['restaurant_id']]['caterer_amount']=$caterer_amount;
                    }
                }
            } else {
              //  $this->Session->delete('orderexcel');
                $current_month = date('Y-m');
                $date = $current_month+"-01";
                $date1 = date('Y-m-d');
                
                $final =[];
                $this->loadModel('Order');
                $unique_res = $this->Order->find('all', array('conditions' => array('AND' => array('Order.created  BETWEEN ? and ?' => array($date, $date1))),'group'=>'Order.restaurant_id','Order.order_status'=>5,'recursive'=>1));
                
                foreach($unique_res as $single_restaurant){
                    $commission_res = $this->Commission->find('first',array('conditions'=>array('Commission.restaurant_id'=>$single_restaurant['Order']['restaurant_id'])));
                    //print_r($commission_res);
                    if($commission_res){
                        $commission_percentage=$commission_res['Commission']['commission'];
                    }else{
                        // Default Commission
                        $commission = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'default_commission')));
                        $commission_percentage=$commission['Setting']['value'];
                    }
                    $all_orders=$this->Order->find('all',array('conditions'=>array('AND'=>array('Order.restaurant_id'=>$single_restaurant['Order']['restaurant_id'],'Order.order_status'=>5))));
                    //print_r($all_orders);
                    if($all_orders){
                        $total=0;
                        foreach($all_orders as $order){
                            $total+=$order['Order']['total'];
                        }
                        // calculations
                        $admin_commission=$total*$commission_percentage/100;
                        $caterer_amount = $total-$admin_commission;
                        $final[$single_restaurant['Order']['restaurant_id']]['restaurant']=$single_restaurant['Restaurant'];
                        $final[$single_restaurant['Order']['restaurant_id']]['caterer']=$single_restaurant['User'];
                        $final[$single_restaurant['Order']['restaurant_id']]['order_total_count']=count($all_orders);
                        $final[$single_restaurant['Order']['restaurant_id']]['order_total_amount']=$total;
                        $final[$single_restaurant['Order']['restaurant_id']]['commission_percentage']=$commission_percentage;
                        $final[$single_restaurant['Order']['restaurant_id']]['admin_commission']=$admin_commission;
                        $final[$single_restaurant['Order']['restaurant_id']]['caterer_amount']=$caterer_amount;
                    }
                }
                
                $this->loadModel('Restaurant');
                $this->set('restaurants',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1),'order'=>array('Restaurant.name ASC'))));
            }
        if ($this->Session->check('orderexcel')) {
            $all = $this->Session->read('orderexcel');
//        } else if ($this->Auth->user('role') == "rest_admin") {
//            $uid = $this->Auth->user('id');
//            $this->loadModel('Restaurant');
//            $res_first_data = $this->Restaurant->find('first', array('conditions' => array('Restaurant.user_id' => $uid)));
//            $all = array(
//                'name' => '',
//                'filter' => '',
//                'conditions' => array(
//                    'Order.restaurant_id' => $res_first_data['Restaurant']['id']));
        } else {
          $all = array(
                'restaurant_id' => '',
                'date' => '',
                'date1' => '');
        }
        
        $this->set(compact('all'));
        }
        $this->set(compact('final'));
    }
    
    public function admin_reset() {
        $this->Session->delete('CommissionList');
        return $this->redirect(array('action' => 'index'));
    }
    
}