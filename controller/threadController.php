<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


require_once("../model/RobotGenereDB.php");
//require_once("../model/RobotTri.php");
//require_once("../model/Connexion.php");


$app->get('/startRobotDB', function() {
    $robot = new RobotGenereDB();
    $robot->start();
    $robot->unpause();
    sleep(5);
    $robot->stopper();
    $robot->join();
    
});

/*$app->get('/startRobotTri', function() {
    $robot = new RobotTri();
    $robot->start();
    sleep(2);
    $robot->stopper();
    $robot->join();
    
});*/




$app->run();
?>