<?php

App::uses('Component', 'Controller');
/*------------------------------------------------------------------------------------------------------------
 * DDNB Security Component
 *
 * @input
 * @output
 *
 * @author		ddnb_admin <admin@ddnb.info>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2014-08
 -------------------------------------------------------------------------------------------------------------*/

class SecurityComponent extends Component {
	
	var $components = array('Session');
	
	public function startup(Controller $controller) {
		$this->Controller = $controller;
	}

	// password
	var $password_length = 8;
	var $password_charlist = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$";

	public function getRandomPassword() {
		do {
			$password = $this -> createRandomPassword();
		} while ( $this->isVulnerable($password) === true );
		return $password;
	}

	private function createRandomPassword() {
		return substr(str_shuffle($this -> password_charlist), 0, $this -> password_length);
	}

	private function isVulnerable($password) {
		if (preg_match("/[0-9]{1,}/", $password) && preg_match("/[a-z]{1,}/", $password) && preg_match("/[A-Z]{1,}/", $password)) {
			return false;
		} else {
			return true;
		}
	}
	
/*----------------------------------------------------------------------
  * return local ip address method
  * 
  * @author: lecaoquochung@gmail.com
  * @created 2015
  * @update
  *----------------------------------------------------------------------*/
	function return_localhostip() {
		// $ip = gethostbyname('localhost');
		$externalContent = file_get_contents('http://checkip.dyndns.com/');
		preg_match('/Current IP Address: ([\[\]:.[0-9a-fA-F]+)</', $externalContent, $match);
		$localhostIP = $match[1];
		return $localhostIP;
	}
	
/*----------------------------------------------------------------------
  * return mac address method
  * 
  * @author: lecaoquochung@gmail.com
  * @created 2014-07
  * @update
  *----------------------------------------------------------------------*/
	function return_macaddress() {
		// WARNING: the commands 'which' and 'arp' should be executable
		// by the apache user; on most linux boxes the default configuration
		// should work fine
		// get the arp executable path
		$location = 'which arp';
		$location = shell_exec($location);
		// debug($location);
		$location = rtrim($location);
		// Execute the arp command and store the output in $arpTable
		$arpTable = "$location -n";
		debug($arpTable);
		$arpTable = shell_exec($arpTable);
		// debug($arpTable);
		// Split the output so every line is an entry of the $arpSplitted array
		$arpSplitted = split("\n", $arpTable);
		// get the remote ip address (the ip address of the client, the browser)
		$remoteIp = $_SERVER['REMOTE_ADDR'];
		$remoteIp = str_replace(".", "\\.", $remoteIp);
		// Cicle the array to find the match with the remote ip address
		foreach ($arpSplitted as $value) {
			// Split every arp line, this is done in case the format of the arp
			// command output is a bit different than expected
			$valueSplitted = split(" ", $value);
			foreach ($valueSplitted as $spLine) {
				$ipFound = False;
				if (preg_match("/$remoteIp/", $spLine)) {
					$ipFound = true;
				}
				// The ip address has been found, now rescan all the string
				// to get the mac address
				if ($ipFound) {
					// Rescan all the string, in case the mac address, in the string
					// returned by arp, comes before the ip address
					// (you know, Murphy's laws)
					reset($valueSplitted);
					foreach ($valueSplitted as $spLine) {
						if (preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $spLine)) {
							return $spLine;
						}
					}
				}
				$ipFound = false;
			}
		}
		return false;
	}

/*----------------------------------------------------------------------
 * system log method
 * 
 * @author: lecaoquochung@gmail.com
 * @created 2015
 * @client: $this->permCheck, Keyword->set_inline_rank
 *----------------------------------------------------------------------*/
	function SystemLog($client = Null) {
		$db = ClassRegistry::init('Log');
		$here = $this->Controller->here;
		if($client == Null) {
			$client = array(__('Permission Required'), $this->Session->read('Auth.User.user.email'), $here);
		}
		$client = json_encode($client);
		
		if(count($this->Session->read('Auth.User.user'))>0) {
			$data['Log']['user_id'] = $this->Session->read('Auth.User.user.id');
			$data['Log']['log'] = $client;
			$data['Log']['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['Log']['useragent'] = $_SERVER['HTTP_USER_AGENT'];
			$data['Log']['mvc'] = $here;
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
	
/*----------------------------------------------------------------------
  * perm check method
  * 
  * @author: lecaoquochung@gmail.com
  * @created 2015
  *----------------------------------------------------------------------*/
	function permCheck() {
		$role = $this->Session->read('Auth.User.user.role');
		if($role!= 1) {
			$this->SystemLog(Null);
			$this -> Session -> setFlash(__('Permission Required'), 'default', array('class' => 'alert alert-danger alert-dismissable'));
			$this->Controller->redirect($this->Controller->referer());
		}
		
		return True;
	}
	
}
?>