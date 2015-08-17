<?php
/*------------------------------------------------------------------------------------------------------------
 * Ddnb Common Component
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/

App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class DdnbCommonComponent extends Component {

 /*------------------------------------------------------------------------------------------------------------
 * get referer method
 *
 * @param: $referer = $_SERVER['HTTP_REFERER']
 * @output: referer for back button
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
        public function get_referer($referer) {
                $back = $referer;
                $here = FULL_BASE_URL . $this -> here;
                if ($referer == Null || $referer == $here) {
                        $back = '/' . $this -> params['controller'];
                }

                return $back;
        }

 /*------------------------------------------------------------------------------------------------------------
 * standardization keyword method
 *
 * @input: keyword,  string or array
 * @output: standadization keyword
 * @logic: hankaku space, uncapitalized
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
        public function standardization_keyword(&$keyword, $array=0) {
                if($array==1) {
                        foreach($keyword as $key => $value) {
                                $keyword[$key] = strip_tags(strtolower(trim(str_replace(' ', ' ', $value))));
                        }
                } else {
                        $keyword = strip_tags(strtolower(trim(str_replace('　', ' ', $keyword))));
                }

                return $keyword;
        }

 /*------------------------------------------------------------------------------------------------------------
 * get model name by controller method
 *
 * @input: controller plural name
 * @output: Model Name Capitalize
 * @logic: check plural & singular on Controller name define by default
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201408
 -------------------------------------------------------------------------------------------------------------*/
        public function model_by_controller($controller) {
                if(substr($controller,-3) == 'ies') {
                        $model = substr($controller, 0, -3).'y';
                } elseif(substr($controller,-2) == 'es') {
                        $model = substr($controller, 0, -2);
                } else {
                        $model = substr($controller, 0, -1);
                }

                return $model;
        }

 /*------------------------------------------------------------------------------------------------------------
 * convert db datetime to date
 *
 * @input db datetime format YYYY-mm-dd hh:mm:ss (created & updated)
 * @output YYYY-mm-dd
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        public function datetime_to_date($datetime) {

        }

 /*------------------------------------------------------------------------------------------------------------
 * encode convert method
 *
 * @input db datetime format YYYY-mm-dd hh:mm:ss (created & updated)
 * @output YYYY-mm-dd
 * @logic mb_convert_encoding "UTF-8", "EUC-JP, UTF-8, ASCII, JIS, eucjp-win, sjis-win"
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        public function encode_convert($string) {
                return mb_convert_encoding(trim($string), "UTF-8", "EUC-JP, UTF-8, ASCII, JIS, eucjp-win, sjis-win");
        }

 /*------------------------------------------------------------------------------------------------------------
 * random sleep method
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        function randomSleep($first, $second) {
                $rand = rand($first, $second);
                sleep($rand);

                return $rand;
        }

 /*------------------------------------------------------------------------------------------------------------
 * remain domain method
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
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
 * remain url method
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
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
 * array to utf8 method
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
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

 /*------------------------------------------------------------------------------------------------------------
 * root domain search method
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
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
 * Get web content curl API
 *
 * @input
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 -------------------------------------------------------------------------------------------------------------*/
        public function getWebContent($url) {
                sleep(rand(3,7));
                if(function_exists('curl_init')) {
                        $ch = curl_init();
                        $userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)";
                        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                } else {
                        $contents = file_get_contents($url);
                }

                return $contents;
        }

/*------------------------------------------------------------------------------------------------------------
 * Get web content mobile curl API
 *
 * @input
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 * $useragent = "DoCoMo/2.0 P705i(c100;TB;W30H19)";
 -------------------------------------------------------------------------------------------------------------*/
        public function getWebContentMobile($url, $userAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53") {
                sleep(rand(7, 15));
                // $userAgent = array();
                // $userAgent[0] = "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53";
                // $userAgent[1] = "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12F70 Safari/600.1.4";
                // $userAgent[2] = "Mozilla/5.0 (iPhone; CPU iPhone OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12B411";
                // $userAgent[3] = "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12F70";
                // $random = rand(0,3);

                if(function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                } else {
                        $contents = file_get_contents($url);
                }

                return $contents;
        }

/*------------------------------------------------------------------------------------------------------------
 * Get web content google mobile curl API
 *
 * @input
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 * $useragent = "DoCoMo/2.0 P705i(c100;TB;W30H19)";
 -------------------------------------------------------------------------------------------------------------*/
        public function getWebContentGoogleMobile($url, $userAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53") {
                sleep(rand(1, 3));

                if(function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                } else {
                        $contents = file_get_contents($url);
                }

                sleep(rand(1, 3));
                return $contents;
        }

/*------------------------------------------------------------------------------------------------------------
 * Get web content yahoo mobile curl API
 *
 * @input
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 * $useragent = "DoCoMo/2.0 P705i(c100;TB;W30H19)";
 -------------------------------------------------------------------------------------------------------------*/
        public function getWebContentYahooMobile($url, $userAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53") {
                sleep(rand(3, 5));

                if(function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                } else {
                        $contents = file_get_contents($url);
                }

                sleep(rand(1, 3));
                return $contents;
        }

/*------------------------------------------------------------------------------------------------------------
 * Get web content mobile pro curl API
 *
 * @input
 * @output      json rankmobile
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             2015
 * $useragent = "DoCoMo/2.0 P705i(c100;TB;W30H19)";
 -------------------------------------------------------------------------------------------------------------*/
        public function getWebContentMobilePro($url, $userAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53") {
                sleep(rand(1, 3));

                if(function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                } else {
                        $contents = file_get_contents($url);
                }

                sleep(rand(1, 3));
                return $contents;
        }

/*------------------------------------------------------------------------------------------------------------
 * check html no space method
 *
 * @input
 * @logic replace special character: no zenkaku space
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        public function check_html_no_space($html) {
                $html = str_replace(array("\r", "\r\n", "\n", "　", "\t"), '', $html);
                return $html;
        }

        public function Text2Domain($string) {
                $string = ReplaceBold($string);
                return $string;
        }

        public function ReplaceBold($string) {
                $string = str_replace('<b>', '', $string);
                $string = str_replace('</b>', '', $string);
                $string = str_replace('<wbr>', '', $string);
                return $string;
        }

/*------------------------------------------------------------------------------------------------------------
 * check html no space method
 *
 * @input
 * @logic replace special character: no zenkaku space
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        public function createToken($string) {
                // app_key = 885470538163558
                // app_secret = 0b9603452a1290dd56e8156dbdf563be

                return $string;
        }
        
/*------------------------------------------------------------------------------------------------------------
 * cron notice mail
 *
 * @input
 * @logic replace special character: no zenkaku space
 *
 * @author              lecaoquochung <lecaoquochung@gmail.com>
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 * @created             201407
 -------------------------------------------------------------------------------------------------------------*/
        public function cronMail($email) {
               
                // $Email = new CakeEmail();
                // $Email->from(array('server-admin@'.$_SERVER['HOSTNAME'] => 'MEDIAX ADMIN'));
                // $Email->from(array($_SERVER['HOSTNAME']));
                // $Email->to($email);
                // $Email->subject('Load Server Time');
                // $Email->send("Start time: ".$start_time."\n End time: ".$end_time);
                echo "Test";
                
                return True;
        }
        
}