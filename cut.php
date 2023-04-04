<?php
function samcut($content,$start,$end,$mt='0',$s='1'){
if($content && $start) {	
$r = explode($start, $content);
if($mt=='0'){if (isset($r["$s"])){
	if(!empty($end)){
$r = explode($end, $r["$s"]);
return $r[0];}else{
	return $r[1];
}
}}elseif($mt=='1'){
unset($r['0']);
$d=array();
foreach($r as $id){
	if(!empty($id)){
		$e = explode($end, $id);
		$d[] = $e[0]; }}
return $d;
}}
return '';}
/*

cut any data from html in php using samcut function 
for single cut use mt=0 for multiple result in array use mt=1
single result: samcut($data,'value start','value end','0','value number ');
for multiple result in array: samcut($data,'value start','value end','1');
*/
