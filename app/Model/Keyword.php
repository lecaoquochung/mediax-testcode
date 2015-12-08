<?php
App::uses('AppModel', 'Model');
/**
 * Keyword Model
 *
 * @property Extra $Extra
 * @property Duration $Duration
 * @property User $User
 * @property Rankhistory $Rankhistory
 * @property Rankhistory $Rankhistory
 */
 
/**
 * Keyword Model
 *
 */
class Keyword extends AppModel {

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

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		/*'Duration' => array(
			'className' => 'Duration',
			'foreignKey' => 'KeyID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'UserID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Server' => array(
			'className' => 'Server',
			'foreignKey' => 'server_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Rankhistory' => array(
			'className' => 'Rankhistory',
			'foreignKey' => 'KeyID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MRankhistory' => array(
			'className' => 'MRankhistory',
			'foreignKey' => 'keyword_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Rank' => array(
            'className' => 'Rank',
            'foreignKey' => 'keyword_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
		'Extra' => array(
			'className' => 'Extra',
			'foreignKey' => 'KeyID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Duration' => array(
			'className' => 'Duration',
			'foreignKey' => 'KeyID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SalesKeyword' => array(
			'className' => 'SalesKeyword',
			'foreignKey' => 'keyword_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Ranklog' => array(
            'className' => 'Ranklog',
            'foreignKey' => 'keyword_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		/*
		'ID' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		*/
		'UserID' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		// 'limit_price' => array(
			// 'numeric' => array(
				// 'rule' => array('numeric'),
				// //'message' => 'Your custom message here',
				// //'allowEmpty' => false,
				// //'required' => false,
				// //'last' => false, // Stop validation after this rule
				// //'on' => 'create', // Limit validation to 'create' or 'update' operations
			// ),
		// ),
		'Keyword' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'hankaku' => array(
				'rule'=> array('hanKaku'),
				'message' => '英文また数字は全て半角です。'
			),
		),
		'Url' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Engine' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		// 'Strict' => array(
			// 'notBlank' => array(
				// 'rule' => array('notBlank'),
				// //'message' => 'Your custom message here',
				// //'allowEmpty' => false,
				// //'required' => false,
				// //'last' => false, // Stop validation after this rule
				// //'on' => 'create', // Limit validation to 'create' or 'update' operations
			// ),
		// ),
		'seika' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nocontract' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * CSV export
 *
 * @var array
 */	
	public $actsAs = array(
	    'CsvExport' => array(
	        'delimiter' => ',', //The delimiter for the values, default is ;
	        'enclosure' => '"', //The enclosure, default is "
	        'max_execution_time' => 360, //Increase for Models with lots of data, has no effect is php safemode is enabled.
	        'encoding' => 'utf8' //Prefixes the return file with a BOM and attempts to utf_encode() data
	    ),
		'CsvImport' => array(
			'delimiter'  => ',',
			'hasHeader'=>false,
			'mapHeader'=> 'HEADER_CSV_KEYWORD'//Configure::read('HEADER_CSV_COMPANY')
		)		
    );
	
	public function header_export_keywork_user($headers, $mapHeader){
		/*
		foreach($mapHeader as $k=>$v){
			if(!in_array($k,$headers)){
				$headers[] = $k;
			}
		}		
		return $headers;
		*/
		return $mapHeader;
	}
	
	public function callback_export_keywork_user($row){
		$rankhistory = $this->Rankhistory->find('first',array('Rankhistory.KeyID'=>$row['Keyword.ID'],'Rankhistory.RankDate'=>date('Ymd')));
		if($rankhistory!=false){
			$row['Rankhistory.Rank'] = $rankhistory['Rankhistory']['Rank'];
		}else{
			$row['Rankhistory.Rank'] = '0/0';
		}
		
		$duration = $this->Duration->find('first',array('Duration.KeyID'=>$row['Keyword.ID']));
		if($duration!=false){
			$row['Duration.StartDate'] = date('Y-m-d',strtotime($duration['Duration']['StartDate']));
		}else{
			$row['Duration.StartDate'] = '';
		}		
		//pr($row);die();
		return $row;
	}
}
