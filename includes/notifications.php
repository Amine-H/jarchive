<?php
	include_once('functions.php');
	preventFromCall();
?>

<?php

redirectIfNotLoggedOn();

?>

<div class = "well">
	<table class = 'table table-striped'>
		<thead>
			<tr>
				<th>Notification du</th>
				<th>Notification</th>
			</tr>
		</thead>
		<tbody>
			<?php

				$query = mysql_query("select id_user_from,type_from,notification_txt from notifications where id_user_to = '".User::getId()."' and type_to='".User::getType()."' order by id desc",$connect);

				$rCount = mysql_num_rows($query);

				if($rCount == 0)
				{
					echo "
						<tr>
							<td colspan = '2' style = 'text-align:center;'> Pas de notifications!</td>
						</tr>
						";
				}
				else
				{
					for($i = 0;$i < $rCount;$i++)
					{
						$row = mysql_fetch_assoc($query);
						if($row['type_from'] == 0)//etudiants
						{
							$query2 = mysql_query("select nom,prenom from etudiants where id = '".$row['id_user_from']."'",$connect);
							if(mysql_num_rows($query2) != 1){continue;}
							$row2 = mysql_fetch_assoc($query2);
							echo "
									<tr>
										<td>".ucfirst($row2['nom'])." ".ucfirst($row2['prenom'])."</td>
										<td>".$row['notification_txt']."</td>
									</tr>
								";
						}
						else if($row['type_from'] == 1)//encadrants
						{
							$query2 = mysql_query("select nom,prenom from encadrants where id = '".$row['id_user_from']."'",$connect);
							if(mysql_num_rows($query2) != 1){continue;}
							$row2 = mysql_fetch_assoc($query2);
							echo "
									<tr>
										<td>".ucfirst($row2['nom'])." ".ucfirst($row2['prenom'])."</td>
										<td>".$row['notification_txt']."</td>
									</tr>
								";
						}
					}
				}

			?>
		</tbody>
	</table>
</div>