function samcut($content,$start,$end,$s='1'){
if($content && $start) {
$r = explode($start, $content);
if (isset($r["$s"])){
	if(!empty($end)){
$r = explode($end, $r["$s"]);
return $r[0];}else{
	return $r[1];
}
	
}
return '';}}

/*

cut any data from html in php using samcut function */
