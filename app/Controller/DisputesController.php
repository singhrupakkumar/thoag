<?php
App::uses('AppController', 'Controller');
class DisputesController extends AppController {
    
    public $components = array('Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    /*
     * Admin Index
     */
    public function admin_index() {
        $this->Dispute->recursive = 2;
         $this->Paginator->settings = array(            
                'Dispute' => array(
                    'limit' => 20,
                    'order'=>'Dispute.id DESC'
                )
            );
        $this->set('disputes', $this->Paginator->paginate());
    }
    
    /**
    * admin_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

	public function admin_view($id = null) {
		if (!$this->Dispute->exists($id)) {
			throw new NotFoundException(__('Invalid staticpage'));
		}
		$options = array('conditions' => array('Dispute.' . $this->Dispute->primaryKey => $id),'recursive'=>2);
		$this->set('Dispute', $this->Dispute->find('first', $options));
	}
        
        /**
        * admin_delete method
        *
        * @throws NotFoundException
        * @param string $id
        * @return void
        */

	public function admin_delete($id = null) {
            $this->Dispute->id = $id;
            if (!$this->Dispute->exists()) {
                    throw new NotFoundException(__('Invalid Dispute'));
            }
            $this->request->allowMethod('post', 'delete');

            if ($this->Dispute->delete()) {
                    $this->Session->setFlash(__('The Dispute has been deleted.'));
            } else {
                    $this->Session->setFlash(__('The Dispute could not be deleted. Please, try again.'));
            }
            return $this->redirect(array('action' => 'index'));
	}
        
        
        //////////////////////////////////
        
            public function add(){
                 configure::write('debug', 0);
                 $uid = $this->Auth->user('id');
                 if($uid==NULL){
                     return $this->redirect('/');
                 } 
             if ($this->request->is('post')) {   
                $msg      = $this->request->data['complaintmsg'];
                $order_id = $this->request->data['order_id'];
             $exist = $this->Dispute->find('first',array('conditions'=>array(
                "AND"=>array(
                    'Dispute.user_id'=>$uid,
                    'Dispute.order_id'=>$order_id
                )
            )
                
                ));
            if($exist){
                $this->Session->setFlash('Already added a Dispute', 'flash_error');
               return $this->redirect('http://' . $this->request->data['server']);
            }else{ 
                $this->request->data['Dispute']['message']= $msg;
                $this->request->data['Dispute']['order_id']= $order_id;
                $this->request->data['Dispute']['user_id']= $uid;
                $this->Dispute->create();
                if($this->Dispute->save($this->request->data)){
                 $this->Session->setFlash('Dispute sent Successfully', 'flash_success');
                  return $this->redirect('http://' . $this->request->data['server']);
                   
                }  else {
                    $this->Session->setFlash('Unable to save', 'flash_error');
                  return $this->redirect('http://' . $this->request->data['server']);
                 
                }
            }
            
                  
              }

             }
    
    public function api_add(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            $exist = $this->Dispute->find('first',array('conditions'=>array(
                "AND"=>array(
                    'Dispute.user_id'=>$redata->Dispute->user_id,
                    'Dispute.order_id'=>$redata->Dispute->order_id
                )
            )
                
                ));
            if($exist){
                $response['isSuccess']=false;
                $response['msg']="Already added a Dispute";
                $response['exist']=$exist;
            }else{
                $this->Dispute->create();
                if($this->Dispute->save($redata)){
                    $response['isSuccess']=true;
                    $response['msg']="Saved Successfully";
                }  else {
                    $response['isSuccess']=false;
                    $response['msg']="Unable to save";
                }
            }
            
        }else{
            $response['isSuccess']=false;
            $response['msg']="Nothing to save";
        }
        
        echo json_encode($response);
        exit;
    }
    /*
     * api_view
     */
    public function api_view(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            $this->Dispute->recursive=2;
            $exist = $this->Dispute->find('first',array('conditions'=>array(
                "AND"=>array(
                    'Dispute.user_id'=>$redata->Dispute->user_id,
                    'Dispute.order_id'=>$redata->Dispute->order_id
                )
                )
                ));
            if($exist){
                if(!empty($exist['Order']['Restaurant']['logo'])){
                    $exist['Order']['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $exist['Order']['Restaurant']['logo']; 
                }
                if(!empty($exist['Order']['Restaurant']['banner'])){
                    $exist['Order']['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $exist['Order']['Restaurant']['banner']; 
                }
                $response['isSuccess']=true;
                $response['msg']="Already added a Dispute";
                $response['data']=$exist;
            }else{
                $response['isSuccess']=false;
                $response['msg']="No Dispute Addes";
            }
            
        }else{
            $response['isSuccess']=false;
            $response['msg']="Nothing to save";
        }
        
        echo json_encode($response);
        exit;
    }
}
?>