<?php 

function samfiletype($name){
	$sam=pathinfo($name);
	$filetype=strtolower($sam['extension']);
	return $filetype;
}
$values = array();
function samget( $key )
    {
	global $values;
        return $values[ $key ];
    }

  function samset( $key, $value )
    { global $values;
        $values[ $key ] = $value;
    }
	function samsize($fileSize, $digits = 2){

        $sizes = array("TB", "GB", "MB", "KB", "B");
        $total = count($sizes);
        while ($total-- && $fileSize > 1024) {
            $fileSize /= 1024;
        }
        return round($fileSize, $digits) . " " . $sizes[$total];

}

function clean($q){
	$qid=array('%20','_','!',"'",'#','@','%','^','&','*','|');
	$sam=pathinfo(str_replace($qid,' ',$q));

	return $sam['filename'];

}
function cclean($q){

	$q = htmlentities(htmlspecialchars($q));
	$qid=array('-','%20','%72','_','!',"'",'"','#','@','%','^','&','*','|',"nbsp;","amp;");
	$sam=str_replace($qid,' ',$q);
	return $sam;

}
function textcut($string,$start='0',$end='160'){
	$string=substr($string,$start,$end);
	return $string;
}

$bot= (strpos(strtolower($ua), 'bot') !== false);
$curl= (strpos(strtolower($ua), 'curl') !== false);
$wget= (strpos(strtolower($ua), 'wget') !== false);

   
   if($curl == true)
    {
       //echo 'Your IP Blocked by site owner.';
	   include '404.php';
   exit; 
   die;}
if($wget == true)
    {
       //echo 'Your IP Blocked by site owner.';
	   include '404.php';
   exit; 
   die;}


function mobile(){
global $ua;
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$ua)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($ua,0,4))){return true;}else{return false;}
}
function badbot(){
 $botArrayName = array (
            'msnbot'=>'/msnbot/',
'slurp'=>'/inktomi/',
'askjeeves'=>'/askjeeves/',
'fastcrawler'=>'/fastcrawler/',
'infoseek'=>'/infoseek/',
'lycos'=>'/lycos/',
'yandex'=>'/yandexbot/',
'geohasher'=>'/geohasher/',
'gigablast'=>'/gigabot/',
'baidu'=>'/baiduspider/',
'spinn3r'=>'/spinn3r/',
'blackwidow'=>'/blackwidow/',
'chinaclaw'=>'/chinaclaw/',
'custo'=>'/custo/',
'disco'=>'/disco/',
'download demon'=>'/download demon/',
'ecatch'=>'/ecatch/',
'eirgrabber'=>'/eirgrabber/',
'emailsiphon'=>'/emailsiphon/',
'emailwolf'=>'/emailwolf/',
'webpictures'=>'/express webpictures/',
'extractorpro'=>'/extractorpro/',
'eyenetie'=>'/eyenetie/',
'flashget'=>'/flashget/',
'getright'=>'/getright/',
'getweb'=>'/getweb!/',
'zilla'=>'/go!zilla/',
'go-ahead-got-it'=>'/go-ahead-got-it/',
'grabnet'=>'/grabnet/',
'grafula'=>'/grafula/',
'hmview'=>'/hmview/',
'httrack'=>'/httrack/',
'image stripper'=>'/image stripper/',
'image sucker'=>'/image sucker/',
'indy library'=>'/indy library/',
'interget'=>'/interget/',
'internet ninja'=>'/internet ninja/',
'jetcar'=>'/jetcar/',
'joc web spider'=>'/joc web spider/',
'larbin'=>'/larbin/',
'leechftp'=>'/leechftp/',
'mass downloader'=>'/mass downloader/',
'midown tool'=>'/midown tool/',
'mister pix'=>'/mister pix/',
'navroad'=>'/navroad/',
'nearsite'=>'/nearsite/',
'netants'=>'/netants/',
'netspider'=>'/netspider/',
'net vampire'=>'/net vampire/',
'netzip'=>'/netzip/',
'octopus'=>'/octopus/',
'offline explorer'=>'/offline explorer/',
'offline navigator'=>'/offline navigator/',
'pagegrabber'=>'/pagegrabber/',
'papa foto'=>'/papa foto/',
'pavuk'=>'/pavuk/',
'pcbrowser'=>'/pcbrowser/',
'realdownload'=>'/realdownload/',
'reget'=>'/reget/',
'sitesnagger'=>'/sitesnagger/',
'smartdownload'=>'/smartdownload/',
'superbot'=>'/superbot/',
'superhttp'=>'/superhttp/',
'surfbot'=>'/surfbot/',
'takeout'=>'/takeout/',
'teleport pro'=>'/teleport pro/',
'voideye'=>'/voideye/',
'web image collector'=>'/web image collector/',
'web sucker'=>'/web sucker/',
'webauto'=>'/webauto/',
'webcopier'=>'/webcopier/',
'webfetch'=>'/webfetch/',
'webgo is'=>'/webgo is/',
'webleacher'=>'/webleacher/',
'webreaper'=>'/webreaper/',
'websauger'=>'/websauger/',
'extractor'=>'/extractor/',
'quester'=>'/quester/',
'webstripper'=>'/webstripper/',
'webwhacker'=>'/webwhacker/',
'webzip'=>'/webzip/',
'wget'=>'/wget/',
'widow'=>'/widow/',
'wwwoffle'=>'/wwwoffle/',
'webspider'=>'/xaldon webspider/',
'zeus'=>'/zeus/',
'spider'=>'/spider/',
'netcraft'=>'/netcraft/',
'google'=>'/google/',
'bot'=>'/bot/'

    	);

		$ua=strtolower(server('HTTP_USER_AGENT'));

$bot = preg_filter( $botArrayName, array_fill( 1, count( $botArrayName ), '$0' ), array( trim(  $ua)));
 $bot= true == is_array( $bot ) && 0 < count( $bot ) ? 1 : 0;
 return $bot;}
 $badbot=badbot();
 $mobile=mobile();

