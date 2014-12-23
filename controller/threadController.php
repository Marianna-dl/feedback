<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


require_once("../model/RobotGenereDB.php");
require_once("../model/Connexion.php");




    $robot = new RobotGenereDB();
    $robot->start();
   
$app->get('/stop', function() use ($robot){
    $robot->unpause();
    sleep(3);
    $robot->pause();  
    sleep(3);
    $robot->stopper(); 

});
$app->get('/start', function() use ($robot) {

    $robot->unpause();
    sleep(3);
    $robot->pause();  
    sleep(3);
    $robot->stopper(); 
    
});



$app->run();
?>