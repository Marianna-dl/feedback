<?php

require_once("classUsers.php");

// on recupere la liste des utilisateurs
$users = new Users();


afficherRepUSer($users, '0646763234', 1);
add($users, '0646763234', 1, 'AC');
afficherRepUSer($users, '0646763234', 1);


// affiche en HTML la liste des réponses d'un utilisateur a la question demandé
function afficherRepUSer($users, $user, $question)
{
	$userp = $users->getUSer($user);
	if($userp!=false) // si pas faux, alors le user existe
	{
		$mess = $userp->messages();
		$reps = $mess->answerToQuestion($question);
		echo '<p>['.$user.'] '.$question.' : ';
		if($reps!=false) // si pas faux, alors il a repondu à la question
			foreach($reps as $key => $rep) 
				echo $rep . ' ';
		
		else echo 'Aucune réponse donné à cette question';
		echo '</p>';
	}
	echo '<p>['.$user.'] n\'existe pas sur la BDD</p>';
	
}

// ajoute/update une réponse de l'utilisateur à une question.
function add($users, $user, $q, $a)
{
	$messages = $users->getUSer($user)->messages();
	$messages->addAnswer($q, $a);
}

?>