<?php
/*------------------------------------------------------------------------------------------------------------
 * Sales Keywords
 * param01: date
 *
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 * run: sales_keywords [param01]
 *-----------------------------------------------------------------------------------------------------------*/	

App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');
App::uses('DdnbCommonComponent', 'Controller/Component');
App::uses('HComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');

class SalesKeywordsShell extends Shell {

	public $uses = array('Keyword', 'Rankhistory', 'SalesKeyword', 'Extra', 'User');

	public function main() {
		//load component
		$component = new ComponentCollection();
		App::import('Component', 'Rank');
		$this -> Rank = new RankComponent($component);
		
		// date
		$date = date('Ymd');
		if(isset($this->args[0])) {
			$date = $this->args[0];
		} 
		
		// {
		// 	$this->out('Not a valid date');
		// 	exit;
		// }
		
		$start_time = date('Ymd H:i:s');
		$this -> out($start_time);
		
		// recursive
		$this -> Keyword -> recursive = 0;
		
		// filter keyword
		set_time_limit(0);
		$conds = array();
		$conds['Rankhistory.rankDate'] = $date;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;
		$conds['Keyword.service'] = 0;
		$conds['Keyword.sales'] = 1;
		$conds['OR'] = array(
			 array('Keyword.rankend' => 0),
			 array('Keyword.rankend >=' => $date)
		);
		
		$order = array();
		$order['Keyword.ID'] = 'ASC';
		
		$this -> Rankhistory -> recursive = 1;
		
		$fields = array(
			// 'Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 
			// 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url', 'Keyword.Strict', 'Keyword.limit_price', 'Keyword.limit_price_group', 'Keyword.cost', 'Keyword.price',
		);
		
		$contain = array(
			'Keyword' => array(
				'fields' => array('ID', 'UserID', 'Keyword', 'Engine', 'rankend', 'Enabled', 'nocontract', 'Penalty', 'Url', 'Strict', 'limit_price', 'limit_price_group', 'cost', 'price'),
				'User' => array(
					'fields' => array('id', 'company', 'name', 'limit_price_multi', 'limit_price_multi2', 'limit_price_multi3')
				)
			)
		);
		
		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'contain' => $contain, 'order' => $order));
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
			
			// check limit
			$limit = 0; 
			if($rankhistory['Keyword']['limit_price'] != 0) {
				// sum from 1 to today
				$conds = array();
				$conds['SalesKeyword.keyword_id'] = $rankhistory['Rankhistory']['KeyID']; // 482
				$conds['SalesKeyword.date BETWEEN ? AND ?'] = array( date('Y-m').'-01', date('Y-m-d', strtotime($date)));
				$fields = array();
				$fields = array('SalesKeyword.id', 'SalesKeyword.keyword_id', 'SalesKeyword.user_id', 'SalesKeyword.keyword', 'SalesKeyword.rank', 'SalesKeyword.sales', 'SalesKeyword.cost', 'SalesKeyword.profit', 'SalesKeyword.date');
				
				$sales_keywords = $this-> SalesKeyword -> find('all', array('conditions' => $conds, 'fields' => $fields));
				$sum_sales_keyword = array();
				foreach($sales_keywords as $sales_keyword) {
					@$sum_sales_keyword['sales'] += $sales_keyword['SalesKeyword']['sales']; 
					@$sum_sales_keyword['cost'] += $sales_keyword['SalesKeyword']['cost']; 
					@$sum_sales_keyword['profit'] += $sales_keyword['SalesKeyword']['profit']; 
				}

				if(@$sum_sales_keyword['sales'] >= $rankhistory['Keyword']['limit_price']) {
					$limit = 1;
				}
			} 
			
			// check limit group: check on group 1 only
			if($rankhistory['Keyword']['limit_price'] != 0) {
				$conds = array();
				$conds['SalesKeyword.keyword_id'] = $rankhistory['Rankhistory']['KeyID'];
				$conds['SalesKeyword.user_id'] = $rankhistory['Keyword']['UserID'];
				$conds['SalesKeyword.date BETWEEN ? AND ?'] = array( date('Y-m').'-01', date('Y-m-d', strtotime($date)));
				$fields = array();
				$fields = array('SalesKeyword.id', 'SalesKeyword.keyword_id', 'SalesKeyword.user_id', 'SalesKeyword.keyword', 'SalesKeyword.rank', 'SalesKeyword.sales', 'SalesKeyword.cost', 'SalesKeyword.profit', 'SalesKeyword.date');
				
				$sales_keywords = $this-> SalesKeyword -> find('all', array('conditions' => $conds, 'fields' => $fields));
				$sum_sales_keyword = array();
				foreach($sales_keywords as $sales_keyword) {
					@$sum_sales_keyword['sales'] += $sales_keyword['SalesKeyword']['sales']; 
					@$sum_sales_keyword['cost'] += $sales_keyword['SalesKeyword']['cost']; 
					@$sum_sales_keyword['profit'] += $sales_keyword['SalesKeyword']['profit']; 
				}

				if(@$sum_sales_keyword['sales'] >= $rankhistory['Keyword']['User']['limit_price_multi']) {
					$limit = 1;
				}
			}
			
			// sales & profit
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
				if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
					$data_extra[$key_extra] = $value_extra;
				}
			}
			
			if($limit == 0) {
				if(count($data_extra) > 0){
					ksort($data_extra);
					$key_extra = array_keys($data_extra);
					// sales
					$sales =  $data_extra[$key_extra[0]];
					$total_sales[$rankhistory['Keyword']['ID']] = $sales;
					// cost
					$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
					// profit
					$profit = $data_extra[$key_extra[0]] - $rankhistory['Keyword']['cost'];
					$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
				}else{
					foreach($extra as $key => $value) {
						if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
							// sales
							$sales = isset($value) ? $value : 0;
							$total_sales[$rankhistory['Keyword']['ID']] = $sales;
							// cost
							$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
							// profit
							$profit = isset($value) ? $value - $rankhistory['Keyword']['cost'] : 0;
							$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
						}
					} 
				}
			}
				
			
			if(($google_rank <= 10 && $google_rank != 0) || ($yahoo_rank <= 10 && $yahoo_rank != 0)){
				// data
				$data = array();
				$data['SalesKeyword']['keyword_id'] = $rankhistory['Keyword']['ID'];
				$data['SalesKeyword']['user_id'] = $rankhistory['Keyword']['UserID'];
				$data['SalesKeyword']['keyword'] = $rankhistory['Keyword']['Keyword'];
				$data['SalesKeyword']['rank'] = $rankhistory['Rankhistory']['Rank'];
				$data['SalesKeyword']['sales'] = (@$total_sales[$rankhistory['Keyword']['ID']] !== Null) ? @$total_sales[$rankhistory['Keyword']['ID']] : 0  ;
				$data['SalesKeyword']['cost'] = (@$total_cost[$rankhistory['Keyword']['ID']] !== Null) ? @$total_cost[$rankhistory['Keyword']['ID']] : 0;
				$data['SalesKeyword']['profit'] = (@$total_profit[$rankhistory['Keyword']['ID'] .@$rankhistory['Keyword']['Keyword'] .@$rankhistory['Rankhistory']['Rank']] !== Null) ? @$total_profit[$rankhistory['Keyword']['ID'] .@$rankhistory['Keyword']['Keyword'] .@$rankhistory['Rankhistory']['Rank']] : 0;
				$data['SalesKeyword']['limit'] = $limit; // deprecated
				$data['SalesKeyword']['date'] = $date;
				
				// save
				$conds_data = array();
				$conds_data['SalesKeyword.keyword_id'] = $rankhistory['Keyword']['ID'];
				$conds_data['SalesKeyword.date'] = $date;
				$check_data = $this->SalesKeyword->find('first',array('conditions'=> $conds_data));
				
				if($check_data != False){
					$data['SalesKeyword']['id'] = $check_data['SalesKeyword']['id'];
				}else{
					$this -> SalesKeyword -> create();
				}				
				$this -> SalesKeyword -> save($data);	
				
				sleep(1);
				
				//done keyword
				$time_end = microtime(true); 
				$execution_time = $time_end - $time_start;
				
				if ($limit == 0) {
					$count++;
					// rank-in
					$keywords_is_ranked [$data['SalesKeyword']['keyword_id']] = $rankhistory['Keyword']['Keyword'];
					$this -> out($count .' ' .date('H:i:s') .' ' . $rankhistory['Keyword']['ID'] .' ' .$rankhistory['Rankhistory']['Rank'] . ' ' . $rankhistory['Keyword']['Keyword'] . ' ' .$date . ' ' .$data['SalesKeyword']['sales'] . ' ' .$data['SalesKeyword']['cost'] . ' ' .$data['SalesKeyword']['profit'] .' ' .$execution_time .'s');
				}
			}
		}
		
		@$sum_sales = money_format('%.2n',array_sum(@$total_sales));
		@$sum_cost = money_format('%.2n',array_sum(@$total_cost));
		@$sum_profit = money_format('%.2n',array_sum(@$total_profit));
		@$rankup_percentage = $count / count($rankhistories) * 100;
		
		$this -> out('-------------------------------------');
		$this -> out('Total');
		$this -> out('Sales: ' .$sum_sales);
		$this -> out('Cost: ' .$sum_cost);
		$this -> out('Profit: ' .$sum_profit);
		$this -> out('Percentage: ' .$rankup_percentage);
		
		// runtime ok
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
