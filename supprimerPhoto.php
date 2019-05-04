<?php
require_once 'class/Cfg.php';
if (!Cfg::$abonne) 
	header('Location:connexion.php');
	exit;

$opt = ['min_range' => 1];
$id_photo = filter_input(INPUT_GET, 'id_photo', FILTER_VALIDATE_INT, $opt);
(new Photo($id_photo))->supprimer();
