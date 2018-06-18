<?php
App::uses('AppModel', 'Model');
class Discount extends AppModel {
    public $belongsTo=array(
        'Restaurant' => array(
          'className' => 'Restaurant',
          'foreignKey' => 'res_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
    );
            
}
?>