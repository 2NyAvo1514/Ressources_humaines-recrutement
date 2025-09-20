<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;
use app\models\RechercheModel;
use app\models\AnnonceModel;
use app\models\EmployeModel;
// =========

use app\models\triModel;
use app\models\triEntretienModel;
/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
 $dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
 $pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
 $app->register('db', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

Flight::map('rechercheModel', function () {
    return new RechercheModel(db: Flight::db());
});

Flight::map('annonceModel', function () {
    return new AnnonceModel(db: Flight::db());
});

Flight::map('employeModel', function () {
    return new EmployeModel(db: Flight::db());
});

// =========== 

Flight::map('triModel', function () {
    return new triModel(db: Flight::db());
});

Flight::map('triEntretienModel', function () {
    return new triEntretienModel(db: Flight::db());
});
