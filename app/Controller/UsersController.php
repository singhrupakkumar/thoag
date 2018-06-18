<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email'); 
App::import('Vendor', 'Facebook', array('file' => 'Facebook' . DS . 'facebook.php'));
App::import('Vendor', 'Twitter', array('file' => 'Twitter' . DS . 'twitteroauth.php'));
App::import('Vendor', 'Google', array('file' => 'Google' . DS . 'autoload.php'));

class UsersController extends AppController {

////////////////////////////////////////////////////////////

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'admin_add', 'api_login','api_googlelogin','api_twitterlogin',
                'api_registration','api_resendVerificationCode','api_verifyEmail', 'admin', 'admin_login', 
                'api_contact', 'api_forgetpwd', 'api_trackorder', 'api_addresslist', 'api_resetpwd',
                'api_fblogin', 'walletipn', 'api_wallet', 'api_loginwork','api_refferalCode','facebook_connect');
    }
    public $components = array('RequestHandler');

////////////////////////////////////////////////////////////

    public function admin_login() { 
        Configure::write("debug", 0);
        $this->layout = "admin2";

        // echo AuthComponent::password('admin');

        if ($this->request->is('post')) {
            //echo $this->request->data['User']['server'];exit;
			 $this->Session->write('payfortpaymenton','website');   
            $sesid = $this->Session->id();
            if ($this->Auth->login()) {

                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->loadModel('Cart');
                $updatesess = $this->Session->id();
                $this->Cart->updateAll(array('Cart.sessionid' => "'$updatesess'"), array('Cart.sessionid' => $sesid));
                if ($this->Auth->user('role') == 'customer') {
                    return $this->redirect('http://' . $this->request->data['User']['server']);
                } elseif ($this->Auth->user('role') == 'admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );

                    return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));
                } elseif ($this->Auth->user('role') == 'rest_admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );


                    return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));
                } else {
                    $this->Session->setFlash('Login is incorrect', 'flash_error');
                }
            } else {
                $this->Session->setFlash('Login is incorrect', 'flash_error');
            }
        }
    }

    public function login() {
        // echo AuthComponent::password('admin');

        if ($this->request->is('post')) {
            $this->Session->write('payfortpaymenton','website');   
            //echo $this->request->data['User']['server'];exit; 
            $sesid = $this->Session->id();
        $hashpass = AuthComponent::password($this->request->data['User']['password']);    
       $users = $this->User->find('all', array('conditions' => array('User.username' =>$this->request->data['User']['username'])));
	
       if(empty($users)){
          $response['msg'] = 'User does not Exist';         
       }elseif($hashpass != $users[0]['User']['password']){    
             $response['msg'] = 'Wrong Password'; 
       }elseif($users[0]['User']['active'] ==0){     
             $response['msg'] = 'Invalid User'; 
       }else{      
       if ($this->Auth->login()) { 
                  $uid = $this->Auth->user('id');
                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->loadModel('Cart');
                $updatesess = $this->Session->id();  
                $this->Cart->updateAll(array('Cart.sessionid' => "'$updatesess'",'Cart.uid' => "'$uid'"), array('Cart.sessionid' => $sesid));
                if ($this->Auth->user('role') == 'customer') {
                    
                $response['msg'] = 'Login successfully';  
		$response['server'] = 'http://' . $this->request->data['User']['server'];
                 //return $this->redirect('http://' . $this->request->data['User']['server']); 
                } elseif ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'rest_admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );

                  /*  return $this->redirect(array(
                                'controller' => 'dashboards',
                                'action' => 'dashboard',
                                'manager' => false,
                                'admin' => true
                    ));*/
					
					 $response['msg'] = 'admintrue'; 
                } else {
                   // $this->Session->setFlash('Login is incorrect');
                }
            } else {
                 $response['msg'] = 'Email id or Password  Wrong';   
                //$this->Session->setFlash('Login is incorrect');
            }
            
        } 
        }
         echo json_encode($response);
        exit; 
        
    }

////////////////////////////////////////////////////////////

    public function logout() {
        $this->Session->setFlash('Good-Bye', 'flash_success');
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
         $this->Session->delete('payfortpaymenton'); 
		 $this->Session->delete('ordertype'); 
        return $this->redirect($this->Auth->logout());  
    }

    public function admin_logout() {
        $this->Session->setFlash('Good-Bye', 'flash_success');
		 $this->Session->delete('payfortpaymenton'); 
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
        $this->Auth->logout();
        return $this->redirect('/admin');
    }

////////////////////////////////////////////////////////////

    public function customer_dashboard() {
        
    }

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

    public function admin_index() {
        Configure::write("debug", 0);
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is("post")) {

                //  Array ( [User] => Array ( [search] => aaa ) )
                //  print_r($this->request->data); 
                $keyword = $this->request->data['User']['search'];
                $users = $this->User->find('all', array('conditions' => array('User.username LIKE' => '%' . $keyword . '%')));
            } else {
                $this->Paginator = $this->Components->load('Paginator');
                $this->Paginator->settings = array(
                    'User' => array(
                        'recursive' => -1,
                        'contain' => array(
                        ),
                        'conditions' => array(
                        ),
                        'order' => array(
                            'Users.name' => 'ASC'
                        ),
                        'limit' => 20,
                        'paramType' => 'querystring',
                    )
                );
                $users = $this->Paginator->paginate();
            }
            $this->set(compact('users'));
        }
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException('Invalid user');
            }
            $this->set('user', $this->User->read(null, $id));

            // Multiple Addresses of a User
            $this->loadModel('Address');
            $this->set('addresses',$this->Address->find('all',array('conditions'=>array('Address.user_id'=>$id))));
        }
    }

