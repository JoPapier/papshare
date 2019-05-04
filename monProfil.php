<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$profil = Cfg::$abonne->charger();
?>

<!DOCTYPE html>
<html>
	<head>
		<script src="js/editer.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>PapSHARE / Mon Profil</title>
	</head>
	<body>
		<?php require_once 'inc/header.php'; ?>
		<div id="container1">
			<div style="background-color: #dcdedb"><img src="img/avatar.jpg" alt=""/>
				<h2><?= $profil->nom . " " . $profil->prenom; ?></h2>
				<div>Quelques informations sur l'utilisateur: </div>
				<ul>
					<li>Votre pseudo est : <?= $profil->pseudo ?></li>
					<li>Votre mail est : <?= $profil->email ?></li>
					<li>Votre compte a été crée le : <?= $profil->date_creation ?></li>
					<li><button onclick="modifierProfil(event,<?= $profil->id_abonne ?>)">Modifier mon profil ?</button></li>
				</ul>
			</div>
		</div>
		<footer></footer>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
