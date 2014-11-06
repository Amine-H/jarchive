<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

include_once 'database.php';
include_once 'config.php';

//to be synth
$doc_id = synthetize($_POST['doc_id']);
//end

if(isset($doc_id))
{
	if(is_numeric($doc_id))
	{
		$query = mysql_query("select user_id from archive where doc_id = '$doc_id'",$connect);

		$rCount = mysql_num_rows($query);

		if($rCount == 0)
		{
			die("<div style = 'color:red' class = 'span2'>Aucun document trouvé!</div>");
		}
		else
		{
			die("<div style = 'color:green'>Document Trouvé veuillez cliquer <a href = '".HOME_DIR."recus.php?doc_id=".$doc_id."'>ICI</a>".
				"<br>Pour voir le recus cliquer <a href = '".HOME_DIR."index.php/doc/".$doc_id."'>ICI</a>"."</div>");
		}
	}
	else
	{
		die("<div style = 'color:red' class = 'span2'>Veuillez entrer un nombre!</div>");
	}
}
else
{
	die("<div style = 'color:red' class = 'span2'>Veuillez entrer le N° du Reçu!</div>");
}


?>