<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotType(2);
?>

<script type="text/javascript">
function checkReceipt()
{
	var recu = $('#recu').val();
	var message = $('#message');
	$.post('<?php echo HOME_DIR;?>includes/checkReceipt_controller.php',{doc_id:recu},function(data)
	{
		message.html(data);
	});
}
</script>

<div class = 'well'>
	<table>
		<tr>
			<td><label for = 'recu' class = 'span2'>N° du Reçu</label></td>
		</tr>
		<tr>
			<td><input type = 'text' id = 'recu' class = 'span2'></td>
		</tr>
		<tr>
			<td>
				<button class = "btn btn-primary span2" onclick="checkReceipt();">Verifier</button>
			</td>
		</tr>
		<tr id = 'message'></tr>
	</table>
</div>