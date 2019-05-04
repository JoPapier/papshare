<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$tabPhoto = Cfg::$abonne->verifierAlbum();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="css/papshare.css" rel="stylesheet" type="text/css"/>
		<title>PapSHARE / Actualité </title>
		<script src="js/index.js" type="text/javascript"></script>	
	</head>
	<body>
		<?php require_once 'inc/header.php' ?>
		<div id="container1">
			<?php
			foreach ($tabPhoto as $photo) {
				$idImg = file_exists("img/prod_{$photo->id_photo}_v.jpg") ? $photo->id_photo : 0;
				?>
				<div class="produit" onclick="detailPhoto(<?= $photo->id_photo ?>)">
					<div class="blocPhoto" style="background-color: #dcdedb">
						<div class="pseudo"><?= $photo->pseudo ?></div>
						<img style="cursor:pointer" src="img/prod_<?= $idImg ?>_v.jpg?alea=<?= rand() ?>"/>
						<div class="date"><?= $photo->date_time ?></div>
						<div class="legende"><?= $photo->legende ?></div>
					</div>
				</div>
			<?php } ?>
		</div>
		<footer></footer>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>






