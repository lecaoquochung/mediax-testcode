<?php
App::uses('AppController', 'Controller');
/**
 * SalesKeywords Controller
 *
 * @property SalesKeyword $SalesKeyword
 * @property PaginatorComponent $Paginator
 */
class SalesKeywordsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SalesKeyword->recursive = 0;
		$this->set('salesKeywords', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SalesKeyword->exists($id)) {
			throw new NotFoundException(__('Invalid sales keyword'));
		}
		$options = array('conditions' => array('SalesKeyword.' . $this->SalesKeyword->primaryKey => $id));
		$this->set('salesKeyword', $this->SalesKeyword->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SalesKeyword->create();
			if ($this->SalesKeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The sales keyword has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sales keyword could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->SalesKeyword->Keyword->find('list');
		$users = $this->SalesKeyword->User->find('list');
		$this->set(compact('keywords', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SalesKeyword->exists($id)) {
			throw new NotFoundException(__('Invalid sales keyword'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SalesKeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The sales keyword has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sales keyword could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SalesKeyword.' . $this->SalesKeyword->primaryKey => $id));
			$this->request->data = $this->SalesKeyword->find('first', $options);
		}
		$keywords = $this->SalesKeyword->Keyword->find('list');
		$users = $this->SalesKeyword->User->find('list');
		$this->set(compact('keywords', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SalesKeyword->id = $id;
		if (!$this->SalesKeyword->exists()) {
			throw new NotFoundException(__('Invalid sales keyword'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SalesKeyword->delete()) {
			$this->Session->setFlash(__('Sales keyword deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sales keyword was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
