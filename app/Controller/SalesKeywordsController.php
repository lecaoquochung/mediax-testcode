<?php
App::uses('AppController', 'Controller');

/*------------------------------------------------------------------------------------------------------------
 * Sales Keywords Controller
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/	
class SalesKeywordsController extends AppController {

	public $components = array('Paginator');
	
/*------------------------------------------------------------------------------------------------------------
 * dashboard method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 * @output daily [1, 43050, 500, 42550]; weekly ['Day', 'Sales', 'Cost', 'Profit', 'Average'],
 * @debug
 * foreach ($daily as $key => $value): echo '[' .($key+1) .',' .$value .'], '; endforeach; exit;
 * foreach ($weekly as $key => $value): $day = date('Y/m/') .(string)(date('d')-(count($weekly)-1-$key)); echo '[' .'"'.$day.'"' .',' .$value .',' .(array_sum(explode(',', $value)))/4 .'], '; endforeach; exit;
 * foreach ($monthly as $key => $value): echo '[' .'\''.$key.'\'' .',' .$value .'], '; endforeach; exit;
 *-----------------------------------------------------------------------------------------------------------*/	
	public function dashboard() {
		$this->SalesKeyword->recursive = -1;
		$daily = array();
		$weekly = array();
		$monthly = array();
		$date = date('Y-m-d');
		$today = date('d');
		$today_int = settype($today, "integer");
		
		$conds = array();
		$conds['SalesKeyword.date BETWEEN ? AND ?'] = array( date('Y-m').'-01', $date);
		$fields = array();
		$fields = array('SalesKeyword.date');
		
		$sales_keywords = $this-> SalesKeyword -> find('all', array('conditions' => $conds, 'fields' => $fields, 'group' => 'SalesKeyword.date', 'order' => 'SalesKeyword.date ASC'));
		$sales_date = Hash::extract($sales_keywords, '{n}.SalesKeyword.date');
		
		$sales_keywords_daily = array();
		$sum_sales_keyword = array();
		
		for($i=0; $i<count($sales_date); $i++) {
			$sum_sales_keyword[$i] = $this->SalesKeyword->find('all', array(
		    	'conditions' => array('SalesKeyword.date' => $sales_date[$i]),
		    	'fields' => array('sum(SalesKeyword.sales) as total_sales', 'sum(SalesKeyword.cost) as total_cost', 'sum(SalesKeyword.profit) as total_profit', 'SalesKeyword.date')
        	));
			
			@$monthly['sales'] += @$sum_sales_keyword[$i][0][0]['total_sales'];
			@$monthly['cost'] += @$sum_sales_keyword[$i][0][0]['total_cost'];
			@$monthly['profit'] += @$sum_sales_keyword[$i][0][0]['total_profit'];
		}
		
		$daily = Hash::format($sum_sales_keyword, array('{n}.0.0.total_sales', '{n}.0.0.total_cost', '{n}.0.0.total_profit'), '%d, %d, %d');
		$weekly = array_slice($daily, $today_int - 8);
		$this->set(compact('daily', 'weekly', 'monthly'));
	}

/*------------------------------------------------------------------------------------------------------------
 * index method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/
	public function index() {
		$this->SalesKeyword->recursive = 0;
		$this->set('salesKeywords', $this->Paginator->paginate());
	}

/*------------------------------------------------------------------------------------------------------------
 * view method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/
	public function view($id = null) {
		if (!$this->SalesKeyword->exists($id)) {
			throw new NotFoundException(__('Invalid sales keyword'));
		}
		$options = array('conditions' => array('SalesKeyword.' . $this->SalesKeyword->primaryKey => $id));
		$this->set('salesKeyword', $this->SalesKeyword->find('first', $options));
	}

/*------------------------------------------------------------------------------------------------------------
 * add method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/	
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

/*------------------------------------------------------------------------------------------------------------
 * edit method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/	
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

/*------------------------------------------------------------------------------------------------------------
 * delete method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20150820
 *-----------------------------------------------------------------------------------------------------------*/	
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
