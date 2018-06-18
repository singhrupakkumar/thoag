<?php
App::uses('AppController', 'Controller');

class SettingsController extends AppController {
    // RequestHandler for json/xml views
    public $components = array('RequestHandler');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_support');
        //$this->Security->validatePost = false;
    }
    public function api_support(){
        $keys = ['contact_name_1','contact_name_2','contact_designation_1','contact_designation_2','contact_number_1','contact_number_2','facebook_link','twitter_link','google_link','admin_contact_mail','admin_contact_number'];
        $settings = $this->Setting->find('all',array('conditions'=>array(
                'Setting.key'=>$keys
        )));
//        $log = $this->Setting->getDataSource()->getLog(false, false);
//        print_r($log);
        $support = array();
        foreach($settings as $setting){
            $support[$setting['Setting']['key']]=$setting['Setting']['value'];
        }
        if(!empty($support)){
            $response['isSuccess']=true;
            $response['data']=$support;
        }else{
            $response['isSuccess']=false;
            $response['msg']='No data found';
        }
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }
    public function admin_index(){
		configure::write('debug',2);
        if ($this->request->is(array('post', 'put'))) {
            
		$one = $this->request->data['Setting']['blog_banner'];
                $image_nameblog = date('dmHis') . $one['name'];

		    $one1 = $this->request->data['Setting']['faq_banner'];
                    $image_namefaq = date('dmHis') . $one1['name'];
			
		 if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_nameblog;

                    move_uploaded_file($one['tmp_name'], $pth);
                    $this->request->data['Setting']['blog_banner']=$image_nameblog;

                }else{
                    $this->request->data['Setting']['blog_banner']='';
                }
				
				 if ($one1['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_namefaq;

                    move_uploaded_file($one1['tmp_name'], $pth);
                    $this->request->data['Setting']['faq_banner']=$image_namefaq;
                }else{
                    $this->request->data['Setting']['faq_banner']='';
                }
		  
            $data = array();
            foreach ($this->request->data['Setting'] as $setting_key=>$setting_value){
                $this->Setting->updateAll(
                    array('Setting.value' => "'$setting_value'"),
                    array('Setting.key' => $setting_key)
                );
            }
            //if ($this->Setting->saveMany($data)) {
                $this->Session->setFlash(__('Settings updated!','flash_success'));
                return $this->redirect(array('action' => 'index'));
           // }
        }else{  
            $settings = $this->Setting->find('all',array('order'=>'Setting.sort_order ASC'));
            $this->set('settings', $settings);
        }
    }
	 /* public function admin_setting_image(){
		  
		    if ($this->request->is(array('post', 'put'))) {
		     $one = $this->request->data['bimage'];
            $image_nameblog = date('dmHis') . $one['name'];

		    $one1 = $this->request->data['fimage'];
            $image_namefaq = date('dmHis') . $one1['name'];
			
			 $this->Setting->updateAll(
                    array('Setting.value' => "'$image_name'"),
                    array('Setting.key' => $setting_key)
                );
			
		 if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_nameblog;

                    move_uploaded_file($one['tmp_name'], $pth);

                }
				
				 if ($one1['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_namefaq;

                    move_uploaded_file($one1['tmp_name'], $pth);

                }
			}
	}*/
}