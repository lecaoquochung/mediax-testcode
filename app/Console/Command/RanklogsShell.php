<?php

/* ------------------------------------------------------------------------------------------------------------
 * Ranklogs Shell
 * 
 * param01(0): offset (start: 0)
 * param02(1): limit (default: 100)
 * param03(2): interval time (default: 15)
 * param04(3): c_logic (boolean: check company) -> deprecated
 * param05(4): random time between 2 query 01 (default: 10)
 * param06(5): random time between 2 query 02 (default: 30)
 * param07(6): interval keyword (default: 40 -> g, 10 -> y)
 * param08(7): nocontract (default: 0 or NULL -> contract)

 * @author lecaoquochung@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created
 * run: ranklogs 0 100 15 0 1 30 10 0
 * ----------------------------------------------------------------------------------------------------------- */

App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent', 'Controller/Component');
App::uses('RankMobileComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');

class RanklogsShell extends Shell {

    public $uses = array('Keyword', 'Ranklog', 'Server');

    public function main() {
        @$offset = $this->args[0];
        @$limit = $this->args[1];
        @$interval_time = $this->args[2] * 60;
        $c_logic = 0;
        if (@$this->args[3] == 1) {
            $c_logic = 1;
        }

        $rand01 = 1;
        if (isset($this->args[4])) {
            $rand01 = $this->args[4];
        }

        $rand02 = 30;
        if (isset($this->args[5])) {
            $rand02 = $this->args[5];
        }

        $interval_keyword = 50;
        if (isset($this->args[6])) {
            $interval_keyword = $this->args[6];
        }

        $nocontract = 0;
        if (isset($this->args[7])) {
            $nocontract = $this->args[7];
        }

        $start_time = date('Ymd H:i:s');
        $this->out($start_time);

        //load component
        $component = new ComponentCollection();
        App::import('Component', 'Rank');
        $this->Ranks = new RankComponent($component);
        $component1 = new ComponentCollection();
        App::import('Component', 'RankMobile');
        $this->RankMobile = new RankMobileComponent($component1);

        //get server id
        $server_ip = gethostbyname(exec('hostname'));

        $this->out('---------------------------------');
        $this->out('IP SERVER: '.$server_ip);
        $this->out('---------------------------------');
        $server = $this->Server->findByIp($server_ip);

        if ($server != false) {
            // recursive
            $this->Keyword->recursive = -1;

            // filter keyword
            $conds = array();
            $conds['Keyword.Enabled'] = 1;
            $conds['Keyword.nocontract'] = $nocontract;
            $conds['Keyword.c_logic'] = $c_logic;
            $conds['OR'] = array(
                array('Keyword.rankend' => 0),
                array('Keyword.rankend >=' => date('Ymd', strtotime('-1 month' . date('Ymd')))),
            );
            $conds['Keyword.server_id'] = $server['Server']['id'];

            $keywords = $this->Keyword->find('all', array('conditions' => $conds, 'limit' => $limit, 'offset' => $offset));

            if (count($keywords) > 0) {
                $count = 0;
                foreach ($keywords as $keyword) {
                    $time_start = microtime(true);
                    $count++;
                    if (($count % $interval_keyword) == 0) {
                        $sleep = $interval_time;
                        $this->out('---------------' . $start_time . ' ' . date('Ymd H:i:s') . ' ' . $sleep . 's ------------------');
                        sleep($sleep);
                    } else {
                        sleep(rand($rand01, $rand02));
                    }
                    if ($keyword != false) {
                        if ($keyword['Keyword']['Strict'] == 1) {
                            $domain = $this->Ranks->remainUrl($keyword['Keyword']['Url']);
                        } else {
                            $domain = $this->Ranks->remainDomain($keyword['Keyword']['Url']);
                        }
                    }

                    $engine = $keyword['Keyword']['Engine'];
                    $rank = array();
                    if ($engine == 3) {
                        $rank['google_jp'] = $this->Ranks->keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
                        $rank['yahoo_jp'] = $this->Ranks->keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
                    } elseif ($engine == 1) {
                        $rank['google_jp'] = $this->Ranks->keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
                    } elseif ($engine == 2) {
                        $rank['yahoo_jp'] = $this->Ranks->keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
                    } else {//end
                        $engine_list = $this->Ranks->getEngineList();
                        $rank[$engine_list[$engine]['Name']] = $this->Ranks->keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword'], $keyword['Keyword']['Strict'], $keyword['Keyword']['g_local']);
                    }

                    //delete Rank current date
                    $this->Ranklog->deleteAll(array('Ranklog.keyword_id' => $keyword['Keyword']['ID'], 'Ranklog.rankdate' => date('Y-m-d')));

                    //Insert Rank current date
                    $ranks['Ranklog']['keyword_id'] = $keyword['Keyword']['ID'];
                    $ranks['Ranklog']['engine_id'] = $engine;
                    $ranks['Ranklog']['keyword'] = $keyword['Keyword']['Keyword'];
                    $ranks['Ranklog']['url'] = $domain;
                    $ranks['Ranklog']['rank'] = json_encode($rank);
                    $ranks['Ranklog']['rankdate'] = date('Y-m-d');

                    $this->Ranklog->create();
                    $this->Ranklog->save($ranks);
                    
                    //done keyword
                    $time_end = microtime(true);
                    $execution_time = $time_end - $time_start;
                    $this->out($count . ' ' . date('H:i:s') . ' ' . $keyword['Keyword']['ID'] . ' ' . json_encode($rank) . ' ' . $keyword['Keyword']['Keyword'] . ' ' . $keyword['Keyword']['Url'] . ' ' . $execution_time . 's');
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
        $Email->subject('Rank Keyword');
        $Email->send("Start time: " . $start_time . "\n End time: " . $end_time);
    }

}

?>
