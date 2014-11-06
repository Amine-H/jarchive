<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

include_once 'database.php';

//to be synth
$entree = synthetize($_POST['entree']);
//end

$entree = strtolower($entree);

$query = mysql_query("select nom,prenom,code_etudiant from etudiants where CONCAT(nom,CONCAT(' ',prenom)) like '%$entree%' or CONCAT(prenom,CONCAT(' ',nom)) like '%$entree%'",$connect);

$rCount = mysql_num_rows($query);

for($i = 0;$i < $rCount;$i++)
{
	$row = mysql_fetch_assoc($query);
	echo "<option>".$row['nom']." ".$row['prenom']." | ".$row['code_etudiant']."</option>";
}


?>