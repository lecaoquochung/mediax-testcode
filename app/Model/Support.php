<?php
App::uses('AppModel', 'Model');
/**
 * Support Model
 *
 * @property Jobhunter $Jobhunter
 */
class Support extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
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
		'Jobhunter' => array(
			'className' => 'Jobhunter',
			'foreignKey' => 'jobhunter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
