<?php

App::uses('Component', 'Controller');

/*------------------------------------------------------------------------------------------------------------
 * Rank Component
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
class RankComponent extends Component {
	
	public $components = array('DdnbCommon');

/*------------------------------------------------------------------------------------------------------------
 * remainUrl
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function remainUrl($string) {
		$string = trim($string);
		$string = str_replace(' ', '', $string);
		if (substr($string, 0, 4) == "http") {
			$pos = strpos($string, "//") + 2;
			$string = substr($string, $pos);
		}
		if (substr($string, -1) == "/") {
			$string = substr($string, 0, -1);
		}
		return $string;
	}
	
/*------------------------------------------------------------------------------------------------------------
 * validate date function
 *
 * @input
 * @logic
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201508
 -------------------------------------------------------------------------------------------------------------*/      
        public function remainUrl1($string)
        {
			// $d = DateTime::createFromFormat($format, $date);
			// return $d && $d->format($format) == $date;
			$string = trim($string);
			$string = str_replace(' ', '', $string);
			if (substr($string, 0, 4) == "http") {
				$pos = strpos($string, "//") + 2;
				$string = substr($string, $pos);
			}
			if (substr($string, -1) == "/") {
				$string = substr($string, 0, -1);
			}
			return $string;
        }

/*------------------------------------------------------------------------------------------------------------
 * remainDomain
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function remainDomain($string) {
		$string = trim($string);
		$string = str_replace(' ', '', $string);
		if (substr($string, 0, 4) == "http") {
			$pos = strpos($string, "//") + 2;
			$string = substr($string, $pos);
		}
		if (($pos = strpos($string, "/")) > 0) {
			$string = substr($string, 0, $pos);
		}

		if (substr($string, 0, 4) == "www.") {
			$string = substr($string, 4);
		}
		return $string;
	}

/*------------------------------------------------------------------------------------------------------------
 * keyWordRank
 * param01: Engine
 * param02: Url
 * param03: Keyword
 * param04: Strict
 * param05: Google Local
 * param06: Speed
 * param: Savecache
 * param: onlytop10
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function keyWordRank($engine, $url, $keyword, $strict = 0, $g_local=0, $speed = 0, $savecache = false, $onlytop10 = false) {
		$status = 0;
		// 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
		$rank = 0;
		$page_start = -1;

		if ($engine == 'google_jp' && $url == 'xn--365-3n4buep92s8h6e.com') {
			$url = mb_convert_encoding('ビル設備365.com', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--t8j0a968wtij.com') {
			$url = mb_convert_encoding('お墓探し.com', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--rms9i4ix79n.net') {
			$url = mb_convert_encoding('外壁塗装.net', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--jckte8ayb1f6082a2pr.net') {
			$url = mb_convert_encoding('屋根リフォーム.net', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--ncke2h5c6a5349avph.jp') {
			$url = mb_convert_encoding('仙台キャバクラ.jp', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--t8jye4be7a0279albcc26s.jp.net') {
			$url = mb_convert_encoding('お金を借りる人へ.jp.net', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--nckgu1cyjxdw750al34a.co') {
			$url = mb_convert_encoding('キャッシング即日.co', "sjis-win", "UTF-8");
		} else if ($engine == 'google_jp' && $url == 'xn--tckue253j.xn--lckua0b4a7mra6b4dcd.jp') {
			$url = mb_convert_encoding('口コミ.カードローンリサーチ.jp', "sjis-win", "UTF-8");
		}

		// Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
		$keystring = urlencode($this -> arrayToUtf8($keyword));
		
		// g code
		$g_lcode = Configure::read('G_LCODE');
		$engines['google_jp'] = array(
			'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=20' .$g_lcode[$g_local], 
			'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_' .$g_lcode[$g_local], 
			'pattern' => '/<div class="s".*?<cite.*?>([^<>].*?)<\/cite><div.*?nBb.*?>/'
		);

		$engines['yahoo_jp'] = array('url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2', 'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_', 'pattern' => '/<li><a href="([^<>]*)">/');
		$engines['google_en'] = array('url0' => 'http://www.google.com/search?q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2', 'url1' => 'http://www.google.com/search?num=100&q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2&start=_START_', 'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
		$engines['yahoo_en'] = array('url0' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2', 'url1' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_', 'pattern' => '/<span class=url>([\S]*)<\/span>/');
		$engines['google_cn'] = array('url0' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=', 'url1' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=&num=100', 'pattern' => '/=r><a href="([^<>]*)" (target=_blank )?class=l>/');

		$start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;
		$page_start++;
		$pagemax = 1;
		
		// only check rank within top10
		if ($onlytop10) {
			$pagemax = 0;
		}
		
//		print_r($engines);
//		 exit;
		
		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			$html = ($speed == 1) ? $this -> getWebContentSpeed($search_url) : $this -> getWebContent($search_url);
			$html = str_replace('<strong>', "", $html);
			$html = str_replace('</strong>', "", $html);
			if ($page == 0)
				$html0 = $html;
			$html = str_replace('<b>', "", $html);
			$html = str_replace('</b>', "", $html);
			
			if ($engine == "google_jp") {
				$html = mb_convert_encoding($html, "UTF-8", "JIS, eucjp-win, sjis-win");
			} else {
				$html = mb_convert_encoding($html, 'UTF-8', "auto");
			} 
			
			$html = str_replace(array("\r", "\r\n", "\n", " ", "　", "\t"), '',$html);		
//			exit;
		
			preg_match_all($engines[$engine]['pattern'], $html, $matches);
			
			if (isset($matches[1])) {
				
//				 pr($matches[1]); 
//				 pr($url);
//				 exit;

				$matches[1] = array_map("Text2Domain", $matches[1]);
				$rank_arr['pages'][$page] = $matches[1];
				$rank_arr['pagecount'] = $page;
				
				if($url == "luxia.jp") {
					$strict = 1;
				}
				$key = $this -> rootDomainSearch($url, $matches[1], $strict);
				if ($key !== false) {
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

		$rank_arr['update'] = time();
		$rank_str = serialize($rank_arr);
		$this -> Rankkeyword = ClassRegistry::init('Rankkeyword');
		if ($status == 0) {
			$rankkeyword['Rankkeyword']['Keyword'] = $keyword;
			$rankkeyword['Rankkeyword'][$engine] = $rank_str;
		} else {
			$rankkeyword['Rankkeyword']['ID'] = $keyid;
			$rankkeyword['Rankkeyword'][$engine] = $rank_str;
			$this -> Rankkeyword -> create();
		}
		$this -> Rankkeyword -> save($rankkeyword);

		//save cahce
		if (!empty($html0) && $rank > 0 && $rank <= 10) {
			$savecache = true;
		}

		if ($savecache == true) {
			$date = date('Ymd');
			if ($rank > 10) {
				$html0 = $html;
			}
			$cachepath = ROOT . "/../rankcache_new/" . $date;
			if (!file_exists($cachepath)) {
				mkdir($cachepath, 0777);
			}
			$filename = $cachepath . "/" . md5(mb_convert_encoding($keyword . "_" . $engine, 'EUC-JP')) . ".html";

			if ($handle = fopen($filename, 'w')) {

				if ($engine == "google_jp") {
					$html0 = mb_convert_encoding($html0, "UTF-8", "JIS, eucjp-win, sjis-win");
				} else {
					$html0 = mb_convert_encoding($html0, 'UTF-8', "auto");
				}

				fwrite($handle, $html0);
				fclose($handle);
			}
		}
		
//		 pr($url);
//		 pr($strict);
//		 pr($this->remainUrl($url));
//		 pr($this->remainDomain($url));
//		 pr($rank);
		return $rank;
	}

/*------------------------------------------------------------------------------------------------------------
 * GoogleJP method
 *
 * @input
 * @output
 *
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2014
 -------------------------------------------------------------------------------------------------------------*/
	public function GoogleJP($engine, $url, $keyword, $strict = 0, $g_local=0, $savecache = false, $onlytop10 = false) {
		$status = 0;
		// 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
		$rank = 0;
		$page_start = -1;
		
		// Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
		$keystring = urlencode($this -> arrayToUtf8($keyword));
		
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		// g code
		$g_lcode = Configure::read('G_LCODE');
		$engines['google_jp'] = array(
			'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=20'.$g_lcode[$g_local], 
			'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_'.$g_lcode[$g_local], 
			'pattern' => '/<div class="s".*?<cite.*?([^<>].*?)<\/cite><div.*?nBb.*?>/'
		);

		$start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;
		$page_start++;
		$pagemax = 1;
		//only check rank within top10
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			$html = $this -> getWebContent($search_url);
			$html = str_replace('<strong>', "", $html);
			$html = str_replace('</strong>', "", $html);
			if ($page == 0)
				$html0 = $html;
			$html = str_replace('<b>', "", $html);
			$html = str_replace('</b>', "", $html);
			
			if ($engine == "google_jp") {
				$html = mb_convert_encoding($html, "UTF-8", "JIS, eucjp-win, sjis-win");
			} else {
				$html = mb_convert_encoding($html, 'UTF-8', "auto");
			}
			
			preg_match_all($engines[$engine]['pattern'], $html, $matches);
			if (isset($matches[1])) {
				$matches[1] = array_map("Text2Domain", $matches[1]);
				$rank_arr['pages'][$page] = $matches[1];
				$rank_arr['pagecount'] = $page;
				
				if($url == "luxia.jp") {
					$strict = 1;
				}
				$key = $this -> rootDomainSearch($url, $matches[1], $strict);
				if ($key !== false) {
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

		//save cahce
		if ($savecache == true) {
			if (!empty($html0) && $rank > 0 && $rank <= 10) {
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
		
		$g_lcode = Configure::read('Search.locale');
		$userAgent = Configure::read('Useragent.pc');
		$random = rand(0,count($userAgent)-1);
		$random1 = rand(0,count($userAgent)-1);
		
		$engines['google_jp'] = array(
			// 'url0' => 'http://www.google.co.jp/m?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2',
			'url0' => 'https://www.google.co.jp/?gfe_rd=cr&#q=_QUERY_',
			'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_'.$g_lcode[$local], 
			'useragent0' => $userAgent[$random],
			'useragent1' => $userAgent[$random1],
			// 'pattern' => '/<h3 class="r".*?href=".*?([^<>].*?)"/'
			'pattern' => '/<div class="s".*?<cite.*?([^<>].*?)<\/cite><div.*?nBb.*?>/'
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
			$html = $this ->DdnbCommon -> getWebContent($search_url, $engines[$engine]['useragent' . $page]);
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
 * YahooJP method
 *
 * @input
 * @output
 *
 * @author		lecaoquochung <lecaoquochung@gmail.com>
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created		2014
 -------------------------------------------------------------------------------------------------------------*/
	public function YahooJP($engine, $url, $keyword, $strict = 0, $local=0, $savecache = false, $onlytop10 = false) {
		$status = 0;
		// 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
		$rank = 0;
		$page_start = -1;

		// Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
		$keystring = urlencode($this -> arrayToUtf8($keyword));
		
		if($strict == 1) {
			$url = $this->DdnbCommon->remainUrl($url);
		} else {
			$url = $this->DdnbCommon->remainDomain($url);
		}
		
		$engines['yahoo_jp'] = array(
			'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2&n=20', 
			'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_', 
			'pattern' => '/<li><a href="([^<>]*)">/'
		);
		
		$start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;

		$page_start++;
		$pagemax = 1;
		
		//only check rank within top10
		if ($onlytop10) {
			$pagemax = 0;
		}

		for ($page = $page_start; $page <= $pagemax; $page++) {
			$start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
			$search_url = $engines[$engine]['url' . $page];
			$search_url = str_replace('_QUERY_', $keystring, $search_url);
			$search_url = str_replace('_START_', $start, $search_url);
			
			$html = $this -> getWebContent($search_url);
			$html = str_replace('<strong>', "", $html);
			$html = str_replace('</strong>', "", $html);
			if ($page == 0)
				$html0 = $html;
			$html = str_replace('<b>', "", $html);
			$html = str_replace('</b>', "", $html);
			
			if ($engine == "google_jp") {
				$html = mb_convert_encoding($html, "UTF-8", "JIS, eucjp-win, sjis-win");
			} else {
				$html = mb_convert_encoding($html, 'UTF-8', "auto");
			}
			
			preg_match_all($engines[$engine]['pattern'], $html, $matches);
			if (isset($matches[1])) {
				$matches[1] = array_map("Text2Domain", $matches[1]);
				$rank_arr['pages'][$page] = $matches[1];
				$rank_arr['pagecount'] = $page;
				
				if($url == "luxia.jp") {
					$strict = 1;
				}
				$key = $this -> rootDomainSearch($url, $matches[1], $strict);
				if ($key !== false) {
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

		//save cahce
		if ($savecache == true) {
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
		if ($rank > 10) {
			$html0 = $html;
		}
		$cachepath = ROOT . "/../rankcache/pc" . $date;
		if (!file_exists($cachepath)) {
			mkdir($cachepath, 0777);
		}
		$filename = $cachepath . "/" . md5(mb_convert_encoding($keyword . "_" . $engine, 'EUC-JP')) . ".html";

		if ($handle = fopen($filename, 'w')) {

			if ($engine == "google_jp") {
				$html0 = mb_convert_encoding($html0, "UTF-8", "JIS, eucjp-win, sjis-win");
			} else {
				$html0 = mb_convert_encoding($html0, 'UTF-8', "auto");
			}

			fwrite($handle, $html0);
			fclose($handle);
		}
	}

/*------------------------------------------------------------------------------------------------------------
 * getWebContent
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function getWebContent($url) {
		sleep(rand(3,5));
		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 300);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//
			$contents = curl_exec($ch);
			curl_close($ch);
		} else {
			$contents = file_get_contents($url);
		}
		$contents = str_replace('/url?', 'http://' . $this -> remainDomain($url) . '/url?', $contents);
		return $contents;
	}
	
/*------------------------------------------------------------------------------------------------------------
 * getWebContent Speed
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function getWebContentSpeed($url) {
		sleep(rand(0,1));
		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 300);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//
			$contents = curl_exec($ch);
			curl_close($ch);
		} else {
			$contents = file_get_contents($url);
		}
		$contents = str_replace('/url?', 'http://' . $this -> remainDomain($url) . '/url?', $contents);
		return $contents;
	}	

/*------------------------------------------------------------------------------------------------------------
 * rootDomainSearch
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function rootDomainSearch($url, $domainArr, $strict) {
		foreach ($domainArr as $key => $domain) {
			$domain = $this -> remainUrl($domain);
			$pos = strpos($domain, $url);
			
				if($strict == 1) {
					if ($pos !== false && $pos === 0) {
						return $key;
					}
				} else {
					if ($pos !== false) {
						return $key;
					}
				}
		}
		return false;
	}

/*------------------------------------------------------------------------------------------------------------
 * getEngineList
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	public function getEngineList() {
		$this -> Engine = ClassRegistry::init('Engine');
		$engines = Cache::read('enginelist', 'Engine');
		if (!$engines) {
			$engines = $this -> Engine -> find('all');
			Cache::write('enginelist', 'Engine');
		}

		foreach ($engines as $engine) {
			$enginelist[$engine['Engine']['Code']] = array('Name' => $engine['Engine']['Name'], 'ShowName' => $engine['Engine']['ShowName']);
		}
		return $enginelist;
	}

/*------------------------------------------------------------------------------------------------------------
 * arrayToUtf8
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
	/**
	 * if array is not UTF-8 then convert keys and values to UTF-8
	 * method is recursive
	 *
	 * @param mixed $in
	 */
	public function arrayToUtf8($in) {
		if (is_array($in)) {
			foreach ($in as $key => $value) {
				$out[$this -> arrayToUtf8($key)] = $this -> arrayToUtf8($value);
			}
		} elseif (is_string($in)) {
			if (mb_detect_encoding($in) != "UTF-8")
				return utf8_encode($in);
			else
				return $in;
		} else {
			return $in;
		}
		return $out;
	}


}

/*------------------------------------------------------------------------------------------------------------
 * Text2Domain
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
function Text2Domain($string) {
	$string = ReplaceBold($string);
	return $string;
}

/*------------------------------------------------------------------------------------------------------------
 * ReplaceBold
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
function ReplaceBold($string) {
	$string = str_replace('<b>', '', $string);
	$string = str_replace('</b>', '', $string);
	$string = str_replace('<wbr>', '', $string);
	return $string;
}
?>