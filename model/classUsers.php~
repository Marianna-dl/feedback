<?php

///
/// les classes abstraites ne sont pas nécéssaire, mais sont plus pratique si on veut modifier
/// les noms des bases de données ou des tables. il suffit juste de modifier le nom dans les
/// classes abstraites
///
abstract class dbNames
{
	const feedback 	= 'feedback';
}
abstract class TableName
{
	const users    	= 'user';
	const messages 	= 'message';
}
abstract class UserColumns
{
	const phoneNumber	= 'num_tel';
}
abstract class MessageColumns
{
	const id		= 'id_mess';
	const ref		= 'num_user';
	const question	= 'num_question';
	const reponses	= 'num_reponse';
	const date		= 'date_recu';
}


///
/// Classe qui va contenir tout la liste des utilisateurs. (regarder index.php pour des)
///
class Users
{	// on garde la BDD en parametre pour eviter de faire une "new PDO" a chaque fois
	private $db;
	// contient la liste des utilisateurs
	private $listUsers;
	// constructeur
	public function __construct()
	{	$this->listUsers = array(); // on pense a initialiser la liste
		try
		{	$this->db = new PDO('mysql:dbname='.dbNames::feedback.';host=127.0.0.1', 'root', '');
			$req = 'SELECT * FROM ' . TableName::users; // equivaut a 'SELECT * FROM user'
			$res = $this->db->query($req); // on lance la requete
			while($data = $res->fetch()) // on while-fetch le resultat pour pour creer toute les instances utilisateurs
			{	$this->listUsers[] = new User( $data[UserColumns::phoneNumber] );	}
		}
		catch (PDOException $e)
		{	echo 'Connexion échouée : ' . $e->getMessage();	}
	}

	// on ajoute un utilsateur a la BDD
	public function addUser($phone)
	{	try
		{	$req = 'INSERT INTO '. TableName::users .' ('.UserColumns::phoneNumber.') VALUES (\''.$phone.'\')';
			$res = $this->db->query($req);
			$this->update(); // methode instancié plus bas. Elle est importante pour remettre à jour la classe depuis la BDD
		}
		catch (PDOException $e)
		{	echo 'Connexion échouée : ' . $e->getMessage();	}
	}

	// recuperer un utilisateur depuis son numero de telephone (Return : User si existant, false sinon)
	public function getUser($phone)
	{	foreach ($this->listUsers as $k => $v) 
		{	if($v->phoneNumber()==$phone)
				return $v;
		}
		return false;
	}

	// on recharge la liste des Utilisateurs à chaque fois qu'il y a eu une modification.
	private function update()
	{	$this->listUsers = array();
		try
		{	$req = 'SELECT * FROM ' . TableName::users;
			$res = $this->db->query($req);
			while($data = $res->fetch())
				$this->listUsers[] = new User( $data[UserColumns::phoneNumber] );
		}
		catch (PDOException $e)
		{
			echo 'Connexion échouée : ' . $e->getMessage();
		}
	}

	// fonction ToString de Java. utilisé pour le debug
	public function ts()
	{	$s = '';
		foreach ($this->listUsers as $k => $user) 
		{
			$s = $s . $user->ts();
		}
		return $s;
	}
}

/// classe qui contient toute les données d'un Utilisateur
class User
{
	private $phoneNumber; // le numero de telephone de l'utilisateur
	private $messages; // une classe qui va contenir tout les messages envoyés.

	// constructeur
	public function __construct($pn)
	{	$this->phoneNumber = $pn;
		$this->messages = new UserAnswers($pn); // on instancie la classe en précisant le numéro pour la lecture de la BDD
	}
	
	// getter
	public function phoneNumber()
	{	return $this->phoneNumber;	}
	public function messages()
	{	return $this->messages;	}

	// ToString
	public function ts()
	{	$s = '<p>Phone Number : ' . $this->phoneNumber . '<br />' . $this->messages->ts(); '</p>';
		return $s;
	}
}

// Classe qui contient toute les messages envoyés par l'utilisateur
class UserAnswers
{	
	private $db; // encore un lien vers la BDD pour eviter les "new PDO" a chaque fois

	private $pn; // on garde le telephone pour des requetes plus tard.
	private $list; // liste des réponse de l'utilisateur


	/// CONSTRUCTEUR
	public function __construct($phoneNumber)
	{	$this->db = new PDO('mysql:dbname='.dbNames::feedback.';host=127.0.0.1', 'root', '');
		$this->pn=$phoneNumber;
		$this->list = array();
		/// on récupère toute les données nécéssaires pour instancier la liste des réponses
		$req =  'SELECT '.UserColumns::phoneNumber.', '.MessageColumns::date.', '.MessageColumns::question.', '.MessageColumns::reponses.
				' FROM '.TableName::messages.
				' INNER JOIN '. TableName::users .' ON '. TableName::users .'.'.UserColumns::phoneNumber.' = '. TableName::messages .'.'.MessageColumns::ref.' '.
				' WHERE '. TableName::users .'.'.UserColumns::phoneNumber.' =\'' . $phoneNumber . '\'';
		try
		{	$res = $this->db->query($req);

			while($data = $res->fetch()) // on while-fetch pour creer toute les instances de réponses
				$this->list[] = new Answer($data); // $data contient les données de réponses
		}
		catch (PDOException $e)
		{	echo 'Connexion échouée : ' . $e->getMessage();	}
	}

