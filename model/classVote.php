<?php

class Vote {

private $db;

public function __construct()
{	
	$this->db = ConnectionFactory::getFactory()->getConnection();
		
}

public function afficheChrono2(){
    	include('timer.html');
	}


public function afficheMSGTempsEcoule($t){
    //$t=2000;
    echo "<script>";
    echo "setTimeout(alert,".$t.", 'Temps écoulé')";
    echo "</script>";
}

public function ouvrirVote(){
    //met en route le chrono
    //les réponses s'affichent dans la table réponse

}

public function fermerVote(){
    //les réponses s'affichent dans une table réponse alternative
}

public function afficheResultat($numQuest){
  try {
    $req=$db->prepare('SELECT'.ReponseColumns::numR.','.ReponseColumns::description.'FROM '. TableName::reponse.'WHERE '.ReponseColumns::numQ.'=:numQuestion');
    $req->bindValue(':numQuestion',$numQuest);
    $req->execute();
    $reponse=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reponse);
	}
catch (PDOException $e)
	{	
       die('Connexion échouée : ' . $e->getMessage());	
        }

}

public function questionSuivante($questionEncours){
try {
    $req=$db->prepare('SELECT'.ReponseColumns::numQ.','.ReponseColumns::description.'FROM'. TableName::reponse.'WHERE'.ReponseColumns::numQ.'=:numQuestion');
    $req->bindValue(':numQuestion',$questionEnCours+1);
    $req->execute();
    $question=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($question);
}
catch (PDOException $e)
{	
     die('Connexion échouée : ' . $e->getMessage());	
       }
}

public function afficheMessage(){
    
   try {
    $req=$db->prepare('SELECT'.MessageColumns::ref.','.MessageColumns::question.','.MessageColumns::reponses.','.MessageColumns::date.'FROM'. TableName::message)
    $req->execute();
    $question=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($question);
	}
		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}

}

?>
