<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Books Catalog',
    'language' => 'en',

    // preloading 'log' component
    'preload' => ['log'],

    // autoloading model and component classes
    'import' => [
        'application.models.*',
        'application.components.*',
        'application.services.*',
    ],

    'modules' => [
        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
    ],

    'components' => [

        'user' => [
            'allowAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],

        'request' => [
            'enableCsrfValidation' => true,
        ],

        'urlManager' => [
            'urlFormat' => 'path',
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],

        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4',         
            'emulatePrepare' => true,
            'username' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'charset' => 'utf8mb4',
        ],

        'errorHandler' => [
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ],

        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],

        'sms' => [
            'class' => 'application.components.SmsPilotClient',
            'apiKey' => getenv('SMSPILOT_API_KEY') ?: '',
        ],
    ],
];
