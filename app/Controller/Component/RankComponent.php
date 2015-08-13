<?php

App::uses('Component', 'Controller');
/*------------------------------------------------------------------------------------------------------------
 * DDNB Rank Component
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/

class RankComponent extends Component {

/*------------------------------------------------------------------------------------------------------------
 * remainUrl method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * remainDomain method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * keyWordRank method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/
        public function keyWordRank($engine, $url, $keyword, $strict = 0, $g_local=0, $speed = 0, $savecache = false, $onlytop10 = false) {
                $status = 0;
                // 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
                $rank = 0;
                $page_start = -1;

                if ($engine == 'google_jp' && $url == 'xn--365-3n4buep92s8h6e.com') {
                        //$url = mb_convert_encoding('ビル設備365.com', "sjis-win", "UTF-8");
                        $url = 'ビル設備365.com';
                } else if ($engine == 'google_jp' && $url == 'xn--t8j0a968wtij.com') {
                        $url = 'お墓探し.com';
                } else if ($engine == 'google_jp' && $url == 'xn--rms9i4ix79n.net') {
                        $url = '外壁塗装.net';
                } else if ($engine == 'google_jp' && $url == 'xn--jckte8ayb1f6082a2pr.net') {
                        $url = '屋根リフォーム.net';
                } else if ($engine == 'google_jp' && $url == 'xn--ncke2h5c6a5349avph.jp') {
                        $url = '仙台キャバクラ.jp';
                } else if ($engine == 'google_jp' && $url == 'xn--t8jye4be7a0279albcc26s.jp.net') {
                        $url = 'お金を借りる人へ.jp.net';
                } else if ($engine == 'google_jp' && $url == 'xn--nckgu1cyjxdw750al34a.co') {
                        $url = 'キャッシング即日.co';
                } else if ($engine == 'google_jp' && $url == 'xn--tckue253j.xn--lckua0b4a7mra6b4dcd.jp') {
                        $url = '口コミ.カードローンリサーチ.jp';
                }

                // Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
                $keystring = urlencode($this -> arrayToUtf8($keyword));

                // g code
                $g_lcode = Configure::read('G_LCODE');
                $engines['google_jp'] = array(
                        'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=20'.$g_lcode[$g_local],
                        'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_'.$g_lcode[$g_local],
                        'pattern' => '/<div class="s".*?<cite.*?([^<>].*?)<\/cite><div.*?nBb.*?>/'
                );

                $engines['yahoo_jp'] = array(
                        // 'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
                        'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2&n=10',
                        'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=10&fl=0&pstart=1&fr=top_v2&b=_START_',
                        'url2' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=40&fl=0&pstart=1&fr=top_v2&b=_START_',
                        'pattern' => '/<li><a href="([^<>]*)">/'
                );

                $engines['google_en'] = array('url0' => 'http://www.google.com/search?q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2', 'url1' => 'http://www.google.com/search?num=100&q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2&start=_START_', 'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
                $engines['yahoo_en'] = array('url0' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2', 'url1' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_', 'pattern' => '/<span class=url>([\S]*)<\/span>/');
                $engines['google_cn'] = array('url0' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=', 'url1' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=&num=100', 'pattern' => '/=r><a href="([^<>]*)" (target=_blank )?class=l>/');

                $start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;

                $page_start++;
                $pagemax = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 2 : 1;

                //only check rank within top10
                if ($onlytop10) {
                        $pagemax = 0;
                }

                for ($page = $page_start; $page <= $pagemax; $page++) {

                        $start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;

                        // 20150729 tracking yahoo jp
                        if($page == 1 && $engine == 'yahoo_jp') {
                                $start_base = 11;
                        }

                        if($page == 2 && $engine == 'yahoo_jp') {
                                $start_base = 21;
                                $start = $start_base;
                        }

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

                        preg_match_all($engines[$engine]['pattern'], $html, $matches);
                        if (isset($matches[1])) {

                                // 20150729 tracking yahoo jp
                                // pr($start);
                                // pr($matches[1]);

                                $matches[1] = array_map("Text2Domain", $matches[1]);
                                $rank_arr['pages'][$page] = $matches[1];
                                $rank_arr['pagecount'] = $page;

                                if($url == "luxia.jp") {
                                        $strict = 1;
                                }
                                $key = $this -> rootDomainSearch($url, $matches[1], $strict);
                                if ($key !== false) {
                                        $rank += (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;

                                        // 20150729 tracking yahoo jp
                                        if($page == 2 && $engine == 'yahoo_jp') {
                                                $rank = 11 + $key;
                                        }
                                        if($page == 2 && $engine == 'yahoo_jp') {
                                                $rank = 21 + $key;
                                        }
                                        break;
                                }
                        }
                        if ($page < $pagemax - 1) {
                                sleep(1);
                        } else {
                                if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
                                        $rank += 11;
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

                //save cache
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

                return $rank;
        }
        
/*------------------------------------------------------------------------------------------------------------
 * keyWordRankTest method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/
        public function keyWordRankTest($engine, $url, $keyword, $strict = 0, $g_local=0, $speed = 0, $savecache = false, $onlytop10 = false) {
               $status = 0;
                // 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
                $rank = 0;
                $page_start = -1;

                if ($engine == 'google_jp' && $url == 'xn--365-3n4buep92s8h6e.com') {
                        //$url = mb_convert_encoding('ビル設備365.com', "sjis-win", "UTF-8");
                        $url = 'ビル設備365.com';
                } else if ($engine == 'google_jp' && $url == 'xn--t8j0a968wtij.com') {
                        $url = 'お墓探し.com';
                } else if ($engine == 'google_jp' && $url == 'xn--rms9i4ix79n.net') {
                        $url = '外壁塗装.net';
                } else if ($engine == 'google_jp' && $url == 'xn--jckte8ayb1f6082a2pr.net') {
                        $url = '屋根リフォーム.net';
                } else if ($engine == 'google_jp' && $url == 'xn--ncke2h5c6a5349avph.jp') {
                        $url = '仙台キャバクラ.jp';
                } else if ($engine == 'google_jp' && $url == 'xn--t8jye4be7a0279albcc26s.jp.net') {
                        $url = 'お金を借りる人へ.jp.net';
                } else if ($engine == 'google_jp' && $url == 'xn--nckgu1cyjxdw750al34a.co') {
                        $url = 'キャッシング即日.co';
                } else if ($engine == 'google_jp' && $url == 'xn--tckue253j.xn--lckua0b4a7mra6b4dcd.jp') {
                        $url = '口コミ.カードローンリサーチ.jp';
                }

                // Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
                $keystring = urlencode($this -> arrayToUtf8($keyword));

                // g code
                $g_lcode = Configure::read('G_LCODE');
                $engines['google_jp'] = array(
                        'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=20'.$g_lcode[$g_local],
                        'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_'.$g_lcode[$g_local],
                        'pattern' => '/<div class="s".*?<cite.*?([^<>].*?)<\/cite><div.*?nBb.*?>/'
                );

                $engines['yahoo_jp'] = array(
                        // 'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
                        'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2&n=10',
                        'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=10&fl=0&pstart=1&fr=top_v2&b=_START_',
                        'url2' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=40&fl=0&pstart=1&fr=top_v2&b=_START_',
                        'pattern' => '/<li><a href="([^<>]*)">/'
                );

                $engines['google_en'] = array('url0' => 'http://www.google.com/search?q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2', 'url1' => 'http://www.google.com/search?num=100&q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2&start=_START_', 'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
                $engines['yahoo_en'] = array('url0' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2', 'url1' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_', 'pattern' => '/<span class=url>([\S]*)<\/span>/');
                $engines['google_cn'] = array('url0' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=', 'url1' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=&num=100', 'pattern' => '/=r><a href="([^<>]*)" (target=_blank )?class=l>/');

                $start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;

                $page_start++;
                $pagemax = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 2 : 1;

                //only check rank within top10
                if ($onlytop10) {
                        $pagemax = 0;
                }

                for ($page = $page_start; $page <= $pagemax; $page++) {

                        $start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;

                        // 20150729 tracking yahoo jp
                        if($page == 1 && $engine == 'yahoo_jp') {
                                $start_base = 11;
                                $start = $start_base;
                        }

                        if($page == 2 && $engine == 'yahoo_jp') {
                                $start_base = 21;
                                $start = $start_base;
                        }

                        $search_url = $engines[$engine]['url' . $page];
                        $search_url = str_replace('_QUERY_', $keystring, $search_url);
                        $search_url = str_replace('_START_', $start, $search_url);

                        $html = ($speed == 1) ? $this -> getWebContentSpeed($search_url) : $this -> getWebContent($search_url);
                        $html = str_replace('<strong>', "", $html);
                        $html = str_replace('</strong>', "", $html);
                        if ($page == 0) $html0 = $html;
                        $html = str_replace('<b>', "", $html);
                        $html = str_replace('</b>', "", $html);

                        if ($engine == "google_jp") {
                                $html = mb_convert_encoding($html, "UTF-8", "JIS, eucjp-win, sjis-win");
                        } else {
                                $html = mb_convert_encoding($html, 'UTF-8', "auto");
                        }

                        preg_match_all($engines[$engine]['pattern'], $html, $matches);
                        if (isset($matches[1])) {

                                // 20150729 tracking yahoo jp
                                // pr($start);
                                pr($matches[1]);

                                $matches[1] = array_map("Text2Domain", $matches[1]);
                                $rank_arr['pages'][$page] = $matches[1];
                                $rank_arr['pagecount'] = $page;

                                if($url == "luxia.jp") {
                                        $strict = 1;
                                }
                                $key = $this -> rootDomainSearch($url, $matches[1], $strict);
                                if ($key !== false) {
                                        $rank += (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;

                                        // 20150729 tracking yahoo jp
                                        if($page == 1 && $engine == 'yahoo_jp') {
                                                $rank = 11 + $key;
                                        }
                                        if($page == 2 && $engine == 'yahoo_jp') {
                                                $rank = 21 + $key;
                                        }
                                        break;
                                }
                        }
                        
                        if ($page < $pagemax - 1) {
                                sleep(1);
                        } else {
                                if ($rank > 0 && $rank <= 10) {// if top 100's rank <= 10, set it to 11
                                        $rank += 11;
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

                //save cache
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

                return $rank;
        }

/*------------------------------------------------------------------------------------------------------------
 * GoogleJP method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/
        public function GoogleJP($engine, $url, $keyword, $strict = 0, $g_local=0, $savecache = false, $onlytop10 = false) {
                $status = 0;
                // 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
                $rank = 0;
                $page_start = -1;

                if ($engine == 'google_jp' && $url == 'xn--365-3n4buep92s8h6e.com') {
                        //$url = mb_convert_encoding('ビル設備365.com', "sjis-win", "UTF-8");
                        $url = 'ビル設備365.com';
                } else if ($engine == 'google_jp' && $url == 'xn--t8j0a968wtij.com') {
                        $url = 'お墓探し.com';
                } else if ($engine == 'google_jp' && $url == 'xn--rms9i4ix79n.net') {
                        $url = '外壁塗装.net';
                } else if ($engine == 'google_jp' && $url == 'xn--jckte8ayb1f6082a2pr.net') {
                        $url = '屋根リフォーム.net';
                } else if ($engine == 'google_jp' && $url == 'xn--ncke2h5c6a5349avph.jp') {
                        $url = '仙台キャバクラ.jp';
                } else if ($engine == 'google_jp' && $url == 'xn--t8jye4be7a0279albcc26s.jp.net') {
                        $url = 'お金を借りる人へ.jp.net';
                } else if ($engine == 'google_jp' && $url == 'xn--nckgu1cyjxdw750al34a.co') {
                        $url = 'キャッシング即日.co';
                } else if ($engine == 'google_jp' && $url == 'xn--tckue253j.xn--lckua0b4a7mra6b4dcd.jp') {
                        $url = '口コミ.カードローンリサーチ.jp';
                }

                // Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
                $keystring = urlencode($this -> arrayToUtf8($keyword));

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
                if ($savecache == true) {
                        if (!empty($html0) && $rank > 0 && $rank <= 10) {
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
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/
        public function YahooJP($engine, $url, $keyword, $strict = 0, $g_local=0, $savecache = false, $onlytop10 = false) {
                $status = 0;
                // 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
                $rank = 0;
                $page_start = -1;

                // Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
                $keystring = urlencode($this -> arrayToUtf8($keyword));

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
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 -------------------------------------------------------------------------------------------------------------*/
        function saveSearchCache($rank, $keyword, $engine, $html0, $html) {
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

/*------------------------------------------------------------------------------------------------------------
 * getWebContent method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * getWebContentSpeed method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * rootDomainSearch method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * getEngineList method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
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
 * arrayToUtf8 method
 *
 * @input
 * @output
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2014
 -------------------------------------------------------------------------------------------------------------*/
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

function Text2Domain($string) {
        $string = ReplaceBold($string);
        return $string;
}

function ReplaceBold($string) {
        $string = str_replace('<b>', '', $string);
        $string = str_replace('</b>', '', $string);
        $string = str_replace('<wbr>', '', $string);
        return $string;
}
?>
