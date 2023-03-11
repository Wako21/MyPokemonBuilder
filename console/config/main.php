<?php

use yii\console\controllers\MigrateController;
$config = require dirname(__DIR__, 2).'/common/config/common.php';

$config['basePath'] = dirname(__DIR__);
$config['id'] = 'my-pokemon-builder';
$config['name'] = 'My Pokemon Builder';
$config['aliases']['@webroot'] = dirname(__DIR__, 2).'/www';
$config['controllerNamespace'] = 'console\controllers';

$config['controllerMap'] = [
    'migrate' => [
        'class' => MigrateController::class,
        'migrationNamespaces' => [
            'app\\migrations\\'
        ],
        'migrationPath' => null,
    ],
];

return $config;