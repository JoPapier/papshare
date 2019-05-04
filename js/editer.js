function afficherPhoto(files) {
	var vignette = document.querySelector('#vignette');
	vignette.style.backgroundImage = '';
	if (!files || !files.length)
		return;
	var file = files[0];
	if (!file.size)
		return alert("Erreur : empty file.");
	if (file.size > MAX_FILE_SIZE)
		return alert("Error : file too big.");
	var ext = file.name.split('.').pop();
	if (TAB_EXT.length && !TAB_EXT.includes(ext))
		return alert("Error : file extension not allowed.");
	if (TAB_MIME.length && !TAB_MIME.includes(file.type))
		return alert("Error : file MIME type not allowed.");
	var reader = new FileReader();
	reader.onload = function () {
		vignette.style.backgroundImage = `url(${this.result})`;
	}
	reader.readAsDataURL(file);
}
function annuler(id_photo = 0) {
	document.querySelector('form1').reset();
	document.querySelector('#vignette').style.backgroundImage = `url(img/prod_${id_photo}_v.jpg)`;
	document.querySelector('.erreur').innerHTML = '';
}




