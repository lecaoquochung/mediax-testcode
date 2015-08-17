<?php
App::uses('SalesKeyword', 'Model');

/**
 * SalesKeyword Test Case
 *
 */
class SalesKeywordTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sales_keyword',
		'app.keyword',
		'app.user',
		'app.rankhistory',
		'app.m_rankhistory',
		'app.engine',
		'app.extra',
		'app.duration'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SalesKeyword = ClassRegistry::init('SalesKeyword');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SalesKeyword);

		parent::tearDown();
	}

}
