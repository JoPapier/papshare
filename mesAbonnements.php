<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$abonne = Cfg::$abonne;
$abonne->afficherAbonnement();
$tabAbonnement = $abonne->afficherAbonnement();
$nombre = $abonne->compterAbonnement();
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/editer.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
			<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<meta charset="UTF-8">
		<title>PapSHARE / Mes abonnements</title>
	</head>
	<body style="background-color:#d5d7d4;">
		<?php require_once 'inc/header.php'; ?>
		<div id="container1" >
			<div class="d-flex justify-content-center"><h2>J'ai accès au photos de <?=$nombre?> utilisateur(s).</h2></div>
			<div class="d-flex justify-content-center">
			<?php
			foreach ($tabAbonnement as $abonne) {
				?>	
				<div class="card text-center" style="width: 18rem;">
					<img class="card-img-top" src="img/icone/avatar.jpeg"  alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title"><?= $abonne->nom . " " . $abonne->prenom; ?></h5>
						<p class="card-text"><?= $abonne->pseudo ?><br><?= $abonne->email ?></p>
					</div>
					<button type="button" class="btn btn-danger" onclick="supprimerAbonne(event,<?= $abonne->id_abonne ?>)">Supprimer cet abonné ?</button>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<footer></footer>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
</body>
</html>
