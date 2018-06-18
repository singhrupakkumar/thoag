<?php
App::uses('AppModel', 'Model');
/**
 * RestaurantsReview Model
 *
 */
class RestaurantsReview extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'restaurants_reviews';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
        
        public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'users_id'
            ),
            'Restaurant' => array(
                'className' => 'Restaurant',
                'foreignKey' => 'restaurant_id'
            )
    );
}
