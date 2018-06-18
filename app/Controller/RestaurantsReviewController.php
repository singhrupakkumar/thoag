<?php
App::uses('AppController','Controller');

/**
 * RestaurantsReview Controller
 *
 * @property RestaurantsReview $RestaurantsReview
 * @property PaginatorComponent $Paginator
 */
class RestaurantsReviewController extends AppController{
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
            $this->RestaurantsReview->recursive = 1;
            if ($this->Auth->user('role') == "rest_admin") {
                $uid = $this->Auth->user('id');
                $this->loadModel('Restaurant');
                $restaurants = $this->Restaurant->find('list', array('conditions' => array('Restaurant.user_id' => $uid),'recursive'=>1));
                $restaurants_ids = array_keys($restaurants);
                $all = array(
                    'name' => '',
                    'filter' => '',
                    'conditions' => array(
                        'RestaurantsReview.restaurant_id' => $restaurants_ids),
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
                'RestaurantsReview.id' => 'desc'
        ));
        $discounts = $this->Paginator->paginate();
            $this->set('reviews', $this->Paginator->paginate());
	}
/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_view($id = null) {
        if (!$this->RestaurantsReview->exists($id)) {
                throw new NotFoundException(__('Invalid Review'));
        }
        $options = array('conditions' => array('RestaurantsReview.' . $this->RestaurantsReview->primaryKey => $id),'recursive'=>1);
        $this->set('review', $this->RestaurantsReview->find('first', $options));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
	if ($this->request->is('post')) {
            $this->RestaurantsReview->create();
            if ($this->RestaurantsReview->save($this->request->data)) {
                $this->Session->setFlash(__('The Review has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Review could not be saved. Please, try again.'));
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
        $this->RestaurantsReview->id = $id;
        if (!$this->RestaurantsReview->exists()) {
            throw new NotFoundException(__('Invalid Restaurant Review'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Discount->save($this->request->data)) {
                $this->Session->setFlash(__('The Review has been saved'));
                $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash(__('The Review could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->RestaurantsReview->read(null, $id);
        }
        $this->set('admin_edit', $this->RestaurantsReview->find('first', array('conditions' => array('RestaurantsReview.id' => $id))));
    }

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null) {
        $this->RestaurantsReview->id = $id;
        if (!$this->RestaurantsReview->exists()) {
            throw new NotFoundException(__('Invalid Review'));
        }
        $this->request->allowMethod('post', 'delete');
            if ($this->RestaurantsReview->delete()) {
                $this->Session->setFlash(__('The Review has been deleted.'));
            } else {
                $this->Session->setFlash(__('The Review could not be deleted. Please, try again.'));
            }
        return $this->redirect(array('action' => 'index'));
    }
   
}
?>