<?php

App::uses('AppController', 'Controller');
/*------------------------------------------------------------------------------------------------------------
 * Rankhistories Controller
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/

class RankhistoriesController extends AppController {

/*------------------------------------------------------------------------------------------------------------
 * index method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function index($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$rankDate = date('Ymd');
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			$rankDate = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;

		$order = array();
		$order['Keyword.UserID'] = 'DESC';
		$order['Rankhistory.updated'] = 'DESC';

		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order, 'limit' => Configure::read('Page.max')));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
		$this -> set('rankDate', $rankDate);
	}

/*------------------------------------------------------------------------------------------------------------
 * sales method
 * 
 * author lecaoquochung@gmail.com
 * created 2015-07
 *-----------------------------------------------------------------------------------------------------------*/
	public function sales($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$rankDate = date('Ymd');
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			$rankDate = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;

		$order = array();
		$order['Keyword.UserID'] = 'DESC';
		$order['Rankhistory.updated'] = 'DESC';

		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group', 'Keyword.cost');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order, 'limit' => Configure::read('Page.max')));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
		$this -> set('rankDate', $rankDate);
	}
	
/*------------------------------------------------------------------------------------------------------------
 * dashboard method
 * 
 * author lecaoquochung@gmail.com
 * created 2015-08
 *-----------------------------------------------------------------------------------------------------------*/
	public function dashboard($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$rankDate = date('Ymd');
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));
		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}
		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}
		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}
		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}
		if ($this -> request -> is('post')) {
			$rankDate = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}
		$this -> Rankhistory -> recursive = 0;
		$order = array();
		$order['Keyword.UserID'] = 'DESC';
		$order['Rankhistory.updated'] = 'DESC';
		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group', 'Keyword.cost', 'Keyword.price');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order, 'limit' => Configure::read('Page.max')));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');
//		Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
		$this -> set('rankDate', $rankDate);
//		debug($rankhistories);exit;
	}

/*------------------------------------------------------------------------------------------------------------
 * rankmobile method
 * 
 * author lecaoquochung@gmail.com
 * created 2015
 *-----------------------------------------------------------------------------------------------------------*/
	public function rankmobile($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$rankDate = date('Ymd');
		$this -> set('rankDate', $rankDate);
		
		$this->loadModel('MRankhistory');
		$this -> MRankhistory -> recursive = 0;
		
		$conds = array();
		$conds['MRankhistory.rankdate'] = date('Ymd');
		$order = array();
		// $order['Keyword.UserID'] = 'DESC';
		$order['MRankhistory.updated'] = 'DESC';
		
		$m_rankhistories = $this -> MRankhistory -> find('all', array('conditions' => $conds, 'order' => $order));
		$this -> set('m_rankhistories', $m_rankhistories);
		// debug($m_rankhistories);exit;

		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * service method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function service($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;

		$order = array();
		$order['Keyword.UserID'] = 'DESC';
		$order['Rankhistory.updated'] = 'DESC';

		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * report method
 * 
 * author lecaoquochung@gmail.com
 * created 2015
 *-----------------------------------------------------------------------------------------------------------*/
	public function report($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;

		$order = array();
		$order['Keyword.UserID'] = 'DESC';
		$order['Rankhistory.updated'] = 'DESC';

		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * seika method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function seika($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.seika'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict');

		// $this->set('rankhistories', $this->Rankhistory->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC')));
		// $this->set('user', $this->Rankhistory->Keyword->User->find('list', array('fields' => array('User.id', 'User.company'))));

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));

	}

