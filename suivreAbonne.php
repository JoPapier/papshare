<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}
$tabErreur = [];
$cnx = Connexion::getInstance();
$abonne_album = new Abonne_album ();
$album = new Album();
$opt = ['min_range' => 1];
$id_album =  filter_input(INPUT_GET, 'id_album', FILTER_VALIDATE_INT, $opt);
$idalbum = (new Abonne($id_album))->charger();
if((Cfg::$abonne != $idalbum)){
$abonne_album->id_album = $idalbum;
$abonne_album->id_abonne = Cfg::$abonne;
$abonne_album->ok = 0;
$abonne_album->sauver();
}