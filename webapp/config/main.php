<?php

use yii\web\ErrorHandler;
use yii\web\JsonParser;

$config = require dirname(__DIR__, 2).'/common/config/common.php';

$config['basePath'] = dirname(__DIR__);
$config['id'] = 'my-pokemon-builder';
$config['name'] = 'My Pokemon Builder';

$config['controllerNamespace'] = 'webapp\controllers';

$config['components']['request'] = [
    'cookieValidationKey' => getstrenv('YII_COOKIE_VALIDATION_KEY'),
    'parsers' => [
        'application/json' => JsonParser::class,
    ],
];


$proxyIp = getstrenv('PROXY_TRUSTED_HOSTS');
if ($proxyIp !== false) {
    $config['components']['request']['trustedHosts'] = [
        $proxyIp
    ];
}

/**/
if (defined('YII_ENV') && YII_ENV !== 'dev') {
    $config['components']['errorHandler'] = [
        'class' => ErrorHandler::class,
        'errorAction' => 'technical/maintenance.php'
    ];
}
/**/

if (defined('YII_ENV') && YII_ENV === 'dev') {
    /**/
    $yiiGii = class_exists(yii\gii\Module::class);
    if ($yiiGii && defined('YII_DEBUG') && YII_DEBUG == true) {
        $config['modules']['gii'] = [
            'class' => yii\gii\Module::class,
            'allowedIPs' => ['*']
        ];
        $config['bootstrap'][] = 'gii';
    }
    /**/
    /**/
    $yiiDebug = class_exists(yii\debug\Module::class);
    if ($yiiDebug && defined('YII_DEBUG') && YII_DEBUG == true) {
        $config['modules']['debug'] = [
            'class' => yii\debug\Module::class,
            'allowedIPs' => ['*']
        ];
        $config['bootstrap'][] = 'debug';
    }
    /**/
}

$config['components']['assetManager'] = [
    'linkAssets' => true,
];

$config['catchAll'] = require(__DIR__ . '/maintenance.php');

$config['defaultRoute'] = 'site/index';

$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false,
    'showScriptName' => false,
    'rules' => [
        [
            'pattern' => 'home',
            'route' => $config['defaultRoute'],
        ],
    ],

];
return $config;