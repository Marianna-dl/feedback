<?php
require('connexion.php'); // Fichier a creer pour votre propre bdd
?>



<?php
// MODIF EN COURS : ROBOT SOUS FORME THREAD
class RobotThread extends Thread {
	private $num;
	private $rep;
	
	public function __construct(){
		$this->num = "";
		$this->rep = "";
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
	
 
	public function run(){
		$bd = ConnectionFactory::getFactory()->getConnection();
		
		$num = $this->genererNum(); // Genere un numero
		$mes = $this->genererRep(); // Genere une réponse
		
		$erreur= mt_rand(0,9); 
		$erreur=((($erreur - 9)*-1)/9)*100; // Calcul un pourcentage d'erreur
		
		try{
			
			if($erreur <= 15){ // Le pourcentage d'erreur doit etre inferieur ou egale a 15% pour genere un message incorrecte
				$numAlea= mt_rand(0,30);
				$chara = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$mesAlea = mt_rand(0,25);
				$mes = $numAlea.substr($chara,$mesAlea,1);
			}
				
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
					
				echo 'Numero : '.$num ;
				echo '<br/> Reponse envoye : '.$mes ;
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
$robot= new RobotThread();
$robot->run();
	
?>
