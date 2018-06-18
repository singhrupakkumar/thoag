<?php
App::uses('AppModel', 'Model');
/**
 * Favrest Model
 *
 */
class Favrest extends AppModel {
    public $belongsTo = array(
        'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'res_id'
        )
    );
}
