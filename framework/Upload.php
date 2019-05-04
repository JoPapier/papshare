<?php

class Upload {

	public $nomChamp; // Nom du champ INPUT.
	public $tabExt = []; // Extensions autorisées, ex : ['jpg','jpeg'].
	public $tabMIME = []; // Types MIME autorisés, ex : ['image/jpeg'].
	public $nomClient; // Nom du fichier côté client.
	public $extension; // Extension du fichier sans le point.
	public $cheminServeur; // Chemin du fichier temporaire côté serveur.
	public $codeErreur; // Eventuel code d'erreur.
	public $octets; // Nombre d'octets téléchargés.
	public $typeMIME; // Type MIME du fichier.
	public $tabErreur = []; // Complété si problème.

	public function __construct($nomChamp, $tabExt = [], $tabMIME = []) {
		$this->nomChamp = $nomChamp;
		$this->tabExt = $tabExt;
		$this->tabMIME = $tabMIME;
		if (!isset($_FILES[$nomChamp]))
			return;
		$this->nomClient = $_FILES[$nomChamp]['name'];
		$this->cheminServeur = $_FILES[$nomChamp]['tmp_name'];
		$this->extension = (new SplFileInfo($this->nomClient))->getExtension();
		$this->codeErreur = $_FILES[$nomChamp]['error'];
		$this->octets = $_FILES[$nomChamp]['size'];
		$this->typeMIME = $_FILES[$nomChamp]['type'];
		if ($this->codeErreur)
			$this->tabErreur[] = I18n::get('UPLOAD_ERR_' . $this->codeErreur);
		if (!$this->tabErreur && !$this->octets)
			$this->tabErreur[] = I18n::get('UPLOAD_ERR_EMPTY');
		if (!$this->tabErreur && $tabExt && !in_array($this->extension, $tabExt))
			$this->tabErreur[] = I18n::get('UPLOAD_ERR_EXTENSION');
		if (!$this->tabErreur && $tabMIME && !in_array($this->typeMIME, $tabMIME))
			$this->tabErreur[] = I18n::get('UPLOAD_ERR_MIME');
	}

	public function sauver($chemin) {
		if (!move_uploaded_file($this->cheminServeur, $chemin))
			$this->tabErreur[] = I18n::get('UPLOAD_ERR_MOVE');
	}

	public static function maxFileSize($enOctets = true) {
		$kmg = ini_get('upload_max_filesize');
		if (!$enOctets) {
			return $kmg;
		}
		$strPoids = str_ireplace('G', '*1024**3+', str_ireplace('M', '*1024**2+', str_ireplace('K', '*1024+', $kmg))) . '0';
		eval("\$poids = {$strPoids};");
		return $poids;
	}

}
