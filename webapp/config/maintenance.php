<?php

$result = null;
if (YII_MAINTENANCE === true) {
    $allowedIp = preg_split('/\s*,\s*/', getenv('YII_MAINTENANCE_ALLOWED_IPS'));
    if (in_array($_SERVER['REMOTE_ADDR'], $allowedIp) === false) {
        $result = ['technical/maintenance'];
    }
}

return $result;