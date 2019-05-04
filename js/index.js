function detailPhoto(id_photo) {
	location = `detailPhoto.php?id_photo=${id_photo}`;
}
function ajouterImage(id_abonne) {
	location = `ajouterPhoto.php?id_abonne=${id_abonne}`;
}
function editerProduit(evt, id_album) {
	evt.stopPropagation();
	location = `editer.php?id_album=${id_album}`;
}
function modifierProfil(evt, id_abonne) {
	evt.stopPropagation();
	location = `modifierProfil.php?id_abonne=${id_abonne}`;
}
function supprimerPhoto(evt, id_photo) {
	evt.stopPropagation();
	if (confirm("Vraiment supprimer ?")) {
		let url = 'supprimerPhoto.php?id_photo='+id_photo;

		fetch(url)
						.then(response => {
							if (response.ok)
								location.reload();
						})
						.catch(error => console.error(error));
	}
}
function suivreAbonne(id_abonne) {
	location = `voirProfil.php?id_abonne=${id_abonne}`;

}
function ajouterAbonne(evt, id_abonne) {
	evt.stopPropagation();
	if (confirm("Vraiment ajouter?")) {
		let url = 'ajouterAbonne.php?id_abonne='+id_abonne;

		fetch(url)
						.then(response => {
							if (response.ok)
								location.reload();
						})
						.catch(error => console.error(error));
	}
}
function rejeterAbonne(evt, id_abonne) {
	evt.stopPropagation();
	if (confirm("Vraiment supprimer?")) {
		let url = 'rejeterAbonne.php?id_abonne='+id_abonne;

		fetch(url)
						.then(response => {
							if (response.ok)
								location.reload();
						})
						.catch(error => console.error(error));
	}
}
function supprimerAbonnement(evt, id_abonne) {
	evt.stopPropagation();
	if (confirm("Vraiment supprimer cet abonnement?")) {
		let url = 'supprimerAbonnement.php?id_abonne='+id_abonne;

		fetch(url)
						.then(response => {
							if (response.ok)
								location.reload();
						})
						.catch(error => console.error(error));
	}
}
function supprimerAbonne(evt, id_abonne) {
	evt.stopPropagation();
	if (confirm("Vraiment supprimer cet abonné?")) {
		let url = 'supprimerAbonne.php?id_abonne='+id_abonne;

		fetch(url)
						.then(response => {
							if (response.ok)
								location.reload();
						})
						.catch(error => console.error(error));
	}
}