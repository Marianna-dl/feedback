<?php
require('connexion.php'); // Fichier a creer pour votre propre bdd
?>



<?php
// MODIF EN COURS : ROBOT SOUS FORME THREAD
class RobotThread extends Thread {
	private $num;
	private $rep;
    private $pause;
	
	public function __construct(){
		$this->num = "";
		$this->rep = "";
        $this->pause=true;
	}
	
    
    public function run(){
                    echo 'ok1';
        

        $this->synchronized(function($robot){
            while(!$robot->pause){   
                $num =$robot->genererNum();
	            $rep=$robot->genererRep();
	            $robot->insererMes($num,$rep); 
                sleep(2);
            }
        }, $this);
     
       /* while(!$this->pause){
            $num =$this->genererNum();
	       $rep=$this->genererRep();
	       $this->insererMes($num,$rep);   
            echo 'ok';
        sleep(2);
        }*/
    }
    
    public function unpause(){
  
        $this->synchronized(function($robot){
            echo 'ok2';
            $robot->pause=false;
            $robot->notify();
        }, $this);  
    }
    
    public function pause(){
        $this->pause=true;
    }
    
	public function genererNum(){
		// Fonction qui genere un numero de portable aleatoirement
		
		$alea = mt_rand(0,1);
		// Genere un boolean qui determinera le prefixe du numero (06 ou 07)
		//num="";
		
		if($alea){
			// Boolean est a true on affecte 06 au prefixe
			$this->num='06';
		}
		else{
			// Boolean est a false on affecte 07 au prefixe
			$this->num='07';
		}
		
		// Genere un nombre a 8 chiffre qui correspond a la fin du numero 
		$this->num=$this->num.mt_rand(10000000,99999999);
		
		return $this->num;
	}

 	public function genererRep(){
		$bd = ConnectionFactory::getFactory()->getConnection();
		
		$num_QAlea=""; // Numero de la question aleatoire
		$numRAlea=""; // Numero de la reponse aleatoire generé en fonction de la question
		
		try{
			$req=$bd->prepare('SELECT MAX(num_quest) from question'); // On le selectionne le maximum du nombre de questions
			$req->execute();
			
			$res = $req->fetch(PDO::FETCH_NUM);
			$numMAX_q = $res[0]; // On recupere le nombre max de question
			$num_QAlea = mt_rand(1,$numMAX_q); // On genere un nombre entre 1 et le maximum du nombre de questions

			$requete=$bd->prepare('SELECT * FROM reponse where num_question=:numQ');
			$requete->bindValue(':numQ', $num_QAlea);
			$requete->execute();
			$nrep='';
			
			// On rassemble les numéros de réponse pour la question qui vient d'être sélectionné
			while($temp=$requete->fetch(PDO::FETCH_ASSOC))
			{
				$nrep.=$temp['num_rep'];
			}
			$ajout=str_split($nrep);
			
			$numMAX_rep = count($ajout); // On recupere le nombre Max de reponse
			$rAlea=mt_rand(0,$numMAX_rep-1); // On genere un nombre entre 1 et le maximum du nombre de reponse
			$num_RAlea=$ajout[$rAlea];
			
			$this->rep = $num_QAlea.$num_RAlea; // On concatene le Numero de la Question et le numero de la reponse
			
			return $this->rep;
		}
		
		catch(PDOException $e){
			die('<p>Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
		}
	}
	
 
	function insererMes($num,$mes){
		$bd = ConnectionFactory::getFactory()->getConnection();
		
		try{
			$req=$bd->prepare("SELECT * from messagebrute where num_recu=:num and corps_mess =:mes"); // On cherche si le numero et le message sont deja dans la table
			$req->bindValue(':num', $num);
			$req->bindValue(':mes', $mes);
			$req->execute();
			
			$res = $req->fetch(PDO::FETCH_NUM);
			
			if($res[0]==""){ // Si le resultat est vide, le message et le numero ne sont pas dans la table donc on les insert. On ne fait rien sinon.
				$req=$bd->prepare("INSERT INTO `messagebrute` (`num_recu`,`corps_mess`,`date_entree`) VALUES (:num, :mes, NOW())");
				$req->bindValue(':num', $num);
				$req->bindValue(':mes', $mes);
				$req->execute();
				
				echo '<br/> Message inserer';
			}
			else{
				echo '<br/> Doublon message';
			}
		}
		
		catch(PDOException $e){
			die('<p>Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
		}
		
	}
 } 
 ?>


<?php
//Partie TEST
/*	$robot= new RobotThread();
    $robot->start();
    $robot->unpause();
    sleep(5);
    $robot->pause();
    sleep(5);
    $robot->unpause();
    sleep(5);
    $robot->pause();*/
?>
