<?php

App::uses('AppController', 'Controller');

/**
 * Promocodes Controller
 *
 * @property Promocodes $Promocodes
 * @property PaginatorComponent $Paginator
 */
class UnavailableDatesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','RequestHandler');

       public function beforeFilter() {
        parent::beforeFilter();
    }
    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index($id=NULL) {
        
        $this->Promocode->recursive=1;
        $this->Paginator = $this->Components->load('Paginator');
        if($id){
            $this->Paginator->settings = array(            
                'Promocode' => array(
                    'conditions'=>array(
                        'Promocode.res_id'=>$id
                    ),
                    'limit' => 20
                )
            );
            $this->set("resid", $id);
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
        if (!$this->UnavailableDate->exists($id)) {
            throw new NotFoundException(__('Invalid Unavailable Date'));
        }
        $options = array('conditions' => array('UnavailableDate.' . $this->UnavailableDate->primaryKey => $id),'recursive'=>1);
        $this->set('UnavailableDate', $this->UnavailableDate->find('first', $options));
          
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($id=NULL) {
        if ($this->request->is('post')) {
            $this->UnavailableDate->create();
            if ($this->UnavailableDate->save($this->request->data)) {
                $this->Session->setFlash(__('The Unavailable Date has been saved.'));
                return $this->redirect(array('controller'=>'restaurants','action' => 'unavailabledates',$id));
            } else {
                $this->Session->setFlash(__('The Unavailable Date could not be saved. Please, try again.'));
            }
        }
        if($id){
            $this->loadModel('Restaurant');
            $this->set('restaurant',$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id))));
        }
		$this->loadModel('Restaurant');
		if($this->Auth->user('role')=="rest_admin"){
			  $this->set('restaurant_list',$this->Restaurant->find('list',array('conditions'=>array('Restaurant.user_id'=>$this->Auth->user('id')))));
		}else{
		    $this->set('restaurant_list',$this->Restaurant->find('list'));	
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
        Configure::write("debug", 0);
        if (!$this->UnavailableDate->exists($id)) {
            throw new NotFoundException(__('Invalid Unavailable Date'));
        }
        if ($this->request->is(array('post', 'put'))) {
               $this->UnavailableDate->id=$id;
          //  print_r($this->request->data);exit;
            if ($this->UnavailableDate->save($this->request->data)) {
                $this->Session->setFlash(__('The Unavailable Date has been saved.'));
                return $this->redirect(array('controller'=>'restaurants','action' => 'unavailabledates',$this->request->data['UnavailableDate']['restaurant_id']));
            } else {
                $this->Session->setFlash(__('The Unavailable Date could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('UnavailableDate.' . $this->UnavailableDate->primaryKey => $id),'recursive'=>1);
            $this->request->data = $this->UnavailableDate->find('first', $options);
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
        $this->UnavailableDate->id = $id;
        if (!$this->UnavailableDate->exists()) {
            throw new NotFoundException(__('Invalid Unavailable Date'));
        }
        $unavailable_info = $this->UnavailableDate->find('first',array('conditions'=>array('UnavailableDate.id'=>$id)));
        //print_r($unavailable_info);
        if($unavailable_info){
            $restaurant_id = $unavailable_info['UnavailableDate']['restaurant_id'];
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->UnavailableDate->delete()) {
            $this->Session->setFlash(__('The Unavailable Date has been deleted.'));
        } else {
            $this->Session->setFlash(__('The Unavailable Date could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('controller'=>'restaurants','action' => 'unavailabledates',$restaurant_id));
    }
    
}
