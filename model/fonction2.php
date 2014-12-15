<?php 
require ('connexion.php');


require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/startEvent', 'startEvent');
$app->post('/stopEvent', 'stopEvent');
$app->post('/afficheMSGTempsEcoule', 'afficheMSGTempsEcoule');
//$app->post('/afficheChrono', 'afficheChrono');
//$app->post('/ouvrirVote', 'ouvrirVote');
//$app->post('/fermerVote', 'fermerVote');
//$app->post('/afficheResultat', 'afficheResultat');
//$app->post('/questionSuivante', 'questionSuivante');*/



//***********************Fonctions gestion Evènements***********************//

//besoin de recharger la page
function startEvent(){
    echo "<script>alert('Début de l\'évènement')</script>"; 
    return true;
}

//pas d'affichage du script alert si redirection
function stopEvent(){
    $_SESSION=array();
    session_destroy();
    echo "<script>alert('Fin de l\'évènement.')</script>";
    //if ($v==true){ 
    //sleep(3);
    return 0; //header('Location: http://localhost/feedback');
        //exit();
    //}
}

//absolument non-fonctionnel
function afficheChrono(){
    /*echo "<script type='text/javascript'>";
    var temps=10;

    window.onload = function (){
        debut=new Date();
        debut=debut.getTime();
   
        document.getElementById('compteur').innerHTML=temps +'s';
       
        cmp=setInterval('decompte();',990);
    }
    function decompte(){
        var tmp=new Date();
        tmp=tmp.getTime();
        tmp=temps-((tmp-debut)/1000);
  
        if (tmp > 0) {
            document.getElementById('compteur').innerHTML=Math.round(tmp) +'s';
        }else {
            clearInterval(cmp);
            //document.getElementById('compteur').innerHTML='Fin';
    
        }
    }
    echo "</script>";
*/
}

function afficheMSGTempsEcoule($t){
    //$t=2000;
    echo "<script>";
    echo "setTimeout(alert,".$t.", 'Temps écoulé')";
    echo "</script>";
}

function ouvrirVote(){
    //met en route le chrono
    //les réponses s'affichent dans la table réponse

}

function fermerVote(){
    //les réponses s'affichent dans une table réponse alternative
}

function afficheResultat($numQuest){
    $bd = ConnectionFactory::getFactory()->getConnection();
   
    $req=$bd->prepare('SELECT num_Rep,description FROM reponse WHERE num_Question=:numQuestion');
    $req->bindValue(':numQuestion',$numQest);
    $req->execute();
    $reponse=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reponse);
}

function questionSuivante($questionEnCours){
    $bd = ConnectionFactory::getFactory()->getConnection();
   
    $req=$bd->prepare('SELECT num_Question,description FROM reponse WHERE num_Question=:numQuestion');
    $req->bindValue(':numQuestion',$questionEnCours+1);
    $req->execute();
    $question=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($question);
}






$app->run();
?>