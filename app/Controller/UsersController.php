<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public $components = array('Mediax');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$conds = array();
		$fields = array();
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}
	
/**
 * agent method
 *
 * @return void
 */
	public function agent() {
		$this->User->recursive = 0;
		$conds = array();
		$fields = array();
		$conds['User.agent'] = 1;
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}

/**
 * agent set method
 *
 * @return void
 */
    public function agent_set($id = NULL) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->data['User']['agent'] = 1;
        
        if ($this->User->save($this->request->data)) {
            $this->Session->setFlash(__('The agent setting has been saved'), 'default', array('class' => 'success'));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__('The agent setting could not be saved. Please, try again.'), 'default', array('class' => 'error'));
        }
        
    }
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {               
        set_time_limit(0);
		ini_set('memory_limit', '512M');
		$this->User->recursive = 2;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
        $user = $this->User->find('first',array(
            'fields'=>array('User.company', 'User.email', 'User.name', 'User.tel', 'User.fax', 'User.agent', 'User.pwd', 'User.limit_price_multi', 'User.limit_price_multi2', 'User.limit_price_multi3'),
            'conditions'=>array('User.id'=>$id),
            'contain'=>array(
                'Keyword'=>array(
                    'fields'=>array('Keyword.ID', 'Keyword.Keyword as keyword', 'Keyword.Url', 'Keyword.rankstart', 'Keyword.nocontract', 'Keyword.rankend','Keyword.Engine', 'Keyword.limit_price_group', 'Keyword.c_logic'),
					'Duration' => array(
						'conditions'=>array('Duration.Flag'=>1),
						'fields' => array('Duration.ID','Duration.KeyID','Duration.StartDate','Duration.EndDate','Duration.Flag')
					),
					'order' => 'Keyword.ID DESC'
                )
            ),
		));
		
		$this->set('user', $user);
        $conds = array();
        $conds['Rankhistory.RankDate'] = date('Ymd');
        if($this->request->is('post')){
			$conds['Rankhistory.RankDate'] = implode('',$this->request->data['Rankhistory']['rankDate']);
        }                
        $rankhistory = $this->User->Keyword->Rankhistory->find('list',array(
            'fields'=>array('Rankhistory.KeyID','Rankhistory.Rank'),
            'conditions'=>$conds
        ));
        $this->set('rankhistory', $rankhistory);
		
		// extra
		$keyword_ids = Hash::extract($user['Keyword'], '{n}.ID');
		$this->loadModel('Extra');
		$this->Extra->recursive = -1;
		$extras = $this->Extra->find('all',array('fields'=>array('Extra.ExtraType','Extra.Price','Extra.KeyID'),'conditions'=>array('Extra.KeyID'=>$keyword_ids)));
		$this->set('extras', $extras);
	}

/*------------------------------------------------------------------------------------------------------------
 * users ranklog (view on NEW rank data)
 * 
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created 20151125
 * @updated
 *-----------------------------------------------------------------------------------------------------------*/	
	public function ranklog($id = null) {               
        set_time_limit(0);
		ini_set('memory_limit', '512M');
		$this->User->recursive = 0;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
        $user = $this->User->find('first',array(
            'fields'=>array('User.company', 'User.email', 'User.name', 'User.tel', 'User.fax', 'User.agent', 'User.pwd', 'User.limit_price_multi', 'User.limit_price_multi2', 'User.limit_price_multi3'),
            'conditions'=>array('User.id'=>$id),
            'contain'=>array(
                'Keyword'=>array(
                    'fields'=>array('Keyword.ID', 'Keyword.Keyword as keyword', 'Keyword.Url', 'Keyword.rankstart', 'Keyword.nocontract', 'Keyword.rankend','Keyword.Engine', 'Keyword.limit_price_group', 'Keyword.c_logic'),
					'Duration' => array(
						'conditions'=>array('Duration.Flag'=>1),
						'fields' => array('Duration.ID','Duration.KeyID','Duration.StartDate','Duration.EndDate','Duration.Flag')
					),
					'order' => 'Keyword.ID DESC'
                )
            ),
		));
		
		$keywords = Hash::extract($user['Keyword'], '{n}.ID');
		
		$conds = array();
        $conds['Ranklog.keyword_id'] = $keywords;
        $conds['Ranklog.rankdate'] = date('Y-m-d');
		$fields = array('Ranklog.keyword_id','Ranklog.rank');
		
		$conds_g = array();
		$conds_g = array();
        $conds_g['Ranklog.keyword_id'] = $keywords;
        $conds_g['Ranklog.rankdate >='] = date('Y-m-d', strtotime("-30 days"));
		$fields_g = array('Ranklog.keyword_id','Ranklog.rank', 'Ranklog.rankdate');
		$limit_g = count($keywords)*30;
		$order_g = 'Ranklog.rankdate DESC';
		
		// post
        if($this->request->is('post')){
			$conds['Ranklog.rankdate'] = implode('',$this->request->data['Rankhistory']['rankDate']);
        }

        $graph = $this->User->Keyword->Ranklog->find('list',array('fields'=>$fields_g,'conditions'=>$conds_g, 'limit' => $limit_g, 'order' => $order_g));
		$rankhistory = $graph[date('Y-m-d')];

		foreach($graph as $key => $value) {
			foreach ($value as $keyID => $json) {
				// rank==0?100:rank
				$graph[$key][$keyID] = $this->Mediax->bestRankJson($json) == 0 ? 100 : $this->Mediax->bestRankJson($json);
			}
		}
		
		// array_reverse
		$graph = (array_values($graph));
		foreach ($graph as $key => $value) {
			$graph[$key] = array_sum($value)/count($value);
		}
		
		// extra
		$keyword_ids = Hash::extract($user['Keyword'], '{n}.ID');
		$this->loadModel('Extra');
		$this->Extra->recursive = -1;
		$extras = $this->Extra->find('all',array('fields'=>array('Extra.ExtraType','Extra.Price','Extra.KeyID'),'conditions'=>array('Extra.KeyID'=>$keyword_ids)));
		
		$this->set(compact('user', 'extras', 'rankhistory', 'graph'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		     # Hash user password with md5
			$this->User->create();
            if($this->request->data['User']['pwd'] != '') {
                $this->request->data['User']['pwd'] = md5($this->request->data['User']['pwd']); 
            }
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                unset($this->request->data['User']['pwd']);
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            # Hash user password with md5
            if($this->request->data['User']['pwd'] != '') {
                $this->request->data['User']['pwd'] = md5($this->request->data['User']['pwd']); 
            }else{
                $User = $this->User->read(null, $id);
                $this->request->data['User']['pwd'] = $User['User']['pwd'];
            }
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The company has been saved'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'view',$id));
            } else {
                $this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['pwd']);
        }
    }

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect($this->referer());
	}

