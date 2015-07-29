<?php
App::uses('AppModel', 'Model');
/**
 * Extra Model
 *
 * @property Keyword $Keyword
 */
class Extra extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'extra';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'ID';

/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'ExtraType' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                // 'on' => 'create'
            ),
        ),
        'Price' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
		"KeyID"=>array( 
			"unique"=>array( 
				"rule"=>array("checkUnique", array("KeyID", "ExtraType")), 
				"message"=>"登録済み" 
			) 
		)		
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Keyword' => array(
			'className' => 'Keyword',
			'foreignKey' => 'KeyID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function checkUnique($data, $fields) { 
		if (!is_array($fields)) { 
			$fields = array($fields); 
		} 
		foreach($fields as $key) { 
				$tmp[$key] = $this->data[$this->name][$key];
		} 
		if (isset($this->data[$this->name][$this->primaryKey])) { 
				$tmp[$this->primaryKey] = "<>".$this->data[$this->name][$this->primaryKey]; 
		} 
		return $this->isUnique($tmp, false); 
	} 
}
