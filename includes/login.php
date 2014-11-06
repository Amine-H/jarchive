<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

//check if not connected
if(User::isConnected())
{
	header('Location: '.HOME_DIR.'index.php/member');
}
//end check

?>

<script type="text/javascript">

	$('#login').addClass('active');

	function formReset()
	{
		$('#email').val('');
		$('#pwd').val('');
	}
	function login ()
	{
		var email = $('#email').val();
		var pwd = $('#pwd').val();
	
	$.post(<?php echo "'".HOME_DIR;?>includes/login_controller.php<?php echo "'"?>,{email:email,pwd:pwd},
	function(data)
	{
		$('#message').html(data);
		if(data.search('Connecté! veuillez patienter..') != -1)
		{
			window.location = '<?php echo HOME_DIR."index.php/member";?>';
		}
	})

	}
</script>

<div class = "well">
	<table>
		<tr>
			<td><label for = "email" class = "span2">Email</label></td>
			<td><input id = "email" type = "email" class = "span2"></td>
		</tr>
		<tr>
			<td><label for = "pwd" class = "span2">Mot de passe</label></td>
			<td><input id = "pwd" type = "password" class = "span2"></td>
		</tr>
		<tr>
			<td><button class = "btn btn-primary span2" onclick = "login();">Login</button></td>
			<td><button class = "btn span2" onclick="formReset();">Effacer</button></td>
		</tr>
	</table>
	<div id = "message"></div>
</div>