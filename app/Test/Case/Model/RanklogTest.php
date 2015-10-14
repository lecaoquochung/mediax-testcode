<?php
App::uses('Ranklog', 'Model');

/**
 * Ranklog Test Case
 */
class RanklogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ranklog',
		'app.keyword',
		'app.user',
		'app.server',
		'app.rankhistory',
		'app.m_rankhistory',
		'app.engine',
		'app.rank',
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
		$this->Ranklog = ClassRegistry::init('Ranklog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ranklog);

		parent::tearDown();
	}

}
