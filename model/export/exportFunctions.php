<?php


function exportIn_Json_Format()
{
	$array = readDataBaseForExport();

	require_once('Json.php');
	$json = new Json($array);

	$content = $json->Stringify();
	$filename = 'export.json';

	!$handle = fopen($filename, 'w');
	fwrite($handle, $content);
	fclose($handle);

	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". filesize("$filename").";");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Type: application/json; "); 
	header("Content-Transfer-Encoding: binary");

	readfile($filename);
}

function exportIn_XML_Format()
{
	$array = readDataBaseForExport();
	require_once('exportXML.php');

	$users = exportUsersInXML($array['users']);
	$messages = exportMessagesInXML($array['messages']);
	$questions = exportQuestionsInXML($array['questions']);
	$reponses = exportReponsesInXML($array['reponses']);

	$content = $users ."\n\n". $messages ."\n\n". $questions ."\n\n". $reponses ."\n\n";
	$filename = 'export.xml';

	!$handle = fopen($filename, 'w');
	fwrite($handle, $content);
	fclose($handle);

	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". filesize("$filename").";");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Type: application/xml; "); 
	header("Content-Transfer-Encoding: binary");

	readfile($filename);
}

function exportIn_CSV_Format()
{
	$array = readDataBaseForExport();
	require_once('exportCSV.php');

	$users = exportUsersInCSV($array['users']);
	$messages = exportMessagesInCSV($array['messages']);
	$questions = exportQuestionsInCSV($array['questions']);
	$reponses = exportReponsesInCSV($array['reponses']);

	$content = $users ."\n\n". $messages ."\n\n". $questions ."\n\n". $reponses ."\n\n";
	$filename = 'export.csv';

	!$handle = fopen($filename, 'w');
	fwrite($handle, $content);
	fclose($handle);

	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". filesize("$filename").";");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Type: application/csv; "); 
	header("Content-Transfer-Encoding: binary");

	readfile($filename);
}

function exportIn_Xls_Format()
{
	$array = readDataBaseForExport();
/*
	?>
    <pre>
    <?php
    	print_r($array);
    ?>
    </pre>
    <?php
*/
}


/// ###############################
///	### modules complémentaires ###
///	###     pour exportation    ###
/// ###############################

function readDataBaseForExport()
{
	$data = array();
	
	$data['users'] 		= readUsers();
	$data['messages'] 	= readMessages();
	$data['questions'] 	= readQuestions();
	$data['reponses'] 	= readReponses();

	return $data;
}

function readMessages()
{
	try
	{	$db = new PDO('mysql:dbname=feedback;host=127.0.0.1', 'root', '');
		$db->query("SET NAMES UTF8");

		$req = 'SELECT * FROM message';
		$res = $db->query($req);

		$container = array();		
		while($data = $res->fetch(PDO::FETCH_ASSOC))
		{	$container[] = $data;	}
		
		return $container;
	}
	catch (PDOException $e)
	{	echo 'Connexion échouée : ' . $e->getMessage();	
		return array();
	}
}

function readQuestions()
{
	try
	{	$db = new PDO('mysql:dbname=feedback;host=127.0.0.1', 'root', '');
		$db->query("SET NAMES UTF8");

		$req = 'SELECT * FROM question';
		$res = $db->query($req);

		$container = array();		
		while($data = $res->fetch(PDO::FETCH_ASSOC))
		{	$container[] = $data;	}
		
		return $container;
	}
	catch (PDOException $e)
	{	echo 'Connexion échouée : ' . $e->getMessage();	
		return array();
	}
}

function readReponses()
{
	try
	{	$db = new PDO('mysql:dbname=feedback;host=127.0.0.1', 'root', '');
		$db->query("SET NAMES UTF8");

		$req = 'SELECT * FROM reponse';
		$res = $db->query($req);

		$container = array();		
		while($data = $res->fetch(PDO::FETCH_ASSOC))
		{	$container[] = $data;	}
		
		return $container;
	}
	catch (PDOException $e)
	{	echo 'Connexion échouée : ' . $e->getMessage();	
		return array();
	}
}

function readUsers()
{
	try
	{	$db = new PDO('mysql:dbname=feedback;host=127.0.0.1', 'root', '');
		$db->query("SET NAMES UTF8");

		$req = 'SELECT * FROM user';
		$res = $db->query($req);

		$container = array();		
		while($data = $res->fetch(PDO::FETCH_ASSOC))
		{	$container[] = $data['num_tel'];}
		
		return $container;
	}
	catch (PDOException $e)
	{	echo 'Connexion échouée : ' . $e->getMessage();	
		return array();
	}	
}

?>