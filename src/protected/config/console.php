<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Books Catalog Console',

    // preloading 'log' component
    'preload' => ['log'],

    'import' => [
        'application.models.*',
        'application.components.*',
        'application.services.*',
    ],

    // application components
    'components' => [

        // database settings are configured in database.php
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4',         
            'emulatePrepare' => true,
            'username' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'charset' => 'utf8mb4',
        ],

        'sms' => [
            'class' => 'application.components.SmsPilotClient',
            'apiKey' => getenv('SMSPILOT_API_KEY') ?: '',
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

    ],
    'commandMap' => [
        'migrate' => [
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
        ],
    ],
];
