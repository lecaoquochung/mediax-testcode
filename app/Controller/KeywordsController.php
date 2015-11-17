<?php

App::uses('AppController', 'Controller');

/**
 * Keywords Controller
 *
 * @property Keyword $Keyword
 */
class KeywordsController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		set_time_limit(0);
		$conds = array();
		$fields = array();
		$offset = 0;
		$c_logic = 0;

		if ($this -> request -> is('post') && !empty($this -> request -> data['Keyword']['keyword'])) {
			$conds['OR']['Keyword.keyword LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Keyword']['keyword']), 'UTF-8') . '%';
			$conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this -> request -> data['Keyword']['keyword']), 'UTF-8') . '%';
		}
		$this -> Keyword -> recursive = 0;
		
		// filter keyword
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
//		$conds['Keyword.c_logic'] = $c_logic;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);

		$fields = array(
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Keyword.Enabled', 'Keyword.Price', 'Keyword.nocontract', 'Keyword.limit_price',
			'Keyword.Penalty', 'Keyword.c_logic', 'Keyword.created', 'Keyword.updated', 'Keyword.cost','Keyword.sales', 'Keyword.server_id',
			'User.id', 'User.company', 'User.name', 'User.loginip', 'User.logintime',
			'Server.id', 'Server.name', 'Server.ip', 'Server.api',
		);

		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Keyword.ID ASC', 'offset' => $offset));
		$now = time();
		$two_weeks = 7 * 24 * 60 * 60;

		$loop = 0;
		foreach ($keywords as $keyword) {
			$created_date = strtotime($keyword['Keyword']['created']);
			if ($now - $created_date > $two_weeks) {
				$keywords[$loop]['Keyword']['NewKeyword'] = 0;
			} else {
				$keywords[$loop]['Keyword']['NewKeyword'] = 1;
			}
			$loop++;
		}

		$this -> set('keywords', $keywords);
	}

	/**
	 * nocontractlist method
	 *
	 * @return void
	 */
	public function nocontractlist() {
		set_time_limit(0);
		$conds = array();
		$fields = array();

		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 1;
		$conds['Keyword.rankend'] = 0;

		$this -> Keyword -> recursive = 0;

		$fields = array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Keyword.Enabled', 'Keyword.Price', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.created', 'Keyword.updated', 'User.id', 'User.company', 'User.name', 'User.loginip', 'User.logintime');

		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Keyword.ID DESC'));

		$this -> set('keywords', $keywords);
	}

	/**
	 * kaiyakulist method
	 *
	 * @return void
	 */
	public function kaiyakulist() {
		set_time_limit(0);
		$conds = array();
		$fields = array();
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.rankend <>'] = 0;
		$conds['Keyword.rankend <'] = date('Ymd', strtotime('-1 month' . date('Ymd')));
		$this -> Keyword -> recursive = 0;
		$fields = array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Keyword.Enabled', 'Keyword.rankend', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.created', 'Keyword.updated', 'User.id', 'User.company', 'User.name', 'User.loginip', 'User.logintime');
		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Keyword.updated DESC'));
		$this -> set('keywords', $keywords);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null, $show_all = 'false') {
		$this -> loadModel('Engine');
		$engine_list = $this -> Engine -> find('all');
		$this -> Keyword -> id = $id;
		$this -> Keyword -> recursive = 0;

		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}

		$this -> set('keyword', $this -> Keyword -> read(null, $id));
		$this -> set('engine_list', $engine_list);
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate');
		$conds = array();
		$conds['Rankhistory.KeyID'] = $id;

		# show only data of this month
		$month_start_day = date('Ym') . '01';
		$month_end_day = date('Ym') . '31';
		$conds1 = array();
		$conds1['Rankhistory.KeyID'] = $id;

		if ($show_all == 10) {
			$conds1['Rankhistory.Rank REGEXP'] = '^([1-9]|10)/([1-9]|10)';
			$conds1['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m")'] = date('Y-m');
			$this -> Paginator -> settings = array('limit' => 1000, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		} else if ($show_all != 'false') {
			 // show all condition
			$conds1['DATE_FORMAT(Rankhistory.RankDate,"%Y")'] = date('Y'); // show year
			$this -> Paginator -> settings = array('limit' => 1000, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		} else {
			 // show all month
			$conds1['Rankhistory.RankDate BETWEEN ? AND ?'] = array($month_start_day, $month_end_day);
			$this -> Paginator -> settings = array('limit' => 31, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		}
		$data_rankhistories = $this -> paginate('Rankhistory');

		if ($this -> request -> is('post')) {
			if (!isset($this -> request -> data['Rankhistory']['data_rank_history'])) {
				 # graph data　with Ajax
				$beginDate = implode('-', $this -> request -> data['Rankhistory']['RankDate1']);
				$endDate = implode('-', $this -> request -> data['Rankhistory']['RankDate2']);
				$days = $this -> dateDiff($beginDate, $endDate);
				
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array(implode('', $this -> request -> data['Rankhistory']['RankDate1']), implode('', $this -> request -> data['Rankhistory']['RankDate2']));
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
				$this -> set(compact('rankhistories'));

				// custom show rank data
				$conds1['Rankhistory.RankDate BETWEEN ? AND ?'] = array(implode('', $this -> request -> data['Rankhistory']['RankDate1']), implode('', $this -> request -> data['Rankhistory']['RankDate2']));
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			} elseif($this -> request -> data['Rankhistory']['show_by_year'] == 1) {
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y")'] = $this -> request -> data['Rankhistory']['RankDate_list']['year']; // show year
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));

				# graph data
				$beginDate = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-01-01';
				$endDate = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-12-31';
				$days = $this -> dateDiff($beginDate, $endDate);
				$beginDate_db = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '0101';
				$endDate_db = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '1231';
				
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($beginDate_db, $endDate_db);
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			} else {
				 # history rank date: choose month data from select month
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('limit' => 1000, 'conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m")'] = date('Y-m', strtotime($this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-' . $this -> request -> data['Rankhistory']['RankDate_list']['month']));
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));

				# graph data
				$beginDate = implode('-', $this -> request -> data['Rankhistory']['RankDate_list']) . '-01';
				$endDate = implode('-', $this -> request -> data['Rankhistory']['RankDate_list']) . '-31';
				$days = $this -> dateDiff($beginDate, $endDate);
				$beginDate_db = implode('', $this -> request -> data['Rankhistory']['RankDate_list']) . '01';
				$endDate_db = implode('', $this -> request -> data['Rankhistory']['RankDate_list']) . '31';

				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($beginDate_db, $endDate_db);
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			}
		} else {
			 // page first load
			if (count($data_rankhistories) > 0) {
				$rankhistories = array_slice($data_rankhistories, 0, 31);
			} else {
				$rankhistories = array();
			}
		}

		// tooday rank set boolean
		$today_rank = 1;
		$this -> set('today_rank', $today_rank);

		// extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extra = $this -> Extra -> find('list', array('fields' => array('Extra.ExtraType', 'Extra.Price'), 'conditions' => array('Extra.KeyID' => $id)));
		$this -> set('extra', $extra);

		$this -> set(compact('data_rankhistories', 'rankhistories'));
	}

