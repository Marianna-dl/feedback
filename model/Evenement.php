<?php

class Evenement{

	private $db;

    public function __construct()
	{	
        $this->db = ConnectionFactory::getFactory()->getConnection();
	}

    public function startEvent(){
        $_SESSION['alive']=true;
        $_SESSION['currentQuestion']=1;
        return $_SESSION['alive'];
       // echo json_encode($_SESSION['alive']);
    }    
    
     public function setCurrentQuestion($i){
        $_SESSION['currentQuestion']=$i;

    }  
    
   public function getCurrentQuestion(){
     if (isset($_SESSION['currentQuestion'])){
        return $_SESSION['currentQuestion'];
     }
       return "erreur";  
    }  
    
   public function stopEvent(){
     if (isset($_SESSION['alive'])){ 
         $_SESSION['alive']=false;
         $_SESSION['currentQuestion']=1;
     }
        return $_SESSION['alive'];
    //    echo json_encode($_SESSION['alive']);
    }
    
   public function getStateEvent(){
        if (isset($_SESSION['alive']) && $_SESSION['alive']==true){
            return true;
        }
            return false;     
    }

}

?>