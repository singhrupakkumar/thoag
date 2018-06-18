<?php
App::uses('AppController','Controller');

/**
 * Discounts Controller
 *
 * @property Discounts $Discount
 * @property PaginatorComponent $Paginator
 */
class DiscountsController extends AppController{
    public $components =array('Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array());
    }
    
    /**
    * admin_index method
    *
    * @return void
    */

	public function admin_index() {
            // $this->Auth->user('role')
            $this->Discount->recursive = 1;
            if ($this->Auth->user('role') == "rest_admin") {
                $uid = $this->Auth->user('id');
                $this->loadModel('Restaurant');
                $restaurants = $this->Restaurant->find('list', array('conditions' => array('Restaurant.user_id' => $uid),'recursive'=>1));
                $restaurants_ids = array_keys($restaurants);
                $all = array(
                    'name' => '',
                    'filter' => '',
                    'conditions' => array(
                        'Discount.res_id' => $restaurants_ids),
                    'recursive'=>2
                    );
            } else {
              $all = array(
                    'name' => '',
                    'filter' => '',
                    'conditions' => '',
                  'recursive'=>2
                  );
            }
        $this->set(compact('all'));
        $this->Paginator = $this->Components->load('Paginator');
        
        $this->Paginator->settings = array('conditions' => $all['conditions'], 'recursive' => 2, 'limit' => 20, 'order' => array(
                'Order.id' => 'desc'
        ));
        $discounts = $this->Paginator->paginate();
            $this->set('discounts', $this->Paginator->paginate());
	}
/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_view($id = null) {
        if($this->Auth->User('role')!='admin'){
            $auth_id = $this->Auth->User('id');
            $this->loadModel('Restaurant');
            $restaurants = $this->Restaurant->find('list',array('conditions'=>array('Restaurant.user_id'=>$auth_id)));
            $restaurants_ids = array_keys($restaurants);
            $options = array('conditions' => array('AND'=>array('Discount.' . $this->Discount->primaryKey => $id,'Discount.res_id IN'=>$restaurants_ids)),'recursive'=>1);
            $discount_id = $this->Discount->find('first', $options);
            if($discount_id){
                $this->set('discount',$discount_id);
            }else{
                $this->render('/Pages/unauthorized');
            }
            
        }else{
            if (!$this->Discount->exists($id)) {
                throw new NotFoundException(__('Invalid Discount!'));
            }
            $options = array('conditions' => array('Discount.' . $this->Discount->primaryKey => $id),'recursive'=>1);
            $this->set('discount', $this->Discount->find('first', $options));
        }
        
        
        
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
	if ($this->request->is('post')) {
            $this->Discount->create();
            if ($this->Discount->save($this->request->data)) {
                $this->Session->setFlash(__('The staticpage has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));
            }
        }
        if ($this->Auth->user('role') == "rest_admin") {
                $uid = $this->Auth->user('id');
                $this->loadModel('Restaurant');
                $restaurants = $this->Restaurant->find('list', array('conditions' => array('Restaurant.user_id' => $uid),'recursive'=>1));
                $restaurants_ids = array_keys($restaurants);
                $this->set('restaurantlist',$this->Restaurant->find('list',array('conditions'=>array(
                    'AND'=>array(
                        'Restaurant.status'=>1,
                        'Restaurant.id'=>$restaurants_ids
                    ),
                    'order'=>array('Restaurant.name ASC')
                    ))));
                
                
            }else{
                $this->loadModel('Restaurant');
                $this->set('restaurantlist',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.status'=>1),'order'=>array('Restaurant.name ASC'))));
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
        $this->Discount->id = $id;
        if (!$this->Discount->exists()) {
            throw new NotFoundException(__('Invalid Discount'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Discount->save($this->request->data)) {
                $this->Session->setFlash(__('The Discount has been saved'));
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash(__('The Discount could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Discount->read(null, $id);
        }
        $this->set('admin_edit', $this->Discount->find('first', array('conditions' => array('Discount.id' => $id))));
    }

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->Discount->id = $id;
        if (!$this->Discount->exists()) {
            throw new NotFoundException(__('Invalid Discount'));
        }
        $this->request->allowMethod('post', 'delete');
            if ($this->Discount->delete()) {
                $this->Session->setFlash(__('The Discount has been deleted.'));
            } else {
                $this->Session->setFlash(__('The Discount could not be deleted. Please, try again.'));
            }
        return $this->redirect(array('action' => 'index'));
    }
   
}
?>