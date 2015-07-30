<?php
App::uses('AppController', 'Controller');
/**
 * Supports Controller
 *
 * @property Support $Support
 */
class SupportsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$conds = array();
		$conds['Support.user_id'] = $this->Auth->user('id');
		$this->Support->recursive = 0;
		$this->paginate = array('conditions'=>$conds,'order'=>'Support.modifield DESC');
		$this->set('supports', $this->paginate());
	}
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Support->recursive = 2;
		$this->set('supports', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Support->exists($id)) {
			throw new NotFoundException(__('Invalid support'));
		}
		$options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
		$this->set('support', $this->Support->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Support']['user_id'] = $this->Auth->user('id');
			$this->Support->create();
			if ($this->Support->save($this->request->data)) {
				$this->Session->setFlash(__('The support has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The support could not be saved. Please, try again.'));
			}
		}
		$jobhunters = $this->Support->Jobhunter->find('list');
		$this->set(compact('jobhunters'));
	}
	
/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			//2013-04-08 16-37 HL add admin in charge
			$this->request->data['Support']['user_id'] = $this->Auth->user('id');
			$this->Support->create();
			if ($this->Support->save($this->request->data)) {
				$this->Session->setFlash(__('The support has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The support could not be saved. Please, try again.'));
			}
		}
		$jobhunters = $this->Support->Jobhunter->find('list');
		$this->set(compact('jobhunters'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Support->exists($id)) {
			throw new NotFoundException(__('Invalid support'));
		}
		$options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
		$this->set('support', $this->Support->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Support->exists($id)) {
			throw new NotFoundException(__('Invalid support'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Support->save($this->request->data)) {
				$this->Session->setFlash(__('The support has been saved'));
				$this->set('success','success');
			} else {
				$this->Session->setFlash(__('The support could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
			$this->request->data = $this->Support->find('first', $options);
		}
		$jobhunters = $this->Support->Jobhunter->find('list');
		$this->set(compact('jobhunters'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Support->exists($id)) {
			throw new NotFoundException(__('Invalid support'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Support->save($this->request->data)) {
				$this->Session->setFlash(__('The support has been saved'));
				//$this->redirect(array('action' => 'index'));
				$this->set('success','success');
			} else {
				$this->Session->setFlash(__('The support could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Support.' . $this->Support->primaryKey => $id));
			$this->request->data = $this->Support->find('first', $options);
		}
		$jobhunters = $this->Support->Jobhunter->find('list');
		$this->set(compact('jobhunters'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Support->delete()) {
			$this->Session->setFlash(__('Support deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Support->delete()) {
			$this->Session->setFlash(__('Support deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}

/**
 * action method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function action($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Support->saveField('action',1)) {
			$this->Session->setFlash(__('Support saved.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}
	
/**
 * admin_action method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_action($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Support->saveField('action',1)) {
			$this->Session->setFlash(__('Support saved.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}	

/**
 * check method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function check($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		if ($this->Support->saveField('action',0)) {
			$this->Session->setFlash(__('Support saved.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}	
	
/**
 * admin_check method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_check($id = null) {
		$this->Support->id = $id;
		if (!$this->Support->exists()) {
			throw new NotFoundException(__('Invalid support'));
		}
		if ($this->Support->saveField('action',0)) {
			$this->Session->setFlash(__('Support saved.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Support was not deleted'));
		$this->redirect($this->referer());
	}	
	
}
