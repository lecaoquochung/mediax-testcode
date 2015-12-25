<?php
App::uses('AppController', 'Controller');
/**
 * Ranks Controller
 *
 * @property Rank $Rank
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class RanksController extends AppController {

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
		$this->Rank->recursive = 0;
		$this->set('ranks', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Rank->exists($id)) {
			throw new NotFoundException(__('Invalid rank'));
		}
		$options = array('conditions' => array('Rank.' . $this->Rank->primaryKey => $id));
		$this->set('rank', $this->Rank->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rank->create();
			if ($this->Rank->save($this->request->data)) {
				$this->Flash->success(__('The rank has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The rank could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->Rank->Keyword->find('list');
		$engines = $this->Rank->Engine->find('list');
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
		if (!$this->Rank->exists($id)) {
			throw new NotFoundException(__('Invalid rank'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Rank->save($this->request->data)) {
				$this->Flash->success(__('The rank has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The rank could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rank.' . $this->Rank->primaryKey => $id));
			$this->request->data = $this->Rank->find('first', $options);
		}
		$keywords = $this->Rank->Keyword->find('list');
		$engines = $this->Rank->Engine->find('list');
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
		$this->Rank->id = $id;
		if (!$this->Rank->exists()) {
			throw new NotFoundException(__('Invalid rank'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Rank->delete()) {
			$this->Flash->success(__('The rank has been deleted.'));
		} else {
			$this->Flash->error(__('The rank could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
