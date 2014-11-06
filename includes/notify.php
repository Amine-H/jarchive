<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

redirectIfNotLoggedOn();

?>

<script type="text/javascript">
	function send()
	{
		var type = $('#type').val();
		var id_from = $('#id_from').val();
		var id_to = $('#encadrants').val();
		var notification = $('#notification').val();
		if(notification.length == 0)
		{
			$('#message').html('<div style = "color:red">Please insert something!</div>');
		}
		else
		{
			if(type == 0)//etudiants
			{
				$.post('<?php echo HOME_DIR;?>includes/notify_controller.php',{id_from:id_from,type:type,notification:notification,id_to:id_to},function(data)
				{
					$('#message').html(data);
				});
			}
			else if(type == 1)//encadrants
			{
				var filieres = $("#filieres").val();
				$.post('<?php echo HOME_DIR;?>includes/notify_controller.php',{id_from:id_from,type:type,notification:notification,filieres:filieres},function(data)
				{
					$('#message').html(data);
				});
			}
		}
	}
</script>

<div class = 'well'>
	<input id = 'id_from' type = 'hidden' val = '<?php echo User::getId();?>'>
	<table>
		<tbody>
			<?php

			if(User::getType() == 0)//etudiants
			{
				echo "<input id = 'type' type = 'hidden' value = '0'>";
				echo "<tr><td><select id = 'encadrants'>";
				listEncadrants($connect);
				echo"</select></td></tr>";
			}
			else if(User::getType() == 1)//encadrants
			{
				echo "<input id = 'type' type = 'hidden' value = '1'>";
				echo "<tr>
						<td>
							<select id = 'filieres' multiple>
					";
				listFilieres($connect);
				echo"
							</select>
						</td>
					</tr>";
			}

			?>
			<tr>
				<td><textarea id = 'notification' style = 'max-width:210px;min-width:210px;max-height:100px;min-height:100px'></textarea></td>
			</tr>
			<tr>
				<td><button class = "btn btn-primary" onclick = "send();">Envoyer</button></td>
			</tr>
			<tr id = 'message'></tr>
		</tbody>
	</table>
</div>