<?php

class Image {

	public $tabErreur = []; // Renseigné si erreur.
	private $chemin; // Chemin du fichier.
	private $largeur; // Largeur en px.
	private $hauteur; // Hauteur en px.
	private $type; // Type PHP, ex : IMG_JPG.

	public function __construct($chemin) {
		$this->chemin = $chemin;
		list($this->largeur, $this->hauteur, $this->type) = getimagesize($chemin);
		if ($this->largeur === null) {
			$this->tabErreur[] = I18n::get('IMG_ERR_UNAVAILABLE');
			return;
		}
		if ($this->type !== IMAGETYPE_JPEG && $this->type !== IMAGETYPE_PNG) {
			$this->tabErreur[] = I18n::get('IMG_ERR_TYPE');
			return;
		}
	}

	public function copier($largeurCible, $hauteurCible, $cheminCible, $qualite = 60) {
		$ratioSource = $this->largeur / $this->hauteur;
		$ratioCible = $largeurCible / $hauteurCible;
		if ($this->largeur < $largeurCible && $this->hauteur < $hauteurCible) {
			if (!copy($this->chemin, $cheminCible))
				$this->tabErreur[] = I18n::get('IMG_ERR_CANT_WRITE');
			return;
		}
		if ($ratioSource > $ratioCible) {
			$largeurFinale = $largeurCible * $ratioSource;
			$hauteurFinale = $hauteurCible;
		} else {
			$largeurFinale = $largeurCible;
			$hauteurFinale = $hauteurCible / $ratioSource;
		}
		if (!$source = $this->type === IMAGETYPE_JPEG ? imageCreateFromJpeg($this->chemin) : imageCreateFromPng($this->chemin)) {
			$this->tabErreur[] = I18n::get('IMG_ERR_OUT_OF_MEMORY');
			return;
		}
		if (!$finale = imageCreateTrueColor($largeurFinale, $hauteurFinale)) {
			$this->tabErreur[] = I18n::get('IMG_ERR_OUT_OF_MEMORY');
			return;
		}
		if (!imageCopyResampled($finale, $source, 0, 0, 0, 0, $largeurFinale, $hauteurFinale, $this->largeur, $this->hauteur)) {
			$this->tabErreur[] = I18n::get('IMG_ERR_OUT_OF_MEMORY');
			return;
		}
		imageDestroy($source);
		if (!($this->type === IMAGETYPE_JPEG ? imageJPEG($finale, $cheminCible, $qualite) : imagePNG($finale, $cheminCible))) {
			$this->tabErreur[] = I18n::get('IMG_ERR_CANT_WRITE');
			return;
		}
		imageDestroy($finale);
	}

}
