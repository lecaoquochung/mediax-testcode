<?php
/*------------------------------------------------------------------------------------------------------------
 * Sales Keywords
 * param01: 
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 * run: sales
 *-----------------------------------------------------------------------------------------------------------*/	

App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');
App::uses('DdnbCommonComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');

class SalesKeywordsShell extends Shell {

	public $uses = array('Keyword', 'Rankhistory', 'SalesKeyword', 'Extra');

	public function main() {
		// offset
		// @$offset = $this->args[0];
		
		$start_time = date('Ymd H:i:s');
		$this -> out($start_time);
		
		//load component
		$component = new ComponentCollection();
		App::import('Component', 'Rank');
		$this -> Rank = new RankComponent($component);
		
		$component1 = new ComponentCollection();
		App::import('Component', 'RankMobile');
		$this -> RankMobile = new RankMobileComponent($component1);
		
		$ddnbcommon_component = new ComponentCollection();
		App::import('Component', 'DdnbCommon');
		$this -> DdnbCommon = new DdnbCommonComponent($ddnbcommon_component);
		
		// recursive
		$this -> Keyword -> recursive = 0;
		
		// filter keyword
		set_time_limit(0);
		$rankDate = date('Ymd');
		$conds = array();
		$conds['Rankhistory.rankDate'] = date('Ymd');
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = 1;
		$conds['OR'] = array(
			 array('Keyword.rankend' => 0), 
			 array('Keyword.rankend >=' => date('Ymd'))
		);
		
		$order = array();
		$order['Keyword.ID'] = 'ASC';
		
		$this -> Rankhistory -> recursive = 0;
		
		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group', 'Keyword.cost', 'Keyword.price');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => $order));
		$this->out(count($rankhistories));
		
		$this -> Extra -> recursive = -1;
		$keyword_ids = Hash::extract($rankhistories, '{n}.Keyword.ID');
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_ids)));
		
		$total_cost = array();
		$total_sales = array();
		$total_profit = array();
		$keywords_is_ranked = array();
		
		$count = 0;
		foreach ($rankhistories as $rankhistory) {
			$time_start = microtime(true);
			
			if ($rankhistory['Keyword']['Engine'] == 1) {
				$google_rank = $rankhistory['Rankhistory']['Rank'];
				$yahoo_rank = 0;
			} elseif ($rankhistory['Keyword']['Engine'] == 2) {
				$google_rank = 0;
				$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
			} else {
				$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
				$google_rank = $ranks[0];
				@$yahoo_rank = $ranks[1];
			}
			
			$rank = min($ranks);
			
			$data_extra = array();
			$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$rankhistory['Keyword']['ID'].']');						
			$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
			foreach($extra as $key_extra => $value_extra) {
				// if(($rank <= $key_extra && $rank != 0)){
				if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
					$data_extra[$key_extra] = $value_extra;
				}
			}
			
			// sales & profit
			if(count($data_extra)>0){
				ksort($data_extra);
				$key_extra = array_keys($data_extra);
				// cost
				$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
				// sales
				$sales =  $data_extra[$key_extra[0]];
				$total_sales[$rankhistory['Keyword']['ID']] = $sales;
				// profile
				$profit = $data_extra[$key_extra[0]] - $rankhistory['Keyword']['cost'];
				$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
			}else{
				foreach($extra as $key => $value) {
					if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
						// cost
						$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
						// sales
						$sales = isset($value) ? $value : 0;
						$total_sales[$rankhistory['Keyword']['ID']] = $sales;
						// profit
						$profit = isset($value) ? $value - $rankhistory['Keyword']['cost'] : 0;
						$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
					}
				} 
			}
			
			if(($google_rank <= 10 && $google_rank != 0) || ($yahoo_rank <= 10 && $yahoo_rank != 0)){
				$count++;
				// data
				$data = array();
				$data['SalesKeyword']['keyword_id'] = $rankhistory['Keyword']['ID'];
				$data['SalesKeyword']['keyword'] = $rankhistory['Keyword']['Keyword'];
				$data['SalesKeyword']['rank'] = $rankhistory['Rankhistory']['Rank'];
				$data['SalesKeyword']['sales'] = (@$total_sales[$rankhistory['Keyword']['ID']] !== Null) ? @$total_sales[$rankhistory['Keyword']['ID']] : 0  ;
				$data['SalesKeyword']['cost'] = (@$total_cost[$rankhistory['Keyword']['ID']] !== Null) ? @$total_cost[$rankhistory['Keyword']['ID']] : 0;
				$data['SalesKeyword']['profit'] = (@$total_profit[$rankhistory['Keyword']['ID'] .@$rankhistory['Keyword']['Keyword'] .@$rankhistory['Rankhistory']['Rank']] !== Null) ? @$total_profit[$rankhistory['Keyword']['ID'] .@$rankhistory['Keyword']['Keyword'] .@$rankhistory['Rankhistory']['Rank']] : 0;
				// $data['SalesKeyword']['limit']; // deprecated
				$data['SalesKeyword']['date'] = date('Ymd');
				
				// save
				$conds_data = array();
				$conds_data['SalesKeyword.keyword_id'] = $rankhistory['Keyword']['ID'];
				$conds_data['SalesKeyword.date'] = date('Y-m-d');
				$check_data = $this->SalesKeyword->find('first',array('conditions'=> $conds_data));
				
				if($check_data != False){
					$data['SalesKeyword']['id'] = $check_data['SalesKeyword']['id'];
				}else{
					$this -> SalesKeyword -> create();
				}				
				$this -> SalesKeyword -> save($data);	
				
				sleep(1);
				
				// rank-in
				$keywords_is_ranked [$data['SalesKeyword']['keyword_id']] = $rankhistory['Keyword']['Keyword'];
				
				//done keyword
				$time_end = microtime(true); 
				$execution_time = $time_end - $time_start;
				$this -> out($count .' ' .date('H:i:s') .' ' . $rankhistory['Keyword']['ID'] .' ' .$rankhistory['Rankhistory']['Rank'] . ' ' . $rankhistory['Keyword']['Keyword'] . ' ' .$data['SalesKeyword']['sales'] . ' ' .$data['SalesKeyword']['cost'] . ' ' .$data['SalesKeyword']['profit'] .' ' .$execution_time .'s');
			}
		}
		
		@$sum_cost = money_format('%.2n',array_sum(@$total_cost));
		@$sum_sales = money_format('%.2n',array_sum(@$total_sales));
		@$sum_profit = money_format('%.2n',array_sum(@$total_profit));
		@$rankup_percentage = (count(@$total_profit)) / count($rankhistories) * 100;
		
		$this -> out('-------------------------------------');
		$this -> out('Total');
		$this -> out('Sales: ' .$sum_sales);
		$this -> out('Cost: ' .$sum_cost);
		$this -> out('Profit: ' .$sum_profit);
		$this -> out('Percentage: ' .$rankup_percentage);
		
		// load rank successfully
		$this -> out('---------------DONE------------------');
		$end_time = date('Ymd H:i:s');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out('-------------------------------------');
		
		foreach($keywords_is_ranked as $key => $value):
			$this -> out($value);	
		endforeach; 
		
	}

}
?>
