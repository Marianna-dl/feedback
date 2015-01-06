<?php
// Classe qui contient toute les messages envoyés par l'utilisateur
class Messages
{	
	private $db;// encore un lien vers la BDD pour eviter les "new PDO" a chaque fois

	public function __construct()
	{	
        $this->db = ConnectionFactory::getFactory()->getConnection();
	}

	// Ajoute une reponse, question, num user dans la table message
    //ATTENTION! Il faut d'abord ajouter l'user dans la table user
	public function addAnswer($questionNumber, $reponse, $tel_user)
	{	
       $sql_query = 'INSERT INTO '.TableName::messages.'( '.MessageColumns::num_user.', '.MessageColumns::question. ', '.MessageColumns::reponses.', '.MessageColumns::date.') VALUES (:tel,:quest,:rep, CURRENT_TIME())';	
        
        try {	
            $req = $this->db->prepare($sql_query );
            $req->bindValue(":tel", $tel_user);
            $req->bindValue(":quest", $questionNumber);
            $req->bindValue(":rep", $reponse);
            $req->execute();
		}
		catch (PDOException $e)
		{	
            die('Connexion échouée : ' . $e->getMessage());	
        }
	}

    public function getMessages(){
        try {
            $sql_query = 'SELECT * FROM '.TableName::messages;
            $req = $this->db->prepare($sql_query);
            $req->execute();
            $messages  = $req->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $e) {
             die('Erreur: '. $e->getMessage());
        } 
        return $messages;        
    }

  public function nbVotantQuestion($quest){
        try{
            $sql_query ='SELECT COUNT(DISTINCT num_user) FROM '.TableName::messages.' where num_question=:quest';
            $req = $this->db->prepare($sql_query);
            $req->bindValue(":quest",$quest);
            $req->execute();
            $votants = $req->fetch(PDO::FETCH_NUM);
        }
          catch(PDOException $e) {
             die('Erreur: '. $e->getMessage());
        }       
    
        return $votants[0];
    }


// Fonction pour les statistiques////////////////////////////////////::::///////////////////
	public function statsAnswer($numQ, $numR)
	{	
  
        $sql_query = 'SELECT COUNT(DISTINCT num_user) FROM '.TableName::messages.' WHERE '.MessageColumns::question.'=:numQ AND '.MessageColumns::reponses.'=:numR';
        $sql_query2 = 'SELECT COUNT(DISTINCT num_user) FROM '.TableName::messages.' WHERE '.MessageColumns::question.'=:numQ';  
        try {	

            $req = $this->db->prepare($sql_query);
            $req->bindValue(":numQ", $numQ);
            $req->bindValue(":numR", $numR);
            $req->execute();
            $nbRep=$req->fetch(PDO::FETCH_NUM);
            
            $req = $this->db->prepare($sql_query2);
            $req->bindValue(":numQ", $numQ);
            $req->execute();
            $nbUsers=$req->fetch(PDO::FETCH_NUM);

	    $stat=($nbRep[0]*100)/$nbUsers[0];
		}
		catch (PDOException $e)
		{	
            die('Connexion échouée : ' . $e->getMessage());	
        }
	   return ($stat);
    }
}
?>
