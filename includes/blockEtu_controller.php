<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

include_once 'database.php';

//to be synth
$blodl = synthetize($_POST['blodl']);
$etudiant = synthetize($_POST['etudiant']);
//end

if(isset($blodl) && isset($etudiant))
{

	if($blodl == 0)//debloquer
	{
		$query = mysql_query("select isBlocked from etudiants where id = '$etudiant'",$connect);

		$row = mysql_fetch_assoc($query);

		if($row['isBlocked'] == 1)
		{
			mysql_query("update etudiants set isBlocked = '0' where id = '$etudiant'",$connect);

			die("<div style = 'color:green'>Etudiant débloqué</div>");
		}
		else
		{
			die("<div style = 'color:red'>Etudiant n'est pas bloqué</div>");
		}
	}
	else//bloquer
	{
		$query = mysql_query("select isBlocked from etudiants where id = '$etudiant'",$connect);

		$row = mysql_fetch_assoc($query);

		if($row['isBlocked'] == 0)
		{
			mysql_query("update etudiants set isBlocked = '1' where id = '$etudiant'",$connect);

			die("<div style = 'color:green'>Etudiant bloqué</div>");
		}
		else
		{
			die("<div style = 'color:red'>Etudiant est deja bloqué</div>");
		}
	}

}


?>