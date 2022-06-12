<?php 
function count_number($n) {
   // first strip any formatting;
   $n = (0+str_replace(",","",$n));

   // is this a number?
   if(!is_numeric($n)) return false;

   // now filter it;
   if($n>1000000000000) return round(($n/1000000000000),1).'T';
   else if($n>1000000000) return round(($n/1000000000),1).'G';
   else if($n>1000000) return round(($n/1000000),1).'M';
   else if($n>1000) return round(($n/1000),1).'K';

   return number_format($n);
}
/* count number to million billion k G T
