<?php 
function formpostdata($post=array()) {
	$postdata = '';
	foreach ($post as $k => $v) $postdata .= "$k=$v&";

	// Remove the last '&'
	$postdata = substr($postdata, 0, -1);
	return $postdata;
}
function StrToCookies($cookies, $cookie=array(), $del=true, $dval=array('','deleted')) {
	if (!is_array($cookie)) $cookie = array();
	$cookies = trim($cookies);
	if (empty($cookies)) return $cookie;
	foreach (array_filter(array_map('trim', explode(';', $cookies))) as $v) {
		$v = array_map('trim', explode('=', $v, 2));
		$cookie[$v[0]] = $v[1];
		if ($del) {
			if (!is_array($dval)) $dval = array($dval);
			if (in_array($v[1], $dval)) unset($cookie[$v[0]]);
		}
	}
	return $cookie;
}
function CookiesToStr($cookie=array()) {
	if (empty($cookie)) return '';
	$cookies = '';
	foreach ($cookie as $k => $v) $cookies .= "$k=$v; ";

	// Remove the last '; '
	$cookies = substr($cookies, 0, -2);
	return $cookies;
}

function GetCookies($content) {
	if (($hpos = strpos($content, "\r\n\r\n")) > 0) $content = substr($content, 0, $hpos); // We need only the headers
	if (empty($content) || stripos($content, "\nSet-Cookie: ") === false) return '';
	// The U option will make sure that it matches the first character
	// So that it won't grab other information about cookie such as expire, domain and etc
	preg_match_all('/\nSet-Cookie: (.*)(;|\r\n)/Ui', $content, $temp);
	$cookie = $temp[1];
	$cookie = implode('; ', $cookie);
	return $cookie;
}

/**
 * Function to get cookies & converted into array
 * @param string The content you want to get the cookie from
 * @param array Array of cookies to be updated [optional]
 * @param bool Options to remove "deleted" or expired cookies (usually it named as 'deleted') [optional]
 * @param mixed The default name for temporary cookie, values are accepted in an array [optional]
 */
function GetCookiesArr($content, $cookie=array(), $del=true, $dval=array('','deleted')) {
	if (!is_array($cookie)) $cookie = array();
	if (($hpos = strpos($content, "\r\n\r\n")) > 0) $content = substr($content, 0, $hpos); // We need only the headers
	if (empty($content) || stripos($content, "\nSet-Cookie: ") === false || !preg_match_all ('/\nSet-Cookie: ([^\r\n]+)/i', $content, $temp)) return $cookie;
	foreach ($temp[1] as $v) {
		if (strpos($v, ';') !== false) list($v, $p) = explode(';', $v, 2);
		else $p = false;
		$v = explode('=', $v, 2);
		$cookie[$v[0]] = $v[1];
		if ($del) {
			if (!is_array($dval)) $dval = array($dval);
			if (in_array($v[1], $dval)) unset($cookie[$v[0]]);
			elseif (!empty($p)) {
				if (stripos($p, 'Max-Age=') !== false && preg_match('/[ \;]?Max-Age=(-?\d+)/i', $p, $P) && (int)$P[1] < 1) unset($cookie[$v[0]]);
				elseif (stripos($p, 'expires=') !== false && preg_match('/[ \;]?expires=([a-zA-Z]{3}, \d{1,2} [a-zA-Z]{3} \d{4} \d{1,2}:\d{1,2}:\d{1,2} GMT)/i', $p, $P) && ($P = strtotime($P[1])) !== false && $P <= time()) unset($cookie[$v[0]]);
			}
		}
	}
	return $cookie;
}
function cache_set($key, $val) {
	if(!is_dir('cookie')){mkdir('cookie',0755);}
   $val = var_export($val, true);
   // HHVM fails at __set_state, so just use object cast for now
   $val = str_replace('stdClass::__set_state', '(object)', $val);
   // Write to temp file first to ensure atomicity
   $tmp = "cookie/$key." . uniqid('', true) . '.tmp';
   file_put_contents($tmp, '<?php $val = ' . $val . ';', LOCK_EX);
   rename($tmp, "cookie/$key");
}
function cache_get($key) {
    @include "cookie/$key";
    return isset($val) ? $val : false;
}
function gettoken($data){
	$d=explode("\n",$data);
foreach($d as $h){
$ha=explode(':',$h);

if(strtolower($ha['0'])=='tkn'){
	
	return $ha['1'];
}else{
	
}
}
return false;}

function getcache($url, $dir,$rename,$format='html',$cookie=0)
{
if(!is_dir($dir)) {mkdir($dir, 0755);}
$rename=md5($rename);
$file=$dir.'/'.$rename.'.'.$format;

$cachetime=(60*60 * 10); // 10mints


if (file_exists($file) && time() - $cachetime < filemtime($file)){
	
$rawdata=file_get_contents($file);
	return $rawdata;
        
}else{
		
	$ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36');

curl_setopt($ch, CURLOPT_HEADER,         true);
    $rawdata=curl_exec ($ch);
    curl_close ($ch);

$fp = fopen("$file",'w');
fwrite($fp, $rawdata); 
fclose($fp);     
return $rawdata;
}}
