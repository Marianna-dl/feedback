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
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM Question');

			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			return (json_encode($tab));
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}



	function seeOneQuestion($num){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM Question WHERE num_Quest=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			return (json_encode($tab));
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}



	function ajouterQuestion($num,$type,$enonce){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('INSERT INTO Question (num_Quest, type_Quest, enonce) VALUES (:num,:type,:enonce)');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
		
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}



	function modifierQuestion($num,$type,$enonce){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('UPDATE Question SET type_Quest=:type, enonce=:enonce WHERE num_Quest=:num');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}


	function supprimerQuestion($num){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('DELETE FROM Question WHERE num_Quest=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}


	function ajouterReponse($numQ,$numR,$descrip,$point){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('INSERT INTO Reponse (num_Question,num_Rep,description,point) VALUES (:numQ,:numR,:descrip,:point)');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
		
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}

	function modifierReponse($numQ,$numR,$descrip,$point){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('UPDATE Reponse SET description=:descrip, point=:point WHERE num_Question=:numQ AND num_Rep=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}

	function supprimerReponse($numQ,$numR){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('DELETE FROM Reponse WHERE num_Question=:numQ AND num_Rep=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->execute();
			
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}

	function seeReponse($numQ){
		

		try{
			$db = ConnectionFactory::getFactory()->getConnection();
			$req=$db->prepare('SELECT * FROM Reponse WHERE num_Question=:numQ');
			$req->bindValue(':numQ',$numQ); 
			$req->execute();
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			return (json_encode($tab));
		}

		catch(PDOException $e){
			die('<p> La connexion a échoué </p>');

		}

	}

	$route->run();
?>
			
