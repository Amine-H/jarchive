<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotType(2);
?>

<script type="text/javascript">

function bloquer ()
{
	var etudiant = $('#etudiant').val();
	var blodl = 1;
	$.post('<?php echo HOME_DIR;?>includes/blockEtu_controller.php',{blodl:blodl,etudiant:etudiant},function(data)
	{
		$('#message').html(data);
	});
}

function debloquer ()
{
	var etudiant = $('#etudiant').val();
	var blodl = 0;
	$.post('<?php echo HOME_DIR;?>includes/blockEtu_controller.php',{blodl:blodl,etudiant:etudiant},function(data)
	{
		$('#message').html(data);
	});
}

</script>

<div class = 'well'>
	<table>
		<tr>
			<td><label for = 'etudiant'>Etudiant</label></td>
			<td>
				<select id = 'etudiant'>
					<?php
						listEtudiants($connect);
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Action</label></td>
			<td>
				<button class = "btn btn-danger" onclick = "bloquer();">Bloquer</button>
				<button class = "btn btn-primary" onclick = "debloquer();">Débloquer</button>
			</td>
		</tr>
		<tr>
			<td colspan = '2' id = 'message'></td>
		</tr>
	</table>
</div>