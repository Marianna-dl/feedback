<?php

function clearBDD()
{
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=feedback', 'root', '');
	
		$db->query('DELETE FROM message');
		$db->query('DELETE FROM messagebrute');
		$db->query('DELETE FROM reponse');
		$db->query('DELETE FROM user');
		// question a faire en dernier, surement a cause des FOREIGN KEY
		$db->query('DELETE FROM question');
		return true;
	}
	catch (PDOException $e)
	{	return false;	}
}

?>