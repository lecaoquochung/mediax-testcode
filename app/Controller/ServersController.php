<?php
App::uses('AppController', 'Controller');
/**
 * Servers Controller
 *
 * @property Server $Server
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class ServersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/*------------------------------------------------------------------------------------------------------------
 * index method
 * 
 * author lecaoquochung@gmail.com
 * created 2015-12-18
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
	public function index() {
		$this->Server->recursive = -1;
		$servers = $this->Server->find('all');
		
		$this->loadModel('Keyword');
		$this->Keyword->recursive = -1;
		$conds = array();
        $conds['Keyword.server_id <>'] = NULL;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);
		
		$fields = array('Keyword.ID', 'Keyword.server_id');
		
		$keywords = $this->Keyword->find('list', array('conditions' => $conds, 'fields' => $fields));
		$use = array_count_values($keywords);

		$this->set(compact('servers', 'keywords','use'));
	}

/*------------------------------------------------------------------------------------------------------------
 * index method
 * 
 * author lecaoquochung@gmail.com
 * created 2015-12-18
 * updated
 *-----------------------------------------------------------------------------------------------------------*/
	public function used($id = null) {
		if (!$this->Server->exists($id)) {
			throw new NotFoundException(__('Invalid server'));
		}
		
		$this->loadModel('Keyword');
		$this->Keyword->recursive = -1;
		
		$conds = array();
        $conds['Keyword.server_id'] = $id;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);
		
		$fields = array();
		// $fields = array('Keyword.ID', 'Keyword.server_id');
		
		$keywords = $this->Keyword->find('all', array('conditions' => $conds, 'fields' => $fields));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Server->exists($id)) {
			throw new NotFoundException(__('Invalid server'));
		}
		$options = array('conditions' => array('Server.' . $this->Server->primaryKey => $id));
		$this->set('server', $this->Server->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Server->create();
			if ($this->Server->save($this->request->data)) {
				$this->Flash->success(__('The server has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The server could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Server->exists($id)) {
			throw new NotFoundException(__('Invalid server'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Server->save($this->request->data)) {
				// $this->Flash->success(__('The server has been saved.'));
				$this -> Session -> setFlash(__('The server has been saved.'), 'default', array('class' => 'error'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The server could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Server.' . $this->Server->primaryKey => $id));
			$this->request->data = $this->Server->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Server->id = $id;
		if (!$this->Server->exists()) {
			throw new NotFoundException(__('Invalid server'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Server->delete()) {
			$this->Flash->success(__('The server has been deleted.'));
		} else {
			$this->Flash->error(__('The server could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
