<?php 
require ('connexion.php');

//ajout du framework php Slim et mise en route
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//routage des méthodes pour que je puisse y accéder
$app->post('/addQuest', 'addQuestion');
$app->get('/maxQuest', 'maxQuestion');
$app->get('/listeQuest', 'afficheQuestions');
$app->post('/addRep', 'ajouterReponse');
$app->get('/listeRep', 'afficheReponses');

//ajout question bdd
function addQuestion(){
    $data = json_decode(file_get_contents("php://input"));
    $enonce = $data->enonce;
    $num=$data->id;

    try{
    $bd = ConnectionFactory::getFactory()->getConnection();
   
       $req=$bd->prepare('INSERT INTO Question (num_Quest,type_Quest,enonce) VALUES (:numQuest,"qcm",:question)');
        $req->bindValue(":question", $enonce); 
        $req->bindValue(":numQuest", $num); 
        $req->execute();
    }
    catch(PDOException $e){
        die("Erreur ".$e->getMessage()."</body></html>");
    }

    echo $enonce;
}

//return l'id le plus élevé des questions
function maxQuestion(){

    try{
    $bd = ConnectionFactory::getFactory()->getConnection();
   
       $req=$bd->prepare('SELECT MAX(num_Quest) FROM Question');
        $req->execute();
        $reponse=$req->fetch(PDO::FETCH_NUM);
        echo $reponse[0];
    }
    catch(PDOException $e){
        die("Erreur ".$e->getMessage()."</body></html>");
    }

}


function afficheQuestions(){

    try{
    $bd = ConnectionFactory::getFactory()->getConnection();
   
       $req=$bd->prepare('SELECT num_Quest, enonce FROM Question');
        $req->execute();
        $reponse=$req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($reponse);
    }
    catch(PDOException $e){
        die("Erreur ".$e->getMessage()."</body></html>");
    }

}

function afficheReponses(){

    $bd = ConnectionFactory::getFactory()->getConnection();
   
       $req=$bd->prepare('SELECT num_Question,num_Rep,description FROM Reponse');
        $req->execute();
        $reponse=$req->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($reponse);
    


}




function ajouterReponse(){

  
        $bd = ConnectionFactory::getFactory()->getConnection();
        $data = json_decode(file_get_contents("php://input"));
        $descrip = $data->description;
        $numR=$data->numRep;
        $numQ=$data->numQuest;
        
        $req=$bd->prepare('INSERT INTO Reponse (num_Question,num_Rep,description,point) VALUES (:numQ,:numR,:descrip,0)');
        $req->bindValue(':numQ',$numQ); 
        $req->bindValue(':numR',$numR); 
        $req->bindValue(':descrip',$descrip);
        $req->execute();

    

}




$app->run();




?>