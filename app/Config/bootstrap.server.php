<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models', '/next/path/to/models'),
 *     'Model/Behavior'            => array('/path/to/behaviors', '/next/path/to/behaviors'),
 *     'Model/Datasource'          => array('/path/to/datasources', '/next/path/to/datasources'),
 *     'Model/Datasource/Database' => array('/path/to/databases', '/next/path/to/database'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions', '/next/path/to/sessions'),
 *     'Controller'                => array('/path/to/controllers', '/next/path/to/controllers'),
 *     'Controller/Component'      => array('/path/to/components', '/next/path/to/components'),
 *     'Controller/Component/Auth' => array('/path/to/auths', '/next/path/to/auths'),
 *     'Controller/Component/Acl'  => array('/path/to/acls', '/next/path/to/acls'),
 *     'View'                      => array('/path/to/views', '/next/path/to/views'),
 *     'View/Helper'               => array('/path/to/helpers', '/next/path/to/helpers'),
 *     'Console'                   => array('/path/to/consoles', '/next/path/to/consoles'),
 *     'Console/Command'           => array('/path/to/commands', '/next/path/to/commands'),
 *     'Console/Command/Task'      => array('/path/to/tasks', '/next/path/to/tasks'),
 *     'Lib'                       => array('/path/to/libs', '/next/path/to/libs'),
 *     'Locale'                    => array('/path/to/locales', '/next/path/to/locales'),
 *     'Vendor'                    => array('/path/to/vendors', '/next/path/to/vendors'),
 *     'Plugin'                    => array('/path/to/plugins', '/next/path/to/plugins'),
 * ));
 *
 */
/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
CakePlugin::loadAll();

