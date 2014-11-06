<?php

if(isset($_POST['HOME_DIR']) && isset($_POST['LOCAL_DIR'])
	&& isset($_POST['mysql_host']) && isset($_POST['mysql_user'])
	&& isset($_POST['mysql_password'])
	&& !empty($_POST['HOME_DIR']) && !empty($_POST['LOCAL_DIR'])
	&& !empty($_POST['mysql_host']) && !empty($_POST['mysql_user'])
	&& isset($_POST['smtp_host']) && !empty($_POST['smtp_host'])
	&& isset($_POST['smtp_port']) && !empty($_POST['smtp_port'])
	&& isset($_POST['smtp_user']) && !empty($_POST['smtp_user'])
	&& isset($_POST['smtp_pwd']) && !empty($_POST['smtp_pwd']))
{
	$HOME_DIR = $_POST['HOME_DIR'];
	$LOCAL_DIR = $_POST['LOCAL_DIR'];
	$mysql_user = $_POST['mysql_user'];
	$mysql_password = $_POST['mysql_password'];
	$mysql_host = $_POST['mysql_host'];

	$SMTP_HOST = $_POST['smtp_host'];
	$SMTP_PORT = $_POST['smtp_port'];
	$SMTP_USER = $_POST['smtp_user'];
	$SMTP_PWD = $_POST['smtp_pwd'];


	$pos = strripos($HOME_DIR,'/');
	if((($pos + 1) != (strlen($HOME_DIR))) || (!$pos))
	{
		$HOME_DIR = $HOME_DIR."/";
	}
	$pos = strpos($HOME_DIR,'http://');
	if($pos === false)
	{
		$HOME_DIR = "http://".$HOME_DIR;
	}
	$content = @file_get_contents($HOME_DIR."includes/index.html");
	if($content == "yes it is")
	{
		@$connect = mysql_connect($mysql_host,$mysql_user,$mysql_password);
		if($connect)
		{
			//writing to config.php

			$File = "includes/config.php"; 
			$Handle = fopen($File,'w');
			$Data = "<?php\n".
					"include_once('functions.php');\n".
					"preventFromCall();\n".
					"@define(HOME_DIR,'".$HOME_DIR."');\n".
					"@define(LOCAL_DIR,'".$LOCAL_DIR."');\n".
					"@define(SMTP_HOST,'".$SMTP_HOST."');\n".
					"@define(SMTP_PORT,'".$SMTP_PORT."');\n".
					"@define(SMTP_USER,'".$SMTP_USER."');\n".
					"@define(SMTP_PWD,'".$SMTP_PWD."');\n".
					"?>";
			fwrite($Handle,$Data); 
			fclose($Handle);

			//writing to database.php

			$File = "includes/database.php"; 
			$Handle = fopen($File,'w');
			$Data = "<?php\n".
					"include_once('functions.php');\n".
					"preventFromCall();\n".
					'$server = "'.$mysql_host.'";'."\n".
					'$database = "jarchive";'."\n".
					'$user = "'.$mysql_user.'";'."\n".
					'$pass = "'.$mysql_password.'";'."\n".
					'@$connect = mysql_connect($server,$user,$pass);'."\n".
					'@mysql_set_charset("utf8");'."\n".
					'if(!$connect)'."\n".
					'{'."\n".
					'die("Erreur ! [connection impossible avec les données \'"'."\n".
					'.$server."\', \'".$user."\', \'".$pass."\']");'."\n".
					'}'."\n".
					'if(!mysql_select_db($database))'."\n".
					'{'."\n".
					'die(\'Erreur ! [selection de la base de données \'.$database.\' impossible]\');'."\n".
					'}'."\n".
					"?>";
			fwrite($Handle,$Data); 
			fclose($Handle);
			mysql_query("create database jarchive",$connect);
			mysql_select_db("jarchive");

$query = mysql_query("
CREATE TABLE IF NOT EXISTS admins (
  id int(11) NOT NULL,
  nom varchar(30) NOT NULL,
  prenom varchar(30) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(25) NOT NULL,
  PRIMARY KEY (id)
);",$connect);
mysql_query("

CREATE TABLE IF NOT EXISTS archive (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  doc_id int(11) NOT NULL,
  date_ajout date NOT NULL,
  PRIMARY KEY (id)
);",$connect);
mysql_query("

CREATE TABLE IF NOT EXISTS documents (
  id int(11) NOT NULL,
  sujet varchar(70) NOT NULL,
  description mediumtext NOT NULL,
  file_name varchar(10) NOT NULL,
  pfe_stage tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY file_name (file_name),
  UNIQUE KEY file_name_2 (file_name)
);",$connect);
mysql_query("

CREATE TABLE IF NOT EXISTS encadrants (
  id int(11) NOT NULL,
  nom varchar(30) NOT NULL,
  prenom varchar(30) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(25) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
);",$connect);
mysql_query("

CREATE TABLE IF NOT EXISTS etudiants (
  id int(11) NOT NULL,
  nom varchar(30) NOT NULL,
  prenom varchar(30) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(25) NOT NULL,
  filiere varchar(30) NOT NULL,
  code_etudiant varchar(10) NOT NULL,
  isBlocked tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
);",$connect);
mysql_query("
CREATE TABLE IF NOT EXISTS notifications (
  id int(11) NOT NULL,
  id_user_from int(11) NOT NULL,
  type_from int(3) NOT NULL,
  id_user_to int(11) NOT NULL,
  type_to int(3) NOT NULL,
  notification_txt mediumtext NOT NULL,
  PRIMARY KEY (id)
);",$connect);
mysql_query("
CREATE TABLE IF NOT EXISTS archive_2 (
  id int(11) NOT NULL,
  encadrant varchar(70) NOT NULL,
  doc_id int(11) NOT NULL,
  date_ajout date NOT NULL,
  PRIMARY KEY (id)
);",$connect);


mysql_query("
INSERT INTO admins (id, nom, prenom, email, password) VALUES(1, 'Admin', 'Admin', 'admin@jarchive.com', 'admin');
",$connect);
			if($query)
			{
				if(unlink('install.php') && unlink('install_controller.php'))
				{
					die("<div style = 'color:green'>tout est cool!</div>");
				}
				else
				{
					die("<div style = 'color:green'>we could not delete install.php and install_controller.php please delete them manually!</div>");
				}
			}
			else
			{
				echo mysql_error($connect);
				die("<div style = 'color:red'>données non inséré dans la base de données</div>");
			}
		}
		else
		{
			die("<div style = 'color:red'>connection impossible au mysql avec les données fournis</div>");
		}
	}
	else
	{
		die("<div style = 'color:red'>HOME_DIR invalid!</div>");
	}
}
else
{
	die("<div style = 'color:red'>Veuillez remplir les champs correctement!</div>");
}

?>