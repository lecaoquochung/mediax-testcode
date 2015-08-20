<?php
/**
 * SalesKeywordFixture
 *
 */
class SalesKeywordFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'keyword_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'keyword' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rank' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sales' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'cost' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'profit' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'limit' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'keyword_id' => 1,
			'user_id' => 1,
			'keyword' => 'Lorem ipsum dolor sit amet',
			'rank' => 'Lorem ipsum dolor sit amet',
			'sales' => 1,
			'cost' => 1,
			'profit' => 1,
			'limit' => 1,
			'date' => '2015-08-20',
			'created' => '2015-08-20 15:23:30',
			'updated' => '2015-08-20 15:23:30'
		),
	);

}
