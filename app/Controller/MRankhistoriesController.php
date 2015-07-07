<?php
App::uses('AppController', 'Controller');
/**
 * MRankhistories Controller
 *
 * @property MRankhistory $MRankhistory
 * @property PaginatorComponent $Paginator
 */
class MRankhistoriesController extends AppController {

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
		$this->MRankhistory->recursive = 0;
		$this->set('mRankhistories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MRankhistory->exists($id)) {
			throw new NotFoundException(__('Invalid m rankhistory'));
		}
		$options = array('conditions' => array('MRankhistory.' . $this->MRankhistory->primaryKey => $id));
		$this->set('mRankhistory', $this->MRankhistory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MRankhistory->create();
			if ($this->MRankhistory->save($this->request->data)) {
				$this->Session->setFlash(__('The m rankhistory has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The m rankhistory could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->MRankhistory->Keyword->find('list');
		$engines = $this->MRankhistory->Engine->find('list');
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
		if (!$this->MRankhistory->exists($id)) {
			throw new NotFoundException(__('Invalid m rankhistory'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MRankhistory->save($this->request->data)) {
				$this->Session->setFlash(__('The m rankhistory has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The m rankhistory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MRankhistory.' . $this->MRankhistory->primaryKey => $id));
			$this->request->data = $this->MRankhistory->find('first', $options);
		}
		$keywords = $this->MRankhistory->Keyword->find('list');
		$engines = $this->MRankhistory->Engine->find('list');
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
		$this->MRankhistory->id = $id;
		if (!$this->MRankhistory->exists()) {
			throw new NotFoundException(__('Invalid m rankhistory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MRankhistory->delete()) {
			$this->Session->setFlash(__('M rankhistory deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('M rankhistory was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
