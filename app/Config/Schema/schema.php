<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $contactus = array(
		'subject' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'userid' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'date' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $durations = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'StartDate' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'EndDate' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Flag' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'sjis', 'collate' => 'sjis_japanese_ci', 'engine' => 'MyISAM')
	);

	public $emaildb = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'company' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tel' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'time' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'ip' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'supportor' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'userid' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $enduser = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'supportor' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'pwd' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'company' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'department' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tel' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'homepage' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'remark' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'date' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'address' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'zipcode' => array('type' => 'string', 'null' => false, 'length' => 115, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'CHPCode' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'CHPTime' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'hosyou' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'seikou' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'loginip' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'logintime' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 14),
		'agent' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'money_bank' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sellremark' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'techremark' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'billlastday' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'parent' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'custom' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'keystr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $engines = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'primary'),
		'Name' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'sjis_japanese_ci', 'charset' => 'sjis'),
		'ShowName' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Short' => array('type' => 'string', 'null' => false, 'length' => 10, 'collate' => 'sjis_japanese_ci', 'charset' => 'sjis'),
		'Code' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'sjis', 'collate' => 'sjis_japanese_ci', 'engine' => 'MyISAM')
	);

	public $extra = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'key' => 'primary'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'key' => 'index'),
		'ExtraType' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'comment' => '1 - in top 5, 2 - in top 3'),
		'Price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1),
			'keyi' => array('column' => 'KeyID', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'sjis', 'collate' => 'sjis_japanese_ci', 'engine' => 'MyISAM')
	);

	public $keywords = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'key' => 'primary'),
		'UserID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'key' => 'index'),
		'Keyword' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Engine' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'key' => 'index'),
		'g_local' => array('type' => 'string', 'null' => false, 'default' => '1', 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cost' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'Price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'limit_price' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'limit_price_group' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1, 'comment' => 'set limit price group: 1,2,3'),
		'upday' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'goukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sengoukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'$sensengoukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'Enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'Strict' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'Extra' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'start' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'rankstart' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'rankend' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'kaiyaku_reason' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middle' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middleinfo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'seika' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'nocontract' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'csv_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'comment' => '[1=直営,2=直営2 , 3=代理店,4=ビスカス,5=アサミ,6=エニー]'),
		'penalty' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'service' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'mobile' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'c_logic' => array('type' => 'boolean', 'null' => false, 'default' => null, 'comment' => 'Ranking restricted to company logic'),
		'sales' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'sitename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'CSV', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1),
			'ke' => array('column' => array('UserID', 'Enabled'), 'unique' => 0),
			'Price' => array('column' => 'Price', 'unique' => 0),
			'Engine' => array('column' => 'Engine', 'unique' => 0),
			'Keyword' => array('column' => 'Keyword', 'type' => 'fulltext')
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'log' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'pre&after data log', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'useragent' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mvc' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'read' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $m_rankhistories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'keyword_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'engine_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'keyword' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rank' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rankdate' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $nocontractkey = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'key' => 'primary'),
		'UserID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'key' => 'index'),
		'Keyword' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Engine' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'Price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'upday' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'goukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sengoukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'$sensengoukeifee' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'Enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'Strict' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'Extra' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'start' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'rankstart' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'rankend' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'kaiyaku_reason' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middle' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middleinfo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1),
			'ke' => array('column' => array('UserID', 'Enabled'), 'unique' => 0),
			'Price' => array('column' => 'Price', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $notice = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'label' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'history' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $orders = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'primary'),
		'UserID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6),
		'Keywords' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'TotalPrice' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'Enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'OrderDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'EnableDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'sjis', 'collate' => 'sjis_japanese_ci', 'engine' => 'MyISAM')
	);

	public $quote_supportor = array(
		'supportorid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'fullname' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'supportorid', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $rankhistory = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Rank' => array('type' => 'string', 'null' => false, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'RankDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'params' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $rankhistoryss = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Rank' => array('type' => 'string', 'null' => false, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'RankDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $rankkeywords = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Keyword' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'google_jp' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'yahoo_jp' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'google_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'yahoo_en' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'bing' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $resell_endcustom = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'resellid' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'customid' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $sendemail = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'status' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $seohistory = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'Remark' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Finish' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'AddDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $servicelog = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'LogTime' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'Type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'Checked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $syslog = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'LogTime' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'Content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'ID', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	public $tmp = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Url' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Rank' => array('type' => 'string', 'null' => false, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'RankDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'params' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $tmp_rankhistory = array(
		'ID' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'KeyID' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'Url' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Rank' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'RankDate' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'params' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $user = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'supportor' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'pwd' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'company' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'department' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tel' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'homepage' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'remark' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'date' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'address' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'zipcode' => array('type' => 'string', 'null' => false, 'length' => 115, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'CHPCode' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'CHPTime' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'hosyou' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'seikou' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'loginip' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'logintime' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 14),
		'agent' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'money_bank' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sellremark' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'techremark' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'billlastday' => array('type' => 'string', 'null' => false, 'default' => '翌月末', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'logo' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'limit_price_multi' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'limit_price_multi2' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'limit_price_multi3' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

}
