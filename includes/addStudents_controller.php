<?php
	include_once('functions.php');
	include_once('config.php');
	include_once('database.php');
	include_once('phpMailer/class.phpmailer.php');
	preventFromCall();
	redirectIfNotType(2);
?>

<div class = 'well'>
	<?php
		$fichier = $_FILES["fichier"];
		if($fichier['error'] == 0)
		{
			if(in_array($fichier['type'],array('application/vnd.ms-excel')))
			{
				$c = 0;
				$data = file($fichier['tmp_name']);
				for($i = 1;$i < count($data);$i++)
				{
					$data[$i] = trim($data[$i]);
					$line = explode(";",$data[$i]);

					if(count($line) != 5)
					{
						echo "
							<div style = 'color:red'>
								Veuillez modifier votre csv
								, seul les champs suivantes sonts autorisé :
								Nom,Prenom,Filiere,Code Etudiant,Email ,et veuillez recspecter l'ordre
							</div>
						";
						break;
					}
					else
					{
						$randPass = substr(md5("jarchive_salt".rand()),0,10);
						$email_to = synthetize($line[4]);

						$mail = new PHPMailer;
						$mail->IsSMTP();
						$mail->Host = SMTP_HOST;
						$mail->Port = SMTP_PORT;
						$mail->CharSet = 'utf-8'; 
						$mail->SMTPAuth = true;
						$mail->Username = SMTP_USER;
						$mail->Password = SMTP_PWD;
						$mail->SMTPKeepAlive = true;  
						$mail->Mailer = "smtp";
						$mail->SMTPDebug = 0;
						$mail->SMTPSecure = 'tls';
						$mail->From = SMTP_USER;
						$mail->FromName = "j'Archive";
						$mail->AddAddress($email_to);
						$mail->IsHTML(true);
						$mail->Subject = "Mot de passe j'Archive [ESTO]";
						$mail->Body    = "Salut <b>".$line[0]." ".$line[1]."</b>,<br>Votre Mot de passe est :".$randPass."<br>".
								"Equipe j'Archive.";
						$mail->AltBody = "Salut ".$line[0]." ".$line[1].",\nVotre Mot de passe est :".$randPass."\n".
								"Equipe j'Archive.";
						$cTMP = $c;
						if(!$mail->Send())
						{
							$c++;
						}
						if($c == $cTMP)
						{
							User::register(synthetize($line[0]),synthetize($line[1]),$email_to,$randPass,
								synthetize($line[2]),synthetize(strtolower($line[3])),$connect);
						}
					}
				}
				if($c != 0)
				{
					echo "
							<div style = 'color:red'>
								some messages didn't reach it's destination
							</div>
						";
				}
				else
				{
					echo "<div style = 'color:green'>les etudiants sont bien enregistré!</div>";
				}
			}
			else
			{
				echo "
						<div style = 'color:red'>
							Veuillez Importer un fichier csv!
						</div>
					";
			}			
		}
		else
		{
			echo "
					<div style = 'color:red'>
						erreur !, peut etre que le fichier est trop volumineux,
						 ou votre configuration php n'est pas correct
					</div>
				";
		}

	?>
</div>