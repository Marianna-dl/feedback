<?php

function exportUsersInCSV($usersArray)
{
	$csv = '"users"';
	$csv = $csv . "\n" . '"num_tel"';
	foreach ($usersArray as $k => $v)
		$csv = $csv . "\n" .'"'.$v.'"';

	return $csv;
}

function exportMessagesInCSV($messagesArray)
{
	$csv = '"messages"';
	$csv = $csv . "\n" . '"id_mess", "num_user", "num_question", "num_reponse", "date_recu"';
	foreach ($messagesArray as $k => $message)
	{
		$csv = $csv . "\n" .'"'.$message['id_mess'].'", "'.$message['num_user'].'", "'.$message['num_question'].'", "'.
								$message['num_reponse'].'", "'.$message['date_recu'].'"';
	}
	return $csv;
}


function exportQuestionsInCSV($questionsArray)
{
	$csv = '"questions"';
	$csv = $csv . "\n" . '"id_quest", "num_quest", "type_quest", "enonce"';
	foreach ($questionsArray as $k => $question)
	{
		$csv = $csv . "\n" .'"'.$question['id_quest'].'", "'.$question['num_quest'].'", "'.$question['type_quest'].'", "'.
								$question['enonce'].'"';
	}
	return $csv;
}


function exportReponsesInCSV($reponsesArray)
{
	$csv = '"reponses"';
	$csv = $csv . "\n" . '"num_question", "num_rep", "description", "point"';
	foreach ($reponsesArray as $k => $reponse)
	{
		$csv = $csv . "\n" .'"'.$reponse['num_question'].'", "'.$reponse['num_rep'].'", "'.$reponse['description'].'", "'.
								$reponse['point'].'"';
	}
	return $csv;
}

?>