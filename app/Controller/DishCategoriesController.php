<?php

App::uses('AppController', 'Controller');

/**
 * DishCategories Controller
 *
 * @property DishCategory $DishCategory
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class DishCategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_categories');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->DishCategory->recursive = 0;
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->DishCategory->exists($id)) {
            throw new NotFoundException(__('Invalid dish category'));
        }
        $options = array('conditions' => array('DishCategory.' . $this->DishCategory->primaryKey => $id));
        $this->set('dishCategory', $this->DishCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is('post')) {
                $this->DishCategory->create();
                if ($this->DishCategory->save($this->request->data)) {
                    return $this->flash(__('The dish category has been saved.'), array('action' => 'index'));
                }
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
        if (!$this->DishCategory->exists($id)) {
            throw new NotFoundException(__('Invalid dish category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->DishCategory->save($this->request->data)) {
                return $this->flash(__('The dish category has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('DishCategory.' . $this->DishCategory->primaryKey => $id));
            $this->request->data = $this->DishCategory->find('first', $options);
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
        $this->DishCategory->id = $id;
        if (!$this->DishCategory->exists()) {
            throw new NotFoundException(__('Invalid dish category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->DishCategory->delete()) {
            return $this->flash(__('The dish category has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The dish category could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_assoindex() {
        $this->DishCategory->recursive = 0;
        $this->paginate = array('conditions' => array('AND' => array('DishCategory.isshow' => 1, 'DishCategory.status' => 1)));
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->DishCategory->recursive = 0;
        $this->paginate = array('conditions' => array('AND' => array('DishCategory.isshow' => 0,'DishCategory.status'=>1)));
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->DishCategory->exists($id)) {
            throw new NotFoundException(__('Invalid dish category'));
        }
        $options = array('conditions' => array('DishCategory.id' => $id ));
        $this->set('dishCategory', $this->DishCategory->find('first', $options));
    }

    public function admin_assoview($id = null) {
        if (!$this->DishCategory->exists($id)) {
            throw new NotFoundException(__('Invalid dish category'));
        }
        $options = array('conditions' => array('AND' => array('DishCategory.' . $this->DishCategory->primaryKey => $id, 'DishCategory.uid' => $this->Auth->user('id'))));
        $this->set('dishCategory', $this->DishCategory->find('first', $options));
    }

    /**
     * admin_assoadd method
     *
     * @return void
     */
    public function admin_assoadd() {
        if ($this->request->is('post')) {
            $count = $this->DishCategory->find('count',array(
                'conditions'=>array('DishCategory.name'=>$this->request->data['DishCategory']['name'])
                )); 

            if($count >0){
                    $this->Session->setFlash('Category Name already taken. Please add Unique Entry!', 'flash_error');
                    //return $this->redirect(array('action' => 'index'));
            }else{
                $this->request->data['DishCategory']['uid'] = $this->Auth->user('id');
                $d = $this->request->data['DishCategory']['image'];
                $this->request->data['DishCategory']['isshow']=1;
                $this->request->data['DishCategory']['status']=1;
                // print_r($this->request->data);
                $uploadfolderpath = "catimage";
                $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                if ($d['error'] == 0) {
                    $imagename = $d['name'];
                    if (file_exists($uploadpath . DS . $imagename)) {
                        $imagename = time() . $imagename;
                    }
                    $fullpathimage = $uploadpath . DS . $imagename;
                    $this->request->data['DishCategory']['image'] = $imagename;
                    move_uploaded_file($d['tmp_name'], $fullpathimage);
                }
                $this->DishCategory->create();
                if ($this->DishCategory->save($this->request->data)) {
                    $this->Session->setFlash(__('The dish category has been saved.'));
                    return $this->redirect(array('action' => 'assoindex'));
                }
            }
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is('post')) {
			
                $count = $this->DishCategory->find('count',array(
                    'conditions'=>array('DishCategory.name'=>$this->request->data['DishCategory']['name'])
                    )); 

                if($count >0){
                        $this->Session->setFlash('Category Name already taken. Please add Unique Entry!', 'flash_error');
                        //return $this->redirect(array('action' => 'index'));
                }else{
			
                    $this->request->data['DishCategory']['uid'] = $this->Auth->user('id');
                    $d = $this->request->data['DishCategory']['image'];
                    $i = $this->request->data['DishCategory']['icon'];

                    $this->request->data['DishCategory']['status']=1;
                    $this->request->data['DishCategory']['isshow']=0;
                    // print_r($this->request->data);
                    $uploadfolderpath = "catimage";
                    $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                    if ($d['error'] == 0) {
                        $imagename = $d['name'];
                        if (file_exists($uploadpath . DS . $imagename)) {
                            $imagename = time() . $imagename;
                        }
                        $fullpathimage = $uploadpath . DS . $imagename;
                        $this->request->data['DishCategory']['image'] = $imagename;
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
                       $this->request->data['DishCategory']['icon'] = $iconname; 
                       move_uploaded_file($i['tmp_name'], $fullpathimage);
                   }
            // print_r($this->request->data);exit;
                    $this->DishCategory->create();
                    if ($this->DishCategory->save($this->request->data)) {
                                          $this->Session->setFlash('Dish Category has been Saved!', 'flash_success');

                        return $this->redirect(array('action' => 'index'));
                    }
			
                }
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
         Configure::write("debug", 0);
         if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->DishCategory->exists($id)) {
                throw new NotFoundException(__('Invalid dish category'));
            }

            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['DishCategory']['uid'] = $this->Auth->user('id');
                $d = $this->request->data['DishCategory']['image'];
                $i = $this->request->data['DishCategory']['icon'];

                if ($d['name'] == '') {
                    $this->request->data['DishCategory']['image'] = $this->request->data['DishCategory']['img']; 
                }


                    if ($i['name'] == '') {
                    $this->request->data['DishCategory']['icon'] = $this->request->data['DishCategory']['ion'];
                }

                $uploadfolderpath = "catimage";
                $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                if ($d['error'] == 0) {
                    $imagename = $d['name'];
                    if (file_exists($uploadpath . DS . $imagename)) {
                        $imagename = time() . $imagename;
                    }
                    $fullpathimage = $uploadpath . DS . $imagename;
                    $this->request->data['DishCategory']['image'] = $imagename;
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
                    $this->request->data['DishCategory']['icon'] = $iconname;
                    move_uploaded_file($i['tmp_name'], $fullpathicon); 
                }
            

                if ($this->DishCategory->save($this->request->data)) {
                    $this->Session->setFlash(__('The dish category has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $options = array('conditions' => array('DishCategory.' . $this->DishCategory->primaryKey => $id));
                $this->request->data = $this->DishCategory->find('first', $options);
            }
        }
    }

    public function admin_assoedit($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->DishCategory->exists($id)) {
                throw new NotFoundException(__('Invalid dish category'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['DishCategory']['uid'] = $this->Auth->user('id');
                $d = $this->request->data['DishCategory']['image'];
                if ($d['name'] == '') {
                    $this->request->data['DishCategory']['image'] = $this->request->data['DishCategory']['img'];
                }

                $uploadfolderpath = "catimage";
                $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                if ($d['error'] == 0) {
                    $imagename = $d['name'];
                    if (file_exists($uploadpath . DS . $imagename)) {
                        $imagename = time() . $imagename;
                    }
                    $fullpathimage = $uploadpath . DS . $imagename;
                    $this->request->data['DishCategory']['image'] = $imagename;
                    move_uploaded_file($d['tmp_name'], $fullpathimage);
                }
                if ($this->DishCategory->save($this->request->data)) {
                    $this->Session->setFlash(__('The dish category has been saved.'));
                    return $this->redirect(array('action' => 'assoindex'));
                }
            } else {
                $options = array('conditions' => array('DishCategory.' . $this->DishCategory->primaryKey => $id));
                $this->request->data = $this->DishCategory->find('first', $options);
            }
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
            $this->DishCategory->id = $id;
            if (!$this->DishCategory->exists()) {
                throw new NotFoundException(__('Invalid dish category'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->DishCategory->delete()) {
                $this->Session->setFlash(__('The dish category has been deleted.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The dish category could not be deleted. Please, try again.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function admin_assodelete($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->DishCategory->id = $id;
            if (!$this->DishCategory->exists()) {
                throw new NotFoundException(__('Invalid dish category'));
            }
            $this->request->allowMethod('post', 'assodelete');
            if ($this->DishCategory->delete()) {
                $this->Session->setFlash(__('The dish category has been deleted.'));
                return $this->redirect(array('action' => 'assoindex'));
            } else {
                $this->Session->setFlash(__('The dish category could not be deleted. Please, try again.'));
                return $this->redirect(array('action' => 'assoindex'));
            }
        }
    }

    public function api_categories(){
        $categories = $this->DishCategory->find('all',array('conditions'=>array('DishCategory.isshow'=>0)));
        if($categories){
            $category_list =array();
            foreach($categories as $category){
                if(!empty($category['DishCategory']['image'])){
                    $category['DishCategory']['image']=FULL_BASE_URL . $this->webroot ."files/catimage/".$category['DishCategory']['image'];
                }
                if(!empty($category['DishCategory']['icon'])){
                    $category['DishCategory']['icon']=FULL_BASE_URL . $this->webroot ."files/caticon/".$category['DishCategory']['icon'];
                }
                $category_list[]=$category;
            }
            
            $response['isSuccess']=true;
            $response['data']=$category_list;
        }else{
            $response['isSuccess']=false;
            $response['msg']="No categories found";
        }
        echo json_encode($response); exit;
    }

}
