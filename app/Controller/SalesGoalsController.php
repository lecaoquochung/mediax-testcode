<?php
App::uses('AppController', 'Controller');
/**
 * SalesGoals Controller
 *
 * @property SalesGoal $SalesGoal
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class SalesGoalsController extends AppController {

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
		$this->SalesGoal->recursive = 0;
		$this->set('salesGoals', $this->Paginator->paginate());
	}
	
/**
 * index method
 *
 * @return void
 */
	public function seika() {
		$this->SalesGoal->recursive = 0;
		$this->set('salesGoals', $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SalesGoal->exists($id)) {
			throw new NotFoundException(__('Invalid sales goal'));
		}
		$options = array('conditions' => array('SalesGoal.' . $this->SalesGoal->primaryKey => $id));
		$this->set('salesGoal', $this->SalesGoal->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['SalesGoal']['date'] = date('Y-m-d');
			$this->SalesGoal->create();
			if ($this->SalesGoal->save($this->request->data)) {
				$this->Session->setFlash(__('The sales goal has been saved.'), 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash->error(__('The sales goal could not be saved. Please, try again.'));
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
		if (!$this->SalesGoal->exists($id)) {
			throw new NotFoundException(__('Invalid sales goal'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SalesGoal->save($this->request->data)) {
				$this->Flash->success(__('The sales goal has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The sales goal could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SalesGoal.' . $this->SalesGoal->primaryKey => $id));
			$this->request->data = $this->SalesGoal->find('first', $options);
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
		$this->SalesGoal->id = $id;
		if (!$this->SalesGoal->exists()) {
			throw new NotFoundException(__('Invalid sales goal'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SalesGoal->delete()) {
			$this->Flash->success(__('The sales goal has been deleted.'));
		} else {
			$this->Flash->error(__('The sales goal could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
