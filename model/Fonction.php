<?php 

	require ('connexion.php');

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



	function seeAllQuestion(){
		
		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM question');

			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);

	}



	function seeOneQuestion(){
		
			$data = json_decode(file_get_contents("php://input"));
    			$num=$data->id;
		

		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM question WHERE num_quest=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);


	}



	function ajouterQuestion(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$enonce = $data->enonce;
   			$num=$data->id;
			$type=$data->type;

		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('INSERT INTO question (num_quest, type_quest, enonce) VALUES (:num,:type,:enonce)');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
		


	}



	function modifierQuestion(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$enonce = $data->enonce;
   			$num=$data->id;
			$type=$data->type;

		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('UPDATE question SET type_quest=:type, enonce=:enonce WHERE num_quest=:num');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			


	}


	function supprimerQuestion(){
		
		 	$data = json_decode(file_get_contents("php://input"));
   			$num=$data->id;
	
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('DELETE FROM question WHERE num_quest=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			


	}


	function ajouterReponse(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
			$descrip=$data->description;
			$point=$data->point;		

		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('INSERT INTO reponse (num_question,num_rep,description,point) VALUES (:numQ,:numR,:descrip,:point)');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
		


	}

	function modifierReponse(){
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
			$descrip=$data->description;
			$point=$data->point;		

		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('UPDATE reponse SET description=:descrip, point=:point WHERE num_question=:numQ AND num_rep=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			


	}

	function supprimerReponse(){
		
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
   			$numR=$data->numRep;
		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('DELETE FROM reponse WHERE num_question=:numQ AND num_rep=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->execute();
			


	}

	function seeReponse(){
		
		 	$data = json_decode(file_get_contents("php://input"));
    			$numQ = $data->numQuest;
		
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM reponse WHERE num_question=:numQ');
			$req->bindValue(':numQ',$numQ); 
			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);


	}

	$route->run();
?>
			
