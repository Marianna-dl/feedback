<?php
	require_once("Connexion.php");

class robotTri extends Thread {
	private $avance;
	private static $lastMessage;
	
public function __construct(){
	$this->avance=true;
}

//Va chercher le contenu de la table messageBrute et le fait analyser (et ajouter si correct)
public function run(){
	$bd = ConnectionFactory::getFactory()->getConnection();
	
	//Je mets la date actuelle (sous la forme "année-mois-jour heure:minute:seconde" dans $i
	$i=date("Y-m-j H:i:s");
	if(isset(self::$lastMessage)){
		$i=self::$lastMessage['date_entree'];
	}

	$temp=null;
	//Récupèration de toutes les entrées dans la table des messages non traitées avant la date i
	$requete=$bd->prepare('SELECT * FROM messagebrute where date_entree<=\''.$i.'\'');
	$requete->execute();
	while($temp=$requete->fetch(PDO::FETCH_ASSOC))
		//Traitement (analise et entrée dans la table des messages si ils sont conformes) les messages avant la date i
		$this->analyse($temp);
	
	//Tant que l'on ne demande pas l'arrêt (avec la fonction stop(), on prends le contenu de la table messageBrute par intervalle de temps 
	while($this->avance){
		//L'intervalle de temps entre $i et $j ($i<$j)

		$j=date("Y-m-j H:i:s");
		$requete=$bd->prepare('SELECT * FROM messagebrute where date_entree>\''.$i.'\' and date_entree<=\''.$j.'\'');
		$requete->execute();
		while($temp=$requete->fetch(PDO::FETCH_ASSOC)){
			$this->analyse($temp);
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

	$requete=$bd->prepare('SELECT * FROM question');
	$requete->execute();
	$nquest='';
	
	//On rassemble tous les numeros de question dans une chaîne de caractères 
	while($temp=$requete->fetch(PDO::FETCH_ASSOC))
		$nquest.=$temp['num_quest'];
		
	//On vérifie que le numéro de télephone est bon et que le numero de la question est bon
	if(preg_match('#^0[67][0-9]{8}$#',$trame['num_recu']) && preg_match('#^(['.$nquest.']{1}) *([a-zA-Z]+)$#',$trame['corps_mess'],$res)){
		$requete=$bd->prepare('SELECT * FROM reponse where num_question='.$res[1]);
		$requete->execute();
		$nrep='';
		//On rassemble les numéros de réponse pour la question qui vient d'être vérifier
		while($temp=$requete->fetch(PDO::FETCH_ASSOC))
			$nrep.=$temp['num_rep'];
		if(preg_match('#(['.$nrep.'])*#',$res[2])){
			//On sépare les réponses données dans des cases de tableau (si l'utilisateur entre 2AB, on a [0]->'A',[1]->'B')
			$ajout=str_split($res[2]);				
			foreach($ajout as $value_rep){ 
			//On vérifie que l'utilisateur n'a pas déjà rentré la valeur, et on la rentre
				$testprec=$bd->prepare('SELECT * FROM message where num_user=\''.$trame['num_recu'].'\' and num_question='.$res[1].' and num_reponse=\''.$value_rep.'\'');
				$testprec->execute();
				if(!$testprec->fetch(PDO::FETCH_ASSOC)){
					$userverif=$bd->prepare('SELECT * FROM user where num_tel=\''.$trame['num_recu'].'\'');
					$userverif->execute();
					if(!$userverif->fetch(PDO::FETCH_ASSOC)){
						$requete=$bd->prepare('insert into user values (\''.$trame['num_recu'].'\')');
						$requete->execute();
					}
					$requete=$bd->prepare('insert into message values (DEFAULT,\''.$trame['num_recu'].'\','.$res[1].',\''.$value_rep.'\',NOW())');
					$requete->execute();
				}

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
