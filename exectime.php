<?php 

$time_start = microtime(true);
//code here
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
echo '<b>file dl Time:</b> '.$execution_time.' Mins';
