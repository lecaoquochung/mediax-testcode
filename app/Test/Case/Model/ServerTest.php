<?php
App::uses('Server', 'Model');

/**
 * Server Test Case
 */
class ServerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.server',
		'app.keyword',
		'app.user',
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
		$this->Server = ClassRegistry::init('Server');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Server);

		parent::tearDown();
	}

}
