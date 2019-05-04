<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}

$abonne = new Abonne();
$tabAbonne = Cfg::$abonne->afficherProfil();
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/editer.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title></title>
	</head>
	<body>
		<?php require_once 'inc/header.php'; ?>
		<div id="container">
			<ul class="list-group max-width: 400px;">
				<li class="list-group-item disabled">Liste des abonnés sur le site</li>
				<?php
				foreach ($tabAbonne as $abonne) {
					?>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						<?= $abonne->pseudo ?>&nbsp;
						<button type="button" class="btn btn-light" style="background-color:#fdf1b8;" 
										onclick="suivreAbonne(<?= $abonne->id_abonne ?>)">Voir le profil</button></li>
						<?php
					}
					?>
			</ul>
		</div>
	</body>
</html>
