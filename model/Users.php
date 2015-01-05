<?php
///
/// Classe qui va contenir toutes les méthodes pour la classe user.
///
class Users 
{	// on garde la BDD en parametre pour eviter de faire une "new PDO" a chaque fois
	private static $db;
	// constructeur
	public function __construct()
	{
        self::$db = ConnectionFactory::getFactory()->getConnection();

	}
    
	// Ajoute un utilsateur a la BDD
	public function addUser($phone)
	{	try
		{	$sql_query = 'INSERT INTO '.TableName::users.' ('.UserColumns::phoneNumber.') VALUES (:tel)';
            $req = self::$db->prepare($sql_query );
            $req->bindValue(":tel", $phone);
            $req->execute();
		}
		catch (PDOException $e)
		{	
            die('Connexion échouée : ' . $e->getMessage());	
        }
	}
    
    //Retourne la liste des utilisateurs
    public function getUsers()
    {	
        try {
            $sql_query = 'SELECT * FROM '.TableName::users;
            $req = self::$db->prepare($sql_query);
            $req->execute();
            $users = $req->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $e) {
             die('Erreur: '. $e->getMessage());
        } 
        return $users;
	}
    
    public function getNombreUsers(){
        
        try
		{	$sql_query = 'SELECT COUNT(*) FROM '.TableName::users;
            $req = self::$db->prepare($sql_query);
            $req->execute();
            $nbUsers=$req->fetchAll(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{	
            die('Connexion échouée : ' . $e->getMessage());	
        }    
        
        return nbUsers;
    }

    //Récupère les messages d'un User
    public function getMessagesByUser($tel){     
        try{
            $sql_query ='SELECT * FROM '.TableName::messages.'WHERE '.MessageColumns::num_user.'= :tel'; 
            $req=self::$db->prepare($sql_query);
            $req->bindValue(":tel", $tel);
            $req->execute();
            $userMessages=$req->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $e){
              die('Erreur: '. $e->getMessage());       
        }
           return $userMessages; 
    }
}


?>
