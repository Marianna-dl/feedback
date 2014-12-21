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
	const questions  = 'question';
	const reponses 	= 'reponse';
}
abstract class UserColumns
{
	const phoneNumber	= 'num_tel';
}
abstract class MessageColumns
{
	const id_mess	= 'id_mess';
	const num_user  = 'num_user';
	const question	= 'num_question';
	const reponses	= 'num_reponse';
	const date		= 'date_recu';
}
abstract class QuestionColumns
{
	const id_quest	= 'id_quest';
	const num		= 'num_quest';
	const type		= 'type_quest';
	const enonce	= 'enonce';
}
abstract class ReponseColumns
{
	const numQ			= 'num_question';
	const numR			= 'num_rep';
	const description 	= 'description';
	const point			= 'point';
}
?>