////////////////////////////////////////////////////////////

    public function admin_resadd() {
        if ($this->request->is('post')) {
            // debug($this->request->data);exit;
            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                $this->Session->setFlash(__('Username already exist!!!', 'flash_error'));
                return $this->redirect(array('action' => 'resadd'));
            }
            $this->User->create();
            $resname = $this->request->data['User']['name'];
            if ($this->User->save($this->request->data)) {
                $this->loadModel('Restaurant');
                $uid = $this->User->getLastInsertID();
                $this->request->data['Restaurant']['status'] = 1;
                $this->request->data['Restaurant']['taxes'] = 0;
                $this->request->data['Restaurant']['user_id'] = $uid;
                $resname = $this->request->data['Restaurant']['name'] = $resname;
                if ($this->Restaurant->save($this->request->data)) {
                    $id = $this->Restaurant->getLastInsertID();
                    $this->loadModel('Tax');
                    $this->request->data['Tax']['tax'] = 0;
                    $this->request->data['Tax']['resid'] = $id;
                    $this->Tax->save($this->request->data);
                    return $this->redirect(array('controller' => 'restaurants', 'action' => 'edit/' . $id . '/' . $uid));
                }
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        }
    }

    public function admin_add() {
//        if($this->Auth->user('role')!='admin'){
//            $this->render('/Pages/unauthorized');
//        }else{
            if ($this->request->is('post')) {
                if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                    $this->Session->setFlash(__('Username already exist!!!', 'flash_error'));
                    return $this->redirect(array('action' => 'add'));
                }
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('The user has been saved', 'flash_success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                }
            }
//        }
    }

    public function add() {
       Configure::write('debug', 0);
  
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = $this->request->data['User']['email'];
            $this->request->data['User']['email'] = $this->request->data['User']['email'];
            $this->request->data['User']['password'] = $this->request->data['User']['password'];
            $this->request->data['User']['gender'] = $this->request->data['User']['gender'];
            $this->request->data['User']['dob'] = $this->request->data['User']['dob'];
            $this->request->data['User']['phone'] = "+9660".$this->request->data['User']['phone'];      
            $encodepass  = base64_encode($this->request->data['User']['password']);
                    
            $this->request->data['User']['md_pass'] = $encodepass;  

            // generate refferal code of a user 
            if(isset($this->request->data['User']['referral_code'])){
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$this->request->data['User']['referral_code']
                        )
                    ));
               // print_r($referral_code_exists); 
               // exit; 
                $this->request->data['User']['used_referral_code'] = $this->request->data['User']['referral_code'];
            }else{
                $this->request->data['User']['used_referral_code'] = '';
            }
            
            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['email']))) {
                
             $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
			if($user['User']['active']== 0){
				
			 $response['msg'] = 'Email_id already exist. Please verify your account for activation.';    
			 $response['user_id'] = $user['User']['id']; 
                        	 
			}else{ 
			$response['msg'] = 'Email_id already exist';	
			}   
                
                
            } else {
                if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){  
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Invalid refferal code';
                }else{
                    $this->User->create();  
                    $verification_code = rand(111111111,999999999);
                    $this->request->data['User']['verification_code'] = $verification_code;
                    $this->request->data['User']['role'] = 'customer';
                    $this->request->data['User']['active'] = 0;

                    if ($this->User->save($this->request->data)) {
                        // generate refferal code
                        $user_id = $this->User->getLastInsertID();
                        $user_referral_code =  substr($this->request->data['User']['username'],0,3).rtrim(strtr(base64_encode($user_id), '+/', '-_'), '='); 
                        $this->User->id = $this->User->getLastInsertID();
                        $this->User->saveField('referral_code', $user_referral_code);

                        $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                                to($this->request->data['User']['email'])->send($ms);

                        $response['isSuccess'] = true;
                        $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account.';
                        $response['user_id']=$this->User->getLastInsertID();
                        
                    } else {
                        $response['isSuccess'] = false;
                        $response['msg'] = 'Sorry please try again';
                    }
                }
            }
        } else {

            $response['msg'] = 'Sorry please try again';
        }
        echo json_encode($response);
        exit;
    }
    
	
	///////////////////////////////////////////
	
	
	 public function catereradd() {
       Configure::write('debug', 0);
	   
	          $this->loadModel('Setting');
           $setting = $this->Setting->find('all');
			$email_to =  $setting[2]['Setting']['value'];
  
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = $this->request->data['User']['email'];
            $this->request->data['User']['email'] = $this->request->data['User']['email'];
            $this->request->data['User']['password'] = $this->request->data['User']['password'];
            $this->request->data['User']['gender'] = $this->request->data['User']['gender'];
            $this->request->data['User']['dob'] = $this->request->data['User']['dob'];
            $this->request->data['User']['phone'] = "+9660".$this->request->data['User']['phone'];      
            $encodepass  = base64_encode($this->request->data['User']['password']);
                    
            $this->request->data['User']['md_pass'] = $encodepass;  

            // generate refferal code of a user 
    
            
            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['email']))) {
                
             $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
			if($user['User']['active']== 0){
				
			 $response['msg'] = 'Email_id already exist. Please verify your account for activation.';    
			 $response['user_id'] = $user['User']['id']; 
                        	 
			}else{ 
			$response['msg'] = 'Email_id already exist';	
			}   
                
                
            } else {
              
                    $this->User->create();  
                    $verification_code = rand(111111111,999999999);
                    $this->request->data['User']['verification_code'] = $verification_code;
                    $this->request->data['User']['role'] = 'rest_admin';
                    $this->request->data['User']['active'] = 0;

                    if ($this->User->save($this->request->data)) {
                        // generate refferal code
                        $user_id = $this->User->getLastInsertID();
                        $user_referral_code =  substr($this->request->data['User']['username'],0,3).rtrim(strtr(base64_encode($user_id), '+/', '-_'), '='); 
                        $this->User->id = $this->User->getLastInsertID();
                        $this->User->saveField('referral_code', $user_referral_code);

                        $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                                to($this->request->data['User']['email'])->send($ms);
								
						 $ms1 = "New Caterer Request!
						 User with below Email address has requested to be a Caterer on Thoag. Please check details from Admin Panel.
                             <b>User Email: ".$this->request->data['User']['email']." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Request Join as Caterer')->
                                to($email_to)->send($ms1); 		

                        $response['isSuccess'] = true;
                        $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account.';
                        $response['user_id']=$this->User->getLastInsertID();
                        
                    } else {
                        $response['isSuccess'] = false;
                        $response['msg'] = 'Sorry please try again';
                    }
              
            }
        } else {

            $response['msg'] = 'Sorry please try again';
        }
        echo json_encode($response);  
        exit;
    }
    
    /////////////////////////////////////
    
     public function resendVerificationCode(){ 
        if($this->request->is('post')){
            $verification_code = rand(111111111,999999999);
//            $this->request->data['User']['verification_code'] = $verification_code;
            $this->User->id=$this->request->data['user_id'];
            $this->User->saveField('verification_code',$verification_code);
            $user = $this->User->find("first",array("conditions"=>array("User.id"=>$this->request->data['user_id'])));
            if($user){
                $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." " 
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Resend Verification Code!!!')->
                                to($user['User']['email'])->send($ms);
                        $response['isSuccess'] = true;
                $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account';
                $response['user_id']=$this->request->data['user_id'];    
            }else{
                $response['isSuccess']=false;
                $response['msg'] = 'Sorry please try again';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg'] = 'Post method required';
        }
        echo json_encode($response);
        exit;
    }
    
    ////////////////////////////////
    public function verifyEmail(){
        if($this->request->is('post')){
            $exist = $this->User->find("first",array('conditions'=>array(
                "AND"=>array(
                    'User.id'=>$this->request->data['user_id'],
                    'User.verification_code'=>$this->request->data['verification_code'],
                    'User.active'=>0
                )
            )));
            if($exist){
                //            print_r($this->request->data); exit;
				
		if($exist['User']['role']== 'rest_admin'){
				 $updated = $this->User->updateAll(array('User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
					  $response['msg']="Your account Verified Successfully Please wait for admin responce"; 			
					
				}else{
				
                $updated = $this->User->updateAll(array('User.active'=>1,'User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
                
                if($updated){
                    $user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['user_id'])));
                    $response['isSuccess']=true;
                        $pass = $user['User']['md_pass'];  
                     $decodepass = base64_decode($pass); 
                     $this->request->data['User']['username'] = $user['User']['username']; 
                     $this->request->data['User']['password'] = $decodepass;  
                    
                      $this->Auth->login(); 
                    $response['msg']="Your account Verified Successfully Welcome to Thoag"; 
                    
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Please verify account with valid verification code. Unable to verify";
                }
				
			}	
            }else{
                $response['isSuccess']=false;
                $response['msg']="Please verify account with valid verification code.";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Only Post Method is allowed";
        }
        echo json_encode($response);
        exit;
    }

    
    ///////////////////////////////////

    public function forgetpwd() { 
        Configure::write("debug", 0);
        $this->User->recursive = -1;
        if (!empty($this->data)) {
            if (empty($this->data['User']['username'])) {
                $this->Session->setFlash('Please Provide your Email Address that you used while Registration.', 'flash_error');
            } else {
                $username = $this->data['User']['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));

                if ($fu['User']['email']) { 
                    if ($fu['User']['active'] == "1") {
                        $key = Security::hash(CakeText::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = '<p>Click the Link below to reset your password.</p><br /><a href="'.$url.'">'
                                . '<button type="button" style="background:none; border:none; height:35px; padding:0px; display:inline-block; padding:0px 15px; background-color:#CC0000; color:#fff;" border-radius:4px;>Reset Password</button></a>';
                        $fu['User']['tokenhash'] = $key;  
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                            
     
                            
                            $l = new CakeEmail('smtp');     
                            $l->emailFormat('html')->template('forgot')->subject('Reset Your Password')
                                     ->viewVars(array('link' => $url)) 
                                    ->viewVars(array('user' => $fu)) 
                                    ->to($fu['User']['email'])->send();
                            
              /*   $email->from('restaurants@test.com')
                ->cc('ashutosh@avainfotech.com')
                  ->to($fu['User']['email'])
                  ->subject('Reset Your Password')
                   ->template('order')
                   ->emailFormat('text')
                  ->viewVars(array('shop' => $order))
                    ->send();
                            */
                            
                            $this->set('smtp_errors', "none");
         
                             $this->Session->setFlash('Check Your Email to reset your password.', 'flash_success');
                          
                            $this->redirect(array('controller' => 'products', 'action' => 'index'));  
                        } else {
                            $this->Session->setFlash("Error Generating Reset link", 'flash_error'); 
                        }
                    } else { 
                        $this->Session->setFlash('This Account is not Active yet. Check Your mail to activate it.', 'flash_error');
                    }
                } else { 
                    $this->Session->setFlash('Email Address does not Exist.', 'flash_error');
                }
            }
        }
    }

    public function reset($token = null) {
        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...", 'flash_error');
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated', 'flash_success');
                            $this->redirect(array('controller' => 'Products', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else { 
                $this->Session->setFlash('Token Corrupted. Please Retry, the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">works</a> only for once.', 'flash_error');
            }
        } else {
            $this->Session->setFlash('Pls try again...', 'flash_error');
            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    } 

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        Configure::write("debug", 0);
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }

        // get saved page permissions
        $this->loadModel('Userpermission');
        $AuthPermission = $this->Userpermission->find('first', array('conditions' => array('Userpermission.user_id' => $id)));
        if ($AuthPermission) {
            $authorized_pages = unserialize($AuthPermission['Userpermission']['view_pages']);
            $this->set('authorized_pages', $authorized_pages);
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $view_pages = serialize($this->request->data['Userpermission']['view_pages']);
            $dataprm = array('user_id' => $id, 'view_pages' => $view_pages);

            if ($this->User->save($this->request->data)) {
                $cnt = $this->Userpermission->find('count', array('conditions' => array('Userpermission.user_id' => $id)));
                if ($cnt < 1) {
                    $this->Userpermission->save($dataprm);
                } else {
                    $this->Userpermission->updateAll(
                            array('view_pages' => "'$view_pages'"), array('user_id' => $id)
                    );
                }
                $this->Session->setFlash('The user has been saved', 'flash_success');

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }
    
    /*
     * Edit Profile
     */
    public function admin_myaccount() {
        Configure::write("debug", 2);
        $id=$this->Auth->User('id');
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }

        // get saved page permissions
        

        if ($this->request->is('post') || $this->request->is('put')) {
            
            $image = $this->request->data['User']['image'];
            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
               
                $full_image_path = $uploadPath . DS . $imageName;
              // $img = Router::url('/', true)."files/profile_pic/".$imageName;
                
                move_uploaded_file($image['tmp_name'], $full_image_path);  
                $this->request->data['User']['image']=$imageName;
            }else{
                $user = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
                $this->request->data['User']['image']=$user['User']['image'];
            }

            if ($this->User->save($this->request->data)) {
                
                $this->Session->setFlash('The user has been saved', 'flash_success');

                return $this->redirect(array('controller'=>'orders','action' => 'myaccount'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        } else {
            $this->request->data=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
        }
    }

    public function edit() {
        $id = $this->Auth->user('id');
        $this->User->id = $this->Auth->user('id');
        if (!$this->User->exists($id)) {
            return $this->redirect(array('action' => 'myaccount'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $email = $this->Auth->user('email');
            $username = $this->Auth->user('username');
            if (($email == $this->request->data['User']['email']) && ($username == $this->request->data['User']['username'])) {
                 $this->request->data['User']['phone'] = "+9660".$this->request->data['User']['phone'];  
                if ($this->User->save($this->request->data)) {
                   $this->Session->setFlash('Your profile has been Updated.', 'flash_success');  
                   
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                      $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                  
                }
            } else if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
                $this->Session->setFlash('Email already exist!', 'flash_error'); 
               
                return $this->redirect(array('action' => 'edit'));
            } else if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                $this->Session->setFlash('Username already exist!', 'flash_error');
                
                return $this->redirect(array('action' => 'edit'));
            } else {
                 $this->request->data['User']['phone'] = "+9660".$this->request->data['User']['phone'];    
                if ($this->User->save($this->request->data)) {
                     $this->Session->setFlash('Your profile has been Updated.', 'flash_success');
                    
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                    $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
                
                }
            }
        } else {   
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $data = $this->request->data = $this->User->find('first', $options);
            $this->set('data', $data);
        } 
        
        $this->loadModel('Address');
       $useraddress= $this->Address->find('all',array('conditions'=> array('Address.user_id'=>$id)));       
        $this->set('addressdata', $useraddress); 
    }

////////////////////////////////////////////////////////////

    public function admin_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved', 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_error');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->request->is('post')) {
                throw new MethodNotAllowedException();
            }
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException('Invalid user');
            }
            if ($this->User->delete()) {
                $this->Session->setFlash('User deleted', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('User was not deleted', 'flash_error');
            return $this->redirect(array('action' => 'index'));
        }
    }
    /**
     * 
     * @param type $id
     */
    public function admin_activate($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;

            if ($this->User->exists()) {
                $x = $this->User->save(array(
                    'User' => array(
                        'active' => '1'
                    )
                ));
                $this->Session->setFlash(__("Activated successfully."));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__("Unable to activate."));
                $this->redirect($this->referer());
            }
        }
    }

    /**
     * 
     * @param type $id
     */
    public function admin_deactivate($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->User->id = $id;
            if ($this->User->exists()) {
                $x = $this->User->save(array(
                    'User' => array(
                        'active' => '0'
                    )
                ));
                $this->Session->setFlash(__("Deactivated successfully."));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__("Unable to Deactivated."));
                $this->redirect($this->referer());
            }
        }
    }

