<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');

class DeleteRankhistoryShell extends Shell {

	public $uses = array('Rankhistory');

	public function main() {
		$start_time = date('Ymd h:i:s');
		
		$this -> Rankhistory -> recursive = -1;
		$limit = $this->args[0];
		
		$count_rank = $this -> Rankhistory -> find('list', array(
			'fields' => array('Rankhistory.ID', 'Rankhistory.ID'),
			'conditions' => array('DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d") <' => date('Y-m-01', strtotime('-2 months'))), 
			'limit' => $limit
		));
		
		$count_rank_all = $this -> Rankhistory -> find('count', array(
			'fields' => array('Rankhistory.ID', 'Rankhistory.ID'),
			'conditions' => array('DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d") <' => date('Y-m-01', strtotime('-2 months'))), 
		));
		
		$count = 0;
		$status = 0;
		while (count($count_rank) > 0) {
			$count++;
			$status = $limit*$count;
			$status_percent = ($status/$count_rank_all)*100;
			
			if ($this -> Rankhistory -> deleteAll(array('Rankhistory.ID' => $count_rank))) {
				$this -> out('STATUS:' .$status .' index deleted ' .round($status_percent,2) .'% -----------------');
				$count_rank = $this -> Rankhistory -> find('list', array(
					'fields' => array('Rankhistory.ID', 'Rankhistory.ID'), 
					'conditions' => array('DATE_FORMAT(Rankhistory.RankDate,"%Y-%m-%d") <' => date('Y-m-01', strtotime('-2 months'))), 
					'limit' => $limit
				));
			}
		}
		
		$end_time = date('Ymd h:i:s');
		
		// end
		$this -> out('---------------DONE------------------');
		$this -> out('Start time:	' .$start_time);
		$this -> out('End time:	' .$end_time);
		$this -> out($status .' Rankhistory index deleted');
		$this -> out('-------------------------------------');
	}
}
?>