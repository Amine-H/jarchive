<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

include_once('database.php');
include_once('functions.php');

//to be synthitised
$nom = synthetize($_POST['nom']);
$prenom = synthetize($_POST['prenom']);
$email = synthetize($_POST['email']);
$filiere = synthetize($_POST['filiere']);
$code_etudiant = synthetize($_POST['code_etudiant']);
$pwd = synthetize($_POST['pwd']);
$cpwd = synthetize($_POST['cpwd']);

//checking if the user entered all required fields
if(isset($nom) && isset($prenom) && isset($email)
	&& isset($pwd) && isset($cpwd)
	&& !empty($nom) && !empty($prenom) && !empty($email)
	&& !empty($pwd) && !empty($cpwd))
{
	$nom = strtolower($nom);
	$prenom = strtolower($prenom);
	$code_etudiant = strtolower($code_etudiant);

	//checking if user exists with entered informations

	if(User::isExists($email,$connect))
	{
		echo "<div style = 'color:red'>Utilisateur Existant!</div>";
	}
	else
	{
		if($pwd == $cpwd)
		{
			User::register($nom,$prenom,$email,$pwd,$filiere,$code_etudiant,$connect);
			echo "<div style = 'color:green'>Utilisateur Créé!,<br>Vous pouvez vous connecter</div>";
		}
		else
		{
			echo "<div style = 'color:red'>Mots de passe ne correspondent pas!</div>";
		}
	}
}
else
{
	echo "<div style = 'color:red'>Veuillez remplir tout les champs!</div>";
}



?>