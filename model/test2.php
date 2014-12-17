<?php
session_start();
//require ('connexion.php');
require('fonction2.php');/*
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//routage des méthodes pour que je puisse y accéder
$app->post('/startEvent', 'startEvent');
$app->get('/stopEvent', 'stopEvent');
$app->get('/afficheMSGTempsEcoule', 'afficheMSGTempsEcoule');

//test startEvent()
/*
if($_SESSION['alive']!=true){ //1ère page.
    echo "<p>Démarrer l'évènement:</p>";?>
    <form method="get">
        <input name="active" type="submit" value="Commencer"/>
    </form>
    <?php
    if ($_GET['active']=="Commencer"){
        $_SESSION['alive']=startEvent();
    }
}
//test stopEvent()
else if ($_SESSION['alive']==true){
    // bouton pour stopper ?>   
    <form method="get">
        <input name="active" type="submit" value="Terminer"/>
    </form><?php
    if ($_GET['active']=="Terminer"){
        stopEvent();       
    }    
}

//test afficheChrono non-fonctionnel
//afficheChrono();


//affiche un message alerte après 2s
afficheMSGTempsEcoule(2000);*/

afficheChrono2();



require("piedDePage.php");
?>