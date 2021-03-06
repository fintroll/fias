<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

/** @noinspection PhpFullyQualifiedNameUsageInspection */
return [
    'id' => 'rest',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'rest\controllers',
    'bootstrap' => [
        'log',
    ],

    // set target language to be Russian
    'language' => 'ru-RU',

    // set source language to be English
    'sourceLanguage' => 'en-US',


    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \rest\models\User::class,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'session' => [
            // this is the name of the session cookie used for login on the rest
            'name' => 'advanced-rest',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET address/<id>' => 'address/default/view',
                'GET link/<id>' => 'link/default/view',
                'POST link' => 'link/default/create',
                [
                    'class' => yii\rest\UrlRule::class,
                    'controller' => [
                        'site',
                    ],
                ],
            ]
        ],
        'sphinx' => [
            'class' => yii\sphinx\Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => '',
            'password' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'address' => [
            'class' => \rest\modules\address\Address::class,
        ],
        'link' => [
            'class' => \rest\modules\link\Link::class,
        ],
        'search' => [
            'class' => \rest\modules\search\Search::class,
        ],
        'analytics' => [
            'class' => \rest\modules\analytics\Analytics::class,
        ],
    ],
    'params' => $params,
];

