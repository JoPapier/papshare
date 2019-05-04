<?php

class I18n {

	private function __construct() {
//class 100% statique.
	}

	public static function get($message) {
		$langues = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE', FILTER_SANITIZE_STRING);
		$langue = $langues ? mb_substr($langues, 0, 2) : 'en';
		if (isset(self::$msg[$langue][$message]))
			return self::$msg[$langue][$message];
		if (isset(self::$msg['en'][$message]))
			return self::$msg['en'][$message];
		return null;
	}

	private static $msg = [
			'fr' => [
					'FORM_ERR_CATEGORY' => "La catégorie est absente ou invalide.",
					'FORM_ERR_NAME' => "Le nom est absent.",
					'FORM_ERR_REF' => "La référence est absente, invalide ou déjà existante.",
					'FORM_ERR_PRICE' => "Le prix est absent ou invalide.",
					'FORM_LABEL_NAME' => 'Nom',
					'FORM_LABEL_REF' => 'Référence',
					'FORM_LABEL_PRICE' => 'Prix',
					'FORM_LABEL_CANCEL' => 'Annuler',
					'FORM_LABEL_SUBMIT' => 'Valider',
					'FORM_LABEL_CATEGORY' => 'Catégorie',
					'UPLOAD_ERR' . UPLOAD_ERR_INI_SIZE => 'taille maximum dépassé côté serveur.',
					'UPLOAD_ERR' . UPLOAD_ERR_FORM_SIZE => 'taille maximum dépassé côté client.',
					'UPLOAD_ERR' . UPLOAD_ERR_PARTIAL => 'fichier partiellement uploadé.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_FILE => 'aucun fichier uploadé.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_TMP_DIR => 'dossier temporaire absent.',
					'UPLOAD_ERR' . UPLOAD_ERR_CANT_WRITE => 'dossier temporaire inaccessible.',
					'UPLOAD_ERR' . UPLOAD_ERR_EXTENSION => "une extension PHP a bloqué l'upload.",
					'UPLOAD_ERR_EMPTY' => "Fichier vide.",
					'UPLOAD_ERR_EXTENSION' => "Extension fichier invalide.",
					'UPLOAD_ERR_MIME' => "Type MIME invalide.",
					'UPLOAD_ERR_MOVE' => "Sauvegarde de fichier invalide.",
					'IMG_ERR_UNAVAILABLE' => "Image inutilisable.",
					'IMG_ERR_TYPE' => "Type image invalide.",
					'DB_ERR_DSN_ALREADY_SET' => "Deja fait",
					'DB_ERR_CONNECTION_FAILED' => "Connexion impossible",
					'DB_ERR_DSN_UNDEFINED' => "La connexion n'existe pas",
					'DB_ERR_BAD_REQUEST' => "Requete incorrecte",
					'FORM_ERR_LOG' => "Login absent ou invalide",
					'FORM_ERR_LOGIN' => "Impossible de se connecter",
					'FORM_ERR_MDP' => "Mot de passe absent ou invalide",
					'FORM_LABEL_LOG' => "Pseudo",
					'FORM_LABEL_MDP' => "Mot de passe",
					'FORM_LABEL_CONNECT' => "Connecter",
			],
			'en' => [
					'FORM_ERR_CATEGORY' => "Category empty or invalid.",
					'FORM_ERR_NAME' => "Name empty  or invalid.",
					'FORM_ERR_REF' => "Reference empty, invalid or already used.",
					'FORM_ERR_PRICE' => "Prix empty or invalid.",
					'FORM_LABEL_NAME' => 'Name',
					'FORM_LABEL_REF' => 'Reference',
					'FORM_LABEL_PRICE' => 'Price',
					'FORM_LABEL_CANCEL' => 'Cancel',
					'FORM_LABEL_SUBMIT' => 'Submit',
					'FORM_LABEL_CATEGORY' => 'Category',
					'UPLOAD_ERR' . UPLOAD_ERR_INI_SIZE => 'maximum size exceeded server side.',
					'UPLOAD_ERR' . UPLOAD_ERR_FORM_SIZE => 'maximum size exceeded client side',
					'UPLOAD_ERR' . UPLOAD_ERR_PARTIAL => 'partially uploaded file.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_FILE => 'no uploaded file.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_TMP_DIR => 'temporary folder absent.',
					'UPLOAD_ERR' . UPLOAD_ERR_CANT_WRITE => 'Temporary folder inaccessible.',
					'UPLOAD_ERR' . UPLOAD_ERR_EXTENSION => "a PHP extension blocked the upload.",
					'UPLOAD_ERR_EMPTY' => "Empty file.",
					'UPLOAD_ERR_EXTENSION' => "Invalid file extension.",
					'UPLOAD_ERR_MIME' => "Invalid MIME type.",
					'UPLOAD_ERR_MOVE' => "Invalid file backup.",
					'IMG_ERR_UNAVAILABLE' => "Unavailable image.",
					'IMG_ERR_TYPE' => "Wrong image type.",
					'DB_ERR_DSN_ALREADY_SET' => "Already set",
					'DB_ERR_CONNECTION_FAILED' => "Connection failed",
					'DB_ERR_DSN_UNDEFINED' => "Connection undefined",
					'DB_ERR_BAD_REQUEST' => "Bad request",
					'FORM_ERR_LOG' => "Login empty or invalid",
					'FORM_ERR_LOGIN' => "Couldnt Attempt to connect",
					'FORM_ERR_MDP' => "Password empty or invalid",
					'FORM_LABEL_LOG' => "Login",
					'FORM_LABEL_MDP' => "Password",
					'FORM_LABEL_CONNECT' => "Connection",
			],
			'mg' => [
					'FORM_ERR_CATEGORY' => "Sokaji tsy misy na diso.",
					'FORM_ERR_NAME' => "Anaran tsy misy na diso.",
					'FORM_ERR_REF' => "Sokaji tsy misy diso na efa misy.",
					'FORM_ERR_PRICE' => "Vidiny tsy misy,diso na efa misy.",
					'FORM_LABEL_CATEGORY' => 'Sokajy',
					'FORM_LABEL_NAME' => 'Anarana',
					'FORM_LABEL_REF' => 'Référence',
					'FORM_LABEL_PRICE' => 'Vidiny',
					'FORM_LABEL_CANCEL' => "hanafoana",
					'FORM_LABEL_SUBMIT' => "Alefa",
					'UPLOAD_ERR' . UPLOAD_ERR_INI_SIZE => 'maximum size exceeded server side.',
					'UPLOAD_ERR' . UPLOAD_ERR_FORM_SIZE => 'maximum size exceeded client side',
					'UPLOAD_ERR' . UPLOAD_ERR_PARTIAL => 'partially uploaded file.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_FILE => 'no uploaded file.',
					'UPLOAD_ERR' . UPLOAD_ERR_NO_TMP_DIR => 'temporary folder absent.',
					'UPLOAD_ERR' . UPLOAD_ERR_CANT_WRITE => 'Temporary folder inaccessible.',
					'UPLOAD_ERR' . UPLOAD_ERR_EXTENSION => "a PHP extension blocked the upload.",
					'UPLOAD_ERR_EMPTY' => "",
					'UPLOAD_ERR_EXTENSION' => "",
					'UPLOAD_ERR_MIME' => "",
					'UPLOAD_ERR_MOVE' => "",
					'IMG_ERR_UNAVAILABLE' => "Tsy misy io sary io.",
					'IMG_ERR_TYPE' => "Tsy misy io karazany io.",
					'DB_ERR_DSN_ALREADY_SET' => "Efa napetraka",
					'DB_ERR_CONNECTION_FAILED' => "Tsy nahomby ny fifandraisana",
					'DB_ERR_DSN_UNDEFINED' => "Fifandraisana tsy voafaritra",
					'DB_ERR_BAD_REQUEST' => "Fangatahana tsy mety",
			]
	];

}