/*------------------------------------------------------------------------------------------------------------
 * admin method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 *-----------------------------------------------------------------------------------------------------------*/
    public function admin() {
        if($this->Session->read('Auth.User.user.role')!=1) {
                $this->Security->SystemLog(Null);
                throw new NotFoundException(__('Page Not Found'));
        }

        $this->User->recursive = 0;
        $conds = array();
        $conds['User.role'] =array(1,2);
        $fields = array();
        $this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
    }
	
/*------------------------------------------------------------------------------------------------------------
 * add admin method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 *-----------------------------------------------------------------------------------------------------------*/
    public function add_admin() {
        $this->Security->permCheck();

        if ($this -> request -> is('post')) {
            $this -> User -> create();
            if ($this -> request -> data['User']['password'] != '') {
                $this -> request -> data['User']['password'] = Security::hash($this->request->data['User']['password'], 'sha1', Configure::read('Security.salt'));
            }
            if ($this -> User -> save($this -> request -> data)) {

                $data = array($this -> request -> data['User']['name'], $this -> request -> data['User']['password'], $this->request->data['User']['email']);
                $email = array();
                $email = Configure::read('Admin.email');
                $email[] = $this->request->data['User']['email'];

                //send mail
                $sendmail = $this->sendMail(array(
                    'to'=> $email,
                    'subject'=>'[MediaX]新規アカウント発行お知らせ',
                    'template'=>'admin',
                    'data'=>$data
                ));

                $this -> Session -> setFlash(__('The user has been saved'));
                $this -> redirect(array('action' => 'admin'));
            } else {
                $this -> Session -> setFlash(__('The user could not be saved. Please, try again.'));
                unset($this -> request -> data['User']['pwd']);
            }
        }
    }

