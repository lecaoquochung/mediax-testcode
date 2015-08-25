<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/*------------------------------------------------------------------------------------------------------------
 * Mediax System Component
 *
 * author lecaoquochung@gmail.com
 * created
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
class AppController extends Controller {
	public $components = array(
		'Auth' => array('authError' => 'Did you really think you are allowed to see that?'), 
		'Session', 
		'Cookie', 
		'Upload', 
		'Email', 
		'RequestHandler', 
		'Security', 
		'Rank', 
		'RankMobile', 
		'Paginator',

		// debug
		'DebugKit.Toolbar', 
	);

	public $helpers = array('Session', 'Form', 'Html', 'Js');

	public $paginate = array('limit' => 20, 'order' => array('modified' => 'desc'));

	public $key = 'givery.mediax';

	public function beforeFilter() {
		parent::beforeFilter();
		$this -> _setupAuth();
		$this -> _setupLayout();
		$this -> Cookie -> key = $this -> key;

		// mobile
		if ($this -> RequestHandler -> isMobile()) {

			// required for CakePHP 2.2.2
			$viewDir = App::path('View');
			// returns an array
			/*
			 * array(
			 *      (int) 0 => '/var/www/maps-cakephp2/app/View/'
			 * )
			 */

			$mobileViewFile = $viewDir[0] . $this -> viewPath . '/mobile/' . $this -> params['action'] . '.ctp';

			Debugger::log($this -> viewPath);
			// use this to log the output to
			// app/tmp/logs/debug.log

			if (file_exists($mobileViewFile)) {
				// if device is mobile, change layout to mobile
				// but only if a view exists for it.
				$this -> layout = 'mobile';
				// and if a mobile view file has been
				// created for the action, serve it instead
				// of the default view file

				$mobileView = $this -> viewPath . '/mobile/';
				$this -> viewPath = $mobileView;
			}
		}

		// template path
		// switch ($this->here) {
			// case '/mediax/' :
				// $this -> layout = 'default_new';
				// break;
			// case '/logs' :
				// $this -> layout = 'default_new';
				// break;
		// }

		// if ($this -> params['action'] == 'service' || 
			// $this -> params['action'] == 'report' || 
			// $this -> params['action'] == 'kotei' || 
			// $this -> params['action'] == 'seika' || 
			// $this -> params['action'] == 'view') 
		// {
			// $this -> layout = 'default_new';
		// }
		// if ($this -> params['controller'] == 'templates' || 
			// $this -> params['controller'] == 'keywords' || 
			// $this -> params['controller'] == 'rankhistories' ||
			// $this -> params['controller'] == 'users' || 
			// $this -> params['controller'] == 'sales_keywords'
		// ) {
			// $this -> layout = 'default_new';
		// }
		$this -> layout = 'default_new';
	}

	public function beforeRender() {
		parent::beforeRender();
		if (isset($this -> request -> data['User']['password'])) {
			unset($this -> request -> data['User']['password']);
		}
		if (isset($this -> request -> data['User']['pwd'])) {
			unset($this -> request -> data['User']['pwd']);
		}
	}

	public function _setupAuth() {
		if (!$this -> Auth -> user()) {
			$this -> Auth -> loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login');
			$this -> Auth -> authenticate = array('Form' => array('fields' => array('username' => 'email', 'pwd' => 'password')));
			AuthComponent::$sessionKey = 'Auth.User.user';
		} else {
			$this -> Auth -> allow('*');
		}
	}

	public function _setupLayout() {
	}

	public function isAuthorized($user = null) {
		return true;
	}

	public function export($options = null) {
		$this -> autoRender = false;
		$modelClass = $this -> modelClass;
		
		$this -> response -> type('Content-Type: text/csv');
		if (isset($options['filename'])) {
			$this -> response -> download(date('Y-m-d_H-i-s') . '_' . strtolower($options['filename']) . '.csv');
			unset($options['filename']);
		} else {
			$this -> response -> download(date('Y-m-d_H-i-s') . '_' . strtolower(Inflector::pluralize($modelClass)) . '.csv');
		}

		$this -> response -> body($this -> $modelClass -> exportCSV($options));
	}

	public function dateDiff($start, $end) {
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		return round($diff / 86400);
	}

	public function forDate($begin, $end, $interval) {
		$data_date = array();
		do {
			$data_date[] = $begin;
			$begin = date('Y-m-d', strtotime($begin . ' +' . $interval . ' day'));
		} while (strtotime($begin)<=strtotime($end));
		$data_date[] = $end;

		return $data_date;
	}

	public function dayToStep($days) {
		if ($days <= 30) {
			$step = 1;
		} else if ($days >= 31 && $days <= 60) {
			$step = 2;
		} else if ($days >= 61 && $days <= 90) {
			$step = 4;
		} else if ($days >= 91 && $days <= 120) {
			$step = 6;
		} else if ($days >= 121 && $days <= 180) {
			$step = 9;
		} else if ($days >= 181 && $days <= 360) {
			$step = 18;
		} else if ($days > 360) {
			$step = 30;
		}
		return $step;
	}

	// email
	public function sendMail($params = array()) {
		Configure::write('debug', 0);
		//$this->autoRender = false;
		$defaults = array('from' => Configure::read('Mail.from'), 'to' => Configure::read('Mail.to'), 'subject' => Configure::read('Mail.subject'), 'template' => Configure::read('Mail.template'), 'cc' => Configure::read('Mail.cc'),
		//'bcc' => Configure::read('Mail.bcc')
		);
		$options = array_merge($defaults, $params);
		if (count($options) > 0) {
			/*Comment Out if use Mail Server*/
			/*
			 $this->Email->smtpOptions = array(
			 'port' => '465',
			 'timeout' => '120',
			 'host' => 'ssl://smtp.gmail.com',
			 'username' => 'admin@ddnb.info',
			 'password' => ''
			 );
			 $this->Email->delivery = 'smtp';
			 */
			/*SMTP Send Mail*/
			if (isset($options['sendAs'])) {
				$this -> Email -> sendAs = $options['sendAs'];
			} else {
				$this -> Email -> sendAs = "text";
			}
			$this -> Email -> from = $options['from'];
			$this -> Email -> replyTo = $options['from'];
			$this -> Email -> to = $options['to'];
			if (isset($options['cc'])) {
				$this -> Email -> cc = $options['cc'];
			}
			if (isset($options['bcc'])) {
				$this -> Email -> bcc = $options['bcc'];
			}
			$this -> Email -> subject = $options['subject'];
			$this -> Email -> template = $options['template'];
			$this -> set('data', $options['data']);
			try {
				$this -> Email -> send();
				return true;
			} catch (Exception $ex) {
				echo $ex;
				return false;
			}
		}
		return false;
	}

}
