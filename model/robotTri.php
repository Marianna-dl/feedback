<?php
	require("Connexion.php");
	require_once("Users.php");
	require("../controller/classController.php");

class RobotTri extends Thread {
	private static $lastMessage;
	private $avance;
	private $question;
	private $usersList;
	
public function __construct(){
	$this->avance=true;
	$this->question=null;//peut etre stocker dans session la question actuelle
	$this->usersList=$users;
}

//Va chercher le contenu de la table messageBrute et le fait analyser (et ajouter si correct)
public function run(){
  // 	while($this->avance){
    
    //    echo "working";
    //}
	$bd = ConnectionFactory::getFactory()->getConnection();

	$temp=null;

	if(isset(self::$lastMessage)){
		$i=self::$lastMessage;
	}
	else{
		//Je mets la date actuelle (sous la forme "année-mois-jour heure:minute:seconde" dans $i
		$i=date("Y-m-j H:i:s");
	}
	//Récupèration de toutes les entrées dans la table des messages non traitées avant la date i
	$requete=request($bd,'SELECT * FROM messagebrute where date_entree<=\''.$i.'\'');
	
	while($temp=$requete->fetch(PDO::FETCH_ASSOC))
		//Traitement (analise et entrée dans la table des messages si ils sont conformes) les messages avant la date i
		analyse($temp);
	
	//Tant que l'on ne demande pas l'arrêt (avec la fonction stop(), on prends le contenu de la table messageBrute par intervalle de temps 
	while($this->avance){
		//L'intervalle de temps entre $i et $j ($i<$j)
		sleep(1);
		$j=date("Y-m-j H:i:s");
		$requete=request($bd,'SELECT * FROM messagebrute where date_entree>\''.$i.'\' and date_entree<=\''.$j.'\'');

		while($temp=$requete->fetch(PDO::FETCH_ASSOC)){
			analyse($temp);
		}
		//on décale $i à $j, et on décale $j plus loin au début de la prochaine boucle
		$i=$j;
		self::$lastMessage=$temp;
	}
}

//Pour stopper la boucle de la fonction check
public function stopper() {
    $this->synchronized(function($thread){
	   $thread->avance=false;
    }, $this);
}
//Analyse un tuple de la table messageBrute et le rajoute à la table Message si il est correcte
public function analyse($trame){
	$bd = ConnectionFactory::getFactory()->getConnection();
	 
	if(($this->question)==null){
		$requete=$bd->prepare('SELECT * FROM question');
		$requete->execute();
		$this->question='';
		
		//On rassemble tous les numeros de question dans une chaîne de caractères 
		while($temp=$requete->fetch(PDO::FETCH_ASSOC))
			$this->question.=$temp['num_quest'];
	}
	
	//On vérifie que le numéro de télephone est bon et que le numero de la question est bon
	if(preg_match('#^0[67][0-9]{8}$#',$trame['num_recu']) && preg_match('#^(['.$this->question.']{1}) *([a-zA-Z]+)$#',$trame['corps_mess'],$res)){

		$requete=request($bd,'SELECT * FROM reponse where num_question='.$res[1]);

		$nrep='';
		//On rassemble les numéros de réponse pour la question qui vient d'être vérifier
		while($temp=$requete->fetch(PDO::FETCH_ASSOC)){
			$nrep.=$temp['num_rep'];
		}

		if(preg_match('#(['.$nrep.'])*#',$res[2])){
			//On sépare les réponses données dans des cases de tableau (si l'utilisateur entre 2AB, on a [0]->'A',[1]->'B')
			$ajout=array_unique(str_split($res[2]));
			
			$mess='';
			foreach($ajout as $value_rep){ 
			//On vérifie que l'utilisateur n'a pas déjà rentré la valeur, et on la rentre
				$testprec=request($bd,'SELECT * FROM message where num_user=\''.$trame['num_recu'].'\' and num_question='.$res[1].' and num_reponse=\''.$value_rep.'\'');
				if(!$testprec->fetch(PDO::FETCH_ASSOC)){
					$mess=$mess.$value_rep;
				}
			}
			if($mess!=''){
				$userverif=$this->usersList->getUser($trame['num_recu']); 				
				if(!$userverif){
					$userverif= new User($trame['num_recu']);
					$this->usersList->addUser($trame['num_recu']);
				}
			
				$answ=$userverif->messages();
				$answ->addAnswer($res[1],$mess);
			}
		}
	}
    }
}
   /* $robot = new RobotTri();
    $robot->start();
    sleep(2);
    $robot->stopper();
    $robot->join();*/
?>
