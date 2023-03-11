<?php

use Dotenv\Dotenv;

function getboolenv($name) {
    $value = $_ENV[$name] ?? ($_SERVER[$name] ?? false);
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}

function getstrenv($name, $default = '') {
    $value = $_ENV[$name] ?? ($_SERVER[$name] ?? false);
    return $value === false ? $default : $value;
}

try {
    $dotEnv = Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotEnv->safeLoad();
    $dotEnv->required([
        'YII_ENV',
        'APP_VERSION',
        'DB_DRIVER',
        'DB_DATABASE',
        'DB_USER',
        'DB_HOST',
        'DB_PORT',
        'DB_PASSWORD',
        'DB_SCHEMA'
    ]);
    $dotEnv->required('YII_ENV')->allowedValues(['prod', 'dev', 'test']);
    $dotEnv->required('YII_COOKIE_VALIDATION_KEY')->notEmpty();
    $dotEnv->required('DB_DRIVER')->allowedValues(['mysql', 'pgsql']);
    $dotEnv->required('DB_SCHEMA_CACHE')->isBoolean();
    $dotEnv->required('DB_SCHEMA_CACHE_DURATION')->isInteger();
    if (getboolenv('REDIS_ENABLED')) {
        $dotEnv->required('REDIS_HOST');
        $dotEnv->required('REDIS_PORT')->isInteger();
        $dotEnv->required('REDIS_DATABASE')->isInteger();
    }

} catch (Exception $e) {
    die('Application not configured');
}

// get wanted debug
$debug = getboolenv('YII_DEBUG');
if ($debug === true) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// get if app is in maintenance.php mode
$maintenance = getboolenv('YII_MAINTENANCE');
defined('YII_MAINTENANCE') or define('YII_MAINTENANCE', $maintenance);

$currentEnvironment = getstrenv('YII_ENV');
defined('YII_ENV') or define('YII_ENV', $currentEnvironment);