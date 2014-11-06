<?php
	include_once('functions.php');
	include_once('database.php');
	preventFromCall();
	$mots_cle = $_POST['mots_cle'];
	$pfe_stage = $_POST['pfe_stage'];
	listDocuments_mc($connect,$mots_cle,$pfe_stage)
?>