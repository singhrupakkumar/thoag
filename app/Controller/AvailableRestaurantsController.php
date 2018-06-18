<?php

App::uses('AppController', 'Controller');

/**
 * Available Restaurants Controller
 *
 * @property AvailableRestaurant $AvailableRestaurant
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */

class AvailableRestaurantsController extends AppController {
       /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash');
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('api_categories');
    }
/**
     * admin_index method
     *
     * @return void
     */
     
    public function admin_index(){
    $this->layout = "admin";
    $this->loadModel('Restaurant');
    //if ($this->Session->check('Restaurant')) {
          
      //      $all = $this->Session->read('Restaurant');
        //} else 
        //if($this->Auth->user('role')=="rest_admin"){
          $all = array(
                'name' => '',
                'filter' => '',
                'conditions' => array(
                'Restaurant.user_id' =>$this->Auth->user('id')
            )); 
       // } else {
          //  $all = array(
            //    'name' => '',
            //    'filter' => '',
            //    'conditions' => ''
           // );
        //}
        $this->set(compact('all'));
        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array(
            'Restaurant' => array(
                'recursive' => 2,
                'contain' => array(
                ),
                'conditions' => array(
                ),
                'order' => array(
                    'Restaurant.created' => 'DESC'
                ),
                'limit' => 20,
                'conditions' => $all['conditions'],
                'paramType' => 'querystring',
            )
        );
        $this->set('restaurants', $this->Paginator->paginate());
        
    } 
}

?>