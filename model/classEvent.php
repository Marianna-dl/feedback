<?php

class Event {

	private $db;

	public function __construct()
	{	
			$this->db = ConnectionFactory::getFactory()->getConnection();
		
	}

	
	public function startEvent(){
		try {
    			echo "<script>alert('Début de l\'évènement')</script>"; 
    			return true;
		}
		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}
	}

	
	public function stopEvent(){
		try {
  			$_SESSION=array();
    			session_destroy();
    			echo "<script>alert('Fin de l\'évènement.')</script>";
    		    }

		catch (PDOException $e)
		{	
           		 die('Connexion échouée : ' . $e->getMessage());	
        	}

   		return 0; 

	}

?>
