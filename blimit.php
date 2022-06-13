<?php 
// set bandwidth limit to download file or html which your want via php only work with apache
include 'throttler.php';

// create new config
$config = new ThrottleConfig();
// enable burst rate for 30 seconds
$config->burstTimeout = 5;
// set burst transfer rate to 50000 bytes/second
$config->burstLimit = 500000;
// set standard transfer rate to 15.000 bytes/second (after initial 30 seconds of burst rate)
$config->rateLimit = 500000;
// enable module (this is a default value)
$config->enabled = true;

// start throttling
$x = new Throttle($config);
