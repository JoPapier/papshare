<?php

require_once 'class/Cfg.php';
if (!Cfg::$abonne) {
	header('Location:connexion.php');
	exit;
}

$tabErreur = [];
$opt = ['min_range' => 1];
$abonne_album = new Abonne_album();
$abonne_album->id_album = Cfg::$abonne->id_abonne;
$abonne_album->id_abonne = filter_input(INPUT_GET, 'id_abonne', FILTER_VALIDATE_INT, $opt);
$abonne_album->ok = 1;

$abonne_album->ajouterAbonne();