	/// getter qui retourne l'array des reponses [array('A', 'C') si user a repondu 'AC' à la question] à la question demandé, false si il n'a pas  repondu
	public function answerToQuestion($questionNumber)
	{	foreach ($this->list as $key => $answer) 
		{	if($answer->question() == $questionNumber)
				return $answer->reponses();
		}
		return false;
	}

	// ajoute une réponse à la question donné
	public function addAnswer($questionNumber, $reponses)
	{	
		try
		{	///
			///	TODO : VERIFIER SI LES REPONSES SAISIES SONT VALIDE
			///

			// $reponses est soit un array('A', 'C'), soit un string, sinon on leve une erreur.
			// ensuite si array alors je change en chaine de caractères
			$valueToAdd = '';
			if(gettype($reponses)=='array')
			{	foreach ($reponses as $key => $rep)
					$valueToAdd = $valueToAdd . $rep;
			}
			elseif(gettype($reponses)=='string') 
			{	$valueToAdd = $valueToAdd . $reponses;	}
			else
				echo '<h3> ERREUR[class.php UserAnswers.addAnswer] : $reponses n\'est pas de type valide ('. gettype($reponses) .').</h3>';

			/// tester si answer existe deja, pour savoir si je dois mettre a jour, ou creer une nouvelle reponse sur la BDD
			$req = 'SELECT * FROM ' . TableName::messages .' WHERE '.MessageColumns::ref.'=\''.$this->pn.'\' AND '.MessageColumns::question.'='.$questionNumber.' ';
			$res = $this->db->query($req);
			$reponseAlreadyExist = false;
			while($data = $res->fetch()) // si ca fetch, alors c'est que la réponse existe deja.
				$reponseAlreadyExist = true;


			if($reponseAlreadyExist==false) // si la reponse existe pas, on ajoute a la BDD
			{	$req = 'INSERT INTO '. TableName::messages .'('.MessageColumns::ref.', '.MessageColumns::question.', '.MessageColumns::reponses.', '. MessageColumns::date.')'.
				' VALUES (\''.$this->pn.'\', '.$questionNumber.', \''.$valueToAdd.'\', CURRENT_TIME() )';
				$res = $this->db->query($req);
			}
			else // si la reponse existe deja, on ecrase la précédente de la BDD
			{	$req = 	'UPDATE '.TableName::messages.' SET '.MessageColumns::reponses.' = \''.$valueToAdd.'\', '.MessageColumns::date.' = CURRENT_TIME() WHERE '.MessageColumns::ref.'=\''.$this->pn.
						'\' AND '.MessageColumns::question.'='. $questionNumber ;
				$res = $this->db->query($req);
			}
			$this->update(); // on oublie pas de recharger les données depuis la BDD, comme pour la liste des Utilisateurs
		}
		catch (PDOException $e)
		{	echo 'Connexion échouée : ' . $e->getMessage();	}
	}

	// pour recharger la liste des réponses depuis la BDD
	private function update()
	{	$this->list = array();
		$req =  'SELECT '.UserColumns::phoneNumber.', '.MessageColumns::date.', '.MessageColumns::question.', '.MessageColumns::reponses.
				' FROM '.TableName::messages.
				' INNER JOIN '. TableName::users .' ON '. TableName::users .'.'.UserColumns::phoneNumber.' = '. TableName::messages .'.'.MessageColumns::ref.' '.
				' WHERE '. TableName::users .'.'.UserColumns::phoneNumber.' =\'' . $this->pn . '\'';
		try
		{	$res = $this->db->query($req);

			while($data = $res->fetch())
				$this->list[] = new Answer($data);
		}
		catch (PDOException $e)
		{	echo 'Connexion échouée : ' . $e->getMessage();	}

	}
	

	/// ToString
	public function ts()
	{	$s = '<ul>';
		foreach ($this->list as $key => $v) 
		{	$s = $s . '<li>'. $v->ts() .'</li>';	}
		$s = $s . '</ul>';
		return $s;
	}
}

/// classe réponse
class Answer
{
	private $date; // date de la réponse
	private $question; // numero de la question
	private $reponses; // array des reponses sausies par l'utilisateur

	///
	/// Constructeur
	///
	public function __construct($array)
	{	$this->date = $array[MessageColumns::date];
		$this->question = $array[MessageColumns::question];
		$this->reponses = str_split($array[MessageColumns::reponses]);
	}

	/// GETTER
	public function date()
	{ return $this->date;	}
	public function question()
	{ return $this->question;	}
	public function compteurReponses()
	{	return count($this->reponses);	}
	public function reponses()
	{ return $this->reponses;	}
	public function reponse($i)
	{	if( isset($this->reponses[$i]) )
			return $this->reponses[$i];
		return false;
	}
	///
	/// ToString
	///
	public function ts()
	{	$s = '<p>question '.$this->question .' : ';
		foreach ($this->reponses as $k => $v) 
		{	$s = $s . ' ' . $v;	}
		return $s . ' ('. count($this->reponses) .')</p>';
	}
}

?>