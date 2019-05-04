<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$album = new Album();
$abonne_album = new Abonne_album();
$opt = ['min_range' => 1];
$album->id_abonne = Cfg::$abonne;
$album->id_album = Cfg::$abonne->id_abonne;
$abonne_album->id_abonne = Cfg::$abonne->id_abonne;
$afficher_profil = Cfg::$abonne->nouveauAbonne();
$tabAbonne = Cfg::$abonne->afficherAbonne();
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/editer.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<title>PapSHARE / Mes abonnés</title>
	</head>
	<body style="background-color:#eeeeee">
		<?php require_once 'inc/header.php'; ?>
		<div id="container1">
			<ul class="list-group" style="background-color:#eeeeee;">
				<li class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#eeeeee">
					Demande d'accès à mes photos en attente
					<span class="badge badge-primary badge-pill"><?= $album->lastAbonne() ?></span>
				</li>
				<?php
				foreach ($afficher_profil as $abonne) {
					?>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						<?= $abonne->nom ?>	&nbsp;<?= $abonne->prenom ?>&nbsp;&nbsp;
						<span><button type="button" class="btn btn-success" onclick="ajouterAbonne(event,<?= $abonne->id_abonne ?>)">Autoriser</button>&nbsp;<button type="button" class="btn btn-danger" onclick="rejeterAbonne(event,<?= $abonne->id_abonne ?>)">Ne pas autoriser</button></span>
					</li>
					<?php
				}
				?>
			</ul>
			<div class="d-flex justify-content-between">
			<?php
			foreach ($tabAbonne as $abonne) {
				?>	
				<div class="card text-center" style="width: 18rem;">
					<img class="card-img-top" src="img/icone/avatar.jpeg"  alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title"><?= $abonne->nom . " " . $abonne->prenom; ?></h5>
						<p class="card-text"><?= $abonne->pseudo ?><br><?= $abonne->email ?></p>
					</div>
					<button type="button" class="btn btn-danger"  onclick="supprimerAbonne(event,<?= $abonne->id_abonne ?>)">Supprimer cet abonné ?</button>
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
