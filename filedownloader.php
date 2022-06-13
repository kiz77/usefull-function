<?php

  header('Content-Encoding: none;');
ini_set('max_execution_time', '0'); 
set_time_limit(0);

/**
 * Class Downloader
 */
class Downloader
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $destination;
	
    private $totalsize = 0;
    private $prevSize = 0;
    private $startTime = 0;
    private $prevTime = 0;

    /**
     * Downloader constructor.
     * @param string $url
     * @param string $destination
     */
    public function __construct( $url,  $destination)
    {
		$this->startTime = microtime(true);
		$this->prevTime = $this->startTime;
        $this->url = $this->prepareUrl($url);
        $this->destination = $this->prepareDestination($destination);
    }
    /*
     * @param string $url
     * @return string
     */
    private function prepareUrl( $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->stderr('Invalid URL');
            die;
        }
        return $url;
    }
    /**
     * @param string $output
     */
    private function stderr( $output)
    {
        echo ( $output);
    }
    /**
     * @param string $destination
     * @return string
     */
    private function prepareDestination($destination)
    {
        $fileName = basename($destination);
        $dirName = realpath(dirname($destination));
        if (!$dirName) {
            $this->stderr('Check the destination path of file');
            die;
        }
        return $dirName . DIRECTORY_SEPARATOR . $fileName;
    }
    /**
     *
     */
	public function get_sizes($url) {
	$sam=get_headers($url);
	foreach($sam as $ssam){
	if(strpos($ssam, 'Content-Length:')=== 0) {
		$size=str_replace('Content-Length: ','',$ssam);
		if($size > 1){
			return($size);
			}
			
		}}
}
    public function download()
    {

		$this->totalsize=$this->get_sizes($this->url);
        $ch = curl_init();
        $fp = fopen($this->destination, 'wb');
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->url,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FILE => $fp,
            CURLOPT_PROGRESSFUNCTION => [$this, 'progress'],
            CURLOPT_NOPROGRESS => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FAILONERROR => true
        ]);
        curl_exec($ch);
        if (curl_errno($ch)) {
            $this->stderr('Error: ' . curl_error($ch));
            die;
        }
        curl_close($ch);
        fclose($fp);
    }
    /**
     * @param $resource
     * @param int $download_size
     * @param int $downloaded
     * @param int $upload_size
     * @param int $uploaded
     */
    private function progress($resource, $download_size = 0, $downloaded = 0, $upload_size = 0, $uploaded = 0)
    {
		
		if($downloaded < 5){
			$downloaded=$this->totalsize;
		}
		
        $percent = $download_size > 0 && $downloaded > 0 ? ceil($downloaded * 100 / $download_size) : 0;
        //$this->stdout('[' . str_pad('', $percent, '#') . str_pad('', 100 - $percent) . "] $percent%\r");
		/*
   $this->stdout('[' .'<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: '.$percent.'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>' . str_pad('', 100 - $percent) . "] $percent%\r");
*/
if($download_size > 1){
$averageSpeed = $downloaded / (microtime(true) - $this->startTime);
$currentSpeed = ($downloaded - $this->prevSize) / (microtime(true) - $this->prevTime);
}else {
	$averageSpeed=1;
	$currentSpeed =0;
}


 /* set prev size */
$this->prevSize=$downloaded;
		$this->prevTime = microtime(true);
$timeRemaining = ($download_size - $downloaded) / $averageSpeed;
 $this->show('<div class="w3-light-grey"><div class="w3-container w3-green" style="width:'.$percent.'%; max-width:100%;"><center>'.$percent.'%</center></div></div><br/>Progress Complete:'.$percent.'% File Size: '.$this->format_size($downloaded).'/'.$this->format_size($download_size).'  Speed:'.$this->format_size($currentSpeed).' Time:'.gmdate("H:i:s", $this->timetosec($timeRemaining)).' remaining', 1, 0, 'rightcol', 1);
 //$this->msleep('0.009'); //for human use

    }
    /**
     * @param string $output
     */
    private function stdout( $output)
    {
        echo $output."<br/>"."\n";
    }
	
	public	function show($msg, $br=1, $stop=0, $place='logbox', $replace=0) {
    if($br == 1) $msg .= "<br />";
    echo "<script type=\"text/javascript\">insertcode('".$msg."', '".$place."', '".$replace."');</script>";
    if($stop == 1) exit;
    @flush();@ob_flush();
}
	public function format_size($size){$filesizename=array(" Bytes"," KB"," MB"," GB"," TB"," PB"," EB"," ZB"," YB");
return $size ? round($size/pow(1024,($i=floor(log($size,1024)))),2).$filesizename[$i] : '0 Bytes';}
public	function msleep($time)
{
    usleep($time * 1000000);
}
public function timetosec($time)
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
}
function template() {
	if (isset($_POST['xploit_url'])){
		$url = $_POST['xploit_url'];
	}else{
		$url='';
	}
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
URL:<br /><input type="text" name="xploit_url" value="'.$url.'" style="width: 100%;" /><br /><br />
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
<br clear="all">
';
}
template();
function name($q){
	$qid=array('%20','_','!',"'",'#','@','~','%','^','&','*','|','+','[',']','(',')');
	$sam=pathinfo(str_replace($qid,'',$q));

	return $sam['basename'];

}
if(!isset($_POST['xploit_url'])) die;
if($_POST['xploit_url'] == '') die;
$url = $_POST['xploit_url'];
$path=parse_url($url);
$host=str_replace('www.','',$_SERVER['HTTP_HOST']);
$pth=pathinfo($path['path']);
	$typ=$pth['extension'];
	
	$type=array('php','php4','php5','php6','php7','php2','php3','html','js');
	
$dir=dirname(__FILE__).'/uploads/';
if(!is_dir($dir)) mkdir($dir, 0755);
$name=''.rand(0,999999).'-'.name($path['path']);
$file=$dir.$name;
$dw = new Downloader($url, $file);
if(in_array($typ,$type)){
		$dw->show('<h3> Error </h3>', 1, 0, 'rightcol', 1);
		exit;
		die;
		}
$dw->download();
$size=filesize($file);
		if(file_exists($file)){
 $dw->show('<div class="w3-light-grey"><div class="w3-container w3-green" style="width:100%">100%</div></div><br/><a href="/uploads/'.$name.'">Click here to download '.$name.'</a> file size: '.$dw->format_size($size).'<br/><br/>Copy URL: <input type="text" value="http://'.$host.'/uploads/'.$name.'" style="width:90%">', 1, 0, 'rightcol', 1);}else{
	 $dw->show('<h3> Error </h3>', 1, 0, 'rightcol', 1);
 }
