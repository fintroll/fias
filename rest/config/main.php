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

	'modules' => [

	],
	'components' => [
		'request' => [
			'csrfParam' => '_csrf-rest',
			'parsers' => [
				'application/json' => \yii\web\JsonParser::class,
			],
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
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
	],
	'params' => $params,
];

