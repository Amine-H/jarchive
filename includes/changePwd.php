<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotLoggedOn();
?>

<script type="text/javascript">
function formReset()
{
	$('#pwd').val('');
	$('#cpwd').val('');
}

function changePwd()
{
	var pwd = $('#pwd').val();
	var cpwd = $('#cpwd').val();
	$.post('<?php echo HOME_DIR;?>includes/changePwd_controller.php',{pwd:pwd,cpwd:cpwd},function(data)
	{
		$('#message').html(data);
	});
}

</script>

<div class = 'well'>
	<table>
		<tr>
			<td><label for = 'pwd' class = 'span2'>Nouveau mot de passe</label></td>
			<td><input type = 'password' id = 'pwd' class = 'span2'></td>
		</tr>
		<tr>
			<td><label for = 'cpwd' class = 'span2'>Confirmer le mot de passe</label></td>
			<td><input type = 'password' id = 'cpwd' class = 'span2'></td>
		</tr>
		<tr>
			<td><button class = "btn btn-primary span2" onclick = "changePwd();">Changer</button></td>
			<td><button class = "btn span2" onclick="formReset();">Effacer</button></td>
		</tr>
		<tr id = 'message'></tr>
	</table>
</div>