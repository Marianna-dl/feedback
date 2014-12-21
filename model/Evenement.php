<?php

class Evenement{

	private $db;

    public function __construct()
	{	
        $this->db = ConnectionFactory::getFactory()->getConnection();
	}

    
    function startEvent(){
        $_SESSION['alive']=true;
        return $_SESSION['alive'];
       // echo json_encode($_SESSION['alive']);
    }    
    
    
    function stopEvent(){
     if (isset($_SESSION['alive'])){ 
         $_SESSION['alive']=false;
     }
        return $_SESSION['alive'];
    //    echo json_encode($_SESSION['alive']);
    }
    
    function getStateEvent(){
        if (isset($_SESSION['alive']) && $_SESSION['alive']==true){
            return true;
        }
            return false;     
    }

}

?>