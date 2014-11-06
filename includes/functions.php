<?php
include 'config.php';

function synthetize($value)
{
	return htmlentities(mysql_real_escape_string($value));
}

function redirectIfNotType($type)
{
	if(!User::isConnected() || User::getType() != $type)
	{
		header('Location: '.HOME_DIR.'index.php/login');
	}
}

function redirectIfNotLoggedOn()
{
	if(!User::isConnected())
	{
		header('Location: '.HOME_DIR.'index.php/login');
	}
}

function redirectIfLoggedOn()
{
	if(User::isConnected())
	{
		header('Location: '.HOME_DIR.'index.php/member');
	}
}

function preventFromCall()
{
	if(strstr($_SERVER['REQUEST_URI'],"includes") && (!in_array($_SERVER['REMOTE_ADDR'],array('::1','127.0.0.1'))))
	{
		die("<center><h1>Erreur 404!</h1></center>");
	}
}

function listFilieres($connect)
{
	$query = mysql_query("select distinct filiere from etudiants",$connect);
	$row_count = mysql_num_rows($query);
	for ($i = 0;$i < $row_count;$i++)
	{
		$row = mysql_fetch_assoc($query);
		echo "<option value = '".$row['filiere']."'>".$row['filiere']."</option>";
	}
}

function listDocuments($connect,$type)
{
	if($type == 0)
	{
		$query = mysql_query("select id,sujet from documents where pfe_stage = '1'",$connect);
	}
	else if($type == 1)
	{
		$query = mysql_query("select id,sujet from documents where pfe_stage = '0'",$connect);
	}
	else if($type == 2)
	{
		$query = mysql_query("select id,sujet from documents",$connect);
	}
	$row_count = mysql_num_rows($query);
	for ($i = 0;$i < $row_count;$i++)
	{
		$row = mysql_fetch_assoc($query);
		echo "<option value = '".$row['id']."'>".$row['sujet']."</option>";
	}
}

function listDocuments_mc($connect,$motsCle,$pfe_stage)
{
	$motsCle = synthetize($motsCle);
	if(trim($pfe_stage) == 2)//convert the bloody pfe_stage to int
	{
		$pfe_stage_inQ = "where (";
	}
	else
	{
		$pfe_stage_inQ = "where pfe_stage = '$pfe_stage' and (";
	}

	$qString = "select distinct id,sujet from documents $pfe_stage_inQ ".
						"sujet LIKE '%$motsCle%' ".
						"OR description LIKE '%$motsCle%') ".
						"union select documents.id as id,sujet from documents,archive,etudiants $pfe_stage_inQ".
						"documents.id = doc_id and etudiants.id = user_id ".
						"and (etudiants.nom LIKE '%$motsCle%' OR etudiants.prenom LIKE '%$motsCle%'))";

	$query = mysql_query($qString,$connect);

	$row_count = mysql_num_rows($query);
	if($row_count == 0)
	{
		echo "<option>PAS DE RESULTATS</option>";
		echo $qString;
	}
	for ($i = 0;$i < $row_count;$i++)
	{
		$row = mysql_fetch_assoc($query);
		echo "<option value = '".$row['id']."'>".$row['sujet']."</option>";
	}
}

function listEncadrants($connect)
{
	$query = mysql_query("select id,nom,prenom from encadrants",$connect);
	$row_count = mysql_num_rows($query);
	for ($i = 0;$i < $row_count;$i++)
	{
		$row = mysql_fetch_assoc($query);
		echo "<option value = '".$row['id']."'>".$row['nom']." ".$row['prenom']."</option>";
	}
}

function listEtudiants($connect)
{
	$query = mysql_query("select id,nom,prenom from etudiants",$connect);
	$row_count = mysql_num_rows($query);
	for ($i = 0;$i < $row_count;$i++)
	{
		$row = mysql_fetch_assoc($query);
		echo "<option value = '".$row['id']."'>".ucfirst($row['nom'])." ".ucfirst($row['prenom'])."</option>";
	}
}

function listContentsOf($file_name)
{
	$za = new ZipArchive(); 

	$za->open($file_name); 

	echo "<table class = 'table table-striped wborders'>";
	echo "
		<thead>
			<tr>
				<th>Nom du fichier</th>
				<th>Taille du fichier</th>
			</tr>
	";
	echo "<tbody>";
	for( $i = 0; $i < $za->numFiles;$i++)
	{ 
	    $stat = $za->statIndex( $i ); 
	    echo "<tr>
	    		<td>".basename($stat['name'])."</td>".
	    		"<td>".(basename($stat['size'])/1000)."Ko</td>".
	    	"</tr>";
	}
	echo "</tbody></table>";
}

/**
* User Class
*/
class User
{
	public static function isExists($email,$connect)
	{
		$query = mysql_query("select * from admins,encadrants,etudiants where email='$email'",$connect);
		if($query)
		{
			$rCount = mysql_num_rows($query);
			return $rCount != 0;
		}
		else
		{
			return 0;
		}

	}
	public static function register($nom,$prenom,$email,$pwd,$filiere,$code_etudiant,$connect)
	{
		$query = mysql_query("select max(id) as maxid from etudiants",$connect);
		$row = mysql_fetch_assoc($query);
		$maxId = $row['maxid'] + 1;
		$nom = strtolower($nom);
		$prenom = strtolower($prenom);
		mysql_query("insert into etudiants values('$maxId','$nom','$prenom','$email','$pwd','$filiere','$code_etudiant','0');",$connect);
	}
	public static function isConnected()
	{
		return isset($_SESSION['id']);
	}
	public static function connect($id,$nom,$prenom,$type)
	{
		$_SESSION['id'] = $id;
		$_SESSION['nom'] = $nom;
		$_SESSION['prenom'] = $prenom;
		$_SESSION['type'] = $type;
	}
	public static function logout()
	{
		$_SESSION = array();
		session_destroy();
	}
	public static function getNom()
	{
		return ucfirst($_SESSION['nom']);
	}
	public static function getPrenom()
	{
		return ucfirst($_SESSION['prenom']);
	}
	public static function getId()
	{
		return $_SESSION['id'];
	}
	public static function getType()//encadrant : 1,etudiant : 0
	{
		return $_SESSION['type'];
	}
}


?>