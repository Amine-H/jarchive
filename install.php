<html>

	<head>
		<title>Installeur j'Archive</title>
		<script type="text/javascript" src = 'js/jquery.js'></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
			pos = 0;
		});
		function next()
		{
			if(pos < 3)
			{
				switch(pos)
				{
					case 0:
						$('#form1').hide();
						$('#form2').fadeIn(900);
						pos++;
						break;
					case 1:
						$('#form2').hide();
						$('#form3').fadeIn(900);
						pos++;
						break;
					case 2:
						$('#form3').hide();
						$('#form1').fadeIn(900);
						pos = 0;
						break;
				}
			}
		}
		function previous()
		{
			if(pos >= 0)
			{
				switch(pos)
				{
					case 0:
						$('#form1').hide();
						$('#form3').fadeIn(900);
						pos = 2;
						break;
					case 1:
						$('#form2').hide();
						$('#form1').fadeIn(900);
						pos--;
						break;
					case 2:
						$('#form3').hide();
						$('#form2').fadeIn(900);
						pos--;
						break;
				}
			}
		}
		function ok()
		{
			var HOME_DIR = $('#HOME_DIR').val();
			var LOCAL_DIR = $('#LOCAL_DIR').val();
			var mysql_host = $('#mysql_host').val();
			var mysql_user = $('#mysql_user').val();
			var mysql_password = $('#mysql_password').val();
			var smtp_host = $('#smtp_host').val();
			var smtp_port = $('#smtp_port').val();
			var smtp_user = $('#smtp_user').val();
			var smtp_pwd = $('#smtp_pwd').val();
			$.post('install_controller.php',{HOME_DIR:HOME_DIR,
											LOCAL_DIR:LOCAL_DIR,
											mysql_host:mysql_host,
											mysql_user:mysql_user,
											mysql_password:mysql_password,
											smtp_host:smtp_host,
											smtp_port:smtp_port,
											smtp_user:smtp_user,
											smtp_pwd:smtp_pwd},
			function(data)
			{
				$('#message1').html(data);
				$('#message2').html(data);
				$('#message3').html(data);
			});
		}
		</script>
		<style type="text/css">
			.center,.center button
			{
				margin-right: auto;
				margin-left: auto;
			}
			input
			{
				border-radius: 6px 6px 6px;
			}
			.formulaire>*
			{
				border:2px solid white;
				background-color: #C6C6C6;
				padding: 15px;
				border-radius: 10px 10px 10px;
				box-shadow: 0px 0px 3px 3px #2B2B2B;
			}
			button
			{
				background-color: #5385F8;
				padding: 2px;
				padding-right: 7px;
				padding-left: 7px;
				border-radius: 10px 10px 10px;
				box-shadow: 0px 0px 3px 2px #6793F9;
				border: 0;
			}
		</style>
	</head>
	<body id = 'container'>
		<div>
			<table class ='center' style = 'margin-bottom:15px;'>
				<tr>
					<td><button id = 'next' onClick = 'previous();'>Precedant</button></td>
					<td><button id = 'back' onClick = 'next();'>Suivant</button></td>
				</tr>
			</table>
			<div id = 'form1' class = 'formulaire'>
				<table class = 'center'>
					<tr>
						<th colspan = '2' style = 'border-bottom:2px solid black;'>Chemins</th>
					</tr>
					<tr>
						<td><label for = 'HOME_DIR'>HOME_DIR</label></td>
						<td><input type = 'text' id = 'HOME_DIR'></td>
					</tr>
					<tr>
						<td><label for = 'LOCAL_DIR'>LOCAL_DIR</label></td>
						<td><input type = 'text' id = 'LOCAL_DIR' value = "<?php echo str_replace("/install.php","",$_SERVER['SCRIPT_FILENAME'])."/";?>" readonly></td>
					</tr>
					<tr>
						<td colspan = '2'><button id = 'ok' onClick = 'ok();'>OK</button></td>
					</tr>
					<tr id = 'message1'></tr>
				</table>
			</div>
			<div id = 'form2' class = 'formulaire' style = 'display:none;'>
				<table class = 'center'>
					<tr>
						<th colspan = '2' style = 'border-bottom:2px solid black;'>Mysql</th>
					</tr>
					<tr>
						<td><label for = 'mysql_host'>mysql host</label></td>
						<td><input type = 'text' id = 'mysql_host'></td>
					</tr>
					<tr>
						<td><label for = 'mysql_user'>mysql user</label></td>
						<td><input type = 'text' id = 'mysql_user'></td>
					</tr>
					<tr>
						<td><label for = 'mysql_password'>mysql password</label></td>
						<td><input type = 'text' id = 'mysql_password'></td>
					</tr>
					<tr>
						<td colspan = '2'><button id = 'ok' onClick = 'ok();'>OK</button></td>
					</tr>
					<tr id = 'message2'></tr>
				</table>
			</div>
			<div id = 'form3' class = 'formulaire' style = 'display:none'>
				<table class = 'center'>
					<tr>
						<th colspan = '2' style = 'border-bottom:2px solid black;'>SMTP</th>
					</tr>
					<tr>
						<td><label for = 'smtp_host'>smtp host</label></td>
						<td><input type = 'text' id = 'smtp_host' value = 'smtp.gmail.com'></td>
					</tr>
					<tr>
						<td><label for = 'smtp_port'>smtp port</label></td>
						<td><input type = 'text' id = 'smtp_port' value = '587'></td>
					</tr>
					<tr>
						<td><label for = 'smtp_user'>smtp user</label></td>
						<td><input type = 'text' id = 'smtp_user' value = 'jarchive.esto@gmail.com'></td>
					</tr>
					<tr>
						<td><label for = 'smtp_pwd'>smtp password</label></td>
						<td><input type = 'password' id = 'smtp_pwd' value = 'hamzarachidabdessamadamine'></td>
					</tr>
					<tr>
						<td colspan = '2'><button id = 'ok' onClick = 'ok();'>OK</button></td>
					</tr>
					<tr id = 'message3'></tr>
				</table>
			</div>
		</div>
	</body>

</html>