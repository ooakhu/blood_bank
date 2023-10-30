<?php

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();

    return [
        'class' => 'yii\db\Connection',
        'dsn' => $_ENV['MYSQL_DSN'],
        'username' => $_ENV['MYSQL_USERNAME'],
        'password' => '',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
