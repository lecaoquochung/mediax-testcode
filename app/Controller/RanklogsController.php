<?php
App::uses('AppController', 'Controller');
/**
 * Ranklogs Controller
 *
 * @property Ranklog $Ranklog
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class RanklogsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/**
 * index method
 *
 * @return void
 */
	 public function index($status = 0, $rankrange = FALSE) {
        set_time_limit(0);
        $rankDate = date('Y-m-d');
        $conds = array();
        $conds['Ranklog.rankdate'] = $rankDate;

        if ($rankrange == 10) {
            $conds['Ranklog.rank REGEXP'] = '(:[1-9],)|(:[1-9]})|10';
        }

        if ($rankrange == 20) {
            $conds['Ranklog.rank REGEXP'] = '(:[1][1-9],)|(:[1][1-9]})|20';
        }

        if ($rankrange == 100) {
            $conds['Ranklog.rank REGEXP'] = '(:[2-9][1-9],)|(:[2-9][1-9]})|100';
        }

        if ($rankrange == 1000) {
            $conds['Ranklog.rank REGEXP'] = '(:[0])|(:[0]})';
        }

        if ($this->request->is('post')) {
            $rankDate = $this->request->data['Ranklog']['rankDate']['year'] .'-'. $this->request->data['Ranklog']['rankDate']['month'] .'-'. $this->request->data['Ranklog']['rankDate']['day'];
            if (!empty($this->request->data['Ranklog']['keyword'])) {
                $users = $this->Rankhistory->Keyword->User->find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this->request->data['Ranklogs']['keyword']), 'UTF-8') . '%')));
                $conds['OR']['Ranklog.url LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.UserID'] = $users;
            }
            $conds['Ranklog.rankdate'] = $rankDate;
        }

        $this->Ranklog->recursive = 0;

        $order = array();
        $order['Keyword.UserID'] = 'DESC';
        $order['Ranklog.modified'] = 'DESC';

        $fields = array(
            'Ranklog.id', 'Ranklog.url', 'Ranklog.rank', 'Ranklog.rankdate', 'Ranklog.params',
            'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group'
        );

        $ranklogs = $this->Ranklog->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order, 'limit' => Configure::read('Page.max')));
        $keyword_id = Hash::extract($ranklogs, '{n}.Keyword.ID');

        #Extra
        $this->loadModel('Extra');
        $this->Extra->recursive = -1;
        $extras = $this->Extra->find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

        $this->set('ranklogs', $ranklogs);
        $this->set('extras', $extras);
        $this->set('user', $this->Ranklog->Keyword->User->find('list', array('fields' => array('User.id', 'User.company'))));
        $this->set('rankDate', $rankDate);
    }

/**
 * seika method
 *
 * @return void
 */
	 public function seika($status = 0, $rankrange = FALSE) {
        set_time_limit(0);
        $rankDate = date('Y-m-d');
        $conds = array();
        $conds['Ranklog.rankdate'] = $rankDate;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = 1;
		$conds['OR'] = array( array('Keyword.rankend' => 0), array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))));

        if ($rankrange == 10) {
            $conds['Ranklog.rank REGEXP'] = '(:[1-9],)|(:[1-9]})|10';
        }

        if ($rankrange == 20) {
            $conds['Ranklog.rank REGEXP'] = '(:[1][1-9],)|(:[1][1-9]})|20';
        }

        if ($rankrange == 100) {
            $conds['Ranklog.rank REGEXP'] = '(:[2-9][1-9],)|(:[2-9][1-9]})|100';
        }

        if ($rankrange == 1000) {
            $conds['Ranklog.rank REGEXP'] = '(:[0])|(:[0]})';
        }

        if ($this->request->is('post')) {
            $rankDate = $this->request->data['Ranklog']['rankDate']['year'] .'-'. $this->request->data['Ranklog']['rankDate']['month'] .'-'. $this->request->data['Ranklog']['rankDate']['day'];
            if (!empty($this->request->data['Ranklog']['keyword'])) {
                $users = $this->Rankhistory->Keyword->User->find('list', array('fields' => array('User.id', 'User.id'), 'conditions' => array('User.company LIKE' => '%' . mb_strtolower(trim($this->request->data['Ranklogs']['keyword']), 'UTF-8') . '%')));
                $conds['OR']['Ranklog.url LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.Keyword LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.url LIKE'] = '%' . mb_strtolower(trim($this->request->data['Ranklog']['keyword']), 'UTF-8') . '%';
                $conds['OR']['Keyword.UserID'] = $users;
            }
            $conds['Ranklog.rankdate'] = $rankDate;
        }

        $this->Ranklog->recursive = 0;

        $order = array();
        $order['Keyword.UserID'] = 'DESC';
        $order['Ranklog.modified'] = 'DESC';

        $fields = array(
            'Ranklog.id', 'Ranklog.url', 'Ranklog.rank', 'Ranklog.rankdate', 'Ranklog.params',
            'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group'
        );

        $ranklogs = $this->Ranklog->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order, 'limit' => Configure::read('Page.max')));
        $keyword_id = Hash::extract($ranklogs, '{n}.Keyword.ID');

        #Extra
        $this->loadModel('Extra');
        $this->Extra->recursive = -1;
        $extras = $this->Extra->find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_id)));

        $this->set('ranklogs', $ranklogs);
        $this->set('extras', $extras);
        $this->set('user', $this->Ranklog->Keyword->User->find('list', array('fields' => array('User.id', 'User.company'))));
        $this->set('rankDate', $rankDate);
    }


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ranklog->exists($id)) {
			throw new NotFoundException(__('Invalid ranklog'));
		}
		$options = array('conditions' => array('Ranklog.' . $this->Ranklog->primaryKey => $id));
		$this->set('ranklog', $this->Ranklog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ranklog->create();
			if ($this->Ranklog->save($this->request->data)) {
				$this->Flash->success(__('The ranklog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The ranklog could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->Ranklog->Keyword->find('list');
		$engines = $this->Ranklog->Engine->find('list');
		$this->set(compact('keywords', 'engines'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ranklog->exists($id)) {
			throw new NotFoundException(__('Invalid ranklog'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ranklog->save($this->request->data)) {
				$this->Flash->success(__('The ranklog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The ranklog could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ranklog.' . $this->Ranklog->primaryKey => $id));
			$this->request->data = $this->Ranklog->find('first', $options);
		}
		$keywords = $this->Ranklog->Keyword->find('list');
		$engines = $this->Ranklog->Engine->find('list');
		$this->set(compact('keywords', 'engines'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ranklog->id = $id;
		if (!$this->Ranklog->exists()) {
			throw new NotFoundException(__('Invalid ranklog'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Ranklog->delete()) {
			$this->Flash->success(__('The ranklog has been deleted.'));
		} else {
			$this->Flash->error(__('The ranklog could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}