<!doctype html>
<?php

session_start();
require_once("includes/database.php");
require_once("includes/functions.php");
require_once("includes/config.php");

?>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name= "viewport" content = "width=device-width, initial-scale=1.0">
		<title>
			j'Archive
			<?php
				if(User::isConnected()){echo " | ".User::getNom()." ".User::getPrenom();}
			?>
		</title>
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_DIR;?>css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_DIR;?>css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_DIR;?>css/style.css">
		<script type="text/javascript" src="<?php echo HOME_DIR;?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo HOME_DIR;?>js/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo HOME_DIR;?>js/carousel.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{
				$('.carousel').carousel('cycle');
			});
		</script>
	</head>
	<body>
		<div class = "navbar navbar-fixed-top">
			<div class = "navbar-inner">
				<div class = "container">
					<a class = "btn btn-navbar" data-toggle = "collapse" data-target = ".nav-collapse">
						<span class = "icon-th-list"></span>
					</a>
					<a class = 'brand' href="<?php echo HOME_DIR;?>index.php/index" style = 'font-size:2em;font-weight:bold;'>j'Archive</a>
					<div class = "nav-collapse collapse">
						<ul class = "nav pull-right">
							<li id = 'index'><a href="<?php echo HOME_DIR;?>index.php/index">Acceuil</a></li>
							<?php
								if(User::isConnected())
								{
									echo "<li id = 'member'><a href='".HOME_DIR."index.php/member'>Membre</a></li>";
									echo "<li id = 'logout'><a href='".HOME_DIR."index.php/logout'>Deconnexion</a></li>";
								}
								else
								{
									echo "<li id = 'login'><a href='".HOME_DIR."index.php/login'>Connexion</a></li>";
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class = "hero-unit">
				<div id="slider" class="carousel slide">
		            <div class="carousel-inner">
            			<div class="item active">
            				<img src="<?php echo HOME_DIR;?>img/j'Archive.jpg" class = 'slider_img'>
            			</div>
			            <div class="item">
			            	<img src="<?php echo HOME_DIR;?>img/j'Archive.jpg" class = 'slider_img'>
			            </div>
			            <div class="item">
			            	<img src="<?php echo HOME_DIR;?>img/j'Archive.jpg" class = 'slider_img'>
			            </div>
		            </div>
					<div class="carousel-caption">
            			<p>Ecole Supérieure de Technologie Oujda</p>
						<p>Application d'archivage des documents des PFE/Stages.</p>
					</div>
	              	<a class="carousel-control left"  href="#slider" data-slide="prev">&lsaquo;</a>
		            <a id = 'right' class="carousel-control right" href="#slider" data-slide="next">&rsaquo;</a>
                </div>
		</div>
		<div id = "contenu">
			<?php
			//les routes possibles (pages dans notre cas)
			$routes = array('index',
							'member',
							'login',
							'changePwd',
							'addStudents',
							'addEncadrant',
							'addStudents_controller',
							'addDocument',
							'addDocument_controller',
							'doc',
							'docs',
							'notify',
							'notifications',
							'blockEtu',
							'blockEnc',
							'checkReceipt',
							'logout');

			if(!empty($raw_route) and preg_match('/^[\p{L}\/\d]++$/uD',$_SERVER["PATH_INFO"]) == 0)//regex to find args
			{
				die("Invalid URL");
			}

			//0:empty 1:action name (page in our case) 2+:arguments
			$url_pieces = @explode("/",$_SERVER["PATH_INFO"]);
			$action = @$url_pieces[1];
			$params = array();//will be called from other files to get parameters

			if(count($url_pieces)>2)
			{
				$params = array_slice($url_pieces,2);
			}

			if(empty($action))
			{
				$action = "index";
			}

			if(in_array($action,$routes))
			{
				include("includes/".$action.".php");
			}
			else
			{
				include("includes/error.php");
			}
			?>
		</div>
		<!--footer -->
		<div id = "footer_wrapper" class="container">
			<div id="footer">
				<p>Copyright ESTO © 2013</p>
			</div>
		</div>
	</body>
</html>