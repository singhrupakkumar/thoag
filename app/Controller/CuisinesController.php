<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 * @property PaginatorComponent $Paginator
 */
class CuisinesController extends AppController {

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
		$this->Cuisine->recursive = 0;
		$this->set('cuisine', $this->Paginator->paginate()); 
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
		$this->set('cuisine', $this->Cuisine->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cuisine->create();
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The Cuisine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cuisine could not be saved. Please, try again.'));
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
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The Cuisine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cuisine could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
			$this->request->data = $this->Cuisine->find('first', $options);
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
		$this->Cuisine->id = $id;
		if (!$this->Cuisine->exists()) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cuisine->delete()) {
			$this->Session->setFlash(__('The Cuisine has been deleted.'));
		} else {
			$this->Session->setFlash(__('The Cuisine could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Cuisine->recursive = 0;
		$this->set('cuisine', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
		$this->set('cuisine', $this->Cuisine->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {

             $d = $this->request->data['Cuisine']['image'];
            $i = $this->request->data['Cuisine']['icon'];
            // print_r($this->request->data);
            $uploadfolderpath = "catimage";
            $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
            if ($d['error'] == 0) {
                $imagename = $d['name'];
                if (file_exists($uploadpath . DS . $imagename)) {
                    $imagename = time() . $imagename;
                }
                $fullpathimage = $uploadpath . DS . $imagename;
                $this->request->data['Cuisine']['image'] = $imagename;
                move_uploaded_file($d['tmp_name'], $fullpathimage);
            }
            
            
             $uploadfoldericpath = "caticon";
            $uploadipath = WWW_ROOT . '/files/' . $uploadfoldericpath;
            if ($i['error'] == 0) {
                $iconname = $i['name'];
                if (file_exists($uploadipath . DS . $iconname)) {
                    $iconname = time() . $iconname;
                }
                $fullpathimage = $uploadipath . DS . $iconname;
                $this->request->data['Cuisine']['icon'] = $iconname; 
                move_uploaded_file($i['tmp_name'], $fullpathimage);
            }

			$this->Cuisine->create();
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The Cuisine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cuisine could not be saved. Please, try again.'));
			}
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
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		if ($this->request->is(array('post', 'put'))) {
                    
                    
                    
           $d = $this->request->data['Cuisine']['image'];
            $i = $this->request->data['Cuisine']['icon'];

            if ($d['name'] == '') {
                $this->request->data['Cuisine']['image'] = $this->request->data['Cuisine']['img']; 
            }
            
            
                if ($i['name'] == '') {
                $this->request->data['Cuisine']['icon'] = $this->request->data['Cuisine']['ion'];
            }

            $uploadfolderpath = "catimage";
            $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
            if ($d['error'] == 0) {
                $imagename = $d['name'];
                if (file_exists($uploadpath . DS . $imagename)) {
                    $imagename = time() . $imagename;
                }
                $fullpathimage = $uploadpath . DS . $imagename;
                $this->request->data['Cuisine']['image'] = $imagename;
                move_uploaded_file($d['tmp_name'], $fullpathimage);
            }
            
            
             $uploadfolderipath = "caticon";
            $uploadpath = WWW_ROOT . '/files/' . $uploadfolderipath;
            if ($i['error'] == 0) {
                $iconname = $i['name'];
                if (file_exists($uploadpath . DS . $iconname)) {
                    $iconname = time() . $iconname;
                }
                $fullpathicon = $uploadpath . DS . $iconname;
                $this->request->data['Cuisine']['icon'] = $iconname;
                move_uploaded_file($i['tmp_name'], $fullpathicon); 
            }
                    
                    
                    
                    
                    
                    
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The Cuisine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cuisine could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
			$this->request->data = $this->Cuisine->find('first', $options);
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
		$this->Cuisine->id = $id;
		if (!$this->Cuisine->exists()) {
			throw new NotFoundException(__('Invalid Cuisine'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cuisine->delete()) {
			$this->Session->setFlash(__('The Cuisine has been deleted.'));
		} else {
			$this->Session->setFlash(__('The Cuisine could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
 