<?php
require_once 'class/Cfg.php';
$tabErreur = [];
$abonne = new Abonne();
// Arrivée en POST après validation du formulaire.
if (filter_input(INPUT_POST, 'submit')) {
	$abonne->pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$abonne->mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if (!$abonne->pseudo) {
		$tabErreur[] = I18n::get('FORM_ERR_LOG');
	}
	if (!$abonne->mdp) {
		$tabErreur[] = I18n::get('FORM_ERR_MDP');
	}
	if (!$tabErreur && $abonne->login()) {
		header('Location:actualite.php');
		exit;
	}
	$tabErreur[] = I18n::get('FORM_ERR_LOGIN');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="css/papshare.css" rel="stylesheet" type="text/css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PapSHARE / Connexion</title>
  </head>
  <body>
    <form class="form1" action="connexion.php" method="post"> 
      <div class="text-center mb-4">
        <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">P.a.p SHARE</h1>
        <p>Partage tes photos avec tes amis</p>
      </div>
			<div class="erreur"><?= implode('<br/>', $tabErreur) ?></div>
      <div class="form-label-group" <?= I18n::get('FORM_LABEL_LOG') ?>>
        <input class="form-control" placeholder="Pseudonyme" required="required" name="pseudo" value="<?= $abonne->pseudo ?>"/>
        <label for="inputPseudonyme"></label>
      </div>

      <div class="form-label-group" <?= I18n::get('FORM_LABEL_MDP') ?>>
        <input class="form-control" placeholder="Mot de passe" type='password'required="required" name="mdp" value="<?= $abonne->mdp ?>" />
        <label for="inputPassword"></label>
      </div>
			<div class="item text-center"> <label><a href="index.php">J'ai oublié mon mot passe </a></label></div>
			<label></label>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="<?= I18n::get('FORM_LABEL_CONNECT') ?>">Se connecter</button>
		</form>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div class="item text-center"> <label><a href="index.php">Vous n'êtes pas encore inscrit ?</a></label></div>
		<p class="mt-5 mb-3 text-muted text-center">© 2017-2018</p>    
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </body>
</html>
