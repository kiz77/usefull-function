<?php 

   // header('Content-Type: application/json');
    header('Content-Encoding: none;');

        set_time_limit(0);
		function template() {
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta **********="Content-Type" *********"text/html; charset=utf-8" />
<title> File downloads Tools </title>
<style type="text/css">
h1.technique-two {
        width: 795px; height: 120px;
        background: url(http://x0rg.org/styles/blackbox_red/imageset/site_logo.gif) no-repeat top center;
        margin: 0 auto;
}
body{
    background: #070707;
    margin: 0;
    padding: 0;
    padding-top: 10px;
    color: #FFF;
    font-family: Calibri;
    font-size: 13px;
}
a{
    color: #FFF;
    text-decoration: none;
    font-weight: bold;
}
.wrapper{
    width: 1000px;
    margin: 0 auto;
}
.tube{
    padding: 10px;
}
.red{
    width: 998px;
    border: 1px solid #e52224;
    background: #191919;
    color: #e52224
}
.red input{
    background: #000;
    border: 1px solid #e52224;
    color: #FFF;
}
.blue{
    float: left;
    width: 1000px;
    border: 1px solid #1d7fc3;
    background: #191919;
    color: #1d7fc3;
}
.green{
    float: left;
    width: 1000px;
    border: 1px solid #5fd419;
    background: #191919;
    color: #5fd419;
}
.w3-light-grey,.w3-hover-light-grey:hover,.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#f1f1f1!important}
.w3-container:after,.w3-container:before,.w3-panel:after,.w3-panel:before,.w3-row:after,.w3-row:before,.w3-row-padding:after,.w3-row-padding:before,
.w3-cell-row:before,.w3-cell-row:after,.w3-clear:after,.w3-clear:before,.w3-bar:before,.w3-bar:after{content:"";display:table;clear:both}
.w3-col,.w3-half,.w3-third,.w3-twothird,.w3-threequarter,.w3-quarter{float:left;width:100%}
.w3-green,.w3-hover-green:hover{color:#fff!important;background-color:#4CAF50!important}
</style>
<script type="text/javascript">
<!--
function insertcode($text, $place, $replace)
{
    var $this = $text;
    var logbox = document.getElementById($place);
    if($replace == 0)
        document.getElementById($place).innerHTML = logbox.innerHTML+$this;
    else
        document.getElementById($place).innerHTML = $this;
//document.getElementById("helpbox").innerHTML = $this;
}
-->
</script>
</head>
<body>
<br />
<br />
<center>
<h1 class="technique-two">
       
File downloads Tools 

</h1>
</center>
<div class="wrapper">
<div class="red">
<div class="tube">
<form action="" method="post" name="xploit_form">
URL:<br /><input type="text" name="xploit_url" value="'.$_POST['xploit_url'].'" style="width: 100%;" /><br /><br />
<br />
<span style="float: right;">



<input type="submit" name="xploit_submit" value="go for it" align="right" /></span>
</form>
<br />
</div> <!-- /tube -->
</div> <!-- /red -->
<br />
<div class="green">
<div class="tube" id="rightcol" style="text-align: center;">
Verificat: <span id="verified">0</span> / <span id="total">0</span><br />
Found ones:<br />
</div> <!-- /tube -->
</div> <!-- /green -->
<br clear="all" /><br />
<div class="blue">
<div class="tube" id="logbox">
<br />

Private files link changer<br /><br />
</div> <!-- /tube -->
</div> <!-- /blue -->
</div> <!-- /wrapper -->
<br clear="all">';
}
template();
if(!isset($_POST['xploit_url'])) die;
if($_POST['xploit_url'] == '') die;
		function show($msg, $br=1, $stop=0, $place='logbox', $replace=0) {
    if($br == 1) $msg .= "<br />";
    echo "<script type=\"text/javascript\">insertcode('".$msg."', '".$place."', '".$replace."');</script>";
    if($stop == 1) exit;
    @flush();@ob_flush();
}
function msleep($time)
{
    usleep($time * 1000000);
}
function timetosec($time)
{
	$time=str_replace('h',':',$time);
	$time=str_replace('m',':',$time);
	$time=str_replace('s','',$time);
     $timed = explode(':', $time);
	
	 $c= count($timed);
	switch ($c) {
		/* 1h=3600
	1mint= 60
	*/
    case "1":
        $data=($timed['0']);
	
        break;
    case "2":
        $data=( ($timed['0'] * 60) + $timed['1']);
	
        break;
    case "3":
	
	$data=(($timed['0'] * 3600) + ($timed['1'] * 60) + $timed['2']);
	
      
        break;

}
    
     return $data;
}

function samcut($content,$start,$end){
if($content && $start && $end) {
$r = explode($start, $content);
if (isset($r[1])){
$r = explode($end, $r[1]);
return $r[0];}
return '';}}
function name($q){
	$qid=array('%20','_','!',"'",'#','@','~','%','^','&','*','|','+','[',']');
	$sam=pathinfo(str_replace($qid,'',$q));

	return $sam['basename'];

}

function get_sizes($url) {
	$sam=get_headers($url);
	foreach($sam as $ssam){
	if(strpos($ssam, 'Content-Length:')=== 0) {
		$size=str_replace('Content-Length: ','',$ssam);
		if($size > 1){
			return($size);
			}
			
		}}
}
function format_size($size){$filesizename=array(" Bytes"," KB"," MB"," GB"," TB"," PB"," EB"," ZB"," YB");
return $size ? round($size/pow(1024,($i=floor(log($size,1024)))),2).$filesizename[$i] : '0 Bytes';}

$url = $_POST['xploit_url'];
$dir=dirname(__FILE__).'/sam';
$name=''.rand(0,999999).'-'.name($url);
$size=get_sizes($url);
$command='wget -P "'.$dir.'" -O "'.$name.'" "'.$url.'"   2>&1'; 
$block=array('7','8');
        $handle = popen($command, "r");
$x=1;
        if (ob_get_level() == 0) 
            ob_start();

        while(!feof($handle)) {

            $buffer = fgets($handle);
           $buffer = trim(htmlspecialchars($buffer));
if($x > 5 && !in_array($x,$block)){
	if($x > 9){
		$buffer=str_replace('.......... ','',$buffer);
		$buffer=str_replace('   ',' ',$buffer);
		$buffer=str_replace('  ',' ',$buffer);
		$buffer=str_replace(array("\n", "\r"), '', $buffer);
		$da=explode(' ',$buffer);
		
	//echo '**$$**'.json_encode(array('progress'=>$da['1'], 'complete'=>$da['0'], 'speed'=>$da['2'], 'time'=>timetosec($da['3'])));
	
		//print_r($da);
		//echo 'dlsize: '.$da['0'].' comp:'.$da['1'].' Speed:'.$da['2'].' Time:'.timetosec($da['3']).' Second<br/>';
		//echo "\n";
		//echo str_pad('', 0);
		$nsize=str_replace('k','',$da['0']);
		$nsize=($nsize*1024);
		 show('<div class="w3-light-grey"><div class="w3-container w3-green" style="width:'.$da['1'].'">'.$da['1'].'</div></div><br/>Progress Complete:'.$da['1'].' File Size: '.format_size($nsize).'/'.format_size($size).'  Speed:'.$da['2'].' Time:'.gmdate("H:i:s", timetosec($da['3'])).' remaining', 1, 0, 'rightcol', 1);
		  ob_flush();
            flush();
		//	msleep('0.009'); //for human use
	 //sleep(1);
	 }
           // echo $buffer . "<br />";
           // echo str_pad('', 0);    

           }
		    ob_flush();
            flush();
			$x++;
           
        }
		$size=filesize($name);
		if(file_exists($name)){
 show('<div class="w3-light-grey"><div class="w3-container w3-green" style="width:100%">100%</div></div><br/><a href="/'.$name.'">Click here to download '.$name.'</a> file size: '.format_size($size).'', 1, 0, 'rightcol', 1);}else{
	 show('<h3> Error </h3>', 1, 0, 'rightcol', 1);
 }
        pclose($handle);
        ob_end_flush();
	