/*------------------------------------------------------------------------------------------------------------
 * kotei method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function kotei($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		// ini_set('memory_limit', '512M');s
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.seika'] = 0;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));
		

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * rankcheck method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function rankcheck($status = 0, $rankrange = FALSE) {
		set_time_limit(0);
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 2;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([{1-9}][^0-9])|10 | ([1-9])|10$';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 0;
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict');

		$this -> set('rankhistories', $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC')));
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));
		$keyword_id = Hash::extract($rankhistories, '{n}.Keyword.ID');

		#Extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

		$this -> set('rankhistories', $rankhistories);
		$this -> set('extras', $extras);
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * nocontract method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function nocontract($show_all = 'false', $status = 0) {
		set_time_limit(0);
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 1;
		$conds['Keyword.rankend'] = 0;
		$conds['Keyword.rankend'] >= date('Ymd');

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
			$conds['Rankhistory.rankDate'] = $this -> request -> data['Rankhistory']['rankDate']['year'] . $this -> request -> data['Rankhistory']['rankDate']['month'] . $this -> request -> data['Rankhistory']['rankDate']['day'];
		}

		$this -> Rankhistory -> recursive = 2;
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url');

		$this -> set('rankhistories', $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC')));
		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));
		$this -> set('agent', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.agent'))));
	}

/*------------------------------------------------------------------------------------------------------------
 * kaiyaku method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function kaiyaku($show_all = 'false') {
		set_time_limit(0);
		$conds = array();

		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.rankend <>'] = 0;

		if ($this -> request -> is('post')) {
			if (!empty($this -> request -> data['Rankhistory']['keyword'])) {
				$users = $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%')));
				$conds['OR']['Rankhistory.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Rankhistory']['keyword']), 'UTF-8') . '%';
				$conds['OR']['Keyword.UserID'] = $users;
			}
		}

		$this -> Rankhistory -> recursive = 0;

		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty');

		if ($show_all != 'false') {// Show all
			$this -> set('rankhistories', $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC')));
		} else {// Page first load
			$this -> paginate = array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
			$this -> set('rankhistories', $this -> paginate());
		}

		$this -> set('user', $this -> Rankhistory -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company'))));

		$nocontract_keyword_count = $this -> Rankhistory -> find('count', array('conditions' => array('Rankhistory.RankDate' => date('Ymd'), 'Keyword.nocontract' => 1)));
		$this -> set('nocontract_keyword_count', $nocontract_keyword_count);
	}

/*------------------------------------------------------------------------------------------------------------
 * csv by keyword method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function csv_by_keyword($keyID = null) {
		$this -> Rankhistory -> Keyword -> recursive = 2;
		$fields = array();
		$fields = array('Keyword.id', 'Keyword.Keyword', 'Keyword.Url', 'User.company');
		$keyword = $this -> Rankhistory -> Keyword -> find('first', array('conditions' => array('Keyword.ID' => $keyID), 'fields' => $fields));
		// $keyword['Keyword']['Keyword']
		$this -> export(array('conditions' => array('Rankhistory.KeyID' => $keyID), 'fields' => array('Rankhistory.RankDate', 'Rankhistory.Rank'), 'order' => array('Rankhistory.RankDate' => 'desc'), 'mapHeader' => 'HEADER_CSV_VIEW_KEYWORD', 'insertHeader' => array($keyword['Keyword']['Keyword'], $keyword['User']['company'], $keyword['Keyword']['Url']), 'filename' => $keyword['Keyword']['Keyword'], 'callbackHeader' => 'header_csv_by_keyword', 'callbackRow' => 'row_csv_by_keyword', ));
	}

/*------------------------------------------------------------------------------------------------------------
 * csv all keyword method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function csv_all_keyword($rankrange = FALSE, $rankDate = FALSE, $sales = FALSE) {
		set_time_limit(0);
		$conds = array();
		$conds['Rankhistory.rankDate'] = $rankDate;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = $sales;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . $rankDate))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([^0]|10)/([^0]|10)';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		$this -> Rankhistory -> recursive = 0;

		$fields = array();
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', );

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));

		$this -> export(array(
			'conditions' => $conds,
			// 'fields' => array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank'),
			'fields' => array('Keyword.ID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate'), 
			'contain' => array(
				'Keyword' => array('fields' => array('User.company'), 'conditions' => array('User.id' => 'Keyword.UserID'), )
			), 
			'order' => array('Keyword.ID' => 'desc'), 
			'mapHeader' => 'HEADER_CSV_ALL_KEYWORD', 
			'filename' => '_【MEDIAX】順位チェック' .$rankDate, 
			'callbackHeader' => 'header_csv_all_keyword', 
			'callbackRow' => 'row_csv_all_keyword', 
		));
	}

/*------------------------------------------------------------------------------------------------------------
 * csv kotei keyword method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function csv_kotei_keyword($rankrange = False) {
		set_time_limit(0);
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.seika'] = 0;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([^0]|10)/([^0]|10)';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		$this -> Rankhistory -> recursive = 0;
		$fields = array();
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', );

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));

		$this -> export(array('conditions' => $conds,
		// 'fields' => array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank'),
		'fields' => array('Keyword.ID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank'), 'contain' => array('Keyword' => array('fields' => array('User.company'), 'conditions' => array('User.id' => 'Keyword.UserID'), )), 'order' => array('Keyword.ID' => 'desc'), 'mapHeader' => 'HEADER_CSV_KOTEI_KEYWORD', 'filename' => '_【MEDIAX】順位チェック_固定キーワード', 'callbackHeader' => 'header_csv_all_keyword', 'callbackRow' => 'row_csv_all_keyword', ));
	}

/*------------------------------------------------------------------------------------------------------------
 * csv seika keyword method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function csv_seika_keyword($rankrange = False) {
		set_time_limit(0);
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.seika'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

		if ($rankrange == 10) {
			$conds['Rankhistory.Rank REGEXP'] = '^([^0]|10)/([^0]|10)';
		}

		if ($rankrange == 20) {
			$conds['Rankhistory.Rank REGEXP'] = '^([1][1-9])|20 | ([1][1-9])|20$';
		}

		if ($rankrange == 100) {
			$conds['Rankhistory.Rank REGEXP'] = '^([2-9][1-9])|100 | ([2-9][1-9])|100$';
		}

		if ($rankrange == 1000) {
			$conds['Rankhistory.Rank REGEXP'] = '^([0-0])/([0-0])';
		}

		$this -> Rankhistory -> recursive = 0;
		$fields = array();
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', );

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));

		$this -> export(array('conditions' => $conds,
		// 'fields' => array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank'),
		'fields' => array('Keyword.ID', 'Keyword.Keyword', 'Keyword.Url', 'Rankhistory.Rank'), 'contain' => array('Keyword' => array('fields' => array('User.company'), 'conditions' => array('User.id' => 'Keyword.UserID'), )), 'order' => array('Keyword.ID' => 'desc'), 'mapHeader' => 'HEADER_CSV_KOTEI_KEYWORD', 'filename' => '_【MEDIAX】順位チェック_固定キーワード', 'callbackHeader' => 'header_csv_all_keyword', 'callbackRow' => 'row_csv_all_keyword', ));
	}

/*------------------------------------------------------------------------------------------------------------
 * view method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function view($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		$this -> set('rankhistory', $this -> Rankhistory -> read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this -> request -> is('post')) {
			$this -> Rankhistory -> create();
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'), 'default', array('class' => 'success'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

/*------------------------------------------------------------------------------------------------------------
 * edit method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function edit($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'), 'default', array('class' => 'success'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'), 'default', array('class' => 'success'));
			}
		} else {
			$this -> request -> data = $this -> Rankhistory -> read(null, $id);
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

/*------------------------------------------------------------------------------------------------------------
 * delete method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		if ($this -> Rankhistory -> delete()) {
			$this -> Session -> setFlash(__('Rankhistory deleted'), 'default', array('class' => 'success'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Rankhistory was not deleted'), 'default', array('class' => 'error'));
		$this -> redirect(array('action' => 'index'));
	}

/*------------------------------------------------------------------------------------------------------------
 * color row method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 * logic
 * Color Row method
 * Rank 1->10: blue、 #E4EDF9
 * Rank 11->20: yellow #FAFAD2
 * Rank change from blue range to outsite: Alert red #FFBFBF
 *-----------------------------------------------------------------------------------------------------------*/
	public function color_row() {
		$this -> autoRender = false;
		Configure::write('debug', 0);

		$rankDate = date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day'));

		$rankhistory = Cache::read($this -> request -> data['keyID'] . '_' . $rankDate, 'Rankhistory');

		if (!$rankhistory) {
			$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => $rankDate)));
			Cache::write($this -> request -> data['keyID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}

		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			return '#E4EDF9';
		}

		if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			return '#FAFAD2';
		}

		if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			return '#FFBFBF';
		}
	}

