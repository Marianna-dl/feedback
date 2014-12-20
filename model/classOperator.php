<?php 

	

	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	$route = new \Slim\Slim();


	$route->post('/ajoutQuest', 'ajouterQuestion');
	$route->post('/modifierQuest', 'modifierQuestion');
	$route->post('/supprimerQuest', 'supprimerQuestion');
	$route->post('/ajoutRep', 'ajouterReponse');
	$route->post('/modifierRep', 'modifierReponse');
	$route->post('/supprimerRep', 'supprimerReponse');
	$route->get('/seeAllQuest', 'seeAllQuestion');
	$route->get('/seeOneQuest', 'seeOneQuestion');
	$route->get('/seeRep', 'seeReponse');

class Question {

	private $db;

	public function __construct()
	{	
			$this->db = new PDO('mysql:dbname='.dbNames::feedback.';host=127.0.0.1', 'root', '');
			$this->db->query('SET NAMES utf8');
		
	}

	public function seeAllQuestion(){
		
		
			
			$req = 'SELECT * FROM ' . TableName::question;
			$res = $this->db->query($req);
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);

	}



	public function seeOneQuestion(){
		
			$data = json_decode(file_get_contents("php://input"));
    			$num=$data->id;
		

		
			
			$req = 'SELECT * FROM ' . TableName::question.'WHERE'.QuestionColumns::id.'=:num';
			$req->bindValue(':num',$num); 
			$res = $this->db->query($req);
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);


	}



	public function ajouterQuestion(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$enonce = $data->enonce;
   			$num=$data->id;
			$type=$data->type;

		
			
			$req=$this->$db->prepare('INSERT INTO '. TableName::question. '('.QuestionColumns::id.','.QuestionColumns::type.',' .QuestionColumns::enonce.') VALUES (:num,:type,:enonce)');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			


	}



	public function modifierQuestion(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$enonce = $data->enonce;
   			$num=$data->id;
			$type=$data->type;

		
			
			$req=$this->$db->prepare('UPDATE'. TableName::question.' SET '.QuestionColumns::type.'=:type,' .QuestionColumns::enonce.'=:enonce WHERE'.QuestionColumns::id.'=:num');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			


	}


	public function supprimerQuestion(){
		
		 	$data = json_decode(file_get_contents("php://input"));
   			$num=$data->id;
	
			
			$req=$this->$db->prepare('DELETE FROM'. TableName::question.'WHERE'.QuestionColumns::id.'=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			


	}

}

class Reponse {

	private $db;

	public function __construct()
	{	
			$this->db = new PDO('mysql:dbname='.dbNames::feedback.';host=127.0.0.1', 'root', '');
			$this->db->query('SET NAMES utf8');
		
	}

	public function ajouterReponse(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
			$descrip=$data->description;
			$point=$data->point;		

		
			
			$req=$this->$db->prepare('INSERT INTO'. TableName::reponse.'('.ReponseColumns::numQ.','.ReponseColumns::numR.','.ReponseColumns::description.','.ReponseColumns::point.') VALUES (:numQ,:numR,:descrip,:point)');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			$this->update();


	}

	public function modifierReponse(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
			$descrip=$data->description;
			$point=$data->point;		

		
			
			$req=$this->$db->prepare('UPDATE'. TableName::reponse.'SET'.ReponseColumns::description.'=:descrip,'.ReponseColumns::point.'=:point WHERE'.ReponseColumns::numQ.'=:numQ AND' .ReponseColumns::numR.'=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			


	}

	public function supprimerReponse(){
		
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
		
			
			$req=$this->$db->prepare('DELETE FROM'. TableName::reponse.'WHERE'.ReponseColumns::numQ.'=:numQ AND' .ReponseColumns::numR.'=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->execute();
			


	}

	public function seeReponse(){
		
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
		
			
			$req=$this->$db->prepare('SELECT * FROM'. TableName::reponse.'WHERE'.ReponseColumns::numQ.'=:numQ');
			$req->bindValue(':numQ',$numQ); 
			$req->execute();
			
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);


	}



}

	$route->run();
?>
			
