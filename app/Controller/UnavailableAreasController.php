<?php
App::uses('AppController', 'Controller');
class UnavailableAreasController extends AppController {
    
     public function beforeFilter() { 
        parent::beforeFilter();
        $this->Auth->allow(array('api_add'));
    }

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','RequestHandler'); 
    
    /*
     * Add unavailable areas
     * parameters: user_id, city, area
     */
    public function api_add(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            $exists = $this->UnavailableArea->find('first',array('conditions'=>array(
                'AND'=>array(
                    'UnavailableArea.user_id'=>$redata->UnavailableArea->user_id,
                    'UnavailableArea.city'=>$redata->UnavailableArea->city,
                    'UnavailableArea.area'=>$redata->UnavailableArea->area,
                    'UnavailableArea.udid'=>$redata->UnavailableArea->udid
                )
            )));
            if($exists){
                $response['isSuccess']=true;
                $response['msg']='You will notify when restaurants are available in this area';
            }else{
                $this->UnavailableArea->create();
                if($this->UnavailableArea->save($redata)){
                    $response['isSuccess']=true;
                    $response['msg']='You will notify when restaurants are available in this area';
                }else{
                    $response['isSuccess']=false;
                    $response['msg']='Some issue occured. Please try again later.';
                }
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']='Some issue occured. Please try again later.';
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    /**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
            if($this->Auth->user('role')!='admin'){
                $this->render('/Pages/unauthorized');
            }else{
		$this->UnavailableArea->recursive = 0;
		$this->set('UnavailableAreas', $this->Paginator->paginate());
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
            if($this->Auth->user('role')!='admin'){
                $this->render('/Pages/unauthorized');
            }else{
		if (!$this->UnavailableArea->exists($id)) {
			throw new NotFoundException(__('Invalid Unavailable Area'));
		}
		$options = array('conditions' => array('UnavailableArea.' . $this->UnavailableArea->primaryKey => $id));
		$this->set('UnavailableArea', $this->UnavailableArea->find('first', $options));
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
		$this->UnavailableArea->id = $id;
		if (!$this->UnavailableArea->exists()) {
			throw new NotFoundException(__('Invalid Unavailable Area'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->UnavailableArea->delete()) {
			$this->Session->setFlash(__('The Unavailable Area has been deleted.'));
		} else {
			$this->Session->setFlash(__('The Unavailable Area could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
            }
	}
}
?>