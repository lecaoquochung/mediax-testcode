<?php
/*------------------------------------------------------------------------------------------------------------
 * Sales
 * param01: offset (start: 0)
 * param02: limit (default: 300)
 * param03: interval time (default: 15)
 * param04: c_logic (boolean: check company) -> deprecated
 * param05: random time between 2 query 01 (default: 10)
 * param06: random time between 2 query 02 (default: 30)
 * param07: interval keyword (default: 40 -> best testing)
 * param08: speed (boolean: delay or not on crawler)
 * param09: company (UserID default:0 not set check all)
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 * run: sales 0 300 15 1 10 30 40 1 0
 *-----------------------------------------------------------------------------------------------------------*/	

App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');

class SalesShell extends Shell {

	public $uses = array('Keyword', 'Rankhistory');

	public function main() {
		// offset
		@$offset = $this->args[0];
		
		// limit
		@$limit =  $this->args[1];
		
		// interval time
		@$interval_time = $this->args[2]*60;
		
		// c logic
		$c_logic = 0;
		if(@$this->args[3] == 1) {
			$c_logic = 1;
		}
		
		// random time 01
		$rand01 = 10;
		if(isset($this->args[4])) {
			$rand01 = $this->args[4];
		}
		
		// random time 01
		$rand02 = 30;
		if(isset($this->args[5])) {
			$rand02 = $this->args[5];
		}
		
		// interval keyword
		$interval_keyword = 40;
		if(isset($this->args[6])) {
			$interval_keyword = $this->args[6];
		}
		
		// speed query
		$speed = 0;
		if(@$this->args[7] == 1) {
			$speed = $this->args[7];
		}
		
		// company or UserID
		$user_id = 0;
		if(isset($this->args[8])) {
			$user_id = $this->args[8];
		}
		
		$start_time = date('Ymd H:i:s');
		$this -> out($start_time);
		
		//load component
		$component = new ComponentCollection();
		App::import('Component', 'Rank');
		$this -> Rank = new RankComponent($component);
		$component1 = new ComponentCollection();
		App::import('Component', 'RankMobile');
		$this -> RankMobile = new RankMobileComponent($component1);
		
		// recursive
		$this -> Keyword -> recursive = -1;
		
		// filter keyword
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
//		$conds['Keyword.c_logic'] = $c_logic; // deprecated
		$conds['Keyword.sales'] = 1;
		$user_id !=0 ? $conds['Keyword.UserID'] = $user_id : '';
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);

		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset));
		$this -> out('Keyword: ' .count($keywords));
		
		$count = 0;
		foreach ($keywords as $keyword) {
			$time_start = microtime(true);
			$count++;
			if(($count % $interval_keyword) == 0) {
				$sleep = $interval_time;
				$this -> out('---------------' .$start_time .' ' .date('Ymd H:i:s') .' ' .$sleep .'s ------------------');
				sleep($sleep);
			} else {
				sleep(rand($rand01,$rand02));
			}
			if ($keyword != false) {
				if ($keyword['Keyword']['Strict'] == 1) {
					$domain = $this -> Rank -> remainUrl($keyword['Keyword']['Url']);
				} else {
					$domain = $this -> Rank -> remainDomain($keyword['Keyword']['Url']);
				}
			}

			$engine = $keyword['Keyword']['Engine'];
			
//			* param01: Engine
// 			* param02: Url
// 			* param03: Keyword
// 			* param04: Strict
// 			* param05: Google Local
// 			* param06: Speed
			if ($engine == 3) {
				$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local'], $speed) 
						.'/' 
						.$this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local'], $speed);
			} elseif ($engine == 1) {
				$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
			} elseif ($engine == 2) {
				$rank = $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
			} else {//end
				$engine_list = $this -> Rank -> getEngineList();
				$rank = $this -> Rank -> keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
			}

			//delete Rankhistory current date
			$this -> Keyword -> Rankhistory -> deleteAll(array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => date('Ymd')));

			//Insert Rankhistory current date
			$rankhistory['Rankhistory']['KeyID'] = $keyword['Keyword']['ID'];
			$rankhistory['Rankhistory']['Url'] = $domain;
			$rankhistory['Rankhistory']['Rank'] = $rank;
			$rankhistory['Rankhistory']['RankDate'] = date('Ymd');

			//check color and arrow
			$check_params = array();
			$rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));

			# cache
			$data_rankhistory = $this -> Rankhistory -> find('first', array(
				'fields' => array('Rankhistory.Rank'), 
				'conditions' => array(
					'Rankhistory.KeyID' => $keyword['Keyword']['ID'], 
					'Rankhistory.RankDate' => $rankDate
			)));

			if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
				$rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
			} elseif (isset($data_rankhistory['Rankhistory']['Rank']) && !strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
				$rank_old[0] = $data_rankhistory['Rankhistory']['Rank'];
				$rank_old[1] = $data_rankhistory['Rankhistory']['Rank'];
			} else {
				$rank_old[0] = 0;
				$rank_old[1] = 0;
			}

			if ($engine == 1) {
				$rank = $rank . '/' . $rank;
			}

			if ($engine == 2) {
				$rank = $rank . '/' . $rank;
			}

			if (!empty($rank) && strpos($rank, '/')) {
				$rank_new = explode('/', $rank);
			} else {
				$rank_new[0] = 0;
				$rank_new[1] = 0;
			}

			//color
			if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
				$check_params['color'] = '#E4EDF9';
			} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
				$check_params['color'] = '#FFBFBF';
			} else if ($rank_new[0] > 10 && $rank_new[0] <= 20 || $rank_new[1] > 10 && $rank_new[1] <= 20) {
				$check_params['color'] = '#FAFAD2';
			} else {
				$check_params['color'] = '';
			}

			//arrow
			if (($rank_new[0] > $rank_old[0] && $rank_old[0] !=0) || ($rank_new[1] > $rank_old[1] && $rank_old[1] !=0) || ($rank_new[0] == 0 && $rank_old[0] != 0) || ($rank_new[1] == 0 && $rank_old[1] != 0)) {
				$check_params['arrow'] = '<span class="red-arrow">↓</span>';
			} else if (($rank_new[0] < $rank_old[0]) || ($rank_new[1] < $rank_old[1]) || ($rank_old[0] == 0 && $rank_new[0] != 0)) {
				$check_params['arrow'] = '<span class="blue-arrow">↑</span>';
			} else {
				$check_params['arrow'] = '';
			}

			$rankhistory['Rankhistory']['params'] = json_encode($check_params);
			$this -> Keyword -> Rankhistory -> create();
			$this -> Keyword -> Rankhistory -> save($rankhistory);

			$duration = $this -> Keyword -> Duration -> find('first', array('fields' => array('Duration.StartDate'), 'conditions' => array('Duration.KeyID' => $keyword['Keyword']['ID'], 'Duration.Flag' => 2), 'order' => 'Duration.ID'));

			if ($duration == false) {
				if (strpos($rank, '/') !== false) {
					$ranks = explode('/', $rank);
					$google_rank = $ranks[0];
					$yahoo_rank = $ranks[1];
				}

				if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
					$durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
					$durations['Duration']['StartDate'] = date('Ymd');
					$durations['Duration']['EndDate'] = 0;
					$durations['Duration']['Flag'] = 2;
					$this -> Keyword -> Duration -> create();
					$this -> Keyword -> Duration -> save($durations);
				}
				sleep(1);
			}
			//done keyword
			$time_end = microtime(true); 
			$execution_time = $time_end - $time_start;
			$this -> out($count .' ' .date('H:i:s') .' ' . $keyword['Keyword']['ID'] .' ' .$rank . ' ' . $keyword['Keyword']['Keyword'] . ' ' . $keyword['Keyword']['Url'] .' ' .$execution_time .'s');
		}
		
		// load rank successfully
		$this -> out('---------------DONE------------------');
		$end_time = date('Ymd H:i:s');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out('-------------------------------------');
		
		$Email = new CakeEmail();
		$Email->from(array('server-admin@'.$_SERVER['HOSTNAME'] => 'MEDIAX ADMIN'));
		$Email->to('lecaoquochung.com@gmail.com');
		$Email->subject('Load Server Time');
		$Email->send("Start time: ".$start_time."\n End time: ".$end_time);		
	}

}
?>
