<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotType(2);
?>

<div class = 'well'>
	<form action = "<?php echo HOME_DIR.'index.php/addStudents_controller';?>" method = 'POST' enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for = 'fichier' class = 'span2'>Choisir Fichier (.csv)</label></td>
				<td><input id = 'fichier' name = 'fichier' type = 'file' class = 'span2'></td>
			</tr>
			<tr>
				<td colspan = '2'><input type = 'submit' value = 'Importer' class = 'btn btn-primary span4'></td>
			</tr>
		</table>
	</form>
</div>