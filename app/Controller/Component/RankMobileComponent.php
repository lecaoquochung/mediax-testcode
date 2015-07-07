<?php

App::uses('Component', 'Controller');

class RankMobileComponent extends Component {

	public $components = array('DdnbCommon');

/*------------------------------------------------------------------------------------------------------------
 * regrex html mobile
 *
 * @input	serp html
 * @output	html no header
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
 	public function RegrexHtml($html) {
 		$pattern = '/HTTP\/1.1([^<>].*?)<head>/';
		$html = $this->DdnbCommon->check_html_no_space($html);
		preg_match_all($pattern, $html, $matches);
		$html = str_replace($matches[0], '', $html);
		
		return $html;
	}
	
/*------------------------------------------------------------------------------------------------------------
 * GoogleJP
 *
 * @input	
 * @output	json rankmobile
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
	public function GoogleJP($engine, $url, $keyword, $strict = 0, $local=0, $savecache = False, $onlytop10 = False) {
		$status = 0; // save cache new rank-in (0: new)
		$rank = 0; // init rank
		$page_start = -1; // page start
		
		$keystring = urlencode($this -> DdnbCommon -> arrayToUtf8($keyword));
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		$g_lcode = Configure::read('G_LCODE');
		$userAgent = Configure::read('Useragent.mobile');
		$random = rand(0,count($userAgent)-1);
		$random1 = rand(0,count($userAgent)-1);
		
		$engines['google_jp'] = array(
			// 'url0' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2',
			'url0' => 'https://www.google.co.jp/?gfe_rd=cr&#q=_QUERY_',
			// 'url1' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&num=100&start=_START_',
			'url1' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&num=100&start=_START_',
			'useragent0' => $userAgent[$random],
			'useragent1' => $userAgent[$random1],
			'pattern' => '/<h3 class="r".*?href=".*?([^<>].*?)"/'
		);
		
		$start_base = 0;
		
		$page_start++;
		$pagemax = 1;
		
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			// $html = $this ->DdnbCommon -> getWebContentMobile($search_url);
			$html = $this ->DdnbCommon -> getWebContentGoogleMobile($search_url, $engines[$engine]['useragent' . $page]);
			if ($page == 0) {
				 $html0 = $html;
			}
			
			preg_match_all($engines[$engine]['pattern'], $html, $matches);
			if (isset($matches[1])) {
				$matches[1] = str_replace("&amp;", "&", $matches[1]);
				$key = $this -> DdnbCommon -> rootDomainSearch($url, $matches[1], $strict);
				
				if ($key !== False) {
					$rank = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;
					break;
				}
			}
			
			if ($page < $pagemax - 1) {
				sleep(1);
			} else {
				if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
					$rank = 11;
				}
			}
		}
		
		// rank-in 
		// $rank_arr['update'] = time();
		// $rank_str = serialize($rank_arr);
		// $this -> Rankkeyword = ClassRegistry::init('Rankkeyword');
		// if ($status == 0) {
			// $rankkeyword['Rankkeyword']['Keyword'] = $keyword;
			// $rankkeyword['Rankkeyword'][$engine] = $rank_str;
		// } else {
			// $rankkeyword['Rankkeyword']['ID'] = $keyid;
			// $rankkeyword['Rankkeyword'][$engine] = $rank_str;
			// $this -> Rankkeyword -> create();
		// }
		// $this -> Rankkeyword -> save($rankkeyword);
		
		// save cache
		if ($savecache == True) {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		} else {
			if (!empty($html0) && $rank >= 0 && $rank <= 100) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		}
		
		return $rank;
	}

/*------------------------------------------------------------------------------------------------------------
 * GoogleJPPro
 *
 * @input	
 * @output	json rankmobile
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
	public function GoogleJPPro($engine, $url, $keyword, $strict = 0, $local=0, $savecache = False, $onlytop10 = False) {
		$status = 0; // save cache new rank-in (0: new)
		$rank = 0; // init rank
		$page_start = -1; // page start
		
		$keystring = urlencode($this -> DdnbCommon -> arrayToUtf8($keyword));
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		$g_lcode = Configure::read('G_LCODE');
		$userAgent = Configure::read('Useragent.mobile');
		$random = rand(0,count($userAgent)-1);
		$random1 = rand(0,count($userAgent)-1);
		
		$engines['google_jp'] = array(
			// 'url0' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2',
			'url0' => 'https://www.google.co.jp/?gfe_rd=cr&#q=_QUERY_',
			'url1' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&num=100&start=_START_',
			'useragent0' => $userAgent[$random],
			'useragent1' => $userAgent[$random1],
			'pattern' => '/<h3 class="r".*?href=".*?([^<>].*?)"/'
		);
		
		$start_base = 0;
		$page_start++;
		$pagemax = 1;
		
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			// $html = $this ->DdnbCommon -> getWebContentMobile($search_url);
			$html = $this ->DdnbCommon -> getWebContentMobilePro($search_url, $engines[$engine]['useragent' . $page]);
			if ($page == 0) {
				 $html0 = $html;
			}
			
			preg_match_all($engines[$engine]['pattern'], $html, $matches);
			if (isset($matches[1])) {
				$matches[1] = str_replace("&amp;", "&", $matches[1]);
				$key = $this -> DdnbCommon -> rootDomainSearch($url, $matches[1], $strict);
				if ($key !== False) {
					$rank = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;
					break;
				}
			}
			
			if ($page < $pagemax - 1) {
				sleep(1);
			} else {
				if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
					$rank = 11;
				}
			}
		}
		
		// rank-in 
		
		// save cache
		if ($savecache == True) {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		} else {
			if (!empty($html0) && $rank >= 0 && $rank <= 100) {
				$html0 = $html;
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		}
		
		return $rank;
	}

/*------------------------------------------------------------------------------------------------------------
 * YahooJP
 *
 * @input	
 * @output	json rankmobile
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
	public function YahooJP($engine, $url, $keyword, $strict = 0, $local=0 , $savecache = False, $onlytop10 = False) {
		$status = 0; // save cache new rank-in (0: new)
		$rank = 0; // init rank
		$page_start = -1; // page start
		
		$keystring = urlencode($this -> DdnbCommon -> arrayToUtf8($keyword));
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		$userAgent = Configure::read('Useragent.mobile');
		$random = rand(0,count($userAgent)-1);
		
		//
		$engines['yahoo_jp'] = array(
			'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
			// 'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_',
			'url1' => 'http://search.yahoo.co.jp/search?ei=UTF-8&p=_QUERY_&aq=-1&pstart=1&fr=applep2&b=_START_&n=100',
			'useragent0' => $userAgent[$random],
			'useragent1' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36 ',
			'pattern0' => '/<div class="cmm u01 next-cmm.*?href=([^<>]*).*?onmousedown/',
			'pattern1' => '/<div class="hd".*?href="([^<>]*)" onmousedown/' ///<li><a href="([^<>]*)">/
		);
		
		// mobile
		// $engines['yahoo_jp'] = array(
			// 'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
			// 'url1' => 'http://search.yahoo.co.jp/search?ei=UTF-8&p=_QUERY_&aq=-1&pstart=1&fr=applep2&b=_START_&n=20',
			// 'useragent0' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53',
			// 'useragent1' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53',
			// 'pattern0' => '/<div class="cmm u01 next-cmm.*?href=([^<>]*).*?onmousedown/',
			// 'pattern1' => '/<div class="cmm u01 next-cmm.*?href=([^<>]*).*?onmousedown/',
		// );
		
		$start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;
		
		$page_start++;
		$pagemax = 1;
		
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			$html = $this ->DdnbCommon -> getWebContentYahooMobile($search_url, $engines[$engine]['useragent' . $page]);
			if ($page == 0) {
				 $html0 = $html;
			}
			
			preg_match_all($engines[$engine]['pattern' . $page], $html, $matches);
			if (isset($matches[1])) {
				$key = $this -> DdnbCommon -> rootDomainSearch($url, $matches[1], $strict);
				
				if ($key !== False) {
					$rank = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;
					break;
				}
			}
			
			if ($page < $pagemax - 1) {
				sleep(1);
			} else {
				if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
					$rank = 11;
				}
			}
		}
		
		// rank-in 
		// $rank_arr['update'] = time();
		// $rank_str = serialize($rank_arr);
		// $this -> Rankkeyword = ClassRegistry::init('Rankkeyword');
		// if ($status == 0) {
			// $rankkeyword['Rankkeyword']['Keyword'] = $keyword;
			// $rankkeyword['Rankkeyword'][$engine] = $rank_str;
		// } else {
			// $rankkeyword['Rankkeyword']['ID'] = $keyid;
			// $rankkeyword['Rankkeyword'][$engine] = $rank_str;
			// $this -> Rankkeyword -> create();
		// }
		// $this -> Rankkeyword -> save($rankkeyword);
		
		// save cache
		if ($savecache == True) {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		} else {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		}
		
		return $rank;
	}

/*------------------------------------------------------------------------------------------------------------
 * YahooJPPro
 *
 * @input	
 * @output	json rankmobile
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
	public function YahooJPPro($engine, $url, $keyword, $strict = 0, $local=0 , $savecache = False, $onlytop10 = False) {
		$status = 0; // save cache new rank-in (0: new)
		$rank = 0; // init rank
		$page_start = -1; // page start
		
		$keystring = urlencode($this -> DdnbCommon -> arrayToUtf8($keyword));
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		$userAgent = Configure::read('Useragent.mobile');
		$random = rand(0,count($userAgent)-1);
		
		//
		$engines['yahoo_jp'] = array(
			'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
			// 'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_',
			'url1' => 'http://search.yahoo.co.jp/search?ei=UTF-8&p=_QUERY_&aq=-1&pstart=1&fr=applep2&b=_START_&n=100',
			'useragent0' => $userAgent[$random],
			'useragent1' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36 ',
			'pattern0' => '/<div class="cmm u01 next-cmm.*?href=([^<>]*).*?onmousedown/',
			'pattern1' => '/<div class="hd".*?href="([^<>]*)" onmousedown/' ///<li><a href="([^<>]*)">/
		);
		
		// mobile
		
		$start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;
		
		$page_start++;
		$pagemax = 1;
		
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			$html = $this ->DdnbCommon -> getWebContentMobilePro($search_url, $engines[$engine]['useragent' . $page]);
			if ($page == 0) {
				 $html0 = $html;
			}
			
			preg_match_all($engines[$engine]['pattern' . $page], $html, $matches);
			if (isset($matches[1])) {
				$matches[1] = str_replace("&amp;", "&", $matches[1]);
				$key = $this -> DdnbCommon -> rootDomainSearch($url, $matches[1], $strict);
				
				if ($key !== False) {
					$rank = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;
					break;
				}
			}
			
			if ($page < $pagemax - 1) {
				sleep(1);
			} else {
				if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
					$rank = 11;
				}
			}
		}
		
		// rank-in 
		
		// save cache
		if ($savecache == True) {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		} else {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
				$this->saveSearchCache($rank, $keyword, $engine, $html0, $html);
			}
		}
		
		return $rank;
	}

/*------------------------------------------------------------------------------------------------------------
 * saveSearchCache
 *
 * @input	
 * @output	json rankmobile
 * 
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2015
 -------------------------------------------------------------------------------------------------------------*/
	function saveSearchCache($rank, $keyword, $engine, $html0, $html) {
		$date = date('Ymd');
		if ($rank > 10 || $rank == 0) {
			$html0 = $html;
		}
		$cachepath = ROOT . "/../rankcache_new/rankmobile/" . $date;
		if (!file_exists($cachepath)) {
			mkdir($cachepath, 0777);
		}
		$filename = $cachepath . "/" . md5(mb_convert_encoding($keyword . "_" . $engine, 'EUC-JP')) . ".html";
		if ($handle = fopen($filename, 'w')) {
			$html0 = $this->RegrexHtml($html0);
			fwrite($handle, $html0);
			fclose($handle);
		}
	}

} // end class RankMobileComponent

?>