<?php
require('connexion.php'); // Fichier a creer pour votre propre bdd
?>


<?php

function genererNum(){
	// Fonction qui genere un numero de portable aleatoirement
	
	$alea = mt_rand(0,1);
	// Genere un boolean qui determinera le prefixe du numero (06 ou 07)
	$num="";
	
	if($alea){
		// Boolean est a true on affecte 06 au prefixe
		$num='06';
	}
	else{
		// Boolean est a false on affecte 07 au prefixe
		$num='07';
	}
	
	$fin_num = mt_rand(10000000,99999999);
	// Genere un nombre a 8 chiffre qui correspond a la fin du numero 
	$num=$num.$fin_num;

	return $num;
}

function genererRep(){
	global $bd;
	
	$num_QAlea=""; // Numero de la question aleatoire
	$numRAlea=""; // Numero de la reponse aleatoire generé en fonction de la question
	
	$req1=$bd->prepare('SELECT MAX(num_Quest) from question'); // On le selectionne le maximum du nombre de questions
	$req1->execute();
	
	$res = $req1->fetch(PDO::FETCH_NUM);
	$numMAX_q = $res[0]; // On recupere le nombre max de question
	$num_QAlea = mt_rand(1,$numMAX_q); // On genere un nombre entre 1 et le maximum du nombre de questions

	
	$req2=$bd->prepare('SELECT MAX(num_rep) from reponse where num_Question= :numQ'); // On selectionne le maximum du nombre de reponse en fonction de la question
	$req2->bindValue(':numQ', $num_QAlea, PDO::PARAM_INT);
    $req2->execute();
	
	$res = $req2->fetch(PDO::FETCH_NUM);
	$numMAX_rep = $res[0]; // On recupere le nombre Max de reponse
	$num_RAlea=mt_rand(1,$numMAX_rep); // On genere un nombre entre 1 et le maximum du nombre de reponse
	
	$rep = $num_QAlea.$num_RAlea; // On concatene le Numero de la Question et le numero de la reponse

	return $rep;
}

// FONCTION POUR AJOUTER LE NUMERO ET LA REPONSE A LA BDD
?>


<?php
// Partie TEST
	$test=genererNum();
	echo $test.'<br/>';
	$test2=genererRep();
	echo $test2;	
?>
