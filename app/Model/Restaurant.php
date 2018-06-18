<?php

App::uses('AppModel', 'Model');

/**
 * Restaurant Model
 *
 * @property User $User
 * @property BookmarkDish $BookmarkDish
 * @property Dish $Dish
 * @property RestauratsReview $RestauratsReview
 * @property UserCheckin $UserCheckin
 */
class Restaurant extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $actsAs = array('Containable');

    /**
     * Validation rules
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'RestaurantsType' => array(
            'className' => 'RestaurantsType',
            'foreignKey' => 'typeid'
        ),
    );
//    public $belongsTo = array(
//        'RestaurantsType' => array(
//            'className' => 'RestaurantsType',
//            'foreignKey' => 'typeid'
//        ),
//        'User' => array(
//          'className' => 'User',
//          'foreignKey' => 'user_id',
//          'conditions' => '',
//          'fields' => '',
//          'order' => ''
//      )
//    );
    public $hasMany = array(
        'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'res_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Favrest' => array(
            'className' => 'Favrest',
            'foreignKey' => 'res_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Reviews'=>array(
            'className'=>'RestaurantsReview',
            'foreignKey'=>'restaurant_id',
            'dependent'=>true
        ),
        'Promocode'=>array(
            'className'=>'Promocode',
            'foreignKey'=>'res_id',
            'dependent'=>true
        ),
		'Discount'=>array(
            'className'=>'Discount',
            'foreignKey'=>'res_id',
            'dependent'=>true
        )
		,
		'UnavailableDate'=>array(
            'className'=>'UnavailableDate',
            'foreignKey'=>'restaurant_id',
            'dependent'=>true
        )
    );

    function import($filename) {
        // to avoid having to tweak the contents of 
        // $data you should use your db field name as the heading name 
        // eg: Post.id, Post.title, Post.description
        // set the filename to read CSV from
        $filename = WWW_ROOT . 'files' . DS . 'resfile' . DS . $filename;

        // open the file
        $handle = fopen($filename, "r");

        // read the 1st row as headings
        $header = fgetcsv($handle);

        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );

        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = array();

            // for each header field 
            foreach ($header as $k => $head) {
                // get the data field from Model.field
                if (strpos($head, '.') !== false) {
                    $h = explode('.', $head);
                    $data[$h[0]][$h[1]] = (isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data['Restaurant'][$head] = (isset($row[$k])) ? $row[$k] : '';
                }
            }

            // see if we have an id 			
            $id = isset($data['Restaurant']['id']) ? $data['Restaurant']['id'] : 0;

            // we have an id, so we update
            if ($id) {
                // there is 2 options here, 
                // option 1:
                // load the current row, and merge it with the new data
                //$this->recursive = -1;
                //$post = $this->read(null,$id);
                //$data['Post'] = array_merge($post['Post'],$data['Post']);
                // option 2:
                // set the model id
                $this->id = $id;
            }

            // or create a new record
            else {
                $this->create();
            }

            // see what we have
            // debug($data);
            // validate the row
            $this->set($data);
            if (!$this->validates()) {
                $this->_flash('warning');
                $return['errors'][] = __(sprintf('Post for Row %d failed to validate.', $i), true);
            }

            // save the row
            if (!$error && !$this->save($data)) {
                $return['errors'][] = __(sprintf('Post for Row %d failed to save.', $i), true);
            }

            // success message!
            if (!$error) {
                $return['messages'][] = __(sprintf('Post for Row %d was saved.', $i), true);
            }
        }

        // close the file
        fclose($handle);

        // return the messages
        return $return;
    }

}
