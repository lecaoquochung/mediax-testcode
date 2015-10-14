<?php
App::uses('SalesGoal', 'Model');

/**
 * SalesGoal Test Case
 */
class SalesGoalTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sales_goal'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SalesGoal = ClassRegistry::init('SalesGoal');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SalesGoal);

		parent::tearDown();
	}

}
