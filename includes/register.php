<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

//check if not connected
	redirectIfLoggedOn();
//end check

?>
<script type="text/javascript">

$('#register').addClass('active');

function formReset()
{
	$('#nom').val('');
	$('#prenom').val('');
	$('#email').val('');
	$('#pwd').val('');
	$('#cpwd').val('');
}

function register()
{
	var nom = $('#nom').val();
	var prenom = $('#prenom').val();
	var email = $('#email').val();
	var filiere = $('#filiere').val();
	var pwd = $('#pwd').val();
	var cpwd = $('#cpwd').val();
	var code_etudiant = $('#code_etudiant').val();
	$.post('<?php echo HOME_DIR;?>includes/register_controller.php',{nom:nom,prenom:prenom,
									email:email,pwd:pwd,cpwd:cpwd,code_etudiant:code_etudiant,filiere:filiere},
	function(data)
	{
		$('#message').html(data);
	})
}
</script>
<div class = "well">
	<table>
		<tr>
			<td><label for = "nom">Nom</label></td>
			<td><input type = "text" id = "nom" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "prenom">Prenom</label></td>
			<td><input type = "text" id = "prenom" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "filiere">Filiere</label></td>
			<td>
				<select id = "filiere" class = "span2">
					<?php
						listFilieres($connect);
					?>
				</select>
				</td>
		</tr>
		<tr>
			<td><label for = "code_etudiant">Code d'etudiant</label></td>
			<td><input type = "text" id = "code_etudiant" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "email">Email</label></td>
			<td><input type = "email" id = "email" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "pwd">Mot de passe</label></td>
			<td><input type = "password" id = "pwd" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "cpwd">Confirmer Mot de passe</label></td>
			<td><input type = "password" id = "cpwd" class = "span2"></td>
		</tr>
		<tr>
			<td><button class = "btn btn-primary span2" onclick = "register();">Enregistrer</button></td>
			<td><button class = "btn span2" onclick="formReset();">Effacer</button></td>
		</tr>
	</table>
	<div id = "message"></div>
</div>