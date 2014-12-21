<?php
session_start();
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

require_once("../model/ClassUsers.php");
require_once("../model/Evenement.php");
require_once("../model/Messages.php");
require_once("../model/connexion.php");
require_once("../model/ClassesAbstraites.php");


$users=new Users();
$messages=new Messages();
$event=new Evenement();

$app->get('/users', function() use ($users){
    echo json_encode($users->getUsers());
});

$app->post('/addUser', function() use ($users) {
    $data= json_decode(file_get_contents("php://input"));
    $tel= $data->tel;
    $users->addUser($tel);
    echo $tel;
});

$app->get('/getMessages/:tel', function($tel) use ($users) {
    echo json_encode($users->getMessagesByUser($tel));
});

$app->get('/getMessages', function() use ($messages){
    echo json_encode($messages->getMessages());
});

$app->get('/etatEvent', function() use ($event){
    echo json_encode($event->getStateEvent());
});
$app->get('/lancer', function() use ($event){
    echo json_encode($event->startEvent());
});

$app->get('/stopper', function() use ($event){
    echo json_encode($event->stopEvent());
});


    $app->run();
    //echo json_encode($users->getUser("0646763234"));

    //echo $users;
    /*afficherRepUSer($users, '0646763234', 1);
    add($users, '0646763234', 1, 'AC');
    afficherRepUSer($users, '0646763234', 1);


    // affiche en HTML la liste des réponses d'un utilisateur a la question demandé
    function afficherRepUSer($users, $user, $question)
    {
        $userp = $users->getUSer($user);
        if($userp!=false) // si pas faux, alors le user existe
        {
            $mess = $userp->messages();
            $reps = $mess->answerToQuestion($question);
            echo '<p>['.$user.'] '.$question.' : ';
            if($reps!=false) // si pas faux, alors il a repondu à la question
                foreach($reps as $key => $rep) 
                    echo $rep . ' ';

            else echo 'Aucune réponse donné à cette question';
            echo '</p>';
        }
        echo '<p>['.$user.'] n\'existe pas sur la BDD</p>';

    }

    // ajoute/update une réponse de l'utilisateur à une question.
    function add($users, $user, $q, $a)
    {
        $messages = $users->getUSer($user)->messages();
        $messages->addAnswer($q, $a);
    }*/

    ?>