<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php
//check if not connected
	redirectIfNotLoggedOn();
//end check

?>

<script type="text/javascript">
	$('#member').addClass('active');
</script>

<div class = 'well'>
<?php

echo "<h3>Bienvenue ".User::getNom()." ".User::getPrenom()."</h3>";
echo "Vous voulez :<br>";
if(User::getType() == 0)//etudiant
{
	echo "
		<table class = 'table table-striped wborders'>
			<tbody>
				<tr>
					<td><a href ='".HOME_DIR."index.php/notifications'>Voir Notifications</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/notify'>Notifier</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/docs'>Chercher un document</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/addDocument'>Ajouter un document</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/changePwd'>Changer votre mot de passe</a></td>
				</tr>
			</tbody>
		</table>
		";
}
else if(User::getType() == 1)//encadrant
{
	echo "
		<table class = 'table'>
			<tbody>
				<tr>
					<td><a href ='".HOME_DIR."index.php/notifications'>Voir Notifications</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/notify'>Notifier</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/docs'>Chercher un document</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/changePwd'>Changer votre mot de passe</a></td>
				</tr>
			</tbody>
		</table>
		";
}
else if(User::getType() == 2)//admin
{
	echo "
		<table class = 'table'>
			<tbody>
				<tr>
					<td><a href ='".HOME_DIR."index.php/blockEtu'>Bloquer/Débloquer un Etudiant</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/docs'>Chercher un document</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/checkReceipt'>Verifier un Reçu</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/changePwd'>Changer votre mot de passe</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/addStudents'>Importer list des etudiants</a></td>
				</tr>
				<tr>
					<td><a href ='".HOME_DIR."index.php/addEncadrant'>Ajouter un encadrant</a></td>
				</tr>
			</tbody>
		</table>
		";	
}
else
{
	echo "we dont have any 4th type YET my friend, something is not cool if U R a user,let me just to make sure everything is good ,i'll disconnect u right now.";
	User::logout();
}


?>
</div>