<?php
session_start();
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

require_once("../model/Users.php");
require_once("../model/Question.php");
require_once("../model/Reponse.php");
require_once("../model/Evenement.php");
require_once("../model/Messages.php");
require_once("../model/Connexion.php");
require_once("../model/ClassesAbstraites.php");



$users=new Users();
$messages=new Messages();
$event=new Evenement();
$questions=new Question();
$reponses=new Reponse();

/******** USERS **************/
$app->get('/users', function() use ($users){
    echo json_encode($users->getUsers());
});

$app->post('/addUser', function() use ($users) {
    $data= json_decode(file_get_contents("php://input"));
    $tel= $data->tel;
    $users->addUser($tel);
    echo $tel;
});


/***************** QUESTION ************/
$app->get('/listeQuest', function() use ($questions){
    echo json_encode($questions->getListeQuestions());
});

$app->get('/getQuestion/:num', function($num) use ($questions){
    echo json_encode($questions->getQuestion($num));
});


$app->get('/maxQuest', function() use ($questions){
    echo $questions->getNombreQuestions();
});

$app->post('/addQuest', function() use ($questions) {
    $data = json_decode(file_get_contents("php://input"));
    $enonce = $data->enonce;
    $num=$data->id;
    $type="qcm";
    $questions->ajouterQuestion($enonce,$num,$type);
    echo ($enonce);
});

/***************** REPONSE ************/
$app->get('/listeRep', function() use ($reponses){
    echo json_encode($reponses->getListeReponses());
});

$app->get('/getRep/:num', function($num) use ($reponses){
    echo json_encode($reponses->seeReponse($num));
});

$app->post('/addRep', function() use ($reponses) {
    $data = json_decode(file_get_contents("php://input"));
    $descrip = $data->description;
    $numR=$data->numRep;
    $numQ=$data->numQuest;
    $points=$data->points;
    $reponses->ajouterReponse($numQ,$numR,$descrip,$points);
});

/************* MESSAGE ***************/
$app->get('/getMessages/:tel', function($tel) use ($users) {
    echo json_encode($users->getMessagesByUser($tel));
});

$app->get('/getMessages', function() use ($messages){
    echo json_encode($messages->getMessages());
});

$app->get('/nbVotantQuestion/:question', function($question) use ($messages){
    echo $messages->nbVotantQuestion($question);
   
});

/*$app->get('/statsAnswer/:quest/:rep', function($quest,$rep) use ($messages){
    echo $messages->statsAnswer($quest,$rep);
   
});*/


/*************** EVENT *************/
$app->get('/etatEvent', function() use ($event){
    echo json_encode($event->getStateEvent());
});
$app->get('/lancer', function() use ($event){
    echo json_encode($event->startEvent());
});

$app->get('/stopper', function() use ($event){
    echo json_encode($event->stopEvent());
});

$app->post('/setQuestion', function() use ($event) {
    $data = json_decode(file_get_contents("php://input"));
    $quest = $data->question;
    $event->setCurrentQuestion($quest);
    echo $quest;
});

$app->get('/getCurrentQuestion', function() use ($event) {
   $quest= $event->getCurrentQuestion();
    echo $quest;
});

$app->get('/initCurrentQuestion', function() use ($event) {
    $event->initCurrentQuestion();
});

$app->run();


?>