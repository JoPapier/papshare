<?php

Cfg::init();

class Cfg {

	public static $abonne = null;
	private static $initDone = false;
	public static $album = null;
	public static $photo = null;
	public static $abonne_album = null;

//upload.
	const TAB_EXT = [];
	const TAB_MIME = ['image/jpeg'];
//image.
	const IMG_V_LARGEUR = 300;
	const IMG_V_HAUTEUR = 300;
	const IMG_P_LARGEUR = 600;
	const IMG_P_HAUTEUR = 600;
	// Session.
	const SESSION_TIMEOUT = 3600; // 5 minutes.

	private function __construct() {
		//Classe 100% statique.
	}

	public static function init() {
		if (self::$initDone)
			return false;
		//Auto chargement des classes.
		spl_autoload_register(function ($classe) {
			@include "class/{$classe}.php";
		});
		spl_autoload_register(function ($classe) {
			@include "framework/{$classe}.php";
		});
// DSN.
		Connexion::setDSN('mydb', 'root', '');

		// Session 
		session_set_save_handler(new Session(self::SESSION_TIMEOUT));
		session_start();
		self::$abonne = Abonne::getUserSession();
		// Init done.

		return self::$initDone = true;
	}

}
