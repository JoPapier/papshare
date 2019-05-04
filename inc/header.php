<header>
	<nav class="navbar navbar-light" style="background-color:#d5d7d4;">
		<a class="navbar-brand" href="monProfil.php" ><?= Cfg::$abonne->pseudo ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="mesActualites.php">Photos <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item active dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Home
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="mesAbonnes.php">Mes abonnés</a>
						<a class="dropdown-item" href="mesAbonnements.php">Mes abonnements</a>
						<a class="dropdown-item" href="rechercherUtilisateur.php">Recherche d'abonnés</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="mesPhotos.php">Mes photos</a>
						<a class="dropdown-item" href="ajouterPhoto.php">Ajouter une photo</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="monProfil.php">Mon profil</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="deconnexion.php">Déconnexion</a>
				</li>
			</ul>
		</div>
	</nav>

</header>
