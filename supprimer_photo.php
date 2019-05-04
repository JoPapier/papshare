<?php

require_once 'class/Cfg.php';
if (!Cfg::$abonne)
	exit;
$opt = ['min_range' => 1];
$id_abonne = filter_input(INPUT_GET, 'id_abonne', FILTER_VALIDATE_INT, $opt);
(new Abonne($id_abonne))->supprimer();
