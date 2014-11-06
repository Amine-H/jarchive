<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotLoggedOn();
?>

<script type="text/javascript">

	function update_list()
	{
		var pfe_stage;
		if(pfe.checked && stage.checked)
		{
			pfe_stage = 2;
		}
		else if(pfe.checked)
		{
			pfe_stage = 0;
		}
		else if(stage.checked)
		{
			pfe_stage = 1;
		}
		else
		{
			pfe_stage = -1;
		}

		if(pfe_stage == 0)
		{
			$('#documents').html("<?php listDocuments($connect,0);?>");
		}
		else if(pfe_stage == 1)
		{
			$('#documents').html("<?php listDocuments($connect,1);?>");
		}
		else if(pfe_stage == 2)
		{
			$('#documents').html("<?php listDocuments($connect,2);?>");
		}
	}

	function update_list_mc()
	{
		var mots_cle = $('#mots_cle').val();
		var pfe_stage;
		if(pfe.checked && stage.checked)
		{
			pfe_stage = 2;
		}
		else if(pfe.checked)
		{
			pfe_stage = 1;
		}
		else if(stage.checked)
		{
			pfe_stage = 0;
		}
		else
		{
			pfe_stage = -1;
		}
		$.post("<?php echo HOME_DIR?>includes/docs_search.php",{mots_cle:mots_cle,
																pfe_stage:pfe_stage},function(data)
																{
																	$('#documents').html(data);
																});
	}

	$(document).ready(function()
	{
		var id = $('#documents').val();
		var file_name = 'not_found';
		var pfe_stage;
		if(pfe.checked && stage.checked)
		{
			pfe_stage = 2;
		}
		else if(pfe.checked)
		{
			pfe_stage = 1;
		}
		else if(stage.checked)
		{
			pfe_stage = 0;
		}
		else
		{
			pfe_stage = -1;
		}

		$('#pfe').change(function()
		{
			update_list();
		});
		$('#stage').change(function()
		{
			update_list();
		});

		$.post(<?php echo "'".HOME_DIR;?>includes/docs_controller.php<?php echo "'"?>,{id:id,what:'file',
																					pfe_stage:pfe_stage},
		function(data)
		{
			var link = '<?php echo HOME_DIR."files/"?>' + data;
			$('#down_doc').attr('href',link);
		});

		var link = '<?php echo HOME_DIR."index.php/doc/"?>' + id;
		$('#see_more').attr('href',link);

		$.post(<?php echo "'".HOME_DIR;?>includes/docs_controller.php<?php echo "'"?>,{id:id,
																		pfe_stage:pfe_stage},
		function(data)
		{
			$('#description').html(data);
		});
		$('#documents').change(function()
		{
			var id = $('#documents').val();
			var link = '<?php echo HOME_DIR."index.php/doc/"?>' + id;
			var pfe_stage;
			if(pfe.checked && stage.checked)
			{
				pfe_stage = 2;
			}
			else if(pfe.checked)
			{
				pfe_stage = 1;
			}
			else if(stage.checked)
			{
				pfe_stage = 0;
			}
			else
			{
				pfe_stage = -1;
			}

			$('#see_more').attr('href',link);
			$.post(<?php echo "'".HOME_DIR;?>includes/docs_controller.php<?php echo "'"?>,{id:id,pfe_stage:pfe_stage},
			function(data)
			{
				$('#description').html(data);
			})

			$.post(<?php echo "'".HOME_DIR;?>includes/docs_controller.php<?php echo "'"?>,{id:id,what:'file',pfe_stage:pfe_stage},
			function(data)
			{
				var link = '<?php echo HOME_DIR."files/"?>' + data;
				$('#down_doc').attr('href',link);
			})
		});
		$('#mots_cle').keyup(function()
		{
			update_list_mc();
		});
	});

</script>

<div class = 'well'>

	<table>
		<tr>
			<td>
				<label>document du PFE ou stage ?</label>
			</td>
		</tr>
		<tr>
			<td><label for = 'pfe' class = 'span2'>PFE</label><input type = 'checkbox' id = 'pfe' checked></td>
		</tr>
		<tr>
			<td><label for = 'stage' class = 'span2'>Stage</label><input type = 'checkbox' id = 'stage' checked></td>
		</tr>
		<tr>
			<td><label for = 'mots_cle'>Rechercher par mot clé</label></td>
		</tr>
		<tr>
			<td><input type = 'text' id = 'mots_cle' class = 'span4'></td>
		</tr>
		<tr>
			<td><label for = 'documents'>Selectionner le document par sujets</label></td>
		</tr>
		<tr>
			<td>
				<select id = 'documents' class = 'span4'>
					<?php listDocuments($connect,2); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><a id = 'see_more' href = '' target = '_blank'>Voir plus..</a></td>
		</tr>
		<tr>
			<td><a id = 'down_doc' href = '' target = '_blank'>Telecharger le document</a></td>
		</tr>
	</table>
	<div id = 'description'></div>
</div>