////////////////////////////////////////////////////////////
     public function api_loginwork() {
         configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
        $username = $redata->User->username;
        $password = $redata->User->password;
        $this->request->data['User']['username'] = $username;
        //$this->request->data['email'];        
        $this->request->data['password'] = $password;
        if ($redata) {
            
            $password_hash = AuthComponent::password($password);
            $check = $this->User->find('first', array('conditions' => array(
                "AND"=>array(
                    "User.username" => $this->request->data['User']['username'],
                    "User.password"=>$password_hash,
                    //"User.active"=>1
                )
                ), 'recursive' => '-1'));
            if($check){
                if($check['User']['active']==1){
                    $this->loadModel('Cart');
                     $this->Cart->updateAll(
                        array('Cart.uid'=>$check['User']['id']),
                        array('Cart.sessionid'=>$redata->User->session_id)
                        );
                    
                
                
                    if(isset($redata->User->device_uuid)){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$redata->User->device_uuid)));
                        if($exist){
                             $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$check['User']['id'])
                                );

                        }else{
                           // $response['device1']=$exist;
                        }
                    }
                    
                    if ($check['User']['image'] != '') {
                        if (!filter_var($check['User']['image'], FILTER_VALIDATE_URL) === false) {
                            $check['User']['image'] = $check['User']['image'];
                        } else {
                            $check['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $check['User']['image'];
                        }

                    } else {
                        $check['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    $response['status'] = true;
                    $response['msg'] = 'You have successfully logged in';
                    $response['data'] = $check;
                }else{
                    $response['status'] = false;
                    $response['verified']=  false;
                    $response['msg'] = 'Email is Registered but not Verified!';
                    $response['user_id']=$check['User']['id'];
                }
            }else{
                $response['status'] = false;
                $response['msg'] = 'User is not valid';
            }
//                $this->request->data['User']['username'] = $this->request->data['User']['username'];
//                $this->request->data['User']['password'] = $password;
//                if (!$this->Auth->login()) {
//                    $response['status'] = false;
//                    $response['msg'] = 'User is not valid';
//                } else {
//                    $user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id'))));
//                    $response['status'] = true;
//                    $response['msg'] = 'You have successfully logged in';
//                    $response['id'] = $user['User']['id'];
//                    $response['name'] = $user['User']['name'];
//                    $response['data'] = $user;
//                }
            }
        echo json_encode($response);
        exit;
    }

    /*
    * get refferal code for a user
    */
    public function api_refferalCode(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $user_id = $redata->user_id;
        if($user_id){
            $user = $this->User->find('first',array("conditions"=>array('User.id'=>$user_id)));
            if($user){
                $response['status'] = true;
                $response['data'] = $user;
            }else{
                $response['status'] = false;
                $response['msg'] = 'User is not valid';
            }
        }else{
            $response['status'] = false;
            $response['msg'] = 'User is not valid';
        }
        echo json_encode($response);
        exit;
    }

    public function api_login() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $this->request->data['User']['username'] = $this->request->data['email'];
        $pass = $this->request->data['password'];
        if ($this->request->is('post')) {
            $check = $this->User->find('first', array('conditions' => array(
                    "User.username" => $this->request->data['User']['username']
                ), 'fields' => array('username'), 'recursive' => '-1'));


            $this->request->data['User']['username'] = $check['User']['username'];
            $this->request->data['User']['password'] = $pass;

            if (!$this->Auth->login()) {


                $response['msg'] = 'User is not valid';
            } else {
                $user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id'))));

                $response['status'] = true;
                $response['msg'] = 'You have successfully logged in';
                $response['id'] = $user['User']['id'];
                $response['name'] = $user['User']['name'];
            }
        }

        echo json_encode($response);
        exit;
    }

    public function api_registration() {
        Configure::write('debug', 2);
        $this->layout = 'ajax';
        ob_start();
        $this->layout = 'ajax';
        ob_start();
        print_r($this->request->data);
        print_r(gettype($this->request->data));
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = $this->request->data['email'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            $this->request->data['User']['password'] = $this->request->data['password'];
            $this->request->data['User']['gender'] = $this->request->data['gender'];
            $this->request->data['User']['dob'] = $this->request->data['dob'];
            $this->request->data['User']['phone'] = $this->request->data['phone'];

            // generate refferal code of a user 
            if(isset($this->request->data['referral_code'])){
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$this->request->data['referral_code']
                        )
                    ));
               // print_r($referral_code_exists); 
               // exit; 
                $this->request->data['User']['used_referral_code'] = $this->request->data['referral_code'];
            }else{
                $this->request->data['User']['used_referral_code'] = '';
            }
            
            if ($this->User->hasAny(array(
                        'OR' => array('User.username' => $this->request->data['User']['username'], 'User.email' => $this->request->data['User']['username'])
                    ))) {
                $response['msg'] = 'Email_id already exist';
                $response['isSuccess'] = false;
            } else {
                if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Invalid refferal code';
                }else{
                    $this->User->create();
                    $verification_code = rand(11111,99999);
                    $this->request->data['User']['verification_code'] = $verification_code;
                    $this->request->data['User']['role'] = 'customer';
                    $this->request->data['User']['active'] = 0;

                    if ($this->User->save($this->request->data)) {
                        // generate refferal code
                        $user_id = $this->User->getLastInsertID();
                        $user_referral_code =  substr($this->request->data['User']['username'],0,3).rtrim(strtr(base64_encode($user_id), '+/', '-_'), '='); 
                        $this->User->id = $this->User->getLastInsertID();
                        $this->User->saveField('referral_code', $user_referral_code);

                        $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                                to($this->request->data['User']['email'])->send($ms);

                        $response['isSuccess'] = true;
                        $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account';
                        $response['user_id']=$this->User->getLastInsertID();
                        
                    } else {
                        $response['isSuccess'] = false;
                        $response['msg'] = 'Sorry please try again';
                    }
                }
            }
        } else {

            $response['msg'] = 'Sorry please try again';
        }
        echo json_encode($response);
        exit;
    }
    public function api_resendVerificationCode(){
        if($this->request->is('post')){
            $verification_code = rand(11111,99999);
//            $this->request->data['User']['verification_code'] = $verification_code;
            $this->User->id=$this->request->data['user_id'];
            $this->User->saveField('verification_code',$verification_code);
            $user = $this->User->find("first",array("conditions"=>array("User.id"=>$this->request->data['user_id'])));
            if($user){
                $ms = "Welcome to Thoag 
                             <b>Verfication Code is: ".$verification_code." "
                                . "</b><br/>";
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Resend Verification Code!!!')->
                                to($user['User']['email'])->send($ms);
                        $response['isSuccess'] = true;
                $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account';
                $response['user_id']=$this->request->data['user_id'];    
            }else{
                $response['isSuccess']=false;
                $response['msg'] = 'Sorry please try again';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg'] = 'Post method required';
        }
        echo json_encode($response);
        exit;
    }
    public function api_verifyEmail(){
        if($this->request->is('post')){
            $exist = $this->User->find("first",array('conditions'=>array(
                "AND"=>array(
                    'User.id'=>$this->request->data['user_id'],
                    'User.verification_code'=>$this->request->data['verification_code'],
                    'User.active'=>0
                )
            )));
            if($exist){
                //            print_r($this->request->data); exit;
                $updated = $this->User->updateAll(array('User.active'=>1,'User.verification_code'=>NULL),
                        array('User.id'=>$this->request->data['user_id'],'User.verification_code'=>$this->request->data['verification_code'],'User.active'=>0)
                        );
                if($updated){
                    $user=$this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['user_id'])));
                     $this->loadModel('Cart');

                    $data_exist_withId = $this->Cart->find('all',array('conditions'=>array('AND'=>array(
                        'Cart.uid'=>$user['User']['id']
                    ))));
                    
                     $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'])
                        );
                    
                
                
                    if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data["device_uuid"])));
                        if($exist){
                             $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );

                        }else{
                           // $response['device1']=$exist;
                        }
                    }
                    
                    if ($user['User']['image'] != '') {
                        if (!filter_var($user['User']['image'], FILTER_VALIDATE_URL) === false) {
                            $user['User']['image'] = $user['User']['image'];
                        } else {
                            $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                        }

                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    
                    
                    $response['isSuccess']=true;
                    $response['msg']="Verified Successfully";
                    $response['data']=$user;
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Please verify account with valid verification code. Unable to verify";
                }
            }else{
                $response['isSuccess']=false;
                $response['msg']="Please verify account with valid verification code.";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Only Post Method is allowed";
        }
        echo json_encode($response);
        exit;
    }

