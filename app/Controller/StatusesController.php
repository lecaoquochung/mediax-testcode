<?php
App::uses('AppController', 'Controller');
/**
 * Statuses Controller
 *
 * @property Status $Status
 */
class StatusesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index($flag = null) {
		$this->loadModel('Jobhunter');
		$this->loadModel('Company');
		$conds = array();
		if($this->request->is('post') && !empty($this->request->data['Status']['keyword'])){
			$conds['OR']['Jobhunter.name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
			$conds['OR']['Status.flag LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
			$conds['OR']['Joboffer.company_name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
		} else {
			if(empty($flag)){
				$conds['Status.flag <>'] = Configure::read('FINISH_FLAG');	
			}
		}
		
		if(!empty($flag)){
			if($flag == 37){
				$conds['Status.flag'] = array(4,8,12);
			} else if ($flag == 38){
				$conds['Status.flag'] = array(17,19);
			} else if ($flag == 39){
				$conds['Status.flag'] = array(34,35);
			} else if ($flag == 26){
				$conds['Status.flag'] = array(26);
			} else {
				$conds['Status.flag'] = $flag;
			}
		}
		
		//$conds['Status.flag <>'] = Configure::read('FINISH_FLAG');
		$conds['Status.user_id'] = $this->Auth->user('id');
		
		$this->Status->recursive = 0;
		$this->paginate = array('conditions'=>$conds,'order'=>'Status.modifield DESC');
		$this->set('statuses', $this->paginate());
		
		// Count Status
		$status = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag <>'=>Configure::read('FINISH_FLAG'))));
		$status1 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>1)));
		$status2 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>2)));
		$status3 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>3)));
		$status4 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>4)));
		$status5 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>5)));
		$status6 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>6)));
		$status7 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>7)));
		$status8 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>8)));
		$status9 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>9)));
		$status10 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>10)));
		$status11 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>11)));
		$status12 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>12)));
		$status13 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>13)));
		$status14 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>14)));
		$status15 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>15)));
		$status16 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>16)));
		$status17 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>17)));
		$status18 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>18)));
		$status19 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>19)));
		$status20 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>20)));
		$status21 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>21)));
		$status22 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>22)));
		$status23 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>23)));
		$status24 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>24)));
		$status25 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>25)));
		$status26 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>26)));
		$status27 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>27)));
		$status28 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>28)));
		$status29 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>29)));
		$status30 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>30)));
		$status31 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>31)));
		$status32 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>32)));
		$status33 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>33)));
		$status34 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>34)));
		$status35 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>35)));
		$status36 = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'),'Status.flag'=>36)));
		$status37 = $status4 + $status8 + $status12;
		$status38 = $status17 + $status19;
		$status39 = $status30 + $status34 + $status35;
		
		$this->set(compact('status','status1','status2','status3','status4','status5','status6','status7','status8','status9','status10',
							'status11','status12','status13','status14','status15','status16','status17','status18','status19','status20',
							'status21','status22','status23','status24','status25','status26','status27','status28','status29','status30',
							'status31','status32','status33','status34','status35','status36','status37','status38','status39'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($flag = null) {
		$this->loadModel('Jobhunter');
		//$this->loadModel('Company');
		$this->loadModel('Joboffer');
		$conds = array();
		if($this->request->is('post') && !empty($this->request->data['Status']['keyword'])){
			$conds['OR']['Jobhunter.name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
			$conds['OR']['Status.flag LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
			$conds['OR']['Joboffer.company_name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Status']['keyword']),'UTF-8').'%';
		} else {
			if(empty($flag)){
				$conds['Status.flag <>'] = Configure::read('FINISH_FLAG');	
			}
		}
		
		if(!empty($flag)){
			if($flag == 37){
				$conds['Status.flag'] = array(4,8,12);
			} else if ($flag == 38){
				$conds['Status.flag'] = array(17,19);
			} else if ($flag == 39){
				$conds['Status.flag'] = array(34,35);
			} else if ($flag == 26){
				$conds['Status.flag'] = array(26);
			} else {
				$conds['Status.flag'] = $flag;
			}
		}
		
		$this->Status->recursive = 0;
		$this->paginate = array('conditions'=>$conds,'order'=>'Status.modifield DESC');
		$this->set('statuses', $this->paginate());
		
		// Count Status
		//$status = $this->Status->find('count',array('conditions'=>array('Status.user_id'=>$this->Auth->user('id'))));
		$status = $this->Status->find('count',array('conditions'=>array('Status.flag <>'=>Configure::read('FINISH_FLAG'))));
		$status1 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>1)));
		$status2 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>2)));
		$status3 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>3)));
		$status4 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>4)));
		$status5 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>5)));
		$status6 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>6)));
		$status7 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>7)));
		$status8 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>8)));
		$status9 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>9)));
		$status10 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>10)));
		$status11 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>11)));
		$status12 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>12)));
		$status13 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>13)));
		$status14 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>14)));
		$status15 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>15)));
		$status16 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>16)));
		$status17 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>17)));
		$status18 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>18)));
		$status19 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>19)));
		$status20 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>20)));
		$status21 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>21)));
		$status22 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>22)));
		$status23 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>23)));
		$status24 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>24)));
		$status25 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>25)));
		$status26 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>26)));
		$status27 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>27)));
		$status28 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>28)));
		$status29 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>29)));
		$status30 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>30)));
		$status31 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>31)));
		$status32 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>32)));
		$status33 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>33)));
		$status34 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>34)));
		$status35 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>35)));
		$status36 = $this->Status->find('count',array('conditions'=>array('Status.flag'=>36)));
		$status37 = $status4 + $status8 + $status12;
		$status38 = $status17 + $status19;
		$status39 = $status30 + $status34 + $status35;
		
		$this->set(compact('status','status1','status2','status3','status4','status5','status6','status7','status8','status9','status10',
							'status11','status12','status13','status14','status15','status16','status17','status18','status19','status20',
							'status21','status22','status23','status24','status25','status26','status27','status28','status29','status30',
							'status31','status32','status33','status34','status35','status36','status37','status38','status39'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			// 2013-03-26 HL add user incharge
			$this->request->data['Status']['user_id'] = $this->Auth->user('id');
			$this->loadModel('Jobhunter');
			$this->Jobhunter->recursive = -1;
			$interview_ok = $this->Jobhunter->find('first',array('fields'=>array('interview_ok'),'conditions'=>array('Jobhunter.id'=>$this->request->data['Status']['jobhunter_id'])));
			if(empty($interview_ok['Jobhunter']['interview_ok'])) {
				$this->request->data['Status']['flag'] = Configure::read('FIRST_FLAG');
			} else {
				$this->request->data['Status']['flag'] = Configure::read('INTERVIEW_OK');	
			}
			$this->request->data['Status']['modifield'] = date('Y-m-d H:i:s');
			$this->Status->create();			
			if ($this->Status->save($this->request->data)) {
				//
				$this->loadModel('Slog');
				$this->Slog->recursive = -1;
				$this->request->data['Slog']['user_id'] = $this->Auth->user('id');;
				$this->request->data['Slog']['status_id'] = $this->Status->id;
				$this->request->data['Slog']['jobhunter_id'] = $this->request->data['Status']['jobhunter_id'];
				$this->request->data['Slog']['flag'] = $this->request->data['Status']['flag'];
				$this->Slog->create();
				if ($this->Slog->save($this->request->data)) {
					$this->Session->setFlash(__('The status has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
			}
		}
		$users = $this->Status->User->find('list');
//		#11
		$jobhunters = $this->Status->Jobhunter->find('list');
		if ($this->request->is('get') && isset($this->request->query['keyword']) && !empty($this->request->query['keyword'])) {
			$joboffers = $this->Status->Joboffer->find('list',array('conditions'=>array('Joboffer.company_name LIKE'=>'%'.strtolower($this->request->query['keyword']).'%')));
		}else{
			$joboffers = $this->Status->Joboffer->find('list');
		}
		$this->set(compact('users', 'jobhunters', 'joboffers'));
	}
	
/**
 * admin_add method
 *
 * @return void
 * 
 */
	public function admin_add() {
		if ($this->request->is('post')) {
//			 2013-03-26 HL add admin incharge
			$this->request->data['Status']['user_id'] = $this->Auth->user('id');
//			 2013-04-26 HL 
			$this->loadModel('Jobhunter');
			$this->Jobhunter->recursive = -1;
//			 面談までいった人はフラグを渡して二度と面談しなくていいようにする
			$interview_ok = $this->Jobhunter->find('first',array('fields'=>array('interview_ok'),'conditions'=>array('Jobhunter.id'=>$this->request->data['Status']['jobhunter_id'])));
			if(empty($interview_ok['Jobhunter']['interview_ok'])) {
				$this->request->data['Status']['flag'] = Configure::read('FIRST_FLAG');
			} else {
				$this->request->data['Status']['flag'] = Configure::read('INTERVIEW_OK');	
			}
			$this->request->data['Status']['modifield'] = date('Y-m-d H:i:s');
			$this->Status->create();			
			if ($this->Status->save($this->request->data)) {
				//
				$this->loadModel('Slog');
				$this->Slog->recursive = -1;
				$this->request->data['Slog']['user_id'] = $this->Auth->user('id');;
				$this->request->data['Slog']['status_id'] = $this->Status->id;
				$this->request->data['Slog']['jobhunter_id'] = $this->request->data['Status']['jobhunter_id'];
				$this->request->data['Slog']['flag'] = $this->request->data['Status']['flag'];
				$this->Slog->create();
				if ($this->Slog->save($this->request->data)) {
					$this->Session->setFlash(__('The status has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
			}
		}
		$users = $this->Status->User->find('list');
//		#11
		$jobhunters = $this->Status->Jobhunter->find('list');
		if ($this->request->is('get') && isset($this->request->query['keyword']) && !empty($this->request->query['keyword'])) {
			$joboffers = $this->Status->Joboffer->find('list',array('conditions'=>array('Joboffer.company_name LIKE'=>'%'.strtolower($this->request->query['keyword']).'%')));
		}else{
			$joboffers = $this->Status->Joboffer->find('list');
		}
		$this->set(compact('users', 'jobhunters', 'joboffers'));
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Status->exists($id)) {
			throw new NotFoundException(__('Invalid status'));
		}
		$options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
		$this->set('status', $this->Status->find('first', $options));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Status->exists($id)) {
			throw new NotFoundException(__('Invalid status'));
		}
		$options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
		$this->set('status', $this->Status->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Status->exists($id)) {
			throw new NotFoundException(__('Invalid status'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Status->id = $id;
			$this->request->data['Status']['modifield'] = date('Y-m-d H:i:s');
			if ($this->Status->save($this->request->data)) {
				$this->loadModel('Slog');
				$this->Slog->recursive = -1;
				$this->request->data['Slog']['user_id'] = $this->Auth->user('id');;
				$this->request->data['Slog']['status_id'] = $this->Status->id;
				$jobhunter_id = $this->Status->find('first',array('fields'=>array('Status.jobhunter_id'),'conditions'=>array('Status.id'=>$this->Status->id)));
				$this->request->data['Slog']['jobhunter_id'] = $jobhunter_id['Status']['jobhunter_id'];
				$this->request->data['Slog']['flag'] = $this->request->data['Status']['flag'];
				$this->Slog->create();
				if ($this->Slog->save($this->request->data)) {
					$this->Session->setFlash(__('The status has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
			$this->request->data = $this->Status->find('first', $options);
		}
		$users = $this->Status->User->find('list');
		$jobhunters = $this->Status->Jobhunter->find('list');
		$joboffers = $this->Status->Joboffer->find('list');
		$this->set(compact('users', 'jobhunters', 'joboffers'));
	}
	
/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Status->exists($id)) {
			throw new NotFoundException(__('Invalid status'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Status->id = $id;
			$this->request->data['Status']['modifield'] = date('Y-m-d H:i:s');		
			if ($this->Status->save($this->request->data)) {
				$this->loadModel('Slog');
				$this->Slog->recursive = -1;
				$this->request->data['Slog']['user_id'] = $this->Auth->user('id');;
				$this->request->data['Slog']['status_id'] = $this->Status->id;
				$jobhunter_id = $this->Status->find('first',array('fields'=>array('Status.jobhunter_id'),'conditions'=>array('Status.id'=>$this->Status->id)));
				$this->request->data['Slog']['jobhunter_id'] = $jobhunter_id['Status']['jobhunter_id'];
				$this->request->data['Slog']['flag'] = $this->request->data['Status']['flag'];
				$this->Slog->create();
				if ($this->Slog->save($this->request->data)) {
					$this->Session->setFlash(__('The status has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The status could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
			$this->request->data = $this->Status->find('first', $options);
		}
		$users = $this->Status->User->find('list');
		$jobhunters = $this->Status->Jobhunter->find('list');
		$joboffers = $this->Status->Joboffer->find('list');
		$this->set(compact('users', 'jobhunters', 'joboffers'));
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
		$this->Status->id = $id;
		if (!$this->Status->exists()) {
			throw new NotFoundException(__('Invalid status'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Status->delete()) {
			$this->Session->setFlash(__('Status deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Status was not deleted'));
		$this->redirect(array('action' => 'index'));
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
		$this->Status->id = $id;
		if (!$this->Status->exists()) {
			throw new NotFoundException(__('Invalid status'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Status->delete()) {
			$this->Session->setFlash(__('Status deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Status was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * user_get_list_company method
 *
 * @return void
 */
	public function get_list_company_status($jobhunter_id = null) {
		Configure::write('debug', 0);		
		$this->autoRender = false;		
		$this->loadModel('Status');
		$this->loadModel('Company');
		
		//$list_company = $this->Event->find('list',array('fields'=>array('Event.company_id'),'conditions'=>array('Event.student_id'=>$student_id)));
		$list_company = $this->Status->find('list',array('fields'=>array('Status.company_id'),'conditions'=>array('Status.jobhunter_id'=>$jobhunter_id)));
		//$companies = $this->Status->find('all',array('conditions'=>array('Status.student_id'=>$student_id,'Status.company_id NOT'=>$list_company)));
		$companies = $this->Company->find('all',array('conditions'=>array('Company.id NOT'=>$list_company)));
		//pr($status);exit();				
		//$companies = $this->Event->Company->find('all',array('conditions'=>array('Company.id <>'=>$list_company)));
		$html = '';
		if(count($companies)>0){
			foreach($companies as $company){
				$html .='<option value="'.$company['Company']['id'].'">'.$company['Company']['name'].'</option>';
			}
		}
		return $html;
	}
	
/**
 * admin_get_list_company method
 *
 * @return void
 */
	public function admin_get_list_company_status($jobhunter_id = null) {
		Configure::write('debug', 0);		
		$this->autoRender = false;		
		$this->loadModel('Status');
		$this->loadModel('Company');
		
		//$list_company = $this->Event->find('list',array('fields'=>array('Event.company_id'),'conditions'=>array('Event.student_id'=>$student_id)));
		$list_company = $this->Status->find('list',array('fields'=>array('Status.company_id'),'conditions'=>array('Status.jobhunter_id'=>$jobhunter_id)));
		//$companies = $this->Status->find('all',array('conditions'=>array('Status.student_id'=>$student_id,'Status.company_id NOT'=>$list_company)));
		$companies = $this->Company->find('all',array('conditions'=>array('Company.id NOT'=>$list_company)));
		//pr($status);exit();				
		//$companies = $this->Event->Company->find('all',array('conditions'=>array('Company.id <>'=>$list_company)));
		$html = '';
		if(count($companies)>0){
			foreach($companies as $company){
				$html .='<option value="'.$company['Company']['id'].'">'.$company['Company']['name'].'</option>';
			}
		}
		return $html;
	}
	
/**
 * user_get_list_joboffer method
 *
 * @return void
 */
	public function get_list_joboffer_status($jobhunter_id = null, $keyword = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;		
		$this->loadModel('Status');
		$this->loadModel('Joboffer');
		$this->loadModel('Company');
		
//		#10
		/*if($this->Auth->user('mark_user')==2){
			$list_joboffer = $this->Status->find('list',array('fields'=>array('Status.joboffer_id'),'conditions'=>array('Status.jobhunter_id'=>$jobhunter_id)));
			$joboffers = $this->Joboffer->find('all',array('conditions'=>array('Joboffer.id NOT'=>$list_joboffer,'Joboffer.user_id'=>$this->Auth->user('id'))));
		}else{*/
//			#11
			$list_joboffer = $this->Status->find('list',array('fields'=>array('Status.joboffer_id'),'conditions'=>array('Status.jobhunter_id'=>$jobhunter_id)));
			if(!empty($keyword)){				
				$joboffers = $this->Joboffer->find('all',array('conditions'=>array('Joboffer.id NOT'=>$list_joboffer,'Joboffer.company_name LIKE'=>'%'.strtolower($keyword).'%')));		
			}else{
				$joboffers = $this->Joboffer->find('all',array('conditions'=>array('Joboffer.id NOT'=>$list_joboffer)));		
			}
//		}		

		$html = '';
		if(count($joboffers)>0){
			foreach($joboffers as $joboffer){				
				$html .='<option value="'.$joboffer['Joboffer']['id'].'">'."「企業名」 ".$joboffer['Joboffer']['company_name']." - 「職場」 ".$joboffer['Joboffer']['city'] ." - 「担当者」 ".$joboffer['Joboffer']['contact'] .'</option>';
			}
		}
		return $html;
	}
	
/**
 * user_get_list_joboffer method
 *
 * @return void
 */
	public function get_list_jobhunter_status() {
		Configure::write('debug', 0);
		$this->autoRender = false;		
		$this->loadModel('Status');
		$this->loadModel('Jobhunter');
		$this->loadModel('Company');
		/*if($this->Auth->user('mark_user')==2){
			//$list_joboffer = $this->Status->find('list',array('fields'=>array('Status.joboffer_id'),'conditions'=>array('Status.user_id'=>$jobhunter_id)));
			$jobhunters = $this->Jobhunter->find('all',array('conditions'=>array('Jobhunter.user_id'=>$this->Auth->user('id'))));*/
//		}else{
			//$list_joboffer = $this->Status->find('list',array('fields'=>array('Status.joboffer_id'),'conditions'=>array('Status.jobhunter_id'=>$jobhunter_id)));
			$jobhunters = $this->Jobhunter->find('all');		
//		}		

		$html = '';
		if(count($jobhunters)>0){
			foreach($jobhunters as $jobhunter){				
				$html .='<option value="'.$jobhunter['Jobhunter']['id'].'">'.$jobhunter['Jobhunter']['name'].'</option>';
			}
		}
		return $html;
	}

/**
 * user_updateStatus method
 *
 * @return void
 */
	public function updateStatus(){
		Configure::write('debug', 0);		
		$this->autoRender = false;		
		$this->Status->id = $this->request->data['id'];
		$this->Status->saveField('flag',$this->request->data['flag']);		
		if(isset($this->request->data['price'])) {
			$this->Status->saveField('price',$this->request->data['price']);		
		}
		$this->Status->saveField('modifield',date('Y-m-d H:i:s'));		
		
		$status = $this->Status->findById($this->Status->id);		
		if($this->request->data['flag']==31){
			$this->Status->Jobhunter->id = $status['Status']['jobhunter_id'];
			$this->Status->Jobhunter->saveField('interview_ok',1);
		}
		
		$this->Status->Slog->recursive = -1;
		$this->Status->Slog->create();
		$slog['Slog']['user_id'] = $this->Auth->user('id');
		$slog['Slog']['status_id'] = $this->Status->id;
		$slog['Slog']['jobhunter_id'] = $status['Status']['jobhunter_id'];
		$slog['Slog']['flag'] = $this->request->data['flag'];
		$this->Status->Slog->save($slog);
		
		return 'true';
	}
}