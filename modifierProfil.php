<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$cnx = Connexion::getInstance();
$tabErreur = [];
$opt = ['min_range' => 1];
$abonne = new Abonne();
$abonne->id_abonne = Cfg::$abonne->id_abonne;
$abonne->id_abonne = filter_input(INPUT_GET, 'id_abonne', FILTER_VALIDATE_INT, $opt);
$abonne->charger();

//arriver en POST après validation du formulaire.
if (filter_input(INPUT_POST, 'submit')) {

	$abonne->id_abonne = filter_input(INPUT_POST, 'id_abonne', FILTER_VALIDATE_INT, $opt);
	$abonne->pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->date_creation = filter_input(INPUT_POST, 'date_creation', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$tabDateCrea = date_parse_from_format('Y-m-d', $abonne->date_creation);
	if ($tabDateCrea['errors']) {
		$tabErreur[] = "Date absente ou invalide";
	} else {
		$annee = $tabDateCrea['year'];
		$mois = $tabDateCrea['month'];
		$jour = $tabDateCrea['day'];
		if (!$abonne->date_creation || !checkdate($mois, $jour, $annee))
			$tabErreur[] = "Date absente ou invalide";
	}
	if (!$tabErreur) {
		$abonne->mdp = password_hash($abonne->mdp, PASSWORD_DEFAULT);
		$abonne->sauver();
		header("Location:monProfil.php");
		exit;
	}
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
		<div id="container">
			<div class="erreur"><?= implode('<br>', $tabErreur) ?></div>
			<form name="form1" action="modifieProfil.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_abonne" value="<?= $abonne->id_abonne ?>"/>
				<input type="hidden" name="date_creation" value="<?= $abonne->date_creation ?: date('Y-m-d') ?>"/>
				<div><img src="img/avatar.jpg" alt=""/>
					<div class="item">
						<label>Pseudo</label>
						<input type="text" class="nom" name="pseudo" value="<?= $abonne->pseudo ?>" maxlength="50" ><br>
						<label>Nom</label>
						<input type="text" class="nom" name="nom" value="<?= $abonne->nom ?>" maxlength="50" ><br>
						<label>Prénom</label>
						<input type="text" name="prenom" value="<?= $abonne->prenom ?>" size="10" maxlength="10" ><br>
						<label>Mot de passe</label>
						<input type="password" name="mdp" value="<?= $abonne->mdp ?>" size="9" min="0.01" max="99999999" step="0.01"><br>
						<label>Email</label>
						<input type="email" class="nom" name="email" value="<?= $abonne->email ?>" maxlength="50" ><br>
					</div>
					<div class="item">
						<label></label>
						<div>
							<input class="button" type="button" value="<?= I18n::get('FORM_LABEL_CANCEL') ?>" onclick="annuler(<?= $abonne->id_abonne ?>)"/>
							<input class="button" type="submit" name="submit" value="<?= I18n::get('FORM_LABEL_SUBMIT') ?>"/>
						</div>
					</div>
				</div>
			</form>
		</div>
		<footer></footer>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
</body>
</html>
