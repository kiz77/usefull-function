<?php 
function mkdir_r($dirName, $rights=0755){
    $dirs = explode('/', $dirName);
    $dir='';
    foreach ($dirs as $part) {
        $dir.=$part.'/';
        if (!@is_dir($dir) && strlen($dir)>0)
            @mkdir($dir, $rights);
    }
}
function ipproxycheck($ip,$loc='tmp'){
	$dip=explode('.',$ip);
  if(!empty($_SERVER['HTTP_CF_IPCOUNTRY'])){
  $ccode=$_SERVER['HTTP_CF_IPCOUNTRY'];}else{
    $ccode='all';}
	$dir=$loc.'/proxyip/'.strtolower($ccode) .'/'.$dip['0'].'/';
	if(!is_dir($dir)) {mkdir_r($dir, 0755);}
	$file=$dir.$ip.'.txt';
	
	if(file_exists($file)){
		$d=file_get_contents($file);
		
		return $d;
	}else{
$proxy_ports = array(80,81,8080,443,1080,6588,3128);
	foreach($proxy_ports as $test_port) {
		if(@fsockopen($ip, $test_port, $errno, $errstr, 0.03)) {
			file_put_contents($file,true);
			return true;
			exit;
		}
	}
	file_put_contents($file,false);
	return false;}
	
	return false; }
	
$ip=$_SERVER['REMOTE_ADDR'];	// get ip
	$loc='proxy'; ////folder location to save cache of ip checker.
	
	if(ipproxycheck($ip,$loc)){
		echo 'proxy detected.'; //proxy detected.
	}else{
		echo 'real ip.'; ///no proxy detected.
	}
