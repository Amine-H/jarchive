<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

include_once('database.php');

//to be synthitised
$id = @synthetize($_POST['id']);
$what = @synthetize($_POST['what']);
$pfe_stage = @synthetize($_POST['pfe_stage']);
//end of synth

if(isset($id))
{
	if(isset($what) && $what == 'file')
	{
		if($pfe_stage == 0)
		{
			$query = mysql_query("select file_name from documents where id = '$id' and pfe_stage = '0'",$connect);
		}
		else if($pfe_stage == 1)
		{
			$query = mysql_query("select file_name from documents where id = '$id' and pfe_stage = '1'",$connect);
		}
		else if($pfe_stage == 2)
		{
			$query = mysql_query("select file_name from documents where id = '$id'",$connect);
		}
		else
		{
			die("<div style = 'color:red'>Veuillez choisir PFE ou Stage !</div>");
		}

		$rCount = mysql_num_rows($query);

		if($rCount == 1)
		{
			$row = mysql_fetch_assoc($query);
			echo $row['file_name'];
		}
		else
		{
			echo "not_found";
		}
	}
	else
	{
		if($pfe_stage == 0)
		{
			$query = mysql_query("select description from documents where id = '$id' and pfe_stage = '0'",$connect);
		}
		else if($pfe_stage == 1)
		{
			$query = mysql_query("select description from documents where id = '$id' and pfe_stage = '1'",$connect);
		}
		else if($pfe_stage == 2)
		{
			$query = mysql_query("select description from documents where id = '$id'",$connect);
		}
		else
		{
			die("<div style = 'color:red'>Veuillez choisir PFE ou Stage !</div>");
		}

		$rCount = mysql_num_rows($query);

		if($rCount == 1)
		{
			$row = mysql_fetch_assoc($query);
			echo "<div class = 'sujet_c'>Description:</div>".$row['description'];
		}
		else
		{
			echo "<div style = 'color:red'>Erreur! document inexistant</div>";
		}
	}

}

?>