////////////////////////////////////////////////////
//      public function api_login() {
//
//        // echo AuthComponent::password('admin');
//
//        if ($this->request->is('post')) {
//            if ($this->Auth->login()) {
//
//                $this->User->id = $this->Auth->user('id');
//                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
//                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
//
//                if ($this->Auth->user('role') == 'customer') {
//                    return $this->redirect(array(
//                                'controller' => 'users',
//                                'action' => 'dashboard',
//                                'customer' => true,
//                                'admin' => false
//                    ));
//                } elseif ($this->Auth->user('role') == 'admin') {
//                    $uploadURL = Router::url('/') . 'app/webroot/upload';
//                    $_SESSION['KCFINDER'] = array(
//                        'disabled' => false,
//                        'uploadURL' => $uploadURL,
//                        'uploadDir' => ''
//                    );
//                    return $this->redirect(array(
//                                'controller' => 'users',
//                                'action' => 'dashboard',
//                                'manager' => false,
//                                'admin' => true
//                    ));
//                } else {
//                    $this->Session->setFlash('Login is incorrect');
//                }
//            } else {
//                $this->Session->setFlash('Login is incorrect');
//            }
//        }
//    }
    /* -------------------------------------------------------Webservice--------------------------------------------- */

//    public function api_login() {
//
//
//        configure::write('debug', 0);
//
//
//        $this->User->recursive = -1;
//
//        $this->layout = 'ajax';
//
//        ob_start();
//
//        echo var_dump($this->request->data);
//
//        $c = ob_get_clean();
//
//        $fc = fopen('files' . DS . 'detail.txt', 'w');
//
//        fwrite($fc, $c);
//
//        fclose($fc);
////
////         $this->request->data['User']['email']="admin@gmail.com";
////         $this->request->data['User']['password']="admixxn";
//
//        if ($this->request->is('post')) {
//
//            $check = $this->User->find('first', array('conditions' => array(
//                    "OR" => array(
//                        "User.username" => $this->request->data['User']['email']
//                        , "User.email" => $this->request->data['User']['email']
//                    )
//                ), 'fields' => array('username'), 'recursive' => '-1'));
//
//            $this->request->data['User']['username'] = $check['User']['username'];
//
//            if (!$this->Auth->login()) {
//
//                $response['isSucess'] = 'false';
//
//                $response['msg'] = 'Email ID or password is  incorrect';
//            } else {
//
//                $user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id'))));
//                $array = array("www", "com", "http", "https");
//
//
//                if ($this->strposa($user['User']['image'], $array)) {
//                    $user['User']['image'];
//                } else {
//                    $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
//                }
//
//                if ($user['User']['status'] == 0) {
//
//                    $response['isSucess'] = 'false';
//
//                    $response['msg'] = 'You have still not verified your Email ID';
//                } else {
//
//                    $this->User->id = $user['User']['id'];
//
//                    $this->User->saveField('device_token', $this->request->data['User']['device_token']);
//                    $this->User->saveField('plateform', $this->request->data['User']['plateform']);
//                    $this->User->saveField('latitude', $this->request->data['User']['latitude']);
//                    $this->User->saveField('longitude', $this->request->data['User']['longitude']);
//
//                    $response['isSucess'] = 'true';
//
//                    $response['data'] = $user;
//                }
//            }
//        }
//
//        $this->set('response', $response);
//
//        $this->render('ajax');
//    }

    public function api_chekdata() {


        configure::write('debug', 0);




        $this->layout = 'ajax';

        ob_start();

        var_dump($this->request->data);

        $c = ob_get_clean();

        $fc = fopen('files' . DS . 'detail.txt', 'w');

        fwrite($fc, $c);

        fclose($fc);

        exit;
    }

    public function api_logout() {


        configure::write('debug', 0);
        $this->layout = 'ajax';

        if ($this->request->is('post')) {

            $this->User->id = $this->request->data[User][id];

            $this->Auth->logout();

            //$this->Cookie->delete('User');

            $response['isSucess'] = 'true';

            $response['msg'] = "Logout Successfully";
        }

        $this->set('response', $response);

        $this->render('ajax');
    }

