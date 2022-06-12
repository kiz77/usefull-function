<?php 
function clearCookies($clearSession = false)
{
    $past = time() - 3600;
    if ($clearSession === false)
        $sessionId = session_id();
    foreach ($_COOKIE as $key => $value)
    {
        if ($clearSession !== false || $value !== $sessionId)
            setcookie($key, $value, $past, '/');
    }
}
