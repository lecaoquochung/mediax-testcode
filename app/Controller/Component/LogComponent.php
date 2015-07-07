<?php
App::uses('Component', 'Controller');
/**
 * Log Component
 *
 * @package  Log.Component
 * @author   ddnb_admin <admin@ddnb.info>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.ddnb.info
 * @created  2014-08-27
 * @updated
 */
class LogComponent extends Component {
	
	public $components = array('DdnbCommon', 'Session', 'Security');
	
 /*----------------------------------------------------------------------
  * system log method
  * 
  * @author: lecaoquochung@gmail.com
  * @created 2015
  * @update
  *----------------------------------------------------------------------*/
	function SystemLog($client_log = Null, $mvc = Null) {
		$db = ClassRegistry::init('Log');
		if(isset($_SESSION['Auth']['User']['user'])) {
			$data['Log']['user_id'] = $_SESSION['Auth']['User']['user']['id'];
			$data['Log']['log'] = $client_log;
			$data['Log']['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['Log']['useragent'] = $_SERVER['HTTP_USER_AGENT'];
			$data['Log']['mvc'] = $mvc;
		} else {
			$this -> redirect(array('controller' => 'users', 'action' => 'logout'));
		}
		
		// data
		if($db -> save($data)) {
			return 1;
		} else {
			return 0;
		}
	}
}
?>