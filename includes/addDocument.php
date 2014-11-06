<?php
	include_once('functions.php');
	preventFromCall();
	redirectIfNotLoggedOn();
	redirectIfNotType(0);
?>

<script type="text/javascript">

	$(document).ready(function()
		{
			$('#pfe').change(function()
			{
				if($('#pfe').val())
				{
					$('#pfe_stage').val('1');
				}
			});
			$('#stage').change(function()
			{
				if($('#stage').val())
				{
					$('#pfe_stage').val('0');
				}
			});
			function showIfNotEmpty_etudiants()
			{
				if($('#membres_sugg').html() != '' && $('#membres_sugg').html().length > 3)
				{
					$('#membres_sugg').show();
				}
				else
				{
					$('#membres_sugg').hide();
				}
			}
			function showIfNotEmpty_encadrants()
			{
				if($('#encadrants_sugg').html() != '' && $('#encadrants_sugg').html().length > 3)
				{
					$('#encadrants_sugg').show();
				}
				else
				{
					$('#encadrants_sugg').hide();
				}
			}
			$('#membres_sugg').hide();
			$('#membres_sugg').change(function()
			{
				$('#membres_sugg').hide();
				$('#membres').val($('#membres_sugg').val());
			});
			$('#membres').keyup(function(e)
			{
				var entree = $('#membres').val();
			    if(e.which == 13)
			    {
			    	if(entree != '')
			    	{
						$('#membres').val('');
			    		if($('#membres_in').val() != '')
			    		{
			    			$('#membres_div').text($('#membres_div').text() + ',');
			    			$('#membres_in').val($('#membres_in').val() + ',');
			    		}
						$('#membres_div').text($('#membres_div').text() + entree);
						$('#membres_in').val($('#membres_in').val() + entree);
			    	}
			    	$('#membres_sugg').hide();
			    }
			    else
			    {
					if(entree != '')
					{
						$.post('<?php echo HOME_DIR;?>includes/find_etud_controller.php',{entree:entree},
							function (data)
							{
								$('#membres_sugg').html(data);
							});
						showIfNotEmpty_etudiants();
					}
					else
					{
						$('#membres_sugg').hide();
					}
			    }
			});
			$('#encadrants').keyup(function(e)
			{
				var entree = $('#encadrants').val();
			    if(e.which == 13)
			    {
			    	if(entree != '')
			    	{
						$('#encadrants').val('');
			    		if($('#encadrants_in').val() != '')
			    		{
			    			$('#encadrants_div').text($('#encadrants_div').text() + ',');
			    			$('#encadrants_in').val($('#encadrants_in').val() + ',');
			    		}
						$('#encadrants_div').text($('#encadrants_div').text() + entree);
						$('#encadrants_in').val($('#encadrants_in').val() + entree);
			    	}
			    	$('#encadrants_sugg').hide();
			    }
			    else
			    {
					if(entree != '')
					{
						$.post('<?php echo HOME_DIR;?>includes/find_enc_controller.php',{entree:entree},
							function (data)
							{
								$('#encadrants_sugg').html(data);
							});
						showIfNotEmpty_encadrants();
					}
					else
					{
						$('#encadrants_sugg').hide();
					}
			    }
			});
			$('#encadrants_sugg').hide();
			$('#encadrants_sugg').change(function()
			{
				$('#encadrants_sugg').hide();
				$('#encadrants').val($('#encadrants_sugg').val());
			});
		});
</script>

<div class = 'well'>
	<table>
		<form action = "<?php echo HOME_DIR.'index.php/addDocument_controller';?>" method = 'POST' enctype="multipart/form-data">
			<tr>
				<td><label for = 'sujet'>Sujet</label></td>
				<td><input id = 'sujet' name = 'sujet' type = 'text' class = 'span3'></td>
			</tr>
			<tr>
				<td><label for = 'description'>Description</label></td>
				<td><textarea id = 'description' name = 'description' style = 'max-width:255px;min-width:255px;max-height:100px;min-height:100px'></textarea></td>
			</tr>
			<tr>
				<td><label>Document du PFE ou du Stage ?</label></td>
				<td>
					<label for = 'pfe'>PFE</label><input type = 'radio' id = 'pfe' name = 'ps' selected>
					<label for = 'stage'>Stage</label><input type = 'radio' id = 'stage' name = 'ps' >
				</td>
				<input type = 'hidden' id = 'pfe_stage' name = 'pfe_stage'>
			</tr>
			<tr>
				<td><label for = 'document_f'>Document</label></td>
				<td><input id = 'document_f' name = 'document_f' type = 'file' class = 'span3'></td>
			</tr>
			<tr>
				<td><label for = 'membres'>Etudiants</label></td>
				<td>
					<input id = 'membres' type = 'text' class = 'span3' autocomplete='off' style = 'margin-bottom:0'><br>
					<select id = 'membres_sugg' class = 'span3' style = 'position:absolute;' multiple></select>
				</td>
			</tr>
			<tr>
				<td colspan = '2'>
					<div id = 'membres_div' style = "width:350px;overflow:scroll;"></div>
					<input type = 'hidden' name = 'membres_div' id = 'membres_in'>
				</td>
			</tr>
			<tr>
				<td><label for = 'encadrants'>Encadrants</label></td>
				<td>
					<input id = 'encadrants' type = 'text' class = 'span3' autocomplete='off' style = 'margin-bottom:0'><br>
					<select id = 'encadrants_sugg' class = 'span3' style = 'position:absolute;' multiple></select>
				</td>
			</tr>
			<tr>
				<td colspan = '2'>
					<div id = 'encadrants_div' style = "width:350px;overflow:scroll;"></div>
					<input type = 'hidden' name = 'encadrants_div' id = 'encadrants_in'>
				</td>
			</tr>
			<tr>
				<td><button class = "btn btn-primary" onClick = 'submit();' type = 'button'>Ajouter</button></td>
			</tr>
		</form>
	</table>
</div>