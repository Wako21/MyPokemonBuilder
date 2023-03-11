<?php

use modules\api\models\User;
use modules\api\Module;
use yii\db\Connection;

$config = [
    'id' => 'my-pokemon-builder',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'api'],
    'extensions' => require dirname(__DIR__, 2) . '/vendor/yiisoft/extensions.php',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'aliases' => [
        '@approot' => dirname(__DIR__, 2),
        '@app' => dirname(__DIR__) . '/',
        '@webapp' => dirname(__DIR__, 2) . '/webapp',
        '@console' => dirname(__DIR__, 2) . '/console',
        '@modules' => dirname(__DIR__, 2) . '/modules',
        '@data' => dirname(__DIR__, 2) . '/data',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'modules' => [
        'api' => [
            'class' => Module::class
        ]
    ],
    'components' => [
        'request' => [

        ],
        'i18n' => [

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => User::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => YII_DEBUG ? ['error', 'warning', 'profile']:['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => Connection::class,
            'charset' => 'utf8',
            'dsn' => getstrenv('DB_DRIVER').':host=' . getstrenv('DB_HOST') . ';port=' . getstrenv('DB_PORT') . ';dbname=' . getstrenv('DB_DATABASE'),
            'username' => getstrenv('DB_USER'),
            'password' => getstrenv('DB_PASSWORD'),
            'tablePrefix' => getstrenv('DB_TABLE_PREFIX'),
            'enableSchemaCache' => getstrenv('DB_SCHEMA_CACHE'),
            'schemaCacheDuration' => getstrenv('DB_SCHEMA_CACHE_DURATION'),

        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => getstrenv('BASE_URL'),
            'scriptUrl' => getstrenv('BASE_URL'),
            'hostInfo' => getstrenv('BASE_URL'),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ]
    ],
    'params' => [],
];

return $config;
