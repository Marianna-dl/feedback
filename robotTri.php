<?php

	require("connexion.php");

	$avance=true;	

//Va chercher le contenu de la table messageBrute et le fait analyser (et ajouter si correct)
function check(){
  $bd = ConnectionFactory::getFactory()->getConnection();
	global $avance;

	//Je mets la date actuelle (sous la forme "année-mois-jour heure:minute:seconde" dans $i
	$i=date("Y-m-j H:i:s");
	
	//Récupèration de toutes les entrées dans la table des messages non traitées avant la date i
	$requete=$bd->prepare('SELECT * FROM messagebrute where date_entree<=\''.$i.'\'');
	$requete->execute();
	while($temp=$requete->fetch(PDO::FETCH_ASSOC))
		//Traitement (analise et entrée dans la table des messages si ils sont conformes) les messages avant la date i
		analyse($temp);
	
	//Tant que l'on ne demande pas l'arrêt (avec la fonction stop(), on prends le contenu de la table messageBrute par intervalle de temps 
	while($avance){
		//L'intervalle de temps entre $i et $j ($i<$j)
		sleep(1);
		$j=date("Y-m-j H:i:s");
		$requete=$bd->prepare('SELECT * FROM messagebrute where date_entree>\''.$i.'\' and date_entree<=\''.$j.'\'');
		$requete->execute();
		while($temp=$requete->fetch(PDO::FETCH_ASSOC)){
			analyse($temp);
		}
		//on décale $i à $j, et on décale $j plus loin au début de la prochaine boucle
		$i=$j;

	}
}

//Pour stopper la boucle de la fonction check
function stop(){
	global $avance;
	$avance=false;
}

//Analyse un tuple de la table messageBrute et le rajoute à la table Message si il est correcte
function analyse($trame){
	 $bd = ConnectionFactory::getFactory()->getConnection();

	$requete=$bd->prepare('SELECT * FROM question');
	$requete->execute();
	$nquest='';
	
	//On rassemble tous les numeros de question dans une chaîne de caractères 
	while($temp=$requete->fetch(PDO::FETCH_ASSOC))
		$nquest.=$temp['num_Quest'];
		
	
	//On vérifie que le numéro de télephone est bon et que le numero de la question est bon
	if(preg_match('#^0[67][0-9]{8}$#',$trame['num_recu']) && preg_match('#^(['.$nquest.']{1}) *([a-zA-Z]+)$#',$trame['corps_mess'],$res)){

		$requete=$bd->prepare('SELECT * FROM reponse where num_Question='.$res[1]);
		$requete->execute();
		$nrep='';
		//On rassemble les numéros de réponse pour la question qui vient d'être vérifier
		while($temp=$requete->fetch(PDO::FETCH_ASSOC))
			$nrep.=$temp['num_Rep'];

		if(preg_match('#(['.$nrep.'])*#',$res[2])){
			//On sépare les réponses données dans des cases de tableau (si l'utilisateur entre 2AB, on a [0]->'A',[1]->'B')
			$ajout=str_split($res[2]);				
				
			foreach($ajout as $value_rep){ 
			//On vérifie que l'utilisateur n'a pas déjà rentré la valeur, et on la rentre
				$testprec=$bd->prepare('SELECT * FROM message where num_user=\''.$trame['num_recu'].'\' and num_Question='.$res[1].' and num_Reponse=\''.$value_rep.'\'');
				$testprec->execute();
					
				if(!$testprec->fetch(PDO::FETCH_ASSOC)){
					$requete=$bd->prepare('insert into message values (DEFAULT,:num_user,:num_Question,:num_Reponse,NOW())');
					$requete->bindValue(':num_user',$trame['num_recu']);
					$requete->bindValue(':num_Question',$res[1]);
					$requete->bindValue(':num_Reponse',$value_rep);
					$requete->execute();
				}
				$userverif=$bd->prepare('SELECT * FROM user where num_tel=\''.$trame['num_recu'].'\'');
				$userverif->execute();
				if(!$userverif->fetch(PDO::FETCH_ASSOC)){
					$requete=$bd->prepare('insert into user values ('.$trame['num_recu'].')');
					$requete->execute();
				}
			}
		}
	}
}?>
