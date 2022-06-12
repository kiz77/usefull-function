<?php 
function cvar($uri){
$sam=explode('?ver=',$uri);
return $sam['0'];
}

/* remove ?ver= from all html code
*/
