<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotLoggedOn();
?>

<div class = 'well'>
<?php

if(count($params) != 1)
{
	header("Location: ".HOME_DIR."index.php/error");
}
else
{
	//to be synthetised
	$id = synthetize($params[0]);

	$query = mysql_query("select sujet,description,file_name from documents where id='$id'",$connect);
	$rCount = mysql_num_rows($query);

	if($rCount == 1)
	{
		$row = mysql_fetch_assoc($query);
		$sujet  = $row['sujet'];
		$description  = $row['description'];
		$file_name  = $row['file_name'];

		if(!file_exists("files/".$file_name))
		{
			echo "Erreur Fatal lecture du fichier impossible!";
		}
		else
		{
			echo "
					<div id = 'sujet'><div class = 'sujet_c'>Sujet:</div> ".$sujet."</div>
					<div id = 'description'><div class = 'sujet_c'>Description:</div> ".$description."</div>
					<div class = 'sujet_c'>Contenu de fichier:</div>
					<div id = 'file'>";
					listContentsOf("files/".$file_name);
				echo"</div>";
				echo "<a href = '".HOME_DIR."files/".$file_name."'>Télecharger</a>";
		}
	}
	else
	{
		echo "Aucun document a afficher ou lien incorrect";
	}
}

?>
</div>