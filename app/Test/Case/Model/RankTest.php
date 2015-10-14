<?php
App::uses('Rank', 'Model');

/**
 * Rank Test Case
 */
class RankTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.rank',
		'app.keyword',
		'app.user',
		'app.server',
		'app.rankhistory',
		'app.m_rankhistory',
		'app.engine',
		'app.extra',
		'app.duration',
		'app.sales_keyword'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rank = ClassRegistry::init('Rank');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rank);

		parent::tearDown();
	}

}
