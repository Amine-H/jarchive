<?php
	require_once('functions.php');
	preventFromCall();
?>

<script type="text/javascript">

$('#index').addClass('active');

</script>
<div class = 'well'>
	<div class = 'row-fluid'>
		<div>
			<video class = 'span6 box_style' controls>
				<source src="jarchive.mp4" type="video/mp4">
				<source src="jarchive.ogv" type="video/ogg">
				ton navigateur ne support pas le html5 veuillez utiliser un navigateur recent!, ou télécharger la video d'<a href = "<?php echo HOME_DIR?>vid.mp4">ICI</a>
			</video>
		</div>
		<div class = 'span6 box_style'>
			<h4>Ajouter votre documents</h4>
			<p>vous pouvez ajouter les documents de votre PFE/Stage facilement</p>
			<a class = 'btn btn-primary' href="<?php echo HOME_DIR?>index.php/addDocument">Ajouter document</a>
		</div>
		<div class = 'span6 box_style'>
			<h4>Voir les documents ajouté</h4>
			<p>vous pouvez voir les documents ajouté par les etudiants</p>
			<a class = 'btn btn-primary' href="<?php echo HOME_DIR?>index.php/docs">Voir documents</a>
		</div>
	</div>
</div>