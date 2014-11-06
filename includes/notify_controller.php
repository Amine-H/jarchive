<?php
	include_once('functions.php');
	preventFromCall();
	session_start();
?>

<?php

include_once("database.php");
include_once("functions.php");

//to be synthetised
$notification = synthetize($_POST['notification']);
$type_from = User::getType();
$id_from = User::getId();
//end

if($type_from == 0)//etudiants
{
	//to be synthetised
	$id_to = $_POST['id_to'];
	//end

	$query = mysql_query("select max(id) as max_id from notifications",$connect);

	$row = mysql_fetch_assoc($query);

	$max_id = $row['max_id'] + 1;

	$query = mysql_query("insert into notifications values('".$max_id."','".$id_from."','".$type_from."','".$id_to."','1','".$notification."')",$connect);

	if($query){echo "<div style = 'color:green'>Notification Envoyé</div>";}
	else{echo "<div style = 'color:red'>Erreur</div>";}


}
else if($type_from == 1)//encadrants
{
	//to be synthetised
	$filieres = $_POST['filieres'];
	//end

	for($i = 0;$i < sizeof($filieres);$i++)
	{
		$query = mysql_query("select id from etudiants where filiere='".$filieres[$i]."'",$connect);
		$rCount = mysql_num_rows($query);
		for($j = 0;$j < $rCount;$j++)
		{
			$row = mysql_fetch_assoc($query);
			$id_to = $row['id'];

			$query2 = mysql_query("select max(id) as max_id from notifications",$connect);

			$row2 = mysql_fetch_assoc($query2);

			$max_id = $row2['max_id'] + 1;

			$query2 = mysql_query("insert into notifications values('".$max_id."','".$id_from."','".$type_from."','".$id_to."','0','".$notification."')",$connect);
			
			if(!$query2)
			{echo "<div style = 'color:red'>Erreur</div>";}
		}
	}
	echo "<div style = 'color:green'>Notifications Envoyé</div>";
}

?>