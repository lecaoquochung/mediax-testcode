<?php
/**
 * SalesGoal Fixture
 */
class SalesGoalFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => '1:seika montly 2:seika daily'),
		'goal' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'target' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'target day, month or year', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'type' => 1,
			'goal' => 1,
			'target' => 'Lorem ipsum dolor ',
			'date' => '2015-10-06',
			'created' => '2015-10-06 13:29:01',
			'modified' => '2015-10-06 13:29:01'
		),
	);

}
