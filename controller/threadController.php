<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


require_once("../model/RobotGenereDB.php");
//require_once("../model/Connexion.php");


$app->get('/startRobot', function() {
    $robot = new RobotGenereDB();
    $robot->start();
    $robot->unpause();
    sleep(5);
    $robot->stopper();
    $robot->join();
    

});






$app->run();
?>