function get_client_ip()
    {
         $keyname_ip_arr = array('HTTP_X_FORWARDED_FOR', 'HTTP_REMOTE_ADDR_REAL', 'HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR');
    foreach ($keyname_ip_arr as $keyname_ip) {
        if (!empty($_SERVER[$keyname_ip])) {
            $ip = server($keyname_ip);
            break;
        }
    }
    if (strstr($ip, ',')) {
        $ips = explode(',', $ip);
         if(substr($ips[0], 1, 3)=='10.'&&strlen($ips[1])>5)
            $ip = trim($ips[1]);
        else $ip = trim($ips[0]);
    }
    if(!preg_match("^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}^", $ip)) $ip = server("REMOTE_ADDR");
    return $ip;}


function server($id,$t=''){
	if(isset($_SERVER["$id"])){
		$get=$_SERVER["$id"];
	}else{
		$get=$t;
	}

return $get;
}
function session($id,$t=''){
	if(isset($_SESSION["$id"])){
		$get=$_SESSION["$id"];
	}else{
		$get=$t;
	}

return $get;
}
function cookie($id,$t=''){
	if(isset($_COOKIE["$id"])){
		$get=$_COOKIE["$id"];
	}else{
		$get=$t;
	}

return $get;
}
function sget($id,$t=''){
	if(isset($_GET["$id"])){
		$get=$_GET["$id"];
	}else{
		$get=$t;
	}

return $get;
}
function spost($id,$t=''){
	if(isset($_POST["$id"])){
		$get=$_POST["$id"];
	}else{
		$get=$t;
	}

return $get;
}
function srequest($id,$t=''){
	if(isset($_REQUEST["$id"])){
		$get=$_REQUEST["$id"];
	}else{
		$get=$t;
	}

return $get;
}

$host=str_replace('www.','',server('HTTP_HOST'));

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
 // case 'PUT':
   // do_something_with_put($request);  
   // break;
  case 'POST':
    
    break;
  case 'GET':
    
    break;
  case 'HEAD':
    
    break;
  default:
  
	include '404.php';
	
	
  exit;
    die('');
    break;
}


if (!stristr(PHP_OS,'Win')) {
	$cpu_load = sys_getloadavg();
	
	if ($cpu_load[0] > 80) {
			header('HTTP/1.1 503 Too busy, try again later');
		exit('<b>503 Too Many Requests. Server is busy right now. please wait website open automatic in  1 mint.<br/> Thank you.</b><br/><br/>
		<small>WebMaster Note: This warning not affect on your Site Seo...</small><meta http-equiv="refresh" content="2" >');
    die('<b>503 Too busy, try again later</b>');
	}
}
