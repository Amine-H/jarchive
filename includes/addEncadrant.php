<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotType(2);
?>

<script type="text/javascript">
function add()
{
	var nom = $('#nom').val();
	var prenom = $('#prenom').val();
	var email = $('#email').val();
	var pwd = $('#pwd').val();
	var pwd_c = $('#pwd_c').val();
	$.post('<?php echo HOME_DIR;?>includes/addEncadrant_controller.php',
												{nom:nom,
												prenom:prenom,
												email:email,
												pwd:pwd,
												pwd_c:pwd_c},
												function(data)
												{
													$('#message').html(data);
												});
}
</script>


<div class = 'well'>
	<table>
		<tr>
			<td><label for = 'nom' class = 'span2'>Nom</label></td>
			<td><input type = 'text' id = 'nom' class = 'span2'></td>
		</tr>
		<tr>
			<td><label for = 'prenom' class = 'span2'>Prenom</label></td>
			<td><input type = 'text' id = 'prenom' class = 'span2'></td>
		</tr>
		<tr>
			<td><label for = 'email' class = 'span2'>Email</label></td>
			<td><input type = 'email' id = 'email' class = 'span2'></td>
		</tr>
		<tr>
			<td><label for = 'pwd' class = 'span2'>Mot de passe</label></td>
			<td><input type = 'password' id = 'pwd' class = 'span2'></td>
		</tr>
		<tr>
			<td><label for = 'pwd_c' class = 'span2'>Confirmer le mot de passe</label></td>
			<td><input type = 'password' id = 'pwd_c' class = 'span2'></td>
		</tr>
		<tr>
			<td colspan = '2'><button class = "btn btn-primary" onclick = "add();">Ajouter</button></td>
		</tr>
		<tr>
			<td colspan = '2' id = 'message'></td>
		</tr>
	</table>
</div>