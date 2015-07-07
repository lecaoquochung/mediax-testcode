<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Keyword $Keyword
 */
class User extends AppModel {

        public $actsAs = array('Containable');
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'user';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pwd' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'on' => 'create'
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'on' => 'add_admin'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'このメールは既に登録しました。'
			),  
		),
		'company' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			 ),
		),
		'tel' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			 ),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Keyword' => array(
			'className' => 'Keyword',
			'foreignKey' => 'UserID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
