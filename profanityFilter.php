<?php
$pro=new profanityFilter();
$txt='com-imageline';
$sam=$pro->scanText($txt);
print_r($sam);

class profanityFilter {
	// construct for holding the wordlist
	var $wordList;

	function __construct() {
		// compile list of words with typography variations
		$this->_setWordList();
	}
	/*
	Check text against rated terms, count instances, 
		and apply ratings as a factor to match count
	- return total match count
	*/
	function scanText($txt) {
		$profanityCount = 0;
		$txt = strip_tags($txt);
		$darr=array('%20'=>' ',
		'-'=>' ',
		'+'=>' ',
		'_'=>' ',
		'.apk'=>' ',
		'.zip'=>' ',
		'.rar'=>' ',
		'.7z'=>' ',);
		$txt=strtr($txt,$darr);
		$txt = html_entity_decode($txt,ENT_QUOTES);
		$txt=strtolower($txt);
		$word='';
		$x='1';
		foreach ($this->wordList as $k=>$v) {
			preg_match_all("#\b".$k."(?:es|s)?\b#si",$txt, $matches, PREG_SET_ORDER);
			if(!empty($matches)){
			$profanityCount += count($matches)*$v;
			
			$word["$x"]=$matches['0']['0'];
			$x++;}
		}
		$pro=array('total'=>$profanityCount,
		'word'=>$word);
		return $pro;
	}

	/*
	compile list of words with typography variations
	change ratings as desired to inflate various terms significance
	use hyphen to separate common break points in text to catch term variants
	*/
	function _setWordList() {
		$words = array(
'com.imageline'=>1,
'com.imageline.flm'=>1,
'44com.imageline.flm'=>1,
'fl slayer'=>1,
'fl studio'=>1,
'fl studio bible'=>1,
'fl studio groove'=>1,
'fl studio mobile'=>1,
'fl synthmaker'=>1,
'image-line'=>1,

	

		);
		$wordsPrepped = array();
		foreach ($words as $k=>$v) {
			$k = str_replace('-','\\W*',$k);
			$wordsPrepped[$k] = $v;
		}
		$this->wordList = $wordsPrepped;
	}	
}
?>
