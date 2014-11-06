<?php
	include_once('functions.php');
	include_once('database.php');
	preventFromCall();

if(isset($_POST['nom']) && isset($_POST['prenom']) &&
	isset($_POST['email']) && isset($_POST['pwd']) &&
	isset($_POST['pwd_c']) && !empty($_POST['nom']) &&
	!empty($_POST['prenom']) && !empty($_POST['email']) &&
	!empty($_POST['pwd']) && !empty($_POST['pwd_c']))
{
	$nom = strtolower(synthetize($_POST['nom']));
	$prenom = strtolower(synthetize($_POST['prenom']));
	$email = synthetize($_POST['email']);
	$pwd = synthetize($_POST['pwd']);
	$pwd_c = synthetize($_POST['pwd_c']);
	if($pwd == $pwd_c)
	{
		$query = mysql_query("select max(id) as max_id from encadrants",$connect);

		$row =  mysql_fetch_assoc($query);
		$max_id = $row['max_id'] + 1;

		$query = mysql_query("insert into encadrants values ('$max_id','$nom','$prenom','$email','$pwd')",$connect);
		if($query)
		{
			die("<div style = 'color:green'>encadrant ajouté!</div>");
		}
		else
		{
			die("<div style = 'color:red'>erreur inconnu de l'insertion,<br>peut etre que l'email est deja utilisé!</div>");
		}
	}
	else
	{
		die("<div style = 'color:red'>mot de passes non identiques</div>");
	}
}
else
{
	die("<div style = 'color:red'>veuillez remplir tout les champs!</div>");
}

?>