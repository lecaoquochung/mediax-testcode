<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('DdnbCommonComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');

class LoadServerTimeMobileShell extends Shell {

	public $uses = array('Keyword', 'MRankhistory');

	public function main() {
		$offset = $this->args[0];
		$limit =  $this->args[1];
		
		$interval_time = 15*60;
		if(isset($this->args[2])) {
			$interval_time = $this->args[2]*60;
		}
		
		$keyword_interval = 50;
		if(isset($this->args[3])) {
			$keyword_interval = $this->args[3];
		}

		$start_time = date('Ymd h:i:s');
		//load component
		$component = new ComponentCollection();
		App::import('Component', 'RankMobile');
		$this -> RankMobile = new RankMobileComponent($component);
		
		$component1 = new ComponentCollection();
		App::import('Component', 'DdnbCommon');
		$this -> DdnbCommon = new DdnbCommonComponent($component1);
		
		// recursive
		$this -> Keyword -> recursive = -1;
		
		// filter keyword
		$conds = array();
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.mobile'] = 1;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);

		// $keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset, 'order' => 'rand()'));
		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset));
		
		$count = 0;
		foreach ($keywords as $keyword) {
			$time_start = microtime(true);
			$count++;
			if(($count%$keyword_interval)==0) {
				$sleep = rand(15*60, $interval_time);
				$this -> out('---------------' .$start_time .' ' .date('Ymd H:i:s') .' ' .$sleep .'s ------------------');
				sleep($sleep);
			} else {
				sleep(rand(7,14));
			}
			
			$rank = array();
			$rank['google_jp'] = $this -> RankMobile -> GoogleJP('google_jp', $keyword['Keyword']['Url'], $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], 0, True);
			$rank['yahoo_jp'] = $this -> RankMobile -> YahooJP('yahoo_jp', $keyword['Keyword']['Url'], $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], 0, True);
			$rank = json_encode($rank);

			//delete Rankhistory current date
			$this -> Keyword -> MRankhistory -> deleteAll(array('MRankhistory.keyword_id' => $keyword['Keyword']['ID'], 'MRankhistory.rankdate' => date('Ymd')));

			//Insert Rankhistory current date
			$m_rankhistory = array();
			$m_rankhistory['MRankhistory']['keyword_id'] = $keyword['Keyword']['ID'];
			$m_rankhistory['MRankhistory']['engine_id'] = 3;
			$m_rankhistory['MRankhistory']['keyword'] = $keyword['Keyword']['Keyword'];
			$m_rankhistory['MRankhistory']['url'] = $keyword['Keyword']['Url'];;
			$m_rankhistory['MRankhistory']['rank'] = $rank;
			$m_rankhistory['MRankhistory']['rankdate'] = date('Ymd');

			//check color and arrow
			// $check_params = array();
			// $rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));

			// cache
			// $data_rankhistory = $this -> Rankhistory -> find('first', array(
				// 'fields' => array('Rankhistory.Rank'), 
				// 'conditions' => array(
					// 'Rankhistory.KeyID' => $keyword['Keyword']['ID'], 
					// 'Rankhistory.RankDate' => $rankDate
			// )));
			// if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
				// $rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
			// } elseif (isset($data_rankhistory['Rankhistory']['Rank']) && !strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
				// $rank_old[0] = $data_rankhistory['Rankhistory']['Rank'];
				// $rank_old[1] = $data_rankhistory['Rankhistory']['Rank'];
			// } else {
				// $rank_old[0] = 0;
				// $rank_old[1] = 0;
			// }
			// if ($engine == 1) {
				// $rank = $rank . '/' . $rank;
			// }
			// if ($engine == 2) {
				// $rank = $rank . '/' . $rank;
			// }
			// if (!empty($rank) && strpos($rank, '/')) {
				// $rank_new = explode('/', $rank);
			// } else {
				// $rank_new[0] = 0;
				// $rank_new[1] = 0;
			// }

			//color
			// $color_code = Configure::read('Color.code');
			// if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
				// $check_params['color'] = $color_code['green'];
			// } else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
				// $check_params['color'] = $color_code['red'];
			// } else if ($rank_new[0] > 10 && $rank_new[0] <= 20 || $rank_new[1] > 10 && $rank_new[1] <= 20) {
				// $check_params['color'] = $color_code['yellow'];
			// } else {
				// $check_params['color'] = '';
			// }

			//arrow
			// if (($rank_new[0] > $rank_old[0] && $rank_old[0] !=0) || ($rank_new[1] > $rank_old[1] && $rank_old[1] !=0) || ($rank_new[0] == 0 && $rank_old[0] != 0) || ($rank_new[1] == 0 && $rank_old[1] != 0)) {
				// $check_params['arrow'] = '<span class="red-arrow">↓</span>';
			// } else if (($rank_new[0] < $rank_old[0]) || ($rank_new[1] < $rank_old[1]) || ($rank_old[0] == 0 && $rank_new[0] != 0)) {
				// $check_params['arrow'] = '<span class="blue-arrow">↑</span>';
			// } else {
				// $check_params['arrow'] = '';
			// }

			// $rankhistory['Rankhistory']['params'] = json_encode($check_params);
			$this -> Keyword -> MRankhistory -> create();
			$this -> Keyword -> MRankhistory -> save($m_rankhistory);

			
			// $duration = $this -> Keyword -> Duration -> find('first', array('fields' => array('Duration.StartDate'), 'conditions' => array('Duration.KeyID' => $keyword['Keyword']['ID'], 'Duration.Flag' => 2), 'order' => 'Duration.ID'));
			// if ($duration == false) {
				// if (strpos($rank, '/') !== false) {
					// $ranks = explode('/', $rank);
					// $google_rank = $ranks[0];
					// $yahoo_rank = $ranks[1];
				// }
				// if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
					// $durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
					// $durations['Duration']['StartDate'] = date('Ymd');
					// $durations['Duration']['EndDate'] = 0;
					// $durations['Duration']['Flag'] = 2;
					// $this -> Keyword -> Duration -> create();
					// $this -> Keyword -> Duration -> save($durations);
				// }
				// sleep(1);
			// }
			
			// done keyword
			$time_end = microtime(true); 
			$execution_time = $time_end - $time_start;
			$this -> out($count .' ' . $keyword['Keyword']['ID'] . ' ' . $keyword['Keyword']['Keyword'] . ' ' . $keyword['Keyword']['Url'] .' ' .$rank .' ' .round($execution_time) .'s ' .date('H:i:s'));
		}
		
		//　load rank successfully
		$this -> out('---------------DONE------------------');
		$end_time = date('Ymd H:i:s');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out('-------------------------------------');
	}

}
?>