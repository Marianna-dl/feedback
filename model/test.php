<?php 
session_start();
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
$app->get('/lancer', 'startEvent');
$app->get('/stopper', 'stopEvent');
$app->get('/etatEvent', 'getStateEvent');
$app->get('/check', 'check');
//$app->get('/robot', 'robot');

//ajout question bdd
function addQuestion(){
    $data = json_decode(file_get_contents("php://input"));
    $enonce = $data->enonce;
    $num=$data->id;

    try{
    $bd = ConnectionFactory::getFactory()->getConnection();
   
       $req=$bd->prepare('INSERT INTO question (num_quest,type_quest,enonce) VALUES (:numQuest,"qcm",:question)');
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
   
       $req=$bd->prepare('SELECT MAX(num_quest) FROM question');
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
   
       $req=$bd->prepare('SELECT num_quest, enonce FROM question');
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
   
       $req=$bd->prepare('SELECT num_question,num_rep,description,point FROM reponse');
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
        $points=$data->points;
        
        $req=$bd->prepare('INSERT INTO reponse (num_question,num_rep,description,point) VALUES (:numQ,:numR,:descrip,:points)');
        $req->bindValue(':numQ',$numQ); 
        $req->bindValue(':numR',$numR); 
        $req->bindValue(':descrip',$descrip);
        $req->bindValue(':points',$points);
        $req->execute();  

}

function startEvent(){
    $_SESSION['alive']=true;
    echo json_encode($_SESSION['alive']);
}

//pas d'affichage du script alert si redirection
function stopEvent(){
     if (isset($_SESSION['alive'])){ $_SESSION['alive']=false;}
    echo json_encode($_SESSION['alive']);
}

/*function robot(){
  
        echo json_encode(false);
        
         

}*/

function check(){
    for($i=0;$i<10;$i++){
        echo $i;
    }


}

function getStateEvent(){
   if (isset($_SESSION['alive']) && $_SESSION['alive']==true){
       echo json_encode(true);
   }
    else{
          echo json_encode(false);     
    }

}
       /*   $http.get("./model/testsClassUsers.php/users").success(function(data){
                 
            $scope.users=data;
              console.log(JSON.stringify($scope.users));
           })
         .error(function(){
              console.log(data);
          })*/
          
         /*   $http.get("./model/testsClassUsers.php/getMessages/"+"0646763234").success(function(data){
                 
            //$scope.users=data;
              console.log(data[0].num_reponse);
           })
         .error(function(){
              console.log(data);
          })*/
            

$app->run();




?>
