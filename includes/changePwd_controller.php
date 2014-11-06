<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

session_start();
include_once 'database.php';
include_once 'functions.php';

//to be synth
$pwd = synthetize($_POST['pwd']);
$cpwd = synthetize($_POST['cpwd']);
//end

if(isset($pwd) && isset($cpwd)
	&& !empty($pwd) && !empty($cpwd))
{
	if($pwd == $cpwd)
	{
		switch(User::getType())
		{
			case 0://etudiant
				$table = "etudiants";
				break;
			case 1://encadrant
				$table = "encadrants";
				break;
			case 2://admin
				$table = "admins";
				break;
		}
		mysql_query("update ".$table." set password = '$pwd' where id = '".User::getId()."'",$connect);
		die("<div style = 'color:green'>Mot de passe changé!</div>");
	}
	else
	{
		die("<div style = 'color:red'>Les mots de passe ne sont pas identiques</div>");
	}
}
else
{
	die("<div style = 'color:red'>Veuillez remplir les deux champs!</div>");
}

?>