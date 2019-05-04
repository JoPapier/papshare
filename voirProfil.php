<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}

$cnx = Connexion::getInstance();
$abonne_album = new Abonne_album();
$tabErreur = [];
$opt = ['min_range' => 1];
$abonne_album->id_album = filter_input(INPUT_GET, 'id_abonne', FILTER_VALIDATE_INT, $opt);
$album = (new Abonne($abonne_album->id_album))->charger();
$abonne_album->id_abonne = Cfg::$abonne->id_abonne;
if (filter_input(INPUT_POST, 'submit')) {
	$abonne_album->id_album = filter_input(INPUT_POST, 'id_album', FILTER_VALIDATE_INT, $opt);
	$abonne_album->id_abonne = Cfg::$abonne->id_abonne;
	$abonne_album->ok = 0;
	$abonne_album->sauver();
	header("Location:dashboard.php");
	exit;
}
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
			<div id="container1">
			<div class="card" style="width: 18rem">
				<img class="card-img-top" src="img/icone/avatar.jpeg"  alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title"><?= $album->nom . " " . $album->prenom; ?></h5>
					<p class="card-text"><?= $album->pseudo ?><br><?= $album->email ?></p>
					<?php if ((Cfg::$abonne != $album)) {
						?>
						<form name="form1" action="voirProfil.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="id_album" value="<?= $abonne_album->id_album ?>"/>
							<input type="hidden" name="id_abonne" value="<?= $abonne_album->id_abonne ?>"/>
							<input type="hidden" name="ok" value="<?= $abonne_album->ok ?>"/>
							<div>
								<input class="btn btn-primary" type="submit" name="submit" value="Voulez suivre cette utilisateur"/>
							</div>
						</form>
						<?php
					}
					?>	
				</div>
			</div>
		</div>
		<footer></footer>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
