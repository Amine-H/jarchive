<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfLoggedOn();
?>

<?php

session_start();
include_once('database.php');
include_once('functions.php');

//to be synthitised
$email = synthetize($_POST['email']);
$pwd = synthetize($_POST['pwd']);

//checking if the user entered all required fields
if(isset($email) && isset($pwd)
	&& !empty($email) && !empty($pwd))
{
	$query = mysql_query("select id,nom,prenom,2 as isBlocked from encadrants where email='$email' and password='$pwd' ".
						"union select id,nom,prenom,3 as isBlocked from admins where email='$email' and password='$pwd' ".
						"union select id,nom,prenom,isBlocked from etudiants where email='$email' and password='$pwd'",$connect);
	$nRows = mysql_num_rows($query);
	if($nRows != 0)
	{
		$row = mysql_fetch_assoc($query);
		$id = $row['id'];
		$nom = $row['nom'];
		$prenom = $row['prenom'];
		$isBlocked = $row['isBlocked'];
		if($isBlocked == 1)
		{
			die("<div style = 'color:red'>Votre compte est Blocké!</div>");
		}
		else
		{
			if($isBlocked == 3)
			{
				$type = 2;//admin
			}
			else if($isBlocked == 2)//just a cool way to know which type :p (from the select)
			{
				$type = 1;//encadrant
			}
			else
			{
				$type = 0;//etudiant
			}
			User::connect($id,$nom,$prenom,$type);
			die("<div style = 'color:green'>Connecté! veuillez patienter..</div>");
		}
	}
	else
	{
		die("<div style = 'color:red'>Mot de passe ou email incorrect!</div>");
	}
}
else
{
	die("<div style = 'color:red'>Veuillez remplir tout les champs!</div>");
}

?>