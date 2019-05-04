<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}

$photo = new Photo();
$abonne = new Abonne();
$opt = ['min_range' => 1];
$photo->id_photo = filter_input(INPUT_GET, 'id_photo', FILTER_VALIDATE_INT, $opt);
$profil = $photo->detailPhoto();

if (!$photo->charger()) {
	header("Location:mesActualites.php");
	exit;
}
$idImg = file_exists("img/prod_{$photo->id_photo}_p.jpg") ? $photo->id_photo : 0;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>PapSHARE / Détail</title>
		<link href="css/papshare.css" rel="stylesheet" type="text/css"/>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
			var marker;
			var map;
			function setMarker(pos) {
				map.setCenter(pos);
				marker.setPosition(pos);
			}
			function map() {
				map = new google.maps.Map(document.getElementById('map2'), {
					zoom: 18
				});
				var pos = new google.maps.LatLng(<?= $photo->latitude ?>,<?= $photo->longitude ?>);
				marker = new google.maps.Marker();
				marker.setMap(map);
				setMarker(pos);
			}
		</script>
	</head>
	<body onload="map()">
		<?php require_once 'inc/header.php'; ?>
		<div id="container">
			<div class="card text-center" style="width: 23rem;">
				<div class="card-header">
					<?= $profil[0]->pseudo ?>
				</div>
				<div class="card-group">
					<div class="card">
						<img class="card-img-top" src="img/prod_<?= $idImg ?>_p.jpg?alea=<?= rand() ?>" alt="Card image cap"> 
						<div id="map2"></div>
						<div class="card-body">
							<h5 class="card-title"></h5>
						</div>
						<div class="card-footer">
							<small class="text-muted"> Postée le <?= $profil[0]->date_time ?></small>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMTsTjSEdJS3I8Po0NObBqC6eJz0KIcew&callback=localisation"
		type="text/javascript"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
