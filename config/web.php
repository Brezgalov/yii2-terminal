<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'omLAui2yWPjvPZ4LIABi44uaTxzHiSCp',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
            'rules'             => [
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'days',
                    'prefix'        => 'api',
                    'extraPatterns' => [
                        'POST duplicate'   => 'duplicate',
                    ],
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'work-shifts',
                    'only'          => ['create'],
                    'prefix'        => 'api',
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'rules',
                    'only'          => ['create'],
                    'prefix'        => 'api',
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'rule-instances',
                    'only'          => ['update'],
                    'prefix'        => 'api',
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'cultures',
                    'except'        => ['update'],
                    'prefix'        => 'api',
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'retailers-groups',
                    'only'          => ['create', 'delete'],
                    'prefix'        => 'api',
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'retailers-group-retailers',
                    'except'        => ['update'],
                    'prefix'        => 'api',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