/*------------------------------------------------------------------------------------------------------------
 * keywords ranklog (NEW view)
 * 
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20151113 
 * @updated
 *-----------------------------------------------------------------------------------------------------------*/	
	public function ranklog($id = null, $show_all = 'false') {
		$this -> loadModel('Engine');
		$engine_list = $this -> Engine -> find('all');
		$this -> Keyword -> id = $id;
		$this -> Keyword -> recursive = 0;

		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}

		$this -> set('keyword', $this -> Keyword -> read(null, $id));
		$this -> set('engine_list', $engine_list);
		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate');
		$conds = array();
		$conds['Rankhistory.KeyID'] = $id;

		# show only data of this month
		$month_start_day = date('Ym') . '01';
		$month_end_day = date('Ym') . '31';
		$conds1 = array();
		$conds1['Rankhistory.KeyID'] = $id;

		if ($show_all == 10) {
			$conds1['Rankhistory.Rank REGEXP'] = '^([1-9]|10)/([1-9]|10)';
			$conds1['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m")'] = date('Y-m');
			$this -> Paginator -> settings = array('limit' => 1000, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		} else if ($show_all != 'false') {
			 // show all condition
			$conds1['DATE_FORMAT(Rankhistory.RankDate,"%Y")'] = date('Y'); // show year
			$this -> Paginator -> settings = array('limit' => 1000, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		} else {
			 // show all month
			$conds1['Rankhistory.RankDate BETWEEN ? AND ?'] = array($month_start_day, $month_end_day);
			$this -> Paginator -> settings = array('limit' => 31, 'conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC');
		}
		$data_rankhistories = $this -> paginate('Rankhistory');

		if ($this -> request -> is('post')) {
			if (!isset($this -> request -> data['Rankhistory']['data_rank_history'])) {
				 # graph data　with Ajax
				$beginDate = implode('-', $this -> request -> data['Rankhistory']['RankDate1']);
				$endDate = implode('-', $this -> request -> data['Rankhistory']['RankDate2']);
				$days = $this -> dateDiff($beginDate, $endDate);
				
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array(implode('', $this -> request -> data['Rankhistory']['RankDate1']), implode('', $this -> request -> data['Rankhistory']['RankDate2']));
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
				$this -> set(compact('rankhistories'));

				// custom show rank data
				$conds1['Rankhistory.RankDate BETWEEN ? AND ?'] = array(implode('', $this -> request -> data['Rankhistory']['RankDate1']), implode('', $this -> request -> data['Rankhistory']['RankDate2']));
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds1, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			} elseif($this -> request -> data['Rankhistory']['show_by_year'] == 1) {
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y")'] = $this -> request -> data['Rankhistory']['RankDate_list']['year']; // show year
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));

				# graph data
				$beginDate = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-01-01';
				$endDate = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-12-31';
				$days = $this -> dateDiff($beginDate, $endDate);
				$beginDate_db = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '0101';
				$endDate_db = $this -> request -> data['Rankhistory']['RankDate_list']['year'] . '1231';
				
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($beginDate_db, $endDate_db);
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			} else {
				 # history rank date: choose month data from select month
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('limit' => 1000, 'conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m")'] = date('Y-m', strtotime($this -> request -> data['Rankhistory']['RankDate_list']['year'] . '-' . $this -> request -> data['Rankhistory']['RankDate_list']['month']));
				$data_rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));

				# graph data
				$beginDate = implode('-', $this -> request -> data['Rankhistory']['RankDate_list']) . '-01';
				$endDate = implode('-', $this -> request -> data['Rankhistory']['RankDate_list']) . '-31';
				$days = $this -> dateDiff($beginDate, $endDate);
				$beginDate_db = implode('', $this -> request -> data['Rankhistory']['RankDate_list']) . '01';
				$endDate_db = implode('', $this -> request -> data['Rankhistory']['RankDate_list']) . '31';

				$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d")'] = $this -> forDate($beginDate, $endDate, $this->dayToStep($days));
				$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($beginDate_db, $endDate_db);
				$rankhistories = $this -> Keyword -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			}
		} else {
			 // page first load
			if (count($data_rankhistories) > 0) {
				$rankhistories = array_slice($data_rankhistories, 0, 31);
			} else {
				$rankhistories = array();
			}
		}

		// tooday rank set boolean
		$today_rank = 1;
		$this -> set('today_rank', $today_rank);

		// extra
		$this -> loadModel('Extra');
		$this -> Extra -> recursive = -1;
		$extra = $this -> Extra -> find('list', array('fields' => array('Extra.ExtraType', 'Extra.Price'), 'conditions' => array('Extra.KeyID' => $id)));
		$this -> set('extra', $extra);

		$this -> set(compact('data_rankhistories', 'rankhistories'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this -> request -> is('post')) {
			$EndDate = date('Ymd', strtotime('+ 6 months' . implode('', $this -> request -> data['Keyword']['rankstart'])));
			$this -> request -> data['Keyword']['rankstart'] = implode('', $this -> request -> data['Keyword']['rankstart']);
			$this -> request -> data['Keyword']['Enabled'] = 1;
			$this -> Keyword -> create();
			if ($this -> Keyword -> save($this -> request -> data)) {
				$this -> request -> data['Rankhistory']['KeyID'] = $this -> Keyword -> id;
				$this -> request -> data['Rankhistory']['Url'] = $this -> request -> data['Keyword']['Url'];
				$this -> request -> data['Rankhistory']['RankDate'] = date('Ymd');

				$this -> request -> data['Duration']['KeyID'] = $this -> Keyword -> id;
				$this -> request -> data['Duration']['StartDate'] = $this -> request -> data['Keyword']['rankstart'];
				$this -> request -> data['Duration']['EndDate'] = $EndDate;
				$this -> request -> data['Duration']['Flag'] = 1;

				if ($this -> Keyword -> Rankhistory -> save($this -> request -> data) && $this -> Keyword -> Duration -> save($this -> request -> data)) {
					$this -> Session -> setFlash(__('The keyword has been saved'), 'default', array('class' => 'success'));
					$this -> redirect($this -> referer());
				} else {
					$this -> Session -> setFlash(__('The keyword could not be saved. Please, try again.'), 'default', array('class' => 'error'));
				}
			} else {
				$this -> Session -> setFlash(__('The keyword could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$users = $this -> Keyword -> User -> find('list', array('fields' => array('User.company')));
		$this -> set(compact('users'));
	}

	/**
	 * extra method : extra keyword method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function extra($id = null) {
		$this -> loadModel('Extra');
		$this -> Keyword -> recursive = 0;
		$this -> Keyword -> id = $id;
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Keyword -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The keyword has been saved'));
				$this -> redirect(array('controller' => 'rankhistories', 'action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The keyword could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Keyword -> read(null, $id);
		}
		$keywords = $this -> Keyword -> find('all', array('conditions' => array('Keyword.ID' => $id)));
		$extras = $this -> Keyword -> Extra -> find('all', array('conditions' => array('Extra.KeyID' => $id)));
		$this -> set(compact('keywords', 'extras'));
	}

	/**
	 * edit method : edit keyword method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null, $layout = null) {
		$this -> Keyword -> id = $id;
		$this -> Keyword -> Rankhistory -> id = $this -> Keyword -> Rankhistory -> find('first', array('conditions' => array('KeyID' => $this -> Keyword -> id, 'RankDate' => date('Ymd'))));
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			
			if (isset($this -> request -> data['Keyword']['rankend'])) {
				$this -> request -> data['Keyword']['rankend'] = implode('', $this -> request -> data['Keyword']['rankend']);
			}
			$this -> request -> data['Rankhistory']['updated'] = date('Y-m-d H:i:s');

			if ($this -> Keyword -> save($this -> request -> data)) {
				$this -> Keyword -> Rankhistory -> save($this -> request -> data);
				if (isset($this -> request -> data['Keyword']['kaiyaku_reason'])) {
					$this -> Session -> setFlash(__('The keyword has been cancelled.'), 'default', array('class' => 'error'));
					if ($this -> request -> data['Keyword']['rankend'] < date('Ymd', strtotime('-1 month' . date('Ymd')))) {
						if(empty($layout)){
							$this -> redirect(array('controller' => 'keywords', 'action' => 'kaiyakulist'));
						}else{
							$this -> set('close_window','close_window');
						}												
					} else {
						// $this->redirect(array('controller'=>'rankhistories','action'=>'index'));
						if(empty($layout)){
							$this -> redirect($this -> referer());
						}else{
							$this -> set('close_window','close_window');
						}
					}
				} else {
					$this -> Session -> setFlash(__('The keyword has been saved'), 'default', array('class' => 'success'));
					// $this -> redirect(array('controller' => 'rankhistories', 'action' => 'index'));
					if(empty($layout)){
						$this -> redirect($this -> referer());
					}else{
						$this -> set('close_window','close_window');
					}
				}
			} else {
				$this -> Session -> setFlash(__('The keyword could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$this -> request -> data = $this -> Keyword -> read(null, $id);
		}
		$users = $this -> Keyword -> User -> find('list', array('fields' => array('User.id', 'User.company')));
		$this -> set(compact('users'));
		if(!empty($layout)){
			$this->layout = 'popup';
		}
	}

	/**
	 * cancel method : cancel keyword method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function cancel($id = null) {
		$this -> Keyword -> id = $id;
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}

		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			$this -> request -> data['Keyword']['rankend'] = implode('', $this -> request -> data['Keyword']['rankend']);
			$this -> request -> data['Keyword']['nocontract'] = 1;
			if ($this -> Keyword -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The keyword has been cancelled'));
				$this -> redirect(array('controller' => 'rankhistories', 'action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The keyword could not be cancelled. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Keyword -> read(null, $id);
		}
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this -> request -> is('post')) {
			throw new MethodNotAllowedException();
		}
		$this -> Keyword -> id = $id;
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}
		if ($this -> Keyword -> delete()) {
			$this -> Session -> setFlash(__('Keyword deleted'));
			$this -> redirect(array('action' => 'index'));
		}
		$this -> Session -> setFlash(__('Keyword was not deleted'));
		$this -> redirect(array('action' => 'index'));
	}

	/**
	 * enabled method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function enabled($id = null, $enabled) {
		$this -> Keyword -> id = $id;
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}
		if ($this -> Keyword -> saveField('Enabled', $enabled)) {
			$this -> Session -> setFlash(__('Keyword ' . ($enabled == 1 ? 'enabled' : 'diabled')));
			$this -> redirect($this -> referer());
		}
		$this -> Session -> setFlash(__('Keyword was not ' . ($enabled == 1 ? 'enabled' : 'diabled')));
		$this -> redirect($this -> referer());
	}

	/**
	 * set all keyword enddate method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function set_all_keyword_enddate() {
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Keyword -> updateAll(array('Keyword.rankend' => implode('', $this -> request -> data['Keyword']['rankend']), 'Keyword.kaiyaku_reason' => implode('', $this -> request -> data['Keyword']['kaiyaku_reason']), 'Keyword.updated' => "'" . date('Y-m-d H:i:s') . "'"), array('Keyword.UserID' => $this -> request -> data['Keyword']['UserID'], 'Keyword.nocontract' => $this -> request -> data['Keyword']['nocontract'], 'Keyword.rankend' => 0, 'Keyword.ID' => $this -> request -> data['Keyword']['id'], ))) {
				$this -> Session -> setFlash(__('The keyword has been kaiyaku'), 'default', array('class' => 'success'));
				$this -> redirect($this -> referer());
			} else {
				$this -> Session -> setFlash(__('The keyword could not be kaiyaku. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

	/**
	 * Set nocontract method ajax
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function nocontract($id = null, $nocontract) {
		$this -> Keyword -> id = $id;
		if (!$this -> Keyword -> exists()) {
			throw new NotFoundException(__('Invalid keyword'));
		}
		if ($this -> Keyword -> saveField('nocontract', $nocontract)) {
			$this -> Session -> setFlash(__('Keyword was set to ' . ($nocontract == 1 ? 'Nocontract' : 'Contract')));
			$this -> redirect($this -> referer());
		}
		$this -> Session -> setFlash(__('Keyword was set to' . ($nocontract == 1 ? 'Nocontract' : 'Contract')));
		$this -> redirect($this -> referer());
	}

	/**
	 * load rank method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function load_rank($nocontract = 0) {
		$this -> autoRender = false;
		Configure::write('debug', 0);
		set_time_limit(0);
		$this -> Keyword -> recursive = -1;

		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.rankend'] = 0;
		$conds['Keyword.ID'] = $this -> request -> data['keyID'];
		$conds['Keyword.nocontract'] = $nocontract;

		$keyword = $this -> Keyword -> find('first', array('conditions' => $conds));

		if ($keyword != false) {
			if ($keyword['Keyword']['Strict'] == 1) {
				$domain = $this -> Rank -> remainUrl($keyword['Keyword']['Url']);
			} else {
				$domain = $this -> Rank -> remainDomain($keyword['Keyword']['Url']);
			}
		}

		$engine = $keyword['Keyword']['Engine'];
		if ($engine == 3) {
			$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword']) . '/' . $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword']);
		} elseif ($engine == 6) {
			$rank = $this -> Rank -> keyWordRank('google_en', $domain, $keyword['Keyword']['Keyword']) . '/' . $this -> Rank -> keyWordRank('yahoo_en', $domain, $keyword['Keyword']['Keyword']);
		} elseif ($engine == 7) {//mobile search engine
			$rank = $this -> RankMobile -> keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword']);
		} elseif ($engine == 8) {
			$rank = $this -> RankMobile -> keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword']);
		} else {//end
			$engine_list = $this -> Rank -> getEngineList();
			$rank = $this -> Rank -> keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
		}

		//delete Rankhistory current date
		$this -> Keyword -> Rankhistory -> deleteAll(array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => date('Ymd')));
		//Insert Rankhistory current date
		$rankhistory['Rankhistory']['KeyID'] = $keyword['Keyword']['ID'];
		$rankhistory['Rankhistory']['Url'] = $domain;
		$rankhistory['Rankhistory']['Rank'] = $rank;
		$rankhistory['Rankhistory']['RankDate'] = date('Ymd');
		//check color and arrow
		$check_params = array();
		$rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));
		$data_rankhistory = Cache::read($keyword['Keyword']['ID'] . '_' . $rankDate, 'Rankhistory');
		if (!$data_rankhistory) {
			$data_rankhistory = $this -> Keyword -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => $rankDate)));
			Cache::write($keyword['Keyword']['ID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}
		if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($rank) && strpos($rank, '/')) {
			$rank_new = explode('/', $rank);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		//color
		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			$check_params['color'] = '#E4EDF9';
		} else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			$check_params['color'] = '#FAFAD2';
		} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			$check_params['color'] = '#FFBFBF';
		} else {
			$check_params['color'] = '';
		}

		//arrow
		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1] || $rank_new[0] == 0 && $rank_old[0] != 0 || $rank_new[1] == 0 && $rank_old[1] != 0) {
			$check_params['arrow'] = '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			$check_params['arrow'] = '<span class="blue-arrow">↑</span>';
		} else {
			$check_params['arrow'] = '';
		}

		$rankhistory['Rankhistory']['params'] = json_encode($check_params);
		$this -> Keyword -> Rankhistory -> create();
		$this -> Keyword -> Rankhistory -> save($rankhistory);

		$duration = $this -> Keyword -> Duration -> find('first', array('fields' => array('Duration.StartDate'), 'conditions' => array('Duration.KeyID' => $keyword['Keyword']['ID'], 'Duration.Flag' => 2), 'order' => 'Duration.ID'));

		if ($duration == false) {
			if (strpos($rank, '/') !== false) {
				$ranks = explode('/', $rank);
				$google_rank = $ranks[0];
				$yahoo_rank = $ranks[1];
			}

			if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
				$durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
				$durations['Duration']['StartDate'] = date('Ymd');
				$durations['Duration']['EndDate'] = 0;
				$durations['Duration']['Flag'] = 2;
				$this -> Keyword -> Duration -> create();
				$this -> Keyword -> Duration -> save($durations);
			}
		}
	}

	/**
	 * load rank one method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function load_rank_one() {
		$this -> autoRender = false;
		Configure::write('debug', 0);
		set_time_limit(0);
		$this -> Keyword -> recursive = -1;
		$keyword = $this -> Keyword -> find('first', array('conditions' => array('Keyword.Enabled' => 1, 'Keyword.ID' => $this -> request -> data['keyID'])));

		if ($keyword != false) {
			if ($keyword['Keyword']['Strict'] == 1) {
				$domain = $this -> Rank -> remainUrl($keyword['Keyword']['Url']);
			} else {
				$domain = $this -> Rank -> remainDomain($keyword['Keyword']['Url']);
			}
		}

		$engine = $keyword['Keyword']['Engine'];

		if ($engine == 3) {
			$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']) 
			.'/' 
			. $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
		} elseif ($engine == 1) {
			$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
		} elseif ($engine == 2) {
			$rank = $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
		} else { // end
			$engine_list = Configure::read('ENGINES');
			$rank = $this -> Rank -> keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
		}

		// delete Rankhistory current date
		$this -> Keyword -> Rankhistory -> deleteAll(array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => date('Ymd')));

		// insert Rankhistory current date
		$rankhistory['Rankhistory']['KeyID'] = $keyword['Keyword']['ID'];
		$rankhistory['Rankhistory']['Url'] = $domain;
		$rankhistory['Rankhistory']['Rank'] = $rank;
		$rankhistory['Rankhistory']['RankDate'] = date('Ymd');

		// check color and arrow
		$check_params = array();
		$rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));
		$data_rankhistory = Cache::read($keyword['Keyword']['ID'] . '_' . $rankDate, 'Rankhistory');

		$this -> loadModel('Rankhistory');
		if (!$data_rankhistory) {
			$data_rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => $rankDate)));
			Cache::write($keyword['Keyword']['ID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}

		if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
		} elseif (isset($data_rankhistory['Rankhistory']['Rank']) && !strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old[0] = $data_rankhistory['Rankhistory']['Rank'];
			$rank_old[1] = $data_rankhistory['Rankhistory']['Rank'];
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if ($engine == 1) {
			$rank = $rank . '/' . $rank;
		}

		if ($engine == 2) {
			$rank = $rank . '/' . $rank;
		}

		if (!empty($rank) && strpos($rank, '/')) {
			$rank_new = explode('/', $rank);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		// color
		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			$check_params['color'] = '#E4EDF9';
		} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			$check_params['color'] = '#FFBFBF';
		} else if ($rank_new[0] > 10 && $rank_new[0] <= 20 || $rank_new[1] > 10 && $rank_new[1] <= 20) {
			$check_params['color'] = '#FAFAD2';
		} else {
			$check_params['color'] = '';
		}

		// arrow
		if (($rank_new[0] > $rank_old[0] && $rank_old[0] !=0) || ($rank_new[1] > $rank_old[1] && $rank_old[1] !=0) || ($rank_new[0] == 0 && $rank_old[0] != 0) || ($rank_new[1] == 0 && $rank_old[1] != 0)) {
			$check_params['arrow'] = '<span class="red-arrow">↓</span>';
		} else if (($rank_new[0] < $rank_old[0]) || ($rank_new[1] < $rank_old[1]) || ($rank_old[0] == 0 && $rank_new[0] != 0)) {
			$check_params['arrow'] = '<span class="blue-arrow">↑</span>';
		} else {
			$check_params['arrow'] = '';
		}

		$rankhistory['Rankhistory']['params'] = json_encode($check_params);
		$this -> Keyword -> Rankhistory -> create();
		$this -> Keyword -> Rankhistory -> save($rankhistory);

		$duration = $this -> Keyword -> Duration -> find('first', array('fields' => array('Duration.StartDate'), 'conditions' => array('Duration.KeyID' => $keyword['Keyword']['ID'], 'Duration.Flag' => 2), 'order' => 'Duration.ID'));

		if ($duration == false) {
			if (strpos($rank, '/') !== false) {
				$ranks = explode('/', $rank);
				$google_rank = $ranks[0];
				$yahoo_rank = $ranks[1];
			}

			if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
				$durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
				$durations['Duration']['StartDate'] = date('Ymd');
				$durations['Duration']['EndDate'] = 0;
				$durations['Duration']['Flag'] = 2;
				$this -> Keyword -> Duration -> create();
				$this -> Keyword -> Duration -> save($durations);
			}
			sleep(1);
		}
		$this->Security->SystemLog(array('Load Rank One', $data_rankhistory['Rankhistory']['Rank'], $rankhistory['Rankhistory']['Rank'], $this->Session->read('Auth.User.user.email'), $this->here));
	}

	/**
	 * test load rank one method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function test_load_rank_one() {
		$this -> layout = "templates/testcode";
		
		if ($this -> request -> is('post')) {
			//$keyword['Keyword']['Strict'] == 0; // 0:部分一致、　1:完全一致
				if ($this->request->data['Keyword']['Strict'] == 1) {
					$domain = $this -> Rank -> remainUrl($this->request->data['Keyword']['Url']);
				} else {
					$domain = $this -> Rank -> remainDomain($this->request->data['Keyword']['Url']);
				}
				
			$engine = 3;
			$rank = array();
			$rank['google_jp'] = $this -> Rank -> keyWordRankTest('google_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0);
			// $rank['yahoo_jp'] = $this -> Rank -> keyWordRankTest('yahoo_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0);
			
			// $rank['google_jp'] = $this -> Rank -> GoogleJP('google_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0, False);
			// $rank['yahoo_jp'] = $this -> Rank -> YahooJP('yahoo_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0, 1, False, False, 9);
			
			// $rank['google_jp_mobile'] = $this -> RankMobile -> GoogleJPPro('google_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0, False);
			// $rank['yahoo_jp_mobile'] = $this -> RankMobile -> YahooJPPro('yahoo_jp', $domain, $this->request->data['Keyword']['Keyword'], $this->request->data['Keyword']['Strict'], 0, False);
			
			$rank = json_encode($rank);
			
			$google_cache_link = '/rankcache_new/rankmobile/' . date('Ymd') .'/' .md5(mb_convert_encoding($this->request->data['Keyword']['Keyword'] ."_google_jp", 'EUC-JP')) .'.html';
			$yahoo_cache_link = 'http://' .$_SERVER['SERVER_NAME'] .'/rankcache_new/rankmobile/' .date('Ymd') .'/' .md5(mb_convert_encoding($this->request->data['Keyword']['Keyword'] ."_yahoo_jp", 'EUC-JP')) .'.html';
			$cache_text = "";
			$cache_text = '<a href="../../../..' .$google_cache_link .'" target="_blank">キャッシュ</a> / ';
			$cache_text .= '<a href="' .$yahoo_cache_link .'" target="_blank">キャッシュ</a>';
		}

		$this -> set(compact('rank', 'cache_text', 'domain'));
	}

	/**
	 * load all rank method
	 * Field: 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.rankend', 'Keyword.Strict', 'Keyword.Url', 'Keyword.Engine'
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function load_all_rank() {
		#$this->autoRender = false;
		$message = array();
		#Configure::write('debug', 0);
		set_time_limit(0);
		$this -> Keyword -> recursive = -1;

		// Filter keyword
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.rankend'] = 0;

		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds));

		foreach ($keywords as $keyword) {
			sleep(4);
			if ($keyword != false) {
				if ($keyword['Keyword']['Strict'] == 1) {
					$domain = $this -> Rank -> remainUrl($keyword['Keyword']['Url']);
				} else {
					$domain = $this -> Rank -> remainDomain($keyword['Keyword']['Url']);
				}
			}

			$engine = $keyword['Keyword']['Engine'];

			if ($engine == 3) {
				$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword']) . '/' . $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword']);
			} elseif ($engine == 6) {
				$rank = $this -> Rank -> keyWordRank('google_en', $domain, $keyword['Keyword']['Keyword']) . '/' . $this -> Rank -> keyWordRank('yahoo_en', $domain, $keyword['Keyword']['Keyword']);
			} elseif ($engine == 7) { // mobile search engine
				$rank = $this -> RankMobile -> keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword']);
			} elseif ($engine == 8) {
				$rank = $this -> RankMobile -> keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword']);
			} else { // end
				$engine_list = $this -> Rank -> getEngineList();
				$rank = $this -> Rank -> keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword']);
			}

			// delete Rankhistory current date
			$this -> Keyword -> Rankhistory -> deleteAll(array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => date('Ymd')));
			
			// insert Rankhistory current date
			$rankhistory['Rankhistory']['KeyID'] = $keyword['Keyword']['ID'];
			$rankhistory['Rankhistory']['Url'] = $domain;
			$rankhistory['Rankhistory']['Rank'] = $rank;
			$rankhistory['Rankhistory']['RankDate'] = date('Ymd');
			
			// check color and arrow
			$check_params = array();
			$rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));
			$data_rankhistory = Cache::read($keyword['Keyword']['ID'] . '_' . $rankDate, 'Rankhistory');
			
			// no cache
			if (!$data_rankhistory) {
				$data_rankhistory = $this -> Keyword -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => $rankDate)));
				Cache::write($keyword['Keyword']['ID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
			}
			
			// already cache
			if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
				$rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
			} else {
				$rank_old[0] = 0;
				$rank_old[1] = 0;
			}
			// check rank is not empty and has a slash
			if (!empty($rank) && strpos($rank, '/')) {
				$rank_new = explode('/', $rank);
			} else {
				$rank_new[0] = 0;
				$rank_new[1] = 0;
			}

			// color
			if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
				$check_params['color'] = '#E4EDF9';
			} else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
				$check_params['color'] = '#FAFAD2';
			} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
				$check_params['color'] = '#FFBFBF';
			} else {
				$check_params['color'] = '';
			}

			// arrow
			if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
				$check_params['arrow'] = '<span class="red-arrow">↓</span>';
			} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
				$check_params['arrow'] = '<span class="blue-arrow">↑</span>';
			} else {
				$check_params['arrow'] = '';
			}

			$rankhistory['Rankhistory']['params'] = json_encode($check_params);
			$this -> Keyword -> Rankhistory -> create();
			$this -> Keyword -> Rankhistory -> save($rankhistory);
			// Old code rewrite
			$duration = $this -> Keyword -> Duration -> find('first', array('fields' => array('Duration.StartDate'), 'conditions' => array('Duration.KeyID' => $keyword['Keyword']['ID'], 'Duration.Flag' => 2), 'order' => 'Duration.ID'));
			//
			if ($duration == false) {
				if (strpos($rank, '/') !== false) {
					$ranks = explode('/', $rank);
					$google_rank = $ranks[0];
					$yahoo_rank = $ranks[1];
				}

				if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
					$durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
					$durations['Duration']['StartDate'] = date('Ymd');
					$durations['Duration']['EndDate'] = 0;
					$durations['Duration']['Flag'] = 2;
					$this -> Keyword -> Duration -> create();
					$this -> Keyword -> Duration -> save($durations);
				}
			}

			$message[] = $keyword['Keyword']['ID'];
		}
		echo implode(', ', $message);
		$this -> redirect($this -> referer());
	}

	/**
	 * daily update ranks method
	 *
	 * @return void
	 */
	public function daily_update_ranks() {
		if (!empty($this -> request -> data) && !empty($this -> request -> data['keyID']) && !isset($this -> request -> data['Keyword'])) {
			$this -> load_rank($this -> request -> data['nocontract']);
			$message_data = array();
			$data_keywords = json_decode($this -> request -> data['keywords'], true);

			if (count($data_keywords) > 0) {
				$message_data['keyID'] = $data_keywords[0];
				unset($data_keywords[0]);
				$message_data['keywords'] = json_encode(array_values($data_keywords));
			} else {
				$message_data['keyID'] = '';
			}
			return json_encode($message_data);
		}

		$this -> Keyword -> recursive = -1;
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.rankend'] = 0;

		$conds['Keyword.nocontract'] = 1;
		if (isset($this -> request -> data['Keyword']['offset_nocontract']) && isset($this -> request -> data['Keyword']['limit_nocontract'])) {
			$keyword_nocontacts = $this -> Keyword -> find('list', array('fields' => array('Keyword.ID', 'Keyword.ID'), 'conditions' => $conds, 'limit' => $this -> request -> data['Keyword']['limit_nocontract'], 'offset' => $this -> request -> data['Keyword']['offset_nocontract']));
		} else {
			$keyword_nocontacts = $this -> Keyword -> find('list', array('fields' => array('Keyword.ID', 'Keyword.ID'), 'conditions' => $conds));
		}

		$conds['Keyword.nocontract'] = 0;
		if (isset($this -> request -> data['Keyword']['offset']) && isset($this -> request -> data['Keyword']['limit'])) {
			$keywords = $this -> Keyword -> find('list', array('fields' => array('Keyword.ID', 'Keyword.ID'), 'conditions' => $conds, 'limit' => $this -> request -> data['Keyword']['limit'], 'offset' => $this -> request -> data['Keyword']['offset']));
		} else {
			$keywords = $this -> Keyword -> find('list', array('fields' => array('Keyword.ID', 'Keyword.ID'), 'conditions' => $conds));
		}

		$this -> set(compact('keywords', 'keyword_nocontacts'));
	}

	public function count_keyword() {
		Configure::write('debug', 0);
		$this -> autoRender = false;
		$conds = array();

		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.rankend'] = 0;

		$count = $this -> Keyword -> find('count', array('conditions' => $conds));
		$message = array();
		$message['count'] = $count;
		return json_encode($message);
	}

	public function count_nocontract() {
		Configure::write('debug', 0);
		$this -> autoRender = false;
		$conds = array();

		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 1;
		$conds['Keyword.rankend'] = 0;

		$count = $this -> Keyword -> find('count', array('conditions' => $conds));
		$message = array();
		$message['count'] = $count;
		return json_encode($message);
	}

	/**
	 * set limit price method
	 *
	 * @return void
	 */
	public function set_limit_price() {
		Configure::write('debug', 0);
		$this -> autoRender = false;

		$this -> Keyword -> updateAll(array('Keyword.limit_price' => $this -> request -> data['value']), array('Keyword.id' => $this -> request -> data['pk']));

		$message = array();
		$message['name'] = 'limit_price';
		$message['value'] = $this -> request -> data['value'];
		return json_encode($message);
	}
	
	/**
	 * set limit price method
	 *
	 * @return void
	 */
	public function set_all_c_logic() {
		Configure::write('debug', 0);
		$this -> autoRender = false;
		$this -> Keyword -> updateAll(
			array('Keyword.c_logic' => $this -> request -> data['value']), 
			array('Keyword.UserID' => $this -> request -> data['company'])
		);

		$message = array();
		$message['status'] = 'ok';
		return json_encode($message);
	}	
		
	/**
	 * set limit price method
	 *
	 * @return void
	 */
	public function edit_inline() {
		Configure::write('debug', 0);
		$this -> autoRender = false;
		$this -> Keyword -> recursive = -1;
		$this->Keyword->unbindModel(
			array('belongsTo' => array('User'))
		);
		$this -> Keyword -> updateAll(
			array('Keyword.'.$this -> request -> data['name'] => $this -> request -> data['value']), 
			array('Keyword.ID' => $this -> request -> data['pk'])
		);

		$message = array();
		$message['name'] = $this -> request -> data['name'];
		$message['value'] = $this -> request -> data['value'];
		return json_encode($message);
	}	

	public function exportCsv() {
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);
		
		$fields = array();
		$fields = array(
			'Keyword.ID', 'Keyword.UserID', 'Keyword.server_id', 'Keyword.Keyword', 'Keyword.Url',
			'Keyword.Strict', 'Keyword.seika', 'Keyword.nocontract', 'Keyword.mobile',
			'Keyword.Engine', 'Keyword.g_local', 'Keyword.cost', 'Keyword.limit_price'
		);
		$this -> export(array(
			//'recursive'=>1,
			'conditions' => $conds,
			'fields' => $fields, 
			'order' => 'Keyword.ID ASC', 
			'mapHeader' => 'HEADER_CSV_EXPORT_KEYWORD',
			'filename' => '[MEDIAX]Keywords',
		));
	}
	
/**
 * upload csv method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */	
	public function uploadCsv() {
		if($this->request->is('post') && !empty($this->request->data['Keyword']['csv'])){
			$result = $this->Upload->uploadFile(Configure::read('FOLDER_UPLOAD_CSV'),$this->request->data['Keyword']['csv']);
			if(array_key_exists('name', $result)){
				try {
					$this->Keyword->importCSV(Configure::read('FOLDER_UPLOAD_CSV').'/'.$result['name']);
					$this->Session->setFlash( __('Upload csv successfull.'));
				} catch (Exception $e) {
					$import_errors = $this->Keyword->getImportErrors();
					$this->set( 'import_errors', $import_errors );
					$this->Session->setFlash( __('Error Importing') . ' ' . $result['name'] . ', ' . __('column name mismatch.')  );
				}
				//$csv = $this->Csv->import(Configure::read('FOLDER_UPLOAD_CSV').'/'.$result['name'],Configure::read('HEADER_CSV'));
			}
		}
	}	
	
	public function exportCsvById() {
		if(!empty($this->request->data)){	
			$conds = array();
			$conds['Keyword.ID'] = explode('-',$this->request->data['ids']);
			
			$fields = array();
			$fields = array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Url', 'Keyword.Price');
			$this -> export(array(
				//'recursive'=>2,
				'conditions' => $conds,
				'fields' => $fields, 
				'order' => 'Keyword.ID DESC', 
				'mapHeader' => 'HEADER_CSV_EXPORT_KEYWORD_USER',
				'callbackHeader' => 'header_export_keywork_user',
				'callbackRow' => 'callback_export_keywork_user'
			));			
		}else{
			$this->redirect($this->referer());
		}
	}
	
 /**
 * set inline rank method
 *
 * @return void
 */
    public function set_inline_rank() {
        Configure::write('debug', 0);
        $pks = explode(',', $this -> request -> data['pk']);
        $this -> autoRender = false;
        // save db
        $this -> Keyword -> Rankhistory -> recursive = -1;
        $this -> Keyword -> Rankhistory -> updateAll(
        	array('Rankhistory.' . $this -> request -> data['name'] => "'" . $this -> request -> data['value'] . "'"), 
        	array('Rankhistory.KeyID' => trim($pks[0]), 'Rankhistory.RankDate' => trim($pks[1])));
        // log
        $this->Security->SystemLog($this -> request -> data);
        // return
        $message = array();
        $message['name'] = $this -> request -> data['name'];
        $message['value'] = $this -> request -> data['value'];

        return json_encode($message);
    }
	
}
