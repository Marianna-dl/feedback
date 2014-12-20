<?php

function exportUsersInXML($usersArray)
{
	$xml = '<users>';
	foreach ($usersArray as $k => $v)
		$xml = $xml . "\n\t" .'<num_tel>'.$v.'</num_tel>';

	$xml = $xml . "\n</users>";
	return $xml;
}

function exportMessagesInXML($messagesArray)
{
	$xml = '<messages>';
	
	foreach ($messagesArray as $k => $message)
	{
		$xml =	$xml .
				"\n\t" .'<message>'.
					"\n\t\t<id_mess>". $message['id_mess']."</id_mess>".
					"\n\t\t<num_user>".$message['num_user']."</num_user>".
					"\n\t\t<num_question>".$message['num_question']."</num_question>".
					"\n\t\t<num_reponse>".$message['num_reponse']."</num_reponse>".
					"\n\t\t<date_recu>".$message['date_recu']."</date_recu>".
				"\n\t" .'</message>';
	}
	$xml = $xml . "\n</messages>";
	return $xml;
}


function exportQuestionsInXML($questionsArray)
{
	$xml = "<questions>";
	foreach ($questionsArray as $k => $question)
	{
		$xml =	$xml .
				"\n\t<question>".
					"\n\t\t<id_quest>".$question['id_quest']."</id_quest>".
					"\n\t\t<num_quest>".$question['num_quest']."</num_quest>".
					"\n\t\t<type_quest>".$question['type_quest']."</type_quest>".
					"\n\t\t<enonce>".$question['enonce']."</enonce>".
				"\n\t</question>";
	}
	$xml = $xml . "\n</questions>";
	return $xml;
}


function exportReponsesInXML($reponsesArray)
{
	$xml = "<reponses>";
	
	foreach ($reponsesArray as $k => $reponse)
	{
		$xml =	$xml .
				"\n\t<reponse>".
					"\n\t\t<num_question>".$reponse['num_question']."</num_question>".
					"\n\t\t<num_rep>".$reponse['num_rep']."</num_rep>".
					"\n\t\t<description>".$reponse['description']."</description>".
					"\n\t\t<point>".$reponse['point']."</point>".
				"\n\t</reponse>";
	}
	$xml = $xml . "\n</reponses>";
	return $xml;
}

?>