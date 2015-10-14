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
	public function index() {
		$this->Ranklog->recursive = 0;
		$this->set('ranklogs', $this->Paginator->paginate());
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