/*------------------------------------------------------------------------------------------------------------
 * arrow row method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
	public function arrow_row() {
		$this -> autoRender = false;
		Configure::write('debug', 0);
		$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day')))));

		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
			return '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			return '<span class="blue-arrow">↑</span>';
		}
	}

/*------------------------------------------------------------------------------------------------------------
 * compare rank method
 * 
 * author lecaoquochung@gmail.com
 * created 2014
 *-----------------------------------------------------------------------------------------------------------*/
 	/*
	 * Arrow Row method
	 * <font style='color:red;font-weight:600'>↓</font>
	 * <font style='color:blue;font-weight:600'>↑</font>
	 *
	 * Rank 1->10: blue、 #E4EDF9
	 * Rank 11->20: yellow #FAFAD2
	 * Rank change from blue range to outsite: Alert red #FFBFBF
	 */
	public function compare_rank() {
		$this -> autoRender = false;
		Configure::write('debug', 0);

		$message = array();
		$rankDate = date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day'));
		$rankhistory = Cache::read($this -> request -> data['keyID'] . '_' . $rankDate, 'Rankhistory');
		if (!$rankhistory) {
			$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day')))));
			Cache::write($this -> request -> data['keyID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}
		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		//color
		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			$message['color'] = '#E4EDF9';
		} else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			$message['color'] = '#FAFAD2';
		} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			$message['color'] = '#FFBFBF';
		} else {
			$message['color'] = '';
		}

		//arrow
		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
			$message['arrow'] = '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			$message['arrow'] = '<span class="blue-arrow">↑</span>';
		} else {
			$message['arrow'] = '';
		}

		return json_encode($message);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this -> Rankhistory -> recursive = 0;
		$this -> set('rankhistories', $this -> paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		$this -> set('rankhistory', $this -> Rankhistory -> read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this -> request -> is('post')) {
			$this -> Rankhistory -> create();
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'), 'default', array('class' => 'success'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'));
			}
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Rankhistory -> read(null, $id);
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		if ($this -> Rankhistory -> delete()) {
			$this -> Session -> setFlash(__('Rankhistory deleted'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Rankhistory was not deleted'));
		$this -> redirect(array('action' => 'index'));
	}

	/**
	 * reset rankend method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function reset_rankend() {
		$this -> autoRender = false;
		Configure::write('debug', 0);
		if (!empty($this -> request -> data['keyID'])) {
			$this -> Rankhistory -> Keyword -> id = $this -> request -> data['keyID'];
			$this -> Rankhistory -> Keyword -> saveField('rankend', 0);
			$this -> Rankhistory -> Keyword -> saveField('kaiyaku_reason', '');
			$this -> Rankhistory -> Keyword -> saveField('nocontract', 0);
			$rankhistory['Rankhistory']['KeyID'] = $this -> request -> data['keyID'];
			$rankhistory['Rankhistory']['Url'] = $this -> request -> data['Url'];
			$rankhistory['Rankhistory']['RankDate'] = date('Ymd');
			$this -> Rankhistory -> create();
			$this -> Rankhistory -> save($rankhistory);
		}
	}

	
	/**
	 * edit_inline method
	 *
	 * @return void
	 */
	public function edit_inline() {
		Configure::write('debug', 0);
		$this -> autoRender = false;
		$this -> Rankhistory -> recursive = -1;
		$this -> Rankhistory -> updateAll(
			array('Rankhistory.'.$this -> request -> data['name'] => "'".$this -> request -> data['value']."'"), 
			array('Rankhistory.ID' => $this -> request -> data['pk'])
		);

		$message = array();
		$message['name'] = $this -> request -> data['name'];
		$message['value'] = $this -> request -> data['value'];
		return json_encode($message);
	}		
}
