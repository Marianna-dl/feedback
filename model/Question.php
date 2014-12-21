<?php 

class Question {

	private $db;

	public function __construct()
	{	
			$this->db = ConnectionFactory::getFactory()->getConnection();
		
	}

	public function seeAllQuestion(){
		
		try
		{
			
			$req = 'SELECT * FROM ' . TableName::question;
			$res = $this->db->query($req);
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);
		}

		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}

	}



	public function seeOneQuestion($num){
		
		
		try
			{
		
			
			$req = 'SELECT * FROM ' . TableName::question.'WHERE'.QuestionColumns::id.'=:num';
			$req->bindValue(':num',$num); 
			$res = $this->db->query($req);
			$tab=$req->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($tab);
			}

		catch (PDOException $e)
			{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        		}


	}



	public function ajouterQuestion($enonce,$num,$type){
		try
			{
			
			$req=$this->$db->prepare('INSERT INTO '. TableName::question. '('.QuestionColumns::id.','.QuestionColumns::type.',' .QuestionColumns::enonce.') VALUES (:num,:type,:enonce)');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			}

		catch (PDOException $e)
			{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        		}


	}



	public function modifierQuestion($enonce,$num,$type){

		try
			{
			$req=$this->$db->prepare('UPDATE'. TableName::question.' SET '.QuestionColumns::type.'=:type,' .QuestionColumns::enonce.'=:enonce WHERE'.QuestionColumns::id.'=:num');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
			}

		catch (PDOException $e)
			{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        		}
			


	}


	public function supprimerQuestion($num){
		try 	{
			$req=$this->$db->prepare('DELETE FROM'. TableName::question.'WHERE'.QuestionColumns::id.'=:num');
			$req->bindValue(':num',$num); 
			$req->execute();
			}
		catch (PDOException $e)
			{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        		}


	}

}

?>