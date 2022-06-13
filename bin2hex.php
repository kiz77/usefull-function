<?php 
function binToAscii($bin) {
    $text = array();
    $bin = str_split($bin, 8);

    for($i=0; count($bin)>$i; $i++)
        $text[] = chr(bindec($bin[$i]));

    return implode($text);
}
function hexentities($str) {
    $return = '';
    for($i = 0; $i < strlen($str); $i++) {
        $return .= '/x'.bin2hex(substr($str, $i, 1)).'';
    }
    return $return;
}
function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
