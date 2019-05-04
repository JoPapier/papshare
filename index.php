<?php
require_once "class/Cfg.php";
$abonne = new Abonne();
$album = new Album();
$cnx = Connexion::getInstance();
$tabErreur = [];
$opt = ['min_range' => 1];
$album->id_abonne = $abonne->id_abonne;
$album->id_album = $abonne->id_abonne;

if (filter_input(INPUT_POST, 'submit')) {
	$album->id_abonne = $abonne->id_abonne;
	$album->id_album = $abonne->id_abonne;
	$abonne->id_abonne = filter_input(INPUT_POST, 'id_abonne', FILTER_VALIDATE_INT, $opt);
	$abonne->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
	if (!$abonne->email) {
		$tabErreur [] = "Veuillez saisir un e-mail valide";
	}
	if (!$abonne->pseudo) {
		$tabErreur [] = "Veuillez saisir un pseudo";
	}

	if (!$tabErreur) {
		$abonne->mdp = password_hash($abonne->mdp, PASSWORD_DEFAULT);
		$abonne->sauver();
		{
			if (!$tabErreur && $abonne->login()) {
				header('Location:actualite.php');
				exit;
			}
		}
		header("Location:actualite.php");
		exit;
	}
	$tabErreur[] = i18n::get('FORM_ERR_LOGIN');
	$album->sauver();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="css/papshare.css" rel="stylesheet" type="text/css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PapSHARE / Inscription</title>
  </head>
  <body>
    <form class="form1" action="index.php" method="post"> 
			<input type="hidden" name="id_abonne" value="<?= $abonne->id_abonne ?>"/>
			<input type="hidden" name="date_creation" value="<?= $abonne->date_creation ?: date('Y-m-d') ?>"/>
			<input type="hidden" name="id_album" value="<?= $album->id_album ?>"/>
      <div class="text-center mb-4">
        <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">P.a.p SHARE</h1>
        <p>Connecte-toi vite, partage tes publications</p>
      </div>
			<div class="form-label-group">
				<input type="hidden" class="form-control" disabled="disabled" placeholder="Date_creation" type='date' required="required" name="date_creation" value="<?= $abonne->date_creation ?: date('Y-m-d') ?>"/>
        <label for="inputPseudo"></label>
      </div>
      <div class="form-label-group">
        <input class="form-control" placeholder="Email" type='pseudo' required="required" name="email" value="<?= $abonne->email ?>"/>
        <label for="inputPseudo"></label>
      </div>
      <div class="form-label-group">
        <input class="form-control" placeholder="Pseudonyme" required="required" name="pseudo" value="<?= $abonne->pseudo ?>"/>
        <label for="inputPassword"></label>
      </div>
      <div class="form-label-group">
        <input class="form-control" placeholder="Mot de passe" type='password'required="required" name="mdp" value="<?= $abonne->mdp ?>" />
        <label for="inputPassword"></label>
      </div>
			<div class="form-label-group">
        <input class="form-control" placeholder="Nom (facultatif)" name="nom" value="<?= $abonne->nom ?>" />
        <label for="inputPassword"></label>
      </div>
			<div class="form-label-group">
        <input class="form-control" placeholder="Prénom (facultatif)" name="prenom" value="<?= $abonne->prenom ?>" />
        <label for="inputPassword"></label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="s'inscrire"/> S'inscrire</button>
	</form>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div class="item text-center"> <label><a href="connexion.php">Vous avez déjà un compte ?</a></label>
		<footer><p class="mt-5 mb-3 text-muted text-center">© 2017-2018</p></footer>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
		
</body>
</html>
