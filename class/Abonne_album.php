<?php

class Abonne_album implements Databasable {

	public $id_abonne_album;
	public $id_album;
	public $id_abonne;
	public $ok;

	public function __construct($id_abonne_album = null, $id_album = null, $id_abonne = null, $ok = null) {

		$this->id_abonne_album = $id_abonne_album;
		$this->id_album = $id_album;
		$this->id_abonne = $id_abonne;
		$this->ok = $ok;
	}

	public function charger() {
		if (!$this->id_abonne_album)
			return false;
		$req = "SELECT * FROM abonne_album WHERE id_abonne_album={$this->id_abonne_album}";
		return Connexion::getInstance()->xeq($req)->ins($this);
	}

	public function sauver() {
		$cnx = Connexion::getInstance();
		if ($this->id_abonne_album) {
			$req = "UPDATE abonne_album SET id_album={$this->id_album},id_abonne={$this->id_abonne}, ok = {$this->ok}  WHERE id_abonne_album = {$this->id_abonne_album}";
			$cnx->xeq($req);
		} else {
			$req = "INSERT INTO abonne_album VALUES(DEFAULT,{$this->id_album},{$this->id_abonne},{$this->ok})";
			$this->id_abonne_album = $cnx->xeq($req)->pk();
		}
		return $this;
	}

	public function supprimer() {
		if (!$this->id_abonne)
			return false;
		$req = "DELETE FROM abonne_album WHERE id_album = {$this->id_album}, id_abonne = {$this->id_abonne}, ok = 0";
		return (bool) Connexion::getInstance()->xeq($req)->nb();
	}

	public static function tab($where = 1, $orderBy = 1, $limit = null) {
		$req = "SELECT * FROM abonne_album WHERE {$where} ORDER BY {$orderBy}" . ($limit ? " LIMIT {$limit}" : '');
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public static function tous() {

		return Album::tab(1, 'nom');
	}

	public function dejaAbonne() {
		if (!$this->id_abonne_album)
			return false;
		$req = "SELECT id_album FROM abonne_album WHERE id_abonne={$this->id_abonne} AND id_album={$this->id_album}";
		return Connexion::getInstance()->xeq($req)->nb();
	}

	public function refExiste() {
		$cnx = Connexion::getInstance();
		$id_abonne = $this->id_abonne ? $this->id_abonne : 0;
		$req = "SELECT * FROM abonne_album WHERE id_album= {$this->id_album} AND id_abonne!={$id_abonne}";
		return (bool) $cnx->xeq($req)->prem(__CLASS__);
	}

	public function ajouterAbonne() {
		if (!$this->id_abonne)
			return false;
		$req = "UPDATE abonne_album SET ok = 1 WHERE id_album = {$this->id_album} AND id_abonne = {$this->id_abonne}";
		return Connexion::getInstance()->xeq($req);
	}

	public function rejeterAbonne() {
		if (!$this->id_abonne)
			return false;
		$req = "DELETE FROM abonne_album WHERE id_album = {$this->id_album} AND id_abonne = {$this->id_abonne} AND ok =0";
		return Connexion::getInstance()->xeq($req);
	}

	public function supprimerAbonnement() {
		if (!$this->id_abonne)
			return false;
		$req = "DELETE FROM abonne_album WHERE id_album = {$this->id_album} AND id_abonne = {$this->id_abonne} AND ok =1";
		return Connexion::getInstance()->xeq($req);
	}

}
