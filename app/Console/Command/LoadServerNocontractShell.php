<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');

class LoadServerNocontractShell extends Shell {

	public $uses = array('Keyword', 'Rankhistory');

	public function main() {
		$offset = $this->args[0];
		$limit =  $this->args[1];

		$start_time = date('Ymd h:i:s');
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
		$conds['Keyword.nocontract'] = 1;
		$conds['OR'] = array( 
			array('Keyword.rankend' => 0), 
			array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
		);

		$keywords = $this -> Keyword -> find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset));
		
		$count = 0;
		foreach ($keywords as $keyword) {
			$time_start = microtime(true);
			$count++;
			if(($count%50)==0) {
				$sleep = 1800;
				$this -> out('---------------' .$start_time .' ' .date('Ymd h:i:s') .' ' .$sleep .'s ------------------');
				sleep($sleep);
			} else {
				sleep(rand(3,5));
			}
			if ($keyword != false) {
				if ($keyword['Keyword']['Strict'] == 1) {
					$domain = $this -> Rank -> remainUrl($keyword['Keyword']['Url']);
				} else {
					$domain = $this -> Rank -> remainDomain($keyword['Keyword']['Url']);
				}
			}

			$engine = $keyword['Keyword']['Engine'];
			if ($engine == 3) {
				$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']) . '/' . $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} elseif ($engine == 1) {
				$rank = $this -> Rank -> keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} elseif ($engine == 2) {
				$rank = $this -> Rank -> keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} elseif ($engine == 6) {
				$rank = $this -> Rank -> keyWordRank('google_en', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']) . '/' . $this -> Rank -> keyWordRank('yahoo_en', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} elseif ($engine == 7) {//mobile search engine
				$rank = $this -> RankMobile -> keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} elseif ($engine == 8) {
				$rank = $this -> RankMobile -> keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
			} else {//end
				$engine_list = $this -> Rank -> getEngineList();
				$rank = $this -> Rank -> keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict']);
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
			$this -> out($count .' ' . $keyword['Keyword']['ID'] . ' ' . $keyword['Keyword']['Keyword'] . ' ' . $keyword['Keyword']['Url'] .' ' .$rank .' ' .$execution_time .'s');
		}
		
		//　load rank successfully
		$this -> out('---------------DONE------------------');
		$end_time = date('Ymd h:i:s');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out('-------------------------------------');
	}

}
?>