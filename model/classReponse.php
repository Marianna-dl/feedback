<?php 
class Reponse {

	private $db;

	public function __construct()
	{	
		$this->db = ConnectionFactory::getFactory()->getConnection();
		
	}

	public function ajouterReponse($numQ,$numR,$descrip,$point){

		try {
			$req=$this->$db->prepare('INSERT INTO'. TableName::reponse.'('.ReponseColumns::numQ.','.ReponseColumns::numR.','.ReponseColumns::description.','.ReponseColumns::point.') VALUES (:numQ,:numR,:descrip,:point)');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			$this->update();
		}
		
		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}


	}

	public function modifierReponse($numQ,$numR,$descrip,$point){
		try {
			$req=$this->$db->prepare('UPDATE'. TableName::reponse.'SET'.ReponseColumns::description.'=:descrip,'.ReponseColumns::point.'=:point WHERE'.ReponseColumns::numQ.'=:numQ AND' .ReponseColumns::numR.'=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->bindValue(':descrip',$descrip);
			$req->bindValue(':point',$point);
			$req->execute();
			}
		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}


	}

	public function supprimerReponse($numQ,$numR){
		try {
			$req=$this->$db->prepare('DELETE FROM'. TableName::reponse.'WHERE'.ReponseColumns::numQ.'=:numQ AND' .ReponseColumns::numR.'=:numR');
			$req->bindValue(':numQ',$numQ); 
			$req->bindValue(':numR',$numR); 
			$req->execute();
			}

		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}


	}

	public function seeReponse($numQ){
		try {
			$req=$this->$db->prepare('SELECT * FROM'. TableName::reponse.'WHERE'.ReponseColumns::numQ.'=:numQ');
			$req->bindValue(':numQ',$numQ); 
			$req->execute();
			
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);
			}

		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}


	}



}

?>
