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
			 array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd'))))
		);
		
		$this -> Rankhistory -> recursive = 0;
		
		$fields = array(
			'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group', 'Keyword.cost', 'Keyword.price');

		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields));
		
		$this -> Extra -> recursive = -1;
		$keyword_ids = Hash::extract($rankhistories, '{n}.Keyword.ID');
		$extras = $this -> Extra -> find('all', array('fields' => array('Extra.ExtraType', 'Extra.Price', 'Extra.KeyID'), 'conditions' => array('Extra.KeyID' => $keyword_ids)));
		
		$total_cost = array();
		$total_sales = array();
		$total_profit = array();
		
		$count = 0;
		foreach ($rankhistories as $rankhistory) {
			$time_start = microtime(true);
			
			$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
			$rank = min($ranks);
			
			
			$data_extra = array();
			$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$rankhistory['Keyword']['ID'].']');						
			$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
			foreach($extra as $key_extra => $value_extra) {
				if(($rank <= $key_extra && $rank != 0)){
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
					if(($rank <= $key && $rank != 0)){
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
			
			if(($rank <= $key && $rank != 0)){
				$count++;
				// data
				$data['SalesKeyword']['keyword_id'] = $rankhistory['Keyword']['ID'];
				$data['SalesKeyword']['keyword'] = $rankhistory['Keyword']['Keyword'];
				$data['SalesKeyword']['rank'] = $rankhistory['Rankhistory']['Rank'];
				$data['SalesKeyword']['sales'] = @$total_sales[$rankhistory['Keyword']['ID']]  ;
				$data['SalesKeyword']['cost'] = @$total_cost[$rankhistory['Keyword']['ID']];
				$data['SalesKeyword']['profit'] = @$total_profit[$rankhistory['Keyword']['ID'] .@$rankhistory['Keyword']['Keyword'] .@$rankhistory['Rankhistory']['Rank']];
				// $data['SalesKeyword']['limit'];
				$data['SalesKeyword']['date'] = date('Ymd');
				
				//done keyword
				$time_end = microtime(true); 
				$execution_time = $time_end - $time_start;
				$this -> out($count .' ' .date('H:i:s') .' ' . $rankhistory['Keyword']['ID'] .' ' .$rankhistory['Rankhistory']['Rank'] . ' ' . $rankhistory['Keyword']['Keyword'] . ' ' .$data['SalesKeyword']['sales'] . ' ' .$data['SalesKeyword']['cost'] . ' ' .$data['SalesKeyword']['profit'] .' ' .$execution_time .'s');
			}
			
		}
		
		// load rank successfully
		$this -> out('---------------DONE------------------');
		$end_time = date('Ymd H:i:s');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out('-------------------------------------');
		
	}

}
?>
