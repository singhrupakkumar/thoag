<?php
App::uses('AppController', 'Controller');
/**
 * Offers Controller
 *
 * @property Offer $Offer
 * @property PaginatorComponent $Paginator
 */
class OffersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Offer->recursive = 0;
		$this->set('offers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Offer->exists($id)) {
			throw new NotFoundException(__('Invalid offer'));
		}
		$options = array('conditions' => array('Offer.' . $this->Offer->primaryKey => $id));
		$this->set('offer', $this->Offer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Offer->create();
			if ($this->Offer->save($this->request->data)) {
				$this->Session->setFlash(__('The offer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Offer->exists($id)) {
			throw new NotFoundException(__('Invalid offer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Offer->save($this->request->data)) {
				$this->Session->setFlash(__('The offer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Offer.' . $this->Offer->primaryKey => $id));
			$this->request->data = $this->Offer->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Offer->delete()) {
			$this->Session->setFlash(__('The offer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The offer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$role = $this->Auth->user('role');
		$id = $this->Auth->user('id');
		$this->Offer->recursive = 0;
		
		if($role == 'rest_admin'){
			$this->loadModel('Restaurant');
			$restuser = $this->Restaurant->find('list',array("conditions"=>array( "Restaurant.user_id"=>$id)));
			

		if(!empty($restuser)){
					  $restids = array_keys($restuser);
		
			  $this->Paginator->settings = array( 
             'recursive' => 2,
        'conditions' =>array( "Offer.res_id"=>$restids) ,
        'limit' =>12
			);
			
		$offers = $this->Paginator->paginate('Offer');
		 
		}
			$this->set('offers', $offers);	
		}else{
		$this->set('offers', $this->Paginator->paginate());
		}
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Offer->exists($id)) {
			throw new NotFoundException(__('Invalid offer'));
		}
		$options = array('conditions' => array('Offer.' . $this->Offer->primaryKey => $id));
		$this->set('offer', $this->Offer->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
                    // Offer Image 
                    $image = $this->request->data['Offer']['image'];
                    $uploadFolder = "offers";
                    $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
                    //check if there wasn't errors uploading file on serwer
                    if ($image['error'] == 0) {
                        $imageName = $image['name'];
                        //check if file exists in upload folder
                        if (file_exists($uploadPath . DS . $imageName)) {
                            //create full filename with timestamp
                            $imageName = date('His') . $imageName;
                        }
                        $full_image_path = $uploadPath . DS . $imageName;
                        move_uploaded_file($image['tmp_name'], $full_image_path);  
                    }
                    $this->request->data['Offer']['image']= $imageName;
                    $this->Offer->create();
                    if ($this->Offer->save($this->request->data)) {
                            $this->Session->setFlash(__('The offer has been saved.'));
                            return $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
                    }
		}
			$this->loadModel('Restaurant');
	   $role = $this->Auth->user('role');
		$id = $this->Auth->user('id');
		if($role == 'rest_admin'){
			$restuser = $this->Restaurant->find('list',array("conditions"=>array( "Restaurant.user_id"=>$id)));
			$this->set('restaurant_list', $restuser);	
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
		if (!$this->Offer->exists($id)) {
			throw new NotFoundException(__('Invalid offer'));
		}
		if ($this->request->is(array('post', 'put'))) {
                   // print_r($this->request->data); exit;
                    $image = $this->request->data['Offer']['image'];
                    $uploadFolder = "offers";
                    $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
                    //check if there wasn't errors uploading file on serwer
                    if ($image['error'] == 0) {
                        $imageName = $image['name'];
                        //check if file exists in upload folder
                        if (file_exists($uploadPath . DS . $imageName)) {
                            //create full filename with timestamp
                            $imageName = date('His') . $imageName;
                        }
                        $full_image_path = $uploadPath . DS . $imageName;
                        move_uploaded_file($image['tmp_name'], $full_image_path);  
                        $this->request->data['Offer']['image'] = $imageName;
                    }else{
                        $this->request->data['Offer']['image'] =$this->request->data['Offer']['old_image'];
                    }
                    $this->request->data['Offer']['id']=$id;
                    
			if ($this->Offer->save($this->request->data)) {
				$this->Session->setFlash(__('The offer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Offer.' . $this->Offer->primaryKey => $id));
			$this->request->data = $this->Offer->find('first', $options);
		}
        $this->loadModel('Restaurant');
	   $role = $this->Auth->user('role');
		$id = $this->Auth->user('id');
		if($role == 'rest_admin'){
			$restuser = $this->Restaurant->find('list',array("conditions"=>array( "Restaurant.user_id"=>$id)));
			$this->set('restaurant_list', $restuser);	
		}else{
            $this->set('restaurant_list',$this->Restaurant->find('list'));
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
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Offer->delete()) {
			$this->Session->setFlash(__('The offer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The offer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
    public function api_allOffers(){
        $this->layout="ajax";
        $this->Offer->recursive=2;
        $lat="28.291666";
        $long="50.220013";
        $offers = $this->Offer->find('all',array(
            'fields'=>  array(
            "get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*",
            "Offer.res_id","start_date","end_date"
            ),
            'group'=>'Offer.res_id'
            ));
        if($offers){
            $response['isSuccess']=true;
            $response['data']=$offers;
        }else{
            $response['isSuccess']=false;
            $response['msg']="No offers found";
        }
        echo json_encode($response);
        $this->render('../Restaurants/ajax');
        exit;
    }
}
