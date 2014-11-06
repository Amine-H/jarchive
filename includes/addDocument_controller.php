<?php
	include_once('functions.php');
	include_once('config.php');
	preventFromCall();
?>

<div class = 'well'>
<?php

//to be synth
$sujet = synthetize($_POST['sujet']);
$description = synthetize($_POST['description']);
$membres = synthetize($_POST['membres_div']);
$encadrants = synthetize($_POST['encadrants_div']);
$pfe_stage = $_POST['pfe_stage'];
//end

if(isset($sujet) && isset($description) && isset($membres))
{
	$membres = strtolower($membres);
	$membres_array = explode(',',$membres);

	$encadrants = strtolower($encadrants);
	$encadrants_array = explode(',',$encadrants);

	$zipMime = array('application/x-zip','application/zip','application/x-zip-compressed','application/octet-stream');

	if($_FILES["document_f"]["error"])
	{
		echo "<div style = 'color:red'>Erreur ,Veuillez ajouter votre document a nouveau, merci</div>";
	}
	else
	{
		if(in_array($_FILES["document_f"]["type"],$zipMime))
		{
			if($_FILES["document_f"]["size"] < 10000000)
			{
				do
				{
					$file_name = substr(md5(time()),0,6).".zip";
				}
				while (file_exists("../files/".$file_name));
				move_uploaded_file($_FILES["document_f"]["tmp_name"],LOCAL_DIR."files/".$file_name);

				$query = mysql_query("select max(id) max_id from documents",$connect);
				$row = mysql_fetch_assoc($query);
				$max_id = $row['max_id'] + 1;

				$query = mysql_query("insert into documents values('$max_id','$sujet','$description','$file_name','$pfe_stage')",$connect);

				$doc_id = $max_id;

				$query = mysql_query("select max(id) max_id from archive",$connect);
				$row = mysql_fetch_assoc($query);
				$max_id = $row['max_id'] + 1;

				$query = mysql_query("insert into archive values('$max_id','".User::getId()."','$doc_id','".date('Y-m-d')."')",$connect);

				$query = mysql_query("select code_etudiant from etudiants where id = '".User::getId()."'",$connect);
				$row = mysql_fetch_assoc($query);
				$u_CE = $row['code_etudiant'];//code d'etudiant who is logged in

				$alreadyIn[0] = strtolower($u_CE);$c = 1;
				for($i = 0;$i < sizeof($membres_array);$i++)
				{
					$pos = strrpos($membres_array[$i], "|") + 1;
					$code_etudiant = strtolower(trim(substr($membres_array[$i],$pos)));

					if(in_array($code_etudiant,$alreadyIn))//check if added already
					{
						continue;
					}
					else
					{
						$alreadyIn[$c] = $code_etudiant;
						$c++;
					}

					$query = mysql_query("select id from etudiants where code_etudiant = '$code_etudiant'",$connect);
					$rCount = mysql_num_rows($query);
					$row = mysql_fetch_assoc($query);
					$id = $row['id'];
					if($rCount == 1)
					{
						$query2 = mysql_query("select max(id) as max_id from archive",$connect);
						$row2 = mysql_fetch_assoc($query2);
						$max_id = $row2['max_id'] + 1;

						$query2 = mysql_query("insert into archive values('$max_id','$id','$doc_id','".date('Y-m-d')."')",$connect);
					}
				}

				//remove doubles just in case..
				$encadrants_array = array_unique($encadrants_array);
				for ($i = 0;$i < sizeof($encadrants_array);$i++)
				{
					$query2 = mysql_query("select max(id) as max_id from archive_2",$connect);
					$row2 = mysql_fetch_assoc($query2);
					$max_id = $row2['max_id'] + 1;
					mysql_query("insert into archive_2 values ('$max_id','$encadrants_array[$i]','$doc_id','".date('Y-m-d')."')");
				}

				echo "<div style = 'color:green'>Zip Archive inséréé<br>";
				echo "<a href = '".HOME_DIR."index.php/doc/".$doc_id."'>Voir le fichier</a></div>";
				echo "<a href = '".HOME_DIR."recus.php?doc_id=".$doc_id."'>Telecharger le Recu</a></div>";
				}
			else
			{
				echo "<div style = 'color:red'>Zip Archive trop volumineux</div>";
			}
		}
		else
		{
			echo "<div style = 'color:red'>Ajout du fichier impossible veuillez utiliser zip format ".print_r($_FILES["document_f"])."</div>";
		}
	}

}
?>
</div>