/*------------------------------------------------------------------------------------------------------------
 * edit admin method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 *-----------------------------------------------------------------------------------------------------------*/
    public function edit_admin($id = null) {
        $this->Security->permCheck();

        $this -> User -> id = $id;
        if (!$this -> User -> exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this -> request -> is('post') || $this -> request -> is('put')) {
            if ($this -> request -> data['User']['password'] != '') {
                $this -> request -> data['User']['password'] = Security::hash($this->request->data['User']['password'], 'sha1', Configure::read('Security.salt'));
            } else {
                $User = $this -> User -> read(null, $id);
                $this -> request -> data['User']['password'] = $User['User']['pwd'];
            }
            if ($this -> User -> save($this -> request -> data)) {
                $this -> Session -> setFlash(__('The company has been saved'), 'default', array('class' => 'success'));
                // $this -> redirect(array('action' => 'view', $id));
                $this -> redirect(array('action' => 'admin'));
            } else {
                $this -> Session -> setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        } else {
            $this -> request -> data = $this -> User -> read(null, $id);
            unset($this -> request -> data['User']['password']);
        }
    }

/*------------------------------------------------------------------------------------------------------------
 * delete admin method
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 *-----------------------------------------------------------------------------------------------------------*/
    public function delete_admin($id = null) {
        $this->Security->permCheck();

        if (!$this -> request -> is('post')) {
            throw new MethodNotAllowedException();
        }

        $this -> User -> id = $id;
        if (!$this -> User -> exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this -> User -> delete()) {
            $this -> Session -> setFlash(__('User deleted'));
            $this -> redirect(array('action' => 'admin'));
        }
        $this -> Session -> setFlash(__('User was not deleted'));
        $this -> redirect(array('action' => 'admin'));
    }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
* login method
*
* @return void
*/	
	public function login() {
        $login_url = 'https://' .$_SERVER['SERVER_NAME'] .$this->here;
        if($_SERVER['SERVER_PORT'] == 80) {
            $this->redirect($login_url);    
        }

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		
		$this->layout = 'default';
	}

/**
* logout method
*
* @return void
*/		
	public function logout() {
		$this->Session->destroy();
		$this->Cookie->delete('auto_login_mediax.user');
		$this->redirect($this->Auth->logout());
	}	

/**
* admin_login method
*
* @return void
*/		
	public function admin_login() {
		/*if ($this->request->clientIp() != '124.33.192.250') {
	        throw new ForbiddenException();
	    }*/
		$auto_login['user'] = $this->Cookie->read('auto_login.admin');
		
		if(!empty($auto_login['user'])){
			$this->Session->write('Auth.user.admin',$auto_login['user']);
			return $this->redirect($this->Auth->redirectUrl());
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if(!empty($this->request->data['User']['remember'])){					
					$this->Cookie->write('auto_login.admin',$this->Auth->user());
				}
				$this->Session->write('Auth.user.admin',$auto_login["user"]);
				return $this->redirect($this->Auth->redirectUrl());
				$this->redirect(array('admin'=>true,'controller' => 'users', 'action' => 'top'));
			} else {
				$this->Session->setFlash(__('Username or password is incorrect. Please, try again.'));
			}
		}
	}	

/**
 * admin_logout method
 *
  * @return void
 */		
	public function admin_logout() {
		$this->Cookie->delete('auto_login.admin');
		$this->redirect($this->Auth->logout());
	}	

/**
 * top method
 *
  * @return void
 */	
	public function top() {

	}
	
/**
 * admin_top method
 *
  * @return void
 */	
	public function admin_top(){
		
	}

/**
 * limit price multi method
 *
  * @return void
 */		
	public function limit_price_multi(){
        Configure::write('debug', 0);
        $this->autoRender = false;
        
        $this->User->updateAll(
			array('User.limit_price_multi'=>$this->request->data['value']),
			array('User.id'=>$this->request->data['pk'])
		);
		
        $message = array();
		$message['name'] = 'limit_price_multi';
        $message['value'] = $this->request->data['value'];
		return json_encode($message);
    }

/**
 * hl limit or not method
 *
  * @return void
 */	
	public function limit_or_not(){
        Configure::write('debug', 0);
        $this->autoRender = false;	

		$keyIDs = explode('-',$this->request->data['keyID']);		
        $fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate',
            'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict'
        );
		
		$total_price = array();
		
		foreach($keyIDs as $keyID){
			#Extra
			$this->loadModel('Extra');
			$this->Extra->recursive = -1;
			$extra = $this->Extra->find('list',array('fields'=>array('Extra.ExtraType','Extra.Price'),'conditions'=>array('Extra.KeyID'=>$keyID)));
			
			$conds = array();
			$conds['Rankhistory.KeyID'] = $keyID;		
			
			$month_start_day = date('Ym') .'01';
			$month_end_day = date('Ym') .'31';		
			$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($month_start_day, $month_end_day);
			
			$this->loadModel('Rankhistory');
			$this->Rankhistory->recursive = 2;
			$rankhistories = $this->Rankhistory->find('all',array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.ID DESC'));
			
			foreach($rankhistories as $rankhistory){
				if ($rankhistory['Keyword']['Engine'] == 1) {
					$google_rank = $rankhistory['Rankhistory']['Rank'];
					$yahoo_rank = 0;
				} 
				elseif ($rankhistory['Keyword']['Engine'] == 2) {
					$google_rank = 0;
					$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
				}else {
					$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
					$google_rank = $ranks[0];
					$yahoo_rank = $ranks[1];
				}
				
				$data_extra = array();		
				foreach($extra as $key_extra => $value_extra) {
					if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
						$data_extra[$key_extra] = $value_extra;
					}
				}
				
				if(count($data_extra)>0){
					ksort($data_extra);
					$key_extra = array_keys($data_extra);			
					$total_price[] = $data_extra[$key_extra[0]];
				}else{
					foreach($extra as $key => $value) {
						if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
							$total_price[] = isset($value) ? $value : 0;
						}
					} 
				}		
			}			
		}
		
		$message = array();
		$message['total'] = array_sum($total_price);
		$message['price'] = money_format('%.0n',array_sum($total_price));
		$message['limit_price']  = $message['total'] > $this->request->data['limit_price']?money_format('%.0n',$this->request->data['limit_price']):$message['price'];
		$message['limit_or_not'] = $message['total'] >= $this->request->data['limit_price']?'上限達成':'';
		return json_encode($message);								
	}		
	
}