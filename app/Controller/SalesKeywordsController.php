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
 * dashboard method
 *
 * @return void
 */
	public function dashboard() {
		$this->SalesKeyword->recursive = 0;
		
		$date = date('Y-m-d');
		$conds = array();
		$conds['SalesKeyword.date BETWEEN ? AND ?'] = array( date('Y-m').'-01', $date);
		$fields = array();
		$fields = array('SalesKeyword.id', 'SalesKeyword.keyword_id', 'SalesKeyword.user_id', 'SalesKeyword.keyword', 'SalesKeyword.rank', 'SalesKeyword.sales', 'SalesKeyword.cost', 'SalesKeyword.profit', 'SalesKeyword.date');
		
		$sales_keywords = $this-> SalesKeyword -> find('all', array('conditions' => $conds, 'fields' => $fields));
		$sales_date = Hash::extract($sales_keywords, '{n}.SalesKeyword.date');
		
		
		// debug($sales_date);exit;
		// debug($sales_keywords);exit;
		// $sales_keywords = Hash::combine($sales_keywords, '{n}.SalesKeyword.date', array('%s,%s',  '{n}.SalesKeyword.sales', '{n}.SalesKeyword.cost'));
		
		$sales_keywords_daily = array();
		$sum_sales_keyword = array();
		foreach($sales_keywords as $sales_keyword) {
			
			// debug($sales_keyword);exit;
			
			for($i=0; $i<=count($sales_keywords); $i++) {
				
				// debug($sales_keywords[$i]['SalesKeyword']['date']);
				// debug($sales_keyword['SalesKeyword']['date']); 
				
				// if($sales_keywords[$i]['SalesKeyword']['date'] == $sales_keyword['SalesKeyword']['date']) {
					// $day_int = date('d', strtotime($sales_keyword['SalesKeyword']['date']));
					// $day_int = settype($day_int, "integer");
// 					
					// @$sum_sales_keyword[$sales_keywords[$i]['SalesKeyword']['date']]['sales'] += $sales_keyword['SalesKeyword']['sales'];
					// @$sum_sales_keyword[$sales_keywords[$i]['SalesKeyword']['date']]['cost'] += $sales_keyword['SalesKeyword']['cost']; 
					// @$sum_sales_keyword[$sales_keywords[$i]['SalesKeyword']['date']]['profit'] += $sales_keyword['SalesKeyword']['profit'];
					// $sales_keywords_daily[$sales_keywords[$i]['SalesKeyword']['date']] = array($day_int, $sales_keyword['SalesKeyword']['sales'], $sales_keyword['SalesKeyword']['cost'], $sales_keyword['SalesKeyword']['profit']);
				// }
			}
		}
		
		debug(count($sales_keywords));
		debug($sales_keywords_daily);
		
		// debug($sales_keywords_daily);
		
	}

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
	// public function add() {
		// if ($this->request->is('post')) {
			// $this->SalesKeyword->create();
			// if ($this->SalesKeyword->save($this->request->data)) {
				// $this->Session->setFlash(__('The sales keyword has been saved'));
				// return $this->redirect(array('action' => 'index'));
			// } else {
				// $this->Session->setFlash(__('The sales keyword could not be saved. Please, try again.'));
			// }
		// }
		// $keywords = $this->SalesKeyword->Keyword->find('list');
		// $users = $this->SalesKeyword->User->find('list');
		// $this->set(compact('keywords', 'users'));
	// }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function edit($id = null) {
		// if (!$this->SalesKeyword->exists($id)) {
			// throw new NotFoundException(__('Invalid sales keyword'));
		// }
		// if ($this->request->is('post') || $this->request->is('put')) {
			// if ($this->SalesKeyword->save($this->request->data)) {
				// $this->Session->setFlash(__('The sales keyword has been saved'));
				// return $this->redirect(array('action' => 'index'));
			// } else {
				// $this->Session->setFlash(__('The sales keyword could not be saved. Please, try again.'));
			// }
		// } else {
			// $options = array('conditions' => array('SalesKeyword.' . $this->SalesKeyword->primaryKey => $id));
			// $this->request->data = $this->SalesKeyword->find('first', $options);
		// }
		// $keywords = $this->SalesKeyword->Keyword->find('list');
		// $users = $this->SalesKeyword->User->find('list');
		// $this->set(compact('keywords', 'users'));
	// }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function delete($id = null) {
		// $this->SalesKeyword->id = $id;
		// if (!$this->SalesKeyword->exists()) {
			// throw new NotFoundException(__('Invalid sales keyword'));
		// }
		// $this->request->onlyAllow('post', 'delete');
		// if ($this->SalesKeyword->delete()) {
			// $this->Session->setFlash(__('Sales keyword deleted'));
			// return $this->redirect(array('action' => 'index'));
		// }
		// $this->Session->setFlash(__('Sales keyword was not deleted'));
		// return $this->redirect(array('action' => 'index'));
	// }
}