//    public function api_registration() {
//        //   $this->request->data['User']['email']="ashutosh@netsmartx.net";
//        // $this->request->data['User']['email']="ashutoshaa@avainfotech.com";
//        //   $this->request->data['User']['password']="ashu";
//
//        Configure::write('debug', 0);
//
//
//        $this->layout = 'ajax';
//
//        ob_start();
//
//        print_r($this->request->data);
//
//        $c = ob_get_clean();
//
//        $fc = fopen('files' . DS . 'detail.txt', 'w');
//
//        fwrite($fc, $c);
//
//        fclose($fc);
//
//
//        $this->request->data['User']['username'] = $this->request->data['User']['email'];
//
//        if ($this->request->is('post')) {
//
//            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
//
//                $response['isSucess'] = 'false';
//
//                $response['msg'] = 'Email ID already exist';
//            } else {
//
//                if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
//
//                    $response['isSucess'] = 'false';
//
//                    $response['msg'] = 'Email ID already exist';
//                } else {
//
//                    $this->User->create();
//
//                    $this->request->data['User']['role'] = 'user';
//                    $this->request->data['User']['status'] = 0;
//
//                    if ($this->User->save($this->request->data)) {
//
//                        $verify_id = base64_encode($this->User->getLastInsertID());
//                        $url = FULL_BASE_URL . $this->webroot . "api/users/verify/" . $verify_id;
//                        $ms = "Welcome to Mobile 
//                             <b><a href='" . $url . "' style='text-decoration:none'>Click to verify your email.</a></b><br/>";
//                        $l = new CakeEmail('smtp');
//                        $l->emailFormat('html')->template('default', 'default')->subject('Registration Successfully!!!')->
//                                to($this->request->data['User']['email'])->send($ms);
//
//                        $response['isSucess'] = 'true';
//
//                        $response['msg'] = 'Register successfully';
//                    } else {
//
//                        $response['isSucess'] = 'false';
//
//                        $response['msg'] = 'Sorry please try again';
//                    }
//                }
//            }
//        }
//
//        $this->set('response', $response);
//
//        $this->render('ajax');
//    }

    public function api_editprofile() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->User->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {
            $id = $redata->user->id;
            $name = $redata->user->name;
            $phone = $redata->user->phone;
            $address = $redata->user->address;
            $city = $redata->user->city;
            $state = $redata->user->state;
            $country = $redata->user->country;
            $zip = $redata->user->zip;
            $dob = $redata->user->dob;
            $gender= $redata->user->gender;
            $email = $redata->user->email;
            if(isset($email)){
                $email_exist = $this->User->find('first',array('conditions'=>array('User.email'=>$email)));
                if($email_exist){
                    if($email_exist['User']['id']==$id){
                        // update data
                        $data = $this->User->updateAll(array(
                            'User.phone' => "'$phone'", 
                            'User.name' => "'$name'",
                            'User.address' => "'$address'",
                            'User.city' => "'$city'",
                            'User.state' => "'$state'",
                            'User.country' => "'$country'",
                            'User.zip' => "'$zip'",
                            'User.gender'=>"'$gender'",
                            'User.dob'=>"'$dob'",
                            'User.email'=>"'$email'"
                            ), array('User.id' => $id));
                    }else{
                        // display error
                        $response['msg'] = "Email Already Exists!";
                        $response['isSuccess'] = false;
                    }
                }else{
                    // update data
                    $data = $this->User->updateAll(array(
                            'User.phone' => "'$phone'", 
                            'User.name' => "'$name'",
                            'User.address' => "'$address'",
                            'User.city' => "'$city'",
                            'User.state' => "'$state'",
                            'User.country' => "'$country'",
                            'User.zip' => "'$zip'",
                            'User.gender'=>"'$gender'",
                            'User.dob'=>"'$dob'",
                            'User.email'=>"'$email'"
                            ), array('User.id' => $id));
                }
            }
            
            if ($data) {
                $user = $this->User->find("first",array('conditions'=>array('User.id'=>$id)));
                //print_r($user);
                if ($user['User']['image'] != '') {
                    if (!filter_var($user['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $user['User']['image'] = $user['User']['image'];
                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $response['data'] = $user;
                $response['isSuccess'] = true;
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_user() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->User->recursive = 2;
        $this->layout = "ajax";

        if (!empty($redata)) {
            $id = $redata->user->id;
            $data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            if ($data['User']['image'] != '') {
                    if (!filter_var($data['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $data['User']['image'] = $data['User']['image'];
                    } else {
                        $data['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $data['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $data['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
            if ($data) {
                $response['isSuccess'] = true;
                $response['data'] = $data;
            } else {

                $response['isSuccess'] = 'false';

                $response['msg'] = 'Sorry There are no data';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_alluser() {

        $this->layout = 'ajax';

        $resp = $this->User->find('all', array('conditions' => array(
                "User.status" => 1
            ), 'recursive' => '-1'));

        if ($resp) {

            $response['isSucess'] = 'true';

            $response['msg'] = 'Success';

            $response['data'] = $resp;
        } else {

            $response['isSucess'] = 'false';

            $response['msg'] = 'Sorry there are no data';
        }

        $this->set('response', $response);

        $this->render('ajax');
    }

    public function changepassword() {

        if ($this->request->is('post')) {
            $password = AuthComponent::password($this->data['User']['old_password']);
            $em = $this->Auth->user('username');
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.username' => $em))));
            if ($pass) {
                if ($this->data['User']['new_password'] != $this->data['User']['cpassword']) {
                    
                    $this->Session->setFlash('New password and Confirm password fields donot match.', 'flash_error'); 
                   
                } else {
                    $this->User->data['User']['password'] = $this->data['User']['new_password'];
                    $this->User->id = $pass['User']['id'];
                    if ($this->User->exists()) {
                        $pass['User']['password'] = $this->data['User']['new_password'];
                        if ($this->User->save()) {
                             $this->Session->setFlash('Password has been Updated.', 'flash_success'); 
                           
                            $this->redirect(array('controller' => 'Users', 'action' => 'myaccount'));
                        }
                    }
                }
            } else { 
               $this->Session->setFlash('Your old password donot match.', 'flash_error'); 
                  
            } 
        }
    }

    public function api_forgetpwd() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $username = $redata->User->username;
        $this->User->recursive = -1;
        if (empty($redata)) {
            $response['isSucess'] = 'false';
            $response['msg'] = 'Please Provide Your Username that You used to register with us';
        } else {
            $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));
            if ($fu['User']['email']) {
                if ($fu['User']['active'] == "1") {
                    $key = Security::hash(CakeText::uuid(), 'sha512', true);
                    $hash = sha1($fu['User']['email'] . rand(0, 100));
                    $url = Router::url(array('controller' => 'users', 'action' => 'api_resetpwd'), true) . '/' . $key . '#' . $hash;
                    $ms = "Welcome to Mobile
      <b><a href='" . $url . "' style='text-decoration:none'>Click here to reset your password.</a></b><br/>";
                    $fu['User']['tokenhash'] = $key;
                    $this->User->id = $fu['User']['id'];
                    if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')
                                ->to($fu['User']['email'])->send($ms);
                        $response['isSucess'] = 'true';
                        $response['msg'] = 'Check Your Email ID to reset your password';
                    } else {
                        $response['isSucess'] = 'false';
                        $response['msg'] = 'Error Generating Reset link';
                    }
                } else {
                    $response['isSucess'] = 'false';
                    $response['msg'] = 'This Account is still not Active .Check Your Email ID to activate it';
                }
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = 'Email ID does Not Exist';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_verify($id = null) {


        Configure::write('debug', 2);

        $id = base64_decode($id);

        $this->User->id = $id;

        $arr1 = $this->User->query("update `users` set `active`='1' where `id`=$id");

        $this->Session->setFlash(__('Congratulations your account has been verified!!! Now you can login!!! ', 'flash_success'));

        return $this->redirect('/');
    }

    public function api_resetpwd($token = null) {

        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {

                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {

                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...", 'flash_success');
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated', 'flash_success');
                           // $this->redirect(array('controller' => 'products', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {

                $this->Session->setFlash('Token Corrupted, Please Retry.the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
            }
        } else {
            $this->Session->setFlash('Pls try again...');
           // $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    }

    /**
     * facebook login
     */
    public function api_fblogin() {

        Configure::write('debug', 2);
        $this->layout = "ajax";
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            ob_start();
            print_r($this->request->data);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);
            $this->request->data['User']['username'] = $this->request->data['email'];
            $this->request->data['User']['name'] = $this->request->data['name'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            $this->request->data['User']['fb_id'] = $this->request->data['facebook_id'];
            if (!$this->User->hasAny(array(
                        'OR' => array('User.username' => $this->request->data['User']['email'], 'User.email' => $this->request->data['User']['email'])
                    ))) {
                $this->request->data['User']['image']=$this->request->data['image'];
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['status'] = 1;
                if ($this->User->save($this->request->data)) {
                    $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['email'])));
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                     if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    $response['isSucess'] = 'true';
                    $response['data'] = $user;
                } else {
                    $response['isSucess'] = 'false';
                    $response['msg'] = 'Sorry please try again';
                }
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['email'])));
                
                if($user['User']['fb_id']!=''){
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                     if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    if($user['User']['image']== ""){
                        $image=$this->request->data['image'];
                        $this->User->updateAll(
                                array('User.image'=>"'".$image."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                    }
                    
                    $response['isSucess'] = 'true';
                    $response['data'] = $user;
                }else{
                    $response['isSucess']='false';
                    $response['msg']='This email is already registered.';
                }
                //$this->User->id = $user['User']['id'];
                // $this->User->saveField('image', $this->request->data['User']['image']);
                //$response['isSucess'] = 'true';
                //$response['data'] = $user;
            }
        }
        $this->set('response', $response);
        $this->render('ajax');
    }
    /**
     * twitter login
     * parameters: user_id, screen_name
     */
    
        /**
     * facebook login
     */
    public function fblogin() { 

        Configure::load('facebook');
        $appId = Configure::read('Facebook.appId');
        $app_secret = Configure::read('Facebook.secret');
        $facebook = new Facebook(array(
            'appId' => $appId,
            'secret' => $app_secret,
        ));

        $loginUrl = $facebook->getLoginUrl(array(
            'scope' => 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
            'redirect_uri' => 'http://rajdeep.crystalbiltech.com/thoag/users/facebook_connect',  
            'display' => 'popup'
        ));
        $this->redirect($loginUrl); 
    }
    
    
    
    ////////////////////////////////////////////////////////////

    public function facebook_connect() {    
 
      configure::write('debug',0);
        Configure::load('facebook');
        $appId = Configure::read('Facebook.appId');
        $app_secret = Configure::read('Facebook.secret'); 

        $facebook = new Facebook(array(
            'appId' => $appId,
            'secret' => $app_secret,
        ));

        $user = $facebook->getUser();
		
        if ($user) { 
			$this->Session->write('payfortpaymenton','website');
            try {
                $user_profile = $facebook->api('/me?fields=id,email,name,picture');
         
             $imgurl ='https://graph.facebook.com/'.$user_profile["id"].'/picture?width=320&height=320' ;  
             echo "<script>window.close()</script>";
				
               if ($user_profile['email'] == '') {
                        $user_profile['email'] = $user_profile['id'] . '@facebook.com';
                    } 
                
            $this->request->data['User']['username'] = $user_profile['email'];
            $this->request->data['User']['name'] = $user_profile['name'];
            $this->request->data['User']['email'] = $user_profile['email'];
            $this->request->data['User']['fb_id'] = $user_profile['id'];
            $this->request->data['User']['password'] = $user_profile['id'] . 'admin';
            $encodepass  = base64_encode($user_profile['id'] . 'admin'); 
            $this->request->data['User']['md_pass'] = $encodepass;   
            
            $this->request->data['User']['image'] =  $imgurl; 
             $sesid = $this->Session->id();  
            
             if (!$this->User->hasAny(array(
                        'OR' => array('User.username' => $user_profile['email'], 'User.email' => $user_profile['email'])
                    ))) {
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['active'] = 1;
                if ($this->User->save($this->request->data)) {
                    $user = $this->User->find('first', array('conditions' => array('email' => $user_profile['email'])));
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
               
                     if ($user['User']['id']) {
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user_profile['id'] . 'admin';
                    
                      $this->Auth->login();  
                     
                       return $this->redirect('/users/myaccount/'); 
                }
                    
                    
                } else { 
                   $this->Session->setFlash('Sorry.Please try again', 'default', array('class' => 'msg_req'));
                    return $this->redirect('/users/myaccount/'); 
                }
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' => $user_profile['email'])));
                
                if($user['User']['fb_id']!=''){
                 
                          if ($user['User']['id']) {
                              
                   $img = $user_profile['picture']['data']['url'];
                   $this->User->updateAll(array('User.image' => "'$img'"), array('User.email' => $user_profile['email']));
                              
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user_profile['id'] . 'admin';
                    
                      $this->Auth->login();  
                      return $this->redirect('/users/myaccount/');  
                     }
                }else{
                     $this->User->saveField('fb_id', $user_profile['id']);
                    // $this->Session->setFlash('This email is already registered.', 'default', array('class' => 'msg_req'));
                     $img = $user_profile['picture']['data']['url'];
                     $this->User->updateAll(array('User.image' => "'$img'"), array('User.email' => $user_profile['email']));  
                     $pass = $user['User']['md_pass'];
                     $decodepass = base64_decode($pass); 
               
                     $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $decodepass; 
                    
                      $this->Auth->login(); 
                   return $this->redirect('/users/myaccount/'); 
                   
                }
                //$this->User->id = $user['User']['id'];
                // $this->User->saveField('image', $this->request->data['User']['image']);
                //$response['isSucess'] = 'true';
                //$response['data'] = $user;
            } 

                $params = array('next' => 'http://rajdeep.crystalbiltech.com/thoag/users/facebook_logout');
                $logout = $facebook->getLogoutUrl($params);
                $this->Session->write('User', $user_profile);
                $this->Session->write('logout', $logout);
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL; 
            }
        } else {
			 echo "<script>window.close()</script>";
			$this->Session->setFlash('Sorry. Please try again', 'flash_error'); 
           
            return $this->redirect('/users/myaccount/'); 
        }
    } 

//////////////////////////////////////////

    function facebook_logout() {

        $this->Session->delete('User');
        $this->Session->delete('logout');
        $this->redirect(array('controller' => 'pages', 'action' => '/'));
    } 
    
    ///////////////////////////////////////
    
    public function api_twitterlogin() {
        Configure::write('debug', 2);
        $this->layout = "ajax";
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            ob_start();
            print_r($this->request->data);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);
            $this->request->data['User']['username'] = $this->request->data['screen_name'];
            $this->request->data['User']['twitter_id'] = $this->request->data['twitter_id'];
            if (!$this->User->hasAny(array('User.username' => $this->request->data['screen_name'])
                    )) {
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['status'] = 1;
                if ($this->User->save($this->request->data)) {
                    $user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['screen_name'])));
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                            //'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                    if(isset($redata->User->device_uuid)){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    if (!empty($user['User']['image'])) {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    $response['isSuccess'] = true;
                    $response['data'] = $user;
                } else {
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Sorry please try again';
                }
            } else {
                $user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['screen_name'])));
                
                if (!empty($user['User']['image'])) {
                    $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                if($user['User']['twitter_id']!=''){
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                            'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                    if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    $response['isSuccess'] = 'true';
                    $response['data'] = $user;
                    $response['ig']=$user['User']['image'];
                }else{
                    $response['isSuccess']='false';
                    $response['msg']='This email is already registered.';
                }
            }
        }
        $this->set('response', $response);
        $this->render('ajax');
        echo json_encode($response); exit;
    }
    /**
     * google login
     * parameters:name: simerjit parmar, image, email, google_id
     */
    public function api_googlelogin() {
        
        Configure::write('debug', 2);
       
        
        $this->layout = "ajax";
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            ob_start();
            print_r($this->request->data);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);
            $this->request->data['User']['name']=$this->request->data['name'];
            $this->request->data['User']['username'] = $this->request->data['email'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            $this->request->data['User']['image'] = $this->request->data['image'];
            $this->request->data['User']['google_id'] = $this->request->data['google_id'];
            if (!$this->User->hasAny(array('User.username' => $this->request->data['email'])
                    )) {
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['status'] = 1;
                if ($this->User->save($this->request->data)) {
              
                    $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['email'])));
                    
                    $user_referral_code =  substr($user['User']['username'],0,3).rtrim(strtr(base64_encode($user['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
                    if (!empty($user['User']['image'])) {
                        if (!filter_var($user['User']['image'], FILTER_VALIDATE_URL) === false) {
                            $user['User']['image'] = $user['User']['image'];
                        } else {
                            $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                        }
                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                    }
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                          //  'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                    if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    $response['isSuccess'] = true;
                    $response['data'] = $user;
                } else {
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Sorry please try again';
                }
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['email'])));
                if (!empty($user['User']['image'])) {
                    if (!filter_var($user['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $user['User']['image'] = $user['User']['image'];
                    } else {
                        $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                    }
                } else {
                    $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                
                if($user['User']['google_id']!=''){
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$this->request->data['session_id'],
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$this->request->data['session_id']),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    
                     if(isset($this->request->data['device_uuid'])){
                        $this->loadModel('Installation');
                        $exist = $this->Installation->find('first',array("conditions"=>array('Installation.device_uuid'=>$this->request->data['device_uuid'])));
                        if($exist){
                            $this->User->updateAll(
                                array('User.device_token'=>"'".$exist["Installation"]["device_token"]."'"),
                                array('User.id'=>$user['User']['id'])
                                );
                        }
                    }
                    
                    $response['isSuccess'] = true;
                    $response['data'] = $user;
                    
                }else{
                    $response['isSuccess']=false;
                    $response['msg']='This email is already registered.';
                }
            }
        }
        $this->set('response', $response);
        $this->render('ajax');
        echo json_encode($response); exit;
    }
    public function api_changepassword() {
        configure::write('debug', 0);

        $this->layout = "ajax";
        if ($this->request->is('post')) {
            $password = AuthComponent::password($this->data['User']['old_password']);
            $em = $this->request->data['User']['email'];
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.email' => $em))));
            if ($pass) {
                $this->User->data['User']['password'] = $this->data['User']['new_password'];
                $this->User->id = $pass['User']['id'];
                if ($this->User->exists()) {
                    $pass['User']['password'] = $this->data['User']['new_password'];
                    if ($this->User->save()) {
                        $email = new CakeEmail();
                        $email->from('restaurants@test.com')
                                //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                ->cc('ashutosh@avainfotech.com')
                                ->to($pass['User']['email']) 
                                ->subject('Thoag:: Password Changed Successfully')
                                ->template('changepassword')
                                ->emailFormat('html')
                                ->viewVars(array('user' => $pass))
                                ->send('html');
                        $response['isSucess'] = 'true';
                        $response['msg'] = "Your Password has been updated Successfully!";
                    }
                }
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = "Your old password did not match";
            }
        }
        $this->set('response', $response);

        $this->render('ajax');
    }

    ///////////29 aug 2016/////////////////////////////   
    public function api_saveimage() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r("simerrr");
        print_r($redata);
        print_r($_POST);
        print_r($_FILES);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $one = $redata->User->img;
        $img = base64_decode($one);
        $im = imagecreatefromstring($img);

        if ($im !== false) {

            $image = "1" . time() . ".png";
            imagepng($im, WWW_ROOT . "files" . DS . "profile_pic" . DS . $image);
            imagedestroy($im);
            $response['msg'] = "image is uploaded";
        } else {
          //  $response['isSucess'] = 'true';
            $response['msg'] = 'Image did not create';
        }


        $this->User->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {

            $id = $redata->User->id;
            $name = $redata->User->name;
            $data = $this->User->updateAll(array('User.image' => "'$image'"), array('User.id' => $id));
            if ($data) {
                $user = $this->User->find("first",array("conditions"=>array('User.id'=>$id)));
               // print_r($user);
                if($user){
                    $user['User']['image']=  FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                }
//$response['img']=  FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $data['User']['image'];
                $response['data'] =  $user;
                $response['error'] = 0;
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_contact() {
        $Email = new CakeEmail('smtp');
        $Email->from(array('me@example.com' => 'My Site'));
        $Email->to('ashutosh@avainfotech.com');
        $Email->subject('About');
        $Email->send('My message');
        exit;
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if ($redata) {
            $Email = new CakeEmail('smtp');
            $Email->from(array('me@example.com' => 'My Site'));
            $Email->to('ashutosh@avainfotech.com');
            $Email->subject($redata->Contact->subject);
            $Email->send($redata->Contact->message);
            $response['isSucess'] = "false";
            $response['msg'] = "Message Sent";
        } else {
            $response['isSucess'] = 'true';
            $response['msg'] = 'Message not sent';
        }
        echo json_encode($response);
        exit;
    }

    public function myaccount() {
        Configure::write("debug", 0);
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            return $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        if ($this->request->is("post")) {
            $image = $this->request->data['User']['image'];
            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
               
                $full_image_path = $uploadPath . DS . $imageName;
              // $img = Router::url('/', true)."files/profile_pic/".$imageName;
                
                move_uploaded_file($image['tmp_name'], $full_image_path);  
                $this->User->updateAll(array('User.image' => "'$imageName'"), array('User.id' => $uid));
                return $this->redirect(array('action' => 'myaccount'));

                exit;
            }
        }
            $this->loadModel('Favrest');
            $favrests_count = $this->Favrest->find('count',array(
                'conditions'=>array('Favrest.user_id'=>$uid)
                )); 
        
        $data = $this->User->find('first', array('conditions' => array('User.id' => $uid)));
        $this->set('data', $data);
        $this->set('favcount', $favrests_count);
        $this->loadModel('Order');
        $odata = $this->Order->find('count', array('conditions' => array('Order.uid' => $uid,'Order.order_status !=' =>0))); 
        $this->set('odata', $odata);  
        $this->set('favcount', $favrests_count);
        
           $this->loadModel('Setting');
           $setting = $this->Setting->find('all');     
          $this->set('setting', $setting);
          
          
          ///////////////////////Referdetails/////////////////////////////////////
          
          
           $user = $this->User->find('first',array('conditions'=>array('User.id'=>$uid)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                  
                if($users){
                    $user_ids = array_keys($users);
                    $this->loadModel('Order');
                    $orders = $this->Order->find('all',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        'group'=>'Order.uid',
                        'recursive'=>1
                        ));
                    
                     
                    if($orders){
                        $order_list=array();
                        $this->loadModel('Setting');
                            $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_refferal')));
                            if($discount_setting['Setting']['dimension']==2){
                               $discount_for_refferal= "SAR".$discount_setting['Setting']['value'];
                            }else if($discount_setting['Setting']['dimension']==1){
                                $discount_for_refferal= $discount_setting['Setting']['value']."%";
                            }else{
                                $discount_for_refferal= $discount_setting['Setting']['value'];
                            }
                        foreach ($orders as $order){
                            $created_date = strtotime($order['Order']['created']);
                            $order['Order']['valid_till']=date('d M,y h:i A', strtotime('+1 months',$created_date));
                            $order['Order']['discount_for_refferal']=$discount_for_refferal;
                            $order_list[]=$order;
                        }
                        $response['isSuccess']=true;
                        $response['data']=$order_list;
                            
                    }else{
                        $response['isSuccess']=false;
                        $response['msg']="Invite more friends to get the discount";
                    }
                    
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Invite friends to get the discount";
                }
            }else{
                $response['isSuccess']=false;
                $response['msg']="Some issue occured. Please login again";
            }
          
          
        $this->set('referdata',$response);   
          
          
        
    }

    public function api_trackorder() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if ($redata) {
            $this->loadModel('Order');
            $order_id = $redata->Order->id;
            $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
            $response['order'] = $data;
            $response['isSucess'] = "true";
            $response['msg'] = "Order has been found";
        } else {
            $response['isSucess'] = 'false';
            $response['msg'] = 'Order has not be found';
        }
        echo json_encode($response);
        exit;
    }

    public function api_addresslist() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if ($redata) {
            $this->loadModel('Order');
            $uid = $redata->User->id;
            $data = $this->User->find('all', array('conditions' => array('User.id' => $uid)));
            $response['user'] = $data;
            $response['isSucess'] = "true";
        } else {
            $response['isSucess'] = 'false';
        }
        echo json_encode($response);
        exit;
    }

    public function wallet() {
        $this->loadModel("Wallet");
        $val = $this->request->data['User']['money'];
        $uid = $this->request->data['User']['uid'];

        $this->Wallet->create();
        $this->request->data['Wallet']['money'] = $val;
        $this->request->data['Wallet']['uid'] = $uid;

        $save = $this->Wallet->save($this->request->data);
        if ($save) {
            $last_id = $this->Wallet->getLastInsertId();
            $id = $last_id . '-' . $uid;
            ///////////////////////////////////////////////payment////////////////////////////////////////////////
            echo ".<form name=\"_xclick\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
                 
                    <input type=\"hidden\" name=\"business\" value=\"ashutosh@avainfotech.com\">
                    <input type=\"hidden\" name=\"currency_code\" value=\"USD\">
                    
                    <input type=\"hidden\" name=\"custom\" value=\"$id\">
                    <input type=\"hidden\" name=\"amount\" value=\"$val\">
                    <input type=\"hidden\" name=\"return\" value=\"http://rajdeep.crystalbiltech.com/ecasnik/users/walletsuccess\">
                    <input type=\"hidden\" name=\"notify_url\" value=\"http://rajdeep.crystalbiltech.com/ecasnik/users/walletipn\"> 
                    </form>";
//                    exit;
            echo "<script>document._xclick.submit();</script>";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    }

    public function walletsuccess() {
        $this->Session->setFlash('You have sucessfully added amount in your wallet so please check the wallt', 'flash_success');
        return $this->redirect(array('controller' => 'users', 'action' => 'myaccount'));
    }

    public function walletipn() {
        $fc = fopen('files/ipn1.txt', 'wb');
        ob_start();
        print_r($this->request);
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.developer.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);
        if (strcmp($res, "VERIFIED") == 0) {
            $custom_field = explode('-', $_POST['custom']);
            $payer_email = $_POST['payer_email'];
            $uid = $custom_field[1];

            $trn_id = $_POST['txn_id'];
            $pay = $_POST['mc_gross'];
            $this->loadModel('Wallet');
            $this->Wallet->query("UPDATE `wallets` SET `status` = 1, `paypal_status` = '$res',`txnid`='$trn_id', `amount`='$pay' WHERE `id` ='$custom_field[0]';");
            $user = $this->User->find('first', array('conditions' => array('User.id' => $uid)));
            $total_p = $user['User']['loyalty_points'] + $pay;
            $this->User->updateAll(array('User.loyalty_points' => $total_p), array('User.id' => $uid));
            $l = new CakeEmail('smtp');
            $l->emailFormat('html')->template('default', 'default')->subject('Payment')->to($payer_email)->send('Payment Done Successfully');
            $this->set('smtp_errors', "none");
        } else if (strcmp($res, "INVALID") == 0) {
            
        }
        $xt = ob_get_clean();
        fwrite($fc, $xt);
        fclose($fc);
        exit;
    }

    public function api_wallet() {
        $this->layout = "ajax";
        configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {        
           $amt= $this->request->data['Wallet']['amount'] = $redata->paypal->total;
            $this->request->data['Wallet']['txnid'] = $redata->paypal->paymentid;
            $this->request->data['Wallet']['status'] = 1;
            $this->request->data['Wallet']['paypal_status'] = $redata->paypal->status;
            $uid= $this->request->data['Wallet']['uid'] = $redata->user->id;

            if ($this->request->data['Wallet']['paypal_status'] == '"approved"') {
                $this->loadModel('Wallet');
                $this->loadModel('User');
                $this->Wallet->create();
                $this->Wallet->save($this->request->data);
                $user = $this->User->find('first', array('conditions' => array('User.id' => $uid)));
                $total_p = $user['User']['loyalty_points'] + $amt;
                $this->User->updateAll(array('User.loyalty_points' => $total_p), array('User.id' => $uid));
                $response['sucsess'] = "true";
            } else {
                $response['sucsess'] = "false";
            }
        } else {
            $response['sucsess'] = "false";
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }
    /*
     * @parameters: user_id
     */
    public function api_getRefferalsList(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        //$redata="fhfgh";
        if($redata){
            //$user_id=30;
            $user_id = $redata->user_id;
            $user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                
                if($users){
                    $user_ids = array_keys($users);
                    $this->loadModel('Order');
                    $orders = $this->Order->find('all',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        'group'=>'Order.uid',
                        'recursive'=>1
                        ));
                    if($orders){
                        $order_list=array();
                        $this->loadModel('Setting');
                            $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                            if($discount_setting['Setting']['dimension']==2){
                               $discount_for_refferal= "SAR".$discount_setting['Setting']['value'];
                            }else if($discount_setting['Setting']['dimension']==1){
                                $discount_for_refferal= $discount_setting['Setting']['value']."%";
                            }else{
                                $discount_for_refferal= $discount_setting['Setting']['value'];
                            }
                        foreach ($orders as $order){
                            $created_date = strtotime($order['Order']['created']);
                            $order['Order']['valid_till']=date('d M,y h:i A', strtotime('+1 months',$created_date));
                            $order['Order']['discount_for_refferal']=$discount_for_refferal;
                            $order_list[]=$order;
                        }
                        $response['isSuccess']=true;
                        $response['data']=$order_list;
                    }else{
                        $response['isSuccess']=false;
                        $response['msg']="Invite more friends to get the discount";
                    }
                    
                }else{
                    $response['isSuccess']=false;
                    $response['msg']="Invite friends to get the discount";
                }
            }else{
                $response['isSuccess']=false;
                $response['msg']="Some issue occured. Please login again";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Nothing to filter";
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    
       ///////////////////rupak/////////////////////////
    
     /////////////////////////////twitter user check///////////////////////////////

    public function checkUser($email, $oauth_uid, $username, $name,$profile_image_url) {

        $exist = $this->User->find("first", array('conditions' => array('User.username' => $username)));
		$this->Session->write('payfortpaymenton','website');
        if ($exist['User']['id']) {
            
			
                     $img = $profile_image_url; 
                $this->User->updateAll(array('User.image' => "'$img'",'User.email' => "'$email'",'User.name' => "'$name'"), array('User.username' => $username)); 
            
                   $pass = $exist['User']['md_pass']; 
                     $decodepass = base64_decode($pass);
                      $this->request->data['User']['username'] = $username;
                    $this->request->data['User']['password'] = $decodepass;  
                      $this->Auth->login();	
	  $this->User->id = $exist['User']['id']; 			//return $this->redirect('/users/myaccount/'); 
          $this->User->saveField('twitter_id', $oauth_uid);
           return $this->redirect('/products');
          
        } else {

            $this->request->data['User']['twitter_id'] = $oauth_uid;
            $this->request->data['User']['name'] = $name; 
            $this->request->data['User']['image'] = $profile_image_url; 
            //$this->request->data['User']['last_name'] = $lname;
            $this->request->data['User']['username'] = $username;
            $this->request->data['User']['password'] = $username;
            $this->request->data['User']['role'] = 'customer';
            $this->request->data['User']['email'] = $email;
            $this->request->data['User']['active'] = 1;    
             $encodepass  = base64_encode($username);  
              $this->request->data['User']['md_pass'] = $encodepass; 
            $this->User->save($this->request->data);
	 $user_id = $this->User->getLastInsertID();
         
               $user2 = $this->User->find('first', array('conditions' => array('email' => $email)));
                    
                    $user_referral_code =  substr($user2['User']['username'],0,3).rtrim(strtr(base64_encode($user2['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
         
                     
                    if ($user_id) {
                    $this->request->data['User']['username'] = $username;
                    $this->request->data['User']['password'] = $username;
                      $this->Auth->login();
                    return $this->redirect('/products');
                }
			
        }
        $userdata = $this->User->find("first", array('conditions' => array('User.twitter_id' => $oauth_uid)));
        return $userdata;
    }

    //////////////
    public function twitter_process() {
 Configure::write("debug", 0);
        Configure::load('twitter');
        $customer_key = Configure::read('Twitter.CONSUMER_KEY');
        $customer_secret = Configure::read('Twitter.CONSUMER_SECRET');
        $callback = Configure::read('Twitter.OAUTH_CALLBACK');


        if (isset($_REQUEST['oauth_token']) && $this->Session->read('token') !== $_REQUEST['oauth_token']) {

            //If token is old, distroy session and redirect user to index.php
            $this->Session->delete('token');
            return $this->redirect('http://rajdeep.crystalbiltech.com/thoag/');
        } elseif (isset($_REQUEST['oauth_token']) && $this->Session->read('token') == $_REQUEST['oauth_token']) {

            //Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
            $connection = new TwitterOAuth($customer_key, $customer_secret, $_SESSION['token'], $_SESSION['token_secret']);
            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            if ($connection->http_code == '200') {
                //Redirect user to twitter
                $this->Session->write('status', 'verified');
                $this->Session->write('request_vars', $access_token);

                //Insert user into the database
                $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');

                $user_info = $connection->get('account/verify_credentials', $params);
       
                //$user_info = $connection->get('account/verify_credentials'); 
               // $name = explode(" ", $user_info->name);
              //  $fname = isset($name[0]) ? $name[0] : '';
               // $lname = isset($name[1]) ? $name[1] : '';
                //$db_user = new Users();
                $this->checkUser($user_info->email, $user_info->id, $user_info->screen_name, $user_info->name, $user_info->profile_image_url);
 
                //Unset no longer needed request tokens
                $this->Session->delete('token');
                $this->Session->delete('token_secret');

               return $this->redirect('/products');
                //header('Location: index.php');
            } else {

               // $this->Session->setFlash('error, try again later!', 'flash_success');

                return $this->redirect('/products');
                //die;
            }
        } else {

            if (isset($_GET["denied"])) {
                return $this->redirect('/products');
                //die();
            }

            //Fresh authentication
            $connection = new TwitterOAuth($customer_key, $customer_secret);
            $request_token = $connection->getRequestToken($callback);

            //Received token info from twitter
            $this->Session->write('token', $request_token['oauth_token']);
            $this->Session->write('token_secret', $request_token['oauth_token_secret']);
            //$_SESSION['token'] 	        = $request_token['oauth_token'];
            //$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
            //Any value other than 200 is failure, so continue only if http code is 200
            if ($connection->http_code == '200') {
                //redirect user to twitter
                $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
                header('Location: ' . $twitter_url);
            } else {
                $this->Session->setFlash('error connecting to twitter! try again later!', 'flash_success');

                return $this->redirect('/products');
            }
        }
    }
    
    
    
    ////////////////////////
    
     public function google_login() {
       Configure::write("debug", 0); 
        $client_id = '323825392115-4f8gq30trjk9in995ha06fkviier8mfo.apps.googleusercontent.com';
        $client_secret = 'LZLeMiAV6dM24daYGJ0HvYU6';
        $redirect_uri = 'http://rajdeep.crystalbiltech.com/thoag/users/google_login';

        $this->set(compact('redirect_uri'));

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
		$this->Session->write('payfortpaymenton','website');
 
        $service = new Google_Service_Oauth2($client);
        		   if (isset($_GET['code'])) { 
            $client->authenticate($_GET['code']);
            $this->Session->write('access_token', $client->getAccessToken());
            // $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            exit;
        } 
        


        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            
            $user = $service->userinfo->get();
            
            
              $name = explode(" ", $user->name);
                $fname = isset($name[0]) ? $name[0] : '';
                $lname = isset($name[1]) ? $name[1] : '';

                $this->request->data['User']['name'] = $user->name;
                $this->request->data['User']['email'] = $user->email;
                $this->request->data['User']['username'] = $user->email;
                $this->request->data['User']['password'] = $user->id;
                 $encodepass  = base64_encode($user->id); 
                 $this->request->data['User']['md_pass'] = $encodepass;  
                $this->request->data['User']['first_name'] = $fname;
                $this->request->data['User']['last_name'] = $lname;
                $this->request->data['User']['image'] = $user->picture;
              
                $this->request->data['User']['google_id'] = $user->id;

             if (!$this->User->hasAny(array('User.username' => $user->email)
                    )) {
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['active'] = 1; 
                if ($this->User->save($this->request->data)) {
              
                    $user2 = $this->User->find('first', array('conditions' => array('email' => $user->email)));
                    
                    $user_referral_code =  substr($user2['User']['username'],0,3).rtrim(strtr(base64_encode($user2['User']['id']), '+/', '-_'), '='); 
                    $this->User->id = $this->User->getLastInsertID();
                    $this->User->saveField('referral_code', $user_referral_code);
                    
                     $this->request->data['User']['username'] = $user->email;
                    $this->request->data['User']['password'] = $user->id;
                      $this->Auth->login(); 
                  return $this->redirect('/products'); 
                } else {
                   
                     echo 'Sorry please try again'; 
                }
            } else {
                
                 $user1 = $this->User->find('first', array('conditions' => array('email' => $user->email)));
               
                if($user1['User']['google_id']!=''){ 
                $img = $user->picture; 
                $this->User->updateAll(array('User.image' => "'$img'"), array('User.email' => $user1['User']['email'])); 
                    
                   $this->request->data['User']['username'] = $user->email;
                    $this->request->data['User']['password'] = $user->id;
                      $this->Auth->login();
                   return $this->redirect('/products');  
                }else{
                    $this->User->saveField('google_id', $user->id);
                    
                     $img = $user->picture; 
                     $this->User->updateAll(array('User.image' => "'$img'"), array('User.email' => $user1['User']['email'])); 
                    
                     $pass = $user1['User']['md_pass'];
                     $decodepass = base64_decode($pass);
                    
                      $this->request->data['User']['username'] = $user->email;
                    $this->request->data['User']['password'] = $decodepass; 
                 
                      $this->Auth->login();
                   return $this->redirect('/products');
                   // echo 'This email is already registered.'; 
                }
                
                
            }   
            
            
            
            
        } else {
            
              $authUrl = $client->createAuthUrl();
          	$this->set(compact('authUrl'));
        }

    }
 
    ///////////////////////////
    /*
     * Update device_token 
     * parameters: user_id, device_token, platform
     */
    public function api_updatedeviceinfo(){
        Configure::write("debug", 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        
        if(!empty($redata)){
            $exists = $this->User->find('first',array('conditions'=>array(
                'User.id'=>$redata->user_id
            )));
            if($exists){
                $this->User->updateAll(
                        array('User.device_token'=>"'$redata->device_token'",
                            'User.platform'=>"'$redata->platform'"), // fields
                        array('User.id'=>$redata->user_id) // conditions
                        );
                $response['isSuccess']=true;
                $response['msg']='Device Token has been updated';
            }else{
                $response['isSuccess']=false;
                $response['msg']='Invalid User. Some issue occured. Please try again later.';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']='Some issue occured. Please try again later.';
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    public function sharecode($refercode = NULL){
        
         if ($this->request->is('post')) {  
            if(isset($this->request->data['User']['referral_code'])){
                $referral_code_exists = $this->User->find('first',array('conditions'=>
                    array(
                        'User.referral_code'=>$this->request->data['User']['referral_code']
                        )
                    ));
               // print_r($referral_code_exists); 
               // exit; 
                $this->request->data['User']['used_referral_code'] = $this->request->data['User']['referral_code'];
            }else{
                $this->request->data['User']['used_referral_code'] = '';
            }
             if($this->request->data['User']['used_referral_code'] != '' && empty($referral_code_exists)){  
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Invalid refferal code';
                }
         }
         $this->set('code',$refercode); 
        
    }
    
      public function favouritie_caterers(){
          
          $user_id = $this->Auth->user('id'); 
            $this->loadModel('Favrest');
           // $this->Favrest->recursive = 2;
            $favrests = $this->Favrest->find('all',array(
                'conditions'=>array('Favrest.user_id'=>$user_id),
                'recursive'=>1
                ));  
            
             if($favrests){
                $restaurants = array();
                foreach ($favrests as $favouriteRestaurant) {
                    if(!empty($favouriteRestaurant['Restaurant']['banner'])){
                        $favouriteRestaurant['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $favouriteRestaurant['Restaurant']['banner'];
                    }
                    if(!empty($favouriteRestaurant['Restaurant']['logo'])){
                        $favouriteRestaurant['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $favouriteRestaurant['Restaurant']['logo'];
                    }
                    $favouriteRestaurant['Restaurant']['opening_time']=date("g:iA", strtotime($favouriteRestaurant['Restaurant']['opening_time']));
                    $favouriteRestaurant['Restaurant']['closing_time']=date("g:iA", strtotime($favouriteRestaurant['Restaurant']['closing_time']));

                    
                    $restaurants[]=$favouriteRestaurant;
                }
                $this->set('favlist',$restaurants) ;   
               // $response['data'] = $restaurants;
            }else {
                  $this->set('favlist',null) ;   
            }
         
        
            
      }
    



}
 