/**
 * You can attach event listeners to the request lifecyle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 * 		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 * 		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 * 		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array('AssetDispatcher', 'CacheDispatcher'));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array('engine' => 'FileLog', 'types' => array('notice', 'info', 'debug'), 'file' => 'debug', ));
CakeLog::config('error', array('engine' => 'FileLog', 'types' => array('warning', 'error', 'critical', 'alert', 'emergency'), 'file' => 'error', ));

//
date_default_timezone_set('Asia/Tokyo');
setlocale(LC_MONETARY, "ja_JP.UTF-8");
Configure::write('Config.language', 'jpn');
Configure::write('Week.ja', array('月', '火', '水', '木', '金', '土', '日'));

Configure::write('monthNames', array('12' => '12', '11' => '11', '10' => '10', '09' => '9', '08' => '8', '07' => '7', '06' => '6', '05' => '5', '04' => '4', '03' => '3', '02' => '2', '01' => '1'));

//
Configure::write('FOLDER_UPLOAD_CSV', 'uploads/csv');

Configure::write('STRICT', array('0' => '通常一致', '1' => '完全一致'));

Configure::write('SEIKA', array('0' => '固定', '1' => '成果'));

Configure::write('NOCONTRACT', array('0' => '契約済み', '1' => '未契約', '2' => 'チェック用'));

Configure::write('MULTI_PRICE_GROUP', array('0' => '', '1' => 'グループ1', '2' => 'グループ2', '3' => 'グループ3'));

Configure::write('ENGINE', array('3' => 'Google/Yahoo', '1' => 'Google', '2' => 'Yahoo',
// '4' => 'Google English',
// '5' => 'Yahoo English',
// '6' => 'Google/Yahoo English',
// '7' => 'Yahoo Mobile',
// '8' => 'Google Mobile',
// '9' => 'Google/Yahoo_Mobile',
// '10' => 'Google and Yahoo',
// '11' => 'Google and Yahoo_Mobile',
// '12' => 'Google and Yahoo English'
));

Configure::write('ENGINES', array('gcn' => array('Name' => 'Google China', 'SearchUrl' => array("http://www.google.cn/search?hl=zh-CN&q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2", "http://www.google.cn/search?hl=zh-CN&num=100&q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2"), 'Pattern' => '/<a href="([^<>]*)" (target=_blank )?class=l/i'), 'gen' => array('Name' => 'Google US', 'SearchUrl' => array("http://www.google.com/search?q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2", "http://www.google.com/search?num=100&q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2"), 'Pattern' => '/<a href="([^<>]*)" (target=_blank )?class=l/i'), 'gjp' => array('Name' => 'Google Japan', 'SearchUrl' => array("http://www.google.co.jp/search?hl=ja&q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2", "http://www.google.co.jp/search?hl=ja&num=100&q=#KEYWORD#&&btnG=Google+%E6%90%9C%E7%B4%A2"), 'Pattern' => '/<a href="([^<>]*)" (target=_blank )?class=l/i'), 'baidu' => array('Name' => 'Baidu China', 'SearchUrl' => array("http://www.baidu.com/s?wd=#KEYWORD#&cl=3", "http://www.baidu.com/s?wd=#KEYWORD#&cl=3&rn=100"), 'Pattern' => '/<a onclick="return c.*?" href="(.*?)" target="_blank">/i')));

Configure::write('EXTRA', array('' => '', '0' => 'No Extra', '3' => '1位保証', '2' => '3位保証', '1' => '5位保証', '10' => '10位保証', '4' => '15位保証', '5' => '20位保証', ));

// Global variables
global $list_engine;
$list_engine = Configure::read('ENGINE');

global $current_year;
$current_year = date('Y');

global $current_date;
$current_date = date('Y-m-d');

global $current_first_date;
$current_first_date = date('Y-m-01');

global $extra_type;
$extra_type = Configure::read('EXTRA');

Configure::write('HEADER_CSV_VIEW_KEYWORD', array('Rankhistory.RankDate' => '日付', 'Rankhistory.Rank' => 'Google/Yahoo'));

Configure::write('HEADER_CSV_ALL_KEYWORD', array('Keyword.ID' => 'KeyID',
// 'Keyword.UserID' => '企業',
'Keyword.Keyword' => 'キーワード', 'Keyword.Url' => 'Url', 'Rankhistory.Rank' => 'Google/Yahoo'));

Configure::write('HEADER_CSV_KOTEI_KEYWORD', array('Keyword.ID' => 'id', 'Keyword.Keyword' => 'keyword', 'Keyword.Url' => 'url', 'Rankhistory.Rank' => 'Google/Yahoo'));

define('CLIENT_PATH', '/mediax.client');

Configure::write('NOTICE_LABEL', array('1' => '重要', '2' => 'ニュース', ));

Configure::write('LABEL_MARKUP', array('1' => 'label-important', '2' => 'label-warning', '3' => 'label-primary', '4' => 'label-success', '5' => 'label-default', ));

Configure::write('G_LOCAL', array('1' => 'Shibuya', '0' => 'Default', '2' => 'Nagoya', '6' => 'nishitama', '8' => 'Yodogawa-ku,Osaka,Japan', '9' => 'Kobe,Hyogo,Japan', '10' => 'Osaka,Osaka,Japan', '11' => 'Kanagawa Prefecture,Japan', ));

Configure::write('G_LCODE', array('0' => '', '1' => '&uule=w+CAIQICITU2hpYnV5YSxUb2t5byxKYXBhbg', '2' => '&uule=w+CAIQICIdTmFnb3lhLEFpY2hpIFByZWZlY3R1cmUsSmFwYW4', '6' => '&uule=w+CAIQICIJbmlzaGl0YW1h', '8' => '&uule=w+CAIQICIXWW9kb2dhd2Eta3UsT3Nha2EsSmFwYW4', '9' => '&uule=w+CAIQICIQS29iZSxIeW9nbyxKYXBhbg', '10' => '&uule=w+CAIQICIRT3Nha2EsT3Nha2EsSmFwYW4', '11' => '&uule=w+CAIQICIZS2FuYWdhd2EgUHJlZmVjdHVyZSxKYXBhbg', ));

// truncate
Configure::write('TRUNCATE_URL', 30);

/*------------------------------------------------------------------------------------------------------------
 * Rank Color Code
 *
 * author lecaoquochung@gmail.com
 * created
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
Configure::write('Color.code', array('green' => '#dff0d8', 'yellow' => '#fcf8e3', // old #FAFAD2
'red' => '#f2dede', // old # FFBFBF
'blue' => '#d9edf7', // old #E4EDF9
));

/*------------------------------------------------------------------------------------------------------------
 * Server Config
 *
 * author lecaoquochung@gmail.com
 * created
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
// Admin.email
Configure::write('Admin.email', array('le.hung@givery.co.jp'));

// Page.limit
Configure::write('Page.max', 1000);
Configure::write('Page.medium', 500);
Configure::write('Page.min', 100);

// IP
Configure::write('Server.ip', array('124.33.192.250', '160.16.105.145'));

/*------------------------------------------------------------------------------------------------------------
 * User Agent
 *
 * author lecaoquochung@gmail.com
 * created
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
// PC
Configure::write('Useragent.pc', array('0' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', '1' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:36.0) Gecko/20100101 Firefox/36.0', '2' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36', '3' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36', '4' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36', '5' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2503.0 Safari/537.36', '6' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36', '7' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:40.0) Gecko/20100101 Firefox/40.0', '8' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36'));

// Mobile
Configure::write('Useragent.mobile', array('0' => "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53", '1' => "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12F70 Safari/600.1.4", '2' => "Mozilla/5.0 (iPhone; CPU iPhone OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12B411", '3' => "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F70", ));

// User.role
Configure::write('User.role', array('1' => __('User Admin'), '2' => __('Rank Admin'), ));

Configure::write('User.admin', array('2' => __('Rank Admin'), ));

// User.permission
Configure::write('User.permission', array('1' => array('index', 'view', 'edit', 'delete'), '2' => array('index', 'view'), ));

Configure::write('HEADER_CSV_EXPORT_KEYWORD', array(
	'Keyword.ID' => 'ID',
	// 'Keyword.code' => 'code', 
	'Keyword.Keyword' => 'Keyword',
	'Keyword.server_id' => 'Server',
	'Keyword.cost' => 'Cost',
	'Keyword.limit_price' => 'Limit'
));


Configure::write('HEADER_CSV_KEYWORD', array(
	'ID' => 'Keyword.ID', 
	'Keyword' => 'Keyword.Keyword',
	'Server' => 'Keyword.server_id',
	'Cost' => 'Keyword.cost',
	'Limit' => 'Keyword.limit_price'
));

/*------------------------------------------------------------------------------------------------------------
 * Sales: sales_goals
 * 
 * author lecaoquochung@gmail.com
 * created
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
 Configure::write('sales_goals.seika', 
	array(
		1 => __('Seika Monthly'),
	)
);
