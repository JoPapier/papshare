<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$cnx = Connexion::getInstance();
$tabErreur = [];
$album = new Album();
$photo = new Photo();
$up = new Upload('testUpload', Cfg::TAB_EXT, Cfg::TAB_MIME);
$opt = ['min_range' => 1];
$photo->latitude = filter_input(INPUT_GET, 'latitude', FILTER_VALIDATE_FLOAT);
$photo->longitude = filter_input(INPUT_GET, 'longitude', FILTER_VALIDATE_FLOAT);

// Arrivée en post après validation du formulaire
if (filter_input(INPUT_POST, 'submit')) {
	$photo->date_time = filter_input(INPUT_POST, 'date_time', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$photo->legende = filter_input(INPUT_POST, 'legende', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$photo->id_album = Cfg::$abonne->id_abonne;
	$photo->id_abonne = Cfg::$abonne->id_abonne;
	$photo->latitude = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
	$photo->longitude = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);

	$photo->sauver();

	if (!$tabErreur) {

		$cnx->start();

		$idImgUpload = $photo->id_photo;

		//traitement upload
		$upload = new Upload('photo', Cfg::TAB_EXT, Cfg::TAB_MIME);
		// Upload facultatif
		if ($upload->codeErreur === 4) {
			$cnx->commit();
			header("Location:mesPhotos.php");
			exit;
		}
		// Un upload a bien eu lieu.
		$tabErreur = array_merge($tabErreur, $upload->tabErreur);
		if (!$upload->tabErreur) {
			//Traitement de l'image
			$image = new Image($upload->cheminServeur);
			$tabErreur = array_merge($tabErreur, $image->tabErreur);
			if (!$image->tabErreur) {
				$image->copier(Cfg::IMG_P_LARGEUR, Cfg::IMG_P_HAUTEUR, "img/prod_{$idImgUpload}_p.jpg");
				$image->copier(Cfg::IMG_V_LARGEUR, Cfg::IMG_V_HAUTEUR, "img/prod_{$idImgUpload}_v.jpg");
				$tabErreur = array_merge($tabErreur, $image->tabErreur);
				if (!$image->tabErreur) {
					$cnx->commit();
					header("Location:mesPhotos.php");
					exit;
					$cnx->rollback();
				}
			}
		}
	}
}

$idImg = file_exists("img/prod_{$album->id_album}_v.jpg") ? $album->id_album : 0;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>PapShare</title>
		<script src="js/editer.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="css/papshare.css" rel="stylesheet" type="text/css"/>
		<script src="js/geolocalisation.js" type="text/javascript"></script>
		<script>
			const TAB_EXT = JSON.parse(`<?= json_encode(Cfg::TAB_EXT) ?>`);
			const TAB_MIME = JSON.parse(`<?= json_encode(Cfg::TAB_MIME) ?>`);
			const MAX_FILE_SIZE =<?= Upload::maxFileSize() ?>;
		</script>
	</head>
	<body onload="localisation()">
		<?php require_once 'inc/header.php'; ?>
		<div class="container">
			<div class="d-flex justify-content-center">
				<h1>Ajouter une photo</h1>
			</div>
			<div class="d-flex justify-content-center">
				<div class="erreur"><?= implode('<br>', $tabErreur) ?></div>
				<form name="form1" action="ajouterPhoto.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_album" value="<?= $album->id_album ?>"/>
					<input type="hidden" name="date_time" value="<?= $photo->date_time ?: date('Y-m-d') ?>"/>
					<input id="latitude" type="hidden" name="latitude" value="<?= $photo->latitude ?>"/>
					<input id="longitude" type="hidden" name="longitude" value="<?= $photo->longitude ?>"/>
					<div class="item">
						<label>Légende</label>
						<input type="text" class="nom" name="legende" value="<?= $photo->legende ?>" maxlength="50" ><br>
					</div>
					<div class="item">
						<label>Choisir une photo</label>
						<input type="file" id="photo" name="photo" onchange="afficherPhoto(this.files)"/>
						<input type="button" value="Ajouter" onclick="this.form.photo.click()"/>
						<input class="button" type="button" value="<?= I18n::get('FORM_LABEL_CANCEL') ?>" onclick="annuler(<?= $photo->id_photo ?>)"/>
						<input class="button" type="submit" name="submit" value="<?= I18n::get('FORM_LABEL_SUBMIT') ?>"/>
					</div>
				</form>
			</div>
			<div class="d-flex justify-content-around">
				<div id="vignette"></div>
				<div id="map"></div>
			</div>

			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMTsTjSEdJS3I8Po0NObBqC6eJz0KIcew&callback=localisation"type="text/javascript"></script>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
