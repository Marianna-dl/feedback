<?php 

class Question {

	private $db;

	public function __construct()
	{	
			$this->db = ConnectionFactory::getFactory()->getConnection();
	}

	public function getListeQuestions(){
		try
		{
			$req = 'SELECT * FROM ' . TableName::question;
			$res = $this->db->prepare($req);
            $res->execute();
			$tab=$res->fetchAll(PDO::FETCH_OBJ); 
			return $tab;
		}
		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        }

	}
    public function getNombreQuestions(){
        try{
            $req=$this->db->prepare('SELECT COUNT(*) FROM '.TableName::question);
            $req->execute();
            $reponse=$req->fetch(PDO::FETCH_NUM);
            echo $reponse[0];
        }
        catch(PDOException $e){
            die("Erreur ".$e->getMessage()."</body></html>");
        }

    }
    
	public function getQuestion($num){
		try{
			$req = 'SELECT * FROM ' . TableName::question.'WHERE'.QuestionColumns::num.'=:num';
			$req->bindValue(':num',$num); 
			$res = $this->db->query($req);
			$tab=$req->fetchAll(PDO::FETCH_OBJ); 
			return $tab;
        }
		catch (PDOException $e)
        {	
           		 die('Connexion échouée : ' . $e->getMessage());	
        }
	}



	public function ajouterQuestion($enonce,$num,$type){
		try{
			$req=$this->db->prepare('INSERT INTO '. TableName::question. '('.QuestionColumns::num.','.QuestionColumns::type.',' .QuestionColumns::enonce.') VALUES (:num,:type,:enonce)');
			$req->bindValue(':num',$num); 
			$req->bindValue(':type',$type); 
			$req->bindValue(':enonce',$enonce);
			$req->execute();
        }
		catch (PDOException $e)
        {	
            header('HTTP/1.1 500 Internal Server Error : '.$e->getMessage() );
            exit(0);	
        }
	}

	public function modifierQuestion($enonce,$num,$type){
		try{
			$req=$this->db->prepare('UPDATE'. TableName::question.' SET '.QuestionColumns::type.'=:type,' .QuestionColumns::enonce.'=:enonce WHERE'.QuestionColumns::id_quest.'=:num');
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
		try {
			$req=$this->db->prepare('DELETE FROM'. TableName::question.'WHERE'.QuestionColumns::num.'=:num');
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
