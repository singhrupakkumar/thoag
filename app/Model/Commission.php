<?php
App::uses('AppModel', 'Model');
class Commission extends AppModel {
    public $belongsTo = array(
        'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'restaurant_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
?>