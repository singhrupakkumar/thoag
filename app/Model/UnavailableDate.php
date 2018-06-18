<?php
App::uses('AppModel', 'Model');
class UnavailableDate extends AppModel {
     public $belongsTo = array(
      'Restaurants' => array(
          'className' => 'Restaurant',
          'foreignKey' => 'restaurant_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );
}
?>