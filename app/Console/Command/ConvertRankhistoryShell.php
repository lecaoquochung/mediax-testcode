<?php

/* ------------------------------------------------------------------------------------------------------------
 * ConvertRankhistory Shell
 * 
 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 * run: convert_rankhistory start_date end_date
 * ----------------------------------------------------------------------------------------------------------- */

App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');

class ConvertRankhistoryShell extends Shell {

    public $uses = array('Keyword', 'Ranklog', 'Rankhistory');
	
	private function convert($size)
	{
	    $unit=array('b','kb','mb','gb','tb','pb');
	    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

    public function main() {
    	
		// check argument
		@$start_date = $this->args[0];
		@$end_date = $this->args[1];
		if($start_date == NULL || $end_date == NULL) {
			$this->out('---------------Error: Input------------------');
			
			exit;
		}
		
        $start_time = date('Ymd H:i:s');
		$memory = memory_get_usage();
        $this->out($start_time);
		

        //load component
        $component = new ComponentCollection();
        App::import('Component', 'Rank');
        $this->Ranks = new RankComponent($component);
        $component1 = new ComponentCollection();
        App::import('Component', 'RankMobile');
        $this->RankMobile = new RankMobileComponent($component1);

        // recursive
        $this->Rankhistory->recursive = 0;
		
		// conditions
		$rank_data = array();
        @$limit = array();
		@$offset = array();
        $conds = array();
		$conds['Rankhistory.RankDate BETWEEN ? AND ?'] = array($start_date, $end_date);
		$conds['Keyword.ID <>'] = NULL;
		
        $rankhistories = $this->Rankhistory->find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset, 'order' => 'Rankhistory.RankDate ASC'));
		
        if (count($rankhistories) > 0) {
            $count = 0;
            foreach ($rankhistories as $rankhistory) {
                $time_start = microtime(true);
				$count++;
				 
                //delete Rank current date
				$this->Ranklog->deleteAll(array('Ranklog.keyword_id' => $rankhistory['Keyword']['ID'], 'Ranklog.rankdate' => date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']))));

                //Insert Rank current date
                $ranks['Ranklog']['keyword_id'] = $rankhistory['Rankhistory']['KeyID'];
                $ranks['Ranklog']['engine_id'] = $rankhistory['Keyword']['Engine'];
                $ranks['Ranklog']['keyword'] = $rankhistory['Keyword']['Keyword'];
                $ranks['Ranklog']['url'] = $rankhistory['Keyword']['Url'];
				
				if($rankhistory['Keyword']['Engine'] == 3) {
					$explode = explode('/', $rankhistory['Rankhistory']['Rank']);
					$rank_data['google'] = $explode[0];
					$rank_data['yahoo'] = $explode[1];
					
				} else if ($rankhistory['Keyword']['Engine'] == 2) {
					$rank_data['yahoo'] = $rankhistory['Rankhistory']['Rank'];
				} else if ($rankhistory['Keyword']['Engine'] == 1) {
					$rank_data['google'] = $rankhistory['Rankhistory']['Rank'];
				}
				
                $ranks['Ranklog']['rank'] = json_encode($rank_data);
				$ranks['Ranklog']['params'] = $rankhistory['Rankhistory']['params'];
                $ranks['Ranklog']['rankdate'] =  date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']));
				
                $this->Ranklog->create();
				if($this -> Ranklog -> save($ranks)) {
					//done keyword
					$time_end = microtime(true); 
					$execution_time = $time_end - $time_start;
					$this->out($count .' ' .$rankhistory['Rankhistory']['RankDate'] .' ' .$rankhistory['Rankhistory']['ID'] .' ' .$rankhistory['Keyword']['Keyword'] .' ' .$ranks['Ranklog']['rank'] .' ' .$execution_time . 's');
					
				} else {
					$this -> out("Db error");
				}
            }
        }

        // load rank successfully
		$this->out('---------------DONE------------------');
        $end_time = date('Ymd H:i:s');
        $this->out('Start time:	' . $start_time);
        $this->out('End time:	' . $end_time);
        $this->out('-------------------------------------');

        $Email = new CakeEmail();
        $Email->from(array('server-admin@' . gethostbyname(exec('hostname')) => 'MEDIAX ADMIN'));
        $Email->to('lecaoquochung@gmail.com');
        $Email->subject('Convert Data');
        $Email->send("Start time: " . $start_time . "\n End time: " . $end_time);
    }

}

?>
