<?php
App::uses('AppController', 'Controller');
/**
 * Sales Controller
 *
 * @property Sale $Sale
 */
class SalesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Sale->recursive = 0;
		$this->set('sales', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Sale->exists($id)) {
			throw new NotFoundException(__('Invalid sale'));
		}
		$options = array('conditions' => array('Sale.' . $this->Sale->primaryKey => $id));
		$this->set('sale', $this->Sale->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Sale->create();
			if ($this->Sale->save($this->request->data)) {
				$this->Session->setFlash(__('The sale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.'));
			}
		}
		$users = $this->Sale->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Sale->exists($id)) {
			throw new NotFoundException(__('Invalid sale'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sale->save($this->request->data)) {
				$this->Session->setFlash(__('The sale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sale.' . $this->Sale->primaryKey => $id));
			$this->request->data = $this->Sale->find('first', $options);
		}
		$users = $this->Sale->User->find('list');
		$this->set(compact('users'));
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
		$this->Sale->id = $id;
		if (!$this->Sale->exists()) {
			throw new NotFoundException(__('Invalid sale'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sale->delete()) {
			$this->Session->setFlash(__('Sale deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sale was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->loadModel('User');
		$this->loadModel('Status');
		$this->Sale->recursive = 0;
		$this->User->recursive = 0;
		
		$this->paginate = array('limit' => 10, 'order' => array('modified' => 'desc'));
		
		$system_month = date('Y-m-00',strtotime('now'));
		$sale_flag = Configure::read('SALE_FLAG');
		
		if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) { // Post data from view
			/*
			*	Have post data from view: target_month
			*	Check data conditions
			*/
			if($this->request->is('get')){
				$this->request->data['Sale'] = $this->request->query;
			}
			if(!empty($this->request->data['Sale'])){
				
				// View target_price of month & year			
				$target_month =implode($this->request->data['Sale']['target_month'],"-")."-00";
				$sales = $this->User->Sale->find('list',array('fields'=>array('Sale.user_id','Sale.target_sale'),'conditions'=>array('Sale.target_month'=>$target_month)));
			} else {
				/*
				*	Show data admin_index
				*	
				*/
				$sales = $this->User->Sale->find('list',array('fields'=>array('Sale.user_id','Sale.target_sale'),'conditions'=>array('Sale.target_month'=>$system_month)));
			}
		}
		
		$users = $this->paginate('User');
		
		foreach ($users as $key=>$user) {
			$sales_count = $this->Status->find('count',array('conditions'=>array('Status.flag'=>$sale_flag,'DATE_FORMAT(Status.created,"%Y-%m-00")'=>(isset($target_month)?$target_month:$system_month),'Status.user_id'=>$user['User']['id'])));
			$sale_status = $this->Status->find('all',array('fields'=>'SUM(price)','conditions'=>array('Status.flag'=>$sale_flag,'DATE_FORMAT(Status.created,"%Y-%m-00")'=>(isset($target_month)?$target_month:$system_month),'Status.user_id'=>$user['User']['id'])));
			//$users[$key]['User']['sales_status'] = $sales_count * $price;
			$users[$key]['User']['sales_status'] = $sale_status[0][0]['SUM(price)'];
		}
		
		//debug($users);
		
		$this->set(compact('users','sales'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Sale->exists($id)) {
			throw new NotFoundException(__('Invalid sale'));
		}
		$options = array('conditions' => array('Sale.' . $this->Sale->primaryKey => $id));
		$this->set('sale', $this->Sale->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			/*
			*	Set target_sale on target_month
			*/
			$target_date = $this->request->data['Sale']['target_month'];
			$this->request->data['Sale']['target_month'] = implode("-",$this->request->data['Sale']['target_month']) ."-00";
			$target_month = $this->request->data['Sale']['target_month'];
			
			$check_exist = $this->Sale->find('first',array('conditions'=>array('Sale.target_month'=>$target_month, 'Sale.user_id'=>$this->request->data['Sale']['user_id'])));
			$check_exist == FALSE?$this->Sale->create():$this->Sale->id = $check_exist['Sale']['id'];
			
			if ($this->Sale->save($this->request->data)) {
				$this->loadModel('User');
				$this->User->id = $this->request->data['Sale']['user_id'];
				$this->User->saveField('modifield',date('Y-m-d H:i:s'));
				$this->Session->setFlash(__('The sale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.'));
			}
		}
		$users = $this->Sale->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Sale->exists($id)) {
			throw new NotFoundException(__('Invalid sale'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sale->save($this->request->data)) {
				$this->Session->setFlash(__('The sale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sale.' . $this->Sale->primaryKey => $id));
			$this->request->data = $this->Sale->find('first', $options);
		}
		$users = $this->Sale->User->find('list');
		$this->set(compact('users'));
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
		$this->Sale->id = $id;
		if (!$this->Sale->exists()) {
			throw new NotFoundException(__('Invalid sale'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sale->delete()) {
			$this->Session->setFlash(__('Sale deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sale was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
